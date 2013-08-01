<?php
if (isset($_SESSION['user_id']))
{

ini_set( "display_errors", 0);
error_reporting (E_ALL ^ E_NOTICE);


$pagetitle = "Dashboard";

$logs = "";
$res = $db->GetAll("SELECT * FROM `logs` ORDER BY `timestamp` DESC LIMIT 100");
foreach($res as $row) {
	$logs .= $row['timestamp'].' '.$row['user'].': '.$row['action'].chr(13);
}
$xml = file_get_contents('quicklinks.xml', true);

require_once('xml2array.php');
$quicklinks = XML2Array::createArray($xml);

?>
<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";

?>
</div>

<table class="table">
	<th class="custom-th"><h4>Global Chat</h4></th>
	<th class="custom-th"><h4>Admin Logs</h4></th>
	<tr>
		<td align="center" width="50%">
			<form action="admin.php?view=actions" method="post">
			<textarea name="say" cols="89" rows="10" >Type something to Global Chat</textarea>
		</td>
		<td align="center" width="50%">
			<textarea cols="89" rows="10" readonly><?php echo $logs; ?></textarea>
		</td>
	</tr>
	<tr>
		<td align="right" style="">
			<input type="submit" class="btn btn-default" style=""/>
			</form>
		</td>
		<td>
		</td>
	</tr>
</table>
</body>
<?php
}
else
{
	header('Location: admin.php');
}
?>
