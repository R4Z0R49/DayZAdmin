<?php

include ('queries.php');
$query = $map6[0];
$binds = $map6[1];
$res = $db->GetAll($query, $binds);
$markers = markers_deployable($res, $map);

?>
