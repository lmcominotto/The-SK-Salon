<?php
	
	session_start();
	include '../dbh.php';

	if(isset($_POST['logIn'])) {
		$userID = mysqli_real_escape_string($conn, $_POST['userID']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		
		$sql = "SELECT * FROM siteUser WHERE userID = '$userID' AND password = '$password'";
		$result = mysqli_query($conn, $sql);
		
		if (!$row = mysqli_fetch_assoc($result)) {
			//if error logging in, return back to login screen with error message
			header("Location: ../admin.php?login=failed"); 
			exit();
		} else {
			$_SESSION['id'] = $row['id'];
			header("Location: ../homepageAdmin.php");
			exit();
		}
	}
?>