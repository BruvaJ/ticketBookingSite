<?php
// A function to organise the array storing production details and present it to the user as a table.

function listProductions($productions){
	$productionTable = '<CAPTION>Currently Showing</CAPTION>';
	$productionTable .= "<tr> <th> Title </th> <th> Prices From </th>";
	foreach($productions as $production) {
		$productionTable .= "<tr>";
		$productionTable .= "<td>".$production['Title']."</td>
						<td>"."&pound{$production['BasicTicketPrice']}"."</td>";
	}
	return $productionTable;
}
//A function to list production, price, performance date,  and time as a table

function listPerformances($performances, $available){
	$performanceTable = '<CAPTION>Currently Showing</CAPTION>';
	$performanceTable .= "<tr> <th> Title </th> <th> Prices From </th><th>Date<th>Time</th><th>Availability</th>";


	$check = 1;
	for($i = 0 ; $i < sizeof($performances); $i ++) {
		//move variables into names for clarity and neatness of code

		$title = $performances[$i]['Title'];
		$price = $performances[$i]['BasicTicketPrice'];
		$date =  $performances[$i]['PerfDate'];
		$time =  $performances[$i]['PerfTime'];	



		$performanceTable .= "<tr>";

		//create the rowspan of title and price column to avoid repetition by checking against 
		//next item in array until 
		if($i+ $check < sizeof($performances) && $title == $performances[$i+$check]['Title']){
			while($i+ $check < sizeof($performances) && $title == $performances[$i+$check]['Title']){
				$check ++;}

		$performanceTable .= "<td class='important' rowspan = $check>".$title."</td>
					<td class='important' rowspan = $check>"."&pound{$price}"."</td>";}

		$performanceTable .= 
						"<td>".$date."</td>
						<td>".$time."</a></td>";
		//create the values to be submitted when clicking a button
		$performanceTable.= '<form action="booking.php?" method="post">		
		<input id="hiddenDate" name="date" type="hidden" value='.$date.' />
		<input id="hiddenTime" name="time" type="hidden" value='.$time.' />
		<input id="hiddenPrice" name="price" type="hidden" value='.$price.' />';

		//display to the user if many seats left, less than twenty orrrrr no seats
		if($available[$i] <= 100 && $available[$i] > 0){	
			$performanceTable .=  "<td><input type='submit' value='Only ".$available[$i]." seats left!'/></td>";			
		}elseif($available[$i] > 100){
			$performanceTable .= "<td><input type='submit' value='See seats'/></td>";
		}else{
			$performanceTable .= "<td>Fully booked!</td>";
		}
		$performanceTable .= '</form>';

		$performanceTable .= "</tr>";
		$check --;

	}
	return $performanceTable;
}
//Make a table of prices and remaining seats by zone for a selected performance
function listPrices($zones, $price, $zoneAvail){
	$priceTable = '<CAPTION>Price List</CAPTION>';
	$priceTable .= "<tr> <th> Zone </th> <th> Price </th> <th> Availability </th>";
	$i = 0;
	foreach($zones as $zone) {
		//move variables into names for clarity and neatness of code
		$zoneName = $zone['Name'];
		$multiplier = $zone['PriceMultiplier'];

		//prepare price as currency
		$zonePrice = $multiplier * $price;
		$zonePrice = number_format($zonePrice, $decimals = 2);

		$priceTable .= "<tr>";
		$priceTable .= "<td>".$zoneName."</td>
						<td>"."&pound{$zonePrice}"."</td>
						<td>".$zoneAvail[$i]."</td>";
		$i ++;
	}
	$priceTable .= "</table>";
	return $priceTable;
}

//Make a group of tables to display availability of seats
function makeSeatTable($zones, $allseats, $booked, $price){
	$seatTable = "";
	foreach($zones as $zone){

		$name = $zone['Name'];		
		$seatTable .= '<table class="zone">';
		$seatTable .=  "<CAPTION>".$name."</CAPTION>";
		$seatTable .=  "<tr>";
		for($i =0; $i < sizeof($allseats[$name]) ; $i++){
			//if the seat isn't already booked show as available and include relevant data
			// otherwise show as unavailable
			if(!in_array($allseats[$name][$i], $booked)){
				$seatTable .=  '<td class="available" onclick = "selectSeat(this, basket, \''.
					$allseats[$name][$i].'\', \''.$zone['PriceMultiplier'].'\', \''.$price.'\');"></td>';			
			} else {
				$seatTable .=  '<td class = "unavailable"></td>';
			}
			if($i > 0 && ($i + 1) % 20 == 0){
				$seatTable .=  "</tr><tr>";
			}
		}
	
	}
	$seatTable .= "</tr></table>";
	return $seatTable;
}

//when a booking is made make sure those seats have not already been taken.
//A useful function anyway, but used specifically due to a bug found where
//a user could click back after booking and then rebuy the same tickets.
//This prevents that.
function checkBooking($seats, $booked){
	for($i = 0; $i < sizeof($seats); $i++){
		if(in_array($seats[$i], $booked)){
			return false;
		}
	}
	return true;
}

//input form validation. From w3schools tutorial.
function validate($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>