<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$last_date = get_option("bft_date");

// this array of mail_id-user_id pairs will ensure no duplicates are sent on the same function run
$currently_sent = array();

// don't start again if there is currently running cron job
// or if there is one, it should be at least 5 minutes old.
// used to avoid simultaneously running cron jobs
$last_start = get_option('bft_last_start');
if(!empty($last_start) and $last_start > (time() - 5 * 60)) {
	if($use_cron_job == 1) die(__('Wait 5 minutes before the next cron job.', 'broadfast'));
	else return true;
}

update_option( 'bft_date', date("Y-m-d") );	// no longer used to limit the cron job but still keep the info when it ran
update_option( 'bft_last_start', time() );	

// if the previous job is still in "running" status, wait ONE hour
$last_status = get_option('bft_current_status');
if($last_status == 'running' and $last_start > (time() - 60 * 60)) {
   if($use_cron_job == 1) die(__('Wait 1 hour before the next cron job.', 'broadfast'));
	else return true;
}

$upload_dir = wp_upload_dir();
$lock_file = $upload_dir['basedir'].'/arigato.lock';

// locking by file is good but we must make sure that a script which could not finish won't block the cron job forever
// so let's delete it if there is a file already and it's more than $cron_minutes old
if(file_exists($lock_file)) {
   $created_on = filectime($lock_file);
   // if one hour passed and the file is still here, delete it
   if($created_on < time() - 60 * 60) @unlink($lock_file);
}

// now use also a lock file protection
$f = @fopen($lock_file, 'x'); 
if(!$f) return false;
if (!flock($f, LOCK_EX | LOCK_NB)) {
   if($use_cron_job == 1) die(__('Locked by lock file. The file will be released in one hour.', 'broadfast'));
   return false;
} 

// after these checks have passed we can set the status to running
update_option( 'bft_current_status', 'running' );

 // sequential mails
$sql="SELECT * FROM {$wpdb->prefix}bft_mails 
 WHERE days>0 AND send_on_date=0 ORDER BY id";
$mails = $wpdb->get_results($sql);

// total mail limit for this run
$mail_limit = get_option('bft_mails_per_run');
$total_emails = 0;
     			
