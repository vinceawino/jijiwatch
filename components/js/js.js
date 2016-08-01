var map, params, grid, app, params1, params2, clickpoint;
	var navToolbar;
	require([ 	"Pusher",
	          	"dojo/dom",
				"dojo/on",
				"dojo/_base/array", 
				"dojo/_base/Color",
				"dojo/parser",
				"dijit/registry",
				"dojo/date/locale",

				"esri/dijit/Measurement",
				"esri/dijit/BasemapToggle",				
				"esri/urlUtils", 
				"esri/map",
				"esri/SpatialReference",
				"esri/geometry/webMercatorUtils",
				"esri/domUtils",
				"esri/lang", 
				"esri/graphic", 
				"esri/InfoTemplate",
				"esri/layers/GraphicsLayer",
				"esri/renderers/SimpleRenderer", 
				"esri/geometry/Point",
				"esri/tasks/FeatureSet", 
				"esri/tasks/ClosestFacilityTask",
				"esri/tasks/ClosestFacilityParameters",
				"esri/symbols/SimpleMarkerSymbol",
				"esri/symbols/SimpleLineSymbol",
				"esri/symbols/SimpleFillSymbol",
				"esri/geometry/Extent",
				"esri/dijit/HomeButton",
				"esri/layers/FeatureLayer",
				"esri/toolbars/draw",
				"esri/tasks/ServiceAreaTask",
				"esri/tasks/ServiceAreaParameters",
				"esri/layers/ArcGISDynamicMapServiceLayer",
				"esri/tasks/Geoprocessor",
				"esri/dijit/Legend",
				"esri/layers/ImageParameters",
				"esri/dijit/Search",
				"esri/toolbars/navigation",
				
				"dijit/form/ToggleButton",
				"dijit/form/CheckBox",
				"dojo/request", 
				"dojo/number", 
				"dojo/dom-construct", 
				"dojo/_base/declare",
				"dojo/store/JsonRest",
				"dojo/store/Memory", 
				"dojo/store/Cache", 
				"dojo/store/Observable",
				"dojox/socket",
				"dgrid/OnDemandGrid", 
				"dgrid/Keyboard",
				"dgrid/Selection",
				"dojox/charting/Chart",
				"dojox/charting/themes/Claro",
				"dojox/charting/plot2d/Pie",
				"dojox/charting/action2d/Tooltip",
				"dojox/charting/action2d/MoveSlice",
				"dojox/charting/plot2d/Columns",
				"dojox/charting/action2d/Highlight",
				"dijit/Dialog",
				"dojox/charting/plot2d/Markers",
				"dojox/charting/axis2d/Default",
				"dijit/form/ComboBox", 
				"dijit/form/TextBox", 
				"dijit/form/DateTextBox",
				"dijit/form/TimeTextBox", 
				"dijit/form/Textarea",
				"dijit/layout/BorderContainer",
				"dijit/layout/TabContainer", 
				"dijit/layout/ContentPane",
				"dijit/layout/AccordionContainer",
				"dijit/layout/AccordionPane",
				"dijit/form/HorizontalRule", 
				"dijit/form/HorizontalRuleLabels", 
				"dijit/form/HorizontalSlider",
				"dijit/Toolbar",
				"dojo/domReady!" 
			],
			function(
				Pusher,
				dom, 
				on, 
				array, 
				Color, 
				parser, 
				registry,
				locale,				
				Measurement,
				BasemapToggle,
				urlUtils, 
				Map,
				SpatialReference,
				webMercatorUtils,
				domUtils,
				esriLang, 
				Graphic, 
				InfoTemplate,
				GraphicsLayer, 
				SimpleRenderer, 
				Point, 
				FeatureSet, 
				ClosestFacilityTask, 
				ClosestFacilityParameters,
				SimpleMarkerSymbol, 
				SimpleLineSymbol, 
				SimpleFillSymbol, 
				Extent, HomeButton, 
				FeatureLayer, 
				Draw, 
				ServiceAreaTask, 
				ServiceAreaParameters,
				ArcGISDynamicMapServiceLayer,
				Geoprocessor,
				Legend,
				ImageParameters,
				Search,
				Navigation,
				ToggleButton, 
				CheckBox, 
				request, 
				number, 
				domConstruct, 
				declare, 
				JsonRest,
				Memory, 
				Cache, 
				Observable,
				Socket,
				OnDemandGrid,
				Keyboard, 
				Selection,
				Chart, 
				theme, 
				Pie, 
				Tooltip, 
				MoveSlice, 
				ColumnsPlot, 
				Highlight, 
				Dialog) {
				
				parser.parse();
				
				var incidentsGraphicsLayer, facilitiesGraphicsLayer, routeGraphicLayer, closestFacilityTask, 
					incidentPointSymbol, facilityPointSymbol, serviceAreaTask;
				var geom1;
				var pusher;
				var channel;
				var masterStore;
				var cacheStore;
				var inventoryStore;
				var CustomGrid;
				var myQuery;

				/*
				urlUtils.addProxyRule({
					urlPrefix: "41.215.68.234:6080",
					proxyUrl: "http://41.215.68.234/demo/PHP/proxy.php"
				});
				**/
				
				map = new Map("map", {
					basemap : "satellite",
					center : [ 36.817, -1.286 ],
					zoom : 15,
					spatialReference: {"wkid":4326},
					showInfoWindowOnClick : true
				});
				var sr = new SpatialReference(4326);
				map.spatialReference = sr;
				
				var toggle = new BasemapToggle({
					map: map,
					basemap: "osm"
				}, "BasemapToggle");
				toggle.startup();
									
				var home = new HomeButton({
					map: map
				}, "HomeButton");
				home.startup();
				
				var checkDrawnExtent;
				var location;
				var location1;
				var features = [];
				var incidents = new FeatureSet();
				var facilities = new FeatureSet();
				var facilities2 = new FeatureSet();
				var facilities3 = new FeatureSet();
				highlightSymbol = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CIRCLE,16,
									new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 0, 255, 255 ]), 2),new Color([ 255, 215, 0, 0.40 ]));
				
				params = new ClosestFacilityParameters();
				params.impedenceAttribute = "";
				params.defaultCutoff = 50;
				params.returnIncidents = false;
				params.returnRoutes = true;
				params.returnDirections = true;
				
				params1 = new ServiceAreaParameters();
				params1.defaultBreaks= [1];
				params1.outSpatialReference = map.spatialReference;
				params1.returnFacilities = false;
				
				params2 = new ServiceAreaParameters();
				params2.defaultBreaks= [1];
				params2.outSpatialReference = map.spatialReference;
				params2.returnFacilities = false;
	  
				map.on("load",function(evtObj) {
					var map = evtObj.target;
					//map.hideZoomSlider();
					map.logo = false;
					checkDrawnExtent = map.extent;
					
					var measurement = new Measurement({
							map : map,
					}, dom.byId("measurementDiv"));
					measurement.startup();
					
					var s = new Search({
						map: map
					}, "search");
					s.startup();

					  navToolbar = new Navigation(map);
					  on(navToolbar, "onExtentHistoryChange", extentHistoryChangeHandler);

					  registry.byId("zoomin").on("click", function () {
						navToolbar.activate(Navigation.ZOOM_IN);
					  });

					  registry.byId("zoomout").on("click", function () {
						navToolbar.activate(Navigation.ZOOM_OUT);
					  });

					  registry.byId("zoomfullext").on("click", function () {
						navToolbar.zoomToFullExtent();
					  });

					  registry.byId("zoomprev").on("click", function () {
						navToolbar.zoomToPrevExtent();
					  });

					  registry.byId("zoomnext").on("click", function () {
						navToolbar.zoomToNextExtent();
					  });

					  registry.byId("pan").on("click", function () {
						navToolbar.activate(Navigation.PAN);
					  });

					  registry.byId("deactivate").on("click", function () {
						navToolbar.deactivate();
					  });

					facilityPointSymbol = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_SQUARE, 15, new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 255, 140, 0 ]),2), new Color([ 255, 215,0, 0.40 ]));
					incidentPointSymbol = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CIRCLE, 16, new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 255, 255, 0 ]), 2),new Color([ 255, 215, 0, 0.40 ]));
					incidentsGraphicsLayer = new GraphicsLayer();
					var incidentsRenderer = new SimpleRenderer(incidentPointSymbol);
					incidentsGraphicsLayer.setRenderer(incidentsRenderer);
					map.addLayer(incidentsGraphicsLayer);

					routeGraphicLayer = new GraphicsLayer();
					var routePolylineSymbol = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 255, 140, 0 ]), 4.0);
					var routeRenderer = new SimpleRenderer(routePolylineSymbol);
					routeGraphicLayer.setRenderer(routeRenderer);
					map.addLayer(routeGraphicLayer);

					facilitiesGraphicsLayer = new GraphicsLayer();
					var facilityRenderer = new SimpleRenderer(facilityPointSymbol);
					facilitiesGraphicsLayer.setRenderer(facilityRenderer);
					map.addLayer(facilitiesGraphicsLayer);
					facilitiesGraphicsLayer.add(new Graphic(new Point(4098609.436, -142434.2164,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4097396.165, -144410.7483,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4100352.922, -144820.5093,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4100248.393, -137421.2953,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4102160.639, -144137.5004,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4096006.230, -143775.9539,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4095909.827, -141976.2455,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4100566.099, -141364.7281,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4097895.655, -140858.3231,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4103320.477, -143860.5782,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4109174.101, -145783.1160,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4110579.398, -148512.6170,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4097526.520, -137540.6575,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4094878.118, -139081.0135,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4093472.821, -140837.6126,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4086095.122, -147053.2721,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4089770.446, -143972.4828,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4088311.159, -140540.3173,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4099200.543, -145246.3051,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4098264.145, -146647.2936,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4099820.815, -146863.3106,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4110072.561, -140404.1405,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4105869.248, -138533.5259,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4098793.558, -143758.8063,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4099564.891, -143847.1051,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4100477.377, -143391.3589,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4100544.948, -143208.9716,map.spatialReference)));
					facilitiesGraphicsLayer.add(new Graphic(new Point(4101705.676, -143783.3029,map.spatialReference)));
													
					facilities.features = facilitiesGraphicsLayer.graphics;
					params.facilities = facilities;
					params.outSpatialReference = map.spatialReference;
									
					facilities2.features = facilitiesGraphicsLayer.graphics;
					params2.facilities = facilities2;
																
					//click graphics
					on(incidentsGraphicsLayer,"click", getIncidentGraphic);
									
					//on add graphics
					on(incidentsGraphicsLayer,"graphic-add", zoomToGraphics);
					
					loadGrid();
					
					socketConnect();
				});
				
				function extentHistoryChangeHandler () {
					registry.byId("zoomprev").disabled = navToolbar.isFirstExtent();
					registry.byId("zoomnext").disabled = navToolbar.isLastExtent();
				}
				
				//add layers
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
			
				//add the legend
				map.on("layers-add-result",function(evt) {
					var layerInfo = array.map(evt.layers,function(layer,index) {
						return {
							layer : layer.layer,
							title : layer.layer.name
						};
					});
														
					//add check boxes 
					array.forEach(layerInfo,function(layer) {
						var layerName = layer.title;
						var checkBox = new CheckBox({
							name : "checkBox" + layer.layer.id,
							value : layer.layer.id,
							checked : layer.layer.hide(),
							onChange : function(evt) {
								var clayer = map.getLayer(this.value);
								clayer.setVisibility(!clayer.visible);
								this.checked = clayer.visible;
							}
						});
						//add the check box and label to the TOC
						domConstruct.place(checkBox.domNode,"toggle","after");
						var checkLabel = domConstruct.create('label',{
							'for' : checkBox.name,
							innerHTML : layerName
						},checkBox.domNode,"after");
						domConstruct.place("<br /><br />",checkLabel,"after");
					});
				});
				
				map.addLayers([wards, healthCenters, schools, geoFence]);
				
				registry.byId("numLocations").on("change", function() {
					params.defaultTargetFacilityCount = this.value;
					//clearGraphics();
				});

				function clearGraphics() {
					dom.byId("directionsDiv").innerHTML = "";
					map.graphics.clear();
					routeGraphicLayer.clear();
					incidentsGraphicsLayer.clear();
				}
				
				var geofence = new CheckBox({
					 name: "checkBox",
					 checked: false
				}, "geofence");
				
				var highlightGraphic;
				function performRouting() {
					routeGraphicLayer.on("mouse-over",function(evt) {
						//clear existing directions and highlight symbol
						map.graphics.clear();
						dom.byId("directionsDiv").innerHTML = "Hover over the route to view directions";

						var highlightSymbol = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 0, 255, 255 ], 0.25),4.5);
						highlightGraphic = new Graphic(evt.graphic.geometry,highlightSymbol);

						map.graphics.add(highlightGraphic);
						dom.byId("directionsDiv").innerHTML = esriLang.substitute(evt.graphic.attributes,"${*}");
						
						var container = dijit.byId("container");
						container.selectChild("legendPane", true); 
					});
					
					if (geofence.checked == true) {
						closestFacilityTask = null;
						closestFacilityTask = new ClosestFacilityTask("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/geofense/NAServer/ClosestFacility_1");
						solveCloseFacilityRouting()
					} else {
						closestFacilityTask = null;
						closestFacilityTask = new ClosestFacilityTask("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/closestfacility/NAServer/ClosestFacility_0");
						solveCloseFacilityRouting()
					}
				}
				
				function solveCloseFacilityRouting() {
					closestFacilityTask.solve(params,function(solveResult) {
						var directions = solveResult.directions;
						array.forEach(solveResult.routes,function(route, index) {
						//build an array of route info
						var attr = array.map(solveResult.directions[index].features,function(feature) {
							return feature.attributes.text;
						});
						var infoTemplate = new InfoTemplate("Attributes", "${*}");

						route.setInfoTemplate(infoTemplate);
						route.setAttributes(attr);

						routeGraphicLayer.add(route);
						dom.byId("directionsDiv").innerHTML = "Hover over the route to view directions";
						});

						//display any messages
						if (solveResult.messages.length > 0) {
							dom.byId("directionsDiv").innerHTML = "Hover over the route to view directions";
						}
					});
				}
				
				serviceAreaTask = new ServiceAreaTask("http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/servicearea/NAServer/ServiceArea");
				
				registry.byId("hslider").on("change", updateHorizontalLabel);
				updateHorizontalLabel();
				var active = false;
				// Create function that updates label when changed
				function updateHorizontalLabel() {
				// Get access to nodes/widgets we need to get/set values
					var hSlider = registry.byId("hslider");
					var label = dom.byId("decValue");
					// Update label
					label.innerHTML = hSlider.get("value");
					params1.defaultBreaks = [ hSlider.value / 60 ];
					params2.defaultBreaks = [ hSlider.value / 60 ];
					if (active == true) {
						if (clickpoint) {
						mapClickHandler(clickpoint);
						}
					}
					if (active == true) {
						performServiceAreaTask();
					}
				}
      
				function mapClickHandler(evt) {
					clickpoint = evt;
					var inPoint2 = new Point(evt.mapPoint.x, evt.mapPoint.y, map.spatialReference);
					var location2 = new Graphic(inPoint2, facilityPointSymbol);
					facilitiesGraphicsLayer.add(location2);
					facilities2.features = facilitiesGraphicsLayer.graphics;
					params2.facilities = facilities2;

					map.graphics.add(location2);
					var features1 = [];
					features1.push(location2);
					var facilities1 = new FeatureSet();
					facilities1.features = features1;
					params1.facilities = facilities1;

					serviceAreaTask.solve(params1,function(solveResult){
					  var polygonSymbol = new SimpleFillSymbol("solid", new SimpleLineSymbol("solid", new Color([232,104,80]), 2), new Color([232,104,80,0.25])
					  );
					  array.forEach(solveResult.serviceAreaPolygons, function(serviceArea){
						serviceArea.setSymbol(polygonSymbol);
						map.graphics.add(serviceArea);
					  });
					  
					}, function(err){
					  console.log(err.message);
					});
				}
			
				function loadGrid () {
					masterStore = new JsonRest({
					target:"http://69.64.65.196:6060/data2/"
					});
					cacheStore = new Observable (new Memory({
					idProperty:"id"
					}));
					inventoryStore = new Cache(masterStore, cacheStore);
					CustomGrid = declare([ OnDemandGrid, Keyboard, Selection ]);
						grid = new CustomGrid({
							//className : "dgrid-autoheight",
							allowSelectAll : true,
							columns : {
								id : "id",
								incident : "incident",
								comment : "comment",
								Date_ : "Date_",
								date_time : "date_time",
								Day_ : "Day_",
								entered_msisdn : "entered_msisdn",
								picked_msisdn : "picked_msisdn",
								status : "status"
							},
							queryOptions: {
								sort: [{ attribute: "id", descending: true }]
							},
							selectionMode : "extended",
							cellNavigation : false
						}, "grid");
						grid.startup();
						
						refresh();
				}
				
				function refresh () {
					myQuery = inventoryStore.query();
					grid.setStore(cacheStore);
				}
				
				on(dom.byId("deleteRow"), "click", function (evt){
					refresh();
				});
					var sms = false;
					// Enable pusher logging - don't include this in production
