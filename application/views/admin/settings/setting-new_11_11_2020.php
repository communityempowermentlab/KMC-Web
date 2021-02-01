<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/sitemap.js"></script>
   
    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">




<!-- Input Validation start -->
<section class="input-validation">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0">Settings</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                
                <li class="breadcrumb-item active">Settings
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            
              <div id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
              <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/manageSetting/');?>" enctype="multipart/form-data">

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
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>OTP Verification for Staff Registration <span class="red">*</span></label>
                      <div class="controls">
                        <input type="radio" class="checkbox-input set_heads" name="staff_register_sms_notification" id="staff_register_sms_notification" value="1" <?php if($result['staffRegisterOtpVerification'] == "1"){ echo "checked"; } ?>> On
                        <input type="radio" class="checkbox-input set_heads" name="staff_register_sms_notification" id="staff_register_sms_notification" value="0" <?php if($result['staffRegisterOtpVerification'] == "0"){ echo "checked"; } ?>> Off
                      </div>
                    </div>
                  </div>
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
                        <input type="text" class="form-control" name="admin_lounge_notification_mobiles" id="admin_lounge_notification_mobiles" placeholder="Enter Mobile Numbers (comma seperated)" value="<?= $result['adminLoungeNotificationMobiles']; ?>">
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
</section>
<!-- Input Validation end -->
        </div>
      </div>
    </div>
    <!-- END: Content-->

    <script type="text/javascript">
      $( document ).ready(function() {
        openNotificationMobiles('<?php echo $result['adminLoungeNotification'] ?>');
      });
      function openNotificationMobiles(status){
        if(status == 1){
          $('#admin_lounge_notification_mobiles_div').show();
        }else{
          $('#admin_lounge_notification_mobiles_div').hide();
        }
      }
    </script>


    