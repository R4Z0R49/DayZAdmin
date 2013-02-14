<?php

$res = mysql_query($map0) or die(mysql_error());
$markers = markers_player($res, $map);

?>
