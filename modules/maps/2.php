<?php

include ('queries.php');
$res = $db->GetAll($map2);
$markers = markers_player($res, $map);

?>
