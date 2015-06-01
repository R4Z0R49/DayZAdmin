<?php

error_reporting (0);
chdir("..");

$markers = array();
$callback = "";
$id = 0;

require_once('config.php');
require_once('db.php');
require_once('queries.php');
require_once('modules/maps/markers.php');

if (isset($_GET['id'])) {
	$tmp = intval($_GET['id']);
	if ($tmp >= 0 && $tmp <= 9) { $id = $tmp; }
}

if (isset($_GET['callback'])) {
	$callback = $_GET['callback'];
}

include('modules/maps/'.$id.'.php');

echo $callback.'('.(json_encode($markers)).')';

?>
