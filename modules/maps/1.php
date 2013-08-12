<?php

include ('queries.php');
$query = $map1[0];
$res = $db->GetAll($query);
$markers = markers_player($res, $map);

?>
