<?php
if (isset($_SESSION['user_id']))
{
?>
</div>
<!--  end content -->
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
<!-- start footer -->         
<div id="footer">
	<!--  start footer-left -->
	<div id="footer-left">
	<?php echo $sitename ?> Panel &copy; Copyright 2006-2013 Admin-panel. Creator katzsmile, Redesigned by R4Z0R49/Wiley. Theme Redesigned By Marcuz.</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
 
</body>
</html>
<?php
}
else
{
	header('Location: admin.php');
}
?>