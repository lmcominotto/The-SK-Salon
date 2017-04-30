<?php

	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('Location: admin.php');
		exit();
	}

	if(isset($_SESSION['id'])) {
		//connect to database
		include 'dbh.php';

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Inventory</title>
		<link href="css/backStyle.css" rel ="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
	</head>
	<body>
		<div class = "content">
			<div class = "log">
				<form action = "includes/logout.inc.php">
					<button>LOG OUT</button>
				</form>
			</div>

			<h1 class = "pageTitle">CUSTOMERS</h1>	

			<ul class = "topnav" id = "nav">
				<li><a href = "adminForm.php">ADMIN</a></li>
				<li><a href = "homepageAdmin.php">HOME</a></li>
				<li><a href = "aboutAdmin.php">ABOUT</a></li>
				<li><a href = "servicesAdmin.php">SERVICES</a></li>
				<li><a href = "stylistsAdmin.php">STYLISTS</a></li>
				<li><a href = "productAdmin.php">PRODUCTS</a></li>
				<li><a href = "photoAdmin.php">PHOTOS</a></li>
				<li><a href = "inventoryAdmin.php">INVENTORY</a></li>
				<li><a href = "customerAdmin.php">CUSTOMERS</a></li>
				<li class="icon">
					<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a> 
				</li>
			</ul>

			<p><h1> Customer Report </h1> </p>

			<div class = "report">
			<table>
				<tr>
					<th> Customer ID </th>
					<th> First Name </th>
					<th> Last Name </th>
					<th> Address </th>
					<th> City </th>
					<th> State </th>
					<th> Zip Code </th>
					<th> Email </th>
					<th> Phone Number </th>
				</tr>
				
			<?php
				$sql = "SELECT * FROM customers";
				$result = mysqli_query($conn, $sql);
				$count = $result->num_rows;

			
			if ($count !=0)
			{
						
					while($row = $result->fetch_object()){
						{				
			?>
			
				<tr>
					<td> <?php echo $row->idCustomers; ?> </td>
					<td> <?php echo $row->firstName; ?> </td>
					<td> <?php echo $row->lastName; ?> </td>
					<td> <?php echo $row->address; ?> </td>
					<td> <?php echo $row->city; ?> </td>
					<td> <?php echo $row->state; ?> </td>
					<td> <?php echo $row->zipCode; ?> </td>
					<td> <?php echo $row->email; ?> </td>
					<td> <?php echo $row->phoneNum; ?> </td>
				</tr>
				
			<?php } 
					}
			}
							
			?>
			</table>
			</div>
		
		</div>
	</body>
</html>	

<?php
	} else {
		//redirects to login form if not logged in
		redirect();
	} 
?>