<?php

include ('queries.php');
$res = $db->GetAll($map0);
$markers = markers_player($res, $map);

?>
