<?php
include_once('../../../wp-config.php');
include_once('../../../wp-load.php');
include_once('../../../wp-includes/wp-db.php');
global $wpdb;
$filename="sh_mailing_lists.xls"; 
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

echo iconv("utf-8", "utf-8", "ID")."\t";
echo iconv("utf-8", "utf-8", "Name")."\t";
echo iconv("utf-8", "utf-8", "Job Title")."\t";
echo iconv("utf-8", "utf-8", "Company")."\t";
echo iconv("utf-8", "utf-8", "Country")."\t";
echo iconv("utf-8", "utf-8", "Email")."\t";
echo iconv("utf-8", "utf-8", "Mobile")."\t";
echo iconv("utf-8", "utf-8", "Subscribe Date")."\n";

$mails = $wpdb->get_results('select * from sh_email_alert');
foreach($mails as $mail):
	echo iconv("utf-8", "utf-8", $mail->id)."\t";
	echo iconv("utf-8", "utf-8", $mail->name)."\t";
	echo iconv("utf-8", "utf-8", $mail->job_title)."\t";
	echo iconv("utf-8", "utf-8", $mail->company)."\t";
	echo iconv("utf-8", "utf-8", $mail->country)."\t";
	echo iconv("utf-8", "utf-8", $mail->email)."\t";
	echo iconv("utf-8", "utf-8", $mail->mobile)."\t";
	echo iconv("utf-8", "utf-8", $mail->pubtime)."\n";
endforeach;
?>