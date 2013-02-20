<?php
require_once('modules/rcon.php');

$markers = array();
$cmd = "players";	
$answer = rcon($serverip_internal, $serverport, $rconpassword, $cmd);

if ($answer != "") {
	$k = strrpos($answer, "---");
	$l = strrpos($answer, "(");
	$out = substr($answer, $k + 4, $l - $k - 5);
	$parray = preg_split ('/$\R?^/m', $out);

	$players = array();
	for ($j = 0; $j < count($parray); $j++) { $players[] = ""; }
	for ($i = 0; $i < count($parray); $i++)
	{
		$m = 0;
		$players[$i][] = "";
		$pout = preg_replace('/\s+/', ' ', $parray[$i]);
		for ($j = 0; $j < strlen($pout); $j++) {
			$char = substr($pout, $j, 1);
			if ($m < 4) {
				if ($char != " ") { $players[$i][$m] .= $char; } else {$m++; }
			} else {
				$players[$i][$m] .= $char;
			}
		}
	}

	for ($i = 0; $i < count($players); $i++) {
		if (strlen($players[$i][4]) > 1) {
			$playername = trim(str_replace(" (Lobby)", "", $players[$i][4]));
			$ip = $players[$i][1];
			$ping = $players[$i][2];
			$res = $db->GetAll("select s.id, p.name, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and p.name = ?", array($world, $playername));
			$markers = array_merge($markers, markers_player($res, $map));
		}
	}
}
else
{
	$markers["error"] = '<div id="page-error" style="margin: 0 0 15px 20px;"><h2>BattlEye did not respond.</h2></div>';
}

?>
