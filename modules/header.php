<?php
if (isset($_SESSION['user_id']))
{
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<link rel="stylesheet" href="css/menu.css" />	
<link rel="stylesheet" href="css/watch.css" />	
<link rel="stylesheet" href="css/flexcrollstyles.css" />	
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>	
<script src="js/flexcroll.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.fullscreen.js"></script>
<!--<script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery/ui.core.js" type="text/javascript"></script>
<script src="js/jquery/ui.checkbox.js" type="text/javascript"></script>
<script src="js/jquery/jquery.bind.js" type="text/javascript"></script>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>

 Custom jquery scripts 
<script src="js/jquery/custom_jquery.js" type="text/javascript"></script>-->
 
<!-- Tooltips
<script src="js/jquery/jquery.tooltip.js" type="text/javascript"></script>
<script src="js/jquery/jquery.dimensions.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
});
</script> -->

<script src="js/modalpopup.js" type="text/javascript"></script>
<?php if($enableclock) { ?>
<script type="text/javascript" src="jquery.jclock.js"></script>
<script type="text/javascript">
    $(function($) {
        var options = {
            utc: true,
            utcOffset: <?php echo $timeoffset; ?>,
            // seedTime must be a number representing time in milliseconds
            seedTime: <?php echo time() * 1000; ?>        }
        $('.jclock').jclock(options);
    });
</script>
<?php } // end if($enableclock) ?>
</head>
<body> 

<?php if($enableclock) { ?>
<div id="clock" style=" font-size: 10pt; color: #ffffff; position: absolute; top: 8px; left: 2px; margin: 0 0 0 0;">
    <span class="jclock">11:11:11</span>
</div>
<?php } // end if($enableclock) ?>

<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo">
		<a href=""><img src="images/logo.png" width="150px" height="72px" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<!-- start watch -->

	<!-- end watch -->
	
	<!--  start top-search -->
	<div id="top-search">
	<?php
	include ('searchbar.php');
	?>
	</div>
 	<!--  end top-search -->
 	<div class="clear"></div>

</div>
<!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
	
<div class="clear">&nbsp;</div>
 
<?php
include ('navbar.php');
?>
 <div class="clear"></div>
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">
<?php
}
else
{
	header('Location: admin.php');
}
?>
