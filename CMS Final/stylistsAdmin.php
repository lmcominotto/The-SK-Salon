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
	
	//connect to database
	include 'dbh.php';

	if(isset($_SESSION['id'])) {

		$title = 'STYLISTS';

		//if upload button is pressed
		if(isset($_POST['create'])) {

			//the path to store the uploaded image
			$target = "img/".basename($_FILES['stylistImg']['name']);

			//get submitted data from form
			$stylistTitle = test_input($_POST['stylistTitle']);
			$stylistTitle = mysqli_real_escape_string($conn, $_POST['stylistTitle']);
			$stylistInfo = test_input($_POST['stylistInfo']);
			$stylistInfo = mysqli_real_escape_string($conn, $_POST['stylistInfo']);

			$stylistImgTmp = addslashes($_FILES['stylistImg']['tmp_name']);
			$stylistImg = addslashes($_FILES['stylistImg']['name']);
			$img_size = getimagesize($_FILES['stylistImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//check whether file is image or not
			if($img_size == FALSE) {
				header("Location: stylistsAdmin.php?error=file");
				exit();
			} 
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: stylistsAdmin.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["stylistImg"]["size"] > 5000000) {
				header("Location: stylistsAdmin.php?image=size");
				exit();
			} 
			//file already exists
			if (file_exists($target)) {
				header("Location: stylistsAdmin.php?file=exists");
				exit();
			} else {
				//insert into database stylists
				$sql = "INSERT INTO stylists(stylistTitle, stylistInfo, stylistImg) VALUES ('$stylistTitle', '$stylistInfo', '$stylistImg')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					header("Location: stylistsAdmin.php?upload=failed"); 
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['stylistImg']['tmp_name'], $target)) {
					header("Location: stylistsAdmin.php?error=image"); 
					exit();
				} else {
					header("Location: stylistsAdmin.php?upload=success");
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

				<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST" enctype = "multipart/form-data">
						
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

			<br><br><hr><br><br>

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
	</body>
</html>

<?php
	//redirect user to login form if not logged in
	} else {
		redirect();
	}
?>