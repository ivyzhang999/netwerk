<?php

	$params = json_decode(file_get_contents('php://input'));
	$username = (string) $params->username;
	$filename = (string) $params->file;
	$filename = basename($filename);

		// // Make sure filename is valid
		// if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
		// 	echo htmlentities("Invalid filename");
		// 	echo ("<form action=\"fileSharing.php\" method=\"GET\">
		// 	<input type = \"hidden\" name =\"username\" value = $username />
		// 	<input type=\"submit\" value=\"go back\" />
		// 	</form>");
		// 	exit;
		// }

		// // Make sure username is valid
		// if( !preg_match('/^[\w_\-]+$/', $username) ){
		// 	echo htmlentities("Invalid username");
		// 	echo "<form action=\"fileSharing.php\" method=\"GET\">
		// 	<input type = \"hidden\" name =\"username\" value = $username />
		// 	<input type=\"submit\" value=\"go back\" />
		// 	</form>";
		// 	exit;
		// }

	// upload file
	$full_path = sprintf("/home/ivy.zhang/%s/%s", $username, $filename);
	if( move_uploaded_file($filename, $full_path) ){
		echo json_encode(array(
			"success" => True,
			"message" => "upload success!"
		));
		exit;
	}
	// else{
	// 	header("Location: upload_failure.php?username=$username");
	// 	exit;
	// }
?>