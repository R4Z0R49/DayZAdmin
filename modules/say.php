<?php 
if (isset($_SESSION['user_id']))
{
?>
<!--  start say-box -->
	<form action="<?php echo $security; ?>.php?view=actions" method="post">
		<table class="table" width="50%"> 
			<tr>
				<td>
					<textarea name="say" cols="68" rows="10" ></textarea>		
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" class="btn btn-default" style=""/>
				</td>
			<tr>
		</table>
	</form>
	<br />

<!--  end say-box -->
<?php
}
else
{
	header('Location: '.$security.'.php');
}
?>
