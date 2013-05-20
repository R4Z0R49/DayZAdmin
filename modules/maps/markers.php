<?php
include('config.php');
require_once('functions.php');

function markers_player($res, $world) {
	$markers = array();
		foreach($res as $row) {
			$Worldspace = str_replace("[", "", $row['worldspace']);
			$Worldspace = str_replace("]", "", $Worldspace);
			$Worldspace = explode(",", $Worldspace);
			$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
			$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

			require_once('modules/calc.php');
			$description = "<h2><a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['cid']."\">".htmlspecialchars($row['name'], ENT_QUOTES)." - ".$row['unique_id']."</a></h2> <table> <tr> <td><img style=\"width: 100px;\" src=\"images/models/".str_replace('"', '', $row['model']).".png\"></td> <td>&nbsp;</td> <td style=\"vertical-align:top; \"> <strong>PlayerID:</strong> ".$row['id']."<br> <strong>CharacterID:</strong> ".$row['unique_id']."<br> <strong>Zed Kills:</strong> ".$row['zombie_kills']."<br> <strong>Bandit Kills:</strong> ".$row['bandit_kills']."<br> <strong>Alive Duration:</strong> ".survivalTimeToString($row['survival_time'])."<br><strong>Position:</strong>&nbsp;".sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world)))."<br><strong>Humanity:</strong>&nbsp;".$row['humanity']."</td></tr></table>";	
			$tmp = array();
			$tmp["id"] = $row['unique_id'];
			$tmp["lat"] = (world_y($y, $world) / 10);
			$tmp["lng"] = (world_x($x, $world) / 10);
			$tmp["icon"] = "Player".($row['is_dead'] ? "Dead" : "");
			$tmp["title"] = htmlspecialchars($row['name'], ENT_QUOTES)." (".$row['unique_id'].")";
			$tmp["description"] = $description;
			$tmp["zIndexOffset"] = 21000;
			
			$markers[] = $tmp;
		}

	return $markers;
}

function markers_vehicle($res, $world) {
	$markers = array();

	$xml = file_get_contents('vehicles.xml', true);
	require_once('modules/xml2array.php');
	$vehicles_xml = XML2Array::createArray($xml);

	foreach($res as $row) {
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$class = $row['class_name'];
		$type = $row['Type'];
		require_once('modules/calc.php');
		$description = '<h2><a href="admin.php?view=info&show=4&id='.$row['id'].'">'.$class.' ('.$row['id'].')</a></h2><strong>Last updated:</strong>&nbsp;'.$row['last_updated'].'<br><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$class.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align: top;"><strong>Position:</strong>&nbsp;'.sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world))).'<br><strong>Damage:</strong>&nbsp;'.sprintf("%d%%", round($row['damage'] * 100))."<br><strong>Fuel:</strong>&nbsp;".sprintf("%d%%", round($row['fuel'] * 100)).'</td></tr></table><br>';
		
		$tmp = array();
		$tmp["id"] = $row['id'];
		$tmp["lat"] = (world_y($y, $world) / 10);
		$tmp["lng"] = (world_x($x, $world) / 10);
		$tmp["icon"] = $type;
		$tmp["title"] = $class." (".$row['id'].")";
		$tmp["description"] = $description;
		$tmp["zIndexOffset"] = 20000;
		
		$markers[] = $tmp;
	};
	
	return $markers;
}

function markers_deployable($res, $world) {
	$markers = array();

    require_once('modules/xml2array.php');
	$xml = file_get_contents('items.xml', true);
    $items_xml = XML2Array::createArray($xml);
	$xml = file_get_contents('vehicles.xml', true);
	$vehicles_xml = XML2Array::createArray($xml);

	foreach($res as $row) {
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$class = $row['Classname'];
		$type = $row['Type'];

		require_once('modules/calc.php');
		$contents = "";
		if($type == "tent") {
			$Inventory  = $row['inventory'];
			$Inventory = str_replace("|", ",", $Inventory);
			$Inventory  = json_decode($Inventory);
			$counts = inventoryCounts($Inventory, $items_xml, $vehicles_xml);
			$contents = "<strong>Weapons:</strong>&nbsp;".$counts[0]."<br><strong>Items:</strong>&nbsp;".$counts[1]."<br><strong>Backpacks:</strong>&nbsp;".$counts[2];
		}
		$description = '<h2><a href="admin.php?view=info&show=6&id='.$row['id'].'">'.$class.' ('.$row['id'].')</a> - '.htmlspecialchars($row['name']).'</h2><strong>Last updated:</strong>&nbsp;'.$row['last_updated'].'<br><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$class.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align: top;"><strong>Position:</strong>&nbsp;'.sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world))).'<br>'.$contents.'</td></tr></table>';
		
		$tmp = array();
		$tmp["id"] = $row['idid'];
		$tmp["lat"] = (world_y($y, $world) / 10);
		$tmp["lng"] = (world_x($x, $world) / 10);
		$tmp["icon"] = $type;
		$tmp["title"] = $class." (".$row['id'].") - ".htmlspecialchars($row['name']);
		$tmp["description"] = $description;
		$tmp["zIndexOffset"] = 10000;
		
		$markers[] = $tmp;
	};
	
	return $markers;
}

?>
