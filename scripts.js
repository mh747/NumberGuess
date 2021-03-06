startNewGame = function(reqBody, callback) {

	$.ajax({
  		method: "POST",
		url: "http://localhost/NumberGuess/api/games",
		data: reqBody,
		dataType: 'json',
		contentType: 'application/json'
	})
	.fail(function(err, status) {
		console.log('failed. ' + status);
	})
	.done(function(msg){
		console.log(msg);
		callback(msg);
	});
}

storeTrial = function(reqBody, callback) {
	$.ajax({
		method: "POST",
		url: "http://localhost/NumberGuess/api/trials",
		data: reqBody,
		contentType: 'application/json'
	})
	.done(function(msg){
		callback(msg);
	});
}

evalGuess = function(msg, number, max, feedback_element, callback) {
	var correct = 0;
	var difference = msg.difference;
	var message;
	max = + max;
	number = +number;
	if(difference > 0) {
		if(number > max) {
			message = "<div class='alert alert-danger'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Sorry, " + number + " is greater than the max number.</div>";
		} else {
			message = "<div class='alert alert-warning'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Sorry, " + number + " is greater than the secret number.</div>";
		}
	} else if(difference < 0) {
		message = "<div class='alert alert-warning'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Sorry, " + number + " is less than the secret number.</div>";
	} else if(difference == 0) {
		correct = 1;
		message = "<div class='alert alert-success'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You are correct!</div>";
	}

	$(feedback_element).fadeOut( "slow", function(){
		$(feedback_element).html( message );
		$(feedback_element).fadeIn( "fast", function(){
			return callback(correct);
		});
	});
}

endGame = function(game_id, callback) {
	var reqBody = JSON.stringify({
		game_status: "3"
	});

	$.ajax({
		method: "PUT",
		url: "http://localhost/NumberGuess/api/games/" + game_id,
		data: reqBody,
		contentType: 'application/json'
	})
	.done(function(msg){
		callback(msg);
	});
}

getGameLog = function(game_id, callback) {
	$.ajax({
		method: "GET",
		url: "http://localhost/NumberGuess/api/stats/" + game_id,
		contentType: 'application/json'
	})
	.done(function(msg){
		callback(msg);
	});
}

abandonGame = function(game_id, callback) {
	var reqBody = JSON.stringify({
		game_status: "2"
	});

	$.ajax({
		method: "PUT",
		url: "http://localhost/NumberGuess/api/games/" + game_id,
		data: reqBody,
		contentType: 'application/json'
	})
	.done(function(msg){
		callback(msg);
	});
}

collectStats = function(callback) {

	$.ajax({
		method: "GET",
		url: "http://localhost/NumberGuess/api/stats",
		contentType: 'application/json'
	})
	.done(function(msg){
		return callback(msg);
	});
}