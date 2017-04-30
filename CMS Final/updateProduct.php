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
		//update only text
		if(empty($_FILES['productImg']['name'])) {
			$edit_Product = test_input($_POST['id']);
			$edit_Product = mysqli_real_escape_string($conn, $_POST['id']);
			$productTitle = test_input($_POST['productTitle']);
			$productTitle = mysqli_real_escape_string($conn, $_POST['productTitle']);
			$productInfo = test_input($_POST['productInfo']);
			$productInfo = mysqli_real_escape_string($conn, $_POST['productInfo']);

			$sql = "UPDATE products SET productTitle = '$productTitle', productInfo = '$productInfo' WHERE ID = '$edit_Product'";

			if(mysqli_query($conn, $sql)) {
				header("Location: productAdmin.php?edit=success");
				exit();
			} else {
				header("Location: productAdmin.php?edit=failed");
				exit();
			}
		} else {
			//update text and image

			//from form
			$edit_Product = test_input($_POST['id']);
			$edit_Product = mysqli_real_escape_string($conn, $_POST['id']);
			$productTitle = test_input($_POST['productTitle']);
			$productTitle = mysqli_real_escape_string($conn, $_POST['productTitle']);
			$productInfo = test_input($_POST['productInfo']);
			$productInfo = mysqli_real_escape_string($conn, $_POST['productInfo']);

			//path to store uploaded image
			$target = "img/".basename($_FILES['productImg']['name']);

			$productImgTmp = addslashes($_FILES['productImg']['tmp_name']);
			$productImg = addslashes($_FILES['productImg']['name']);
			$img_size = getimagesize($_FILES['productImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//check whether file is image or not
			if($img_size == FALSE) {
				header("Location: productAdmin.php?error=file");
				exit();
			} 
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: productAdmin.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["productImg"]["size"] > 5000000) {
				header("Location: productAdmin.php?image=size");
				exit();
			} 
			//file already exists
			if (file_exists($target)) {
				header("Location: productAdmin.php?file=exists");
				exit();
			} else {
				$sql = "UPDATE products SET productTitle = '$productTitle', productInfo = '$productInfo', productImg = '$productImg' WHERE ID = '$edit_Product'";
			
				if(!mysqli_query($conn, $sql)) {
					header("Location: productAdmin.php?edit=failed");
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['productImg']['tmp_name'], $target)) {
					header("Location: productAdmin.php?error=image");
					exit();
				} else {
					header("Location: productAdmin.php?edit=success");
					exit();
				}
			} 
		}
	} else {
		header("Location: productAdmin.php?record=unavailable");
		exit();
	}

?>