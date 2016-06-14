<?
include "../includes/inc_connect.php";
include "twitchtv.php";

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$twitchtv = new TwitchTV;
$ttv_code = $_GET['code'];

$access_token = $twitchtv->get_access_token($ttv_code);

$username  = $twitchtv->authenticated_user($access_token);

$email = $twitchtv->authenticated_user_email($access_token);

// unterscheidet zwischen groß- und kleinschreibung
$display_name = $twitchtv->authenticated_channel_name($access_token);
//--------------------------------------------------------------//

if($stmt = $mysqli->prepare("SELECT id FROM users WHERE username LIKE ? LIMIT 1")){
	$stmt->bind_param("s", $username);
	$result = $stmt->execute();
	if ( $result === false){
	  die('execute() failed: ' . htmlspecialchars($stmt->error));
	}	
	$stmt->store_result();
	$num_of_rows = $stmt->num_rows;
	$stmt->bind_result($col1);
	while ($stmt->fetch()) {      
	   $q_id = $col1;
    }
	$stmt->close();
}

if ($username != "" AND $access_token != "" AND $display_name != "") {
	// den usernamen gibt es noch nicht, er autorisiert sich zum ersten mal
	if ($num_of_rows == 0) {
		$result = $mysqli->query("SELECT start_money FROM meta WHERE id = 1");
		$meta = $result->fetch_array(MYSQLI_ASSOC);		
		if($stmt = $mysqli->prepare("INSERT INTO users (access_token,username,email,display_name,money) VALUES (?,?,?,?,?)")){
			$stmt->bind_param("ssssi", $access_token, $username , $email , $display_name, $meta["start_money"]);
			$rc = $stmt->execute();
			if ( false===$rc ) {
			  die('execute() failed: ' . htmlspecialchars($stmt->error));
			}	
			$last_id = $stmt->insert_id;			
			$stmt->close();
			$_SESSION["user_id"] = $last_id;				 
		}		
	}
	// der username existiert bereits
	if($num_of_rows == 1){
		if($stmt = $mysqli->prepare("UPDATE users SET access_token = ? WHERE username = ?")){
			$stmt->bind_param("ss", $access_token, $username);
			$rc = $stmt->execute();
			if ( false===$rc ) {
			  die('execute() failed: ' . htmlspecialchars($stmt->error));
			}
			$stmt->close();
		}	
		$_SESSION["user_id"] = $q_id;			
	}		 
	$_SESSION["username"] = $username;		
	header('Location: ../home.php');
}else{
	echo "such error, username, token or display_name no value";
}
?>