//					Pusher.log = function(message) {
//					  if (window.console && window.console.log) {
//						window.console.log(message);
//					  }
//					};

				function socketConnect() {
					geom1 = [];
					pusher = new Pusher('fae3f83fa67c2d978994');
					channel = pusher.subscribe('test_channel');
					channel.bind('my_event', function(data) {
						grid.store.add(data[0]);
						geom1.length = 0;
						geom1 = webMercatorUtils.lngLatToXY(data[0].x, data[0].y);
						var inPoint = {
							"geometry" : {
							"x" : geom1[0],
							"y" : geom1[1],
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
							"content" : "${incident}<br/> Date: ${date}<br/><br/>View Picture on Picture Panel<br/>"}
							};
						
						location = new Graphic(inPoint);
							
						highlightSymbolNew = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CIRCLE,16,
								new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([ 255, 0, 0 ]), 2),new Color([ 255, 215, 0, 0.40 ]));
						location.setSymbol(highlightSymbolNew);
							
						incidentsGraphicsLayer.add(location);
						features.push(location);
						incidents.features = features;
						params.incidents = incidents;
																
						map.graphics.enableMouseEvents();
						
					//check if the browser supports notifications
					  if (!("Notification" in window)) {
						alert("This browser does not support desktop notification");
					  }
					 //check whether notification permissions have already been granted
					  else if (Notification.permission === "granted") {
						var notification = new Notification("You have a new incident reported!");
					  }
					 // Otherwise, ask the user for permission
					  else if (Notification.permission !== 'denied') {
						Notification.requestPermission(function (permission) {
						  if (permission === "granted") {
							var notification = new Notification("You have a new incident reported!");
						  }
						});
					  }
						
						request1(data[0].id);
					});
					
					Pusher.log = function(message) {
						  if (window.console && window.console.log) {
							window.console.log(message);
						  }
						};
				}
					
					function request1(id){
						request("insertMessage.php?id=" + id).then(function(data){
							 console.log(data);
						  }, function(err){
							console.log(err);
						  });
					}
					
					//get real-time incidents
					var realTimeButton = new ToggleButton({
						showLabel: true,
						checked: false,
						label: "Stop Real-Time Data",
						onChange : function clearSelectedGraphics() {
							if (this.get('checked') == true){
								this.set("label","Get Real-Time Data");
								pusher.disconnect();
								if (!("Notification" in window)) {
								alert("This browser does not support desktop notification. Upgrade to latest browser version");
								}else{
									var notification = new Notification("You are NOT connected to Real-time event reception!!");
								}
								//socket.close();
								//socket = null;
							} else {
								this.set("label","Stop Real-Time Data");
								try {
								pusher.connect();
								if (!("Notification" in window)) {
								alert("This browser does not support desktop notification. Upgrade to latest browser version");
								}else{
									var notification = new Notification("You are connected to Real-time event reception");
								}
								//myWebsocket();
								} catch(ex) { 
									console.log(ex); 
								}
							}
						}
					}, "realTimeButton");

					on(dom.byId("queryForm"), "submit", function(event) {
						event.preventDefault();
						grid.set("query", {
							incident: new RegExp(this.elements.incident.value, "i")
						});
					});
					on(dom.byId("queryForm"), "reset", function() {
						grid.set("query", {});
					});
							
					//map all selected incidents
					var geom = [];
					on(dom.byId("mapSelect"), "click", function (evt3){
						array.forEach(grid.store.data, function (item) {
							if (grid.selection[item.id]) {
							geom.length = 0;
							geom = webMercatorUtils.lngLatToXY(item.x, item.y);
								var inPoint = {
									"geometry" : {
									"x" : geom[0],
									"y" : geom[1],
									"spatialReference" : map.spatialReference
									},
									"attributes" : {
									"id" : item.id,
									"incident" : item.incident,
									"comment" : item.comment,
									"date" : item.Date_,
									"date_time" : item.date_time,
									"day" : item.Day_,
									"x" : item.x,
									"y" : item.y,
									"status" : item.status,
									"entered_msisdn" : item.entered_msisdn,
									"picked_msisdn" : item.picked_msisdn,
									"url" : item.url
									},
									"infoTemplate": {
									"title" : "Incident",
									"content" : "${incident}<br/> Date: ${date}<br/>View Picture on Picture Panel<br/><br/>"}
									};
								location = new Graphic(inPoint);
								incidentsGraphicsLayer.add(location);
								features.push(location);
								incidents.features = features;
								params.incidents = incidents;
																
								map.graphics.enableMouseEvents();
							}
						});
					});
					
					//Create PieChart
					var totalGarbage, totalStreetLight, totalBurstSewer, totalFire, totalBurstPipes, totalHawkers, totalPotholes, totalFlooding, totalDangerousBuildings, totalVandalism, totalCorruption, totalGraffiti, others;
					on(dom.byId("pieButt"), "click", function(evt) {
						domConstruct.empty("chartNode");
						totalGarbage = totalStreetLight = totalBurstSewer = totalFire = totalBurstPipes = totalHawkers = totalPotholes = totalFlooding = totalDangerousBuildings = totalVandalism = totalCorruption = totalGraffiti = others = 0;
						array.forEach(grid.store.data, function (item) {
							if (item.incident == "Garbage") {
								totalGarbage = totalGarbage + 1;
							} else if (item.incident == "No/Brocken Street light") {
								totalStreetLight = totalStreetLight +1;
							}else if (item.incident == "Burst Sewer") {
								totalBurstSewer = totalBurstSewer +1;
							}else if (item.incident == "Fire") {
								totalFire = totalFire +1;
							}else if (item.incident == "Burst Pipes") {
								totalBurstPipes = totalBurstPipes +1;
							}else if (item.incident == "Hawkers") {
								totalHawkers = totalHawkers +1;
							}else if (item.incident == "Potholes") {
								totalPotholes = totalPotholes +1;
							}else if (item.incident == "Flooding") {
								totalFlooding = totalFlooding +1;
							}else if (item.incident == "Dangerous buildings") {
								totalDangerousBuildings = totalDangerousBuildings +1;
							}else if (item.incident == "Vandalism") {
								totalVandalism = totalVandalism +1;
							}else if (item.incident == "corruption") {
								totalVandalism = totalCorruption +1;
							}else if (item.incident == "Graffiti") {
								totalVandalism = totalGraffiti +1;
							}else {
								others = others + 1;
							}
						});
						var chartData = [totalGarbage, totalStreetLight, totalBurstSewer,  totalFire, totalBurstPipes, totalHawkers, totalPotholes, totalFlooding, totalDangerousBuildings, totalVandalism, others];
						var chart = new Chart("chartNode");
						chart.setTheme(theme);
						chart.addPlot("default", {
							type: Pie,
							markers: true,
							radius:150
						});
						
						chart.addAxis("x");
						chart.addAxis("y", {
							min: 0, 
							//max: 30000, 
							vertical: true, 
							fixLower: "major", 
							fixUpper: "major" 
						});
						chart.addSeries("Incidents",chartData);
								// Create the tooltip
						var tip = new Tooltip(chart,"default");
								// Create the slice mover
						var mag = new MoveSlice(chart,"default");
						chart.render();
									
						pieChartDialog.show();
					});
							
					on(dom.byId("barButt"), "click", function(evt) {
						domConstruct.empty("barNode");
						totalGarbage = totalStreetLight = totalBurstSewer = totalFire = totalBurstPipes = totalHawkers = totalPotholes = totalFlooding = totalDangerousBuildings = totalVandalism = others = 0;
						array.forEach(grid.store.data, function (item) {
							if (item.incident == "Garbage") {
								totalGarbage = totalGarbage + 1;
							} else if (item.incident == "No/Brocken Street light") {
								totalStreetLight = totalStreetLight +1;
							}else if (item.incident == "Burst Sewer") {
								totalBurstSewer = totalBurstSewer +1;
							}else if (item.incident == "Fire") {
								totalFire = totalFire +1;
							}else if (item.incident == "Burst Pipes") {
								totalBurstPipes = totalBurstPipes +1;
							}else if (item.incident == "Hawkers") {
								totalHawkers = totalHawkers +1;
							}else if (item.incident == "Potholes") {
								totalPotholes = totalPotholes +1;
							}else if (item.incident == "Flooding") {
								totalFlooding = totalFlooding +1;
							}else if (item.incident == "Dangerous buildings") {
								totalDangerousBuildings = totalDangerousBuildings +1;
							}else if (item.incident == "Vandalism") {
								totalVandalism = totalVandalism +1;
							}else if (item.incident == "corruption") {
								totalVandalism = totalCorruption +1;
							}else if (item.incident == "Graffiti") {
								totalVandalism = totalGraffiti +1;
							}else {
								others = others + 1;
							}
						});
						var chartData = [totalGarbage, totalStreetLight, totalBurstSewer, totalFire, totalBurstPipes, totalHawkers, totalPotholes, totalFlooding, totalDangerousBuildings, totalVandalism, others];
						var chart1 = new Chart("barNode");
						chart1.setTheme(theme);
						chart1.addPlot("default", {
							type: ColumnsPlot,
							markers: true,
							gap: 5
						});
						chart1.addAxis("x", {
							labels: [{value: 1, text: "Garbage"}, {value: 2, text: "St.Light"},
									{value: 3, text: "Sewer"}, {value: 4, text: "Fire"},
									{value: 5, text: "Pipe"}, {value: 6, text: "Hwk"},
									{value: 7, text: "Pt.Hole"}, {value: 8, text: "Fld"},
									{value: 9, text: "Bld"}, {value: 10, text: "Vand"},
									{value: 11, text: "other"}]
						});
						chart1.addAxis("y", { vertical: true, fixLower: "major", fixUpper: "major" });
						chart1.addSeries("Incidents",chartData);
						new Highlight(chart1,"default");
						chart1.render();
								
						barGraphDialog.show();
					});

					function getIncidentGraphic (evt1) {
						domConstruct.empty("displayImage");
						domConstruct.empty("incidentContent");
						domConstruct.create("img",{src:"http://69.64.65.196:6060/demo/" + evt1.graphic.attributes.url, width:"175", height:"170"}, "displayImage", "first");
						dom.byId("incidentContent").innerHTML = "<b>Incident:</b> "
																+ evt1.graphic.attributes.incident
																+ "<br><br><b>Comments:</b> "
																+ evt1.graphic.attributes.comment
																+ "<br><br><b>Date:</b> "
																+ evt1.graphic.attributes.date
																+ "<br><br><b>Day:</b> "
																+ evt1.graphic.attributes.day
																+ "<br><br><b>Date:time:</b> "
																+ evt1.graphic.attributes.date_time
																+ "<br><br><b>Entered Phone Number:</b> "
																+ evt1.graphic.attributes.entered_msisdn
																+ "<br><br><b>Picked Phone Number:</b> "
																+ evt1.graphic.attributes.picked_msisdn
																+ "<br><br><b>Status:</b> "
																+ evt1.graphic.attributes.status
																+ "<br><br>";
						var container = dijit.byId("container");
						container.selectChild("pane2", true);
					}
				
				function zoomToGraphics (evt2) {
					if (incidentsGraphicsLayer.graphics.length == 1) {
						var numx = number.parse(evt2.graphic.geometry.x);
						var numy = number.parse(evt2.graphic.geometry.y);
						var factor = 1000;
						var extent = new esri.geometry.Extent(numx - factor, numy - factor, numx + factor, numy + factor, map.spatialReference);
					    map.setExtent(extent.expand(1));
					} else if (incidentsGraphicsLayer.graphics.length > 1) {
						var extent = esri.graphicsExtent(incidentsGraphicsLayer.graphics);
						map.setExtent(extent.expand(1), true);
					}
				}
				
				var routeButton = new dijit.form.Button({
					iconClass : "myIcon",
					label : "Route to Incident",
					onClick : function createRoute() {
					if (features.length != 0) {
						map.graphics.remove(highlightGraphic);
						routeGraphicLayer.clear();
						performRouting();
						}
					}
				}, "routeButton");
				
				var clearButton = new dijit.form.Button({
					iconClass : "dijitEditorIcon dijitEditorIconDelete",
					label : "Clear",
					onClick : function clearAllGraphics() {
						domConstruct.empty("displayImage");
						domConstruct.empty("incidentContent");
						domConstruct.empty("directionsDiv");
							if (blue == true) {
							array.forEach(unselectIncidents, function(graphic) {
								if (checkDrawnExtent.contains(graphic.geometry)) {
									incidentsGraphicsLayer.remove(graphic);
									var graphicID = graphic.attributes.id;
									for(var i = 0; i < features.length; i++){
										if(features[i].attributes.id == graphicID){
											features.splice(i,1);
										}
									}
								}
							});
						} else if (blue == false){
							clearGraphics();
							features.length = 0;
						}
					}
				}, "clearButton");
				
				var blue = false;
				var tb;
				var clearSelectedButton = new ToggleButton({
					iconClass: "dijitCheckBoxIcon",
					showLabel: true,
					checked: false,
					label: "Select Incidents",
					onChange : function clearSelectedGraphics() {
						blue = true;
						if (this.get('checked') == true){
							map.isPan = false;
							navToolbar.deactivate();
							tb = new Draw(map);
							tb.on("draw-end", findPointsInExtent);
							tb.activate(Draw.EXTENT);
						} else {
							blue = false;
							map.isPan = true;
							tb.deactivate();
							checkDrawnExtent = map.extent;
							domConstruct.empty("directionsDiv");
							array.forEach(unselectIncidents, function(graphic) {
								graphic.setSymbol(incidentPointSymbol);
							});
						}
					}
				}, "clearSelectedButton");
				
				var unselectIncidents = [];
				var results = [];
				var resultsGraphic = [];
				function findPointsInExtent(drawnExtent) {
					results.length = 0;
					unselectIncidents.length = 0;
					resultsGraphic.length = 0;
					checkDrawnExtent = drawnExtent.geometry;
					array.forEach(incidentsGraphicsLayer.graphics,function(graphic){
					unselectIncidents.push(graphic);
						 if (drawnExtent.geometry.contains(graphic.geometry)) {
							graphic.setSymbol(highlightSymbol);
							results.push(graphic.getContent());
							resultsGraphic.push(graphic);
						 }
						  else if (graphic.symbol == highlightSymbol) {
							graphic.setSymbol(incidentPointSymbol);
						 }
					});

					//display list of points in extent
					dom.byId("directionsDiv").innerHTML = "<br/>Number of Slected Incidents: " + results.length + "<br/><br/>" + "<table><tbody>" + results.join("") + "</tbody></table>";
					var container = dijit.byId("container");
					container.selectChild("legendPane", true); 
				}
				
				function performServiceAreaTask (){
					map.graphics.clear();
					serviceAreaTask.solve(params2,function(solveResult){
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
				
				domUtils.hide(dom.byId('ruler'));
				var clickEvent;
				var serviceAreaButton = new ToggleButton({
					iconClass: "dijitCheckBoxIcon",
					showLabel: true,
					checked: false,
					label : "Service Area Analysis",
					onChange : function serviceAreaAnalysis() {
						if (this.get('checked') == true){
							active = true;
							performServiceAreaTask();
							clickEvent = on(map, "click", mapClickHandler);
							domUtils.show(dom.byId('ruler')); 
						} else {
							active = false;
							clickEvent.remove();
							clickEvent = null;
							map.graphics.clear();
							domUtils.hide(dom.byId('ruler'));
						}
					}
				}, "serviceAreaButton");
				
				var legend;
				var gpServiceUrl = "http://69.64.65.196:6080/arcgis/rest/services/jijiwatch/Hotspot/GPServer/Hotspot";
				var gp = new Geoprocessor(gpServiceUrl);
				var hotSpotButton = new dijit.form.Button({
					iconClass : "hotspotIcon",
					label : "Hot Spot Analysis",
					onClick : function hotSpotAnalysis() {
						hotSpotDialog.show();
					}
				}, "hotSpotButton");
				
				function findHotspot(){
					var paramsHSA = {
						"Expression": buildDefinitionQuery()
					};
					//cleanup any results from previous runs 
					cleanup();
					gp.submitJob(paramsHSA, gpJobComplete, gpJobStatus, gpJobFailed);
				}
				
				function gpJobComplete(jobinfo){
					//get the result map service layer and add to map
					var imageParams = new ImageParameters();
					imageParams.imageSpatialReference = map.spatialReference;
					gp.getResultImageLayer(jobinfo.jobId, "Visualization_Surface", imageParams, function(layer){
						layer.setOpacity(0.9);
						map.addLayers([layer]);
						console.log (map.getLayer('Visualization_Surface'));
					});
					gp.getResultImageLayer(jobinfo.jobId, "Selected_Incidents", imageParams, function(layer){
						console.log (layer);
						map.addLayers([layer]);
					});

					map.on("layers-add-result", function(evtObj) {
						 domUtils.show(dom.byId('legendDiv'));          
						 if( !legend ) { 
						//add the legend to show the resulting layer. 
							var layerInfo = array.map(evtObj.layers, function(layer,index){
								return {
								layer: layer.layer,
								title: layer.layer.name
								};
							});
							legend = new Legend({
							  map: map,
							  layerInfos: layerInfo
							},"legendDiv");
							legend.startup();
						}
					});
					
					hotSpotResult.show();
				}      
      
				function gpJobStatus(jobinfo){
					domUtils.show(dom.byId('status'));
					var jobstatus = '';
					switch (jobinfo.jobStatus) {
						case 'esriJobSubmitted':
						jobstatus = 'Submitted...';
						break;
						case 'esriJobExecuting':
						jobstatus = 'Executing...';
						break;
						case 'esriJobSucceeded':
						domUtils.hide(dom.byId('status'));
						break;
					}
					dom.byId('status').innerHTML = jobstatus;
				}
				
				function gpJobFailed(error){
					console.log("pole");
					dom.byId('status').innerHTML = error;
					domUtils.hide(dom.byId('status'));
				 }
				 
				function buildDefinitionQuery(){
					var defQuery;
					var startDate = locale.format(registry.byId('fromDate').value, {
						datePattern: 'yyyy-MM-dd 00:00:00',
						selector: 'date'
					});
					var endDate = locale.format(registry.byId('toDate').value, {
						datePattern: 'yyyy-MM-dd 00:00:00',
						selector: 'date'
					});
					var def = [];
					def.push("(Date_ >= date '" + startDate + "' AND Date_ <= date '" + endDate + "')");
					def.push("(Day_ = 'Sun' OR Day_ = 'Sat' OR Day_ = 'Fri' OR Day_ = 'Mon' OR Day_ = 'Tue' OR Day_ = 'Wed' OR Day_ = 'Thu')");

					if (def.length > 1) {
						defQuery = def.join(" AND ");
					}
					
					console.log(defQuery);
					return defQuery;
				}
      
				function cleanup(){
					//hide the legend and remove the existing hotspot layer
					domUtils.hide(dom.byId('legendDiv'));
					var hotspotLayer = map.getLayer('Hot_Spot_Result');
					if(hotspotLayer){
					  map.removeLayer(hotspotLayer);
					}
				}
				app = {
					findHotspot: findHotspot
				};
				var authority;
				var rprtIncident;
				var rprtDate;
				var rprtTime;
				var rprtComment;
				var rprtX;
				var rprtY;
				var dispatchButton = new dijit.form.Button({
					iconClass : "dispatchIcon",
					label : "Dispatch",
					onClick : function dispatchIncident() {
						array.forEach(resultsGraphic, function(graphic) {
							authority = registry.byId("station");
							rprtIncident = registry.byId("name");
							rprtDate = registry.byId("sdate");
							rprtComment = registry.byId("com");
							rprtTime = registry.byId("time");
							authority.set ("value","Nearest Station");
							rprtIncident.set("value",graphic.attributes.incident);
							rprtDate.set("value",graphic.attributes.date);
							rprtComment.set("value",graphic.attributes.comment);
							rprtTime.set("value", new Date().getTime());
						});
						myFormDialog.show();
					}
				}, "dispatchButton");
				
			});