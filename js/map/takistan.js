var map, crsTakistan;

function InitMap() {
	var tilesUrl = 'http://static.dayzdb.com/tiles/takistan/{z}/{x}_{y}.png',
		tilesAttrib = '&copy; Crosire, Takistan map data from <a href="http://dayzdb.com/map">DayZDB</a>',
		tiles = new L.TileLayer(tilesUrl, {noWrap: true, continuousWorld: true, attribution: tilesAttrib, tileLimits: {2:{x:4,y:4},3:{x:8,y:7},4:{x:15,y:14},5:{x:29,y:27},6:{x:57,y:54}}});
		
	var b = [0.769897 / 12.8, 0.769897 / 12.8], c = L.latLng([13.4071032, 0.9750912]);
	crsTakistan = L.Util.extend({}, L.CRS, {
		latLngToPoint: function (e, d) {var a = this.projection.project(L.latLng([c.lat - e.lat, c.lng + e.lng])), b = this.scale(d); return a = this.transformation._transform(a, b)},
		pointToLatLng: function(b, d) {var a = this.scale(d); a = this.projection.unproject(this.transformation.untransform(b, a)); a.lat = c.lat - a.lat; a.lng -= c.lng; return a},
		projection: L.Projection.LonLat,
		transformation: new L.Transformation(b[0], 0, b[1], 0)
	})

	// Set up the map
	map = new L.Map('map', {center: [6.4, 6.4], zoom: 3, minZoom: 2, maxZoom: 6, markerZoomAnimation: false, attributionControl: false, crs: crsTakistan});

	// Create tile layer
	map.addLayer(tiles);
}