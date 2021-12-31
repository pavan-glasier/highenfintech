<!-- Newsletter plugin pane -->

<div id="wpcf7-tg-pane-newsletters" class="newsletters">
	<form action="">
		<div class="control-box">
			<fieldset>
				<?php
					
				$description = __('Generate a %s subscribe checkbox for your form. See the %s', $this -> extension_name);
				$plugin_link = "http://tribulant.com/plugins/view/1/wordpress-newsletter-plugin";
				$desc_link = "http://tribulant.com/extensions/view/28/contact-form-7-subscribers";	
					
				?>
				<legend><?php echo sprintf(esc_html($description), '<a target="_blank" href="' . $plugin_link . '">Newsletter plugin</a>', '<a target="_blank" href="' . $desc_link . '">Contact Form 7 Subscribers extension</a>'); ?></legend>
		
				<table class="form-table">	
					<tr>
						<th><label for="<?php echo $args['content']; ?>-name"><?php _e('Name', $this -> extension_name); ?></label></th>
						<td>
							<input type="text" name="name" class="tg-name oneline" id="<?php echo $args['content']; ?>-name" />
						</td>
					</tr>
					<tr>
						<th><label for="<?php echo $args['content']; ?>-autocheck"><?php _e('Checked by default?', $this -> extension_name); ?></label></th>
						<td>
							<label><input type="checkbox" name="autocheck:on" class="option" id="<?php echo $args['content']; ?>-autocheck" /> <?php _e('Yes, check by default', $this -> extension_name); ?></label>
						</td>
					</tr>
					<tr>
						<th><label for="<?php echo $args['content']; ?>-values"><?php _e('Checkbox Label', $this -> extension_name); ?></label></th>
						<td>
							<input type="text" name="values" id="<?php echo $args['content']; ?>-values" value="<?php _e('Please subscribe me to your newsletters', $this -> extension_name); ?>" class="labelvalue oneline" />
						</td>
					</tr>
					<tr>
						<th><label for="<?php echo $args['content']; ?>-listchoice-choose"><?php _e('Mailing List(s)', $this -> extension_name); ?></label></th>
						<td>					
							<label><input id="<?php echo $args['content']; ?>-listchoice-choose" checked="checked" onclick="jQuery('input[name=list]').val('choice'); newsletters_cf7_updatetags(this); /*jQuery.tgCreateTag(jQuery('.tg-pane'), 'newsletters');*/ jQuery('#listchoice_div').hide();" type="radio" name="listchoice" value="choose" /> <?php _e('Let user choose', $this -> extension_name); ?></label>
							<label><input onclick="jQuery('#listchoice_div').show(); newsletters_cf7_updatetags(this);" type="radio" name="listchoice" value="predefined" /> <?php _e('Predefined lists', $this -> extension_name); ?></label>
							
							<div id="listchoice_div" style="display:none; margin:15px 0;">
								<?php if ($mailinglists = wpml_get_mailinglists()) : ?>								
									<?php foreach ($mailinglists as $mailinglist) : ?>
										<label><input type="checkbox" name="lists[]" value="<?php echo $mailinglist -> id; ?>" /> <?php echo __($mailinglist -> title); ?></label><br/>
									<?php endforeach; ?>
									
									<input type="hidden" name="list" value="choice" class="option" />
									
									<script type="text/javascript">
									jQuery('input[name="lists[]"]').on('click', function() {
										jQuery('input[name="list"]').val(jQuery('input[name="lists[]"]:checked').map(function() { return this.value; }).get().join('|'));
										/*jQuery.tgCreateTag(jQuery('.tg-pane'), 'newsletters');*/	
										newsletters_cf7_updatetags(this);
									});
									</script>
								<?php else : ?>
									<p class="<?php echo $this -> pre; ?>error"><?php _e('No mailing lists are available.', $this -> extension_name); ?></p>
								<?php endif; ?>
							</div>
							
							<script type="text/javascript">
								function newsletters_cf7_updatetags(element) {
									var form = jQuery('#wpcf7-tg-pane-newsletters').closest('form.tag-generator-panel');
									_wpcf7.taggen.normalize(jQuery(element));
									_wpcf7.taggen.update(form);
								}
							</script>
						</td>
					</tr>
					<tr>
						<th><?php _e('Custom Fields', $this -> extension_name); ?></th>
						<td>
							<?php if ($fields = wpml_get_fields()) : ?>
								<table>
									<tbody>
										<?php foreach ($fields as $field) : ?>
											<?php if ($field -> slug != "list") : ?>
												<?php
												
												$value = ($field -> slug == "email") ? "your-email" : false; 
												
												?>
											
												<p><?php echo __($field -> title); ?> <?php _e('for field name:', $this -> extension_name); ?>
												<br/><input type="text" class="oneline option" name="<?php echo $field -> slug; ?>" value="<?php echo esc_attr(stripslashes($value)); ?>" /></p>
											<?php endif; ?>
										<?php endforeach; ?>
									</tbody>
								</table>
							<?php else : ?>
								<p class="<?php echo $this -> pre; ?>error"><?php _e('No custom fields are available.', $this -> extension_name); ?></p>
							<?php endif; ?>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
		
		<div class="insert-box">
			<input type="text" name="newsletters" class="tag code" readonly="readonly" onfocus="this.select()">
		
			<div class="submitbox">
			<input type="button" class="button button-primary insert-tag" value="<?php _e('Insert Tag', $this -> extension_name); ?>">
			</div>
		
			<br class="clear">
		
			<p class="description mail-tag"><label for="tag-generator-panel-newsletters-mailtag">To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (<strong><span class="mail-tag">[newsletters-***]</span></strong>) into the field on the Mail tab.<input type="text" class="mail-tag code hidden" readonly="readonly" id="tag-generator-panel-newsletters-mailtag"></label></p>
		</div>
		
		<?php /*<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?><br /><input type="text" name="newsletters" class="tag" readonly="readonly" onfocus="this.select()" /></div>
		<div class="tg-mail-tag"><?php echo esc_html( __( "And, put this code into the Mail fields below.", 'wpcf7' ) ); ?><br /><span class="arrow">&#11015;</span>&nbsp;<input type="text" class="mail-tag" readonly="readonly" onfocus="this.select()" /></div>*/ ?>
	</form>
</div>