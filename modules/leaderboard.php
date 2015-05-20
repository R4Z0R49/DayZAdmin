<?php
	// Sortby
	if(isset($_REQUEST['sortby'])) {
		$sortby = $_REQUEST['sortby'];
	} else {
		$sortby = 'KillsZ';
	}

	// Sorttype
	if(isset($_REQUEST['sorttype'])) {
		$sorttype = $_REQUEST['sorttype'];
	} else {
		$sorttype = 'DESC';
	}

	// Limit
	if(isset($_REQUEST['limit'])) {
		$limit =  $_REQUEST['limit'];
	} else {
		$limit = 10;
    }
	
	$pagetitle = 'Leaderboard';

?>

<div class="leaderboard-content">
	<div class="leaderboard-box">	
		<div id="page-heading-leaderboard">
			<?php
				echo "<title>".$pagetitle." - ".$sitename."</title>";
				echo "<h1>".$pagetitle."</h1>";

			?>
		</div>
		<table class="table">
			<thead>
				<th>#</th>
				<th><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img> Name</th>
				<th><img src="images/icons/statspage/infectedkilled1.png" width="25px" height="25px" class="table-img"></img> Z Kills</th>
				<th><img src="images/icons/statspage/murders.png" width="25px" height="25px" class="table-img"></img> Murders</th>
				<th><img src="images/icons/statspage/banditskilled1.png" width="25px" height="25px" class="table-img"> B Kills</img></th>
				<th><img src="images/icons/statspage/infectedheadshots1.png" width="25px" height="25px" class="table-img"> Z Headshots</img></th>
				<th><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"> Humanity</img></th>
				<th><img src="images/icons/statspage/playerdeaths1.png" width="25px" height="25px" class="table-img"> Deaths</img></th>
				<th><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"> Points</img></th>
			</thead>
			<tbody>
				<?php
					$result = $db->GetAll($leaderboard_query . " ORDER BY $sortby $sorttype LIMIT $limit");
					$rank = 1;

					if (sizeof($result) != 0) {
						foreach($result as $rowl) {
							$points = $rowl['KillsZ']+$rowl['KillsB']-$rowl['KillsH']-($rowl['Generation'] - 1);
							$deaths = $rowl['Generation'] - 1;
							if(isset($_SESSION['user_id'])) {
								echo "<tr>
									  <td>{$rank}</td>
									  <td><a href=\"".$security.".php?view=info&show=1&CharacterID={$rowl['CharacterID']}\">{$rowl['playerName']}</a></td>
									  <td>{$rowl['KillsZ']}</td>
									  <td>{$rowl['KillsH']}</td>
									  <td>{$rowl['KillsB']}</td>
									  <td>{$rowl['HeadshotsZ']}</td>
									  <td>{$rowl['Humanity']}</td>
									  <td>{$deaths}</td>
									  <td>{$points}</td>
									  </tr>";
							} else {
								echo "<tr>
									  <td>{$rank}</td>
									  <td>{$rowl['playerName']}</td>
									  <td>{$rowl['KillsZ']}</td>
									  <td>{$rowl['KillsH']}</td>
									  <td>{$rowl['KillsB']}</td>
									  <td>{$rowl['HeadshotsZ']}</td>
									  <td>{$rowl['Humanity']}</td>
									  <td>{$deaths}</td>
									  <td>{$points}</td>
									  </tr>";
							}

							$rank++;
						}
					}
				?>
			</tbody>
		</table>
		<select class="form-control pull-left" style="width:100px; margin-top: 20px; margin-bottom: 20px;" name="limit" onChange='window.location="index.php?leaderboard<?php if(isset($_GET['sortby'])) { echo '&sortby=' . $_GET['sortby']; } ?><?php if(isset($_GET['sorttype'])) { echo '&sorttype=' . $_GET['sorttype']; } ?>&limit=" + this.value;'>
			<option>Show</option>
			<option>10</option>
			<option>20</option>
			<option>30</option>
			<option>40</option>
			<option>50</option>
		</select>
		<select class="form-control pull-right" style="width:200px; margin-top: 20px; margin-bottom: 20px;" name="sortby" onChange='window.location="index.php?leaderboard<?php if(isset($_GET['sorttype'])) { echo '&sorttype=' . $_GET['sorttype']; } ?><?php if(isset($_GET['limit'])) { echo '&limit=' . $_GET['limit']; } ?>&sortby=" + this.value;'>
			<option>Sort by:</option>
			<option value="KillsZ">Zombie Kills</option>
			<option value="KillsH">Human Kills</option>
			<option value="KillsB">Bandit Kills</option>
			<option value="HeadshotsZ">Headshots</option>
			<option value="Humanity">Humanity</option>
			<option value="Generation">Deaths</option>
		</select>
		<select class="form-control pull-right" style="width:150px; margin-top: 20px; margin-bottom: 20px;" name="sorttype" onChange='window.location="index.php?leaderboard<?php if(isset($_GET['sortby'])) { echo '&sortby=' . $_GET['sortby']; } ?><?php if(isset($_GET['limit'])) { echo '&limit=' . $_GET['limit']; } ?>&sorttype=" + this.value;'>
			<option>Sort type:</option>
			<option value="DESC">Descending</option>
			<option value="ASC">Ascending</option>
		</select>
	</div>
</div>
