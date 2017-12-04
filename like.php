<?php
require 'db.php';
$params = json_decode(file_get_contents('php://input'));
$liked = (string) $params->liked;
$liker = (string) $params->liker;

// insert like into table
$stmt = $mysqli->prepare("INSERT INTO likes (liker, liked) VALUES (?, ?)");
  if(!$stmt){
    echo json_encode(array(
      "success" => false,
      "message" => "Query Prep Failed"
    ));
    exit;
  }
  $stmt->bind_param('ss', $liker, $liked);
  $stmt->execute();
  $stmt->close();

echo json_encode(array(
    "success" => true
  ));
exit;

?>