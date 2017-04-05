<?php

$name = $email = $suject = $message = "";
$nameErr = $emailErr = $subjectErr = $messageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["Name"])) {
		$nameErr = "Name is required";
	} else {
		$name = test_input($_POST["Name"]);
	}
	
	if (empty($_POST["Email"])) {
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["Email"]);
	}
	
	if (empty($_POST["Subject"])) {
		$subjectErr = "Subject is required";
	} else {
		$subject = test_input($_POST["Subject"]);
	}
	
	if (empty($_POST["Message"])) {
		$messageErr = "Message is required";
	} else {
		$message = test_input($_POST["Message"]);
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//echo "Thank you ".$name.". Your message has been sent";

?>
