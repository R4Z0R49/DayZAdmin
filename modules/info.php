<?php
$debug = '';
//ob_end_clean();
if (isset($_SESSION['user_id']) && $accesslvls[0][4] != "false")
{
	include ('info/'.$show.'.php');
}
else
{
	header('Location: admin.php');
}
//ob_end_clean();
?>