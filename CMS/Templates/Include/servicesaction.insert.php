<?php

	include '../dbh.php';
	
	//script to upload file to appropriate location
	$target_dir = "../img/";
	$target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	// Check if image file is a actual image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileupload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	 // Check file size
	if ($_FILES["fileupload"]["size"] > 5000000) {
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
		echo "Sorry, your file was not uploaded.  ";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileupload"]["name"]). " has been uploaded.  ";
			echo "All changes have been saved.";
			?>
		<html>
			<body>
			<br>
				<a href = "../adminform.php">Click here</a> to go return to editing.<br>
				<a href = "../index.php">Click here</a> to go back to the main homepage.<br>
			</body>
		</html>
	<?php
			
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	//sets variables and runs query
	$title = $_POST['title'];
	$text = $_POST['text'];
	
	//SQL query to insert new row into table
	$sql = "INSERT INTO services(Title, Text, Image) VALUES ('$title', '$text', 'img/$target_file')";
	$result = mysqli_query($conn, $sql);
	

	?>