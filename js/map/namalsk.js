var map, crsNamalsk;

function InitMap() {
	var tilesUrl = 'http://static.dayzdb.com/tiles/namalsk/{z}/{x}_{y}.png',
		tilesAttrib = '&copy; Crosire, Namalsk map data from <a href="http://dayzdb.com/map">DayZDB</a>',
		tiles = new L.TileLayer(tilesUrl, {noWrap: true, continuousWorld: true, attribution: tilesAttrib, tileLimits: {2:{x:4,y:3},3:{x:7,y:5},4:{x:13,y:9},5:{x:25,y:18},6:{x:50,y:35}}, minZoom: 2, maxZoom: 6});

	var b = [0.769897/12.8, 0.54126/8.9974156], c = L.latLng([0,0]);
	crsNamalsk = L.Util.extend({}, L.CRS, {
		latLngToPoint: function (b, d) {var b = this.projection.project(L.latLng([b.lat + c.lat, b.lng + c.lng])), e = this.scale(d); return b = this.transformation._transform(b, e)},
		pointToLatLng: function (b, d) {var a = this.scale(d); a = this.projection.unproject(this.transformation.untransform(b, a)); a.lat += c.lat; a.lng += c.lng; return a},
		projection: L.Projection.LonLat,
		transformation: new L.Transformation(b[0], 0, b[1], 0)
	})
	
	// Set up the map
	map = new L.Map('map', {center: [4.5, 6.4], zoom: 3, minZoom: 2, maxZoom: 6, markerZoomAnimation: false, attributionControl: false, crs: crsNamalsk});

	// Create tile layer
	map.addLayer(tiles);
}
