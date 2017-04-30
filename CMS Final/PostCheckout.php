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
include 'dbh.php';
//header( "refresh:3; url = '$CHECKOUT_URL'" );
include 'ValidateInput.php';

function SearchCustomerByPhone( $phoneNum ) {
	$selectID = "SELECT * FROM customers WHERE phoneNum = '$phoneNum'";
	$selectResult = mysqli_query($conn, $selectID);
	$selectNum = mysqli_num_rows($selectResult);

	if ( $selectID && ($selectNum == 0) ) {
		echo 'No customer found with that phone number. Please wait.';
		mysqli_close($conn);
		exit();
	}
	$row = mysqli_fetch_assoc($selectResult); 
	$idCustomers = $row['idCustomers'];
	return $idCustomers;
}

function NewTransaction( $idCustomers, $paymentType, $total ) {
	$transaction = "INSERT INTO transactions( idCustomers, paymentType, total ) VALUES ( '$idCustomers', '$paymentType', '$total' )";
	$transactionResult = mysqli_query($conn, $transaction);
	if (!$transaction) {
		echo 'Error! Unable to insert transaction into database. Please wait.';
		exit();
	}
	return;
}

// Calculates total and adds tax.
function CalculateTotal() {
	$total = 0;
	$prices = "SELECT price FROM shopping_cart";
	$result = mysqli_query($conn, $prices);

	while ($row = mysqli_fetch_assoc($result)) {
		$total += $row['price'];
	}
	$tax = 0.09;
	$total = $total + ( $tax * $total );
	$total = round( $total, 2 );
	return $total;
}

function GetMostRecentTransID() {
	$mostRecent = "SELECT * FROM transactions ORDER BY transTime DESC LIMIT 1";
	$mostRecentResult = mysqli_query($conn, $mostRecent);
	$mostRecentCount = mysqli_num_rows($mostRecentResult);
	if ( $mostRecentResult && ($mostRecentCount == 0) ) {
		echo 'Error! Unable to select most recent transaction. Please wait.';
		header( "refresh:3; url = '$CHECKOUT_URL'" );
		exit();
	}
	$row = mysqli_fetch_assoc( $mostRecentResult ); 
	$idTransactions = $row['idTransactions'];
	return $idTransactions;
}

function ProductsSold( $idTransactions )
{
	$summary = "SELECT *, COUNT(description) FROM shopping_cart GROUP BY description";
	$summaryResult = mysqli_query ($conn, $summary);
	$summaryCount = mysqli_num_rows($summaryResult);

	if ( $summaryResult && ($summaryCount == 0) ) {
		echo 'Error! Unable to return cart summary. Please wait.';
		exit();
	}
	$rows = array();
	while( $row = mysqli_fetch_array( $summaryResult )) {
		$rows[] = $row;
	}
	foreach( $rows as $row ) { 
		$UPC = $row['UPC']; 
		$description = $row['description'];
		$price = $row['price'];
		$quantity = $row['COUNT(description)'];
		$insert = "INSERT INTO products_sold (idTransactions, UPC, description, price, quantity)
			 VALUES ('$idTransactions', '$UPC', '$description', '$price', '$quantity')";
		$insertResult = mysqli_query($conn, $insert);
		if ( !$insertResult ) {
			echo "Could not connect.<br>";
			mysqli_close($conn);
			exit();
		}
		// After posting a product record to database, an SQL trigger will decrement
		// its quantity in the inventory table. Should a quantity now be <= 5, echo 
		// a warning to the user.
		$checkQuan = "SELECT * FROM inventory WHERE (UPC = '$UPC')";
		$checkQuanResult = mysqli_query($conn, $checkQuan);
		$checkQuanCount = mysqli_num_rows( $checkQuanResult );
		if ($checkQuanResult && ($checkQuanCount == 0) ) {
			echo "Error with transaction.";
			mysqli_close();
			exit();
		}
		$getQuan = mysqli_fetch_assoc( $checkQuanResult );
		if ( $getQuan['quantityAvail'] <= 5 ) {
			echo "Only " . $getQuan['quantityAvail'] . " " . $description . " left!";
			echo "<br><br>";
		}
	}
	return;
}

