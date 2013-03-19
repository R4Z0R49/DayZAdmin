<?php

include ('queries.php');
$query = $map7[0];
$binds = $map7[1];
$res = $db->GetAll($query, $binds);
$markers = markers_deployable($res, $map);

?>
