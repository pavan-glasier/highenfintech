<?php
/*
Plugin Name: Arigato Autoresponder and Newsletter 
Plugin URI: http://calendarscripts.info/autoresponder-wordpress.html
Description: This is a sequential autoresponder that can send automated messages to your mailing list. For more advanced features check our <a href="http://calendarscripts.info/bft-pro">PRO Version</a>
Author: Kiboko Labs
Version: 2.6.8
Author URI: http://calendarscripts.info
License: GPL 2
Text domain: broadfast
*/ 

/***  Copyright 2012 - 2017  Kiboko Labs

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
***/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'BFT_PATH', dirname( __FILE__ ) );
define( 'BFT_RELATIVE_PATH', dirname( plugin_basename( __FILE__ )));
define( 'BFT_URL', plugin_dir_url( __FILE__ ));
include(BFT_PATH."/bft-lib.php");
include(BFT_PATH."/models/attachment.php");
include(BFT_PATH."/controllers/newsletter.php");
include(BFT_PATH."/controllers/help.php");
include(BFT_PATH."/controllers/config.php");
include(BFT_PATH."/controllers/list.php");
include(BFT_PATH."/controllers/integrations.php");
include(BFT_PATH."/controllers/integrations/contact.php");
include(BFT_PATH."/controllers/integrations/jetpack.php");
include(BFT_PATH."/controllers/log.php");
include(BFT_PATH."/controllers/messages.php");
include(BFT_PATH."/controllers/shortcodes.php");
include(BFT_PATH."/helpers/text-captcha.php");
include(BFT_PATH."/helpers/linkhelper.php");

// initialize plugin
function bft_init() {
	global $wpdb;	
	
	load_plugin_textdomain( 'broadfast', false, BFT_RELATIVE_PATH."/languages/" );
	
	if (!session_id() and !empty($_GET['page']) and (strstr($_GET['page'], 'bft_')) ) {		
			@session_start();
	}
	
	define( 'BFT_USERS', $wpdb->prefix. "bft_users" );
	define( 'BFT_MAILS', $wpdb->prefix. "bft_mails" );
	define( 'BFT_SENTMAILS', $wpdb->prefix. "bft_sentmails" );
	define( 'BFT_EMAILLOG', $wpdb->prefix. "bft_emaillog" );
	define( 'BFT_DEBUG', get_option('broadfast_debug'));
   define( 'BFT_ATTACHMENTS', $wpdb->prefix. "bft_attachments" );
   define( 'BFT_NLS', $wpdb->prefix. "bft_newsletters" );
   define( 'BFT_BCC_ALL', get_option('bft_bcc'));		
   define( 'BFT_UNSUBS', $wpdb->prefix."bft_unsubs");
   
   if(!defined('BFT_SENDER')) define('BFT_SENDER',get_option( 'bft_sender' ));
   
   add_action('admin_enqueue_scripts', 'arigato_scripts');
   add_action('admin_enqueue_scripts', 'arigato_admin_scripts');
   add_action('wp_enqueue_scripts', 'arigato_scripts');
	
	// contact form 7 integration
	add_filter( 'wpcf7_form_elements', array('BFTContactForm7', 'shortcode_filter') );
	add_action( 'wpcf7_before_send_mail', array('BFTContactForm7', 'signup') );
	add_shortcode( 'bft-int-chk', array("BFTContactForm7", 'int_chk'));
	
	
	// jetpack contact form integration
	add_action('grunion_pre_message_sent', array('BFTJetPack', 'signup'));
	
	// Ninja forms integration
	add_action( 'ninja_forms_save_sub', array('BFTIntegrations', 'ninja_signup') );
	
	// Formidable forms integration
	add_action( 'frm_after_create_entry', array('BFTIntegrations', 'signup_formidable'), 30, 2 );
	
	// other shortcodes
	add_shortcode('bft-num-subs', array('ArigatoShortcodes', 'num_subscribers'));
	add_shortcode('bft-unsubscribe', array('ArigatoShortcodes', 'unsubscribe'));
	add_shortcode('bft-newsletter-archive', array('ArigatoShortcodes', 'newsletter_archive'));
	
	// privacy data eraser
	add_filter( 'wp_privacy_personal_data_erasers', 'bft_register_personal_data_eraser', 10, 1);
	
	if($wpdb->get_var("SHOW TABLES LIKE '".BFT_EMAILLOG."'") == BFT_EMAILLOG) {
		$cleanup_raw_log = get_option('bft_cleanup_raw_log');
		if(empty($cleanup_raw_log)) $cleanup_raw_log = 7;
		$wpdb->query($wpdb->prepare("DELETE FROM ".BFT_EMAILLOG." WHERE date < CURDATE() - INTERVAL %d DAY", $cleanup_raw_log));				
	}
	
	define('BFT_SLEEP', floatval(get_option('bft_sleep')));
	
	$version = get_option('bft_db_version');
	if(empty($version) or version_compare($version, '2.22') == -1) bft_install(true);
	
	$use_cron_job = get_option('bft_use_cron_job');
	if($use_cron_job == 1) bft_hook_up(); // hook this on init ONLY if cron job will be used. Otherwise the function will be called directly by wp_cron
}

