<?php

	$server = 'localhost'; //'localhost:3306';
	$user = 'root'; //'skmain';
	$password = ''; //'koala8giraffe*';
	$db = 'loginTest';//'theSKsalon';
	
	$conn = mysqli_connect($server, $user, $password, $db);
	//localhost = xampp localhost
	//root = my username through xampp
	//secret = my password through xampp, you may not have a password so can leave it blank like ""
	//logintest = name of my database through xampp to test this
	
	if(!$conn) {
		die("Connection failed: ".mysqli_connect_error()); 
	}

	// A list of redirect URLs for inventory portion
	$DB_MAIN_URL = "DBMain.php";
	$SCAN_ITEMS_URL = "ScanItems.php";
	$CHECKOUT_URL = "Checkout.php";
	$NEW_CUSTOMER_URL = "NewCustomer.php";
	$EDIT_CUSTOMER_URL = "EditCustomer.php";
	$DELETE_CUSTOMER_URL = "DeleteCustomer.php";
	$NEW_ITEM_URL = "NewItem.php";
	$DELETE_ITEM_URL = "DeleteItem.php";
	$RESTOCK_ITEM_URL = "RestockItem.php";

?>