<?php
	
	session_start();
	include 'dbh.php';

	$sql = "UPDATE siteUser SET firstName = '$_POST[firstName]', lastName = '$_POST[lastName]', userID = '$_POST[userID]', password = '$_POST[password]' WHERE id = '$_POST[id]'";
	if(mysqli_query($conn, $sql)) {
		header("Location: viewUsers.php?edit=success");
	} else {
		header("Location: viewUsers.php?edit=failed");
	}

	/*if (isset($_POST['firstName'])) {
		$firstName = $_POST['firstName'];
	} else {
		echo "Missing first name value";
		$firstName = '';
	}
	
	//$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$userID = $_POST['userID'];
	$password = $_POST['password'];

	//check if id is in URL and check it's valid
	if(isset($_GET['id']) && is_numeric($_GET['id'])) {
		$edit_id = $_GET['id'];
	} else {
		echo "User record could not be found and updated.";
	} 

	//error checking, makes sure no fields are empty on user sign up form
	//if empty, returns to signup form with error message
	if(empty($firstName)){
		echo "Missing first name.";
		//header("Location: editUser.php?error=fempty");
		//exit();
	}
	if(empty($lastName)){
		echo "Missing last name.";
		//header("Location: editUser.php?error=lempty");
		//exit();
	}
	if(empty($userID)){
		echo "Missing username.";
		//header("Location: editUser.php?error=uempty");
		//exit();
	}
	if(empty($password)){
		echo "Missing password.";
		//header("Location: editUser.php?error=pempty");
		//exit();
	}
	else {
		//if no errors, edit user and return to admin page
		$sql = "UPDATE siteUser SET firstName = '$firstName', lastName = '$lastName', userID = '$userID', password = '$password' WHERE id = '$edit_id'";
		$result = mysqli_query($conn, $sql);
		header("Location: viewUsers.php?edit=success");
		//header("Location: ../admin.php?success");	
		echo "Yes.";
	} */
?>