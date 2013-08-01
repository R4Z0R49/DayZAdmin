<?php
	session_start();
	require_once('config.php');
	require_once('db.php');
	include('queries.php');
	//ini_set( "display_errors", 0);
	error_reporting (E_ALL ^ E_NOTICE);

	$KillsZ = 0;
	$KillsB = 0;
	$KillsH = 0;
	$HeadshotsZ = 0;
	$Killshero = 0;

	$res = $db->Execute($stats_totalkills);
	foreach($res as $row) {
		$KillsZ += $row[$stats_totalkills_KillsZ];
		$KillsB += $row[$stats_totalkills_KillsB];
		$KillsH += $row[$stats_totalkills_KillsH];
		$HeadshotsZ += $row[$stats_totalkills_HeadshotsZ];
	}
		
	$totalAlive = $db->GetOne($stats_totalAlive);

	$num_totalplayers = $db->GetOne($stats_totalplayers);

	$num_deaths = $db->GetOne($stats_deaths);

	$num_alivebandits = $db->GetOne($stats_alivebandits);

	$num_aliveheros = $db->GetOne($stats_aliveheros);

	$num_totalVehicles = $db->GetOne($stats_totalVehicles);

	$num_Played24h = $db->GetOne($stats_Played24h);
	
	$page = 'home';
?>
<!DOCTYPE html>
<html lang="EN">
<head>
	<title><?php echo $sitename ?></title>
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
	<script src="js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		$(document).pngFix( );
		});
	</script>
	
	<!-- New design (Bootstrap - font-awesome) -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>
<body class="stats-bg"> 
<?php include('modules/stats-header.php'); ?>


	<div class="container custom-container">
	<div class="content">
		<div class="gametracker">
			<a href="http://www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/" target="_blank"><img src="http://cache.www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/b_560_95_1.png" border="0" alt=""/></a>
		</div>	
		<div class="stats-box">	
		<div class="stats-box-inner">
			<table border="0" cellpadding="4" cellspacing="0">
				<td width="26"><img src="images/icons/statspage/totalplayers1.png" width="36" height="36" /></td>
					<td width="184"><strong>Total Players:</strong></td>
					<td align="right"><strong><?php echo $num_totalplayers;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/totalplayerin24h.png" width="36" height="36" /></td>
					<td><strong>Players in Last 24h:</strong></td>
					<td align="right"><strong><?php echo $num_Played24h;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/alivecharacters1.png" width="36" height="36" /></td>
					<td><strong>Alive Characters:</strong></td>
					<td align="right"><strong><?php echo $totalAlive;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/playerdeaths1.png" width="36" height="36" /></td>
					<td><strong>Player Deaths:</strong></td>
					<td align="right"><strong><?php echo $num_deaths;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/infectedkilled1.png" width="36" height="36" /></td>
					<td><strong>Zombies Killed:</strong></td>
					<td align="right"><strong><?php echo $KillsZ;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/infectedheadshots1.png" width="36" height="36" /></td>
					<td><strong>Zombies Headshots:</strong></td>
					<td align="right"><strong><?php echo $HeadshotsZ;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/murders.png" width="36" height="36" /></td>
					<td><strong>Murders:</strong></td>
					<td align="right"><strong><?php echo $KillsH;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/heroesalive1.png" width="36" height="36" /></td>
					<td><strong>Heros Alive:</strong></td>
					<td align="right"><strong><?php echo $num_aliveheros;?></strong></td>
				</tr>
				<tr>
				<tr>
					<td><img src="images/icons/statspage/banditsalive1.png" width="36" height="36" /></td>
					<td><strong>Bandits Alive:</strong></td>
					<td align="right"><strong><?php echo $num_alivebandits;?></strong></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/banditskilled1.png" width="36" height="36" /></td>
					<td><strong>Bandits Killed:</strong></td>
					<td align="right"><strong><?php echo $KillsB;?></strong></td>
				</tr>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/vehicles.png" width="36" height="36" /></td>
					<td><strong>Vehicles:</strong></td>
					<td align="right"><strong><?php echo $num_totalVehicles;?></strong></td>
				</tr>
			</table>
			<div class="stats-search">
				<?php include ('playersearch.php'); ?>	
			</div>
		</div>
		</div>
		<?php if ($EnableSocialMedia == 1) { ?> 
		<div class="social-box">
			<!--  start social-center -->
			<h1 class="Topleveltext"><?php echo $socialheader ?></h1>
		<p>
		<?php if ($callenabled == 1) { ?>  
		 <a href="http://<?php echo $call ?>" target="_new"><img src="images/social/icons/call-splatter.png" alt="Phone Call" width="150" height="150" /></a>
		<?php } if ($emailenabled == 1) { ?>   
		  <a href="mailto:<?php echo $email ?>"><img src="images/social/icons/email-splatter.png" alt="Email Us" width="150" height="150" /></a>
		<?php } if ($facebookenabled == 1) { ?>
		  <a href="http://<?php echo $facebook ?>" target="_new"><img src="images/social/icons/facebook-splatter.png" alt="Facebook Page" width="150" height="150" /></a>
		<?php } if ($flickrenabled == 1) { ?>
		  <a href="http://<?php echo $flickr ?>" target="_new"><img src="images/social/icons/flickr-splatter.png" alt="Flickr Page" width="150" height="150" /></a>
		<?php } if ($youtubeenabled == 1) { ?>
		  <a href="http://<?php echo $youtube ?>" target="_new"><img src="images/social/icons/youtube-splatter.png" alt="YouTube Page" width="150" height="150" /></a>
		<?php } if ($twitterenabled == 1) { ?>
		  <a href="http://<?php echo $twitter ?>" target="_new"><img src="images/social/icons/twitter-splatter.png" alt="Twitter Page" width="150" height="150" /></a>
		<?php } if ($vimeoenabled == 1) { ?>
		  <a href="http://<?php echo $vimeo ?>" target="_new"><img src="images/social/icons/vimeo-splatter.png" alt="Vimeo Page" width="150" height="150" /></a>
		<?php } ?>  
		</p>
		<?php } ?>
			<!--  end social-center -->
		</div>
	</div>
	<!--  end content -->
	</div>

		<!-- start footer -->         
		<?php
			include('modules/footer.php');
		?>
		<!-- end footer -->
	</body>
</html>
