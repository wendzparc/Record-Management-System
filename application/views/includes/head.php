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
                </ul>
            </nav>
        </aside>
