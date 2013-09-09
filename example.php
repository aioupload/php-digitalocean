<?php
	require_once "functions.php";
	
	try {
		$do = new DigitalOcean("client_id", "api_key");
		$response = $do->droplets();
		print_r($response);	
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
?>