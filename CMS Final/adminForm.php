<?php 
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('Location: admin.php');
		exit();
	}

	if(isset($_SESSION['id'])) {

		$title = 'ADMIN';

		//connect to database
		include 'dbh.php';

		//if upload button is pressed
		if(isset($_POST['createLogo'])) {

			//path to store uploaded image
			$target = "img/".basename($_FILES['logoImg']['name']);

			//get submitted data from form
			$logoImg = addslashes($_FILES['logoImg']['name']);
			$logoImgTmp = addslashes($_FILES['logoImg']['tmp_name']);

			//check whether file is image or not
			$img_size = getimagesize($_FILES['logoImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//check whether file is image or not
			if($img_size == FALSE) {
				header("Location: adminForm.php?error=file");
				exit();
			}
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: adminForm.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["logoImg"]["size"] > 5000000) {
				header("Location: adminForm.php?image=size");
				exit();
			} 
			//file already exists
			if (file_exists($target)) {
				header("Location: adminForm.php?file=exists");
				exit();
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


			<?php 
				//nav bar, etc. 
				include 'includes/headerAdmin.php';

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
							</form><br>

							<a href = 'index.php'><button>VIEW CHANGES</button></a><br>";
					}
				}
			?>

			</div>

			<br><br><hr><br><br>

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
		</div>
	</body>
</html>

<?php
	//redirect user to login form if not logged in
	} else {
		redirect();
	}
?>