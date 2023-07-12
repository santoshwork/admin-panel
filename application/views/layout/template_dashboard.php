<?php $objCI =& get_instance(); ?>
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('common/head'); ?>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <?php $this->load->view('common/sidebar_menu'); ?>
        <div class="content">
            <?php $this->load->view('common/header_menu'); ?>
            <div class="container-fluid pt-4 px-2">
                <?php $this->load->view('content/'.$page); ?>
            </div>
            <?php $this->load->view('common/footer'); ?>
        </div>
    </div>
    <?php $this->load->view('common/jsScript'); ?>
</body>

</html>