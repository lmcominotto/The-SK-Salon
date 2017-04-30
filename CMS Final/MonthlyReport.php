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
session_start();

//redirect to login form if not logged in
function redirect() {
  header('Location: admin.php');
  exit();
}

if(isset($_SESSION['id'])) {

	include 'dbh.php';
	include 'includes/headerInventory.php';

	date_default_timezone_set('America/Chicago');

	$unix_timestamp = strtotime("first day of this month midnight");
	$month = date('Y-m-d H:i:s', $unix_timestamp);
	$now = date('Y-m-d H:i:s');

	$sql = "SELECT * FROM transactions WHERE transTime between '$month' and '$now' ORDER by transTime DESC";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		echo "Error retrieving report. Please wait.<br>";
		header( "refresh:3; url = '$DB_MAIN_URL'" );
		exit();
	}

	$grossTotal = 0;
	echo "<br>";
	echo '<table class="table table-striped table-bordered">'; 
	echo '<tr><th>Date & Time:</th><th>Customer ID</th><th>Payment Type:</th><th>Total:</th></tr>';
	while ($row = mysqli_fetch_assoc($result)) {
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
	echo "<br><br>";

	mysqli_close($conn);
	exit();

} else {
  redirect();
}
?>