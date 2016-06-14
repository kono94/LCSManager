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

		
		
		<h3> EU Team </h3>
		<div id="eu_contentplay" style="width:800px; height:500px; background:url(images/content/srift.jpg) no-repeat; margin-bottom:50px;">	
			<div id="box1" class="sp_top"></div>		
			<div id="box2" class="sp_mid"></div>		
			<div id="box3" class="sp_jungle"></div>		
			<div id="box4" class="sp_support"></div>		
			<div id="box5" class="sp_adc"></div>	
			
			<div id="box6" class="rebox1"></div>	
			<div id="box7" class="rebox2"></div>	
			<div id="box8" class="rebox3"></div>	
			<div id="box9" class="rebox4"></div>	
			<div id="box10" class="rebox5"></div>	
			<div id="box11" class="rebox6"></div>	
			<div id="box12" class="rebox7"></div>
			<div id="box13" class="rebox8"></div>	
		</div>
		<div id="eu_infobox"></div>	
		
		<h3> NA Team </h3>
		<div id="na_contentplay" style="width:800px; height:500px; background:url(images/content/srift.jpg) no-repeat;">	
		<div id="box1" class="sp_top"></div>		
			<div id="box2" class="sp_mid"></div>		
			<div id="box3" class="sp_jungle"></div>		
			<div id="box4" class="sp_support"></div>		
			<div id="box5" class="sp_adc"></div>	
			
			<div id="box6" class="rebox1"></div>	
			<div id="box7" class="rebox2"></div>	
			<div id="box8" class="rebox3"></div>	
			<div id="box9" class="rebox4"></div>	
			<div id="box10" class="rebox5"></div>	
			<div id="box11" class="rebox6"></div>	
			<div id="box12" class="rebox7"></div>
			<div id="box13" class="rebox8"></div>	
		</div>
		<div id="na_infobox"></div>	
<script>
 
  var eu_players = new Array();
  var na_players = new Array();
   <?php 
		if(ctype_digit($_GET["id"])){
		   $user_id = $mysqli->real_escape_string($_GET["id"]);		  
		   $keyindex = 0;
		   $result = $mysqli->query("SELECT user_players.*, players.*, players.id AS player_id, regions.id, regions.name AS region_name, roles.*  FROM user_players INNER JOIN players ON user_players.player_id = players.id INNER JOIN regions ON players.region = regions.id  INNER JOIN roles ON players.role = roles.id WHERE user_players.region = 0 AND user_players.user_id = $user_id");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($row["first_name"] != ""){				
					echo "eu_players[$keyindex] = new Object();";
					echo "eu_players[$keyindex].pos = ".$row["position"].";";
					echo "eu_players[$keyindex].id = ".$row["player_id"].";";
					echo "eu_players[$keyindex].nickname = '".$row["nickname"]."';";
					echo "eu_players[$keyindex].realName = '".$row["first_name"]." ".$row["last_name"]."';";
					echo "eu_players[$keyindex].imageURL = '".$row["image"]."';";
					echo "eu_players[$keyindex].role = ".$row["role"].";";
					echo "eu_players[$keyindex].roleName = '".$row["long"]."';";
					echo "eu_players[$keyindex].roleShort  = '".$row["short"]."';";
					$keyindex++;
				}		
			}	
		    $keyindex = 0;
		    $result = $mysqli->query("SELECT user_players.*, players.*, players.id AS player_id, regions.id, regions.name AS region_name, roles.*  FROM user_players INNER JOIN players ON user_players.player_id = players.id INNER JOIN regions ON players.region = regions.id  INNER JOIN roles ON players.role = roles.id WHERE user_players.region = 1 AND user_players.user_id = $user_id");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($row["first_name"] != ""){				
					echo "na_players[$keyindex] = new Object();";
					echo "na_players[$keyindex].pos = ".$row["position"].";";
					echo "na_players[$keyindex].id = ".$row["player_id"].";";
					echo "na_players[$keyindex].nickname = '".$row["nickname"]."';";
					echo "na_players[$keyindex].realName = '".$row["first_name"]." ".$row["last_name"]."';";
					echo "na_players[$keyindex].imageURL = '".$row["image"]."';";
					echo "na_players[$keyindex].role = ".$row["role"].";";
					echo "na_players[$keyindex].roleName = '".$row["long"]."';";
					echo "na_players[$keyindex].roleShort  = '".$row["short"]."';";
					$keyindex++;
				}		
			}			
		}else{
			echo "$('#page-content').html('invalid url parameter')";
		}	 
	?>	
 
	for (var i = 0; i < eu_players.length; i++) {    
		$('<div><a href="player.php?id='+eu_players[i].id+'" target=_blank><img src="' + eu_players[i].imageURL + '"></a></div>').addClass( "player" ).attr({ id: eu_players[i].id, pos: eu_players[i].roleShort}).appendTo( '#eu_contentplay #box'+ (eu_players[i].pos));
	}

	
	
for(var j=1; j<14;j++){
   $('#box'+j).mouseover(function(e){
		  var playersPos = 0;
		  if($(this).children().length !=0){
			  for (var i = 0; i < eu_players.length; i++) {    
				if(eu_players[i].id == $(this).children().attr('id')){
				 playersPos = i; 
				}
			  }				 
			 var hovertext = "Summoner: <b>" + eu_players[playersPos].nickname + "</b><br> Name: <b>" + eu_players[playersPos].realName + "</b><br> Position: <b>" + eu_players[playersPos].roleName + "</b><br>";
			 $('#infobox').html(hovertext);	
			 $('#infobox').fadeIn(150);
			 $('#infobox').show();		 
			 $('#infobox').position( { of: $(this), my: 'left top', at: 'left+65 top-100' } );
		 }	 
	 })		 
	 
	$('#box'+j).mouseout(function(){
	$('#infobox').hide();	
	})
	$('#box'+j).mousedown(function(){
	$('#infobox').hide();	
	})
	$('#infobox').mouseover(function(){
	$('#infobox').hide();		
	});	
} 



	for (var i = 0; i < na_players.length; i++) {    
		$('<div><a href="player.php?id='+na_players[i].id+'" target=_blank><img src="' + na_players[i].imageURL + '"></a></div>').addClass( "player" ).attr({ id: na_players[i].id, pos: na_players[i].roleShort}).appendTo( '#na_contentplay #box'+ (na_players[i].pos));
	}

	
		
	for(var j=1; j<14;j++){
	   $('#box'+j).mouseover(function(e){
			  var playersPos = 0;
			  if($(this).children().length !=0){
				  for (var i = 0; i < na_players.length; i++) {    
					if(na_players[i].id == $(this).children().attr('id')){
					 playersPos = i; 
					}
				  }				 
				 var hovertext = "Summoner: <b>" + na_players[playersPos].nickname + "</b><br> Name: <b>" + na_players[playersPos].realName + "</b><br> Position: <b>" + na_players[playersPos].roleName + "</b><br>";
				 $('#infobox').html(hovertext);	
				 $('#infobox').fadeIn(150);
				 $('#infobox').show();		 
				 $('#infobox').position( { of: $(this), my: 'left top', at: 'left+65 top-100' } );
			 }	 
		 });	
	} 
</script>		
		<? endif; ?>
		</div>
		</div>
<?php include "includes/layout/three_column.php" ?>
<?php include "includes/layout/footer.php" ?>
	</body>
</html>