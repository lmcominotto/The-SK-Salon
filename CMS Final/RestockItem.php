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

  if(isset($_POST['restock'])) {

  	$UPC = ValidateUPC( $_POST['UPC'] );
  	$stock = ValidateQuantityAvail( $_POST['stock'] );

  	$check = "SELECT * FROM inventory WHERE (UPC = '$UPC')";
  	$checkResult = mysqli_query($conn, $check);
  	$checkCount = mysqli_num_rows($checkResult);
    
  	if ( $checkResult && ($checkCount == 0) ) {
  		echo 'Invalid UPC! Please wait.';
  		header( "refresh:4; url = '$RESTOCK_ITEM_URL'" );
  		mysqli_close($conn);
  		exit();
  	}

  	$sql = "UPDATE inventory SET quantityAvail = quantityAvail + '$stock' WHERE (UPC = '$UPC')";
  	$result = mysqli_query($conn, $sql);
  	if ( !$result ) {
  		echo "Error: could not connect and update.";
  		header( "refresh:4; url = '$RESTOCK_ITEM_URL'" );
  		mysqli_close($conn);
  		exit();
  	}

  	$row = mysqli_fetch_assoc( $checkResult );
  	$description = $row['description'];

  	echo "You succesfully added " . $stock . " more " . $description . " to inventory. Please wait.";
  	header( "refresh:4; url = '$DB_MAIN_URL'" );
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
      <title>Restock Item</title>
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

      <form class="well form-horizontal" action = "RestockItem.php" method="post"  id="RestockItem">
  <fieldset>

  <style>
  Legend {
    display: block;
    width: 100%;
    text-align: center;
  }
  </style>

  <!-- Form Name -->
  <legend>Restock Item</legend> 

  <!-- Text input-->

  <div class="form-group">
    <label class="col-md-4 control-label">UPC</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
    <input  name="UPC" placeholder="" class="form-control"  type="text">
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Increment by</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
    <input  name="stock" placeholder="" class="form-control"  type="text">
      </div>
    </div>
  </div>


  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
      <button type="submit" class="btn btn-basic" name = "restock">Add to Inventory <span class="glyphicon glyphicon-"></span></button>
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