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

	$sql = "SELECT * FROM inventory";
	$result = mysqli_query($conn, $sql);

	if (!$result ) {
		echo mysqli_error($conn);
		echo "<br>An error has occurred.<br>";
		header( "refresh:3; url = '$DB_MAIN_URL'" );
		mysqli_close($conn);
		exit();
	}

	echo "<br>";
	echo '<table class="table table-striped table-bordered">'; 
	echo '<tr><th>UPC</th><th>Description</th><th>Quantity Available</th><th>Cost</th><th>Price</th></tr>';
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		if ( $row['description'] != 'HAIR_SERVICE' ) {
			echo "<tr><td>";
			echo $row['UPC'];
			echo "</td><td>";
			echo $row['description'];
			echo "</td><td>"; 
			echo $row['quantityAvail'];
			echo "</td><td>";
			echo $row['cost'];
			echo "</td><td>";
			echo $row['price'];
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