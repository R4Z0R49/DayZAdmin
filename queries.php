<?php
include ('config.php');
//include ('querys.php');
switch($sql)
{
   	case 'Bliss':
	//Index
		$stats_totalAlive = "SELECT COUNT(*) FROM survivor WHERE is_dead = 0";
		$stats_totalplayers = "SELECT COUNT(*) FROM profile";
		$stats_deaths = "SELECT COUNT(*) FROM survivor WHERE is_dead = 1";
		$stats_alivebandits = "SELECT COUNT(*) FROM survivor WHERE is_dead = 0 AND Model = 'Bandit1_DZ'";
		$stats_aliveheros = "SELECT COUNT(*) FROM survivor WHERE is_dead = 0 AND Model = 'Survivor3_DZ'";
		$stats_totalVehicles = "SELECT COUNT(*) FROM instance_vehicle WHERE instance_id =" .$iid;
		$stats_Played24h = "SELECT COUNT(*) FROM survivor WHERE last_updated > now() - INTERVAL 1 DAY";
		$stats_totalkills = "SELECT * FROM profile";
		$stats_totalkills_KillsZ = 'total_zombie_kills';
		$stats_totalkills_KillsB = 'total_bandit_kills';
		$stats_totalkills_KillsH = 'total_survivor_kills';
		$stats_totalkills_HeadshotsZ = 'total_headshots';
	//Info
		$info1 = array("SELECT s.*,p.* FROM survivor s JOIN profile p ON p.unique_id = s.unique_id WHERE s.unique_id = ? AND is_dead=0 AND world_id = ? LIMIT 1", array($_GET['id'], $world)); 
		$info4 = array("SELECT iv.*, v.class_name FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id WHERE iv.id = ? and instance_id = ? LIMIT 1", array($_GET["id"], $iid));
		$info5 = array("select v.class_name as otype,wv.id as id,wv.worldspace as pos from world_vehicle wv join vehicle v on v.id = wv.vehicle_id where world_id = (select id from world where name = ?) and wv.id = ? LIMIT 1", array($map, $_GET['id']));
		$info6 = array("SELECT id.*,d.class_name,p.name,p.unique_id player_unique_id from instance_deployable id JOIN deployable d on d.id = id.deployable_id JOIN survivor s ON s.id = id.owner_id JOIN profile p on p.unique_id = s.unique_id WHERE id.id = ? and instance_id = ? LIMIT 1", array($_GET["id"], $iid) );
	//Maps
		$map0 = array("select s.id, p.name, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and last_updated > now() - interval 1 minute", $world);
	break;
	
	
    case 'DayZ':
	//Index
		$stats_totalAlive = "SELECT COUNT(*) FROM character_data WHERE Alive = 1";
		$stats_totalplayers = "SELECT COUNT(*) FROM player_data";
		$stats_deaths = "SELECT COUNT(*) FROM character_data WHERE Alive = 0";
		$stats_alivebandits = "SELECT COUNT(*) FROM character_data WHERE Alive = 1 AND Model = 'Bandit1_DZ'";
		$stats_aliveheros = "SELECT COUNT(*) FROM character_data WHERE Alive = 1 AND Model = 'Survivor3_DZ'";
		$stats_totalVehicles = "SELECT COUNT(*) FROM object_data WHERE Instance = '" . $iid . "' and CharacterID = '0'";
		$stats_Played24h = "select count(*) from (SELECT count(*) from character_data WHERE LastLogin > now() - INTERVAL 1 DAY group by PlayerUID) uniqueplayers";
		$stats_totalkills = "SELECT * FROM character_data";
		$stats_totalkills_KillsZ = 'KillsZ';
		$stats_totalkills_KillsB = 'KillsB';
		$stats_totalkills_KillsH = 'KillsH';
		$stats_totalkills_HeadshotsZ = 'HeadshotsZ';
	//Info	
		$info1 = array("select 
	player_data.playerName as name, 
	player_data.playerUID as unique_id,
	character_data.Worldspace as worldspace,
	character_data.Inventory as inventory,
	character_data.Backpack as backpack,
	character_data.Model as model,
	character_data.Medical as medical,
	character_data.distanceFoot as DistanceFoot,
	character_data.duration as survival_time,
	character_data.last_updated as last_updated,
	character_data.KillsZ as zombie_kills,
	character_data.KillsZ as total_zombie_kills,
	character_data.HeadshotsZ as headshots,
	character_data.HeadshotsZ as total_headshots,
	character_data.KillsH as survivor_kills,
	character_data.KillsH as total_survivor_kills,
	character_data.KillsB as bandit_kills,
	character_data.KillsB as total_bandit_kills,
	character_data.Generation as survival_attempts,
	character_data.duration as survival_time,
	character_data.distanceFoot as distance
from player_data, character_data 
where player_data.PlayerUID like ?
AND Alive=1", array($_GET["id"])); 
		$info4 = array("SELECT * FROM object_data WHERE ObjectUID = ".$_GET["id"]." and instance = '" . $iid . "'"); 
		$info5 = array("SELECT * FROM object_spawns WHERE ObjectUID = ".$_GET["id"]." LIMIT 1"); 
		$info6 = array(""); 
	//Map	
		$map0 = array("
select player_data.playerName as name, player_data.playerUID, 
character_data.PlayerUID as unique_id, 
character_data.CharacterID as id,
character_data.Worldspace as worldspace, 
character_data.Model as model, 
character_data.KillsZ as zombie_kills,
character_data.KillsB as bandit_kills, 
character_data.duration as survival_time 
from player_data, character_data 
where player_data.PlayerUID = character_data.PlayerUID 
and character_data.Alive = 1 
and character_data.last_updated >= NOW() - INTERVAL 1 minute");
	break;
};
?>
