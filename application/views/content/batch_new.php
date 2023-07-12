<?php $objCI =& get_instance(); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-8">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">New Batch Entry Form</h6>
                    <a href="<?=site_url("dashboard/batches");?>"><button type="button"
                            class="btn btn-sm btn-primary m-2">Batch List</button></a>
                </div>
                <form name="frmNewBatch" id="frmNewBatch" method="post" enctype="multipart/form-data">   
                <?php if ($objCI->session->userdata('role') =='admin'): ?>                 
                    <div class="form-floating mb-3">
                        <select class="form-select" id="user" name="user"
                            aria-label="Floating label select">
                            <option value="">Select User</option>
                            <?php foreach ($users as  $user) : ?>
                            <option value="<?=$user->id."##".$user->username;?>"><?=$user->first_name." ".$user->last_name."(".$user->username.")";?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="role">Select Users</label>
                    </div>
                <?php endif;?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="batch_name" name="batch_name"
                            placeholder="Batch Name" />
                        <label for="mobile">Batch Name</label>
                    </div>                  
                               
                    <div class="my-15">
                        <div id="user_success"></div>
                        <button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary">Submit
                            Information</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>