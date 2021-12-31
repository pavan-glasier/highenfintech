<form method="post" class="bft" action="?bft=bft_unsubscribe">
	<p><?php _e("Please confirm that you wish to unsubscribe", 'broadfast')?></p>
	<p><input type="text" name="email" value="<?php echo esc_attr(@$_GET['email'])?>"></p>
			
	
	<p><input type="submit" value="<?php _e('Unsubscribe me', 'broadfast');?>" class="bft-button"></p>
	<input type="hidden" name="bft_unsubscribe" value="1">
</form>		