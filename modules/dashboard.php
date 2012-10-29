<?php
if (isset($_SESSION['user_id']))
{

ini_set( "display_errors", 0);
error_reporting (E_ALL ^ E_NOTICE);


$pagetitle = "Dashboard";

$logs = "";
$query = "SELECT * FROM `logs` ORDER BY `timestamp` DESC LIMIT 100";
$res = mysql_query($query) or die(mysql_error());
while ($row=mysql_fetch_array($res)) {
	$logs .= $row['timestamp'].' '.$row['user'].': '.$row['action'].chr(13);
}
$xml = file_get_contents('quicklinks.xml', true);

require_once('xml2array.php');
$quicklinks = XML2Array::createArray($xml);

?>
<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";

?>
</div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?php echo $path;?>images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?php echo $path;?>images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<div id="content-table-inner">	
		<!--  start content-table-inner ...................................................................... START -->
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
			<tr>
				<th class="table-header-repeat line-left minwidth-1"><a href="">Say to global chat</a>	</th>
				<th class="table-header-repeat line-left minwidth-1"><a href="">Actions log</a></th>
			</tr>
			<tr>
				<td align="center" width="50%">
					<div id="quicklinks">
						<ul>
					<?php
						include ('say.php');
					?>
						</ul>
					</div>
				</td>
				<td align="center" width="50%">
					<textarea cols="68" rows="12" readonly><?php echo $logs; ?></textarea>
				</td>	
			</tr>				
		</table>		
		<!--  end content-table-inner ............................................END  -->
		</div>
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>
<?php
}
else
{
	header('Location: admin.php');
}
?>