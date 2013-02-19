<?php

$res = $db->GetAll("select wv.*, v.*, oc.* from world_vehicle wv inner join vehicle v on wv.vehicle_id = v.id inner join object_classes oc on v.class_name = oc.classname where wv.world_id = ?", $world);
$markers = markers_vehicle($res, $map);

?>
