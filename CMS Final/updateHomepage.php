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

	//update main content on page
	if(isset($_POST['updateMain'])) {
		//from form
		$edit_Main = test_input($_POST['id']);
		$edit_Main = mysqli_real_escape_string($conn, $_POST['id']);
		$mainInfo = test_input($_POST['mainInfo']);
		$mainInfo = mysqli_real_escape_string($conn, $_POST['mainInfo']);

		$sql_One = "UPDATE homePage SET mainInfo = '$mainInfo' WHERE ID = '$edit_Main'";

		if(mysqli_query($conn, $sql_One)) {
			header("Location: homepageAdmin.php?edit=success");
			exit();
		} else {
			header("Location: homepageAdmin.php?edit=failed");
			exit();
		}
	}
	//update contact information on page
	else if (isset($_POST['updateContact'])) {
		//if just text update
		if(empty($_FILES['logoImg']['name'])) {
			//from form
			$edit_Contact = test_input($_POST['id']);
			$edit_Contact = mysqli_real_escape_string($conn, $_POST['id']);
			$contactTitle = test_input($_POST['contactTitle']);
			$contactTitle = mysqli_real_escape_string($conn, $_POST['contactTitle']);
			$contactInfo = test_input($_POST['contactInfo']);
			$contactInfo = mysqli_real_escape_string($conn, $_POST['contactInfo']);

			$sql_Two = "UPDATE contactHome SET contactTitle = '$contactTitle', contactInfo = '$contactInfo' WHERE ID = '$edit_Contact'";

			if(mysqli_query($conn, $sql_Two)) {
				header("Location: homepageAdmin.php?edit=success");
				exit();
			} else {
				header("Location: homepageAdmin.php?edit=failed");
				exit();
			}
		} else {
			//update image and text

			//from form
			$edit_Contact = test_input($_POST['id']);
			$edit_Contact = mysqli_real_escape_string($conn, $_POST['id']);

			//path to store uploaded image
			$target = "img/".basename($_FILES['logoImg']['name']);

			$contactTitle = test_input($_POST['contactTitle']);
			$contactTitle = mysqli_real_escape_string($conn, $_POST['contactTitle']);
			$contactInfo = test_input($_POST['contactInfo']);
			$contactInfo = mysqli_real_escape_string($conn, $_POST['contactInfo']);

			$contactLogo = addslashes($_FILES['logoImg']['name']);;
			$contactLogoTmp = addslashes($_FILES['logoImg']['tmp_name']);;
			$logo_size = getimagesize($_FILES['logoImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//check whether file is image or not
			if($logo_size == FALSE) {
				header("Location: homepageAdmin.php?error=file");
				exit();
			}
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: homepageAdmin.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["logoImg"]["size"] > 5000000) {
				header("Location: homepageAdmin.php?image=size");
				exit();
			} 
			//file already exists
			if (file_exists($target)) {
				header("Location: homepageAdmin.php?file=exists");
				exit();
			} else {
				$sql_Two = "UPDATE contactHome SET contactTitle = '$contactTitle', contactInfo = '$contactInfo', contactLogo = '$contactLogo' WHERE ID = '$edit_Contact'";
			
				if(!mysqli_query($conn, $sql_Two)) {
					header("Location: homepageAdmin.php?edit=failed");
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['logoImg']['tmp_name'], $target)) {
					header("Location: homepageAdmin.php?error=image");
					exit();
				} else {
					header("Location: homepageAdmin.php?edit=success");
					exit();
				}
			} 
		}
	} else {
		header("Location: homepageAdmin.php?record=unavailable");
		exit();
	}
?>