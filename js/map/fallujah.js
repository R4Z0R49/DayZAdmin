var map, crsFallujah;

function InitMap() {
	var tilesUrl = 'http://static.dayzdb.com/tiles/fallujah/{z}/{x}_{y}.png',
		tilesAttrib = '&copy; Crosire, Fallujah map data from <a href="http://dayzdb.com/map">DayZDB</a>',
		tiles = new L.TileLayer(tilesUrl, {noWrap: true, continuousWorld: true, attribution: tilesAttrib, tileLimits: {2:{x:4,y:4},3:{x:7,y:7},4:{x:13,y:13},5:{x:25,y:25},6:{x:50,y:50}}, minZoom: 2, maxZoom: 6});

	var b = [0.07519244342390738, 0.07519244342390738], d = L.latLng(100, 0, true);
	crsFallujah = L.Util.extend({}, L.CRS, {
		latLngToPoint: function (e, c) {var a = this.projection.project(L.latLng(d.lat - e.lat, e.lng, true)),b = this.scale(c); return a = this.transformation._transform(a, b)},
		pointToLatLng: function (b, c) {var a = this.scale(c); a = this.projection.unproject(this.transformation.untransform(b, a)); a.lat = d.lat- a.lat; return a},
		projection: L.Projection.LonLat,
		transformation: new L.Transformation(b[0], 0, b[1], 0)
	})
	
	// Set up the map
	map = new L.Map('map', {center: L.latLng(94.7, 5.1, true), zoom: 3, minZoom: 2, maxZoom: 6, markerZoomAnimation: false, attributionControl: false, crs: crsFallujah});

	// Create tile layer
	map.addLayer(tiles);
}