// enqueue scripts & stypes front-end
function arigato_scripts() {
	wp_register_style( 'arigato-css', BFT_URL . 'front.css', array(), '2.6.3');
	wp_enqueue_style( 'arigato-css' );
}

function arigato_admin_scripts() {
	wp_register_style( 'arigato-admin-css', BFT_URL . 'css/admin.css', array(), '2.6.1');
	wp_enqueue_style( 'arigato-admin-css' );
}

/* Adds the menu items */
function bft_autoresponder_menu() {  
  $arigato_caps = current_user_can('manage_options') ? 'manage_options' : 'arigato_manage';
  
  add_menu_page(__('Arigato Light', 'broadfast'), __('Arigato Light', 'broadfast'), $arigato_caps, 'bft_options', 'bft_options');
  add_submenu_page('bft_options',__('Settings', 'broadfast'), __('Settings', 'broadfast'), $arigato_caps, 'bft_options', 'bft_options');
  add_submenu_page('bft_options',__('Your Mailing List', 'broadfast'), __('Mailing List', 'broadfast'), $arigato_caps, "bft_list", "bft_list");
  add_submenu_page('bft_options',__('Import/Export Members', 'broadfast'), __('Import/Export', 'broadfast'), $arigato_caps, "bft_import", "bft_import");
  add_submenu_page('bft_options',__('Manage Messages', 'broadfast'), __('Email Messages', 'broadfast'), $arigato_caps, "bft_messages", "bft_messages");
  add_submenu_page('bft_options',__('Send Newsletter', 'broadfast'), __('Send Newsletter', 'broadfast'), $arigato_caps, "bft_newsletter", "bft_newsletter");  
  add_submenu_page('bft_options',__('Raw Email Log', 'broadfast'), __('Raw Email Log', 'broadfast'), $arigato_caps, "bft_log", "bft_log");  
  add_submenu_page('bft_options',__('Help', 'broadfast'), __('Help', 'broadfast'), $arigato_caps, "bft_help", "bft_help");
  add_submenu_page('bft_options',__('Integrate in Contact Form', 'broadfast'), __('Integrate in Contact Form', 'broadfast'), $arigato_caps, "bft_integrate_contact", array("BFTIntegrations", "contact_form"));
  if(function_exists('ninja_forms_get_all_forms')) add_submenu_page('bft_options',__('Integrate in Ninja Form', 'broadfast'), __('Integrate in Ninja Form', 'broadfast'), $arigato_caps, "bft_integrate_ninja", array("BFTIntegrations", "ninja"));
  if(class_exists('FrmField')) add_submenu_page('bft_options',__('Integrate in Formidable Form', 'broadfast'), __('Integrate in Formidable Form', 'broadfast'), $arigato_caps, "bft_integrate_formidable", array("BFTIntegrations", "formidable"));
  
  // not in the menu
  add_submenu_page(null, __('Configure Email Message', 'broadfast'), __('Configure Email Message', 'broadfast'), $arigato_caps, 'bft_messages_config', 'bft_message_config');
  add_submenu_page(NULL,__('Integrate in Contact Form', 'broadfast'), __('Integrate in Contact Form', 'broadfast'), $arigato_caps, "bft_integrate_contact", array("BFTIntegrations", "contact_form"));
}

/* Creates the mysql tables needed to store mailing list and messages */
$bft_msg="";

