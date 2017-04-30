<?php
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('Location: admin.php');
		exit();
	}
	
	if(isset($_SESSION['id'])) {

		//connect to database
		include 'dbh.php';

		//if upload form submitted - no image
		if(isset($_POST['updateInventory'])) {

			$UPC = $_POST['UPC'];
			$add = $_POST['add'];
			$remove = $_POST['remove'];

			//check if item is in inventory first
			$sql_check = "SELECT * FROM inventory WHERE UPC = '$UPC'";
			$result_check = mysqli_query($conn, $sql_check);

			if($result_check->num_rows == 0)
			{
				//not in inventory!
				header("Location: inventoryAdmin.php?UPC=unavailable");
				exit();
			} else {
				//is in inventory!

				$row = mysqli_fetch_array($result_check);

				//record of current product quantity
				$rowQuantity = $row['quantityAvail'];

				//add to current inventory
				if(empty($remove) or $remove == 0) {
					$updateVal = $add;
					
					$newQuantity = $rowQuantity + $updateVal;
				} else if(empty($add) or $add == 0) {
				  	//remove from current inventory
					$updateVal = $remove;
			
					$newQuantity = $rowQuantity - $updateVal;

					//if goes into negatives, just set new quantity to 0
					if($newQuantity < 0) {
						$newQuantity = 0;
					}
				} else {
					echo "<br>Can only add OR remove, not both.<br>";
					exit();
				}

				$sql = "UPDATE inventory SET quantityAvail = '$newQuantity' WHERE UPC = '$UPC'";

				if (mysqli_query($conn, $sql)) {
					header("Location: inventoryAdmin.php?update=success");
					exit();
				} else {
					header("Location: inventoryAdmin.php?update=failed");
					exit();
				} 
					
			}
		}
				
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Inventory</title>
		<link href="css/backStyle.css" rel ="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Rokkitt|Rochester" rel="stylesheet">
	</head>
	<body>
		<div class = "content">
			<div class = "log">
				<form action = "includes/logout.inc.php">
					<button>LOG OUT</button>
				</form>
			</div>

			<h1 class = "pageTitle">INVENTORY</h1>	

			<ul class = "topnav" id = "nav">
				<li><a href = "adminForm.php">ADMIN</a></li>
				<li><a href = "homepageAdmin.php">HOME</a></li>
				<li><a href = "aboutAdmin.php">ABOUT</a></li>
				<li><a href = "servicesAdmin.php">SERVICES</a></li>
				<li><a href = "stylistsAdmin.php">STYLISTS</a></li>
				<li><a href = "productAdmin.php">PRODUCTS</a></li>
				<li><a href = "photoAdmin.php">PHOTOS</a></li>
				<li><a href = "inventoryAdmin.php">INVENTORY</a></li>
				<li><a href = "customerAdmin.php">CUSTOMERS</a></li>
				<li class="icon">
					<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a> 
				</li>
			</ul>

			<?php
				//check for messages in URL and print description
				include 'includes/urlMsg.php'; 
			?>

			<p class = "floatText"><a href = "">VIEW INVENTORY REPORT</a></p><br>

			<div class = "sectionTitleCurrent">
				UPDATE ITEM<br>
			</div><br>

			<div class = "inventory">
				<form action = "" method = "POST">
					<label for = 'UPC'>Scan or Manually Type UPC#<input type = "text" name = "UPC"></label><br>

					<label for = 'add'>Add<input type = 'number' name = 'add'></label>&emsp;
				
					<label for = 'remove'>Remove<input type = 'number' name = 'remove'></label><br><br>

					<label><input type="submit" name="updateInventory" value="UPDATE"></label>

				</form>
			</div><br><br>

			<div class = "sectionTitleNew">
				ADD NEW ITEM<br>
			</div><br><br>

			<div class = "container">

			    <form class = "well form-horizontal" action = "NewItem.php" method = "POST" id = "NewItem">
					<fieldset>

					<style>
					Legend {
					  display: block;
					  width: 100%;
					  text-align: center;
					}
					</style>

					<!-- Form Name -->
					<legend>New Item</legend> 

					<!-- Text input: UPC-->
					<div class="form-group">
						<label class="col-md-4 control-label">UPC</label>  
					  	<div class="col-md-4 inputGroupContainer">
					 		<div class="input-group">
					  			<span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
					  			<input  name="UPC" placeholder="123456789123" class="form-control"  type="text">
							</div>
						</div>
					</div>

					<!-- Text input: Product Description-->
					<div class="form-group">
						<label class="col-md-4 control-label" >Description</label> 
					    <div class="col-md-4 inputGroupContainer">
					    	<div class="input-group">
						  		<span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
						  		<input name="description" placeholder="PM Ultimate Color Repair Shampoo" class="form-control"  type="text">
					    	</div>
					  	</div>
					</div>

					<!-- Text input: Quantity-->
					<div class="form-group">
						<label class="col-md-4 control-label">Quantity Available</label>  
					    <div class="col-md-4 inputGroupContainer">
					    	<div class="input-group">
						        <span class="input-group-addon"><i class="glyphicon glyphicon-sort"></i></span>
						  		<input name="quantityAvail" placeholder="3" class="form-control"  type="text">
							</div>
						</div>
					</div>


					<!-- Text input: Cost-->     
					<div class="form-group">
						<label class="col-md-4 control-label">Cost</label>  
						<div class="col-md-4 inputGroupContainer">
					    	<div class="input-group">
						        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
						  		<input name="cost" placeholder="Include tax if applicable. Ex: 12.50" class="form-control" type="text">
					    	</div>
					  	</div>
					</div>

					<!-- Text input: Price-->     
					<div class="form-group">
						<label class="col-md-4 control-label">Price</label>  
					    <div class="col-md-4 inputGroupContainer">
					    	<div class="input-group">
					        	<span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
					  			<input name="price" placeholder="Ex: 23.99" class="form-control" type="text">
					    	</div>
					  	</div>
					</div>


					<!-- Button -->
					<div class="form-group">
						<label class="col-md-4 control-label"></label>
					  	<div class="col-md-4">
					    	<button type="submit" class="btn btn-warning" >Send <span class="glyphicon glyphicon-send"></span></button>
					  	</div>
					</div>

					</fieldset>
				</form>
			</div>
		</div>
	
	<!-- End your own HTML above here: -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script>
		function myFunction() {
			var x = document.getElementById("nav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}
	</script>

  </body>
</html>
			

<?php
	} else {
		//redirects to login form if not logged in
		redirect();
	} 
?>