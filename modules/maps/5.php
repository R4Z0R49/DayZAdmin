<?php

$res = mysql_query("select wv.*, v.*, oc.* from world_vehicle wv inner join vehicle v on wv.vehicle_id = v.id inner join object_classes oc on v.class_name = oc.classname where wv.world_id = ".$iid) or die(mysql_error());
$markers = markers_vehicle($res, $map);

?>
