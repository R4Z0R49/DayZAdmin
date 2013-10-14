<?php
if (isset($_SESSION['user_id']) && $accesslvls[0][2] != 'false')
{
	$pagetitle = "Add Vehicles";

    if (isset($_REQUEST['upload_submit'])){
    	if($_FILES["UploadFile"]["name"] != "mission.sqf"){
    		$message->Add('danger', 'File is not named mission.sqf!');
    	} else {
			{
			$message->Add('success', 'File successfully uploaded!');
			$movefile = move_uploaded_file($_FILES["UploadFile"]["tmp_name"], 
			"mission". DIRECTORY_SEPARATOR . $_FILES["UploadFile"]["name"]);
			}
			if($movefile == false){
				$message->Add('danger', 'Path is not writeable! Check that your webserver user has write permissions to the mission folder');
			}
		}
	}
	if(isset($_REQUEST['addVehsSQF_delete'])){
		$message->Add('success', 'File successfully deleted!');
		unlink('mission'. DIRECTORY_SEPARATOR .'mission.sqf');
	}

	if(isset($_REQUEST['chance']) && $_REQUEST['chance'] <= 1 && $_REQUEST['chance'] >= 0 && is_numeric($_REQUEST['chance'])){
		$chance = $_REQUEST['chance'];
	} elseif (!isset($_REQUEST['chance']) or !is_numeric($_REQUEST['chance'])){
		$chance = 0.50;
		//$message->Add('danger', 'Chance can not be less than 0 or greater than 1!');
	} 
	//echo $chance;

	if(isset($_REQUEST['addVehsSQF_submit'])){
		$missionfile = file_get_contents('mission'. DIRECTORY_SEPARATOR .'mission.sqf');
		$mission_rows = explode("\n",$missionfile);
		array_shift($mission_rows);
		$vehiclecount = 0;

		if(isset($_REQUEST['chance_checkbox'])){
			for($i=0;$i<count($mission_rows);$i++)
			{
				$direction = 0;
				if (strpos($mission_rows[$i],'_this = createVehicle [') !== false)
				{
					$strings = explode("\"",$mission_rows[$i]);
					$firstOpenBracket = strpos($mission_rows[$i], "[");
					$secondOpenBracket = strpos($mission_rows[$i], "[", $firstOpenBracket + strlen("]"));
					$firstCloseBracket = strpos($mission_rows[$i], "]");
					
					if (strpos($mission_rows[$i+2],'_this setDir') !== false)
					{
						$firstSpace = strpos($mission_rows[$i+2]," ");
						$secondSpace = strpos($mission_rows[$i+2]," ",$firstSpace+strlen(" "));
						$thirdSpace = strpos($mission_rows[$i+2]," ",$secondSpace+strlen(" "));
						$forthSpace = strpos($mission_rows[$i+2]," ",$thirdSpace+strlen(" "));
						$period = strpos($mission_rows[$i+2],".");
						$direction = substr($mission_rows[$i+2],$forthSpace+1, $period-$forthSpace-1);
					}
					
					$pos = "[$direction," . substr($mission_rows[$i],$secondOpenBracket, $firstCloseBracket-$secondOpenBracket+1) . "]";
					$pos = str_replace(array(' '), '',$pos);
					$newPos = explode(",",$pos);
					if (count($newPos) == 3)
					{
						$pos = "[$direction," . substr($mission_rows[$i],$secondOpenBracket, $firstCloseBracket-$secondOpenBracket) . ",0]]";
						$pos = str_replace(array(' '), '',$pos);
					}
					
					$resultClassNameQuery = $db->Execute("SELECT * FROM Object_CLASSES");
					$userDataClassNameQuery;
					$userDataVehicleIDs;
					while ($row = $resultClassNameQuery->FetchRow()){ 
						$userDataClassNameQuery[] = $row['Classname'];
					}

					$matchFound = 0;
					for($j=0;$j<count($userDataClassNameQuery)-1;$j++)
					{
						if ($strings[1] == $userDataClassNameQuery[$j]) 
						{
							$matchFound = 1;
						}
					}
					if($matchFound == 0)
					{
						$rs = $db->Execute("INSERT INTO `Object_CLASSES`(`Classname`, `Chance`, `MaxNum`, `Damage`, `Type`) VALUES (?, ?, 10, 0.05000, '')", array($strings[1], $chance));
						//echo 'Veh inserted<br>';
					}

					$vehicle_id = rand(100000, 99999999);
					$rs = $db->Execute("INSERT INTO `Object_SPAWNS`(`ObjectUID`, `Classname`, `Inventory`, `Worldspace`) VALUES (?, ?, ?, ?)", array($vehicle_id, $strings[1], '[]', $pos));
				
					if($rs == false) {
						$message->Add('danger', 'MySQL query failed for adding a normal chance spawn!');
					} else {
					$message->Add('success', 'Successfully added '. $strings[1] .' vehicles to normal chance spawn');
					}
				}
			}
		}
		if(isset($_REQUEST['spawn_checkbox'])){
			for($i=0;$i<count($mission_rows);$i++)
			{
				$direction = 0;
				if (strpos($mission_rows[$i],'_this = createVehicle [') !== false)
				{
					$strings = explode("\"",$mission_rows[$i]);
					$firstOpenBracket = strpos($mission_rows[$i], "[");
					$secondOpenBracket = strpos($mission_rows[$i], "[", $firstOpenBracket + strlen("]"));
					$firstCloseBracket = strpos($mission_rows[$i], "]");
					
					if (strpos($mission_rows[$i+2],'_this setDir') !== false)
					{
						$firstSpace = strpos($mission_rows[$i+2]," ");
						$secondSpace = strpos($mission_rows[$i+2]," ",$firstSpace+strlen(" "));
						$thirdSpace = strpos($mission_rows[$i+2]," ",$secondSpace+strlen(" "));
						$forthSpace = strpos($mission_rows[$i+2]," ",$thirdSpace+strlen(" "));
						$period = strpos($mission_rows[$i+2],".");
						$direction = substr($mission_rows[$i+2],$forthSpace+1, $period-$forthSpace-1);
					}
					
					$pos = "[$direction," . substr($mission_rows[$i],$secondOpenBracket, $firstCloseBracket-$secondOpenBracket+1) . "]";
					$pos = str_replace(array(' '), '',$pos);
					$newPos = explode(",",$pos);
					if (count($newPos) == 3)
					{
						$pos = "[$direction," . substr($mission_rows[$i],$secondOpenBracket, $firstCloseBracket-$secondOpenBracket) . ",0]]";
						$pos = str_replace(array(' '), '',$pos);
					}
					
					$resultClassNameQuery = $db->Execute("SELECT * FROM Object_CLASSES");
					$userDataClassNameQuery;
					$userDataVehicleIDs;
					while ($row = $resultClassNameQuery->FetchRow()){ 
						$userDataClassNameQuery[] = $row['Classname'];
					}

					$matchFound = 0;
					for($j=0;$j<count($userDataClassNameQuery)-1;$j++)
					{
						if ($strings[1] == $userDataClassNameQuery[$j]) 
						{
							$matchFound = 1;
						}
					}
					if($matchFound == 0)
					{
						$rs = $db->Execute("INSERT INTO `Object_CLASSES`(`Classname`, `Chance`, `MaxNum`, `Damage`, `Type`) VALUES (?, ?, 10, 0.05000, '')", array($strings[1], $chance));
					}
					
					$vehicle_id = rand(100000, 99999999);
					$rs = $db->Execute("INSERT INTO `Object_DATA`(`ObjectUID`, `Instance`, `Classname`, `Datestamp`, `Worldspace`, `Inventory`, `last_updated`) 
					VALUES (?, ?, ?, ?, ?, ?, ?);", array($vehicle_id, $iid, $strings[1], date("Y-m-d H:i:s"), $pos, '[]', date("Y-m-d H:i:s")));
					$vehiclecount++;
					if($rs == false) {
						$message->Add('danger', 'MySQL query failed for spawning a vehicle!');
					} else {
					$message->Add('success', 'Successfully spawned '. $strings[1]);
					}
				}
			}
		}
		if($rs == false) {
			$message->Add('danger', 'No option selected');
		}
	}
?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";
?>
</div>

<?php 
	$message->display();
?>

<?php if (!file_exists('mission'. DIRECTORY_SEPARATOR .'mission.sqf')) {?>
<form role="form" method="POST" action="admin.php?view=addVehsSQF" name="uploadform" enctype="multipart/form-data">
  <div class="form-group">
    <input type="file" name="UploadFile" id="UploadFile">
    <p class="help-block">Upload your mission.sqf made in the ArmA 2 editor with vehicles placed around the map.<br> Keep in mind only DayZ allowed vehicles will work. <br>If it gives you a file move error, make sure the mission directory is read/write for your web server user.</p>
  </div>
  <button type="submit" class="btn btn-default" name="upload_submit">Submit</button>
</form>
<?php }?>
<?php if (file_exists('mission'. DIRECTORY_SEPARATOR .'mission.sqf')) {?>
<form role="form" method="POST" action="admin.php?view=addVehsSQF" name="addform">
  <div class="checkbox">
    <label>
      <input type="checkbox" name="chance_checkbox"> Create a chance to spawn
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="spawn_checkbox"> Create vehicle at location
    </label>
  </div>
  <input name="chance" class="form-control" style="width: 250px; margin-bottom: 10px;" type="text" placeholder="Type a number from 0.00 to 1">

  <button type="submit" class="btn btn-default" name="addVehsSQF_submit">Submit</button>
  <button type="submit" class="btn btn-danger" name="addVehsSQF_delete">Delete mission.sqf</button>
</form>
<?php 
}
}
else
{
	if ($accesslvls[0][2] != 'true') {
		$message->add('danger', "You dont have enough access to view this");
		$message->display();
	}
}
?>