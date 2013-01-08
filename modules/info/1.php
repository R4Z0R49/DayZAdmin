<?php
$cid = '';
if (isset($_GET['cid'])){
	$cid = " AND id ='".$_GET['cid']."'";
}
$query = "SELECT * FROM survivor WHERE unique_id like '".$_GET['id']."' AND is_dead=0 LIMIT 1"; 
$res = mysql_query($query) or die(mysql_error());
$number = mysql_num_rows($res);

$queryname = "SELECT * FROM profile WHERE unique_id like '".$_GET['id']."' LIMIT 1";
$resname = mysql_query($queryname) or die(mysql_error());
$rowname = mysql_fetch_array($resname);

while ($row=mysql_fetch_array($res)) {

	
	$MapCoords = worldspaceToMapCoords($row['worldspace'], $map);
	$Inventory = $row['inventory'];
	$Inventory = str_replace("|", ",", $Inventory);
	//$Inventory = str_replace('"', "", $Inventory);
	$Inventory  = json_decode($Inventory);
	
	$Backpack  = $row['backpack'];
	$Backpack = str_replace("|", ",", $Backpack);
	//$Backpack  = str_replace('"', "", $Backpack );
	$Backpack  = json_decode($Backpack);
	$model = $row['model'];
	
	$binocular = array();
	$rifle = '<img style="max-width:220px;max-height:92px;" src="images/gear/rifle.png" title="" alt=""/>';
	$pistol = '<img style="max-width:92px;max-height:92px;" src="images/gear/pistol.png" title="" alt=""/>';
	$second = '<img style="max-width:220px;max-height:92px;" src="images/gear/second.png" title="" alt=""/>';
	$heavyammo = array();
	$heavyammoslots = 0;
	$smallammo = array();
	$usableitems = array();

	//$items_ini = parse_ini_file("/items.ini", true);
	$xml = file_get_contents('items.xml', true);
	require_once('modules/xml2array.php');
	$items_xml = XML2Array::createArray($xml);
	
	$Inventory = (array_merge($Inventory[0], $Inventory[1]));
	
	for ($i=0; $i<count($Inventory); $i++){
		if(array_key_exists($i,$Inventory)){
			//$debug .= 'Debug:&nbsp;'.$Inventory[$i].';<br />';
			$curitem = $Inventory[$i];
			$icount = "";
			if (is_array($curitem)){$curitem = $Inventory[$i][0]; $icount = ' - '.$Inventory[$i][1].' rounds'; }
			if(array_key_exists('s'.$curitem,$items_xml['items'])){
				switch($items_xml['items']['s'.$curitem]['Type']){
					case 'binocular':
						$binocular[] = '<img style="max-width:78px;max-height:78px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.'" alt="'.$curitem.'"/>';
						break;
					case 'rifle':
						$rifle = '<img style="max-width:220px;max-height:92px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.'" alt="'.$curitem.'"/>';
						break;
					case 'pistol':
						$pistol = '<img style="max-width:92px;max-height:92px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.'" alt="'.$curitem.'"/>';
						break;
					case 'backpack':
						break;
					case 'heavyammo':
						$heavyammo[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/>', 'slots' => $items_xml['items']['s'.$curitem]['Slots']);
						
						break;
					case 'smallammo':
						$smallammo[] = '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/>';
						break;
					case 'item':
						$usableitems[] = '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.'" alt="'.$curitem.'"/>';
						break;
					default:
						$s = '';
				}
			} else {
				$debug .= 'Unknown item:&nbsp;'.$curitem.';<br />';
			}
		}
	}	


?>	
	<div id="page-heading">
		<h1><?php echo "<title>".$rowname['name']." - ".$sitename."</title>"; ?></h1>
		<h1><?php echo $rowname['name']; ?> - <?php echo $row['unique_id']; ?> - Last save: <?php echo $row['last_updated']; ?></h1>
	</div>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
				<div id="gear_player">	
					<div class="gear_info">
						<img class="playermodel" src='images/models/<?php echo str_replace('"', '', $model); ?>.png'/>
						<div id="gps" style="margin-left:46px;margin-top:54px">
							<div class="gpstext" style="font-size: 22px;width:60px;text-align: left;margin-left:47px;margin-top:13px">
							<?php
								echo $MapCoords[0];
							?>
							</div>
							<div class="gpstext" style="font-size: 22px;width:60px;text-align: left;margin-left:47px;margin-top:34px">
							<?php
							    echo $MapCoords[3];
								
							?>
							</div>
							<div class="gpstext" style="width:120px;margin-left:13px;margin-top:61px">
							<?php
								echo sprintf("%03d",$MapCoords[1]).sprintf("%03d",$MapCoords[2]);
							?>
							</div>							
						</div>
						<div class="statstext" style="width:180px;margin-left:205px;margin-top:-120px">
							<?php echo 'Zed kills:&nbsp;'.$row['zombie_kills'].' / '.$rowname['total_zombie_kills'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:205px;margin-top:-100px">
							<?php echo 'Zed headshots:&nbsp;'.$row['headshots'].' / '.$rowname['total_headshots'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:205px;margin-top:-80px">
							<?php echo 'Human killed:&nbsp;'.$row['survivor_kills'].' / '.$rowname['total_survivor_kills'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:205px;margin-top:-60px">
							<?php echo 'Bandit killed:&nbsp;'.$row['bandit_kills'].' / '.$rowname['total_bandit_kills'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:205px;margin-top:-40px">
							<?php echo 'Survival Attempts:&nbsp;'.$rowname['survival_attempts'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:205px;margin-top:-20px">
							<?php echo 'Total Survival Time:&nbsp;'.$rowname['total_survival_time'];?>
						</div>
					</div>
					<div class="gear_inventory">
						<div class="gear_slot" style="margin-left:1px;margin-top:48px;width:80px;height:80px;">
						<?php
							if(array_key_exists(0,$binocular)){
								echo $binocular[0];
							} else {
								echo '<img style="max-width:78px;max-height:78px;" src="images/gear/binocular.png" title="" alt=""/>';
							}
						?>
						</div>
						<div class="gear_slot" style="margin-left:292px;margin-top:48px;width:80px;height:80px;">
						<?php
							if(array_key_exists(1,$binocular)){
								echo $binocular[1];
							} else {
								echo '<img style="max-width:78px;max-height:78px;" src="images/gear/binocular.png" title="" alt=""/>';
							}
						?>
						</div>
						<div class="gear_slot" style="margin-left:0px;margin-top:130px;width:224px;height:96px;">
							<?php
								echo $rifle;
							?>
						</div>
						<div class="gear_slot" style="margin-left:0px;margin-top:228px;width:224px;height:96px;">
						<?php					
							if(array_key_exists(0, $Backpack)){
								echo '<img style="max-width:220px; max-height:92px;" src="images/thumbs/'.$Backpack[0].'.png" title="'.$Backpack[0].'" alt="'.$Backpack[0].'"/>';
							} else {
								echo $second;
							}
						?>
						</div>
						<div class="gear_slot" style="margin-left:30px;margin-top:326px;width:96px;height:96px;">
						<?php
							echo $pistol;
						?>
						</div>
						<?php					
							$jx = 226;
							$jy = 130;
							$jk = 0;
							$jl = 0;
							$maxslots = 12;
							for ($j=0; $j<$maxslots; $j++){
								if ($jk > 2){ $jk = $jk - 3;$jl++;}
								
								//big ammo
								$hammo = '<img style="max-width:43px;max-height:43px;" src="images/gear/heavyammo.png" title="" alt=""/>';
								if ($j > 5){
									$hammo = '<img style="max-width:43px;max-height:43px;" src="images/gear/grenade.png" title="" alt=""/>';
								}
								if(array_key_exists($j,$heavyammo)){
									$hammo = $heavyammo[$j]['image'];									
									echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;">'.$hammo.'</div>';
									$jk = $jk - 1 + $heavyammo[$j]['slots'];
									$heavyammoslots = $heavyammoslots + $heavyammo[$j]['slots'];
								} else {
									if($heavyammoslots==$maxslots){
										break;
									}
									$heavyammoslots++;
									
									echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;">'.$hammo.'
								</div>';
								}
								$jk++;
								
							}
							$jx = 128;
							$jy = 326;
							$jk = 0;
							$jl = 0;
							for ($j=0; $j<8; $j++){
								if ($jk > 3){ $jk = 0;$jl++;}
								//small ammo
								$sammo = '<img style="max-width:43px;max-height:43px;" src="images/gear/smallammo.png" title="" alt=""/>';
								if(array_key_exists($j,$smallammo)){
									$sammo = $smallammo[$j];
								}
								echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;">'.$sammo.'
								</div>';								
								$jk++;
							}
							$jx = 30;
							$jy = 424;
							$jk = 0;
							$jl = 0;
							for ($j=0; $j<12; $j++){
								if ($jk > 5){ $jk = 0;$jl++;}
								//items
								$uitem = '';
								if(array_key_exists($j,$usableitems)){
									$uitem = $usableitems[$j];
								}
								echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;">'.$uitem.'
								</div>';								
								$jk++;
							}
						?>
					</div>
					<!-- Backpack -->
					<div class="gear_backpack">						
						<?php
							$maxmagazines = 24;
							$BackpackName = $Backpack[0];
							if(array_key_exists('s'.$Backpack[0],$items_xml['items'])){
								$maxmagazines = $items_xml['items']['s'.$Backpack[0]]['maxmagazines'];
							}
							
							$bpweapons = array();
							if(array_key_exists(0, $Backpack[1])){
								$bpweaponscount = count($Backpack[1][0]);							
								for ($m=0; $m<$bpweaponscount; $m++){
										for ($mi=0; $mi<$Backpack[1][1][$m]; $mi++){
											$bpweapons[] = $Backpack[1][0][$m];
										}
								}
							}

							
							$bpitems = array();
							if(array_key_exists(0, $Backpack[2])){
								$bpitemscount = count($Backpack[2][0]);							
								for ($m=0; $m<$bpitemscount; $m++){
									for ($mi=0; $mi<$Backpack[2][1][$m]; $mi++){
										$bpitems[] = $Backpack[2][0][$m];
									}
								}
							}
							
							$Backpack = (array_merge($bpweapons, $bpitems));
							
							$backpackslots = 0;
							$backpackitem = array();
							$bpweapons = array();
							for ($i=0; $i<count($Backpack); $i++){
								if(array_key_exists('s'.$Backpack[$i],$items_xml['items'])){
									switch($items_xml['items']['s'.$Backpack[$i]]['Type']){
										case 'binocular':
											$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
											break;
										case 'rifle':
											$bpweapons[] = array('image' => '<img style="max-width:124px;max-height:92px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
											break;
										case 'pistol':
											$bpweapons[] = array('image' => '<img style="max-width:92px;max-height:92px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
											break;
										case 'backpack':
											break;
										case 'heavyammo':
											$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
											break;
										case 'smallammo':
											$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
											break;
										case 'item':
											$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
											break;
										default:
											$s = '';
									}
								}
							}	
							
							$weapons = count($bpweapons);
							$magazines = $maxmagazines;
							$freeslots = $magazines;
							$jx = 1;
							$jy = 48;
							$jk = 0;
							$jl = 0;
							for ($j=0; $j< $weapons; $j++){
								if ($jk > 1){ $jk = 0;$jl++;}
								echo '<div class="gear_slot" style="margin-left:'.($jx+(130*$jk)).'px;margin-top:'.($jy+(98*$jl)).'px;width:128px;height:96px;">'.$bpweapons[$j]['image'].'</div>';
								$magazines = $magazines - $bpweapons[$j]['slots'];	
								$freeslots = $freeslots - $magazines;
								$jk++;
							}
							
							
							$jx = 1;
							$jy = 48 + (98*round($weapons/2));
							$jk = 0;
							$jl = 0;

							for ($j=0; $j<$magazines; $j++){
								if ($jk > 6){ $jk = 0;$jl++;}
								if ($j<count($backpackitem)){
									echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;">'.$backpackitem[$j]['image'].'</div>';
									$jk = $jk - 1 + $backpackitem[$j]['slots'];
									$backpackslots = $backpackslots + $backpackitem[$j]['slots'];
									$freeslots = $freeslots - $backpackitem[$j]['slots'];
								} else {
									if($backpackslots==$maxmagazines){
										break;
									}
									$backpackslots++;
									echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;"></div>';
								}								
								$jk++;
							}	 			
						?>
						<div class="backpackname">
						<?php
							echo $BackpackName.'&nbsp;&nbsp;(&nbsp;'.$freeslots.'&nbsp;/&nbsp;'.$maxmagazines.'&nbsp;)';
						?>
						</div>
					</div>
					<!-- Backpack -->
				</div>			
			</div>
			<!--  end table-content  -->
			<?php
			echo $debug;
			?>
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
<?php } ?>
	<div class="clear">&nbsp;</div>
