<?php
	//must assure every single page in website has this!
	session_start();
	
	//connect to database
	include 'dbh.php';
	
	// Check if image file is a actual image
	if(isset($_POST['deletePhoto'])) {
		$delete_Photo = $_POST['id'];

		//delete image from carousel
		$sql = "DELETE FROM photoGallery WHERE ID = '$delete_Photo'";
		$result = mysqli_query($conn, $sql);

		if($result) {
			header("Location: photoAdmin.php?delete=success");
		} else {
			header("Location: photoAdmin.php?delete=failed");
		}
	}

?>