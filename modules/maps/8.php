<?php
include ('queries.php');

if(is_array($map8_players)) {
	$pquery = $map8_players[0];
	$pbinds = $map8_players[1];
	$res1 = $db->GetAll($pquery, $pbinds);
} else {
	$res1 = $db->GetAll($map8_players);
}

if($map8_vehicles) {
	$vquery = $map8_vehicles[0];
	$vbinds = $map8_vehicles[1];
	$res2 = $db->GetAll($vquery, $vbinds);
}

$oquery = $map8_objects[0];
$obinds = $map8_objects[1];
$res3 = $db->GetAll($oquery, $obinds);

$markers = array();
$markers = array_merge($markers, markers_player($res1, $map));
if($map8_vehicles) {
	$markers = array_merge($markers, markers_vehicle($res2, $map));
}
$markers = array_merge($markers, markers_deployable($res3, $map));

?>
