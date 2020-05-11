<!DOCTYPE html>
<!-- saved from url=(0067)https://demo.bootstrapious.com/dashboard-premium/1-4-5/login-2.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap.min.css');?>">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?=  baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/bootstrap-select.min.css');?>">
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/font-awesome/css/font-awesome.min.css');?>">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/fontastic.css');?>">
    <!-- Google fonts - Roboto -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"> -->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/css/googlefonts.css');?>">
    
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/grasp_mobile_progress_circle-1.0.0.min.css');?>">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css');?>">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/style.default.premium.css');?>" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= baseUrl('assets/bootstrapdashboard/css/custom.css');?>">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= baseUrl('assets/bootstrapdashboard/img/favicon.ico');?>">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  <style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style></head>
  <body style="">
    <div class="container-fluid px-3">
      <div class="row min-vh-100">
        <div class="col-md-4 col-lg-4 col-xl-4 px-lg-4 d-flex align-items-center">
          <div class="w-100 py-5">
            <div class="text-center"><img src="<?= baseUrl('assets/resource/imgs/logo.png')?>" alt="..." style="max-width: 8rem;" class="img-fluid mb-4">
              <h1 class="display-4 mb-3">Sign in</h1>
            </div>
            <?= formOpen(baseUrl('login/dologin'))?>
              
              <div class="form-group">
                <label>Username</label>
                <input name="loginUsername" type="text" placeholder="username" autocomplete="off" required="" data-msg="Please enter your email" class="form-control">
              </div>
              <div class="form-group mb-4">
                <div class="row">
                  <div class="col">
                    <label>Password</label>
                  </div>
                </div>
                <input name="loginPassword" placeholder="Password" type="password" required="" data-msg="Please enter your password" class="form-control">
              </div>
              <button type = "submit" class="btn btn-lg btn-block btn-primary mb-3">Sign in</button>
              <a href = "<?= baseUrl("welcome")?>" class="btn btn-lg btn-block btn-primary mb-3">Beranda</a>
            <?= formClose()?>
          </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8 col-xl-8 d-none d-lg-block">
          <div style="background-image: url(<?= baseUrl('assets/bootstrapdashboard/img/photos/victor-ene-1301123-unsplash.jpg')?>);" class="bg-cover h-100 mr-n3"></div>
        </div>
      </div>
    </div>
    <button type="button" data-toggle="collapse" data-target="#style-switch" id="style-switch-button" class="btn btn-primary btn-sm d-none d-md-inline-block"><i class="fa fa-cog fa-2x"></i></button>
    <div id="style-switch" class="collapse">
      <h5 class="mb-3">Select theme colour</h5>
      <form class="mb-3">
        <select name="colour" id="colour" class="form-control">
          <option value="">select colour variant</option>
          <option value="default.premium">green</option>
          <option value="red.premium">red</option>
          <option value="violet.premium">violet</option>
          <option value="pink.premium">pink</option>
          <option value="sea.premium">sea</option>
          <option value="blue.premium">blue</option>
        </select>
      </form>
      <p><img src="<?= baseUrl('assets/bootstrapdashboard/img/template-mac.png')?>" alt="" class="img-fluid"></p>
      <p class="text-muted text-small">Stylesheet switching is done via JavaScript and can cause a blink while page loads. This will not happen in your production code.</p>
    </div>
    <!-- JavaScript files-->
    
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/jquery/jquery.min.js');?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/popper.js/umd/popper.min.js');?>"> </script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/bootstrap/js/plugins/bootstrap-select.min.js');?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/js/grasp_mobile_progress_circle-1.0.0.min.js');?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/jquery.cookie/jquery.cookie.js');?>"> </script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/chart.js/Chart.min.js');?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/jquery-validation/jquery.validate.min.js');?>"></script>
    <script src="<?= baseUrl('assets/bootstrapdashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js');?>"></script>
    <!-- Main File-->
    <script src="<?= baseUrl('assets/bootstrapdashboard/js/front.js');?>"></script>
  
<!-- <input id="ext-version" type="hidden" value="1.4.1"> -->
<script>
  $(document).ready(function(){
    initlogin();
  });

  function initlogin(){
    $('.selectpicker').selectpicker({
      style : 'btn-primary'
    }); 
  }
</script>
</body>
</html>