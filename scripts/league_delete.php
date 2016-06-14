<?
include "../includes/inc_connect.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"])){
	
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
		if($stmt = $mysqli->prepare("DELETE FROM user_leagues WHERE league_id = ?")){
			$stmt->bind_param("i", $league_id);
			$rc = $stmt->execute();
			if ( false===$rc ) {
				$response = array("error" => true, "error_message" => "delete error 1");
				echo json_encode($response);	
				exit;			 
			}else{
				if($stmt2 = $mysqli->prepare("DELETE FROM leagues WHERE id = ?")){
					$stmt2->bind_param("i", $league_id);
					$rc = $stmt2->execute();
					if ( false===$rc ) {
						$response = array("error" => true, "error_message" => "delete error 2");
						echo json_encode($response);
						exit;						
					}	
					$response = array("error" => false, "success_message" => "You deleted your league :(");
					echo json_encode($response);	
					$stmt2->close();
				}				
			}				
			$stmt->close();						
		}		
	}	
}else{
		$response = array("error" => true, "error_message" => "not logged in, no post");
		echo json_encode($response);
}
	
?>