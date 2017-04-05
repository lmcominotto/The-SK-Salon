<?php

	$server = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'logintest';
	
	$conn = mysqli_connect($server, $user, $password, $db);
	//localhost = xampp localhost
	//root = my username through xampp
	//secret = my password through xampp, you may not have a password so can leave it blank like ""
	//logintest = name of my database through xampp to test this
	
	if(!$conn) {
	die("Connection failed: ".mysqli_connect_error()); 
	//remove mysqli_connect_error() when site goes live to prevent SQL injection!

	//mysql_select_db($db, $conn)
	//or die ("Could not connect to database...\n" .mysql_error());
	}