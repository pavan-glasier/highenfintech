<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Adapted code from the MIT licensed QuickDD class
// created also by me
function BFTquickDD_date($name, $date=NULL, $format=NULL, $markup=NULL, $start_year=1900, $end_year=2100) {
   // normalize params
   if(empty($date) or !preg_match("/\d\d\d\d\-\d\d-\d\d/",$date)) $date=date("Y-m-d");
    if(empty($format)) $format="YYYY-MM-DD";
    if(empty($markup)) $markup=array();

    $parts=explode("-",$date);
    $html="";

    // read the format
    $format_parts=explode("-",$format);

    $errors=array();
    
    // let's output
    foreach($format_parts as $cnt=>$f) {
        if(preg_match("/[^YMD]/",$f)) 
        { 
            $errors[]="Unrecognized format part: '$f'. Skipped.";
            continue;
        }

        // year
        if(strstr($f,"Y"))
        {
            $extra_html="";
            if(isset($markup[$cnt]) and !empty($markup[$cnt])) $extra_html=" ".$markup[$cnt];
            $html.=" <select name=\"".$name."year\"".$extra_html.">\n";

            for($i=$start_year;$i<=$end_year;$i++)
            {
                $selected="";
                if(!empty($parts[0]) and $parts[0]==$i) $selected=" selected";
                
                $val=$i;
                // in case only two digits are passed we have to strip $val for displaying
                // it's either 4 or 2, everything else is ignored
                if(strlen($f)<=2) $val=substr($val,2);        
                
                $html.="<option value='$i'".$selected.">$val</option>\n";
            }

            $html.="</select>";    
        }

        // month
        if(strstr($f,"M"))
        {
            $extra_html="";
            if(isset($markup[$cnt]) and !empty($markup[$cnt])) $extra_html=" ".$markup[$cnt];
            $html.=" <select name=\"".$name."month\"".$extra_html.">\n";

            for($i=1;$i<=12;$i++)
            {
                $selected="";
                if(!empty($parts[1]) and intval($parts[1])==$i) $selected=" selected";
                
                $val=sprintf("%02d",$i);
                    
                $html.="<option value='$val'".$selected.">$val</option>\n";
            }

            $html.="</select>";    
        }

        // day - we simply display 1-31 here, no extra intelligence depending on month
        if(strstr($f,"D")) {
            $extra_html="";
            if(isset($markup[$cnt]) and !empty($markup[$cnt])) $extra_html=" ".$markup[$cnt];
            $html.=" <select name=\"".$name."day\"".$extra_html.">\n";

            for($i=1;$i<=31;$i++) {
                $selected="";
                if(!empty($parts[2]) and intval($parts[2])==$i) $selected=" selected";
                
                if(strlen($f)>1) $val=sprintf("%02d",$i);
                else $val=$i;
                    
                $html.="<option value='$val'".$selected.">$val</option>\n";
            }

            $html.="</select>";    
        }
    }

    // that's it, return dropdowns:
    return $html;
}

// send notice when someone subscribes
function bft_subscribe_notify($mid) {
	global $wpdb;	
	$mid = intval($mid);
	$member = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".BFT_USERS." WHERE id=%d", $mid));
 
	$subject = get_option('bft_subscribe_notify_subject');
	if(empty($subject)) $subject = sprintf(__("New user subscribed to the mailing list at %s", 'broadfast'), get_option('blogname'));
	$message = get_option('bft_subscribe_notify_message');
	if(empty($message)) $message = __('User details:', 'broadfast')."<br><p>".__('Name:', 'broadfast').' '.$member->name.'</p><p>'.__('Email:', 'broadfast').' '.$member->email;
	
	// replace variables if any
	$message = str_replace('{{{blog-name}}}', get_option('blogname'), $message);
	$message = str_replace('{{{subscriber-name}}}', $member->name, $message);
	$message = str_replace('{{{subscriber-email}}}', $member->email, $message);
	$message = str_replace('{{{date}}}', date(get_option('date_format'), time()), $message);
	
	$subject = stripslashes($subject);
	$message = stripslashes($message);
	
	$admin_email = get_option('bft_sender');
	$receivers = get_option('bft_subscribe_notify_receivers');
	if(empty($receivers)) $receivers = $admin_email;
	
	bft_mail($admin_email, $receivers, $subject, $message, 'text/html');	 
}

