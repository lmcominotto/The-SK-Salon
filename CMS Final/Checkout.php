<?php 
include 'dbh.php';
//include 'ShoppingCart.php';

  $total = 0;
  $prices = "SELECT price FROM shopping_cart";
  $result = mysqli_query($conn, $prices);

  while ( $row = mysqli_fetch_assoc($result)) {
    $total += $row['price'];
  }
  $tax = 0.09;
  $total = $total + ( $tax * $total );
  $total = round( $total, 2 );

  $finalTotal = $total;
?>

<!-- Pen by username Jay Deutsch. You can find this form at: http://codepen.io/jaycbrf/ -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Checkout</title>
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

 <?php include 'includes/headerInventory.php'; ?> 

<div class="container">
<form class = "well form-horizontal" action = "PostCheckout.php" method = "post">
<fieldset>

<style>
Legend {
  display: block;
  width: 100%;
  text-align: center;
}

button {
	margin-left: 15px;
	margin-right: 15px;
}
</style>

<!-- Form Name -->
<legend>Checkout</legend> 

<!-- total gets printed here: -->
<h2 align="center"> Total: $<?php echo $finalTotal;?></h2><br>

<!-- Text input-->  
<div class="form-group">
  <label class="col-md-4 control-label">Phone #</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  <input name="phoneNum" placeholder="256-555-1212 (optional)" class="form-control" type="text">
    </div>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group"> 
  <label class="col-md-4 control-label">Payment Type</label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    <select name="paymentType" class="form-control selectpicker" >
      <option value="" >Select Payment Type</option>
      <option>Debit/Credit</option>
      <option>Cash</option>
      <option >Check</option>
      <option >Gift Card</option>
    </select>
  </div>
</div>
</div>



<!-- Buttons -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
	<button type="submit" class="btn btn-default" name="Cart" value="Cart">View Cart <span class="glyphicon glyphicon-"></span></button>
	<br><br><br><br><br>
    <button type="submit" class="btn btn-success" name="Transaction" value="Transaction">Complete Transaction <span class="glyphicon glyphicon-ok"></span></button> 
	<button type="submit" class="btn btn-danger" name="Cancel" value="Cancel">Cancel <span class="glyphicon glyphicon-remove"></span></button>
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