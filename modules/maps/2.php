<?php

$res = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '1'") or die(mysql_error());
$markers = markers_player($res, $map);

?>