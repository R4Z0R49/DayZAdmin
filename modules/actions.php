<?php
if (isset($_SESSION['user_id']))
{	
	//if (isset($_GET["url"])){
		if (isset($_GET["kick"])){
			$cmd = "kick ".$_GET["kick"];
			$query = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Player Kicked','{$_SESSION['login']}',NOW())";
			$sql2 = mysql_query($query) or die(mysql_error());
				
			$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=table&show=0';
			</script>
			<?php
		}
		if (isset($_GET["ban"])){
			$cmd = "ban ".$_GET["ban"];
			$query = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Player Banned','{$_SESSION['login']}',NOW())";
			$sql2 = mysql_query($query) or die(mysql_error());
				
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
			$query = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Used Global','{$_SESSION['login']}',NOW())";
			$sql2 = mysql_query($query) or die(mysql_error());
				
			$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
			?>
			<script type="text/javascript">
				window.location = 'admin.php';
			</script>
			<?php
		}
		if (isset($_GET["delete"])){

			$remquery = "Delete FROM objects WHERE id=".$_GET["delete"];
			$result = mysql_query($remquery) or die(mysql_error());
			$class = mysql_fetch_assoc($result);
			$query = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Removed Object ".$_GET["delete"]."','{$_SESSION['login']}',NOW())";
			$sql2 = mysql_query($query) or die(mysql_error());
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=map&show=7';
			</script>
			<?php
		}
		if (isset($_GET["deletecheck"])){

			$remquery = "delete from id using instance_deployable id join survivor s on id.owner_id = s.id where s.id = '".$_GET["deletecheck"]."'";
			$result = mysql_query($remquery) or die(mysql_error());
			$class = mysql_fetch_assoc($result);
			$remquery1 = "Delete FROM survivor WHERE id='".$_GET["deletecheck"]."'";
			$result1 = mysql_query($remquery1) or die(mysql_error());
			$class1 = mysql_fetch_assoc($result1);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=check';
			</script>
			<?php
		}
		if (isset($_GET["deletespawns"])){

			$remquery = "Delete FROM spawns WHERE ObjectID=".$_GET["deletespawns"];
			$result = mysql_query($remquery) or die(mysql_error());
			$class = mysql_fetch_assoc($result);
			?>
			<script type="text/javascript">
				window.location = 'admin.php?view=map&show=8';
			</script>
			<?php
		}
		if (isset($_GET["resetlocation"])){

			$remquery = "update survivor set pos = '[]' WHERE id='".$_GET["resetlocation"]."'";
			$result = mysql_query($remquery) or die(mysql_error());
			$class = mysql_fetch_assoc($result);
			$query = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Reset Player Location of ID:".$_GET["resetlocation"]."','{$_SESSION['login']}',NOW())";
			$sql2 = mysql_query($query) or die(mysql_error());
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
