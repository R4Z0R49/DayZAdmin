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

if (isset($_GET['chat'])){
	$chat_view = 'chat';
}
if (isset($_GET['logs'])){
	$chat_view = 'logs';
}
if (!isset($_GET['logs']) && !isset($_GET['chat'])){
	$chat_view = 'logs';
}
?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";

?>
</div>

<table class="table" style="width: 60%;">
	<thead>
		<th><h4>Server/panel information</h4></th>
	</thead>

	<tbody>
		<?php if($chat_enabled == 1) {?>
		<tr>
			<td>
				<ul class="nav nav-pills">
				  <li class="<?php if($chat_view == 'logs') { echo 'active'; }?>"><a href="admin.php?logs">Logs</a></li>
				  <li class="<?php if($chat_view == 'chat') { echo 'active'; }?>"><a class="" href="admin.php?chat">Chat</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<div class="chat" style="height: 300px; overflow:auto;">
					<?php 
						include('chat.php');
					?>
				</div>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td>
				<form action="admin.php?view=actions" method="post">
					<textarea name="say" style="width: 80%;">Type something to Global Chat</textarea>
					<input type="submit" class="btn btn-default" style="margin-top: 5px"/>
				</form>
			</td>
		</tr>
	</tbody>
</table>

<table class="table pull-right" style="width: 35%; <?php if($chat_enabled == 0) {?>margin-top: -140px;<?php } elseif ($chat_enabled == 1) {?>margin-top: -513px;<?php }?>">
	<thead>
		<th><h4>Panel Logs</h4></th>
	</thead>

	<tbody>
		<tr>
			<td>
				<textarea style="width: 100%; height: 200px;" readonly><?php echo $logs; ?></textarea>
			</td>
		</tr>
	</tbody>
</table>
</body>
<?php
}
else
{
	header('Location: admin.php');
}
?>
