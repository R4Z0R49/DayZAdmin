<?php
if (isset($_SESSION['user_id']))
{
	switch($_GET['show']) {
	case 0:
		$title = 'Recent Players';
		break;
	case 1:
		$title = 'Alive Players';
		break;
	case 2:
		$title = 'Dead Players';
		break;
	case 3:
		$title = 'All Players';
		break;
	case 4:
		$title = 'Vehicles';
		break;
	case 5:
		$title = 'Vehicle Spawns';
		break;
	case 6:
		$title = 'Tents';
		break;
	case 7:
		$title = 'Deployables';
		break;
	case 8:
		$title = 'Recent Players, Vehicles and Deployables';
		break;
	}

	switch($map)
	{
		case 'chernarus':
			$latOffset = 1024;
			$scaleFactor = 64;
			$minZoom = 2;
			$maxZoom = 6;
			$zoom = 2;
			break;
		case 'lingor':
			$latOffset = 0;
			$scaleFactor = 40;
			$minZoom = 2;
			$maxZoom = 6;
			$zoom = 2;
			break;
		case 'tavi':
			$latOffset = 0;
			$scaleFactor = 100;
			$minZoom = 2;
			$maxZoom = 6;
			$zoom = 2;
			break;
		case 'namalsk':
			$latOffset = 3835;
			$scaleFactor = 65;
			$minZoom = 2;
			$maxZoom = 6;
			$zoom = 2;
			break;
		default:
			die("Undefined map: $map");
			break;
	}
?>
	<div id="debug"></div>
	<h1><div id="title"><?php echo $title; ?></div></h1>
<?php
if(!isset($map))
{
	die("No map set, check config.php");
}
?>
	<div id="map_canvas" style="width:99%;height:750px;margin:10px auto;border:2px solid #000;"></div>

	<script type="text/javascript" src="js/jquery/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
		function debug(s) {
			var elem = document.getElementById('debug');
			if(s == 'clear') {
				elem.innerHTML = '';
			} else {
				elem.innerHTML += s + '<br>\n';
			}
		}

		function degreesToRadians(deg) {
			return deg * (Math.PI / 180);
		}

		function radiansToDegrees(rad) {
			return rad / (Math.PI / 180);
		}

		var infowindow = null;
		var marker = null;

		var pixelOrigin_ = new google.maps.Point(128, 128);
		var pixelsPerLonDegree_ = 256 / 360;
		var pixelsPerLonRadian_ = 256 / (2 * Math.PI);

		// these are used to line up the varying map coordinate systems
		// with the tile coordinates
		var latOffset = <?php echo $latOffset; ?>;
		var scaleFactor = <?php echo $scaleFactor; ?>;

		infowindow = new google.maps.InfoWindow({
			content: "loading..."
		});

		var mapMarkers = [];

		// store player/vehicle path
		var mapMarkersPolylines = [];

		var enableTracking = <?php echo $enableTracking; ?>

		function CustomMapType() {
		}
		CustomMapType.prototype.tileSize = new google.maps.Size(256,256);
		CustomMapType.prototype.maxZoom = 7;
		CustomMapType.prototype.getTile = function(coord, zoom, ownerDocument) {
			var div = ownerDocument.createElement('DIV');
			var baseURL = 'tiles/<?php echo $map; ?>/';
			baseURL += zoom + '_' + coord.x + '_' + coord.y + '.png';
			div.style.width = this.tileSize.width + 'px';
			div.style.height = this.tileSize.height + 'px';
			div.style.backgroundColor = '#1B2D33';
			div.style.backgroundImage = 'url(' + baseURL + ')';
			return div;
		};
 
		CustomMapType.prototype.name = "Custom";
		CustomMapType.prototype.alt = "Tile Coordinate Map Type";
		var map;
		var CustomMapType = new CustomMapType();
		function initialize() {
			var mapOptions = {
				minZoom: <?php echo $minZoom; ?>,
				maxZoom: <?php echo $maxZoom; ?>,
				zoom: <?php echo $zoom; ?>,
				isPng: true,
				mapTypeControl: false,
				streetViewControl: false,
				center: new google.maps.LatLng(0, 0),	 
				mapTypeControlOptions: {
					mapTypeIds: ['custom', google.maps.MapTypeId.ROADMAP],
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
				}
			};
			map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
			map.mapTypes.set('custom',CustomMapType);
			map.setMapTypeId('custom');
		}

		// add a new point to a marker path
		function addMarkerCoordToPolyline(m) {
			var found = false;
			// look for an existing entry in list of paths
			mapMarkersPolylines.forEach(function(element) {
				if(element.uid == m.uid) {
					found = true;
					// don't add if position hasn't changed
					if(!element.getPath().getArray()[element.getPath().length - 1].equals(m.getPosition())) {
						element.getPath().push(m.getPosition());
					}
				}
			});

			// if we didn't find an entry then we create one
			if(!found) {
				var pos = new google.maps.MVCArray([m.getPosition()]);
				var line = new google.maps.Polyline({
					strokeColor: '#c00000',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					uid: m.uid,
					map: map,
					path: pos
				});

				var trackMouseOverOptions = {
					'strokeWeight':'3',
					'strokeColor':'#ffff33',
					'strokeOpacity':'1'
				}

				var trackMouseOutOptions = {
					'strokeWeight':'2',
					'strokeColor':'#c00000',
					'strokeOpacity':'0.8'
				}
				google.maps.event.addListener(line, 'mouseover', function(){line.setOptions(trackMouseOverOptions);});
				google.maps.event.addListener(line, 'mouseout', function(){line.setOptions(trackMouseOutOptions);});
				mapMarkersPolylines.push(line);
			}
		}

		// remove points from paths if > maxTrackingPositions in config.php
		function clearPolyLines() {
			for(i = 0; i < mapMarkersPolylines.length; i++) {
				var found = false;
				mapMarkers.forEach(function(mm) {
					if(mm.uid == mapMarkersPolylines[i].uid) { found = true; }
				});
				// no marker entry so remove this path
				if(!found) {
					mapMarkersPolylines[i].setMap(null);
					if(mapMarkersPolylines.length > 1) {
						mapMarkersPolylines.splice(i,1);
					} else {
						mapMarkersPolylines = [];
					}
				}
				while(mapMarkersPolylines[i].getPath().length > <?php echo $maxTrackingPositions; ?>) {
					mapMarkersPolylines[i].getPath().removeAt(0);
				}
			};
		}

		function pollMarkers(){
			$.getJSON('positions.php?type=<?php echo $_GET['show']; ?>', function(markers) {
				map.clearMarkers();

				for (i = 0; i < markers.length; i++) { 
					var lng = ((markers[i][2]/scaleFactor) - pixelOrigin_.x) / pixelsPerLonDegree_;
					var latRadians = (((markers[i][3] + latOffset)/scaleFactor) - pixelOrigin_.y) / pixelsPerLonRadian_;
					var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) - Math.PI / 2);
						
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(lat, lng),
						map: map,
						title: markers[i][0],
						clickable: true,
						icon: markers[i][5],
/*
// an arrow icon that points in the direction the object is facing
// maybe make this an option?
						icon: {
							path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
							strokeColor: '#ff0000',
							fillColor: '#ff0000',
							fillOpacity: 1,
							scale: 2,
							rotation: markers[i][6],
						},
*/
						zIndex:  markers[i][4],
						uid: markers[i][7]
					});
					marker.setDraggable(true);
					mapMarkers.push(marker);

					// add this point to the path if an id is defined and tracking is enabled
					if(typeof markers[i][7] !== "undefined" && enableTracking) {
						addMarkerCoordToPolyline(marker);
					}
						
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infowindow.setContent(markers[i][1]);
							infowindow.open(map, marker);
						}
					})(marker, i));
				}

				// update the current object count in title
				var elem = document.getElementById('title');
				elem.innerHTML = '<?php echo $title; ?>&nbsp;(' + mapMarkers.length + ')';
			});
			if(enableTracking) { clearPolyLines(); }
		}

		google.maps.Map.prototype.clearMarkers = function() {
			for(i = 0; i < mapMarkers.length; i++) {
				mapMarkers[i].setMap(null);
			}
			mapMarkers = new Array();
		};

		google.maps.event.addDomListener(window, 'load', function () {
			initialize();
			setInterval(function() {pollMarkers();}, 10000);
			pollMarkers();
		});
		
	</script>

<?php
}
else
{
	header('Location:' .$security.'.php');
}
?>
