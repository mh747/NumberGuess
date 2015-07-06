<?php

class GamesController extends NumberGuessController {
	public function getAction($request) {
		//Implement get -- should give statistics
		//$data['message'] = 'GET request to /api/games';
		if(isset($request->url_elements[2])) {
			$game_id = (int)$request->url_elements[2];

			if(isset($request->url_elements[3])) {
				switch($request->url_elements[3]) {
					case 'trials':
						$trials = new TrialsModel($request);
						$data = $trials->getTrialsByGameId($game_id);
						break;
					default:
						$data['message'] = "Unsupported action";
				}
			} else {
				$games = new GamesModel($request);
				$game = $games->getGameById($game_id);
				if($game['game_status'] == 1) {
					$data['message'] = "Nice try. No cheating allowed.";
				} else {
					$data = $game;
				}
			}
		} else {
			$games = new GamesModel($request);
			$data = $games->getAllGames();
		}

		return $data;
	}

	/*Function postAction
		Takes in a Request object containing info on the incoming http request
		Request should contain a number, which is the max number. This will be 
		read and a secret number will be calculated, and the new game instance 
		will be added to the games table. Returns (int) secret number.
	*/
	public function postAction($request) {
		//Function called to start new game on front-end

		//Making sure correct URI is called, must be /api/games, nothing after
		if(!(isset($request->url_elements[2]))) {
			if(isset($request->parameters['max_number'])) {
				$games = new GamesModel($request);
				$data = $games->getNewGame();
			} else {
				//Max number not set --- return 400 bad request
				$data["message"] = "Must pass in max_number field in http request body";
			}
		} else {
			//Bad request - invalid url
			$data["message"] = "Bad Request - Invalid URL";
		}

		return $data;
	}

	public function putAction($request) {
		if(isset($request->url_elements[2])) {
			$game_id = $request->url_elements[2];
			if(isset($request->parameters['game_status'])) {
				if($request->parameters['game_status'] != 1) {
					$games = new GamesModel($request);
					$data = $games->updateGame($game_id);
				} else {
					$data['message'] = "Cannot reactivate a completed or abandoned game.";
				}
			} else {
				//Record will be unchanged
				$games = new GamesModel($request);
				$data = $games->getGameById($game_id);
			}
		} else {
			$data['message'] = "Game ID to be changed must be sent in url";
		}

		return $data;
	}
}