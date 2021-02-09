<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="KMC">
    <title><?php echo $title; ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url('assets/kmc_favicon.png'); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/kmc_favicon.png'); ?>">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/extensions/dragula.min.css">
    <!-- END: Vendor CSS-->

    <script src="https://kit.fontawesome.com/d4ca55c285.js" crossorigin="anonymous"></script>

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/semi-dark-layout.min.css">
    <!-- END: Theme CSS-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/plugins/forms/validation/form-validation.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/dashboard-analytics.min.css">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/extensions/sweetalert2.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/pickers/pickadate/pickadate.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>twd-theme/videojs/video-js.css">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <!-- END: Custom CSS-->
    <style type="text/css">
      .logoimg{width:190px; float: left;margin-left: 0px;}
      .logoimg1{float: left;margin-top:-20px;height: 70px;}
      .nonclick_link{ cursor: default;color: #727E8C; }
      .notifyDa{background-color: #ECECEC;}
      .notifyDa:hover {
        background-color: yellow !important;
      }
    </style>
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/get-data.js"></script>

  <script type="text/javascript">
    function markReadNotification(id){
      $.ajax({
          url: '<?php echo base_url('notificationM/markReadNotification'); ?>',
          type: 'POST',
          data: {'id': id},
          success: function(result) {
          }
      });
    }
  </script>

  </head>
  <!-- END: Head-->

  <!-- END: Get Notification-->
  <?php
    $this->db->order_by('id','DESC');
    $notifications = $this
                    ->db
                    ->get_where('adminNotification', array(
                    'status' => 1
                ))->result_array();

    $countNotification = count($notifications);
  ?>
  <!-- END: Get Notification-->

  <!-- BEGIN: Body-->
  <body class="horizontal-layout horizontal-menu navbar-sticky 2-columns   footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <?php $adminData = $this->session->userdata('adminData');   ?>

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed bg-primary navbar-brand-center">
      <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item"><a class="navbar-brand" href="<?php echo base_url() ?>admin/dashboard">
              <div class="brand-logo"><img class="logoimg1" src="<?php echo base_url(); ?>assets/kmc_logo_header.png"></div>
              <!-- <h2 class="brand-text mb-0">KMC V2</h2> -->
            </a>
          </li>
        </ul>
      </div>
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="navbar-collapse" id="navbar-mobile">
            <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
              <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu mr-auto"><a class="nav-link nav-menu-main menu-toggle" href="#"><i class="bx bx-menu"></i></a></li>
              </ul>
              <ul class="nav navbar-nav bookmark-icons">
                <!-- <li class="nav-item d-none d-lg-block"><img src="<?php echo base_url(); ?>assets/cel_logo.png" class="logoimg"></li> -->
                <li class="nav-item d-none d-lg-block"><span style="color:#FFF;letter-spacing:.01rem;font-size:1.57rem;">Community Empowerment Lab</span></li>
              </ul>
              <!-- <ul class="nav navbar-nav bookmark-icons">
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon bx bx-envelope"></i></a></li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i></a></li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon bx bx-check-circle"></i></a></li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calendar.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon bx bx-calendar-alt"></i></a></li>
              </ul>
              <ul class="nav navbar-nav">
                <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon bx bx-star warning"></i></a>
                  <div class="bookmark-input search-input">
                    <div class="bookmark-input-icon"><i class="bx bx-search primary"></i></div>
                    <input class="form-control input" type="text" placeholder="Explore Frest..." tabindex="0" data-search="template-search">
                    <ul class="search-list"></ul>
                  </div>
                </li>
              </ul> -->
            </div>
            <ul class="nav navbar-nav float-right d-flex align-items-center">
              <!-- <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language d-lg-inline d-none">English</span></a>
                <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-us mr-50"></i>English</a><a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-fr mr-50"></i>French</a><a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-de mr-50"></i>German</a><a class="dropdown-item" href="#" data-language="pt"><i class="flag-icon flag-icon-pt mr-50"></i>Portuguese</a></div>
              </li> -->
              <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
              <li class="nav-item nav-search"><a class="nav-link nav-link-search pt-2"><i class="ficon bx bx-search"></i></a>
                <div class="search-input">
                  <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                  <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">
                  <div class="search-input-close"><i class="bx bx-x"></i></div>
                  <ul class="search-list"></ul>
                </div>
              </li>
              <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up"><?php echo $countNotification; ?></span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title"><?php echo $countNotification; ?> new Notification</span><a href="<?php echo base_url(); ?>notificationM/markAllRead" style="color: #FFF;"><span class="text-bold-400 cursor-pointer">Mark all as read</span></a></div>
                  </li>
                  <li class="scrollable-container media-list">

                  <?php  foreach ($notifications as $key => $value) {
                      $time =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                      $notificationTypeArray = array('1'=>'E','2'=>'A','3'=>'S');
                  ?>
                  <a href="<?= $value['url']; ?>" onclick="markReadNotification('<?php echo $value['id'] ?>');">
                    <div class="d-flex justify-content-between cursor-pointer notifyDa">
                      <div class="media d-flex align-items-center" style="border-bottom:1px solid #D3D5D7;">
                        <div class="media-left pr-0">
                          <div class="avatar bg-primary bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content text-primary font-medium-2"><?php if(array_key_exists($value['type'], $notificationTypeArray)){ echo $notificationTypeArray[$value['type']]; }else{ echo "N"; } ?></span></div>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading"><?php echo $value['text']; ?></h6><small class="notification-text"><?php echo $time; ?></small>
                        </div>
                      </div>
                    </div>
                  </a>
                  <?php }   ?>
                    
                  </li>
                  <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="<?php echo base_url() ?>notificationM/viewAll">Read all notifications</a></li>
                </ul>
              </li>
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                  <div class="user-nav d-lg-flex d-none"><span class="user-name"><?php echo $adminData['Name']; ?></span><span class="user-status">Available</span></div><span><img class="round" src="<?php echo base_url(); ?>app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"></span></a>
                <div class="dropdown-menu dropdown-menu-right pb-0"><a class="dropdown-item" href="page-user-profile.html"><i class="bx bx-user mr-50"></i> Edit Profile</a><a class="dropdown-item" href="app-email.html"><i class="bx bx-envelope mr-50"></i> My Inbox</a><a class="dropdown-item" href="app-todo.html"><i class="bx bx-check-square mr-50"></i> Task</a><a class="dropdown-item" href="app-chat.html"><i class="bx bx-message mr-50"></i> Chats</a>
                  <?php if($adminData['Type']==1) { $logoutUrl = base_url()."Welcome/logout"; } else { $logoutUrl = base_url()."Welcome/employeeLogout";  } ?>
                  <div class="dropdown-divider mb-0"></div><a class="dropdown-item" href="<?= $logoutUrl; ?>"><i class="bx bx-power-off mr-50"></i> Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow" role="navigation" data-menu="menu-wrapper">
      <div class="navbar-header d-xl-none d-block">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html">
              <div class="brand-logo"><img class="logo" src="<?php echo base_url(); ?>assets/cel_logo_login.png"/></div>
              <!-- <h2 class="brand-text mb-0">Frest</h2> -->
            </a></li>
          <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i></a></li>
        </ul>
      </div>
      <div class="shadow-bottom"></div>
      <!-- Horizontal menu content-->
      <div class="navbar-container main-menu-content" data-menu="menu-container">
        <!-- include ../../../includes/mixins-->
        <?php $adminData = $this->session->userdata('adminData');
        if($adminData['Type']==1) { ?>
          <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
            
            <li class="<?php echo ($index =='index'  ? 'active' : ''); ?>" data-menu=""><a class="dropdown-toggle nav-link" href="<?php echo base_url(); ?>admin/dashboard"><i class="menu-livicon" data-icon="desktop"></i><span data-i18n="Dashboard">Dashboard</span></a>
            </li>

            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="users"></i><span>Facilities</span></a>
              <ul class="dropdown-menu">
                <li data-menu="" class="<?php echo (($index=='facilities')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/facility/manageFacility'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Facilities</a>
                </li>
                
                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item align-items-center dropdown-toggle" href="#" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Lounges</a>
                  <ul class="dropdown-menu">
                    <li data-menu="" class="<?php echo (($index=='lounge') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/loungeM/manageLounge'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Lounges Information</a>
                    </li>
                    <li data-menu="" class="<?php echo (($index=='temporaryLounge') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('loungeM/temporaryLounge'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Amenities Information</a>
                    </li>
                    
                  </ul>
                </li>
                <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item align-items-center dropdown-toggle" href="#" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Staff</a>
                  <ul class="dropdown-menu">
                    <li data-menu="" class="<?php echo (($index=='staff') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/staffM/manageStaff'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Approved Staff</a>
                    </li>
                    <li data-menu="" class="<?php echo (($index=='temporaryStaff') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('staffM/temporaryStaff'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Not Approved Staff</a>
                    </li>
                    
                  </ul>
                </li>

                <li data-menu="" class="<?php echo (($index=='coachM')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/coachM/coachList'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Coaches</a>
                </li>
                
                <li data-menu="" class="<?php echo (($index=='enquiryM')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/enquiryM/enquiryList'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Enquiries</a>
                </li>
                <!-- <li data-menu="" class="<?php echo (($index=='manageVideo')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/videoM/manageVideo'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Videos</a>
                </li> -->
                <li data-menu="" class="<?php echo (($index=='manageRevenue')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('Location/manageRevenue'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Revenue Districts (U.P)</a>
                </li>
                <!-- <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item align-items-center dropdown-toggle" href="#" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Revenue Districts (U.P)</a>
                  <ul class="dropdown-menu">
                    <li data-menu="" class="<?php echo (($index=='manageState') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Location/manageState'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>States</a>
                    </li>
                    <li data-menu="" class="<?php echo (($index=='manageRevenue') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Location/manageRevenue'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Revenue Districts</a>
                    </li>
                    
                  </ul>
                </li> -->
                <li data-menu="" class="<?php echo (($index=='employee') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/employeeM/manageEmployee'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>CEL Employees</a>
                </li>
              </ul>
            </li>
            <li class="<?php echo ($index =='Mother'  ? 'active' : ''); ?>" data-menu=""><a class="dropdown-toggle nav-link" href="<?php echo base_url(); ?>motherM/registeredMother/all/all"><i class="menu-livicon" data-icon="user"></i><span data-i18n="Dashboard">Mothers</span></a>
            </li>
            <li class="<?php echo ($index =='Baby'  ? 'active' : ''); ?>" data-menu=""><a class="dropdown-toggle nav-link" href="<?php echo base_url(); ?>babyM/registeredBaby/1/all"><i class="menu-livicon" data-icon="user"></i><span data-i18n="Dashboard">Infants</span></a>
            </li>
            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="report"></i><span>Reports</span></a>
              <ul class="dropdown-menu">
                <!-- <li data-menu="" class="<?php echo (($index=='report') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Admin/statisticsReport'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Statistics Report</a>
                </li> -->
                <!-- <li data-menu="" class="<?php echo (($index=='report1') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Admin/downloadReports'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Download Reports</a>
                </li> -->
                <!-- <li data-menu="" class="<?php echo (($index=='report2') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Admin/generateReport'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Generate Reports</a>
                </li> -->
                <li data-menu="" class="<?php echo (($index=='report2') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/GenerateReportM/manageGeneralReport'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Generate Reports</a>
                </li>
              </ul>
            </li>
            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="counselling"></i><span>Counselling</span></a>
              <ul class="dropdown-menu">
                <li data-menu="" class="<?php echo (($index=='manageCounsellingVideos')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/counsellingM/manageCounsellingVideos'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Counselling Videos</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='manageApplicationVideos')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/counsellingM/manageApplicationVideos'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Application Training Videos</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='manageCounsellingPoster')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/counsellingM/manageCounsellingPoster'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Counselling Poster</a>
                </li>
              </ul>
            </li>
            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="communication"></i><span>Communication</span></a>
              <ul class="dropdown-menu">
                <li data-menu=""><a class="dropdown-item align-items-center" href="chart-apex.html" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>SMS</a>
                </li>
                <li data-menu=""><a class="dropdown-item align-items-center" href="chart-chartjs.html" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Notification</a>
                </li>
              </ul>
            </li>
            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="gear"></i><span>Miscellaneous</span></a>
              <ul class="dropdown-menu">
                <li data-menu="" class="<?php echo (($index=='manageNBCU')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/manageNBCU'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Newborn Care Unit Type</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='managementType')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/managementType'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Management Type</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='FacilityType')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/facility/facilityType/'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Facility Type</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='StaffType')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo base_url('staffM/staffType/');?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Staff Type</a>
                </li>
                <!-- <li data-menu="" class="<?php echo (($index=='videoType')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo base_url('videoM/videoType');?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Video Type</a>
                </li> -->
                <li data-menu="" class="<?php echo (($index=='manageTemplate')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/staffM/manageTemplate/'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>SMS Template</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='Sitemap')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/manageSitemap'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Sitemap</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='MenuGroup')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/viewMenuGroup'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Menu Group</a>
                </li>
                <li data-menu="" class="<?php echo (($index=='Setting')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/manageSetting/1'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Settings</a>
                </li>
              </ul>
            </li>
          </ul>
        <?php } else {
          $userPermittedMenuData = array();
          $userPermittedMenuData = $this->session->userdata('userPermission');
        ?>
          <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
            <?php if(in_array(1, $userPermittedMenuData)){ ?>
              <li class="<?php echo ($index =='index'  ? 'active' : ''); ?>" data-menu=""><a class="dropdown-toggle nav-link" href="<?php echo base_url(); ?>admin/dashboard"><i class="menu-livicon" data-icon="desktop"></i><span data-i18n="Dashboard">Dashboard</span></a>
              </li>
            <?php } ?>

            <?php if(in_array(2, $userPermittedMenuData)){ ?>
              <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="users"></i><span>Facilities</span></a>
                <ul class="dropdown-menu">
                  <?php if(in_array(3, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='facilities')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/facility/manageFacility'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Facilities</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(6, $userPermittedMenuData) || in_array(61, $userPermittedMenuData)){ ?>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item align-items-center dropdown-toggle" href="#" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Lounges</a>
                      <ul class="dropdown-menu">
                        <?php if(in_array(6, $userPermittedMenuData)){ ?>
                          <li data-menu="" class="<?php echo (($index=='lounge') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/loungeM/manageLounge'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Lounges Information</a>
                          </li>
                        <?php } ?>
                        <?php if(in_array(61, $userPermittedMenuData)){ ?>
                          <li data-menu="" class="<?php echo (($index=='temporaryLounge') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('loungeM/temporaryLounge'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Amenities Information</a>
                          </li>
                        <?php } ?>
                      </ul>
                    </li>
                  <?php } ?>

                  <?php if(in_array(9, $userPermittedMenuData) || in_array(65, $userPermittedMenuData)){ ?>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item align-items-center dropdown-toggle" href="#" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Staff</a>
                      <ul class="dropdown-menu">
                        <?php if(in_array(9, $userPermittedMenuData)){ ?>
                          <li data-menu="" class="<?php echo (($index=='staff') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/staffM/manageStaff'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Approved Staff</a>
                          </li>
                        <?php } ?>
                        <?php if(in_array(65, $userPermittedMenuData)){ ?>
                          <li data-menu="" class="<?php echo (($index=='temporaryStaff') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('staffM/temporaryStaff'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Not Approved Staff</a>
                          </li>
                        <?php } ?>
                      </ul>
                    </li>
                  <?php } ?>  

                  <?php if(in_array(14, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='coachM')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/coachM/coachList'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Coaches</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(12, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='enquiryM')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/enquiryM/enquiryList'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Enquiries</a>
                    </li>
                  <?php } ?>
                  
                  <?php if(in_array(17, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='manageRevenue')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('Location/manageRevenue'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Revenue Districts (U.P)</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(20, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='employee') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/employeeM/manageEmployee'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>CEL Employees</a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <?php if(in_array(23, $userPermittedMenuData)){ ?>
              <li class="<?php echo ($index =='Mother'  ? 'active' : ''); ?>" data-menu=""><a class="dropdown-toggle nav-link" href="<?php echo base_url(); ?>motherM/registeredMother/all/all"><i class="menu-livicon" data-icon="user"></i><span data-i18n="Dashboard">Mothers</span></a>
              </li>
            <?php } ?>

            <?php if(in_array(24, $userPermittedMenuData)){ ?>
              <li class="<?php echo ($index =='Baby'  ? 'active' : ''); ?>" data-menu=""><a class="dropdown-toggle nav-link" href="<?php echo base_url(); ?>babyM/registeredBaby/1/all"><i class="menu-livicon" data-icon="user"></i><span data-i18n="Dashboard">Infants</span></a>
              </li>
            <?php } ?>

            <?php if(in_array(25, $userPermittedMenuData)){ ?>
              <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="report"></i><span>Reports</span></a>
                <ul class="dropdown-menu">
                  <?php if(in_array(46, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='report2') ? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/GenerateReportM/manageGeneralReport'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Generate Reports</a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <?php if(in_array(48, $userPermittedMenuData)){ ?>
              <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="counselling"></i><span>Counselling</span></a>
                <ul class="dropdown-menu">
                  <?php if(in_array(49, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='manageCounsellingVideos')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/counsellingM/manageCounsellingVideos'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Counselling Videos</a>
                    </li>
                  <?php } ?>
                  <?php if(in_array(50, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='manageApplicationVideos')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/counsellingM/manageApplicationVideos'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Application Training Videos</a>
                    </li>
                  <?php } ?>
                  <?php if(in_array(51, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='manageCounsellingPoster')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/counsellingM/manageCounsellingPoster'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Counselling Poster</a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <?php if(in_array(26, $userPermittedMenuData)){ ?>
              <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="communication"></i><span>Communication</span></a>
                <ul class="dropdown-menu">
                  <?php if(in_array(27, $userPermittedMenuData)){ ?>
                    <li data-menu=""><a class="dropdown-item align-items-center" href="chart-apex.html" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>SMS</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(28, $userPermittedMenuData)){ ?>
                    <li data-menu=""><a class="dropdown-item align-items-center" href="chart-chartjs.html" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Notification</a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>

            <?php if(in_array(29, $userPermittedMenuData)){ ?>
              <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon" data-icon="gear"></i><span>Miscellaneous</span></a>
                <ul class="dropdown-menu">
                  <?php if(in_array(30, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='manageNBCU')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/manageNBCU'); ?>" data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Newborn Care Unit Type</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(33, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='managementType')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/managementType'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Management Type</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(36, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='FacilityType')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/facility/facilityType/'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Facility Type</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(39, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='StaffType')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo base_url('staffM/staffType/');?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Staff Type</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(45, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='manageTemplate')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/staffM/manageTemplate/'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>SMS Template</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(52, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='Sitemap')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/manageSitemap'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Sitemap</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(42, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='MenuGroup')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/viewMenuGroup'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Menu Group</a>
                    </li>
                  <?php } ?>

                  <?php if(in_array(47, $userPermittedMenuData)){ ?>
                    <li data-menu="" class="<?php echo (($index=='Setting')? 'active' : ''); ?>"><a class="dropdown-item align-items-center" href="<?php echo site_url('/Miscellaneous/manageSetting/1'); ?>" data-toggle="dropdown" ><i class="bx bx-right-arrow-alt"></i>Settings</a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
          </ul>
      <?php } ?>
      </div>
      <!-- /horizontal menu content-->
    </div>
    <!-- END: Main Menu-->