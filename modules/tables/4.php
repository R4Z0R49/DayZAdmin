<?php
		
	error_reporting (E_ALL ^ E_NOTICE);
	
	$binds = $query[1];
	$query = $query[0];
	$res = $db->GetAll($query, $binds);
	$pnumber = sizeof($res);

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

			
	$query = $query." LIMIT ".$offset.",".$rowsPerPage;
	$res = $db->GetAll($query, $binds);
	$number = sizeof($res);
	
	$tableheader = header_vehicle(0, $chbox);
	
	foreach($res as $row) {
		$tablerows .= row_vehicle($row, $chbox);
	}
	include ('paging.php');
?>
