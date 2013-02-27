<?php
//ini_set( "display_errors", 0);
error_reporting (E_ALL ^ E_NOTICE);
	
session_start();
require_once('config.php');
require_once('db.php');
include('queries.php');

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

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $sitename ?></title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" charset="utf-8" />
</head>
<body id="stats-bg"> 
<div id="stats-holder">

	<div id="stats-margin">
		<a href="index.php"><img src="images/logo.png" width="451px" height="218px" alt="" /></a>
	</div>
	<div class="clear"></div>		
	
	<a href="http://www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/" target="_blank"><img src="http://cache.www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/b_560_95_1.png" border="0" width="560" height="95" alt=""/></a>
	
		<div id="statsbox">	
			<div id="login-inner">
				<table border="0" cellpadding="4" cellspacing="0">
<td width="26"><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-unique.gif" width="36" height="27" /></td>
    <td width="184"><strong>Total Players:</strong></td>
    <td width="129" align="right"><?php echo $num_totalplayers;?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-24hr.gif" width="36" height="27" /></td>
    <td><strong> Players in Last 24h:</strong></td>
    <td align="right"><?php echo $num_Played24h;?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-alive.gif" width="36" height="27" /></td>
    <td><strong>Alive Characters:</strong></td>
    <td align="right"><?php echo $totalAlive;?></td>
  </tr>
  <tr>
      <td><img src="./images/playerdeaths.png" width="24" height="24" /></td>
    <td><strong>Player Deaths:</strong></td>
    <td align="right"><?php echo $num_deaths;?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-zombies.gif" width="36" height="27" /></td>
    <td><strong>Zombies Killed:</strong></td>
    <td align="right"><?php echo $KillsZ;?></td>
  </tr>
  <tr>
    <td><img src="images/zombiehs.png" width="24" height="24" /></td>
    <td><strong>Zombies Headshots:</strong></td>
    <td align="right"><?php echo $HeadshotsZ;?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-murders.gif" width="36" height="27" /></td>
    <td><strong>Murders:</strong></td>
    <td align="right"><?php echo $KillsH;?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-bandits.gif" width="36" height="27" /></td>
    <td><strong>Heros Alive:</strong></td>
    <td align="right"><?php echo $num_aliveheros;?></td>
  </tr>
  <tr>
    <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-bandits.gif" width="36" height="27" /></td>
    <td><strong>Bandits Alive:</strong></td>
    <td align="right"><?php echo $num_alivebandits;?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-banditskilled.gif" width="36" height="27" /></td>
    <td><strong>Bandits Killed:</strong></td>
    <td align="right"><?php echo $KillsB;?></td>
  </tr>
  </tr>
  <tr>
    <td><img src="./images/vehicles.png" width="24" height="24" /></td>
    <td><strong>Vehicles:</strong></td>
    <td align="right"><?php echo $num_totalVehicles;?></td>
  </tr>
				</table>
<?php
		include ('playersearch.php');
?>
			</div>
			
			<div class="clear"></div>
		</div>
	</form> 
</div>
</body>
</html>

</div>
<!--  end content -->
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
<?php if ($EnableSocialMedia == 1) { ?> 
<div id="social">
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
	<!--  end social-center -->
	<div class="clear">&nbsp;</div>
</div>
<?php } ?>
<!-- start footer -->         
<div id="footer">
	<!--  start footer-left -->
	<div id="footer-left">
	<a href="admin.php"><?php echo $sitename ?> &copy; Copyright 2006-2012</a>. All rights reserved. Redesigned By UnclearWall</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
 
</body>
</html>
