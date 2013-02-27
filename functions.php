<?php

include 'config.php';

// Convert a Bliss worldspace string to game map coordinates
function worldspaceToMapCoords($ws, $map = "chernarus")
{
    $ws = str_replace("[", "", $ws);
    $ws = str_replace("]", "", $ws);
    $ws = explode(",", $ws);

    $mapcoords = array(0, 0, 0, 0);

    if(is_array($ws) && sizeof($ws) >= 3)
    {
        switch($map)
        {
            case "chernarus":
                $mapcoords[0] = $ws[0];
                $mapcoords[1] = round($ws[1] / 100);
                $mapcoords[2] = round(154 - ($ws[2] / 100));
                $mapcoords[3] = round($ws[3] / 100);
                break;
            case "lingor":
                $mapcoords[0] = $ws[0];
                $mapcoords[1] = floor($ws[1] / 100);
                $mapcoords[2] = floor($ws[2] / 100);
                $mapcoords[3] = round($ws[3] / 100);
                break;
		case "tavi":
                $mapcoords[0] = $ws[0];
                $mapcoords[1] = floor($ws[1] / 100);
                $mapcoords[2] = floor($ws[2] / 100);
                $mapcoords[3] = round($ws[3] / 100);
                break;
		case "namalsk":
                $mapcoords[0] = $ws[0];
                $mapcoords[1] = round($ws[1] / 100);
                $mapcoords[2] = round(128 - ($ws[2] / 100));
                $mapcoords[3] = round($ws[3] / 100);
                break;
            default:
                break;
        }
    }

    return $mapcoords;
}

// Wrap print_r in <pre> tags, useful for debugging
function print_r_html($s)
{
    echo "<pre>\n";
    print_r($s);
    echo "</pre>\n";
}

function distanceToString($feet) {
    $m = round($feet * 0.3048);
    $km = 0;
    if($m > 1000) {
        $r = $m % 1000;
        $km = ($m - $r) / 1000;
        return sprintf("%d km %d m", $km, $r);
    } else {
        return sprintf("%d m", $m);
    }
}

function survivalTimeToString($minutes) {
    if($minutes > 60) {
        $r = $minutes % 60;
        $hours = ($minutes - $r) / 60;
        $minutes = $r;
        if($hours > 24) {
            $r = $hours % 24;
            $days = ($hours - $r) / 24;
            $hours = $r;
            return sprintf("%d d %d h %d m", $days, $hours, $minutes);
        } else {
            return sprintf("%d h %d m", $hours, $minutes);
        }
    } else {
        return sprintf("%d m", $minutes);
    }
}

function inventoryCounts($arr, $items_xml, $vehicles_xml) {
	$maxmagazines = 24;
	$maxweaps = 3;
	$maxbacks = 0;
	$freeslots = 0;
	$freeweaps = 0;
	$freebacks = 0;

	if(array_key_exists('s'.$row['class_name'],$vehicles_xml['vehicles'])){
    	$maxmagazines = $vehicles_xml['vehicles']['s'.$row['class_name']]['transportmaxmagazines'];
	    $maxweaps = $vehicles_xml['vehicles']['s'.$row['class_name']]['transportmaxweapons'];
    	$maxbacks = $vehicles_xml['vehicles']['s'.$row['class_name']]['transportmaxbackpacks'];
	}

	$counts = array(0,0,0);

	if(count($arr) > 0) {
		$bpweaponscount = count($arr[0][0]);
		$bpweapons = array();
		for ($m=0; $m<$bpweaponscount; $m++){
				for ($mi=0; $mi<$arr[0][1][$m]; $mi++){
					$bpweapons[] = $arr[0][0][$m];
				}
		}


		$bpitemscount = count($arr[1][0]);
		$bpitems = array();
		for ($m=0; $m<$bpitemscount; $m++){
			for ($mi=0; $mi<$arr[1][1][$m]; $mi++){
				$bpitems[] = $arr[1][0][$m];
			}
		}

		$bpackscount = count($arr[2][0]);
		$bpacks = array();
		for ($m=0; $m<$bpackscount; $m++){
			for ($mi=0; $mi<$arr[2][1][$m]; $mi++){
				$bpacks[] = $arr[2][0][$m];
			}
		}

		$arr = (array_merge($bpweapons, $bpacks, $bpitems));

		for ($i=0; $i<count($arr); $i++){
			if(array_key_exists('s'.$arr[$i],$items_xml['items'])){
				switch($items_xml['items']['s'.$arr[$i]]['Type']){
					case 'binocular':
						$counts[1]++;
						break;
					case 'rifle':
						$counts[0]++;
						break;
					case 'pistol':
						$counts[0]++;
						break;
					case 'backpack':
						$counts[2]++;
						break;
					case 'heavyammo':
						$counts[1]++;
						break;
					case 'smallammo':
						$counts[1]++;
						break;
					case 'item':
						$counts[1]++;
						break;
					default:
				}
			}
		}
	}
	return $counts;
}

?>
