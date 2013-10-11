<?php
require_once('config.php');
require_once('functions.php');

function markers_player($res, $world) {
	$markers = array();
		foreach($res as $row) {
			$Worldspace = str_replace("[", "", $row['Worldspace']);
			$Worldspace = str_replace("]", "", $Worldspace);
			$Worldspace = explode(",", $Worldspace);
			$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
			$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

            $state = str_replace("[", "", $row['currentState']);
            $state = str_replace("]", "", $state);
            $state = str_replace('"', "", $state);
            $state = explode(",", $state);
            if(is_array($state) && $state[0] != "") {
                $wpnstr = " - " . $state[0];
            } else {
                $wpnstr = "";
            }

			require_once('modules/calc.php');
			$description = "<strong><a href=\"admin.php?view=info&show=1&CharacterID=".$row['CharacterID']."\">".htmlspecialchars($row['playerName'], ENT_QUOTES)."</a>".$wpnstr."</strong><br><table> <tr> <td><img style=\"width: 100px;\" src=\"images/models/".str_replace('"', '', $row['Model']).".png\"></td> <td>&nbsp;</td> <td style=\"vertical-align:top; \"> <strong>PlayerID:</strong> ".$row['PlayerUID']."<br> <strong>CharacterID:</strong> ".$row['CharacterID']."<br> <strong>Zed Kills:</strong> ".$row['KillsZ']."<br> <strong>Bandit Kills:</strong> ".$row['KillsB']."<br> <strong>Alive Duration:</strong> ".survivalTimeToString($row['duration'])."<br><strong>Survival Attempts:</strong> ".$row['Generation']."<br><strong>Position:</strong>&nbsp;".sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world)))."<br><strong>Humanity:</strong>&nbsp;".$row['Humanity']."</td></tr></table>";	
			$tmp = array();
			$tmp["id"] = $row['CharacterID'];
			$tmp["lat"] = (world_y($y, $world) / 10);
			$tmp["lng"] = (world_x($x, $world) / 10);
			$tmp["icon"] = "Player".($row['Alive'] ? "" : "Dead");
			$tmp["title"] = htmlspecialchars($row['playerName'], ENT_QUOTES)." (".$row['CharacterID'].")";
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
		$Worldspace = str_replace("[", "", $row['Worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$class = $row['Classname'];
		$type = $row['Type'];
		require_once('modules/calc.php');
		$description = '<strong><a href="admin.php?view=info&show=4&ObjectID='.$row['ObjectID'].'">'.$class.' ('.$row['ObjectID'].')</a></strong><br><strong>Last updated:</strong>&nbsp;'.$row['last_updated'].'<br><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$class.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align: top;"><strong>Position:</strong>&nbsp;'.sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world))).'<br><strong>Damage:</strong>&nbsp;'.sprintf("%d%%", round($row['Damage'] * 100))."<br><strong>Fuel:</strong>&nbsp;".sprintf("%d%%", round($row['Fuel'] * 100)).'</td></tr></table><br>';
		
		$tmp = array();
		$tmp["id"] = $row['ObjectID'];
		$tmp["lat"] = (world_y($y, $world) / 10);
		$tmp["lng"] = (world_x($x, $world) / 10);
		$tmp["icon"] = $type;
		$tmp["title"] = $class." (".$row['ObjectID'].")";
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
		$Worldspace = str_replace("[", "", $row['Worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$class = $row['Classname'];
		$type = $row['Type'];

		require_once('modules/calc.php');
		$contents = "";
		if($type == "tent" || $type == "StashSmall" || $type == "StashMedium") {
			$Inventory  = $row['Inventory'];
			$Inventory = str_replace("|", ",", $Inventory);
			$Inventory  = json_decode($Inventory);
			$counts = inventoryCounts($Inventory, $items_xml, $vehicles_xml);
			$contents = "<strong>Weapons:</strong>&nbsp;".$counts[0]."<br><strong>Items:</strong>&nbsp;".$counts[1]."<br><strong>Backpacks:</strong>&nbsp;".$counts[2];
		}
		$description = '<strong><a href="admin.php?view=info&show=6&ObjectID='.$row['ObjectID'].'">'.$class.' ('.$row['ObjectID'].')</a> - '.htmlspecialchars($row['playerName']).'</strong><br><strong>Last updated:</strong>&nbsp;'.$row['last_updated'].'<br><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$class.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align: top;"><strong>Position:</strong>&nbsp;'.sprintf("%03d%03d", round(world_x($x, $world)), round(world_y($y, $world))).'<br>'.$contents.'</td></tr></table>';
		
		$tmp = array();
		$tmp["id"] = $row['ObjectID'];
		$tmp["lat"] = (world_y($y, $world) / 10);
		$tmp["lng"] = (world_x($x, $world) / 10);
		$tmp["icon"] = $type;
		$tmp["title"] = $class." (".$row['ObjectID'].") - ".htmlspecialchars($row['playerName']);
		$tmp["description"] = $description;
		$tmp["zIndexOffset"] = 10000;
		
		$markers[] = $tmp;
	};
	
	return $markers;
}

?>
