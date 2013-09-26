<?php

include ('queries.php');
$query = $map2[0];
$binds = $map2[1];
$res = $db->GetAll($query, $binds);
$markers = markers_player($res, $map);

?>
