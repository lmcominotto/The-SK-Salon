<?php
	session_start();
	//must assure every single page in website has this

	//redirect to login form if not logged in
	function redirect() {
		header('location: admin.php');
		exit();
	}
	
	if(isset($_SESSION['id']) and ($_SESSION['id'] == 1)) {

		$title = 'EDIT USERS';
	
		//connect to database
		include 'dbh.php';

		//nav bar, etc. 
		include 'includes/headerAdmin.php';

		//check if id is in URL and check it's valid
		if(isset($_GET['id']) && is_numeric($_GET['id'])) {
			$edit_id = mysqli_real_escape_string($conn, $_GET['id']);
		} else {
			header("Location: viewUsers.php?record=unavailable");
			exit();
		} 

		//select query 
		$sql = "SELECT id, firstName, lastName, userID FROM siteUser WHERE id = '$edit_id'";
		//execute query and store in result
		$result = mysqli_query($conn, $sql);

		while($row = $result->fetch_assoc()) {
			echo
				"<div class = 'adminLogIn'>
					<form action = 'editUserAction.php' method = POST>
					
						<b>To update user information, please enter new details below.<br> Assure no input fields are left blank!</b>
						<br><br><br>

						<label for = 'firstName'>FIRST NAME</label><br>
						<input type = 'text' name = 'firstName' value = '" .$row['firstName']. "'><br><br>
							
						<label for = 'lastName'>LAST NAME</label><br>
						<input type = 'text' name = 'lastName' value = '" .$row['lastName']. "'><br><br>
							
						<label for = 'userID'>USERNAME</label><br>
						<input type = 'text' name = 'userID' value = '" .$row['userID']. "'><br><br>

						<input type = 'hidden' name = 'id' value = '" .$row['id']. "'>
							
						<button type = 'submit' name = 'submit'>UPDATE</button><br>
					</form>
				</div>";
			}
?>

		</div>
	</body>
</html>

<?php
	//redirect user to login form if not logged in
	} else {
		redirect();
	}
?>