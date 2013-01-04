<?php

function header_player($show){
	return '<tr>
		<th class="table-header-repeat line-left" width="5%"><a href="">Control</a></th>
		<th class="table-header-repeat line-left" width="13%"><a href="">Player Name</a></th>
		<th class="table-header-repeat line-left" width="7%"><a href="">Player UID</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Inventory preview</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Backpack preview</a></th>
		</tr>';
}

function header_vehicle($show, $chbox){
	return '
		<tr>'.$chbox.'
		<th class="table-header-repeat line-left" width="5%"><a href="">ID</a></th>
		<th class="table-header-repeat line-left" width="13%"><a href="">Classname</a>	</th>
		<th class="table-header-repeat line-left" width="7%"><a href="">Object UID</a></th>
		<th class="table-header-repeat line-left" width="5%"><a href="">Damage</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Inventory</a></th>
		<th class="table-header-repeat line-left" width="22%"><a href="">Hitpoints</a></th>
		</tr>';
}

function row_player($row){
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = explode(",", $Worldspace);
	$x = 0;
	$y = 0;
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	$Inventory = $row['inventory'];
	$Inventory = str_replace(",", ",", $Inventory);
	$Inventory  = json_decode($Inventory);
	if(!is_array($Inventory)) {$Inventory = array();}
	if(array_key_exists(0,$Inventory)){
		if(array_key_exists(1,$Inventory)){
			$Inventory = (array_merge($Inventory[0], $Inventory[1]));
		} else {
			$Inventory = $Inventory[0];
		}
	} else {
		if(array_key_exists(1,$Inventory)){
			$Inventory = $Inventory[1];
		}
	}
	$InventoryPreview = "";
	$limit = 6;
	for ($i=0; $i< $limit; $i++){
		if(array_key_exists($i,$Inventory)){
			//$InventoryPreview .= $Inventory[$i];
			$curitem = $Inventory[$i];
			$icount = "";
			if (is_array($curitem)){$curitem = $Inventory[$i][0]; $icount = ' - '.$Inventory[$i][1].' rounds'; }
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/></div>';
		} else {
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}
	$Backpack  = $row['backpack'];
	$Backpack = str_replace(",", ",", $Backpack);
	$Backpack  = json_decode($Backpack);
	if(array_key_exists(0,$Backpack)){ 
		$bpweapons = array();
		$bpweapons[] = $Backpack[0];
		if(array_key_exists(1,$Backpack)){ 
			$bpweaponscount = count($Backpack[1][0]);				
			for ($m=0; $m<$bpweaponscount; $m++){
					for ($mi=0; $mi<$Backpack[1][1][$m]; $mi++){
						$bpweapons[] = $Backpack[1][0][$m];
					}
			}							
		}
		$bpitems = array();
		if(array_key_exists(1,$Backpack)){ 
			$bpitemscount = count($Backpack[2][0]);
			for ($m=0; $m<$bpitemscount; $m++){
				for ($mi=0; $mi<$Backpack[2][1][$m]; $mi++){
					$bpitems[] = $Backpack[2][0][$m];
				}
			}
		}
		$Backpack = (array_merge($bpweapons, $bpitems));
	}
	$BackpackPreview = "";
	for ($i=0; $i< $limit; $i++){
		if(array_key_exists($i,$Backpack)){
			$curitem = $Backpack[$i];
			if (is_array($curitem)){
				if ($i != 0){
					$curitem = $Backpack[$i][0]; $icount = ' - '.$Backpack[$i][1].' rounds';
				}
			}
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/></div>';
		} else {
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}
	$icon = '<img src="images/icons/player'.($row['is_dead'] ? '_dead' : '').'.png" title="" alt=""/>';
	
	$tablerow = "<tr>
		<td align=\"center\" class=\"gear_preview\">".$icon."</td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$row['name']."</a></td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$row['unique_id']."</a></td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".sprintf("%03d",round($y/100)).sprintf("%03d",round((154-($x/100))))."</a></td>
		<td align=\"center\" class=\"gear_preview\">".$InventoryPreview."</td>
		<td align=\"center\" class=\"gear_preview\">".$BackpackPreview. "</td>
	</tr>";
	return $tablerow;	
}

function row_online_player($row, $player){
	//$queryinfo = "SELECT * FROM survivor WHERE is_dead=0 AND unique_id like '" . $row['unique_id'] . "'";

	//$resinfo = mysql_query($queryinfo) or die(mysql_error());								
	//$rowinfo = mysql_fetch_array($resinfo);
	$x = 0;
	$y = 0;
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = explode(",", $Worldspace);					
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	$dead = ($row['is_dead'] ? '_dead' : '');
	$Inventory = $row['inventory'];
	$Inventory = str_replace("|", ",", $Inventory);
	$Inventory  = json_decode($Inventory);
	if(array_key_exists(0,$Inventory)){
		if(array_key_exists(1,$Inventory)){
			$Inventory = (array_merge($Inventory[0], $Inventory[1]));
		} else {
			$Inventory = $Inventory[0];
		}
	} else {
		if(array_key_exists(1,$Inventory)){
			$Inventory = $Inventory[1];
		}
	}
	$InventoryPreview = "";
	$limit = 6;
	for ($p=0; $p< $limit; $p++){
		if(array_key_exists($p,$Inventory)){
			$curitem = $Inventory[$p];
			$pcount = "";
			if (is_array($curitem)){$curitem = $Inventory[$p][0]; $pcount = ' - '.$Inventory[$p][1].' rounds'; }
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$pcount.'" alt="'.$curitem.$pcount.'"/></div>';
		} else {
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}
	$Backpack  = $row['backpack'];
	$Backpack = str_replace("|", ",", $Backpack);
	$Backpack  = json_decode($Backpack);
	if(!is_array($Backpack)) {$Backpack = array();}
	if(array_key_exists(0,$Backpack)){ 
		$bpweapons = array();
		$bpweapons[] = $Backpack[0];
		if(array_key_exists(1,$Backpack)){ 
			if(array_key_exists(0,$Backpack[1])){ 
				$bpweaponscount = count($Backpack[1][0]);				
				for ($m=0; $m<$bpweaponscount; $m++){
						for ($mi=0; $mi<$Backpack[1][1][$m]; $mi++){
							$bpweapons[] = $Backpack[1][0][$m];
						}
				}	
			}							
		}
		$bpitems = array();
		if(array_key_exists(1,$Backpack)){ 
			if(array_key_exists(0,$Backpack[2])){ 
				$bpitemscount = count($Backpack[2][0]);
				for ($m=0; $m<$bpitemscount; $m++){
					for ($mi=0; $mi<$Backpack[2][1][$m]; $mi++){
						$bpitems[] = $Backpack[2][0][$m];
					}
				}
			}
		}
		$Backpack = (array_merge($bpweapons, $bpitems));
	}
	$BackpackPreview = "";
	for ($p=0; $p< $limit; $p++){
		if(!is_array($Backpack)) {$Backpack = array();}
		if(array_key_exists($p,$Backpack)){
			$curitem = $Backpack[$p];
			if (is_array($curitem)){
				if ($p != 0){
					$curitem = $Backpack[$p][0]; $pcount = ' - '.$Backpack[$p][1].' rounds';
				}
			}
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$pcount.'" alt="'.$curitem.$pcount.'"/></div>';
		} else {
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}
	$name = "<a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."\">".$player[4]."</a>";
	$uid = "<a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."\">".$row["unique_id"]."</a>";
	

	$icon = '<a href="admin.php?view=actions&kick='.$player[0].'"><img src="images/icons/player.png" title="Kick '.$player[4].'" alt="Kick '.$player[4].'"/></a>';
	$icon1 = '<a href="admin.php?view=actions&ban='.$player[0].'"><img src="images/icons/player_dead.png" title="Ban '.$player[4].'" alt="Ban '.$player[4].'"/></a>';
	$icon2 = '<a href="admin.php?view=actions&resetlocation='.$row['id'].'"><img src="images/icons/Wire.png" title="ResetLocation '.$player[4].'" alt="ResetLocation '.$row['id'].'"/></a>';
	
	$tablerow = "<tr>
				<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\">".$icon.$icon1.$icon2."</td>
				<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\">".$name."</td>
				<td align=\"center\" class=\"gear_preview\">".$uid."</td>

				<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".sprintf("%03d",round($y/100)).sprintf("%03d",round((154-($x/100))))."</a></td>
				<td align=\"center\" class=\"gear_preview\">".$InventoryPreview."</td>
				<td align=\"center\" class=\"gear_preview\">".$BackpackPreview."</td>
				<tr>";
	return $tablerow;	
}

function row_vehicle($row, $chbox){
	$x = 0;
	$y = 0;
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = explode(",", $Worldspace);					
	if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
	if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
	$Inventory  = $row['inventory'];
	$Inventory = str_replace("", ",", $Inventory);
	$Inventory  = json_decode($Inventory);
	$limit = 6;
	if(count($Inventory) >0){ 
		$bpweapons = array();
		if(array_key_exists(0,$Inventory)){ 
			$bpweaponscount = count($Inventory[0][0]);				
			for ($m=0; $m<$bpweaponscount; $m++){
					for ($mi=0; $mi<$Inventory[0][1][$m]; $mi++){
						$bpweapons[] = $Inventory[0][0][$m];
					}
			}							
		}

						
		$bpitems = array();
		if(array_key_exists(1,$Inventory)){ 
			$bpitemscount = count($Inventory[1][0]);
			for ($m=0; $m<$bpitemscount; $m++){
				for ($mi=0; $mi<$Inventory[1][1][$m]; $mi++){
					$bpitems[] = $Inventory[1][0][$m];
				}
			}
		}
		$bpacks = array();
		if(array_key_exists(2,$Inventory)){ 
			$bpackscount = count($Inventory[2][0]);
			for ($m=0; $m<$bpackscount; $m++){
				for ($mi=0; $mi<$Inventory[2][1][$m]; $mi++){
					$bpacks[] = $Inventory[2][0][$m];
				}
			}
		}
		$Inventory = (array_merge($bpweapons, $bpacks, $bpitems));
	}
	$InventoryPreview = "";
	for ($i=0; $i< $limit; $i++){
		if(array_key_exists($i,$Inventory)){
			$curitem = $Inventory[$i];
			if (is_array($curitem)){
				if ($i != 0){
					$curitem = $Inventory[$i][0]; $icount = ' - '.$Inventory[$i][1].' rounds';
				}
			}
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/></div>';
		} else {
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}
	
	$Hitpoints  = $row['parts'];
	$Hitpoints = str_replace(",", ",", $Hitpoints);
	$Hitpoints  = json_decode($Hitpoints);
	$HitpointsPreview = "";
	for ($i=0; $i< $limit; $i++){
		if(array_key_exists($i,$Hitpoints)){
			$curitem = $Hitpoints[$i];
			$HitpointsPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;background-color: rgba(100,'.round((255/100)*(100 - ($curitem[1]*100))).',0,0.8);"><img style="max-width:43px;max-height:43px;" src="images/hits/'.$curitem[0].'.png" title="'.$curitem[0].' - '.round(100 - ($curitem[1]*100)).'%" alt="'.$curitem[0].' - '.round(100 - ($curitem[1]*100)).'%"/></div>';
		}			
	}	
	
	$tablerow = "<tr>".$chbox."
		<td align=\"center\" class=\"gear_preview\" ><a href=\"admin.php?view=info&show=4&id=".$row['instance_vehicle_id']."\">".$row['id']."</a></td>
		<td align=\"center\" class=\"gear_preview\" ><a href=\"admin.php?view=info&show=4&id=".$row['id']."\">".$row['class_name']."</a></td>			
		<td align=\"center\" class=\"gear_preview\" ><a href=\"admin.php?view=info&show=4&id=".$row['id']."\">".$row['id']."</a></td>
		<td align=\"center\" class=\"gear_preview\" style=\"background-color: rgba(100,".round((255/100)*(100 - ($row['damage']*100))).",0,0.8);\">".substr($row['damage'], 0, 6)."</td>
		<td align=\"center\" class=\"gear_preview\" ><a href=\"admin.php?view=info&show=4&id=".$row['id']."\">".sprintf("%03d",round($y/100)).sprintf("%03d",round((154-($x/100))))."</a></td>
		<td align=\"center\" class=\"gear_preview\">".$InventoryPreview."</td>
		<td align=\"center\" class=\"gear_preview\">".$HitpointsPreview. "</td>
	</tr>";
	return $tablerow;
}

?>
