<?php
	//Sortby
	if(!isset($_GET['value'])){
		$sortby = $leaderboard_KillsZ;
	}elseif($_GET['value'] == 'Human Kills') {
		$sortby = $leaderboard_KillsH;
	}elseif($_GET['value'] == 'Bandit Kills') {
		$sortby = $leaderboard_KillsB;
	}elseif($_GET['value'] == 'Zombie Kills') {
		$sortby = $leaderboard_KillsZ;
	}elseif($_GET['value'] == 'Headshots') {
		$sortby = $leaderboard_Headshots;
	}elseif($_GET['value'] == 'Humanity') {
		$sortby = $leaderboard_Humanity;
	}elseif($_GET['value'] == 'Deaths') {
		$sortby = $leaderboard_Deaths;
	}

	//Sorttype
	if(!isset($_GET['sorttype'])){
		$sorttype = 'DESC';
	}elseif($_GET['sorttype'] == 'Ascending'){
		$sorttype = 'ASC';
	}elseif($_GET['sorttype'] == 'Descending'){
		$sorttype = 'DESC';
	}

	//Limit
	if(!isset($_GET['limit'])){
		$limit = 10;
	}elseif($_GET['limit'] == 10){
		$limit = 10;
	}elseif($_GET['limit'] == 20){
		$limit = 20;
	}elseif($_GET['limit'] == 30){
		$limit = 30;
	}elseif($_GET['limit'] == 40){
		$limit = 40;
	}elseif($_GET['limit'] == 50){
		$limit = 50;
	}

?>

<div class="leaderboard-box">	
	<table class="table">
		<thead>
			<th class="custom-th"># Rank</th>
			<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img>Playername</th>
			<th class="custom-th"><img src="images/icons/statspage/infectedkilled1.png" width="25px" height="25px" class="table-img"></img> Zombie Kills</th>
			<th class="custom-th"><img src="images/icons/statspage/murders.png" width="25px" height="25px" class="table-img"></img> Human Kills</th>
			<th class="custom-th"><img src="images/icons/statspage/banditskilled1.png" width="25px" height="25px" class="table-img"></img> Bandit Kills</th>
			<th class="custom-th"><img src="images/icons/statspage/infectedheadshots1.png" width="25px" height="25px" class="table-img"></img> Headshots</th>
			<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img> Humanity</th>
			<th class="custom-th"><img src="images/icons/statspage/playerdeaths1.png" width="25px" height="25px" class="table-img"></img> Deaths</th>
			<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img> Points</th>
		</thead>
		<tbody>
			<?php
		        $result = $con->query("SELECT * FROM $leaderboard ORDER BY $sortby $sorttype LIMIT $limit");
		        $rank = 1;

		        if ($result->num_rows != 0) {
		            while ($rowl = $result->fetch_assoc()) {
		            	$points = $rowl[$leaderboard_KillsZ]+$rowl[$leaderboard_KillsB]-$rowl[$leaderboard_KillsH]-$rowl[$leaderboard_Deaths];
		                echo "<tr>
		                	  <td>{$rank}</td>
		                      <td>{$rowl[$leaderboard_Playername]}</td>
		                      <td>{$rowl[$leaderboard_KillsZ]}</td>
		                      <td>{$rowl[$leaderboard_KillsH]}</td>
		                      <td>{$rowl[$leaderboard_KillsB]}</td>
		                      <td>{$rowl[$leaderboard_Headshots]}</td>
		                      <td>{$rowl[$leaderboard_Humanity]}</td>
		                      <td>{$rowl[$leaderboard_Deaths]}</td>
		                      <td>{$points}</td>
		                      </tr>";  

		                $rank++;
		            }
		        }
		    ?>
		</tbody>
	</table>
	<select class="form-control pull-left" style="width:100px; margin-top: 20px; margin-bottom: 20px;" onChange='window.location="index.php?leaderboard<?php if(isset($_GET['value'])) { echo '&value=' . $_GET['value']; } ?><?php if(isset($_GET['sorttype'])) { echo '&sorttype=' . $_GET['sorttype']; } ?>&limit=" + this.value;'>
		<option>Show</option>
		<option>10</option>
		<option>20</option>
		<option>30</option>
		<option>40</option>
		<option>50</option>
	</select>
	<input placeholder="Username" class="form-control pull-left" style="width:150px; margin-top: 20px; margin-bottom: 20px;" onChange='window.location="index.php?leaderboard&Username=" + this.value;'>
		<option>Sort type:</option>
		<option>Descending</option>
		<option>Ascending</option>
	</select>
	<select class="form-control pull-right" style="width:200px; margin-top: 20px; margin-bottom: 20px;" name="by" onChange='window.location="index.php?leaderboard<?php if(isset($_GET['sorttype'])) { echo '&sorttype=' . $_GET['sorttype']; } ?><?php if(isset($_GET['limit'])) { echo '&limit=' . $_GET['limit']; } ?>&value=" + this.value;'>
		<option>Sort by:</option>
		<option>Zombie Kills</option>
		<option>Human Kills</option>
		<option>Bandit Kills</option>
		<option>Headshots</option>
		<option>Humanity</option>
		<option>Deaths</option>
	</select>
</div>