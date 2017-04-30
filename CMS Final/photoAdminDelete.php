<?php
	//must assure every single page in website has this
	session_start();
	
	//connect to database
	include 'dbh.php';
	
	// Check if image file is a actual image
	if(isset($_POST['deletePhoto'])) {
		$delete_Photo = $_POST['check'];

		//delete image from carousel
		foreach ($delete_Photo as $ID) {
			$sql = "DELETE FROM photoGallery WHERE ID = '$ID'";
			$result = mysqli_query($conn, $sql);
		}

		if($result) {
			header("Location: photoAdmin.php?delete=success");
			exit();
		} else {
			header("Location: photoAdmin.php?delete=failed");
			exit();
		}
	}

?>