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

		$title = 'ABOUT';
	
		//connect to database
		include 'dbh.php';

		//if upload form submitted - no image
		if(isset($_POST['createPost'])) {

			//get submitted data from form
			$postTitle = test_input($_POST['postTitle']);
			$postTitle = mysqli_real_escape_string($conn, $_POST['postTitle']);
			$postInfo = test_input($_POST['postInfo']);
			$postInfo = mysqli_real_escape_string($conn, $_POST['postInfo']);

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
		//if upload form submitted and is image
		else if (isset($_POST['createImg'])) {

			//the path to store the uploaded image
			$target = "img/".basename($_FILES['postImg']['name']);

			//from form 
			$postImgTmp = addslashes($_FILES['postImg']['tmp_name']);
			$postImg = addslashes($_FILES['postImg']['name']);

			//check whether file is image or not
			$img_size = getimagesize($_FILES['postImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//not an image file
			if($img_size == FALSE) {
				header("Location: aboutAdmin.php?error=file");
				exit();
			}
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: aboutAdmin.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["postImg"]["size"] > 5000000) {
				header("Location: aboutAdmin.php?image=size");
				exit();
			} 
			//file already exists
			if (file_exists($target)) {
				header("Location: aboutAdmin.php?file=exists");
				exit();
			} else {
				//insert into database aboutSK
				$sql_Two = "INSERT INTO aboutSK(postInfo) VALUES ('$postImg')";
				$result_Two = mysqli_query($conn, $sql_Two);

				//check whether insert query executed
				if(!$result_Two) {
					header("Location: aboutAdmin.php?upload=failed"); 
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['postImg']['tmp_name'], $target)) {
					header("Location: aboutAdmin.php?error=image");
					exit();
				} else {
					header("Location: aboutAdmin.php?upload=success");
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

				<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
						
					<b>To add more content to the About page, input information in the forms below:</b><br><br><br>

					<label for = 'postTitle'>Post Title</label><br>
					<input type = 'text' name = 'postTitle' ><br><br>
											
					<label for = 'postInfo'>Post Description</label><br>
					<textarea name = "postInfo" rows = "8" cols = "56"></textarea><br><br>
								
					<button type = 'submit' name = 'createPost'>UPLOAD</button><br><br><br>
				</form><br>

				<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST" enctype = "multipart/form-data">

					<input type = 'hidden' name = 'size' value = '1000000'>

					<label for = 'postImg'>Post Image</label><br>
					<input type = "file" name = "postImg" value = "postImg" id = "postImg"><br><br><br>
								
					<button type = 'submit' name = 'createImg'>UPLOAD</button><br><br>
				</form>

				<a href = "About.php"><button>VIEW CHANGES</button></a><br>
			</div>

			<br><br><hr><br><br>

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
						$extension = strtolower(pathinfo($checkFile, PATHINFO_EXTENSION));

						//if post is an image
						if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
							echo "
								<form action = 'updateAbout.php' method = 'POST' enctype = 'multipart/form-data'>
						
									<input type = 'hidden' name = 'size' value = '1000000'>
									<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

									<label>Post Image</label><br>
									<img src = 'img/" .$row['postInfo']. "'><br>
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
	</body>
</html>

<?php
	//redirect user to login form if not logged in
	} else {
		redirect();
	} 
?>