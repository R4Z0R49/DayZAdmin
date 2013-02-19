<?php

$res = $db->GetAll("SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id");
$markers = markers_player($res, $map);

?>
