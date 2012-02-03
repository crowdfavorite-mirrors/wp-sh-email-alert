<style>
form.search_mail{
	display:block;
	float:right;
}
ul.sh_email_alert_nav{
	display:block;
	float:right;
}
ul.sh_email_alert_nav li{
	display:inline;
	float:left;
	padding:5px;
}
ul.sh_email_alert_nav li a{
	text-decoration:none;
}
ul.sh_email_alert_nav li.current_page a{
	color:#000;
}
</style>
<script>
	function ch_del(i){
		var q = confirm('Do you want to delete ID '+i+' ?');
		if(q){
			return true;
		}else{
			return false;
		}
	}
</script>
<?php 
	global $wpdb;
	include_once('functions.php');
	$countries = get_countries();
	switch($_GET['action']):
		case 'add':
			$result = sh_email_alert_add();
			if($result){
				echo '<div id="message" class="updated fade">Added</div>';
			}else{
				echo '<div id="message" class="updated fade">Not added</div>';
			}
		break;
		case 'upgrade':
			$result = sh_email_alert_update($_POST['mid']);
			if($result){
				echo '<div id="message" class="updated fade">Update Successful.</div>';
			}else{
				echo '<div id="message" class="updated fade">Update Not Successful.</div>';
			}
		break;
		case 'delete':
			$result = sh_email_alert_delete($_GET['mid']);
			if($result){
				echo '<div id="message" class="updated fade">Deleted</div>';
			}else{
				echo '<div id="message" class="updated fade">Not deleted</div>';
			}
		break;
	endswitch;
?>
<div class="wrap" id="top">
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
    <h2>Email Alert Management</h2>
    
    <h3>Mailing Lists <a class="button add-new-h2" href="#add">Add New</a> <a class="button add-new-h2" href="<?php echo SH_EMAIL_ALERT_PATH; ?>/excel.php">Export Mailing Lists</a>
    <form name="search" class="search_mail" method="post">
    	<input type="text" name="sh_mail_alert_s" class="medium-text" />
        <input type="submit" class="button" value="Search by Email" />
    </form></h3>
    <table class="widefat">
    	<thead>
        	<tr>
            	<th>ID</th>
                <th>Name</th>
                <th>Job Title</th>
                <th>Company</th>
                <th>Country</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Subscribe Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$pagesize = 20;
			$linksize = 5;
			require_once('pager.php');
			$page = new page();
			if(isset($_POST['sh_mail_alert_s'])):
				$page->sql = 'select * from sh_email_alert where email like "'.$_POST['sh_mail_alert_s'].'" order by id ASC';
			else:
				$page->sql = 'select * from sh_email_alert order by id ASC';
			endif;
			$page->pagesize = $pagesize;
			$page->linksize = $linksize;
			$page->init();
			$start = $page->start;
			$current_page = $page->current_page;
			$url = $page->get_page_link($current_page);
			if(stristr($_SERVER['QUERY_STRING'],'action=')):
				$url = str_replace('&action='.$_GET['action'],'',$url);
			endif;
			$mails = $wpdb->get_results($page->sql.' limit '.$start.','.$pagesize);
			if (empty($mails)):
				echo '<tr><td colspan="9">No Mailing Lists found.</td><tr>';
			else:
			foreach($mails as $mail):
		?>
        	<tr>
            	<td><?php echo $mail->id; ?></td>
                <td><?php echo $mail->name; ?></td>
                <td><?php echo $mail->job_title; ?></td>
                <td><?php echo $mail->company; ?></td>
                <td><?php echo $mail->country; ?></td>
                <td><?php echo $mail->email; ?></td>
                <td><?php echo $mail->mobile; ?></td>
                <td><?php echo $mail->pubtime; ?></td>
                <td><a href="<?php echo $url; ?>&action=update&mid=<?php echo $mail->id; ?>#add" title="Update">Update</a> / <a href="<?php echo $url; ?>&action=delete&mid=<?php echo $mail->id; ?>" title="Delete" onclick="javascript: return ch_del(<?php echo $mail->id; ?>)">Delete</a></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
    <?php
		$page->show_pager();
		if($_GET['action'] == 'update'):
			$updates = $wpdb->get_results('select * from sh_email_alert where id='.$_GET['mid']);
			foreach($updates as $update):
				$uname = $update->name;
				$jtitle = $update->job_title;
				$company = $update->company;
				$ucountry = $update->country;
				$email = $update->email;
				$mobile = $update->mobile;
			endforeach;
			$action = 'upgrade';
			$button = 'Update';
		else:
			$action = 'add';
			$button = 'Add to List';
		endif;
	?>
    <h3 id="add">Add Mailing list</h3>
    <form id="mlist" name="mlist" action="<?php echo $url; ?>&action=<?php echo $action; ?>" method="post">
    	<input type="hidden" name="mid" value="<?php echo $_GET['mid']; ?>">
		<table class="form-table">
        	<tbody>
            	<tr>
                    <th scope="row"><label for="uname">Name</label></th>
                    <td><input type="text" id="uname" name="uname" value="<?php echo $uname; ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="jtitle">Job Title</label></th>
                    <td><input type="text" id="jtitle" name="jtitle" value="<?php echo $jtitle; ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="company">Company</label></th>
                    <td><input type="text" id="company" name="company" value="<?php echo $company; ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="country">Country</label></th>
                    <td>
                    	<select id="country" name="country">
                        <?php foreach($countries as $country): ?>
                        <?php if(($country == $ucountry) && ($ucountry !='')): ?>
                        	<option value="<?php echo $country; ?>" selected><?php echo $country; ?></option>
                        <?php elseif(($country == 'Singapore') && ($ucountry =='')): ?>
                        	<option value="<?php echo $country; ?>" selected><?php echo $country; ?></option>
                        <?php else: ?>
                        	<option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="email">Email</label></th>
                    <td><input type="text" id="email" name="email" value="<?php echo $email; ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mobile">Mobile</label></th>
                    <td><input type="text" id="mobile" name="mobile" value="<?php echo $mobile; ?>" class="regular-text"></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
    		<input type="submit" name="submit" value="<?php echo $button; ?>" />
    	</p>
	</form>
</div>