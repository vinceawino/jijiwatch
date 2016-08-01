<div class="contentpanel" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12">
        <?php if(isset($report)):?>
        <?php echo form_open('index.php/en/updateReport',array("id"=>"basicForm4")); ?>
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
                 <div class="form-group border-bottom">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">Date</label>
                                <input type="text" id="date" name="date" value="<?php echo $report->date_created; ?>" readonly="readonly" class="form-control" placeholder="Not available" required/>
                                <label class="error" for="orgname"></label>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Last edited</label>
                                <input type="text" name="lastname" class="form-control" value="<?php echo $report->last_edited;?>" readonly="readonly" placeholder="Not available" required />
                                <label class="error" for="lastname"></label>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Status</label>
                                <input type="text" name="gender" class="form-control"  value="<?php echo $report->status==0?'Finished':'Pending'; ?>" readonly="readonly" placeholder="Not available" required />
                                <label class="error" for="gender"></label>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="control-label">Report ID</label>
                                <input type="text" name="report_id" class="form-control"  value="<?php echo $report->id; ?>" readonly="readonly" placeholder="Not available" required />
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">Officer in charge</label>
                                <input type="text" name="entry_time" class="form-control" value="<?php echo $report->officer_id; ?>" readonly="readonly" placeholder="Not available" required />
                            </div>
                        </div>
                    </div>
                </div><!-- form-group -->
                <div class="panel-heading">
                    <p>Reports</p>
                </div>
                <div class="form-group">
                    <div class="col-sm-4">
                        <label class="control-label">Admin Report</label>
                        <?php if ($report->username==$report->admin_id):;?>
                            <input type="text" name="admin_report" class="form-control" value="<?php echo $report->admin_report; ?>" placeholder="Not available" required />
                        <? else: ?>
                            <input type="text" name="admin_report" class="form-control" value="<?php echo $report->admin_report; ?>" placeholder="Not available" required />
                        <?php endif; ?>
                    </div>
                </div><!-- form-group -->

                <div class="form-group">
                    <div class="col-sm-4">
                        <label class="control-label">Officer report</label>
                        <?php if ($report->username==$report->officer_id):;?>
                            <input type="text" name="officer_report" class="form-control" value="<?php echo $report->officer_report; ?>" placeholder="Not available" required />
                        <? else: ?>
                            <input type="text" name="officer_report" class="form-control" value="<?php echo $report->officer_report; ?>" placeholder="Not available" required />
                        <?php endif; ?>
                    </div>
                </div><!-- form-group -->
            </div><!-- panel-body -->
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-9 ">
                        <button  class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div><!-- panel-footer -->
            </div><!-- panel -->
        </form>
        <?php endif;?>
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

    });
</script>