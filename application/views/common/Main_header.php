<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo  base_url('components/images/favicon.ico');?>" type="image/png">

    <title>Jijiwatch</title>
    <script src="<?php echo  base_url('components/js/jquery-1.11.1.min.js');?>"></script>
    <link href="<?php echo base_url('components/css/style.default.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('components/css/jquery.datatables.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('components/css/jquery.tagsinput.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('components/css/jquery.gritter.css'); ?>" rel="stylesheet" />
     <link rel="stylesheet" href="<?php echo base_url('components/css/bootstrap-timepicker.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('components/css/dropzone.css');?>" />
    <link href="<?php echo base_url('components/css/morris.css');?>" rel="stylesheet"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo  base_url('components/js/html5shiv.js');?>"></script>
    <script src="<?php echo  base_url('components/js/respond.min.js');?>"></script>
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
                     <li><a href="http://localhost/jijiwatch/index.php/en/login"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>

            <h5 class="sidebartitle">Navigation</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket">
                <li class="active"><a href="http://localhost/jijiwatch/index.php/en/map_view"><i class="fa fa-home"></i> <span>Map View</span></a></li>
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
            <div>