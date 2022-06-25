<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title." | Peace Therapy International"; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/build/images/favicon.png') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/main.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/font-awesome.min.css">
        <!-- Datatables -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/custom.css">        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/jqueryui/jquery-ui.min.css">
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <?php
            __load_assets__($__assets__,'css');
            $method = $this->router->fetch_method();
        ?>
    </head>
    
    <body class="app sidebar-mini rtl">
        <div class="overlay" style="z-index: 9999999;width:100%;height:100%;position:fixed;top:0;bottom:0;left:0;right:0;background-color:rgba(0,0,0,0.6);display:none;">
            <div class="loader"></div>
        </div>
        <!-- Navbar-->
        <header class="app-header"><a class="app-header__logo" href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/build/images/main-logo.png')?>" alt=""></a>
          <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
          <!-- Navbar Right Menu-->
            <ul class="app-nav app-nav-custom">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_updateProfile" class="updateProfileBtn" data-id="<?php echo $_SESSION['user_id']; ?>"><i class="fa fa-user fa-lg"></i> Profile</a> &nbsp;&nbsp;&nbsp;
                <a href="<?php echo base_url('logout')?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a>
            </ul>
        </header>
        <!-- Sidebar menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar left-sidebar">
            <!-- <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url('assets/build/images/adminicon.png')?>" width="60" alt="User Image">
                <div>
                    <p class="app-sidebar__user-designation">Administrator</p>
                </div>
            </div> -->
            <nav class="sidebar-nav">
                <ul class="app-menu" id="sidebarnav">
                    <?php if($_SESSION['user_type'] != 3) { ?>
                        <li><a class="app-menu__item <?php echo $route=='users'?'active':''; ?>" href="<?php echo base_url('users')?>" aria-expanded="false"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label hide-menu">Users</span></a></li>
                    <?php } ?>
                    <li><a class="app-menu__item <?php echo $route=='documents'?'active':''; ?>" href="<?php echo base_url('documents')?>" aria-expanded="false"><i class="app-menu__icon fa fa-file"></i><span class="app-menu__label hide-menu">Documents</span></a></li>
                    <?php if($_SESSION['user_type'] != 3) { ?>
                        <li><a class="app-menu__item <?php echo $route=='historylogs'?'active':''; ?>" href="<?php echo base_url('historylogs')?>" aria-expanded="false"><i class="app-menu__icon fa fa-history"></i><span class="app-menu__label hide-menu">History Logs</span></a></li>
                    <?php } ?>
                </ul>
            </nav>
        </aside>

        <!-- =============================Update Profile Modal================================= -->
<div id="modal_updateProfile" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Update Profile</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateProfile" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">First Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="pfirstname" placeholder="Enter First Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Middle Name</label>
                                    <input type="text" class="form-control" name="pmiddlename" placeholder="Enter Middle Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Last Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="plastname" placeholder="Enter Last Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Address <sup>(Barangay / Municipality / Province) <i class="text-danger">*</i></sup></label>
                                    <input type="text" class="form-control" name="paddress" placeholder="Enter Address Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="pusername" placeholder="Enter Username Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" name="pemail" placeholder="Enter Email Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" name="pphone" placeholder="Enter Phone Number Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="ppassword" placeholder="Enter Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Office <sup class="text-danger">*</sup></label>
                                    <select name="poffice" class="form-control">
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
                                    <select name="pdivision" class="form-control">
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
                            <input type="hidden" name="puser_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="puser_type" value="<?php echo $_SESSION['user_type']; ?>">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>

