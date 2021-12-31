<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// sends immediate newsletter
function bft_newsletter() {
	global $wpdb;
	
	if(!empty($_POST['ok']) and !empty($_POST['subject']) and !empty($_POST['message']) and check_admin_referer('bft_newsletter')) {
		// select all active users
		$users = $wpdb->get_results("SELECT * FROM ".BFT_USERS." WHERE status=1 ORDER BY id");
		$num_mails_sent = 0;
		
		$sender = get_option('bft_sender');
		$subject = stripslashes(sanitize_text_field($_POST['subject']));
		$message = stripslashes(bft_strip_tags($_POST['message']));
		$content_type = sanitize_text_field($_POST['content_type']);
		
		// save this newsletter
		if(empty($_GET['id'])) {
			// add new
			$wpdb->query($wpdb->prepare("INSERT INTO ".BFT_NLS." SET
				subject=%s, message=%s, date=CURDATE(), num_sent=0, num_failed=0, email_type=%s, status='in progress', last_user_id=0", 
				$subject, $message, $content_type));
			$id = $wpdb->insert_id;	
		}
		else {
			// edit newsletter
			$wpdb->query($wpdb->prepare("UPDATE ".BFT_NLS." SET
				subject=%s, message=%s, date=CURDATE(), num_sent=0, num_failed=0, email_type=%s, status='in progress', last_user_id=0
				WHERE id=%d", $subject, $message, $content_type, intval($_GET['id'])));
			$id = intval($_GET['id']);	
		}
		
		do_action('arigato_sent_newsletter', $id, $num_mails_sent);
		$_SESSION['bft_flash'] = sprintf(__('%d emails were sent.', 'broadfast'), $num_mails_sent);
		bft_redirect("admin.php?page=bft_newsletter");
	}
	
	// delete newsletter?
	if(!empty($_GET['del'])) {
		$wpdb->query($wpdb->prepare("DELETE FROM ".BFT_NLS." WHERE id=%d", intval($_GET['del'])));
		bft_redirect("admin.php?page=bft_newsletter");
	}
	
	// select existing newsletters
	$newsletters = $wpdb->get_results("SELECT id, subject, date, num_sent, num_failed, status 
		FROM ".BFT_NLS." ORDER BY date DESC, id DESC");
	$dateformat = get_option('date_format');
		
	if(!empty($_GET['id'])) {
		$nl = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".BFT_NLS." WHERE id=%d", intval($_GET['id'])));
	}
	
	$list_size = $wpdb->get_var("SELECT COUNT(id) FROM ".BFT_USERS." WHERE status=1");
	require(BFT_PATH."/views/newsletter.html.php");
}

// public newsletter archive
function bft_newsletter_archive($atts) {
	global $wpdb, $wp;
 		
 		$per_page = empty($atts['per_page']) ? 10 : intval($atts['per_page']);
 		$offset = empty($_GET['offset']) ? 0 : intval($_GET['offset']); 		
 		$current_url = home_url( $wp->request );
 		
 		if(!empty($_GET['id'])) return bft_view_newsletter();
 		
 		// select newsletters
 		$newsletters = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS id, subject, date FROM ".BFT_NLS."
 			WHERE date <= %s ORDER BY date DESC LIMIT %d, %d", date('Y-m-d', current_time('timestamp')), $offset, $per_page));
 			
 		$count = $wpdb->get_var("SELECT FOUND_ROWS()");	
 			
 		$date_format = get_option('date_format');	
 		require(BFT_PATH."/views/newsletter-archive.html.php");		
} // end newsletter archive

// view newsletter from the archive
function bft_view_newsletter() {
 		global $wpdb, $wp;
 		
 		$current_url = home_url( $wp->request );
 		$offset = empty($_GET['offset']) ? 0 : intval($_GET['offset']); // keep it to return to the same offset
 		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);
 		
 		// select newsletter
 		$newsletter = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".BFT_NLS." WHERE id=%d", $id));
 		
 		if(empty($newsletter->id)) {
 			_e('Nothing found.', 'broadfast');
 			return false;
 		}
 		
 		$date_format = get_option('date_format');	
 		require(BFT_PATH."/views/view-archived-newsletter.html.php");		
} // end view_newsletter