<!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">

  <!--********* First Section *************-->
  <div class="row">
    <div class="col-xl-12 col-12 dashboard-users">
    <div class="row  ">
      <!-- Statistics Cards Starts -->
      <div class="col-12">
        <div class="row">
          
          <div class="col-sm-2 col-12 dashboard-users-success">
            <a href="<?php echo base_url('facility/manageFacility'); ?>">
              <div class="card text-center">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                      <i class="bx bxs-bank font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis">Total Facilities</div>
                    <h3 class="mb-0"><?php echo $getDashboardData['facility_count']; ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-2 col-12 dashboard-users-danger">
            <a href="<?php echo base_url('loungeM/manageLounge'); ?>">
              <div class="card text-center">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                      <i class="bx bxs-institution font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis">Total Lounges</div>
                    <h3 class="mb-0"><?php echo $getDashboardData['lounge_count']; ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-2 col-12 dashboard-users-success">
            <a href="<?php echo base_url('staffM/manageStaff'); ?>">
              <div class="card text-center">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                      <i class="bx bx-user font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis">Total Registered Staff</div>
                    <h3 class="mb-0"><?php echo $getDashboardData['staff_count']; ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-2 col-12 dashboard-users-danger">
            <a href="<?php echo base_url('enquiryM/enquiryList'); ?>">
              <div class="card text-center">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                      <i class="bx bx-mail-send font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis">Total Enquiries</div>
                    <h3 class="mb-0"><?php echo $getDashboardData['total_enquiry']; ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-2 col-12 dashboard-users-success">
            <a href="<?php echo base_url('videoM/manageVideo'); ?>">
              <div class="card text-center">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                      <i class="bx bx-video font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis">Total Videos</div>
                    <h3 class="mb-0"><?php echo $getDashboardData['total_video']; ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-sm-2 col-12 dashboard-users-danger">
            <a href="<?php echo base_url('employeeM/manageEmployee'); ?>">
              <div class="card text-center">
                <div class="card-content">
                  <div class="card-body py-1">
                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                      <i class="bx bx-group font-medium-5"></i>
                    </div>
                    <div class="text-muted line-ellipsis">Total CEL Employees</div>
                    <h3 class="mb-0"><?php echo $getDashboardData['cel_emp_count']; ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

        </div>
      </div>
      <!-- Revenue Growth Chart Starts -->
    </div>
  </div>
  </div>
  <!-- *********************************** -->

  <div class="row">
    <!-- Greetings Content Starts -->
    <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
      <div class="card">
        <div class="card-header">
          <h3 class="greeting-text">Congratulations Lounge02!</h3>
          <p class="mb-0">Best lounge of the month</p>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-end">
              <div class="dashboard-content-left">
                <h1 class="text-primary font-large-2 text-bold-500">135</h1>
                <p>You have done 57.6% more admission today.</p>
                <a href="<?php echo base_url(); ?>babyM/registeredBaby/1/all"><button type="button" class="btn btn-primary glow">View All</button></a>
              </div>
              <div class="dashboard-content-right">
                <img src="<?php echo base_url(); ?>app-assets/images/icon/cup.png" height="220" width="220" class="img-fluid"
                  alt="Dashboard Ecommerce" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Multi Radial Chart Starts -->
    <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Enquiries of 2020</h4>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div id="multi-radial-chart"></div>
            <ul class="list-inline d-flex justify-content-around mb-0">
              <li> <span class="bullet bullet-xs bullet-success mr-50"></span>Closed</li>
              <li> <span class="bullet bullet-xs bullet-danger mr-50"></span>Cancelled</li>
              <li> <span class="bullet bullet-xs bullet-warning mr-50"></span>Pending</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
      <div class="card">
        <div class="card-header">
          <h3 class="greeting-text">Congratulations Lounge02!</h3>
          <p class="mb-0">Best lounge of the month</p>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-end">
              <div class="dashboard-content-left">
                <h1 class="text-primary font-large-2 text-bold-500">135</h1>
                <p>You have done 57.6% more admission today.</p>
                <a href="<?php echo base_url(); ?>babyM/registeredBaby/1/all"><button type="button" class="btn btn-primary glow">View All</button></a>
              </div>
              <div class="dashboard-content-right">
                <img src="<?php echo base_url(); ?>app-assets/images/icon/cup.png" height="220" width="220" class="img-fluid"
                  alt="Dashboard Ecommerce" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    
    <!-- Marketing Campaigns Starts -->
    <div class="col-xl-4 col-12 dashboard-marketing-campaign">
      <div class="card marketing-campaigns">
        <div class="card-header d-flex justify-content-between align-items-center pb-1">
          <h4 class="card-title d-flex mb-25 mb-sm-0">
            <i class="bx bxs-institution font-medium-5 pl-25 pr-75"></i>List Of Lounges
          </h4>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        
        <div class="table-responsive">
          <!-- table start -->
          <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Last&nbsp;Activity</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              
              <?php foreach ($getDashboardData['lounge_list'] as $key => $value) {
                if($value['logoutTime'] != '0000-00-00 00:00:00'){
                  $last_activity =     $this->load->FacilityModel->time_ago_in_php($value['logoutTime']);
                } else {
                  $last_activity =     $this->load->FacilityModel->time_ago_in_php($value['loginTime']);
                }
              ?>
                <tr>
                  <td class="py-1 line-ellipsis">
                    <?= $value['loungeName']; ?>
                  </td>
                  <td class="text-success py-1"><?= $last_activity; ?></td>
                  <td class="text-center py-1">
                    <a class="btn btn-sm btn-info" href="<?php echo base_url() ?>loungeM/updateLounge/<?= $value['loungeMasterId'] ?>">View</a>
                  </td>
                </tr>
              <?php } ?>
              
              
            </tbody>
          </table>
          <!-- table ends -->
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-12 dashboard-marketing-campaign">
      <div class="card marketing-campaigns">
        <div class="card-header d-flex justify-content-between align-items-center pb-1">
          <h4 class="card-title">List Of Staff</h4>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        
        <div class="table-responsive">
          <!-- table start -->
          <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Last Activity</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($getDashboardData['staff_list'] as $key => $value) {
                if($value['modifyDate'] != '0000-00-00 00:00:00'){
                  $last_activity =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);
                } else {
                  $last_activity =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                }
              ?>
                <tr>
                  <td class="py-1 line-ellipsis">
                    <?= $value['name']; ?>
                  </td>
                  <td class="text-success py-1"><?= $last_activity; ?></td>
                  <td class="text-center py-1">
                    <a class="btn btn-sm btn-info" href="<?php echo base_url() ?>staffM/updateStaff/<?= $value['staffId'] ?>">View</a>
                  </td>
                </tr>
              <?php } ?>
              
            </tbody>
          </table>
          <!-- table ends -->
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-12 dashboard-marketing-campaign">
      <div class="card marketing-campaigns">
        <div class="card-header d-flex justify-content-between align-items-center pb-1">
          <h4 class="card-title">List Of CEL Employees</h4>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        
        <!-- <div class="table-responsive"> -->
          <!-- table start -->
          <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Last Activity</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($getDashboardData['cel_emp_list'] as $key => $value) {
                if($value['loginTime'] != ''){
                  $last_activity =     $this->load->FacilityModel->time_ago_in_php($value['loginTime']);
                } else {
                  $last_activity =     '--';
                }
              ?>
                <tr>
                  <td class="py-1 line-ellipsis">
                    <?= $value['name']; ?>
                  </td>
                  <td class="text-success py-1"><?= $last_activity; ?></td>
                  <td class="text-center py-1">
                    <a class="btn btn-sm btn-info" href="<?php echo base_url() ?>employeeM/updateEmployee/<?= $value['id'] ?>">View</a>
                  </td>
                </tr>
              <?php } ?>
              
            </tbody>
          </table>
          <!-- table ends -->
        <!-- </div> -->
      </div>
    </div>
  </div>
