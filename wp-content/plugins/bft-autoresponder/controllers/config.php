<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// configure email message on subscribe/unsubscribe
function bft_message_config() {
	$type = ($_GET['msg'] == 'subscribe_notify') ? sanitize_text_field($_GET['msg']) : 'unsubscribe_notify';	
	// user friendly text
	$friendly_type = ($type == 'subscribe_notify') ? __('Subscribe Notification', 'broadfast') : __('Unsubscribe Notification', 'broadfast');
	
	if(!empty($_POST['ok']) and check_admin_referer('bft_message_config')) {
		update_option('bft_'.$type.'_subject', sanitize_text_field($_POST['subject']));
		update_option('bft_'.$type.'_message', bft_strip_tags($_POST['message']));
		update_option('bft_'.$type.'_receivers', sanitize_text_field($_POST['receivers']));
	}	
	
	$subject = get_option('bft_'.$type.'_subject');
	$message = get_option('bft_'.$type.'_message');
	$receivers = get_option('bft_'.$type.'_receivers');
	if(empty($receivers)) {
		$receivers = get_option('bft_sender');
		// this is when address is entered like "sender, email@dot.com"
		if(strstr($receivers, ',')) {
			$parts = explode(",", $receivers);
			$receivers = trim($parts[1]);
		}
	}
	
	include(BFT_PATH."/views/message-config.html.php");
}