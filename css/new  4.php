<?
	ini_set( "display_errors", 0);
	error_reporting (E_ALL ^ E_NOTICE);

	$cmd = "Players";	
	$answer = rcon($serverip,$serverport,$rconpassword,$cmd);
	
	if ($answer != ""){
		$k = strrpos($answer, "---");
		$l = strrpos($answer, "(");
		$out = substr($answer, $k+4, $l-$k-5);
		$array = preg_split ('/$\R?^/m', $out);
		
		$players = array();
		for ($j=0; $j<count($array); $j++){
			$players[] = "";
		}
		for ($i=0; $i < count($array); $i++)
		{
			$m = 0;
			for ($j=0; $j<5; $j++){
				$players[$i][] = "";
			}
			$pout = preg_replace('/\s+/', ' ', $array[$i]);
			for ($j=0; $j<strlen($pout); $j++){
				$char = substr($pout, $j, 1);
				if($m < 4){
					if($char != " "){
						$players[$i][$m] .= $char;
					}else{
						$m++;
					}
				} else {
					$players[$i][$m] .= $char;
				}
			}
		}
		
		$pnumber = count($players);

		$markers= "var markers = [";
		for ($i=0; $i<count($players); $i++){

			if(strlen($players[$i][4])>1){
				$k = strrpos($players[$i][4], " (Lobby)");
				$playername = str_replace(" (Lobby)", "", $players[$i][4]);
				
				$paren_num = 0;
				$chars = str_split($playername);
				$new_string = '';
				foreach($chars as $char) {
					if($char=='[') $paren_num++;
					else if($char==']') $paren_num--;
					else if($paren_num==0) $new_string .= $char;
				}
				$playername = trim($new_string);

				$search = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $playername);
				$good = trim(preg_replace("/\s(\S{1,2})\s/", " ", preg_replace("[ +]", "  "," $search ")));
				$good = trim(preg_replace("/\([^\)]+\)/", "", $good));
				$good = preg_replace("[ +]", " ", $good);

				$query = "SELECT * FROM main WHERE name LIKE '%". str_replace(" ", "%' OR name LIKE '%", $good). "%' ORDER BY lastupdate DESC LIMIT 1"; 				

				$res = null;
				$res = mysql_query($query) or die(mysql_error());
				$dead = "";
				$x = 0;
				$y = 0;
				$inventory = "";
				$backpack = "";
				$ip = $players[$i][1];
				$ping = $players[$i][2];
				$name = $players[$i][4];
				$id = "0";
				$uid = "0";
				
				while ($row=mysql_fetch_array($res)) {
					$Worldspace = str_replace("[", "", $row['pos']);
					$Worldspace = str_replace("]", "", $Worldspace);
					$Worldspace = explode("|", $Worldspace);					
					if(array_key_exists(2,$Worldspace)){$x = $Worldspace[2];}
					if(array_key_exists(1,$Worldspace)){$y = $Worldspace[1];}
					$x = round(((15360-$x)/100));
					$y = round(($y/100));
					$dead = ($row['death'] ? '_dead' : '');
					$inventory = substr($row['inventory'], 0, 40)."...";
					$backpack = substr($row['backpack'], 0, 40)."...";
					$name = $players[$i][4];
					$id = $row['id'];
					$uid = $row['uid'];
					$model = $row['model'];
					
				}				
				$description = "<h2><a href=\"index.php?view=info&show=1&id=".$uid."&cid=".$id."\">".htmlspecialchars($name, ENT_QUOTES)." - ".$uid."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"/images/models/".str_replace('"', '', $model).".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left:".$y." top:".$x."</td></tr></table>";
				$markers .= "['".htmlspecialchars($name, ENT_QUOTES)."', '".$description."',".$y.", ".($x+1024).", ".$k++.", '/images/icons/player".$dead.".png'],";				
			}
		}
		$markers .= "['Edge of map', 'Edge of Chernarus', 0.0, 0.0, 1, '/images/thumbs/null.png']];";
		include ('modules/gm.php');
	}

?>