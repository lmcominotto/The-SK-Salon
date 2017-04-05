<?php
	session_start();
	//must assure every single page in website has this
	
	include 'dbh.php';
	//connect to database

	//update main content on page
	if(isset($_POST['updateMain'])) {
		$edit_Main = $_POST['id'];

		$sql_One = "UPDATE homePage SET mainInfo = '$_POST[mainInfo]' WHERE ID = '$edit_Main'";

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

		if(empty($_FILES['logoImg']['name'])) {

			$edit_Contact = $_POST['id'];

			$sql_Two = "UPDATE contactHome SET contactTitle = '$_POST[contactTitle]', contactInfo = '$_POST[contactInfo]' WHERE ID = '$edit_Contact'";

			if(mysqli_query($conn, $sql_Two)) {
				header("Location: homepageAdmin.php?edit=success");
				exit();
			} else {
				header("Location: homepageAdmin.php?edit=failed");
				exit();
			}
		} else {

			$edit_Contact = $_POST['id'];
			$target = "img/".basename($_FILES['logoImg']['name']);

			$contactTitle = $_POST['contactTitle'];
			$contactInfo = $_POST['contactInfo'];
			$contactLogo = addslashes($_FILES['logoImg']['name']);;
			$contactLogoTmp = addslashes($_FILES['logoImg']['tmp_name']);;
			$logo_size = getimagesize($_FILES['logoImg']['tmp_name']);

			if($logo_size == FALSE) {
				header("Location: homepageAdmin.php?error=file");
				exit();
			} else {
				$sql_Two = "UPDATE contactHome SET contactTitle = '$contactTitle', contactInfo = '$contactInfo', contactLogo = '$contactLogo' WHERE ID = '$edit_Contact'";
			}

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
	} else {
		header("Location: homepageAdmin.php?record=unavailable");
		exit();
	}
?>