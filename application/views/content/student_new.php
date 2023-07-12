<?php $objCI =& get_instance(); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">            
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Student New Entry Form</h6>
                    <?php if ($objCI->session->userdata('role') !='operator'): ?>
                    <a href="<?=site_url("dashboard/students");?>"><button type="button"
                            class="btn btn-sm btn-primary m-2">Student List</button></a>
                   <?php endif;?>
                </div>
                <form name="frmStudentNew" id="frmStudentNew" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="student_name" name="student_name"
                            placeholder="Student Name" />
                        <label for="student_name">Student Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                            placeholder="Mobile No" />
                        <label for="mobile_no">Mobile No</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="batch_no" name="batch_no"
                            aria-label="Floating label select">
                            <option value="">Batch</option>
                            <?php foreach ($batches as  $batch) : ?>
                            <option value="<?=$batch->id;?>"><?=$batch->batch_name;?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="role">Select Batch</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="address" name="address" placeholder="Address"
                            style="height: 150px;"></textarea>
                        <label for="address">Address</label>
                    </div>
                    <div class="d-flex align-items-start py-10">
                        <div class="nav flex-column nav-pills me-3 mb-5 mt-3" id="finger-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active" id="finger1-tab" data-bs-toggle="pill"
                                data-bs-target="#finger1" type="button" role="tab" aria-controls="finger1"
                                aria-selected="true">Image1</button>
                            <button class="nav-link" id="finger2-tab" data-bs-toggle="pill" data-bs-target="#finger2"
                                type="button" role="tab" aria-controls="finger2" aria-selected="true">Image2</button>
                            <button class="nav-link" id="finger3-tab" data-bs-toggle="pill" data-bs-target="#finger3"
                                type="button" role="tab" aria-controls="finger3" aria-selected="true">Image3</button>
                            <button class="nav-link" id="finger4-tab" data-bs-toggle="pill" data-bs-target="#finger4"
                                type="button" role="tab" aria-controls="finger4" aria-selected="true">Image4</button>
                            <button class="nav-link" id="finger5-tab" data-bs-toggle="pill" data-bs-target="#finger5"
                                type="button" role="tab" aria-controls="finger5" aria-selected="true">Image5</button>
                        </div>
                        <div class="tab-content" id="finger-tabContent">
                            <div class="tab-pane fade show active" id="finger1" role="tabpanel"
                                aria-labelledby="finger1-tab">
                                <img id="imgFinger1" width="145px" height="188px" Falt="Finger Image" class="padd_top"
                                    style="margin:auto" src="<?=SITE_URL;?>media/img/image-capture.png" />
                                <input type="hidden" name="finger1Value" id="finger1Value" value="">
                                <button type="button" class="btn btn-success rounded-pill m-2"
                                    onclick="captureFinger(1);">Capture Image</button>
                            </div>
                            <div class="tab-pane fade show" id="finger2" role="tabpanel" aria-labelledby="finger2-tab">
                                <img id="imgFinger2" width="145px" height="188px" Falt="Finger Image" class="padd_top"
                                    style="margin:auto" src="<?=SITE_URL;?>media/img/image-capture.png" />
                                <input type="hidden" name="finger2Value" id="finger2Value">
                                <button type="button" class="btn btn-success rounded-pill m-2"
                                    onclick="captureFinger(2);">Capture Image</button>
                            </div>
                            <div class="tab-pane fade show" id="finger3" role="tabpanel" aria-labelledby="finger3-tab">
                                <img id="imgFinger3" width="145px" height="188px" Falt="Finger Image" class="padd_top"
                                    style="margin:auto" src="<?=SITE_URL;?>media/img/image-capture.png" />
                                <input type="hidden" name="finger3Value" id="finger3Value">
                                <button type="button" class="btn btn-success rounded-pill m-2"
                                    onclick="captureFinger(3);">Capture Image</button>
                            </div>
                            <div class="tab-pane fade show" id="finger4" role="tabpanel" aria-labelledby="finger4-tab">
                                <img id="imgFinger4" width="145px" height="188px" Falt="Finger Image" class="padd_top"
                                    style="margin:auto" src="<?=SITE_URL;?>media/img/image-capture.png" />
                                <input type="hidden" name="finger4Value" id="finger4Value">
                                <button type="button" class="btn btn-success rounded-pill m-2"
                                    onclick="captureFinger(4);">Capture Image</button>
                            </div>
                            <div class="tab-pane fade show" id="finger5" role="tabpanel" aria-labelledby="finger5-tab">
                                <img id="imgFinger5" width="145px" height="188px" Falt="Finger Image" class="padd_top"
                                    style="margin:auto" src="<?=SITE_URL;?>media/img/image-capture.png" />
                                <input type="hidden" name="finger5Value" id="finger5Value">
                                <button type="button" class="btn btn-success rounded-pill m-2"
                                    onclick="captureFinger(5);">Capture Image</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-15">
                        <div id="user_success"></div>
                        <div id="fileprogress" class="pg-bar mb-3"></div>
                        <button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary">Submit
                            Information</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>