<?php

class StatsModel extends NumberGuessModel {

	public function getAllStats() {
		$sql = "SELECT g.*, t.number, t.trial_time from games g LEFT JOIN trials t on g.game_id=t.game_id WHERE g.game_status <> 1 ORDER BY g.start_time,t.trial_time";
		$query = $this->db->prepare($sql);
		$query->execute();
		$data['stats'] = $query->fetchAll(PDO::FETCH_ASSOC);

		//Getting totals
		$sql = "SELECT count(*) Total, sum(case when game_status=2 then 1 else 0 end) Abandoned, "
			. "sum(case when game_status=3 then 1 else 0 end) Completed FROM games";
		$query = $this->db->prepare($sql);
		$query->execute();
		$data['totals'] = $query->fetch(PDO::FETCH_ASSOC);

		return $data;
	}

	public function getStatsByGameId($game_id) {
		$sql = "SELECT g.*, t.number, t.trial_time from games g LEFT JOIN trials t on g.game_id=t.game_id WHERE g.game_id=" . (int)$game_id . " ORDER BY g.start_time,t.trial_time";
		$query = $this->db->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		return $data;	
	}
}

?>