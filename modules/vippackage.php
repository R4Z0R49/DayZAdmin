<?php
if (isset($_SESSION['user_id']))
{

if (empty($_POST))
{
	?>
<div class="custom-container-popup">
				<h2 class="custom-h2">Enter Details</h2>
				<form id="regformvip" action="admin.php?view=register">
					<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
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
						<th>Skin:</th>
						<td><input type="text" class="form-control" name="skin" /></td>
						<td></td>
					</tr>
					<tr>
						<th>Description:</th>
						<td><input type="text" class="form-control" name="desc" /></td>
						<td></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<input type="submit" value="Submit" class="btn btn-default pulll-right" />
						</td>
						<td></td>
					</tr>
					</table>
					<br>
					* Inventory = The inventory sql string
					<br>
					* Backpack = The backpack sql string
					<br>
					* Skin = The skin sql model
					<br>
					* Description = A brief description
				</form>		
			</div>
			<div id="result"></div>
			<!--  end table-content  -->
			<script>
				  /* attach a submit handler to the form */
				  $("#regformvip").submit(function(event) {

					/* stop form from submitting normally */
					event.preventDefault(); 
						
					/* get some values from elements on the page: */
					var $form = $( this ),
						term = $form.find( 'input[name="inv"]' ).val(),
						term2 = $form.find( 'input[name="bck"]' ).val(),
						term3 = $form.find( 'input[name="skin"]' ).val(),
						term4 = $form.find( 'input[name="desc"]' ).val(),
						url = $form.attr( 'action' );
						
					var d = document.getElementById('content-table-inner');
					var olddiv = document.getElementById('table-content');
					d.removeChild(olddiv);
					
					var d = document.getElementById('dvPopup2');
					var olddiv = document.getElementById('closebutton');
					d.removeChild(olddiv);

					/* Send the data using post and put the results in a div */
					$.post( url, { inv: term, bck: term2, skin: term3, desc: term4 },
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
	$skin = (isset($_POST['skin'])) ? $_POST['skin'] : '';
	$desc = (isset($_POST['desc'])) ? $_POST['desc'] : '';
	
	$error = false;
	$errort = '';
	
	if (!$error)
	{		
		$db->Execute("INSERT INTO `cust_loadout'`(`inventory`,`backpack`,`model`,`description`", array($inv, $bck, $skin, $desc));
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`,) VALUES ('ADDED PACKAGE',?,NOW())", array($login, $_SESSION['login']));
		?>
		<!--  start message-green -->
		<div id="msg">
			<div id="message-green">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td class="green-left">New VIP package is succesfully added!</td>
				<td class="green-right"><a href="#" onclick="window.location.href = 'admin.php?view=addpackage';" class="close-green"><img src="<?php echo $path;?>images/table/icon_close_green.gif" alt="" /></a></td>
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
				<td class="red-right"><a href="#" onclick="window.location.href = 'admin.php?view=addpackage';" class="close-red"><img src="<?echo $path;?>images/table/icon_close_red.gif" alt="" /></a></td>
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
