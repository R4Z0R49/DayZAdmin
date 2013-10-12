<?php
if (isset($_SESSION['user_id']) && $accesslvls[0][2] != 'false')
{
	$pagetitle = "Add Vehicles";

    if (isset($_REQUEST['upload_submit'])){
    	if($_FILES["UploadFile"]["name"] != "mission.sqf"){
    		$message->Add('danger', 'File is not named mission.sqf!');
    	}else {
			{
			$message->Add('success', 'File successfully uploaded!');
			move_uploaded_file($_FILES["UploadFile"]["tmp_name"],
			"mission". DIRECTORY_SEPARATOR . $_FILES["UploadFile"]["name"]);
			}
		}
	}
	if(isset($_REQUEST['addVehsSQF_delete'])){
		$message->Add('success', 'File successfully deleted!');
		unlink('mission'. DIRECTORY_SEPARATOR .'mission.sqf');
	}

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
					
					$resultClassNameQuery = $db->Execute("SELECT * FROM object_classes");
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
						$db->Execute("INSERT INTO `object_classes`(`Classname`, `Chance`, `MaxNum`, `Damage`, `Type`) VALUES (?, 0.50, 10, 0.05000, '')", array($strings[1]));
						//echo 'Veh inserted<br>';
					}

					$vehicle_id = rand(100000, 99999999);
					$db->Execute("INSERT INTO `object_spawns`(`ObjectUID`, `Classname`, `Inventory`, `Worldspace`) VALUES (?, ?, ?, ?)", array($vehicle_id, $strings[1], '[]', $pos));
					$message->Add('success', 'Successfully added '. $strings[1] .' vehicles to normal chance spawn');
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
					
					$resultClassNameQuery = $db->Execute("SELECT * FROM object_classes");
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
						$db->Execute("INSERT INTO `object_classes`(`Classname`, `Chance`, `MaxNum`, `Damage`, `Type`) VALUES (?, 0.50, 10, 0.05000, '')", array($strings[1]));
					}
					
					$vehicle_id = rand(100000, 99999999);
					$db->Execute("INSERT INTO `object_data`(`ObjectUID`, `Instance`, `Classname`, `Datestamp`, `Worldspace`, `Inventory`, `last_updated`) 
					VALUES (?, ?, ?, ?, ?, ?, ?);", array($vehicle_id, $iid, $strings[1], date("Y-m-d H:i:s"), $pos, '[]', date("Y-m-d H:i:s")));
					$vehiclecount++;
				}
			}
			$message->Add('success', $vehiclecount.' vehicles successfully spawned');
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
    <p class="help-block">Upload your mission.sqf made in the ArmA 2 editor with vehicles placed around the map.<br> Keep in mind only DayZ allowed vehicles will work. <br>If it gives you a file move error, make sure your chmod for your DayZAdmin directory and /mission directory is 777.</p>
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