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

	if(isset($_POST['update'])) {
		//if just want to update text
		if (empty($_FILES['stylistImg']['name'])) {
			//from form
			$edit_Stylist = test_input($_POST['id']);
			$edit_Stylist = mysqli_real_escape_string($conn, $_POST['id']);
			$stylistTitle = test_input($_POST['stylistTitle']);
			$stylistTitle = mysqli_real_escape_string($conn, $_POST['stylistTitle']);
			$stylistInfo = test_input($_POST['stylistInfo']);
			$stylistInfo = mysqli_real_escape_string($conn, $_POST['stylistInfo']);

			$sql = "UPDATE stylists SET stylistTitle = '$stylistTitle', stylistInfo = '$stylistInfo' WHERE ID = '$edit_Stylist'";

			if(mysqli_query($conn, $sql)) {
				header("Location: stylistsAdmin.php?edit=success");
				exit();
			} else {
				header("Location: stylistsAdmin.php?edit=failed");
				exit();
			}
		} else { 	
			//if want to update image

			//from form
			$edit_Stylist = test_input($_POST['id']);
			$edit_Stylist = mysqli_real_escape_string($conn, $_POST['id']);
			$stylistTitle = test_input($_POST['stylistTitle']);
			$stylistTitle = mysqli_real_escape_string($conn, $_POST['stylistTitle']);
			$stylistInfo = test_input($_POST['stylistInfo']);
			$stylistInfo = mysqli_real_escape_string($conn, $_POST['stylistInfo']);

			//path to store image
			$target = "img/".basename($_FILES['stylistImg']['name']);

			$stylistImgTmp = addslashes($_FILES['stylistImg']['tmp_name']);
			$stylistImg = addslashes($_FILES['stylistImg']['name']);
			$img_size = getimagesize($_FILES['stylistImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//check file is image or not
			if($img_size == FALSE) {
				header("Location: stylistsAdmin.php?error=file");
				exit();
			} 
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: stylistsAdmin.php?error=file");
				exit();
			}
			//file too large
			if($_FILES["stylistImg"]["size"] > 5000000) {
				header("Location: stylistsAdmin.php?image=size");
				exit();
			} 
			//file already exists
			if(file_exists($target)) {
				header("Location: stylistsAdmin.php?file=exists");
				exit();
			} else {
				$sql = "UPDATE stylists SET stylistTitle = '$stylistTitle', stylistInfo = '$stylistInfo', stylistImg = '$stylistImg' WHERE ID = '$edit_Stylist'";
			
				if(!mysqli_query($conn, $sql)) {
					header("Location: stylistsAdmin.php?edit=failed");
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['stylistImg']['tmp_name'], $target)) {
					header("Location: stylistsAdmin.php?error=image");
					exit();
				} else {
					header("Location: stylistsAdmin.php?edit=success");
					exit();
				} 
			}
		}
	} else {
		header("Location: stylistsAdmin.php?record=unavailable");
		exit();
	}
?>