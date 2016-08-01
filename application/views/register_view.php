<?php
/**
 * Created by PhpStorm.
 * User: miles
 * Date: 7/5/16
 * Time: 2:10 PM
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
    <link rel="shortcut icon" href="<?php echo base_url('components/images/favicon.ico');?>" type="image/png">

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
    <div class="signuppanel">

        <div class="row">

            <div class="col-md-6">

                <div class="signup-info">
                    <div class="logopanel">
                        <h1><img  width="200px" height="200px" src="<?php echo base_url('components/images/ncclogo.png');?>"></h1>
                    </div><!-- logopanel -->

                    <div class="mb20"></div>

                    <h5><strong>Welcome to Jijiwatch</strong></h5>

                </div><!-- signup-info -->

            </div><!-- col-sm-6 -->

            <div class="col-md-6">
                <?php echo form_open('index.php/en/register',array("id"=>"basicForm4")); ?>
                    <h3 class="nomargin">Add a new user</h3>
                    <?php if(isset($message)): ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $message;?>
                        </div>
                    <?php endif; ?>
                    <label class="control-label">Name</label>
                    <div class="row mb10">
                        <div class="col-sm-6">
                            <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" class="form-control" placeholder="Firstname" />
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" class="form-control" placeholder="Lastname" />
                        </div>
                    </div>

                    <div class="mb10">
                        <label class="control-label">Username</label>
                        <input type="text" name="username" value="<?php echo set_value('username'); ?>" class="form-control" />
                    </div>

                    <div class="mb10">
                        <label class="control-label">Password</label>
                        <input type="password" value="<?php echo set_value('password'); ?>" name="password" class="form-control" />
                    </div>
                    <div class="mb10">
                        <label class="control-label">Retype Password</label>
                        <input type="password" value="<?php echo set_value('verify_password'); ?>" name="verify_password" class="form-control" />
                    </div>

                    <label class="control-label">Account Type</label>
                    <div class=" row mb10">
                        <div class="col-sm-12">
                            <select class="select2" name="account_type" data-placeholder="Month">
                                <?php if(isset($accounts)): foreach($accounts as $account): ?>
                                    <option value="<?php echo $account->id; ?>"><?php echo $account->description; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb10">
                        <label class="control-label">Email Address</label>
                        <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" />
                    </div>

                    <div class="mb10">
                        <label class="control-label">Address</label>
                        <input type="text" name="address" value="<?php echo set_value('address'); ?>" class="form-control" />
                    </div>

                    <div class="mb10">
                        <label class="control-label">Phone</label>
                        <input type="text" name="phone" value="<?php echo set_value('phone'); ?>" class="form-control" />
                    </div>

                    <div class="mb10">
                        <label class="control-label">ID number</label>
                        <input type="text" name="idnumber" value="<?php echo set_value('idnumber'); ?>" class="form-control" />
                    </div>

                    <div class="mb10">
                        <label class="control-label">Jurisdiction</label>
                        <select class="select2-2" name="jurisdiction" data-placeholder="Choose a region...">
                            <?php if(isset($jurisdictions)): foreach($jurisdictions as $jurisdiction): ?>
                                <option value="<?php echo $jurisdiction->id; ?>"><?php echo $jurisdiction->name; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <br />

                    <button type="submit" class="btn btn-success btn-block">Sign Up</button>
                </form>
            </div><!-- col-sm-6 -->

        </div><!-- row -->

        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2016. All Rights Reserved. Jijiwatch
            </div>
        </div>

    </div><!-- signuppanel -->

</section>


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.cookies.js"></script>

<script src="js/toggles.min.js"></script>
<script src="js/retina.min.js"></script>

<script src="js/select2.min.js"></script>

<script src="js/custom.js"></script>
<script>
    jQuery(document).ready(function(){

        jQuery(".select2").select2({
            width: '100%',
            minimumResultsForSearch: -1
        });

        jQuery(".select2-2").select2({
            width: '100%'
        });
        jQuery("#basicForm4").validate({
            highlight: function(element) {
                jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                jQuery(element).closest('.form-group').removeClass('has-error');
            }
        });
        jQuery('#first_name,#last_name').on('keyup keypress blur change',function(){
            $('#username').val($('#first_name').val()+' '+$('#last_name').val());
        })

    });
</script>

</body>


</html>