function bft_install($update = false) {
	 global $wpdb;
	 
	 if(!$update) bft_init();
    $bft_db_version="2.22";
    $collation = $wpdb->get_charset_collate();
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  
	 $sql = "CREATE TABLE " . BFT_USERS . " (
			  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			  email varchar(100) NOT NULL UNIQUE,	
			  name varchar(255)	NOT NULL,		  
			  status tinyint UNSIGNED NOT NULL DEFAULT 0,
			  date date NOT NULL,
           ip varchar(100) NOT NULL,
			  code varchar(10) NOT NULL,
			  auto_subscribed tinyint UNSIGNED NOT NULL DEFAULT 0,
			  PRIMARY KEY  (id)			  
			) $collation";
		dbDelta( $sql );	  	
	  
	  if($wpdb->get_var("SHOW TABLES LIKE '".BFT_MAILS."'") != BFT_MAILS) {
	  
			$sql = "CREATE TABLE `" . BFT_MAILS . "` (
				  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				  `subject` VARCHAR(255) NOT NULL,				  
				  `message` TEXT NOT NULL,				  
				  `days` INT UNSIGNED NOT NULL,
                  `send_on_date` TINYINT UNSIGNED NOT NULL,
                   `date` DATE NOT NULL
				) DEFAULT CHARSET=utf8;";			
			
			$wpdb->query($sql);
	  }
	  
	  if($wpdb->get_var("SHOW TABLES LIKE '".BFT_SENTMAILS."'") != BFT_SENTMAILS) {
	  
			$sql = "CREATE TABLE `" . BFT_SENTMAILS . "` (
				  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				  `mail_id` INT UNSIGNED NOT NULL,				  
				  `user_id` INT UNSIGNED NOT NULL,				  
				  `date` DATE NOT NULL
				) DEFAULT CHARSET=utf8;";
			$wpdb->query($sql);
	  }
	 
	  // this is email log of all the messages sent in the system 
	  if($wpdb->get_var("SHOW TABLES LIKE '".BFT_EMAILLOG."'") != BFT_EMAILLOG) {
	  
			$sql = "CREATE TABLE `" . BFT_EMAILLOG . "` (
				  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				  `sender` VARCHAR(255) NOT NULL DEFAULT '',
				  `receiver` VARCHAR(255) NOT NULL DEFAULT '',
				  `subject` VARCHAR(255) NOT NULL DEFAULT '',
				  `date` DATE,
				  `datetime` TIMESTAMP,
				  `status` VARCHAR(100) NOT NULL DEFAULT 'OK'				  
				) DEFAULT CHARSET=utf8;";
			$wpdb->query($sql);
	  }

       // attachments table      
        if($wpdb->get_var("SHOW TABLES LIKE '".BFT_ATTACHMENTS."'") != BFT_ATTACHMENTS) {             
            $sql = "CREATE TABLE IF NOT EXISTS `".BFT_ATTACHMENTS."` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `mail_id` int(10) unsigned NOT NULL DEFAULT 0,
              `nl_id` int(10) unsigned NOT NULL DEFAULT 0,
              `file_name` VARCHAR(255) NOT NULL DEFAULT '',
              `file_path` VARCHAR(255) NOT NULL DEFAULT '',
              `url` VARCHAR(255) NOT NULL DEFAULT '',
              PRIMARY KEY (`id`)
            ) DEFAULT CHARSET=utf8;";
            $wpdb->query($sql);
      } 
      
      // instant newsletters
	  if($wpdb->get_var("SHOW TABLES LIKE '".BFT_NLS."'") != BFT_NLS) {
	  
			$sql = "CREATE TABLE `" . BFT_NLS . "` (
				  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				  `subject` VARCHAR(255) NOT NULL,				  
				  `message` TEXT NOT NULL,				  
              `date` DATE NOT NULL,
              `num_sent` INT UNSIGNED NOT NULL DEFAULT 0,
              `email_type` VARCHAR(100) NOT NULL DEFAULT 'text/html'
				) DEFAULT CHARSET=utf8;";			
			
			$wpdb->query($sql);
	  }
	  
	   // unsubscribe stats per reason (reason NYI)
	  if($wpdb->get_var("SHOW TABLES LIKE '".BFT_UNSUBS."'") != BFT_UNSUBS) {
	  		$sql = "CREATE TABLE `" . BFT_UNSUBS . "` (
				  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				  `email` varchar(100) NOT NULL DEFAULT '',
				  `date` date NOT NULL DEFAULT '2000-01-01',
				  `ar_mails` smallint(5) unsigned NOT NULL DEFAULT 0,
				  `reason` varchar(255) NOT NULL DEFAULT ''
				) DEFAULT CHARSET=utf8;";
			$wpdb->query($sql);
	  }
	  
	  // add DB fields	  
	  bft_add_db_fields(array(
		  array("name"=>"content_type", "type"=>"VARCHAR(100) NOT NULL DEFAULT 'text/html'"),  		  
	  ), BFT_MAILS);
	  
	  bft_add_db_fields(array(
		  array("name"=>"auto_subscribed", "type"=>"tinyint UNSIGNED NOT NULL DEFAULT 0"),  		  
	  ), BFT_USERS);
	  
	  
	  bft_add_db_fields(array(
		  array("name"=>"nl_id", "type"=>"INT UNSIGNED NOT NULL DEFAULT 0"), /* newsletter ID */ 		  
	  ), BFT_SENTMAILS);
	  
	  bft_add_db_fields(array(
		  array("name"=>"status", "type"=>"VARCHAR(255) NOT NULL DEFAULT ''"), /* in progress or sent */
		  array("name"=>"last_user_id", "type"=>"INT UNSIGNED NOT NULL DEFAULT 0"), /* last user ID from the mailing list that we reached so far */ 		  	
		  array("name"=>"num_failed", "type"=>"INT UNSIGNED NOT NULL DEFAULT 0"), /* number of failed recipients */	  
	  ), BFT_NLS);
	  
	  $old_bft_db_version = get_option('bft_db_version');
	  
	  // DB version 1.2, plugin version 1.5
      if(!empty($old_bft_db_version) and $old_bft_db_version<1.2) {
         $sql="ALTER TABLE ".BFT_MAILS." ADD `send_on_date` TINYINT UNSIGNED NOT NULL,
            ADD `date` DATE NOT NULL";
         $wpdb->query($sql);
     }  
	  
	  update_option( 'bft_db_version', $bft_db_version);	 
	  
	  // schedule wp_cron
	  $cron_schedule = get_option('bft_cron_schedule');
	  if(!in_array($cron_schedule, array('hourly', 'daily', 'twicedaily'))) $cron_schedule = 'hourly';
	  if (! wp_next_scheduled ( 'bft_hook_up' )) {
        wp_schedule_event( time(), $cron_schedule, 'bft_hook_up' );
     }
}

