<?php
	
	$conn = mysqli_connect("localhost", "root", "", "sk salon");
	//localhost = xampp localhost
	//root = my username through xampp
	//secret = my password through xampp, you may not have a password so can leave it blank like ""
	//logintest = name of my database through xampp to test this
	
	if(!$conn) {
	die("Connection failed: ".mysqli_connect_error()); 
	//remove mysqli_connect_error() when site goes live to prevent SQL injection!
	}