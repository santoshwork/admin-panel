<?php $objCI =& get_instance(); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Users List</h6>
                    <a href="<?=site_url("dashboard/user_new");?>"><button type="button"
                            class="btn btn-sm btn-primary m-2">Add New User</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table" id="userList">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Active</th>
                                <th scope="col">Allowed Students</th>
                                <th scope="col">Permissions</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as  $user) : ?>
                            <tr>
                                <th scope="row"><?=$user->id;?></th>
                                <td><?=$user->first_name." ".$user->last_name;?></td>
                                <td><?=$user->username;?><br />
                                    Role: <?=$user->role;?><br />
                                    Last Login: <?=$user->lastlogin;?></td>
                                <td><?=$user->email;?></td>
                                <td><?=$user->mobile;?></td>
                                <td><?=$user->active;?></td>
                                <td><?=$user->total_allow_students;?></td>
                                <td>Edit: <?=$user->editoption;?><br />
                                    Delete: <?=$user->deleteoption;?></td>
                                <td><button type="button" class="btn btn-square btn-success m-2"
                                        onclick="editUser('<?=$user->id;?>');"><i class="fa fa-edit"></i></button>
                                    <?php if($user->id != 1):?>
                                    <button type="button" class="btn btn-square btn-primary m-2"
                                        onclick="deleteUser('<?=$user->id;?>');"><i class="fa fa-times"></i></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="bg-secondary rounded modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="frmEditUser" id="frmEditUser" method="post" enctype="multipart/form-data">
                <div class="modal-body row g-2">
                    <div class="col-sm-12 col-xl-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                placeholder="First Name" />
                            <label for="first_name">First Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                placeholder="Last Name" />
                            <label for="last_name">Last Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" autocomplete="off" />
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="user_email" name="user_email"
                                placeholder="Email" />
                            <label for="email">Email</label>
                        </div>
                        <div class="mb-3">
                            <label for="user_photo" class="form-label">Upload profile photo</label>
                            <input class="form-control form-control-sm bg-dark" id="user_photo" name="user_photo"
                                type="file">
                            <span class="image_error_user_photo"></span>
                            <div class="user-photo" id="user-photo"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" />
                            <label for="mobile">Mobile</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="total_allow_students" name="total_allow_students"
                                placeholder="Allow Batch" />
                            <label for="mobile">No of Allow Students</label>
                        </div>                       
                        <div class="form-floating mb-3">
                            <select class="form-select" id="active" name="active" aria-label="Floating label select">
                                <option value="Y" selected>Yes</option>
                                <option value="N">No</option>
                            </select>
                            <label for="role">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit" name="submit" value="Update changes">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>