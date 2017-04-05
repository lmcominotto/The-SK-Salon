<?php 
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('location: admin.php');
		exit();
	}

	if(isset($_SESSION['id'])) {

		//include database info
		include 'dbh.php';

		//carousel upload button
		if(isset($_POST['createCarousel'])) {
			//path to store uploaded image
			$target = "img/".basename($_FILES['carousel']['name']);

			//submitted data from form
			$carouselImg = addslashes($_FILES['carousel']['name']);;
			$carouselImgTmp = addslashes($_FILES['carousel']['tmp_name']);;
			$img_size = getimagesize($_FILES['carousel']['tmp_name']);

			if($img_size == FALSE) {
				header("Location: homepageAdmin.php?error=file");
				exit();
			} else {
				$sql = "INSERT INTO carousel(carouselImg) VALUES ('$carouselImg')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					header("Location: homepageAdmin.php?upload=failed"); 
					exit();
				} else {
					header("Location: homepageAdmin.php?upload=success");
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['carousel']['tmp_name'], $target)) {
					header("Location: homepageAdmin.php?error=image");
					exit();
				} 
			}

		}

		//main text upload button
		else if(isset($_POST['createMain'])) {
			//submitted data from form 
			$mainInfo = $_POST['mainInfo'];

			//insert into database homePage
			$sql = "INSERT INTO homePage(mainInfo) VALUES ('$mainInfo')";
			$result = mysqli_query($conn, $sql);

			//if query did not execute
			if(!$result) {
				header("Location: homepageAdmin.php?upload=failed");
				exit();
			} else {
				header("Location: homepageAdmin.php?upload=success");
				exit();
			}
		}

		//contact upload button
		else if(isset($_POST['createContact'])) {
			//path to store uploaded logo image
			$target = "img/".basename($_FILES['logoImg']['name']);

			//submitted data from form
			$contactTitle = $_POST['contactTitle'];
			$contactInfo = $_POST['contactInfo'];
			$contactLogo = addslashes($_FILES['logoImg']['name']);;
			$contactLogoTmp = addslashes($_FILES['logoImg']['tmp_name']);;
			$logo_size = getimagesize($_FILES['logoImg']['tmp_name']);

			//check whether file is image or not
			if($logo_size == FALSE) {
				header("Location: homepageAdmin.php?error=file");
				exit();
			} else {
				//insert into database contactHome
				$sql = "INSERT INTO contactHome(contactTitle, contactInfo, contactLogo) VALUES ('$contactTitle', '$contactInfo', '$contactLogo')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					header("Location: homepageAdmin.php?upload=failed");
					exit(); 
				} else {
					header("Location: homepageAdmin.php?upload=success");
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['logoImg']['tmp_name'], $target)) {
					header("Location: homepageAdmin.php?error=image");
					exit();
				} 
			}
		}
	?>

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

				<h1>HOMEPAGE</h1>
				
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
					ADD NEW CONTENT<br>
				</div>

				<div class = "adminLogIn">
					<p class = "subsectionTitle">CAROUSEL IMAGES</p><br>
					<b>Add images to the carousel on the homepage below:</b><br><br>
					<form action = "homepageAdmin.php" method = "POST" enctype = "multipart/form-data">
						<label for = 'carousel'>Carousel Image</label><br>
						<input type = "file" name = "carousel" value = "carousel" id = "carousel"><br><br>
						
						<button type = 'submit' name = 'createCarousel'>UPLOAD</button><br>
					</form>

					<br><br><br><br>

					<!--form for main content on page under carousel-->
					<p class = "subsectionTitle">MAIN CONTENT</p><br>
					<b>Add content to the main section of the homepage below:</b><br><br>
					<form action = "homepageAdmin.php" method = "POST">
						<label for = 'mainInfo'>Content</label><br>
						<textarea name = "mainInfo" rows = "8" cols = "56"></textarea><br><br>

						<button type = 'submit' name = 'createMain'>UPLOAD</button><br>
					</form>

					<br><br><br><br>

					<!--form for contant info at bottom of page-->
					<p class = "subsectionTitle">CONTACT INFORMATION</p><br>
					<b>Add contact information to the bottom of the homepage below:</b><br><br>
					<form action = "homepageAdmin.php" method = "POST" enctype = "multipart/form-data">
						<label for = 'contactLogo'>Logo</label><br>
						<input type = "file" name = "logoImg" value = "logoImg" id = "logoImg"><br><br>

						<label for = 'contactTitle'>Title</label><br>
						<input type = 'text' name = 'contactTitle' ><br><br>
						
						<label for = 'contactInfo'>Description</label><br>
						<textarea name = "contactInfo" rows = "8" cols = "56"></textarea><br><br>

						<button type = 'submit' name = 'createContact'>UPLOAD</button><br><br>
					</form>

					<a href = "index.php"><button>VIEW CHANGES</button></a><br>

					<hr><br><br>

					<div class = "sectionTitleCurrent">
						EDIT CURRENT CONTENT<br>
					</div>

				
					<?php
						echo "<br><b>Edit content on the homepage below:</b><br><br>";

						//select all from carousel table in database
						$sql_One = "SELECT * FROM carousel";
						$result_One = mysqli_query($conn, $sql_One);
						$count = 1;

						//if there is anything in database, display
						if($result_One->num_rows > 0) {
							echo "<p class = 'subsectionTitle'>CAROUSEL IMAGES</p><br>";

							while ($row = mysqli_fetch_array($result_One)) {
								echo "Carousel Image $count<br><br>";
										$count++;

								//displays current record of what's on website and can also delete
								echo "
										<form action = 'deleteHomepage.php' method = 'POST'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
											<img src = 'img/" .$row['carouselImg']. "' width = '400'><br>
											
											<button type = 'submit' name = 'deleteCarousel'>DELETE</button><br><br>
										</form>";
							}
						}

						echo "<br><br>";
						//select all from homePage table in database
						$sql_Two = "SELECT * FROM homePage";
						$result_Two = mysqli_query($conn, $sql_Two);

						//if there is anything in database, display
						if($result_Two->num_rows > 0) {
							echo "<p class = 'subsectionTitle'>MAIN CONTENT</p><br>";

							while ($row = mysqli_fetch_array($result_Two)) {

								//displays current record of what's on website and can also delete
								echo "	<form action = 'updateHomepage.php' method = 'POST'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

											<textarea name = 'mainInfo' rows = '8' cols = '56'>" .$row['mainInfo']. "</textarea><br><br>

											<button type = 'submit' name = 'updateMain'>UPDATE</button><br><br>
										</form>"; 

								//delete record option
								echo "
										<form action = 'deleteHomepage.php' method = 'POST'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
											<button type = 'submit' name = 'deleteMain'>DELETE</button><br><br><br>
										</form>";
							}
						}

						echo "<br><br>";
						//select all from contactHome table
						$sql_Three = "SELECT * FROM contactHome";
						$result_Three = mysqli_query($conn, $sql_Three);
						$count = 1;

						//if there is anything in database, display
						if($result_Three->num_rows > 0) {
							echo "<p class = 'subsectionTitle'>CONTACT INFORMATION</p><br><br>";

							while ($row = mysqli_fetch_array($result_Three)) {
								echo "<div class = 'archiveThree'>
										<p class = 'postTitle'>Contact Section $count</p><br><br>";
								$count++;

								//displays current record of what's on website and can also update/delete
								echo "
										<form action = 'updateHomepage.php' method = 'POST' enctype = 'multipart/form-data'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

											<label for = 'contactLogo'>Logo</label><br><br>
											<img src = 'img/" .$row['contactLogo']. "' width = '100'><br>
											<input type = 'file' name = 'logoImg' value = 'logoImg' id = 'logoImg'><br><br>

											<label for = 'contactTitle'>Title</label><br>
											<input type = 'text' name = 'contactTitle' value = '" .$row['contactTitle']. "'><br><br>
											
											<label for = 'contactInfo'>Description</label><br>
											<textarea name = 'contactInfo' rows = '8' cols = '56'>" .$row['contactInfo']. "</textarea><br><br>

											<button type = 'submit' name = 'updateContact'>UPDATE</button><br><br>
										</form>";

								//delete record option
								echo "
										<form action = 'deleteHomepage.php' method = 'POST'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
											<button type = 'submit' name = 'deleteContact'>DELETE</button><br><br><br>
										</form>
									</div>";
							}
						}
					?>
				</div>
				<?php

					} else {
						//redirects to login form if not logged in
						redirect();				
					} 
				?>
			</div>
		</body>
	</html>