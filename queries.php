<?php
include ('config.php');

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Access lvls
    $accesslvlname = $db->GetOne("SELECT accesslvl FROM users WHERE id = ?", $user_id);
    $accesslvltable = $db->GetAll("SELECT * FROM accesslvl WHERE name = ?", $accesslvlname);
    $accesslvls = $accesslvltable[0]['access'];
    $accesslvls = str_replace("|", ",", $accesslvls);
    $accesslvls = json_decode($accesslvls);
    $accesslvls = array($accesslvls);
}

//Index
$stats_totalAlive = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1";
$stats_totalplayers = "SELECT COUNT(*) FROM Player_DATA";
$stats_deaths = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 0";
$stats_alivebandits = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Model = 'Bandit1_DZ'";
$stats_aliveheros = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Model = 'Survivor3_DZ'";
$stats_totalVehicles = array("SELECT COUNT(*) FROM Object_DATA WHERE Instance = ? AND CharacterID = '0'", $iid);
$stats_Played24h = "SELECT COUNT(*) FROM (SELECT COUNT(*) FROM Character_DATA WHERE LastLogin > NOW() - INTERVAL 1 DAY GROUP BY PlayerUID) uniqueplayers";
$stats_totalkills = "SELECT * FROM Character_DATA";

//Info
if(isset($_GET['cid']) && $_GET['cid'] > 0) {
	$info1 = array("
SELECT
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
FROM
	Player_DATA, Character_DATA
WHERE
	Character_DATA.playerUID = Player_DATA.playerUID
AND
    Player_DATA.PlayerUID = ?
AND Character_DATA.CharacterID = ?
", array($_GET["id"], $_GET["cid"]));
} else {
$info1 = array("
SELECT
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
FROM
	Player_DATA, Character_DATA
WHERE
	Character_DATA.playerUID = Player_DATA.playerUID
AND	Character_DATA.Alive = 1 AND Player_DATA.PlayerUID = ?
", isset($_GET["id"]) ? $_GET['id'] : 0);
}

$info4 = array("
SELECT
	Object_CLASSES.*,
	Object_DATA.ObjectID as id,
	Object_DATA.Hitpoints as parts,
	Object_DATA.Inventory as inventory,
	Object_DATA.ObjectUID as uid,
	Object_DATA.Classname as class_name,
	Object_DATA.Worldspace as worldspace,
	Object_DATA.Damage as damage,
	Object_DATA.last_updated,
	Object_DATA.Fuel as fuel
FROM
	Object_CLASSES, Object_DATA as Object_DATA
WHERE
	Object_DATA.Classname = Object_CLASSES.Classname
AND Object_DATA.ObjectID = ?
AND Object_DATA.Instance =  ? and CharacterID = 0
", array(isset($_REQUEST["id"]) ? $_REQUEST["id"] : 0, $iid));

$info5 = array("
SELECT
	*
FROM
	Object_SPAWNS
WHERE
	ObjectUID = ?
AND Instance = ?
", array(isset($_GET["id"]) ? $_REQUEST["id"] : 0, $iid));

$info6 = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as idid,
	od.Classname,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	od.last_updated,
	pd.playerName AS name,
	pd.playerUID AS unique_id,
	oc.Classname AS class_name,
	cd.CharacterID AS cid,
	oc.Type
FROM
	Object_DATA od
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd
ON
	pd.PlayerUID = cd.playerUID
JOIN
	Object_CLASSES oc ON oc.Classname = od.Classname
WHERE
	od.Classname IN ('TentStorage','StashSmall','StashMedium')
AND od.ObjectID = ?
AND od.Instance = ?
", array(isset($_GET["id"]) ? $_REQUEST["id"] : 0, $iid));

//Map
$map0 = array("
SELECT
	Player_DATA.playerName as name,
	Player_DATA.playerUID,
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
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 1
AND Character_DATA.last_updated >= NOW() - INTERVAL 1 minute
");

$map1 = array("
SELECT
	Player_DATA.playerName as name,
	Player_DATA.playerUID,
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
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 1
");

$map2 = array("
SELECT
	Player_DATA.playerName as name, Player_DATA.playerUID,
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
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 0
");

$map4 = array("
SELECT
	Object_CLASSES.*,
	Object_DATA.ObjectID as id,
	Object_DATA.ObjectUID as uid,
	Object_DATA.Classname as class_name,
	Object_DATA.Worldspace as worldspace,
	Object_DATA.Damage as damage,
	Object_DATA.last_updated,
	Object_DATA.Fuel as fuel
FROM
	Object_CLASSES, Object_DATA as Object_DATA
WHERE
	Object_DATA.Classname = Object_CLASSES.Classname
AND Object_DATA.Instance =  " . $iid . " and CharacterID = 0");

$map5 = array("
SELECT
	Object_CLASSES.*,
	Object_SPAWNS.ObjectUID as id,
	Object_SPAWNS.Hitpoints as parts,
	Object_SPAWNS.Inventory as inventory,
	Object_SPAWNS.Classname as class_name,
	Object_SPAWNS.Worldspace as worldspace
FROM
	Object_CLASSES, Object_SPAWNS as Object_SPAWNS
WHERE
	Object_SPAWNS.Classname = Object_CLASSES.Classname
");

$map6 = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as idid,
	od.Classname,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	od.last_updated,
	pd.playerName AS name,
	pd.playerUID AS unique_id,
	oc.Type
FROM
	Object_DATA od
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd
ON
	pd.PlayerUID = cd.playerUID
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE od.Classname IN ('TentStorage','StashSmall','StashMedium') AND od.Instance = ?
", $iid);

$map7 = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as idid,
	od.Classname,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	od.last_updated,
	pd.playerName AS name,
	pd.playerUID AS unique_id,
	oc.Type
FROM
	Object_DATA od
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd
ON
	pd.PlayerUID = cd.playerUID
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE od.Classname IN ('Hedgehog_DZ','Sandbag1_DZ','TrapBear','Wire_cat1') AND od.Instance = ?
", $iid);

$map8_players = array("
SELECT
	Player_DATA.playerName as name,
	Player_DATA.playerUID,
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
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 1
AND Character_DATA.last_updated >= NOW() - INTERVAL 1 minute
");

$map8_vehicles = array("
SELECT
	Object_CLASSES.*,
	Object_DATA.ObjectID as id,
	Object_DATA.ObjectUID as uid,
	Object_DATA.Classname as class_name,
	Object_DATA.Worldspace as worldspace,
	Object_DATA.Damage as damage,
	Object_DATA.last_updated,
	Object_DATA.Fuel as fuel
FROM
	Object_CLASSES, Object_DATA as Object_DATA
WHERE
	Object_DATA.Classname = Object_CLASSES.Classname
AND Object_DATA.Instance =  " . $iid . " and CharacterID = 0
");

$map8_objects = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as idid,
	od.Classname,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	od.last_updated,
	pd.playerName AS name,
	pd.playerUID AS unique_id,
	oc.Type
FROM
	Object_DATA od
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd ON pd.PlayerUID = cd.playerUID
JOIN
	Object_CLASSES oc on oc.Classname = od.Classname
WHERE
	od.Classname IN ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1', 'TentStorage','StashSmall','StashMedium') AND od.Instance = ". $iid
);

// Tables
$table0 = array("
SELECT
	pd.playerName as name,
	pd.playerUID as unique_id,
	cd.CharacterID AS cid,
	cd.Backpack as backpack,
	cd.Inventory as inventory,
	cd.Worldspace as worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
WHERE
	pd.playerName = ?
ORDER BY
	cd.last_updated DESC
LIMIT 1
");

$table1 = array("
SELECT
	pd.playerName as name,
	pd.playerUID as unique_id,
	cd.CharacterID AS cid,
	cd.Backpack as backpack,
	cd.Inventory as inventory,
	cd.Worldspace as worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
WHERE
	cd.Alive = 1
");

$table2 = array("
SELECT
	pd.playerName as name,
	pd.playerUID as unique_id,
	cd.CharacterID AS cid,
	cd.Backpack as backpack,
	cd.Inventory as inventory,
	cd.Worldspace as worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
WHERE
	cd.Alive = 0
");

$table3 = array("
SELECT
	pd.playerName as name,
	pd.playerUID as unique_id,
	cd.CharacterID AS cid,
	cd.Backpack as backpack,
	cd.Inventory as inventory,
	cd.Worldspace as worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
");

$table4 = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as unique_id,
	od.Classname AS class_name,
	od.Damage AS damage,
	od.Hitpoints AS parts,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace
FROM
	Object_DATA od
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck')
AND od.Instance = ?
", $iid);

$table5 = array("
SELECT
	od.Classname as otype,
	oc.Type as type,
	od.ObjectID as id,
	od.Worldspace as pos
FROM
	Object_DATA od
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck') AND od.Instance = ?
", $iid);

$table6 = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as idid,
	od.Classname AS class_name,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	od.last_updated,
	pd.playerName AS name,
	pd.playerUID AS unique_id,
	oc.Type,
	cd.CharacterID AS cid
FROM
	Object_DATA od
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd ON pd.PlayerUID = cd.playerUID
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	od.Classname IN ('TentStorage','StashSmall','StashMedium') AND od.Instance = ?
", $iid);

$table7 = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as idid,
	od.Classname AS class_name,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	od.last_updated,
	pd.playerName AS name,
	pd.playerUID AS unique_id,
	oc.Type,
	cd.CharacterID AS cid
FROM
	Object_DATA od
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd
ON
	pd.PlayerUID = cd.playerUID
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	od.Classname IN ('Hedgehog_DZ', 'Sandbag1_DZ', 'TrapBear', 'Wire_cat1') AND od.Instance = ?
", $iid);

// Check
$check_player = "
SELECT
	pd.playerName as name,
	pd.playerUID as unique_id,
	cd.CharacterID AS cid,
	cd.Backpack as backpack,
	cd.Inventory as inventory,
	cd.Worldspace as worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
";

$check_deployable = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as instance_deployable_id,
	od.Classname AS class_name,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	pd.playerName AS owner_name,
	pd.playerUID AS owner_unique_id
FROM
	Object_DATA od
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd
ON
	pd.PlayerUID = cd.playerUID
WHERE
	od.Classname IN ('TentStorage','SmallStash','MediumStash')
AND od.Instance = ?
", $iid);

$check_vehicle = array("
SELECT
	od.ObjectID as id,
	od.ObjectUID as instance_vehicle_id,
	od.Classname AS class_name,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace
FROM
	Object_DATA od
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck')
AND od.Instance = ?
", $iid);

//Leaderboard
$leaderboard_query = "
SELECT
	pd.playerName,
	pd.playerUID,
    cd.CharacterID,
	cd.Generation,
	cd.KillsZ,
	cd.KillsB,
	cd.KillsH,
	cd.HeadshotsZ,
	Humanity
FROM
	Character_DATA cd
LEFT JOIN
	Player_DATA pd
ON
	pd.playerUID = cd.PlayerUID
";

$leaderboard_Playername = "playerName";

$leaderboard_Deaths = "Generation";

$leaderboard_KillsZ = "KillsZ";

$leaderboard_KillsB = "KillsB";

$leaderboard_KillsH = "KillsH";

$leaderboard_Headshots = "HeadshotsZ";

$leaderboard_Humanity = "Humanity";

// Search
$search_query_player = "
SELECT
	pd.playerName as name,
	pd.playerUID as unique_id,
	cd.CharacterID AS cid,
	cd.Backpack as backpack,
	cd.Inventory as inventory,
	cd.Worldspace as worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
WHERE
	cd.Alive = 1
AND pd.playerName LIKE ?
";

$search_query_item = "
SELECT
	pd.playerName as name,
	pd.playerUID as unique_id,
	cd.CharacterID AS cid,
	cd.Backpack as backpack,
	cd.Inventory as inventory,
	cd.Worldspace as worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
WHERE
	cd.Alive = 1
AND (Inventory LIKE ? OR Backpack LIKE ?)
";

$search_query_vehicle = "
SELECT
	od.ObjectID as id,
	od.ObjectUID as unique_id,
	od.Classname AS class_name,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Worldspace AS worldspace,
	od.Hitpoints AS parts
FROM
	Object_DATA od
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck')
AND od.Instance = ?
AND od.Classname LIKE ?
";

$search_query_container = "
SELECT
	od.ObjectID as id,
	od.ObjectUID as unique_id,
	od.Classname AS class_name,
	od.Damage AS damage,
	od.Inventory AS inventory,
	od.Hitpoints AS parts,
	od.Worldspace AS worldspace,
	pd.playerName AS name,
	pd.playerUID AS unique_id,
	cd.CharacterID AS cid
FROM
	Object_DATA od
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
LEFT OUTER JOIN
	Character_DATA cd
ON
	cd.CharacterID = od.CharacterID
LEFT OUTER JOIN
	Player_DATA pd
ON
	pd.PlayerUID = cd.playerUID
WHERE
	od.Instance = ?
AND od.Inventory LIKE ?
";

?>
