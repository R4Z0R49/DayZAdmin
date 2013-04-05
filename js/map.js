// Credits for the map functions and crs go to the developers at http://www.dayzdb.com/map, Krunch and Crosire

function fromCoordToGps(e) {
	var e = Math.abs(e), b = (1E3 * e).toString();
	return b = 0.1 > e?"000":1 > e?"00" + b.substr(0,1):10 > e?"0" + b.substr(0,2):100 > e?b.substr(0,3):"999"
}

function fromGpsToCoord(e) {
	return 0.1 * parseInt(e, 10)
}

function fromLatLngToGps(e) {
	return fromCoordToGps(e.lng) + " " + fromCoordToGps(e.lat)
}

function getData(id) {
	$.getJSON('js/map.php?id=' + id + '&callback=?', function(data) {
		if ("error" in data) {
			if ($('#page-error').length == 0) { $('#map').before(data.error); }
		} else {
			$('#page-error').remove();
			for (i = 0; i < plotlayers.length; i++) { map.removeLayer(plotlayers[i]); }
			plotlayers = [];
			for (i = 0; i < data.length; i++) {
				var pos = new L.LatLng(data[i].lat, data[i].lng);
				var plotmark = new mapMarker(pos, { icon: eval(data[i].icon), title: data[i].title, zIndexOffset: data[i].zIndexOffset });
				plotmark.options.draggable = true;
				plotmark.options.uid = data[i].id;
				map.addLayer(plotmark);
				plotmark.bindPopup(data[i].description);
				plotlayers.push(plotmark);	

				if(enableTracking && (id == 0 || id == 4 || id == 8)) {
					addMarkerCoordToPolyline(data[i].id, pos, data[i].description);
				}
			}
		}
		// update the current object count in title
		var elem = document.getElementById('count');
		elem.innerHTML = data.length;
	});
	if(enableTracking) { clearPolyLines(); }
}

// add a new point to a marker path
function addMarkerCoordToPolyline(id, pos, desc) {
	if(pos.lng == 0) {
		// most likely a debug area coordinate so ignore
		return;
	}

	var found = false;
	mapMarkersPolylines.forEach(function(element) {
		if(element.options.uid == id) {
			found = true;
			// only add new point to line if position hasn't changed
			if(!element.getLatLngs()[element.getLatLngs().length - 1].equals(pos)) {
				element.addLatLng(pos);

				// update end marker
				trackendlayers.forEach(function(element) {
					if(element.options.uid == id) {
						element.setLatLng(pos);
					}
				});
			}
		}
	});

	if(!found) {
		var trackMouseOutOptions = {
			weight: 2,
			color: '#c00000',
			opacity: 0.8
		}

		var trackMouseOverOptions = {
			weight: 3,
			color: '#ff0000',
			opacity: 1 
		}

		// if we didn't find an entry above then create one
		// create a line to hold coords for this track
		var line = new trackPolyline([], trackMouseOutOptions);
		line.addLatLng(pos);
		line.options.uid = id;
		line.on('mouseover', function(){
			line.setStyle(trackMouseOverOptions);
		});
		line.on('mouseout', function(){
			line.setStyle(trackMouseOutOptions);
		});
		line.bindPopup(desc);

		// create a start marker to designate this is the beginning of the track
		var startMarker = new trackCircleMarker(pos, { color: 'green', fill: true, fillColor: 'green', fillOpacity: 1 });
		startMarker.bindPopup(desc);
		startMarker.setRadius(4);
		startMarker.options.uid = id;

		// create an end marker to designate this is the end of the track
		var endMarker = new trackCircleMarker(pos, { color: 'yellow', fill: true, fillColor: 'yellow', fillOpacity: 1 });
		endMarker.bindPopup(desc);
		endMarker.setRadius(4);
		endMarker.options.uid = id;

		// add to array for cleanup later
		mapMarkersPolylines.push(line);
		tracklayers.push(line);
		trackstartlayers.push(startMarker);
		trackendlayers.push(endMarker);

		//add to map layers to render
		map.addLayer(line);
		map.addLayer(startMarker);
		map.addLayer(endMarker);
	}
}

// remove points from paths if > maxTrackingPositions in config.php
// remove paths if keepTracksAfterLogout == 0
function clearPolyLines() {
	for(i = 0; i < mapMarkersPolylines.length; i++) {
		var found = false;
		var uid = mapMarkersPolylines[i].options.uid;
		plotlayers.forEach(function(element) {
			if(element.options.uid == uid) { found = true; }
		});

		if(found) {
			// trim path to maxTrackingPositions
			while(mapMarkersPolylines[i].getLatLngs().length > maxTrackingPositions) {
				mapMarkersPolylines[i].getLatLngs().splice(0, 1);
			}
		} else if(!keepTracksAfterLogout) {
			// remove path
			map.removeLayer(mapMarkersPolylines[i]);
			if(mapMarkersPolylines.length > 1) {
				mapMarkersPolylines.splice(i,1);
			} else {
				mapMarkersPolylines = [];
			}

			// find and remove startMarker
			trackstartlayers.forEach(function(element) {
				if(element.options.uid == uid) { map.removeLayer(element); }
			});

			// find and remove endMarker
			trackendlayers.forEach(function(element) {
				if(element.options.uid == uid) { map.removeLayer(element); }
			});
		}
	};
}
