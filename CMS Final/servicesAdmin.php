<?php
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('Location: admin.php');
		exit();
	}

	//form validation
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if(isset($_SESSION['id'])) {

		$title = 'SERVICES';
	
		//connect to database
		include 'dbh.php';

		//if upload button is pressed
		if(isset($_POST['createService'])) {

			//get submitted data from form
			$serviceTitle = test_input($_POST['serviceTitle']);
			$serviceTitle = mysqli_real_escape_string($conn, $_POST['serviceTitle']);
			$serviceInfo = test_input($_POST['serviceInfo']);
			$serviceInfo = mysqli_real_escape_string($conn, $_POST['serviceInfo']);

			$sql_One = "INSERT INTO services(serviceTitle, serviceInfo) VALUES ('$serviceTitle', '$serviceInfo')";
			$result_One = mysqli_query($conn, $sql_One);

			if($result_One) {
				header("Location: servicesAdmin.php?upload=success");
				exit();
			} else {
				header("Location: servicesAdmin.php?upload=failed");
				exit();
			}
		} 

		else if (isset($_POST['createImg'])) {

			//the path to store the uploaded image
			$target = "img/".basename($_FILES['serviceImg']['name']);

			//from form 
			$serviceImgTmp = addslashes($_FILES['serviceImg']['tmp_name']);
			$serviceImg = addslashes($_FILES['serviceImg']['name']);

			//check whether file type is image
			$img_size = getimagesize($_FILES['serviceImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//check whether file is image or not
			if($img_size == FALSE) {
				header("Location: servicesAdmin.php?error=file");
				exit();
			} 
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: servicesAdmin.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["serviceImg"]["size"] > 5000000) {
				header("Location: servicesAdmin.php?image=size");
				exit();
			} 
			//file already exists
			if (file_exists($target)) {
				header("Location: servicesAdmin.php?file=exists");
				exit();
			} else {
				//insert into database aboutSK
				$sql_Two = "INSERT INTO services(serviceInfo) VALUES ('$serviceImg')";
				$result_Two = mysqli_query($conn, $sql_Two);

				//check whether insert query executed
				if(!$result_Two) {
					header("Location: servicesAdmin.php?upload=failed");
					exit(); 
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['serviceImg']['tmp_name'], $target)) {
					header("Location: servicesAdmin.php?error=image");
					exit();
				} else {
					header("Location: servicesAdmin.php?upload=success");
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

			<div class = 'adminLogIn'>

				<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
						
					<b>To add more content to the Service page, input information in the forms below:</b><br><br><br>

					<label for = 'serviceTitle'>Service Title</label><br>
					<input type = 'text' name = 'serviceTitle' ><br><br>
											
					<label for = 'serviceInfo'>Service Description</label><br>
					<textarea name = "serviceInfo" rows = "8" cols = "56"></textarea><br><br>
								
					<button type = 'submit' name = 'createService'>UPLOAD</button><br><br><br>
				</form><br>

				<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST" enctype = "multipart/form-data">

					<input type = 'hidden' name = 'size' value = '1000000'>

					<label for = 'serviceImg'>Post Image</label><br>
					<input type = "file" name = "serviceImg" value = "serviceImg" id = "serviceImg"><br><br><br>
								
					<button type = 'submit' name = 'createImg'>UPLOAD</button><br><br>
				</form>

				<a href = "Services.php"><button>VIEW CHANGES</button></a><br>

			</div>

			<br><br><hr><br><br>

			<div class = "sectionTitleCurrent">
				EDIT CURRENT CONTENT<br>
			</div><br><br>

			<div class = "archives">

				<?php
			
				$sql = "SELECT * FROM services";
				$result = mysqli_query($conn, $sql);
				$cnt = 1;

				//if there are results in database, output
				if($result->num_rows > 0) {
					
					while ($row = mysqli_fetch_array($result)) {
						echo "<div class = 'archiveTwo'>
								<p class = 'subsectionTitle'>POST $cnt</p><br>";
						$cnt++;
						
						$checkFile = $row['serviceInfo'];
						$extension = strtolower(pathinfo($checkFile, PATHINFO_EXTENSION));

						//if post is an image
						if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
							echo "
									<form action = 'updateServices.php' method = 'POST' enctype = 'multipart/form-data'>
							
										<input type = 'hidden' name = 'size' value = '1000000'>
										<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

										<label>Post Image</label><br>
										<img src = 'img/" .$row['serviceInfo']. "'><br>
										<label>Update Image</label><br>
										<input type = 'file' name = 'serviceImg' value = 'serviceImg' id = 'serviceImg'><br><br>
										<button type = 'submit' name = 'updateImg'>UPDATE</button><br><br>
									</form>";

							//delete record option
							echo "
									<form action = 'deleteServices.php' method = 'POST'>
										<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
										<button type = 'submit' name = 'deleteImg'>DELETE</button><br><br><br>
									</form>
									</div>";

						} else {
							//displays current (text only) record of what's on website and can also update
							echo "
									<form action = 'updateServices.php' method = 'POST'>
								
										<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

										<label for = 'serviceTitle'>Service Title</label><br>
										<input type = 'text' name = 'serviceTitle' value = '" .$row['serviceTitle']. "'><br><br>
															
										<label for = 'serviceInfo'>Service Description</label><br>
										<textarea name = 'serviceInfo' rows = '8' cols = '56'>" .$row['serviceInfo']. "</textarea><br><br>
						
										<button type = 'submit' name = 'updateService'>UPDATE</button><br><br>
									</form>";

							//delete record option
							echo "
									<form action = 'deleteServices.php' method = 'POST'>
										<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>
										<button type = 'submit' name = 'deleteService'>DELETE</button><br><br><br>
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
	</body>
</html>

<?php
	//redirect user to login form if not logged in
	} else {
		redirect();
	}
?>
