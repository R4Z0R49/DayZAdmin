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

?>