/* Stores the autoresponder configuration */
function bft_options() {
	global $wpdb, $wp_roles;
	$roles = $wp_roles->roles;		
	
	// update "require name"
	if(!empty($_POST['update_require_name']) and check_admin_referer('bft_name_field')) {
		$require_name = empty($_POST['require_name']) ? 0 : 1;
		$allow_get = empty($_POST['allow_get']) ? 0 : 1;
		update_option('bft_require_name', $require_name);
		update_option('bftpro_allow_get', $allow_get);
	}

  if(!empty($_POST['settings_ok']) and check_admin_referer('bft_settings')) {
  	 // save autoresponder settings
  	 	$subscribe_notify = empty($_POST['subscribe_notify']) ? 0 : 1;
  	 	$unsubscribe_notify = empty($_POST['unsubscribe_notify']) ? 0 : 1;
  	 	$auto_subscribe = empty($_POST['auto_subscribe']) ? 0 : 1;
  	 	$subscribe_to_blog = empty($_POST['subscribe_to_blog']) ? 0 : 1;
  	 	$subscribe_auto_login = empty($_POST['subscribe_auto_login']) ? 0 : 1;
  	 	$use_cron_job = empty($_POST['use_cron_job']) ? 0 : 1;
  	 	$use_text_captcha = empty($_POST['use_text_captcha']) ? 0 : 1;
  	 	$no_signup_popup_msg = empty($_POST['no_signup_popup_msg']) ? 0 : 1;
  	 	$no_unsub_popup_msg = empty($_POST['no_unsub_popup_msg']) ? 0 : 1;
  	 	$cron_schedule = $_POST['cron_schedule'];
	   if(!in_array($cron_schedule, array('hourly', 'daily', 'twicedaily'))) $cron_schedule = 'hourly';
	   $recaptcha = empty($_POST['recaptcha']) ? 0 : 1;
	   $recaptcha_version = (empty($_POST['recaptcha_version']) or $_POST['recaptcha_version']==2) ? 2 : intval($_POST['recaptcha_version']);
		$recaptcha_size = sanitize_text_field($_POST['recaptcha_size']);
		$recaptcha_score = floatval($_POST['recaptcha_score']);
		
		
  	 	
	 update_option( 'bft_sender', sanitize_text_field($_POST['bft_sender']) );
	 update_option( 'bft_redirect', esc_url($_POST['bft_redirect']) );
	 update_option( 'bft_optin', intval($_POST['bft_optin']) );		 
	 update_option( 'bft_subscribe_notify', $subscribe_notify );
	 update_option( 'bft_unsubscribe_notify', $unsubscribe_notify );
	 update_option( 'bft_auto_subscribe', $auto_subscribe );
	 update_option( 'bft_subscribe_to_blog', $subscribe_to_blog );
	 update_option( 'bft_subscribe_auto_login', $subscribe_auto_login );
	 update_option( 'bft_use_cron_job', $use_cron_job );
	 update_option( 'bft_mails_per_run', intval($_POST['mails_per_run']) );	 
	 update_option('bft_text_captcha', strip_tags($_POST['text_captcha']));
	 update_option('bft_use_text_captcha', $use_text_captcha);
	 update_option( 'bft_no_signup_popup_msg', $no_signup_popup_msg );
	 update_option( 'bft_no_unsub_popup_msg', $no_unsub_popup_msg );
	 update_option('bft_sleep', floatval($_POST['sleep']));
	 update_option('bft_cron_schedule', $cron_schedule); // wp_cron_schedule
	 update_option('bft_bcc', sanitize_email($_POST['bcc']));
	 update_option('arigato_recaptcha', $recaptcha);
	 update_option('bftpro_recaptcha_public', sanitize_text_field($_POST['recaptcha_public']));
	 update_option('bftpro_recaptcha_private', sanitize_text_field($_POST['recaptcha_private']));
	 update_option('bftpro_recaptcha_version', $recaptcha_version);
	 update_option('bftpro_recaptcha_lang', sanitize_text_field($_POST['recaptcha_lang']));
	 update_option('bftpro_recaptcha_size', $recaptcha_size);
	 update_option('bftpro_recaptcha_score', $recaptcha_score);
	 
	 
	 // roles that can manage the autoresponder
			if(current_user_can('manage_options')) {				
				foreach($roles as $key=>$role) {
					$r=get_role($key);
					
					if(!empty($_POST['manage_roles']) and is_array($_POST['manage_roles']) and in_array($key, $_POST['manage_roles'])) {					
	    				if(!$r->has_cap('arigato_manage')) $r->add_cap('arigato_manage');
					}
					else $r->remove_cap('arigato_manage');
				}
			}	
  }

  $bft_sender = stripslashes( get_option( 'bft_sender' ) );	
  $bft_redirect = stripslashes( get_option( 'bft_redirect' ) );	
  $bft_optin = stripslashes( get_option( 'bft_optin' ) );	
  
  // double opt-in message
  if(!empty($_POST['double_optin_ok']) and check_admin_referer('bft_optin')) {
  	 update_option('bft_optin_subject', sanitize_text_field($_POST['optin_subject']));
  	 update_option('bft_optin_message', wp_kses_post($_POST['optin_message']));
  	 update_option( 'bft_optin_redirect', esc_url($_POST['bft_optin_redirect']) );
  	 update_option( 'bft_no_double_optin_popup_msg', intval(@$_POST['no_double_optin_popup_msg']) );
  }
  
  $subscribe_notify = get_option('bft_subscribe_notify');
  $unsubscribe_notify = get_option('bft_unsubscribe_notify');
  $use_cron_job = get_option('bft_use_cron_job');
  $bft_optin_redirect = stripslashes( get_option( 'bft_optin_redirect' ) ); 	 
  $use_text_captcha = get_option('bft_use_text_captcha');
  $text_captcha = get_option('bft_text_captcha');
  $require_name = get_option('bft_require_name');
  $cron_schedule = get_option('bft_cron_schedule');
  $recaptcha = get_option('arigato_recaptcha');
  $recaptcha_version = get_option('bftpro_recaptcha_version');
	$recaptcha_lang = get_option('bftpro_recaptcha_lang');
	$recaptcha_size = get_option('bftpro_recaptcha_size');
	$recaptcha_score = get_option('bftpro_recaptcha_score');
	if(empty($recaptcha_score)) $recaptcha_score = 0.5;
	$allow_get = get_option('bftpro_allow_get');
	$subscribe_to_blog = get_option('bft_subscribe_to_blog');
	$subscribe_auto_login = get_option('bft_subscribe_auto_login');
  
  // load 3 default questions in case nothing is loaded
	if(empty($text_captcha)) {
		$text_captcha = __('What is the color of the snow? = white', 'broadfast').PHP_EOL.__('Is fire hot or cold? = hot', 'broadfast') 
			.PHP_EOL. __('In which continent is France? = Europe', 'broadfast'); 
	}
	
  list($recaptcha_html, $recaptcha2, $recaptcha3) = arigato_recaptcha();
  
  require(BFT_PATH."/views/bft_main.html.php");
}

