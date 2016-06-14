<?
include "../includes/inc_connect.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"]) && isset($_POST["league_join_id"]) && isset($_POST["league_join_password"])){
	
	$user_id = (int)$_SESSION["user_id"];
	
	$already_in_league = $mysqli->query("SELECT * FROM user_leagues WHERE user_id = $user_id");
	$league_count = $already_in_league->num_rows;
	if($league_count != 0){
		$response = array("error" => true, "error_message" => "You are already part of a league");
		echo json_encode($response);	
		exit;	   
	}	
	
	if($stmt = $mysqli->prepare("SELECT id FROM leagues WHERE id = ? AND password = ?")){
		$stmt->bind_param("is", $_POST["league_join_id"], $_POST["league_join_password"]);
		$rc = $stmt->execute();
		if ( false===$rc ) {
			$response = array("error" => true, "error_message" =>"select error");
			echo json_encode($response);	
			exit;			 
		}	
		$stmt->store_result();
		$count = $stmt->num_rows;			
		$stmt->close();
		if($count == 1){
			if($stmt = $mysqli->prepare("INSERT INTO user_leagues (user_id,league_id) VALUES (?,?)")){
				$stmt->bind_param("ii", $user_id, $_POST["league_join_id"]);
				$rc = $stmt->execute();
				if ( false===$rc ) {
					$response = array("error" => true, "error_message" => "insert error");
					echo json_encode($response);	
					exit;			 
				}
				$stmt->close();
				$response = array("error" => false, "success_message" => "Successfully joined league! <br> Name: undefined <br> ID: ".$_POST["league_join_id"]);
				echo json_encode($response);	
				exit;
			}		
		}else{
			$response = array("error" => true, "error_message" => "Wrong password or league does not exist");
			echo json_encode($response);	
			exit;		
		}
				
	}	
}else{
		$response = array("error" => true, "error_message" => "not logged in, no post");
		echo json_encode($response);
}
	
?>