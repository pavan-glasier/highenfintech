<?php // phpcs:ignoreFile ?>
<!-- Export Ajax Post -->

<div class="wrap newsletters <?php echo esc_html($this -> pre); ?>">
	<h2><?php esc_html_e('Export Subscribers', 'wp-mailinglist'); ?></h2>
	
	<?php if (!empty($subscribers)) : ?>
		<p><?php echo sprintf(__('You are about to export <b>%d</b> subscribers from <b>%d</b> mailing lists with <b>%s</b> status.', 'wp-mailinglist'), count($subscribers), count($_POST['export_lists']), sanitize_text_field(wp_unslash($_POST['export_status']))); ?></p>
		<p class="newsletters_exportajaxcount"><span id="exportajaxcount"><strong><span id="exportajaxcountinside" class="newsletters_success">0</span></strong></span> <span id="exportajaxfailedcount">(<strong><span id="exportajaxfailedcountinside" class="newsletters_error">0</span></strong> failed)</span> <?php esc_html_e('out of', 'wp-mailinglist'); ?> <strong><?php echo count($subscribers); ?></strong> <?php esc_html_e('subscribers have been exported.', 'wp-mailinglist'); ?></p>
		
		<div id="exportprogressbar"></div>
		
		<p class="submit">
			<a href="javascript:history.go(-1);" class="button button-primary" onclick=""><i class="fa fa-arrow-left"></i> <?php esc_html_e('Back', 'wp-mailinglist'); ?></a>
			<a href="" onclick="cancelexporting(); return false;" id="cancelexporting" disabled="disabled" style="display:none;" class="button-secondary"><i class="fa fa-pause"></i> <?php esc_html_e('Pause', 'wp-mailinglist'); ?></a>
			<a href="" onclick="startexporting(); return false;" id="startexporting" disabled="disabled" class="button-primary"><i class="fa fa-refresh fa-spin"></i> <?php esc_html_e('Reading data, please wait', 'wp-mailinglist'); ?></a>
			<span id="exportmore" style="display:none;"><a href="?page=<?php echo $this -> sections -> importexport; ?>#export" id="" class="button-secondary"><?php esc_html_e('Export More', 'wp-mailinglist'); ?> <i class="fa fa-arrow-right"></i></a></span>
		</p>
		
		<h3 style="display:none;"><?php esc_html_e('Subscribers Exported', 'wp-mailinglist'); ?></h3>
		<div id="exportajaxsuccessrecords" class="scroll-list" style="display:none;"><!-- successful records --></div>
		
		<script type="text/javascript">
		var allsubscribers = [];
			
		jQuery(document).ready(function() {	
			<?php if (!empty($subscribers)) : ?>
				<?php foreach ($subscribers as $subscriber) : ?>
					allsubscribers.push(<?php echo wp_json_encode(stripslashes_deep($subscriber)); ?>);
				<?php endforeach; ?>
			<?php endif; ?>
				
			requestArray = new Array();
			cancelexport = "N";
			exportingnumber = 100;
			jQuery('#startexporting').removeAttr('disabled').html('<i class="fa fa-play"></i> <?php echo addslashes(__("Start Exporting", 'wp-mailinglist')); ?>');
		});
		
		function cancelexporting() {
			cancelexport = "Y";
			jQuery('#cancelexporting').attr('disabled', "disabled");
			jQuery('#startexporting').removeAttr('disabled').attr('onclick', 'resumeexporting(); return false;').html('<i class="fa fa-play"></i> <?php echo addslashes(__('Resume Exporting', 'wp-mailinglist')); ?>');
			
			for (var r = 0; r < requestArray.length; r++) {
				requestArray[r].abort();
			}
		}
		
		function resumeexporting() {
			cancelexport = "N";
			jQuery('#startexporting').attr('disabled', "disabled").html('<i class="fa fa-refresh fa-spin"></i> <?php echo addslashes(__('Exporting Now', 'wp-mailinglist')); ?>');
			jQuery('#cancelexporting').removeAttr('disabled');
			
			var newexportingnumber = (exportingnumber - completed);
			requests = (completed - 1);
			
			var exportsubscribers = [];
			var i = (completed - 1);
			requests = i;
			
			while (subscribers.length > i) {
				exportsubscribers.push(subscribers[i]);				
				if (exportsubscribers.length == exportingnumber || (i + 1) >= subscribers.length) {
					exportmultiple(exportsubscribers);								
					exportsubscribers = [];
				}
				
				i++;
			}
		}
		
		function startexporting() {
			jQuery('#cancelexporting').removeAttr('disabled').show();
			jQuery('#startexporting').attr('disabled', "disabled").html('<i class="fa fa-refresh fa-spin"></i> <?php echo addslashes(__('Exporting Now', 'wp-mailinglist')); ?>');
		
			//text = jQuery('#exportajaxbox').text();
			//subscribercount = '<?php echo count($subscribers); ?>';
			subscribercount = allsubscribers.length;
			//subscribers = text.split('<|>');
			subscribers = allsubscribers;
			completed = 0;
			cancelexport = "N";
			requests = 0;
			exported = 0;
			failed = 0;
			
			headings = <?php echo wp_json_encode($headings); ?>;
			
			jQuery('#exportprogressbar').progressbar({value:0});
			
			var exportsubscribers = [];
			var i = 0;
			
			while (subscribers.length > i) {
				exportsubscribers.push(subscribers[i]);				
				if (exportsubscribers.length == exportingnumber || (i + 1) >= subscribers.length) {
					exportmultiple(exportsubscribers);															
					exportsubscribers = [];
				}
				
				i++;
			}
		}
		
		function exportmultiple(exportsubscribers) {
			if (requests >= subscribercount || cancelexport == "Y") { return; }
			requests += exportsubscribers.length;
			
			requestArray.push(jQuery.post(newsletters_ajaxurl + 'action=newsletters_exportmultiple&security=<?php echo esc_html( wp_create_nonce('exportmultiple')); ?>', {delimiter:'<?php echo esc_html( $delimiter); ?>', subscribers:exportsubscribers, headings:headings, exportfile:'<?php echo esc_html( $exportfile); ?>'}, function(response) {
				var data = response.split("<|>");
				if (data.length > 1) {
					for (d = 0; d < data.length; d++) {
						if (data[d] != "") {
							completed++;
							jQuery('#exportajaxcountinside').text(completed);
							jQuery('#exportajaxsuccessrecords').prepend('<div class="ui-state-highlight ui-corner-all" style="margin-bottom:3px;"><p><i class="fa fa-check"></i> ' + data[d] + '</div>').fadeIn().prev().fadeIn();
							var value = (completed * 100) / subscribercount;
							jQuery("#exportprogressbar").progressbar("value", value);
						}
					}
				}
			}).success(function() {
				if (completed >= subscribercount) {
					jQuery('#cancelexporting').hide();
					warnMessage = null;
					jQuery('#startexporting').html('<?php echo addslashes(__('Download CSV', 'wp-mailinglist')); ?> <i class="fa fa-download"></i>').removeAttr('disabled').removeAttr('onclick').attr("href", "<?php echo esc_url_raw($Html -> retainquery('wpmlmethod=exportdownload&file=' . urlencode($exportfile), home_url())); ?>");
					jQuery('#exportmore').show();
				}
			}).fail(function() {
				completed += exportsubscribers.length;
				failed += exportsubscribers.length;
			}));
		}
		</script>
		
		<script type="text/javascript">
		var warnMessage = "<?php esc_html_e('You have unsaved changes on this page! All unsaved changes will be lost and it cannot be undone.', 'wp-mailinglist'); ?>";
		
		jQuery(document).ready(function() {
		    window.onbeforeunload = function () {
		        if (warnMessage != null) return warnMessage;
		    }
		});
		</script>
	<?php else : ?>
		<p class="newsletters_error"><?php esc_html_e('No subscribers are available for export, please try again.', 'wp-mailinglist'); ?></p>
		<p>
			<a href="javascript:history.go(-1);" class="button button-primary" onclick=""><?php esc_html_e('&laquo; Back', 'wp-mailinglist'); ?></a>
		</p>
	<?php endif; ?>
</div>