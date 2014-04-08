<head>
	<title><?php echo $sitename ?></title>
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
	<script src="js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		$(document).pngFix( );
		});
	</script>
	
	<!-- New design (Bootstrap - font-awesome) -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/font-awesome.css" rel="stylesheet">
</head>

<!DOCTYPE html>
<html lang="EN">
<body>
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="sidebar-nav">
					<li class="sidebar-brand" style="padding-top: 8px;"><a href="index.php"><img src="images/DayZAdmin.png" width="200px" height="50px"></img></a>
					</li>
					<li <?php echo ($page == 'home' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../index.php ' : ' index.php '); ?>"><i class="icon-home icon-color"></i> Stats</a>
					</li>
					<li <?php echo ($page == 'leaderboard' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../index.php?leaderboard ' : ' index.php?leaderboard '); ?>"><i class="icon-home icon-color"></i> Leaderboard</a> 
					</li>
					<?php if ($ManuPanelLink == 1) { ?>
					<li <?php echo ($page == 'dashboard' || $page == 'cpanel' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../admin.php ' : ' admin.php '); ?>"><i class="icon-cog icon-color"></i> Dashboard</a>
					</li>
					<?php } ?>
				</ul>
			</div>
        </div>
