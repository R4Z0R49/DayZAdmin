<?php

include ('queries.php');
$res = $db->GetAll($map6, $iid);
$markers = markers_deployable($res, $map);

?>
