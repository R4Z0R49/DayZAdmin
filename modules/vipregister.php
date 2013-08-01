<?php
if (isset($_SESSION['user_id']))
{

if (empty($_POST))
{
	?>
<div class="custom-container-popup">
				<h2 class="custom-h2">Enter Details</h2>
				<form id="regformvip" action="admin.php?view=register">
					<table border="0">
					<tr>
						<th>Unique ID:</th>
						<td><input type="text" class="form-control" name="unique_id" /></td>
						<td></td>
					</tr>
					<tr>
						<th>PackageID:</th>
						<td><input type="text" class="form-control" name="package" /></td>
						<td></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<input type="submit" value="Submit" class="btn btn-default pull-right" />
						</td>
						<td></td>
					</tr>
					</table>
					<br>
					* UniqueID = The unique id of the player.
					<br>* PackageID = The id of the package.
				</form>		
			<div id="result"></div>
			<!--  end table-content  -->
			<script>
				  /* attach a submit handler to the form */
				  $("#regformvip").submit(function(event) {

					/* stop form from submitting normally */
					event.preventDefault(); 
						
					/* get some values from elements on the page: */
					var $form = $( this ),
						term = $form.find( 'input[name="unique_id"]' ).val(),
						term2 = $form.find( 'input[name="package"]' ).val(),
						url = $form.attr( 'action' );
						
					var d = document.getElementById('content-table-inner');
					var olddiv = document.getElementById('table-content');
					d.removeChild(olddiv);
					
					var d = document.getElementById('dvPopup');
					var olddiv = document.getElementById('closebutton');
					d.removeChild(olddiv);

					/* Send the data using post and put the results in a div */
					$.post( url, { unique_id: term, cust_loadout_id: term2 },
					  function( data ) {
						  var content = $( data ).find( '#content' );
						  $( "#result" ).empty().append( content );
					  }
					);
				  });
			</script>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
<?php
}
else
{

	$unique_id = (isset($_POST['unique_id'])) ? $_POST['unique_id'] : '';
	$cust_loadout_id = (isset($_POST['cust_loadout_id'])) ? $_POST['cust_loadout_id'] : '';
	
	$error = false;
	$errort = '';
	
	$res = $db->GetAll("SELECT `unique_id` FROM `cust_loadout_profile` WHERE `cust_loadout_id` = ?", $cust_loadout_id);
	if (sizeof($res)==1)
	{
		$error = true;
		$errort .= 'Unique_ID already used.<br />';
	}
	
	if (!$error)
	{		
		$db->Execute("INSERT INTO cust_loadout_profile SET unique_id = ?, cust_loadout_id = ?", array($unique_id, $cust_loadout_id));
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`,) VALUES ('ADDED VIP: ?',?,NOW())", array($login, $_SESSION['login']));
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
				<td class="red-left">Error in adding process!</td>
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
