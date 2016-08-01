<div class="contentpanel">
	<div class="col-md-12">
      <?php echo form_open('users/adduser',array("id"=>"basicForm4")); ?>
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
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <label class="control-label">Organization</label>
                <select id="organization" name="organization" class="select2" required data-placeholder="Choose One">
                  <option value=""></option>
                  <?php if(isset($organizations)): foreach($organizations as $organization): ?>
                  <option value="<?php echo $organization->id; ?>"><?php echo $organization->name; ?></option>
              	  <?php endforeach; endif; ?>
                </select>
                <label class="error" for="organization"></label>
              </div>
              <div class="col-sm-6">
                <label class="control-label">Job Title</label>
                <input type="text" name="job_title" class="form-control" title="Your name is required!" placeholder="Type your job title..." required/>
                <label class="error" for="job_title"></label>
              </div>
            </div><!-- form-group -->
            
            <div class="form-group">
              <div class="col-sm-6">
                <label class="control-label">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" title="Your first name is required!" placeholder="Type your first name..." required/>
                <label class="error" for="first_name"></label>
              </div>
              <div class="col-sm-6">
                <label class="control-label">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" title="Your last name is required!" placeholder="Type your last name..." required />
                <label class="error" for="last_name"></label>
              </div>
            </div><!-- form-group -->

            <div class="form-group">
              <div class="col-sm-6">
                <label class="control-label">Email</label>
                <input type="email" name="email" class="form-control" title="Your email is required!" placeholder="Type your email..." required />
                <label class="error" for="email"></label>
              </div>
              <div class="col-sm-6">
                <label class="control-label">Address</label>
                <input type="text" name="address" class="form-control" title="Your address is required!" placeholder="Type your address..." required />
                <label class="error" for="address"></label>
              </div>
            </div><!-- form-group -->

            <div class="form-group">
              <div class="col-sm-6">
                <label class="control-label">Phone</label>
                <input type="text" name="phone" class="form-control" title="Your phone is required!" placeholder="Type your phone..." required />
                <label class="error" for="phone"></label>
              </div>
              <div class="col-sm-6">
                <label class="control-label">Web page</label>
                <input type="url" name="webpage" class="form-control" placeholder="Type your web page..." />
              </div>
            </div><!-- form-group -->

            <div class="form-group">
              <div class="col-sm-6">
                <label class="control-label">Postal Code</label>
                <input type="text" name="postal_code" class="form-control" title="Your postal code is required!" placeholder="Type your postal code..." required />
                <label class="error" for="postal_code"></label>
              </div>
              <div class="col-sm-6">
                <label class="control-label">Username</label>
                <input type="text" id="username" name="username" readonly="" class="form-control" title="Your username is required!" placeholder="Your username..." required />
                <label class="error" for="username"></label>
              </div>
            </div><!-- form-group -->
          </div><!-- panel-body -->
          
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-9 col-sm-offset-3">
                <button class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-default">Reset</button>
              </div>
            </div>
          </div><!-- panel-footer -->

      </div><!-- panel -->
      </form>
     </div><!-- col-md-6 -->
</div><!-- panel -->

<script>
jQuery(document).ready(function(){
    
    "use strict";
    
    // Select2
  jQuery(".select2").select2({
    width: '100%',
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

  jQuery('#first_name,#last_name').on('keyup keypress blur change',function(){
    $('#username').val($('#first_name').val()+' '+$('#last_name').val());
  })
  
  
});
</script>