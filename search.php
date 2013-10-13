<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('queries.php');
$page == 'home';

if (isset($_REQUEST['search'])){
    $search = '%'.substr($_REQUEST['search'], 0, 64).'%';

    $row = $db->GetRow($search_query_player, $search);

    if(count($row) > 0) {
    	$pagetitle = "Stats for ".$row['playerName'];
    } else {
    	$pagetitle = "Stats for ".$_REQUEST['search'];
    }
} else {
	$pagetitle = "New search";
}


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
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/font-awesome.css" rel="stylesheet">
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
		<?php
			echo "<center><h1>".$pagetitle."</h1></center>";
			echo "<br />";
			if($row) {
			$id = $row['id'];
		?>
		<table border="0" cellpadding="4" cellspacing="0">
		<td width="26"><img src="images/icons/statspage/alivecharacters1.png" width="36" height="36" /></td>
			<td width="184"><strong>Latest id:</strong></td>
			<td width="12" align="right"><?php echo $row['CharacterID'];?></td>
		  </tr>
		  <tr>
			<td><img src="images/icons/statspage/totalplayers1.png" width="36" height="36" /></td>
			<td><strong>UID:</strong></td>
			<td align="right"><?php echo $row['PlayerUID'];?></td>
		  </tr>
			<tr>
			<td><img src="images/icons/statspage/totalplayers1.png" width="36" height="36" /></td>
			<td><strong>Humanity:</strong></td>
			<td align="right"><?php echo $row['Humanity'];?></td>
		  </tr>
		  <tr>
			  <td><img src="images/icons/statspage/playerdeaths1.png" width="24" height="36" /></td>
			<td><strong>Survival Attempts:</strong></td>
			<td align="right"><?php echo $row['Generation'];?></td>
		  </tr>
		  <tr>
			<td><img src="images/icons/statspage/totalplayerin24h.png" width="36" height="36" /></td>
			<td><strong>Survival Time:</strong></td>
			<td align="right" width="120px"><?php echo survivalTimeToString($row['duration']);?></td>
		  </tr>
		  <tr>
			<td><img src="images/icons/statspage/banditskilled1.png" width="36" height="36" /></td>
			<td><strong>Bandit Kills:</strong></td>
			<td align="right"><?php echo $row['KillsB'];?></td>
		  </tr>
		  <tr>
			<td><img src="images/icons/statspage/infectedkilled1.png" width="36" height="36" /></td>
			<td><strong>Zombie Kills:</strong></td>
			<td align="right"><?php echo $row['KillsZ'];?></td>
		  </tr>
		  <tr>
			<td><img src="images/icons/statspage/infectedheadshots1.png" width="24" height="36" /></td>
			<td><strong>Headshots:</strong></td>
			<td align="right"><?php echo $row['HeadshotsZ'];?></td>
		  </tr>
		  <tr>
			<td><img src="images/icons/statspage/murders.png" width="36" height="36" /></td>
				<td><strong>Survivor Kills:</strong></td>
			<td align="right"><?php echo $row['KillsH'];?></td>
		  </tr>
		</table>
		<?php } else {  echo "No results found\n"; } ?>
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
