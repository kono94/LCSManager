<?php require "includes/inc_connect.php"; ?>
<?php include "includes/layout/head.php";?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css"/> 
<link href="js/datatable/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>
</head>
	<body>
<?php include "includes/layout/header.php"; ?>
    <?php include "includes/layout/navigation.php"; ?>
		<div id="pageWrapper">		
		<div id="page-content">
		<?php include "scripts/twitchtv.php";	
		    $twitchtv = new TwitchTV; ?>
		<?php if (!isset($_SESSION["user_id"])): ?>
		<a id="signup" href="<?php echo $twitchtv->authenticate() ?>">LOGIN VIA TWITCH.TV</a>
		<br> CURRENTLY NOT LOGGED IN
		<? else:  $user_info = get_session_user($mysqli); ?>		
	
	
	
			<?php  
	$check_for_league = $mysqli->query("SELECT user_leagues.league_id, user_leagues.joined, leagues.* FROM user_leagues INNER JOIN leagues ON user_leagues.league_id = leagues.id WHERE user_id = ".(int)$user_info["id"]);
	// has no league
	if($check_for_league->num_rows != 1): ?>
		 <input style="margin-right:50px;" type="Submit" value="Create League" class="btn btn-default" onclick="create();"> 
		 <input type="Submit" value="Join League" class="btn btn-default" onclick="join();"> <br>	

		 <script>
function create(){
 new Messi('<div style ="width:150px;">Name of the League</div><input type="text" size="24" maxlength="50" class="form-control" id="league_name"><br>'+
  '<div style ="width:70px;">Password</div><input type="password" size="24" maxlength="50" class="form-control" id="league_password_1"><br>'+
  '<div style ="width:70px;">Repeat</div><input type="password" size="24" maxlength="50" class="form-control" id="league_password_2"><br>'+
  '<input type="button" value="Create" class="btn btn-default" onclick="postinfo();">', 
   {title: 'Create a League', titleClass: 'info', modal: true});

  
};

  function postinfo(){  
     var league_name = $('#league_name').val();
     var league_password_1 = $('#league_password_1').val();
     var league_password_2 = $('#league_password_2').val();
 $.post("/scripts/league_create.php", {league_name: league_name, league_password_1: league_password_1, league_password_2: league_password_2},
       function(data){
        var response = jQuery.parseJSON(data);		
		if(response.error){    
           new Messi(response.error_message, {title: 'Error', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],callback: function(val){
		   $('#league_name').val('');
		   $('#league_password_1').val('');
		   $('#league_password_2').val('');}});		  
		   }else{
		   new Messi(response.success_message, {title: 'Succes', titleClass: 'anim success', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],
			callback: function(val){location.reload();}});
		   }
		   
        });
}
</script>

<script>
function join(){
 new Messi( '<div style ="width:150px;">Name of the League</div><input type="number" size="24" maxlength="50" class="form-control" id="league_join_id"><br>'+
  '<div style ="width:70px;">Password</div><input type="password" size="24" maxlength="50" class="form-control" id="league_join_password"><br>'+  
  '<input type="button" value="Join" class="btn btn-default" onclick="postjoin();">', 
   {title: 'Join a League', titleClass: 'info', modal: true});   
}

 function postjoin(){  
     var league_join_id = $('#league_join_id').val();
     var league_join_password = $('#league_join_password').val();     
 $.post("/scripts/league_join.php", {league_join_id: league_join_id, league_join_password: league_join_password},
       function(data){
        var response = jQuery.parseJSON(data);		
		if(response.error){      	   
           new Messi(response.error_message, {title: 'Error', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],callback: function(val){
		    $('#league_join_id').val('');
		   $('#league_join_password').val('');
		       }});		  
		   }else{
		   new Messi(response.success_message, {title: 'Succes', titleClass: 'anim success', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],
		   callback: function(val){location.reload();}});
		   }		   
        });
}
</script>
	<?  else: $league_info = $check_for_league->fetch_array(MYSQLI_ASSOC); 
		echo "league id (important to join): ".$league_info["id"]."<br>";
		echo "league name: ".$league_info["name"]."<br>";
		echo "admin:id: ".$league_info["admin_user_id"]."<br>";
	?>	
	<div id="table_wrap" style="width:500px;margin-top:80px;margin-bottom:80px;">
	<table id="league_ranking" style ="width:440px;padding-bottom:50px;">
			<thead>
				<tr><th style="width:82px">Rank</th><th>Name</th><th>Points (EU)</th><th>Points (NA)</th></tr>
			</thead>
			<tbody>  
	<?php 		
		$get_all_members = $mysqli->query("SELECT users.display_name, users.eu_points, users.na_points, users.id  FROM user_leagues INNER JOIN users ON user_leagues.user_id = users.id WHERE league_id = ".$league_info["league_id"]." ORDER BY users.eu_points DESC LIMIT 20");
		$loop = 1;
		while($row = $get_all_members->fetch_array(MYSQLI_ASSOC)){						
			if($row["id"] != ""){
			   echo "<tr><td>".$loop."</td><td><a href='team.php?id=".$row["id"]."' target=_blank>".($row["id"] == $league_info["admin_user_id"] ? $row["display_name"].' (Admin)': $row["display_name"])."</a></td><td style='padding-left:45px;'>".$row["eu_points"]."</td><td style='padding-left:45px;'>".$row["na_points"]."</td></tr>";
			}
			$loop++;
		 }		
	 ?>			
			</tbody>
		</table>
		</div>
