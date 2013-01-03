<?php
if ($pageNum > 1)
{
   $page  = $pageNum - 1;
   $prev  = "$self&page=$page";
   $first = "$self&page=1";
}
else
{
   $prev  = '&nbsp;'; // we're on page one, don't print previous link
   $first = '&nbsp;'; // nor the first page link
}
if ($pageNum < $maxPage)
{
   $page = $pageNum + 1;
   $next = "$self&page=$page";
   $last = "$self&page=$maxPage";
}
else
{
   $next = '&nbsp;'; // we're on the last page, don't print next link
   $last = '&nbsp;'; // nor the last page link
}
$paging = '
<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
<tr>
<td>
<a href="'.$first.'" class="page-far-left"></a>
<a href="'.$prev.'" class="page-left"></a>
<div id="page-info">Page <strong>'.$pageNum.'</strong> / '.$maxPage.'</div>
<a href="'.$next.'" class="page-right"></a>
<a href="'.$last.'" class="page-far-right"></a>
</td>
</tr>
</table>';
?>
