<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
session_start();
include ('config.php');
include ('functions.php');

mysql_connect($hostname, $username, $password) or die (mysql_error());
mysql_select_db($dbName) or die (mysql_error());

if (isset($_GET['logout']))
{
	$query = "INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('LOGOUT','{$_SESSION['login']}',NOW())";
	$sql2 = mysql_query($query) or die(mysql_error());
	
	if (isset($_SESSION['user_id']))
		unset($_SESSION['user_id']);
		
	setcookie('login', '', 0, "/");
	setcookie('password', '', 0, "/");
	header('Location: admin.php');
	exit;
}

if (isset($_SESSION['user_id']))
{
	include ('modules/rcon.php');
	include ('modules/tables/rows.php');
	function slashes(&$el)
	{
		if (is_array($el))
			foreach($el as $k=>$v)
				slashes($el[$k]);
		else $el = stripslashes($el); 
	}

	if (isset($_GET["show"])){
		$show = $_GET["show"];
	}else{
		$show = 0;
	}

	// Start: page-header 
	include ('modules/header.php');
	// End page-header

	if (isset($_GET["show"])) {
		$show = $_GET["show"];
	} else {
		$show = 0;
	}

	if (isset($_GET['view'])){
		include ('modules/'.$_GET["view"].'.php');
	} else {
		include ('modules/dashboard.php');
	}

	// Start: page-footer 
	include ('modules/footer.php');
	// End page-footer
?>
</div>
<!--  end content -->
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
 
</body>
</html>
<?php
}
else
{
	include ('modules/login.php');
}
?>
