<?php

$res = $db->GetAll("select id.id,id.unique_id as idid,id.worldspace,id.inventory,id.last_updated,instance_id,oc.Classname,oc.Type,p.name,p.unique_id from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name = 'TentStorage' and id.instance_id = ?", $iid);
$markers = markers_deployable($res, $map);

?>
