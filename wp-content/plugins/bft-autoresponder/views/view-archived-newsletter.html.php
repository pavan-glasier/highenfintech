<h2><?php echo stripslashes($newsletter->subject);?></h2>

<p><a href="<?php echo add_query_arg(['offset'=> $offset], $current_url);?>"><?php _e('Back to the newsletter archive', 'broadfast');?></a></p>

<p><i><?php printf(__('Date: %s', 'broadfast'), date_i18n($date_format, strtotime($newsletter->date)));?></i></p>

<?php echo apply_filters('the_content', stripslashes($newsletter->message));?>