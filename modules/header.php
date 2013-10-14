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
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
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
<div id="clock" style=" font-size: 10pt; color: #ffffff; position: absolute; top: 8px; left: 2px; margin: 0 0 0 0;">
    <span class="jclock">11:11:11</span>
</div>
<?php } // end if($enableclock) ?>  

<div id="logo-stats-bg">
	<div id="logo-stats-centerer">
		<div id="logo-stats-left">
			<img src="images/DayZAdmin.png" width="250px" height="80px" alt=""></a>
		</div>
		<div id="top-search">
		<?php
			include ('searchbar.php');
		?>
		</div>
	</div>
</div>
 
<?php
include ('navbar.php');
?>
 
<body class="stats-bg">
<div class="container custom-container">
<div class="content" id="content">
<?php

    if(isset($_GET["view"]) && $_GET["view"] == "table" && isset($_GET["show"]) && $_GET["show"] == 0 && isset($refreshPlayersOnline) && $refreshPlayersOnline >= 15) {
        printf("Refreshing every %d seconds<br>\n", $refreshPlayersOnline);
    }
}else{
	header('Location: admin.php');
}
?>
