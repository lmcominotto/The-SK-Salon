<?php
	
	session_start();
	include '../dbh.php';

	//redirect to login form if not logged in
	function redirect() {
		header('location: ../admin.php');
		exit();
	}

	if(isset($_SESSION['id']) and ($_SESSION['id'] == 1)) {
	
		$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
		$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
		$userID = mysqli_real_escape_string($conn, $_POST['userID']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);
		
		//error checking, makes sure no fields are empty on user sign up form
		//if empty, returns to signup form with error message
		if(empty($firstName)){
			header("Location: ../signup.php?error=empty");
			exit();
		}
		if(empty($lastName)){
			header("Location: ../signup.php?error=empty");
			exit();
		}
		if(empty($userID)){
			header("Location: ../signup.php?error=empty");
			exit();
		}
		if(empty($password)){
			header("Location: ../signup.php?error=empty");
			exit();
		}
		else {
			//checks to make sure no userID duplicates
			$sql = "SELECT userID FROM siteUser WHERE userID ='$userID'";
			$result = mysqli_query($conn, $sql);
			$userIDcheck = mysqli_num_rows($result);
			
			//if there are duplicates, returns to signup form with error message 
			if($userIDcheck > 0){
				header("Location: ../signup.php?error=username");
				exit();
			} else {
				//hash the password
				$hashPwd = password_hash($password, PASSWORD_DEFAULT);
				//if no errors, sign up user and return to admin page
				$sql = "INSERT into siteUser (firstName, lastName, userID, password) 
				VALUES ('$firstName', '$lastName', '$userID', '$hashPwd')";
				
				$result = mysqli_query($conn, $sql);
				
				header("Location: ../adminForm.php?add=success");
				exit();
			}
		}
	}