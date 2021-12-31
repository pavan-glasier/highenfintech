<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class BFTJetPack {
	static function signup() {
		if(empty($_POST['action']) or $_POST['action'] != 'grunion-contact-form') return false;
		
		$user = array('email' => "", "name"=>"");	
		$user['email'] = !empty( $_POST['g' . @$_POST['contact-form-id'] . '-email']  ) ? trim( $_POST['g' . sanitize_text_field(@$_POST['contact-form-id']) . '-email'] ) : '';
	   $user['name'] = !empty( $_POST['g' . @$_POST['contact-form-id'] . '-name']  ) ? trim( $_POST['g' . sanitize_text_field(@$_POST['contact-form-id']) . '-name'] ) : '';		
		BFTIntegrations :: signup($_POST, $user);		
	}
}