// send notice when someone unsubscribes
function bft_unsubscribe_notify($user) {
	
	 $subject = get_option('bft_unsubscribe_notify_subject');
	 if(empty($subject)) $subject = __("An user unsubscribed from the mailing list at", 'broadfast').' '.get_option('blogname');	
	 
	 $message = get_option('bft_unsubscribe_notify_message');
	 if(empty($message)) {
		 $message = __('User name:', 'broadfast').' <b>'.$user->name."</b><br>";
		 $message .= __('User email:', 'broadfast').' <b>'.$user->email."</b><br>";
		 $message .= __('Registration date:', 'broadfast').' <b>'.date(get_option('date_format', strtotime($user->date)))."</b>";
 	 }
 	 
 	 // replace variables if any
	$message = str_replace('{{{blog-name}}}', get_option('blogname'), $message);
	$message = str_replace('{{{subscriber-name}}}', $user->name, $message);
	$message = str_replace('{{{subscriber-email}}}', $user->email, $message);
	$message = str_replace('{{{date}}}', date(get_option('date_format'), strtotime($user->date)), $message);
 	 
 	 $subject = stripslashes($subject);
	 $message = stripslashes($message);
	 
	 $admin_email = get_option('bft_sender');
	 $receivers = get_option('bft_unsubscribe_notify_receivers');
	 if(empty($receivers)) $receivers = $admin_email;
	 bft_mail($admin_email, $receivers, $subject, $message, 'text/html');	 
}

/* wrapper for wp_mail() function */
function bft_mail($from, $to, $subject, $message, $content_type = 'text/html', $attachments = NULL) {
	global $wpdb;   	
	if(empty($from)) $from = get_option('admin_email');
	
	// make sure $from supports the new format
	if(strstr($from, ',')) {
		$parts = explode(',', $from);
		$from = $parts[0].' <'.trim($parts[1]).'>';
	}
	
   $headers=array();
	$headers[] = "Content-Type: ".$content_type;
	$headers[] = 'From: '.$from;
	$headers[] = 'sendmail_from: '.$from;
	if(BFT_BCC_ALL) $headers[] = 'Bcc: ' . BFT_BCC_ALL;
	
	// if $to is in format name <email@dot.com> break it so only email@dot.com is used
	if(strstr($to, '<')) {
		$toparts = explode('<', $to);
		$to = str_replace('>', '', $toparts[1]);		
	}
   
   $subject=stripslashes($subject);
   $message=stripslashes($message);   
   $message=wpautop($message);

   // strip tags from non-HTML emails
   if($content_type != 'text/html') $message = strip_tags($message);    
   
   	// prepare attachments if any	
	if($attachments and is_array($attachments)) {
		$atts = array();
		foreach($attachments as $attachment) $atts[] = $attachment->file_path;
		$attachments = $atts;
	} 
      
   if(BFT_DEBUG) echo( "From: $from To: $to<br>".$subject.'<br>'.$message."<br>");  
   $result = wp_mail($to, $subject, $message, $headers, $attachments);
   
	do_action('arigato_sent_mail', $from, $to, $subject, $message, $result);   
   
   // insert into the email log
   $status = $result ? 'OK' : 'Error';
   $wpdb->query($wpdb->prepare("INSERT INTO ".BFT_EMAILLOG." SET
   	sender=%s, receiver=%s, subject=%s, date=CURDATE(), status=%s",
   	$from, $to, $subject, $status));
   
   return $result;
}

