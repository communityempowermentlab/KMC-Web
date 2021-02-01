<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?> | Admin Panel Login</title>
  <!-- Tell the browser to be responsive to screen width -->
<link rel="shortcut icon" href="<?php echo site_url();?>assets/favicon_1.ico" type="image/x-icon"> 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url('assets/images/android-icon-36x36.png'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/dist/css/skins/_all-skins.min.css">
   <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/plugins/iCheck/square/blue.css">
  
 
  <script src="<?php echo site_url(); ?>assets/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
  <script src="<?php echo site_url(); ?>assets/admin/js/jquery-ui.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
  <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms2").fadeOut(5000);
  }



  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  

  <style type="text/css">
  /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;

    /*padding: 23px;*/
    border: 1px solid #888;
    width: 37%;
}

/* The Close Button */
.close {
    color: #820505;
    float: right;
    font-size: 28px;
    font-weight: bold;
    padding-right: 13px;
}

.login-page2{
  

}

@media screen and (min-width: 480px ) {
    body {
        background-size:  1500px;
    }
}
@media screen and (max-width: 1500px) {
    body {
        background-size:  100%;

    }
}
/*@media screen and (min-width: 480px) {
    body {
        background-size:  1500px;
    }
}*/
.login-page1{

  background-image: url(<?php  echo base_url('/assets/bg1.png');?>) !important;

}
.login-page3{
  background-image: url(<?php  echo base_url('/assets/vendor.png');?>) !important;

}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.login-box {
    margin: 5% auto !important;
}
   </style>
</head>

<body class="hold-transition login-page2" id="login-page">
<!--     <div class=""> <img src="<?php //echo base_url('assets/images/logo.jpg'); ?>" style="max-width: 150px;
    position: relative;"></div> -->
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body">
  <div class="login-logo">
   <img src="<?php echo site_url().'assets/logo_white.png' ?>" align="left" style="max-width:140px;">
   <img src="<?php echo site_url().'assets/logo.png' ?>" align="right" style="max-width:107px;">
   <br/>
  </div>
  <div class="login-logo"><center><?php  echo  'Admin Panel' ;?></center> </div>
    <p class="login-box-msg">Sign in to start your session</p>
  <?php echo $this->session->flashdata('login_message'); ?>

   <form method="post" action="<?php echo site_url().'Welcome/doLogin'; ?>">
     
      <div class="form-group has-feedback">
        
        <input type="email" name="email" class="form-control" placeholder="Email" required >
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="g-recaptcha" data-sitekey="6LfdpcYUAAAAAD084Wsu42xzXbZrYNwluJNXdWP3"></div>
      <div class="row" style="margin-top: 5px;">
        <div class="col-xs-8">
          <div class="checkbox icheck">
  
            <label><a href="<?php echo base_url();?>Admin/Login">Login as a CEL Employee</a></label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>

        <!-- /.col -->
      </div>
    </form>
     

  
</div>

</div>


<div style=" background:white;padding: 15px;width: 100%;
    transition: transform 0.3s ease-in-out 0s;margin :0.3s ease-in-out 0s;position:absolute;bottom: 0;">
  
<center><strong>Copyright &copy; <?php echo date('Y'); ?>-<?php echo (date('Y')+1); ?> <a href="#">The Kangaroo Care Project</a>.</strong> All rights
    reserved.</center>

</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/admin/dist/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/admin/dist/js/bootstrap.min.js')?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>"></script>

<script>

  function randomImage(){ 
    var images = <?php echo json_encode($backgroundImages); ?>; console.log(images);
    $('#login-page').css({'background-image': 'url(<?php echo base_url(); ?>assets/loginPage/'+images[Math.floor(Math.random() * images.length)] + ')'});
  }

  $(document).ready(function(){
    randomImage();
  });
</script>

</body>
</html>
