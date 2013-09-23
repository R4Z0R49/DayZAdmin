<?php
if (isset($_SESSION['user_id']) && $accesslvl != 'semi')
{
	$pagetitle = "Manage admins";
	$delresult = "";
	if (isset($_POST["user"]) && $_POST['Delete']){
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

	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('MANAGE ADMINS',?,NOW())", $_SESSION['login']);

    $userid = $_REQUEST['userid'];
    if(isset($_REQUEST['new_aname']) && $_REQUEST['new_aname'] != NULL){
        $db->Execute("UPDATE users SET login = ? WHERE id = ?", array($_POST['new_aname'], $userid));
    }
    if(isset($_REQUEST['new_apass']) && $_REQUEST['new_apass'] != NULL){
        if (strlen($_REQUEST['new_apass']) < 6) {
            $message->add('danger', "Password must be at least 6 characters");
        } else {
            $db->Execute("UPDATE users SET password = ? WHERE id = ?", array(md5(md5($_POST['new_apass']) . $salt), $userid));
        }
    }
    if(isset($_REQUEST['new_access']) && $_REQUEST['new_access'] != 'New Accesslvl'){
        if($_REQUEST['new_access'] == 'Semi'){
            $db->Execute("UPDATE users SET accesslvl = ? WHERE id = ?", array('semi', $userid));
        }
        if($_REQUEST['new_access'] == 'Full'){
            $db->Execute("UPDATE users SET accesslvl = ? WHERE id = ?", array('full', $userid));
        }
    }
	
	$res = $db->GetAll("SELECT * FROM users ORDER BY id ASC");
	$number = sizeof($res);
	
	$users="";
	foreach($res as $row) {
		$users .= "<tr class='custom-tr'><td><input name=\"user[]\" value=\"".$row['id']."\" type=\"checkbox\"/></td><td>".$row['id']."</td><td>".$row['login']."</td><td>".$row['lastlogin']."</td><td>".$row['accesslvl']."</td></tr>";
	}
	
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

<div id="table-content">
<form action="admin.php?view=admin" method="post">
<table class="table" style="width: 70%;">
<tr>
	<th class="custom-th"><h4>Select <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Id <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Login <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Last Access <i class="icon-arrow-down"></i></h4></th>
	<th class="custom-th"><h4>Access Level <i class="icon-arrow-down"></i></h4></th>
</tr>

	<?php echo $users; ?>	
</table>
<input type="submit" value="Delete" name="Delete" class="btn btn-danger"  />
<input type="submit" value="Edit" name="Edit" class="btn btn-default"  />
</div>
</form>

<?php if(isset($_REQUEST['Edit']) && isset($_REQUEST['user'])){
	$userid = $_REQUEST['user'][0];
	$editing = $db->GetOne("SELECT login FROM users WHERE id = ?", $userid);
	echo '<br>';
	$message->display();
?>
<h1 class="custom-h1"><?php echo 'Editing '. $editing; ?></h1>
<form method="POST">
    <input type="hidden" name="userid" value="<?php echo $_REQUEST['user'][0]; ?>">
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-4">
			<input type="text" value="<?php echo $editing; ?>" name="new_aname" class="form-control">
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-4">
			<input type="password" placeholder="New Password" name="new_apass" class="form-control">
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-4">
			<select name="new_access" class="form-control">
				<option>New Accesslvl</option>
				<option>Full</option>
				<option>Semi</option>
			</select>
		</div>
	</div>
	<input type="submit" class="btn btn-default" name="edit_submit">
</form>
<?php } ?>


<?php
}
else
{
	if ($accesslvl != 'full') {
		$message->add('danger', "You dont have enough access to view this");
		$message->display();
	}
}
?>
