<?php
session_start();

//redirect to login form if not logged in
function redirect() {
  header('Location: admin.php');
  exit();
}

if(isset($_SESSION['id'])) {

  include 'dbh.php';
  include 'ValidateInput.php';

  if (isset($_POST['newCustomer'])) {

  	$firstName = ValidateFirstName( $_POST['firstName'] );
  	$lastName = ValidateLastName( $_POST['lastName'] );
  	$address = ValidateAddress( $_POST['address'] );
  	$city = ValidateCity( $_POST['city'] );
  	$state = $_POST['state'];
  	$zipCode = ValidateZipCode( $_POST['zipCode'] );
  	$email = ValidateEmail( $_POST['email'] );
  	$phoneNum = ValidatePhoneNum( $_POST['phoneNum'] );

  	//check if customer is already in system
  	$sql = "SELECT * FROM customers WHERE phoneNum = '$phoneNum'";
  	$result = mysqli_query($conn, $sql);
  	$check = mysqli_num_rows($result);

  	if ($check > 0 ) {
  		echo 'A customer has already registered with this ';
  		echo 'phone number! Please wait.';
  		exit();
  	} else {
  		//if not in system, insert new customer
  		$sql = "INSERT INTO customers( firstName, lastName, address, city, state, zipCode, email, phoneNum) 
  		VALUES ('$firstName', '$lastName', '$address', '$city', '$state', '$zipCode', '$email', '$phoneNum')";

  		if (!mysqli_query($conn, $sql )) {
  			echo 'Customer insertion error! Please wait.';
  			exit();
  		} else {
  			header( "refresh:3; url = '$DB_MAIN_URL'" );
  			echo "Successfully added " . $firstName . " " . $lastName . " to database. ";
  			echo "Please wait.";
  			exit();
  		}
  	}
  }

  ?>

  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>New Customer</title>
      <!-- Bootstrap -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>
   <!-- Insert your own HTML below here: -->
    
    
    
    <!-- Pen by username Jay Deutsch. You can find this form at: http://codepen.io/jaycbrf/ -->
    <?php include 'includes/headerInventory.php'; ?>
    
    <div class="container">

      <form class="well form-horizontal" action="NewCustomer.php" method="post"  id="NewCustomer">
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

  <!-- Text input-->

  <div class="form-group">
    <label class="col-md-4 control-label">First Name</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    <input  name="firstName" placeholder="John" class="form-control"  type="text">
      </div>
    </div>
  </div>

  <!-- Text input-->

  <div class="form-group">
    <label class="col-md-4 control-label" >Last Name</label> 
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    <input name="lastName" placeholder="Doe" class="form-control"  type="text">
      </div>
    </div>
  </div>

  <!-- Text input-->
         <div class="form-group">
    <label class="col-md-4 control-label">E-Mail</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
    <input name="email" placeholder="johndoe@gmail.com" class="form-control"  type="text">
      </div>
    </div>
  </div>


  <!-- Text input-->
         
  <div class="form-group">
    <label class="col-md-4 control-label">Phone #</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
    <input name="phoneNum" placeholder="256-555-1212" class="form-control" type="text">
      </div>
    </div>
  </div>

  <!-- Text input-->
        
  <div class="form-group">
    <label class="col-md-4 control-label">Address</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
    <input name="address" placeholder="120 Sunny Dr." class="form-control" type="text">
      </div>
    </div>
  </div>

  <!-- Text input-->
   
  <div class="form-group">
    <label class="col-md-4 control-label">City</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
    <input name="city" placeholder="Athens" class="form-control"  type="text">
      </div>
    </div>
  </div>

  <!-- Select Basic -->
     
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

  <!-- Text input-->

  <div class="form-group">
    <label class="col-md-4 control-label">Zip Code</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
    <input name="zipCode" placeholder="35611" class="form-control"  type="text">
      </div>
  </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
      <button type="submit" class="btn btn-warning" name = "newCustomer">Send <span class="glyphicon glyphicon-send"></span></button>
    </div>
  </div>

  </fieldset>
  </form>
  </div>
      </div><!-- /.container -->
  	
  	
  	
  	
  <!-- End your own HTML above here: -->

      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="js/bootstrap.min.js"></script>
    </body>
  </html>

<?php 
} else {
  redirect();
}
?>