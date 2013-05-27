<?php
if (isset($_SESSION['user_id']))
{

if (empty($_POST))
{
	?>
	<div id="page-heading">
		<h1>VIP Adding</h1>
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
				<h2>Enter unique ID and package for new VIP</h2>
				
				<form id="regformvip" action="admin.php?view=register">
				
					<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
					<tr>
						<th valign="top">Unique ID:</th>
						<td><input type="text" class="inp-form" name="unique_id" /></td>
						<td></td>
					</tr>
					<tr>
						<th valign="top">Package:</th>
						<td><input type="text" class="inp-form" name="package" /></td>
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
