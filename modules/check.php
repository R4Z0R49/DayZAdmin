<?php
if (!isset($_SESSION['user_id'])) {
	header('Location: admin.php');
} else {

	$pagetitle = "Items check (survivors, tents and vehicles)";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('ITEMS CHECK',?,NOW())", $_SESSION['login']);

	//ini_set('max_execution_time', 300);
	echo "<div id=\"page-heading\">";
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";
	
	error_reporting (E_ALL ^ E_NOTICE);
	
	//$items_ini = parse_ini_file("/items.ini", true);
	$xml = file_get_contents('items.xml', true);
	require_once('modules/xml2array.php');
	$items_xml = XML2Array::createArray($xml);
	
	//$query = "SELECT * FROM survivor";
	$rows = "";
	$itemscount = 0;
	$res = $db->GetAll("select p.name, s.* from profile p left join survivor s on p.unique_id = s.unique_id where s.is_dead = 0");	
	if (is_array($res) && count($res) > 0) {
		foreach($res as $row) {
			$Inventory = $row['inventory'];	
			$Inventory = str_replace(",", ",", $Inventory);
			$Inventory = json_decode($Inventory);
		
			$Backpack = $row['backpack'];
			$Backpack = str_replace(",", ",", $Backpack);
			$Backpack = json_decode($Backpack);

			$Unknown = null;
			$Unknown = array();
			if (is_array($Inventory[0])) {
				if (is_array($Inventory[1])) {
					$Inventory = (array_merge($Inventory[0], $Inventory[1]));
				}
			} else {
				if (is_array($Inventory[1])) {
					$Inventory = $Inventory[1];
				}			
			}				
		
			$bpweaponscount = count($Backpack[1][0]);
			$bpweapons = array();
			for ($m=0; $m<$bpweaponscount; $m++) {
				for ($mi=0; $mi<$Backpack[1][1][$m]; $mi++) {
					$bpweapons[] = $Backpack[1][0][$m];
				}
				//if(array_key_exists(0,$Backpack[1][$m])){
				//	$bpweapons[] = $Backpack[1][$m][0];
				//}
			}		
			$bpitemscount = count($Backpack[2][0]);
			$bpitems = array();
			for ($m=0; $m<$bpitemscount; $m++) {
				for ($mi=0; $mi<$Backpack[2][1][$m]; $mi++) {
					$bpitems[] = $Backpack[2][0][$m];
				}
			}		
			$Backpack = array_merge($bpweapons, $bpitems);
		
			$Inventory = array_merge($Inventory, $Backpack);
							
			for ($i=0; $i<count($Inventory); $i++) {
				if(array_key_exists($i,$Inventory)) {
					$curitem = $Inventory[$i];
					if (is_array($curitem)) {
						$curitem = $Inventory[$i][0];
					}
					if(!array_key_exists('s'.$curitem,$items_xml['items'])) {
						$Unknown[] = $curitem;
					}
				}
			}
			
			$name = htmlspecialchars($row['name']);	
			$icon1 = '<a href="admin.php?view=actions&deletecheck='.$row['id'].'"><img src="'.$path.'images/icons/player_dead.png" title="Delete '.$name.'" alt="Delete '.$name.'"/></a>';		
			if ($row['is_dead'] == 1) {
					$status = '<img src="'.$path.'images/icons/player_dead.png" title="'.$name.' is Dead" alt="'.$name.' is Dead"/>';
			}
			if ($row['is_dead'] == 0) {
					$status = '<img src="'.$path.'images/icons/player.png" title="'.$name.' is Alive" alt="'.$name.' is Alive"/>';
			}
			if (count($Unknown)>0) {
				$rows .= "<tr>
					<td align=\"center\" class=\"gear_preview\"><a href=\"amin.php?view=actions&deletecheck=".$row['unique_id']."\">".$icon1."</td>
					<td align=\"center\" class=\"gear_preview\">".$status."</td>
					<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."\">".$name."</a></td>
					<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&id=".$row['unique_id']."\">".$row['unique_id']."</a></td>
					<td align=\"center\" class=\"gear_preview\">";
					foreach($Unknown as $uitem => $uval) {
						$rows .= $uval."; ";
						$itemscount++;
					}
				$rows .= "</td></tr>";
			}
		}
	}
	
	$res = $db->GetAll("SELECT * FROM v_deployable");
	if (is_array($res) && count($res) > 0) {
		foreach($res as $row) {
			$Inventory = $row['inventory'];
			$Inventory = json_decode($Inventory);
			$Unknown = array();

			$bpweaponscount = count($Inventory[1][0]);
			$bpweapons = array();
			for ($m = 0; $m < $bpweaponscount; $m++) {
				for ($mi = 0; $mi < $Inventory[1][1][$m]; $mi++) {
					$bpweapons[] = $Inventory[1][0][$m];
				}
			}
			$bpitemscount = count($Inventory[2][0]);
			$bpitems = array();
			for ($m = 0; $m < $bpitemscount; $m++) {
				for ($mi = 0; $mi < $Inventory[2][1][$m]; $mi++) {
					$bpitems[] = $Inventory[2][0][$m];
				}
			}

			$Inventory = array_merge($bpweapons, $bpitems);

			for ($i = 0; $i < count($Inventory); $i++) {
				if (array_key_exists($i, $Inventory)) {
					$curitem = $Inventory[$i];
					if (is_array($curitem)) {
						$curitem = $Inventory[$i][0];
					}
					if (!array_key_exists('s'.$curitem, $items_xml['items'])) {
						$Unknown[] = $curitem;
					}
				}
			}

			if (count($Unknown) > 0) {
				$rows .= '<tr>
					<td class="gear_preview">&nbsp;</td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=6&id='.$row['instance_deployable_id'].'"><img src="images/icons/tent.png"></a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=1&id='.$row['owner_unique_id'].'">'.$row['owner_name'].'</a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=6&id='.$row['instance_deployable_id'].'">'.$row['instance_deployable_id'].'</a></td>
					<td align="center" class="gear_preview">';

				foreach ($Unknown as $item) {
					$rows .= $item."; ";
					$itemscount++;
				}

				$rows .= '</td></tr>';
			}
		}
	}

	$res = $db->GetAll("SELECT * FROM v_vehicle");
	if (is_array($res) && count($res) > 0) {
		foreach($res as $row) {
			$Inventory = $row['inventory'];
			$Inventory = json_decode($Inventory);
			$Unknown = array();

			$bpweaponscount = count($Inventory[1][0]);
			$bpweapons = array();
			for ($m = 0; $m < $bpweaponscount; $m++) {
				for ($mi = 0; $mi < $Inventory[1][1][$m]; $mi++) {
					$bpweapons[] = $Inventory[1][0][$m];
				}
			}
			$bpitemscount = count($Inventory[2][0]);
			$bpitems = array();
			for ($m = 0; $m < $bpitemscount; $m++) {
				for ($mi = 0; $mi < $Inventory[2][1][$m]; $mi++) {
					$bpitems[] = $Inventory[2][0][$m];
				}
			}

			$Inventory = array_merge($bpweapons, $bpitems);

			for ($i = 0; $i < count($Inventory); $i++) {
				if (array_key_exists($i, $Inventory)) {
					$curitem = $Inventory[$i];
					if (is_array($curitem)) { $curitem = $Inventory[$i][0]; }
					if (!array_key_exists('s'.$curitem, $items_xml['items'])) { $Unknown[] = $curitem; }
				}
			}

			if (count($Unknown) > 0) {
				$rows .= '<tr>
					<td class="gear_preview">&nbsp;</td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=4&id='.$row['instance_vehicle_id'].'"><img src="images/icons/car.png" /></a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=4&id='.$row['instance_vehicle_id'].'">'.$row['class_name'].'</a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=4&id='.$row['instance_vehicle_id'].'">'.$row['instance_vehicle_id'].'</a></td>
					<td align="center" class="gear_preview">';

				foreach ($Unknown as $item) {
					$rows .= $item."; ";
					$itemscount++;
				}

				$rows .= '</td></tr>';
			}
		}
	}
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
		<!--  start content-table-inner ...................................................................... START -->
			<div id="content-table-inner">	
				<!--  start table-content  -->
				<div id="table-content">
				<!--  start message-red -->
				<?php if ($itemscount > 0) { ?>
					<div id="message-red">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="red-left">WARNING! <?php echo $itemscount;?> unknown items found!</td>
								<td class="red-right"><a class="close-red"><img src="<?php echo $path;?>images/table/icon_close_red.gif"   alt="" /></a></td>
							</tr>
						</table>
					</div>			
					<!--  end message-red -->
					<!--  start product-table ..................................................................................... -->
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
						<tr>
							<th class="table-header-repeat line-left minwidth-1" width="5px"><a href="">Remove</a>	</th>
							<th class="table-header-repeat line-left minwidth-1" width="5px"><a href="">Status</a></th>
							<th class="table-header-repeat line-left minwidth-1" width="5px"><a href="">Name</a>	</th>
							<th class="table-header-repeat line-left minwidth-1" width="5px"><a href="">ID</a></th>
							<th class="table-header-repeat line-left minwidth-1"><a href="">Unknown items</a></th>
						</tr>
						<?php
							echo $rows;
						?>				
					</table>
					<!--  end product-table................................... --> 
					<?php } else { ?>
						<div id="message-green">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td class="green-left">No banned items found!</td>
								</tr>
							</table>
						</div>
					<?php } ?>
				</div>
				<!--  end content-table  -->					
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
<?php } ?>