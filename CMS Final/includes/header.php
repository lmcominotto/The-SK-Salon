<?php
	session_start();
	//must assure every single page in website has this

	include 'dbh.php';

	$sql_Logo = "SELECT * FROM siteLogo";
	$result_Logo = mysqli_query($conn, $sql_Logo);
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="css/main.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>	
	<body>
		<div class="outerContainer">
			<div class = "heading">
				<div id = "topName">
					<?php
						$logoCnt = 1;

						if($result_Logo->num_rows > 0) {
							while ($row = mysqli_fetch_array($result_Logo)) {
								
								if($logoCnt == 1) {
									echo "<a href = 'index.php'><img src = 'img/" .$row['logoImg']. "'></a>";
								}
								$logoCnt++;
							}
						} else {
							echo "The SK Salon<br>";
						}
					?>
				</div>

				<div class = "topIcons">
						<a href = "https://www.facebook.com/thesksalon/"><img src = "img/facebook-logo.png" height = "25"></a>
						<a href = "https://www.instagram.com/sandee318/"><img src = "img/instagram-symbol.png" height = "25"></a>
				</div>
			</div>

			<div class="content">
				<!-- Nav Bar -->
				<div class="header">
					<ul class="topnav" id="myTopnav">
							<li><a href="index.php">HOME</a></li>
							<li><a href="About.php">ABOUT</a></li>
							<li><a href="Services.php">SERVICES</a></li>
							<li><a href="Stylists.php">STYLISTS</a></li>
							<li><a href="Products.php">PRODUCTS</a></li>
							<li><a href="Photos.php">PHOTOS</a></li>
							<li><a href="Contact.php">CONTACT</a></li>
							<li><a href="https://www.vagaro.com/thesksalon">BOOK</a></li>
							<li class="icon">
								<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a> 
							</li>
					</ul>
				</div>				