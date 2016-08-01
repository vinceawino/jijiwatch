 require([
		"application/bootstrapmap",
		"application1/BootSideMenu",
		"timeSlider/bootstrap-slider",
		"Pusher",
		"esri/urlUtils",
		"esri/map",
		"esri/dijit/Search",
		"esri/dijit/BasemapGallery",
		"esri/dijit/HomeButton",
		"esri/geometry/webMercatorUtils",
		"esri/geometry/Extent",
		"esri/geometry/Point", 
		"esri/graphic", 
		"esri/symbols/SimpleMarkerSymbol", 
		"esri/symbols/SimpleLineSymbol", 
		"esri/symbols/SimpleFillSymbol",
		"esri/renderers/SimpleRenderer",
		"esri/layers/GraphicsLayer",
		"esri/layers/FeatureLayer",
		"esri/InfoTemplate",
		"esri/tasks/FeatureSet",
		"esri/tasks/ClosestFacilityTask",
		"esri/tasks/ClosestFacilityParameters",
		"esri/tasks/ServiceAreaTask",
		"esri/tasks/ServiceAreaParameters",
		"esri/lang",
		"esri/toolbars/draw",
		"dojo/_base/Color",
		"dojo/_base/array",
		"dojo/dom",
		"dojo/dom-construct",
		"dojo/on",
		"dojo/number",
		"dojo/domReady!"],
        function(
		BootstrapMap,
		BootSideMenu,
		bootstrapSlider,
		Pusher,
		urlUtils,
		Map,
		Search,
		BasemapGallery,
		HomeButton,
		webMercatorUtils,
		Extent,
		Point, 
		Graphic, 
		SimpleMarkerSymbol, 
		SimpleLineSymbol, 
		SimpleFillSymbol,
		SimpleRenderer,		
		GraphicsLayer,
		FeatureLayer,
		InfoTemplate,
		FeatureSet,
		ClosestFacilityTask,
		ClosestFacilityParameters,
		ServiceAreaTask,
		ServiceAreaParameters,
		esriLang,
		Draw,
		Color,
		array,
		dom,
		domconstruct,
		on,
		number) {
			
			/*
			urlUtils.addProxyRule({
					urlPrefix: "69.64.65.196:6080",
					proxyUrl: "http://192.168.0.12:6060/demo/proxy/proxy.php"
			});
			*/
			
			//Create Map
            var map = BootstrapMap.create("map", {
              logo : false,
              basemap: "topo",
              center: [36.817, -1.286],
              zoom: 15,
              showInfoWindowOnClick : true
            });
			
			//initialize Widgets
			var basemapGallery = new BasemapGallery({
					showArcGISBasemaps: true,
					map: map
			}, "basemapGallery");
						
			var s = new Search({
						map: map
			}, "search");
			s.startup();
			
			var home = new HomeButton({
					map: map
				}, "HomeButton");
			home.startup();
				
			//Load Map dependencies
			var facilityPointSymbol, incidentPointSymbol, incidentsGraphicsLayer, routeGraphicLayer, facilitiesGraphicsLayer, highlightSymbol, facilities1;
			map.on("load", function() {

				highlightSymbol = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CIRCLE,16, new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 0, 255, 255 ]), 2),new Color([ 255, 215, 0, 0.40 ]));
				
				incidentPointSymbol = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CIRCLE, 16, new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 255, 128, 0 ]), 3),new Color([ 255, 215, 0, 0.50 ]));
				incidentsGraphicsLayer = new GraphicsLayer();
				var incidentsRenderer = new SimpleRenderer(incidentPointSymbol);
				incidentsGraphicsLayer.setRenderer(incidentsRenderer);
				map.addLayer(incidentsGraphicsLayer);
				
				routeGraphicLayer = new GraphicsLayer();
				var routePolylineSymbol = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 255, 140, 0 ]), 4.0);
				var routeRenderer = new SimpleRenderer(routePolylineSymbol);
				routeGraphicLayer.setRenderer(routeRenderer);
				map.addLayer(routeGraphicLayer);
				
				facilityPointSymbol = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CIRCLE, 15, new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 76, 0, 153 ]),3), new Color([ 255, 255,255 ]));
				facilitiesGraphicsLayer = new GraphicsLayer();
				var facilityRenderer = new SimpleRenderer(facilityPointSymbol);
				facilitiesGraphicsLayer.setRenderer(facilityRenderer);
				map.addLayer(facilitiesGraphicsLayer);
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4098609.436,"y":-142434.2164,"spatialReference": map.spatialReference},"attributes":{"id":1,"name":"Response Unit 1"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4097396.165,"y":-144410.7483,"spatialReference": map.spatialReference},"attributes":{"id":2,"name":"Response Unit 2"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4097396.165,"y":-144410.7483,"spatialReference": map.spatialReference},"attributes":{"id":3,"name":"Response Unit 3"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4100352.922,"y":-144820.5093,"spatialReference": map.spatialReference},"attributes":{"id":4,"name":"Response Unit 4"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4100248.393,"y":-137421.2953,"spatialReference": map.spatialReference},"attributes":{"id":5,"name":"Response Unit 5"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4102160.639,"y":-144137.5004,"spatialReference": map.spatialReference},"attributes":{"id":6,"name":"Response Unit 6"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4096006.230,"y":-143775.9539,"spatialReference": map.spatialReference},"attributes":{"id":7,"name":"Response Unit 7"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4095909.827,"y":-141976.2455,"spatialReference": map.spatialReference},"attributes":{"id":8,"name":"Response Unit 8"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4100566.099,"y":-141364.7281,"spatialReference": map.spatialReference},"attributes":{"id":9,"name":"Response Unit 9"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4097895.655,"y":-140858.3231,"spatialReference": map.spatialReference},"attributes":{"id":10,"name":"Response Unit 10"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4103320.477,"y":-143860.5782,"spatialReference": map.spatialReference},"attributes":{"id":11,"name":"Response Unit 11"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4109174.101,"y":-145783.1160,"spatialReference": map.spatialReference},"attributes":{"id":12,"name":"Response Unit 12"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4110579.398,"y":-148512.6170,"spatialReference": map.spatialReference},"attributes":{"id":13,"name":"Response Unit 13"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4097526.520,"y":-137540.6575,"spatialReference": map.spatialReference},"attributes":{"id":14,"name":"Response Unit 14"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4094878.118,"y":-139081.0135,"spatialReference": map.spatialReference},"attributes":{"id":15,"name":"Response Unit 15"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4093472.821,"y":-140837.6126,"spatialReference": map.spatialReference},"attributes":{"id":16,"name":"Response Unit 16"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4086095.122,"y":-147053.2721,"spatialReference": map.spatialReference},"attributes":{"id":17,"name":"Response Unit 17"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4089770.446,"y":-143972.4828,"spatialReference": map.spatialReference},"attributes":{"id":18,"name":"Response Unit 18"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4088311.159,"y":-140540.3173,"spatialReference": map.spatialReference},"attributes":{"id":19,"name":"Response Unit 19"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4099200.543,"y":-145246.3051,"spatialReference": map.spatialReference},"attributes":{"id":20,"name":"Response Unit 20"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4098264.145,"y":-146647.2936,"spatialReference": map.spatialReference},"attributes":{"id":21,"name":"Response Unit 21"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4099820.815,"y":-146863.3106,"spatialReference": map.spatialReference},"attributes":{"id":22,"name":"Response Unit 22"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4110072.561,"y":-140404.1405,"spatialReference": map.spatialReference},"attributes":{"id":23,"name":"Response Unit 23"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4105869.248,"y":-138533.5259,"spatialReference": map.spatialReference},"attributes":{"id":24,"name":"Response Unit 24"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4098793.558,"y":-143758.8063,"spatialReference": map.spatialReference},"attributes":{"id":25,"name":"Response Unit 25"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4099564.891,"y":-143847.1051,"spatialReference": map.spatialReference},"attributes":{"id":26,"name":"Response Unit 26"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4100477.377,"y":-143391.3589,"spatialReference": map.spatialReference},"attributes":{"id":27,"name":"Response Unit 27"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4100544.948,"y":-143208.9716,"spatialReference": map.spatialReference},"attributes":{"id":28,"name":"Response Unit 28"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				facilitiesGraphicsLayer.add(new Graphic({"geometry":{"x":4101705.676,"y":-143783.3029,"spatialReference": map.spatialReference},"attributes":{"id":29,"name":"Response Unit 29"},"infoTemplate":{"title":"Response Unit", "content":"Unit ${id}"}}));
				
				var facilities = new FeatureSet();
				facilities.features = facilitiesGraphicsLayer.graphics;
				params.facilities = facilities;
				params.outSpatialReference = map.spatialReference;
				
				facilities1 = new FeatureSet();
				facilities1.features = facilitiesGraphicsLayer.graphics;
				params1.facilities = facilities1;
				params1.outSpatialReference = map.spatialReference;
				
				on(incidentsGraphicsLayer,"graphic-add", zoomToGraphics);
				
				//Load Feature layers
				var infoTemplate = new InfoTemplate("Attributes", "${*}");
				var wards = new FeatureLayer("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/map/MapServer/2",{
					mode : FeatureLayer.MODE_ONDEMAND,
					outFields : [ "*" ],
					opacity : 0.6,
					infoTemplate : infoTemplate
				});

				var healthCenters = new FeatureLayer("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/map/MapServer/0",{
					mode : FeatureLayer.MODE_ONDEMAND,
					outFields : [ "*" ],
					infoTemplate : infoTemplate
				});

				var schools = new FeatureLayer("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/map/MapServer/1",{
					mode : FeatureLayer.MODE_ONDEMAND,
					outFields : [ "*" ],
					infoTemplate : infoTemplate 
				});

				var geoFence = new FeatureLayer("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/geofense/MapServer/0",{
					mode : FeatureLayer.MODE_ONDEMAND,
					outFields : [ "*" ],
					infoTemplate : infoTemplate 
				});
				
				map.on("layers-add-result", function(evt){
					//Display sidepanel  
					$('#demo').BootSideMenu({
						side:"left",
						autoClose:true
					});
					$('#demo').css("display", "block");
					
					//Set-up legend
					var layerInfo = array.map(evt.layers, function(layer, index) {
						return {
							layer : layer.layer,
							title : layer.layer.name
						};
					});
					
					array.forEach(layerInfo, function(layer){
						layer.layer.hide();
						var layerName = layer.title;
						domconstruct.place("<tr><td><div class='checkbox'><input type='checkbox' id='"+layer.layer.id+"'><label for='"+layer.layer.id+"'>"+layer.layer.name+"</label></div></td><tr>", "toggle");
						on(dom.byId(layer.layer.id), "change", function(evt){
							var clayer = map.getLayer(layer.layer.id);
							clayer.setVisibility(!clayer.visible);
							this.checked = clayer.visible;
						});
					});
				});
				
				map.addLayers([wards, healthCenters, schools, geoFence]);
            });
			
			//Add Graphics
			function zoomToGraphics(zoomEvt){
				if (incidentsGraphicsLayer.graphics.length == 1) {
					var numx = number.parse(zoomEvt.graphic.geometry.x);
					var numy = number.parse(zoomEvt.graphic.geometry.y);
					var factor = 1000;
					var extent = new esri.geometry.Extent(numx - factor, numy - factor, numx + factor, numy + factor, map.spatialReference);
					   map.setExtent(extent.expand(1));
				} else if (incidentsGraphicsLayer.graphics.length > 1) {
					var extent = esri.graphicsExtent(incidentsGraphicsLayer.graphics);
					map.setExtent(extent.expand(1), true);
				}
			}
			
			//Perform Closest Facility Routing
			var closestFacilityTask;
			params = new ClosestFacilityParameters();
			params.impedenceAttribute = "";
			params.defaultCutoff = 50;
			params.returnIncidents = false;
			params.returnRoutes = true;
			params.returnDirections = true;
			on(dom.byId("numLocations"), "change", function(){
				params.defaultTargetFacilityCount = this.value;
			});
			
			var incidents = new FeatureSet();
			var features = [];
			
			on(dom.byId("routeBtn"), "click", function(){
				if(features.length != 0){
					$("#routingDialog").modal();
				}else {
					$("#routingErrorDialog").modal();
				}
			});
			
			var highlightGraphic;
			function performRouting() {
				map.graphics.remove(highlightGraphic);
				routeGraphicLayer.clear();
				routeGraphicLayer.on("mouse-over", function(evt) {
					map.graphics.clear();
					dom.byId("directionsDiv").innerHTML = "Hover over the route to view directions";

					var highlightSymbol = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 0, 255, 255 ], 0.25),4.5);
					highlightGraphic = new Graphic(evt.graphic.geometry,highlightSymbol);

					map.graphics.add(highlightGraphic);
					dom.byId("directionsDiv").innerHTML = esriLang.substitute(evt.graphic.attributes,"${*}");
				});

				if (dom.byId("geofence").checked == true) {
					closestFacilityTask = null;
					closestFacilityTask = new ClosestFacilityTask("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/geofense/NAServer/ClosestFacility_1");
					solveCloseFacilityRouting();
				} else {
					closestFacilityTask = null;
					closestFacilityTask = new ClosestFacilityTask("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/closestfacility/NAServer/ClosestFacility_0");
					solveCloseFacilityRouting();
				}
			}
			
			function solveCloseFacilityRouting() {
				closestFacilityTask.solve(params, function(solveResult) {
					var directions = solveResult.directions;
					array.forEach(solveResult.routes, function(route, index) {
						var attr = array.map(solveResult.directions[index].features, function(feature) {
							return feature.attributes.text;
						});
						var infoTemplate = new InfoTemplate("Attributes", "${*}");
						route.setInfoTemplate(infoTemplate);
						route.setAttributes(attr);
						routeGraphicLayer.add(route);
						dom.byId("directionsDiv").innerHTML = "Hover over the route to view directions";
					});
					if (solveResult.messages.length > 0) {
						dom.byId("directionsDiv").innerHTML = "Hover over the route to view directions";
					}
				});
			}
			
			on(dom.byId("performRouteBtn"), "click", function(){
				performRouting();
			});

			//Clear Graphics
			function clearGraphics(){
				dom.byId("directionsDiv").innerHTML = "";
				map.graphics.clear();
				routeGraphicLayer.clear();
				incidentsGraphicsLayer.clear();
				features.length = 0;
				map.graphics.clear();
				generatedPolygons = 0;
			}

			on(dom.byId("clearBtn"), "click", function(){
				if (routeGraphicLayer.graphics.length != 0 && resultsGraphic.length == 0) {
						map.graphics.remove(highlightGraphic);
						routeGraphicLayer.clear();
						dom.byId("directionsDiv").innerHTML = "";
				} else{
					if ($("#selectBtn")[0].checked == true && resultsGraphic.length != 0) {				
						array.forEach(unselectIncidents, function(graphic) {
							if (checkDrawnExtent.contains(graphic.geometry)) {
								incidentsGraphicsLayer.remove(graphic);
								var graphicID = graphic.attributes.id;
								for(var i = 0; i < features.length; i++){
									if(features[i].attributes.id == graphicID){
										features.splice(i, 1);
									}
								}
								resultsGraphic.length = 0;
								results.length = 0;
							}
							if(routeGraphicLayer.graphics.length != 0){
								map.graphics.remove(highlightGraphic);
							}
						});
					}else if($("#selectBtn")[0].checked == true && resultsGraphic.length == 0){
						clearGraphics();
					}else {
						clearGraphics();
						resultsGraphic.length = 0;
						results.length = 0;
					}
				}
			});
			
			//Select Graphics
			var checkDrawnExtent = map.extent;
			var tb;
			on($("#selectBtn"), "change", function(){
				if($("#selectBtn")[0].checked == true){
					map.isPan = false;
					//navToolbar.deactivate();
					tb = new Draw(map);
					tb.on("draw-end", findPointsInExtent);
					tb.activate(Draw.EXTENT);
				}else {
					map.isPan = true;
					tb.deactivate();
					checkDrawnExtent = map.extent;
					dom.byId("directionsDiv").innerHTML = "";
					array.forEach(unselectIncidents, function(graphic) {
						graphic.setSymbol(incidentPointSymbol);
						results.length = 0;
					});
				}
			});
			
			var unselectIncidents = [];
			var results = [];
			var resultsGraphic = [];
			function findPointsInExtent(drawnExtent) {
				results.length = 0;
				unselectIncidents.length = 0;
				resultsGraphic.length = 0;
				checkDrawnExtent = drawnExtent.geometry;
				array.forEach(incidentsGraphicsLayer.graphics, function(graphic){
				unselectIncidents.push(graphic);
					if (drawnExtent.geometry.contains(graphic.geometry)) {
						graphic.setSymbol(highlightSymbol);
						results.push(graphic.getContent());
						resultsGraphic.push(graphic);
					 }else if (graphic.symbol == highlightSymbol) {
						graphic.setSymbol(incidentPointSymbol);
					 }
				});
				
				dom.byId("directionsDiv").innerHTML = "<br/>Number of Slected Incidents: " + results.length + "<br/><br/>" + "<table><tbody>" + results.join("") + "</tbody></table>";
			}
			
			/*Perform Service Area Analysis
			  Automatic
			*/
			var serviceAreaTask = new ServiceAreaTask("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/NetworkAnalyst/NAServer/Service_Area");
			params1 = new ServiceAreaParameters();
			params1.defaultBreaks= [5];
			params1.returnFacilities = false;
			
			var generatedPolygons = [];
			function performServiceAreaTask (){
				map.graphics.clear();
				generatedPolygons = 0;
				serviceAreaTask.solve(params1, function(solveResult){
					generatedPolygons = solveResult.serviceAreaPolygons;
					var polygonSymbol = new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID, 
					new SimpleLineSymbol(SimpleFillSymbol.STYLE_SOLID, new Color([232,104,80]), 2), new Color([232,104,80,0.25]));
					array.forEach(solveResult.serviceAreaPolygons, function(serviceArea){
						serviceArea.setSymbol(polygonSymbol);
						map.graphics.add(serviceArea);
					});
				}, function(err){
					console.log(err.message);
				});
			}
			
			var mySlider = $("#timeSlider").slider();
			
			mySlider.on("slideStop", function(evt){
				params1.defaultBreaks = [evt.value];
				performServiceAreaTask();
			});
			
			on($("#serviceAreaBtn"), "change", function(){
				if($("#serviceAreaBtn")[0].checked == true){
					$('#timeSlider1	').css("visibility", "visible");
					var sliderValue = mySlider.slider("getValue");
					params1.defaultBreaks = [sliderValue];
					performServiceAreaTask();
					clickEvent = on(map, "click", mapClickHandler);
					if(clickpoint){
						mapClickHandler(clickpoint);
					}
				}else{
					$('#timeSlider1	').css("visibility", "hidden");
					map.graphics.clear();
					generatedPolygons = 0;
					clickEvent.remove();
					clickEvent = null;
				}
			});
			
			/*Perform Service Area Analysis
			  On-Click
			*/
			var clickpoint;
			var i=30;
			function mapClickHandler(mapClickevt){
				clickpoint = mapClickevt;
				tempID = i++;
				var inPoint = {
					"geometry": {
						"x":mapClickevt.mapPoint.x, 
						"y":mapClickevt.mapPoint.y, 
						"spatialReference":map.spatialReference
					},
					"attributes":{
						"id":tempID,
						"name":"Response Unit " + String(tempID)
					},
					"infoTemplate":{
						"title":"Response Unit",
						"content":"Unit ${id}"
					}
				};
				
				var location = new Graphic(inPoint, facilityPointSymbol);
				facilitiesGraphicsLayer.add(location);
				facilities1.features = facilitiesGraphicsLayer.graphics;
				params1.facilities = facilities1;
				map.graphics.enableMouseEvents();
				performServiceAreaTask();
			}
			
			//Web Sockets
			socketConnect();
			var pusher;
			var geom = [];
			function socketConnect() {
				pusher = new Pusher('fae3f83fa67c2d978994');
				var channel = pusher.subscribe('test_channel');
				channel.bind('my_event', function(data) {
					//grid.store.add(data[0]);
					geom.length = 0;
					geom = webMercatorUtils.lngLatToXY(data[0].x, data[0].y);
					var inPoint = {
						"geometry" : {
						"x" : geom[0],
						"y" : geom[1],
						"spatialReference" : map.spatialReference
						},
						"attributes" : {
						"id" : data[0].id,
						"incident" : data[0].incident,
						"comment" : data[0].comment,
						"date" : data[0].Date_,
						"date_time" : data[0].date_time,
						"day" : data[0].Day_,
						"x" : data[0].x,
						"y" : data[0].y,
						"entered_msisdn" : data[0].entered_msisdn,
						"picked_msisdn" : data[0].picked_msisdn,
						"status" : data[0].status,
						"url" : data[0].url
						},
						"infoTemplate": {
						"title" : "Incident",
						"content" : "${incident}<br/> Date/Time: ${date_time}<br/>Phone No: ${entered_msisdn}<br/><br/> <img src='" + "http://69.64.65.196:6060/demo/" + "${url}' alt='Picture was not taken' style='width:170px;height:175;'>"
						}
					};

					var location = new Graphic(inPoint);
					var highlightSymbolNew = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CIRCLE,16,new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 255, 0, 0 ]), 2),new Color([ 255, 215, 0, 0.40 ]));
					location.setSymbol(highlightSymbolNew);
					incidentsGraphicsLayer.add(location);
					features.push(location);
					incidents.features = features;
					params.incidents = incidents;								
					map.graphics.enableMouseEvents();
					if (!("Notification" in window)) {
						alert("This browser does not support desktop notification");
					}else if (Notification.permission === "granted") {
						var notification = new Notification("You have a new incident reported!");
					}else if (Notification.permission !== 'denied') {
						Notification.requestPermission(function (permission) {
							if (permission === "granted") {
								var notification = new Notification("Check your Map (new incident in Red Circle)");
							}
						});
					}
				});
				Pusher.log = function(message) {
					if (window.console && window.console.log) {
						window.console.log(message);
					}
				};
			}
			
			//Turn WebSocket on/off
			on($("#realTimeBtn"), "change", function(){
				if($("#realTimeBtn")[0].checked == true){
					pusher.disconnect();
					if (!("Notification" in window)) {
						alert("This browser does not support desktop notification. Upgrade to latest browser version");
					}else{
						var notification = new Notification("You are NOT connected to Real-time event reception!!");
					}
				}else{
					try {
						pusher.connect();
						if (!("Notification" in window)) {
							alert("This browser does not support desktop notification. Upgrade to latest browser version");
						}else{
							var notification = new Notification("You are NOW connected to Real-time event reception");
						}
					}catch(ex){
							console.log(ex); 
					}
				}
			});
			
			//Show BasemapGallery
			on(dom.byId("basemapBtn"), "click", function(){
				$("#basemapGalleryDialog").modal();
				basemapGallery.startup();
				basemapGallery.on("error", function(msg) {
					console.log("basemap gallery error:  ", msg);
				});
			});
			
			/*Table
			  Dispalay Table
			*/
			var table = $("#table");
			on($("#tableBtn"), "change", function(){
				if($("#tableBtn")[0].checked == true){
					$('#dataTable').css("display", "block");
				}else{
					$('#dataTable').css("display", "none");
				}
			});
			/*Table
			  Map Selected
			*/
			var geom = []
			var location3;
			on($("#mapSelected"), "click", function(){
				var selectedRow = table.bootstrapTable('getAllSelections');
				array.forEach(selectedRow, function(obj){
					geom.length = 0;
					geom = webMercatorUtils.lngLatToXY(obj.x, obj.y);
					var inPoint = {
						"geometry" : {
						"x" : geom[0],
						"y" : geom[1],
						"spatialReference" : map.spatialReference
						},
						"attributes" : {
						"id" : obj.id,
						"incident" : obj.incident,
						"comment" : obj.comment,
						"date" : obj.Date_,
						"date_time" : obj.date_time,
						"day" : obj.Day_,
						"x" : obj.x,
						"y" : obj.y,
						"status" : obj.status,
						"entered_msisdn" : obj.entered_msisdn,
						"picked_msisdn" : obj.picked_msisdn,
						"url" : obj.url
						},
						"infoTemplate": {
						"title" : "Incident",
						"content" : "${incident}<br/> Date/Time: ${date_time}<br/>Phone No: ${entered_msisdn}<br/><br/> <img src='" + "http://69.64.65.196:6060/demo/" + "${url}' alt='Picture was not taken' style='width:170px;height:175;'>"
						}
					};
					console.log("Hatufanani");
					location3 = new Graphic(inPoint);
					incidentsGraphicsLayer.add(location3);
					features.push(location3);
					incidents.features = features;
					params.incidents = incidents;										
					map.graphics.enableMouseEvents();
				});
			});
			/*Table
			  Map Selected
			*/
			on($("#hideTable"), "click", function(){
					$('#dataTable').css("display", "none");
			});
        });