<?php
if (isset($_SESSION['user_id']))
{
ini_set( "display_errors", 0);
error_reporting (E_ALL ^ E_NOTICE);
require_once 'GameQ.php';

// Define your servers,
// see list.php for all supported games and identifiers.
$servers = array(
    'server1' => array('armedassault2', '79.174.32.203')
);


// Call the class, and add your servers.
$gq = new GameQ();
$gq->addServers($servers);

echo "<title>Server info - ".$sitename."</title>";
    
// You can optionally specify some settings
$gq->setOption('timeout', 30);


// You can optionally specify some output filters,
// these will be applied to the results obtained.
$gq->setFilter('normalise');
$gq->setFilter('sortplayers', 'gq_ping');

// Send requests, and parse the data
$oresults = $gq->requestData();
//print_r($oresults);
// Some functions to print the results
function print_results($oresults) {

    foreach ($oresults as $id => $data) {

        //printf("<h2>%s</h2>\n", $id);		
        print_table($data);
    }

}

function print_table($data) {  

    if (!$data['gq_online']) {
        printf("<p>The server did not respond within the specified time.</p>\n");
        return;
    }
	
	
?>	
	<div id="page-heading">
		<h1><?php echo $data['gq_hostname']; ?></h1>
	</div>
	<!-- end page-heading -->

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
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
			
			<h2>Address:</h2><h3><?php echo $data['gq_address']; ?>:<? echo $data['gq_port']; ?></h3>
			<h2>Mods:</h2><h3><?php echo $data['gq_mod']; ?></h3>
			<h2>Max players:</h2><h3><?php echo $data['gq_maxplayers']; ?></h3>
			<h2>Online players:</h2><h3><?php echo $data['gq_numplayers']; ?></h3>
					
			<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
			<tr>
				<th class="table-header-repeat line-left minwidth-1"><a href="">Player Name</a>	</th>
				<th class="table-header-repeat line-left minwidth-1"><a href="">Player ID</a></th>
				<!--  <th class="table-header-repeat line-left"><a href="">Sex</a></th>  -->
				<th class="table-header-repeat line-left minwidth-1"><a href="">Position</a></th>
				<th class="table-header-repeat line-left"><a href="">Inventory</a></th>
				<th class="table-header-repeat line-left"><a href="">Backpack</a></th>
			</tr>
			<?php
			$players = $data['players'];		
			
			
			foreach ($players as $key => $val) {
				
				$query = "SELECT * FROM profiles WHERE name = '".$val['player_']."' ORDER BY lastupdate DESC LIMIT 1"; 
				$res = mysql_query($query) or die(mysql_error());
				$number = mysql_num_rows($res);
				while ($row=mysql_fetch_array($res)) {
					$Worldspace = str_replace("[", "", $row['pos']);
					$Worldspace = str_replace("]", "", $Worldspace);
					$Worldspace = explode(",", $Worldspace);
					
					echo "<tr>
						<td align=\"center\"><a href=\"admin.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$val['player_']."</a></td>
						<td align=\"center\"><a href=\"admin.php?view=info&show=1&id=".$row['uid']."&cid=".$row['id']."\">".$row["uid"]."</a></td>
						<td align=\"center\">left:".round(($Worldspace[1]/100))." top:".round((154-($Worldspace[2]/100)))."</td>
						<td align=\"center\">".substr($row['inventory'], 0, 50) . "...</td>
						<td align=\"center\">".substr($row['backpack'], 0, 50) . "...</td>
						<tr>";
				}
			}		
			?>								
			</table>
			
			</div>
			<!--  end table-content  -->
	
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
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
    print_results($oresults);
}
else
{
	header('Location: admin.php');
}
?>