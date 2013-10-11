<?php
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = $db->GetAll($table2);
    $pnumber = is_array($res) ? count($res) : 0;

	if(isset($_GET['page']))
	{
		$pageNum = $_GET['page'];
	}
	$offset = ($pageNum - 1) * $rowsPerPage;
	$maxPage = ceil($pnumber/$rowsPerPage);			

	for($page = 1; $page <= $maxPage; $page++)
	{
	   if ($page == $pageNum)
	   {
		  $nav .= " $page "; // no need to create a link to current page
	   }
	   else
	   {
		  $nav .= "$self&page=$page";
	   }
	}

	$query = $table2." LIMIT ".$offset.",".$rowsPerPage;
	$res = $db->GetAll($query);

	$tableheader = header_player(0);
		
	foreach($res as $row) {
		$tablerows .= row_player($row);
	}
	include ('paging.php');
?>
