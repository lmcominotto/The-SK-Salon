<?php
	session_start();
	//must assure every single page in website has this!
	
	include 'dbh.php';
	//connect to database

	
	if(isset($_POST['delete'])) {
		
		$delete_Stylist = $_POST['id'];

		$sql = "DELETE FROM stylists WHERE ID = '$delete_Stylist'";
		$result = mysqli_query($conn, $sql);

		if($result) {
			header("Location: stylistsAdmin.php?delete=success");
		} else {
			header("Location: stylistsAdmin.php?delete=failed");
		}
	} else {
		header("Location: stylistsAdmin.php?record=unavailable");
	}
?>