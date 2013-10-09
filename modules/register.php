<?php
if (isset($_SESSION['user_id']))
{

$res_accesslvl = $db->GetAll("SELECT name FROM accesslvl");
$accesslvl_list="";
foreach($res_accesslvl as $row_accesslvl) {
$accesslvl_list .= '<option value="'. $row_accesslvl['name'] .'">' . $row_accesslvl['name'] . '</option>';
}
function GenerateSalt($n=3)
{
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
	$counter = strlen($pattern)-1;
	for($i=0; $i<$n; $i++)
	{
		$key .= $pattern{rand(0,$counter)};
	}
	return $key;
}

if (empty($_POST))
{
	?>
<div class="custom-container-popup" id="content-table-inner">
	<div id="table-content">
				<h2 class="custom-h2">Enter Details</h2><br>
				<form method="POST" id="regform" action="admin.php?view=admin">
				<table border="0" id="id-form">
					<tr>
						<th class="custom-th-popup">Login:</th>
						<td><input type="text" class="form-control" name="login" /></td>
						<td></td>
					</tr>
					<tr>
						<th>Password:</th>
						<td><input type="text" class="form-control" name="password" /></td>
						<td></td>
					</tr>
					<tr>
						<th>Access level:</th>
						<td>
						<select name="accesslvl" class="form-control">
						<option value="" selected="selected">Access Level</option>
						<?php echo $accesslvl_list; ?>
						</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<input type="submit" value="Submit" name="regSubmit" class="btn btn-default pull-right">
						</td>
						<td></td>
					</tr>
					</table>
						<h2 class="custom-h2">Access level</h2>
						<br>
						* Gives the user the access of the group that you've set up. Full which is one of the default access levels gives full access to the panel, and semi gives access to everything but map, gps co-ords and editing of administrators.
				</form>	
		</div>
			<div id="result"></div>
			</body>
</div>
<?php
}
else
{

	$login = (isset($_POST['login'])) ? $_POST['login'] : '';
	$password = (isset($_POST['password'])) ? $_POST['password'] : '';
	$accesslvl = (isset($_POST['accesslvl'])) ? $_POST['accesslvl'] : '';
	
	$error = false;
	$errort = '';
	
	if(isset($_POST['regSubmit']) && !$_POST['accesslvl'] == 'Access Level')
	{
		$error = true;
		$errort .= 'Select the access level of the user! <br />';
	}
	
	if (isset($_POST['regSubmit']) && strlen($login) < 2)
	{
		$error = true;
		$errort .= 'Login must be at least 2х characters.<br />';
	}
	if (isset($_POST['regSubmit']) && strlen($password) < 6)
	{
		$error = true;
		$errort .= 'Password must be at least 6 characters.<br />';
	}
	
	$res = $db->GetAll("SELECT `id` FROM `users` WHERE `login` = ?", $login);
	if (isset($_POST['regSubmit']) && sizeof($res)==1)
	{
		$error = true;
		$errort .= 'Login already used.<br />';
	}
	
	if (!$error && isset($_POST['regSubmit']))
	{
		$salt = GenerateSalt();
		$hashed_password = md5(md5($password) . $salt);
		
		$db->Execute("INSERT INTO users SET login = ?, password = ?, accesslvl = ?, salt = ?", array($login, $hashed_password, $accesslvl, $salt));
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`,) VALUES ('REGISTER ADMIN: ?',?,NOW())", array($login, $_SESSION['login']));
		?>
		<?php
		$message->add('success', "New administrator successfully registered!");
	}
	else
	{
		?>
		<?php
		if(isset($_POST['regSubmit'])){
			$message->add('danger', "Error in registration proccess!<br>". $errort);
		}
	}

}
}
else
{
	header('Location: admin.php');
}
?>
