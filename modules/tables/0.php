<?php
	//ini_set( "display_errors", 0);
	//error_reporting (E_ALL ^ E_NOTICE);		<th class="table-header-repeat line-left" width="15%"><a href="">IP Address</a></th>
		//<th class="table-header-repeat line-left" width="5%"><a href="">Ping</a></th>

	$cmd = "Players";
	
	$answer = rcon($serverip_internal,$serverport,$rconpassword,$cmd);
	$tableheader = header_player(0);
		
	
	if ($answer != ""){
		$k = strrpos($answer, "---");
		$l = strrpos($answer, "(");
		$out = substr($answer, $k+4, $l-$k-5);
		$array = preg_split ('/$\R?^/m', $out);
		
		//echo $answer."<br /><br />";
		
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
		//echo count($players)."<br />";
		for ($i=0; $i<count($players); $i++){
			//echo $players[$i][4]."<br />";
			if(strlen($players[$i][4])>1){
				$k = strrpos($players[$i][4], " (Lobby)");
				$playername = str_replace(" (Lobby)", "", $players[$i][4]);
				
				//$search = substr($playername, 0, 5);
				$paren_num = 0;
				$chars = str_split($playername);
				$new_string = '';
				foreach($chars as $char) {
					if($char=='[') $paren_num++;
					else if($char==']') $paren_num--;
					else if($paren_num==0) $new_string .= $char;
				}
				$playername = trim($new_string);


				//echo $playername."<br />";
				$search = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $playername);
				$good = trim(preg_replace("/\s(\S{1,2})\s/", " ", preg_replace("[ +]", "  "," $search ")));
				$good = trim(preg_replace("/\([^\)]+\)/", "", $good));
				$good = preg_replace("[ +]", " ", $good);
				//echo $good."<br />";
				$query = "select * from (SELECT profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id) as T where name LIKE '%". str_replace(" ", "%' OR name LIKE '%", $good). "%' ORDER BY last_updated DESC LIMIT 1"; 				
				//echo $playername."<br />";
				$res = null;
				$res = mysql_query($query) or die(mysql_error());
				$name = $res['name'];
				$id = $res['unique_id'];
				$dead = "";
				$x = 0;
				$y = 0;
				$InventoryPreview = "";
				$BackpackPreview = "";
				$ip = $players[$i][1];
				$ping = $players[$i][2];
				$name = $players[$i][4];
				$uid = "";
				
				while ($row=mysql_fetch_array($res)) {					
					$tablerows .= row_online_player($row, $players[$i]);
				}
			}
		}
	}

?>
