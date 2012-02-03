<?php
// Get Country lists
function get_countries(){
	$countries_name = "Afghanistan,Albania,Algeria,American Samoa,Andorra,Angola,Anguilla,Antarctica,Antarctica French Southern territories,Antigua and Barbuda,Argentina,Armenia,Aruba,Australia,Austria,Azerbaijan,Bahamas,Bahrain,Bangladesh,Barbados,Belarus,Belgium,Belize,Benin,Bermuda,Bhutan,Bolivia,Bosnia and Herzegovina,Botswana,Bouvet Island,Brazil,British Indian Ocean Territory,Bulgaria,Burkina Faso,Burundi,Brunei,Cambodia,Cameroon,Canada,Cape Verde,Cayman Islands,Central African Republic,Chad,Cocos (Keeling) Islands,Chile,China,Christmas Island,Colombia,Comoros,Congo Democratic Republic,Congo,Cook Islands,Costa Rica,Cote d'Ivoire,Croatia,Cuba,Cyprus,Czech Republic,Denmark,Djibouti,Dominica,Dominican Republic,East Timor,Ecuador,Egypt,El Salvador,Eritrea,Equatorial Guinea,Estonia,Ethiopia,Falkland Islands,Faroe Islands,Fiji,Fiji Islands,Finland,France,French Guiana,French Polynesia,Gabon,Gambia,Germany,Georgia,Ghana,Gibraltar,Greece,Greenland,Grenada,Guadeloupe,Guam,Guatemala,Guinea,Guinea-Bissau,Guyana,Haiti,Heard Island and McDonald Islands,Honduras,Hong Kong,Hungary,Iceland,India,Indonesia,Iran,Iraq,Ireland,Israel,Italy,Jamaica,Japan,Jordan,Kazakstan,Kenya,Kiribati,Kuwait,Kyrgyzstan,Laos,Latvia,Lebanon,Lesotho,Liechtenstein,Liberia,Libyan Arab Jamahiriya,Lithuania,Luxembourg,Macao,Macedonia,Madagascar,Malawi,Malaysia,Maldives,Mali,Malta,Marshall Islands,Mauritania,Mauritius,Martinique,Mayotte,Mexico,Micronesia Federated States of,Moldova,Monaco,Mongolia,Montserrat,Morocco,Mozambique,Myanmar,Namibia,Nauru,Nepal,Netherlands,Netherlands Antilles,New Caledonia,New Zealand,Nicaragua,Niger,Nigeria,Niue,Norfolk Island,Northern Mariana Islands,North Korea,Norway,Oman,Pakistan,Palestine,Palau,Panama,Papua New Guinea,Paraguay,Peru,Philippines,Pitcairn,Poland,Portugal,Puerto Rico,Qatar,Reunion,Romania,Russian Federation,Rwanda,Saint Helena,Saint Kitts and Nevis,Saint Pierre and Miquelon,Saint Lucia,Saint Vincent and the Grenadines,Sao Tome and Principe,Samoa,San Marino,Saudi Arabia,Senegal,Seychelles,Sierra Leone,Singapore,Slovakia,Slovenia,Solomon Islands,South Africa,South Georgia and the South Sandwich Islands,South Korea,Somalia,Spain,Sri Lanka,Sudan,Suriname,Svalbard and Jan Mayen,Swaziland,Sweden,Switzerland,Syria,Taiwan,Tanzania,Tajikistan,Thailand,Tokelau,Togo,Tonga,Trinidad and Tobago,Tunisia,Turkey,Turkmenistan,Turks and Caicos Islands,Tuvalu,Uganda,United Arab Emirates,United Kingdom,United States Minor Outlying Islands,United States,Ukraine,Uruguay,Uzbekistan,Vanuatu,Vatican Holy See (Vatican City State),Venezuela,Vietnam,Virgin Islands GB,Virgin Islands U.S.,Wallis and Futuna,Western Sahara,Yemen,Yugoslavia,Zambia,Zimbabwe";
	$countries = split(',',$countries_name);
	return $countries;
}
// Add to mailing list
function sh_email_alert_add(){
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
	return $result;
}
// Update
function sh_email_alert_update($id){
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
	$sql = 'update sh_email_alert set name="'.$uname.'", job_title="'.$jtitle.'", company="'.$company.'", country="'.$country.'", email="'.$email.'", mobile="'.$mobile.'", pubtime="'.$today.'" where id = '.$id;
	$result = $wpdb->query($sql);
	return $result;
}
// Delete
function sh_email_alert_delete($id){
	global $wpdb;
	$sql = 'delete from sh_email_alert where id = '.$id;
	$result = $wpdb->query($sql);
	return $result;
}

?>