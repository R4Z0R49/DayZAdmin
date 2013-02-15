<?php
include ('config.php');
//include ('querys.php');
switch($sql)
{
   	case 'Bliss':
		$info1 = array("SELECT s.*,p.* FROM survivor s JOIN profile p ON p.unique_id = s.unique_id WHERE s.unique_id = ? AND is_dead=0 AND world_id = ? LIMIT 1", array($_GET['id'], $world)); 
		$info4 = array("SELECT iv.*, v.class_name FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id WHERE iv.id = ? and instance_id = ? LIMIT 1", array($_GET["id"], $iid));
		$info5 = array("select v.class_name as otype,wv.id as id,wv.worldspace as pos from world_vehicle wv join vehicle v on v.id = wv.vehicle_id where world_id = (select id from world where name = ?) and wv.id = ? LIMIT 1", array($map, $_GET['id']));
		$info6 = array("SELECT id.*,d.class_name,p.name,p.unique_id player_unique_id from instance_deployable id JOIN deployable d on d.id = id.deployable_id JOIN survivor s ON s.id = id.owner_id JOIN profile p on p.unique_id = s.unique_id WHERE id.id = ? and instance_id = ? LIMIT 1", array($_GET["id"], $iid) );
	
		$map0 = array("select s.id, p.name, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and last_updated > now() - interval 1 minute", $iid);
	break;
	
	
    case 'DayZ':
		$info1 = "select player_data.*, character_data.* from player_data, character_data as character_data where player_data.PlayerUID like ".$_GET["id"].$cid." AND Alive=1"; 
		$info4 = "SELECT * FROM object_data WHERE ObjectUID = ".$_GET["id"]." and instance = '" . $iid . "'";
		$info5 = "SELECT * FROM object_spawns WHERE ObjectUID = ".$_GET["id"]." LIMIT 1"; 
		$info6 = "";
		
		$map0 = "select player_data.*, character_data.* from player_data, character_data as character_data where player_data.PlayerUID = character_data.PlayerUID and character_data.Alive = 1 and character_data.last_updated >= NOW() - INTERVAL 1 minute";
	break;
}
?>
