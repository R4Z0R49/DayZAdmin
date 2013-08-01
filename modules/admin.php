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
		$users .= "<tr class='custom-tr'><td><input name=\"user[]\" value=\"".$row['id']."\" type=\"checkbox\"/></td><td>".$row['id']."</td><td>".$row['login']."</td><td>".$row['lastlogin']."</td><td>".$row['accesslvl']."</td></tr>";
	}
	
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('MANAGE ADMINS',?,NOW())", $_SESSION['login']);
?>
<div id="dvPopup" class="container custom-container" style="display:none; width:900px; height: 600px;">
	<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
	<?php include ('modules/register.php'); ?>
</div>
<div id="page-heading">
	<h1 class="custom-h1"><?php echo $pagetitle; ?></h1>
	<h1><?php echo "<title>".$pagetitle." - ".$sitename."</title>"; ?></h1>
</div>
<!-- end page-heading -->

<table class="table" style="width: 25%; float: right;">
<tr>
	<th class="custom-th"><h4>Related Activities <i class="icon-arrow-down"></i></h4></th>
</tr>
<tr class="custom-tr">
	<td><a href="#" onclick="ShowModalPopup('dvPopup'); return false;"><h4>Add Administrator</h4></a>
	Adds a new administrator
	</td>
</tr>
<tr class="custom-tr">
	<td><a href="admin.php?view=actions&clearLogs"><h4>Clear Logs</h4></a>
	Clears the action logs
	</td>
</tr>
</table>

<table class="table table-hover" style="width: 70%;">
<tr>
	<th class="custom-th"><h4>Delete <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Id <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Login <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Last Access <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Access Level <i class="icon-arrow-down"></i></h4></th>
</tr>

	<?php echo $users; ?>	
</table>


<?php
}
else
{
	if ($accesslvl != 'full') {
	echo 'You dont have enough access to view this';
	}
}
?>
