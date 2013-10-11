<?php

include ('queries.php');

$res = $db->GetAll($map5);
$markers = markers_vehicle($res, $map);

?>
