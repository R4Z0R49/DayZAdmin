<?php

$res1 = $db->GetAll("select s.id, p.name, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and last_updated > now() - interval 1 minute", $world);

$res2 = $db->GetAll("SELECT world_vehicle.vehicle_id, vehicle.class_name, object_classes.Type, instance_vehicle.*, instance.world_id FROM `world_vehicle`, `vehicle`, `object_classes`, `instance_vehicle`, `instance` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND instance_vehicle.instance_id = ? AND world_vehicle.world_id = instance.world_id AND object_classes.classname = vehicle.class_name", $iid);

$res3 = $db->GetAll("select id.id,id.unique_id as idid,id.worldspace,id.inventory,oc.Classname,oc.Type,p.name from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name in ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1', 'TentStorage') and id.instance_id = ?", $iid);

$markers = array();
$markers = array_merge($markers, markers_player($res1, $map));
$markers = array_merge($markers, markers_vehicle($res2, $map));
$markers = array_merge($markers, markers_deployable($res3, $map));

?>
