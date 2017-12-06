<?php
$params = json_decode(file_get_contents('php://input'));
$desired_location = (string) $params->location;
$url = "https://jobs.github.com/positions.json?location=".$desired_location;
	ini_set("allow_url_fopen", 1);
	$json = file_get_contents($url);
	$jobdata = json_decode($json);

	$index = rand(0, count($jobdata)-1);
	$jobtitle= $jobdata[$index]->title;
	$joblocation = $jobdata[$index]->location;
	$jobcompany = $jobdata[$index]->company;
	if (count($jobdata)<1){
		echo json_encode(array(
		"suggestion" => "No jobs found in your desired location!!"
		));
		exit;
	}else{
		echo json_encode(array(
			"suggestion" => $jobtitle." - ".$joblocation." - ".$jobcompany
		));
		exit;
}
?>