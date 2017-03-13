<!DOCTYPE html>
<html>
	<head>
		<title><?php echo htmlspecialchars( $title )?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="stylesheets/main.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>	
	<body>
		<div class="outerContainer">
		<!--Logo-->
			<div id = "topName">
				<img src = "img/sk.png" alt = "The SK Salon">
			</div>
			
				<div class="content">
					<!-- Nav Bar -->
					<div class="header">
						<ul class="topnav" id="myTopnav">
							<li><a href="index.php">HOME</a></li>
							<li><a href="https://www.vagaro.com/thesksalon">BOOK</a></li>
							<li><a href="about.php">ABOUT</a></li>
							<li><a href="services.php">SERVICES</a></li>
							<li><a href="stylists.php">STYLISTS</a></li>
							<li><a href="products.php">PRODUCTS</a></li>
							<li><a href="photos.php">PHOTOS</a></li>
							<li><a href="contact.php">CONTACT</a></li>
							<li class="icon">
								<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a> 
							</li>
						</ul>
					</div>
					
<!-- Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon -->
<script>
	function myFunction() {
		var x = document.getElementById("myTopnav");
		if (x.className === "topnav") {
			x.className += " responsive";
		} else {
			x.className = "topnav";
		}
	}
</script>