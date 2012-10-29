<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

if (isset($_SESSION['user_id']))
{
	header('Location: admin.php');
	exit;
}

if (!empty($_POST))
{
	$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
	
	$query = "SELECT `salt`
				FROM `users`
				WHERE `login`='{$login}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($sql) == 1)
	{
		$row = mysql_fetch_assoc($sql);
		
		// итак, вот она соль, соответствующая этому логину:
		$salt = $row['salt'];
		
		// теперь хешируем введенный пароль как надо и повторям шаги, которые были описаны выше:
		$password = md5(md5($_POST['password']) . $salt);
		
		// и пошло поехало...

		// делаем запрос к БД
		// и ищем юзера с таким логином и паролем

		$query = "SELECT `id`
					FROM `users`
					WHERE `login`='{$login}' AND `password`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());

		// если такой пользователь нашелся
		if (mysql_num_rows($sql) == 1)
		{
			// то мы ставим об этом метку в сессии (допустим мы будем ставить ID пользователя)

			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['login'] = $login;
			// если пользователь решил "запомнить себя"
			// то ставим ему в куку логин с хешем пароля
			
			$time = 86400; // ставим куку на 24 часа
			
			if (isset($_POST['remember']))
			{
				setcookie('login', $login, time()+$time, "/");
				setcookie('password', $password, time()+$time, "/");
			}
			$query = "UPDATE `users` SET `lastlogin`= NOW() WHERE `login`='{$login}' LIMIT 1";
			$sql2 = mysql_query($query) or die(mysql_error());
			$query = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('LOGIN','{$login}',NOW())";
			$sql2 = mysql_query($query) or die(mysql_error());
			// и перекидываем его на закрытую страницу
			header('Location: admin.php');
			exit;

			// не забываем, что для работы с сессионными данными, у нас в каждом скрипте должно присутствовать session_start();
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