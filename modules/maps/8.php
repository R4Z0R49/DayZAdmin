<?php
include ('queries.php');

$pquery = $map8_players[0];
$pbinds = $map8_players[1];
$res1 = $db->GetAll($pquery, $pbinds);
$vquery = $map8_vehilces[0];
$vbinds = $map8_vehilces[1];
$res2 = $db->GetAll($vquery, $vbinds);
$oquery = $map8_objects[0];
$obinds = $map8_objects[1];
$res3 = $db->GetAll($oquery, $obinds);

$markers = array();
$markers = array_merge($markers, markers_player($res1, $map));
$markers = array_merge($markers, markers_vehicle($res2, $map));
$markers = array_merge($markers, markers_deployable($res3, $map));

?>
