<?php
	session_start();
	//must assure every single page in website has this
	
	include 'dbh.php';
	//connect to database

	if(isset($_POST['updateLogo'])) {

		$edit_Post = $_POST['id'];
		$target = "img/".basename($_FILES['logoImg']['name']);

		$logoImgTmp = addslashes($_FILES['logoImg']['tmp_name']);
		$logoImg = addslashes($_FILES['logoImg']['name']);
		$img_size = getimagesize($_FILES['logoImg']['tmp_name']);
		$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

		if($img_size == FALSE) {
			header("Location: adminForm.php?error=file");
			exit();
		} 
		//file type not allowed
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			header("Location: adminForm.php?error=file");
			exit();
		}
		//file too large
		if($_FILES["logoImg"]["size"] > 5000000) {
			header("Location: adminForm.php?image=size");
			exit();
		} 
		//file already exists
		if(file_exists($target)) {
			header("Location: adminForm.php?file=exists");
			exit();
		} else {
			$sql = "UPDATE siteLogo SET logoImg = '$logoImg' WHERE ID = '$edit_Post' ";

			if(!mysqli_query($conn, $sql)) {
				header("Location: adminForm.php?edit=failed");
				exit();
			}

			//check whether file has been moved to image file/directory
			if(!move_uploaded_file($_FILES['logoImg']['tmp_name'], $target)) {
				header("Location: adminForm.php?error=image");
				exit();
			} else {
				header("Location: adminForm.php?edit=success");
				exit();
			}
		} 
	} else {
		header("Location: adminForm.php?record=unavailable");
		exit();
	}

?>