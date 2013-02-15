<?php

$res = $db->GetAll("SELECT world_vehicle.vehicle_id, vehicle.class_name, object_classes.Type, instance_vehicle.*, instance.world_id FROM `world_vehicle`, `vehicle`, `object_classes`, `instance_vehicle`, `instance` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND instance_vehicle.instance_id = ? AND world_vehicle.world_id = instance.world_id AND object_classes.classname = vehicle.class_name", $iid);
$markers = markers_vehicle($res, $map);

?>
