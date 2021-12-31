<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// output raw email log
function bft_log() {
	global $wpdb;
	$start_date = empty($_POST['start_date']) ? date('Y-m-d') : sanitize_text_field($_POST['start_date']);
	$end_date = empty($_POST['end_date']) ? date('Y-m-d') : sanitize_text_field($_POST['end_date']);
	if(!empty($_POST['cleanup'])) update_option('bft_cleanup_raw_log', intval($_POST['cleanup_days']));
	
	$cleanup_raw_log = get_option('bft_cleanup_raw_log');
	if(empty($cleanup_raw_log)) $cleanup_raw_log = 7;
	
	$emails = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".BFT_EMAILLOG." WHERE date >= %s AND date <= %s ORDER BY id", $start_date, $end_date));
	
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', BFT_URL.'/css/jquery-ui.css');
	require(BFT_PATH."/views/raw-email-log.html.php"); 
}