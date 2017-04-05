<?php
	session_start();
	//must assure every single page in website has this!
	
	include 'dbh.php';
	//connect to database
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="css/backStyle.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
	</head>	

	<body>
	<?php
		//check if id is in URL and check it's valid
		if(isset($_GET['id']) && is_numeric($_GET['id'])) {
			$edit_id = $_GET['id'];
		} else {
			echo "User record could not be found.";
		} 

		//select query 
		$sql = "SELECT id, firstName, lastName, userID, password FROM siteUser WHERE id = '$edit_id'";
		//execute query and store in result
		$result = mysqli_query($conn, $sql);

		while($row = $result->fetch_assoc()) {
			echo
				"<div class = 'adminLogIn'>
					<form action = 'editUserAction.php' method = POST>
					
						<b>To Update User Information, Please Enter New Details Below.<br>Assure No Input Fields Are Left Blank!</b>
						<br><br><br>

						<label for = 'firstName'>FIRST NAME</label><br>
						<input type = 'text' name = 'firstName' value = '" .$row['firstName']. "'><br><br>
							
						<label for = 'lastName'>LAST NAME</label><br>
						<input type = 'text' name = 'lastName' value = '" .$row['lastName']. "'><br><br>
							
						<label for = 'userID'>USERNAME</label><br>
						<input type = 'text' name = 'userID' value = '" .$row['userID']. "'><br><br>
							
						<label for = 'password'>PASSWORD</label><br>
						<input type = 'text' name = 'password' value = '" .$row['password']. "'><br><br>

						<input type = 'hidden' name = 'id' value = '" .$row['id']. "'>
							
						<button type = 'submit' name = 'submit'>UPDATE</button><br>
					</form>
				</div>";
			}
	?>
	</body>
</html>