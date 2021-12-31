<style type="text/css">
    <?php bft_resp_table_css(600);?>
</style>
<div class="wrap">
    <div class="arigato">
        <section>
            <h1><?php _e('Email Log', 'broadfast')?></h1>

            <div>
                <p><?php _e('This is a raw email log showing you all emails sent from the autoresponder. It incldues activation, double opt-in emails, drip marketing emails, newsletters, etc. A lot more specific logs are available in the PRO version.', 'broadfast')?></p>

                <form method="post">
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e('Log date (start - end):', 'broadfast')?></label>
                        <div class="arigato-admin-col">
                            <input type="text" name="start_date" class="datepicker arigato-admin-col-xs" value="<?php echo $start_date?>"> - <input type="text" name="end_date" class="datepicker arigato-admin-col-xs" value="<?php echo $end_date?>">
                            <input type="submit" value="<?php _e('Show log', 'broadfast')?>" class="button-primary">
                        </div>
                    </div>
                    <div class="arigato-admin-form-group">
                        <label class="arigato-admin-col"><?php _e('Automatically cleanup old logs after', 'broadfast')?></label>
                        <div class="arigato-admin-col">
                            <input type="text" class="arigato-admin-col-xs" name="cleanup_days" value="<?php echo $cleanup_raw_log?>">
                            <span class="arigato-ml-25 arigato-mr-25"><?php _e('days', 'broadfast')?></span>
                            <input type="submit" name="cleanup" value="<?php _e('Set Cleanup', 'broadfast')?>" class="button-primary">
                        </div>

                    </div>
                </form>

		        <?php if(!sizeof($emails)):?>
                    <p><?php _e('No emails have been sent on the selected date.', 'broadfast')?></p>
		        <?php else:?>
                    <table class="widefat bft-table">
                        <thead>
                            <tr>
                                <th><?php _e('Time', 'broadfast')?></th>
                                <th><?php _e('Sender', 'broadfast')?></th>
                                <th><?php _e('Receiver', 'broadfast')?></th>
                                <th><?php _e('Subject', 'broadfast')?></th>
                                <th><?php _e('Status', 'broadfast')?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($emails as $email):
	                        $class = ('alternate' == @$class) ? '' : 'alternate';?>
                            <tr class="<?php echo $class?>"><td><?php echo date('H:i', strtotime($email->datetime))?></td>
                                <td><?php echo stripslashes($email->sender)?></td>
                                <td><?php echo stripslashes($email->receiver)?></td>
                                <td><?php echo stripslashes($email->subject)?></td>
                                <td><?php echo $email->status?></td></tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
		        <?php endif;?>

            </div>
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