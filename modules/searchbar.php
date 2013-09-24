<?php 
if (isset($_SESSION['user_id']))
{
?>

<!--  start top-search -->

	<form action="admin.php?view=search" method="post">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td><input name="search" type="text" value="<?php if(isset($_POST['search'])){ echo $_POST['search']; } else { echo 'Search'; }?>" onblur="if (this.value=='') { this.value='Search'; }" onfocus="if (this.value=='Search') { this.value=''; }" class="form-control" /></td>
		<td>
		<select name="type" class="form-control">
			<option value="player" <?php if(isset($_POST['type']) && $_POST['type'] == "player"){?> selected<?php }?>>Player name</option>
			<option value="item" <?php if(isset($_POST['type']) && $_POST['type'] == "item"){?> selected<?php }?>>Player items</option>
			<option value="vehicle" <?php if(isset($_POST['type']) && $_POST['type'] == "vehicle"){?> selected<?php }?>>Vehicle type</option>
			<option value="container" <?php if(isset($_POST['type']) && $_POST['type'] == "container"){?> selected<?php }?>>Vehicle/Tent/Stash items</option>
		</select> 
		</td>
		<td>
		<input type="submit" value="Search" style="height: 39px;" class="btn btn-default"  />
		</td>
		</tr>
		</table>
	</form>

<!--  end top-search -->
<?php
}
else
{
	header('Location: admin.php');
}
?>
