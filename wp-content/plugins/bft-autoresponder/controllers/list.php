<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Manages the mailing list */
function bft_list(){
	global $wpdb;
	
	$action = empty($_GET['action']) ? 'list' : $_GET['action'];
	
	if(isset($_POST['email'])) $email = sanitize_email($_POST['email']);
	if(isset($_POST['user_name'])) $name = sanitize_text_field($_POST['user_name']);
	if(isset($_POST['id'])) $id = intval($_POST['id']);
	$status = empty($_POST['status']) ? 0 : 1;
	$dateformat = get_option('date_format');
	
	$offset = empty($_GET['offset']) ? 0 : intval($_GET['offset']);
	$ob = sanitize_text_field(@$_GET['ob']);
	
	switch($action) {
		case 'edit':
			if(!empty($_POST['save_user']) and check_admin_referer('bft_list_user')) {
				$sql=$wpdb->prepare("UPDATE ".BFT_USERS." SET 
				date=%s, name=%s, email=%s, status=%d
				WHERE id=%d", sanitize_text_field($_POST['date']), $name, $email, $status, intval($_GET['id']));
				$wpdb->query($sql);
				
				$url = "admin.php?page=bft_list&offset=".$offset."&ob=".$ob;
				bft_redirect($url);
            //    echo "<meta http-equiv='refresh' content='0;url=$url' />"; 				
				exit;
			}
			
			// select user
			$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . BFT_USERS . " WHERE id=%d", intval($_GET['id'])));
			
			// enqueue datepicker
			wp_enqueue_script('jquery-ui-datepicker');
			wp_enqueue_style('jquery-style', BFT_URL.'/css/jquery-ui.css');			
			require(BFT_PATH."/views/list-user.html.php");	
		break;		
		
		case 'list':
		default:
			$per_page = 20;
			$offset = empty($_GET['offset']) ? 0 : intval($_GET['offset']);		
			
		  $error = false;

			if(!empty($_POST['add_user']) and check_admin_referer('bft_list_user')) {
		        // user exists?
		        $exists=$wpdb->get_row($wpdb->prepare("SELECT *
		                FROM ".BFT_USERS." WHERE email=%s", $email));
		       
		        if(empty($exists->id)) {
		            $sql="INSERT IGNORE INTO ".BFT_USERS." SET name=%s,email=%s,status=%s,date=%s";
		            $wpdb->query($wpdb->prepare($sql, $name, $email, $status, date("Y-m-d", current_time('timestamp'))));
		            
		            if($status) bft_welcome_mail($wpdb->insert_id);    
		        }		
		        else {
		            $error=true;
		            $err_msg = "User with this email address already exists.";
		        }
			}
			
			if(!empty($_POST['del_user']) and check_admin_referer('bft_del_user')) {
				$wpdb->delete(BFT_USERS, array('id' => $id));
			}
			
			// mass delete
			if(!empty($_POST['mass_delete']) and !empty($_POST['del_ids']) and check_admin_referer('bft_mass_del')) {
				
				// make sure it contains only numbers and commas
				$del_ids = preg_replace('/[^0-9,]/', '', $_POST['del_ids']);				
				$wpdb->query("DELETE FROM ".BFT_USERS." WHERE id IN (".$del_ids.")");
			}
			
			// select users from the mailing list
			$ob = in_array(@$_GET['ob'], array("tU.email","tU.name","tU.ip","tU.date","tU.status,tU.email","cnt_mails"))? $_GET['ob'] : 'email';
			$dir = 'ASC';
			if($ob == 'cnt_mails') $dir = 'DESC';
			
			$filters_sql = "";
			
			if(!empty($_GET['filter_email'])) {
				$filter_email = sanitize_email($_GET['filter_email']);
				$filter_email = "%".$filter_email."%";
				$filters_sql.=$wpdb->prepare(" AND email LIKE %s ", $filter_email); 
			}			
			
			if(!empty($_GET['filter_name'])) {
				$filter_name = sanitize_text_field($_GET['filter_name']);
				$filter_name="%".$filter_name."%";
				$filters_sql.=$wpdb->prepare(" AND name LIKE %s ", $filter_name); 
			}
			
			if(!empty($_GET['filter_ip'])) {
				$filter_ip = sanitize_text_field($_GET['filter_ip']);
				$filter_ip="%".$filter_ip."%";
				$filters_sql.=$wpdb->prepare(" AND ip LIKE %s ", $filter_ip); 
			}
			
			if(isset($_GET['filter_status']) and intval($_GET['filter_status'])!=-1) {		
				$filter_status = intval($_GET['filter_status']);
				$filters_sql.=$wpdb->prepare(" AND tU.status=%d ", $filter_status); 
			}
			
			if(!empty($_GET['signup_date_cond']) and !empty($_GET['filter_signup_date'])) {			
				switch($_GET['signup_date_cond']) {
					case 'before': $signup_date_cond = '<'; break;
					case 'after': $signup_date_cond = '>'; break;
					case 'on': default: $signup_date_cond = '='; break;
				}
				$filter_signup_date = sanitize_text_field($_GET['filter_signup_date']);
				$filters_sql .= $wpdb->prepare(" AND tU.date ".$signup_date_cond." %s ", $filter_signup_date);			
			}
			
			$sql="SELECT SQL_CALC_FOUND_ROWS tU.*, COUNT(tS.id) as cnt_mails FROM ".BFT_USERS." tU
				LEFT JOIN ".BFT_SENTMAILS." tS ON tS.user_id=tU.id 
				WHERE 1 $filters_sql
				GROUP BY tU.id ORDER BY $ob $dir LIMIT $offset, $per_page";
			$users=$wpdb->get_results($sql);
			
			$count = $wpdb->get_var("SELECT FOUND_ROWS()");
			
			// are there any filters? Used to know whether to display the filter box
			$any_filters = false;
			if(!empty($_GET['filter_email']) or !empty($_GET['filter_name']) or !empty($_GET['filter_ip'])
				or (isset($_GET['filter_status']) and intval($_GET['filter_status'])!=-1)
				or (!empty($_GET['signup_date_cond']) and !empty($_GET['filter_signup_date'])) ) {
					$any_filters = true;
			}
			
			// num unsubscribed users
			$num_unsubs = $wpdb->get_var("SELECT COUNT(id) FROM ".BFT_UNSUBS);
			
			bft_enqueue_datepicker();
			require(BFT_PATH."/views/bft_list.html.php");	
		break; // end list / add
	}
}

// auto-subscribe user
function bft_auto_subscribe($user_login, $user) {
	global $wpdb;
	
	// only do this if the setting is selected
	if(!get_option('bft_auto_subscribe')) return false;
		
	// if already logged in, return false to avoid needless queries
	if(get_user_meta($user->ID, 'bft_logged_in', true)) return false;
		
	add_user_meta( $user->ID, 'bft_logged_in', 1, true);
	
	$code = substr(md5(microtime().$user_login), 0, 8);	
	$sql = $wpdb->prepare("INSERT IGNORE INTO ".BFT_USERS." (name,email,status,code,date,ip, auto_subscribed)
	VALUES (%s,%s,1,%s,CURDATE(),%s)", $user_login, $user->user_email, $code, '', 1);		
	$wpdb->query($sql);
	$mid = $wpdb->insert_id;
	
	if(empty($mid)) return true;
	
	bft_welcome_mail($mid);
	
	// notify admin?			
	if(get_option('bft_subscribe_notify')) {				
		bft_subscribe_notify($mid);
	}	
} // end auto-subscribe

// subscribe to the site in case that's selected
function bft_subscribe_to_blog($mid) {
	if(get_option('bft_subscribe_to_blog') != 1) return false;
	global $wpdb;
	
	// select user
	$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".BFT_USERS." WHERE id=%d", intval($mid)));
	
	// if user is auto-subscribed in this list, we should not continue with this procedure to avoid endless loop
	if($user->auto_subscribed) $action_completed = true;
	
	// if the user is already registered, do nothing
		$wp_user = get_user_by('email', $user->email);
		if(!empty($wp_user->ID)) $action_completed = true;

		if(empty($action_completed)) {
		// prepare desired username
		$target_username = empty($user->name) ? strtolower(substr($user->email, 0, strpos($user->email, '@')+1)) : strtolower(preg_replace("/\s/",'_',$user->name));
		
		// check if target username is available
		$wp_user = get_user_by('login', $target_username);
		
		// if not, find how many users whose username starts with this are available, and add a number to make it unique
		// then again check if it's unique, and if not, add timestamp
		if(!empty($wp_user->ID)) {
			$num_users = $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->users} WHERE user_login LIKE '$target_username%'");
			
			if($num_users) {
				$num = $num_users+1;
				$old_target_username = $target_username;
				$target_username = $target_username."_".$num;
				
				$wp_user = get_user_by('login', $target_username);
			
				// still not unique? Add timestamp and hope no one is crazy enough to have the same
				if(!empty($wp_user->ID)) $target_username = $old_target_username . '_' . time(); 
			}
		}
		
		// finally use the username to create the user
		$random_password = wp_generate_password();
		$user_id = wp_create_user( $target_username, $random_password, $user->email );
		
		// update name if any
		if(!empty($user->name)) {
			list($fname, $lname) = array_pad(explode(' ', $user->name, 2), 2, null);
			wp_update_user(array("ID"=>$user_id, "first_name"=>$fname, "last_name"=>$lname));
		}
		
		// log them in?
		if(get_option('bft_subscribe_auto_login')) {
			wp_set_current_user($user_id);
  			wp_set_auth_cookie($user_id);
		}
	}
} // end bft_subscribe_to_blog()
