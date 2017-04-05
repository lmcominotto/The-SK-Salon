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

		//if upload button is pressed
		if(isset($_POST['createPost'])) {

			//get submitted data from form
			$postTitle = $_POST['postTitle'];
			$postInfo = $_POST['postInfo'];

			$sql_One = "INSERT INTO aboutSK(postTitle, postInfo) VALUES ('$postTitle', '$postInfo')";
			$result_One = mysqli_query($conn, $sql_One);

			if($result_One) {
				header("Location: aboutAdmin.php?upload=success");
				exit();
			} else {
				header("Location: aboutAdmin.php?upload=failed");
				exit();
			}
		} 

		else if (isset($_POST['createImg'])) {

			//the path to store the uploaded image
			$target = "img/".basename($_FILES['postImg']['name']);

			//from form 
			$postImgTmp = addslashes($_FILES['postImg']['tmp_name']);
			$postImg = addslashes($_FILES['postImg']['name']);
			$img_size = getimagesize($_FILES['postImg']['tmp_name']);

			//check whether file is image or not
			if($img_size == FALSE) {
				echo "File selected is not an image.";
			} else {
				//insert into database aboutSK
				$sql_Two = "INSERT INTO aboutSK(postInfo) VALUES ('$postImg')";
				$result_Two = mysqli_query($conn, $sql_Two);

				//check whether insert query executed
				if(!$result_Two) {
					echo "There was an error uploading stylist information.<br>";
					//header("Location: aboutAdmin.php?upload=failed"); 
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['postImg']['tmp_name'], $target)) {
						echo "There was a problem uploading the image.";
						header("Location: aboutAdmin.php?error=image");
				} else {
					header("Location: aboutAdmin.php?upload=success");
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
			<link rel ="stylesheet" type = "text/css" href="css/backStyle.css">
			<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
		</head>
		
		<body>
			<div class = "content">
				<div class = "log">
					<button><a href = "includes/logout.inc.php">LOG OUT</a></button>
				</div>
				
				<h1>ABOUT</h1>
				
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

					<form action = "aboutAdmin.php" method = "POST">
							
						<b>To add more content to the About page, input information in the forms below:</b><br><br><br>

						<label for = 'postTitle'>Post Title</label><br>
						<input type = 'text' name = 'postTitle' ><br><br>
												
						<label for = 'postInfo'>Post Description</label><br>
						<textarea name = "postInfo" rows = "8" cols = "56"></textarea><br><br>
									
						<button type = 'submit' name = 'createPost'>UPLOAD</button><br><br><br>
					</form>

					<form action = "aboutAdmin.php" method = "POST" enctype = "multipart/form-data">

						<input type = 'hidden' name = 'size' value = '1000000'>

						<label for = 'postImg'>Post Image</label><br>
						<input type = "file" name = "postImg" value = "postImg" id = "postImg"><br><br><br>
									
						<button type = 'submit' name = 'createImg'>UPLOAD</button><br><br>
					</form>

					<a href = "About.php"><button>VIEW CHANGES</button></a><br>
				</div>

				<hr><br><br>

				<div class = "sectionTitleCurrent">
					EDIT CURRENT CONTENT<br>
				</div><br><br>

				<div class = "archives">

					<?php
					
						$sql = "SELECT * FROM aboutSK";
						$result = mysqli_query($conn, $sql);
						$cnt = 1;

						//if there are results in database, output
						if($result->num_rows > 0) {
							
							while ($row = mysqli_fetch_array($result)) {
								echo "<div class = 'archiveTwo'>
										<p class = 'subsectionTitle'>POST $cnt</p><br>";
								$cnt++;
								
								$checkFile = $row['postInfo'];
								$extension = pathinfo($checkFile, PATHINFO_EXTENSION);

								//if post is an image
								if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
									echo "
										<form action = 'updateAbout.php' method = 'POST' enctype = 'multipart/form-data'>
								
											<input type = 'hidden' name = 'size' value = '1000000'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

											<label>Post Image</label><br>
											<img src = 'img/" .$row['postInfo']. "' width = '400'><br>
											<label>Update Image</label><br>
											<input type = 'file' name = 'postImg' value = 'postImg' id = 'postImg'><br><br>
											<button type = 'submit' name = 'updateImg'>UPDATE</button><br><br>
										</form>";

								//delete record option
								echo "
										<form action = 'deleteAbout.php' method = 'POST'>
											<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
											<button type = 'submit' name = 'deleteImg'>DELETE</button><br><br><br>
										</form>
										</div>";

								} else {
									//displays current (text only) record of what's on website and can also update
									echo "
											<form action = 'updateAbout.php' method = 'POST'>
										
												<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

												<label for = 'postTitle'>Post Title</label><br>
												<input type = 'text' name = 'postTitle' value = '" .$row['postTitle']. "'><br><br>
																	
												<label for = 'postInfo'>Post Description</label><br>
												<textarea name = 'postInfo' rows = '8' cols = '56'>" .$row['postInfo']. "</textarea><br><br>
								
												<button type = 'submit' name = 'updatePost'>UPDATE</button><br><br>
											</form>";

									//delete record option
									echo "
											<form action = 'deleteAbout.php' method = 'POST'>
												<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
												<button type = 'submit' name = 'deletePost'>DELETE</button><br><br><br>
											</form>
											</div>";
									} 
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