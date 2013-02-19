<?php
require_once('config.php');
require_once('adodb5/adodb.inc.php');

$db = ADONewConnection('mysqli://'.$username.':'.$password.'@'.$hostname.'/'.$dbName.'?port='.$dbport);
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->debug = false;

?>
