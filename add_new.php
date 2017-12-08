<?php
	// Error check
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	// Establish DB Connect
	$db = mysqli_connect('localhost','root','root','barchart') or die('Error connecting to MySQL server.');
	$base_url = "http://" . $_SERVER['SERVER_NAME'];
	$symbol_arr = array();
	// Query DB
	$query = "SELECT * FROM quotes";	
	$result = mysqli_query($db, $query) or die('Error querying database.');	
	$row = mysqli_fetch_array($result);

	do {
		$symbol = $row['symbol'];
 
		$symbol_arr[] = $symbol;
	} while ($row = mysqli_fetch_array($result));	

	// Add new symbol to watchlist query
	if(isset($_POST['symbol']) && !in_array( strtoupper($_POST['symbol']), $symbol_arr ) ) {		
		$post_symbol 	= strtoupper($_POST['symbol']);
		$post_name 		= ucwords($_POST['symbolName']);
		$post_last 		= (double)$_POST['lastPrice'];
		$post_change 	= (double)$_POST['change'];
		$post_pctchange = (double)$_POST['changePercent'];
		$post_volume 	= (int)$_POST['volume'];
		$post_tradetime = $_POST['date'];		
		$query = "INSERT INTO quotes (`symbol`, `name`, `last`, `change`, `pctchange`, `volume`, `tradetime`) VALUES ('".$post_symbol."', '".$post_name."', '".$post_last."','".$post_change."','".$post_pctchange."', '".$post_volume."', '".$post_tradetime."')";

		$insert = mysqli_query( $db, $query ) or die('Error: '. mysqli_error($db) );
		header('Location: '.$base_url ); die();
	}
	else if(isset($_POST['symbol']) && in_array( strtoupper($_POST['symbol']), $symbol_arr )){
		header('Location: '.$base_url.'/?exist=1' ); die();		
	}	
