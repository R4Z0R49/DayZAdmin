<?php
include ('config.php');
include ('queries.php');

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
			$pagetitle = "Alive players";		
			break;
		case 2:
			$pagetitle = "Dead players";	
			break;
		case 3:
			$pagetitle = "All players";	
			break;
		case 4:
			$pagetitle = "Vehicles";	
			break;
		case 5:
			$pagetitle = "Vehicle spawn locations";	
			break;
		case 6:
			$pagetitle = "Tents/Stashes";	
			break;
		case 7:
			$pagetitle = "Other Deployables";	
			break;
		default:
			$pagetitle = "Online players";
		};
		
	include ('tables/'.$show.'.php');

?>

<div id="page-heading">
<?php
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";
?>
</div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="table">
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
	</table>
	<div class="clear">&nbsp;</div>
<?php
}
else
{
	header('Location: admin.php');
}
?>
