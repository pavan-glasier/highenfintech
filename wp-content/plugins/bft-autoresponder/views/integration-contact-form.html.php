<div class="wrap">
    <div class="arigato">
        <section>
            <h1><?php _e('Mailing List to Contact Form Integration', 'broadfast')?></h1>
            <p><a href="admin.php?page=bft_options"><?php _e('Back to settings', 'broadfast')?></a></p>

            <p><?php printf(__('Using the shortcode below will display a checkbox for subscribing in the mailing list inside your contact form. We currently support integration with the most popular contact form plugins - <a href="%s" target="_blank">Contact Form 7</a> and JetPack.', 'broadfast'),'http://wordpress.org/plugins/contact-form-7/');?></p>

            <form method="post">
                <div class="postbox">

                    <p><input type="checkbox" name="checked_by_default" value="1" <?php if(!empty($_POST['checked_by_default'])) echo 'checked'?>> <?php _e('Checked by default', 'broadfast')?></p>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('CSS classes (optional):', 'broadfast')?></label>
                        <input type="text" name="classes" value="<?php echo esc_attr(@$_POST['classes'])?>" class="arigato-admin-col">
                    </div>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('HTML ID (optional):', 'broadfast')?></label>
                        <input type="text" name="html_id" value="<?php echo esc_attr(@$_POST['html_id'])?>" class="arigato-admin-col">
                    </div>

                    <p><input type="submit" value="<?php _e('Refresh Shortcode', 'broadfast')?>" class="button button-primary"></p>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Shortcode to use in contact form:', 'broadfast')?></label>
                        <textarea readonly="readonly" onclick="this.select()" rows="2" class="arigato-admin-col-10">[bft-int-chk<?php echo $shortcode_atts?>] <?php _e('Subscribe for the mailing list', 'broadfast')?></textarea>
                    </div>
                </div>
                <div class="postbox">
                    <h3><?php _e('Contact Form 7 Integration', 'broadfast')?></h3>
                    <p><b><?php _e('Place this shortcode inside your Contact Form 7 contact form - right where you want the checkbox to appear.', 'broadfast')?></b></p>
                    <p class="arigato-notice arigato-notice-warning"><?php _e('<b>IMPORTANT:</b> By default Contact Form 7 creates shortcodes with parameters "your-name" for the name field, and "your-email" for the email field. If you have changed this you must reflect this in the boxes below otherwise the integration will not work.', 'broadfast')?></p>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Name field name:', 'broadfast')?></label>
                        <input type="text" name="cf7_name_field" value="<?php echo $name_name?>" class="arigato-admin-col">
                    </div>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Email field name:', 'broadfast')?></label>
                        <input type="text" name="cf7_email_field" value="<?php echo $email_name?>" class="arigato-admin-col">
                    </div>

                    <p><b><?php _e('These field names are the same for all your mailing lists.', 'broadfast')?></b></p>
                    <p><input type="submit" name="change_defaults" value="<?php _e('Change field names', 'broadfast')?>" class="button button-primary"></p>
                    
                    <p class="arigato-notice arigato-notice-warning"><?php printf(__('If you are using Contact Form 7 we also recommend checking out the database management tool <a href="%s" target="_blank">Data Tensai</a>.', 'broadfast'), 'https://calendarscripts.info/data-tensai/')?></p>
                </div>
                <div class="postbox">
                    <h3><?php _e('Jetpack Contact Form Integration', 'broadfast')?></h3>
                    <p><b><?php _e('Place this shortcode inside the published shortcode of your contact form - somewhere before the closing "[/contact-form]" shortcode.', 'broadfast')?></b></p>
                </div>
            </form>

            <h3 class="arigato-notice arigato-notice-info"><?php printf(__('In the <a href="%s" target="_blank">PRO Version</a> you can also include all custom fields directly in your contact form.', 'broadfast'), 'http://calendarscripts.info/bft-pro/')?>	</h3>
        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>
</div>