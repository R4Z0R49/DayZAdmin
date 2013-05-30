<?php
$user_id = $_SESSION['user_id'];
$accesslvl = $db->GetOne("SELECT accesslvl FROM users WHERE id = '$user_id'");

if (isset($_SESSION['user_id']) && $accesslvl != 'semi')
{
	$pagetitle = "Manage admins";
	$delresult = "";
	if (isset($_POST["user"])){
		$aDoor = $_POST["user"];
		$N = count($aDoor);
		for($i=0; $i < $N; $i++)
		{
			$res2 = $db->GetAll("SELECT * FROM users WHERE id = ?", $aDoor[$i]); 
			foreach($res2 as $row2) {
				$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES (CONCAT('DELETE ADMIN: ', ?),?,NOW())", array($row2['login'], $_SESSION['login']));
				$db->Execute("DELETE FROM `users` WHERE id = ?", $aDoor[$i]);
				$delresult .= '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">Admin '.$row2['login'].' successfully removed!</td>
					<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
			}		
			//echo($aDoor[$i] . " ");
		}
		//echo $_GET["deluser"];
	}
	
	$res = $db->GetAll("SELECT * FROM users ORDER BY id ASC");
	$number = sizeof($res);
	
	$users="";
	foreach($res as $row) {
		$users .= "<tr><td><input name=\"user[]\" value=\"".$row['id']."\" type=\"checkbox\"/></td><td>".$row['id']."</td><td>".$row['login']."</td><td>".$row['lastlogin']."</td><td>".$row['accesslvl']."</td></tr>";
	}
	
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('MANAGE ADMINS',?,NOW())", $_SESSION['login']);

?>
<div id="dvPopup" style="display:none; width:900px; height: 450px; border:4px solid #000000; background-color:#FFFFFF;">
				<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
				<?php include ('modules/register.php'); ?>
</div>
	<div id="page-heading">
		<h1><?php echo $pagetitle; ?></h1>
		<h1><?php echo "<title>".$pagetitle." - ".$sitename."</title>"; ?></h1>
	</div>
	<!-- end page-heading -->

	
	
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
			<?php echo $delresult; ?>
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
							<a href="#" onclick="">
							<img width="21" height="21" alt="" style="margin-top: 5px;" src="images/forms/icon_plus.gif"></a>
						</div>
						<div class="right">
							<h5><a href="#" onclick="ShowModalPopup('dvPopup'); return false;">Add admin</a></h5>
							Add new administrator
							<br><br>
							<h5><a href="admin.php?view=actions&clearLogs">Clear logs</a></h5>
							Clears the action logs
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>	
				
			<!--  start table-content  -->
			<div id="table-content">
			<form action="admin.php?view=admin" method="post">
				<table border="0" width="75%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left"><a href="">Delete</a></th>
					<th class="table-header-repeat line-left" width="5%"><a href="">Id</a>	</th>
					<th class="table-header-repeat line-left minwidth-1" width="55%"><a href="">Login</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="20%"><a href="">Last access</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="20%"><a href="">Access level</a></th>
				</tr>
				<?php echo $users; ?>				
				</table>
				<input type="submit" class="submit-login"  />
				</div>
			</form>
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
	if ($accesslvl != 'full') {
	echo 'You dont have enough access to view this';
	}
}
?>
