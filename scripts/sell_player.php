<?
include "../includes/inc_connect.php";
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"]) && (int)$_POST["player_id"] != 0){	

	$user_id = (int)$_SESSION["user_id"];
	$region_id = (int)$_SESSION["region"];
	$current_players = $mysqli->query("SELECT * FROM user_players WHERE user_id = $user_id AND region = $region_id");
	$count = 0;
	while($row = $current_players->fetch_array(MYSQLI_ASSOC)){
		if($row["player_id"] == (int)$_POST["player_id"]){
			$sell_player_id = $row["player_id"];
			$bought_for = $row["bought_for"];
			$count++;
		}
	}	
	if($count == 1){
		$update = $mysqli->query("UPDATE users SET money = money + ".($bought_for/2)." WHERE id = $user_id");
		if(!$update){
			$response = array("error" => true, "error_message" => "database update failed on the first step");
		    echo json_encode($response);	
			exit;	
		}
		if($stmt = $mysqli->prepare("DELETE FROM user_players WHERE user_id = ? AND player_id = ? AND region = ?")){
			$stmt->bind_param("iii", $user_id, $sell_player_id, $region_id);
			$result = $stmt->execute();
			if($result === true){
				$response = array("error" => false, "error_message" => "", "success_message" => "successfully sold player with id ".$sell_player_id." !");
				echo json_encode($response);				
			}else{
				$response = array("error" => true, "error_message" => "database update failed");
				echo json_encode($response);	
			}
			$stmt->close();
		}else{
			$response = array("error" => true, "error_message" => "prepared statement error!");
			echo json_encode($response);	
		}
	}else if($count<1){
		$response = array("error" => true, "error_message" => "selected player is not in your team");
		echo json_encode($response);		
	}else{
		$response = array("error" => true, "error_message" => "two players with the same id in your team, contact an admin");
		echo json_encode($response);			
	}
}else{
	$response = array("error" => true, "error_message" => "not logged in or plyaer id manipulated");
	echo json_encode($response);	
}

?>