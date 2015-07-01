<?php

class StatsController extends NumberGuessController {

	public function getAction($request) {
		if(isset($request->url_elements[2])) {
			$data['message'] = "Unsupported action";
		} else {
			$stats = new StatsModel($request);
			$data = $stats->getAllStats();
		}

		return $data;
	}
}