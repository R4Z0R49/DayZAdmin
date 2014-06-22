<?php

if (isset($_SESSION['user_id']) && $accesslvls[0][4] != 'false')
{
	if (isset($_REQUEST['type'])){
		$pagetitle = "Search for ".$_REQUEST['type'];
	} else {
		$pagetitle = "New search";
	}
?>
<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";

?>
</div>
		<?php
        require_once('queries.php');
		?><br/><?php
		if (isset($_REQUEST['type']))
		{
			error_reporting (E_ALL ^ E_NOTICE);
			$search = '%'.substr($_REQUEST['search'], 0, 64).'%';

			?>
			<table border="0" width="100%">
			<?php
    		$chbox = "";
			switch ($_REQUEST['type']) {
				case 'player':
					$tableheader = header_player(0);
					echo $tableheader;
					$res = $db->GetAll($search_query_player, array($search, $search));
					$tablerows = "";
					foreach($res as $row) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
				break;
				case 'item':
					$tableheader = header_player(0);
					echo $tableheader;
					$res = $db->GetAll($search_query_item, array($search, $search));
					$tablerows = "";
					foreach($res as $row) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
					break;
				case 'vehicle':
					$tableheader = header_vehicle(0, $chbox);
					echo $tableheader;
					$res = $db->GetAll($search_query_vehicle, array($iid, $search));
					$tablerows = "";
					foreach($res as $row) {
							$tablerows .= row_vehicle($row, $chbox);
					}
					echo $tablerows;
					break;
				case 'container':
   					$res = $db->GetAll($search_query_container, array($iid, $search));
    				$tablerows = "";
	    			$tablerows_veh = "";
   					foreach($res as $row) {
                        if(preg_match('/TentStorage|StashSmall|StashMedium/', $row['Classname'])) {
           				    $tablerows .= row_deployable($row, $chbox);
                        } else {
   			    			$tablerows_veh .= row_vehicle($row, $chbox);
                        }
	    			}
   					$tableheader = header_vehicle(0, $chbox);
                    echo "<tr><th colspan=\"6\" align=\"left\">Vehicles</th></tr>\n";
	    			echo $tableheader;
		    		echo $tablerows_veh;
			    	$tableheader = header_deployable(0, $chbox);
                    echo "</table>\n<br>\n<table border=\"0\" width=\"100%\">\n";
                    echo "<tr><th colspan=\"5\" align=\"left\">Tents/Stashes</th></tr>\n";
    				echo $tableheader;
	    			echo $tablerows;
    				break;
				default:
					$tableheader = header_player(0);
					echo $tableheader;
                    $res = $db->GetAll($search_query_player, $search);
					$tablerows = "";
					foreach($res as $row) {
    				    $tablerows .= row_player($row);
					}
					echo $tablerows;
				};
			?>
			</table>
			<?php
		}
		else
		{

		}
		?>		
<?php
}
else
{
	if ($accesslvls[0][4] != 'true') {
		$message->add('danger', "You dont have enough access to view this");
		$message->display();
	}
}
?>
