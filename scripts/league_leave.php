<?
include "../includes/inc_connect.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"])){
	
	$user_id = (int)$_SESSION["user_id"];
	
	$already_in_league = $mysqli->query("SELECT * FROM user_leagues WHERE user_id = $user_id");
	$league_count = $already_in_league->num_rows;
	if($league_count == 0){
		$response = array("error" => true, "error_message" => "Cant leave a league you not a part of");
		echo json_encode($response);	
		exit;	   
	}	
	
	if($stmt = $mysqli->prepare("DELETE FROM user_leagues WHERE user_id = ?")){
		$stmt->bind_param("i", $user_id);
		$rc = $stmt->execute();
		if ( false===$rc ) {
			$response = array("error" => true, "error_message" => "delete error");
			echo json_encode($response);	
			exit;			 
		}				
		$stmt->close();
		$response = array("error" => false, "success_message" => "Successfully left your league(s)");
		echo json_encode($response);	
		exit;				
	}	
}else{
		$response = array("error" => true, "error_message" => "not logged in, no post");
		echo json_encode($response);
}
	
?>