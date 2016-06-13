//this function will deal with selection, and deselection of seats. Presenting both
// selected seats and total price to the user.

function selectSeat(td, basket ,seat, multiplier, price){
	if(td.className == 'available'){
		td.className = 'select';
		basket.push(seat);
		total += (multiplier * price);
	}else{
	total -= (multiplier * price);
	td.className = 'available';
	var i = 0;
	while(basket[i] !== seat){
		i++;
		}
	basket.splice (i, 1);
	}
	totalPounds = "&pound".concat(parseFloat(total).toFixed(2));


	document.getElementById("basket").innerHTML = basket;
	document.getElementById("price").innerHTML = totalPounds;

	document.getElementById("hiddenPrice").value = totalPounds;
	document.getElementById("hiddenBasket").value = basket;
	if(basket.length > 0){
	document.getElementById("submitButton").type = "submit";	
	}else{
	document.getElementById("submitButton").type = "hidden";			
	}
}

//checks that the email resembles a real address and the name is not too long
function jValidate(){
	at = document.getElementById("customerEmail").value.indexOf("@");
	period = document.getElementById("customerEmail").value.indexOf(".");
	name = document.getElementById("customerName").value;
	surname = document.getElementById("customerLastName").value;
	if(at === -1 || period === -1 || (at + period) < 4){
    	alert("Please use a real e-mail address.");
		return false;
    }else if(name.length>20){
    	alert("That name is a little long! Try something shorter.");
    	return false;
    }else if(surname.length>20){
    	alert("That surname is a little long! Try something shorter.");
    	return false;
    }else{
		return true;
	}
}

//go back a page. gives the user a chance to change their order
function amendOrder(){
	window.history.back();
}