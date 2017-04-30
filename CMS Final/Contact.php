<?php
	include 'includes/header.php';
	require_once "recaptchalib.php";
?>

<?php

	$name = $email = $subject = $message = $captcha = "";
	$to = "theSKsalon@gmail.com";  //change to Sandee's email
	$nameErr = $emailErr = $subjectErr = $messageErr = $captchaErr = "";
	$valid = true;
	//for recaptcha
	$secret = "6LdoqhwUAAAAAM3ml2zGh8qCKLn3OIjvR1iK9oZq";
	$response = null;
	$reCaptcha = new reCaptcha($secret);

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//make sure name field is not empty
		if (empty($_POST["Name"])) {
			$nameErr = "is required";
			$valid = false;
		} else {
			$name = test_input($_POST["Name"]);
			//check name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
				$nameErr = "Only letters and white space allowed";
				$valid = false;
			}
		}
		//make sure email field is not empty and in right form
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
		//make sure subject field not empty
		if (empty($_POST["Subject"])) {
			$subjectErr = "is required";
			$valid = false;
		} else {
			$subject = test_input($_POST["Subject"]);
		}
		//make sure message field not empty
		if (empty($_POST["Message"])) {
			$messageErr = "is required";
			$valid = false;
		} else {
			$message = test_input($_POST["Message"]);
		}
		//recaptcha server side response
		if ($_POST['g-recaptcha-response']) {
			$response = $reCaptcha->verifyResponse (
				$_SERVER['REMOTE_ADDR'],
				$_POST['g-recaptcha-response']
			);
			$captcha = $_POST['g-recaptcha-response'];
		}
		//make sure recaptcha form is checked
		if(empty($captcha)) {
			$captchaErr = "Please check captcha form.";
			$valid = false;
		}
		//check server side response is success 
		if(!($response != NULL && $response->success)) {
			$valid = false;
		}

		if($valid) {
			mail ($to, $subject, $message, "From: " . $name);
			echo "<p id = 'thanks'>Thank You!<br>Your Message Has Been Sent!</p>";
		}
	}

	//form validation
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
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3978.717062720551!2d-86.9467999114079!3d34.78491641982821!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xdaacc2af5656ac63!2sThe+SK+Salon!5e0!3m2!1sen!2sus!4v1493309864774" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
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
						<textarea name = "Message" rows = "5" cols="10" id = "Message"></textarea><br><br>

						<span class = "error"><?php echo "<b><font color = 'red'>".$captchaErr."</font></b>";?></span>
						<div class="g-recaptcha" data-sitekey="6LdoqhwUAAAAAKSj2cceEWqOHl9vryxsPbgcKKWO"></div><br>
						
						<input type = "submit" name = "submit" value = "Submit" class = "submit-button"/>
		
					</form>

				</div>
			</div>
		</div>
		
<?php
	include 'includes/footer.php';
?>