<?php

// Perform database query for productions and prices
function getProductions($conn){
	$query = "SELECT * ";
	$query .= "FROM Production;";

	$handle = $conn->prepare($query);
	$handle->execute();
	$result = $handle->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}
?>

<?php

//perform database query for performance dates
function getPerformances($conn){
	$query = "SELECT Performance.Title, Production.BasicTicketPrice, 
				Performance.PerfDate, Performance.PerfTime 
				FROM Production JOIN Performance 
				ON Production.Title = Performance.Title;";

	$handle = $conn->prepare($query);
	$handle->execute();
	$result = $handle->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}

//perform database query for zone names and price multipliers
function getZones($conn){
	$query = "SELECT * FROM Zone;";
	$handle = $conn->prepare($query);
	$handle->execute();
	$result = $handle->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}

//a query to return the number of available seats by performance
function getAllAvail($conn, $date, $time){
		$query = $conn->prepare ("SELECT COUNT(Seat.RowNumber) FROM Seat LEFT JOIN
				(SELECT * FROM Booking WHERE PerfDate = :perfdate AND PerfTime = :perftime) 
				AS b ON Seat.RowNumber = b.RowNumber WHERE b.RowNumber IS NULL;");
		$query ->bindParam(':perfdate', $date);
		$query ->bindParam(':perftime', $time);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_COLUMN);
	return $result;
}

//a query to return the number of seats available by zone of a particular performance
function getAvailability($conn, $zones, $date, $time){
	$result = [];
	foreach($zones as $zone){
		$query = $conn->prepare("SELECT COUNT(Seat.RowNumber) FROM Seat LEFT JOIN
				(SELECT * FROM Booking WHERE PerfDate = :perfdate AND PerfTime = :perftime) 
				AS b ON Seat.RowNumber = b.RowNumber WHERE b.RowNumber IS NULL 
				AND Seat.Zone = :zonename");
		$query ->bindParam(':perfdate', $date);
		$query ->bindParam(':perftime', $time);
		$query ->bindParam(':zonename', $zone['Name']);
		$query->execute();
		array_push($result, $query->fetch(PDO::FETCH_COLUMN));
	}
	return $result;
}


//database query for all seats booked based on date and time
function getBooked($conn, $date, $time){
	$query = $conn->prepare("SELECT RowNumber FROM Booking WHERE PerfDate = :perfdate 
				AND PerfTime = :perftime");

	$query->bindParam(':perfdate', $date);
	$query->bindParam(':perftime', $time);
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_COLUMN);

	return $result;
}

//a function to return all seats in the theatre
function getAllSeats($conn){
	$query = $conn->prepare("SELECT Zone, RowNumber FROM Seat;");
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_COLUMN);

	return $result;
}

// insert a booking into the database.
function payment($conn, $date, $time, $name, $email, $seats){
	$query = $conn->prepare("INSERT INTO Booking 
	VALUES(:ref, :perfdate, :perftime, :custname, :email, :seat)");

	$query->bindParam(':ref', $reference);
	$query->bindParam(':perfdate', $date);
	$query->bindParam(':perftime', $time);
	$query->bindParam(':custname', $name);
	$query->bindParam(':email', $email);
	$query->bindParam(':seat', $seat);

	foreach($seats as $seat){
		$reference = $seat . time() . mt_rand(0, 100);
		$query ->execute();
	}
}

?>
