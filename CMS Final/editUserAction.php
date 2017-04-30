<?php
	
	session_start();
	include 'dbh.php';

	//form validation
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$update = mysqli_real_escape_string($conn, $_POST['id']);
	$firstName = test_input($_POST['firstName']);
	$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
	$lastName = test_input($_POST['lastName']);
	$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
	$userID = test_input($_POST['userID']);
	$userID = mysqli_real_escape_string($conn, $_POST['userID']);

	$sql = "UPDATE siteUser SET firstName = '$firstName', lastName = '$lastName', userID = '$userID' WHERE id = '$update'";

	if(mysqli_query($conn, $sql)) {
		header("Location: viewUsers.php?edit=success");
		exit();
	} else {
		header("Location: viewUsers.php?edit=failed");
		exit();
	}
?>