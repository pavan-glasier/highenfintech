<style type="text/css">
<?php bft_resp_table_css(600);?>
</style>
<div class="wrap">
    <div class="arigato">
        <section>
            <p class="arigato-notice arigato-notice-info"><b><?php _e('Note: you can use the variable {{name}} in any message to address the user by name.', 'broadfast')?></b></p>

            <div class="postbox">
                <h2><?php _e('Create New Message:', 'broadfast')?></h2>

                <form method="post" style="margin:none;" onsubmit="return validateMessage(this);" enctype="multipart/form-data">

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e('Subject:', 'broadfast')?></label>
                        <input type="text" name="subject" class="arigato-admin-col-10">
                    </div>
                    <p><label><?php _e('Message:', 'broadfast')?> </label> <?php wp_editor("", "bft_message", array('textarea_name' => 'message'))?></p>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e('Days after registration:', 'broadfast')?></label>
                        <div class="arigato-admin-col">
                            <input type="text" name="days" class="arigato-admin-col-xs">
                            <span><?php _e('or', 'broadfast')?></span>
                            <input type="checkbox" name="send_on_date" value="1" onclick="sendOnDate(this);">
	                        <?php _e('send on', 'broadfast')?>
                        </div>
                        <p class="arigato-admin-col"><?php echo BFTquickDD_date("date", NULL, "YYYY-MM-DD", NULL, date("Y"),date("Y")+10);?></p>
                    </div>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e("Email type:", 'broadfast')?></label>
                        <select name="content_type" class="arigato-admin-col">
                            <option value="text/html"><?php _e("HTML", 'broadfast');?></option>
                            <option value="text/plain"><?php _e("Text", 'broadfast');?></option>
                        </select>
                    </div>
                    <hr>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e('Upload attachments (optional):', 'broadfast')?></label>
                        <input type="file" name="attachments[]" multiple="multiple">
                    </div>
		            <?php wp_nonce_field('bft_attach_nonce','bft_attach_nonce');?>

                    <p class="arigato-notice arigato-notice-info"><?php printf(__('Note: an unsubscribe link with default text is added to your outgoing messages. You can however use the variables %s or %s with your custom text. The variable will be replaced with the unsubscribe link or URL', 'broadfast'), '{{{unsubscribe-link}}}', '{{{unsubscribe-url}}}');?> </p>

                    <p><input type="submit" value="<?php _e('Add Message', 'broadfast')?>" class="button-primary"></p>

                    <input type="hidden" name="add_message" value="1">
		            <?php wp_nonce_field('bft_message');?>
                </form>
            </div>


            <h2><?php _e('Existing Messages:', 'broadfast')?></h2>

	        <?php foreach($mails as $mail): ?>
                <form method="post" style="margin:none;" onsubmit="return validateMessage(this);" enctype="multipart/form-data">
                    <div class="postbox">
                        <div class="arigato-admin-form-group">
                            <label class="arigato-admin-col"><?php _e('Subject:', 'broadfast')?></label>
                            <input type="text" name="subject" value="<?php echo htmlentities(stripslashes($mail->subject))?>" class="arigato-admin-col-10">
                        </div>
                        <p><label><?php _e('Message:', 'broadfast')?> </label> <?php wp_editor(stripslashes($mail->message), "message".$mail->id, array("textarea_name"=>"message"))?></p>
                        <div class="arigato-admin-form-group">
                            <label><?php _e('Days after registration:', 'broadfast')?></label>
                            <div class="arigato-admin-col">
                                <input type="text" name="days" size="4" value="<?php echo $mail->days?>" <?php if($mail->send_on_date) echo "disabled"?>>
	                            <?php _e('or', 'broadfast')?>
                                <input type="checkbox" name="send_on_date" value="1" onclick="sendOnDate(this);" <?php if($mail->send_on_date) echo "checked"?>>
	                            <?php _e('send on', 'broadfast')?>
                            </div>
                            <p class="arigato-admin-col"><?php echo BFTquickDD_date("date", $mail->date, "YYYY-MM-DD", NULL, date("Y"),date("Y")+10);?></p>
                        </div>
                        <div class="arigato-admin-form-group">
                            <label class="arigato-admin-col"><?php _e("Email type:", 'broadfast')?></label>
                            <select name="content_type" class="arigato-admin-col">
                                <option value="text/html" <?php if(!empty($mail->content_type) and $mail->content_type=='text/html') echo 'selected'?>><?php _e("HTML", 'broadfast');?></option>
                                <option value="text/plain" <?php if(!empty($mail->content_type) and $mail->content_type=='text/plain') echo 'selected'?>><?php _e("Text", 'broadfast');?></option>
                            </select>
                        </div>
                        <hr>
                        <div class="arigato-admin-form-group">
                            <label class="arigato-admin-col"><?php _e('Upload attachments (optional):', 'broadfast')?></label>
                            <input type="file" name="attachments[]" multiple="multiple">
                        </div>
                        <?php wp_nonce_field('bft_attach_nonce','bft_attach_nonce');?>
                        <?php $_att->list_editable(@$mail->attachments);?>

                        <p>
                            <input type="submit" name="save_message" value="<?php _e('Save Message', 'broadfast')?>" class="button-primary">
                            <input type="button" value="<?php _e('Delete', 'broadfast')?>" onclick="delMessage(this.form);" class="button-secondary">
                        </p>

                    </div>
                    <input type="hidden" name="id" value="<?php echo $mail->id?>">
                    <input type="hidden" name="del_message" value="0">
			        <?php wp_nonce_field('bft_message');?>
                </form>
	        <?php endforeach; ?>
        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>
</div>					

<script language="javascript">
function delMessage(frm)
{
	if(confirm("<?php _e('Are you sure?', 'broadfast')?>"))
	{
		frm.del_message.value=1;
		frm.submit();
	}
}

function validateMessage(frm)
{
	if(frm.subject.value=="")
	{
		alert("<?php _e('Please enter subject', 'broadfast')?>");
		frm.subject.focus();
		return false;
	}

	if(isNaN(frm.days.value))
	{
		alert("<?php _e('Please enter number of days after registration', 'broadfast')?>");
		frm.days.focus();
		return false;
	}
	
	return true;
}

// when checked turns the days to disabled and vice versa
function sendOnDate(chk)
{
    if(chk.checked)
    {
        chk.form['days'].disabled=true;
    }
    else
    {
        chk.form['days'].disabled=false;
    }
}
<?php bft_resp_table_js();?>	
</script>