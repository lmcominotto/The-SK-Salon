<?php 
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('location: admin.php');
		exit();
	}

	if(isset($_SESSION['id'])) {

		//connect to database
		include 'dbh.php';

		//if upload button is pressed
		if(isset($_POST['createLogo'])) {

			$target = "img/".basename($_FILES['logoImg']['name']);
			//get submitted data from form
			$logoImg = addslashes($_FILES['logoImg']['name']);
			$logoImgTmp = addslashes($_FILES['logoImg']['tmp_name']);
			$img_size = getimagesize($_FILES['logoImg']['tmp_name']);

			//check whether file is image or not
			if($img_size == FALSE) {
				echo "File selected is not an image.";
			} else {
				//insert into database siteLogo
				$sql = "INSERT INTO siteLogo(logoImg) VALUES ('$logoImg')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					header("Location: adminForm.php?upload=failed");
					exit(); 
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['logoImg']['tmp_name'], $target)) {
						header("Location: adminForm.php?error=image");
						exit();
				} else {
					header("Location: adminForm.php?upload=success");
					exit();
				}
			} 
		} 

?>

	<!DOCTYPE HTML>
	<html>
		<head>
			<title>Admin</title>
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

				<h1>ADMIN</h1>

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

				<div class = "sectionTitleCurrent">
					ALL PAGES<br>
				</div><br>

				<p class = "subsectionTitle">SITE LOGO</p>

				<div class = "adminLogIn">

				<?php
					$sql = "SELECT * FROM siteLogo";
					$result = mysqli_query($conn, $sql);

					//if no logo in database, display form to insert logo into database
					if ($result->num_rows == 0) {
						echo "
							<form action = 'adminForm.php' method = 'POST' enctype = 'multipart/form-data'>

								<input type = 'hidden' name = 'size' value = '1000000'>

								<label for = 'logoImg'>Choose Site Logo</label><br>
								<input type = 'file' name = 'logoImg' value = 'logoImg' id = 'logoImg'><br><br>
											
								<button type = 'submit' name = 'createLogo'>UPLOAD</button><br><br>
							</form>";
					} else {  //display form to allow logo to be updated
						while ($row = mysqli_fetch_array($result)) {
							echo "
								<form action = 'updateSiteLogo.php' method = 'POST' enctype = 'multipart/form-data'>
						
									<input type = 'hidden' name = 'size' value = '1000000'>
									<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

									<img src = 'img/" .$row['logoImg']. "' width = '600'><br><br>
									<input type = 'file' name = 'logoImg' value = 'logoImg' id = 'logoImg'><br><br>
									<button type = 'submit' name = 'updateLogo'>UPDATE</button><br>
								</form>";
						}
					}
				?>

				</div>

				<hr><br><br>

				<div class = "sectionTitleCurrent">
					ADMIN USERS<br>
				</div>

				<div class = "adminLogIn">

					<form action = "viewUsers.php">
						<button>VIEW USERS</button>
					</form><br>

					<form action = "signup.php">
						<button>ADD NEW USER</button>
					</form><br>

				</div>

<?php
	//redirect user to login form if not logged in
	} else {
		redirect();
	}
?>

		</div>
	</body>
</html>
