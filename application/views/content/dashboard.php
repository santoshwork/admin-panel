<?php $objCI =& get_instance(); ?>
                <div class="row g-4">
                <?php if ($objCI->session->userdata('role') !='operator'): ?>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Batches</p>
                                <h6 class="mb-0"><?=$total_batches;?></h6>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if ($objCI->session->userdata('role') =='admin'): ?>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Users</p>
                                <h6 class="mb-0"><?=$total_users;?></h6>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Images</p>
                                <h6 class="mb-0"><?=($total_images*5);?></h6>
                            </div>
                        </div>
                    </div>
                    <?php if ($objCI->session->userdata('role') =='distributor'): ?>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Pending Batches</p>
                                <h6 class="mb-0"><?=$total_pending_batches;?></h6>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <!-- Sale & Revenue End -->
            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                <?php if($objCI->session->userdata('role')=="admin"):?>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Recent Logins</h6>
                            </div>
                            <?php foreach ($recent_logins as  $recent_login) : ?>
                            <div class="d-flex align-items-center border-bottom py-3">                                
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0"><?=$recent_login->username;?></h6>
                                        <small><?=$recent_login->login_time;?></small>
                                        <small><?=$recent_login->ip_address;?></small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>                                                    
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <a href="">Show All</a>
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>                   
                </div>
           