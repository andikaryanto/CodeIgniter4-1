<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- bootstrapdashboard -->
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap-datepicker3.css'); ?>">
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap-datetimepicker.min.css'); ?>">
    <!-- <link rel="stylesheet" href="<?= baseUrl('assets/css/bootstrapdashboardcustom.css'); ?>"> -->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap-select.min.css'); ?>">
    <!-- <link rel="stylesheet" href="<?= baseUrl('assets/bootstrap/css/bootstrap.css'); ?>"> -->
    <!-- <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/bootstrap-datepicker3.css'); ?>"> -->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/animate.css'); ?>">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/fontastic.css'); ?>">
    <!-- Google fonts - Roboto -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"> -->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/googlefonts.css'); ?>">

    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/dataTables.bootstrap4.css'); ?>">
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/responsive.bootstrap4.min.css'); ?>">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/grasp_mobile_progress_circle-1.0.0.min.css'); ?>">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'); ?>">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/style.default.premium.css'); ?>" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/custom.css'); ?>">
    <!-- <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/file/component.css'); ?>">
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/file/demo.css'); ?>">
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/file/normalize.css'); ?>"> -->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/mapbox-gl.css'); ?>">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= baseUrl('assets/bootstrapdashboard/img/favicon.ico'); ?>">

    <!-- JS -->
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= baseUrl('assets/js/mapbox-gl.js'); ?>"></script>
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body>

    <div class="page" style="position:unset !important; width:100% !important;">
        <!-- navbar-->
        <header class="header">
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="navbar-holder d-flex align-items-center justify-content-between">
                        <div class="navbar-header"><a href="<?= baseUrl(); ?>" class="navbar-brand">
                                <div class="brand-text d-none d-md-inline-block"><span> </span><strong class="text-primary"></strong></div>
                            </a></div>
                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                            <!-- Notifications dropdown-->
                            <li class="nav-item"><a href="<?= baseUrl("disasterreport") ?>" class="nav-link logout"> <span class="d-none d-sm-inline-block"><?= lang('Form.disasterreport') ?></span></a></li>
                            <?php if (empty(\Core\Session::get(get_variable() . 'userdata'))) { ?>
                                <li class="nav-item"><a href="<?= baseUrl("login") ?>" class="nav-link logout"> <span class="d-none d-sm-inline-block">Login</span><i class="fa fa-sign-out"></i></a></li>
                            <?php }  else { ?>
                                <li class="nav-item"><a href="<?= baseUrl("home") ?>" class="nav-link logout"> <span class="d-none d-sm-inline-block">Menu</span></i></a></li>
                            <?php }?>
                            
                        </ul>
                    </div>
                </div>
            </nav>
        </header>