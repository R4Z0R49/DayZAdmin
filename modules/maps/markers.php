<?php
include('config.php');
require_once('functions.php');


function markers_player($res, $world) {
	$markers = array();
		foreach($res as $row) {
			include('rowlayout.php');
			$Worldspace = str_replace("[", "", $row[$row_Worldspace]);
			$Worldspace = str_replace("]", "", $Worldspace);
			$Worldspace = explode(",", $Worldspace);
			$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
			$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

			require_once('modules/calc.php');
			$description = "<h2><a href=\"admin.php?view=info&show=1&id=".$row[$row_PlayerUID]."\">".htmlspecialchars($row[$row_playerName], ENT_QUOTES)." - ".$row[$row_PlayerUID]."</a></h2> <table> <tr> <td><img style=\"width: 100px;\" src=\"images/models/".str_replace('"', '', $row[$row_Model]).".png\"></td> <td>&nbsp;</td> <td style=\"vertical-align:top; \"> <strong>PlayerID:</strong> ".$row[$row_PlayerID]."<br> <strong>CharacterID:</strong> ".$row[$row_PlayerUID]."<br> <strong>Zed Kills:</strong> ".$row[$row_KillsZ]."<br> <strong>Bandit Kills:</strong> ".$row[$row_KillsB]."<br> <strong>Alive Duration:</strong> ".survivalTimeToString($row[$row_duration])."<br><strong>Position:</strong>&nbsp;".sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world)))."<br><strong>Humanity:</strong>&nbsp;".$row[$row_Humanity]."</td></tr></table>";	
			$tmp = array();
			$tmp["id"] = $row[$row_id];
			$tmp["lat"] = (world_y($y, $world) / 10);
			$tmp["lng"] = (world_x($x, $world) / 10);
			$tmp["icon"] = "Player".($row[$row_Alive] ? "Dead" : "");
			$tmp["title"] = htmlspecialchars($row[$row_playerName], ENT_QUOTES)." (".$row[$row_PlayerUID].")";
			$tmp["description"] = $description;
			
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
		include('rowlayout.php');
		$Worldspace = str_replace("[", "", $row[$row_ObjectWorldspace]);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$class = $row[$row_ObjectClassname];
		$type = $row[$row_ObjectType];
		require_once('modules/calc.php');
		$description = '<h2><a href="admin.php?view=info&show=4&id='.$row[$row_ObjectID].'">'.$class.' ('.$row[$row_ObjectID].')</a></h2><strong>Last updated:</strong>&nbsp;'.$row[$row_Objectlast_updated].'<br><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$class.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align: top;"><strong>Position:</strong>&nbsp;'.sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world))).'<br><strong>Damage:</strong>&nbsp;'.sprintf("%d%%", round($row[$row_ObjectDamage] * 100))."<br><strong>Fuel:</strong>&nbsp;".sprintf("%d%%", round($row[$row_ObjectFuel] * 100)).'</td></tr></table><br>';
		
		$tmp = array();
		$tmp["id"] = $row[$row_ObjectID];
		$tmp["lat"] = (world_y($y, $world) / 10);
		$tmp["lng"] = (world_x($x, $world) / 10);
		$tmp["icon"] = $type;
		$tmp["title"] = $class." (".$row[$row_ObjectID].")";
		$tmp["description"] = $description;
		
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
		include('rowlayout.php');
		$Worldspace = str_replace("[", "", $row[$row_ObjectWorldspace]);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$class = $row[$row_ObjectClassname];
		$type = $row[$row_ObjectType];

		require_once('modules/calc.php');
		$contents = "";
		if($type == "tent") {
			$Inventory  = $row[$row_ObjectInventory];
			$Inventory = str_replace("|", ",", $Inventory);
			$Inventory  = json_decode($Inventory);
			$counts = inventoryCounts($Inventory, $items_xml, $vehicles_xml);
			$contents = "<strong>Weapons:</strong>&nbsp;".$counts[0]."<br><strong>Items:</strong>&nbsp;".$counts[1]."<br><strong>Backpacks:</strong>&nbsp;".$counts[2];
		}
		$description = '<h2><a href="admin.php?view=info&show=6&id='.$row[$row_ObjectID].'">'.$class.' ('.$row[$row_ObjectID].')</a> - '.htmlspecialchars($row[$row_playerName]).'</h2><strong>Last updated:</strong>&nbsp;'.$row[$row_Objectlast_updated].'<br><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$class.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align: top;"><strong>Position:</strong>&nbsp;'.sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world))).'<br>'.$contents.'</td></tr></table>';
		
		$tmp = array();
		$tmp["id"] = $row[$row_ObjectID];
		$tmp["lat"] = (world_y($y, $world) / 10);
		$tmp["lng"] = (world_x($x, $world) / 10);
		$tmp["icon"] = $type;
		$tmp["title"] = $class." (".$row[$row_ObjectID].") - ".htmlspecialchars($row['name']);
		$tmp["description"] = $description;
		
		$markers[] = $tmp;
	};
	
	return $markers;
}

?>
