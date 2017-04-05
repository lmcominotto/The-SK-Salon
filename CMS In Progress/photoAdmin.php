<?php
	//must assure every single page in website has this
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header( 'location: admin.php');
		exit();
	}
	
	if(isset($_SESSION['id'])) {

		//connect to database
		include 'dbh.php';
		
		// Check if image file is a actual image
		if(isset($_POST['addPhoto'])) {

			//script to upload file to appropriate location
			$target_dir = "img/";
			$target_file = $target_dir .basename($_FILES["gallery"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			$galleryImg = addslashes($_FILES['gallery']['name']);

			$check = getimagesize($_FILES["gallery"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}

			// Check if file already exists
			/*
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			} */

			 // Check file size
			if ($_FILES["gallery"]["size"] > 5000000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				header("Location: photoAdmin.php?upload=failed");
			// if everything is ok, try to upload file
			} else {
				$sql = "INSERT INTO photoGallery (galleryImg) VALUES ('$galleryImg')";
				$result = mysqli_query($conn, $sql);
				if (move_uploaded_file($_FILES["gallery"]["tmp_name"], $target_file)) {
					header("Location: photoAdmin.php?upload=success");
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

				<h1>PHOTOS</h1>
				
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
					<form action = "photoAdmin.php" method = "POST" enctype = "multipart/form-data">
						<b>Add images to the Photo Gallery</b><br><br>
						
						<input type = "file" name = "gallery" value = "gallery"><br><br><br>
						
						<button type = 'submit' name = 'addPhoto'>UPLOAD</button><br><br>
					</form>

					<a href = "Photos.php"><button>VIEW CHANGES</button></a><br><br>
					
					<hr><br>
				</div>

				<div class = "sectionTitleCurrent">
						EDIT CURRENT CONTENT<br>
				</div>
				
				<div class = "galleryAdmin">

				<?php
						echo "";

						//select all from photoGallery table in database
						$sql_One = "SELECT * FROM photoGallery";
						$result_One = mysqli_query($conn, $sql_One);
						$count = 1;

						//if there is anything in database, display
						if($result_One->num_rows > 0) {

							while ($row = mysqli_fetch_array($result_One)) {
								
								//displays current record of what's on website and can also delete
								echo "
										<form action = 'photoAdminDelete.php' method = 'POST' style = 'float: left;'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
											<img src = 'img/" .$row['galleryImg']. "' id = 'gallery' width = '200'><br>
											
											<button type = 'submit' name = 'deletePhoto'>DELETE</button>
										</form>";
							}
						}
				?>
				</div>
			</div>

			<?php
				} else {
					//redirects to login form if not logged in
					redirect();
				} 
			?>
			
		</body>
	</html>