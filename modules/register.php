<?php
if (isset($_SESSION['user_id']))
{

$res_accesslvl = $db->GetAll("SELECT name FROM accesslvl");
$accesslvl_list="";
foreach($res_accesslvl as $row_accesslvl) {
$accesslvl_list .= '<option value="'. $row_accesslvl['name'] .'">' . $row_accesslvl['name'] . '</option>';
}
function GenerateSalt($n=3)
{
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
	$counter = strlen($pattern)-1;
	for($i=0; $i<$n; $i++)
	{
		$key .= $pattern{rand(0,$counter)};
	}
	return $key;
}

if (empty($_POST))
{
	?>
<div class="custom-container-popup" id="content-table-inner">
	<div id="table-content">
				<h2 class="custom-h2">Enter Details</h2><br>
				<form id="regform" action="admin.php?view=register">
				<table border="0" id="id-form">
					<tr>
						<th class="custom-th-popup">Login:</th>
						<td><input type="text" class="form-control" name="login" /></td>
						<td></td>
					</tr>
					<tr>
						<th>Password:</th>
						<td><input type="text" class="form-control" name="password" /></td>
						<td></td>
					</tr>
					<tr>
						<th>Access level:</th>
						<td>
						<select name="accesslvl" class="form-control">
						<option value="" selected="selected">Access Level</option>
						<?php echo $accesslvl_list; ?>
						</select>
						</td>
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
						<h2 class="custom-h2">Access level</h2>
						<br>
						* Gives the user the access of the group that you've set up. Full which is one of the default access levels gives full access to the panel, and semi gives access to everything but map, gps co-ords and editing of administrators.
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
						term = $form.find( 'input[name="login"]' ).val(),
						term2 = $form.find( 'input[name="password"]' ).val(),
						term3 = $form.find( 'select[name="accesslvl"]' ).val(),
						url = $form.attr( 'action' );
						
					var d = document.getElementById('content-table-inner');
					var olddiv = document.getElementById('table-content');
					d.removeChild(olddiv);
					
					var d = document.getElementById('dvPopup');
					var olddiv = document.getElementById('closebutton');
					d.removeChild(olddiv);

					/* Send the data using post and put the results in a div */
					$.post( url, { login: term, password: term2, accesslvl: term3 },
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

	$login = (isset($_POST['login'])) ? $_POST['login'] : '';
	$password = (isset($_POST['password'])) ? $_POST['password'] : '';
	$accesslvl = (isset($_POST['accesslvl'])) ? $_POST['accesslvl'] : '';
	
	$error = false;
	$errort = '';
	
	if(!isset($_POST['accesslvl']))
	{
		$error = true;
		$errort .= 'Select the access level of the user! <br />';
	}
	
	if (strlen($login) < 2)
	{
		$error = true;
		$errort .= 'Login must be at least 2х characters.<br />';
	}
	if (strlen($password) < 6)
	{
		$error = true;
		$errort .= 'Password must be at least 6 characters.<br />';
	}
	
	$res = $db->GetAll("SELECT `id` FROM `users` WHERE `login` = ?", $login);
	if (sizeof($res)==1)
	{
		$error = true;
		$errort .= 'Login already used.<br />';
	}
	
	if (!$error)
	{
		$salt = GenerateSalt();
		$hashed_password = md5(md5($password) . $salt);
		
		$db->Execute("INSERT INTO users SET login = ?, password = ?, accesslvl = ?, salt = ?", array($login, $hashed_password, $accesslvl, $salt));
		$db->Execute("INSERT INTO `logs`(`action`, `user`, `timestamp`,) VALUES ('REGISTER ADMIN: ?',?,NOW())", array($login, $_SESSION['login']));
		?>
		<!--  start message-green -->
		<div id="msg">
			<div id="message-green">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td class="green-left">New admin is succesfully registered!</td>
				<td class="green-right"><a href="#" onclick="window.location.href = 'admin.php?view=admin';" class="close-green"><img src="<?php echo $path;?>images/table/icon_close_green.gif" alt="" /></a></td>
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
				<td class="red-right"><a href="#" onclick="window.location.href = 'admin.php?view=admin';" class="close-red"><img src="<?echo $path;?>images/table/icon_close_red.gif" alt="" /></a></td>
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
