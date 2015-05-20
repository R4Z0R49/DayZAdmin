<?php 
if (isset($_SESSION['user_id']))
{
?>

<!--  start top-search -->

	<form action="<?php echo $security; ?>.php?view=search" method="post" style="margin-left: 20px; margin-top: 10px;">
		<table>
		<tr>
		<td><input style="margin-bottom: 2px;" name="search" type="text" value="<?php if(isset($_POST['search'])){ echo $_POST['search']; } else { echo 'Search'; }?>" onblur="if (this.value=='') { this.value='Search'; }" onfocus="if (this.value=='Search') { this.value=''; }" class="form-control" /></td>
		</tr>
		<tr>
		<td>
		<select name="type" style="margin-bottom: 2px;" class="form-control">
			<option value="player" <?php if(isset($_POST['type']) && $_POST['type'] == "player"){?> selected<?php }?>>Player name</option>
			<option value="item" <?php if(isset($_POST['type']) && $_POST['type'] == "item"){?> selected<?php }?>>Player items</option>
			<option value="vehicle" <?php if(isset($_POST['type']) && $_POST['type'] == "vehicle"){?> selected<?php }?>>Vehicle type</option>
			<option value="container" <?php if(isset($_POST['type']) && $_POST['type'] == "container"){?> selected<?php }?>>Vehicle/Tent/Stash items</option>
		</select> 
		</td>
		</tr>
		<tr>
		<td>
		<input type="submit" value="Search" style="height: 39px;" class="btn btn-primary"  />
		</td>
		</tr>
		</table>
	</form>

<!--  end top-search -->
<?php
}
else
{
	header('Location: '.$security.'.php');
}
?>
