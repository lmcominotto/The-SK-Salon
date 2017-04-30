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

		$title = 'PRODUCTS';
	
		//connect to database
		include 'dbh.php';

		//if upload button is pressed
		if(isset($_POST['create'])) {

			//the path to store the uploaded image
			$target = "img/".basename($_FILES['productImg']['name']);

			//get submitted data from form
			$productTitle = test_input($_POST['productTitle']);
			$productTitle = mysqli_real_escape_string($conn, $_POST['productTitle']);
			$productInfo = test_input($_POST['productInfo']);
			$productInfo = mysqli_real_escape_string($conn, $_POST['productInfo']);

			$productImgTmp = addslashes($_FILES['productImg']['tmp_name']);
			$productImg = addslashes($_FILES['productImg']['name']);
			$img_size = getimagesize($_FILES['productImg']['tmp_name']);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

			//check whether file is image or not
			if($img_size == FALSE) {
				header("Location: productAdmin.php?error=file");
				exit();
			} 
			//file type not allowed
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				header("Location: productAdmin.php?error=file");
				exit();
			}
			//file too large
			if ($_FILES["productImg"]["size"] > 5000000) {
				header("Location: productAdmin.php?image=size");
				exit();
			} 
			//file already exists
			if (file_exists($target)) {
				header("Location: productAdmin.php?file=exists");
				exit();
			} else {
				//insert into database PRODUCTS
				$sql = "INSERT INTO products(productTitle, productInfo, productImg) VALUES ('$productTitle', '$productInfo', '$productImg')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					header("Location: productAdmin.php?upload=failed"); 
					exit();
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['productImg']['tmp_name'], $target)) {
					header("Location: productAdmin.php?error=image"); 
					exit();
				} else {
					header("Location: productAdmin.php?upload=success");
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
						
					<b>To add more content to the products page, input information in the form below:</b><br><br><br>

					<input type = 'hidden' name = 'size' value = '1000000'>

					<label for = 'productTitle'>Product Title</label><br>
					<input type = 'text' name = 'productTitle' ><br><br>
								
					<label for = 'productInfo'>Product Description</label><br>
					<textarea name = "productInfo" rows = "8" cols = "56"></textarea><br><br>

					<label for = 'productImg'>Product Image</label><br>
					<input type = "file" name = "productImg" value = "productImg" id = "productImg"><br><br>
								
					<button type = 'submit' name = 'create'>UPLOAD</button><br><br>
				</form>

				<a href = "Products.php"><button>VIEW CHANGES</button></a><br>
			</div>

			<br><br><hr><br><br>

			<div class = "sectionTitleCurrent">
				EDIT CURRENT CONTENT<br>
			</div><br><br>

			<div class = "archives">

				<?php
				
					$sql = "SELECT * FROM products";
					$result = mysqli_query($conn, $sql);
					$productNum = 1;

					//if there are results in database, output
					if($result->num_rows > 0) {
						
						while ($row = mysqli_fetch_array($result)) {
							echo "<div class = 'archiveOne'>
									<p class = 'subsectionTitle'>PRODUCT $productNum</p><br>";
							$productNum++;

							//displays current record of what's on website and can also update
							echo "
									<form action = 'updateProduct.php' method = 'POST' enctype = 'multipart/form-data'>
							
										<input type = 'hidden' name = 'size' value = '1000000'>
										<input type = 'hidden' name = 'id' value = '" .$row['ID']. "'>

										<label for = 'productTitle'>Product Title</label><br>
										<input type = 'text' name = 'productTitle' value = '" .$row['productTitle']. "'><br><br>
													
										<label for = 'productInfo'>Product Description</label><br>
										<textarea name = 'productInfo' rows = '8' cols = '56'>" .$row['productInfo']. "</textarea><br><br>

										<label>Product Image</label><br>
										<img src = 'img/" .$row['productImg']. "' width = '400'><br>
										<label>Update Image</label><br>
										<input type = 'file' name = 'productImg' value = 'productImg' id = 'productImg'><br><br>
													
										<button type = 'submit' name = 'update'>UPDATE</button><br><br>
									</form>";

							//delete record option
							echo "
									<form action = 'deleteProduct.php' method = 'POST'>
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