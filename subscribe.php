<?php
	include_once('../../../wp-config.php');
	include_once('../../../wp-load.php');
	include_once('../../../wp-includes/wp-db.php');
	global $wpdb;
	$uname = $_POST['uname'];
	$jtitle = $_POST['jtitle'];
	$company = $_POST['company'];
	$country = $_POST['country'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	// get today date
	$second=strtotime(date("H:i:s"))+(8*3600);
	$today=gmdate("Y-m-d H:i:s",$second);
	// query
	$sql = 'insert into sh_email_alert (name,job_title,company,country,email,mobile,pubtime) values ("'.$uname.'","'.$jtitle.'","'.$company.'","'.$country.'","'.$email.'","'.$mobile.'","'.$today.'")';
	$result = $wpdb->query($sql);
	if($result):
		echo get_option('sh_email_alert_success');
	else:
		echo get_option('sh_email_alert_failed');
	endif;
?>