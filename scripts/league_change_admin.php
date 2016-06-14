<?
include "../includes/inc_connect.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"]) && isset($_POST["new_admin_id"])){
	
	$user_id = (int)$_SESSION["user_id"];
	
	$already_in_league = $mysqli->query("SELECT * FROM user_leagues INNER JOIN leagues ON user_leagues.league_id = leagues.id  WHERE user_id = $user_id");
	$league_count = $already_in_league->num_rows;
	if($league_count == 0){
		$response = array("error" => true, "error_message" => "Not part of league");
		echo json_encode($response);	
		exit;	   
	}else{
		$row = $already_in_league->fetch_array(MYSQLI_ASSOC);
		$league_id = $row["league_id"];
		$current_admin_id = $row["admin_user_id"];
	}	
	if($current_admin_id != $user_id){
			$response = array("error" => true, "error_message" => "You are not admin");
			echo json_encode($response);	
			exit;			
	}else{
		if($stmt = $mysqli->prepare("SELECT * FROM user_leagues WHERE user_id = ? AND league_id = ?")){
			$stmt->bind_param("ii", $_POST["new_admin_id"], $league_id);
			$rc = $stmt->execute();
			if ( false===$rc ) {
				$response = array("error" => true, "error_message" =>"select error");
				echo json_encode($response);	
				exit;			 
			}	
			$stmt->store_result();
			$count = $stmt->num_rows;			
			$stmt->close();
		}
		if($count != 1){
			$response = array("error" => true, "error_message" => "Selected user not part of your league");
			echo json_encode($response);	
			exit;			
		}else{
			if($stmt = $mysqli->prepare("UPDATE leagues SET admin_user_id = ? WHERE id = ?")){
				$stmt->bind_param("ii", $_POST["new_admin_id"], $league_id);
				$rc = $stmt->execute();
				if ( false===$rc ) {
					$response = array("error" => true, "error_message" => "update error");
					echo json_encode($response);	
					exit;			 
				}				
				$stmt->close();
				$response = array("error" => false, "success_message" => "Successfully changed league admin");
				echo json_encode($response);	
				exit;				
			}	
		}
	
	}	
}else{
		$response = array("error" => true, "error_message" => "not logged in, no post");
		echo json_encode($response);
}
	
?>