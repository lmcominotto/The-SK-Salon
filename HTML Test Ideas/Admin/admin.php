<?php
	include 'includes/header.php';
?>
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
					<b>USER HAS BEEN SIGNED UP.<br></b></font></div>";
			}
			//if user is logged in, a logout button appears
			if(isset($_SESSION['id'])) {
				echo
				"<div class = 'adminLogIn'>
					<b>You are logged in.</b><br><br>
					<form action = 'includes/logout.inc.php'>
						<button><b>LOG OUT</b></button>
					</form>
					<br><br>
					Site admin may proceed <a href = 'signup.php'>HERE</a> to create new users to for this site.<br>
				</div>";
			} else { 
				//login form is presented if not logged in 
				echo
				"<div class = 'adminLogIn'>
					<form action = 'includes/login.inc.php' method = 'POST'>
						<b>SITE ADMINISTRATOR LOGIN</b>
						<br><br><br>
				
						<label for = 'userID'>USERNAME</label><br>
						<input type = 'text' name = 'userID'><br>
						
						<label for = 'password'>PASSWORD</label><br>
						<input type = 'password' name = 'password'><br><br>
						
						<button type = 'submit'><b>LOG IN</b></button>
					</form>
				</div>";
			}
		?>
			
<?php
	include 'includes/footer.php';
?>
