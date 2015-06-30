<?php

class TrialsModel extends NumberGuessModel {

	public function getAllTrials() {
		$sql = "SELECT * FROM trials";
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}

	public function getTrialById($trial_id) {
		$sql = "SELECT * FROM trials WHERE trial_id=" . (int)$trial_id;
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data[0];
	}

	public function getTrialsByGameId($game_id) {
		$sql = "SELECT * FROM trials WHERE game_id=" . (int)$game_id;
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}

	public function addTrial() {
		$number = $this->request->parameters['number'];
		$game_id = $this->request->parameters['game_id'];

		$sql = "INSERT INTO trials (game_id, number) VALUES(" . (int)$game_id . "," . (int)$number . ")";
		$query = $this->db->prepare($sql);
		$query->execute();

		//Getting row for return value
		$trial_id = $this->db->lastInsertId();
		$sql = "SELECT * FROM trials WHERE trial_id=" . $trial_id;
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data[0];
	}
}