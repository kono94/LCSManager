<div id="topbar" >
	<div id="region_selector" style="float:right;">
	region:
<?php if($_SESSION["region"] != 0): ?> <input type="button" value="switch to EU" class="button button-log" onclick="set_region(0);"> <? else: ?>
	<b>EU</b>		
<? endif; ?>
	 |  
<?php if($_SESSION["region"] != 1): ?> <input type="button" value="switch to NA" class="button button-log"onclick="set_region(1);"> <? else:?>
	 <b>NA</b>
<? endif; ?>
	 <script>
	 function set_region(region_id){
		 if(region_id === 1 || region_id === 0){
				 $.post("scripts/set_region.php", {region_id: region_id},
				function(data){ 			
					var response = jQuery.parseJSON(data);					
					if(!response.error){
						new Messi('<b>' +response.success_message + '</b>', {title: 'changed region', titleClass: 'success', modal: true,buttons: [{id: 0, label: 'Close', val: 'X'}],
						callback: function(val){location.reload();}});
					}else{
						new Messi(response.error_message, {title: 'Error', titleClass: 'anim error', modal: true,buttons: [{id: 0, label: 'Close', val: 'X'}],
						callback: function(val){location.reload();}});	
					}
				}); 
		 }else{
			 alert("html, javascript manipulation");
		 }
	 }
	 </script>
	</div>
</div>
