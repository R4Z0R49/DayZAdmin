<?php
require_once ('queries.php');
require_once ('config.php');

mysql_connect ($hostname, $username, $password) or die ('Error: ' . mysql_error());
mysql_select_db($dbName);

if (isset($_SESSION['user_id']))
{
	$user_id = $_SESSION['user_id'];
	$pagetitle = "Manage VIPS( Only for Reality )";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Manage VIPS',?,NOW())", $_SESSION['login']);

	$delresult = "";
	if (isset($_POST["vip"])){
		$aDoor = $_POST["vip"];
		$N = count($aDoor);
		for($i=0; $i < $N; $i++)
		{
			$res2 = $db->GetAll("SELECT * FROM cust_loadout_profile WHERE unique_id = ?", $aDoor[$i]); 
			foreach($res2 as $row2) {
				$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('DELETE VIP: ', ?),?,NOW())", array($row2['login'], $_SESSION['login']));
				$db->Execute("DELETE FROM `cust_loadout_profile` WHERE unique_id = ?", $aDoor[$i]);
				$delresult .= '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">VIP '.$row2['unqique_id'].' successfully removed!</td>
					<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
			}		
			//echo($aDoor[$i] . " ");
		}
		//echo $_GET["deluser"];
	}

	if (isset($_POST["vip"])){
		$aDoor = $_POST["vip"];
		$N = count($aDoor);
		for($i=0; $i < $N; $i++)
		{
			$res4 = $db->GetAll("SELECT * FROM cust_loadout WHERE id = ?", $aDoor[$i]); 
			foreach($res4 as $row4) {
				$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('DELETE VIPPACKAGE: ', ?),?,NOW())", array($row4['login'], $_SESSION['login']));
				$db->Execute("DELETE FROM `cust_loadout` WHERE id = ?", $aDoor[$i]);
				$delresult .= '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">Package '.$row4['id'].' successfully removed!</td>
					<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
			}		
			//echo($aDoor[$i] . " ");
		}
		//echo $_GET["deluser"];
	}


	$res = $db->GetAll("SELECT * FROM cust_loadout_profile ORDER BY unique_id ASC");
	$number = sizeof($res);
	
	$vips = "";
	foreach($res as $row) {
		$vips .= "<tr class='custom-tr'><td><input name=\"vip[]\" value=\"".$row['unique_id']."\" type=\"checkbox\"/></td><td>".$row['unique_id']."</td><td>".$row['cust_loadout_id']."</td></tr>";
	}

	$res = $db->GetAll("SELECT * FROM users ORDER BY id ASC");
	$number = sizeof($res);
	

	$res2 = $db->GetAll("SELECT * FROM cust_loadout ORDER BY id ASC");
	$number2 = sizeof($res2);
	
	$packages = "";
	foreach($res2 as $row2) {
		$packages .= "<tr class='custom-tr'><td><input name=\"vip[]\" value=\"".$row2['id']."\" type=\"checkbox\"/></td><td>".$row2['id']."</td><td><textarea class='form-control'>".$row2['inventory']."</textarea></td><td><textarea class='form-control'>".$row2['backpack']."</textarea></td><td>".$row2['model']."</td></tr>";
	}
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('MANAGE VIPS',?,NOW())", $_SESSION['login']);
?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";
?>
</div>

<table class="table" style="width: 25%; float: right;">
<tr>
	<th class="custom-th"><h4>Related Activities <i class="icon-arrow-down"></i></h4></th>
</tr>
<tr class="custom-tr">
	<td><a href="vippackage.php" onclick="ShowModalPopup('dvPopup'); return false;"><h4>Add Package</h4></a>
	Adds a package
	</td>
</tr>
<tr class="custom-tr">
	<td><a href="vipregister.php" onclick="ShowModalPopup('dvPopup2'); return false;"><h4>Add VIP</h4></a>
	Adds a new VIP
	</td>
</tr>
</table>

<form action="admin.php?view=vip" method="post">
<table class="table" style="width: 70%; margin-left: 10px;">
<tr>
	<th class="custom-th"><h4>Delete <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Unique ID <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Loadout <i class="icon-arrow-down"></i></h4></th>
</tr>
	<?php echo $vips; ?>	
</table>
<input type="submit" value="Submit" style="margin-left: 10px;" class="btn btn-default" name="vips" />
</form>

<form action="admin.php?view=vip" method="post">
<br><br>
<table class="table" style="width: 70%; margin-left: 10px;">
<tr>
	<th class="custom-th"><h4>Delete <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Loadout <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Inventory <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Backpack <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Skin <i class="icon-arrow-down"></i></h4></th>
</tr>
	<?php echo $packages; ?>	
</table>
<input type="submit" value="Submit" style="margin-left: 10px;" class="btn btn-default" name="packages" />
<br><br>
</form>
		
<?php
mysql_connect ($hostname, $username, $password) or die ('Error: ' . mysql_error());
mysql_select_db($dbName);

$inv = $db->GetOne("SELECT inventory FROM instance WHERE id = 1");
$bck = $db->GetOne("SELECT backpack FROM instance WHERE id = 1");

if ($_POST['submit_load']) {
	$load_inv =  mysql_real_escape_string($_POST['load_inv']);
	$load_bck =  mysql_real_escape_string($_POST['load_bck']);
	$db->Execute("UPDATE instance SET inventory = '$load_inv' WHERE id = 1");
	$db->Execute("UPDATE instance SET backpack = '$load_bck' WHERE id = 1");
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Edited instance loadout',?,NOW())", $_SESSION['login']);
} 
?>		

<div id="vipString">
	<form method="post">
	<br><h2 class="custom-h2" style="margin-left: 10px;">Loadout Inventory</h2>
		<textarea name="load_inv" action="" style="margin-left: 10px;"><?php echo $inv; ?></textarea><br>

	<br><h2 class="custom-h2" style="margin-left: 10px;">Loadout Backpack</h2>
		<textarea name="load_bck" action="" style="margin-left: 10px;"><?php echo $bck; ?></textarea><br>
	<br>
	<input name="submit_load" type="submit" class="btn btn-default" style="margin-left: 10px; margin-bottom: 10px;" value="Submit" />
	</form>
</div>

<?php
}
else
{
	header('Location: admin.php');
}
?>

<div id="dvPopup" class="container custom-container" style="display:none; width:900px; height: 600px;">
	<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
	<?php 
		include ('modules/vippackage.php'); 
	?>
</div>

<div id="dvPopup2" class="container custom-container" style="display:none; width:900px; height: 600px;">
	<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup2'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
	<?php 
		include ('modules/vipregister.php'); 
	?>
</div>
