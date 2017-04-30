<?php
session_start();

//redirect to login form if not logged in
function redirect() {
  header('Location: admin.php');
  exit();
}

if(isset($_SESSION['id'])) {

  require 'dbh.php';
  require 'ValidateInput.php';

  if(isset($_POST['newItem']))
  {
  	$UPC = ValidateUPC( $_POST['UPC'] );
  	$description = ValidateDescription( $_POST['description'] );
  	$quantityAvail = ValidateQuantityAvail( $_POST['quantityAvail'] );
  	$cost = ValidateCost( $_POST['cost'] );
  	$price = ValidatePrice( $_POST['price'] );

  	$sql = "INSERT INTO inventory(UPC, description, quantityAvail, cost, price) 
  			VALUES ('$UPC', '$description', '$quantityAvail', '$cost', '$price')";

  	if (!mysqli_query($conn, $sql )) {
  		echo 'Could not add item to inventory! Please wait.';
      header( "refresh:3; url = '$NEW_ITEM_URL'" );
  		mysqli_close($conn);
  		exit();
  	}

  	header( "refresh:3; url = '$NEW_ITEM_URL'" );
  	echo "Successfully added " . $description . " to inventory. Please wait.";
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
      <title>New Item</title>
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
    <?php include 'includes/headerInventory.php';?>

    <div class="container">

    <form class="well form-horizontal" action="NewItem.php" method="post"  id="NewItem">
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

  <!-- Text input-->

  <div class="form-group">
    <label class="col-md-4 control-label">UPC</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
    <input  name="UPC" placeholder="123456789123" class="form-control"  type="text">
      </div>
    </div>
  </div>

  <!-- Text input-->

  <div class="form-group">
    <label class="col-md-4 control-label" >Description</label> 
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
    <input name="description" placeholder="PM Ultimate Color Repair Shampoo" class="form-control"  type="text">
      </div>
    </div>
  </div>

  <!-- Text input-->
         <div class="form-group">
    <label class="col-md-4 control-label">Quantity Available</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-sort"></i></span>
    <input name="quantityAvail" placeholder="3" class="form-control"  type="text">
      </div>
    </div>
  </div>


  <!-- Text input-->
         
  <div class="form-group">
    <label class="col-md-4 control-label">Cost</label>  
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
    <input name="cost" placeholder="Include tax if applicable. Ex: 12.50" class="form-control" type="text">
      </div>
    </div>
  </div>

  <!-- Text input-->
        
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
      <button type="submit" class="btn btn-warning" name = "newItem">Send <span class="glyphicon glyphicon-send"></span></button>
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