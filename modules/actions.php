<?php
if (isset($_SESSION['user_id']))
{	
	//if (isset($_GET["url"])){
		if (isset($_GET["kick"])){
			$cmd = "kick ".$_GET["kick"];
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Player Kicked',?,NOW())", $_SESSION['login']);
			$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=table&show=0';
			</script>
			<?php
		}
		if (isset($_GET["ban"])){
			$cmd = "ban ".$_GET["ban"];
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
