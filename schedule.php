<?php
	require_once("connect.php");
	require_once("sql.php");
	require("phpfunctions.php")
?>

<!DOCTYPE html>
<html>
	<head>
		<title>KYT - Home</title>
		<link href="style/basic.css" type="text/css" rel="stylesheet" />
	</head>

	<body>

		<?php
			include("header.php");
		?>

		<?php
			include("menu.php");
		?>

		<p class="content"> See below a list of all our upcoming shows.
		 Press the links under "Availability" to make a booking. </p>

		<?php

		//connect to server and keep it in $conn variable
		$conn = connect();

		// puts productions and prices into an array
		$performances = getPerformances($conn);
		//creates an array to list availability by performance
		$allAvail = [];
		foreach($performances as $performance){
			$date = $performance['PerfDate'];
			$time = $performance['PerfTime'];
			array_push($allAvail, getAllAvail($conn, $date, $time));
		}
		$performanceTable = listPerformances($performances, $allAvail);
		echo '<table id = "t01">';
		echo $performanceTable;
		echo "</table>";
		// close the connection
		$conn = null;
		?>

	</body>

<?php 
	require("footer.php");
?>

			
</html>