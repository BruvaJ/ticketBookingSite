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


		<div class = "body">
			<p class= "content">Welcome to the website of <abbr title = "Kent Youth Theatre"> KYT </abbr>. 
			We are a new, up-and-coming theatre company based in Canterbury run by students at
			the University of Kent. Click <a href="about.php"title ="You know you want to!"> 
			here</a> to learn more about us.</p> 
	 	</div>

	 	<div class = "productionTable">
			<?php
			//connect to server and keep it in $conn variable
				$conn = connect();

				// puts productions and prices into an array
				$productions = getProductions($conn);
				// close the connection
				$conn = null;

				// puts performance times in a seperate array
				// put the data into a table and show to the user
				$productionTable = listProductions($productions);
				echo '<table id = "t01">';
				echo $productionTable;
				echo "</table>";

			?>
		</div>

		<p class="content"><b> Head over to our <a href = schedule.php>schedules page</a> 
		to check out dates and make a booking!</b></p>


	</body>		
		


<?php 
	include("footer.php");
?>

	
</html>