<?php

/**
 * Plugin Name:       CF7 api sender
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            PV
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


//add_action( 'wpcf7_mail_sent', 'techiepress_cf7_api_sender', 10, 1 );

// function techiepress_cf7_api_sender(){

// }

// function action_wpcf7_mail_sent( $contact_form ) { 
//     // you can limit this script to certains forms, just change the IDs (111,222,333) and uncomment line 10 and 47

//     $title = $contact_form->title;
//     echo $title;
//      // if (in_array($WPCF7_ContactForm->id(), [111,222,333])) {
//       if ( $title === 'New Form') {
//         // $wpcf7      = WPCF7_ContactForm::get_current();
//         $submission = WPCF7_Submission::get_instance();
//         if ( $submission ) {
//             $posted_data = $submission->get_posted_data();
            
//             $name = $posted_data['your-name'];
//             $email = $posted_data['your-email'];
//             $subject = $posted_data['your-subject'];
//             $message = $posted_data['your-message'];

//             // var_dump($name);
//             // var_dump($email);
//             // var_dump($subject);
//             // var_dump($message);

//             // wp_die;

//             $url = 'https://hook.integromat.com/f2e1xtxoqo6l7m4ikcn6i64naskvmda2';
//             $args = array(
//                 'body' => array(
//                     'name' => $name,
//                     'email' => $email,
//                     'subject' => $subject,
//                     'message' => $message,
//                 )
//             );

//             wp_remote_post( $url, $args );
            
//             retrun;

//         }
//      }
// }
         
// // add the action 
// add_action( 'wpcf7_mail_sent', 'action_wpcf7_mail_sent', 10, 1 );
