function displayCountdown(start_date_time, timeLimit){
	// variables for time units and extra digits (i.e. 09 instead of 9)
	var days, hours, minutes, seconds, xhour, xmin, xsec;

	// get tag element
	var countdown = document.getElementById("countdown");
	var timer = document.getElementById("timer");
	// var countdown = $('.countdown');

	// update the tag with id "countdown" every 1 second
	setInterval(function () {

	    // find the amount of "seconds" between now and target
	    var d = new Date();	

	    var current_date = d.getTime();
	    var seconds_left = (timeLimit - (current_date - start_date_time)) / 1000;

	    if (seconds_left < 0){
	    	countdown.innerHTML = "Times Up!";
	    	timer.style.visibility = "visible";
	    } else{
	    	// do some time calculations
		    days = parseInt(seconds_left / 86400);
		    seconds_left = seconds_left % 86400;

		    hours = parseInt(seconds_left / 3600);
		    seconds_left = seconds_left % 3600;
		    xhour = (hours < 10 ) ? '0' : '' ;

		    minutes = parseInt(seconds_left / 60);
		    xmin = (minutes < 10 ) ? '0' : '' ;
		    seconds = parseInt(seconds_left % 60);
		    xsec = (seconds < 10 ) ? '0' : '' ;

		    // format countdown string + set tag value
		    countdown.innerHTML = xmin + minutes + ":" + xsec + seconds; 
		    timer.style.visibility = "visible";

		    //set the color of the timer
		    if (seconds_left < 120){
		    	timer.style.color = "#FF0808";
		    }
		    

	    }

	}, 1000);

}