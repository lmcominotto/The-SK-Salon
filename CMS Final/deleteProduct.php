<?php
	session_start();
	
	include 'dbh.php';
	//connect to database

	
	if(isset($_POST['delete'])) {
		
		$delete_Product = $_POST['id'];

		$sql = "DELETE FROM products WHERE ID = '$delete_Product'";
		$result = mysqli_query($conn, $sql);

		if($result) {
			header("Location: productAdmin.php?delete=success");
			exit();
		} else {
			header("Location: productAdmin.php?delete=failed");
			exit();
		}
	} else {
		header("Location: productAdmin.php?record=unavailable");
		exit();
	}
?>