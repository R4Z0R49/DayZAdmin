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

// Stats
$stats_totalAlive = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1";
$stats_totalplayers = "SELECT COUNT(*) FROM Player_DATA";
$stats_deaths = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 0";
$stats_alivebandits = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Humanity < -2000";
$stats_aliveheros = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Humanity > 5000";
$stats_totalVehicles = array("SELECT COUNT(*) FROM Object_DATA WHERE Instance = ? AND CharacterID = '0'", $iid);
$stats_Played24h = "SELECT COUNT(*) FROM (SELECT COUNT(*) FROM Character_DATA WHERE LastLogin > NOW() - INTERVAL 1 DAY GROUP BY PlayerUID) uniqueplayers";
$stats_totalkills = "SELECT * FROM Character_DATA";

// Info
$info1 = "
SELECT
    pd.playerName,
    pd.playerUID,
    pd.playerSex,
    cd.*
FROM
    Character_DATA cd
JOIN
    Player_DATA pd
ON
    cd.playerUID = pd.playerUID
WHERE
    cd.CharacterID = ?
";

$info4 = "
SELECT
	od.*,
    oc.*
FROM
	Object_DATA od
JOIN
    Object_CLASSES oc
ON
    od.Classname = oc.Classname
WHERE
    od.ObjectID = ?
AND od.Instance =  ?
AND od.CharacterID = 0
";

$info5 = "
SELECT
	*
FROM
	Object_SPAWNS
WHERE
	ObjectUID = ?
";

$info6 = "
SELECT
	od.*,
	pd.playerName,
	pd.playerUID,
	oc.Classname,
	cd.CharacterID,
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
";

// Map
$map0 = "
SELECT
	Player_DATA.playerName AS name,
	Player_DATA.playerUID,
	Character_DATA.PlayerUID AS unique_id,
	Character_DATA.CharacterID AS cid,
	Character_DATA.Worldspace AS worldspace,
	Character_DATA.Model AS model,
	Character_DATA.KillsZ AS zombie_kills,
	Character_DATA.KillsB AS bandit_kills,
	Character_DATA.duration AS survival_time,
	Character_DATA.Generation AS survival_attempts,
	Character_DATA.currentState AS state,
	Character_DATA.Humanity AS humanity
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 1
AND Character_DATA.last_updated >= NOW() - INTERVAL 1 minute
";

$map1 = "
SELECT
	Player_DATA.playerName AS name,
	Player_DATA.playerUID,
	Character_DATA.PlayerUID AS unique_id,
	Character_DATA.CharacterID AS cid,
	Character_DATA.Worldspace AS worldspace,
	Character_DATA.Model AS model,
	Character_DATA.KillsZ AS zombie_kills,
	Character_DATA.KillsB AS bandit_kills,
	Character_DATA.duration AS survival_time,
	Character_DATA.Generation AS survival_attempts,
	Character_DATA.currentState AS state,
	Character_DATA.Humanity AS humanity
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 1
";

$map2 = "
SELECT
	Player_DATA.playerName AS name, Player_DATA.playerUID,
	Character_DATA.PlayerUID AS unique_id,
	Character_DATA.CharacterID AS cid,
	Character_DATA.Worldspace AS worldspace,
	Character_DATA.Model AS model,
	Character_DATA.KillsZ AS zombie_kills,
	Character_DATA.KillsB AS bandit_kills,
	Character_DATA.duration AS survival_time,
	Character_DATA.Generation AS survival_attempts,
	Character_DATA.currentState AS state,
	Character_DATA.Humanity AS humanity
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 0
";

$map4 = "
SELECT
	Object_CLASSES.*,
	Object_DATA.ObjectID AS id,
	Object_DATA.ObjectUID AS uid,
	Object_DATA.Classname AS class_name,
	Object_DATA.Worldspace AS worldspace,
	Object_DATA.Damage AS damage,
	Object_DATA.last_updated,
	Object_DATA.Fuel AS fuel
FROM
	Object_CLASSES, Object_DATA AS Object_DATA
WHERE
	Object_DATA.Classname = Object_CLASSES.Classname
AND Object_DATA.Instance = ? and CharacterID = 0
";

$map5 = "
SELECT
	Object_CLASSES.*,
	Object_SPAWNS.ObjectUID AS id,
	Object_SPAWNS.Hitpoints AS parts,
	Object_SPAWNS.Inventory AS inventory,
	Object_SPAWNS.Classname AS class_name,
	Object_SPAWNS.Worldspace AS worldspace
FROM
	Object_CLASSES, Object_SPAWNS AS Object_SPAWNS
WHERE
	Object_SPAWNS.Classname = Object_CLASSES.Classname
";

$map6 = "
SELECT
	od.ObjectID AS id,
	od.ObjectUID AS idid,
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
";

$map7 = "
SELECT
	od.ObjectID AS id,
	od.ObjectUID AS idid,
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
";

