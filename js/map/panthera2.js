var map, crsPanthera;

function InitMap() {
	var tilesUrl = 'http://static.dayzdb.com/tiles/panthera/{z}/{x}_{y}.png',
		tilesAttrib = '&copy; Crosire, Panthera map data from <a href="http://dayzdb.com/map">DayZDB</a>',
		tiles = new L.TileLayer(tilesUrl, {noWrap: true, continuousWorld: true, attribution: tilesAttrib, tileLimits: {2:{x:3,y:3},3:{x:6,y:6},4:{x:11,y:11},5:{x:22,y:22},6:{x:44,y:44}}});
		
	var b = [0.06667731502557828, 0.06667134162937072], c = L.latLng([0, 0]);
	crsPanthera = L.Util.extend({}, L.CRS, {
		latLngToPoint: function(e, d) {var a = this.projection.project(L.latLng([e.lat + c.lat, e.lng + c.lng])), b = this.scale(d); return a = this.transformation._transform(a, b)},
		pointToLatLng: function(b, d) {var a = this.scale(d); a = this.projection.unproject(this.transformation.untransform(b, a)); a.lat -= c.lat; a.lng -= c.lng; return a},
		projection: L.Projection.LonLat,
		transformation: new L.Transformation(b[0], 0, b[1], 0)
	})

	// Set up the map
	map = new L.Map('map', {center: [5.7, 5.1], zoom: 3, minZoom: 2, maxZoom: 6, markerZoomAnimation: false, attributionControl: false, crs: crsPanthera});

	// Create tile layer
	map.addLayer(tiles);
}