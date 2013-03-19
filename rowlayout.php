<?php
include('config.php');
switch($sql)
{		
   	case 'Bliss':
	//char
		$row_playerName = 'name';
		$row_playerMorality = '';
		$row_playerSex = '';	
		$row_CharacterID = 'cid';
		$row_PlayerID = 'id';
		$row_PlayerUID = 'unique_id';
		$row_InstanceID = 'iid';
		$row_Datestamp = '';
		$row_LastLogin = '';
		$row_Inventory = 'inventory';
		$row_Backpack = 'backpack';
		$row_Worldspace = 'worldspace';
		$row_Medical = 'medical';
		$row_Alive = 'is_dead';
		$row_Generation = '';
		$row_LastAte = '';
		$row_LastDrank = '';
		$row_KillsZ = 'zombie_kills';
		$row_HeadshotsZ = '';
		$row_distanceFoot = '';
		$row_duration = 'survival_time';
		$row_currentState = '';
		$row_KillsH = '';
		$row_Model = 'model';
		$row_KillsB = 'bandit_kills';
		$row_Humanity = 'humanity';
		$row_last_updated = '';
	//object
		$row_ObjectID = 'id';
		$row_ObjectUID = 'uid';
		$row_ObjectInstance = 'instance';
		$row_ObjectClassname = 'class_name';
		$row_ObjectDatestamp = '';
		$row_ObjectCharacterID = 'characterID';
		$row_ObjectWorldspace = 'worldspace';
		$row_ObjectInventory = 'inventory';
		$row_ObjectHitpoints = 'hitpoints';
		$row_ObjectFuel = 'fuel';
		$row_ObjectDamage = 'damage';
		$row_Objectlast_updated = 'last_updated';
		$row_ObjectType = 'Type';
	break;
	
    case 'DayZ':
	//char
		$row_playerName = 'playerName';
		$row_playerMorality = 'playerMorality';
		$row_playerSex = 'playerSex';	
		$row_CharacterID = 'CharacterID';
		$row_PlayerID = 'PlayerID';
		$row_PlayerUID = 'PlayerUID';
		$row_InstanceID = 'InstanceID';
		$row_Datestamp = '';
		$row_LastLogin = '';
		$row_Inventory = 'Inventory';
		$row_Backpack = 'Backpack';
		$row_Worldspace = 'Worldspace';
		$row_Medical = 'Medical';
		$row_Alive = 'Alive';
		$row_Generation = 'Generation';
		$row_LastAte = '';
		$row_LastDrank = '';
		$row_KillsZ = 'KillsZ';
		$row_HeadshotsZ = 'HeadshotsZ';
		$row_distanceFoot = '';
		$row_duration = 'duration';
		$row_currentState = '';
		$row_KillsH = 'KillsH';
		$row_Model = 'Model';
		$row_KillsB = 'KillsB';
		$row_Humanity = 'Humanity';
		$row_last_updated = 'last_updated';
	//object
		$row_ObjectID = 'ObjectID';
		$row_ObjectUID = 'ObjectUID';
		$row_ObjectInstance = 'Instance';
		$row_ObjectClassname = 'Classname';
		$row_ObjectDatestamp = '';
		$row_ObjectCharacterID = 'characterID';
		$row_ObjectWorldspace = 'Worldspace';
		$row_ObjectInventory = 'Inventory';
		$row_ObjectHitpoints = 'Hitpoints';
		$row_ObjectFuel = 'Fuel';
		$row_ObjectDamage = 'Damage';
		$row_Objectlast_updated = 'last_updated';
		$row_ObjectType = 'Type';
	break;
};
?>