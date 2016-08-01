<div>
    <div class="table-responsive">
        <table class="table table-striped" id="table2">
            <thead>
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Time</th>
                <th>Status</th>
                <th>Officer in charge</th>
                <th>Contact phone</th>
                <th>Image attached</th>
                <th>Your report</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $imageNumber ='';?>
            <?php if(isset($incidents)): foreach($incidents as $incident): ?>
            <tr class="odd gradeX">
                <td><?php echo $incident->incident_type;?></td>
                <td><?php echo $incident->description;?></td>
                <td><?php echo $incident->recordtime;?></td>
                <td> <?php echo $incident->status==0?'Finished':'Pending'; ?></td>
                <td>Not assigned</td>
                <td><?php echo $incident->phone;?></td>
                <td><?php echo anchor('index.php/en/image/'.$incident->upload,'View',array('data-placement'=>"top",'data-toggle'=>'modal','data-target'=>'#'.$incident->id)); ?>
                </td>
                <div class="modal fade" id="<?php echo $incident->id;?>"  role="dialog">
                    <div class="modal-dialog modal-photo-viewer">
                        <div class="modal-content">
                            <img width="100%" height="100%" src="<?php echo base_url('uploads/'.$incident->upload);?>" alt="Image">
                        </div>
                    </div>
                </div>
                <td><?php echo anchor('index.php/en/reports/'.$incident->report_id,'View',array('data-placement'=>"top",'data-toggle'=>'tooltip','class'=>'tooltips','data-original-title'=>'View your report')); ?>
                </td>
                <td><?php echo $incident->jurisdiction;?></td>
                <td>
                    <?php echo anchor('index.php/en/incidents/'.$incident->id,'Dispatch',array('data-placement'=>"top",'data-toggle'=>'tooltip','class'=>'tooltips','data-original-title'=>'Dispatch officer')); ?>
                </td>

            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
   
    
</div>