<script>
$('#league_ranking').dataTable( {
	"searching": false,
	"paging":   false,
	"info": false
	
} );
</script>
		<div class="form-group">
		<label>League note:</label>
		 <textarea id="league_note" rows="6" cols="50" readonly onfocus="this.blur()" class="form-control" style="resize:vertical;width:400px;"><? echo $league_info["note"]; ?>	</textarea>
		</div>
		<br>
		<br>
		<input type="Submit" value="Edit note" class="btn btn-default" onclick="edit();">
		<br><br><br><br><br>
		<? if($league_info["admin_user_id"] == (int)$user_info["id"]){ ?>
		<b>- Admin options - </b><br>
		<input type="Submit" value="Change Admin" class="btn btn-default" onclick="change_admin();"> 
		<input type="Submit" value="Kick Player" class="btn btn-default" onclick="kick();"> <br>
		<input type="Submit" value="Delete League" class="btn btn-default" onclick="delete_league();"> 
<script>
function change_admin(){
	new Messi('<div style="margin-bottom:20px;"><b>Chose the future admin</b></div><select class="form-control" name="teamA" id="new_admin_selection" form="dataForm">'+
	 ' <option value="" disabled selected style="display:none;">Choose</option>'+
	 <?  $sql = $mysqli->query("SELECT * FROM user_leagues INNER JOIN users ON user_leagues.user_id = users.id WHERE league_id = ".$league_info["id"]);
	   while($row = $sql->fetch_array(MYSQLI_ASSOC)){
		   if($row["user_id"] != $league_info["admin_user_id"]){
			  echo "'<option value=\"".$row["user_id"]."\">".$row["display_name"]."</option>'+";
		   }
	   } ?>
	 ' </select><br>'+ 
	  '<input type="button" value="Submit" class="btn btn-default" onclick="post_new_admin();" style="width:120px;">', 
	   {title: 'Change admin', titleClass: 'anim info', modal: true});
	}
	
  function post_new_admin(){  
     var new_admin_id = $('#new_admin_selection').val();	
	 if(new_admin_id != "" && new_admin_id > 0){
		$.post("/scripts/league_change_admin.php", {new_admin_id: new_admin_id},
       function(data){
         var response = jQuery.parseJSON(data);		
		if(response.error){      
           new Messi(response.error_message, {title: 'Error', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],callback: function(val){
		      location.reload();
		       }});		  
		   }else{
		   new Messi(response.success_message, {title: 'Succes', titleClass: 'anim success', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],
		   callback: function(val){location.reload();}});
		   }
		   
        });
	 }else{		 
	 }
}
</script>

