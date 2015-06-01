<?php

include ('queries.php');
$res = $db->GetAll($map9, $iid);
$markers = markers_buildable($res, $map);

?>
