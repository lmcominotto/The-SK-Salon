<?php
	session_start();
	
	include 'dbh.php';
	//connect to database

	if(isset($_POST['deleteCarousel'])) {
		$delete_Img = $_POST['id'];

		//delete image from carousel
		$sql_One = "DELETE FROM carousel WHERE ID = '$delete_Img'";
		$result_One = mysqli_query($conn, $sql_One);

		if($result_One) {
			header("Location: homepageAdmin.php?delete=success");
			exit();
		} else {
			header("Location: homepageAdmin.php?delete=failed");
			exit();
		}
	} else if(isset($_POST['deleteMain'])) {
		$delete_Post = $_POST['id'];

		//delete post from main content on page
		$sql_Two = "DELETE FROM homePage WHERE ID = '$delete_Post'";
		$result_Two = mysqli_query($conn, $sql_Two);

		if($result_Two) {
			header("Location: homepageAdmin.php?delete=success");
			exit();
		} else {
			header("Location: homepageAdmin.php?delete=failed");
			exit();
		}
	} else if (isset($_POST['deleteContact'])) {
		$delete_Info = $_POST['id'];

		//delete contact information on page
		$sql_Three = "DELETE FROM contactHome WHERE ID = '$delete_Info'";
		$result_Three = mysqli_query($conn, $sql_Three);

		if($result_Three) {
			header("Location: homepageAdmin.php?delete=success");
			exit();
		} else {
			header("Location: homepageAdmin.php?delete=failed");
			exit();
		}
	}

?>