<?php
include ('queries.php');
require_once ('config.php');

$query = $info1[0];
$binds = $info1[1];
$res = $db->GetAll($query, $binds);
$number = sizeof($res);

	$cid = '';
	if (isset($_GET['cid']) && $_GET['cid'] > 0){
		$cid = $_GET['cid'];
	} else {
		$cid = $row['cid'];
	}

if (isset($_SESSION['user_id'])) {
$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Viewing player: $cid',?,NOW())", $_SESSION['login']);
}

foreach($res as $row) {	

	$MapCoords = worldspaceToMapCoords($row['worldspace']);
	$Inventory = $row['inventory'];
	$Inventory = str_replace("|", ",", $Inventory);
	$Inventory  = json_decode($Inventory);

	$Backpack  = $row['backpack'];
	$Backpack = str_replace("|", ",", $Backpack);
	$Backpack  = json_decode($Backpack);
	$model = $row['model'];
	
	$Medical = $row['medical'];
	$Medical = str_replace("|", ",", $Medical);
	$Medical = json_decode($Medical);

	$binocular = array();
	$rifle = '<img style="max-width:220px;max-height:92px;" src="images/gear/rifle.png" title="" alt=""/>';
	$carry = '<img style="max-width:220px;max-height:92px;" src="images/gear/rifle.png" title="" alt=""/>';
	$pistol = '<img style="max-width:92px;max-height:92px;" src="images/gear/pistol.png" title="" alt=""/>';
	$second = '<img style="max-width:220px;max-height:92px;" src="images/gear/second.png" title="" alt=""/>';
	$heavyammo = array();
	$heavyammoslots = 0;
	$smallammo = array();
	$usableitems = array();
	$survival_time = survivalTimeToString($row['survival_time']);

	$xml = file_get_contents('items.xml', true);
	require_once('modules/xml2array.php');
	$items_xml = XML2Array::createArray($xml);

	$InvCarry = array($Inventory[2], "Placeholder"); 
	$Inventory = (array_merge($Inventory[0], $Inventory[1], $InvCarry));
	for ($i=0; $i<count($Inventory); $i++){
		if(array_key_exists($i,$Inventory)){
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
					case 'carry':
						$carry = '<img style="max-width:220px;max-height:92px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.'" alt="'.$curitem.'"/>';
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
		<h1><?php echo "<title>".htmlspecialchars($row['name'])." - ".$sitename."</title>"; ?></h1>
		<h1 class="custom-h1"><?php echo htmlspecialchars($row['name']); ?> - <?php echo $row['unique_id']; ?> - Last save: <?php echo $row['last_updated']; ?></h1>
	</div>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
				<div id="gear_player" style="margin-left: 10px;">	
					<div class="gear_info">
						<img class="playermodel" src='images/models/<?php echo str_replace('"', '', $model); ?>.png'/>
						<div id="gps" style="margin-left:10px;margin-top:54px">
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
						<div class="statstext" style="width:180px;margin-left:170px;margin-top:-120px">
							<?php echo 'Zed kills:&nbsp;'.$row['zombie_kills'].' / '.$row['total_zombie_kills'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:170px;margin-top:-105px">
							<?php echo 'Zed headshots:&nbsp;'.$row['headshots'].' / '.$row['total_headshots'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:170px;margin-top:-90px">
							<?php echo 'Human killed:&nbsp;'.$row['survivor_kills'].' / '.$row['total_survivor_kills'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:170px;margin-top:-75px">
							<?php echo 'Bandit killed:&nbsp;'.$row['bandit_kills'].' / '.$row['total_bandit_kills'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:170px;margin-top:-60px">
							<?php echo 'Survival Attempts:&nbsp;'.$row['survival_attempts'];?>
						</div>
						<div class="statstext" style="width:180px;margin-left:170px;margin-top:-45px">
							<?php echo 'Survival Time:&nbsp;'.$survival_time;?>
						</div>
						<div class="statstext" style="width:180px;margin-left:170px;margin-top:-30px">
							<?php echo 'Humanity:&nbsp;'.$row['humanity'];?>
						</div>
					</div>
					<div class="gear_inventory">
						<div class="gear_slot" style="margin-left:295px;margin-top:350px;width:80px;height:80px;">
						<?php
							if(array_key_exists(0,$binocular)){
								echo $binocular[0];
							} else {
								echo '<img style="max-width:78px;max-height:78px;" src="images/gear/binocular.png" title="" alt=""/>';
							}
						?>
						</div>
						<div class="gear_slot" style="margin-left:295px;margin-top:448px;width:80px;height:80px;">
						<?php
							if(array_key_exists(1,$binocular)){
								echo $binocular[1];
							} else {
								echo '<img style="max-width:78px;max-height:78px;" src="images/gear/binocular.png" title="" alt=""/>';
							}
						?>
						</div>
						<div class="gear_slot" style="margin-left:99px;margin-top:146px;width:224px;height:96px;">
							<?php
								echo $rifle;
							?>
						</div>
						<div class="gear_slot" style="margin-left:99px;margin-top:244px;width:224px;height:96px;">
							<?php
								echo $carry;
							?>
						</div>
						<div class="gear_slot" style="margin-left:99px;margin-top:48px;width:224px;height:96px;">
						<?php					
							if(array_key_exists(0, $Backpack)){
								echo '<img style="max-width:220px; max-height:92px;" src="images/thumbs/'.$Backpack[0].'.png" title="'.$Backpack[0].'" alt="'.$Backpack[0].'"/>';
							} else {
								echo $second;
							}
						?>
						</div>
						<div class="gear_slot" style="margin-left:1px;margin-top:342px;width:96px;height:96px;">
						<?php
							echo $pistol;
						?>
						</div>
						<?php					
							$jx = 1;
							$jy = 48;
							$jk = 0;
							$jl = 0;
							$maxslots = 12;
							for ($j=0; $j<$maxslots; $j++){
								if ($jk > 1){ $jk = $jk - 2;$jl++;}
								
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
							$jx = 99;
							$jy = 342;
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
							$jx = 1;
							$jy = 440;
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
							if(count($Backpack[1][0]) == NULL){
								$maxmagazines = 0;
							} else {
								$maxmagazines = 26;
							}
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
										case 'carry':
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
	<div id="medical">
	<table id="medical">
	<tr>
		<th class="custom-th">Alive</th>
		<th class="custom-th">Unconscious</th>
		<th class="custom-th">Infected</th>
		<th class="custom-th">Injured</th>
		<th class="custom-th">Bleeding</th>
		<th class="custom-th">Blood</th>
		<th class="custom-th">Leg</th>
	</tr>
	<tr>
		<td><?php echo $row['is_dead'] == 1 ? "No" : "Yes"; ?></td>
		<td><?php echo $Medical[1] ? "Yes" : "No"; if($Medical[10] > 0) { printf(" (%d)", $Medical[10]); } ?></td>
		<td><?php echo $Medical[2] ? "Yes" : "No"; ?></td>
		<td><?php echo $Medical[3] ? "Yes" : "No"; ?></td>
		<td><?php echo $Medical[3] ? "Yes" : "No"; ?></td>
		<td><?php printf("%d (%d%%)", round($Medical[7]), ($Medical[7]/12000) * 100); ?></td>
		<td><?php printf("%d%%", ($Medical[9][0]/1)*100); ?></td>
	</tr>
	<!-- <tr><td colspan="7">&nbsp;<br><?php print_r_html($Medical); ?></td></tr> -->
	<tr><td colspan="7">&nbsp;</td></tr>
	</table>
<?php if($sql == 'Bliss') { ?>
	<table>
	<tr>
		<th class="custom-th">
		Options
		</th>
		<?php if($map == 'chernarus') {?>
		<th class="custom-th">
		Teleport
		</th>
		<?php } ?>
		<th class="custom-th">
		Skin
		</th>
	</tr>
	<!-- Row 1 -->
	<tr>
	<td><a href="admin.php?view=actions&revivePlayer=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Revive Player</a></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportNE=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">North East Airfield</a></td>
	<?php } ?>
	<td><a href="admin.php?view=actions&skinNormal=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Normal Clothing</a></td>
	</tr>
	<!-- Row 2 -->
	<tr>
	<td><a href="admin.php?view=actions&healPlayer=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Heal Player</a></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportNW=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">North West Airfield</a></td>
	<?php } ?>
	<td><a href="admin.php?view=actions&skinCamo=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Camo Clothing</a></td>
	</tr>
	<!-- Row 3 -->
	<tr>
	<td><a href="admin.php?view=actions&killPlayer=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Kill Player</a></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportStary=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Stary Tents</a></td>
	<?php } ?>
	<td><a href="admin.php?view=actions&skinGillie=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Ghillie Suit</a></td>
	</tr>
	<!-- Row 4 -->
	<tr>
	<td><a href="admin.php?view=actions&resetHumanity=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Reset Humanity</a></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportCherno=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Cherno</a></td>
	<?php } ?>
	<td><a href="admin.php?view=actions&skinSoldier=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Soldier Clothing</a></td>
	</tr>
	<!-- Row 5 -->
	<tr>
	<td></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportElektro=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Elektro</a></td>
	<?php } ?>
	<td><a href="admin.php?view=actions&skinBandit=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Bandit Skin</a></td>
	</tr>
	<!-- Row 6 -->
	<tr>
	<td></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportSkalisty=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Skalisty</a></td>
	<?php } ?>
	</tr>
	<!-- Row 7 -->
	<tr>
	<td></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportBerezino=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Berezino</a></td>
	<?php } ?>
	</tr>
	<!-- Row 8 -->
	<tr>
	<td></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportSolnichniy=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Solnichniy</a></td>
	<?php } ?>
	</tr>
	<!-- Row 9 -->
	<tr>
	<td></td>
	<?php if($map == 'chernarus') {?>
	<td><a href="admin.php?view=actions&teleportPolana=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">Polana</a></td>
	<?php } ?>
	</tr>
	</table>
	</div>
<!--  end table-content  -->

<!-- Start inventory management -->

<?php
mysql_connect ($hostname, $username, $password) or die ('Error: ' . mysql_error());
mysql_select_db($dbName);

$login = $_SESSION['login'];
$accesslvl = $db->GetOne("SELECT accesslvl FROM users WHERE id = '$user_id'");

if ($_POST['submit_inv']) {
	$inv =  mysql_real_escape_string($_POST['inv']);
	$dbQuery="UPDATE survivor SET inventory = '$inv' WHERE id = $cid AND is_dead = 0";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Edited inventory of user: $cid',?,NOW())", $_SESSION['login']);
	mysql_query($dbQuery) or die ('Error updating database' . mysql_error());
}

if ($_POST['submit_bck']) {
	$bck =  mysql_real_escape_string($_POST['bck']);
	$dbQuery="UPDATE survivor SET backpack = '$bck' WHERE id = $cid AND is_dead = 0";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Edited backpack of user: $cid',?,NOW())", $_SESSION['login']);
	mysql_query($dbQuery) or die ('Error updating database' . mysql_error());
}

if ($_POST['submit_loc']) {
	$loc =  mysql_real_escape_string($_POST['loc']);
	$dbQuery="UPDATE survivor SET worldspace = '$loc' WHERE id = $cid AND is_dead = 0";
	$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`) VALUES ('Edited location of user: $cid',?,NOW())", $_SESSION['login']);
	mysql_query($dbQuery) or die ('Error updating database' . mysql_error());
} 

?>

<div id="inventoryString">
	<form method="post">
	<h2 class="custom-h2-string">Inventory String</h2>
		<textarea name="inv" action="modules/info/1.php=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">
<?php
echo $row['inventory'];
?>
		</textarea><br>
	<br><input name="submit_inv" class="btn btn-default" type="submit" value="Submit" />
	</form>

	<form method="post">
	<br><h2 class="custom-h2-string">Backpack String</h2>
		<textarea name="bck" action="modules/info/1.php=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">
<?php 
echo $row['backpack'];
?>
		</textarea><br>
	<br><input name="submit_bck" class="btn btn-default" type="submit" value="Submit" />
	</form>

	<form method="post">
	<br><h2 class="custom-h2-string">Location String</h2>
		<textarea name="loc" action="modules/info/1.php=<?php echo $row['unique_id']; ?>&cid=<?php echo $cid; ?>">
<?php 
echo $row['worldspace'];
?>
		</textarea><br>
	<br><input name="submit_loc" class="btn btn-default" type="submit" value="Submit" />
	</form>
</div>


<!-- End inventory management -->
<?php } ?>
			<?php
			echo $debug;
			?>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
	</tr>
	</table>
		
<?php } ?>
