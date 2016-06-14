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
		<? else: 	
 
		if(ctype_digit($_GET["id"])){
		   $player_id = $mysqli->real_escape_string($_GET["id"]);		  
		   $result = $mysqli->query("SELECT players.*, roles.long AS role_name, teams.name AS team_name, teams.name_short AS team_name_short FROM players INNER JOIN roles ON players.role = roles.id INNER JOIN teams ON players.team = teams.id WHERE players.id = $player_id");
		   if($result->num_rows == 1){
			  $player_info = $result->fetch_array(MYSQLI_ASSOC);?>
			  
			<h3> <? echo $player_info["nickname"]; ?> </h3>
			<img src="<? echo $player_info["image"];?>" style="width:100px;height:100px;"></img>	<br>
			<span>First Name: <? echo $player_info["first_name"];?> </span><br>
			<span>Last Name :<? echo $player_info["last_name"];?></span><br>	
			<span>Position: <? echo $player_info["role_name"];?></span><br>
			<span>Team: <? echo $player_info["team_name"]." [".$player_info["team_name_short"]."]";?></span><br>			
			
			<?}else{?>
			<h3> No player found with that ID, sorry :(</h3>  

			  
		   <?}		  		
		}else{
			echo "invalid url parameter";
		}	 
	?>	
		<? endif; ?>
		</div>
		</div>
<?php include "includes/layout/three_column.php" ?>
<?php include "includes/layout/footer.php" ?>
	</body>
</html>