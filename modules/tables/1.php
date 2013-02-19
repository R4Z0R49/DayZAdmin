<?php
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = $db->GetAll($query);
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
	$res = $db->GetAll($query);
	$number = sizeof($res);

	$tableheader = header_player(0);
		
	foreach($res as $row) {
		$tablerows .= row_player($row);
	}
	include ('paging.php');
?>
