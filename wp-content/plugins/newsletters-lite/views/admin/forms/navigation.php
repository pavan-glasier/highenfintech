<?php // phpcs:ignoreFile ?>

<div style="float:none;" class="subsubsub"><?php echo ( $Html -> link(__('&larr; Back to Forms', 'wp-mailinglist'), admin_url('admin.php?page=' . $this -> sections -> forms))); ?></div>

<?php
	
$method = sanitize_text_field(wp_unslash($_GET['method']));
	
?>

<div class="wp-filter">
	<ul class="filter-links">
		<li><a href="<?php echo esc_url_raw( admin_url('admin.php?page=' . $this -> sections -> forms . '&method=save&id=' . $form -> id)) ?>" data-sort="featured" <?php echo ($method == "save") ? 'class="current"' : ''; ?>><i class="fa fa-pencil"></i> Form Builder</a></li>
		<li><a href="<?php echo esc_url_raw( admin_url('admin.php?page=' . $this -> sections -> forms . '&method=settings&id=' . $form -> id)) ?>" data-sort="popular" <?php echo ($method == "settings") ? 'class="current"' : ''; ?>><i class="fa fa-cogs"></i> Settings</a></li>
		<li><a href="<?php echo esc_url_raw( admin_url('admin.php?page=' . $this -> sections -> forms . '&method=preview&id=' . $form -> id)) ?>" <?php echo ($method == "preview") ? 'class="current"' : ''; ?>><i class="fa fa-eye"></i> <?php esc_html_e('Preview', 'wp-mailinglist'); ?></a></li>
		<li><a href="<?php echo esc_url_raw( admin_url('admin.php?page=' . $this -> sections -> forms . '&method=codes&id=' . $form -> id)) ?>" <?php echo ($method == "codes") ? 'class="current"' : ''; ?>><i class="fa fa-code"></i> <?php esc_html_e('Embed/Codes', 'wp-mailinglist'); ?></a></li>
		<li><a href="<?php echo esc_url_raw( admin_url('admin.php?page=' . $this -> sections -> forms . '&method=subscriptions&id=' . $form -> id)) ?>" <?php echo ($method == "subscriptions") ? 'class="current"' : ''; ?>><i class="fa fa-users"></i> <?php esc_html_e('Subscriptions', 'wp-mailinglist'); ?></a></li>
	</ul>
	
	<div class="search-form" id="tableofcontentsdiv">
		<div class="inside">
			<?php $this -> render('forms' . DS . 'switch', false, true, 'admin'); ?>
		</div>
	</div>
</div>