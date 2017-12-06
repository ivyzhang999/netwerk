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
	$stmt = $mysqli->prepare("SELECT password, first_name, last_name, education, gpa, major, skills, current_location, desired_location, most_recent_job, salary, fun_fact FROM candidates WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($pwd_hash, $first_name, $last_name, $education, $gpa, $major, $skills, $current_location, $desired_location, $most_recent_job, $salary, $fun_fact);
	$stmt->fetch();
	$stmt->close();

	// Compare the submitted password to the actual password hash
	if(password_verify($password, $pwd_hash)){
		ini_set("session.cookie_httponly", 1);
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['profile_type'] = $profile_type;
		// $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
		echo json_encode(array(
			"success" => true,
			"username" => $username,
			"first_name"=> $first_name,
			"last_name"=> $last_name,
			"education"=>$education,
			"major"=>$major,
			"gpa"=>$gpa,
			"current_location"=>$current_location,
			"location"=>$desired_location,
			"most_recent_job"=>$most_recent_job,
			"salary"=>$salary,
			"skills"=>$skills,
			"fun_fact"=>$fun_fact

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

	
}
else{
	// get hashed password from jobs database
	$stmt = $mysqli->prepare("SELECT password, company_name, location, title, industry, skills, salary, description FROM jobs WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($pwd_hash, $company_name, $location, $title, $industry, $skills, $salary, $description);
	$stmt->fetch();
	$stmt->close();
	
	// Compare the submitted password to the actual password hash
	if(password_verify($password, $pwd_hash)){
		ini_set("session.cookie_httponly", 1);
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['profile_type'] = $profile_type;
		echo json_encode(array(
			"success" => true,
			"username" => $username,
			"company_name"=> $company_name,
			"industry"=>$industry,
			"title"=>$title,
			"location"=>$location,
			"skills"=>$skills,
			"salary"=>$salary,
			"description"=>$description
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
	
}

?>