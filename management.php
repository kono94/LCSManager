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

		
		
		
		<div id="contentplay" style="width:800px; height:500px; background:url(images/content/srift.jpg) no-repeat;">
	
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
		<div class="sellboxborder">
        <div id="sellbox" class="sellbox1"></div>
		<input type="Submit" value="Release" class="btn btn-primary btn-lg" style="display:inline-block;position:relative;top:20px; left:100px;" onclick="sell();">
      	</div>
		<input style="   position: relative;   top: 450px;   left: 580px;" type="Submit" value="Save" class="btn btn-success btn-lg" onclick="save();">
		</div>
		<div id="infobox"></div>
				
		money : <?php echo $user_info["money"]; ?>
		
		
<script>
// topbox
 $("#box1").droppable({
  accept: function(e){
           return e.attr('pos')=="top";
		   },
    activate: function(event, ui){ 
             if($(this).children().length==0){  
          $(this).addClass('hovered2');}
		else{$(this).addClass('hovered');}   
  },  
  deactivate: function(event, ui){
       $(this).removeClass('hovered hovered2');  
  },  
  hoverClass: 'hovered3',   
  drop: function (event,ui){
		$('#contentplay').children().removeClass('hovered hovered2');			   
		if($(this).children().length==0){			   
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );		      
	    }else{			
			$(this).children().appendTo($(ui.draggable).parent());
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );
		}
	}			   
 } ); 
 
 // midbox
  $("#box2").droppable({
  accept: function(e){
           return e.attr('pos')=="mid";
		  },
   activate: function(event, ui){ 
             if($(this).children().length==0){  
			    $(this).addClass('hovered');
				$(this).addClass('hovered2');
			 }else{
				$(this).addClass('hovered');
			 }   
  },  
  deactivate: function(event, ui){
       $(this).removeClass('hovered hovered2');  
  },  
  hoverClass: 'hovered3',   
  drop: function (event,ui){ 
		$('#contentplay').children().removeClass('hovered hovered2 hovered3');
		if($(this).children().length==0){			   
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );		      
	    }else{			
			$(this).children().appendTo($(ui.draggable).parent());
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );
		}
	}			   
 } );
 
 // junglebox
  $("#box3").droppable({
	  accept: function(e){
			   return e.attr('pos')=="jungle";
			  },
		activate: function(event, ui){ 
				 if($(this).children().length==0){  
			  $(this).addClass('hovered2');}
			else{$(this).addClass('hovered');}   
	  },  
	  deactivate: function(event, ui){
		   $(this).removeClass('hovered hovered2');  
	  },  
	   hoverClass: 'hovered3',    
	   drop: function (event,ui){ 
			$('#contentplay').children().removeClass('hovered hovered2');
			if($(this).children().length==0){			   
				$(this).append($(ui.draggable));	   
				ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );		      
		    }else{			
				$(this).children().appendTo($(ui.draggable).parent());
				$(this).append($(ui.draggable));	   
				ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );
		    }
		}				   
 } );
 
 //supportbox
  $("#box4").droppable({
  accept: function(e){
           return e.attr('pos')=="supp";
		  },
    activate: function(event, ui){ 
             if($(this).children().length==0){  
          $(this).addClass('hovered2');}
		else{$(this).addClass('hovered');}   
  },  
  deactivate: function(event, ui){
       $(this).removeClass('hovered hovered2');  
  },  
   hoverClass: 'hovered3',   
   drop: function (event,ui){ 
		$('#contentplay').children().removeClass('hovered hovered2');
		if($(this).children().length==0){			   
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );		      
	   }
	   else{			
			$(this).children().appendTo($(ui.draggable).parent());
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );
		}
	}			   
 } );
 
 //adcbox
  $("#box5").droppable({
  accept: function(e){
           return e.attr('pos')=="adc";
		  },
    activate: function(event, ui){ 
             if($(this).children().length==0){  
          $(this).addClass('hovered2');}
		else{$(this).addClass('hovered');}   
  },
  
  deactivate: function(event, ui){
       $(this).removeClass('hovered hovered2');  
  },
  hoverClass: 'hovered3',   
  drop: function (event,ui){ 
		$('#contentplay').children().removeClass('hovered hovered2');
		if($(this).children().length==0){			   
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );		      
	    }else{			
			$(this).children().appendTo($(ui.draggable).parent());
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );
		}
	}			   
 } );

 //sellbox
 $("#sellbox").droppable({
  accept: function(e){
           return e.hasClass('player');
		  },
    activate: function(event, ui){ 
             if($(this).children().length==0){  
          $(this).addClass('hovered2');}
		else{$(this).addClass('hovered');}   
  },  
  deactivate: function(event, ui){
       $(this).removeClass('hovered hovered2');  
  },  
  hoverClass: 'hovered3',   
  drop: function (event,ui){ 
		$('#contentplay').children().removeClass('hovered hovered2');
		if($(this).children().length==0){			   
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );		      
	    } else{			
			$(this).children().appendTo($(ui.draggable).parent());
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );
		}
	}			   
 } );
 
 var box=6; 
 for(var i=0; i<9;i++){
  $("#box"+box).droppable({
  accept: function(ui){
    var kann = ui.parent().attr('id');
    if( kann == "box6" || kann == "box7" ||  kann == "box8" || kann == "box9" || kann == "box10" || kann == "box11" || kann == "box12" ||  kann == "box13" ){return true;}
	else{
          if($(this).children().length==0){
                return ui.hasClass("player");		        
		    }       		  
		  else{			    
			  return $(this).children().attr("pos") == ui.attr("pos");					  
			}			  
		}  
	},
  activate: function(event, ui){ 
             if($(this).children().length==0){  
          $(this).addClass('hovered2');}
		else{$(this).addClass('hovered');}   
  },  
  deactivate: function(event, ui){
       $(this).removeClass('hovered hovered2');  
  },  
  hoverClass: 'hovered3',
  drop: function (event,ui){ 
		$('#contentplay').children().removeClass('hovered hovered2');
		if($(this).children().length==0){			   
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );		      
	    }else{			
			$(this).children().appendTo($(ui.draggable).parent());
			$(this).append($(ui.draggable));	   
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left+3 top+3' } );
		}
	}	
 } );
 box++;
 }
 
 
  var players = new Array();
  <?php 	    
       $username=$user_info["username"];       
	   $number_of_players = 0;
	   $keyindex = 0;
	   $result = $mysqli->query("SELECT user_players.*, players.*, players.id AS player_id, regions.id, regions.name AS region_name, roles.*  FROM user_players INNER JOIN players ON user_players.player_id = players.id INNER JOIN regions ON players.region = regions.id  INNER JOIN roles ON players.role = roles.id WHERE user_players.region = ".(int)$_SESSION["region"]." AND user_players.user_id = ".(int)$_SESSION["user_id"]);
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			if($row["first_name"] != ""){				
				echo "players[$keyindex] = new Object();";
				echo "players[$keyindex].pos = ".$row["position"].";";
				echo "players[$keyindex].id = ".$row["player_id"].";";
				echo "players[$keyindex].nickname = '".$row["nickname"]."';";
				echo "players[$keyindex].realName = '".$row["first_name"]." ".$row["last_name"]."';";
				echo "players[$keyindex].imageURL = '".$row["image"]."';";
				echo "players[$keyindex].role = ".$row["role"].";";
				echo "players[$keyindex].roleName = '".$row["long"]."';";
				echo "players[$keyindex].roleShort  = '".$row["short"]."';";
				$keyindex++;
			}		
		}
		$number_of_players = $keyindex;
		echo "var number_of_players = ".$number_of_players.";";		
	?>	
 
	for (var i = 0; i < players.length; i++) {    
		$('<div><a href="player.php?id='+players[i].id+'" target=_blank><img src="' + players[i].imageURL + '"></a></div>').addClass( "player" ).attr({ id: players[i].id, pos: players[i].roleShort}).appendTo( '#box'+ (players[i].pos)) .draggable( {
					cursor: "move",
					revert: 'invalid',
					zIndex: 2500,
				});	 
	}

	
	
