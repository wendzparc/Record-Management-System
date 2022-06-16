<section class="material-half-bg">
</section>
<section class="login-content">
    <div class="logo">
        <a href="<?php echo base_url().'login'?>"><img src="<?php echo base_url('assets/build/images/main-logo.png') ?>" alt="Logo"></a>
    </div>
    <div class="login-box">
        <form class="login-form" id="login-form" action="<?php echo base_url('login/auth'); ?>" method="POST">
            <div class="form-group text-center">
                <h2 class="text-white">Login</h2>
                <?php if (isset($_SESSION['error'])){ ?>
                <label class="text-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['error']; ?></label>
                <?php }else{ ?>
                    <br>
                <?php } ?>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="uname" id="uname" placeholder="Username" autocomplete="off" value="<?php echo set_value('uname');?>" autofocus>
                <span class="text-danger"><?php echo form_error('uname');?></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="pass" id="pass" placeholder="Password">
                <span class="text-danger"><?php echo form_error('pass');?></span>
            </div>

            <div class="form-group btn-container text-center">
                <button class="btn btn-blue" name="button"><i class="fa fa-sign-in"></i> SIGN IN</button>
            </div><br />

            <div class="form-group btn-container text-center">
                <button type="button" data-toggle="modal" data-target="#modal_registerApplicant" class="btn btn-blue btnRegister"><i class="fa fa-forward"></i> REGISTER</button>
            </div>

        </form>
    </div>
</section>


<!-- =============================Register Applicant Modal================================= -->
<div id="modal_registerApplicant" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> User Registration</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_registerApplicant" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">First Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="firstname" placeholder="Enter First Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" placeholder="Enter Middle Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Last Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Address <sup>(Barangay / Municipality / Province) <i class="text-danger">*</i></sup></label>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="username" placeholder="Enter Username Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password <sup class="text-danger">*</sup></label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Office <sup class="text-danger">*</sup></label>
                                    <select name="office" class="form-control">
                                        <option value="" selected> - Please select - </option>
                                        <option value="MDRRMO">MDRRMO</option>
                                        <option value="MDRRMC">MDRRMC</option>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Division <sup class="text-danger">*</sup></label>
                                    <select name="division" class="form-control">
                                        <option value="" selected> - Please select - </option>
                                        <option value="General">General</option>
                                        <option value="Admin & Finance">Admin & Finance</option>
                                        <option value="Training & Planning / Operation">Training & Planning</option>
                                        <option value="Operations">Operations</option>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        <br />

                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>