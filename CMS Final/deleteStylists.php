<?php
	session_start();
	
	include 'dbh.php';
	//connect to database

	if(isset($_POST['delete'])) {
		
		$delete_Stylist = $_POST['id'];

		$sql = "DELETE FROM stylists WHERE ID = '$delete_Stylist'";
		$result = mysqli_query($conn, $sql);

		if($result) {
			header("Location: stylistsAdmin.php?delete=success");
			exit();
		} else {
			header("Location: stylistsAdmin.php?delete=failed");
			exit();
		}
	} else {
		header("Location: stylistsAdmin.php?record=unavailable");
		exit();
	}
?>