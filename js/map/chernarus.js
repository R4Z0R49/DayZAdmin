var map, crsChernarus;

function InitMap() {
	var tilesUrl = 'http://static.dayzdb.com/tiles/{z}/{x}_{y}.png',
		tilesAttrib = '&copy; Crosire, Chernarus map data from <a href="http://dayzdb.com/map">DayZDB</a>',
		tiles = new L.TileLayer(tilesUrl, {noWrap: true, continuousWorld: true, attribution: tilesAttrib, tileLimits: {2:{x:4,y:4},3:{x:8,y:7},4:{x:16,y:14},5:{x:32,y:27},6:{x:64,y:54}}});
		
	var b = 1 / 14.524823, c = L.latLng([1.920978, 0.284574]);
	crsChernarus = L.Util.extend({}, L.CRS, {
		latLngToPoint: function (e, d) {var a = this.projection.project(L.latLng([e.lat - c.lat, e.lng - c.lng])), b = this.scale(d); return a = this.transformation._transform(a, b)},
		pointToLatLng: function (b, d) {var a = this.scale(d); a = this.projection.unproject(this.transformation.untransform(b, a)); a.lat += c.lat; a.lng += c.lng; return a},
		projection: L.Projection.LonLat,
		transformation: new L.Transformation(b, 0, b, 0)
	})

	// Set up the map
	map = new L.Map('map', {center: [7.5, 7], zoom: 2, minZoom: 2, maxZoom: 6, markerZoomAnimation: false, attributionControl: false, crs: crsChernarus});

	// Create tile layer
	map.addLayer(tiles);
}
