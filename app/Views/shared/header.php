<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="5"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- bootstrapdashboard -->
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap-datepicker3.css');?>">
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap-datetimepicker.min.css');?>">
    <!-- <link rel="stylesheet" href="<?=  base_url('assets/css/bootstrapdashboardcustom.css');?>"> -->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap-select.min.css');?>">
    <!-- <link rel="stylesheet" href="<?=  base_url('assets/bootstrap/css/bootstrap.css');?>"> -->
    <!-- <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/bootstrap-datepicker3.css');?>"> -->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/animate.css');?>">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/font-awesome/css/all.css');?>">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/fontastic.css');?>">
    <!-- Google fonts - Roboto -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"> -->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/googlefonts.css');?>">

    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/summernote-bs4.css');?>">
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/dataTables.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/bootstrap/css/responsive.bootstrap4.min.css');?>">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/grasp_mobile_progress_circle-1.0.0.min.css');?>">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css');?>">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/style.default.premium.css');?>" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/custom.css');?>">
    <!-- <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/file/component.css');?>">
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/file/demo.css');?>">
    <link rel="stylesheet" href="<?=  base_url('assets/bootstrapdashboard/css/file/normalize.css');?>"> -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrapdashboard/css/mapbox-gl.css'); ?>">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?=  base_url('assets/bootstrapdashboard/img/favicon.ico');?>">

    <!-- JS -->
    <script src="<?= base_url('assets/bootstrapdashboard/vendor/jquery/jquery.min.js');?>"></script>
    <script src="<?= base_url('assets/js/mapbox-gl.js'); ?>"></script>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body> 
    <!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="<?= base_url('assets/resource/imgs/logo.png')?>" alt="person" class="img-fluid rounded-circle">
         
          </div>
          
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <?= $menu ?>
      
          
      </div>
    </nav>
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="<?=  base_url();?>" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span> BPBD</span><strong class="text-primary">SLEMAN</strong></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Notifications dropdown-->
                <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-warning">12</span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-envelope"></i>You have 6 new messages </div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-upload"></i>Server Rebooted</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                          <div class="notification-time"><small>10 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-bell"></i>view all notifications                                            </strong></a></li>
                  </ul>
                </li>
                <!-- Languages dropdown    -->
                <li class="nav-item dropdown">
                  <a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle">
                    <?php 
                    $flag = "assets/bootstrapdashboard/img/flags/16/US.png";
                    if(session(get_variable().'language') == "id")
                      $flag = 'assets/bootstrapdashboard/img/flags/16/ID.png';
                    ?>
                    <img src="<?= base_url($flag)?>" alt="">
                    <span class="d-none d-sm-inline-block"></span>
                  </a>
                  <ul aria-labelledby="languages" class="dropdown-menu">
                    <li><a rel="nofollow" class="dropdown-item" href ="<?=  base_url('changeLanguage');?>?language=id"> 
                      <img src="<?=  base_url('assets/bootstrapdashboard/img/flags/16/ID.png')?>" alt="Indonesia" class="mr-2">
                      <span>Indonesia</span></a>
                    </li>
                    <li><a rel="nofollow" class="dropdown-item" href ="<?=  base_url('changeLanguage');?>?language=en"> 
                      <img src="<?=  base_url('assets/bootstrapdashboard/img/flags/16/US.png');?>" alt="English" class="mr-2">
                      <span>English</span></a>
                    </li>
                  </ul>
                </li>
                <!-- profile dropdown    -->
                <li class="nav-item dropdown">
                  <a id="profile" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle">
                    hi, <?=session(get_variable().'userdata')['Username']?>
                    <span class="d-none d-sm-inline-block"></span>
                  </a>
                  <ul aria-labelledby="profile" class="dropdown-menu">
                    <li><a rel="nofollow" class="dropdown-item" href ="<?=  base_url('changePassword');?>"> 
                      <i class="fa fa-edit"></i>
                      <span><?= lang("Form.changepassword")?></span></a>
                    </li>
                    <li><a rel="nofollow" class="dropdown-item" href ="<?=  base_url('login/dologout');?>"> 
                      <i class="fa fa-sign-out-alt"></i>
                      <span><?= lang("Form.logout")?></span></a>
                    </li>
                    
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>

      
    
    