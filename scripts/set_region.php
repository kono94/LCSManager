<?php
$user_logged = session_name("user_logged");
// session_set_cookie_params(1800, '/kappabets', 'gamedots.de');
session_start();

$region_id = (int)$_POST["region_id"];
if($region_id === 1 || $region_id === 0){	
	$_SESSION["region"] = $region_id;		
	setcookie("region",$region_id,time()+3600*24*14,'/', 'lcsmanager.net');	
	$region_name = $region_id == 1 ? 'NA' : 'EU';
	$response = array("error" => false, "error_message" => "", "success_message" => "changed your current region to ".$region_name);
	echo json_encode($response);	
}else{
	$_SESSION["region"] = 0;		
	setcookie("region",0,time()+3600*24*14,'/', 'lcsmanager.net');	
	$response = array("error" => true, "error_message" => "something wierd happened, set region to EU", "success_message" => "");
	echo json_encode($response);	
}
?>