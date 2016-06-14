<?php require "includes/inc_connect.php"; ?>
<?php include "includes/layout/head.php";?>
</head>
	<body>
<?php include "includes/layout/header.php"; ?>  
<?php include "includes/layout/navigation.php"; ?>  
		<div id="pageWrapper">
			<div id="page-content">
		<?php //page content ?>
		<?php include "scripts/twitchtv.php";	
		    $twitchtv = new TwitchTV; ?>
		<?php if (!isset($_SESSION["user_id"])): ?>
		<a id="signup" href="<?php echo $twitchtv->authenticate() ?>">LOGIN VIA TWITCH.TV</a>
		<br> CURRENTLY NOT LOGGED IN
		<? else:  $user_info = get_session_user($mysqli);?>
		Hallo <b><? echo  $user_info["username"]; ?></b><br>		
		ID: <?  echo $_SESSION["user_id"];?><br>
		username: <? echo $user_info["username"]; ?><br>
		display name: <? echo $user_info["display_name"]; ?><br>
		money: <? echo $user_info["money"]; ?> <br>
		email: <? echo $user_info["email"]; ?><br>
		access token: <? echo $user_info["access_token"]; ?><br>
		joined: <? echo $user_info["created"]; ?><br>
		current region: <? echo $_SESSION["region"]; ?><br>
		<b> TEAM </b><br>
		<br>
		<? $result = $mysqli->query("SELECT user_players.*, players.*, regions.id, regions.name AS region_name  FROM user_players LEFT JOIN players ON user_players.player_id = players.id INNER JOIN regions ON players.region = regions.id WHERE user_players.user_id = ".(int)$_SESSION["user_id"]);
		    while($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($row["first_name"] == ""){
					echo "position: ".$row["position"]." player_name: not set, will not be displayed  region: ".$row["region_name"]."<br>"; 
				}else{
					echo "position: ".$row["position"]." player_name: ".$row["first_name"]." region: ".$row["region_name"]."<br>";
				}		
		    }		   
		 ?>	
		<? endif; ?>
		</div>
		</div>
<?php include "includes/layout/three_column.php" ?>
<?php include "includes/layout/footer.php" ?>
<script>
$("a[accesskey='1']").addClass("active_page");
</script>
	</body>
</html> 	