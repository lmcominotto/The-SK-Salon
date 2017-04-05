<!DOCTYPE HTML>
 <html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="css/backStyle.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
	</head>
	
	<body>
		<div class = "content">
			<div class = "log">
				<button><a href = "includes/logout.inc.php">LOG OUT</a></button>
			</div>

			<h1>INVENTORY</h1>
			
			<ul class = "topnav">
				<li><a href = "adminForm.php">ADMIN</a></li>
				<li><a href = "homepageAdmin.php">HOME</a></li>
				<li><a href = "aboutAdmin.php">ABOUT</a></li>
				<li><a href = "servicesAdmin.php">SERVICES</a></li>
				<li><a href = "stylistsAdmin.php">STYLISTS</a></li>
				<li><a href = "productAdmin.php">PRODUCTS</a></li>
				<li><a href = "photoAdmin.php">PHOTOS</a></li>
				<li><a href = "inventoryAdmin.php">INVENTORY</a></li>
			</ul>

			<?php 
				//check for messages in URL and print description
				include 'includes/urlMsg.php'; 
			?>

			<div class = "sectionTitleNew">
				ADD NEW ITEMS<br>
			</div>

			<div class = "adminLogIn">
				<form action = "" method = "POST">
					<label>UPC</label><br>
					<input type = "text" name = "UPCnumber"><br><br>

					<label>Description</label><br>
					<input type = "text" name = "description"><br><br>

					<label>Quantity Available</label><br>
					<input type = "text" name = "quantity"><br><br>

					<label>Cost</label><br>
					<input type = "text" name = "cost"><br><br>

					<label>Price</label><br>
					<input type = "text" name = "price"><br><br>

					<button type = "sumit" name = "newItem">SUBMIT</button>
				</form>
			</div>

		</div>
	</body>
</html>