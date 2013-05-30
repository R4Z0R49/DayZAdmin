<?php
if (isset($_SESSION['user_id']))
{

if (empty($_POST))
{
	?>
	<div id="page-heading">
		<h1>VIP Package Adding</h1>
	</div>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			
			<div id="table-content">
				<h2>Enter inventory, backpack and skin of package</h2>
				
				<form id="regformvip" action="admin.php?view=register">
				
					<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
					<tr>
						<th valign="top">Inventory:</th>
						<td><input type="text" class="inp-form" name="inv" /></td>
						<td></td>
					</tr>
					<tr>
						<th valign="top">Backpack:</th>
						<td><input type="text" class="inp-form" name="bck" /></td>
						<td></td>
					</tr>
					<tr>
						<th valign="top">Skin:</th>
						<td><input type="text" class="inp-form" name="skin" /></td>
						<td></td>
					</tr>
					<tr>
						<th valign="top">Description:</th>
						<td><input type="text" class="inp-form" name="desc" /></td>
						<td></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td valign="top">
							<input type="submit" value="" class="form-submit" />
						</td>
						<td></td>
					</tr>
					</table>
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
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
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
