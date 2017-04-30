<?php
	session_start();
	//must assure every single page in website has this!
	
	function redirect() {
		header('Location: homepageAdmin.php');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Admin</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="css/backStyle.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
	</head>	
	<body>

		<!-- Basic check that user is logged -->
		<?php
			//check for login errors
			$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if(strpos($url, 'login=failed') !== false){
				echo "<div class = 'adminLogIn'><font color = 'red'>
					<b>USERNAME OR PASSWORD ENTERED IS NOT RECOGNIZED.<br>
					PLEASE TRY AGAIN.<br></b></font></div>";
			}
			else if(strpos($url, 'success') !== false){
				echo "<div class = 'adminLogIn'><font color = 'red'>
					<b>NEW USER HAS BEEN REGISTERED.<br></b></font></div>";
			}
			
			//if user is logged in
			if(isset($_SESSION['id'])) {
				//redirects user to backend admin area
				redirect();
			} else { 
				//login form is presented if not logged in 
				echo
					"<div class = 'content'>
						<div class = 'adminLogInMain'>
							<form action = 'includes/login.inc.php' method = 'POST'>
								<b>SITE ADMINISTRATOR LOGIN</b>
								<br><br><br>
						
								<label for = 'userID'>USERNAME</label><br>
								<input type = 'text' name = 'userID'><br><br>
								
								<label for = 'password'>PASSWORD</label><br>
								<input type = 'password' name = 'password'><br><br>
								
								<button type = 'submit' name = 'logIn'><b>LOG IN</b></button><br><br>
							</form>
						</div>
					</div>";
			}
		?>

	</body>
</html>