$map8_players = "
SELECT
	Player_DATA.playerName AS name,
	Player_DATA.playerUID,
	Character_DATA.PlayerUID AS unique_id,
	Character_DATA.CharacterID AS cid,
	Character_DATA.Worldspace AS worldspace,
	Character_DATA.Model AS model,
	Character_DATA.KillsZ AS zombie_kills,
	Character_DATA.KillsB AS bandit_kills,
	Character_DATA.duration AS survival_time,
	Character_DATA.Generation AS survival_attempts,
	Character_DATA.currentState AS state,
	Character_DATA.Humanity AS humanity
FROM
	Player_DATA, Character_DATA
WHERE
	Player_DATA.PlayerUID = Character_DATA.PlayerUID
AND Character_DATA.Alive = 1
AND Character_DATA.last_updated >= NOW() - INTERVAL 1 minute
";

$map8_vehicles = "
SELECT
	Object_CLASSES.*,
	Object_DATA.ObjectID AS id,
	Object_DATA.ObjectUID AS uid,
	Object_DATA.Classname AS class_name,
	Object_DATA.Worldspace AS worldspace,
	Object_DATA.Damage AS damage,
	Object_DATA.last_updated,
	Object_DATA.Fuel AS fuel
FROM
	Object_CLASSES, Object_DATA AS Object_DATA
WHERE
	Object_DATA.Classname = Object_CLASSES.Classname
AND Object_DATA.Instance = ? and CharacterID = 0
";

$map8_objects = "
SELECT
	od.ObjectID AS id,
	od.ObjectUID AS idid,
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
	od.Classname IN ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1', 'TentStorage','StashSmall','StashMedium') AND od.Instance = ?
";

// Tables
$table0 = "
SELECT
	pd.playerName,
	pd.playerUID,
	cd.*
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
";

$table1 = "
SELECT
	pd.playerName,
	pd.playerUID,
	cd.*
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.playerUID
WHERE
	cd.Alive = 1
";

$table2 = "
SELECT
    pd.playerName,
    pd.playerUID,
    cd.*
FROM
    Player_DATA pd
JOIN
    Character_DATA cd
ON
    cd.PlayerUID = pd.playerUID
WHERE
    cd.Alive = 0
UNION
SELECT
    pd.playerName,
    pd.playerUID,
    cdd.*
FROM
    Player_DATA pd
JOIN
    Character_DEAD cdd
ON
    cdd.PlayerUID = pd.playerUID
WHERE
    cdd.Alive = 0
";

$table3 = "
SELECT
    pd.playerName,
    pd.playerUID,
    cd.*
FROM
    Player_DATA pd
JOIN
    Character_DATA cd
ON
    cd.PlayerUID = pd.playerUID
UNION
SELECT
    pd.playerName,
    pd.playerUID,
    cdd.*
FROM
    Player_DATA pd
JOIN
    Character_DEAD cdd
ON
    cdd.PlayerUID = pd.playerUID
WHERE
    cdd.Alive = 0
";

$table4 = "
SELECT
	od.*
FROM
	Object_DATA od
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck')
AND
    od.Instance = ?
";

$table5 = "
SELECT
    os.*
FROM
    Object_SPAWNS os
JOIN
    Object_CLASSES oc
ON
    os.Classname = oc.Classname
WHERE
    oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck')
";

$table6 = "
SELECT
	od.*,
	pd.playerName,
	pd.playerUID,
	oc.Type,
	cd.CharacterID
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
	od.Classname IN ('TentStorage','StashSmall','StashMedium') AND od.Instance = ?
";

$table7 = "
SELECT
	od.*
	pd.playerName,
	pd.playerUID,
	oc.Type,
	cd.CharacterID
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
";

// Check Items
$check_player = "
SELECT
	pd.playerName,
	pd.playerUID,
	cd.CharacterID,
	cd.Backpack,
	cd.Inventory,
	cd.Worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
";

$check_deployable = "
SELECT
	od.*,
	pd.playerName,
	pd.playerUID
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
";

$check_vehicle = "
SELECT
	od.*
FROM
	Object_DATA od
JOIN
	Object_CLASSES oc
ON
	oc.Classname = od.Classname
WHERE
	oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck')
AND od.Instance = ?
";

// Leaderboard
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
	cd.Humanity
FROM
	Character_DATA cd
LEFT JOIN
	Player_DATA pd
ON
	pd.playerUID = cd.PlayerUID
";

// Search
$search_query_player = "
SELECT
	pd.playerName,
	pd.playerUID,
	cd.CharacterID,
	cd.Backpack,
	cd.Inventory,
	cd.Worldspace
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.PlayerUID
WHERE
	cd.Alive = 1
AND
    pd.playerName LIKE ?
";

$search_query_item = "
SELECT
	pd.playerName,
	pd.playerUID,
	cd.CharacterID,
	cd.Backpack,
	cd.Inventory,
	cd.Worldspace
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
	od.*
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
	od.*,
	pd.playerName,
	pd.playerUID,
	cd.CharacterID
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
