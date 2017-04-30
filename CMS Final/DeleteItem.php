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

  if(isset($_POST['deleteItem'])) {

  	$UPC = ValidateUPC( $_POST['UPC'] );

    $getDescrip = "SELECT * FROM inventory WHERE UPC = '$UPC'";
    $getDescripResult = mysqli_query($conn, $getDescrip);
    $DescripCount = mysqli_num_rows($getDescripResult);

    if ($getDescripResult && ($DescripCount == 0) ) {
      echo mysqli_error($conn);
      echo '<br>Error! Could not find item. Please wait.<br>';
      header("refresh:3; url = '$DELETE_ITEM_URL'");
      mysqli_close($conn);
      exit();
    } else {

      //disable foreign keys
    	$check1 = mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
    	$check2 = mysqli_query($conn, "DELETE FROM inventory WHERE UPC = '$UPC'");
    	$check3 = mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

    	if ( !$check1 || !$check2 || !$check3 && mysqli_affected_rows($conn) == 0 ) {
    		echo mysqli_error($conn);
    		echo 'Error! Unable to delete item. Please wait.';
    		header("refresh:3; url = '$DELETE_ITEM_URL'");
    		mysqli_close($conn);
    		exit();
    	}

    	$descrip = mysqli_fetch_assoc( $getDescripResult );
    	$str = $descrip['description'];

    	header( "refresh:3; url = '$DB_MAIN_URL'" );
    	echo "Successfully deleted " . $str . " from inventory. Please wait.";
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
      <title>Delete Item</title>
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

      <form class="well form-horizontal" action="DeleteItem.php" method="post"  id="DeleteItem">
  <fieldset>

  <style>
  Legend {
    display: block;
    width: 100%;
    text-align: center;
  }
  </style>

  <!-- Form Name -->
  <legend>Delete Item</legend> 

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


  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
      <button type="submit" class="btn btn-danger" name = "deleteItem">Delete <span class="glyphicon glyphicon-remove"></span></button>
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