function bft_subscribe($email, $name, $noalert = false, $in_admin = false) {
	global $wpdb;
	
	$status = !get_option( 'bft_optin' );
   $email = sanitize_email($email);
   
	if(empty($email) or !strstr($email, '@')) wp_die(__("Please enter valid email address", 'broadfast'));
		
		$code = substr(md5($email.microtime()),0,8);

		// text captcha		
		if(get_option('bft_use_text_captcha') and !$in_admin) {
			if(!BFTTextCaptcha :: verify($_POST['bft_text_captcha_question'], $_POST['bft_text_captcha_answer'])) {
      		wp_die(__('The verification question was not answered correctly. Please go back and try again.', 'broadfast'));
      	}
		}
		
		// recaptcha?
		$require_recaptcha = get_option('arigato_recaptcha');
      if($require_recaptcha and empty($in_admin)) {
      	
      	$recaptcha_public = get_option('bftpro_recaptcha_public');
			$recaptcha_private = get_option('bftpro_recaptcha_private');
			$recaptcha_version = get_option('bftpro_recaptcha_version');
			
			if($recaptcha_public and $recaptcha_private) {				
                  
         	// recaptcha v 2 and v3, thanks to https://www.sitepoint.com/no-captcha-integration-wordpress/
            $response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';
				$remote_ip = $_SERVER["REMOTE_ADDR"];     
				// make a GET request to the Google reCAPTCHA Server
				$request = wp_remote_get(
					'https://www.google.com/recaptcha/api/siteverify?secret='.$recaptcha_private.'&response=' . $response . '&remoteip=' . $remote_ip
				);       
				$response_body = wp_remote_retrieve_body( $request );
				$result = json_decode( $response_body, true );					
				if(!$result['success']) {
					wp_die(sprintf(__('The captcha verification is not correct. Please go back and try again. (%s)', 'broadfast'), @$result['error-codes'][0]));
				}
				
				if($recaptcha_version == 3) {
					// for version 3 we must verify score and action					
					$recaptcha_score = get_option('bftpro_recaptcha_score');
					if(empty($recaptcha_score)) $recaptcha_score = 0.5;
					if($result['score'] < $recaptcha_score or $result['action'] != 'register') {
						wp_die(__('The captcha verification is not correct. Please go back and try again.', 'broadfast'));
					}
				}
				
			}
      } // end recaptcha
		
		// user exists
		$sql = $wpdb->prepare("SELECT id FROM ".BFT_USERS." WHERE email=%s", $email);
		$id = $wpdb->get_var($sql);		
		
		if(!$id) {			
			$sql="INSERT IGNORE INTO ".BFT_USERS." (name,email,status,code,date,ip)
			VALUES (%s,%s,%s,%s,CURDATE(),'')";		
			$wpdb->query($wpdb->prepare($sql, $name, $email, $status, $code));
			$id = $wpdb->insert_id;
		}
		else {
			$sql=$wpdb->prepare("UPDATE ".BFT_USERS." SET code=%s WHERE id=%d", $code, $id);
			$wpdb->query($sql);
		}
		$bft_redirect = stripslashes( get_option( 'bft_redirect' ) );	
		
		if($status) {
			$mid = $id;
			bft_welcome_mail($mid);
					
			// notify admin?			
			if(get_option('bft_subscribe_notify')) {				
				bft_subscribe_notify($mid);
			}	
			
			do_action('arigato_subscribed', true, $mid);
			bft_subscribe_to_blog($mid);
			
			// display success message
			if($noalert) return true;
			echo "<html><script data-cfasync='false' type='text/javascript'>\n";
			if(get_option('bft_no_signup_popup_msg') != 1) echo "alert('".__('You have been subscribed!', 'broadfast')."')\n";
			echo "window.location='".($bft_redirect?$bft_redirect:site_url())."';
			</script></html>";
			exit;
		}
		else {
			$mid = $id;
			// send confirmation email
			$url=site_url("?bft=bft_confirm&code=$code&id=$id");
			
			$subject = get_option('bft_optin_subject');
			if(empty($subject)) $subject=__("Please confirm your email", 'broadfast');
			$subject = str_replace('{{name}}', $name, $subject);
			
			$message = get_option('bft_optin_message');	
			if(empty($message)) {							
				$message=__("Please click on the link below or copy and paste it in the browser address bar:<br><br>", 'broadfast').
				'<a href="'.$url.'">'.$url.'</a>';
			} else {
				if(strstr($message, '{{url}}')) $message = str_replace('{{url}}', $url, $message);
				else $message .= '<br><br><a href="'.$url.'">'.$url.'</a>';
			}
			$message = str_replace('{{name}}', $name, $message);
			$message = str_replace('{{email}}', $email, $message);
			$message = str_replace('{{ip}}', $_SERVER['REMOTE_ADDR'], $message);
			
			do_action('arigato_subscribed', false, $mid);

			// send the optin email			
			bft_mail(BFT_SENDER,$email,$subject,$message, 'text/html');
			if($noalert) return true;
			echo "<html><script data-cfasync='false' type='text/javascript'>
			alert('".__('Please check your email. A confirmation link is sent to it.', 'broadfast')."');
			window.location='".($bft_redirect?$bft_redirect:site_url())."';
			</script></html>";
			exit;
		}
}

function broadfast_define_newline() {
	// credit to http://yoast.com/wordpress/users-to-csv/
	$unewline = "\r\n";
	if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'win')) {
	   $unewline = "\r\n";
	} else if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'mac')) {
	   $unewline = "\r";
	} else {
	   $unewline = "\n";
	}
	return $unewline;
}

