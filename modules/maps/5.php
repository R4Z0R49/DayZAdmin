<?php

include ('queries.php');
$query = $map5[0];
$binds = $map5[1];

$res = $db->GetAll($query, $binds);
$markers = markers_vehicle($res, $map);

?>
