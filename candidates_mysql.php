<?php
$mysqli = new mysqli('localhost', 'admin', 'admin_pass', 'netwerk');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

// retrieve all candidates
$stmt = $mysqli->prepare("SELECT first_name, last_name, current_location, desired_location, most_recent_job, education, major, gpa, skills, salary, fun_fact FROM candidates");
if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => "Query Prep Failed"
	));
	exit;
}
$stmt->execute();
$candidates = $stmt->get_result();
// $candidates_send = array();
// while($candidate = $candidates->fetch_assoc()){
// 	$candidates_send[] = $candidate['event_time'].": ".$event['event_name'];
// }
// $stmt->close();


echo json_encode(array(
	"success" => true,
	"data" => $candidates
));

// if events exist, send data to javascript
// if (sizeof($events_send)!= 0){
// 	echo json_encode(array(
// 	"success" => true,
// 	"date_id" => $date_id,
// 	"events" => $events_send
// 	));
// 	exit;
// } 
// else{
// 	echo json_encode(array(
// 		"success" => true,
// 		"date_id" => $date_id,
// 		"events" => ""
// 	));
// 	exit;
// }

?>