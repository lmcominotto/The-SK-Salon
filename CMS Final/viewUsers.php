<?php
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('location: admin.php');
		exit();
	}

	if(isset($_SESSION['id'])) {

		$title = 'VIEW USERS';
	
		include 'dbh.php';
		//connect to database
		
		$sql = "SELECT id, firstName, lastName, userID FROM siteUser";
		$result = mysqli_query($conn, $sql);
		//get results from database

		//nav bar, etc. 
		include 'includes/headerAdmin.php';

		//check for error or success messages
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(strpos($url, 'delete=failed') !== false){
			echo "<div class = 'adminLogIn'><font color = 'red'>
				<b>There was an error deleting user record.<br>
				Please try again later.<br></b></font></div>";
		}
		else if(strpos($url, 'delete=success') !== false){
			echo "<div class = 'adminLogIn'><font color = 'red'>
				<b>The selected user record was deleted successfully!<br></b></font></div>";
		}
		else if(strpos($url, 'edit=failed') !== false){
			echo "<div class = 'adminLogIn'><font color = 'red'>
				<b>The selected user record could not be updated.<br>
				Please try again later.<br></b></font></div>";
		}
		else if(strpos($url, 'edit=success') !== false){
			echo "<div class = 'adminLogIn'><font color = 'red'>
				<b>The selected user record was updated successfully!<br></b></font></div>";
		}

		//if user logged in is site admin, present list of all current users
		if(isset($_SESSION['id']) and ($_SESSION['id'] == 1)) { 
			if($result->num_rows > 0) {
				echo "<div class = 'adminLogIn'>CURRENT USERS<br><br>";
				echo "<table border = '1' cellpadding = '10'>";
				echo "<tr> <th>First Name</th> <th>Last Name</th> <th>Username</th> <th>Edit</th> <th>Delete</th></tr>";

				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					/*echo "<td>" .$row['id']. "</td>"; */
					echo "<td>" .$row['firstName']. "</td>";
					echo "<td>" .$row['lastName']. "</td>";
					echo "<td>" .$row['userID']. "</td>";
					echo "<td><a href = 'editUser.php?id=" .$row['id']. "'>Edit</a></td>";
					
					if($row['id'] != 1)
					{	//as long as user profile is not site admin, option to delete is available
						echo "<td><a href = 'deleteUser.php?id=" .$row['id']. "'>Delete</a></td>";	
					}

					echo "</tr>";
				}
			} else {
				echo "0 results";
			}

			echo "</table>";
			echo "</div>";

		} else {
			//user logged in is not site admin and cannot see all user information
			echo 
				"<div class = 'adminLogIn'>
					<font color = 'red'><b>THE SITE ADMIN IS NOT LOGGED IN.<br>
					ONLY THE SITE ADMIN CAN VIEW USERS!</b></font><br><br>
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