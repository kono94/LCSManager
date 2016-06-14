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

		<? endif; ?>		
<?php include "includes/layout/three_column.php" ?>
<?php include "includes/layout/footer.php" ?>
<script>
$("a[accesskey='3']").addClass("active_page");
</script>
	</body>
</html> 	