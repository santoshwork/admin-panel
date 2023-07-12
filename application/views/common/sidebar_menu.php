<?php $objCI =& get_instance(); ?>
<!-- Sidebar Start -->
<?php if($objCI->session->userdata('usrid')): ?>
<div class="sidebar pe-4 pb-3">
  <nav class="navbar bg-secondary navbar-dark">
    <a href="index.html" class="navbar-brand mx-4 mb-3">
      <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>AdminSection</h3>
    </a>
    <div class="d-flex align-items-center ms-4 mb-4">
      <div class="position-relative">
        <img class="rounded-circle" src="<?=$objCI->session->userdata('profile_photo');?>" alt="" style="width: 40px; height: 40px;">
        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
      </div>
      <div class="ms-3">
        <h6 class="mb-0">Hi <?=ucfirst($objCI->session->userdata('username'));?></h6>
        <span><?=ucfirst($objCI->session->userdata('role'));?></span>
      </div>
    </div>
    <div class="navbar-nav w-100">
    <?php if($objCI->session->userdata('role')=="admin"):?>
      <a href="<?=site_url("dashboard");?>" class="nav-item nav-link <?php if($page=="dashboard"):?> active <?php endif;?>">
        <i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
      <a href="<?=site_url("dashboard/students");?>" class="nav-item nav-link <?php if($page=="student_list" || $page=="student_new"):?> active <?php endif;?>">
        <i class="fa fa-th me-2"></i>Student List</a>
      <a href="<?=site_url("dashboard/batches");?>" class="nav-item nav-link <?php if($page=="batch_list"):?> active <?php endif;?>">
        <i class="fa fa-keyboard me-2"></i>Batch List</a>
      <a href="<?=site_url("dashboard/users");?>" class="nav-item nav-link <?php if($page=="user_list"):?> active <?php endif;?>">
        <i class="fa fa-table me-2"></i>User List</a>
    <?php elseif($objCI->session->userdata('role')=="distributor"): ?>
      <a href="<?=site_url("dashboard");?>" class="nav-item nav-link <?php if($page=="dashboard"):?> active <?php endif;?>">
        <i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
      <a href="<?=site_url("dashboard/students");?>" class="nav-item nav-link <?php if($page=="student_list"):?> active <?php endif;?>">
        <i class="fa fa-th me-2"></i>Student List</a>
        <a href="<?=site_url("dashboard/batches");?>" class="nav-item nav-link <?php if($page=="batch_list"):?> active <?php endif;?>">
        <i class="fa fa-keyboard me-2"></i>Batch List</a>
        <?php elseif($objCI->session->userdata('role')=="operator"): ?>
          <a href="<?=site_url("dashboard");?>" class="nav-item nav-link <?php if($page=="dashboard"):?> active <?php endif;?>">
        <i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
      <a href="<?=site_url("dashboard/student_new");?>" class="nav-item nav-link <?php if($page=="student_new"):?> active <?php endif;?>">
        <i class="fa fa-th me-2"></i>Add Student</a>
    <?php endif; ?>
    </div>
  </nav>
</div>
<?php endif; ?>
<!-- Sidebar End -->