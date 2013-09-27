<?php

if (isset($_SESSION['user_id']) && $accesslvls[0][4] != 'false')
{
	if (isset($_POST['type'])){
		$pagetitle = "Search for ".$_POST['type'];
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
		include ('searchbar.php');
		?><br/><?php
		if (!empty($_POST))
		{
			error_reporting (E_ALL ^ E_NOTICE);
			$search = '%'.substr($_POST['search'], 0, 64).'%';

			?>
			<table border="0" width="100%">
			<?php
    		$chbox = "";
			switch ($_POST['type']) {
				case 'player':
					$tableheader = header_player(0);
					echo $tableheader;
					$res = $db->GetAll($search_query_player, $search);
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
                    if($sql == "DayZ") {
    					$res = $db->GetAll($search_query_container, array($iid, $search));
	    				$tablerows = "";
		    			$tablerows_veh = "";
    					foreach($res as $row) {
                            if($row['class_name'] == "TentStorage" || $row['class_name'] == "StashSmall" || $row['class_name'] == "StashMedium") {
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
                    } else {
                        $res = $db->GetAll($search_query_container_veh, array($iid, $search));
                        $tablerows = "";
                        foreach($res as $row) {
                            $tablerows .= row_vehicle($row, $chbox);
                        }
                        $tableheader = header_vehicle(0, $chbox);
                        echo "<tr><th colspan=\"6\" align=\"left\">Vehicles</th></tr>\n";
                        echo $tableheader;
                        echo $tablerows;
                        echo "</table>\n<br>\n<table border=\"0\" width=\"100%\">\n";
                        $res = $db->GetAll($search_query_container, array($iid, $search));
                        $tablerows = "";
                        foreach($res as $row) {
                            $tablerows .= row_deployable($row, $chbox);
                        }
                        $tableheader = header_deployable(0, $chbox);
                        echo "<tr><th colspan=\"6\" align=\"left\">Tents/Stashes</th></tr>\n";
                        echo $tableheader;
                        echo $tablerows;
                    }
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
