

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add Lounge</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                </li>
                <li class="breadcrumb-item active">Add Lounge
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('loungeM/addLounge/');?>">

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
                              <option value="<?php echo $value['PRIDistrictCode']; ?>"><?php echo $value['DistrictNameProperCase']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="facility_id" id="facilityname" required="" data-validation-required-message="This field is required">
                          <option value="">Select Facility</option>
                          
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
                          <option value="1">Yes</option>
                          <option value="2">No</option>
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
                        <input type="text" class="form-control" data-validation-required-message="This field is required" name="lounge_name" id="lounge_name" placeholder="Lounge Name / Number">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>TAB Unique Number</label>
                      <div class="controls">
                        <input type="text" class="form-control" onblur="checkTabUniqueness(this.value, '<?php echo site_url('loungeM/checkExistImei')?>', 'add')" name="imeiNumber" id="imei" placeholder="TAB Unique Number">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Lounge Mobile Number</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="lounge_contact_number" id="lounge_contact_number" placeholder="Lounge Mobile Number" data-validation-regex-regex="([^a-z]*[A-Z]*)*" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+"
                        maxlength="10" minlength="10">
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Lounge Password <span class="red">*</span></label>
                    <div class="controls">
                      <input type="password" class="form-control" data-validation-required-message="This field is required" name="lounge_password" id="lounge_password" placeholder="Lounge Password">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Lounge Location / Address <span class="red">*</span></label>
                    <div class="controls">
                      <textarea class="form-control" id="addr" rows="3" placeholder="Lounge Location / Address" required="" data-validation-required-message="This field is required" name="address"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Header menus -->
              <br>
              <div class="col-12">
                <h5 class="float-left pr-1">Header Menus Privilege</h5>
              </div>

              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Menu Group</label>
                    <div class="controls">
                      <select class="select2 form-control" multiple="multiple" name="menu_group[]" id="menu_group">
                        <?php foreach ($menuGroup as $key => $value) {?>
                          <option value ="<?php echo $value['id']?>" ><?php echo $value['groupName'] ?></option>
                        <?php } ?>
                      </select>
                      <span class="custom-error" id="err_menu_group"></span>
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


    