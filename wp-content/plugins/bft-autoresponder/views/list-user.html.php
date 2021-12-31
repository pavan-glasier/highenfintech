<div class="wrap">
    <div class="arigato">
        <section>
            <h1><?php _e('Edit Subscriber', 'broadfast');?></h1>

            <p><a href="admin.php?page=bft_list&ob=<?php echo esc_attr($_GET['ob'])?>&offset=<?php echo intval($_GET['offset'])?>"><?php _e('Back to all subscribers', 'broadfast');?></a></p>

            <form method="post">
                <div class="arigato-admin-form-group-column">
                    <label><?php _e('Email address:', 'broadfast');?></label>
                    <input type="text" name="email" value="<?php echo $user->email?>" class="arigato-admin-col-4">
                </div>
                <div class="arigato-admin-form-group-column">
                    <label><?php _e('User name:', 'broadfast');?></label>
                    <input type="text" name="user_name" value="<?php echo $user->name?>" class="arigato-admin-col-4">
                </div>
                <div class="arigato-admin-form-group-column">
                    <label><?php _e('Status', 'broadfast');?></label>
                    <select name="status" class="arigato-admin-col">
                        <option value="1" <?php if(!empty($user->status)) echo 'selected'?>><?php _e('Active', 'broadfast');?></option>
                        <option value="0" <?php if(empty($user->status)) echo 'selected'?>><?php _e('Inactive', 'broadfast');?></option>
                    </select>
                </div>
                <div class="arigato-admin-form-group-column">
                    <label><?php _e('Date subscribed:', 'broadfast');?></label>
                    <input type="text" name="date" class="datepicker arigato-admin-col" value="<?php echo $user->date;?>">
                </div>

                <p><input type="hidden" name="save_user" value="1">
                    <input type="submit" value="<?php _e('Save subscriber', 'broadfast');?>" class="button-primary"></p>
		        <?php wp_nonce_field('bft_list_user');?>
            </form>
        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>
</div>

<script type="text/javascript" >
jQuery(function(){
	jQuery('.datepicker').datepicker({dateFormat: "yy-m-d"});
});
</script>