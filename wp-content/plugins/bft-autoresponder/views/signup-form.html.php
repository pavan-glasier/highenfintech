<?php if(!empty($recaptcha2)):?><script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $recaptcha2?>"></script><?php endif;?>
<?php if(!empty($recaptcha3)):?><script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptcha3?>"></script><?php endif;?>
<form class="bft-front-form <?php echo !empty($orientation_class) ? $orientation_class : 'bft-vertical'?> <?php echo !empty($label_class) ? $label_class : 'bft-inline-label'?>" method="post" action="<?php echo home_url("/");?>" onsubmit="return BFTValidate(this);">
<div class="bft-form-group"><label><?php _e('Name:', 'broadfast')?></label> <input type="text" name="user_name" <?php if(!empty($allow_get) and !empty($name)) echo 'value="'.$name.'"';?>></div>
<div class="bft-form-group"><label><?php _e('Email:', 'broadfast')?></label> <input type="text" name="email" <?php if(!empty($allow_get) and !empty($email)) echo 'value="'.$email.'"';?>></div>
<?php if(!empty($recaptcha_html)):?><div class="bft-form-group recaptcha"><label> </label><?php echo $recaptcha_html?></div><?php endif;?>
<?php if(!empty($text_captcha_html)) echo '<div class="bft-form-group text-captcha">'.$text_captcha_html.'</div>';?>
<div class="bft-form-group"><input type="submit" value="<?php echo empty($attr['button_text']) ? __('Register', 'broadfast') : esc_attr($attr['button_text']);?>" class="bft-button"></div>
<input type="hidden" name="bft" value="register">
</form>

<script type="text/javascript" >
function BFTValidate(frm) {
	<?php if(!empty($require_name)):?>
	if(frm.user_name.value == "") {
		alert("<?php _e('Please fill in your name', 'broadfast')?>");
		frm.user_name.focus();
		return false;
	}
	<?php endif;?>		
	
	var email = frm.email.value;
	if(email=="" || email.indexOf("@")<1 ||email.indexOf(".")<1) {
		alert("<?php _e('Please fill in valid email address', 'broadfast')?>");
		frm.email.focus();
		return false;
	}
	
	<?php if(!empty($text_captcha_html)):?>
	if(frm.bft_text_captcha_answer.value == '') {
		alert("<?php _e('Please answer the validation question', 'broadfast')?>");
		frm.bft_text_captcha_answer.focus();
		return false;
	}
	<?php endif;?>
	
	return true;
}
</script>