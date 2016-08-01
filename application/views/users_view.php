<div  style="padding-top: 30px;" class="col-md-12">
    <div class="col-md-12">
        <h5 class="subtitle mb5"><?php if(isset($type)): echo $type?><?php endif;?></h5>
        <div class="table-responsive">
            <table class="table mb30">
                <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Username</th>
                    <th>Date created</th>
                    <th>Active</th>
                    <th>Jurisdiction</th>
                    <th>Mobile phone</th>
                    <th>ID number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($users)): foreach($users as $user): ?>
                    <tr class="odd gradeX">
                        <td><?php echo $user->firstname;?></td>
                        <td><?php echo $user->lastname;?></td>
                        <td><?php echo $user->username;?></td>
                        <td><?php echo $user->date_created;?></td>
                        <td><?php echo $user->active==1?'Inactive':'Active'; ?></td>
                        <td><?php echo $user->jurisdiction;?></td>
                        <td><?php echo $user->mobile_phone;?></td>
                        <td><?php echo $user->idnumber;?> </td>
                        <td><?php echo $user->email;?> </td>
                        <td><?php echo $user->address;?> </td>
                        <td class="table-action">
                            <a href="http://localhost/jijiwatch/index.php/en/users/<?php echo $user->id;?>"><i class="fa fa-pencil"></i></a>
                            <a href="http://localhost/jijiwatch/index.php/en/delete/<?php echo $user->id;?>" class="delete-row"><i class="fa fa-trash-o"></i></a>
                        </td>

                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- col-md-6 -->
</div>