<?php
	global $wpdb;
	if($_REQUEST['submit']):
		update_option('sh_email_alert_waiting',$_REQUEST['waiting']);
		update_option('sh_email_alert_success',$_REQUEST['success']);
		update_option('sh_email_alert_failed',$_REQUEST['failed']);
		update_option('sh_email_alert_required',$_REQUEST['required']);
		echo '<div id="message" class="updated fade">Successfully updated!</div>';
	endif;
?>
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br></div>
    <div style="float:right">
    	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_donations" />
            <input type="hidden" name="business" value="samhoamt@gmail.com" />
            <input type="hidden" name="item_name" value="SH Email Alert" />
            <input type="hidden" name="currency_code" value="USD" />
            <input type="image" src="<?php echo SH_EMAIL_ALERT_PATH; ?>/donate_btn.gif" name="submit" alt="Make payments with payPal - it's fast, free and secure!" />
        </form>
    </div>
    <h2>Email Alert Options</h2>
    <form method="post">
    	<h3>Messages</h3>
        <table class="form-table">
        	<tbody>
            	<tr>
                    <th scope="row"><label for="waiting">Waiting Message</label></th>
                    <td><input type="text" id="waiting" name="waiting" value="<?php echo get_option('sh_email_alert_waiting'); ?>" class="large-text" /></td>
                </tr>
            	<tr>
                    <th scope="row"><label for="success">Subscribe Successfully</label></th>
                    <td><input type="text" id="success" name="success" value="<?php echo get_option('sh_email_alert_success'); ?>" class="large-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="failed">Subscribe Failed</label></th>
                    <td><input type="text" id="failed" name="failed" value="<?php echo get_option('sh_email_alert_failed'); ?>" class="large-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="required">There is a field that sender needs to fill in</label></th>
                    <td><input type="text" id="required" name="required" value="<?php echo get_option('sh_email_alert_required'); ?>" class="large-text" /></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
    		<input type="submit" name="submit" value="Update" />
    	</p>
	</form>
</div>