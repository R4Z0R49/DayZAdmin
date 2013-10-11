<?php

include ('queries.php');
$res = $db->GetAll($map7, $iid);
$markers = markers_deployable($res, $map);

?>
