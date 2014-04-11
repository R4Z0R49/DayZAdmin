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
$stats_totalwalked = "SELECT SUM(distanceFoot),(SELECT SUM(distanceFoot) FROM Character_DATA) FROM Character_DEAD";
$stats_duration = "
SELECT 
	CONCAT(FLOOR(AVG(`duration`)/60), 'h ', MOD(ROUND(AVG(`duration`)),60),'m')
FROM
	Character_DEAD 
UNION ALL
	SELECT CONCAT(FLOOR(AVG(`duration`)/60), 'h ', MOD(ROUND(AVG(`duration`)),60),'m')
FROM
	Character_DATA
WHERE 
	duration > 15 AND Alive = 0;
";

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
UNION
SELECT
    pd.playerName,
    pd.playerUID,
    pd.playerSex,
    cdd.*
FROM
    Character_DEAD cdd
JOIN
    Player_DATA pd
ON
    cdd.playerUID = pd.playerUID
WHERE
    cdd.CharacterID = ?
";

$info4 = "
SELECT
	od.*
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
	cd.*,
	pd.playerName,
	pd.playerUID
FROM
	Character_DATA cd
JOIN
    Player_DATA pd
ON
    pd.playerUID = cd.PlayerUID
WHERE
    cd.Alive = 1
AND cd.last_updated >= NOW() - INTERVAL 1 minute
";

$map1 = "
SELECT
    cd.*,
    pd.playerName,
    pd.playerUID
FROM
    Character_DATA cd
JOIN
    Player_DATA pd
ON
    pd.playerUID = cd.PlayerUID
WHERE
    cd.Alive = 1
";

$map2 = "
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

$map3 = "
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
";

$map4 = "
SELECT
    od.*,
    oc.Type
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

$map5 = "
SELECT
    os.ObjectUID AS ObjectID,
    os.Last_changed AS last_updated,
    os.*,
    oc.Type
FROM
    Object_SPAWNS os
JOIN
    Object_CLASSES oc
ON
    os.Classname = oc.Classname
WHERE
    oc.Type IN ('atv','bike','car','farmvehicle','helicopter','largeboat','mediumboat','motorcycle','plane','smallboat','truck')
";

$map6 = "
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
    od.Classname IN ('TentStorage','StashSmall','StashMedium')
AND od.Instance = ?
";

$map7 = "
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
    od.Classname IN ('Hedgehog_DZ', 'Sandbag1_DZ', 'BearTrap_DZ', 'Wire_cat1', 'TrapBearTrapFlare', 'TrapBearTrapSmoke', 'TrapTripwireCans', 'TrapTripwireFlare', 'TrapTripwireGrenade', 'TrapTripwireSmoke')
AND od.Instance = ?
";

$map8_players = $map0;

$map8_vehicles = $map4;

$map8_deployables = "
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
    od.Classname IN ('TentStorage','StashSmall','StashMedium', 'Hedgehog_DZ', 'Sandbag1_DZ', 'BearTrap_DZ', 'Wire_cat1', 'TrapBearTrapFlare', 'TrapBearTrapSmoke', 'TrapTripwireCans', 'TrapTripwireFlare', 'TrapTripwireGrenade', 'TrapTripwireSmoke')
AND od.Instance = ?

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
	od.Classname IN ('TentStorage','StashSmall','StashMedium')
AND od.Instance = ?
";

$table7 = "
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
	od.Classname IN ('Hedgehog_DZ', 'Sandbag1_DZ', 'TrapBear', 'Wire_cat1', 'ItemTrapBearTrapFlare', 'ItemTrapBearTrapSmoke', 'ItemTrapTripwireCans', 'ItemTrapTripwireFlare', 'ItemTrapTripwireGrenade', 'ItemTrapTripwireSmoke')
AND od.Instance = ?
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
where
	Alive like 1
";

// Search
$search_query_player = "
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
    pd.playerName LIKE ?
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
    pd.playerName LIKE ?
ORDER BY
    last_updated DESC
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
