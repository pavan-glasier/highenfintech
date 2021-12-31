<style type="text/css">
<?php bft_resp_table_css(900);?>
</style>
<div class="wrap">
    <div class="arigato">
        <section>
            <div class="">
                <h1><?php _e('Manage Your Mailing List', 'broadfast')?></h1>

		        <?php if($error):?>
                    <p class="error"><?php echo $err_msg;?></p>
		        <?php endif;?>

                <form method="post" onsubmit="return validateUser(this);">
                    <div>
                        <div class="arigato-admin-form-group arigato-mt-2">
                            <label class="arigato-admin-col"><?php _e('Email:', 'broadfast')?></label>
                            <input type="text" name="email" class="arigato-admin-col arigato-mr-1">
                            <label class="arigato-admin-col"><?php _e('Name:', 'broadfast')?></label>
                            <input type="text" name="user_name" class="arigato-admin-col">
                            <div class="arigato-admin-col">
                                <input type="checkbox" name="status" value="1" checked="checked"> <?php _e('Active', 'broadfast')?>
                            </div>
                            <input type="submit" value="<?php _e('Add User', 'broadfast')?>" class="button button-primary" class="arigato-admin-col">
                        </div>
                    </div>
                    <input type="hidden" name="add_user" value="1">
			        <?php wp_nonce_field('bft_list_user');?>
                </form>

                <p><a href="#" onclick="jQuery('#userFilters').toggle();return false;"><?php _e('Show/Hide Search Form', 'broadfast')?></a></p>


                <div class="inside" id="userFilters" style='display:<?php echo $any_filters?'block':'none'?>;'>
                    <div class="postbox wp-admin">
                        <form class="bftpro" method="get">
                            <input type="hidden" name="page" value="bft_list">
                            <div class="arigato-admin-form-group">
                                <label class="arigato-admin-col-2"><?php _e('Filter by email', 'broadfast')?>:</label>
                                <input type="text" name="filter_email" value="<?php echo esc_attr(@$_GET['filter_email'])?>" class="arigato-admin-col-6">
                            </div>
                            <div class="arigato-admin-form-group">
                                <label class="arigato-admin-col-2"><?php _e('Filter by name', 'broadfast')?>:</label>
                                <input type="text" name="filter_name" value="<?php echo esc_attr(@$_GET['filter_name'])?>" class="arigato-admin-col-6">
                            </div>
                            <div class="arigato-admin-form-group">
                                <label class="arigato-admin-col-2"><?php _e('Filter by status', 'broadfast')?>:</label>
                                <select name="filter_status" class="arigato-admin-col">
                                    <option value="-1" <?php if(!isset($_GET['filter_status']) or $_GET['filter_status']=='-1') echo "selected"?>><?php _e("Any Status", 'broadfast')?></option>
                                    <option value="1" <?php if(isset($_GET['filter_status']) and $_GET['filter_status']=='1') echo "selected"?>><?php _e("Active", 'broadfast')?></option>
                                    <option value="0" <?php if(isset($_GET['filter_status']) and $_GET['filter_status']==='0') echo "selected"?>><?php _e("Inactive", 'broadfast')?></option>
                                </select>
                            </div>

                            <div class="arigato-admin-form-group">
                                <label class="arigato-admin-col-2"><?php _e('Signed up:', 'broadfast');?></label>
                                <select name="signup_date_cond" class="arigato-admin-col">
                                    <option value=""><?php _e('Any time', 'broadfast');?></option>
                                    <option value="on" <?php if(!empty($_GET['signup_date_cond']) and $_GET['signup_date_cond']=='on') echo 'selected'?>><?php _e('On', 'broadfast');?></option>
                                    <option value="after" <?php if(!empty($_GET['signup_date_cond']) and $_GET['signup_date_cond']=='after') echo 'selected'?>><?php _e('After', 'broadfast');?></option>
                                    <option value="before" <?php if(!empty($_GET['signup_date_cond']) and $_GET['signup_date_cond']=='before') echo 'selected'?>><?php _e('Before', 'broadfast');?></option>
                                </select>
                                <input type="text" class="bftDatePicker" name="sdate" id="bftSignupDate" value="<?php echo empty($_GET['sdate']) ? '' : esc_attr($_GET['sdate'])?>" class="arigato-admin-col">
                                <input type="hidden" name="filter_signup_date" value="<?php echo empty($_GET['filter_signup_date']) ? '' : esc_attr($_GET['filter_signup_date'])?>" id="alt_bftSignupDate">
                            </div>

                            <div class="arigato-admin-form-group">
                                <div class="arigato-admin-offset-2">
                                    <input type="submit" value="<?php _e('Filter subscribers', 'broadfast');?>" class="button button-primary">
                                    <input type="button" value="<?php _e('Reset filters', 'broadfast')?>" onclick="window.location='admin.php?page=bft_list';" class="button button-secondary">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

		        <?php if(count($users)):?>
                    <table class="widefat bft-table">
                        <thead>
                        <tr><th><input type="checkbox" onclick="this.checked ? jQuery('.subscriber_chk').attr('checked', 'true') : jQuery('.subscriber_chk').removeAttr('checked');showHideDelSubs();"></th><th><a href="admin.php?page=bft_list&<?php echo BFTLinkHelper::subscribers('email')?>"><?php _e('User Email Address', 'broadfast')?></a></th>
                            <th><a href="admin.php?page=bft_list&<?php echo BFTLinkHelper::subscribers('name')?>"><?php _e('User Name', 'broadfast')?></a></th>
                            <th><a href="admin.php?page=bft_list&<?php echo BFTLinkHelper::subscribers('tU.date')?>"><?php _e('Date Signed', 'broadfast')?></a></th>
                            <th><a href="admin.php?page=bft_list&<?php echo BFTLinkHelper::subscribers('tU.date, tU.email')?>"><?php _e('Active?', 'broadfast')?></a></th>
                            <th><a href="admin.php?page=bft_list&<?php echo BFTLinkHelper::subscribers('cnt_mails')?>"><?php _e('Emails sent', 'broadfast')?></a></th>
                            <th><?php _e('Action', 'broadfast')?></th></tr>
                        </thead>

                        <tbody>
				        <?php foreach($users as $user):
					        $class = ('alternate' == @$class) ? '' : 'alternate'; ?>

                            <form method="post" style="margin:none;" onsubmit="return validateUser(this);">
                                <tr class="<?php echo $class?>"><td><input type="checkbox" value="<?php echo $user->id?>" class="subscriber_chk" onclick="showHideDelSubs();"></td>
                                    <td><?php echo $user->email?></td>
                                    <td><?php echo stripslashes($user->name)?></td>
                                    <td><?php echo date_i18n($dateformat, strtotime($user->date));?></td>
                                    <td><?php echo $user->status ? __('Yes', 'broadfast') : __('No', 'broadfast');?></td>
                                    <td><?php echo $user->cnt_mails;?></td>
                                    <td><a href="admin.php?page=bft_list&action=edit&id=<?php echo $user->id?>&ob=<?php echo $ob?>&offset=<?php echo $offset?>" class="button button-primary"><?php _e('Edit subscriber', 'broadfast');?></a>
                                        &nbsp; <input type="button" value="<?php _e('Delete', 'broadfast')?>" onclick="delUser(this.form);" class="button"></td></tr>
                                <input type="hidden" name="del_user" value="0">
                                <input type="hidden" name="id" value="<?php echo $user->id?>">
						        <?php wp_nonce_field('bft_del_user');?>
                            </form>
				        <?php endforeach; ?>
                        </tbody>
                    </table>

		        <?php else: ?>
                    <p><?php _e('This mailing list is empty.', 'broadfast')?></p>
		        <?php endif;?>

		        <?php if($num_unsubs):?><p><?php printf(__('%d user(s) unsubscribed.', 'broadfast'), $num_unsubs);?></p><?php endif;?>

                <p align="center">
			        <?php if($offset > 0):?><a href="admin.php?page=bft_list&<?php echo BFTLinkHelper::subscribers($ob, false)?>&offset=<?php echo $offset-$per_page?>"><?php _e('previous page')?></a> &nbsp;<?php endif;?>
			        <?php if($offset + $per_page < $count):?><a href="admin.php?page=bft_list&<?php echo BFTLinkHelper::subscribers($ob, false)?>&offset=<?php echo $offset+$per_page?>"><?php _e('next page')?></a> &nbsp;<?php endif;?>
                </p>

                <div id="massSubscribersAction" style="display:none;">
                    <form method="post" action="admin.php?page=bft_list&ob=<?php echo $ob?>&offset=<?php echo $offset?>">
                        <p align="center"><input type="hidden" name="mass_delete" value="0">
                            <input type="button" value="<?php _e('Delete Selected Subscribers', 'broadfast')?>" onclick="bftMassDelete(this.form);" class="button"></p>
                        <input type="hidden" name="del_ids" value="0">
				        <?php wp_nonce_field('bft_mass_del');?>
                    </form>
                </div>
            </div>
        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>



