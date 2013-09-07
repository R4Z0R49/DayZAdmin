<?php
require_once('config.php');
require_once('adodb5/adodb.inc.php');

$con = new mysqli($hostname, $username, $password, $dbName);

$db = ADONewConnection('mysqli://'.$username.':'.$password.'@'.$hostname.'/'.$dbName.'?port='.$dbport);
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->SetCharset('utf8');
$db->debug = false;

?>
