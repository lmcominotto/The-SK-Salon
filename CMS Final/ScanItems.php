<html>
<style>
<!-- CSS for displaying shopping_cart table -->
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</html>

<?php
session_start();

//redirect to login form if not logged in
function redirect() {
  header('Location: admin.php');
  exit();
}

if(isset($_SESSION['id'])) {
	include 'dbh.php';
	include 'ShoppingCart.php';

	if(isset($_POST['Next'])) {
		$UPC = $_POST['UPC'];
		
		// If first character of UPC input is a letter, treat as a hair service.
		if (ctype_alpha( $UPC[0])) { 

			$position = strpos( $UPC, '$' ); // Find dollar sign.
			if ( $position === false ) {
				echo 'No dollar sign found! Example: Haircut $25.00<br>';
				echo 'Redirecting. Please wait.';
				header( "refresh:3; url = '$SCAN_ITEMS_URL'" );
				exit();
			}

			$UPC = preg_replace( '/\s+/', '', $UPC ); // Remove whitespace
			$description = substr( $UPC, 0, $position-1 ); // Google "PHP Substring"
			$price = substr( $UPC, $position ); 
			//check price
			if ( !is_numeric( $price ) OR $price <=  0 ) {
				echo 'Error! Invalid price.';
				echo 'Redirecting. Please wait.';
				header( "refresh:3; url = '$SCAN_ITEMS_URL'" ); 
				exit();
			} else {
				//add service to cart
				$service = "INSERT INTO shopping_cart (UPC, description, price) VALUES ( '000000000001', '$description', '$price' )";
				$checkService = mysqli_query($conn, $service); 
				if (!$checkService ) {
					echo "Unknown Error! Could not add item to cart!";
					echo 'Redirecting. Please wait.';
					header( "refresh:3; url = '$SCAN_ITEMS_URL'" );
					exit();
				}
			}

			//print shopping cart
			$cart = "SELECT description, price FROM shopping_cart";
			$checkCart = mysqli_query($conn, $cart);
			if (!$checkCart ) {
				echo "Error! Unable to load shopping cart!";
				echo 'Redirecting. Please wait.';
				header( "refresh:3; url = '$SCAN_ITEMS_URL'" );
				exit();
			}
			echo '<table class="table table-striped table-bordered">'; 
			echo '<tr><th>Description:</th><th>Price:</th></tr>'; 
			while ($row = mysqli_fetch_assoc($checkCart) ) {
				echo "<tr><td>";   
				echo $row['description'];
				echo "</td><td>";    
				echo $row['price'];
				echo "</td></tr>";  
			}
			echo '</table>';
			echo "<a href = '$SCAN_ITEMS_URL'>HIDE CART</a>";

		}
		// Else if first character of UPC input is a number, treat as a normal UPC.
		else if (is_numeric( $UPC[0])) {
			//check if item is in inventory
			$selectUPC = "SELECT * FROM inventory WHERE UPC = '$UPC'";
			$result = mysqli_query($conn, $selectUPC);
			$check = mysqli_num_rows($result);
			
			//not in inventory
			if ($result && $check == 0 ) {
				echo 'Error: This UPC does not exist in inventory.';
				echo 'Redirecting. Please wait.';
				header( "refresh:3; url = '$SCAN_ITEMS_URL'" );
			} else {
				$row = mysqli_fetch_assoc($result); 
				$description = $row['description'];
				$price = $row['price'];

				//add item to shopping cart
				$item = "INSERT INTO shopping_cart (UPC, description, price) VALUES ( '$UPC', '$description', '$price' )";
				$checkItem = mysqli_query($conn, $item); 
				if (!$checkItem ) {
					echo "Unknwon Error! Could not add item to cart!";
					echo 'Redirecting. Please wait.';
					header( "refresh:3; url = '$SCAN_ITEMS_URL'" );
					exit();
				}

				//print shopping cart
				$cart = "SELECT description, price FROM shopping_cart";
				$checkCart = mysqli_query($conn, $cart);
				if (!$checkCart ) {
					echo "Error! Unable to load shopping cart!";
					echo 'Redirecting. Please wait.';
					header( "refresh:3; url = '$SCAN_ITEMS_URL'" );
					exit();
				}
				echo '<table class="table table-striped table-bordered">'; 
				echo '<tr><th>Description:</th><th>Price:</th></tr>'; 
				while ($row = mysqli_fetch_assoc($checkCart) ) {
					echo "<tr><td>";   
					echo $row['description'];
					echo "</td><td>";    
					echo $row['price'];
					echo "</td></tr>";  
				}
				echo '</table>';
				echo "<a href = '$SCAN_ITEMS_URL'>HIDE CART</a>";
			}
		}
		else {
			echo 'Error! Invalid UPC or description. Please wait.';
			header( "refresh:2; url = '$SCAN_ITEMS_URL'" );

		}
	} else if (isset($_POST['Done'])) {
		header( "refresh:2; url = '$CHECKOUT_URL'" );
		echo 'Redirecting to checkout. Please wait.<br><br>';
	} else if (isset($_POST['View_Cart'])) {
		//print shopping cart
		$cart = "SELECT description, price FROM shopping_cart";
		$checkCart = mysqli_query($conn, $cart);
		if (!$checkCart ) {
			echo "Error! Unable to load shopping cart!";
			echo 'Redirecting. Please wait.';
			header( "refresh:3; url = '$SCAN_ITEMS_URL'" );
			exit();
		}
		echo '<table class="table table-striped table-bordered">'; 
		echo '<tr><th>Description:</th><th>Price:</th></tr>'; 
		while ($row = mysqli_fetch_assoc($checkCart) ) {
			echo "<tr><td>";   
			echo $row['description'];
			echo "</td><td>";    
			echo $row['price'];
			echo "</td></tr>";  
		}
		echo '</table>';
		echo "<a href = '$SCAN_ITEMS_URL'>HIDE CART</a>";
	} else if (isset($_POST['Cancel'])) {
		//empty cart and return to main page
		$sql = "TRUNCATE TABLE shopping_cart";
		$cart = mysqli_query($conn, $sql);

		if (!$cart) {
			echo "Unknown Error! Unable to empty shopping cart.";
			exit();
		}

		header( "refresh:2; url = '$DB_MAIN_URL'" );
		echo 'Transaction cancelled. Please wait.<br><br>';
	}

	?>

	<!-- 
	This form accepts either a scanned or typed UPC code and inserts it
	into a table named shopping_cart. Once the user is done scanning, 
	the user will then either click "Done" to proceed to the checkout 
	screen, or click "Cancel" to empty the shopping cart.
	-->
	  
	  <!DOCTYPE html>
	<html lang="en">
	  <head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <title>Scan Items</title>
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

	    <form class="well form-horizontal" action = "ScanItems.php" method="post"  id="DeleteItem">
	<fieldset>

	<style>
	Legend {
	  display: block;
	  width: 100%;
	  text-align: center;
	}

	button {
	  margin-left: 8px;
	  margin-right: 8px;
	}
	</style>

	<!-- Form Name -->
	<legend>Scan Items</legend> 

	<!-- Text input-->

	<div class="form-group">
	  <label class="col-md-4 control-label">UPC</label>  
	  <div class="col-md-4 inputGroupContainer">
	  <div class="input-group">
	  <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
	  <input  name="UPC" placeholder="Ex: 009531113470 or Haircut $25.00" class="form-control"  type="text">
	    </div>
	  </div>
	</div>


	<!-- Button -->

	<div class="form-group">
	  <label class="col-md-4 control-label"></label>
	  <div class="col-md-4">
	  <button type="submit" name="Next" value="Next" class="btn btn-default" >Add Item to Cart <span class="glyphicon glyphicon-"></span></button>
	  <br><br><br><br><br>
	  <button type="submit" name="View_Cart" value="View_Cart" class="btn btn-default" >View Cart <span class="glyphicon glyphicon-"></span></button>
	  <button type="submit" name="Done" value="Done" class="btn btn-success" > Checkout <span class="glyphicon glyphicon-ok"></span></button>
	  <button type="submit" name="Cancel" value="Cancel" class="btn btn-danger" >Cancel <span class="glyphicon glyphicon-remove"></span></button>
	  
	  </div>
	</div>

	</fieldset>
	</form>
	</div>	  
	  
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