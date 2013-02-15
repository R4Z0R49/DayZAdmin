<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

if (isset($_SESSION['user_id']))
{
	header('Location: admin.php');
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
			header('Location: admin.php');
			exit;
		}
		else
		{
			header('Location: admin.php');
		}
	}
	else
	{
		header('Location: admin.php');
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login - DayZ Administration</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<script src="js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg"> 
 
<div id="login-holder">

	<div id="logo-login">
		<a href="/"><img src="images/logo.png" width="451px" height="218px" alt="" /></a>
	</div>
	
	<div class="clear"></div>
	<form action="admin.php" method="post">
		<div id="loginbox">	
			<div id="login-inner">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th>Username</th>
					<td><input type="text" name="login" class="login-inp" /></td>
				</tr>
				<tr>
					<th>Password</th>
					<td><input type="password" name="password" value="************"  onfocus="this.value=''" class="login-inp" /></td>
				</tr>
				<tr>
					<th></th>
					<td valign="top"><input type="checkbox" name="remember" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
				</tr>
				<tr>
					<th></th>
					<td><input type="submit" class="submit-login"  /></td>
				</tr>
				</table>
			</div>
			<div class="clear"></div>
		</div>
	</form>
</div>
</body>
</html>
