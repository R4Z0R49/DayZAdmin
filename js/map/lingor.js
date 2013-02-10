var map, crsLingor;

function InitMap() {
	var tilesUrl = 'http://static.dayzdb.com/tiles/lingor/{z}/{x}_{y}.png',
		tilesAttrib = '&copy; Crosire, Lingor map data from <a href="http://dayzdb.com/map">DayZDB</a>',
		tiles = new L.TileLayer(tilesUrl, {noWrap: true, continuousWorld: true, attribution: tilesAttrib, tileLimits: {2:{x:4,y:4},3:{x:7,y:7},4:{x:14,y:14},5:{x:28,y:28},6:{x:56,y:56}}, minZoom: 2, maxZoom: 6});

	var b = [0.625 / 10.240943, 0.625 / 10.240943], c = L.latLng([10.240943, 0])
	crsLingor = L.Util.extend({}, L.CRS, {
		latLngToPoint: function (b, d) {var a = this.projection.project(L.latLng([c.lat - b.lat, b.lng])), f = this.scale(d); return this.transformation._transform(a, f)},
		pointToLatLng: function (b, d) {var a = this.scale(d); a = this.projection.unproject(this.transformation.untransform(b, a)); a.lat = c.lat - a.lat; return a},
		projection: L.Projection.LonLat,
		transformation: new L.Transformation(b[0], 0, b[1], 0)
	})

	// Set up the map
	map = new L.Map('map', {center: [4.1, 4.1], zoom: 3, minZoom: 2, maxZoom: 6, markerZoomAnimation: false, attributionControl: false, crs: crsLingor});

	// Create tile layer
	map.addLayer(tiles);
}