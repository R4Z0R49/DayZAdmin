<?php
if (isset($_SESSION['user_id']) && $accesslvls[0][1] != 'false')
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

	//USER EDIT
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
        if($_REQUEST['new_access'] != "Select an accesslvl:"){
            $new_accesslvl = $_REQUEST['new_access'];
            $db->Execute("UPDATE users SET accesslvl = ? WHERE id = ?", array($new_accesslvl, $userid));
        } else {
          $message->add('danger', "Please select a valid accesslvl!");
        }
    }

  $res_accesslvl = $db->GetAll("SELECT name FROM accesslvl");
  $accesslvl_list="";
  foreach($res_accesslvl as $row_accesslvl) {
    $accesslvl_list .= '<option value="'. $row_accesslvl['name'] .'">' . $row_accesslvl['name'] . '</option>';
  }

  //ACCESSLVL QUERY
  if(isset($_REQUEST['alvl_new_name']) or isset($_REQUEST['alvl_mapview']) or isset($_REQUEST['alvl_editadmin']) or isset($_REQUEST['alvl_editvip']) or isset($_REQUEST['alvl_canseecoords']) or isset($_REQUEST['alvl_cansearch']) or isset($_REQUEST['alvl_checkitems']) or isset($_REQUEST['alvl_canviewdbmanager'])) {
    if(!isset($_REQUEST['alvl_mapview'])){
      $alvl_mapview = 'false';
    } else {
      $alvl_mapview = 'true';
    }
    if(!isset($_REQUEST['alvl_editadmin'])){
      $alvl_editadmin = 'false';
    } else {
      $alvl_editadmin = 'true';
    }
    if(!isset($_REQUEST['alvl_editvip'])){
      $alvl_editvip = 'false';
    } else {
      $alvl_editvip = 'true';
    }
    if(!isset($_REQUEST['alvl_canseecoords'])){
      $alvl_canseecoords = 'false';
    } else {
      $alvl_canseecoords = 'true';
    }
    if(!isset($_REQUEST['alvl_cansearch'])){
      $alvl_cansearch = 'false';
    } else {
      $alvl_cansearch = 'true';
    }
    if(!isset($_REQUEST['alvl_checkitems'])){
      $alvl_checkitems = 'false';
    } else {
      $alvl_checkitems = 'true';
    }
    if(!isset($_REQUEST['alvl_canviewdbmanager'])){
      $alvl_canviewdbmanager = 'false';
    } else {
      $alvl_canviewdbmanager = 'true';
    }
    $access_query = ("['". $alvl_mapview ."', '". $alvl_editadmin ."', '". $alvl_editvip ."', '". $alvl_canseecoords ."', '". $alvl_cansearch ."', '". $alvl_checkitems ."', '". $alvl_canviewdbmanager ."']");
    $access_query = str_replace("'", '"', $access_query);
    //echo $access_query;
  }
  //ACCESSLVL ADD
  if($_REQUEST['alvl_add_submit']) {
  	//echo($access_query);
  	if($_REQUEST['alvl_new_name'] == NULL) {
  		$message->add('danger', "You must name your accesslvl");
  	} else {
  		$message->add('success', "Successfully added a new accesslvl!");
  		$new_alvl_name = $_REQUEST['alvl_new_name'];
  		$db->Execute("INSERT INTO `accesslvl`(`name`, `access`) VALUES (?, ?)", array($new_alvl_name, $access_query));
  	}
  }
  //ACCESSLVL EDIT
  if($_REQUEST['alvl_edit_submit']) {
    if(!isset($_REQUEST['AccessName'])) {
      $message->add('danger', "You must select an accesslvl to edit");
    } elseif($_REQUEST['AccessName'] == 'full') {
      $message->add('danger', "You can't edit this accesslvl");
    } else {
      $message->add('success', "Successfully edited an accesslvl!");
      $edit_access_name = $_REQUEST['AccessName'];
      $db->Execute("UPDATE accesslvl SET access = ? WHERE name = ?", array($access_query, $edit_access_name));
    }
  }
  //ACCESSLVL DELETE
  if($_REQUEST['alvl_delete_submit']) {
    if(!isset($_REQUEST['AccessName'])) {
      $message->add('danger', "You must select an accesslvl to delete");
    } elseif($_REQUEST['AccessName'] == 'full') {
      $message->add('danger', "You can't delete this accesslvl");
    } else {
      $message->add('success', "Successfully deleted an accesslvl!");
      $delete_access_name = $_REQUEST['AccessName'];
      $db->Execute("DELETE FROM accesslvl WHERE name = ?", array($delete_access_name));
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
<tr class="custom-tr">
	<td><a href="admin.php?view=admin&AddAccess"><h4>Add Accesslvl</h4></a>
	Adds an accesslvl
	</td>
</tr>
<tr class="custom-tr">
	<td><a href="admin.php?view=admin&EditAccess"><h4>Edit/Delete Accesslvl</h4></a>
	Lets you edit/delete an accesslvl
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
<input type="submit" value="Edit" name="Edit" class="btn btn-default"  />
<input type="submit" value="Delete" name="Delete" class="btn btn-danger"  />
</div>
</form>

<?php 
echo '<br>';
$message->display();
if(isset($_REQUEST['Edit']) && isset($_REQUEST['user'])){
	$userid = $_REQUEST['user'][0];
	$editing = $db->GetOne("SELECT login FROM users WHERE id = ?", $userid);
	echo '<br>';
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
        <option>Select an accesslvl:</option>
        <?php echo $accesslvl_list; ?>
			</select>
		</div>
	</div>
	<input type="submit" class="btn btn-default" name="alvl_editprofile_submit">
</form>
<?php } ?>

<?php if(isset($_REQUEST['AddAccess'])){ 
 	//var_dump($accesslvls);
	//echo $accesslvls[0][0]; -> Map Access
	//echo $accesslvls[0][1]; -> Admin Edit
	//echo $accesslvls[0][2]; -> VIP Edit
	//echo $accesslvls[0][3]; -> Can view co-ords/gridrefs
	//echo $accesslvls[0][4]; -> Has search access
	//echo $accesslvls[0][5]; -> Can check illegal items
	//echo $accesslvls[0][6]; -> Can use db manager
	//echo $accesslvls[0][7];
?>
<h1 class="custom-h1">Add an accesslvl</h1>
<form method="POST">
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-4">
			<input type="text" placeholder="New accesslvl name" name="alvl_new_name" class="form-control">
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-6">
		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_mapview"> Map Access
   				 </label>
  			</div>
  			 <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_editadmin"> Admin Edit
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_editvip"> VIP Edit
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_canseecoords"> Can view co-ords/gridrefs
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_cansearch"> Can use search
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_checkitems"> Can check illegal items
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_canviewdbmanager"> Can use db manager
   				 </label>
  			</div>
		</div>
	</div>
	<input type="submit" class="btn btn-default" value="Add" name="alvl_add_submit">
</form>
<?php } ?>

<?php if(isset($_REQUEST['EditAccess'])){ 
$hasAccess = $db->GetAll("SELECT access FROM accesslvl WHERE name = ?", array($_GET['AccessName']));
$hasAccess = $hasAccess[0]['access'];
$hasAccess = str_replace("|", ",", $hasAccess);
$hasAccess = json_decode($hasAccess);
$hasAccess = array($hasAccess);
//var_dump($hasAccess);
?>
<h1 class="custom-h1">Edit/Remove an accesslvl</h1>
<form method="POST">
	<div class="row" style="margin-bottom: 15px;">
		<div class="col-lg-4">
			<select name="alvl_edit_name" class="form-control" onChange='window.location="admin.php?view=admin&EditAccess&AccessName=" + this.value;'>
				<option>Select an accesslvl:</option>
				<?php echo $accesslvl_list; ?>
			</select>
		</div>
	</div>
  <div class="row" style="margin-bottom: 5px;">
    <div class="col-lg-4">
        <?php if(isset($_REQUEST['AccessName'])) { echo 'Editing: ' . $_REQUEST['AccessName']; }; ?>
    </div>
  </div>
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-6">
		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_mapview"> <font color="<?php if($hasAccess[0][0] == 'true') { echo 'green'; }?>">Map Access</font>
   				 </label>
  			</div>
  			 <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_editadmin"> <font color="<?php if($hasAccess[0][1] == 'true') { echo 'green'; } ?>">Admin Edit</font>
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_editvip"> <font color="<?php if($hasAccess[0][2] == 'true') { echo 'green'; } ?>">VIP Edit</font>
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_canseecoords"> <font color="<?php if($hasAccess[0][3] == 'true') { echo 'green'; } ?>">Can view co-ords?</font>
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_cansearch"> <font color="<?php if($hasAccess[0][4] == 'true') { echo 'green'; } ?>">Has search access</font>
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_checkitems"> <font color="<?php if($hasAccess[0][5] == 'true') { echo 'green'; } ?>">Can check illegal items</font>
   				 </label>
  			</div>
  		    <div class="checkbox">
    			<label>
     			 	<input type="checkbox" name="alvl_canviewdbmanager"> <font color="<?php if($hasAccess[0][6] == 'true') { echo 'green'; } ?>">Can use db manager</font>
   				 </label>
  			</div>
		</div>
	</div>
	<input type="submit" class="btn btn-default" name="alvl_edit_submit" value="Edit" style="margin-bottom: 5px;">
  <input type="submit" class="btn btn-danger" name="alvl_delete_submit" value="Delete" style="margin-bottom: 5px;">
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-12">
			<b>Remember to re-select even the ones highlighted as green, unless you want to unselect them!</b>
		</div>
	</div>
</form>
<?php } ?>

<?php
}
else
{
	if ($accesslvls[0][1] != 'true') {
		$message->add('danger', "You dont have enough access to view this");
		$message->display();
	}
}
?>
