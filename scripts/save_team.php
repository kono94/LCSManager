<?
include "../includes/inc_connect.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"]) && isset($_POST["players"]) && $_POST["players"] != ""){	
	
	$user_id = (int)$_SESSION["user_id"];
	$region_id = (int)$_SESSION["region"];
	$current_players = $mysqli->query("SELECT * FROM user_players INNER JOIN players ON user_players.player_id = players.id WHERE user_id = $user_id AND user_players.region = $region_id");
	$count = 0;
	$client_player_count = 0;
	$server_player_count = 0;
	$bought_for_array = array();
	$i = 0;
	$check_for_pos = array();
	
	foreach ($_POST["players"] as &$given_player) {
		if($given_player["id"] != NULL){ 
			$client_player_count++;
			if($given_player["pos"] == 14){
				$response = array("error" => true, "error_message" => "Sellbox has to be emtpy");
				echo json_encode($response);	
				exit;		
			}
			$check_for_pos[$i] = $given_player["pos"];
			$i++;
		}
	}
	if(count($check_for_pos) != count(array_unique($check_for_pos))){
		$response = array("error" => true, "error_message" => "positions got manipulated... faggot ");
		echo json_encode($response);	
		exit;	
	}
	
	while($row = $current_players->fetch_array(MYSQLI_ASSOC)){		
			$bought_for_array[$row["player_id"]] = $row["bought_for"];			
			foreach ($_POST["players"] as &$given_player) {
				if($given_player["id"] != NULL && $given_player["id"] == $row["player_id"]){
					if($given_player["pos"] > 0 && $given_player["pos"] <=5){
						if($given_player["pos"] != $row["role"]){
							$response = array("error" => true, "error_message" => "faggot trying to manipulate the html code.. ");
							echo json_encode($response);	
							exit;	
						}
					}
					$count++;
				}
		    }
			if($count == 1){
				//player found in DB
				$server_player_count++;
			}else{
				$response = array("error" => true, "error_message" => "Did not find all players");
				echo json_encode($response);	
				exit;	
			}	
			$count = 0;		
	}		
	if($client_player_count === $server_player_count){		
		if($stmt = $mysqli->prepare("UPDATE user_players SET position = ? WHERE user_id = ? AND player_id = ? AND region = ?")){
			foreach ($_POST["players"] as &$given_player) {								
				if($given_player["id"] != NULL && $given_player["pos"] > 0 && $given_player["pos"] < 14){
					$stmt->bind_param("iiii", $given_player["pos"], $user_id,  $given_player["id"], $region_id);
				}else{
					$response = array("error" => true, "error_message" => "index error!".$given_player["pos"]);
					echo json_encode($response);	
					exit;		
				}
				$result = $stmt->execute();
				if($result === false){					
					$response = array("error" => true, "error_message" => "update error!");
					echo json_encode($response);	
					exit;
				}				
			}
			$stmt->close();
			$response = array("error" => false, "error_message" => "", "success_message" => "Saved your team!");
			echo json_encode($response);		
			exit;
		}else{
			$response = array("error" => true, "error_message" => "prepared statement error!");
			echo json_encode($response);		
		}
	}else{
		$response = array("error" => true, "error_message" => "Your team has changed please reload the page");
		echo json_encode($response);
		exit;
	}
}else{
		$response = array("error" => true, "error_message" => "not logged in, no post");
		echo json_encode($response);
}
	
?>