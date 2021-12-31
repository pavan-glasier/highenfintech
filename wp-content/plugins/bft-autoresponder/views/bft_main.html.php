<div class="wrap">

    <div class="arigato">
        <section>
            <div class="arigato-admin-row">
                <div class="arigato-admin-col-6 top">
                    <div class="postbox">
                        <h2><?php _e('Main Settings', 'broadfast')?></h2>
                        <form method="post">
                            <input type="hidden" name="settings_ok" value="Y">
                            <div class="arigato-admin-form-group">
                                <label class="arigato-admin-col-4"><?php _e('Sender of all emails:', 'broadfast')?></label>
                                <input type="text" name="bft_sender" value="<?php echo $bft_sender?>" class="arigato-admin-col-7">
                            </div>
                            <p class="arigato-notice arigato-notice-info"><?php _e('Fill valid email address or name/email like this:</br> <b>Name, email@domain.com</b></span>', 'broadfast')?></p>

                            <div class="arigato-admin-form-group">
                                <label class="arigato-admin-col-4"><?php _e('BCC all outgoing emails to this address:', 'broadfast');?></label>
                                <input type="text" name="bcc" value="<?php echo get_option('bft_bcc');?>" class="arigato-admin-col-7">
                            </div>
	                        <p class="arigato-notice arigato-notice-info"><?php _e('Leave blank for no BCC', 'broadfast');?></p>

                            <div class="arigato-admin-form-group-column">
                                <label><?php _e('URL to redirect to after registration (optional):', 'broadfast')?></label>
                                <input type="text" name="bft_redirect" value="<?php echo $bft_redirect?>" class="arigato-admin-col-12">
                            </div>
                            <div class="arigato-admin-form-group">
                                <label><?php _e('Double opt-in:', 'broadfast')?></label>
                                <select name="bft_optin" onchange="if(this.value == '1') { jQuery('#bftOptinConfig').show();} else {jQuery('#bftOptinConfig').hide();}">
                                    <option value="0" <?php if(empty($bft_optin)) echo "selected";?>><?php _e('No', 'broadfast')?></option>
                                    <option value="1" <?php if($bft_optin) echo "selected";?>><?php _e('Yes', 'broadfast')?></option>
                                </select>
                            </div>

                            <p><input type="checkbox" name="subscribe_notify" value="1" <?php if($subscribe_notify) echo 'checked'?> onclick="this.checked ? jQuery('#subscribeNotify').show() : jQuery('#subscribeNotify').hide();"> <?php _e('Notify me when someone subscribes/activates', 'broadfast')?></p>
                            <div id="subscribeNotify" style='display:<?php echo $subscribe_notify ? 'block' : 'none';?>'>
                                [<a href="admin.php?page=bft_messages_config&msg=subscribe_notify" target="_blank"><?php _e('Configure this message', 'broadfast')?></a>]
                            </div>

                            <p><input type="checkbox" name="unsubscribe_notify" value="1" <?php if($unsubscribe_notify) echo 'checked'?>  onclick="this.checked ? jQuery('#unsubscribeNotify').show() : jQuery('#unsubscribeNotify').hide();"> <?php _e('Notify me when someone unsubscribes', 'broadfast')?></p>
                            <div id="unsubscribeNotify" style='display:<?php echo $unsubscribe_notify ? 'block' : 'none';?>'>
                                [<a href="admin.php?page=bft_messages_config&msg=unsubscribe_notify" target="_blank"><?php _e('Configure this message', 'broadfast')?></a>]
                            </div>

                            <p><input type="checkbox" name="auto_subscribe" <?php if(get_option('bft_auto_subscribe') == 1) echo 'checked'?> value="1"> <?php _e('Automatically subscribe to the mailing list all new users who register in my blog. (To avoid spam this will happen when users login for the first time)', 'broadfast')?></p>
                            
                            <p><input type="checkbox" name="subscribe_to_blog" <?php if($subscribe_to_blog == 1) echo 'checked'?> value="1" onclick="this.checked ? jQuery('#subToBlogOptions').show() : jQuery('#subToBlogOptions').hide();"> <?php _e('When user subscribes to this mailing list register them as subscriber for my site too. (Happens when the subscription is activated.)', 'broadfast')?>
									<span id="subToBlogOptions" style='display:<?php echo empty($subscribe_to_blog) ? 'none' : 'inline';?>;'>
										<input type="checkbox" name="subscribe_auto_login" value="1" <?php if(!empty($subscribe_auto_login)) echo 'checked';?>> <?php _e('Immediately log them into the site.','broadfast');?>
									</span>	                            
                            </p>

                            <fieldset>
                                <legend>Cron Job</legend>

                                <p><input type="radio" name="use_cron_job" value="0" <?php if($use_cron_job != 1) echo 'checked'?> onclick="this.checked ? jQuery('#bftCronJob').hide() : jQuery('#bftCronJob').show();"> <?php _e('I will use WP cron (default behavior)', 'broadfast');?>
		                            <?php _e('Running sequence:','broadfast');?> <select name="cron_schedule">
                                        <option value="hourly" <?php if(empty($cron_schedule) or $cron_schedule == 'hourly') echo 'selected'?>><?php _e('Hourly', 'broadfast');?></option>
                                        <option value="daily" <?php if($cron_schedule == 'daily') echo 'selected'?>><?php _e('Daily', 'broadfast');?></option>
                                        <option value="daily" <?php if($cron_schedule == 'twicedaily') echo 'selected'?>><?php _e('Twice daily', 'broadfast');?></option>
                                    </select>
                                </p>

                                <p><input type="radio" name="use_cron_job" value="1" <?php if($use_cron_job == 1) echo 'checked'?> onclick="this.checked ? jQuery('#bftCronJob').show() : jQuery('#bftCronJob').hide();"> <?php _e('I will set up a cron job to send my autoresponder emails.', 'broadfast')?>
                                    <span style="font-weight:bold;"><b><i><?php _e('Use this if the default option does not work well', 'broadfast');?></i></b></span><br>
		                            <?php _e("(If you don't select this option the email sending will be done when someone (or a bot) visits your site for the day.)", 'broadfast')?></p>

                                <div id="bftCronJob" style='display:<?php echo ($use_cron_job == 1) ? 'block': 'none';?>'>

		                            <p class="arigato-notice arigato-notice-info"><?php _e('Cron jobs are scheduled tasks that run on your server. This is the preferred setting but you will need to set up a cron job through your web host control panel. To handle this I recommend to set up a cron job on your server. It needs to run at least once per day (preferably every hour or so), at a time chosen by you. Here is a <a href="http://calendarscripts.info/cron-jobs-tutorial.html" target="_blank">quick and easy guide</a> how to do it.', 'broadfast')?></p>
                                    <h3><?php _e('The exact command you need to set is:', 'broadfast');?></h3>
                                    <p><input type="text" class="arigato-admin-col-12" value="curl <?php echo site_url("?bft_cron=1");?>" readonly="readonly" onclick="this.select()"></p>
                                    <p><?php _e('In case the above does not work on your host please try:', 'broadfast')?></p>
                                    <p><input type="text" class="arigato-admin-col-12" value="wget <?php echo site_url("?bft_cron=1");?>" readonly="readonly" onclick="this.select()"></p>
                                    <p><?php _e('If your server does not support cron jobs you can use external service to hit the following URL:', 'broadfast')?></p>
                                    <p><input type="text" class="arigato-admin-col-12" value="<?php echo site_url("?bft_cron=1");?>" readonly="readonly" onclick="this.select()"></p>
                                    <p><?php printf(__('You can also run the cron job manually by visiting <a href="%s" target="_blank">the link</a> in your browser. If there are no errors you will see just a blank page with text "Running in cron job mode".', 'broadfast'), site_url("?bft_cron=1"))?></p>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="arigato-admin-form-group">
                                    <label class="arigato-admin-col"><?php _e('Send up to', 'broadfast')?></label>
                                    <input type="text" name="mails_per_run" value="<?php echo get_option('bft_mails_per_run');?>" class="arigato-admin-col-xs">
                                    <span class="arigato-admin-col"><?php _e('mails at once.', 'broadfast');?></span>
                                </div>
                                <p class="arigato-help"><?php _e('Leave 0 or blank for no limit. This option will be useful on shared hosts which limit the number of emails you can send per hour. Note that this limit does not relate to instant newsletters and welcome emails and they will not be considered in the total number of emails sent.', 'broadfast');?></p>

                                <div class="arigato-admin-form-group">
                                    <label class="arigato-admin-col-4"><?php _e('Artificial delay between emails:', 'broadfast');?></label>
                                    <input type="text" name="sleep" value="<?php echo get_option('bft_sleep');?>" class="arigato-admin-col-xs">
                                    <span class="arigato-admin-col-5"><?php _e('In seconds, decimals accepted. Example: 0.1', 'broadfast');?></span>
                                </div>
                                <div class="arigato-help">
                                    <p><?php _e('If you are getting bounced emails with warnings that you are sending too fast, your server may be in danger of being blacklisted. In such case try to define some artificial delay. Usually values between 0.1 and 1 second work best.', 'broadfast');?></p>
                                </div>

                                <p><input type="checkbox" name="no_signup_popup_msg" value="1" <?php if(get_option('bft_no_signup_popup_msg')==1) echo "checked"?>> <?php _e('Do not display JS popup alert when user has been subscribed.', 'broadfast');?></p>
                                <p><input type="checkbox" name="no_unsub_popup_msg" value="1" <?php if(get_option('bft_no_unsub_popup_msg')==1) echo "checked"?>> <?php _e('Do not display JS popup alert when user has been un-subscribed.', 'broadfast');?></p>
                            </fieldset>

                            <fieldset>
                                <legend><?php _e('Anti-Spam: Captcha and reCaptcha', 'broadfast');?></legend>
                                <p><input type="checkbox" name="use_text_captcha" value="1" <?php if($use_text_captcha == 1) echo 'checked';?> onclick="if(this.checked) { jQuery('#bftRawHTML').hide(); jQuery('#bftTextCaptcha').show();} else { jQuery('#bftRawHTML').show(); jQuery('#bftTextCaptcha').hide();}"> <?php _e('Use question based captcha</a> to prevent spam.', 'broadfast');?></p>

                                <div id="bftTextCaptcha" style='display:<?php echo ($use_text_captcha == 1) ? 'block' : 'none';?>'>
                                    <p class="arigato-notice arigato-notice-warning"><b><?php _e('Note that when question based captcha is enbabled, you cannot use the HTML signup code! Only the WP shortcode will work.', 'broadfast');?></b></p>

                                    <h3><?php _e('Question based captcha', 'broadfast')?></h3>

                                    <p><?php _e("This is a simple text-based captcha. We have loaded 3 basic questions but you can edit them and load your own. Make sure to enter only one question per line and use = to separate question from answer.", 'broadfast')?></p>

                                    <p><textarea name="text_captcha" rows="5" class="arigato-admin-col-12"><?php echo stripslashes($text_captcha);?></textarea></p>
                                </div>

                                <p><input type="checkbox" name="recaptcha" value="1" <?php if($recaptcha == 1) echo 'checked';?> onclick="this.checked ? jQuery('#bftreCaptcha').show() : jQuery('#bftreCaptcha').hide();"> <?php _e('Use Google reCaptcha to prevent spam.', 'broadfast');?></p>

                                <div id="bftreCaptcha" style='display:<?php echo ($recaptcha == 1) ? 'block' : 'none';?>'>
                                    <p><?php _e("You can optionally enable <a href='http://www.google.com/recaptcha' target='_blank'>ReCaptcha</a> to prevent spam bots to register to your mailing lists. You will need a ReCaptcha API key. You can <a href='http://www.google.com/recaptcha/whyrecaptcha' target='_blank'>get one here</a>. It's free.", 'broadfast')?></p>

                                    <p>
                                        <label><?php _e('Site key:', 'broadfast')?></label>
                                        <input type="text" name="recaptcha_public" value="<?php echo get_option('bftpro_recaptcha_public');?>" class="arigato-admin-col-12 arigato-admin-form-control">
                                    </p>

                                    <p>
                                        <label><?php _e('Secret key:', 'broadfast')?></label>
                                        <input type="text" name="recaptcha_private" value="<?php echo get_option('bftpro_recaptcha_private');?>" class="arigato-admin-col-12 arigato-admin-form-control">
                                    </p>

                                    <div class="arigato-admin-form-group">
                                        <label class="arigato-admin-col-3"><?php _e('reCaptcha Version:', 'broadfast');?></label>
                                        <select name="recaptcha_version" onchange="bftChangeReCaptchaVersion(this.value);" class="arigato-admin-col">
                                            <option value="2" <?php if(empty($recaptcha_version) or $recaptcha_version == 2) echo 'selected'?>><?php _e('2 (no Captcha reCaptcha)', 'broadfast');?></option>
                                            <option value="3" <?php if(!empty($recaptcha_version) and $recaptcha_version == 3) echo 'selected'?>><?php _e('3 (invisible reCaptcha)', 'broadfast');?></option>
                                        </select>
                                    </div>

                                    <div id="reCaptchanoCaptcha" style='display:<?php echo (empty($recaptcha_version) or $recaptcha_version == 2) ? 'block' : 'none'; ?>'>
                                        <div class="arigato-admin-form-group">
                                            <label class="arigato-admin-col-3"><?php _e('Size:', 'broadfast');?></label>
                                            <select name="recaptcha_size" class="arigato-admin-col">
                                                <option value="normal"><?php _e('Normal', 'broadfast');?></option>
                                                <option value="compact" <?php if(!empty($recaptcha_size) and $recaptcha_size == 'compact') echo 'selected'?>><?php _e('Compact', 'broadfast');?></option>
                                            </select>
                                        </div>
                                        <div class="arigato-admin-form-group">
                                            <label class="arigato-admin-col-3"><?php _e('Language code:', 'broadfast');?></label>
                                            <input type="text" name="recaptcha_lang" value="<?php echo $recaptcha_lang ? $recaptcha_lang : 'en'?>" class="arigato-admin-col-1">
                                            <p class="arigato-admin-col"><a href="https://developers.google.com/recaptcha/docs/language" target="_blank"><?php _e('See language codes', 'broadfast');?></a></p>
                                        </div>
                                    </div>

                                    <div id="reCaptcha3" style='display:<?php echo ($recaptcha_version == 3) ? 'block' : 'none'; ?>'>
                                        <p><?php _e('Valid response threshold score:', 'broadfast');?> <select name="recaptcha_score">
					                            <?php for($i = 1; $i <= 10; $i ++):?>
                                                    <option value="<?php echo $i/10?>" <?php if(!empty($recaptcha_score) and $recaptcha_score == $i/10) echo 'selected'?>><?php echo $i/10?></option>
					                            <?php endfor;?>
                                            </select></p>
                                        <p><?php _e('For more information check reCaptcha v3 docs. If you are unsure just leave the default of 0.5', 'broadfast');?></p>
                                    </div>

                                    <p class="arigato-notice arigato-notice-info"><?php _e('You need to create keys for your domains and for the different reCaptcha versions. If you want to test the captcha on localhost you have to create a key for "localhost".', 'broadfast');?></p>

                                </div>

                            </fieldset>

                            <div style='display:<?php echo current_user_can('manage_options') ? 'block' : 'none'?>'>
                                <fieldset>
                                    <legend><?php _e('Roles', 'broadfast') ?></legend>

                                    <div class="inside">
                                        <h4><?php _e('Roles that can manage the autoresponder', 'broadfast')?></h4>
                                        <p><?php _e('By default only Administrator and Super admin can manage the autoresponder. You can enable other roles here.', 'broadfast')?></p>
                                        <p>
                                            <?php foreach($roles as $key=>$r):
				                                if($key=='administrator') continue;
				                                $role = get_role($key);?>
                                                <span class="arigato-admin-inline">
                                                    <input type="checkbox" name="manage_roles[]" value="<?php echo $key?>" <?php if($role->has_cap('arigato_manage')) echo 'checked';?>> <?php echo $role->name?>
                                                </span>
			                                <?php endforeach;?>
                                        </p>
                                        <p><?php _e('Only administrator or superadmin can change this!', 'broadfast')?></p>
                                    </div>
                                </fieldset>
                            </div>

                            <p><input type="submit" value="<?php _e('Save Settings', 'broadfast')?>" class="button button-primary"></p>
		                    <?php wp_nonce_field('bft_settings');?>
                        </form>
                    </div>
                </div><!-- /arigato-admin-col-6 -->
                <div class="arigato-admin-col-6 top">
                    <div class="postbox">
                        <h2><?php _e('Signup Form', 'broadfast')?></h2>
                        <form method="post">
                            <p><input type="checkbox" name="require_name" value="1" <?php if($require_name == 1) echo 'checked'?>> <?php _e("Make 'name' required (email is always required)", 'broadfast')?></p>
                            <p><input type="checkbox" name="allow_get" value="1" <?php if($allow_get == 1) echo 'checked'?>> <?php _e("Allow passing pre-populated values by GET. Use URL parameters 'arigato_name' and 'arigato_email' to pass values.", 'broadfast')?>&nbsp;</p>
                            <p><input type="submit" name="update_require_name" value="<?php _e('Update', 'broadfast');?>" class="button button-primary"></p>
		                    <?php wp_nonce_field('bft_name_field');?>
                        </form>

                        <div class="arigato-admin-form-group">
                            <label><?php _e('WordPress shortcode:', 'broadfast')?></label>
                            <input type="text" value='[BFTWP button_text="<?php _e('Sign Up', 'broadfast');?>"]' onclick="this.select();" readonly="readonly" class="arigato-admin-col-5">
                            <span class="arigato-admin-col"><i><?php _e('Place it inside a post or page.', 'broadfast')?></i></span>
                        </div>

                        <div id="bftRawHTML" style='display:<?php echo ($use_text_captcha == 1) ? 'none' : 'block';?>'>
                            <p><?php _e('Or use the registration form HTML code <br>(Copy and paste in a post, page or your wordpress template):', 'broadfast')?></p>
                            <textarea rows="10" class="arigato-admin-col-12" onclick="this.select();"><?php ob_start();
			                    require(BFT_PATH."/views/signup-form.html.php");
			                    $content = ob_get_clean();
			                    echo htmlentities($content);?></textarea>
                        </div>

                        <p align="center"><a href="admin.php?page=bft_integrate_contact"><?php _e('Integrate in Contact Form', 'broadfast')?></a></p>
                        <?php if(function_exists('ninja_forms_get_all_forms')):?><p align="center"><a href="admin.php?page=bft_integrate_ninja"><?php _e('Integrate in Ninja Form', 'broadfast');?></a></p><?php endif;?>
                       <?php if(class_exists('FrmField')):?><p align="center"><a href="admin.php?page=bft_integrate_formidable"><?php _e('Integrate in Formidable Form', 'broadfast');?></a></p><?php endif;?>
                    </div>

                    <div id="bftOptinConfig" class="postbox" style='clear:both;display:<?php echo $bft_optin ? 'block': 'none';?>;'>
                        <h2><?php _e('Double Opt-in Settings', 'broadfast')?></h2>
                        <form method="post">
                            <fieldset>
                                <legend><?php _e('Double Opt-in Redirect Configuration', 'broadfast')?></legend>
                                <div class="arigato-admin-form-group-column">
                                    <label><?php _e('URL to redirect after double opt-in (optional):', 'broadfast')?></label>
                                    <input type="text" name="bft_optin_redirect" value="<?php echo $bft_optin_redirect?>" class="arigato-admin-col-12">
                                </div>
		                        <p class="arigato-help"><?php _e('(If you leave this empty, the value from  "URL to redirect to after registration" will be used)', 'broadfast')?> </p>
                                <p><input type="checkbox" name="no_double_optin_popup_msg" value="1" <?php if(get_option('bft_no_double_optin_popup_msg')==1) echo "checked"?>> <?php _e('Do not display confirmation popup alert when email is confirmed.', 'broadfast');?></p>
                            </fieldset>

                            <fieldset>
                                <legend><?php _e('Double Opt-in Email Message Configuration', 'broadfast')?></legend>
                                <p><?php _e('Feel free to leave this empty - in such case a default message will be used.', 'broadfast')?></p>

                                <div class="arigato-admin-form-group">
                                    <label class="arigato-admin-col"><?php _e('Message subject:', 'broadfast')?></label>
                                    <input type="text" name="optin_subject" value="<?php echo htmlentities(stripslashes(get_option('bft_optin_subject')))?>" class="arigato-admin-col-8">
                                </div>
                                <p><?php wp_editor(stripslashes(get_option('bft_optin_message')), 'optin_message')?></p>
                                <p><?php _e('Please use the variable {{url}} to provide the confirmation URL. If you do not provide it, it will be attached at the end of the message.', 'broadfast')?></p>
                                <p><b><?php printf(__('You can use the variable %s to address the user by name and the variables %s and %s.', 'broadfast'),'{{name}}', '{{email}}', '{{ip}}')?></b></p>
                            </fieldset>

                            <p><input type="submit" name="double_optin_ok" value="<?php _e('Save Double Opt-in Message', 'broadfast')?>" class="button-primary"></p>
	                        <?php wp_nonce_field('bft_optin');?>
                        </form>
                    </div>
                </div><!-- /arigato-admin-col-6 -->
            </div>
        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>

</div>			

<script type="text/javascript" >
function bftChangeReCaptchaVersion(val) {
	if(val == 1) {
		jQuery('#reCaptchaSSL').show();
		jQuery('#reCaptchanoCaptcha').hide();
		jQuery('#reCaptcha3').hide();
	}
	if(val == 2) {
		jQuery('#reCaptchaSSL').hide();
		jQuery('#reCaptchanoCaptcha').show();
		jQuery('#reCaptcha3').hide();
	}
	if(val == 3) {
		jQuery('#reCaptchaSSL').hide();
		jQuery('#reCaptchanoCaptcha').hide();
		jQuery('#reCaptcha3').show();
	}
}
</script>