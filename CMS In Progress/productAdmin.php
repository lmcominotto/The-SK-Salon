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
		if(isset($_POST['create'])) {

			//the path to store the uploaded image
			$target = "img/".basename($_FILES['productImg']['name']);

			//get submitted data from form
			$productTitle = $_POST['productTitle'];
			$productInfo = $_POST['productInfo'];
			$productImgTmp = addslashes($_FILES['productImg']['tmp_name']);
			$productImg = addslashes($_FILES['productImg']['name']);
			$img_size = getimagesize($_FILES['productImg']['tmp_name']);

			//check whether file is image or not
			if($img_size == FALSE) {
				echo "File selected is not an image.";
			} else {
				//insert into database PRODUCTS
				$sql = "INSERT INTO products(productTitle, productInfo, productImg) VALUES ('$productTitle', '$productInfo', '$productImg')";
				$result = mysqli_query($conn, $sql);

				//check whether insert query executed
				if(!$result) {
					echo "There was an error uploading product information.<br>"; 
				}

				//check whether file has been moved to image file
				if(!move_uploaded_file($_FILES['productImg']['tmp_name'], $target)) {
						echo "There was a problem uploading the image.";
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
				
				<h1>PRODUCTS</h1>
				
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

					<form action = "productAdmin.php" method = "POST" enctype = "multipart/form-data">
							
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

				<hr><br><br>

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
			
			
			<?php
				} else {
					//redirects to login form if not logged in
					redirect();
				} 
			?>
		</body>
	</html>
