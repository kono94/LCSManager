<?php require "includes/inc_connect.php"; ?>
<?php include "includes/layout/head.php";?>
 <link href="js/datatable/jquery.dataTables.css" rel="stylesheet" type="text/css" media="all" />
   <link href="js/datatable/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css" media="all" />
   	<script src="js/datatable/jquery.dataTables.js"></script> 
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
		<? else:  $user_info = get_session_user($mysqli); $meta = get_meta_data($mysqli);?>
<script>
$(document).ready(function() {

	var user_players = new Array();
	var players = new Array();
  <?php 
	   $user_playercount = 0;
	   $keyindex = 0;
	   $result = $mysqli->query("SELECT player_id FROM user_players WHERE player_id IS NOT NULL AND user_id = ".(int)$_SESSION["user_id"]);
       while($row = $result->fetch_array(MYSQLI_ASSOC)){
		  	echo "user_players[$keyindex] = new Object();";
			echo "user_players[$keyindex].id = ".$row["player_id"].";";
			$keyindex++;
	   }	
	  $user_playercount = $keyindex;
	   
	   $keyindex = 0;
	   $result = $mysqli->query("SELECT players.*, teams.name AS team_name, roles.short AS role_short, roles.long AS role_long, countries.name AS country_name, countries.name_short AS country_name_short FROM players INNER JOIN teams ON players.team = teams.id INNER JOIN countries ON players.id = countries.id INNER JOIN roles ON players.role = roles.id WHERE players.region = ".(int)$_SESSION["region"]);
       while($row = $result->fetch_array(MYSQLI_ASSOC)){
		  	echo "players[$keyindex] = new Object();";
			echo "players[$keyindex].id = ".$row["id"].";";		
			echo "players[$keyindex].nickname = '".$row["nickname"]."';";		
			echo "players[$keyindex].first_name = '".$row["first_name"]."';";		
			echo "players[$keyindex].last_name = '".$row["last_name"]."';";	
			echo "players[$keyindex].price = ".$row["price"].";";		
			echo "players[$keyindex].points = ".$row["total_points"].";";					
			echo "players[$keyindex].image = '".$row["image"]."';";
			echo "players[$keyindex].age = ".$row["age"].";";		
			echo "players[$keyindex].role_short = '".$row["role_short"]."';";		
			echo "players[$keyindex].team_name = '".$row["team_name"]."';";		
			echo "players[$keyindex].country = '".$row["country_name"]."';";		
			echo "players[$keyindex].country_short = '".$row["country_name_short"]."';";		
			echo "players[$keyindex].role_id = ".$row["role"].";";		
			echo "players[$keyindex].region = ".$row["region"].";";
	        $keyindex++;
	    }	   
		
		?>	   
   
	    for(var k=0; k< players.length;k++){	
			var taken = false;
			for(var i=0; i<user_players.length;i++){
				if(players[k].id == user_players[i].id){taken=true}  
			}				
			if(!taken){				
				$('<tr><td><a class="playerino" id="' + players[k].id + '" onclick="buy_popup(\''+players[k].id +'\',\''+ players[k].nickname +'\',\''+players[k].price+'\');">&nbsp;&nbsp;' + players[k].nickname + '</a><img src="'+ players[k].image +'" style="float:left;height:30px;width:30px"></td><td>'+ players[k].role_short +'</td><td>' + players[k].team_name + '</td><td>'+ players[k].points +'</td><td>'+players[k].price+'</td></tr>').appendTo('#transferTable');
			}	   
        }
 var table = $('#transferTable').DataTable(); 	
 $('#contentmarkt .title').html("<h2>Transfer Market</h2><br><div style='color:red;'>Remaining buys for this week: error</div>");
	
});
</script>


<div id="table_wrap" style="width:750px;">
	<table id="transferTable">
		<thead>
			<tr><th>Name</th><th>Pos</th><th>Team</th><th>Points</th><th>Price</th></tr>
		</thead>
		<tbody>  
		</tbody>
		<tfoot>
			<tr>
			<th></th>
			<th></th>
			</tr>
		</tfoot>
	</table>
	</div>
</div>

<script> 
function buy_popup(id,nickname,price){    
   new Messi('Do you REALLY want to sign <b>' + nickname + '</b> for a small loan of <b>'+ price+'</b> dollaronis? <br> Be aware that you can only add two players to your team each week!<br><br>'<? if($meta["eu_open"] == 0){?>+
   '<span style="color:red"> EU is locked right now! You cant buy players.</span>'<? } ?>   , 
   {title: 'Info', titleClass: 'info', modal: true, buttons: [<? if($meta["eu_open"] == 1){?>{id: 0, label: 'Yes', val: 'Y', class: 'btn-success'},<? } ?>
   {id: 1, label: 'Cancel', val: 'C', class: 'btn-danger'}]<? if($meta["eu_open"] == 1){?>, callback:
    function(val){
		if (val=='Y'){        
   <?php 		
		if($user_playercount < 9){
			?>
			 $.post("scripts/buy_player.php", {player_id: id},
			 function(data){ 			
				var response = jQuery.parseJSON(data);					
				if(!response.error){
					new Messi('<b>' +response.success_message + '</b>', {title: 'Title', titleClass: 'success', modal: true,buttons: [{id: 0, label: 'Close', val: 'X'}],
					callback: function(val){location.reload();}});
				}else{
					new Messi(response.error_message, {title: 'Title', titleClass: 'anim error', modal: true,buttons: [{id: 0, label: 'Close', val: 'X'}],
					callback: function(val){location.reload();}});	
				}
			 }); 
			<?php			
		}else{
			?> 
			new Messi('You already have 8 Players', {title: 'Title', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}]});
		    <?php
		}
	?> 	
	    }}
      <? } ?>
	}); 
};		
</script>
		<? endif; ?>		
<?php include "includes/layout/three_column.php" ?>
<?php include "includes/layout/footer.php" ?>
<script>
$("a[accesskey='3']").addClass("active_page");
</script>
	</body>
</html> 	