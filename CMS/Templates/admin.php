 <!DOCTYPE HTML>
 <html>
	<head>
		<title> Edit Content </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel ="stylesheet" href="stylesheets/admin.css">
	</head>
	
	<body>
		<h1> Edit Pages </h1>
		
		 <div class="tab">
		 <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Home')">HOME</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'About')">ABOUT</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Stylists')">STYLISTS</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Services')">SERVICES</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Photo')">PHOTO GALLERY</a>
		  <a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Products')">PRODUCTS</a>
		</div>

		<div id="Home" class="tabcontent">
		  <h3>Home</h3>
			<form>
			<form action="/action_page.php">
				First name:<br>
				<input type="text" name="firstname" value="Mickey"><br>
				Last name:<br>
				<input type="text" name="lastname" value="Mouse"><br><br>
				<input type="submit" value="Submit">
			</form> 
		</div>
		
		<div id="About" class="tabcontent">
		  <h3>About</h3>
		  <form>
			<form action="/action_page.php">
				Title:<br>
				<input type="text" name="title" value="Article Title"><br>
				Article Test:<br>
				<input type="text" name="arttext" value="Place article text here"><br><br>
				<input type="submit" value="Submit">
			</form> 
		</div>

		<div id="Stylists" class="tabcontent">
		  <h3>Stylists</h3>
		  <p>This div shows content for Stylists.</p>
		</div>

		<div id="Services" class="tabcontent">
		  <h3>Services</h3>
		  <p>This div shows content for Services.</p>
		</div>
		
		<div id="Photo" class="tabcontent">
		  <h3>Photo Gallery</h3>
		  <p>This div shows content for Photo Gallery.</p>
		</div>
		
		<div id="Products" class="tabcontent">
		  <h3>Products</h3>
		  <p>This div shows content for Products.</p>
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