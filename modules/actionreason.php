<?php
if (isset($_SESSION['user_id']))
{
	if (isset($_GET["ban"])){
?>
<form action="<?php echo $security; ?>.php" method=GET>
<input type="hidden" name="view" value="actions">
<input type="hidden" name="ban" value="<?php echo $_GET["ban"];?>">
<table>
<tr><th align="right">Banning:</th><td>&nbsp;&nbsp;</td><td><?php echo $_GET["player"];?></td></tr>
<tr><th align="right">Time (minutes):</th><td>&nbsp;&nbsp;</td><td><input type="text" name="minutes" value="0"></td></tr>
<tr><th align="right">Reason:</th><td>&nbsp;&nbsp;</td><td><input type="text" name="reason" value="Admin Ban"></td></tr>
<tr><td colspan="3" align="left"><input type="submit" name="submit" value="Ban Player"></td></tr>
</table>
</form>
<?php
	} elseif(isset($_GET["kick"])) {
?>
<form action="<?php echo $security; ?>.php" method=GET>
<input type="hidden" name="view" value="actions">
<input type="hidden" name="kick" value="<?php echo $_GET["kick"];?>">
<table>
<tr><th align="right">Kicking:</th><td>&nbsp;&nbsp;</td><td><?php echo $_GET["player"];?></td></tr>
<tr><th align="right">Reason:</th><td>&nbsp;&nbsp;</td><td><input type="text" name="reason" value="Admin Kick" maxlength="64" size="32"></td></tr>
<tr><td colspan="3" align="left"><input type="submit" name="submit" value="Kick Player"></td></tr>
</table>
</form>
<?php
	}
}
?>
