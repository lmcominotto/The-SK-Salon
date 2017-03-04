<?php
	
	session_start();
	include '../dbh.php';
	
	$userID = $_POST['userID'];
	$password = $_POST['password'];
	
	$sql = "SELECT * FROM siteUser WHERE userID = '$userID' AND password = '$password'";
	$result = mysqli_query($conn, $sql);
	
	if (!$row = mysqli_fetch_assoc($result)) {
		//if error logging in, return back to login screen with error message
		header("Location: ../admin.php?login=failed"); 
		exit();
	} else {
		$_SESSION['id'] = $row['id'];
	}
	
	header("Location: ../admin.php");