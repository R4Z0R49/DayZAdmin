<?php

$res = mysql_query("select s.id, p.name, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ".$iid." and last_updated > now() - interval 1 minute") or die(mysql_error());
$markers = markers_player($res, $map);

?>
