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

function AddItemToCart( $upc, $descrip, $amount )
{
	$item = "INSERT INTO shopping_cart ( UPC, description, price ) VALUES ( '$upc', '$descrip', '$amount' )";
	$check = mysqli_query($conn, $item); 

	if (!$check ) {
		echo "Unknwon Error! Could not add item to cart!";
		exit();
	}
	return;
}

function PrintShoppingCart()
{
	$cart = "SELECT description, price FROM shopping_cart";
	$check = mysqli_query($conn, $item);
	if (!$check ) {
		echo "Error! Unable to load shopping cart!";
		exit();
	}
	echo '<table class="table table-striped table-bordered">'; 
	echo '<tr><th>Description:</th><th>Price:</th></tr>'; 
	while ( $row = mysqli_fetch_assoc( $cart ) ) {
		echo "<tr><td>";   
		echo $row['description'];
		echo "</td><td>";    
		echo $row['price'];
		echo "</td></tr>";  
	}
	echo '</table>';
	return;
}

function EmptyShoppingCart()
{
	$sql = "TRUNCATE TABLE shopping_cart";
	$cart = mysqli_query($conn, $sql);

	if (!$cart) {
		echo "Unknown Error! Unable to empty shopping cart.";
		exit();
	}

	return;
}

// A function to add a haircut or some other service to shopping_cart.
// Services itemized this way are assigned a barcode of 000000000001.
//
// Dependencies: AddItemToCart()
// Syntax: letter, alphanumeric, $, +float
// Example: "Haircut $25.00" (without the quotation marks)
function AddServiceToCart( $UPC )
{
	$position = strpos( $UPC, '$' ); // Find dollar sign.
	if ( $position === false ) {
		echo 'No dollar sign found! Example: Haircut $25.00';
		mysqli_close();
		exit();
	}
	$UPC = preg_replace( '/\s+/', '', $UPC ); // Remove whitespace
	$description = substr( $UPC, 0, $position-1 ); // Google "PHP Substring"
	$price = substr( $UPC, $position ); 
	if ( !is_numeric( $price ) OR $price <=  0 ) {
		echo 'Error! Invalid price. Redirecting...'; 
		mysqli_close();
		exit();
	}
	$price = round( $price, 2 ); // Two decimal places
	$price = abs( $price ); // Absolute value
	AddItemToCart( '000000000001', $description, $price );
	return;
}

// Calculates total and adds tax.
function CalculateTotal()
{
	$total = 0;
	$prices = "SELECT price FROM shopping_cart";
	$result = mysqli_query($conn, $prices);

	while ( $row = mysqli_fetch_assoc($result)) {
		$total += $row['price'];
	}
	$tax = 0.09;
	$total = $total + ( $tax * $total );
	$total = round( $total, 2 );
	return $total;
}
?>
