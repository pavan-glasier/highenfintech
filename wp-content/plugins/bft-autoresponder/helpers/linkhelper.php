<?php
// this small class will produce some proper internal links for using within the program
// for example in mailing list subscribers page it produces proper URL to sort by name, email etc
// depending on the current selection
class BFTLinkHelper {
	static function subscribers($orderby, $reverse = true) {
		$current_order=empty($_GET['ob'])?"name":$_GET['ob'];
		
		// otherwise we use default direction for the property
		switch($orderby) {
			case 'status':
				// default status is active, i.e. DESC
			case 'date':
				// default order is DESC
				$default_dir="DESC";
			break;
			
			default:
				// for other default order is ASC
				$default_dir="ASC";			
			break;
		}
		
		// when $current_order is the same as $orderby we just flip the direction
		$dir = empty($_GET['dir']) ? "ASC" : $_GET['dir'];
		if(!in_array($dir, array('ASC', 'DESC'))) $dir = "ASC";
		if($reverse) {
			if($current_order==$orderby) {
				$reverse_dir=empty($_GET['dir'])?$default_dir:$_GET['dir'];
				$dir=($reverse_dir=='ASC')?'DESC':'ASC';
			}
			else $dir=$default_dir;
		}	
		
		$link = "&ob=$orderby&dir=$dir";
		
		$link.= self::subscribers_filters();
		
		return $link;
	}
	
	static function subscribers_filters() {		
		$link="";
		
		if(isset($_GET['filter_status'])) $link.="&filter_status=".sanitize_text_field($_GET['filter_status']);
		if(isset($_GET['filter_email'])) $link.="&filter_email=".sanitize_email($_GET['filter_email']);
		if(isset($_GET['filter_name'])) $link.="&filter_name=".sanitize_text_field($_GET['filter_name']);
		if(isset($_GET['filter_ip'])) $link.="&filter_ip=".sanitize_text_field($_GET['filter_ip']);		
		if(isset($_GET['signup_date_cond'])) $link.="&signup_date_cond=".sanitize_text_field($_GET['signup_date_cond'])."&sdate=".sanitize_text_field($_GET['sdate'])."&filter_signup_date=".sanitize_text_field($_GET['filter_signup_date']);
		
		return $link;
	}
}