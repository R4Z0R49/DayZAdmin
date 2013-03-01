<?php
if (isset($_SESSION['user_id']))
{
	if (isset($_POST['type'])){
		$pagetitle = "Search for ".$_POST['type'];
	} else {
		$pagetitle = "New search";
	}
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
		<div id="content-table-inner">	
		<!--  start content-table-inner ...................................................................... START -->
		<?php
		include ('searchbar.php');
		?><br/><?php
		if (!empty($_POST))
		{
			error_reporting (E_ALL ^ E_NOTICE);
			$search = '%'.substr($_POST['search'], 0, 64).'%';

			?>
			<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
			<?php
			switch ($_POST['type']) {
				case 'player':
					$tableheader = header_player(0);
					echo $tableheader;
					$likeString = '%' . $good . '%';
					$res = $db->GetAll("select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id and name LIKE ? ORDER BY last_updated DESC", $search);
					$tablerows = "";
					foreach($res as $row) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
				break;
				case 'item':
					$tableheader = header_player(0);
					echo $tableheader;
					$likeString = '%' . $good . '%';
					$res = $db->GetAll("SELECT * from (SELECT profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id) as T where inventory LIKE ? OR backpack LIKE ? ORDER BY last_updated DESC", array($likeString, $likeString));
					$tablerows = "";
					foreach($res as $row) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
					break;
				case 'vehicle':
					$chbox = "";
					$tableheader = header_vehicle(0, $chbox);
					echo $tableheader;
					$likeString = '%' . $good . '%';
					$res = $db->GetAll("select iv.id, v.class_name, 0 owner_id, iv.worldspace, iv.inventory, iv.instance_id, iv.parts, fuel, oc.type, damage from instance_vehicle iv inner join world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on v.id = wv.vehicle_id inner join object_classes oc on v.class_name = oc.classname where v.class_name LIKE ? OR oc.type LIKE ?", array($likeString, $likeString));
					$chbox = "";
					foreach($res as $row) {
							$tablerows .= row_vehicle($row, $chbox);
					}
					echo $tablerows;
					break;
				case 'container':
					$chbox = "";
					$tableheader = header_vehicle(0, $chbox);
					echo $tableheader;
					$likeString = '%' . $good . '%';
					$res = $db->GetAll("select * from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname where d.class_name = 'TentStorage' and id.inventory LIKE ?", $likeString);
					$chbox = "";
					foreach($res as $row) {
							$tablerows .= row_vehicle($row, $chbox);
					}
					echo $tablerows;
					break;
				default:
					$tableheader = header_player(0);
					echo $tableheader;
					$likeString = '%' . $good . '%';
					$res = $db->GetAll("select profile.name, survivor.* from profile, survivor as survivor where profile.unique_id = survivor.unique_id and name LIKE ? OR name LIKE ? ORDER BY lastupdate DESC", array($likeString, $likeString));
					$tablerows = "";
					foreach($res as $row) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
				};
			?>
			</table>
			<?php
		}
		else
		{

		}
		?>		
		<!--  end content-table-inner ............................................END  -->
		</div>
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
	header('Location: index.php');
}
?>
