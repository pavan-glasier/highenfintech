<?php // phpcs:ignoreFile ?>

<div id="newsletters_forms_field_<?php echo esc_html( $field -> id); ?>" class="postbox ">
	<button value="1" type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">Toggle panel: First</span><span class="toggle-indicator" aria-hidden="true"></span></button>
	<div class="newsletters_delete_handle"><a href="" onclick="if (confirm('<?php esc_html_e('Are you sure you want to delete this field?', 'wp-mailinglist'); ?>')) { newsletters_forms_field_delete('<?php echo esc_html( $field -> id); ?>'); } return false;"><i class="fa fa-times fa-fw"></i></a></div>
	<div class="newsletters_edit_handle"><a href="" onclick="jQuery(this).closest('div.postbox').toggleClass('closed'); return false;"><i class="fa fa-pencil fa-fw"></i></a></div>
	<h2 class="hndle ui-sortable-handle" onclick="jQuery(this).parent().toggleClass('closed');"><i class="fa fa-bars fa-fw"></i> <span><?php echo esc_html($field -> title) . ' <span class="newsletters_handle_more">' . $Html -> field_type($field -> type, $field -> slug) . '</span>' . ((!empty($field -> required) && $field -> required == "Y") ? ' <span class="newsletters_error"><i class="fa fa-asterisk fa-sm"></i></span>' : ''); ?></span></h2>
	
	<div class="inside">	
		<?php echo wp_kses_post( wp_unslash($content)) ?>
	</div>
</div>