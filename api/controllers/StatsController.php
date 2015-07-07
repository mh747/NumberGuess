<?php

class StatsController extends NumberGuessController {

	public function getAction($request) {
		if(isset($request->url_elements[2])) {
			$game_id = $request->url_elements[2];
			$stats = new StatsModel($request);
			$results = $stats->getStatsByGameId($game_id);

			if($results[0]['game_status'] == 1) {
				$data['message'] = "Nice try. No cheating allowed.";
			} else {
				$data = $results;
			}
		} else {
			$stats = new StatsModel($request);
			$data = $stats->getAllStats();
		}

		return $data;
	}
}