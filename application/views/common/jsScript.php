<?php $objCI =& get_instance(); ?>
<!--JQuery Includation Common for all pages-->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=SITE_URL;?>media/lib/chart/chart.min.js"></script>
    <script src="<?=SITE_URL;?>media/lib/easing/easing.min.js"></script>
    <script src="<?=SITE_URL;?>media/lib/waypoints/waypoints.min.js"></script>
    <script src="<?=SITE_URL;?>media/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?=SITE_URL;?>media/lib/tempusdominus/js/moment.min.js"></script>
    <script src="<?=SITE_URL;?>media/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="<?=SITE_URL;?>media/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="<?=SITE_URL;?>media/js/main.js"></script>



<!-- Common Varialbe rule -->
<script>
var base_url="<?=SITE_URL;?>";
</script>
<!-- End Code -->
<!------ Datatables Calling for selected pages only-------------------->
<?php if($page=="student_list" || $page=="batch_list" || $page=="user_list" ): ?>
   
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
   <!-- Add DataTables Bootstrap 5 JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
   <script src="<?=SITE_URL;?>media/js/extrajs/page.StudentsList.js" type="text/javascript"></script>
   
<?php endif; ?>
<!----- End  ------------------------------------------>
<!-- Start: Form Validation Scripts -->
<script src="<?=SITE_URL;?>media/js/extrajs/jquery.validate.min.js"></script>
<script src="<?=SITE_URL;?>media/js/extrajs/additional-methods.min.js"></script>
<script src="<?=SITE_URL;?>media/js/extrajs/jquery.validate.bootstrap.popover.min.js" type="text/javascript"></script>
<!-- End: Form Validation Scripts -->


<!------------ Extra JS File calling for each pages ------------------>
<?php if($page=="login"): ?>
<script src="<?=SITE_URL;?>media/js/extrajs/page.Login.js" type="text/javascript"></script>
<?php elseif($page=="student_new"): ?>
<script src="<?=SITE_URL;?>media/js/mfs/mfs100-9.0.2.6.js" type="text/javascript"></script>
<script src="<?=SITE_URL;?>media/js/extrajs/page.StudentNew.js" type="text/javascript"></script>
<?php elseif($page=="user_new"): ?>
<script src="<?=SITE_URL;?>media/js/extrajs/page.NewUser.js" type="text/javascript"></script>
<?php elseif($page=="batch_new"): ?>
<script src="<?=SITE_URL;?>media/js/extrajs/page.BatchNew.js" type="text/javascript"></script>
<?php elseif($page=="user_list"): ?>
<script src="<?=SITE_URL;?>media/js/extrajs/page.EditUser.js" type="text/javascript"></script>
<!----- End  ------------------------------------------>

<?php endif; ?>


