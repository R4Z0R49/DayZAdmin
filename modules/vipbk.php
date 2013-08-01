<?php
include ('queries.php');
require_once ('config.php');

mysql_connect ($hostname, $username, $password) or die ('Error: ' . mysql_error());
mysql_select_db($dbName);

if (isset($_SESSION['user_id']))
{
	$user_id = $_SESSION['user_id'];
	$pagetitle = "Manage VIPS( Coming soon™ )";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Manage VIPS',?,NOW())", $_SESSION['login']);

	$unique_id = $db->GetOne("SELECT unique_id FROM users WHERE id = ?");
	$delresult = "";
	if (isset($_POST["vip"])){
		$aDoor = $_POST["vip"];
		$N = count($aDoor);
		for($i=0; $i < $N; $i++)
		{
			$res2 = $db->GetAll("SELECT * FROM cust_loadout_profile WHERE unique_id = ?", $aDoor[$i]); 
			foreach($res2 as $row2) {
				$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('DELETE VIP: ', ?),?,NOW())", array($row2['unique_id'], $_SESSION['login']));
				$db->Execute("DELETE FROM `cust_loadout_profile` WHERE unique_id = ?", $aDoor[$i]);
				$delresult .= '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">VIP '.$row2['unique_id'].' successfully removed!</td>
					<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
			}		
			//echo($aDoor[$i] . " ");
		}
		//echo $_GET["deluser"];
	
	$res = $db->GetAll("SELECT * FROM cust_loadout_profile ORDER BY unique_id ASC");
	$number = sizeof($res);
	
	$vips="";
	foreach($res as $row) {
		$vips .= "<tr><td><input name=\"vip[]\" value=\"".$row['unique_id']."\" type=\"checkbox\"/></td><td>".$row['unique_id']."</td><td>".$row['cust_loadout_id']."</td></tr>";
	}
}
?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";
?>
<div id="dvPopup" class="container custom-container" style="display:none; width:900px; height: 600px;">
				<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
				<?php include ('modules/vipregister.php'); ?>
</div>
<div id="dvPopup2" class="container custom-container" style="display:none; width:900px; height: 600px;">
				<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup2'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
				<?php include ('modules/vippackage.php'); ?>
</div>
</div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">		
			<div id="related-activities">
				<div id="related-act-top">
					<img width="271" height="43" alt="" src="images/forms/header_related_act.gif">
				</div>
				<div id="related-act-bottom">
					<div id="related-act-inner">
						<div class="left">
							<a href="#" onclick="ShowModalPopup('dvPopup'); return false;">
							<img width="21" height="21" alt="" src="images/forms/icon_plus.gif"></a>
							<br><br>
							<a href="#" onclick="ShowModalPopup('dvPopup2'); return false;">
							<img width="21" height="21" alt="" style="margin-top: 5px;" src="images/forms/icon_plus.gif"></a>
						</div>
						<div class="right">
							<h5><a href="vipregister.php" onclick="ShowModalPopup('dvPopup'); return false;">Add VIP</a></h5>
							Add new VIP
							<br><br>
							<h5><a href="vipregister.php" onclick="ShowModalPopup('dvPopup2'); return false;">Add Package</a></h5>
							Add new Package
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			
			<!--  start table-content  -->
			<div id="table-content">
			<form action="admin.php?view=vip" method="post">
			<h2>VIPS</h2>
				<table border="0" width="75%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left"><a href="">Delete</a></th>
					<th class="table-header-repeat line-left" width="20%"><a href="">Unique ID</a>	</th>
					<th class="table-header-repeat line-left minwidth-1" width="80%"><a href="">Package</a></th
				</tr>
				<?php echo $vips; ?>				
				</table>
				<input type="submit" class="submit-login" name="vip" />
				</div>
			</form>
			
			<form action="admin.php?view=addPackage" method="post">
			<h2>Packages</h2>
				<table border="0" width="75%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left" width="5%"><a href="">Delete</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="10%"><a href="">Package</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="35%"><a href="">Inventory</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="35%"><a href="">Backpack</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="15%"><a href="">Skin</a></th>
				</tr>
				<?php echo $packages; ?>				
				</table>
				<input type="submit" class="submit-login" name="packages" />
				</div>
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
			<br><h2>Loadout Inventory</h2>
				<textarea name="load_inv" action=""><?php echo $inv; ?></textarea><br>

			<br><h2>Loadout Backpack</h2>
				<textarea name="load_bck" action=""><?php echo $bck; ?></textarea><br>
			<input name="submit_load" type="submit" class="submit-login" value="Submit" />
			</form>
		</div>
			<!--  end table-content  -->
	
			<div class="clear"></div>

		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>
<?php
}
else
{
	header('Location: admin.php');
}
?>
