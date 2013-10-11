<?php

include ('queries.php');
$res = $db->GetAll($map3);
$markers = markers_player($res, $map);

?>
