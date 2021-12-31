<div class="wrap">
    <div class="arigato">
        <section>
	        <?php if(!empty($success_text)) echo $success_text; ?>

            <div class="postbox">
                <h2><?php _e('Import Members from CSV File', 'broadfast')?></h2>

                <form method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Fields Delimiter:', 'broadfast')?></label>
                        <input type="text" name="delim" value="," class="arigato-admin-col-xs">
                        <p class="arigato-admin-col arigato-help"><?php _e('(Can be comma, semicolon, or tabulator. Enter <b>\t</b> for tabulator)', 'broadfast')?></p>
                    </div>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Email column is number:', 'broadfast')?></label>
                        <input type="text" name="email_column" value="1" class="arigato-admin-col-xs">
                        <p class="arigato-admin-col arigato-help"><?php _e('in the CSV', 'broadfast')?></p>
                    </div>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Name column is number:', 'broadfast')?></label>
                        <input type="text" name="name_column" value="2" class="arigato-admin-col-xs">
                        <p class="arigato-admin-col arigato-help"><?php _e('in the CSV', 'broadfast')?></p>
                    </div>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Upload CSV:', 'broadfast')?></label>
                        <input type="file" name="file">
                    </div>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2">
                        	<input type="checkbox" name="skip_title_row" value="1"> <?php _e('Skip title row', 'broadfast');?> 
                        </label>                        
                    </div>
                    <div class="arigato-admin-offset-2">
                        <input type="submit" name="broadfast_import" value="<?php _e('Import CSV File', 'broadfast')?>" class="button button-primary">
                    </div>
		            <?php wp_nonce_field('bft_import');?>
                </form>
            </div>

            <div class="postbox">
                <h2><?php _e('Export Members to CSV File', 'broadfast')?></h2>

                <form method="post" action="admin.php?page=bft_import&noheader=1">
                    <p><input type="checkbox" checked="true" name="active"> <?php _e('Export only confirmed members', 'broadfast')?></p>
                    <p><input type="submit" name="broadfast_export" value="<?php _e('Export members', 'broadfast')?>" class="button-primary"></p>
		            <?php wp_nonce_field('bft_export');?>
                </form>

	            <?php if(isset($_POST['export'])):?>
                    <div style="float:left;width:620px;margin-left:5%">
                        <textarea style="width:600px;height:440px;"><?php echo $content; ?></textarea>
                    </div>
	            <?php endif; ?>
            </div>

        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>

</div>	