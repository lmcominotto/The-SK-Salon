<?php
	session_start();
	//must assure every single page in website has this!
	
	include 'dbh.php';
	//connect to database

	if(isset($_POST['update'])) {

		if(empty($_FILES['productImg']['name'])) {
			$edit_Product = $_POST['id'];
			$productTitle = $_POST['productTitle'];
			$productInfo = $_POST['productInfo'];

			$sql = "UPDATE products SET productTitle = '$productTitle', productInfo = '$productInfo' WHERE ID = '$edit_Product'";

			if(mysqli_query($conn, $sql)) {
				header("Location: productAdmin.php?edit=success");
				exit();
			} else {
				header("Location: productAdmin.php?edit=failed");
				exit();
			}
		} else {
			$edit_Product = $_POST['id'];
			$productTitle = $_POST['productTitle'];
			$productInfo = $_POST['productInfo'];
			$target = "img/".basename($_FILES['productImg']['name']);
			$productImgTmp = addslashes($_FILES['productImg']['tmp_name']);
			$productImg = addslashes($_FILES['productImg']['name']);
			$img_size = getimagesize($_FILES['productImg']['tmp_name']);

			if($img_size == FALSE) {
				header("Location: productAdmin.php?error=file");
				exit();
			} else {
				$sql = "UPDATE products SET productTitle = '$productTitle', productInfo = '$productInfo', productImg = '$productImg' WHERE ID = '$edit_Product'";
			}

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
	} else {
		header("Location: productAdmin.php?record=unavailable");
		exit();
	}

?>