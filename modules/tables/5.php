<?php
	error_reporting (E_ALL ^ E_NOTICE);
	
    $res = $db->GetAll($table5 );
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

			
	$query = $table5." LIMIT ".$offset.",".$rowsPerPage;
    $res = $db->GetAll($query);

	$tableheader = '
		<tr>
		<th class="table-header-repeat line-left minwidth-1"><a href="">Classname</a>	</th>
		<th class="table-header-repeat line-left minwidth-1"><a href="">Object UID</a></th>
		<th class="table-header-repeat line-left"><a href="">Position</a></th>
		</tr>';
		foreach($res as $row) {
		$Worldspace = str_replace("[", "", $row['Worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);

		$tablerows .= "<tr>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&ObjectUID=".$row['ObjectUID']."\">".$row['Classname']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&ObjectUID=".$row['ObjectUID']."\">".$row['ObjectUID']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&ObjectUID=".$row['ObjectUID']."\">".sprintf("%03d%03d",round($Worldspace[1]/100),round((154-($Worldspace[2]/100))))."</a></td>
		</tr>";
		}
	include ('paging.php');
?>
