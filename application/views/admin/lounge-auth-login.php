<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="KMC">
    <title><?php echo $title; ?> | Lounge Login</title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/kmc_favicon.png'); ?>">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Page CSS-->

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">

    <!-- END: Custom CSS-->
    <style type="text/css">
        .social_icon div{
            display: inline;
        }
        .divPadding{padding-right: 0px; padding-left: 0px;}
        /*.set_icons a img{height: 50px;}*/
        .social_icon div a i{
            color: #fff;
            
        }
        .bdr{border: 1px solid red;}
        /*.social_icon{padding: 10px 0;}*/
        .social_icon a{
            font-size: 20px;
            background: #fff !important;
            padding: 2px 12px;
            border-radius: 10px;
        }
        .img1{height: 48px;}
        .img2{height: 44px;}
        .img3{height: 44px;}
        .social_icon a{border-radius: 50% !important; padding: 4px 0px !important; margin-left: 5px;}
        .logoimg{float: left;margin-left: 30px;margin-top:-7px;height: 100px;}
        .logoimg1{width:215px;float: left;margin-right: 30px;}

        @media (min-width: 200px) and (max-width: 767px) {
            .logoimg{width:150px;height: 80px; float: left;margin-left: 30px;}
            .logoimg1{width:150px;height: 65px; float: left;margin-right: 30px;}
        } 
        .error_style{ color: red; }
        
    </style>
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

    <div class="col-xs-12 col-sm-12 divPadding sets_icons">
    <div class="col-xs-12 col-sm-12 divPadding social_icon">

        <div class="set_logo_top">
            <img src="<?php echo base_url(); ?>assets/cel_logo_login.png" class="logoimg">
        </div>
        <div class="set_icons" style="float: right;">
            <img src="<?php echo base_url(); ?>assets/kmc_logo_login.png" class="logoimg1">
        </div>
    </div>
</div>

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
                                    <div class="divider-text text-uppercase text-muted">
                                        <small>login with lounge</small>
                                    </div>
                                </div>
                                <?php echo $this->session->flashdata('login_message'); ?>
                                <form action="<?php echo site_url().'Welcome/loungeLogin'; ?>" method="post" id="loginForm">
                                    <div class="form-group mb-50">
                                        <div class="controls">
                                            <label class="text-bold-600" for="district_id">District</label>
                                            <select class="select2 form-control" name="district_id" id="district_id" onchange="getDistrictFacility(this.value);">
                                                <option value="">Select District</option>
                                                <?php foreach($district as $district_data){ ?>
                                                    <option value="<?php echo $district_data['PRIDistrictCode']; ?>"><?php echo $district_data['DistrictNameProperCase']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="district_id_error" class="error_style"></span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-50">
                                        <div class="controls">
                                            <label class="text-bold-600" for="facility_id">Facility</label>
                                            <select class="select2 form-control" name="facility_id" id="facility_id" onchange="getFacilityLounge(this.value);">
                                               <option value="">Select Facility</option> 
                                            </select>
                                            <span id="facility_id_error" class="error_style"></span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-50">
                                        <div class="controls">
                                            <label class="text-bold-600" for="lounge_id">Lounge</label>
                                            <select class="select2 form-control" name="lounge_id" id="lounge_id">
                                                <option value="">Select Lounge</option> 
                                            </select>
                                            <span id="lounge_id_error" class="error_style"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="controls">
                                            <label class="text-bold-600" for="login_password">Password</label>
                                            <input type="password" name="password" class="form-control" id="login_password" placeholder="Password">
                                            <span id="password_error" class="error_style"></span>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary glow w-100 position-relative" id="login_button">Login<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                </form>
                                <hr>
                                <div class="text-center" style="margin-top:-12px;"><small class="mr-25">Login as Admin</small><a href="<?php echo base_url() ?>Admin"><small>Click Here</small></a></div>
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
        <br>
        <center style="font-size: 13px;color:#626060;">Copyright © <?php echo date('Y'); ?> - All rights reserved CEL</center>
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
        
        // get facility
        function getDistrictFacility(district){
            $.ajax({ 
              type: "POST", 
              url: '<?php echo base_url('admin/getDistrictFacility'); ?>', 
              data: {'district': district}, 
              success:function(response){
                $('#facility_id').html(response);
              }
            });
        }

        // get lounges
        function getFacilityLounge(facility){
           $.ajax({ 
              type: "POST", 
              url: '<?php echo base_url('admin/getFacilityLounge'); ?>', 
              data: {'facility': facility}, 
              success:function(response){
                $('#lounge_id').html(response);
              }
            }); 
        }

        // login field validation
        $('#login_button').click(function() { 

            var district_id = $('#district_id').val();
            if(district_id == "")
            {
                $('#district_id_error').html('District field is required.');
                setTimeout(function() {
                    $('#district_id_error').html("");
                }, 5000);
                return false;
            }

            var facility_id = $('#facility_id').val();
            if(facility_id == "")
            {
                $('#facility_id_error').html('Facility field is required.');
                setTimeout(function() {
                    $('#facility_id_error').html("");
                }, 5000);
                return false;
            }

            var lounge_id = $('#lounge_id').val();
            if(lounge_id == "")
            {
                $('#lounge_id_error').html('Lounge field is required.');
                setTimeout(function() {
                    $('#lounge_id_error').html("");
                }, 5000);
                return false;
            }

            var password = $('#login_password').val();
            if(password == "")
            {
                $('#password_error').html('Password field is required.');
                setTimeout(function() {
                    $('#password_error').html("");
                }, 5000);
                return false;
            }
        });
    </script>

    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script> -->
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <!-- <script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script> -->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/configs/horizontal-menu.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/core/app.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/components.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/footer.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>app-assets/js/scripts/forms/select/form-select2.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- <script src="<?php echo base_url(); ?>app-assets/js/scripts/forms/validation/form-validation.js"></script> -->
    <!-- END: Page JS-->

  </body>
  
</html>