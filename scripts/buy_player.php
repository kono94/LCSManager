<?
include "../includes/inc_connect.php";
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"]) && (int)$_POST["player_id"] != 0){	

	$user_id = (int)$_SESSION["user_id"];
    $region_id = (int)$_SESSION["region"];	
	$player_info_query = $mysqli->query("SELECT * FROM players WHERE id = ".(int)$_POST["player_id"]." AND region = $region_id LIMIT 1");
	if(!$player_info_query OR $player_info_query->num_rows < 1){
			$response = array("error" => true, "error_message" => "Player does not exist");
		    echo json_encode($response);	
			exit;		
	}
	$player_info = $player_info_query->fetch_array(MYSQLI_ASSOC); 
	
	$current_players = $mysqli->query("SELECT * FROM user_players WHERE user_id = $user_id AND region = $region_id");
	$playercount = $current_players->num_rows;
	//check if to-buy-player is already part of users team
	$helper = 6;
	$position = -1;
	while($row = $current_players->fetch_array(MYSQLI_ASSOC)){		
		if($row["player_id"] == (int)$_POST["player_id"]){
			$response = array("error" => true, "error_message" => "You already own this player!");
		    echo json_encode($response);	
			exit;	
		}
		if($row["position"]>5){
			if(($helper - $row["position"]) < 0 && $position < 0){
				$position = $helper;
			}
			$helper++;
		}
	}	
	if($position < 0 && $helper < 14 ){
		$position = $helper;
	}
	
	if($playercount < 9 ){
		$user_info = get_session_user($mysqli);
		// if user does not have enough money to buy the player exit the script
		if($user_info["money"] < $player_info['price']){
			$response = array("error" => true, "error_message" => "Not enough money");
		    echo json_encode($response);	
			exit;			
		}
		$update = $mysqli->query("UPDATE users SET money = money - ".$player_info['price']." WHERE id = $user_id");
		if(!$update){
			$response = array("error" => true, "error_message" => "database update failed on the first step");
		    echo json_encode($response);	
			exit;	
		}
		if($stmt = $mysqli->prepare("INSERT INTO user_players (user_id, player_id, bought_for, position,  region ) VALUES (?,?,?,?,?)")){
			$stmt->bind_param("iiiii", $user_id, $player_info['id'], $player_info['price'], $position,  $region_id);
			$result = $stmt->execute();
			if($result === true){
				$response = array("error" => false, "error_message" => "", "success_message" => "successfully bought ".$player_info['nickname']." !");
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
	}else{
		$response = array("error" => true, "error_message" => "You cant have more than 8 players in you team!");
		echo json_encode($response);			
	}
}else{
	$response = array("error" => true, "error_message" => "not logged in or player id manipulated");
	echo json_encode($response);	
}

?>