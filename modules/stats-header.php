<head>
	<title><?php echo $sitename ?></title>
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<!-- New design (Bootstrap - font-awesome) -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/font-awesome.css" rel="stylesheet">
	
	<!-- Graphs -->
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.jqplot.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />
	<script type="text/javascript" src="js/plugins/jqplot.canvasTextRenderer.min.js"></script>
	<script type="text/javascript" src="js/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>	
	<script type="text/javascript" src="js/plugins/jqplot.bubbleRenderer.min.js"></script>	
	<script type="text/javascript" src="js/plugins/jqplot.dateAxisRenderer.min.js"></script>
	<script type="text/javascript" src="js/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
	<script type="text/javascript" src="js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	<script type="text/javascript" src="js/plugins/jqplot.barRenderer.min.js"></script>
	<script type="text/javascript" src="js/plugins/jqplot.jqplot.donutRenderer.min.js"></script>
	
	<script>
		$(document).ready(function(){
		 
			var arr = [[1, <?php echo $totalAlive; ?>, <?php echo $totalAlive; ?>, "Alive"], [2, <?php echo $num_deaths; ?>, <?php echo $num_deaths; ?>, "Dead"]];
			 
			var plot1 = $.jqplot('chart1',[arr],{
				title: 'Dead vs Alive Players',
				seriesDefaults:{
					renderer: $.jqplot.BubbleRenderer,
					rendererOptions: {
						bubbleAlpha: 0.6,
						highlightAlpha: 0.8
					},
					shadow: true,
					shadowAlpha: 0.05
				}
			});
			
			var arr2 = [[1, <?php echo $num_aliveheros; ?>, <?php echo $num_aliveheros; ?>, "Heroes"], [2, <?php echo $num_alivebandits; ?>, <?php echo $num_alivebandits; ?>, "Bandits"]];
			var plot2 = $.jqplot('chart2',[arr2],{
				title: 'Bandits vs Heroes',
				seriesDefaults:{
					renderer: $.jqplot.BubbleRenderer,
					rendererOptions: {
						bubbleAlpha: 0.6,
						highlightAlpha: 0.8
					},
					shadow: true,
					shadowAlpha: 0.05
				}
			});
			
			var arr3 = [[1, <?php echo $KillsZ; ?>, <?php echo $KillsZ; ?>, "Zombie Kills"], [2, <?php echo $HeadshotsZ; ?>, <?php echo $HeadshotsZ; ?>, "Headshots"]];
			var plot3 = $.jqplot('chart3',[arr3],{
				title: 'Zombie Statistics',
				seriesDefaults:{
					renderer: $.jqplot.BubbleRenderer,
					rendererOptions: {
						bubbleAlpha: 0.6,
						highlightAlpha: 0.8
					},
					shadow: true,
					shadowAlpha: 0.05
				}
			});
			
			var arr4 = [[1, <?php echo $KillsZ; ?>, <?php echo $KillsZ; ?>, "Bandits Alive"], [2, <?php echo $HeadshotsZ; ?>, <?php echo $HeadshotsZ; ?>, "Bandits Killed"]];
			var plot4 = $.jqplot('chart4',[arr4],{
				title: 'Bandit Statistics',
				seriesDefaults:{
					renderer: $.jqplot.BubbleRenderer,
					rendererOptions: {
						bubbleAlpha: 0.6,
						highlightAlpha: 0.8
					},
					shadow: true,
					shadowAlpha: 0.05
				}
			});
			
			var arr5 = [[1, <?php echo $num_totalplayers; ?>, <?php echo $num_totalplayers; ?>, "Total"], [2, <?php echo $totalAlive; ?>, <?php echo $totalAlive; ?>, "Alive"]];
			var plot5 = $.jqplot('chart5',[arr5],{
				title: 'Total vs Alive Players',
				seriesDefaults:{
					renderer: $.jqplot.BubbleRenderer,
					rendererOptions: {
						bubbleAlpha: 0.6,
						highlightAlpha: 0.8
					},
					shadow: true,
					shadowAlpha: 0.05
				}
			});
		});
	</script>
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
				<div class="gametracker">
					<a href="http://www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/" target="_blank"><img src="http://cache.www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/b_160_400_1_ffffff_c5c5c5_ffffff_000000_0_1_0.png" border="0" width="160" height="248" alt=""/></a>
				</div>
			</div>       
		</div>
