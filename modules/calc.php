<?php

function world_x($x, $world){
	if (strpos($world, "chernarus") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "lingor") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "utes") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "panthera") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "takistan") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "fallujah") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "namalsk") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "celle") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "zargabad") !== false) {
		return ($x / 100);
	} elseif (strpos($world, "tavi") !== false) {
		return ($x / 100);
	} else {
		return ($x / 100);
	}
}

function world_y($y, $world){
	if (strpos($world, "chernarus") !== false) {
		return ((15360 - $y) / 100);
	} elseif (strpos($world, "lingor") !== false) {
		return ($y / 100);
	} elseif (strpos($world, "utes") !== false) {
		return ($y / 100);
	} elseif (strpos($world, "panthera") !== false) {
		return ((10240 - $y) / 100);
	} elseif (strpos($world, "takistan") !== false) {
		return ($y / 100);
	} elseif (strpos($world, "fallujah") !== false) {
		return ($y / 100);
	} elseif (strpos($world, "namalsk") !== false) {
		return ((12800 - $y) / 100);
	} elseif (strpos($world, "celle") !== false) {
		return ($y / 100);
	} elseif (strpos($world, "zargabad") !== false) {
		return ($y / 100);
	} elseif (strpos($world, "tavi") !== false) {
		return ($y / 100);
	} else {
		return ($y / 100);
	}
}

?>