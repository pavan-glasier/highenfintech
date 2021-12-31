<style type="text/css">
<?php bft_resp_table_css(600);?>
</style>
<div class="wrap">
    <div class="arigato">
        <section>
            <h2><?php _e('Send Instant Newsletter', 'broadfast')?></h2>

	        <?php if(!empty($_SESSION['bft_flash'])):?>
                <p><b><?php echo $_SESSION['bft_flash'];
				        unset($_SESSION['bft_flash']);?></b></p>
	        <?php endif;?>

            <div class="postbox">
                <form  method="post" action="#" onsubmit="return BFTValidateNewsletter(this);">
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e('Newsletter Subject:', 'broadfast')?></label>
                        <input type="text" name="subject" class="arigato-admin-col-9" value="<?php echo htmlentities(stripslashes(@$nl->subject))?>">
                    </div>

                    <div class="arigato-admin-form-group-column">
                        <label class="arigato-admin-col"><?php _e('Newsletter contents:', 'broadfast')?></label>
                        <?php echo wp_editor(stripslashes(@$nl->message), 'bft_message', array('textarea_name'=>'message'))?>
                    </div>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e("Email type:", 'broadfast')?></label>
                        <select name="content_type">
                            <option value="text/html"><?php _e("HTML", 'broadfast');?></option>
                            <option value="text/plain"><?php _e("Text", 'broadfast');?></option>
                        </select>
                    </div>

                    <p class="arigato-notice arigato-notice-warning"><b><?php _e("Important!", 'broadfast')?></b> <?php _e('This newsletter will be sent scheduled for sending to all your confirmed subscribers by the cron job which sends also the auto responder emails. Newsletters have lower priority than autoresponder emails so they will be sent after all autoresponder emails for the day are sent.', 'broadfast')?></p>

                    <p class="arigato-notice arigato-notice-success"><?php _e('Our <a href="http://calendarscripts.info/bft-pro/" target="_blank">PRO Version</a> offers much better flexibility over the number of emails you send at once and per day, detailed reports, multiple mailing lists. You can also see and reuse old newsletters, customize them with dynamic tags, see reports and a lot more', 'broadfast')?></p>

                    <div><p><input type="submit" value="<?php _e('Send Newsletter', 'broadfast')?>" class="button-primary"></p></div>
                    <input type="hidden" name="ok" value="1">
		            <?php wp_nonce_field('bft_newsletter');?>
                </form>
            </div>


	        <?php if(count($newsletters)):?>
                <h2><?php _e('Previous newsletters', 'broadfast')?></h2>
                
                <p><?php printf(__('You can publish the newsletters archive on the front-end using this shortcode: %s', 'broadfast'), '<input type="text" readonly="readonly" onclick="this.select()" value="[bft-newsletter-archive per_page=10]" size="25">');?></p>

		        <?php if(!empty($_GET['id'])):?>
                    <p><a href="admin.php?page=bft_newsletter"><?php _e('Create a new newsletter', 'broadfast')?></a></p>
		        <?php endif;?>
                <table class="widefat bft-table">
                    <thead>
                    <tr><th><?php _e('Subject', 'broadfast')?></th><th><?php _e('Sent on', 'broadfast')?></th>
                        <th><?php _e('Receivers', 'broadfast')?></th><th><?php _e('Edit/Delete', 'broadfast')?></th></tr>
                    </thead>
                    <tbody>
			        <?php foreach($newsletters as $newsletter):
				        $class = ('alternate' == @$class) ? '' : 'alternate';?>
                        <tr class="<?php echo $class?>"><td><?php echo stripslashes($newsletter->subject);?></td>
                            <td><?php echo date($dateformat, strtotime($newsletter->date))?></td>
                            <td><?php if($newsletter->status == 'in progress'): printf(__('In progress. Sent %d of %d', 'broadfast'), ($newsletter->num_sent + $newsletter->num_failed), $list_size);
						        else: printf(__('%d sent, %d failed', 'broadfast'), $newsletter->num_sent, $newsletter->num_failed);
						        endif;?></td>
                            <td><a href="admin.php?page=bft_newsletter&id=<?php echo $newsletter->id?>"><?php _e('Edit', 'broadfast')?></a>
                                | <a href="#" onclick="BFTDelNewsletter(<?php echo $newsletter->id?>);return false;"><?php _e('Delete', 'broadfast')?></a></td></tr>
			        <?php endforeach;?>
                    </tbody>
                </table>
	        <?php endif;?>
        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>
</div>		

<script type="text/javascript" >
function BFTValidateNewsletter(frm) {
	if(frm.subject.value == '') {
		alert("<?php _e('Please enter subject', 'broadfast');?>");
		frm.subject.focus();
		return false;
	}
	
	return true;
}

function BFTDelNewsletter(id) {
	if(confirm("<?php _e('Are you sure?', 'broadfast')?>")) {
		window.location = 'admin.php?page=bft_newsletter&del=' + id;
	}
}

<?php bft_resp_table_js();?>
</script>