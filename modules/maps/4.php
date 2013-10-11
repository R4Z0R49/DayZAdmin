<?php

include ('queries.php');
$res = $db->GetAll($map4, $iid);
$markers = markers_vehicle($res, $map);

?>
