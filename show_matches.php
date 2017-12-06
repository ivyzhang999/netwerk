<?php
require 'db.php';

session_start();
$params = json_decode(file_get_contents('php://input'));
$username = $_SESSION['username'];

// retrieve all rows with username as liker
$stmt = $mysqli->prepare("SELECT liker, liked FROM likes WHERE liker =?");
if(!$stmt){
	echo json_encode(array(
		"success" => false,	
		"message" => "Query Prep Failed"
	));
	exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$likes = $stmt->get_result();
$stmt->close();

// retrieve all rows with username as liked
$stmt = $mysqli->prepare("SELECT liker, liked FROM likes WHERE liked =?");
if(!$stmt){
  echo json_encode(array(
    "success" => false, 
    "message" => "Query Prep Failed"
  ));
  exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$liked = $stmt->get_result();
$stmt->close();

$matches_send = array();
$liked_rows = array();
$liker_rows = array();
// check for matches
while($row_likes = mysqli_fetch_assoc($likes)){
  $liked_rows[] = $row_likes['liked'];
}


while($row_liked = mysqli_fetch_assoc($liked)){
  $liker_rows[] = $row_liked['liker'];  
}

for ($i = 0; $i < sizeof($liked_rows); $i++){
    if (in_array($liked_rows[$i], $liker_rows)){
      $matches_send[] = $liked_rows[$i];
    }
}

// send json of matches
echo json_encode(array(
	"success" => true,
	"matches" => $matches_send
));

?>