<div class="wrap">
    <div class="arigato">
        <section>
            <h1><?php _e('Integrate Your Mailing List With a Formidable Form', 'broadfast')?></h1>
            <p><?php printf(__('This page is available because you have installed and activated the plugin <a href="%s" target="_blank">Formidable Forms</a>. It lets you connect the form to your Arigato  mailing list so when the form is submitted the user is also subscribed to the mailing list.', 'broadfast'), 'https://wordpress.org/plugins/formidable/');?></p>

            <p><a href="admin.php?page=bft_list"><?php _e('Back to your mailing list', 'broadfast');?></a></p>

            <form method="post" class="broadfast">
                <div class="postbox wp-admin">
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Select Formidable Form:', 'broadfast');?></label>
                        <select name="form_id" onchange="this.form.submit();">
									<option value=""><?php _e('-Please select-', 'broadfast');?></option>
									<?php foreach($forms as $form):?>
										<option value="<?php echo $form->id?>" <?php if($selected_form_id == $form->id) echo 'selected'?>><?php echo stripslashes($form->name)?></option>
									<?php endforeach;?>
								</select>
                    </div>

                    <h3><?php _e('Mailing list fields','broadfast');?></h3>

                    <p><?php _e('You need to select which fields from the Formidable form correspond to the fields in the mailing list. The only mailing list field that requires a corresponding form field is email. All other fields can be omitted.', 'broadfast');?></p>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Email field', 'broadfast');?></label>
                        <select name="field_email">
                            <option value=""><?php _e('- Please select -', 'broadfast')?></option>
							        <?php foreach($formidable_fields as $formidable): 
											if($formidable->type != 'email') continue;?>
											<option value="<?php echo $formidable->id?>" <?php if(!empty($integration['fields']['email']) and $integration['fields']['email'] == $formidable->id) echo 'selected'?>><?php echo stripslashes($formidable->name);?></option>
										<?php endforeach;?>
                        </select>
                    </div>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Name field', 'broadfast');?></label>
                        <select name="field_name" class="arigato-admin-col">
                            <option value=""><?php _e('- No matching field -', 'broadfast')?></option>
								      <?php foreach($formidable_fields as $formidable): 
										if($formidable->type != 'name') continue;?>
										<option value="<?php echo $formidable->id?>" <?php if(!empty($integration['fields']['name']) and $integration['fields']['name'] == $formidable->id) echo 'selected'?>><?php echo stripslashes($formidable->name);?></option>
									<?php endforeach;?>
                        </select>
                    </div>

                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col-2"><?php _e('Checkbox to confirm', 'broadfast');?></label>
                        <select name="field_checkbox" class="arigato-admin-col">
                        	<option value=""><?php _e('- No matching field -', 'broadfast')?></option>
		                     <?php foreach($formidable_fields as $formidable): 
										if($formidable->type != 'checkbox' or count($formidable->options) != 1) continue;?>
										<option value="<?php echo $formidable->id?>" <?php if(!empty($integration['fields']['checkbox']) and $integration['fields']['checkbox'] == $formidable->id) echo 'selected'?>><?php echo stripslashes($formidable->name);?></option>
									<?php endforeach;?>
                        </select>
				        <p class="arigato-admin-col-8 arigato-help"><?php _e("You can choose a checkbox from the Formidable form that shoud be selected to subscribe the user in the list. If you don't select such checkbox, everyone who submits the associated Ninja form will be subscribed to the mailing list.", 'broadfast');?></p>
                    </div>

                    <p><input type="submit" name="ok" value="<?php _e('Save integration','broadfast');?>" class="button-primary"></p>
                </div>
		        <?php wp_nonce_field('bft_formidable');?>
            </form>
        </section>
        <aside id="bft-sidebar">
		    <?php require(BFT_PATH."/views/sidebar.html.php");?>
        </aside>
    </div>

</div>