/* import/export */
function bft_import() {
	global $wpdb;

	if(!empty($_POST['broadfast_import']) and check_admin_referer('bft_import')) {
		if(empty($_FILES["file"]["name"])) {
			die(__("Please upload file", 'broadfast'));
		}
		
		if(empty($_POST["delim"])) {
			die(__("There must be a delimiter", 'broadfast'));
		}
		
		// validate mime type. Thanks to https://stackoverflow.com/questions/6654351/check-file-uploaded-is-in-csv-format
		$csv_mimetypes = array(
		    'text/csv',
		    'text/plain',
		    'application/csv',
		    'text/comma-separated-values',
		    'application/excel',
		    'application/vnd.ms-excel',
		    'application/vnd.msexcel',
		    'text/anytext',
		    'application/octet-stream',
		    'application/txt',
		);
		
		if(!in_array($_FILES['file']['type'], $csv_mimetypes)) wp_die(__('The uploaded file type is not accepted. You need to upload a CSV file.', 'broadfast'));
		
		$rows = file($_FILES["file"]["tmp_name"]);
		
		$delim = $_POST['delim'];
		if(!in_array($delim, array(',', ';', '\t'))) $delim = ',';

		foreach($rows as $cnt => $row) {
			if(!empty($_POST['skip_title_row']) and $cnt == 0) continue;
			//explode values
			$values = explode($delim, $row);
			$position = intval($_POST['email_column'])-1;
			$name_position = intval($_POST['name_column'])-1;
			if($position<0 or !is_numeric($position)) $position=0;			
			if($name_position<0 or !is_numeric($name_position)) $name_position=1;			
			$email = trim(@$values[$position]);
			$email = sanitize_email($email);
			$name = trim(@$values[$name_position]);
			$name = sanitize_text_field($name);
			
			$sql="INSERT IGNORE INTO ".BFT_USERS." SET date=CURDATE(), name=%s, email=%s, status=1"; 
			$wpdb->query($wpdb->prepare($sql, $name, $email));
			
			bft_welcome_mail($wpdb->insert_id);
		}
		
		$num_imported = empty($_POST['skip_title_row']) ? count($rows) : count($rows) - 1;
		$success_text="<p style='color:green;'><b>".sprintf(__('%d subscribers were imported', 'broadfast'), $num_imported)."</b></p>";
	}
	
	if(!empty($_POST['broadfast_export']) and check_admin_referer('bft_export')) {
		$active_sql = '';
		if(!empty($_POST['active'])) {
			$active_sql=" AND status='1' ";
		}
	
		$sql="SELECT * FROM ".BFT_USERS." WHERE 1 $active_sql
		ORDER BY email";		
		$members=$wpdb->get_results($sql);
		
		$newline = broadfast_define_newline();
		
		$content=__('Email', 'broadfast').','.__('Name', 'broadfast').','.
			__('IP Address', 'broadfast').','.__('Date signed', 'broadfast').$newline;
			
		foreach($members as $member) {
			$content.="{$member->email},{$member->name},{$member->ip},{$member->date}".$newline;
		}
		
		// credit to http://yoast.com/wordpress/users-to-csv/	
		$now = gmdate('D, d M Y H:i:s') . ' GMT';
		
		$filename = 'subscribers.csv';
	
		header('Content-Type: ' . broadfast_get_mime_type());
		header('Expires: ' . $now);
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Pragma: no-cache');
		echo $content;
		exit;
	}

	require(BFT_PATH."/views/bft_import.html.php");
}

