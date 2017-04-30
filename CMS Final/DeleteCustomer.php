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

  if(isset($_POST['deleteCustomer'])) {

  	$firstName = ValidateFirstName( $_POST['firstName'] );
  	$lastName = ValidateLastName( $_POST['lastName'] );
  	$phoneNum = ValidatePhoneNum( $_POST['phoneNum'] );

    //check if customer exists in system
  	$checkCustomer = "SELECT * FROM customers WHERE firstName = '$firstName' AND 
  		lastName = '$lastName' AND phoneNum = '$phoneNum'";
  	$checkResult = mysqli_query($conn, $checkCustomer);
  	$count = mysqli_num_rows($checkResult);

  	if($count == 0) {  //customer does not exist
  		echo "Customer Does Not Exist.<br>";
  		echo "Please Wait.<br>";
  		header( "refresh:3; url = '$DELETE_CUSTOMER_URL'" );
  		mysqli_close($conn);
  		exit();
  	} else if ($count > 0) {  //get customer ID number if exists
  		$row = $checkResult->fetch_assoc();
  		$toDelete = $row['idCustomers'];

      //disable foreign keys
  		$check1 = mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
  		$check2 = mysqli_query($conn, "DELETE FROM customers WHERE idCustomers = '$toDelete'");
  		$check3 = mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
      
  		if ( !$check1 || !$check2 || !$check3 && mysqli_affected_rows($conn) == 0 ) {
  			echo mysqli_error($conn);
  			echo 'Error! Unable to delete item. Please wait.';
  			header( "refresh:3; url = '$DELETE_CUSTOMER_URL'" );
  			mysqli_close($conn);
  			exit();
  		} else {
  			echo "Successfully deleted " . $firstName . " " . $lastName . " from database!<br>";
  			echo "Please wait.";
  			header( "refresh:3; url = '$DELETE_CUSTOMER_URL'" );
  			mysqli_close($conn);
  			exit();
  		}

  	} else {
  		echo "There was en error searching for the customer. Please wait.<br>";
  		header( "refresh:3; url = '$DELETE_CUSTOMER_URL'" );
  		mysqli_close($conn);
  		exit();
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
      <title>Delete Customer</title>
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

      <form class="well form-horizontal" action="DeleteCustomer.php" method="post"  id="DeleteCustomer">
  <fieldset>

  <style>
  Legend {
    display: block;
    width: 100%;
    text-align: center;
  }
  </style>

  <!-- Form Name -->
  <legend>Delete Customer</legend> 

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
    <label class="col-md-4 control-label">Phone #</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
    <input name="phoneNum" placeholder="256-555-1212" class="form-control" type="text">
      </div>
    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
      <button type="submit" class="btn btn-danger" name = "deleteCustomer" >Delete <span class="glyphicon glyphicon-remove"></span></button>
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