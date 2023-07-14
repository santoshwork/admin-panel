<?php $objCI =& get_instance(); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-8">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">User New Entry Form</h6>
                    <a href="<?=site_url("dashboard/users");?>"><button type="button"
                            class="btn btn-sm btn-primary m-2">Users List</button></a>
                </div>
                <form name="frmNewUser" id="frmNewUser" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Username" autocomplete="off" />
                        <label for="username">Username</label>
                    </div>                    
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" />
                        <label for="password">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" />
                        <label for="email">Email</label>
                    </div>
                    <div class="mb-3">
                        <label for="user_photo" class="form-label">Upload profile photo</label>
                        <input class="form-control form-control-sm bg-dark" id="user_photo" name="user_photo" type="file">
                        <span class="image_error_user_photo"></span>                        
                        <div class="user-photo" id="user-photo"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="role" name="role"
                            aria-label="Floating label select">
                            <option selected>Select Role</option>
                            <option value="distributor">Distributor</option>
                            <option value="operator">Operator</option>
                        </select>
                        <label for="role">User Role</label>
                    </div>
                    <div class="form-floating mb-3 distributor-select" style="display:none;">
                        <select class="form-select" id="distributor" name="distributor"
                            aria-label="Floating label select">
                            <?php foreach ($distributors as  $distributor) : ?>
                                <option value="<?=$distributor->id;?>"><?=$distributor->first_name.' '.$distributor->last_name;?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="role">Select Distributor</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="mobile" name="mobile"
                            placeholder="Mobile" />
                        <label for="mobile">Mobile</label>
                    </div>                    
                    <div class="form-floating mb-3 allow-students" style="display:none;">
                        <input type="number" class="form-control" id="total_allow_students" name="total_allow_students"
                            placeholder="Allow Batch" value="1" />
                        <label for="mobile">No of Allow Students</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="editoption" name="editoption"
                            aria-label="Floating label select">
                            <option value="Y">Yes</option>
                            <option value="N" selected>No</option>
                        </select>
                        <label for="role">Allow Edit</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="deleteoption" name="deleteoption"
                            aria-label="Floating label select">
                            <option value="Y">Yes</option>
                            <option value="N" selected>No</option>
                        </select>
                        <label for="role">Allow Delete</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="active" name="active"
                            aria-label="Floating label select">
                            <option value="Y" selected>Yes</option>
                            <option value="N">No</option>
                        </select>
                        <label for="role">Active</label>
                    </div>                   
                    <div class="my-15">
                        <div id="user_success"></div>
                        <div id="fileprogress" class="pg-bar mb-3"></div>
                        <input type="hidden" name="added_by" value="<?=$objCI->session->userdata('username');?>" />
                        <button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary">Submit
                            Information</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>