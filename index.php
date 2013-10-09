<?php
	session_start();
	require_once('config.php');
	require_once('db.php');
	include('queries.php');
	//ini_set( "display_errors", 0);
	error_reporting (E_ALL ^ E_NOTICE);
	$page == 'home';

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

	//$leaderboardplayers .= '<tr><td>'.$kunt.'</td></tr>';

	if(!isset($_GET['leaderboard'])) {
		$page = 'home';
	} elseif(isset($_GET['leaderboard'])){
		$page = 'leaderboard';
	}
?>
<!DOCTYPE html>
<html lang="EN">
<?php include('modules/stats-header.php'); ?>
	<div class="container custom-container">
		<div class="content">

			<?php
				if(!isset($_GET['leaderboard'])) {
					include('modules/stats.php');
				} elseif (isset($_GET['leaderboard'])){
					include('modules/leaderboard.php');
				}
			?>

		</div>
	</div>
        
	<?php
		include('modules/footer.php');
	?>
	</body>
</html>
