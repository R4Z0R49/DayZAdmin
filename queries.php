<?php
include ('config.php');
//include ('querys.php');
$user_id = $_SESSION['user_id'];

// Access lvls
$accesslvlname = $db->GetOne("SELECT accesslvl FROM users WHERE id = '$user_id'");
$accesslvltable = $db->GetAll("SELECT * FROM accesslvl WHERE name = '$accesslvlname'");
$accesslvls = $accesslvltable[0]['access'];
$accesslvls = str_replace("|", ",", $accesslvls);
$accesslvls = json_decode($accesslvls);
$accesslvls = array($accesslvls);

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
		if(isset($_GET['cid']) && $_GET['cid'] > 0) {
			$info1 = array("SELECT s.id as cid,s.*,p.* FROM survivor s JOIN profile p ON p.unique_id = s.unique_id WHERE s.unique_id = ? AND s.id = ? AND world_id = ? LIMIT 1", array($_GET['id'], $_GET['cid'], $world)); 
		} else {
			$info1 = array("SELECT s.id as cid,s.*,p.* FROM survivor s JOIN profile p ON p.unique_id = s.unique_id WHERE s.unique_id = ? AND is_dead = 0 AND world_id = ? LIMIT 1", array($_GET['id'], $world)); 
		}
		$info4 = array("SELECT iv.*, v.class_name FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id WHERE iv.id = ? and instance_id = ? LIMIT 1", array($_GET["id"], $iid));
		$info5 = array("select v.class_name as otype,wv.id as id,wv.worldspace as pos from world_vehicle wv join vehicle v on v.id = wv.vehicle_id where world_id = (select id from world where name = ?) and wv.id = ? LIMIT 1", array($map, $_GET['id']));
		$info6 = array("SELECT id.*,d.class_name,p.name,p.unique_id AS unique_id from instance_deployable id JOIN deployable d on d.id = id.deployable_id JOIN survivor s ON s.id = id.owner_id JOIN profile p on p.unique_id = s.unique_id WHERE  d.class_name IN ('TentStorage','StashSmall','StashMedium') AND id.id = ? and instance_id = ? LIMIT 1", array($_GET["id"], $iid) );
		$info7 = array("SELECT * FROM instance");
	//Maps
		$map0 = array("select s.id AS cid, s.state, p.*, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and last_updated > now() - interval 1 minute", $world);
		$map1 = array("select s.id AS cid, s.state, p.*, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ?", $world);
        $map2 = array("SELECT profile.*, survivor.id AS cid, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '1' AND survivor.world_id = ?", $world);
		$map4 = array("SELECT iv.*, v.class_name, oc.Type FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id inner join object_classes oc on oc.Classname = v.class_name WHERE iv.instance_id = ? AND wv.world_id = ?", array($iid, $world));
        $map5 = array("select wv.*, v.*, oc.* from world_vehicle wv inner join vehicle v on wv.vehicle_id = v.id inner join object_classes oc on v.class_name = oc.classname where wv.world_id = ?", $world);
		$map6 = array("select id.id,id.unique_id as idid,id.worldspace,id.inventory,id.last_updated,instance_id,oc.Classname,oc.Type,p.name,p.unique_id from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name IN ('TentStorage','StashSmall','StashMedium') and id.instance_id = ?", $iid);
		$map7 = array("select id.id,id.unique_id as idid,id.worldspace,id.last_updated,oc.Classname,oc.Type,p.name from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name in ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1') and id.instance_id = ?", $iid);
		$map8_players = array("select s.id, s.state, p.*, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and last_updated > now() - interval 1 minute", $world);
		$map8_vehicles = array("SELECT iv.*, v.class_name, oc.Type FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id inner join object_classes oc on oc.Classname = v.class_name WHERE iv.instance_id = ? AND wv.world_id = ?", array($iid, $world));
		$map8_objects = array("select id.id,id.unique_id as idid,id.worldspace,id.inventory,id.last_updated,oc.Classname,oc.Type,p.name from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name in ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1', 'TentStorage', 'StashSmall', 'StashMedium') and id.instance_id = ?", $iid);
        // Tables
        $table0 = array("SELECT p.name, s.* FROM profile p, survivor s WHERE p.unique_id = s.unique_id AND p.name = ? ORDER BY s.last_updated DESC LIMIT 1", array($playername));
        $table1 = array("select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id and survivor.is_dead = '0'");
        $table2 = array("select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id and survivor.is_dead = '1'");
        $table3 = array("select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id");
        $table4 = array("SELECT iv.*, v.class_name from instance_vehicle iv inner join world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id WHERE instance_id = ?", $iid);
        $table5 = array("select v.class_name as otype,wv.id as id,wv.worldspace as pos from world_vehicle wv join vehicle v on v.id = wv.vehicle_id where world_id = (select id from world where name = ?)", $map);
		$table6 = array("SELECT id.*,d.class_name,p.name,p.unique_id AS unique_id, s.id AS cid from instance_deployable id JOIN deployable d on d.id = id.deployable_id JOIN survivor s ON s.id = id.owner_id JOIN profile p on p.unique_id = s.unique_id WHERE d.class_name IN ('TentStorage','StashSmall','StashMedium') AND instance_id = ?", $iid);
		$table7 = array("SELECT id.*,d.class_name,p.name,p.unique_id AS unique_id, s.id AS cid from instance_deployable id JOIN deployable d on d.id = id.deployable_id JOIN survivor s ON s.id = id.owner_id JOIN profile p on p.unique_id = s.unique_id WHERE d.class_name NOT IN ('TentStorage', 'StashSmall', 'StashMedium') AND instance_id = ?", $iid);
        // Check
        $check_player = "select p.name, s.* from profile p left join survivor s on p.unique_id = s.unique_id where s.is_dead = 0";
        $check_deployable = "SELECT * FROM v_deployable";
        $check_vehicle = "SELECT * FROM v_vehicle";
    //Leaderboard
        $leaderboard_query = "SELECT * FROM profile";
        $leaderboard_Playername = "name";
        $leaderboard_Deaths = "survival_attempts";
        $leaderboard_KillsZ = "total_zombie_kills";
        $leaderboard_KillsB = "total_bandit_kills";
        $leaderboard_Headshots = "total_headshots";
        $leaderboard_KillsH = "total_survivor_kills";
        $leaderboard_Humanity = "humanity";
    // Search
        $search_query_player = "select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id and name LIKE ? ORDER BY last_updated DESC";
        $search_query_item = "SELECT * from (SELECT profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id) as T where inventory LIKE ? OR backpack LIKE ? ORDER BY last_updated DESC";
        $search_query_vehicle = "select iv.id, v.class_name, 0 owner_id, iv.worldspace, iv.inventory, iv.instance_id, iv.parts, fuel, oc.type, damage from instance_vehicle iv inner join world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on v.id = wv.vehicle_id inner join object_classes oc on v.class_name = oc.classname where iv.instance_id = ? AND v.class_name LIKE ?";
        $search_query_container = "SELECT id.*,d.class_name,p.name,p.unique_id AS unique_id from instance_deployable id JOIN deployable d on d.id = id.deployable_id JOIN survivor s ON s.id = id.owner_id JOIN profile p on p.unique_id = s.unique_id WHERE id.instance_id = ? AND id.inventory LIKE ?";
        $search_query_container_veh = "SELECT iv.*, v.class_name FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id WHERE iv.instance_id = ? AND iv.inventory LIKE ?";

	break;
	
	
    case 'DayZ':
	//Index
		$stats_totalAlive = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1";
		$stats_totalplayers = "SELECT COUNT(*) FROM Player_DATA";
		$stats_deaths = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 0";
		$stats_alivebandits = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Model = 'Bandit1_DZ'";
		$stats_aliveheros = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Model = 'Survivor3_DZ'";
		$stats_totalVehicles = "SELECT COUNT(*) FROM Object_DATA WHERE Instance = " . $iid . " and CharacterID = '0'";
		$stats_Played24h = "select count(*) from (SELECT count(*) from Character_DATA WHERE LastLogin > now() - INTERVAL 1 DAY group by PlayerUID) uniqueplayers";
		$stats_totalkills = "SELECT * FROM Character_DATA";
		$stats_totalkills_KillsZ = 'KillsZ';
		$stats_totalkills_KillsB = 'KillsB';
		$stats_totalkills_KillsH = 'KillsH';
		$stats_totalkills_HeadshotsZ = 'HeadshotsZ';
	//Info	
		if(isset($_GET['cid']) && $_GET['cid'] > 0) {
		    $info1 = array("select 
            	Player_DATA.playerName as name,
            	Player_DATA.playerUID as uid,
            	Character_DATA.playerUID as unique_id,
            	Character_DATA.Worldspace as worldspace,
            	Character_DATA.Inventory as inventory,
            	Character_DATA.Backpack as backpack,
            	Character_DATA.Model as model,
            	(CASE Character_DATA.Alive WHEN '1' THEN '0' ELSE '1' END) AS is_dead,
            	Character_DATA.Medical as medical,
            	Character_DATA.distanceFoot as DistanceFoot,
            	Character_DATA.duration as survival_time,
            	Character_DATA.last_updated as last_updated,
            	Character_DATA.KillsZ as zombie_kills,
            	Character_DATA.KillsZ as total_zombie_kills,
            	Character_DATA.HeadshotsZ as headshots,
            	Character_DATA.HeadshotsZ as total_headshots,
            	Character_DATA.KillsH as survivor_kills,
            	Character_DATA.KillsH as total_survivor_kills,
            	Character_DATA.KillsB as bandit_kills,
            	Character_DATA.KillsB as total_bandit_kills,
            	Character_DATA.Generation as survival_attempts,
            	Character_DATA.duration as survival_time,
            	Character_DATA.distanceFoot as distance,
            	Character_DATA.Humanity as humanity
            from Player_DATA, Character_DATA 
            where Character_DATA.playerUID = Player_DATA.playerUID
            and Player_DATA.PlayerUID = ? AND Character_DATA.CharacterID = ?", array($_GET["id"], $_GET["cid"]));
        } else {
            $info1 = array("select
                Player_DATA.playerName as name,
                Player_DATA.playerUID as uid,
                Character_DATA.playerUID as unique_id,
                Character_DATA.Worldspace as worldspace,
                Character_DATA.Inventory as inventory,
                Character_DATA.Backpack as backpack,
                Character_DATA.Model as model,
                (CASE Character_DATA.Alive WHEN '1' THEN '0' ELSE '1' END) AS is_dead,
                Character_DATA.Medical as medical,
                Character_DATA.distanceFoot as DistanceFoot,
                Character_DATA.duration as survival_time,
                Character_DATA.last_updated as last_updated,
                Character_DATA.KillsZ as zombie_kills,
                Character_DATA.KillsZ as total_zombie_kills,
                Character_DATA.HeadshotsZ as headshots,
                Character_DATA.HeadshotsZ as total_headshots,
                Character_DATA.KillsH as survivor_kills,
                Character_DATA.KillsH as total_survivor_kills,
                Character_DATA.KillsB as bandit_kills,
                Character_DATA.KillsB as total_bandit_kills,
                Character_DATA.Generation as survival_attempts,
                Character_DATA.duration as survival_time,
                Character_DATA.distanceFoot as distance,
                Character_DATA.Humanity as humanity
            from Player_DATA, Character_DATA
            where Character_DATA.playerUID = Player_DATA.playerUID
            and Character_DATA.Alive = 1 AND Player_DATA.PlayerUID = ?", $_GET["id"]);
        }
		$info4 = array("SELECT Object_CLASSES.*,
        Object_DATA.ObjectID as id,
        Object_DATA.Hitpoints as parts,
        Object_DATA.Inventory as inventory,
        Object_DATA.ObjectUID as uid,
        Object_DATA.Classname as class_name,
        Object_DATA.Worldspace as worldspace,
        Object_DATA.Damage as damage,
        Object_DATA.last_updated,
        Object_DATA.Fuel as fuel
        FROM Object_CLASSES, Object_DATA as Object_DATA
        where Object_DATA.Classname = Object_CLASSES.Classname
        AND Object_DATA.ObjectID = ?
        and Object_DATA.Instance =  ? and CharacterID = 0", array($_GET["id"], $iid) ); 
		$info5 = array("SELECT * FROM Object_SPAWNS WHERE ObjectUID = ? AND Instance = ?", array($_GET["id"], $iid) ); 
		$info6 = array("SELECT od.ObjectID as id, od.ObjectUID as idid, od.Classname, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, od.last_updated,pd.playerName AS name, pd.playerUID AS unique_id,oc.Classname AS class_name, cd.CharacterID AS cid, oc.Type FROM Object_DATA od LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE od.Classname IN ('TentStorage','StashSmall','StashMedium') AND od.ObjectID = ? AND od.Instance = ?", array($_GET["id"], $iid)); 
	//Map	
		$map0 = array("
select Player_DATA.playerName as name, Player_DATA.playerUID, 
Character_DATA.PlayerUID as unique_id, 
Character_DATA.CharacterID AS cid,
Character_DATA.Worldspace as worldspace, 
Character_DATA.Model as model, 
Character_DATA.KillsZ as zombie_kills,
Character_DATA.KillsB as bandit_kills, 
Character_DATA.duration as survival_time,
Character_DATA.Generation as survival_attempts,
Character_DATA.currentState AS state,
Character_DATA.Humanity as humanity
from Player_DATA, Character_DATA 
where Player_DATA.PlayerUID = Character_DATA.PlayerUID 
and Character_DATA.Alive = 1 
and Character_DATA.last_updated >= NOW() - INTERVAL 1 minute");
        $map1 = array("
select Player_DATA.playerName as name, Player_DATA.playerUID,
Character_DATA.PlayerUID as unique_id,
Character_DATA.CharacterID as cid,
Character_DATA.Worldspace as worldspace,
Character_DATA.Model as model,
Character_DATA.KillsZ as zombie_kills,
Character_DATA.KillsB as bandit_kills,
Character_DATA.duration as survival_time,
Character_DATA.Generation as survival_attempts,
Character_DATA.currentState AS state,
Character_DATA.Humanity as humanity
from Player_DATA, Character_DATA
where Player_DATA.PlayerUID = Character_DATA.PlayerUID
and Character_DATA.Alive = 1");
        $map2 = array("
select Player_DATA.playerName as name, Player_DATA.playerUID,
Character_DATA.PlayerUID as unique_id,
Character_DATA.CharacterID as cid,
Character_DATA.Worldspace as worldspace,
Character_DATA.Model as model,
Character_DATA.KillsZ as zombie_kills,
Character_DATA.KillsB as bandit_kills,
Character_DATA.duration as survival_time,
Character_DATA.Generation as survival_attempts,
Character_DATA.currentState AS state,
Character_DATA.Humanity as humanity
from Player_DATA, Character_DATA
where Player_DATA.PlayerUID = Character_DATA.PlayerUID
and Character_DATA.Alive = 0");
		$map4 = array("SELECT Object_CLASSES.*,
		Object_DATA.ObjectID as id,
		Object_DATA.ObjectUID as uid,
		Object_DATA.Classname as class_name,
		Object_DATA.Worldspace as worldspace,
		Object_DATA.Damage as damage,
		Object_DATA.last_updated,
		Object_DATA.Fuel as fuel
		FROM Object_CLASSES, Object_DATA as Object_DATA  
		where Object_DATA.Classname = Object_CLASSES.Classname 
		and Object_DATA.Instance =  " . $iid . " and CharacterID = 0");
        $map5 = array("SELECT Object_CLASSES.*,
        Object_SPAWNS.ObjectUID as id,
        Object_SPAWNS.Hitpoints as parts,
        Object_SPAWNS.Inventory as inventory,
        Object_SPAWNS.Classname as class_name,
        Object_SPAWNS.Worldspace as worldspace
        FROM Object_CLASSES, Object_SPAWNS as Object_SPAWNS
        where Object_SPAWNS.Classname = Object_CLASSES.Classname");
		$map6 = array("SELECT od.ObjectID as id, od.ObjectUID as idid, od.Classname, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, od.last_updated,pd.playerName AS name, pd.playerUID AS unique_id,oc.Type FROM Object_DATA od LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE od.Classname IN ('TentStorage','StashSmall','StashMedium') AND od.Instance = ?", $iid);
		$map7 = array("SELECT od.ObjectID as id, od.ObjectUID as idid, od.Classname, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, od.last_updated,pd.playerName AS name, pd.playerUID AS unique_id,oc.Type FROM Object_DATA od LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE od.Classname IN ('Hedgehog_DZ','Sandbag1_DZ','TrapBear','Wire_cat1') AND od.Instance = ?", $iid);
		$map8_players = array("select Player_DATA.playerName as name, Player_DATA.playerUID, 
Character_DATA.PlayerUID as unique_id, 
Character_DATA.CharacterID as cid,
Character_DATA.Worldspace as worldspace, 
Character_DATA.Model as model, 
Character_DATA.KillsZ as zombie_kills,
Character_DATA.KillsB as bandit_kills, 
Character_DATA.duration as survival_time,
Character_DATA.Generation as survival_attempts,
Character_DATA.currentState AS state,
Character_DATA.Humanity as humanity
from Player_DATA, Character_DATA 
where Player_DATA.PlayerUID = Character_DATA.PlayerUID 
and Character_DATA.Alive = 1 
and Character_DATA.last_updated >= NOW() - INTERVAL 1 minute");
		$map8_vehicles = array("SELECT Object_CLASSES.*,
		Object_DATA.ObjectID as id,
		Object_DATA.ObjectUID as uid,
		Object_DATA.Classname as class_name,
		Object_DATA.Worldspace as worldspace,
		Object_DATA.Damage as damage,
		Object_DATA.last_updated,
		Object_DATA.Fuel as fuel
		FROM Object_CLASSES, Object_DATA as Object_DATA  
		where Object_DATA.Classname = Object_CLASSES.Classname 
		and Object_DATA.Instance =  " . $iid . " and CharacterID = 0");
		$map8_objects = array("SELECT od.ObjectID as id, od.ObjectUID as idid, od.Classname, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, od.last_updated,pd.playerName AS name, pd.playerUID AS unique_id,oc.Type FROM Object_DATA od LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE od.Classname IN ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1', 'TentStorage','StashSmall','StashMedium') AND od.Instance = ". $iid);
        // Tables
        $table0 = array("SELECT pd.playerName as name, pd.playerUID as unique_id, cd.CharacterID AS cid, cd.Backpack as backpack, cd.Inventory as inventory, cd.Worldspace as worldspace FROM Player_DATA pd JOIN Character_DATA cd ON cd.PlayerUID = pd.PlayerUID WHERE pd.playerName = ? ORDER BY cd.last_updated DESC LIMIT 1");
        $table1 = array("SELECT pd.playerName as name, pd.playerUID as unique_id, cd.CharacterID AS cid, cd.Backpack as backpack, cd.Inventory as inventory, cd.Worldspace as worldspace FROM Player_DATA pd JOIN Character_DATA cd ON cd.PlayerUID = pd.PlayerUID WHERE cd.Alive = 1");
        $table2 = array("SELECT pd.playerName as name, pd.playerUID as unique_id, cd.CharacterID AS cid, cd.Backpack as backpack, cd.Inventory as inventory, cd.Worldspace as worldspace FROM Player_DATA pd JOIN Character_DATA cd ON cd.PlayerUID = pd.PlayerUID WHERE cd.Alive = 0");
        $table3 = array("SELECT pd.playerName as name, pd.playerUID as unique_id, cd.CharacterID AS cid, cd.Backpack as backpack, cd.Inventory as inventory, cd.Worldspace as worldspace FROM Player_DATA pd JOIN Character_DATA cd ON cd.PlayerUID = pd.PlayerUID");
        $table4 = array("SELECT od.ObjectID as id, od.ObjectUID as unique_id, od.Classname AS class_name, od.Damage AS damage, od.Hitpoints AS parts, od.Inventory AS inventory, od.Worldspace AS worldspace FROM Object_DATA od JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck') AND od.Instance = ?", $iid);
        $table5 = array("SELECT od.Classname as otype, oc.Type as type, od.ObjectID as id, od.Worldspace as pos FROM Object_DATA od JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck') AND od.Instance = ?", $iid);
        $table6 = array("SELECT od.ObjectID as id, od.ObjectUID as idid, od.Classname AS class_name, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, od.last_updated,pd.playerName AS name, pd.playerUID AS unique_id, oc.Type, cd.CharacterID AS cid FROM Object_DATA od LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE od.Classname IN ('TentStorage','StashSmall','StashMedium') AND od.Instance = ?", $iid);
        $table7 = array("SELECT od.ObjectID as id, od.ObjectUID as idid, od.Classname AS class_name, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, od.last_updated,pd.playerName AS name, pd.playerUID AS unique_id, oc.Type, cd.CharacterID AS cid FROM Object_DATA od LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE od.Classname IN ('Hedgehog_DZ', 'Sandbag1_DZ', 'TrapBear', 'Wire_cat1') AND od.Instance = ?", $iid);
        // Check
        $check_player = "SELECT pd.playerName as name, pd.playerUID as unique_id, cd.CharacterID AS cid, cd.Backpack as backpack, cd.Inventory as inventory, cd.Worldspace as worldspace FROM Player_DATA pd JOIN Character_DATA cd ON cd.PlayerUID = pd.PlayerUID";
        $check_deployable = array("SELECT od.ObjectID as id, od.ObjectUID as instance_deployable_id, od.Classname AS class_name, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, pd.playerName AS owner_name, pd.playerUID AS owner_unique_id FROM Object_DATA od LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID WHERE od.Classname IN ('TentStorage','SmallStash','MediumStash') AND od.Instance = ?", $iid);
        $check_vehicle = array("SELECT od.ObjectID as id, od.ObjectUID as instance_vehicle_id, od.Classname AS class_name, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace FROM Object_DATA od JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck') AND od.Instance = ?", $iid);
    //Leaderboard
        $leaderboard_query = "SELECT pd.playerName,cd.Generation,cd.KillsZ,cd.KillsB,cd.KillsH,cd.HeadshotsZ,Humanity FROM Character_DATA cd LEFT JOIN Player_DATA pd ON pd.playerUID = cd.playerUID";
        $leaderboard_Playername = "playerName";
        $leaderboard_Deaths = "Generation";
        $leaderboard_KillsZ = "KillsZ";
        $leaderboard_KillsB = "KillsB";
        $leaderboard_KillsH = "KillsH";
        $leaderboard_Headshots = "HeadshotsZ";
        $leaderboard_Humanity = "Humanity";
    // Search
        $search_query_player = "SELECT pd.playerName as name, pd.playerUID as unique_id, cd.CharacterID AS cid, cd.Backpack as backpack, cd.Inventory as inventory, cd.Worldspace as worldspace FROM Player_DATA pd JOIN Character_DATA cd ON cd.PlayerUID = pd.PlayerUID WHERE cd.Alive = 1 AND pd.playerName LIKE ?";
        $search_query_item = "SELECT pd.playerName as name, pd.playerUID as unique_id, cd.CharacterID AS cid, cd.Backpack as backpack, cd.Inventory as inventory, cd.Worldspace as worldspace FROM Player_DATA pd JOIN Character_DATA cd ON cd.PlayerUID = pd.PlayerUID WHERE cd.Alive = 1 AND (Inventory LIKE ? OR Backpack LIKE ?)";
        $search_query_vehicle = "SELECT od.ObjectID as id, od.ObjectUID as unique_id, od.Classname AS class_name, od.Damage AS damage, od.Inventory AS inventory, od.Worldspace AS worldspace, od.Hitpoints AS parts FROM Object_DATA od JOIN Object_CLASSES oc on oc.Classname = od.Classname WHERE oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck') AND od.Instance = ? AND od.Classname LIKE ?";
        $search_query_container = "SELECT od.ObjectID as id, od.ObjectUID as unique_id, od.Classname AS class_name, od.Damage AS damage, od.Inventory AS inventory, od.Hitpoints AS parts, od.Worldspace AS worldspace,pd.playerName AS name, pd.playerUID AS unique_id, cd.CharacterID AS cid FROM Object_DATA od JOIN Object_CLASSES oc on oc.Classname = od.Classname LEFT OUTER JOIN Character_DATA cd ON cd.CharacterID = od.CharacterID LEFT OUTER JOIN Player_DATA pd ON pd.PlayerUID = cd.playerUID WHERE od.Instance = ? AND od.Inventory LIKE ?";

	break;
};
?>
