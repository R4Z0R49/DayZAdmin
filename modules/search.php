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
	echo "<h1 class='custom-h1'>".$pagetitle."</h1>";

?>
</div>
		<?php
        require_once('queries.php');
		include ('searchbar.php');
		?><br/><?php
		if (!empty($_POST))
		{
			error_reporting (E_ALL ^ E_NOTICE);
			$search = '%'.substr($_POST['search'], 0, 64).'%';

			?>
			<table border="0" width="100%">
			<?php
			switch ($_POST['type']) {
				case 'player':
					$tableheader = header_player(0);
					echo $tableheader;
					$res = $db->GetAll($search_query_player, $search);
					$tablerows = "";
					foreach($res as $row) {
						$tablerows .= row_player($row);
					}
					echo $tablerows;
				break;
				case 'item':
					$tableheader = header_player(0);
					echo $tableheader;
					$res = $db->GetAll($search_query_item, array($search, $search));
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
					$res = $db->GetAll($search_query_vehicle, array($iid, $search));
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
					$res = $db->GetAll($search_query_container, array($iid, $search));
					$chbox = "";
					foreach($res as $row) {
							$tablerows .= row_vehicle($row, $chbox);
					}
					echo $tablerows;
					break;
				default:
					$tableheader = header_player(0);
					echo $tableheader;
                    $res = $db->GetAll($search_query_player, $search);
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
<?php
}
else
{
	header('Location: index.php');
}
?>
