<?php
require 'db.php';

// retrieve all candidates
$stmt = $mysqli->prepare("SELECT first_name, last_name, username, current_location, desired_location, most_recent_job, education, major, gpa, skills, salary, fun_fact FROM candidates");
if(!$stmt){
	echo json_encode(array(
		"success" => false,	
		"message" => "Query Prep Failed"
	));
	exit;
}
$stmt->execute();
$candidates = $stmt->get_result();

// set up json of candidates from query result
$candidates_send = array();
$index = 0;
while($candidate = mysqli_fetch_assoc($candidates))
{
  $candidates_send[$index]['first_name'] = $candidate['first_name'];
  $candidates_send[$index]['last_name']  = $candidate['last_name'];
  $candidates_send[$index]['username'] = $candidate['username'];
  $candidates_send[$index]['current_location'] = $candidate['current_location'];
  $candidates_send[$index]['desired_location'] = $candidate['desired_location'];
  $candidates_send[$index]['most_recent_job'] = $candidate['most_recent_job'];
  $candidates_send[$index]['education'] = $candidate['education'];
  $candidates_send[$index]['major'] = $candidate['major'];
  $candidates_send[$index]['gpa'] = $candidate['gpa'];
  $candidates_send[$index]['skills'] = $candidate['skills'];
  $candidates_send[$index]['salary'] = $candidate['salary'];
  $candidates_send[$index]['fun_fact'] = $candidate['fun_fact'];

  $index++;
}

// send json of candidates
echo json_encode(array(
	"success" => true,
	"candidates" => $candidates_send
));

?>