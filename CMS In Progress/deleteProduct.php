<?php
	session_start();
	//must assure every single page in website has this
	
	include 'dbh.php';
	//connect to database

	
	if(isset($_POST['delete'])) {
		
		$delete_Product = $_POST['id'];

		$sql = "DELETE FROM products WHERE ID = '$delete_Product'";
		$result = mysqli_query($conn, $sql);

		if($result) {
			header("Location: productAdmin.php?delete=success");
		} else {
			header("Location: productAdmin.php?delete=failed");
		}
	} else {
		header("Location: productAdmin.php?record=unavailable");
	}
?>