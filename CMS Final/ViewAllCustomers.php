<?php
session_start();

//redirect to login form if not logged in
function redirect() {
  header('Location: admin.php');
  exit();
}

if(isset($_SESSION['id'])) {

	include 'dbh.php';
	include 'Report.php';
	include 'includes/headerInventory.php';

	$sql = "SELECT * FROM customers";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		echo mysqli_error($conn);
		echo "<br>An error has occurred.<br>";
		header( "refresh:3; url = '$DB_MAIN_URL'" );
		mysqli_close($conn);
		exit();
	}
	echo "<br>";
	echo '<table class="table table-striped table-bordered">'; 
	echo '<tr><th>Customer ID</th><th>First Name</th><th>Last Name</th><th>Address</th>
		  <th>City</th><th>State</th><th>Zip Code</th><th>Email</th><th>Phone Number</th>
		  </tr>';
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		if ( $row['firstName'] != 'GUEST' ) {
			echo "<tr><td>";
			echo $row['idCustomers'];
			echo "</td><td>";
			echo $row['firstName'];
			echo "</td><td>"; 
			echo $row['lastName'];
			echo "</td><td>";
			echo $row['address'];
			echo "</td><td>";
			echo $row['city'];
			echo "</td><td>";
			echo $row['state'];
			echo "</td><td>";
			echo $row['zipCode'];
			echo "</td><td>";
			echo $row['email'];
			echo "</td><td>";
			echo $row['phoneNum'];
			echo "</td></tr>";  
		}
	}
	echo '</table>';
	echo "<br>";

	mysqli_close($conn);
	exit();

} else {
	redirect();
} 
?>
