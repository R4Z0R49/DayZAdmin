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
		$title = 'Recent Players and Vehicles';
		break;
	}
?>
	<h1><?php echo $title; ?></h1>
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
		
		infowindow = new google.maps.InfoWindow({
			content: "loading..."
		});

		var mapMarkers = [];

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
		<?php
		switch($map)
		{
			case 'chernarus':
		?>
			minZoom: 2,
			maxZoom: 6,
			zoom: 2,
		<?php
				break;
			case 'lingor':
		?>
			minZoom: 2,
			maxZoom: 6,
			zoom: 2,
		<?php
				break;
			case 'tavi':
                ?>
                        minZoom: 2,
                        maxZoom: 6,
                        zoom: 2,
                <?php
                                break;
			default:
				die("Undefined map: $map");
				break;
		}
		?>
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

		function pollMarkers(){
			$.getJSON('positions.php?type=<?php echo $_GET['show']; ?>', function(markers) {
			map.clearMarkers();

		<?php
		switch($map)
		{
			case 'chernarus':
		?>
				var latOffset = 0;
				var scaleFactor = 64;
		<?php
				break;
			case 'lingor':
		?>
				var latOffset = 1024;
				var scaleFactor = 40;
		<?php
				break;
			case 'tavi':
                ?>
                                var latOffset = 1024;
                                var scaleFactor = 100;
                <?php
                                break;
			default:
				die("Undefined map: $map");
				break;
		}
		?>

			for (i = 0; i < markers.length; i++) { 
				var lng = ((markers[i][2]/scaleFactor) - pixelOrigin_.x) / pixelsPerLonDegree_;
				var latRadians = (((markers[i][3] - latOffset)/scaleFactor) - pixelOrigin_.y) / pixelsPerLonRadian_;
				var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) - Math.PI / 2);
						
				marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat, lng),
					map: map,
					title: markers[i][0],
					clickable: true,
					icon: markers[i][5],
					zIndex:  markers[i][4]
				});
				marker.setDraggable(true);
				mapMarkers.push(marker);
						
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						infowindow.setContent(markers[i][1]);
						infowindow.open(map, marker);
					}
				})(marker, i));
			}
			});
		}

		google.maps.Map.prototype.clearMarkers = function() {
			for(var i = 0; i < mapMarkers.length; i++){
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