function broadfast_get_mime_type()  {
	// credit to http://yoast.com/wordpress/users-to-csv/
	$USER_BROWSER_AGENT="";

			if (preg_match('/OPERA(\/| )([0-9].[0-9]{1,2})/', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
				$USER_BROWSER_AGENT='OPERA';
			} else if (preg_match('/MSIE ([0-9].[0-9]{1,2})/',strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
				$USER_BROWSER_AGENT='IE';
			} else if (preg_match('/OMNIWEB\/([0-9].[0-9]{1,2})/', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
				$USER_BROWSER_AGENT='OMNIWEB';
			} else if (preg_match('/MOZILLA\/([0-9].[0-9]{1,2})/', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
				$USER_BROWSER_AGENT='MOZILLA';
			} else if (preg_match('/KONQUEROR\/([0-9].[0-9]{1,2})/', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version)) {
		    	$USER_BROWSER_AGENT='KONQUEROR';
			} else {
		    	$USER_BROWSER_AGENT='OTHER';
			}

	$mime_type = ($USER_BROWSER_AGENT == 'IE' || $USER_BROWSER_AGENT == 'OPERA')
				? 'application/octetstream'
				: 'application/octet-stream';
	return $mime_type;
}

function bft_redirect($url) {
	echo "<meta http-equiv='refresh' content='0;url=$url' />"; 
	exit;
}

// enqueue the localized and themed datepicker
// localization NYI, we'll stick to default CSS and locale for now
function bft_enqueue_datepicker() {
	$locale_url = get_option('bft_locale_url');	
	wp_enqueue_script('jquery-ui-datepicker');	
	if(!empty($locale_url)) {
		// extract the locale
		$parts = explode("datepicker-", $locale_url);
		$sparts = explode(".js", $parts[1]);
		$locale = $sparts[0];
		wp_enqueue_script('jquery-ui-i18n-'.$locale, $locale_url, array('jquery-ui-datepicker'));
	}
	$css_url = get_option('bft_datepicker_css');
	if(empty($css_url)) $css_url = BFT_URL.'css/jquery-ui.css';
	wp_enqueue_style('jquery-style', $css_url);
}

/*
 * Matches each symbol of PHP date format standard
 * with jQuery equivalent codeword
 * @author Tristan Jahier
 * thanks to http://tristan-jahier.fr/blog/2013/08/convertir-un-format-de-date-php-en-format-de-date-jqueryui-datepicker
 */
if(!function_exists('dateformat_PHP_to_jQueryUI')) { 
	function dateformat_PHP_to_jQueryUI($php_format) {
	    $SYMBOLS_MATCHING = array(
	        // Day
	        'd' => 'dd',
	        'D' => 'D',
	        'j' => 'd',
	        'l' => 'DD',
	        'N' => '',
	        'S' => '',
	        'w' => '',
	        'z' => 'o',
	        // Week
	        'W' => '',
	        // Month
	        'F' => 'MM',
	        'm' => 'mm',
	        'M' => 'M',
	        'n' => 'm',
	        't' => '',
	        // Year
	        'L' => '',
	        'o' => '',
	        'Y' => 'yy',
	        'y' => 'y',
	        // Time
	        'a' => '',
	        'A' => '',
	        'B' => '',
	        'g' => '',
	        'G' => '',
	        'h' => '',
	        'H' => '',
	        'i' => '',
	        's' => '',
	        'u' => ''
	    );
	    $jqueryui_format = "";
	    $escaping = false;
	    for($i = 0; $i < strlen($php_format); $i++)
	    {
	        $char = $php_format[$i];
	        if($char === '\\') // PHP date format escaping character
	        {
	            $i++;
	            if($escaping) $jqueryui_format .= $php_format[$i];
	            else $jqueryui_format .= '\'' . $php_format[$i];
	            $escaping = true;
	        }
	        else
	        {
	            if($escaping) { $jqueryui_format .= "'"; $escaping = false; }
	            if(isset($SYMBOLS_MATCHING[$char]))
	                $jqueryui_format .= $SYMBOLS_MATCHING[$char];
	            else
	                $jqueryui_format .= $char;
	        }
	    }
	    return $jqueryui_format;
	}
}

// makes sure all values in array are ints. Typically used to sanitize POST data from multiple checkboxes
function bft_int_array($value) {
   if(empty($value) or !is_array($value)) return array();
   $value = array_filter($value, 'is_numeric');
   return $value;
}

// this will strip tags for users who don't have the "unfiltered_html" capability
// we will keep safe tags so even they can use some formatting
function bft_strip_tags($content) {
	// when emojis are entered from mobile phone they can make the $wpdb query silently fail. So encode them all.
	$content = wp_encode_emoji($content);	
	
   if(is_user_logged_in() and current_user_can('unfiltered_html')) return $content;
   
   return strip_tags($content, '<p><b><i><u><em><div><span><br><font><img><ul><ol><li>');
}

// output responsive table CSS in admin pages (and not only)
function bft_resp_table_css($screen_width = 600) {
	?>
/* Credits:
 This bit of code: Exis | exisweb.net/responsive-tables-in-wordpress
 Original idea: Dudley Storey | codepen.io/dudleystorey/pen/Geprd */
  
@media screen and (max-width: <?php echo $screen_width?>px) {
    table.bft-table {width:100%;}
    table.bft-table thead {display: none;}
    table.bft-table tr:nth-of-type(2n) {background-color: inherit;}
    table.bft-table tr td:first-child {background: #f0f0f0; font-weight:bold;font-size:1.3em;}
    table.bft-table tbody td {display: block;  text-align:center;}
    table.bft-table tbody td:before { 
        content: attr(data-th); 
        display: block;
        text-align:center;  
    }
}
	<?php
} // end bft_resp_table_css()

function bft_resp_table_js() {
	?>
/* Credits:
This bit of code: Exis | exisweb.net/responsive-tables-in-wordpress
Original idea: Dudley Storey | codepen.io/dudleystorey/pen/Geprd */
  
var headertext = [];
var headers = document.querySelectorAll("thead");
var tablebody = document.querySelectorAll("tbody");

for (var i = 0; i < headers.length; i++) {
	headertext[i]=[];
	for (var j = 0, headrow; headrow = headers[i].rows[0].cells[j]; j++) {
	  var current = headrow;
	  headertext[i].push(current.textContent);
	  }
} 

for (var h = 0, tbody; tbody = tablebody[h]; h++) {
	for (var i = 0, row; row = tbody.rows[i]; i++) {
	  for (var j = 0, col; col = row.cells[j]; j++) {
	    col.setAttribute("data-th", headertext[h][j]);
	  } 
	}
}
<?php
} // end bft_resp_table_js


// generates reCaptcha. For easier transfer to Pro we'll use the same meta field names for the captcha values
function arigato_recaptcha() {
	   $recaptcha_html = '';
	   
	   $require_recaptcha = get_option('arigato_recaptcha');
		$recaptcha_public = get_option('bftpro_recaptcha_public');
		$recaptcha_private = get_option('bftpro_recaptcha_private');
		$recaptcha_version = get_option('bftpro_recaptcha_version');
		$recaptcha_lang = get_option('bftpro_recaptcha_lang');
		$recaptcha_size = get_option('bftpro_recaptcha_size');
		if(empty($recaptcha_size)) $recaptcha_size = 'normal';
		$recaptcha2 = $recaptcha3 = false;		
			
		if($recaptcha_public and $recaptcha_private and $require_recaptcha) {			
			if(!empty($recaptcha_version) and $recaptcha_version == 2) {
				// recaptcha v 2
				wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?hl=' . $recaptcha_lang);
				$recaptcha_html = '<div class="g-recaptcha" data-sitekey="'.$recaptcha_public.'" data-size="'.$recaptcha_size.'"></div>';
				$recaptcha2 = $recaptcha_lang;
			}	
			
			if(!empty($recaptcha_version) and $recaptcha_version == 3) {
				// recaptcha v 2
				wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . $recaptcha_public);
					$recaptcha_html = "
					<input type='hidden' name='g-recaptcha-response' id='gRecaptchaResponseArigato'>
					<script>
					jQuery(function(){
						grecaptcha.ready(function() {
						    grecaptcha.execute('".$recaptcha_public."', {action: 'register'}).then(function(token) {
						       // fill the hidden field with the token
						       jQuery('#gRecaptchaResponseArigato').val(token);
						    });
						});
					}); // jQuery Wrapper	
						</script>";
					$recaptcha3 = $recaptcha_public;
			}				
		}
		
		return array($recaptcha_html, $recaptcha2, $recaptcha3);
}