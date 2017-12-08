<?php
	// Error check
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	// Establish DB Connect
	$db = mysqli_connect('localhost','root','root','barchart') or die('Error connecting to MySQL server.');
	$base_url = "http://" . $_SERVER['SERVER_NAME'];
	
?>

<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bar Chart Test</title>
	<meta name="description" content="Bar Chart Test">
	<meta name="author" content="Cleo Hister">
	<link rel="stylesheet" href="css/style.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>

<div class="modal fade" id="add-new-symbol" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add New Symbol</h4>
			</div>
			<div class="modal-body">

				<form method="post" action="<?php echo $base_url; ?>/add_new.php" id="add-new-symbol">
					<div class="form-group">
						<label for="symbol">Symbol</label>
						<input type="text" name="symbol" class="form-control" id="symbol" placeholder="Symbol">
					</div>
					<div class="form-group">
						<label for="symbol-name">Symbol Name</label>
						<input type="text" name="symbolName" class="form-control" id="symbol-name" placeholder="Symbol Name">
					</div>
					<div class="form-group">
						<label for="last-price">Last Price</label>
						<input type="text" name="lastPrice" class="form-control" id="last-price" placeholder="Last Price">
					</div>
					<div class="form-group">
						<label for="change">Change</label>
						<input type="text" name="change" class="form-control" id="change" placeholder="Change">
					</div>
					<div class="form-group">
						<label for="change">%Change</label>
						<input type="text" name="changePercent" class="form-control" id="change-percent" placeholder="%Change">
					</div>
					<div class="form-group">
						<label for="volume">Volume</label>
						<input type="text" name="volume" class="form-control" id="volume" placeholder="Volume">
					</div>
					<div class="form-group">
						<label for="date">Time</label>
						<input type="datetime-local" name="date" class="form-control" id="date">
					</div>
					<button type="submit" class="btn btn-primary">Add New Symbol</button>
				</form>

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container">
	<div id="search-container">
		<div class="row">
			<span class="col-md-4">	
			<div class="form-group">
				<input type="text" name="search" class="form-control" id="search" placeholder="Enter a symbol...">
			</div>
			</span>
			<span class="col-md-2">
			<button class="btn btn-default" data-toggle="modal" data-target="#add-new-symbol">Add New Symbol</button>
			</span>
		</div>	
	</div>
	
<?php
	
	if(isset($exist)){
		echo "<h3 class='warning'>This symbol has already been added to watchlist.</h3>";
	}
	
	// Query DB
	$query = "SELECT * FROM quotes";	
	$result = mysqli_query($db, $query) or die('Error querying database.');;
	$row = mysqli_fetch_array($result);
	$symbol_arr = array();

	$table = "";
	$table .= "<table class='table table-striped' border='1' bordercolor='dddddd'>";
	$table .= "<thead>";
	$table .= "<tr> ";
	$table .= "<th>Symbol</th>";
	$table .= "<th>Symbol Name</th>";
	$table .= "<th>Last Price</th>";
	$table .= "<th>Change</th>";
	$table .= "<th>%Change</th>";
	$table .= "<th>Volume</th>";
	$table .= "<th>Time</th>";
	$table .= "<th></th>";
	$table .= "</tr>";
	$table .= "</thead>";
	$table .= "<tbody>";
		
	// Loop through quuery results
	// Echo results to screen in table 
	if( $row !== NULL ) {
		do {
			$symbol 	= $row['symbol'];
			$name 		= $row['name'];
			$last 		= floatval($row['last']);
			$change 	= floatval($row['change']);
			$pctchange 	= floatval($row['pctchange']);
			$volume 	= (int) $row['volume'];
			$tradetime 	= $row['tradetime'];
			$symbol_arr[] = $symbol;
			
			$table .= "<tr class='".$symbol."'>";
			$table .= "<td>".$symbol."</td>";
			$table .= "<td>".$name."</td>";
			$table .= "<td>".$last."</td>";
			$table .= "<td>".$change."</td>";
			$table .= "<td>".$pctchange."</td>";
			$table .= "<td>".$volume."</td>";
			$table .= "<td>".$tradetime."</td>";
			$table .= "<td class='delete_row' align='center'><a href='".$base_url."/delete.php?delete_symb=".$symbol."'>x</a></td>";
			$table .= "</tr>";
		} while ($row = mysqli_fetch_array($result));	
	}
	else{
		$table .= "<tr>";
		$table .= "<td colspan='8'><h5>There are no symbols in your watch list, please add one.</h5></td>";
		$table .= "</tr>";
	}
	$table .= "</tbody>";
	$table .= "</table>";
	echo $table;
	
	mysqli_close($db); 
	
	?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
<![endif]-->

<script src="js/script.js" type="text/javascript"></script>
	
</body>
</html>
