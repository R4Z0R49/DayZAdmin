<?php
require_once('config.php');
require_once('adodb5/adodb.inc.php');

$db = ADONewConnection('mysqli');
$db->Connect($hostname, $username, $password, $dbName);
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->debug = false;

?>
