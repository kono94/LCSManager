<?
require "inc_config.php";
$user_logged = session_name("user_logged");
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
   if(!isset($_COOKIE["login"])){
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	}
}
$_SESSION['LAST_ACTIVITY'] = time();

// establish connection to database
$mysqli = new mysqli(DB_HOST, DB_USERNAME , DB_PASSWORD, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (". $mysqli->connect_errno . ")" . $mysqli->connect_error;
}

function check_input($mysqli,$data){
	if($data == trim($mysqli->real_escape_string($data)))return $data;	
	echo "mysql injection?"; exit;  
}

if (!isset($_SESSION["region"]) OR !((int)$_SESSION["region"] == 0 OR (int)$_SESSION["region"] == 1)){	
	if(isset($_COOKIE["region"])){
		if((int)$_COOKIE["region"] == 0){
			$_SESSION["region"] = 0;
		}else if((int)$_COOKIE["region"] == 1){
			$_SESSION["region"] = 1;
		}else{
			$_SESSION["region"] = 0;
			setcookie("region",0,time()+3600*24*14,'/', 'lcsmanager.net');
		}
	}else{
		$_SESSION["region"] = 0;
		setcookie("region",0,time()+3600*24*14,'/', 'lcsmanager.net');
	}
}

		
// get_result not working
// function get_session_user($mysqli){
	// if (isset($_SESSION['username'])) { 
		// $username = check_input($mysqli,$_SESSION["username"]);
		// if ($stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?")){
			// $stmt->bind_param("s", $username);
			// $stmt->execute();			
			// return $stmt->get_result();
		// }
	// }	
	// return false;
// }

function get_session_user($mysqli){
	if (isset($_SESSION["user_id"])) { 		
		$result = $mysqli->query("SELECT * FROM users WHERE id = ".(int)$_SESSION["user_id"]." LIMIT 1");			
		return $result->fetch_array(MYSQLI_ASSOC);
	}	
	return false;
}
function get_meta_data($mysqli){
	$result = $mysqli->query("SELECT * FROM meta WHERE id = 1 LIMIT 1");			
	return $result->fetch_array(MYSQLI_ASSOC);
}

?>