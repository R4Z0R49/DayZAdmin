<?php

if (isset($_SESSION['user_id']))
{
	header('Location: '.$security.'.php');
	exit;
}

if (!empty($_POST))
{
	$login = (isset($_POST['login'])) ? $_POST['login'] : '';
	$salt = $db->GetOne("SELECT `salt` FROM `users` WHERE `login` = ? LIMIT 1", $login);
	
	if ($salt)
	{
		$password = md5(md5($_POST['password']) . $salt);
		$user_id = $db->GetOne("SELECT `id` FROM `users` WHERE `login` = ? AND `password` = ? LIMIT 1", array($login, $password));

		if ($user_id)
		{
			$_SESSION['user_id'] = $user_id;
			$_SESSION['login'] = $login;
			$time = 86400;
			
			if (isset($_POST['remember']))
			{
				setcookie('login', $login, time()+$time, "/");
				setcookie('password', $password, time()+$time, "/");
			}
			$db->Execute("UPDATE `users` SET `lastlogin` = NOW() WHERE `login` = ? LIMIT 1", $login);
			$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('LOGIN', ?, NOW())", $login);
			header('Location: '.$security.'.php');
			exit;
		}
		else
		{
			header('Location: '.$security.'.php');
		}
	}
	else
	{
		header('Location: '.$security.'.php');
	}
}

$page = 'dashboard';
$pagetitle = 'Login';
?>

<?php include('modules/stats-header.php'); ?>

	<div class="container">
	<div class="login-content">
		<form action="<?php echo $security; ?>.php" method="post">
			<div class="login-box">	
				<div id="page-heading-login">
					<?php
						echo "<title>".$pagetitle." - ".$sitename."</title>";
						echo "<h1>".$pagetitle."</h1>";

					?>
				</div>
				<div class="login-box-inner">
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th>Username: </th>
						<td><input type="text" style="margin-left: 5px;" name="login" value="Username" onfocus="this.value=''" class="form-control" /></td>
					</tr>
					<tr>
						<td><br></td>
					</tr>
					<tr>
						<th>Password:</th>
						<td><input type="password" style="margin-left: 5px;" name="password" value="Password" onfocus="this.value=''" class="form-control" /></td>
					</tr>
					<tr>
						<td><br></td>
					</tr>
					<tr>
						<th></th>
						<td valign="top"><input type="checkbox" name="remember" class="checkbox-size" id="login-check" /><label for="login-check" style="margin-left: 5px;">Remember me</label></td>
					</tr>
					<tr>
						<th></th>
						<td><input type="submit" class="btn btn-primary" value="Submit" style="margin-top: 5px;"/></td>
					</tr>
					</table>
				</div>
			</div>
		</form>
	</div>
	<!--  end content -->
	</div>
	</div>

		<!-- start footer -->         
		<?php
			include('modules/footer.php');
		?>
		<!-- end footer -->
	</body>
</html>
