<?php
	session_start();
	
	include 'dbh.php';
	//connect to database

	//form validation
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if(isset($_POST['updateService'])) {
		//update text only post

		//from form 	
		$edit_Service = test_input($_POST['id']);
		$edit_Service = mysqli_real_escape_string($conn, $_POST['id']);
		$serviceTitle = test_input($_POST['serviceTitle']);
		$serviceTitle = mysqli_real_escape_string($conn, $_POST['serviceTitle']);
		$serviceInfo = test_input($_POST['serviceInfo']);
		$serviceInfo = mysqli_real_escape_string($conn, $_POST['serviceInfo']);

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

		//from form
		$edit_Service = test_input($_POST['id']);
		$edit_Service = mysqli_real_escape_string($conn, $_POST['id']);

		//path to store image
		$target = "img/".basename($_FILES['serviceImg']['name']);

		$serviceImgTmp = addslashes($_FILES['serviceImg']['tmp_name']);
		$serviceImg = addslashes($_FILES['serviceImg']['name']);
		$img_size = getimagesize($_FILES['serviceImg']['tmp_name']);
		$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

		//check whether file is image or not
		if($img_size == FALSE) {
			header("Location: servicesAdmin.php?error=file");
			exit();
		} 
		//file type not allowed
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			header("Location: servicesAdmin.php?error=file");
			exit();
		}
		//file too large
		if($_FILES["serviceImg"]["size"] > 5000000) {
			header("Location: servicesAdmin.php?image=size");
			exit();
		} 
		//file already exists
		if(file_exists($target)) {
			header("Location: servicesAdmin.php?file=exists");
			exit();
		} else {
			$sql = "UPDATE services SET serviceInfo = '$serviceImg' WHERE ID = '$edit_Service' ";

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
		} 

	} else {
		//record can't be found
		header("Location: servicesAdmin.php?record=unavailable");
		exit();
	}

?>