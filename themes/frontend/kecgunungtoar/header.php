<!DOCTYPE html>
<html lang="<?php echo $language_code ?>">

<head>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <title><?php echo $header_meta['meta_title']; ?></title>

    <meta name="generator" content="<?php echo $meta_generator; ?>">
    <meta name="robots" content="<?php echo $meta_robot; ?>">
    <meta name="description" content="<?php echo $header_meta['meta_description']; ?>">
    <meta name="keywords" content="<?php echo $header_meta['meta_keyword']; ?>">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $theme_url; ?>js/jquery-2.2.4.js" type="text/javascript"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $theme_url; ?>js/bootstrap.min.js" type="text/javascript"></script>

    <script src="<?php echo $theme_url; ?>js/toastr.min.js" type="text/javascript"></script>

    <!-- Datatable -->
    <script src="<?php echo $theme_url; ?>vendors/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo $theme_url; ?>vendors/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo $theme_url; ?>vendors/datatables/dataTables.responsive.min.js" type="text/javascript"></script>
    <link href="<?php echo $theme_url; ?>vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- Icon css link -->
    <link href="<?php echo $theme_url; ?>css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?php echo $theme_url; ?>css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $theme_url; ?>css/toastr.css" rel="stylesheet">

    <!-- Rev slider css -->
    <link href="<?php echo $theme_url; ?>vendors/animate-css/animate.css" rel="stylesheet">

    <!-- Fancybox -->
    <link href="<?php echo $theme_url; ?>css/jquery.fancybox.css" rel="stylesheet">

    <!-- Extra plugin css -->
    <link href="<?php echo $theme_url; ?>vendors/owl-carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo $theme_url; ?>vendors/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Ionicons -->
    <link href="<?php echo $theme_url; ?>vendors/ionicons/ionicons.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="<?php echo $theme_url; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo $theme_url; ?>css/custom.css" rel="stylesheet">
    <!-- Slider CSS -->
    <link href="<?php echo $theme_url; ?>vendors/glider-slider/glider.min.css" rel="stylesheet">

    <style>
        .main_blog_area.welcome_inner .panel-group .panel .panel-collapse .panel-body {
            padding: 0;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #ddd;
            margin-bottom: 1px;
        }

        .list-group-item:last-child {
            border-bottom: 0;
            border-radius: 0;
        }

        .hp-comment {
            display: none !important;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- FAVICON -->
    <link rel="shortcut icon" href="<?php echo $theme_url; ?>img/favicon/favicon.ico">
    <link rel="shortcut icon" href="<?php echo $theme_url; ?>img/favicon/icon.png">
    <link rel="shortcut icon" sizes="72x72" href="<?php echo $theme_url; ?>img/favicon/icon-72x72.png">
    <link rel="shortcut icon" sizes="114x114" href="<?php echo $theme_url; ?>img/favicon/icon-114x114.png">

</head>

<body>
    <!--================Header Area =================-->
    <header class="main_header_area">
        <div class="header_top">
            <div class="container header_top_wrapper">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo $theme_url; ?>img/header-logo.png" alt=""></a>
                <?php if (isset($theme_option['about_us_social'])) : ?>
                    <ul class="social_media_top">
                        <?php foreach ($theme_option['about_us_social'] as $social) : ?>
                            <li><a href="<?php echo $social['social_url'] ?>" target="blank"><i class="<?php echo $social['social_icon'] ?>" aria-hidden="true"></i></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <div class="main_menu_area">
            <nav class="navbar navbar-default">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <div class="header-logo">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo $theme_url; ?>img/header-logo-xs.png" alt=""></a>
                        </div>

                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <form method="post" action="<?php echo site_url('search') ?>">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="" name="search" placeholder="Search here...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </li>
                        </ul>
                        <?php
                        echo get_menus('Header Top Menu', array('ul_class' => 'nav navbar-nav', 'sub_ul_class' => 'dropdown-menu', 'li_class' => 'submenu dropdown'))
                        ?>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>
        </div>
    </header>