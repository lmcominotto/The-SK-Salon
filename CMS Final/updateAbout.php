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

	//update text post
	if(isset($_POST['updatePost'])) {
		//from form
		$edit_Post = test_input($_POST['id']);
		$edit_Post = mysqli_real_escape_string($conn, $_POST['id']);
		$postTitle = test_input($_POST['postTitle']);
		$postTitle = mysqli_real_escape_string($conn, $_POST['postTitle']);
		$postInfo = test_input($_POST['postInfo']);
		$postInfo = mysqli_real_escape_string($conn, $_POST['postInfo']);

		$sql = "UPDATE aboutSK SET postTitle = '$postTitle', postInfo = '$postInfo' WHERE ID = '$edit_Post'";

		if(mysqli_query($conn, $sql)) {
			header("Location: aboutAdmin.php?edit=success");
			exit();
		} else {
			header("Location: aboutAdmin.php?edit=failed");
			exit();
		}
	} else if (isset($_POST['updateImg'])) {
		//update image post

		//from form
		$edit_Post = test_input($_POST['id']);
		$edit_Post = mysqli_real_escape_string($conn, $_POST['id']);

		//path to store uploaded image
		$target = "img/".basename($_FILES['postImg']['name']);
		
		$postImgTmp = addslashes($_FILES['postImg']['tmp_name']);
		$postImg = addslashes($_FILES['postImg']['name']);
		$img_size = getimagesize($_FILES['postImg']['tmp_name']);
		$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

		//check whether file is image or not
		if($img_size == FALSE) {
			header("Location: aboutAdmin.php?error=file");
			exit();
		} 
		//file type not allowed
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			header("Location: aboutAdmin.php?error=file");
			exit();
		}
		//file too large
		if ($_FILES["postImg"]["size"] > 5000000) {
			header("Location: aboutAdmin.php?image=size");
			exit();
		} 
		//file already exists
		if (file_exists($target)) {
			header("Location: aboutAdmin.php?file=exists");
			exit();
		} else {
			$sql = "UPDATE aboutSK SET postInfo = '$postImg' WHERE ID = '$edit_Post' ";

			if(!mysqli_query($conn, $sql)) {
				header("Location: aboutAdmin.php?edit=failed");
				exit();
			}

			//check whether file has been moved to image file
			if(!move_uploaded_file($_FILES['postImg']['tmp_name'], $target)) {
				header("Location: aboutAdmin.php?error=image");
				exit();
			} else {
				header("Location: aboutAdmin.php?edit=success");
				exit();
			} 
		} 
	} else {
		header("Location: aboutAdmin.php?record=unavailable");
		exit();
	}

?>