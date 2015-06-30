<?php

class GamesModel extends NumberGuessModel {

	public function getAllGames() {
		$sql = "SELECT * FROM games";
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}

	public function getGameById($game_id) {
		$sql = "SELECT * FROM games WHERE game_id=" . (int)$game_id;
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data[0];
	}

	public function getGameByTrialId($trial_id) {
		$sql = "SELECT g.game_id, g.max_number, g.secret_number, g.start_time, g.game_status" .
			" FROM games g, trials t WHERE t.game_id=g.game_id and t.trial_id=" . $trial_id;

		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data[0];
	}

	public function getNewGame() {
		$max_number = (int)$this->request->parameters['max_number'];
		//$data['message'] = 'the number is ' . $max_number;

		//Generating secret number
		$secret_number = rand(0, $max_number);

		//Adding new game record to 'games' table
		$sql = "INSERT INTO games (max_number, secret_number, game_status) VALUES(" . $max_number . "," . $secret_number . ", 1)";
		$query = $this->db->prepare($sql);
		$query->execute();

		//Getting row to return 
		$game_id = $this->db->lastInsertId();
		$sql = "SELECT * from games WHERE game_id=" . $game_id;
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data[0];
	}
}

?>