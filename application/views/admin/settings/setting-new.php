<div class="app-content content">
  <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
          <div class="row breadcrumbs-top">
            <div class="col-12">
              <h5 class="content-header-title float-left pr-1 mb-0">Settings</h5>
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb p-0 mb-0">
                  <li class="breadcrumb-item"><a href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/html/ltr/horizontal-menu-template/index.html"><i class="bx bx-home-alt"></i></a>
                  </li>
                  <?php $tabArray = array('1'=>'General Settings','2'=>'Enquiry Settings','3'=>'Danger Notification Settings','4'=>'Baseline Information'); ?>
                  <li class="breadcrumb-item active"> <?php echo $tabArray[$page_type]; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
      <section id="page-account-settings">
          <div class="row">
              <div class="col-12">
                  <div class="row">
                      <!-- left menu section -->
                      <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                          <ul class="nav nav-pills flex-column">
                              <li class="nav-item">
                                  <a class="nav-link d-flex align-items-center <?php if($page_type == "1"){ echo "active"; } ?>" id="account-pill-general" href="<?php echo base_url('Miscellaneous/manageSetting/1'); ?>" aria-expanded="true">
                                      <i class="bx bx-cog"></i>
                                      <span>General Settings</span>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link d-flex align-items-center <?php if($page_type == "2"){ echo "active"; } ?>" id="account-pill-password" href="<?php echo base_url('Miscellaneous/manageSetting/2'); ?>" aria-expanded="false">
                                      <i class="bx bx-mail-send"></i>
                                      <span>Enquiry Settings</span>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link d-flex align-items-center <?php if($page_type == "3"){ echo "active"; } ?>" id="account-pill-info"  href="<?php echo base_url('Miscellaneous/manageSetting/3'); ?>" aria-expanded="false">
                                      <i class="bx bx-error"></i>
                                      <span>Danger Notification Settings</span>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link d-flex align-items-center <?php if($page_type == "4"){ echo "active"; } ?>" id="account-pill-social" href="<?php echo base_url('Miscellaneous/manageSetting/4'); ?>" aria-expanded="false">
                                      <i class="bx bx-info-circle"></i>
                                      <span>Baseline Information</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                      <!-- right content section -->
                      <div class="col-md-9">
                          <div class="card">
                              <div class="card-content">
                                  <div class="card-body">
                                      <div id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>

                                      <div class="tab-content">

                                          <!--********************************* First Tab ****************************-->
                                          <div role="tabpanel" class="tab-pane <?php if($page_type == "1"){ echo "active"; } ?>" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">

                                            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/updateGeneralSettings/1');?>" enctype="multipart/form-data">

                                              <div class="col-12">
                                                <h5 class="float-left pr-1">Settings For Dashboard Table</h5>
                                              </div>
                                              
                                              <div class="row col-12">
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>For Lounge <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="lounge" id="lounge" placeholder="For Lounge" required="" data-validation-required-message="This field is required" value="<?= $result['dashboardLounge']; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>For Staff <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="staff" id="staff" placeholder="For Staff" required="" data-validation-required-message="This field is required" value="<?= $result['dashboardStaff']; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>For CEL Employees <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="cel_employees" placeholder="For CEL Employees" id="cel_employees" required="" data-validation-required-message="This field is required" value="<?= $result['dashboardCelEmp']; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                                              </div>

                                              <div class="row col-12">
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>For Low Bed Occupancy <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="low_bed_occupancy" id="low_bed_occupancy" placeholder="For Low Bed Occupancy" required="" data-validation-required-message="This field is required" value="<?= $result['dashboardLowBed']; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>For Amenities Information <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="amenities_info" id="amenities_info" placeholder="For Amenities Information" required="" data-validation-required-message="This field is required" value="<?= $result['dashboardAmenitiesInfo']; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                                                  
                                              </div>
                                              
                                              <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                              
                                          </div>

                                          <!--********************************* Second Tab ***************************-->
                                          <div class="tab-pane <?php if($page_type == "2"){ echo "active"; } ?>" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                              
                                              <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/updateEnquirySettings/2');?>" enctype="multipart/form-data">

                                                  <div class="row col-12">
                                                    <div class="col-md-3">
                                                      <div class="form-group">
                                                        <label>Send Sms on New enquiry <span class="red">*</span></label>
                                                        <div class="controls">
                                                          <input type="radio" class="checkbox-input set_heads" name="newEnquiryNotification" id="newEnquiryNotification" value="1" <?php if($result['newEnquiryNotification'] == "1"){ echo "checked"; } ?> onclick="openEnquiryNotificationMobiles(1);"> On
                                                          <input type="radio" class="checkbox-input set_heads" name="newEnquiryNotification" id="newEnquiryNotification" value="0" <?php if($result['newEnquiryNotification'] == "0"){ echo "checked"; } ?> onclick="openEnquiryNotificationMobiles(0);"> Off
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <div class="col-md-5" id="newEnquiryNotificationMobileDiv" style="display: none;">
                                                      <div class="form-group">
                                                        <label>Enter Mobile Numbers (comma seperated) <span class="red">*</span></label>
                                                        <div class="controls">
                                                          <input type="text" class="form-control" name="newEnquiryNotificationMobiles" id="newEnquiryNotificationMobiles" placeholder="Enter Mobile Numbers (comma seperated)" value="<?= $result['newEnquiryNotificationMobiles']; ?>" autocomplete="off">
                                                        </div>
                                                      </div>
                                                    </div>

                                                  </div>
                                                
                                                <button type="submit" class="btn btn-primary">Submit</button>

                                              </form>

                                          </div>

                                          <!--********************************* Third Tab ***************************-->
                                          <div class="tab-pane <?php if($page_type == "3"){ echo "active"; } ?>" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                                              
                                            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/updateDangerNotificationSettings/3');?>" enctype="multipart/form-data">

                                              <div class="col-12">
                                                <h5 class="float-left pr-1">Lounge Notification</h5>
                                              </div>

                                              <div class="row col-12">
                                                <div class="col-md-4">
                                                  <div class="form-group">
                                                    <label>Allow Lounge Notification <span class="red">*</span></label>
                                                    <div class="controls">
                                                      <input type="radio" class="checkbox-input set_heads" name="admin_lounge_notification" id="admin_lounge_notification" value="1" <?php if($result['adminLoungeNotification'] == "1"){ echo "checked"; } ?> onclick="openNotificationMobiles(1);"> On
                                                      <input type="radio" class="checkbox-input set_heads" name="admin_lounge_notification" id="admin_lounge_notification" value="0" <?php if($result['adminLoungeNotification'] == "0"){ echo "checked"; } ?> onclick="openNotificationMobiles(0);"> Off
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="col-md-4" id="admin_lounge_notification_mobiles_div" style="display: none;">
                                                  <div class="form-group">
                                                    <label>Enter Mobile Numbers (comma seperated) <span class="red">*</span></label>
                                                    <div class="controls">
                                                      <input type="text" class="form-control" name="admin_lounge_notification_mobiles" id="admin_lounge_notification_mobiles" placeholder="Enter Mobile Numbers (comma seperated)" value="<?= $result['adminLoungeNotificationMobiles']; ?>" autocomplete="off">
                                                    </div>
                                                  </div>
                                                </div>

                                              </div>
                                            
                                            <button type="submit" class="btn btn-primary">Submit</button>

                                            </form>

                                          </div>

                                          <!--********************************* Fourth Tab ***************************-->
                                          <div class="tab-pane <?php if($page_type == "4"){ echo "active"; } ?>" id="account-vertical-social" role="tabpanel" aria-labelledby="account-pill-social" aria-expanded="false">
                                              
                                            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/updateBaselineSettings/4');?>" enctype="multipart/form-data">

                                                <div class="col-12">
                                                  <h5 class="float-left pr-1">Amenities Value Should Be Updated After</h5>
                                                </div>

                                                <div class="row col-12">
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>Enter No. Of Days <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="amenities_value_updation" id="amenities_value_updation" placeholder="Enter No. Of Days" required="" data-validation-required-message="This field is required" value="<?= $result['amenitiesValueUpdation']; ?>" onkeypress="checkNum(event)">
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="col-12">
                                                  <h5 class="float-left pr-1">Amenities</h5>
                                                </div>

                                                <div class="row col-12">
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>OTP Verification for Updating Amenities <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="radio" class="checkbox-input set_heads" name="amenities_register_sms_notification" id="amenities_register_sms_notification" value="1" <?php if($result['amenitiesRegisterOtpVerification'] == "1"){ echo "checked"; } ?>> On
                                                        <input type="radio" class="checkbox-input set_heads" name="amenities_register_sms_notification" id="amenities_register_sms_notification" value="0" <?php if($result['amenitiesRegisterOtpVerification'] == "0"){ echo "checked"; } ?>> Off
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                      <label>War Room Alert Generation <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="radio" class="checkbox-input set_heads" name="warRoomAlertAmenities" id="warRoomAlertAmenities" value="1" <?php if($result['warRoomAlertAmenities'] == "1"){ echo "checked"; } ?> onclick="openWarRoomMobiles(this.value,'1');"> On
                                                        <input type="radio" class="checkbox-input set_heads" name="warRoomAlertAmenities" id="warRoomAlertAmenities" value="0" <?php if($result['warRoomAlertAmenities'] == "0"){ echo "checked"; } ?> onclick="openWarRoomMobiles(this.value,'1');"> Off
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-5" id="warRoomMobileDiv1" style="display: none;">
                                                    <div class="form-group">
                                                      <label>Enter Mobile Numbers (comma seperated) <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="warRoomAlertAmenitiesMobiles" id="warRoomAlertAmenitiesMobiles" placeholder="Enter Mobile Numbers (comma seperated)" value="<?= $result['warRoomAlertAmenitiesMobiles']; ?>" autocomplete="off">
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!-- *************** -->

                                                <div class="col-12">
                                                  <h5 class="float-left pr-1">Staff</h5>
                                                </div>

                                                <div class="row col-12">
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label>OTP Verification for Staff Registration <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="radio" class="checkbox-input set_heads" name="staff_register_sms_notification" id="staff_register_sms_notification" value="1" <?php if($result['staffRegisterOtpVerification'] == "1"){ echo "checked"; } ?>> On
                                                        <input type="radio" class="checkbox-input set_heads" name="staff_register_sms_notification" id="staff_register_sms_notification" value="0" <?php if($result['staffRegisterOtpVerification'] == "0"){ echo "checked"; } ?>> Off
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                      <label>War Room Alert Generation <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="radio" class="checkbox-input set_heads" name="warRoomAlertStaff" id="warRoomAlertStaff" value="1" <?php if($result['warRoomAlertStaff'] == "1"){ echo "checked"; } ?> onclick="openWarRoomMobiles(this.value,'2');"> On
                                                        <input type="radio" class="checkbox-input set_heads" name="warRoomAlertStaff" id="warRoomAlertStaff" value="0" <?php if($result['warRoomAlertStaff'] == "0"){ echo "checked"; } ?> onclick="openWarRoomMobiles(this.value,'2');"> Off
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-5" id="warRoomMobileDiv2" style="display: none;">
                                                    <div class="form-group">
                                                      <label>Enter Mobile Numbers (comma seperated) <span class="red">*</span></label>
                                                      <div class="controls">
                                                        <input type="text" class="form-control" name="warRoomAlertStaffMobiles" id="warRoomAlertStaffMobiles" placeholder="Enter Mobile Numbers (comma seperated)" value="<?= $result['warRoomAlertStaffMobiles']; ?>" autocomplete="off">
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>

                                          </div>

                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </section>
    
    </div>
  </div>
</div>

<script type="text/javascript">
  $( document ).ready(function() {
    openNotificationMobiles('<?php echo $result['adminLoungeNotification'] ?>');
    openWarRoomMobiles('<?php echo $result['warRoomAlertAmenities'] ?>','1');
    openWarRoomMobiles('<?php echo $result['warRoomAlertStaff'] ?>','2');
    openEnquiryNotificationMobiles('<?php echo $result['newEnquiryNotification'] ?>');
  });
  function openNotificationMobiles(status){
    if(status == 1){
      $('#admin_lounge_notification_mobiles_div').show();
    }else{
      $('#admin_lounge_notification_mobiles_div').hide();
    }
  }
  
  function openWarRoomMobiles(value,type){

    if(value == 1){
      $('#warRoomMobileDiv'+type).show();
    }else{
      $('#warRoomMobileDiv'+type).hide();
    }
  }

  function openEnquiryNotificationMobiles(status){
    if(status == 1){
      $('#newEnquiryNotificationMobileDiv').show();
    }else{
      $('#newEnquiryNotificationMobileDiv').hide();
    }
  }
</script>