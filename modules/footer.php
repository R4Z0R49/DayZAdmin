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
	Bliss Administration panel &copy; Copyright 2006-2012 <a href="http://lead-games.com">Lead Games</a>Redesigned by UnclearWall. All rights reserved.</div>
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