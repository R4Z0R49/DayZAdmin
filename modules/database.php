<?php
if (isset($_SESSION['user_id']))
{
	$pagetitle = "Database Admin Coming Soon";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('DATABASE ADMIN',?,NOW())", $_SESSION['login']);
?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";
?>
</div>

<!-- CONTENT GOES HERE -->

<?php
}
else
{
	header('Location: admin.php');
}
?>
