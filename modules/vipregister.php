<?php
if (isset($_SESSION['user_id']))
{

if (empty($_POST))
{
	?>
<div class="custom-container-popup" id="content-table-inner">
	<div id="table-content">
				<h2 class="custom-h2">Enter Details</h2><br>
				<form id="regformvip" action="admin.php?view=vipregister">
				<table border="0" id="id-form">
					<tr>
						<th>UniqueID:</th>
						<td><input type="text" class="form-control" name="unique_id" /></td>
						<td></td>
					</tr>
					<tr>
						<th>LoadoutID:</th>
						<td><input type="text" class="form-control" name="loadout_id" /></td>
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
						* UniqueID = The unique id of the user.
						<br>* LoadoutID = The id of the loadout.	
				</form>	
		</div>
			<div id="result"></div>
			</body>
			<!--  end table-content  -->
			<script>
				  /* attach a submit handler to the form */
				  $("#regformvip").submit(function(event) {

					/* stop form from submitting normally */
					event.preventDefault(); 
						
					/* get some values from elements on the page: */
					var $form = $( this ),
						term = $form.find( 'input[name="unique_id"]' ).val(),
						term2 = $form.find( 'input[name="loadout_id"]' ).val(),
						url = $form.attr( 'action' );
						
					var d = document.getElementById('content-table-inner');
					var olddiv = document.getElementById('table-content');
					d.removeChild(olddiv);
					
					var d = document.getElementById('dvPopup');
					var olddiv = document.getElementById('closebutton');
					d.removeChild(olddiv);

					/* Send the data using post and put the results in a div */
					$.post( url, { unique_id: term, loadout_id: term2},
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

	$unique_id = (isset($_POST['unique_id'])) ? $_POST['unique_id'] : '';
	$loadout_id = (isset($_POST['loadout_id'])) ? $_POST['loadout_id'] : '';
	
	$error = false;
	$errort = '';
	
	if(!isset($_POST['unique_id'])){
		$error = true;
		$errort .= 'You must specify a unique id! <br />';
	}

	if(!isset($_POST['loadout_id'])){
		$error = true;
		$errort .= 'You must specify a loadout id! <br />';
	}


	if (!$error)
	{
		$db->Execute("INSERT INTO cust_loadout_profile SET  unique_id = ?, cust_loadout_id = ?", array($unique_id, $loadout_id));
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`,) VALUES ('ADD VIP: ?',?,NOW())", array($login, $_SESSION['login']));
		?>
		<!--  start message-green -->
		<div id="msg">
			<div id="message-green">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td class="green-left">New VIP is succesfully added!</td>
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