for(var j=1; j<14;j++){
   $('#box'+j).mouseover(function(e){
		  var playersPos = 0;
		  if($(this).children().length !=0){
			  for (var i = 0; i < players.length; i++) {    
				if(players[i].id == $(this).children().attr('id')){
				 playersPos = i; 
				}
			  }				 
			 var hovertext = "Summoner: <b>" + players[playersPos].nickname + "</b><br> Name: <b>" + players[playersPos].realName + "</b><br> Position: <b>" + players[playersPos].roleName + "</b><br>";
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
	})		
} 
	
var error_count=0;
 for(var l=1;l<6;l++){	   
	    if($('#box'+l).children().length == 0){
		  error_count++; 
	  }	
	}
 if(error_count == 0){
 $('#content .title').html("<h2>Your Team ['']</h2> <br><div style='color:green;'>Dein Team ist korrekt aufgestellt und nimmt an der Wertung teil.</div>");
 }
 else{
 $('#content .title').html("<h2>Your Team ['']</h2><br><div style='color:red;'>Dein Team ist nicht korrekt aufgestellt und nimmt nicht an der Wertung teil.</div>");
 }
	
		
	$( "#Konto" ).val("<?php echo $user_info["money"]; ?>");
</script>
<script>
function sell(){
	var valid = true;  	 
	if($('.player').length != number_of_players){valid = false;}

	if($('#sellbox').children().length == 0 ){
		new Messi('Sellbox is empty !', {title: 'Title', titleClass: 'anim error', buttons: [{id: 0, label: 'Close', val: 'X'}]});  
		return;
	}

	if($('#sellbox').children().length > 1 ){
		new Messi('Sellbox has more than one player in it !', {title: 'Title', titleClass: 'anim error', buttons: [{id: 0, label: 'Close', val: 'X'}]});  
		return;
	}	 
	for(var m=1; m< 14;m++){
		if($('#box'+m).length != 1){valid = false;}
	}
	if($('#sellbox').length != 1){valid = false;}
	
	var count = 0;
	var id = document.getElementById('sellbox').firstChild.getAttribute('id');
	for (var i = 0; i < players.length; i++) {  
		if(players[i].id == id){
			count++;
		}
	}
	if(count == 1 && valid==true){
		$.post("/scripts/sell_player.php", {player_id: id},
			function(data){	
			var response = jQuery.parseJSON(data);		
				if(!response.error){
				   $('#sellbox').empty();	
				   new Messi('<b>' + response.success_message + '<b>!' , {title: 'Saved', titleClass: 'success', modal: true, buttons: [{id: 0, label: 'Close', val: 'X'}],
						  callback: function(val){location.reload();}
				   });			
				}else{						 
				   new Messi('<b>' + response.error_message + '<b>!' , {title: 'Saved', titleClass: 'error', modal: true, buttons: [{id: 0, label: 'Close', val: 'X'}],
						  callback: function(val){location.reload();}
				   });	
				}							 
			 }
		);
	}else{
		new Messi('Something went from or your html code got manipulated', {title: 'Title', titleClass: 'anim error',  modal: true, buttons: [{id: 0, label: 'Close', val: 'X'}],
		  callback: function(val){location.reload();}
		});  	
	}
}
</script>


<script>
function save(){
	var valid = true;	
	if($('.player').length != number_of_players){valid = false;}
	if($('#sellbox').children().length > 0 ){
		new Messi('Sellbox has to be empty in order to save your Team!', {title: 'Title', titleClass: 'anim error', buttons: [{id: 0, label: 'Close', val: 'X'}]}); 
		window.setTimeout(function(){location.reload();},4000);
		return;
	}
	for(var m=1; m< 14;m++){
		if($('#box'+m).length != 1){valid = false; break;}
	}	
	if(valid){
		var box= new Array();
		var index = 0;
		for(var i=1;i<14;i++){
			if(document.getElementById('box'+i).hasChildNodes()){				
				box[index] = new Object();
				box[index].id =  document.getElementById('box'+i).firstChild.getAttribute('id');
				box[index].pos = i;
				index++;
			}
		}  
		// box[0] = new Object();
		// box[0].id = 3;
		// box[0].pos = 6;
		// box[1] = new Object();
		// box[1].id = 2;		
		// box[1].pos = 6;
		
		$.post("/scripts/save_team.php", {players: box},
		   function(data){			  
			    var response = jQuery.parseJSON(data);	
				if(!response.error){
				   new Messi('<b>' + response.success_message + '<b>', {title: 'Saved', titleClass: 'success', modal: true,buttons: [{id: 0, label: 'Close', val: 'X'}],
				   callback: function(val){location.reload();}
				   });			  
				}else{
				   new Messi('<b>' + response.error_message + '<b>' , {title: 'Saved', titleClass: 'error', modal: true, buttons: [{id: 0, label: 'Close', val: 'X'}],
							  callback: function(val){location.reload();}
					});	
				}   
			}
	    );
	}else{ 
		new Messi('Something went from or your html code got manipulated', {title: 'Title', titleClass: 'anim error',  modal: true, buttons: [{id: 0, label: 'Close', val: 'X'}],
			  callback: function(val){location.reload();}
		});    
	} 
}
</script>		
		<? endif; ?>
		</div>
		</div>
<?php include "includes/layout/three_column.php" ?>
<?php include "includes/layout/footer.php" ?>

		
<script>
$("a[accesskey='2']").addClass("active_page");
</script>
	</body>
</html>