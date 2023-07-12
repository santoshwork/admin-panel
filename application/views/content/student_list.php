<?php $objCI =& get_instance(); 
$role = $objCI->session->userdata('role');
?>

<div class="container-fluid pt-4 px-2">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-2">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Students List</h6>
                    <div class="form-floating mb-2">
                                <select class="form-select" id="batch_no" name="batch_no" aria-label="Floating label select">
                                    <option value="">Batch</option>
                                    <?php foreach ($batches as  $batch) : ?>
                                    <option value="<?=$batch->batch_name;?>"><?=$batch->batch_name;?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="role">Select Batch</label>
                            </div>
                    <?php if ($objCI->session->userdata('role') !='distributor'): ?>
                    <a href="<?=site_url("dashboard/student_new");?>"><button type="button"
                            class="btn btn-sm btn-primary m-2">Add New Student</button></a> 
                    <?php endif; ?>                           
                </div>
                
                <div class="table-responsive">
                    <table class="table" id="studentList">
                        <thead>
                            <tr>
                                <th scope="col">Slno</th>
                                <th scope="col">Name</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Photo1</th>
                                <th scope="col">Photo2</th>
                                <th scope="col">Photo3</th>
                                <th scope="col">Photo4</th>
                                <th scope="col">Photo5</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                    $ct=1;
                                    foreach ($students as  $student) : ?>
                            <tr>
                                <td scope="row"><?=$ct;?></td>
                                <td><?=$student->Student_Name;?><br /><?=date("d/m/Y H:i:s",strtotime($student->Date));?>
                                </td>
                                <td><?=$student->Batch_No;?></td>
                                <td><img src="<?=$student->Finger1;?>" class="modify_image" height="100px"
                                        width="100px"></td>
                                <td><img src="<?=$student->Finger2;?>" class="modify_image" height="100px"
                                        width="100px"></td>
                                <td><img src="<?=$student->Finger3;?>" class="modify_image" height="100px"
                                        width="100px"></td>
                                <td><img src="<?=$student->Finger4;?>" class="modify_image" height="100px"
                                        width="100px"></td>
                                <td><img src="<?=$student->Finger5;?>" class="modify_image" height="100px"
                                        width="100px"></td>
                                        
                            </tr>
                            <?php 
                                        $ct++;
                                        endforeach;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="bg-secondary rounded modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form name="frmNewBatch" id="frmNewBatch" method="post" enctype="multipart/form-data">      
      <div class="modal-body">                    
        <div class="form-floating mb-3">
        <select class="form-select" id="edit_batch_no" name="edit_batch_no"
            aria-label="Floating label select">
            <option value="">Batch</option>
            <?php foreach ($batches as  $batch) : ?>
            <option value="<?php echo $batch->id."##".$batch->batch_name."##".$batch->userid;?>"><?=$batch->batch_name;?></option>
            <?php endforeach; ?>
        </select>
        <label for="role">Select Batch</label>
        </div>
        <div class="form-floating mb-3">
            <p class="text-muted" id="edit_student_name" name="edit_student_name"></p>
        </div>        
      </div>
      <div class="modal-footer">
        <input type="hidden" name="edit_student_id" id="edit_student_id" value="">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update_student">Update changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

