<?php
	// Create a database connection

	function connect(){

	try {
			$host = "dragon.ukc.ac.uk";
			$dbuser = "jww21";
			$dbname = "jww21";
			$dbpass = "rhagev!";
			$conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ($conn) {
				return $conn;
			} else {
				echo "Sorry, there was an error connecting to the server.";
			}
		} catch (PDOException $e) {
			echo "PDOException: ".$e->getMessage();
		}
	}

