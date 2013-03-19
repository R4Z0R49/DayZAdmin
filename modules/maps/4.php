<?php

include ('queries.php');
$query = $map4[0];
$binds = $map4[1];
$res = $db->GetAll($query, $binds);
$markers = markers_vehicle($res, $map);

?>
