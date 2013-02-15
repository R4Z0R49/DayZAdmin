<?php

$res = $db->GetAll("SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '0'");
$markers = markers_player($res, $map);

?>
