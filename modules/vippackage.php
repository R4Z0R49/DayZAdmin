<?php
if (isset($_SESSION['user_id']))
{

if (empty($_POST))
{
	?>
<div class="custom-container-popup" id="content-table-inner">
	<div id="table-content">
				<h2 class="custom-h2">Enter Details</h2><br>
				<form id="regform" action="admin.php?view=vippackage">
				<table border="0" id="id-form">
					<tr>
						<th>Inventory:</th>
						<td><input type="text" class="form-control" name="inv" /></td>
						<td></td>
					</tr>
					<tr>
						<th>Backpack:</th>
						<td><input type="text" class="form-control" name="bck" /></td>
						<td></td>
					</tr>
					<tr>
						<th>Model:</th>
						<td><input type="text" class="form-control" name="model" /></td>
						<td></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<input type="submit" value="Submit" class="btn btn-default pull-right">
						</td>
						<td></td>
					</tr>
					</table>
						<br>
						* Inventory = The inventory SQL string.
						<br>
						* Backpack = The backpack SQL string.
						<br>
						* Model = The playermodel (Default: Survivor2_DZ).	
				</form>	
		</div>
			<div id="result"></div>
			</body>
			<!--  end table-content  -->
			<script>
				  /* attach a submit handler to the form */
				  $("#regform").submit(function(event) {

					/* stop form from submitting normally */
					event.preventDefault(); 
						
					/* get some values from elements on the page: */
					var $form = $( this ),
						term = $form.find( 'input[name="inv"]' ).val(),
						term2 = $form.find( 'input[name="bck"]' ).val(),
						term3 = $form.find( 'input[name="model"]' ).val(),
						url = $form.attr( 'action' );
						
					var d = document.getElementById('content-table-inner');
					var olddiv = document.getElementById('table-content');
					d.removeChild(olddiv);
					
					var d = document.getElementById('dvPopup');
					var olddiv = document.getElementById('closebutton');
					d.removeChild(olddiv);

					/* Send the data using post and put the results in a div */
					$.post( url, { inv: term, bck: term2, model: term3},
					  function( data ) {
						  var content = $( data ).find( '#content' );
						  $( "#result" ).empty().append( content );
					  }
					);
				  });
			</script>
</div>
<?php
}
else
{

	$inv = (isset($_POST['inv'])) ? $_POST['inv'] : '';
	$bck = (isset($_POST['bck'])) ? $_POST['bck'] : '';
	$model = (isset($_POST['model'])) ? $_POST['model'] : '';

	$error = false;
	$errort = '';
	
	if(!isset($_POST['model'])){
		$error = true;
		$errort .= 'You must specify a model! <br />';
	}

	if (!$error)
	{
		$db->Execute("INSERT INTO cust_loadout SET inventory = ?, backpack = ?, model = ?", array($inv, $bck, $model));
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`,) VALUES ('ADD LOADOUT: ?',?,NOW())", array($login, $_SESSION['login']));
		?>
		<!--  start message-green -->
		<div id="msg">
			<div id="message-green">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td class="green-left">New loadout is succesfully added!</td>
				<td class="green-right"><a href="#" onclick="window.location.href = 'admin.php?view=vip';" class="close-green"><img src="<?php echo $path;?>images/table/icon_close_green.gif" alt="" /></a></td>
			</tr>
			</table>
			</div>
		</div>
		<!--  end message-green -->
		<?php
	}
	else
	{
		?>
		<div id="msg">
			<div id="message-red">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td class="red-left">Error in registration process!</td>
				<td class="red-right"><a href="#" onclick="window.location.href = 'admin.php?view=vip';" class="close-red"><img src="<?echo $path;?>images/table/icon_close_red.gif" alt="" /></a></td>
			</tr>
			</table>
			</div>
			<?php print $errort;?>
		</div>
		<?php
		
	}

}
}
else
{
	header('Location: admin.php');
}
?>