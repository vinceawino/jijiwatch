<!DOCTYPE html>
<html>
  <head>
    <title>Map View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" media="screen">
    
    <!-- Add CSS for the mapping components -->
    <link rel="stylesheet" type="text/css" href="//js.arcgis.com/3.13/esri/css/esri.css">   
    <link rel="stylesheet" type="text/css" href="http://esri.github.io/bootstrap-map-js/src/css/bootstrapmap.css">
	
	<!-- Custom css -->
	<link rel="stylesheet" href="<?php echo base_url('components/src/css/mapcss.css');?>">
    
	<!-- HTML5 IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
      <script src="../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body >
	<div id="map">
	<div class="toolbar1">
	<div id="search"></div>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-road"></span> Route</button>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span> Clear</button>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> Select</button>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-fullscreen"></span> Service Area</button>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-asterisk"></span> Hotspot</button>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-share-alt"></span> Dispatch</button>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-time"></span> Stop Real-time</button>
	<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-large"></span> Basemap</button>
	</div>
	</div>
    <script>
        var package_path ='http://localhost:6060/jijiwatch/components'
        var dojoConfig = {
            packages: [{
                name: "application",
                location: package_path + '/src/js'
            }, {
                name: "bootstrap",
                location: "//rawgit.com/xsokev/Dojo-Bootstrap/master"
            }]
        };
    </script>
    <script src="//js.arcgis.com/3.13compact"></script>
    <script src="<?php echo base_url('components/src/js/mapscript.js');?>"></script>
  </body>
</html>