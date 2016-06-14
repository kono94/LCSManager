<?
include "../includes/inc_connect.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
//--------------------------------------------------------------//
if(isset($_SESSION["user_id"]) && isset($_POST["league_name"]) && isset($_POST["league_password_1"]) && isset($_POST["league_password_2"])){	
	
	$user_id = (int)$_SESSION["user_id"];
	
	if( strlen($_POST["league_name"]) > 20 ){
		$response = array("error" => true, "error_message" => "League name too long (max. 20 characters)");
		echo json_encode($response);	
		exit;		
	}
	if(strlen($_POST["league_name"]) < 3){
		$response = array("error" => true, "error_message" => "League name too short (min. 3 characters)");
		echo json_encode($response);	
		exit;	
	}
    if($_POST["league_name"] != $mysqli->real_escape_string($_POST["league_name"])){
		$response = array("error" => true, "error_message" => "Special characters are not allowed in the name");
		echo json_encode($response);	
		exit;	   
    }
	if($_POST["league_password_1"] != $_POST["league_password_2"]){
		$response = array("error" => true, "error_message" => "Passwords do not match");
		echo json_encode($response);	
		exit;	   
	}
	
	$already_in_league = $mysqli->query("SELECT * FROM user_leagues WHERE user_id = $user_id");
	$league_count = $already_in_league->num_rows;
	if($league_count != 0){
		$response = array("error" => true, "error_message" => "You are already part of a league");
		echo json_encode($response);	
		exit;	   
	}
	//passed all tests, time to insert the new league in "leagues" and the user to the new created league in "user_leagues"
	if($stmt = $mysqli->prepare("INSERT INTO leagues (name,password,admin_user_id,note) VALUES (?,?,?,'')")){
		$stmt->bind_param("ssi", $_POST["league_name"], $_POST["league_password_1"] , $user_id);
		$rc = $stmt->execute();
		if ( false===$rc ) {
			$response = array("error" => true, "error_message" => "insert error");
			echo json_encode($response);	
			exit;			 
		}	
		$last_id = $stmt->insert_id;			
		$stmt->close();
		if($stmt2 = $mysqli->prepare("INSERT INTO user_leagues (user_id,league_id) VALUES (?,?)")){
			$stmt2->bind_param("ii", $user_id, $last_id);
			$rc = $stmt2->execute();
			if ( false===$rc ) {
				$response = array("error" => true, "error_message" => "inset error 2");
				echo json_encode($response);	
				exit;			 
			}
			$stmt2->close();
			$response = array("error" => false, "success_message" => "Successfully created league! <br> Name: ". $_POST["league_name"]." <br> ID: ".$last_id);
			echo json_encode($response);	
		}			
	}	
}else{
		$response = array("error" => true, "error_message" => "not logged in, no post");
		echo json_encode($response);
}
	
?>