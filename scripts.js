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

evalGuess = function(secret, guess, max, feedback_element, callback) {
	var correct = 0;
	var message;
	secret = +secret;
	guess = +guess;
	max = + max;
	if(guess > secret) {
		if(guess > max) {
			message = "Guess is greater than max number.";
		} else {
			message = "Guess is greater than secret.";
		}
	} else if(guess < secret) {
		message = "Guess is less than secret.";
	} else if(guess == secret) {
		correct = 1;
		message = "You are correct!";
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