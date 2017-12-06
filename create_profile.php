<?php
require 'db.php';
$params = json_decode(file_get_contents('php://input'));


$profile_type = (string) $params->profile_type;

if ($profile_type == "candidate"){
	$username = (string) $params->new_username;
	$password = (string) $params->new_password;
	$first_name = (string) $params->new_first;
	$last_name = (string) $params->new_last;
	$cloc = (string) $params->new_cloc;
	$dloc = (string) $params->new_dloc;
	$job = (string) $params->new_job;
	$edu = (string) $params->new_edu;
	$major = (string) $params->new_major;
	$gpa = (double) $params->new_gpa;
	$sal = (int) $params->new_sal;
	$fun = (string) $params->new_fun;
	$skills = (string) $params->new_skills;

	// if any fields are empty, display error message
	if (empty($username) || empty($password) || empty($first_name) ||
	    empty($last_name) || empty($cloc) || empty($dloc) ||
	    empty($job) || empty($edu) || empty($major) || 
	    empty($gpa) || empty($sal) || empty($fun) || empty($skills)
	    ){
	  echo json_encode(array(
	    "success" => false,
	    "message" => "error: empty field(s)"
	  ));
	  exit;
	}

	// if user's password is not the right length, display error message
	if (strlen($password) < 5){
		echo json_encode(array(
			"success" => false,
			"message" => "error: password length"
		));
		exit;
	}

	// check if username is already in candidates database
	$stmt = $mysqli->prepare("SELECT username FROM candidates WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($existing_usernames);
	$stmt->fetch();
	$stmt->close();

	// if username already exists, display error message
	if (sizeof($existing_usernames) > 0){
		echo json_encode(array(
			"success" => false,
			"message" => "error: username already exists"
		));
		exit;
	}

	// check if username is already in jobs database
	$stmt = $mysqli->prepare("SELECT username FROM jobs WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($existing_usernames);
	$stmt->fetch();
	$stmt->close();

	// if username already exists, display error message
	if (sizeof($existing_usernames) > 0){
		echo json_encode(array(
			"success" => false,
			"message" => "error: username already exists"
		));
		exit;
	}


	// insert username and hashed password into database
	$pwd_hash = password_hash($password, PASSWORD_BCRYPT);
	$stmt = $mysqli->prepare("INSERT INTO candidates (first_name, last_name, username, password, current_location, desired_location, most_recent_job, education, major, gpa, skills, salary, fun_fact) VALUES (?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?)");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('sssssssssdsis', $first_name, $last_name, $username, $pwd_hash, $cloc, $dloc, $job, $edu, $major, $gpa, $skills, $sal, $fun);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
	    "success" => true,
	    "message" => "success"
	  ));
	exit;

}

else{

	$username = (string) $params->new_username;
	$password = (string) $params->new_password;
	$name = (string) $params->new_name;
	$loc = (string) $params->new_loc;
	$title = (string) $params->new_title;
	$industry = (string) $params->new_industry;
	$sal = (int) $params->new_sal;
	$desc = (string) $params->new_desc;
	$skills = (string) $params->new_skills;
 	
	// if any fields are empty, display error message
	if (empty($username) || empty($password) || empty($name) ||
	   	empty($loc) || empty($title) ||
	    empty($industry) || empty($sal) || empty($desc) || empty($skills)
	    ){
	  echo json_encode(array(
	    "success" => false,
	    "message" => "error: empty field(s)"
	  ));
	  exit;
	}

	// if user's password is not the right length, display error message
	if (strlen($password) < 5){
		echo json_encode(array(
			"success" => false,
			"message" => "error: password length"
		));
		exit;
	}

	// check if username is already in jobs database
	$stmt = $mysqli->prepare("SELECT username FROM jobs WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($existing_usernames);
	$stmt->fetch();
	$stmt->close();

	// if username already exists, display error message
	if (sizeof($existing_usernames) > 0){
		echo json_encode(array(
			"success" => false,
			"message" => "error: username already exists"
		));
		exit;
	}

	// check if username is already in candidates database
	$stmt = $mysqli->prepare("SELECT username FROM candidates WHERE username=?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($existing_usernames);
	$stmt->fetch();
	$stmt->close();

	// if username already exists, display error message
	if (sizeof($existing_usernames) > 0){
		echo json_encode(array(
			"success" => false,
			"message" => "error: username already exists"
		));
		exit;
	}

	// insert username and hashed password into database
	$pwd_hash = password_hash($password, PASSWORD_BCRYPT);
	$stmt = $mysqli->prepare("INSERT INTO jobs (company_name, username, password, location, title, industry, skills, salary, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('sssssssis', $name, $username, $pwd_hash, $loc, $title, $industry, $skills, $sal, $desc);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
	    "success" => true,
	    "message" => "success"
	  ));
	exit;
}



?>