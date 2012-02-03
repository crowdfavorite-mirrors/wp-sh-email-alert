<?php
/*
Plugin Name: SH Email Alert
Plugin URI: 
Description: Email Alert subscribe form. Simple put the shortcode '[sh_email_alert_form]' into your page or post.
Version: 1.0
Author: Sam Hoe
Author URI: 
*/

/*  Copyright 2011  Sam Hoe  (email : SH Email Alert Sam Hoe samhoamt@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define(SH_EMAIL_ALERT_PATH,WP_PLUGIN_URL.'/sh-email-alert');
include_once('functions.php');

// Add Actions and Filters
add_action('admin_menu','sh_email_alert_menu');
add_action('wp_head','sh_email_alert_script');
add_action('init','sh_email_alert_init');
register_activation_hook(__FILE__,'set_sh_email_alert_options');
register_deactivation_hook(__FILE__,'unset_sh_email_alert_options');

// Initial
function sh_email_alert_init(){
	// Add jQuery Script
	wp_enqueue_script('jquery');
	// Create table in database
	if(isset($_GET['activate']) && $_GET['activate'] == 'true'):
		global $wpdb;
		$result = mysql_list_tables(DB_NAME);
		$current_tables = array();
		while($row = mysql_fetch_array($result)):
			$current_tables[] = $row[0];
		endwhile;
		// create email alert table
		if(!in_array('sh_email_alert',$current_tables)):
			$result = mysql_query('CREATE TABLE sh_email_alert (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), job_title VARCHAR(255), company VARCHAR(255), country VARCHAR(255), email VARCHAR(255), mobile VARCHAR(255), pubtime DATETIME)');
		endif;
	endif;
}

// Set Option values
function set_sh_email_alert_options(){
	add_option('sh_email_alert_success', 'Email Alert was subscribed successfully. Thanks.');
	add_option('sh_email_alert_failed', 'Failed to subscribe. Please try later or contact administrator by other way.');
	add_option('sh_email_alert_required', 'Please fill the required field.');
	add_option('sh_email_alert_waiting', 'Please wait a moment.');
}

// Delete Option values
function unset_sh_email_alert_options(){
	delete_option('sh_email_alert_success');
	delete_option('sh_email_alert_failed');
	delete_option('sh_email_alert_required');
	delete_option('sh_email_alert_waiting');
}

// Admin Menu
function sh_email_alert_menu(){
	$tmp = basename(dirname(__FILE__)); // Plugin folder
	add_menu_page('SH Email Alert','SH Email Alert',8,$tmp.'/manage.php');
	add_submenu_page($tmp.'/manage.php','Email Alert Management','Manage',8,$tmp.'/manage.php');
	add_submenu_page($tmp.'/manage.php','Email Alert Options','Options',8,$tmp.'/options.php');
}

// Script
function sh_email_alert_script(){
	// Add jQuery Script
	wp_enqueue_script('jquery');
	echo '<!-- SH Email Alert Script -->
	<script type="text/javascript" src="'.SH_EMAIL_ALERT_PATH.'/jquery.form.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="'.SH_EMAIL_ALERT_PATH.'/sh-email-alert.css" />';
	echo "<script type='text/javascript'>
	jQuery(document).ready(function(){
	jQuery('.shea_form').ajaxForm({
		target:'.shea_msg',
		beforeSubmit:validate,
		success:function(){
			jQuery('.shea_msg').removeClass('error');
			jQuery('.shea_msg').removeClass('waiting');
			jQuery('.shea_msg').fadeIn('slow');
		}
	});
});

function validate(formData, jqForm, options){
	var bool = true;
	jQuery('.shea_form .required').each(function(){
		if(jQuery(this).fieldValue()==''){
			bool = false;
		}
	});
	jQuery('.shea_form select.required option:selected').each(function(){
		if(jQuery(this).text()==''){
			bool = false;
		}
	});
	if(bool){
		jQuery('.shea_msg').text('".get_option('sh_email_alert_waiting')."');
		jQuery('.shea_msg').removeClass('error');
		jQuery('.shea_msg').removeClass('waiting');
		jQuery('.shea_msg').addClass('waiting');
		jQuery('.shea_msg').fadeIn('slow');
		return true;
	}else{
		jQuery('.shea_msg').text('".get_option('sh_email_alert_required')."');
		jQuery('.shea_msg').removeClass('error');
		jQuery('.shea_msg').removeClass('waiting');
		jQuery('.shea_msg').addClass('error');
		jQuery('.shea_msg').fadeIn('slow');
		return false;
	}
}
</script>";
}

// Form
function sh_email_alert_form(){
	$countries = get_countries();
?>
	<form class="shea_form" action="<?php echo SH_EMAIL_ALERT_PATH; ?>/subscribe.php" method="post">
    	<p><label for="uname">Name</label><input type="text" id="uname" name="uname" class="shea_field required"> *</p>
        <p><label for="jtitle">Job Title</label><input type="text" id="jtitle" name="jtitle" class="shea_field required"> *</p>
        <p><label for="company">Company</label><input type="text" id="company" name="company" class="shea_field required"> *</p>
        <p><label for="country">Country</label>
        	<select id="country" name="country">
            <?php foreach($countries as $country): ?>
            <?php if($country == 'Singapoer'): ?>
            	<option value="<?php echo $country; ?>" selected><?php echo $country; ?></option>
            <?php else: ?>
            	<option value="<?php echo $country; ?>"><?php echo $country; ?></option>
            <?php endif; ?>
            <?php endforeach; ?>
            </select> *
        </p>
        <p><label for="email">Email</label><input type="text" id="email" name="email" class="shea_field required"> *</p>
        <p><label for="mobile">Mobile</label><input type="text" id="mobile" name="mobile" class="shea_field"></p>
        <p class="submit"><label>&nbsp;</label><input type="submit" name="submit" value="Subscribe" /></p>
        <div class="shea_msg"></div>
    </form>
<?php
}
// Short Code
function sh_email_alert_form_shortcode($atts, $content=null){
	$countries = get_countries();
	$result = '<form class="shea_form" action="'.SH_EMAIL_ALERT_PATH.'/subscribe.php" method="post"><p><label for="uname">Name</label><input type="text" id="uname" name="uname" class="shea_field required"> *</p><p><label for="jtitle">Job Title</label><input type="text" id="jtitle" name="jtitle" class="shea_field required"> *</p><p><label for="company">Company</label><input type="text" id="company" name="company" class="shea_field required"> *</p><p><label for="country">Country</label><select id="country" name="country">';
    foreach($countries as $country):
    	if($country == "Singapore"):
			$result .= '<option value="'.$country.'" selected>'.$country.'</option>';
        else:
            $result .= '<option value="'.$country.'">'.$country.'</option>';
        endif;
    endforeach;
	$result .= '</select> *</p><p><label for="email">Email</label><input type="text" id="email" name="email" class="shea_field required"> *</p><p><label for="mobile">Mobile</label><input type="text" id="mobile" name="mobile" class="shea_field"></p><p class="submit"><label>&nbsp;</label><input type="submit" name="submit" value="Subscribe" /></p><div class="shea_msg"></div></form>';
	return $result;
}
add_shortcode('sh_email_alert_form','sh_email_alert_form_shortcode');
?>