foreach($mails as $mail) {
	$attachments = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".BFT_ATTACHMENTS."
				WHERE mail_id = %d ORDER BY id", $mail->id));	
				
	// tables locked in the last minute and not unlocked? Log & exit
	$tables_locked_time = get_option('bft_lock_tables');
	if(time() - 60 < $tables_locked_time) {
	   update_option( 'bft_current_status', 'completed' );
	   @unlink($lock_file);
		return false;
	}	
	// now lock tables
	update_option('bft_lock_tables', time());				
			
	// get users who need to get this mail sent today and send it
	$sql="SELECT * FROM {$wpdb->prefix}bft_users
	WHERE date='".date("Y-m-d")."' - INTERVAL $mail->days DAY
	AND status=1
	ORDER BY id";			
	$members=$wpdb->get_results($sql);
	
	// unlock tables
	update_option('bft_lock_tables', '');			
     		
	if(sizeof($members))	{
		foreach($members as $member)	{
			if(in_array($mail->id.'--'.$member->id, $currently_sent)) continue;				
			
			// don't send the same email twice
			$already_sent = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}bft_sentmails
				WHERE mail_id=%d AND date=%s AND user_id=%d", $mail->id, date("Y-m-d"), $member->id));
			
			if(!$already_sent) {
				$total_emails++;
				if(!empty($mail_limit) and $total_emails > $mail_limit) {
					update_option( 'bft_last_start', time() ); // finished successfully
					update_option( 'bft_current_status', 'completed' );
					@unlink($lock_file);
					return true;
				}				
				
				// insert in sent mails
				$wpdb->query($wpdb->prepare("INSERT INTO ".BFT_SENTMAILS." SET
					mail_id=%d, user_id=%d, date=%s", $mail->id, $member->id, date("Y-m-d", current_time('timestamp'))));					
				
				$currently_sent[] = $mail->id.'--'.$member->id;
				bft_customize($mail,$member, $attachments);
			}
		}
	}
}

 // now date mails
 $sql="SELECT * FROM {$wpdb->prefix}bft_mails
 WHERE send_on_date=1 AND date=CURDATE()";
 $mails = $wpdb->get_results($sql);

 // tables locked in the last minute and not unlocked? Log & exit
	$tables_locked_time = get_option('bft_lock_tables');
	if(time() - 60 < $tables_locked_time) {
	   update_option( 'bft_current_status', 'completed' );
	   @unlink($lock_file);
		return false;
	}	
	// now lock tables
	update_option('bft_lock_tables', time());		

 // select all users
 $sql="SELECT * FROM {$wpdb->prefix}bft_users
 WHERE status=1
 ORDER BY id";           
 $members = $wpdb->get_results($sql);
 
	// unlock tables
	update_option('bft_lock_tables', '');			

 foreach($mails as $mail) {        
     if(sizeof($members)) {
         foreach($members as $member) {
         	 if(in_array($mail->id.'--'.$member->id, $currently_sent)) continue;
         	 
         	 // don't send the same email twice
				 $already_sent = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}bft_sentmails
					WHERE mail_id=%d AND date=%s AND user_id=%d", $mail->id, date("Y-m-d"), $member->id));					
         		
             if(!$already_sent) {
             	$total_emails++;
					if(!empty($mail_limit) and $total_emails > $mail_limit) {
						update_option( 'bft_last_start', time() ); // finished successfully
						@unlink($lock_file);
						return true;
					}	
				
             	$wpdb->query($wpdb->prepare("INSERT INTO ".BFT_SENTMAILS." SET
						mail_id=%d, user_id=%d, date=%s", $mail->id, $member->id, date("Y-m-d", current_time('timestamp'))));
					
             	$currently_sent[] = $mail->id.'--'.$member->id;
             	bft_customize($mail,$member, $attachments);
             }
         }
     }
 }
 
 // after sending all autoresponder emails, send any in progress newsletters
 $newsletters = $wpdb->get_results("SELECT * FROM ".BFT_NLS." WHERE status='in progress' ORDER BY id");
 
 foreach($newsletters as $newsletter) {
 	 // select all users
	 $sql="SELECT * FROM {$wpdb->prefix}bft_users
	 WHERE status=1 AND id > %d ORDER BY id";           
	 $members = $wpdb->get_results($wpdb->prepare($sql, $newsletter->last_user_id));
	 
	 // newsletter fully sent?
	 $cnt_members = count($members);
	 if(!$cnt_members) {
	 	$wpdb->query($wpdb->prepare("UPDATE " . BFT_NLS . " SET status='completed' WHERE id=%d", $newsletter->id));
	 	continue;
	 }
	 
	 // now sending
	 foreach($members as $cnt => $member) {
	 	$sent = $failed = 0;	
		if(bft_customize($newsletter,$member)) $sent = 1;
		else $failed = 1;
		$total_emails++;
		
		$status = 'in progress';
		$last_user_id = $member->id;
		if($cnt + 1 == $cnt_members) {
			$status = 'completed';
			$last_user_id = 0;
		}
		
		// update newsletter stats
		$wpdb->query($wpdb->prepare("UPDATE ".BFT_NLS." SET status=%s, last_user_id=%d, num_sent=num_sent + %d, num_failed=num_failed + %d
			WHERE id=%d",
			$status, $last_user_id, $sent, $failed, $newsletter->id));
		
		if(!empty($mail_limit) and $total_emails > $mail_limit) {
			update_option( 'bft_last_start', time() ); // finished successfully
			@unlink($lock_file);
			return true;
		}	
	 } // end foreach member
} // end foreach newsletter

do_action('arigato_cron_job_ran');
update_option( 'bft_last_start', time() ); // finished successfully
update_option( 'bft_current_status', 'completed' );
@unlink($lock_file);