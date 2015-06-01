<?php
include ('queries.php');

$res1 = $db->GetAll($map8_players);
$res2 = $db->GetAll($map8_vehicles, $iid);
$res3 = $db->GetAll($map8_deployables, $iid);
$res4 = $db->GetAll($map8_buildables, $iid);

$markers = array();
$markers = array_merge($markers, markers_player($res1, $map));
$markers = array_merge($markers, markers_vehicle($res2, $map));
$markers = array_merge($markers, markers_deployable($res3, $map));
$markers = array_merge($markers, markers_buildable($res4, $map));

?>
