<?php


if (isset($_SESSION['user_id']))
{	
$cid = $_GET["cid"];
	//if (isset($_GET["url"])){
		if (isset($_GET["kick"]) && isset($_GET["reason"])){
			$cmd = "kick ".$_GET["kick"]." ".$_GET["reason"];
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Player Kicked',?,NOW())", $_SESSION['login']);
			$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=table&show=0';
			</script>
			<?php
		}
		if (isset($_GET["ban"]) && isset($_GET["minutes"]) && isset($_GET["reason"])){
			$cmd = "ban ".$_GET["ban"]." ".$_GET["minutes"]." ".$_GET["reason"];
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Player Banned',?,NOW())", $_SESSION['login']);
			$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=table&show=0';
			</script>
			<?php
		}	
		if (isset($_POST["say"])){
			$id = "-1";
			if (isset($_GET["id"])){
				$id = $_GET["id"];
			}
			$cmd = "Say ".$id." ".$_POST["say"];
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Used Global',?,NOW())", $_SESSION['login']);
			$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'admin.php';
			</script>
			<?php
		}
		if (isset($_GET["delete"])){

			$db->Execute("Delete FROM objects WHERE id = ?", $_GET["delete"]);
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Removed Object ?',?,NOW())", array($db->qstr($_GET["delete"]), $_SESSION['login']));
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=map&show=7';
			</script>
			<?php
		}
		if (isset($_GET["deletecheck"])){

			$db->Execute("delete from id using instance_deployable id join survivor s on id.owner_id = s.id where s.id = ?", $_GET["deletecheck"]);
			$db->Execute("Delete FROM survivor WHERE id = ?", $_GET["deletecheck"]);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=check';
			</script>
			<?php
		}
		if (isset($_GET["deletespawns"])){

			$db->Execute("Delete FROM spawns WHERE ObjectID = ?", $_GET["deletespawns"]);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=map&show=8';
			</script>
			<?php
		}
		if (isset($_GET["resetlocation"])){

			$db->Execute("update survivor set worldspace = '[]' WHERE id = ?", $_GET["resetlocation"]);
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Reset Player Location of ID: ?,?,NOW())", array($_GET["resetlocation"], $_SESSION['login']));
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=table&show=0';
			</script>
			<?php
		}		
		if (isset($_GET["repairVehicle"])){
			$db->Execute("UPDATE instance_vehicle SET parts = '[]', damage = 0 WHERE id = ?", $_GET["repairVehicle"]);
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Repaired vehicle id: ?,?,NOW())", array($_GET["repairVehicle"], $_SESSION['login']));
			?>
			<script type="text/javascript">
                window.location = 'admin.php?view=info&show=4&id=<?php echo $_GET["repairVehicle"]; ?>';
            </script>
			<?php
		}
		if (isset($_GET["destroyVehicle"])){
            $db->Execute("UPDATE instance_vehicle SET damage = 1 WHERE id = ?", $_GET["destroyVehicle"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Destroyed vehicle id: ?,?,NOW())", array($_GET["destroyVehicle"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=4&id=<?php echo $_GET["destroyVehicle"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["healPlayer"])){
            $db->Execute("UPDATE survivor SET medical = '[false,false,false,false,false,false,false,12000,[],[0,0],0,[0,0]]' WHERE unique_id = ? AND is_dead = 0", $_GET["healPlayer"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Healed player id: ?,?,NOW())", array($_GET["healPlayer"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["healPlayer"]; ?>&cid=<?php echo $_GET["cid"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["killPlayer"])){
            $db->Execute("UPDATE survivor SET is_dead = '1' WHERE unique_id = ? AND id = $cid AND is_dead = 0", $_GET["killPlayer"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Killed player id: ?,?,NOW())", array($_GET["killPlayer"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["killPlayer"]; ?>&cid=<?php echo $_GET["cid"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["revivePlayer"])){
            $db->Execute("UPDATE survivor SET is_dead = '0' WHERE unique_id = ? AND id = $cid AND is_dead = 1", $_GET["revivePlayer"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Revived player id: ?,?,NOW())", array($_GET["revivePlayer"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["revivePlayer"]; ?>&cid=<?php echo $_GET["cid"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["resetHumanity"])){
            $db->Execute("UPDATE profile SET humanity = '2500' WHERE unique_id = ?", $_GET["resetHumanity"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Reset humanity for player id: ?,?,NOW())", array($_GET["resetHumanity"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["resetHumanity"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportNE"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[12509.9,12602.2,0.00144958]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportNE"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(NEAF) player id: ?,?,NOW())", array($_GET["teleportNE"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportNE"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportStary"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[6421.79,7745.49,0.00115967]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportStary"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(Stary) playerid: ?,?,NOW())", array($_GET["teleportStary"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportStary"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportNW"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[4937.24,9709.31,0.00143433]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportNW"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(NWAF) playerid: ?,?,NOW())", array($_GET["teleportNW"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportNW"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportCherno"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[7072.14,2166.65,0.00130177]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportCherno"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(Cherno) playerid: ?,?,NOW())", array($_GET["teleportCherno"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportCherno"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportElektro"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[10017.2,1634.3,0.00123644]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportElektro"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(Elektro) playerid: ?,?,NOW())", array($_GET["teleportElektro"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportElektro"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportSkalisty"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[13686.5,2911.2,0.00140381]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportSkalisty"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(Skalisty) playerid: ?,?,NOW())", array($_GET["teleportSkalisty"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportSkalisty"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportBerezino"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[11796.5,8846.02,0.00179291]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportBerezino"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(Berezino) playerid: ?,?,NOW())", array($_GET["teleportBerezino"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportBerezino"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportSolnichniy"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[13225.4,7177.08,0.00147486]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportSolnichniy"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(Solnichniy) playerid: ?,?,NOW())", array($_GET["teleportSolnichniy"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportSolnichniy"]; ?>';
            </script>
            <?php
        }
		if (isset($_GET["teleportPolana"])){
            $db->Execute("UPDATE survivor SET worldspace = '[0,[11463.8,7484.06,0.00140381]]' WHERE is_dead = 0 AND unique_id = ?", $_GET["teleportPolana"]);
            $db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Teleported(Polana) playerid: ?,?,NOW())", array($_GET["teleportPolana"], $_SESSION['login']));
            ?>
            <script type="text/javascript">
                window.location = 'admin.php?view=info&show=1&id=<?php echo $_GET["teleportPolana"]; ?>';
            </script>
            <?php
        }
		
		
	//}
	?>
	<script type="text/javascript">
		window.location = 'admin.php';
	</script>
	<?php

	
	
}
else
{
	header('Location: admin.php');
}
?>
