<?php
if (isset($_SESSION['user_id']) && $accesslvls[0][5] != 'false')
{

	$pagetitle = "Items check (survivors, tents and vehicles)";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('ITEMS CHECK',?,NOW())", $_SESSION['login']);
?>
<?php
    include('queries.php');
	//ini_set('max_execution_time', 300);
	echo "<div id='page-heading'>";
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1></div>";
	
	error_reporting (E_ALL ^ E_NOTICE);
	
	//$items_ini = parse_ini_file("/items.ini", true);
	$xml = file_get_contents('items.xml', true);
	require_once('modules/xml2array.php');
	$items_xml = XML2Array::createArray($xml);
	
	//$query = "SELECT * FROM survivor";
	$res = $db->GetAll($check_player);
	$number = sizeof($res);
	$rows = null;
	$itemscount = 0;		
	if ($number == 0) {
	  	echo "<CENTER>\n";
	} else {
		foreach($res as $row) {
			$Inventory = $row['Inventory'];	
			$Inventory = str_replace(",", ",", $Inventory);
			$Inventory = json_decode($Inventory);
		
			$Backpack = $row['Backpack'];
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
			
			$name = htmlspecialchars($row['playerName']);	
			$icon1 = '<a href="admin.php?view=actions&deletecheck='.$row['id'].'"><img src="'.$path.'images/icons/player_dead.png" title="Delete '.$name.'" alt="Delete '.$name.'"/></a>';		
			if ($row['Alive'] == 0) {
					$status = '<img src="'.$path.'images/icons/player_dead.png" title="'.$name.' is Dead" alt="'.$name.' is Dead"/>';
			}
			if ($row['Alive'] == 1) {
					$status = '<img src="'.$path.'images/icons/player.png" title="'.$name.' is Alive" alt="'.$name.' is Alive"/>';
			}
			if (count($Unknown)>0) {
				$rows .= "<tr>
					<td align=\"center\" class=\"gear_preview\"><a href=\"amin.php?view=actions&deletecheck=".$row['CharacterID']."\">".$icon1."</td>
					<td align=\"center\" class=\"gear_preview\">".$status."</td>
					<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&CharacterID=".$row['CharacterID']."\">".$name."</a></td>
					<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=1&CharacterID=".$row['CharacterID']."\">".$row['CharacterID']."</a></td>
					<td align=\"center\" class=\"gear_preview\">";
					foreach($Unknown as $uitem => $uval) {
						$rows .= $uval."; ";
						$itemscount++;
					}
				$rows .= "</td></tr>";
			}
		}
	}
	
	$res = $db->GetAll($check_deployable, $iid);
    if (sizeof($res) > 0) {
		foreach($res as $row) {
			$Inventory = $row['Inventory'];
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
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=6&ObjectID='.$row['ObjectID'].'"><img src="images/icons/tent.png"></a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=1&CharacterID='.$row['CharacterID'].'">'.$row['playerName'].'</a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=6&ObjectID='.$row['ObjectID'].'">'.$row['ObjectID'].'</a></td>
					<td align="center" class="gear_preview">';

				foreach ($Unknown as $item) {
					$rows .= $item."; ";
					$itemscount++;
				}

				$rows .= '</td></tr>';
			}
		}
	}

	$res = $db->GetAll($check_vehicle, $iid);
    if (sizeof($res) > 0) {
        foreach($res as $row) {
            $Inventory = $row['Inventory'];
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
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=4&ObjectID='.$row['ObjectID'].'"><img src="images/icons/car.png" /></a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=4&ObjectID='.$row['ObjectID'].'">'.$row['Classname'].'</a></td>
					<td align="center" class="gear_preview"><a href="admin.php?view=info&show=4&ObjectID='.$row['ObjectID'].'">'.$row['ObjectID'].'</a></td>
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
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="table">
	<tr>
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
								<td>
									<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<b>WARNING! <?php echo $itemscount;?> unknown items found!</b>
									</div>
								</td>
							</tr>
						</table>
					</div>			
					<!--  end message-red -->
					<!--  start product-table ..................................................................................... -->
					<table border="0" width="100%" id="product-table">
						<tr>
							<th width="8%" class="custom-th" style="text-align: center;"><a href=""><h4>Remove</h4></a></th>
							<th width="8%" class="custom-th" style="text-align: center;"><a href=""><h4>Status</h4></a></th>
							<th width="20%" class="custom-th" style="text-align: center;"><a href=""><h4>Name</h4></a></th>
							<th width="10%" class="custom-th" style="text-align: center;"><a href=""><h4>UID</h4></a></th>
							<th width="56%" class="custom-th" style="text-align: center;"><a href=""><h4>Unknown items</h4></a></th>
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
									<td>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<b>No banned items found!</b>
									</div>
									</td>
								</tr>
							</table>
						</div>
					<?php } ?>
				</div>
				<!--  end content-table  -->					
			</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
	</tr>
</table>
</div>
<?php
}
else
{
	if ($accesslvls[0][5] != 'true') {
		$message->add('danger', "You dont have enough access to view this");
		$message->display();
	}
}
?>
