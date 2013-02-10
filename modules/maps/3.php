<?php

$res = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id") or die(mysql_error());
$markers = markers_player($res, $map);

?>