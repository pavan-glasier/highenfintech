<div class="arigato-archive" style="overflow-x:auto;">
	<table class="arigato-archive">
		<thead>
			<tr>
				<th><?php _e('Newsletter', 'broadfast');?></th>
				<th><?php _e('Date', 'broadfast');?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($newsletters as $newsletter):?>
				<tr>
					<td><a href="<?php echo add_query_arg(['offset' => $offset, 'id'=>$newsletter->id], $current_url);?>"><?php echo stripslashes($newsletter->subject);?></a></td>
					<td><?php echo date_i18n($date_format, strtotime($newsletter->date));?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	
	<?php if($count > $per_page):?>
		<p class="arigato-pagination">
			<?php if($offset > 0):?>
				<a href="<?php echo add_query_arg(['offset' => $offset - $per_page], $current_url);?>"><?php _e('&lt;&lt; Previous', 'broadfast');?></a> 
			<?php endif;?>
			
			<?php if(($offset + $per_page) < $count):?>
				<a href="<?php echo add_query_arg(['offset' => $offset + $per_page], $current_url);?>"><?php _e('Next &gt;&gt;', 'broadfast');?></a> 
			<?php endif;?>
		</p>
	<?php endif;?>
</div>