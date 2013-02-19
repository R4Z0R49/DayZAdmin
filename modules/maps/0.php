<?php

$query = $map0[0];
$binds = $map0[1];
$res = $db->GetAll($query, $binds);
$markers = markers_player($res, $map);

?>
