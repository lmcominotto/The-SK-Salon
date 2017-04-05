<?php
	//must assure every single page in website has this
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header( 'location: admin.php');
		exit();
	}
	
	//connect to database
	include 'dbh.php';

	if(isset($_SESSION['id'])) {

		//if upload button is pressed
		if(isset($_POST['create'])) {

			//the path to store the uploaded image
			$target = "img/".basename($_FILES['stylistImg']['name']);

			//get submitted data from form
			$stylistTitle = $_POST['stylistTitle'];
			$stylistInfo = $_POST['stylistInfo'];
			$stylistImgTmp = addslashes($_FILES['stylistImg']['tmp_name']);
			$stylistImg = addslashes($_FILES['stylistImg']['name']);
			$img_size = getimagesize($_FILES['stylistImg']['tmp_name']);

			//check whether file is image or not
			if($img_size == FALSE) {
				echo "File selected is not an image.";
			} else {
				//insert into database stylists
				$sql = "INSERT INTO stylists(stylistTitle, stylistInfo, stylistImg) VALUES ('$stylistTitle', '$stylistInfo', '$stylistImg')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					echo "There was an error uploading stylist information.<br>"; 
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['stylistImg']['tmp_name'], $target)) {
						echo "There was a problem uploading the image.";
				} else {
					header("Location: stylistsAdmin.php?upload=success");
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
				
				<h1>STYLISTS</h1>
				
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

				<div class = 'adminLogIn'>

					<form action = "stylistsAdmin.php" method = "POST" enctype = "multipart/form-data">
							
						<b>To add more content to the Stylists page, input information in the form below:</b><br><br><br>

						<input type = 'hidden' name = 'size' value = '1000000'>

						<label for = 'stylistTitle'>Stylist Name</label><br>
						<input type = 'text' name = 'stylistTitle' ><br><br>
									
						<label for = 'stylistInfo'>Stylist Information</label><br>
						<textarea name = "stylistInfo" rows = "8" cols = "56"></textarea><br><br>

						<label for = 'stylistImg'>Stylist Photo</label><br>
						<input type = "file" name = "stylistImg" value = "stylistImg" id = "stylistImg"><br><br><br>
									
						<button type = 'submit' name = 'create'>UPLOAD</button><br><br>
					</form>

					<a href = "Stylists.php"><button>VIEW CHANGES</button></a><br>

				</div>

				<hr><br><br>

				<div class = "sectionTitleCurrent">
					EDIT CURRENT CONTENT<br>
				</div><br><br>

				<div class = "archives">

					<?php
					
						$sql = "SELECT * FROM stylists";
						$result = mysqli_query($conn, $sql);
						$cnt = 1;

						//if there are results in database, output
						if($result->num_rows > 0) {
							
							while ($row = mysqli_fetch_array($result)) {
								echo "<div class = 'archiveOne'>
										<p class = 'subsectionTitle'>STYLIST $cnt</p><br>";
								$cnt++;

								//displays current record of what's on website and can also update
								echo "
										<form action = 'updateStylists.php' method = 'POST' enctype = 'multipart/form-data'>
								
											<input type = 'hidden' name = 'size' value = '1000000'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

											<label for = 'stylistTitle'>Stylist Name</label><br>
											<input type = 'text' name = 'stylistTitle' value = '" .$row['stylistTitle']. "'><br><br>
														
											<label for = 'stylistInfo'>Stylist Information</label><br>
											<textarea name = 'stylistInfo' rows = '8' cols = '56'>" .$row['stylistInfo']. "</textarea><br><br>

											
											<label>Stylist Photo</label><br>
											<img src = 'img/" .$row['stylistImg']. "' name = 'stylistImg' value = 'stylistImg' id = 'stylistImg' width = '350'><br>
											<label>Update Photo</label><br>
											<input type = 'file' name = 'stylistImg' value = 'stylistImg' id = 'stylistImg'><br><br>
														
											<button type = 'submit' name = 'update'>UPDATE</button><br><br>
										</form>";

								//delete record option
								echo "
										<form action = 'deleteStylists.php' method = 'POST'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
											<button type = 'submit' name = 'delete'>DELETE</button><br><br><br>
										</form>
									  </div>";
							} 
						} else {
							echo "0 results<br>";
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