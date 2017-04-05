<?php
	session_start();
	//must assure every single page in website has this!
	
	include 'dbh.php';
	//connect to database


	//check if id is in URL and check it's valid
	if(isset($_GET['id']) && is_numeric($_GET['id'])) {
		$delete_id = $_GET['id'];

		//delete entry
		$sql = "DELETE FROM siteUser WHERE id = '$delete_id'";
		$result = mysqli_query($conn, $sql);
		header("Location: viewUsers.php?delete=success");
	} else {
		header("Location: viewUsers.php?delete=failed");
	}

?>