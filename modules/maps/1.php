<?php

include ('queries.php');
$res = $db->GetAll($map1);
$markers = markers_player($res, $map);

?>
