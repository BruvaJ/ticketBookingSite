

<?php
	require_once("connect.php");
	require_once("sql.php");
	require("phpfunctions.php")
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Payment</title>
		<link href="style/basic.css" type="text/css" rel="stylesheet" />
	</head>

	<body>

		<?php
			include("header.php");
		?>

		<?php
			include("menu.php");
		?>

		<?php
		//put variables into smaller, neater names. Seats prepared as array for later use.
			$seats = explode(",", $_POST['seats']);
			$price = $_POST['price'];
			$date = $_POST['date'];
			$time = $_POST['time'];
			$email = $_POST['email'];
			$name = $_POST['name']." ".$_POST['surname'];
		?>

		<?php

		//chgeck that the seat has not already been booked
		$conn = connect();
		$booked = getBooked($conn, $date, $time);
		$check = checkBooking($seats, $booked);
		if(!$check){
			echo "<p class='content'> It seems these seats have already been booked. Please try again! </p>";
			}else{
				//make the payment if the seats are available
				payment($conn, $date, $time, $name, $email, $seats);
				// close the connection
				$conn = null;

				echo "<div id='order'>
				<fieldset id='order'>
					<legend>Your order was succesful</legend>
						<p> Thanks for booking with us ".$name.". We hope you enjoy the show on 
						".$date." at ".$time.".</p>
						<u>Total cost</u>:".$price."<br /><br />
					 	<u>Seats Booked:</u> ".$_POST['seats'].". <br />
					 	</fieldset>
					 </div>"; 
			}
		?>

		<?php
			include("footer.php");
		?>		
</body>	
</html>