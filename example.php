<?php
	require_once "functions.php";
	$do = new DigitalOcean("client_id", "api_key");
	$response = $do->droplets();
	
	print_r($response);

?>