</section>
<!-- Dashboard Ecommerce ends -->

        </div>
      </div>
    </div>

    <!-- <div class="customizer d-none d-md-block">
      <a class="customizer-close" href="#"><i class="bx bx-x"></i></a><a class="customizer-toggle" href="#"><i class="bx bx-cog bx bx-spin white"></i></a>
      <div class="customizer-content p-2">
      <h4 class="text-uppercase mb-0">Theme Customizer</h4>
      <small>Customize & Preview in Real Time</small>
      <hr>
 
      <h5 class="mt-1">Theme Layout</h5>
      <div class="theme-layouts">
        <div class="d-flex justify-content-start">
          <div class="mx-50">
            <fieldset>
              <div class="radio">
                <input type="radio" name="layoutOptions" value="false" id="radio-light" class="layout-name" data-layout=""
                  checked>
                <label for="radio-light">Light</label>
              </div>
            </fieldset>
          </div>
          <div class="mx-50">
            <fieldset>
              <div class="radio">
                <input type="radio" name="layoutOptions" value="false" id="radio-dark" class="layout-name"
                  data-layout="dark-layout">
                <label for="radio-dark">Dark</label>
              </div>
            </fieldset>
          </div>
          <div class="mx-50">
            <fieldset>
              <div class="radio">
                <input type="radio" name="layoutOptions" value="false" id="radio-semi-dark" class="layout-name"
                  data-layout="semi-dark-layout">
                <label for="radio-semi-dark">Semi Dark</label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>

      <hr>

      <div id="customizer-theme-colors">
        <h5>Menu Colors</h5>
        <ul class="list-inline unstyled-list">
          <li class="color-box bg-primary selected" data-color="theme-primary"></li>
          <li class="color-box bg-success" data-color="theme-success"></li>
          <li class="color-box bg-danger" data-color="theme-danger"></li>
          <li class="color-box bg-info" data-color="theme-info"></li>
          <li class="color-box bg-warning" data-color="theme-warning"></li>
          <li class="color-box bg-dark" data-color="theme-dark"></li>
        </ul>
        <hr>
      </div>

      <div id="menu-icon-animation">
        <div class="d-flex justify-content-between align-items-center">
          <div class="icon-animation-title">
            <h5 class="pt-25">Icon Animation</h5>
          </div>
          <div class="icon-animation-switch">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" checked id="icon-animation-switch">
              <label class="custom-control-label" for="icon-animation-switch"></label>
            </div>
          </div>
        </div>
        <hr>
      </div>

      <div class="collapse-sidebar d-flex justify-content-between align-items-center">
        <div class="collapse-option-title">
          <h5 class="pt-25">Collapse Menu</h5>
        </div>
        <div class="collapse-option-switch">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="collapse-sidebar-switch">
            <label class="custom-control-label" for="collapse-sidebar-switch"></label>
          </div>
        </div>
      </div>

      <hr>

      <div id="customizer-navbar-colors">
        <h5>Navbar Colors</h5>
        <ul class="list-inline unstyled-list">
          <li class="color-box bg-white border selected" data-navbar-default=""></li>
          <li class="color-box bg-primary" data-navbar-color="bg-primary"></li>
          <li class="color-box bg-success" data-navbar-color="bg-success"></li>
          <li class="color-box bg-danger" data-navbar-color="bg-danger"></li>
          <li class="color-box bg-info" data-navbar-color="bg-info"></li>
          <li class="color-box bg-warning" data-navbar-color="bg-warning"></li>
          <li class="color-box bg-dark" data-navbar-color="bg-dark"></li>
        </ul>
        <small><strong>Note :</strong> This option with work only on sticky navbar when you scroll page.</small>
        <hr>
      </div>

      <h5>Navbar Type</h5>
      <div class="navbar-type d-flex justify-content-start">
        <div class="hidden-ele mx-50">
          <fieldset>
            <div class="radio">
              <input type="radio" name="navbarType" value="false" id="navbar-hidden">
              <label for="navbar-hidden">Hidden</label>
            </div>
          </fieldset>
        </div>
        <div class="mx-50">
          <fieldset>
            <div class="radio">
              <input type="radio" name="navbarType" value="false" id="navbar-static">
              <label for="navbar-static">Static</label>
            </div>
          </fieldset>
        </div>
        <div class="mx-50">
          <fieldset>
            <div class="radio">
              <input type="radio" name="navbarType" value="false" id="navbar-sticky" checked>
              <label for="navbar-sticky">Fixed</label>
            </div>
          </fieldset>
        </div>
      </div>
      <hr>

      <h5>Footer Type</h5>
      <div class="footer-type d-flex justify-content-start">
        <div class="mx-50">
          <fieldset>
            <div class="radio">
              <input type="radio" name="footerType" value="false" id="footer-hidden">
              <label for="footer-hidden">Hidden</label>
            </div>
          </fieldset>
        </div>
        <div class="mx-50">
          <fieldset>
            <div class="radio">
              <input type="radio" name="footerType" value="false" id="footer-static" checked>
              <label for="footer-static">Static</label>
            </div>
          </fieldset>
        </div>
        <div class="mx-50">
          <fieldset>
            <div class="radio">
              <input type="radio" name="footerType" value="false" id="footer-sticky">
              <label for="footer-sticky" class="">Sticky</label>
            </div>
          </fieldset>
        </div>
      </div>

      <hr>

      <div class="card-shadow d-flex justify-content-between align-items-center py-25">
        <div class="hide-scroll-title">
          <h5 class="pt-25">Card Shadow</h5>
        </div>
        <div class="card-shadow-switch">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" checked id="card-shadow-switch">
            <label class="custom-control-label" for="card-shadow-switch"></label>
          </div>
        </div>
      </div>

      <hr>

      
      <div class="hide-scroll-to-top d-flex justify-content-between align-items-center py-25">
        <div class="hide-scroll-title">
          <h5 class="pt-25">Hide Scroll To Top</h5>
        </div>
        <div class="hide-scroll-top-switch">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="hide-scroll-top-switch">
            <label class="custom-control-label" for="hide-scroll-top-switch"></label>
          </div>
        </div>
      </div>
      
      </div>
    </div> -->
    <!-- End: Customizer-->

    
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
