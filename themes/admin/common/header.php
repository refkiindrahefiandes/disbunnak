<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo 'Admin Dashboard'; ?></title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">

    <!-- LIBS JS -->
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/select2.full.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/Chart.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/toastr.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/jquery.ui.nestedSortable.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/jquery.multi-select.js"></script>

    <!-- Load dynamic header script from plugin -->
    <?php echo plugin_admin_enqueue_scripts() ?>

    <!-- APP JS-->
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/app/App.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/app/AppSidebar.js"></script>

    <!-- LIBS CSS -->
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/bootstrap-switch.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>js/libs/iCheck/skins/square/green.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/select2.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/toastr.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/multi-select.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/style.css">

</head>

<body>
    <!-- HEADER -->
    <header id="main-header">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <ul class="nav navbar-nav visible-xs-block list-unstyled">
                        <li><a data-toggle="collapse" data-target="#navbar-mobile" class="" aria-expanded="true"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                        <li><a class="sidebar-main-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a></li>
                    </ul>
                    <a class="navbar-brand" href="<?php echo site_url('admin/dashboard') ?>"><img alt="" src="<?php echo ADMIN_ASSETS_URL; ?>images/logo_light.png"></a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav hidden-xs">
                        <li>
                            <a class="sidebar-control sidebar-main-toggle">
                                <i class="glyphicon glyphicon-menu-hamburger"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" id="notif-badge">
                                <i class="icon ion-ios-bell"></i>
                                <span class="visible-xs-inline-block position-right">
                                    Pemberitahuan
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-content">
                                <div class="dropdown-content-heading">
                                    Pengaduan & Konsultasi
                                </div>
                                <ul class="dropdown-content-body list-unstyled drnicescroll" id="notif-content"></ul>
                            </div>
                        </li>
                        <li class="dropdown dropdown-user">
                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown">
                                <img alt="" src="<?php echo get_gravatar($this->session->userdata['email'], 180); ?>">
                                <span style="margin-right: 10px;">
                                    <?php echo $this->session->userdata['firstname'] . ' ' . $this->session->userdata['lastname'] ?>
                                </span>
                                <i class="icon ion-ios-arrow-down"></i>
                                </img>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="<?php echo site_url('admin/user/user/edit/' . $this->session->userdata['user_id']); ?>"> <i class="icon ion-settings"> </i> Account settings </a> </li>
                                <li>
                                    <?php echo anchor('admin/user/user/logout', '<i class="icon ion-log-out"></i> Logout'); ?>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo site_url(); ?>" class="dropdown-toggle" target="_blank">
                                <i class="icon ion-forward"></i>
                                <span class="visible-xs-inline-block position-right">
                                    Kunjungi Website
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>