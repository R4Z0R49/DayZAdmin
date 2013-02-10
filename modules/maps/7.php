<?php

$res = mysql_query("select id.id,id.unique_id as idid,id.worldspace,oc.Classname,oc.Type,p.name from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name in ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1') and id.instance_id = ".$iid) or die(mysql_error());
$markers = markers_deployable($res, $map);

?>
