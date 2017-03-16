<?php
	include '../dbh.php';
	
	//sets variables and runs db query
		$id = $_POST['ID'];
		
		//SQL query to delete row from table
		$sql = "DELETE FROM stylists WHERE ID = '$id'";		
		$result = mysqli_query($conn, $sql);
		
		//Printing results to screen for user
		if($result) {
			echo "Record deleted successfully"; ?>
<html>
	<body>
			<br><a href = "../adminform.php">Return to Editing Page</a>
	</body>
</html>
<?php
		} else {
			echo "Error deleting record.";
		}
	
?>