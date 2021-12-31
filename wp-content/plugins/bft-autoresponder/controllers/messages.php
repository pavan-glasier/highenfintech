<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Manages the messages */
function bft_messages() {
	global $wpdb;
	$_att = new BFTAttachmentModel();
	
	$send_on_date = $days = 0;
	if(isset($_POST['subject'])) $subject = sanitize_text_field($_POST['subject']);
	if(isset($_POST['message'])) $message = bft_strip_tags($_POST['message']);
	if(isset($_POST['days'])) $days = intval($_POST['days']);
	if(isset($_POST['id'])) $id = intval($_POST['id']);
   if(isset($_POST['send_on_date'])) $send_on_date = intval($_POST['send_on_date']);
    
    // prepare date
    if(!empty($_POST['dateyear'])) $date = intval($_POST['dateyear'])."-".intval($_POST['datemonth'])."-".intval($_POST['dateday']);
    else $date = date("Y-m-d");
    //$date = esc_sql($date); // it's sanitized above

	if(!empty($_POST['add_message']) and check_admin_referer('bft_message')) {
		$sql=$wpdb->prepare("INSERT INTO ".BFT_MAILS." (subject,message,days,send_on_date,date, content_type)
		VALUES (%s, %s, %d, %d, %s, %s)", $subject, $message, $days, $send_on_date, $date, 
		sanitize_text_field($_POST['content_type']));
		$wpdb->query($sql);
		$id = $wpdb->insert_id;
		$_att->save_attachments($id, 'mail');
	}
	
	if(!empty($_POST['save_message']) and check_admin_referer('bft_message')) {
		$sql=$wpdb->prepare("UPDATE ".BFT_MAILS." SET
		subject=%s,
		message=%s,
		days=%d,
   	send_on_date=%d,
      date=%s,
      content_type = %s
		WHERE id=%d", $subject, $message, $days, $send_on_date, $date, sanitize_text_field($_POST['content_type']), $id);		
		$wpdb->query($sql);
		$_att->save_attachments($id, 'mail');
	}
	
	if(!empty($_POST['del_message']) and check_admin_referer('bft_message') and !empty($id)) {
		$wpdb->delete(BFT_MAILS, array("id" => $id));
		$_att->delete_attachments($id, 'mail');
	}
	
	// select all messages ordered by days
	$sql="SELECT * FROM ".BFT_MAILS." ORDER BY days";
	$mails=$wpdb->get_results($sql);
	
	foreach($mails as $cnt=>$mail) {
		$attachments = $_att->select("mail", $mail->id);
		$mails[$cnt]->attachments = $attachments;
	}
	
	require(BFT_PATH."/views/bft_messages.html.php");
}