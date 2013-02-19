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

	$tableheader = '
		<tr>
		<th class="table-header-repeat line-left minwidth-1"><a href="">Classname</a>	</th>
		<th class="table-header-repeat line-left minwidth-1"><a href="">Object UID</a></th>
		<th class="table-header-repeat line-left"><a href="">Position</a></th>
		</tr>';
		foreach($res as $row) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);

		$tablerows .= "<tr>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&id=".$row['id']."\">".$row['otype']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&id=".$row['id']."\">".$row['id']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&id=".$row['id']."\">".sprintf("%03d",round($Worldspace[1]/100)).sprintf("%03d",round((154-($Worldspace[2]/100))))."</a></td>
		</tr>";
		}
	include ('paging.php');
?>
