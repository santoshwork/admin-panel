<?php $objCI =& get_instance(); ?>
<div class="container-fluid pt-4 px-4">
                <div class="row g-4">                    
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Batch List</h6>
                                <a href="<?=site_url("dashboard/batch_new");?>"><button type="button" class="btn btn-sm btn-primary m-2">Add New Batch</button></a>
                            </div>                             
                            <div class="table-responsive">
                                <table class="table" id="batchList">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Batch Name</th>
                                            <?php if ($objCI->session->userdata('role') =='admin'): ?>
                                            <th scope="col">Username</th>
                                            <th scope="col">Created By</th> 
                                            <th scope="col">Active</th>
                                            <?php endif; ?>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ct=0;
                                    foreach ($batches as  $batch) : 
                                        $ct++;
                                        ?>
                                        <tr>
                                            <th scope="row"><?=$ct;?></th>
                                            <td><?=$batch->batch_name;?></td>
                                            <?php if ($objCI->session->userdata('role') =='admin'): ?>
                                            <td><?=$batch->username;?></td>
                                            <td><?=$batch->created_by;?></td>
                                            <td><?=$batch->active;?></td>
                                            <?php endif; ?>
                                            
                                        </tr>
                                        <?php endforeach;?>    
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>