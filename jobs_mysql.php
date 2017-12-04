<?php
require 'db.php';

// retrieve all candidates
$stmt = $mysqli->prepare("SELECT company_name, username, location, title, industry, skills, salary, description FROM jobs");
if(!$stmt){
	echo json_encode(array(
		"success" => false,	
		"message" => "Query Prep Failed"
	));
	exit;
}
$stmt->execute();
$jobs = $stmt->get_result();

// set up json of jobs from query result
$jobs_send = array();
$index = 0;
while($job = mysqli_fetch_assoc($jobs))
{
  $jobs_send[$index]['company_name'] = $job['company_name'];
  $jobs_send[$index]['username'] = $job['username'];
  $jobs_send[$index]['location'] = $job['location'];
  $jobs_send[$index]['title'] = $job['title'];
  $jobs_send[$index]['industry'] = $job['industry'];
  $jobs_send[$index]['skills'] = $job['skills'];
  $jobs_send[$index]['salary'] = $job['salary'];
  $jobs_send[$index]['description'] = $job['description'];

  $index++;
}

// send json of jobs
echo json_encode(array(
	"success" => true,
	"jobs" => $jobs_send
));

?>