<?php

$res = $db->GetAll("SELECT iv.*, v.class_name, oc.Type FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id inner join object_classes oc on oc.Classname = v.class_name WHERE iv.instance_id = ? AND wv.world_id = ?", array($iid, $world));
$markers = markers_vehicle($res, $map);

?>
