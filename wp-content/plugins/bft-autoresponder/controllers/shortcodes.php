<?php
class ArigatoShortcodes {
	// returns the total number of subscribers
	public static function num_subscribers() {
		global $wpdb;
		
		$num = $wpdb->get_var("SELECT COUNT(id) FROM ".BFT_USERS." WHERE status=1");
		return $num;
	}
	
	// shows unsubscribe form on custom page/post
   // this is redundancy with the template_redirect function in the basic model   
   public static function unsubscribe($atts) {
   	global $wpdb;
   	
		ob_start();
		include(BFT_PATH."/views/unsubscribe.html.php");
		$content = ob_get_clean();
		return $content;
   }
   
   // displays a newsletter archive on the front-end
   public static function newsletter_archive($atts) {
   	ob_start();
   	bft_newsletter_archive($atts);
   	$content = ob_get_clean();
   	return $content;
   }
}