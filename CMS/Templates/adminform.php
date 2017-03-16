<?php
include 'dbh.php';?>

	<!DOCTYPE HTML>
 <html>
	<head>
		<title> Site Administration </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="stylesheets/admin.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
	</head>
	
	<body>
		<h1> EDIT PAGES </h1>
		
		 <div class="tab">
		 <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Home')">HOME</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'About')">ABOUT</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Stylists')">STYLISTS</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Services')">SERVICES</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Photo')">PHOTO GALLERY</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Products')">PRODUCTS</a>
		</div>

		<div id="Home" class="tabcontent">
		  <h3><a href = "index.php">Home</h3></a>
			 
		</div>
		
		<div id="About" class="tabcontent">
		  <p> Begin typing in the form to create a new page element, or select an element from the archives below to edit or delete</p>
		  <form action='include/aboutaction.insert.php' method = 'POST' enctype='multipart/form-data'>
				Section Title:<br>
				<input type="text" name="title" value="Article Title"><br>
				Article Text:<br>
				<textarea rows="4" cols="50" name="text"></textarea>
				<br>
				Image input:<br>
				<input type="file" name="fileupload" value="fileupload" id="fileupload"><br><br>
				
				<input type="submit" value="Submit">
			</form> 
			<hr>
			<div id = "aboutArchive">
				<h3> Archives </h3>
			</div>
		</div>

		<div id="Stylists" class="tabcontent">
		  <p> Begin typing in the form to create a new page element, or select an element from the archives below to edit or delete</p>
		  
			<form action='include/stylistactionform.insert.php' method = 'POST' enctype='multipart/form-data'>
				Section Title:<br>
				<input type="text" name="title" value="Article Title"><br>
				Article Text:<br>
				<textarea rows="4" cols="50" name="text"></textarea>
				<br>
				Image input:<br>
				<input type="file" name="fileupload" value="fileupload" id="fileupload"><br><br>				
				<input type="submit" value="Submit">
			</form> 
			<hr>
			<div id = "stylistsArchive">
				<h3> Archives </h3>
				 

					<?php
						//query database and get variables set
						$sql = "SELECT * FROM stylists";
						$result = mysqli_query($conn, $sql);
						
						//while there's something in the database, output to screen
						while($row = $result->fetch_object()){ ?>
						
				<form action = 'include/stylistsactionform.delete.php' method = 'POST'>
							<a href = "index.php"><?php echo $row->Title;?></a> 
							<input type="hidden" name="ID" value="<?php echo htmlspecialchars($row->ID); ?>">
							<input type="submit" name="submit" value="Delete"><br>
				</form>
					<?php
						}
					?>
					
			</div>
		</div>

		<div id="Services" class="tabcontent">
		  <p> Begin typing in the form to create a new page element, or select an element from the archives below to edit or delete</p>
		  
			<form action='include/servicesaction.insert.php' method = 'POST' enctype='multipart/form-data'>
				Section Title:<br>
				<input type="text" name="title" value="Article Title"><br>
				Article Text:<br>
				<textarea rows="4" cols="50" name="text"></textarea>
				<br>
				Image input:<br>
				<input type="file" name="fileupload" value="fileupload" id="fileupload"><br><br>
				
				<input type="submit" value="Submit">
			</form> 
			<hr>
			<div id = "servicesArchive">
				<h3> Archives </h3>
			</div>
		</div>
		
		<div id="Photo" class="tabcontent">
		  <p> Begin typing in the form to create a new page element, or select an element from the archives below to edit or delete</p>
		  
			<form action='include/photoactionform.insert.php' method = 'POST' enctype='multipart/form-data'>
				Input new images --
				Image input:<br>
				<input type="file" name="fileupload" value="fileupload" id="fileupload"><br><br>
				
				<input type="submit" value="Submit">
			</form> 
			<hr>
			<div id = "photoArchive">
				<h3> Archives </h3>
				
				
			</div>
		</div>
		
		<div id="Products" class="tabcontent">
		  <p> Begin typing in the form to create a new page element, or select an element from the archives below to edit or delete</p>
		 
			<form action='include/stylistactionform.insert.php' method = 'POST' enctype='multipart/form-data'>
				Section Title:<br>
				<input type="text" name="title" value="Article Title"><br>
				Article Text:<br>
				<textarea rows="4" cols="50"></textarea>
				<br>
				Image input:<br>
				<input type="file" name="fileupload" value="fileupload" id="fileupload"><br><br>
				
				<input type="submit" value="Submit">
			</form> 
			<hr>
			<div id = "productsArchive">
				<h3> Archives </h3>
			</div>
		</div>

		<script>		
		/*JavaScript to make tabs active*/
		function openTab(evt, tabName) {
			// Declare all variables
			var i, tabcontent, tablinks;

			// Get all elements with class="tabcontent" and hide them
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}

			// Get all elements with class="tablinks" and remove the class "active"
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}

			// Show the current tab, and add an "active" class to the link that opened the tab
			document.getElementById(tabName).style.display = "block";
			evt.currentTarget.className += " active";
		}
		</script>		
	</body>
</html>