<?php
	// Error check
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	// Base URL
	$base_url = "http://" . $_SERVER['SERVER_NAME'];
	// Establish DB connection
	$db = mysqli_connect('localhost','root','root','barchart') or die('Error connecting to MySQL server.');
	
	// Delete symbol row query
	if(isset($_GET['delete_symb'] ) ){
		$del_query = "DELETE FROM `quotes` WHERE `symbol` = '".$_GET['delete_symb']."'";
		$delete = mysqli_query($db, $del_query) or die('Error: '. mysqli_error($db) );		
	}	
	header('Location: '.$base_url );