if(isset($_POST['Cart'])) {
	//print shopping cart
	$cart = "SELECT description, price FROM shopping_cart";
	$checkCart = mysqli_query($conn, $cart);
	if (!$checkCart ) {
		echo "Error! Unable to load shopping cart!";
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
	echo "<a href = '$CHECKOUT_URL'><-- RETURN</a>";
} else if (isset($_POST['Transaction'])) {
	if ( $_POST['phoneNum'] != "" ) {
			$phoneNum = ValidatePhoneNum( $_POST['phoneNum'] );
			//find customer with phone number 
			$selectID = "SELECT * FROM customers WHERE phoneNum = '$phoneNum'";
			$selectResult = mysqli_query($conn, $selectID);
			$selectNum = mysqli_num_rows($selectResult);

			if ( $selectID && ($selectNum == 0) ) {
				echo 'No customer found with that phone number. Please wait.';
				mysqli_close($conn);
				header( "refresh:3; url = '$CHECKOUT_URL'" );
				exit();
			}
			$row = mysqli_fetch_assoc($selectResult); 
			$idCustomers = $row['idCustomers'];
		}
		else {
			$idCustomers = 1; // Guest is ID #1.
		}

		//calculate total
		$total = 0;
		$prices = "SELECT price FROM shopping_cart";
		$result = mysqli_query($conn, $prices);

		while ($row = mysqli_fetch_assoc($result)) {
			$total += $row['price'];
		}
		$tax = 0.09;
		$total = $total + ( $tax * $total );
		$total = round( $total, 2 );
		$finalTotal = $total;

		//validate payment
		$paymentType = ValidatePaymentType( $_POST['paymentType'] );

		//insert new transaction for records
		$transaction = "INSERT INTO transactions( idCustomers, paymentType, total ) 
		VALUES ( '$idCustomers', '$paymentType', '$finalTotal' )";
		$transactionResult = mysqli_query($conn, $transaction);
		if (!$transactionResult) {
			echo 'Error! Unable to insert transaction into database. Please wait.';
			exit();
		}

		//get most recent transaction ID
		$mostRecent = "SELECT * FROM transactions ORDER BY transTime DESC LIMIT 1";
		$mostRecentResult = mysqli_query($conn, $mostRecent);
		$mostRecentCount = mysqli_num_rows($mostRecentResult);
		if ( $mostRecentResult && ($mostRecentCount == 0) ) {
			echo 'Error! Unable to select most recent transaction. Please wait.';
			header( "refresh:3; url = '$CHECKOUT_URL'" );
			exit();
		}
		$row = mysqli_fetch_assoc( $mostRecentResult ); 
		$idTransactions = $row['idTransactions'];

		//products sold update
		$summary = "SELECT *, COUNT(description) FROM shopping_cart GROUP BY description";
		$summaryResult = mysqli_query ($conn, $summary);
		$summaryCount = mysqli_num_rows($summaryResult);

		if ( $summaryResult && ($summaryCount == 0) ) {
			echo 'Error! Unable to return cart summary. Please wait.';
			exit();
		}
		$rows = array();
		while( $row = mysqli_fetch_array( $summaryResult )) {
			$rows[] = $row;
		}
		foreach( $rows as $row ) { 
			$UPC = $row['UPC']; 
			$description = $row['description'];
			$price = $row['price'];
			$quantity = $row['COUNT(description)'];
			$insert = "INSERT INTO products_sold (idTransactions, UPC, description, price, quantity)
				 VALUES ('$idTransactions', '$UPC', '$description', '$price', '$quantity')";
			$insertResult = mysqli_query($conn, $insert);
			if ( !$insertResult ) {
				echo "Could not connect.<br>";
				mysqli_close($conn);
				exit();
			}
			// After posting a product record to database, an SQL trigger will decrement
			// its quantity in the inventory table. Should a quantity now be <= 5, echo 
			// a warning to the user.
			$checkQuan = "SELECT * FROM inventory WHERE (UPC = '$UPC')";
			$checkQuanResult = mysqli_query($conn, $checkQuan);
			$checkQuanCount = mysqli_num_rows( $checkQuanResult );
			if ($checkQuanResult && ($checkQuanCount == 0) ) {
				echo "Error with transaction.";
				mysqli_close();
				exit();
			}
			$getQuan = mysqli_fetch_assoc( $checkQuanResult );
			if ( $getQuan['quantityAvail'] <= 5 ) {
				echo "Only " . $getQuan['quantityAvail'] . " " . $description . " left!";
				echo "<br><br>";
			}
		}

		//empty cart 
		$sql = "TRUNCATE TABLE shopping_cart";
		$cart = mysqli_query($conn, $sql);

		if (!$cart) {
			echo "Unknown Error! Unable to empty shopping cart.";
			exit();
		}

		echo 'Successfully posted transaction. Please wait.';
		header( "refresh:3; url = '$CHECKOUT_URL'" );

} else if (isset($_POST['Cancel'])) {
	//empty cart and return to main page
	$sql = "TRUNCATE TABLE shopping_cart";
	$cart = mysqli_query($conn, $sql);

	if (!$cart) {
		echo "Unknown Error! Unable to empty shopping cart.";
		exit();
	}

	header( "refresh:2; url = '$DB_MAIN_URL'" );
	echo 'Transaction cancelled. Please wait.';
}

?>