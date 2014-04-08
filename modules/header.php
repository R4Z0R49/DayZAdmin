<?php
if (isset($_SESSION['user_id'])) {
?>
<!DOCTYPE html>
<html lang="EN">
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF8">
<?php
if(isset($_GET["view"]) && $_GET["view"] == "table" && isset($_GET["show"]) && $_GET["show"] == 0 && isset($refreshPlayersOnline) && $refreshPlayersOnline >= 15) {
    printf("\t<META HTTP-EQUIV=\"refresh\" CONTENT=\"%d\">\n", $refreshPlayersOnline);
}
?>
	<link rel="stylesheet" href="css/watch.css" />	
	<link rel="stylesheet" href="css/flexcrollstyles.css" />	
	<script src="js/flexcroll.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.fullscreen.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

	<!-- New design (Bootstrap - font-awesome) -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	
	<?php if($enableclock) { ?>
	<script type="text/javascript" src="js/jquery.jclock.js"></script>
	<script type="text/javascript">
		$(function($) {
			var options = {
				utc: true,
				utcOffset: <?php echo $timeoffset; ?>,
				// seedTime must be a number representing time in milliseconds
				seedTime: <?php echo time() * 1000; ?>        }
			$('.jclock').jclock(options);
		});
	</script>
	<?php } // end if($enableclock) ?>
</head>
<body> 

<?php if($enableclock) { ?>
<div id="clock" style="text-align: center; font-size: 10pt; color: #fff; position: absolute; top: 23px; right: 24px; margin: 0 0 0 0; z-index: 1000; background-color: rgba(0,0,0,0.2); padding: 5px;">
    Server time:<br>
	<span class="jclock">11:11:11</span>
</div>
<?php } // end if($enableclock) ?>  
 
<?php
include ('navbar.php');
?>
 
<body>
<div class="container">
<div class="content">
<?php
}else{
	header('Location: admin.php');
}
?>
