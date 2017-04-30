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

	// Function that actually updates the customer. If a field was left blank on the form,
	// no changes will be made to that field. If, however, one or more fields typed in, those
	// fields will be checked, sanitized, then be SQL UPDATE values.

	if(isset($_POST['editCustomer'])) {

  	$phoneID = $_POST['phoneID'];
  	$firstName = $_POST['firstName'];
  	$lastName = $_POST['lastName'];
  	$address = $_POST['address'];
  	$city =  $_POST['city'];
  	$state = $_POST['state'];
  	$zipCode = $_POST['zipCode'];
  	$phoneNum = $_POST['phoneNum'];
  	$email = $_POST['email'];

    $phoneID = preg_replace("/[^0-9]/","", $phoneID);

  	//check that customer exists
  	$check = mysqli_query($conn, "SELECT * FROM customers WHERE phoneNum = '$phoneID'");
    $count = mysqli_num_rows($check);
  	
    if ( $count == 0 ) {
  		echo 'No customer exists with that phone number! Please wait. ';
      header( "refresh:3; url = '$EDIT_CUSTOMER_URL'" );
  		mysqli_close($conn);
  		exit();
  	}

  	//update customer information
  	if ( $firstName != "" ) {
  		$firstName = ValidateFirstName( $firstName );
  		$result = mysqli_query($conn, "UPDATE customers SET firstName = '$firstName' 
  			WHERE phoneNum = '$phoneID'");
  	}
  	
  	if ( $lastName != "" ) {
  		$lastName = ValidateLastName( $lastName );
  		$result = mysqli_query($conn, "UPDATE customers SET lastName = '$lastName' 
  			WHERE phoneNum = '$phoneID'" );
  	}

  	if ( $address != "" ) {
  		$address = ValidateAddress( $address ); 
  		$result = mysqli_query($conn, "UPDATE customers SET address = '$address' 
  			WHERE phoneNum = '$phoneID'" );
  	}
  	
  	if ( $city != "" ) {
  		$city = ValidateCity( $city );
  		$result = mysqli_query($conn, "UPDATE customers SET city = '$city' 
  			WHERE phoneNum = '$phoneID'" );
  	}
  	
  	if ( $state != " " ) { // " " not "" this is on purpose
  		$result = mysqli_query($conn, "UPDATE customers SET state = '$state' 
  			WHERE phoneNum = '$phoneID'" );
  	}
  	
  	if ( $zipCode != "" ) {
  		$zipCode = ValidateZipCode( $zipCode );
  		$result = mysqli_query($conn, "UPDATE customers SET zipCode = '$zipCode' 
  			WHERE phoneNum = '$phoneID'" );
  	}
  	
  	if ( $email != "" ) {
  		$email = ValidateEmail( $email );
  		$result = mysqli_query($conn, "UPDATE customers SET email = '$email' 
  			WHERE phoneNum = '$phoneID'" );
  	}
  	
  	// PhoneNum must be last
  	if ( $phoneNum != "" ) {
  		$phoneNum = ValidatePhoneNum( $phoneNum );
  		$result = mysqli_query($conn, "UPDATE customers SET phoneNum = '$phoneNum' 
  			WHERE phoneNum = '$phoneID'" );
  	}
  		
  	if ( $phoneNum != "" ) {
  		$sql = mysqli_query($conn, "SELECT * FROM customers WHERE phoneNum = '$phoneNum'");
  	} else {
  		$sql = mysqli_query($conn, "SELECT * FROM customers WHERE phoneNum = '$phoneID'");
  	}

  	$rows = mysqli_fetch_assoc( $sql );
  	$fn = $rows['firstName'];
  	$ln = $rows['lastName'];

  	header( "refresh:3; url = '$DB_MAIN_URL'" );
  	echo "Successfully updated " . $fn . " " . $ln . "'s information. ";
  	echo "Please wait.";
  	mysqli_close($conn);
  	exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Edit Customer</title>
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
 <!-- Insert your own HTML below here:-->
  
  
  
  <!-- Pen by username Jay Deutsch. You can find this form at: http://codepen.io/jaycbrf/ -->
  <?php include 'includes/headerInventory.php'; ?>

  <div class="container">

    <form class="well form-horizontal" action="EditCustomer.php" method="post"  id="EditCustomer">
<fieldset>

<style>
Legend {
  display: block;
  width: 100%;
  text-align: center;
}
</style>

<!-- Form Name -->
<legend>Edit Customer</legend> 

<div class="form-group">
  <label class="col-md-4 control-label">Phone # of customer you wish to edit</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  <input name="phoneID" placeholder="256-555-1212" class="form-control" type="text">
    </div>
  </div>
</div>

<br>
<br>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">First Name</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="firstName" placeholder="" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Last Name</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="lastName" placeholder="" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Text input-->
       <div class="form-group">
  <label class="col-md-4 control-label">E-Mail</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  <input name="email" placeholder="" class="form-control"  type="text">
    </div>
  </div>
</div>


<!-- Text input-->
       
<div class="form-group">
  <label class="col-md-4 control-label">Phone #</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  <input name="phoneNum" placeholder="" class="form-control" type="text">
    </div>
  </div>
</div>

<!-- Text input-->
      
<div class="form-group">
  <label class="col-md-4 control-label">Address</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="address" placeholder="" class="form-control" type="text">
    </div>
  </div>
</div>

<!-- Text input-->
 
<div class="form-group">
  <label class="col-md-4 control-label">City</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
  <input name="city" placeholder="" class="form-control"  type="text">
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
      <option value=" " >No change</option>
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
  <input name="zipCode" placeholder="" class="form-control"  type="text">
    </div>
</div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button type="submit" name = "editCustomer" class="btn btn-warning" >Send <span class="glyphicon glyphicon-send"></span></button>
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