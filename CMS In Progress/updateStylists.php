<?php
	session_start();
	//must assure every single page in website has this!
	
	include 'dbh.php';
	//connect to database

	if(isset($_POST['update'])) {
		//if just want to update text
		if (empty($_FILES['stylistImg']['name'])) {
			
			$edit_Stylist = $_POST['id'];
			$stylistTitle = $_POST['stylistTitle'];
			$stylistInfo = $_POST['stylistInfo'];

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
			$edit_Stylist = $_POST['id'];
			$stylistTitle = $_POST['stylistTitle'];
			$stylistInfo = $_POST['stylistInfo'];
			$target = "img/".basename($_FILES['stylistImg']['name']);
			$stylistImgTmp = addslashes($_FILES['stylistImg']['tmp_name']);
			$stylistImg = addslashes($_FILES['stylistImg']['name']);
			$img_size = getimagesize($_FILES['stylistImg']['tmp_name']);

			if($img_size == FALSE) {
				header("Location: stylistsAdmin.php?error=file");
				exit();
			} else {
				$sql = "UPDATE stylists SET stylistTitle = '$stylistTitle', stylistInfo = '$stylistInfo', stylistImg = '$stylistImg' WHERE ID = '$edit_Stylist'";
			}

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
	} else {
		header("Location: stylistsAdmin.php?record=unavailable");
		exit();
	}
?>