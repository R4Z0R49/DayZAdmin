<div class="stats-content">
	<div class="gametracker">
		<a href="http://www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/" target="_blank"><img src="http://cache.www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/b_560_95_1.png" border="0" alt=""/></a>
	</div>	
	<div class="stats-box">	
		<div class="stats-box-inner">
			<table border="0" cellpadding="4" cellspacing="0">
				<td width="26"><img src="images/icons/statspage/totalplayers1.png" width="36" height="36" /></td>
					<td width="184"><strong>Total Players:</strong></td>
					<td align="right"><?php echo $num_totalplayers;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/totalplayerin24h.png" width="36" height="36" /></td>
					<td><strong>Players in Last 24h:</strong></td>
					<td align="right"><?php echo $num_Played24h;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/alivecharacters1.png" width="36" height="36" /></td>
					<td><strong>Alive Characters:</strong></td>
					<td align="right"><?php echo $totalAlive;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/playerdeaths1.png" width="36" height="36" /></td>
					<td><strong>Player Deaths:</strong></td>
					<td align="right"><?php echo $num_deaths;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/infectedkilled1.png" width="36" height="36" /></td>
					<td><strong>Zombies Killed:</strong></td>
					<td align="right"><?php echo $KillsZ;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/infectedheadshots1.png" width="36" height="36" /></td>
					<td><strong>Zombies Headshots:</strong></td>
					<td align="right"><?php echo $HeadshotsZ;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/murders.png" width="36" height="36" /></td>
					<td><strong>Murders:</strong></td>
					<td align="right"><?php echo $KillsH;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/heroesalive1.png" width="36" height="36" /></td>
					<td><strong>Heros Alive:</strong></td>
					<td align="right"><?php echo $num_aliveheros;?></td>
				</tr>
				<tr>
				<tr>
					<td><img src="images/icons/statspage/banditsalive1.png" width="36" height="36" /></td>
					<td><strong>Bandits Alive:</strong></td>
					<td align="right"><?php echo $num_alivebandits;?></td>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/banditskilled1.png" width="36" height="36" /></td>
					<td><strong>Bandits Killed:</strong></td>
					<td align="right"><?php echo $KillsB;?></td>
				</tr>
				</tr>
				<tr>
					<td><img src="images/icons/statspage/vehicles.png" width="36" height="36" /></td>
					<td><strong>Vehicles:</strong></td>
					<td align="right"><?php echo $num_totalVehicles;?></td>
				</tr>
			</table>
		</div>
	</div>

	</br>

	<div class="stats-box">
		<div class="stats-box-inner">
			<div class="stats-search">
				<?php require_once('playersearch.php'); ?>	
			</div>
		</div>
	</div>

	<?php if ($EnableSocialMedia == 1) { ?> 
	<div class="social-box">
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
