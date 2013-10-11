<?php
		
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = $db->GetAll($table7, $iid);
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

			
	$query = $table7." LIMIT ".$offset.",".$rowsPerPage;
	$res = $db->GetAll($query, $iid);
	
    if(is_array($res)) {
    	$tableheader = header_deployable(0, $chbox);
	
	    foreach($res as $row) {
		    $tablerows .= row_deployable($row, $chbox);
    	}
	    include ('paging.php');
    }
?>
