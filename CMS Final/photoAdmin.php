<?php
	//must assure every single page in website has this
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header( 'location: admin.php');
		exit();
	}
	
	if(isset($_SESSION['id'])) {

		$title = 'PHOTOS';

		//connect to database
		include 'dbh.php';
		
		// Check if image file is a actual image
		if(isset($_POST['addPhoto'])) {

			//path to store uploaded image
			$target = "img/".basename($_FILES['gallery']['name']);

			//get submitted data from form
			$galleryImg = addslashes($_FILES['gallery']['name']);
			$galleryImgTmp = addslashes($_FILES['gallery']['tmp_name']);

			//check whether file is image or not
			$img_size = getimagesize($_FILES['gallery']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));

			//check whether file is image or not
			if($img_size == FALSE) {
				header("Location: photoAdmin.php?error=file");
				exit();
			}
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: photoAdmin.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["gallery"]["size"] > 5000000) {
				header("Location: photoAdmin.php?image=size");
				exit();
			}
			//check if file already exists
			if (file_exists($target)) {
				header("Location: photoAdmin.php?file=exists");
				exit();
			} else {
				$sql = "INSERT INTO photoGallery (galleryImg) VALUES ('$galleryImg')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					header("Location: photoAdmin.php?upload=failed");
					exit(); 
				}
				//check whether file has been moved to image file
				if (!move_uploaded_file($_FILES["gallery"]["tmp_name"], $target)) {
					header("Location: photoAdmin.php?error=image");
					exit();
				} else {
					header("Location: photoAdmin.php?upload=success");
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

			<div class = "sectionTitleNew">
				ADD NEW CONTENT<br>
			</div>

			<div class = "adminLogIn">
				<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST" enctype = "multipart/form-data">
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

					//select all from photoGallery table in database
					$sql_One = "SELECT * FROM photoGallery";
					$result_One = mysqli_query($conn, $sql_One);
					$count = 1;
					$photoCount = 0;

					//if there is anything in database, display
					if($result_One->num_rows > 0) {
							
						//displays current record of what's on website and can also delete
						echo "
							<form action = 'photoAdminDelete.php' method = 'POST' style = 'float: left;'>";
								while ($row = mysqli_fetch_array($result_One)) {
									echo "
									<div id = 'gallery'>
									<img src = 'img/" .$row['galleryImg']. "' width = '250'><br>
									<input type = 'checkbox' name = 'check[]' value = '" .$row['ID']. "'>
									</div>";

									$photoCount++;
									if($photoCount % 3 == 0) {
										echo "<br><br>";
									}
								}
								
								echo "
								<br><button type = 'submit' name = 'deletePhoto'>DELETE</button><br><br>
							</form>";
											
					}
			?>
			
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