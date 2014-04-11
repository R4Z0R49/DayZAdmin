<div class="stats-content">	
	<div id="page-heading">
		<h1>Statistics</h1>
	</div>
	<div class="row">
		<div class="col-lg-1">
		</div>
		<div class="col-lg-5">
			<div class="stats-box">		
				<div class="stats-box-inner">
					<table border="0" cellpadding="4" cellspacing="0">
						<td width="26"><img src="images/icons/statspage/totalplayers1.png" width="36" height="36" /></td>
							<td width="184"><font color="#428bca"><strong>Total Players:</strong></font></td>
							<td align="right"><?php echo $num_totalplayers;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/totalplayerin24h.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Players in Last 24h:</strong></font></td>
							<td align="right"><?php echo $num_Played24h;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/alivecharacters1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Alive Characters:</strong></font></td>
							<td align="right"><?php echo $totalAlive;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/playerdeaths1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Player Deaths:</strong></font></td>
							<td align="right"><?php echo $num_deaths;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/infectedkilled1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Zombies Killed:</strong></font></td>
							<td align="right"><?php echo $KillsZ;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/infectedheadshots1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Zombies Headshots:</strong></font></td>
							<td align="right"><?php echo $HeadshotsZ;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/murders.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Murders:</strong></font></td>
							<td align="right"><?php echo $KillsH;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/heroesalive1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Heroes Alive:</strong></font></td>
							<td align="right"><?php echo $num_aliveheros;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/banditsalive1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Bandits Alive:</strong></font></td>
							<td align="right"><?php echo $num_alivebandits;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/banditskilled1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Bandits Killed:</strong></font></td>
							<td align="right"><?php echo $KillsB;?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/alivecharacters1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Total Walked:</strong></font></td>
							<td align="right"><?php echo round($totalwalked/1000);?>km</td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/alivecharacters1.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Average Alive:
							</strong></font></td>
							<td align="right"><?php echo $avg_duration ?></td>
						</tr>
						<tr>
							<td><img src="images/icons/statspage/vehicles.png" width="36" height="36" /></td>
							<td><strong><font color="#428bca">Vehicles:</strong></font></td>
							<td align="right"><?php echo $num_totalVehicles;?></td>
						</tr>
					</table>
					<br>
					<?php require_once('playersearch.php'); ?>
					<br>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3">
			<div id="chart1" style="height:200px;width:200px;"></div>
			<br>
			<div id="chart2" style="height:200px;width:200px;"></div>	
			<br>
			<div id="chart4" style="height:200px;width:200px;"></div>
		</div>
		<div class="col-lg-3">
			<div id="chart3" style="height:200px;width:200px;"></div>
			<br>
			<div id="chart5" style="height:200px;width:200px;"></div>
		</div>
	</div>	
</div>
