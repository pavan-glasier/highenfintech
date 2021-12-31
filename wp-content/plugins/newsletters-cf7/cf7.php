<?php

/*
Plugin Name: Newsletters - Contact Form 7 Subscribers
Plugin URI: http://tribulant.com/extensions/view/28/contact-form-7-subscribers
Description: Capture newsletter subscribers into the <a href="http://tribulant.com/plugins/view/1/wordpress-newsletter-plugin">Newsletter plugin</a> from your Contact Form 7 plugin forms.
Author: Tribulant Software
Version: 1.5
Author URI: http://tribulant.com
Text Domain: newsletters-cf7
Domain Path: /languages
*/
 
if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); } 
if (!defined('NEWSLETTERS_EXTENSION_URL')) { define('NEWSLETTERS_EXTENSION_URL', "http://tribulant.com/extensions/"); }

if (!class_exists('wpmlcf7')) {
	$path = dirname(dirname(__FILE__)) . DS . 'wp-mailinglist' . DS . 'wp-mailinglist.php';
	$path2 = dirname(dirname(__FILE__)) . DS . 'newsletters-lite' . DS . 'wp-mailinglist.php';
	
	if (file_exists($path)) {
		require_once($path);
	} elseif (file_exists($path2)) {
		require_once($path2);
	} elseif (defined('NEWSLETTERS_NAME')) {
		$path = dirname(dirname(__FILE__)) . DS . NEWSLETTERS_NAME . DS . 'wp-mailinglist.php';
		if (file_exists($path)) {
			require_once($path);
		}
	}

	if (class_exists('wpMailPlugin')) {
		class wpmlcf7 extends wpMailPlugin {
			
			var $version = '1.5';
					
			function __construct() {
				$this -> sections = (object) $this -> sections;
				$this -> extension_name = basename(dirname(__FILE__));
				$this -> extension_base = dirname(__FILE__);
				$this -> extension_path = plugin_basename(__FILE__);
				
				$path1 = dirname(dirname(__FILE__)) . DS . 'wp-mailinglist' . DS . 'wp-mailinglist.php';
				$path2 = dirname(dirname(__FILE__)) . DS . 'newsletters-lite' . DS . 'wp-mailinglist.php';
				
				if (file_exists($path1)) {
					$this -> parent_path = plugin_basename('wp-mailinglist' . DS . 'wp-mailinglist.php');
				} elseif (file_exists($path2)) {
					$this -> parent_path = plugin_basename('newsletters-lite' . DS . 'wp-mailinglist.php');
				} elseif (defined('NEWSLETTERS_NAME') && file_exists(dirname(dirname(__FILE__)) . DS . NEWSLETTERS_NAME . DS . 'wp-mailinglist.php')) {
					$this -> parent_path = plugin_basename(NEWSLETTERS_NAME . DS . 'wp-mailinglist.php');
				}
			}
			
			function activation_hook() {
				require_once ABSPATH . 'wp-admin' . DS . 'includes' . DS . 'admin.php';
				
				if (!is_plugin_active(plugin_basename($this -> parent_path))) {
					_e('You must have the Newsletter plugin installed and activated in order to use this.', $this -> extension_name);
					exit(); die();
				} else {
					
					$plugin_data = get_plugin_data(WP_PLUGIN_DIR . DS . $this -> parent_path);
					$plugin_version = $plugin_data['Version'];
					$required = "4.3";
					
					$versiongood = false;
					if (version_compare($plugin_version, $required) >= 0) {
						$versiongood = true;	
					}
					
					if ($versiongood == true) {
						//success
					} else {
						echo sprintf(__('The Contact Form 7 Subscribers extension requires the %sNewsletter plugin%s v%s at least.', $this -> extension_name), '<a target="_blank" href="http://tribulant.com/plugins/view/1/wordpress-newsletter-plugin">', '</a>', $required);
						exit(); die();	
					}
				}
				
				return true;			
			}
			
			function init_textdomain() {		
				if (function_exists('load_plugin_textdomain')) {			
					load_plugin_textdomain($this -> extension_name, false, $this -> extension_name . DS . 'languages' . DS);
				}	
			}
			
			function plugin_action_links($links = array()) { 
				$settings_link = '<a href="' . admin_url('admin.php?page=wpcf7') . '">' . __('Settings', $this -> extension_name) . '</a>'; 
				$links[] = $settings_link;
				return $links; 
			}
			
			function after_plugin_row($plugin_name = null) {				
		        $key = $this -> get_option('serialkey');
		        $update = $this -> vendor('update');
		        $version_info = $update -> get_version_info();
		    }
			
			function display_changelog() {
				if (!empty($_GET['plugin']) && $_GET['plugin'] == $this -> extension_name) {   		 
			    	require_once dirname(__FILE__) . DS . 'vendors' . DS . 'class.update.php';
					$update = new wpmlcf7_update();
			    	$changelog = $update -> get_changelog();
			    	$this -> render('views' . DS . 'changelog', array('changelog' => $changelog), true, false, 'cf7');
			    	
			    	exit();
			    	die();
			    }
		    }
			
			function has_update($cache = true) {
				require_once dirname(__FILE__) . DS . 'vendors' . DS . 'class.update.php';
				$update = new wpmlcf7_update();
		        $version_info = $update -> get_version_info($cache);
		        return version_compare($this -> version, $version_info["version"], '<');
		    }
			
			function check_update($option, $cache = true) {
				require_once dirname(__FILE__) . DS . 'vendors' . DS . 'class.update.php';
				$update = new wpmlcf7_update();
		        $version_info = $update -> get_version_info($cache);
		
		        if (!$version_info) { return $option; }
		        
		        if(empty($option -> response[$this -> extension_path])) {
					$option -> response[$this -> extension_path] = new stdClass();
		        }
		
		        //Empty response means that the key is invalid. Do not queue for upgrade
		        if(!$version_info["is_valid_key"] || version_compare($this -> version, $version_info["version"], '>=')){
		            unset($option -> response[$this -> extension_path]);
		        } else {
		            $option -> response[$this -> extension_path] -> url = "http://tribulant.com/extensions/view/28/contact-form-7-subscribers";
		            $option -> response[$this -> extension_path] -> slug = $this -> extension_name;
		            $option -> response[$this -> extension_path] -> package = $version_info['url'];
		            $option -> response[$this -> extension_path] -> new_version = $version_info["version"];
		            $option -> response[$this -> extension_path] -> id = "0";
		        }
		
		        return $option;
		    }
			
			function admin_init() {				
				if (function_exists('wpcf7_add_tag_generator')) {
					wpcf7_add_tag_generator('newsletters', __('Newsletters', $this -> extension_name), 'wpcf7-tg-pane-newsletters', array($this, 'wpcf7_tg_pane_newsletters'));
				}
			}
			
			function wpcf7_tg_pane_newsletters($contact_form = null, $args = null) {						
				$this -> render('views' . DS . 'pane', array('contact_form' => $contact_form), true, false, 'cf7');
			}
			
			function wpcf7_add_form_tag_newsletters() {
				if (function_exists('wpcf7_add_form_tag')) {
					wpcf7_add_form_tag(array('newsletters'), array($this, 'wpcf7_newsletters_add_form_handler'), true);
				}
			}
			
			function wpcf7_newsletters_add_form_handler($tag = null) {	
				global $Mailinglist;
					
				$tag = new WPCF7_FormTag($tag);
				$html = '';
	
				if (!empty($tag -> name)) {
					$validation_error = wpcf7_get_validation_error($tag -> name);
					$class = wpcf7_form_controls_class($tag -> type, 'wpcf7-checkbox');
					
					if ($validation_error) {
						$class .= ' wpcf7-not-valid';
					}
				
					$atts = array();
					$atts['class'] = $tag -> get_class_option($class);
					$atts['id'] = $tag -> get_option('id', 'id', true);
					$atts['tabindex'] = $tag -> get_option('tabindex', 'int', true);
					$atts['checked'] = ($tag -> get_option('autocheck', false, true) == "on") ? 'checked' : false;
				
					if (wpcf7_is_posted() && isset($_POST[$tag -> name])) {
						$value = stripslashes_deep($_POST[$tag -> name]);
					}
				
					$atts['value'] = 1;
					$atts['type'] = 'checkbox';			
					$atts['name'] = $tag -> name . '[]';
					
					$label = $tag -> values[0];
					$list = 'choice';
					
					if (!empty($tag -> options)) {
						foreach ($tag -> options as $option) {
							if (($o = @explode(":", $option)) !== false) {
								if (!empty($o[0]) && $o[0] == "list") {
									if (!empty($o[1]) && $o[1] != "choice") {
										$list = 'predefined';
										$atts['name'] = $tag -> name;
									}
								}
							}
						}
					}
				
					if (!empty($list) && $list == "predefined") {
						$atts = wpcf7_format_atts( $atts );
						$html = sprintf('<span class="wpcf7-form-control-wrap %1$s wpcf7-newsletters-wrap"><label><input %2$s /> %3$s</label>%4$s</span>', $tag -> name, $atts, $label, $validation_error);
					} else {
						ob_start();
						if ($mailinglists = $Mailinglist -> select()) {
							echo sprintf('<span class="wpcf7-form-control-wrap %1$s wpcf7-newsletters-wrap">', $tag -> name);
							echo sprintf('<p>%1$s</p>', $label);
							foreach ($mailinglists as $list_id => $list_title) {
								$atts['value'] = $list_id;	
								$newatts = wpcf7_format_atts( $atts );							
								echo sprintf('<label><input %1$s /> %2$s</label><br/>', $newatts, __($list_title));
							}
							echo sprintf('%1$s</span>', $validation_error);
						}
						$html = ob_get_clean();
					}
				}
				
				return $html;
			}
			
			function wpcf7_mail_sent($object = null) {
				global $wpdb, $Db, $Field, $Subscriber, $fromwpml;
				
				$tags = wpcf7_scan_form_tags();
			
				if (!empty($tags)) {
					$data = array();
					$dosubscribe = false;
				
					foreach ($tags as $tag) {				
						if ($tag['basetype'] == "newsletters") {
							$tag = new WPCF7_FormTag($tag);
						
							if (!empty($tag -> name)) {							
								$submission = WPCF7_Submission::get_instance();
								$posted_data = $submission -> get_posted_data();
							
								if (!empty($posted_data[$tag -> name]) && (!empty($posted_data[$tag -> name]) || is_array($posted_data[$tag -> name]))) {							
									$dosubscribe = true;
								
									if (!empty($tag -> options)) {								
										foreach ($tag -> options as $option) {
											if (($o = @explode(":", $option)) !== false) {											
												switch ($o[0]) {
													case 'list'			:
														if (!empty($o[1])) {
															if ($o[1] != "choice") {
																//the mailing lists
																$mailinglists = @explode("|", $o[1]);
																
																if (empty($data['list_id'])) {
																	$data['list_id'] = $mailinglists;
																	$data['mailinglists'] = $mailinglists;
																} else {
																	$newlists = array_unique(array_merge($data['list_id'], $mailinglists));
																	$data['list_id'] = $newlists;
																	$data['mailinglists'] = $newlists;
																}
															} else {
																$data['list_id'] = $data['mailinglists'] = $posted_data[$tag -> name];
															}
														}
														break;
													case 'autocheck'	:
														//do nothing
														break;
													default				:
														//must be a custom field?
														$Db -> model = $Field -> model;
														if ($field = $Db -> find(array('slug' => $o[0]))) {
															switch ($field -> type) {
																case 'radio'				:
																	$data[$o[0]] = $posted_data[$o[1]][0];
																	break;
																default						:
																	$data[$o[0]] = $posted_data[$o[1]];	
																	break;
															}
														}
														break;
												}
											}										
										}
									}
								}
							}
						}
					}
					
					if (!empty($data) && $dosubscribe) {
						if (!$Subscriber -> optin($data, false, false, true)) {
							//something went wrong...
							$this -> log_error(sprintf(__('Newsletters - Contact Form 7 Subscribers: %s', $this -> extension_name), implode("; ", $Subscriber -> errors)));
						}
					}
				}
				
				$fromwpml = false;
			}
			
			function wpcf7_newsletters_validation_filter($result, $tag) {
				$tag = new WPCF7_FormTag($tag);
				return $result;
			}
			
			function extensions_list($extensions = array()) {
				$extensions['cf7'] = array(
					'name'			=>	__('Contact Form 7 Subscribers', $this -> extension_name),
					'link'			=>	"http://tribulant.com/extensions/view/28/contact-form7-subscribers",
					'image'			=>	plugins_url() . '/' . $this -> extension_name . '/images/icon.png',
					'description'	=>	__("Capture newsletter subscribers into the Newsletter plugin from your Contact Form 7 plugin forms.", $this -> extension_name),
					'slug'			=>	'cf7',
					'plugin_name'	=>	$this -> extension_name,
					'plugin_file'	=>	'cf7.php',
					'settings'		=>	admin_url('admin.php?page=wpcf7'),
				);
				
				$titles = array();
				foreach ($extensions as $extension) {
					$titles[] = $extension['name'];
				}
				
				array_multisort($titles, SORT_ASC, $extensions);
				return $extensions;
			}
			
			function wpcf7_posted_data($posted_data = null) {
				
				if ($tags = wpcf7_scan_form_tags()) {
					foreach ($tags as $tag) {
						if (!empty($tag['basetype']) && $tag['basetype'] == "newsletters") {
							if (!empty($posted_data[$tag['name']])) {
								//$posted_data[$tag['name']] = __('Yes', $this -> extension_name);
							}
						}
					}
				}
				
				
				return $posted_data;
			}
		}
	
		$wpmlcf7 = new wpmlcf7();
		register_activation_hook(__FILE__, array($wpmlcf7, 'activation_hook'));
		add_action('admin_init', array($wpmlcf7, 'admin_init'), 35, 1);
		add_action('init', array($wpmlcf7, 'init_textdomain'), 10, 1);
		add_action('init', array($wpmlcf7, 'wpcf7_add_form_tag_newsletters'), 10, 1);
		add_action('wpcf7_before_send_mail', array($wpmlcf7, 'wpcf7_mail_sent'), 10, 1);
		add_filter('wpcf7_posted_data', array($wpmlcf7, 'wpcf7_posted_data'), 10, 1);
		add_filter('wpcf7_validate_newsletters', array($wpmlcf7, 'wpcf7_newsletters_validation_filter'), 10, 2);
		add_filter('wpml_extensions_list', array($wpmlcf7, 'extensions_list'), 10, 1);
		add_action('after_plugin_row_' . $wpmlcf7 -> extension_path, array($wpmlcf7, 'after_plugin_row'), 10, 2);
		add_filter('plugin_action_links_' . $wpmlcf7 -> extension_path, array($wpmlcf7, 'plugin_action_links'));
		add_action('install_plugins_pre_plugin-information', array($wpmlcf7, 'display_changelog'), 10, 1);
		add_filter('transient_update_plugins', array($wpmlcf7, 'check_update'), 10, 1);
		add_filter('site_transient_update_plugins', array($wpmlcf7, 'check_update'), 10, 1);	
	}
}

?>