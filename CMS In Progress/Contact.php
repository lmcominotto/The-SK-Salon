<?php
	include 'includes/header.php';
?>

<?php

	$name = $email = $subject = $message = "";
	$to = "myemail@email.com";  //change to Sandee's email
	$nameErr = $emailErr = $subjectErr = $messageErr = "";
	$valid = true;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//make sure name field is not empty
		if (empty($_POST["Name"])) {
			$nameErr = "is required";
			$valid = false;
		} else {
			$name = test_input($_POST["Name"]);
			//check name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
				$nameErr = "Only letters and whit space allowed";
				$valid = false;
			}
		}
		
		if (empty($_POST["Email"])) {
			$emailErr = "is required";
			$valid = false;
		} else {
			$email = test_input($_POST["Email"]);
			//check email address is well formed
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$emailErr = "- invalid format";
				$valid = false;
			}
		}
		
		if (empty($_POST["Subject"])) {
			$subjectErr = "is required";
			$valid = false;
		} else {
			$subject = test_input($_POST["Subject"]);
		}
		
		if (empty($_POST["Message"])) {
			$messageErr = "is required";
			$valid = false;
		} else {
			$message = test_input($_POST["Message"]);
		}

		if($valid) {
			mail ($to, $subject, $message, "From: " . $name);
			echo "<p id = 'thanks'>Thank You!<br>Your Message Has Been Sent!</p>";
		}
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>	

	
				<div class = "pageHeading">
					<p>CONTACT US</p>
				</div>
					
				<div id = "map">
					The SK Salon<br>
					1117 US Highway 72 East<br>
					Athens, AL 35611<br>
					256-800-1088<br><br>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3276.8287231397726!2d-86.95209868541805!3d34.78508688041286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88628b067d0b969f%3A0x1948d096ac865d1c!2s
					1117+US+Hwy+72+E%2C+Athens%2C+AL+35611!5e0!3m2!1sen!2sus!4v1487990507115" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
					
				<div id = "contactArea">
					<!--<p id = "thanks">THANK YOU!<br>YOUR MESSAGE HAS BEEN SENT!</p>-->
					<p id = "contactMsg">
						To schedule an appointment, please go <a href = "https://www.vagaro.com/thesksalon"><b>HERE</b></a>.<br>
						For questions or comments, please fill out the form below.<br>
						We will get back to you shortly!<br>
						<b>*All fields are required!</b>
					</p>
						
					<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
						
						<label for = "Name">Name</label>
						<span class = "error"><?php echo "<b><font color = 'red'>".$nameErr."</font></b>";?></span><br>
						<input type = "text" name = "Name" id = "Name"/>
						<br>
				
						<label for ="Email">Email</label>
						<span class = "error"><?php echo "<b><font color = 'red'>".$emailErr."</font></b>";?></span><br>
						<input type = "text" name = "Email" id = "Email"/><br>
							
						<label for = "Subject">Subject</label>
						<span class = "error"><?php echo "<b><font color = 'red'>".$subjectErr."</font></b>";?></span><br>
						<input type = "text" name = "Subject" id = "Subject"/><br>
							
						<label for = "Message">Message</label>
						<span class = "error"><?php echo "<b><font color = 'red'>".$messageErr."</font></b>";?></span><br>
						<textarea name = "Message" rows = "5" cols="10" id = "Message"></textarea><br>

						<input type = "submit" name = "submit" value = "Submit" class = "submit-button"/>
					</form>

				</div>
			</div>
		</div>
		
<?php
	include 'includes/footer.php';
?>