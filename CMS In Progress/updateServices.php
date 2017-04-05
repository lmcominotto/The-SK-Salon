<?php
	session_start();
	//must assure every single page in website has this
	
	include 'dbh.php';
	//connect to database

	if(isset($_POST['updateService'])) {
		//update text only post 
		
		$edit_Service = $_POST['id'];
		$serviceTitle = $_POST['serviceTitle'];
		$serviceInfo = $_POST['serviceInfo'];

		$sql = "UPDATE services SET serviceTitle = '$serviceTitle', serviceInfo = '$serviceInfo' WHERE ID = '$edit_Service'";

		if(mysqli_query($conn, $sql)) {
			header("Location: servicesAdmin.php?edit=success");
			exit();
		} else {
			header("Location: servicesAdmin.php?edit=failed");
			exit();
		}
	} else if (isset($_POST['updateImg'])) {
		//update image post

		$edit_Service = $_POST['id'];
		$target = "img/".basename($_FILES['serviceImg']['name']);
		$serviceImgTmp = addslashes($_FILES['serviceImg']['tmp_name']);
		$serviceImg = addslashes($_FILES['serviceImg']['name']);
		$img_size = getimagesize($_FILES['serviceImg']['tmp_name']);

		if($img_size == FALSE) {
			header("Location: servicesAdmin.php?error=file");
			exit();
		} else {
			$sql = "UPDATE services SET serviceInfo = '$serviceImg' WHERE ID = '$edit_Service' ";
		}

		if(!mysqli_query($conn, $sql)) {
			header("Location: servicesAdmin.php?edit=failed");
			exit();
		}

		//check whether file has been moved to image file
		if(!move_uploaded_file($_FILES['serviceImg']['tmp_name'], $target)) {
			header("Location: servicesAdmin.php?error=image");
			exit();
		} else {
			header("Location: servicesAdmin.php?edit=success");
			exit();
		} 

	} else {
		//record can't be found
		header("Location: servicesAdmin.php?record=unavailable");
		exit();
	}

?>