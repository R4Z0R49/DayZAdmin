<?php
	$pagetitle = "Profile Settings";

    if(isset($_REQUEST['old_pass']) && isset($_REQUEST['new_pass']) && isset($_REQUEST['confirm_pass'])) {
	    $old_passmd5 = $User_query[0]['password'];
	    $hashed_password = md5(md5($_REQUEST['old_pass']) . $salt);

    	if($_REQUEST['new_pass'] != $_REQUEST['confirm_pass']) {
	    	$message->add('danger', "Passwords do not match");
    	} 

	    if(isset($_REQUEST['old_pass'])) {
		    if($hashed_password != $old_passmd5){
			    $message->add('danger', "Old password is incorrect");
    		}
	    }

    	if (isset($_REQUEST['new_pass']) && strlen($_REQUEST['new_pass']) < 6)
	    {
		    $message->add('danger', "Password must be at least 6 characters");
    	}

	    if($hashed_password == $old_passmd5 && $_REQUEST['new_pass'] == $_REQUEST['confirm_pass'] && strlen($_REQUEST['confirm_pass']) >= 6){
		    $newpass = md5(md5($_REQUEST['new_pass']) . $salt);
	    	$db->Execute("UPDATE users SET password = ? WHERE login = ?", array($newpass, $User));
    		$message->add('success', "Password successfully changed");
	    }

    }
?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";
?>
</div>

<?php 
	$message->display();
?>
<form method="POST" action="admin.php?view=profile">
	<div class="row" style="margin-bottom: 5px">
		<div class="col-lg-4">
			<b>Change Password</b>
		</div>
		<div class="col-lg-4">
			<b>Information</b>
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px">
		<div class="col-lg-4">
			<input type="password" class="form-control" placeholder="Old Password" name="old_pass">
		</div>
		<div class="col-lg-4">
			<b>Accesslvl</b> = <?php echo $User_query[0]['accesslvl']; ?><br>
			<b>Last Login</b> = <?php echo $User_query[0]['lastlogin']; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4" style="margin-bottom: 5px">
			<input type="password" class="form-control" placeholder="New Password" name="new_pass">
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px">
		<div class="col-lg-4">
			<input type="password" class="form-control" placeholder="Confirm Password" name="confirm_pass">
		</div>
	</div>
	<input type="submit" class="btn btn-default">
</form>
