<div  style="padding-top: 30px;" class="col-md-12">
    <div class="col-md-12">
        <h5 class="subtitle mb5">Your reports</h5>
        <div class="table-responsive">
            <table class="table mb30">
                <thead>
                <tr>
                    <th>Incident</th>
                    <th>Date created</th>
                    <th>Last edited</th>
                    <th>Admin report</th>
                    <th>Officer report</th>
                    <th>Status</th>
                    <th>Officer</th>
                    <th>Admin</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($reports)): foreach($reports as $report): ?>
                    <tr class="odd gradeX">
                        <td><?php echo $report->description;?></td>
                        <td><?php echo $report->date_created;?></td>
                        <td><?php echo $report->last_edited;?></td>
                        <td><?php echo $report->admin_report;?></td>
                        <td><?php echo $report->officer_report;?></td>
                        <td> <?php echo $report->status==0?'Finished':'Pending'; ?></td>
                        <td><?php echo $report->officer_id;?></td>
                        <td><?php echo $report->admin_id;?> </td>
                        <td class="table-action">
                            <a href="http://localhost/jijiwatch/index.php/en/reports/<?php echo $report->id;?>"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- col-md-6 -->
</div>