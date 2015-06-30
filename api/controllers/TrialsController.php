<?php

class TrialsController extends NumberGuessController {

	public function getAction($request) {
		if(isset($request->url_elements[2])) {
			$trial_id = $request->url_elements[2];

			if(isset($request->url_elements[3])) {
				switch($request->url_elements[3]) {
					case 'games':
						$games = new GamesModel($request);
						$data = $games->getGameByTrialId($trial_id);
						break;
					default:
						$data['message'] = "Unsupported action";
				}
			} else {
				$trials = new TrialsModel($request);
				$data = $trials->getTrialById($trial_id);
			}
		} else {
			$trials = new TrialsModel($request);
			$data = $trials->getAllTrials();
		}

		return $data;
	}

	public function postAction($request) {
		if(!isset($request->url_elements[2])) {
			if(isset($request->parameters['number']) && isset($request->parameters['game_id'])) {
				$trials = new TrialsModel($request);
				$data = $trials->addTrial();
			} else {
				$data['message'] = "Must pass a guessed number, and a game id to add a new trial";
			}
		} else {
			$data['message'] = "Unsupported action";
		}

		return $data;
	}
}