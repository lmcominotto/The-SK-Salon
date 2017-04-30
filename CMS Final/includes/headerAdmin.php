<!DOCTYPE HTML>
<html>
	<head>
		<title>Admin</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="css/backStyle.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>
	<body>
		<div class = "content">
			<div class = "log">
				<form action = "includes/logout.inc.php">
					<input type = "submit" name = "logout" value = "LOG OUT">
				</form>
			</div>

			<h1><?php echo $title ?></h1>
			
			<ul class = "topnav" id = "nav">
				<li><a href = "adminForm.php">ADMIN</a></li>
				<li><a href = "homepageAdmin.php">HOME</a></li>
				<li><a href = "aboutAdmin.php">ABOUT</a></li>
				<li><a href = "servicesAdmin.php">SERVICES</a></li>
				<li><a href = "stylistsAdmin.php">STYLISTS</a></li>
				<li><a href = "productAdmin.php">PRODUCTS</a></li>
				<li><a href = "photoAdmin.php">PHOTOS</a></li>
				<li><a href = "DBmain.php">INVENTORY</a></li>
				<li class="icon">
					<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a> 
				</li>
			</ul>

			<script>
				function myFunction() {
					var x = document.getElementById("nav");
					if (x.className === "topnav") {
						x.className += " responsive";
					} else {
						x.className = "topnav";
					}
				}
			</script>