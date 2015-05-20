<?php
include ('config.php');

if (isset($_SESSION['user_id']))
{

$user_id = $_SESSION['user_id'];
$accesslvl = $db->GetOne("SELECT accesslvl FROM users WHERE id = '$user_id'");

	switch($map)
	{
   		case 'chernarus':
			$mapName = "Chernarus";
			break;
    	case 'lingor':
			$mapName = "Lingor";
			break;
    	case 'tavi':
			$mapName = "Taviana";
			break;
	    case 'namalsk':
			$mapName = "Namalsk";
			break;
	    case 'takistan':
			$mapName = "Takistan";
			break;
	    case 'panthera2':
			$mapName = "Panthera";
			break;
	    case 'fallujah':
			$mapName = "Fallujah";
			break;
	}
?>
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="sidebar-nav">
					<li class="sidebar-brand"><a href="index.php"><img src="images/DayZAdmin.png" width="200px" height="50px"></img></a>
					</li>
					<li <?php echo ($page == 'home' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../index.php ' : ' index.php '); ?>"><i class="icon-home icon-color"></i> Stats</a>
					</li>
					<li <?php echo ($page == 'leaderboard' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../index.php?leaderboard ' : ' index.php?leaderboard '); ?>"><i class="icon-home icon-color"></i> Leaderboard</a> 
					</li>
					<li <?php echo ($page == 'dashboard' || $page == 'cpanel' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../'.$security.'.php ' : ' '.$security.'.php '); ?>"><i class="icon-cog icon-color"></i> Dashboard</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-color"></i> Settings<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $security; ?>.php?view=admin">Admin Options</a></li>
							<!--<li><a href="<?php echo $security; ?>.php?view=vip">VIP Options</a></li>-->
							<li><a href="<?php echo $security; ?>.php?view=profile">Profile Settings</a></li>
							<li><a href="<?php echo $security; ?>.php?view=database">Database Manager</a></li>
						</ul>
					</li>
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-color"></i> Entities<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $security; ?>.php?view=table&show=0">Online Players</a></li>
					<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Database <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Players <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $security; ?>.php?view=table&show=1">Alive</a></li>
									<li><a href="<?php echo $security; ?>.php?view=table&show=2">Dead</a></li>
									<li><a href="<?php echo $security; ?>.php?view=table&show=3">All</a></li>
								</ul>
							</li>
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Vehicles <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $security; ?>.php?view=table&show=4">All Vehicles</a></li>
									<li><a href="<?php echo $security; ?>.php?view=table&show=5">Spawn Locations</a></li>
								</ul>
							</li>
							<li><a href="<?php echo $security; ?>.php?view=table&show=6">Tents/Stashes</a></li>
							<li><a href="<?php echo $security; ?>.php?view=table&show=7">Other Deployables</a></li>
						</ul>
					</li>
					<li>
						<a href="<?php echo $security; ?>.php?view=check">Check Items</a>
					</li>
					<li>
						<a href="<?php echo $security; ?>.php?view=addVehsSQF">Add Vehicles by mission.sqf</a>
					</li>
				</ul>
				</li>
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-color"></i> <?php echo $mapName; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Instance ID: <?php echo $iid?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="dropdown">
									<li><a href="<?php echo $security; ?>.php?view=map&show=0">Active Players</a></li>
									<li><a href="<?php echo $security; ?>.php?view=map&show=4">Vehicles</a></li>
									<li><a href="<?php echo $security; ?>.php?view=map&show=6">Tents/Stashes</a></li>
									<li><a href="<?php echo $security; ?>.php?view=map&show=7">Other Deployables</a></li>
									<li><a href="<?php echo $security; ?>.php?view=map&show=8">Everything</a></li>
								</li>
							</ul>
						</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Database <b class="caret"></b></i></a>	
						<ul class="dropdown-menu">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Players <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $security; ?>.php?view=map&show=1">Alive</a></li>
									<li><a href="<?php echo $security; ?>.php?view=map&show=2">Dead</a></li>
									<li><a href="<?php echo $security; ?>.php?view=map&show=3">All</a></li>
								</ul>
							</li>
							<li><a href="<?php echo $security; ?>.php?view=map&show=5">Vehicle Spawn Locations</a></li>
						</ul>
					</li>
					</ul>
				</li> 
					<li class="divider"></li>
					<li><a href="<?php echo $security; ?>.php?logout"><i class="icon-arrow-left"></i> Logout</a></li>	
					<div id="top-search">
						<?php
							include ('searchbar.php');
						?>
					</div>	
				</ul>					
			</div>
        </div>

<?php
}
else
{
	header('Location: '.$security.'.php');
}
?>
