<?php
	require_once("connect.php");
	require_once("sql.php");
	require("phpfunctions.php")
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Booking Form</title>
		<link href="style/basic.css" type="text/css" rel="stylesheet" />
		<script src="javascript.js"></script>
	</head>

	<body>	
		<?php
		//put variable into easy names for later use
		$price = $_POST['price'];
		$date = $_POST['date'];
		$time = $_POST['time'];
		$seats = $_POST['seats'];

		//form validation *based* on w3schools tutorials
		$link = htmlspecialchars($_SERVER["PHP_SELF"]);
		$surname = "";
		$name = "";
		$email = "";
		$surnameError = "";
		$nameError = ""; 
		$emailError = "";
		if(sizeof($_POST)===7){
			if(empty($_POST['name'])){
				$nameError = "Name is required";
			}else{
				$name = validate($_POST['name']);
				if(!preg_match("/^[a-zA-Z ]*$/",$name)){
					$nameError = "Please put in a proper name.";
				}
			if(empty($_POST['surname'])){
				$surameError = "Surname is required";
			}else{
				$surname = validate($_POST['surname']);
			}
				if(!preg_match("/^[a-zA-Z ]*$/",$name)){
					$surnameError = "Please put in a proper name.";
				}
			}
			if(empty($_POST['email'])){
				$emailError = "Email is required";
			}else{
				$email = validate($_POST['email']);
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$emailError = "That doesn't look like an e-mail!";
				}
			}
			// if form has been shown to be valid create and auto submit hidden form to payment page
			if($nameError === "" && $surnameError ==="" && $emailError === ""){

				echo "<form action = 'payment.php' method = 'post' id = 'paymentform'>
				<input id='hiddenPrice' name='price' type='hidden' value =".$_POST['price'].">
				<input id='hiddenName' name='name' type='hidden' value =".$_POST['name'].">
				<input id='hiddenName' name='surname' type='hidden' value =".$_POST['surname'].">
				<input id='hiddenEmail' name='email' type='hidden' value =".$_POST['email'].">
				<input id='hiddenBasket' name='seats' type='hidden' value =".$_POST['seats'].">
				<input id='hiddenDate' name='date' type='hidden' value =".$_POST['date'].">
				<input id='hiddenTime' name='time' type='hidden' value =".$_POST['time'].">
				<script>document.getElementById('paymentform').submit();</script>";
			}
		}
		
		?>

		<?php
			include("header.php");	
		?>

		<fieldset id="customer"> 
			<legend>Customer details</legend>
			<p> Please fill in the below form with your details and click buy now.
			<br/><i>To cancel the order you can simply click the KYT icon in the top left.</i></p>

			<!-- Set up forms as required. validate email on submit *based* on w3schools tutorial -->
			<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>"
			 name="checkbooking" method = "post" onsubmit="return(jValidate());">
				<p>First Name: <input id="customerName" type="text" name="name" value = "" required /></p>
				<span class="error">* <?php echo $nameError;?></span>
				<p>Surname: <input id="customerLastName" type="text" name="surname" value = "" required /></p>
				<span class="error">* <?php echo $nameError;?></span>
				<p>E-mail: <input id="customerEmail" type="text" name="email" value = "" required /></p>
				<span class="error">* <?php echo $emailError;?></span>				
				<br />
				<?php echo "<input id='hiddenPrice' name='price' type='hidden' value =".$price.">
					<input id='hiddenBasket' name='seats' type='hidden' value =".$seats.">
					<input id='hiddenDate' name='date' type='hidden' value =".$date.">
					<input id='hiddenTime' name='time' type='hidden' value =".$time.">";
				?>
				<input type="submit" value="Buy now"/>
			</form>
			<button onclick="amendOrder()">Amend order</button>
			<div id="order">
				<fieldset id="order">
					<legend>Your order</legend>
					<?php
						echo "<u>Total cost</u> <br/><br/>".$price."<br /><br />";
						echo "<u>Seats Booked:</u> <br /> <br />".$seats.".";
					?>
				</fieldset>
			</div>

		</fieldset>
	</body>

<?php 
	require("footer.php");
?>

			
</html>