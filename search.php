<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');

if (isset($_POST['search'])){
	$pagetitle = "Stats for ".$_POST['search'];
} else {
	$pagetitle = "New search";
}

$search = '%'.substr($_POST['search'], 0, 64).'%';

$row = $db->GetRow("SELECT profile.*, survivor.* FROM profile, survivor AS survivor WHERE profile.unique_id = survivor.unique_id AND name LIKE ? ORDER BY last_updated DESC LIMIT 1", $search);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
?>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<script type="text/javascript">
</script>
</head>
<body id="stats-bg"> 

<div id="topbg"></div>
<div id="logo">
		<img src="http://www.ninjah-gaming.co.uk/s/DayZ/Chernarus/images/logo.png" width="150px" height="72px" alt=""></a>
</div>
<div id="rightlogo">
		<a href="<?php echo($rightlogoLink); ?>"><img src="<?php echo($rightlogoImg); ?>" width="<?php echo($rightlogoWidth); ?>" height="<?php echo($rightlogoHeight); ?>" alt=""></img></a>
</div>
<div id="nav">
	<div id="nav_middle">
		<div id="nav_padding">
			<nav>
				<a href="index.php">Home</a>
			</nav>
		</div>
	</div>
</div>
 
 
<div id="stats-holder">
	
	 	<div id="gametracker">
		<a href="http://www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/" target="_blank"><img src="http://cache.www.gametracker.com/server_info/<?php echo $serverip?>:<?php echo $serverport?>/b_560_95_1.png" border="0" alt=""/></a>
		</div>
	
	<div class="clear"></div>
		<div id="statsbox">	
			<div id="login-inner">
<?php
	echo "<center><h1>".$pagetitle."</h1></center>";
	echo "<br />";
if($row) {
	$id = $row['id'];
?>
				<table border="0" cellpadding="4" cellspacing="0">
<td width="26"><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-unique.gif" width="36" height="27" /></td>
    <td width="184"><strong>Latest id:</strong></td>
    <td width="12" align="right"><?php echo $row['id'];?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-alive.gif" width="36" height="27" /></td>
    <td><strong>uid:</strong></td>
    <td align="right"><?php echo $row['unique_id'];?></td>
  </tr>
    <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-alive.gif" width="36" height="27" /></td>
    <td><strong>humanity:</strong></td>
    <td align="right"><?php echo $row['humanity'];?></td>
  </tr>
  <tr>
      <td><img src="./images/playerdeaths.png" width="24" height="24" /></td>
    <td><strong>survival_attempts:</strong></td>
    <td align="right"><?php echo $row['survival_attempts'];?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-zombies.gif" width="36" height="27" /></td>
    <td><strong>total_survival_time:</strong></td>
    <td align="right"><?php echo survivalTimeToString($row['total_survival_time']);?></td>
  </tr>
  <tr>
    <td><img src="images/zombiehs.png" width="24" height="24" /></td>
    <td><strong>total_headshots:</strong></td>
    <td align="right"><?php echo $row['total_headshots'];?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-murders.gif" width="36" height="27" /></td>
    <td><strong>total_bandit_kills:</strong></td>
    <td align="right"><?php echo $row['total_bandit_kills'];?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-bandits.gif" width="36" height="27" /></td>
    <td><strong>total_zombie_kills:</strong></td>
    <td align="right"><?php echo $row['total_zombie_kills'];?></td>
  </tr>
  <tr>
    <td><img src="http://www.dayzmod.com/images/icons/sidebar/staticon-banditskilled.gif" width="36" height="27" /></td>
	    <td><strong>total_survivor_kills:</strong></td>
    <td align="right"><?php echo $row['total_survivor_kills'];?></td>
  </tr>
				</table>
    <?php } else {  echo "No results found\n"; } ?>
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
<!-- start footer -->         
<div id="footer">
	<!--  start footer-left -->
	<div id="footer-left">
	<a href="admin.php"><?php echo $sitename ?> &copy; Copyright 2010-2013. All rights reserved(LeadGames). Redesigned By Marcuz</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
 
</body>
</html>
