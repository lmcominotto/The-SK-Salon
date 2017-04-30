<?php
	session_start();

	//redirect to login form if not logged in
	function redirect() {
		header('Location: admin.php');
		exit();
	}
	
	if(isset($_SESSION['id'])) {

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Customers</title>
		<link rel ="stylesheet" href="css/backStyle.css">
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

			<h1 class = "pageTitle">CUSTOMERS</h1>	

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

			<p class = "floatText"><a href = "customerreport.php">VIEW CUSTOMER REPORT</a></p><br>

			<div class = "sectionTitleNew">
				ADD NEW CUSTOMER<br>
			</div><br><br>

			<div class = "container">

		    <form class = "well form-horizontal" action = "NewCustomer.php" method = "POST"  id = "NewCustomer">
				<fieldset>

				<style>
				Legend {
				  display: block;
				  width: 100%;
				  text-align: center;
				}
				</style>

				<!-- Form Name -->
				<legend>New Customer</legend> 

				<!-- Text input: First Name -->
				<div class="form-group">
					<label class="col-md-4 control-label">First Name</label>  
					<div class="col-md-4 inputGroupContainer">
				  		<div class="input-group">
				  			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				  			<input  name="firstName" placeholder="First Name" class="form-control"  type="text">
						</div>
				  	</div>
				</div>

				<!-- Text input: Last Name -->
				<div class="form-group">
					<label class="col-md-4 control-label" >Last Name</label> 
				    <div class="col-md-4 inputGroupContainer">
				    	<div class="input-group">
				  			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				  			<input name="lastName" placeholder="Last Name" class="form-control"  type="text">
				    	</div>
				  	</div>
				</div>

				<!-- Text input: Email -->
				<div class="form-group">
					<label class="col-md-4 control-label">E-Mail</label>  
					<div class="col-md-4 inputGroupContainer">
						<div class="input-group">
					        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
					 		<input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
					    </div>
					</div>
				</div>


				<!-- Text input: Phone Number -->      
				<div class="form-group">
					<label class="col-md-4 control-label">Phone #</label>  
				    <div class="col-md-4 inputGroupContainer">
				    	<div class="input-group">
				        	<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				  			<input name="phoneNum" placeholder="256-555-1212" class="form-control" type="text">
				    	</div>
				  	</div>
				</div>

				<!-- Text input: Address -->	      
				<div class="form-group">
					<label class="col-md-4 control-label">Address</label>  
				    <div class="col-md-4 inputGroupContainer">
				    	<div class="input-group">
				        	<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  			<input name="address" placeholder="Address" class="form-control" type="text">
				    	</div>
				  	</div>
				</div>

				<!-- Text input: City -->
				<div class="form-group">
					<label class="col-md-4 control-label">City</label>  
				    <div class="col-md-4 inputGroupContainer">
				    	<div class="input-group">
				        	<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  			<input name="city" placeholder="City" class="form-control"  type="text">
				    	</div>
				  	</div>
				</div>

				<!-- Select Basic: State -->
				<div class="form-group"> 
					<label class="col-md-4 control-label">State</label>
			    	<div class="col-md-4 selectContainer">
			    		<div class="input-group">
			        		<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
						    <select name="state" class="form-control selectpicker" >
						    	<option value=" " >Please select your state</option>
						     	<option>Alabama</option>
						      	<option>Alaska</option>
						      	<option >Arizona</option>
						      	<option >Arkansas</option>
						      	<option >California</option>
						      	<option >Colorado</option>
						      	<option >Connecticut</option>
						      	<option >Delaware</option>
						      	<option >District of Columbia</option>
						      	<option> Florida</option>
						      	<option >Georgia</option>
						      	<option >Hawaii</option>
						      	<option >daho</option>
						      	<option >Illinois</option>
						      	<option >Indiana</option>
						      	<option >Iowa</option>
						      	<option> Kansas</option>
						      	<option >Kentucky</option>
						      	<option >Louisiana</option>
						      	<option>Maine</option>
						      	<option >Maryland</option>
						      	<option> Mass</option>
						      	<option >Michigan</option>
						      	<option >Minnesota</option>
						      	<option>Mississippi</option>
						      	<option>Missouri</option>
						      	<option>Montana</option>
						      	<option>Nebraska</option>
						      	<option>Nevada</option>
						      	<option>New Hampshire</option>
						      	<option>New Jersey</option>
						      	<option>New Mexico</option>
						      	<option>New York</option>
						      	<option>North Carolina</option>
						      	<option>North Dakota</option>
						      	<option>Ohio</option>
						      	<option>Oklahoma</option>
						      	<option>Oregon</option>
						      	<option>Pennsylvania</option>
						      	<option>Rhode Island</option>
						      	<option>South Carolina</option>
						      	<option>South Dakota</option>
						      	<option>Tennessee</option>
						      	<option>Texas</option>
						      	<option> Uttah</option>
						      	<option>Vermont</option>
						      	<option>Virginia</option>
						      	<option >Washington</option>
						      	<option >West Virginia</option>
						      	<option>Wisconsin</option>
						      	<option >Wyoming</option>
						    </select>
			  			</div>
					</div>
				</div>

				<!-- Text input: Zipcode -->
				<div class="form-group">
					<label class="col-md-4 control-label">Zip Code</label>  
				    <div class="col-md-4 inputGroupContainer">
				    	<div class="input-group">
				        	<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  			<input name="zipCode" placeholder="Zip Code" class="form-control"  type="text">
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
