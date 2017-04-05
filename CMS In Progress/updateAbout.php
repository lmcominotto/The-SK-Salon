<?php
	session_start();
	//must assure every single page in website has this
	
	include 'dbh.php';
	//connect to database

	if(isset($_POST['updatePost'])) {

		$edit_Post = $_POST['id'];
		$postTitle = $_POST['postTitle'];
		$postInfo = $_POST['postInfo'];

		$sql = "UPDATE aboutSK SET postTitle = '$postTitle', postInfo = '$postInfo' WHERE ID = '$edit_Post'";

		if(mysqli_query($conn, $sql)) {
			header("Location: aboutAdmin.php?edit=success");
			exit();
		} else {
			header("Location: aboutAdmin.php?edit=failed");
			exit();
		}
	} else if (isset($_POST['updateImg'])) {
		$edit_Post = $_POST['id'];
		$target = "img/".basename($_FILES['postImg']['name']);
		
		$postImgTmp = addslashes($_FILES['postImg']['tmp_name']);
		$postImg = addslashes($_FILES['postImg']['name']);
		$img_size = getimagesize($_FILES['postImg']['tmp_name']);

		if($img_size == FALSE) {
			header("Location: aboutAdmin.php?error=file");
			exit();
		} else {
			$sql = "UPDATE aboutSK SET postInfo = '$postImg' WHERE ID = '$edit_Post' ";
		}

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
	} else {
		header("Location: aboutAdmin.php?record=unavailable");
		exit();
	}

?>