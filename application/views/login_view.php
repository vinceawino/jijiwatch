<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Miles">
    <link rel="shortcut icon" href="<?php echo base_url('components/images/favicons/favicon.ico');?>" type="image/png">

    <title>Jijiwatch</title>

    <link href="<?php echo base_url('components/css/style.default.css');?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('components/js/html5shiv.js');?>"></script>
    <script src="<?php echo base_url('components/js/respond.min.js');?>"></script>
    <![endif]-->
</head>

<body class="signin">


<section>

    <div class="signinpanel">

        <div class="row">

            <div class="col-md-7">

                <div class="signin-info">
                    <div class="logopanel">
                        <h1><img  width="200px" height="200px" src="<?php echo base_url('components/images/ncclogo.png');?>"></h1>
                    </div><!-- logopanel -->

                    <div class="mb20"></div>

                    <h5><strong>Welcome to Jijiwatch</strong></h5>
                </div><!-- signin0-info -->

            </div><!-- col-sm-7 -->

            <div class="col-md-5">

                <?php echo form_open('index.php/en/login',array("id"=>"basicForm4")); ?>
                    <h4 class="nomargin">Sign In</h4>
                    <p class="mt5 mb20">Login to access your account.</p>
                    <?php if(isset($message)): ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $message;?>
                        </div>
                    <?php endif; ?>
                    <input type="text" name="username" class="form-control uname" placeholder="Username" />
                    <input type="password" name="password" class="form-control pword" placeholder="Password" />
                    <a href="#"><small>Forgot Your Password?</small></a>
                    <button type="submit" class="btn btn-success btn-block">Sign In</button>

                </form>
            </div><!-- col-sm-5 -->

        </div><!-- row -->

        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2016. All Rights Reserved. <a href="http://beatbox.co.ke">Jijiwatch</a> Ltd.
            </div>
        </div>

    </div><!-- signin -->

</section>


<script src="<?php echo base_url('components/js/jquery-1.11.1.min.js'); ?>"></script>
<script src="<?php echo base_url('components/js/jquery-migrate-1.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('components/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('components/js/modernizr.min.js'); ?>"></script>
<script src="<?php echo base_url('components/js/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo base_url('components/js/jquery.cookies.js'); ?>"></script>

<script src="<?php echo base_url('components/js/toggles.min.js'); ?>"></script>
<script src="<?php echo base_url('components/js/retina.min.js'); ?>"></script>

<script src="<?php echo base_url('components/js/custom.js'); ?>"></script>

<script>
    jQuery(document).ready(function(){

        // Please do not use the code below
        // This is for demo purposes only
        var c = jQuery.cookie('change-skin');
        if (c && c == 'greyjoy') {
            jQuery('.btn-success').addClass('btn-orange').removeClass('btn-success');
        } else if(c && c == 'dodgerblue') {
            jQuery('.btn-success').addClass('btn-primary').removeClass('btn-success');
        } else if (c && c == 'katniss') {
            jQuery('.btn-success').addClass('btn-primary').removeClass('btn-success');
        }
    });
</script>

</body>


</html>