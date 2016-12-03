<?php

class VGame {
	
	//Nende funktsioonide põhimõte - iga kasutaja saab salvestada oma videomänge (mis tal olemas on)
	
	private $connection;
	
	function __construct($mysqli) {
			
		$this->connection = $mysqli;
			
		}
		
		function SaveVGame ($vgame) {
			
			$stmt = $this->connection->prepare("INSERT INTO V_Games (V_game_name) VALUES(?)");
			
			echo $this->connection->error;
			
			$stmt->bind_param("s", $vgame);
			
			if($stmt->execute()) {
				
				echo "Saving successful";
				
			} else {
				
				echo "Error".$stmt->error;
				
			}
			
			$stmt->close();
			
		}
		
		function SaveUserVGame ($vgame) {
			
			$stmt = $this->connection->prepare("SELECT id FROM User_V_Games WHERE User_id=? AND v_game_id=?");
			
			echo $this->connection->error;
			
			$stmt->bind_param("ii", $_SESSION["userId"], $vgame);
			
			$stmt->execute();
			
			if($stmt->fetch()) {
				
				echo "Already exists";
				return;
				
			}
			
			$stmt->close();
			
			$stmt = $this->connection->prepare("INSERT INTO User_V_Games (user_id, v_game_id) VALUES (?, ?)");
			
			echo $this->connection->error;
			
			$stmt->bind_param("ii", $_SESSION["userId"], $vgame);
			
			if($stmt->execute()) {
				
				echo "Saving successful";
				
			} else {
				
				echo "Error".$stmt->error;
				
			}
			
			$stmt->close();
			
		}
		
		function GetAllVGames() {
			
			$stmt = $this->connection->prepare("SELECT id, V_game_name FROM V_Games");
			echo $this->connection->error;
			
			$stmt->bind_result($id, $V_game_name);
			$stmt->execute();
			
			$result = array();
			
			while($stmt->fetch()) {
				
				$v = new StdClass();
				
				$v->id = $id;
				$v->v_game_name = $V_game_name;
				
				array_push($result, $v);
				
			}
			
			$stmt->close();
			return $result;
			
		}
	
}

?>