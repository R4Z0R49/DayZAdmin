<?php

include ('queries.php');
$query = $map1[0];
$binds = $map1[1];
$res = $db->GetAll($query, $binds);
$markers = markers_player($res, $map);

?>
