<?php
	session_start();
	
	include 'dbh.php';
	//connect to database

	//check if id is in URL and check it's valid
	if(isset($_GET['id']) && is_numeric($_GET['id'])) {
		$delete_id = $_GET['id'];

		//delete entry
		$sql = "DELETE FROM siteUser WHERE id = '$delete_id'";
		$result = mysqli_query($conn, $sql);

		if($result) {
			header("Location: viewUsers.php?delete=success");
			exit();
		} else {
			header("Location: viewUsers.php?delete=failed");
			exit();
		}
	} else {
		header("Location: viewUsers.php?record=unavailable");
		exit();
	}

?>