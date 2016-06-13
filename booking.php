<?php
	require_once("connect.php");
	require_once("sql.php");
	require("phpfunctions.php")
?>

<!DOCTYPE html>
<html>
	<head>
		<title>KYT - Seating Plan</title>
		<link href="style/basic.css" type="text/css" rel="stylesheet" />
		<script src="javascript.js"></script>
	</head>


	<body>	
		<?php
			include("header.php");		
		?>
		<?php
			include("menu.php");
		?>		

		<?php
			$price = $_POST['price'];
			$date = $_POST['date'];
			$time = $_POST['time'];

			//connect to server and keep it in $conn variable
			$conn = connect();
			$zones = getZones($conn);
			$zoneAvail = getAvailability($conn, $zones, $date, $time);
			$booked = getBooked($conn, $date, $time);
			$allseats = getAllSeats($conn);

			// close the connection
			$conn = null;
			
			// puts productions and prices into an array

			$priceTable = listPrices($zones, $price, $zoneAvail);
			echo '<table id = "t01">';
			echo $priceTable;
			echo "</table>";
			?>

			<p class="content"> Click on a seat to select it. Once you've selected your seats
			click the "Next step" button in the bottom right to continue. Red seats are unavailable,
			green are available. </p>
			<?php			

			$seatTable = makeSeatTable($zones, $allseats, $booked, $price);
			echo $seatTable; 

			// create and set users basket to empty
			echo '<script> 
				var basket = [];
				var total = 0;
			</script>';
	
			echo	'<p id="basket"><u><b> No seats selected </b></u></p id="basket">
					<p id="price"><u><b> Price </b></u></p>

					<form name="myform" action="bookingform.php" method="post">	
						<input id="hiddenPrice" name="price" type="hidden"/>
						<input id="hiddenBasket" name="seats" type="hidden"/>
						<input id="hiddenDate" name="date" type="hidden" value='.$_POST['date'].' />
						<input id="hiddenTime" name="time" type="hidden" value='.$_POST['time'].' />
						<input id="submitButton" name="mySubmit" type="hidden" value="Next step"/>
					</form>'
	
		?>
<!--Makes sure basket doesn't overlap seating plan -->
<br/ > <br /> <br /> <br />


	</body>		
			

</html>