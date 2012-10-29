<?php 
if (isset($_SESSION['user_id']))
{
?>
<!--  start say-box -->
	<form action="admin.php?view=actions" method="post">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		<textarea name="say" cols="68" rows="10" ></textarea>
		</td>
		</tr>
		<tr>		
		<td align="right">
		<br />
		<input type="submit" class="submit-login" style="margin-right:20px;"/>
		</td>
		</tr>
		</table>
	</form>
	<br />

<!--  end say-box -->
<?php
}
else
{
	header('Location: admin.php');
}
?>