</div>

<script language="javascript">
function delUser(frm) {
	if(confirm("<?php _e('Are you sure?', 'broadfast')?>")) {
		frm.del_user.value=1;
		frm.submit();
	}
}

function validateUser(frm) {
	if(frm.email.value=="") {
		alert("<?php _e('Please enter email', 'broadfast')?>");
		frm.email.focus();
		return false;
	}	
	return true;
}

// show or hide the mass-action button(s)
function showHideDelSubs() {
	var len = jQuery(".subscriber_chk:checked").length;
	
	if(len) jQuery('#massSubscribersAction').show();
	else jQuery('#massSubscribersAction').hide();
}

function bftMassDelete(frm) {
	if(confirm("<?php _e('Are you sure?', 'broadfast')?>")) {
		jQuery(".subscriber_chk:checked").each(function(){
			frm.del_ids.value += "," + jQuery(this).val();
		})
		frm.mass_delete.value = 1;
		frm.submit();
	}
}

jQuery(document).ready(function() {
    jQuery('.bftDatePicker').datepicker({
    		dateFormat : '<?php echo dateformat_PHP_to_jQueryUI($dateformat);?>',
         altFormat : 'yy-mm-dd'
    });
    
    jQuery(".bftDatePicker").each(function (idx, el) { 
	    jQuery(this).datepicker("option", "altField", "#alt_" + jQuery(this).attr("id"));
    });
});

<?php bft_resp_table_js();?>
</script>