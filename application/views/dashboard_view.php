<?php
/**
 * Created by PhpStorm.
 * User: miles
 * Date: 7/5/16
 * Time: 3:26 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo  base_url('components/images/favicon.ico');?>" type="image/png">

    <title>Jijiwatch</title>

    <link href="<?php echo  base_url('components/css/style.default.css" rel="stylesheet');?>">

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
                        <h4>Miles Obadiah</h4>
                    </div>
                </div>

                <h5 class="sidebartitle actitle">Account</h5>
                <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                    <li><a href="profile.html"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
                    <li><a href="#"><i class="fa fa-question-circle"></i> <span>Help</span></a></li>
                    <li><a href="signout.html"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>

            <h5 class="sidebartitle">Navigation</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket">
                <li class="active"><a href="#"><i class="fa fa-home"></i> <span>Map View</span></a></li>
                <li class="nav-parent"><a href="#"><i class="fa fa-edit"></i> <span>Incidents</span></a>
                    <ul class="children">
                        <li><a href="general-forms.html"><i class="fa fa-caret-right"></i>All Incidents</a></li>
                        <li><a href="form-layouts.html"><i class="fa fa-caret-right"></i>Pending</a></li>
                        <li><a href="form-validation.html"><i class="fa fa-caret-right"></i>Finished</a></li>
                        <li><a href="form-wizards.html"><i class="fa fa-caret-right"></i>Active</a></li>
                        <li><a href="form-wizards.html"><i class="fa fa-caret-right"></i>Export</a></li>
                    </ul>
                </li>
                <li class="nav-parent"><a href="#"><i class="fa fa-suitcase"></i> <span>Reports</span></a>
                    <ul class="children">
                        <li><a href="buttons.html"><i class="fa fa-caret-right"></i>All Reports</a></li>
                        <li><a href="icons.html"><i class="fa fa-caret-right"></i>Bar Graph</a></li>
                        <li><a href="typography.html"><i class="fa fa-caret-right"></i>Pie Chart</a></li>
                        <li><a href="alerts.html"><i class="fa fa-caret-right"></i>Export</a></li>
                    </ul>
                </li>
                <li class="nav-parent"><a href="#"><i class="fa fa-bug"></i> <span>Users</span></a>
                    <ul class="children">
                        <li><a href="bug-tracker.html"><i class="fa fa-caret-right"></i>Admins</a></li>
                        <li><a href="bug-issues.html"><i class="fa fa-caret-right"></i>Officers</a></li>
                        <li><a href="view-issue.html"><i class="fa fa-caret-right"></i>Add user</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- leftpanelinner -->
    </div><!-- leftpanel -->

    <div class="mainpanel">

        <div class="headerbar">

            <a class="menutoggle"><i class="fa fa-bars"></i></a>

            <form class="searchform" action="http://themepixels.com/demo/webpage/bracket/index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="Search incidents..." />
            </form>

            <div class="header-right">
                <ul class="headermenu">
                    <li>
                        <div class="btn-group">
                            <button class="btn btn-default dropdown-toggle tp-icon" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-globe"></i>
                                <span class="badge">5</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-head pull-right">
                                <h5 class="title">You Have 5 Pending tasks</h5>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                John Doe
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Account Settings</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                                <li><a href="signin.html"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div><!-- header-right -->
            <div>
                <!--Put your shit here -->
            </div>

        </div><!-- headerbar -->

    </div><!-- mainpanel -->



</section>


<script src="<?php echo  base_url('components/js/jquery-1.11.1.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery-migrate-1.2.1.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery-ui-1.10.3.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/bootstrap.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/modernizr.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery.sparkline.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/toggles.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/retina.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery.cookies.js');?>"></script>

<script src="<?php echo  base_url('components/js/flot/jquery.flot.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/flot/jquery.flot.resize.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/flot/jquery.flot.spline.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/morris.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/raphael-2.1.0.min.js');?>"></script>

<script src="<?php echo  base_url('components/js/custom.js');?>"></script>
<script src="<?php echo  base_url('components/js/dashboard.js');?>"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-55586762-1', 'auto');
    ga('send', 'pageview');

</script>

</body>


</html>

