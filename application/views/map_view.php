<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url('components/images/favicon.png');?>" type="image/png">
    <title>Jijiwatch</title>
    <link href="<?php echo base_url('components/css/style.default.css');?>" rel="stylesheet">
    <!-- Add CSS for the mapping components -->
    <link rel="stylesheet" type="text/css" href="//js.arcgis.com/3.13/esri/css/esri.css">
    <link rel="stylesheet" type="text/css" href="http://esri.github.io/bootstrap-map-js/src/css/bootstrapmap.css">

    <!-- Custom css -->
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/BootSideMenu.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/bootstrap-slider.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/bootstrap-table.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('components/src/css/mapcss.css');?>">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('components/js/html5shiv.js');?>"></script>
    <script src="<?php echo base_url('components/js/respond.min.js');?>"></script>
    <![endif]-->
</head>

<body>
<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>
<section>

    <div class="leftpanel">

        <div class="logopanel">
            <h1>Jijiwatch</h1>
        </div><!-- logopanel -->

        <div class="leftpanel">

            <div class="logopanel">
                <h1>Jijiwatch</h1>
            </div><!-- logopanel -->

            <div class="leftpanelinner">

                <!-- This is only visible to small devices -->
                <div class="visible-xs hidden-sm hidden-md hidden-lg">
                    <div class="media userlogged">
                        <img alt="" src="<?php echo  base_url('components/images/photos/loggeduser.png');?>" class="media-object">
                        <div class="media-body">
                            <h4>Admin</h4>
                        </div>
                    </div>

                    <h5 class="sidebartitle actitle">Account</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                        <li><a href="profile.html"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
                        <li><a href="#"><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
                        <li><a href="http://localhost/jijiwatch/index.php/en/register"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                    </ul>
                </div>

                <h5 class="sidebartitle">Navigation</h5>
                <ul class="nav nav-pills nav-stacked nav-bracket">
                    <li class="active"><a href="http://localhost/jijiwatch/index.php/en/dashboard"><i class="fa fa-home"></i> <span>Map View</span></a></li>
                    <li class="nav-parent"><a href="#"><i class="fa fa-edit"></i> <span>Incidents</span></a>
                        <ul class="children">
                            <li><a href="http://localhost/jijiwatch/index.php/en/incidents/pending"><i class="fa fa-caret-right"></i>Pending</a></li>
                            <li><a href="http://localhost/jijiwatch/index.php/en/incidents/finished"><i class="fa fa-caret-right"></i>Finished</a></li>
                        </ul>
                    </li>
                    <li class="nav-parent"><a href="#"><i class="fa fa-suitcase"></i> <span>Reports</span></a>
                        <ul class="children">
                            <li><a href="http://localhost/jijiwatch/index.php/en/reports/list"><i class="fa fa-caret-right"></i>All Reports</a></li>
                        </ul>
                    </li>
                    <li class="nav-parent"><a href="#"><i class="fa fa-bug"></i> <span>Users</span></a>
                        <ul class="children">
                            <li><a href="http://localhost/jijiwatch/index.php/en/users/admins"><i class="fa fa-caret-right"></i>Admins</a></li>
                            <li><a href="http://localhost/jijiwatch/index.php/en/users/officers"><i class="fa fa-caret-right"></i>Officers</a></li>
                            <li><a href="http://localhost/jijiwatch/index.php/en/register"><i class="fa fa-caret-right"></i>Add user</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- leftpanelinner -->
        </div><!-- leftpanel -->
    </div><!-- leftpanel -->

    <div class="mainpanel">

        <div class="headerbar">
            <a class="menutoggle"><i class="fa fa-bars"></i></a>
            <div class="header-right">
                <ul class="headermenu">
                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                Account
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                <li><a href="http://localhost/jijiwatch/index.php/en/logout"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div><!-- header-right -->
        </div><!-- header-right -->
        <div>

        <div class="contentpanel">
            <div class="panel  panel-default">
                <div class="panel-body" style="padding: 5px;">
                    <!-- Map -->
                    <div id="map" style="height: 700px"></div>

                    <!-- Table -->
                    <div class="container" id="dataTable">
                        <div id="myToolbar">
                            <button id="mapSelected" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Click to Map Selected row(s)"><span class="glyphicon glyphicon-pushpin"></span> Map Selected Row(s)</button>
                            <button id="hideTable" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Click to Hide the table"><span class="glyphicon glyphicon-arrow-down"></span> Hide Table</button>
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
                    <div id="search"></div>

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
                                                <td><input id="geofence" type="checkBox" class="checkBox" /><label for="checkBox"></label></td>
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
                </div><!-- panel-body -->
            </div><!-- panel -->

        </div><!-- contentpanel -->

        </div><!-- mainpanel -->

</section>
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
<script src="<?php echo base_url('components/js/jquery-1.11.1.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/custom.js');?>"></script>
<script src="<?php echo base_url('components/js/bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('components/src/js/bootstrap-table.js');?>"></script>
<script src="<?php echo base_url('components/src/js/extensions/toolbar/bootstrap-table-toolbar.js');?>"></script>
<script src="<?php echo base_url('components/src/js/mapscript.js');?>"></script>
<script src="<?php echo base_url('components/js/jquery-migrate-1.2.1.min.js');?>"></script>
<script src="<?php echo base_url('components/js/modernizr.min.js');?>"></script>
</body>
</html>
