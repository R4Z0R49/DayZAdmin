<?php
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$pnumber = mysql_num_rows($res);			

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
	$res = mysql_query($query) or die(mysql_error());
	$number = mysql_num_rows($res);

	$tableheader = '
		<tr>
		<th class="table-header-repeat line-left minwidth-1"><a href="">Classname</a>	</th>
		<th class="table-header-repeat line-left minwidth-1"><a href="">Object UID</a></th>
		<th class="table-header-repeat line-left"><a href="">Position</a></th>
		</tr>';
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);

		$tablerows .= "<tr>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&id=".$row['id']."\">".$row['otype']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&id=".$row['id']."\">".$row['id']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"admin.php?view=info&show=5&id=".$row['id']."\">".sprintf("%03d",round($y/100)).sprintf("%03d",round((154-($x/100))))."</a></td>
		</tr>";
		}
	include ('paging.php');
?>