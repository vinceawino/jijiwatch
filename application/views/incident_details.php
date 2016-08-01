<div class="contentpanel" style="padding-top: 50px;">
        <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Select Officer</h4>
            </div>
            <div class="panel-body panel-body-nopadding">
                <?php echo form_open('index.php/en/dispatch',array("id"=>"basicForm4")); ?>
                    <?php if(isset($message)): ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $message;?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Officer to dispatch</label>
                        <div class="col-sm-5">
                            <select name="officer_id" class="form-control input-lg">
                                <?php if(isset($officers)): foreach($officers as $officer): ?>
                                    <option value="<?php echo $officer->user_id; ?>"><?php echo $officer->username; ?></option>
                                <?php endforeach; endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Incident ID</label>
                        <div class="col-sm-5">
                            <input type="text" name="incident_id" class="form-control" value="<?php if(isset($officers)):echo $officers[0]->id; endif;?>" readonly="readonly" placeholder="Not available" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Incident Type</label>
                        <div class="col-sm-5">
                            <input type="text" name="incident_type" class="form-control" value="<?php  if(isset($officers)): echo $officers[0]->incident_type; endif; ?>" readonly="readonly" placeholder="Not available" required />
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <label class="col-sm-3 control-label">Comment</label>
                        <div class="col-sm-7">
                            <textarea name="admin_comment" maxlength="160" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <?php if(isset($officers)): ?>
                                    <button type="submit"  class="btn btn-primary">Dispatch</button>
                                <?php else: ?>
                                    <button type="submit" disabled  class="btn btn-primary">Dispatch</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><!-- panel-footer -->
                </form>
            </div>
        </div>
</div><!-- panel -->
</div><!-- panel -->