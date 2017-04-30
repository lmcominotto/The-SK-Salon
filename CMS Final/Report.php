<html>
<style>
<!-- CSS for displaying report -->
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</html>

<?php

function PrintReport( $from_date, $to_date )
{
	$sql = "SELECT * FROM transactions WHERE transTime between '$from_date' 
		 and '$to_date' ORDER by transTime DESC";
	$result = mysqli_query($conn, $sql);
	if ( !$result ) {
		echo mysqli_error();
		mysqli_close();
		exit();
	}
	$grossTotal = 0;
	echo '<table class="table table-striped table-bordered">'; 
	echo '<tr><th>Date & Time:</th><th>Customer ID</th><th>Payment Type:</th><th>Total:</th></tr>';
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		echo "<tr><td>";
		echo $row['transTime'];
		echo "</td><td>";
		echo $row['idCustomers'];
		echo "</td><td>"; 
		echo $row['paymentType'];
		echo "</td><td>";
		echo $row['total'];
		echo "</td></tr>";  
		$grossTotal += $row['total'];
	}
	echo '</table>';
	echo "<br>";
	
	echo '<table class="table table-striped table-bordered">'; 
	echo '<tr><th>Gross Total:</th></tr>';
	echo "<tr><td>";
	echo '$' . "$grossTotal";
	echo "</td></tr>";
	echo '</table>';
	
	return;
}

function PrintInventory()
{
	$result = mysql_query( "SELECT * FROM inventory" );
	if ( !$result ) {
		echo mysql_error();
		mysql_close();
		exit;
	}
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
	
	return;
}

function PrintCustomers()
{
	$sql = "SELECT * FROM customers";
	$result = mysqli_query($conn, $sql);

	/*if (!$result) {
		echo mysqli_error($conn);
		mysqli_close($conn);
		exit();
	} */
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
	
	return;
}

?>