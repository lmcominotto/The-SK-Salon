<?php
	session_start();
	
	include 'dbh.php';
	//connect to database
	
	if(isset($_POST['deleteImg'])) {
		
		$delete_Img = $_POST['id'];

		$sql_One = "DELETE FROM services WHERE ID = '$delete_Img'";
		$result_One = mysqli_query($conn, $sql_One);

		if($result_One) {
			header("Location: servicesAdmin.php?delete=success");
			exit();
		} else {
			header("Location: servicesAdmin.php?delete=failed");
			exit();
		}
	} 
	else if(isset($_POST['deleteService'])) {
		$delete_Service = $_POST['id'];

		$sql_Two = "DELETE FROM services WHERE ID = '$delete_Service'";
		$result_Two = mysqli_query($conn, $sql_Two);

		if($result_Two) {
			header("Location: servicesAdmin.php?delete=success");
			exit();
		} else {
			header("Location: servicesAdmin.php?delete=failed");
			exit();
		}
	}
?>