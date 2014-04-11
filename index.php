<?php
	session_start();
	require_once('config.php');
	require_once('db.php');
	include('queries.php');
	$page = 'home';

	$KillsZ = 0;
	$KillsB = 0;
	$KillsH = 0;
	$HeadshotsZ = 0;
	$Killshero = 0;

	$res = $db->Execute($stats_totalkills);
	foreach($res as $row) {
		$KillsZ += $row['KillsZ'];
		$KillsB += $row['KillsB'];
		$KillsH += $row['KillsH'];
		$HeadshotsZ += $row['HeadshotsZ'];
	}
		
	$totalAlive = $db->GetOne($stats_totalAlive);
	$num_totalplayers = $db->GetOne($stats_totalplayers);
	$num_deaths = $db->GetOne($stats_deaths);
	$num_alivebandits = $db->GetOne($stats_alivebandits);
	$num_aliveheros = $db->GetOne($stats_aliveheros);
	$num_totalVehicles = $db->GetOne($stats_totalVehicles[0], $stats_totalVehicles[1]);
	$num_Played24h = $db->GetOne($stats_Played24h);
	$totalwalked = $db->GetOne($stats_totalwalked);	
	$avg_duration = $db->GetOne($stats_duration);
	
	

	//$leaderboardplayers .= '<tr><td>'.$kunt.'</td></tr>';

	if(isset($_GET['leaderboard'])) {
		$page = 'leaderboard';
	} else {
		$page = 'home';
	}
?>
<?php include('modules/stats-header.php'); ?>
		<div class="container">

				<?php
					if(isset($_GET['leaderboard'])) {
						include('modules/leaderboard.php');
					} else {
						include('modules/stats.php');
					}
				?>

		</div>
	<?php if ($EnableSocialMedia == 1) { ?> 
	<div class="social-box" style="margin-top: 30px;">
		<div class="social-box-inner">
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
		</div>
	</div> 	
	<?php
		include('modules/footer.php');
	?>
	</body>
</html>
