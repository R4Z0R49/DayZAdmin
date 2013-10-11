<?php


if (isset($_SESSION['user_id'])) {
    if(isset($_REQUEST['CharacterID'])) {
        $CharacterID = $_REQUEST['CharacterID'];
    } else {
        $CharacterID = 0;
    }

	if (isset($_REQUEST["kick"]) && isset($_REQUEST["reason"])){
		$cmd = "kick ".$_REQUEST["kick"]." ".$_REQUEST["reason"];
		$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Player ',?,' Kicked'),?,NOW())", array($_REQUEST["kick"], $_SESSION['login']));
		?>
		<script type="text/javascript">
			window.location = 'admin.php?view=table&show=0';
		</script>
		<?php
	}
	if (isset($_REQUEST["ban"]) && isset($_REQUEST["minutes"]) && isset($_REQUEST["reason"])){
		$cmd = "ban ".$_REQUEST["ban"]." ".$_REQUEST["minutes"]." ".$_REQUEST["reason"];
		$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Player ',?,' Banned'),?,NOW())", array($_REQUEST["ban"], $_SESSION['login']));
		?>
		<script type="text/javascript">
			window.location = 'admin.php?view=table&show=0';
		</script>
		<?php
	}	
	if (isset($_POST["say"])){
		$id = "-1";
		if (isset($_REQUEST["id"])){
			$id = $_REQUEST["id"];
		}
		$cmd = "Say ".$id." ".$_POST["say"];
		$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Used Global',?,NOW())", $_SESSION['login']);
		?>
		<script type="text/javascript">
			window.location = 'admin.php';
		</script>
		<?php
	}
	if (isset($_REQUEST["delete"])){

		$db->Execute("DELETE FROM Object_DATA WHERE ObjectID = ?", $_REQUEST["delete"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Removed Object ?',?,NOW())", array($db->qstr($_REQUEST["delete"]), $_SESSION['login']));
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Object ',?,' deleted'),?,NOW())", array($_REQUEST["delete"], $_SESSION['login']));
		?>
		<script type="text/javascript">
			window.location = 'admin.php?view=map&show=7';
		</script>
		<?php
	}
	if (isset($_REQUEST["deletecheck"])){

		$db->Execute("DELETE FROM Object_DATA WHERE CharacterID = ?", $_REQUEST["deletecheck"]);
		$db->Execute("DELETE FROM Character_DATA WHERE CharacterID = ?", $_REQUEST["deletecheck"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Player ',?,' deleted'),?,NOW())", array($_REQUEST["deletecheck"], $_SESSION['login']));
		?>
		<script type="text/javascript">
			window.location = 'admin.php?view=check';
		</script>
		<?php
	}
	if (isset($_REQUEST["deletespawns"])){

		$db->Execute("DELETE FROM Object_SPAWNS WHERE ObjectUID = ?", $_REQUEST["deletespawns"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Object spawn location ',?,' deleted'),?,NOW())", array($_REQUEST["deletespawns"], $_SESSION['login']));
		?>
		<script type="text/javascript">
			window.location = 'admin.php?view=map&show=8';
		</script>
		<?php
	}
	if (isset($_REQUEST["resetlocation"])){

		$db->Execute("UPDATE Character_DATA SET Worldspace = '[]' WHERE CharacterID = ?", $_REQUEST["resetlocation"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Reset location for player ',?),?,NOW())", array($_REQUEST["resetlocation"], $_SESSION['login']));
		?>
		<script type="text/javascript">
			window.location = 'admin.php?view=table&show=0';
		</script>
		<?php
	}		
// VEHICLES
	if (isset($_REQUEST["repairVehicle"])){
    	$db->Execute("UPDATE Object_DATA SET Hitpoints = '[]', Damage = 0 WHERE ObjectID = ?", $_REQUEST["repairVehicle"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Repaired vehicle ', ?),?,NOW())", array($_REQUEST["repairVehicle"], $_SESSION['login']));
		?>
		<script type="text/javascript">
               window.location = 'admin.php?view=info&show=4&ObjectID=<?php echo $_REQUEST["repairVehicle"]; ?>';
           </script>
		<?php
	}
	if (isset($_REQUEST["destroyVehicle"])){
        $db->Execute("UPDATE Object_DATA SET Damage = 1 WHERE ObjectID = ?", $_REQUEST["destroyVehicle"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Destroyed vehicle ', ?),?,NOW())", array($_REQUEST["destroyVehicle"], $_SESSION['login']));
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=4&ObjectID=<?php echo $_REQUEST["destroyVehicle"]; ?>';
        </script>
        <?php
    }
	if (isset($_REQUEST["refuelVehicle"])){
        $db->Execute("UPDATE Object_DATA SET Fuel = 1.0 WHERE ObjectID = ?", $_REQUEST["refuelVehicle"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Refueled vehicle ', ?),?,NOW())", array($_REQUEST["refuelVehicle"], $_SESSION['login']));
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=4&ObjectID=<?php echo $_REQUEST["refuelVehicle"]; ?>';
        </script>
        <?php
    }
//PLAYERS
	if (isset($_REQUEST["healPlayer"])){
        $db->Execute("UPDATE Character_DATA SET Medical = '[false,false,false,false,false,false,false,12000,[],[0,0],0,[0,0]]' WHERE CharacterID = ? AND Alive = 1", $CharacterID);
        $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Healed player ',?),?,NOW())", array($CharacterID, $_SESSION['login']));
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=1&CharacterID=<?php echo $CharacterID; ?>';
        </script>
        <?php
    }
	if (isset($_REQUEST["killPlayer"])){
        $db->Execute("UPDATE Character_DATA SET Alive = 0 WHERE CharacterID = ? AND Alive = 1", $CharacterID);
        $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Killed player ',?),?,NOW())", array($CharacterID, $_SESSION['login']));
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=1&CharacterID=<?php echo $CharacterID; ?>';
        </script>
        <?php
    }
	if (isset($_REQUEST["revivePlayer"])){
        $db->Execute("UPDATE Character_DATA SET Alive = 1 WHERE CharacterID = ? AND Alive = 0", $CharacterID);
        $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Revived player ',?),?,NOW())", array($CharacterID, $_SESSION['login']));
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=1&CharacterID=<?php echo $CharacterID; ?>';
        </script>
        <?php
    }
	if (isset($_REQUEST["resetHumanity"])){
        $db->Execute("UPDATE Character_DATA SET Humanity = 2500 WHERE CharacterID = ? AND Alive = 1", $CharacterID);
        $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Reset humanity for player ',?),?,NOW())", array($CharacterID, $_SESSION['login']));
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=1&CharacterID=<?php echo $CharacterID; ?>';
        </script>
        <?php
    }
// TELLEPORTS
	if (isset($_REQUEST["teleport"]) && isset($CharacterID)){
        $coordinates = array(
            'NEAF' => '[0,[12509.9,12602.2,0.00144958]]',
            'NWAF' => '[0,[4937.24,9709.31,0.00143433]]',
            'Stary' => '[0,[6421.79,7745.49,0.00115967]]',
            'Chernogorsk' => '[0,[7072.14,2166.65,0.00130177]]',
            'Elektrozavodsk' => '[0,[10017.2,1634.3,0.00123644]]',
            'Skalisty' => '[0,[13686.5,2911.2,0.00140381]]',
            'Berezino' => '[0,[11796.5,8846.02,0.00179291]]',
            'Solnichniy' => '[0,[13225.4,7177.08,0.00147486]]',
            'Polana' => '[0,[11463.8,7484.06,0.00140381]]'
        );

        if(array_key_exists($_REQUEST['teleport'], $coordinates)) {
            $db->Execute("UPDATE Character_DATA SET Worldspace = ?, last_updated = NOW() WHERE CharacterID = ? AND Alive = 1", array($coordinates[$_REQUEST["teleport"]], $CharacterID));
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Teleported player ',?,' to ',?),?,NOW())", array($CharacterID, $_REQUEST['teleport'], $_SESSION['login']));
        }
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=1&CharacterID=<?php echo $CharacterID; ?>';
        </script>
        <?php
    }
// SKINS
	if (isset($_REQUEST["skin"]) && isset($CharacterID)){
        $db->Execute("UPDATE Character_DATA SET Model = ? WHERE Alive = 1 AND CharacterID = ?", array($_REQUEST["skin"], $CharacterID));
        $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('Changed skin to ',?,' for player ',?,' to ',?),?,NOW())", array($_REQUEST['skin'], $CharacterID, $_SESSION['login']));
        ?>
        <script type="text/javascript">
            window.location = 'admin.php?view=info&show=1&CharacterID=<?php echo $CharacterID; ?>';
        </script>
        <?php
    }
//ADMIN ACTIONS
	if (isset($_REQUEST["clearLogs"])){
        $db->Execute("DELETE FROM logs", $_REQUEST["clearLogs"]);
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Cleared logs',?,NOW())", $_SESSION['login']);
        }
/*
	?>
	<script type="text/javascript">
		window.location = 'admin.php';
	</script>
	<?php
*/
}
else
{
	header('Location: admin.php');
}
?>
