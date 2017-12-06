<?php
require 'db.php';
$params = json_decode(file_get_contents('php://input'));


$profile_type = (string) $params->profile_type;

if ($profile_type == "candidate"){
	$username = (string) $params->username;
	$password = (string) $params->password;
	$first_name = (string) $params->first;
	$last_name = (string) $params->last;
	$cloc = (string) $params->cloc;
	$dloc = (string) $params->dloc;
	$job = (string) $params->job;
	$edu = (string) $params->edu;
	$major = (string) $params->major;
	$gpa = (double) $params->gpa;
	$sal = (int) $params->sal;
	$fun = (string) $params->fun;
	$skills = (string) $params->skills;


	// if any fields are empty, display error message
	if (empty($password)||empty($first_name) ||
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


	// modify profile into candidates db
	$pwd_hash = password_hash($password, PASSWORD_BCRYPT);
	$stmt = $mysqli->prepare("UPDATE candidates SET password = ?, first_name = ?, last_name = ?, current_location = ?, desired_location = ?, most_recent_job = ?, education = ?, major = ?, gpa = ?, skills = ?, salary = ?, fun_fact = ? WHERE username = ?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('ssssssssdsiss', $pwd_hash, $first_name, $last_name, $cloc, $dloc, $job, $edu, $major, $gpa, $skills, $sal, $fun, $username);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
	    "success" => true,
	    "username" => $username,
		"first_name"=> $first_name,
		"last_name"=> $last_name,
		"education"=>$edu,
		"major"=>$major,
		"gpa"=>$gpa,
		"current_location"=>$cloc,
		"location"=>$dloc,
		"most_recent_job"=>$most_recent_job,
		"salary"=>$sal,
		"skills"=>$skills,
		"fun_fact"=>$fun
	  ));
	exit;

}

else{

	$username = (string) $params->username;
	$password = (string) $params->password;
	$name = (string) $params->name;
	$loc = (string) $params->loc;
	$title = (string) $params->title;
	$industry = (string) $params->industry;
	$sal = (int) $params->sal;
	$desc = (string) $params->desc;
	$skills = (string) $params->skills;
 	
	// if any fields are empty, display error message
	if (empty($password) || empty($name) ||
	   	empty($loc) || empty($title) ||
	    empty($industry) || empty($sal) || empty($desc) || empty($skills)
	    ){
	  echo json_encode(array(
	    "success" => false,
	    "message" => "error: empty field(s)"
	  ));
	  exit;
	}

	// modify profile in jobs db
	$pwd_hash = password_hash($password, PASSWORD_BCRYPT);
	$stmt = $mysqli->prepare("UPDATE jobs SET password = ?, company_name = ?,  location = ?, title = ?, industry = ?, skills = ?, salary = ?, description =? WHERE username = ?");
	if(!$stmt){
		echo json_encode(array(
			"success" => false,
			"message" => "Query Prep Failed"
		));
		exit;
	}
	$stmt->bind_param('ssssssiss', $pwd_hash, $name, $loc, $title, $industry, $skills, $sal, $desc, $username);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
	    "success" => true,
	   	"username" => $username,
		"company_name"=> $name,
		"industry"=>$industry,
		"title"=>$title,
		"location"=>$loc,
		"skills"=>$skills,
		"salary"=>$sal,
		"description"=>$desc
	  ));
	exit;
}



?>