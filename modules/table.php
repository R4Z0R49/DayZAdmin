<?php
include ('config.php');
if (isset($_SESSION['user_id']))
{	
	$pnumber = 0;
	$tableheader = '';
	$tablerows = '';
	$pageNum = 1;
	$maxPage = 1;
	$rowsPerPage = 30;
	$nav  = '';
	$self = 'admin.php?view=table&show='.$show;
	$paging = '';
	
	$serverrunning = false;
	$delresult = "";
	$formhead = "";
	$formfoot = "";
	
	if (isset($_GET["show"])){
		$show = $_GET["show"];
	}else{
		$show = 0;
	}
	
	switch ($show) {
		case 0:
			$pagetitle = "Online players";
			break;
		case 1:
			$query = "select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id and survivor.is_dead = '0'"; 
			$pagetitle = "Alive players";		
			break;
		case 2:
			$query = "select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id and survivor.is_dead = '1'"; 
			$pagetitle = "Dead players";	
			break;
		case 3:
			$query = "select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id"; 
			$pagetitle = "All players";	
			break;
		case 4:
			$query = "SELECT iv.*, v.class_name from instance_vehicle iv inner join world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id WHERE instance_id = '" . $iid . "'";
			$pagetitle = "All Ingame Objects";	
			break;
		case 5:
			$query = "SELECT * FROM spawns WHERE world = '" . $map . "'";
			$pagetitle = "Vehicle spawn locations";	
			break;
		case 6:
			$query = "SELECT * FROM spawns WHERE world = '" . $map . "'";
			$pagetitle = "TEST Online Players";	
			break;
		default:
			$pagetitle = "Online players";
		};
		
	include ('tables/'.$show.'.php');

?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";
?>
</div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">		
			<?php echo $delresult; ?>
			<!--  start table-content  -->
			<div id="table-content">
				<!--  start message-blue -->
				<div id="message-blue">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="blue-left"><?php echo $pagetitle.": ".$pnumber; ?>. </td>
					<td class="blue-right"><a class="close-blue"><img src="images/table/icon_close_blue.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>
				<!--  end message-blue -->
				
				<!--  start paging..................................................... -->
				<?php echo $paging; ?>				
				<!--  end paging................ -->
				<br/>
				<br/>
				<!--  start product-table ..................................................................................... -->
				<?php echo $formhead;?>	
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
						<?php echo $tableheader; ?>
						<?php echo $tablerows; ?>				
					</table>
				<?php echo $formfoot;?>	
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->
				
			<!--  start paging..................................................... -->
			<?php echo $paging; ?>				
			<!--  end paging................ -->
	
			<div class="clear"></div>

		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>
<?php
}
else
{
	header('Location: admin.php');
}
?>