/* sends the first welcome mail to newly registered or imported user
if such has been scheduled. Scheduling of those mails is done by setting "0" for "days" */
function bft_welcome_mail($uid) {
	global $wpdb;
   $uid = intval($uid);
	
	// select email
	$sql="SELECT * FROM ".BFT_MAILS." WHERE days=0";	
	$mail=$wpdb->get_row($sql);
		
	if(empty($mail->id)) return false;
	
	// select member
	$sql="SELECT * FROM ".BFT_USERS." WHERE id='$uid' AND status=1";
	$member=$wpdb->get_row($sql);
	if(empty($member->id)) return false;
	
	$attachments = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".BFT_ATTACHMENTS."
					WHERE mail_id = %d ORDER BY id", $mail->id));	
					
	// insert in sent
	$wpdb->query($wpdb->prepare("INSERT INTO ".BFT_SENTMAILS." SET
						mail_id=%d, user_id=%d, date=%s", $mail->id, $uid, date("Y-m-d", current_time('timestamp'))));									
	do_action('arigato_welcome_email', $uid, $mail, $member);	
	bft_customize($mail,$member, $attachments);
}

/* private function called to customize an email message and send it */
function bft_customize($mail,$member, $attachments = null) {
	// send mail to member
	$subject=$mail->subject;				
	$message=$mail->message;
	
	$subject=str_replace("{{name}}",$member->name,$subject);
	$subject=str_replace("{{email}}",$member->email,$subject);
	
	$message=str_replace("{{name}}",$member->name,$message);
	$message=str_replace("{{email}}",$member->email,$message);
	
	$content_type = empty($mail->content_type) ? 'text/html' : $mail->content_type;
				
	// add unsubscribe link
	$unsub_url = get_option('siteurl')."/?bft=bft_unsubscribe&email=".$member->email;
	if(strstr($message, '{{{unsubscribe-url}}}') or strstr($message, '{{{unsubscribe-link}}}')) {
		$message = str_replace('{{{unsubscribe-url}}}', $unsub_url, $message);
		$message = str_replace('{{{unsubscribe-link}}}', '<a href="'.$unsub_url.'">'.$unsub_url.'</a>', $message);
	}
	else {
		// add the default one
		if($content_type == 'text/html') {
			$message.= "<br><br>".__('To unsubscribe from our list visit the url below:', 'broadfast').
			"<br><a href='$unsub_url'>$unsub_url</a>";
			$message=str_replace("\t","",$message);
		}
		else {
			$message.= "\n\n".__('To unsubscribe from our list visit the url below:', 'broadfast')."\n".$unsub_url;		
		}
	}
	
	$message = do_shortcode($message);
	
	$sender = empty($mail->sender) ? BFT_SENDER : $mail->sender;
	
	// sleep?
	if(BFT_SLEEP) usleep(BFT_SLEEP * 1000000);
	
	return bft_mail($sender,$member->email,$subject,$message, $content_type, $attachments);
}

// handle all this stuff on template_redirect call so
// plugins and especially the possible WP MAIL SMTP are loaded!!
function bft_template_redirect() {
	global $wpdb, $post;	
	
	//  subscribe user
	if(!empty($_REQUEST['bft']) and $_REQUEST['bft']=='register') {
		$email = sanitize_email($_POST['email']);
		$name = sanitize_text_field($_POST['user_name']);
		
		bft_subscribe($email, $name);
			
		add_filter('the_content', 'bft_screenmsg');
	}
	
	
	// unsubscribe user
	if(!empty($_GET['bft']) and $_GET['bft']=='bft_unsubscribe') {		
      $_GET['email'] = sanitize_email($_GET['email']);	
      
      // if there is a page with [bft-unsubscribe] shortcode on it, we'll also require $_POST[bft_usubscribe] to be non-empty
      // and when empty, we'll display form
     	$unsub_post_id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} 
				WHERE (post_status='publish' or post_status='private')
				AND post_content LIKE '%[bft-unsubscribe]%'");
		
		// there is such post, we are not on it and the form is not submitted		
		if(!empty($unsub_post_id) and empty($_POST['bft_unsubscribe']) and !strstr(@$post->content, '[bft-unsubscribe]')) {
			$link = get_permalink($unsub_post_id);
			unset($_GET['bft']);
			$link = add_query_arg($_GET, $link);			
			bft_redirect($link);
			exit;
		}	 
	  
	  	// let's unsubscribe in the following conditions:
	  	// there is NO post with unsubscribe code OR $_POST[bft_usubscribe] is there	  	
	  	if(empty($unsub_post_id) or !empty($_POST['bft_unsubscribe'])) {
	  		//  notify admin?
			if(get_option('bft_unsubscribe_notify')) {
				// select this user
				$user = $wpdb->get_row( $wpdb->prepare(" SELECT * FROM ".BFT_USERS." WHERE email=%s", $_GET['email']));			
				
				bft_unsubscribe_notify($user);
			}
			
			$sql="DELETE FROM ".BFT_USERS." WHERE email=%s";
			$email = empty($_GET['email']) ? $_POST['email'] : $_GET['email'];
			$email = sanitize_email($email);
			$wpdb->query($wpdb->prepare($sql, $email));
			
			// insert in unsubs (obfuscate email - right to be forgotten)
			$wpdb->query($wpdb->prepare("INSERT INTO ".BFT_UNSUBS." SET email=%s, date=%s", md5($email), date("Y-m-d", current_time('timestamp') ) ));
			
			echo "<html><script data-cfasync='false' type='text/javascript'>\n";
			
			if(get_option('bft_no_unsub_popup_msg') != 1) echo "alert('".__('You have been unsubscribed.', 'broadfast')."');\n";
				
			echo "window.location='".(!empty($bft_redirect) ? $bft_redirect : site_url())."';
			</script></html>";
			exit;
	  	} // end actual unsubscribe action
	  	
	} // end unsubscribe
	
	// confirm user registration
	if(!empty($_REQUEST['bft']) and $_REQUEST['bft']=='bft_confirm') {
		// select user
      $_GET['code'] = sanitize_text_field($_GET['code']);
		$sql=$wpdb->prepare("SELECT * FROM ".BFT_USERS." WHERE id=%d AND code=%s", 
   		intval($_GET['id']), $_GET['code']);	
		$member = $wpdb->get_row($sql);	
		
		$bft_redirect = stripslashes( get_option( 'bft_optin_redirect' ) );
		if(empty($bft_redirect)) $bft_redirect = get_option('bft_redirect');	
		
		if(!empty($member->id)) {			
			$sql="UPDATE ".BFT_USERS." SET 
			code='".substr(md5($_GET['code'].time()), 0,8)."',
			status=1
			WHERE id='{$member->id}'";		
			$wpdb->query($sql);
			
			do_action('arigato_confirmed', $member->id);
			bft_subscribe_to_blog($mid);
			
			bft_welcome_mail($member->id);
			
			// notify admin?			
			if(get_option('bft_subscribe_notify')) {
				bft_subscribe_notify($member->id);
			}
		}
		
		// display success message
		echo "<html><script data-cfasync='false' type='text/javascript'>\n";
		if(get_option('bft_no_double_optin_popup_msg')!=1) {
			echo "alert('".__('Your email address has been confirmed!', 'broadfast')."');\n";
		}
		echo "window.location='".($bft_redirect?$bft_redirect:site_url())."';
		</script></html>";
		exit;
	}
}

// the actual autoresponder hook - it's run when the index page is loaded
function bft_hook_up() {
  $use_cron_job = get_option('bft_use_cron_job');
  
	// If user chose to run cron job, execute this only when the GET param is present  
	// this way even in WP cron calls the same funciton it will not run wrongly
  if($use_cron_job == 1 and empty($_GET['bft_cron'])) return true;
  
  update_option('bft_hooked_up', current_time('mysql'));
  	 
  if(!defined('BFT_SENDER')) define('BFT_SENDER',get_option( 'bft_sender' ));
  require(BFT_PATH."/controllers/bft_hook.php");    

  // for real cron job exit here  
  if($use_cron_job == 1 and !empty($_GET['bft_cron'])) die(__('Running in cron job mode', 'broadfast'));
}

// handle shortcode
function bft_shortcode_signup($attr) {			
	ob_start();

	$text_captcha_html = '';
	if(get_option('bft_use_text_captcha')) {
		$text_captcha_html = BFTTextCaptcha :: generate();
	}	
	
	list($recaptcha_html, $recaptcha2, $recaptcha3) = arigato_recaptcha();
	
	$require_name = get_option('bft_require_name');
	$allow_get = get_option('bftpro_allow_get');
	$name = $email = '';
	if($allow_get) {
		if(!empty($_GET['arigato_name'])) $name = esc_attr($_GET['arigato_name']);
		if(!empty($_GET['arigato_email'])) $email = esc_attr($_GET['arigato_email']);
	}
	
	require_once(BFT_PATH."/views/signup-form.html.php");
	$contents = ob_get_contents();
	ob_end_clean();
	
	return $contents;
}

// function to conditionally add DB fields
function bft_add_db_fields($fields, $table) {
		global $wpdb;
		
		// check fields
		$table_fields = $wpdb->get_results("SHOW COLUMNS FROM `$table`");
		$table_field_names = array();
		foreach($table_fields as $f) $table_field_names[] = $f->Field;		
		$fields_to_add=array();
		
		foreach($fields as $field) {
			 if(!in_array($field['name'], $table_field_names)) {
			 	  $fields_to_add[] = $field;
			 } 
		}
		
		// now if there are fields to add, run the query
		if(!empty($fields_to_add)) {
			 $sql = "ALTER TABLE `$table` ";
			 
			 foreach($fields_to_add as $cnt => $field) {
			 	 if($cnt > 0) $sql .= ", ";
			 	 $sql .= "ADD $field[name] $field[type]";
			 } 
			 
			 $wpdb->query($sql);
		}
}

// register personal data eraser
function bft_register_personal_data_eraser($erasers) {
		$erasers['arigato_eraser'] = array(
			'eraser_friendly_name' => 'Arigato Eraser', 
			'callback' => 'bft_personal_data_eraser', 
		);
		
		return $erasers;
} // end register_personal_data_eraser

// the actual personal data eraser
function bft_personal_data_eraser($email_address) {
	global $wpdb;
	
	$users = $wpdb->get_results($wpdb->prepare("SELECT id FROM ".BFT_USERS." WHERE email=%s", $email_address));
	$wpdb->query($wpdb->prepare("DELETE FROM ".BFT_EMAILLOG." WHERE receiver=%s", $email_address));
	
	if(count($users)) {
			$uids = array();
			foreach($users as $user) $uids[] = $user->id;
			
			$uid_sql = implode(', ', $uids);
			
			$wpdb->query("DELETE FROM ".BFT_USERS." WHERE id IN ($uid_sql)");
			$wpdb->query("DELETE FROM ".BFT_SENTMAILS." WHERE user_id IN ($uid_sql)");
	}
	
	return array(
        'items_removed'  => count($users),
        'items_retained' => false, // always false in this example
        'messages'       => array(), // no messages in this example
        'done'           => true,
   );
}

register_activation_hook(__FILE__,'bft_install');
add_action('init', 'bft_init');
add_action('admin_menu', 'bft_autoresponder_menu');
add_action('template_redirect', 'bft_template_redirect');
add_shortcode( 'BFTWP', "bft_shortcode_signup" );
add_action('wp_login', 'bft_auto_subscribe', 10, 2);
add_action('bft_hook_up', 'bft_hook_up');