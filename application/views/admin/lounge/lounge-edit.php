

   
    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">

<?php
  $last_updated =     $this->load->FacilityModel->time_ago_in_php($lastUpdate['addDate']);
?>


<!-- Input Validation start -->
<section class="input-validation">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0">Update Lounge</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                </li>
                <li class="breadcrumb-item active">Update Lounge 
                </li>
              </ol>
              <p style="float: right; color: black;"><b>Last Updated On:</b>&nbsp;<?php if(!empty($lastUpdate)) { ?><a class="tooltip" href="<?php echo base_url(); ?>loungeM/viewLoungeLog/<?php echo $GetLounge['loungeId']; ?>"><?php echo $last_updated ;?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($lastUpdate['addDate'])) ?></span></a>
              <?php } else {  echo "Not Updated"; } ?>
              </p>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url();?>loungeM/UpdateLoungePost/<?php echo $GetLounge['loungeId'];?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Lounge Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="district_name" id="district_name" required="" data-validation-required-message="This field is required" onchange="getFacility(this.value, '<?php echo base_url('loungeM/getFacility/') ?>')">
                          <option value="">Select District</option>
                          <?php
                            foreach ($GetDistrict as $key => $value) {?>
                              <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($value['PRIDistrictCode'] == $district_id) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="facilityname" id="facilityname" required="" data-validation-required-message="This field is required">
                          <option value="">Select Facility</option>
                          <?php foreach ($GetFacilities as $key => $value) { ?>
                           <option value="<?= $value['FacilityID']; ?>"  <?php if($value['FacilityID'] == $GetLounge['facilityId']) { echo 'selected'; } ?>><?= $value['FacilityName']; ?></option>
                         <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>KMC Lounge is part of MNCU unit? <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="isMNCUUnitPart" id="isMNCUUnitPart" required="" data-validation-required-message="This field is required">
                          <option value="">Select </option>
                          <option value="1" <?php if($GetLounge['isMNCUUnitPart'] == 1) { echo 'selected'; } ?>>Yes</option>
                          <option value="2" <?php if($GetLounge['isMNCUUnitPart'] == 2) { echo 'selected'; } ?>>No</option>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Lounge Name / Number <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" data-validation-required-message="This field is required" name="lounge_name" id="lounge_name" placeholder=">Lounge Name / Number" value="<?php echo $GetLounge['loungeName'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>TAB Unique Number</label>
                      <div class="controls">
                        <input type="text" class="form-control" onblur="checkTabUniqueness(this.value, '<?php echo site_url('loungeM/checkExistImei')?>', 'add')" name="imeiNumber" id="imei" placeholder="TAB Unique Number" value="<?php echo $GetLounge['imeiNumber'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Lounge Mobile Number</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="lounge_contact_number" id="lounge_contact_number" placeholder="Lounge Mobile Number" data-validation-regex-regex="([^a-z]*[A-Z]*)*" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+"
                        maxlength="10" minlength="10" value="<?php echo $GetLounge['loungeContactNumber'];?>">
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Lounge Password </label>
                    <div class="controls">
                      <fieldset>
                        <div class="input-group">
                          <input type="password" class="form-control" name="lounge_password" id="lounge_password" placeholder="Lounge Password">
                          <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2-password" onclick="showPassword()"><i class="bx bxs-show"></i></span>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Lounge Location / Address <span class="red">*</span></label>
                    <div class="controls">
                      <textarea class="form-control" id="addr" rows="3" placeholder="Lounge Location / Address" required="" data-validation-required-message="This field is required" name="address"><?php echo $GetLounge['address'];?></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label>Status <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="status" id="status" required="" data-validation-required-message="This field is required">
                          <option value="">Select Status</option>
                          <option value="1" <?php if($GetLounge['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($GetLounge['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                        </select>
                      </div>
                    </div>
                </div>
              </div>

              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Allow Lounge Notification</label>
                    <div class="controls">
                      <input type="radio" name="lounge_notification" id="lounge_notification" value="1" <?php if($GetLounge['lounge_notification'] == 1) { echo 'checked'; } ?>> On
                      <input type="radio" name="lounge_notification" id="lounge_notification" value="0" <?php if($GetLounge['lounge_notification'] == 0) { echo 'checked'; } ?>> Off
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


    