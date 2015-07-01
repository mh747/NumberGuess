<?php

class StatsModel extends NumberGuessModel {

	public function getAllStats() {
		$sql = "SELECT g.*, t.number, t.trial_time from games g LEFT JOIN trials t on g.game_id=t.game_id order by g.start_time,t.trial_time";
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}
}

?>