<script>
function kick(){
	new Messi('<div style="margin-bottom:20px;"><b>Which player should be kicked?</b></div><select name="teamA" id="kick_user_selection"  class="form-control" form="dataForm">'+
 ' <option value="0" disabled selected style="display:none;">Choose</option>'+
	 <?  $sql = $mysqli->query("SELECT * FROM user_leagues INNER JOIN users ON user_leagues.user_id = users.id WHERE league_id = ".$league_info["id"]);
	   while($row = $sql->fetch_array(MYSQLI_ASSOC)){
		   if($row["user_id"] != $league_info["admin_user_id"]){
			  echo "'<option value=\"".$row["user_id"]."\">".$row["display_name"]."</option>'+";
		   }
	   } ?>
	 ' </select><br>'+ 
	  '<input type="button" value="Submit" class="btn btn-default" onclick="post_kick();" style="width:120px;">', 
	   {title: 'Kick player from league', titleClass: 'anim info', modal: true});
	}
	
  function post_kick(){  
     var kick_user_id = $('#kick_user_selection').val();	
	 if(kick_user_id != "" && kick_user_id > 0){
		$.post("/scripts/league_kick_user.php", {kick_user_id: kick_user_id},
       function(data){
         var response = jQuery.parseJSON(data);		
		if(response.error){      
           new Messi(response.error_message, {title: 'Error', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],callback: function(val){
		      location.reload();
		       }});		  
		   }else{
		   new Messi(response.success_message, {title: 'Succes', titleClass: 'anim success', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],
		   callback: function(val){location.reload();}});
		   }
		   
        });
	 }else{		 
	 }
}
</script>		
		
		
		
		<? } else{?>
		<input type="Submit" value="Leave league" class="btn btn-default" onclick="leave();"> 
		<? } ?>  
		<br> 

		<script>
function leave(){
     new Messi('<div style="margin-left:90px;margin-top:40px;"><b>Do you really want to leave your league?</b></div><br>'+
       '<input type="button" value="Yes" class=btn btn-warning" onclick="yes_leave();" style="width:120px;margin-right:150px;margin-left:50px;background:#FF0000;">'+
	   '<input type="button" value="No" class="btn btn-default" onclick="no();" style="width:120px;">',
   {title: 'Leave', titleClass: 'anim info', modal: true});
   
   }
   function yes_leave(){       
		$.post("/scripts/league_leave.php", {},
		function(data){	    
		var response = jQuery.parseJSON(data);			
	    if(response.error){		   
           new Messi(response.error_message, {title: 'Error', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],callback: function(val){
		              $('.messi').remove();
	                 $('.messi-modal').remove();
		       }});		  
		   }else{
		   new Messi(response.success_message, {title: 'Succes', titleClass: 'anim success', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],
			callback: function(val){location.reload();}});
		   }		   
        });	      
    }   
	function no(){
		$('.messi').remove();
		$('.messi-modal').remove();   
	}
</script>
		
<script>
function edit(){

new Messi('<div class="form-group"><label>New Note:</label></div><textarea id="note_text" rows="5" cols="50" class="form-control"></textarea><br>'+
  '<input type="button" value="Submit" class="btn btn-default" onclick="posttext();" style="width:120px;">', 
   {title: 'New league note', titleClass: 'anim info', modal: true});
}


    function posttext(){  
     var new_text = $('#note_text').val();	 
	 $.post("/scripts/league_edit_note.php", {new_text: new_text},
       function(data){
        var response = jQuery.parseJSON(data);			
	    if(response.error){		
           new Messi(response.error_message, {title: 'Error', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],callback: function(val){
		    $('#note_text').val('');
		       }});		  
		   }else{
		   new Messi(response.success_message, {title: 'Succes', titleClass: 'anim success', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],
		   callback: function(val){location.reload();}});
		   }		   
        });
	}
</script>	
<script>
function delete_league(){
     new Messi('<div style="margin-left:90px;margin-top:40px;"><b>Do you really want to delete the league?</b></div><br>'+
       '<input type="button" value="Yes" class="btn btn-warning" onclick="yes_delete();" style="width:120px;margin-right:150px;margin-left:50px;background:#FF0000;font-weight:900;">'+
	   '<input type="button" value="No" class="btn btn-default" onclick="no();" style="width:120px;">',
   {title: 'Leave', titleClass: 'anim info', modal: true});
   
   }
   function yes_delete(){       
		$.post("/scripts/league_delete.php", {},       
	   function(data){
        var response = jQuery.parseJSON(data);			
	    if(response.error){		
           new Messi(error, {title: 'Error', titleClass: 'anim error', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],callback: function(val){
		              $('.messi').remove();
	                 $('.messi-modal').remove();
		       }});		  
		   }else{
		   new Messi("Legaue has been deleted!", {title: 'Succes', titleClass: 'anim success', modal:true, buttons: [{id: 0, label: 'Close', val: 'X'}],
		   callback: function(val){location.reload();}});
		   }		   
        });	      
   }
</script>		
		
		
		<?php endif; ?>
		
		<? endif; ?>
		</div>
		</div>
<?php include "includes/layout/three_column.php" ?>
<?php include "includes/layout/footer.php" ?>
<script>
$("a[accesskey='4']").addClass("active_page");
</script>
	</body>
</html> 	