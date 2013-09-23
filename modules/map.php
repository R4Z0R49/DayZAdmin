<?php
include('config.php');
mysql_connect ($hostname, $username, $password) or die ('Error: ' . mysql_error());
mysql_select_db($dbName);

if (isset($_SESSION['user_id']) && $accesslvl != 'semi')
{
	switch($show) {
	case 0:
		$title = 'Recent Players';
		break;
	case 1:
		$title = 'Alive Players';
		break;
	case 2:
		$title = 'Dead Players';
		break;
	case 3:
		$title = 'All Players';
		break;
	case 4:
		$title = 'Vehicles';
		break;
	case 5:
		$title = 'Vehicle Spawns';
		break;
	case 6:
		$title = 'Tents / Stashes';
		break;
	case 7:
		$title = 'Deployables';
		break;
	case 8:
		$title = 'Recent Players, Vehicles and Deployables';
		break;
	}
	echo '<div id="page-heading"><title>'.$title.' - '.$sitename.'</title><h2 class="custom-h2">'.$title.'&nbsp;(<span id="count">0</span>)</h2></div>';
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Viewing map',?,NOW())", $_SESSION['login']);
	include('modules/leaf.php');
}
else
{
	if ($accesslvl != 'full') {
		$message->add('danger', "You dont have enough access to view this");
		$message->display();
	}
}
?>
