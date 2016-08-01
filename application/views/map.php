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
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/BootSideMenu.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/bootstrap-slider.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/bootstrap-table.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/mapcss.css');?>">

    <!-- HTML5 IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('components/js/html5shiv.js');?>"></script>
    <script src="<?php echo base_url('components/js/respond.min.js');?>"></script>
    <![endif]-->
</head>
<body >
<!-- Map -->
<div id="map"></div>

<!-- Table -->
<div class="container" id="dataTable">
    <div id="myToolbar">
        <div id="tableButtons">
            <button id="hideTable" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Click to Hide the table"><span class="glyphicon glyphicon-arrow-down"></span> Hide Table</button>
            <button id="mapSelected" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Click to Map Selected row(s)"><span class="glyphicon glyphicon-pushpin"></span> Map Selected Row(s)</button>
        </div>
        <div id="tableDropDown">
            <select class="form-control">
                <option value="">Export Basic</option>
                <option value="all">Export All</option>
                <option value="selected">Export Selected</option>
            </select>
        </div>
    </div>
    <table id="table"
           data-toggle="table"
           data-url="http://69.64.65.196:6060/data2"
           data-height="350"
           data-search="true"
           data-advanced-search="true"
           data-id-table="advancedTable"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-show-export="true"
           data-click-to-select="true"
           data-toolbar="#myToolbar">
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">ID</th>
            <th data-field="incident" data-sortable="true">Incident</th>
            <th data-field="date_time" data-sortable="true">Data\Time</th>
            <th data-field="entered_msisdn">Phone No.</th>
            <th data-field="Incident_Verified" data-sortable="true">Verified</th>
            <th data-field="status" data-sortable="true">Status</th>
        </tr>
        </thead>
    </table>
</div>
<!-- Toolbar -->
<div class="toolbar1">
    <a id="dashboardBtn" href="http://localhost/jijiwatch/index.php/en/dashboard" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Got to dashboard"><span class="glyphicon glyphicon-road"></span> Dashboard</a>
    <button id="routeBtn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Route to the closest response unit(s)"><span class="glyphicon glyphicon-road"></span> Route</button>
    <button id="clearBtn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Remove Graphics from Map"><span class="glyphicon glyphicon-remove"></span> Clear</button>
    <div id="toggleBtn1" class="btn-group" data-toggle="buttons"><label class="btn btn-default btn-sm" data-toggle="tooltip" title="Select a Graphic (To Remove from view or to Dispatch)"><input id="selectBtn" type="checkBox" autocomplete="off"><span class="glyphicon glyphicon-pencil"></span> Select</label></div>
    <div id="toggleBtn2" class="btn-group" data-toggle="buttons"><label class="btn btn-default btn-sm" data-toggle="tooltip" title="See Areas Covered by your response units withing given time limits"><input id="serviceAreaBtn" type="checkBox" autocomplete="off"><span class="glyphicon glyphicon-fullscreen"></span> Service Area</label></div>
    <button id="hotSpotBtn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Find Hotspot areas"><span class="glyphicon glyphicon-asterisk"></span> Hotspot</button>
    <button id="dispatchBtn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Send Incident for Action"><span class="glyphicon glyphicon-share-alt"></span> Dispatch</button>
    <div id="toggleBtn3" class="btn-group" data-toggle="buttons"><label id="realTimeBtnLabel" class="btn btn-default btn-sm" data-toggle="tooltip" title="Disable/Enable Real-Time Reception of Data"><input id="realTimeBtn" type="checkBox" autocomplete="off"><span class="glyphicon glyphicon-time"> </span> Toggle Real-Time</label></div>
    <button id="basemapBtn" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Change the Basemap"><span class="glyphicon glyphicon-th-large"></span> Basemap</button>
    <div id="toggleBtn4" class="btn-group" data-toggle="buttons"><label id="tableBtnLabel" class="btn btn-default btn-sm" data-toggle="tooltip" title="Hide/Show Table"><input id="tableBtn" type="checkBox" autocomplete="off"><span class="glyphicon glyphicon-menu-hamburger"> </span> Table</label></div>
</div>

<!-- Search Bar -->
<!--<div id="search"></div>-->

<!-- HomeButton -->
<div id="HomeButton"></div>

<!-- Side Panel -->
<!-- Feature Layers -->
<div id="demo">
    <div class="panel panel-default">
        <div class="panel-heading">Results Panel</div>
        <div class="panel-body" style="margin-left:15px;">
            <div >
                <b>Check to View Layers</b> <hr>
                <table class="table table-condensed" id="toggle">
                </table>
            </div>
            <hr>
            <b>Route Directions</b><br />(Appear below)<br /><br />
            <div id="directionsDiv"></div>
        </div>
    </div>
</div>

<!-- Routing Dialog Box -->
<div id="routingDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Perform Routing</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>How Many response units should respond?</td>
                            <td><select id="numLocations" name="numLocations" value="1" class="form-control"
                                        style="width: 60px;">
                                    <option selected="selected">1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Do you want to enable Geofencing? Check if Yes	</td>
                            <td><input id="geofence" type="checkBox" class="checkBox" /><label for="geofence"></label></td>
                        </tr>
                        <tr>
                            <td><p><br />Hover over the routes to view directions in the side panel</p></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button id="performRouteBtn" type="button" class="btn btn-default btn-sm" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Routing Error Dialog -->
<div id="routingErrorDialog" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Routing Alert!</h4>
            </div>
            <div class="modal-body" >
                <p>At least One incident must be displayed on the MapView to enable routing</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Service Area -->
<!-- Time Slider -->
<div id="timeSlider1">
    <label data-toggle="tooltip" title="Click & Drag to change the time interval">
        <input
            id="timeSlider"
            type="text"
            name="timeSlider"
            data-slider-min="0"
            data-slider-max="30"
            data-slider-step="2.5"
            data-slider-value="5"
            data-slider-tooltip="show">
    </label>
</div>

<!-- Basemap Gallery Dialog Box -->
<div id="basemapGalleryDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Basemap</h4>
            </div>
            <div class="modal-body" >
                <div id="basemapGallery" ></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Dispatch Warning Dialog -->
<div id="dispatchWarningDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Dispatch Alert</h4>
            </div>
            <div class="modal-body" >
                <p>priviledges
                <center>Use the <b>select button</b> to select the incident you want to dispatch. <br />
                    Make Sure the Incident you want to dispatch is displayed on the Map. <br />
                    Make sure you have only selected one incident.</center>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    var package_path = 'http://localhost/jijiwatch/components'
    var dojoConfig = {
        packages: [{
            name: "application",
            location: package_path + '/src/js'
        },{
            name: "application1",
            location: package_path + '/src/js'
        },{
            name: "timeSlider",
            location: package_path + '/src/js'
        }],
        aliases : [
            ['Pusher', '//js.pusher.com/3.0/pusher.min.js']
        ]};
</script>
<script src="//js.arcgis.com/3.13compact"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('components/src/js/bootstrap-table.js');?>"></script>
<script src="<?php echo base_url('components/src/js/extensions/toolbar/bootstrap-table-toolbar.js');?>"></script>
<script src="<?php echo base_url('components/src/js/extensions/export/bootstrap-table-export.js');?>"></script>
<script src="//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
<script src="<?php echo base_url('components/src/js/mapscript.js');?>"></script>
</body>
</html>