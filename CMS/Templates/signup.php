<?php
	include 'include/headeradmin.php';
?>

		<?php
			//check for signup form errors
			$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if(strpos($url, 'error=empty') !== false){
				echo "<div class = 'adminLogIn'><font color = 'red'>
					<b>YOU MUST FILL OUT ALL FIELDS!</b></font></div>";
			}
			else if(strpos($url, 'error=username') !== false){
				echo "<div class = 'adminLogIn'><font color = 'red'>
					<b>USERNAME ALREADY EXISTS!<br>
					PLEASE ENTER ANOTHER AND TRY AGAIN.</b></font></div>";
			}
			//if user logged in is site admin, present add new user form
			if(isset($_SESSION['id']) and $_SESSION['id'] == 1) { 
				echo 
				"<div class = 'adminLogIn'>
					<form action = 'include/signup.inc.php' method = 'POST'>
				
						<b>TO ADD NEW USERS, PLEASE ENTER ALL INFORMATION BELOW.</b>
						<br><br><br>
						
						<label for = 'firstName'>FIRST NAME</label><br>
						<input type = 'text' name = 'firstName'><br><br>
						
						<label for = 'lastName'>LAST NAME</label><br>
						<input type = 'text' name = 'lastName'><br><br>
						
						<label for = 'userID'>USERNAME</label><br>
						<input type = 'text' name = 'userID'><br><br>
						
						<label for = 'password'>PASSWORD</label><br>
						<input type = 'password' name = 'password'><br><br>
						
						<button type = 'submit'><b>SIGN UP</b></button><br>
					</form>
				</div>";
			} else {
				//user logged in is not site admin and cannot add new users
				echo 
				"<div class = 'adminLogIn'>
					<font color = 'red'><b>THE SITE ADMIN IS NOT LOGGED IN.<br>
					ONLY THE SITE ADMIN CAN ADD NEW USERS!</b></font><br><br>
					<form action = 'include/logout.inc.php'>
						<button><b>LOG OUT</b></button>
					</form>
				</div>";
			}
		?>
		
<?php
	include 'include/footer.php';
?>