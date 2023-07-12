<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">

        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        
            <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                <form id="frmLogin" method="post">
                    <div id="register_success" style="display:hide;"></div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="<?=site_url("login");?>" class="">
                            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Admin</h3>
                        </a>
                        <h3>Sign In</h3>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="username" class="form-control" placeholder="User Name" name="uname" >
                        <label for="floatingInput">User Name</label>
                    </div>
                    <div class="form-floating mb-4">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>  
                    <button type="submit" id="btnSubmit" name="submit" class="btn btn-primary py-3 w-100 mb-4" value="Sign In">Sign In</button>
                </form>             
            </div>
        </div>
    </div>
</div>
   