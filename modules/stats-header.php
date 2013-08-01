<div id="logo-stats-bg">
	<div id="logo-stats-centerer">
		<div id="logo-stats-left">
			<img src="images/Blissadmin.png" width="250px" height="80px" alt=""></a>
		</div>
		<div id="logo-stats-right">
			<a href="<?php echo($rightlogoLink); ?>"><img src="<?php echo($rightlogoImg); ?>" width="<?php echo($rightlogoWidth); ?>" height="<?php echo($rightlogoHeight); ?>" style="margin-top: <?php echo ($rightlogoMarginTop); ?>;" alt=""></img></a>
		</div>
	</div>
</div>

<div class="navbar navbar-inverse navbar-static-top navbar-custom">
	<div class="navbar-middle">
		<ul class="nav navbar-nav">
			<li <?php echo ($page == 'home' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../index.php ' : ' index.php '); ?>"><i class="icon-home"></i> Home</a></li> 
		<?php if ($ManuPanelLink == 1) { ?>
			<li <?php echo ($page == 'dashboard' || $page == 'cpanel' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../admin.php ' : ' admin.php '); ?>"><i class="icon-cog"></i> Dashboard</a></li> 
		<?php } ?>
		</ul>
	</div>
</div>