<?php
// A collection of validation methods to make sure
// those user inputs are squeaky clean.

function ValidateFirstName( $firstName ) 
{
	if ( $firstName == "" ) {
		echo 'Error! Please enter a first name. Please wait.';
		exit();
	}
	if ( !preg_match( "/^[a-zA-Z ]*$/", $firstName )) {
		echo 'Error! Invalid first name. Please wait.'; 
		exit();
	} 
	$firstName = ucwords( $firstName );
	return $firstName;
}

function ValidateLastName( $lastName )
{
	if ( $lastName == "" ) {
		echo 'Error! Please enter a last name. Please wait.';
		exit();
	}
	if ( !preg_match( "/^[a-zA-Z ]*$/", $lastName )) {
		echo 'Error! Invalid last name. Please wait.'; 
		exit;
	}
	$lastName = ucwords( $lastName );
	return $lastName;
}

function ValidateAddress( $address )
{
	if ( $address == "" ) {
		echo 'Error! Please enter an address. Please wait.';
		exit();
	}
	$address = str_replace(array('.'), '' , $address );
	if ( !preg_match( "/^[a-zA-Z0-9 ]*$/", $address )) {
		echo 'Error! Invalid address. Please wait.';
		exit();
	}
	return $address;
}

function ValidateCity( $city )
{
	if ( $city == "" ) {
		echo 'Error! Please enter a city. Please wait.';
		exit();
	}
	if ( !preg_match( "/^[a-zA-Z ]*$/", $city )) {
		echo 'Error! Invalid city name. Please wait.'; 
		exit();
	}
	$city = ucwords( $city );
	return $city;
}

function ValidateZipCode( $zipCode ) 
{
	if ( $zipCode > 99999 or strlen($zipCode) != 5 ) {
		echo 'Error! Please enter a valid zip code. Please wait.';
		mysqli_close($conn);
		exit();
	}
	return $zipCode;
}

function ValidatePhoneNum( $phoneNum )
{
	$phoneNum = preg_replace( "/[^0-9]/","", $phoneNum );
	if ( strlen( $phoneNum ) != 10 ) {
		echo 'Error! Please enter a valid phone number. Please wait.';
		exit();
	}
	return $phoneNum;
}

function ValidateEmail( $email )
{
	if ( !filter_var( $email, FILTER_VALIDATE_EMAIL )) {
		echo 'Error! Invalid email address. Please wait.';
		exit();
	}
	return $email;
}

function ValidateUPC( $UPC )
{
	$UPC = filter_var($UPC, FILTER_SANITIZE_NUMBER_INT);
	if ( !is_numeric( $UPC )) {
		echo 'Invalid barcode! Please wait.';
		exit();
	}
	if ( strlen( $UPC ) != 12 and strlen( $UPC ) != 14 ) {
		echo 'Invalid barcode! Please wait.';
		exit();
	}
	return $UPC;
}

function ValidateDescription( $description )
{
	if ( $description == "" ) {
		echo 'Error! Please enter a description. Please wait.';
		exit();
	}
	return $description;
}

function ValidateQuantityAvail( $quantityAvail )
{
	if ( $quantityAvail < 0 or !is_numeric( $quantityAvail )) {
		echo 'Error! Invalid quantity. Please wait.';
		exit();
	}
	return $quantityAvail;
}

function ValidateCost( $cost )
{
	if ( $cost < 0 or !is_numeric( $cost )) {
		echo 'Error! Invalid cost amount. Please wait.';
		exit();
	}
	$cost = filter_var( $cost, FILTER_SANITIZE_NUMBER_FLOAT, 
		FILTER_FLAG_ALLOW_FRACTION );
	$cost = round($cost, 2); // round float to two decimal places
	return $cost;
}

function ValidatePrice( $price )
{
	if ( $price < 0 or !is_numeric( $price )) {
		echo 'Error! Invalid price amount. Please wait.';
		mysqli_close($conn);
		exit();
	}
	$price = filter_var( $price, FILTER_SANITIZE_NUMBER_FLOAT, 
		FILTER_FLAG_ALLOW_FRACTION );	
	$price = round($price, 2);
	return $price;
}

function ValidatePaymentType ( $paymentType )
{
	if ( $paymentType == "" ) {
		echo 'Error! Please select a payment type. Please wait.';
		exit();
	}
	return $paymentType;
}
?>
