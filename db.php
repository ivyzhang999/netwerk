<?php
$mysqli = new mysqli('localhost', 'admin', 'admin_pass', 'netwerk');

if($mysqli->connect_errno) {
	echo json_encode(array(
		"success" => false,	
		"message" => "Connection failed"
	));
	exit;
}
?>