<?php

require 'db.php';
$params = json_decode(file_get_contents('php://input'));
$profile_type = (string) $params->profile_type;
$username = (string) $params->username;
$password = (string) $params->password;

// if any fields are empty, display error message
if (empty($username) || empty($password) || empty($profile_type)){
  echo json_encode(array(
    "success" => false,
    "message" => "error: empty field(s)"
  ));
  exit;
}

if ($profile_type == "candidate"){
	// get hashed password database
	$stmt = $mysqli->prepare("SELECT password FROM candidates WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($pwd_hash);
	$stmt->fetch();
	$stmt->close();
}
else{
	// get hashed password from jobs database
	$stmt = $mysqli->prepare("SELECT password FROM jobs WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($pwd_hash);
	$stmt->fetch();
	$stmt->close();
}


// Compare the submitted password to the actual password hash
if(password_verify($password, $pwd_hash)){
	ini_set("session.cookie_httponly", 1);
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['profile_type'] = $profile_type;
	// $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
	echo json_encode(array(
		"success" => true,
		"user" => $username,
	));
	exit;
}
else{
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}

?>