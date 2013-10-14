<?php

if (isset($_SESSION['user_id']))
{
	?>

	<head>
		<link rel="stylesheet" href="css/leaflet.css" type="text/css" />
		<link rel="stylesheet" href="css/map.css" type="text/css" />
		<script src="js/leaflet.js" type="text/javascript"></script>
		<script src="js/map.js" type="text/javascript"></script>
		<script src="js/map/<?php echo $map; ?>.js"></script>
	</head>
	
	<div id="map"></div>
	
	<script>
	InitMap();
	
	var Icon = L.Icon.extend({ options: { iconSize: [32, 37], iconAnchor: [16, 35] } });
	var car = new Icon({ iconUrl: 'images/icons/car.png' }),
		bus = new Icon({ iconUrl: 'images/icons/bus.png' }),
		atv = new Icon({ iconUrl: 'images/icons/atv.png' }),
		bike = new Icon({ iconUrl: 'images/icons/bike.png' }),
		farmvehicle = new Icon({ iconUrl: 'images/icons/farmvehicle.png' }),
		helicopter = new Icon({ iconUrl: 'images/icons/helicopter.png' }),
		largeboat = new Icon({ iconUrl: 'images/icons/largeboat.png' }),
		mediumboat = new Icon({ iconUrl: 'images/icons/mediumboat.png' }),
		smallboat = new Icon({ iconUrl: 'images/icons/smallboat.png' }),
		motorcycle = new Icon({ iconUrl: 'images/icons/motorcycle.png' }),
		pbx = new Icon({ iconUrl: 'images/icons/pbx.png' }),
		truck = new Icon({ iconUrl: 'images/icons/truck.png' }),
		plane = new Icon({ iconUrl: 'images/icons/plane.png' }),
		trap = new Icon({ iconUrl: 'images/icons/trap.png' }),
		wire = new Icon({ iconUrl: 'images/icons/wire.png' }),
		tent = new Icon({ iconUrl: 'images/icons/tent.png' }),
		StashSmall = new Icon({ iconUrl: 'images/icons/tent.png' }),
		StashMedium = new Icon({ iconUrl: 'images/icons/tent.png' }),
		hedgehog = new Icon({ iconUrl: 'images/icons/hedgehog.png' }),
		Hedgehog = new Icon({ iconUrl: 'images/icons/hedgehog.png' }),
		sandbag = new Icon({ iconUrl: 'images/icons/sandbag.png' }),
		Sandbag = new Icon({ iconUrl: 'images/icons/sandbag.png' }),
		Player = new Icon({ iconUrl: 'images/icons/player.png' }),
		PlayerDead = new Icon({ iconUrl: 'images/icons/player_dead.png' });

	// store player/vehicle path
	var mapMarkersPolylines = [];
	var enableTracking = <?php echo $enableTracking; ?>;
	var keepTracksAfterLogout = <?php echo $keepTracksAfterLogout; ?>;
	var maxTrackingPositions = <?php echo $maxTrackingPositions; ?>;
	var trackinfowindow = new L.popup({ content: "loading..." });

	var trackPolyline = L.Polyline.extend({
		options: {
			uid: -1
		},
	});

	var trackCircleMarker = L.CircleMarker.extend({
		options: {
			uid: -1
		},
	});

	var mapMarker = L.Marker.extend({
		options: {
			uid: -1
		},
	});

	map.on("mousemove", function (a) {
		$("#mapCoords").html(fromLatLngToGps(a.latlng));
	});
	
	var intervalId;
	var plotlayers = [];
	var tracklayers = [];
	var trackstartlayers = [];
	var trackendlayers = [];
	var autorefresh = true;
	intervalId = setInterval(function() { getData(<?php echo $show; ?>); }, 10000);
	
	$('#map').append('<div id="mapCoords"><label>000 000</label></div>');
	$('#map').append('<div id="mapRefresh"><label>Auto Refresh</label></div>');
	$('#mapRefresh').click(function() {
		if (autorefresh) {
			$(this).css('background-color', "#ff0000");
			$(this).css('background-color', "rgba(255, 0, 0, 0.5)");
			clearInterval(intervalId);
		} else {
			$(this).css('background-color', "#404040");
			$(this).css('background-color', "rgba(0, 0, 0, 0.5)");
			intervalId = setInterval(function() { getData(<?php echo $show; ?>); }, 10000);
		}
		autorefresh = !autorefresh;
	});
	
	getData(<?php echo $show; ?>);
	</script>

<?php
}
else
{
	header('Location: index.php');
}

?>
