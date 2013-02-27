<?php

$res = $db->GetAll("SELECT profile.*, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id");
$markers = markers_player($res, $map);

?>
