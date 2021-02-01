<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title><?php echo $title; ?> | Admin Panel Login</title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d4ca55c285.js" crossorigin="anonymous"></script>
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/semi-dark-layout.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/authentication.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/plugins/forms/validation/form-validation.css">
    <!-- END: Page CSS-->

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <!-- END: Custom CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="horizontal-layout horizontal-menu navbar-sticky 1-column   footer-static bg-full-screen-image  blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper" style="margin-top: 0rem !important;">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- login page start -->
<section id="auth-login" class="row flexbox-container">
    <div class="col-xl-8 col-11">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                        <div class="card-header pb-0">
                            <div class="card-title">
                                <h4 class="text-center mb-1">Welcome Back</h4>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                
                                <div class="divider mt-0">
                                    <div class="divider-text text-uppercase text-muted"><small>login with
                                            email</small>
                                    </div>
                                </div>
                                
                                <?php echo $this->session->flashdata('login_message'); ?>
                                
                                <form action="<?php echo site_url().'Welcome/doCELLogin'; ?>" method="post" novalidate>
                                    <div class="form-group mb-50">
                                        <div class="controls">
                                            <label class="text-bold-600" for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Email address" name="email" required="" data-validation-required-message="This Email address field is required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="controls">
                                            <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                                            <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password" required="" data-validation-required-message="This Password field is required">
                                        </div>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6LfdpcYUAAAAAD084Wsu42xzXbZrYNwluJNXdWP3"></div>
                                    <div
                                        class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                        <div class="text-left">
                                            <div class="checkbox checkbox-sm">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="checkboxsmall" for="exampleCheck1"><small>Keep me logged
                                                        in</small></label>
                                            </div>
                                        </div>
                                        <div class="text-right"><a href="auth-forgot-password.html"
                                                class="card-link"><small>Forgot Password?</small></a></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary glow w-100 position-relative">Login<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                </form>
                                <hr>
                                <!-- <div class="text-center"><small class="mr-25">Login as CEL Employee</small><a
                                        href="<?php echo base_url() ?>Admin/Login"><small>Click Here</small></a></div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <div class="card-content">
                        <img class="img-fluid" src="<?php echo base_url(); ?>app-assets/images/pages/login.png" alt="branding logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- login page ends -->

        </div>
      </div>
    </div>
    <!-- END: Content-->

    <script type="text/javascript">
        setTimeout(function(){
            $('.alert-dismissible').hide();
        },5000);
    </script>


    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script> -->
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/configs/horizontal-menu.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/core/app.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/components.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/forms/validation/form-validation.js"></script>
    <!-- END: Page JS-->

  </body>
  
</html>