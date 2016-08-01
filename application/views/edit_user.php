<div class="contentpanel">
    <div class="col-md-12">
        <?php echo form_open('index.php/en/updateUser',array("id"=>"basicForm4")); ?>
        <?php if(isset($user)):?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php if(isset($message)): ?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $message;?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-6">
                        <label class="control-label">First Name</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" title="First name is required!" placeholder="Type first name..." value="<?php echo $user->firstname; ?>" required/>
                        <label class="error" for="orgname"></label>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Last Name</label>
                        <input type="text" name="lastname" class="form-control" title="Last name is required!" placeholder="Type last name..." value="<?php echo $user->lastname; ?>" required />
                        <label class="error" for="lastname"></label>
                    </div>
                </div><!-- form-group -->

                <div class="form-group">
                    <div class="col-sm-6">
                        <label class="control-label">Username</label>
                        <input type="text" name="username" readonly="readonly" class="form-control" title="Username is required!" placeholder="Type Username..." value="<?php echo $user->username; ?>" required />
                        <label class="error" for="username"></label>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">ID Number</label>
                        <input type="text" name="idnumber" class="form-control" title="ID number is required!" placeholder="Type ID number..." value="<?php echo $user->idnumber; ?>" required />
                        <label class="error" for="idnumber"></label>
                    </div>
                </div><!-- form-group -->

                <div class="form-group">
                    <div class="col-sm-6">
                        <label class="control-label">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" title="Mobile Number is required!" placeholder="Type Mobile Number..." value="<?php echo $user->idnumber; ?>" required />
                        <label class="error" for="mobile"></label>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Email</label>
                        <input type="text"  name="email" class="form-control" value="<?php echo $user->email;?>" placeholder="Type Email..."/>
                    </div>
                </div><!-- form-group -->

                <div class="panel-heading">
                    <p>Other Details</p>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <label class="control-label">Jurisdiction</label>
                        <select id="jurisdiction" name="jurisdiction" class="select2" title="Jurisdiction name is required!" data-placeholder="Choose jurisdiction">
                            <?php if(isset($jurisdictions)): foreach($jurisdictions as $jurisdiction): ?>
                                <option value="<?php echo $jurisdiction->id; ?>"><?php echo $jurisdiction->name; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                        <label class="error" for="jurisdiction"></label>
                    </div>

                    <div class="col-sm-6">
                        <label class="control-label">User ID</label>
                        <input type="text" id="userid" name="userid" class="form-control" title="User id" readonly="readonly" placeholder="User id..." value="<?php echo $user->id; ?>" required />
                        <label class="error" for="status"></label>
                    </div>
                </div><!-- form-group -->
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button  class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div><!-- panel-footer -->

        </div><!-- panel -->
        <?php endif;?>
        </form>
    </div><!-- col-md-6 -->
</div><!-- panel -->


<script>
    jQuery(document).ready(function(){

        "use strict";

        // Select2
        jQuery(".select2").select2({
            width: '100%',
            //minimumResultsForSearch: -1
        });

        $(document.body).on('change','#organization',function(){
            var orgtype=$(this).find(':selected').data('orgtype');
            $('#organization_type').val(orgtype);
        });

        // Validation with select boxes
        jQuery("#basicForm4").validate({
            highlight: function(element) {
                jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                jQuery(element).closest('.form-group').removeClass('has-error');
            }
        });



    });
</script>