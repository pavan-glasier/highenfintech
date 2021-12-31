<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class BFTIntegrations {
	// currently integrates with contact form 7
	static function contact_form() {
		global $wpdb;		
		
		$shortcode_atts = '';
		if(!empty($_POST['checked_by_default'])) {
			$shortcode_atts .= ' checked="true" ';
		}
		if(!empty($_POST['required'])) {
			$shortcode_atts .= ' required="true" ';
		}
		if(!empty($_POST['classes'])) {
			$shortcode_atts .= ' css_classes="'.sanitize_text_field($_POST['classes']).'" ';
		}
		if(!empty($_POST['html_id'])) {
			$shortcode_atts .= ' html_id="'.sanitize_text_field($_POST['html_id']).'" ';
		}
		
		// change your-name and your-email to custom field names
		if(!empty($_POST['change_defaults'])) {
			update_option('bft_cf7_name_field', sanitize_text_field($_POST['cf7_name_field']));
			update_option('bft_cf7_email_field', sanitize_text_field($_POST['cf7_email_field']));
		}
		
		// load default field names
		$custom_name_field_name = get_option('bft_cf7_name_field');
		$name_name = !empty($custom_name_field_name) ? $custom_name_field_name : 'your-name'; 
		$custom_email_field_name = get_option('bft_cf7_email_field');
		$email_name = !empty($custom_email_field_name) ? $custom_email_field_name : 'your-email';
		
		require(BFT_PATH."/views/integration-contact-form.html.php");
	}
	
	// signup user from contact form 7 or jetpack
	// $data - $_POST data
	static function signup($data, $user) {
		global $wpdb;
		
		$data = $_POST;
		if(empty($data['bft_int_signup'])) return true;
				
		bft_subscribe($user['email'], $user['name'], true, true);
	}
	
	// Ninja forms integration
	static function ninja() {
		global $wpdb;		
		
		if(!function_exists('ninja_forms_get_all_forms')) {
					wp_die(__('Ninja Forms is not activated.', 'broadfast'));
		} 

		
		if(!empty($_POST['ok']) and check_admin_referer('bft_ninja')) {
			// save integration
			$integration = array("form_id" => intval($_POST['form_id']), "fields"=>array());
			$integration['fields']['email'] = sanitize_text_field($_POST['field_email']);
			$integration['fields']['name'] = sanitize_text_field($_POST['field_name']);
			$integration['fields']['checkbox'] = sanitize_text_field($_POST['field_checkbox']);
						
			update_option('bft_ninja_integration', $integration);
		} 
		
	
		// unserialize current integration
		$integration = get_option('bft_ninja_integration');
		
		// if another form is selected by post, it overwrites the integration
		$selected_form_id = 0;
		if(!empty($integration['form_id'])) $selected_form_id = $integration['form_id'];
		if(isset($_POST['form_id'])) $selected_form_id = intval($_POST['form_id']);
		
		// select ninja forms
		$forms = ninja_forms_get_all_forms();
		//$forms = Ninja_Forms()->form()->get_forms();	
				
		// form selected? get fields
		$ninja_fields = array();		
		if($selected_form_id) {
			$ninja_fields = ninja_forms_get_fields_by_form_id( $selected_form_id );			
		}
		// print_r($ninja_fields);
		require(BFT_PATH."/views/integration-ninja-form.html.php");
	}
	
	// integrate ninja form signup
	static function ninja_signup($submission_id) {
		global  $wpdb;	
		$form_id = get_post_meta($submission_id, '_form_id', true);	
		$ninja_fields = ninja_forms_get_fields_by_form_id( $form_id );	
		$post_fields = json_decode(stripslashes($_POST['formData']));	
		$post_fields = $post_fields->fields;
	
		if( !is_array( $ninja_fields ) ) return false;
		
		//  is it integrated?
		$integration = get_option('bft_ninja_integration');
		if(empty($integration['form_id']) or $integration['form_id'] != $form_id) return false;
		
		// is checkbox required?
		if(!empty($integration['fields']['checkbox'])) {
			$integrate = false;
			foreach($ninja_fields as $field) {
				if($field['id'] == $integration['fields']['checkbox']) {													 
					 foreach($post_fields as $post_field) {					 	
						 if($post_field->id == $field['id'] and !empty($post_field->value))	$integrate = true;
					 }					 
				}
			}
			if(!$integrate) return false;			
		}

		$email = $name = '';
		foreach($integration['fields'] as $key => $field_id) {
			// fill email
			if($key == 'email') {
				foreach($ninja_fields as $field) {
					if($field['id'] == $field_id) {						
						foreach($post_fields as $post_field) {					 	
						 	if($post_field->id == $field['id'] and !empty($post_field->value))	$email = $post_field->value;
					 	}
					} // end if field found
				} // end foreach ninja field
			} // end email
			
			// fill name
			if($key == 'name') {
				foreach($ninja_fields as $field) {
					if($field['id'] == $field_id) {					
						foreach($post_fields as $post_field) {					 	
						 	if($post_field->id == $field['id'] and !empty($post_field->value))	$name = $post_field->value;
					 	}
					} // end if field found
				} // end foreach ninja field
			}
			
			// skip name, email and checkbox at this point
			if($key == 'name' or $key == 'email' or $key == 'checkbox') continue;			
		}
		
		// subscribe
		if(empty($email)) return false;
		update_option('in_ninja_form', 6);
		
		bft_subscribe($email, $name, true, true);
	} // end ninja_signup
	
	// Formidable forms integration
	static function formidable() {
		global $wpdb;		
		
		if(!class_exists('FrmField')) {
			wp_die(__('Formidable Forms is not activated.', 'broadfast'));
		} 

		
		if(!empty($_POST['ok']) and check_admin_referer('bft_formidable')) {
			// save integration
			$integration = array("form_id" => intval($_POST['form_id']), "fields" => [] );
			$integration['fields']['email'] = sanitize_text_field($_POST['field_email']);
			$integration['fields']['name'] = sanitize_text_field($_POST['field_name']);
			$integration['fields']['checkbox'] = sanitize_text_field($_POST['field_checkbox']);
						
			update_option('bft_formidable_integration', $integration);
		} 
		
	
		// unserialize current integration
		$integration = get_option('bft_formidable_integration');
		
		// if another form is selected by post, it overwrites the integration
		$selected_form_id = 0;
		if(!empty($integration['form_id'])) $selected_form_id = $integration['form_id'];
		if(isset($_POST['form_id'])) $selected_form_id = intval($_POST['form_id']);
		
		// select formidable forms
		$forms = $wpdb->get_results("SELECT id, form_key, name FROM {$wpdb->prefix}frm_forms ORDER BY name");
		$forms = wp_unslash($forms);
		
		// form selected? get fields
		$formidable_fields = [];		
		if($selected_form_id) {
			$formidable_fields = FrmField :: get_all_for_form($selected_form_id);			
		}
		
		require(BFT_PATH."/views/integration-formidable-form.html.php");
	} // end formidable settings
	
	// actually handle the formidable signup
	static function signup_formidable($entry_id, $form_id) {
		global  $wpdb;	
		
		$formidable_fields = FrmField :: get_all_for_form($form_id);
		
		if(empty($formidable_fields) or !is_array($formidable_fields)) return false;
		
		$fids = [];
		foreach($formidable_fields as $field) $fids[] = $field->id;		

		//  is it integrated?
		$integration = get_option('bft_formidable_integration');
		if(empty($integration['form_id']) or $integration['form_id'] != $form_id) return false;
			
		// is checkbox required?
		if(!empty($integration['fields']['checkbox'])) {
			$integrate = false;
			foreach($formidable_fields as $field) {
				if($field->id == $integration['fields']['checkbox'] and !empty($_POST['item_meta'][$field->id])) $integrate = true;
			}
			if(!$integrate) return false;			
		} // end checkbox check
			
			
		$email = $name = '';	
			
		foreach($integration['fields'] as $key => $field_id) {
			
			if($key == 'email') {
				foreach($formidable_fields as $field) {
					if($field->id == $field_id) {						
						if(!empty($_POST['item_meta'][$field->id])) {
							$email = sanitize_email($_POST['item_meta'][$field->id]);
						}
						break;						 	
					} // end if field found
				} // end foreach ninja field
			} // end email
			
			if($key == 'name') {
				foreach($formidable_fields as $field) {
					if($field->id == $field_id) {						
						
						if(!empty($_POST['item_meta'][$field->id])) {							
							$name = sanitize_text_field(implode(' ',$_POST['item_meta'][$field->id]));
						}
						break;						 	
					} // end if field found
				} // end foreach ninja field
			} // end name
		} // end foreach integration field
		
		// subscribe
		if(empty($email)) return false;
		
		bft_subscribe($email, $name, true, true);		
	} // end signup_formidable()
} 