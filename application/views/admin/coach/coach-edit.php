

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit Coach</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>coachM/coachList">Coaches</a>
                </li>
                <li class="breadcrumb-item active">Edit Coach
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo site_url('coachM/updateCoach/'.$GetCoachData['id']);?>" enctype="multipart/form-data" onsubmit="return coachValidate('2')">

              <div class="col-12">
                <h5 class="float-left pr-1">Coach Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="coach_name" id="coach_name" placeholder="Name" value="<?= $GetCoachData['name']; ?>">
                        <span class="custom-error" id="err_coach_name"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="mobileDiv">
                      <label>Mobile Number <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" onkeypress="checkNum(event)" onblur="checkCoachMobile(this.value, '<?php echo base_url() ?>coachM/checkCoachMobile', '<?= $GetCoachData['id']; ?>')" maxlength="10" name="coach_mobile_number" id="coach_mobile_number" placeholder="Mobile Number"  value="<?= $GetCoachData['mobile']; ?>">
                        <span class="custom-error" id="err_coach_mobile_number"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Password </label>
                    <div class="controls">
                      <fieldset>
                        <div class="input-group">
                          <input type="password" class="form-control hideCls" name="password" id="password" placeholder="Password">
                          <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2-password" onclick="showPassword('password')"><i class="bx bxs-show"></i></span>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" multiple="multiple" name="district[]" id="district" onchange="getMultipleFacility('<?php echo base_url('coachM/getFacility/') ?>')">
                          <?php foreach ($GetDistrict as $key => $value) {?>
                            <option value ="<?php echo $value['PRIDistrictCode']?>" <?php if (in_array($value['PRIDistrictCode'], $dis_arr)) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase'] ?></option>
                          <?php } ?>
                        </select>
                        <span class="custom-error" id="err_district"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" multiple="multiple" name="facility[]" id="facility" onchange="getMultipleLounge('<?php echo base_url('coachM/getLounge/') ?>')">
                          <?php foreach ($dis_arr as $key => $value) {
                            $getFacility = $this->LoungeModel->GetFacilityByDistrict($value); 
        
                            $getDistrict = $this->FacilityModel->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs', $value); ?>
                            <optgroup label="<?= $getDistrict['DistrictNameProperCase'] ?>">
                              <?php foreach ($getFacility as $key2 => $value2) { ?>
                                <option value="<?= $value ?>-<?= $value2['FacilityID'] ?>" <?php if (in_array($value2['FacilityID'], $fac_arr)) { echo 'selected'; } ?>><?= $value2['FacilityName']; ?></option>
                              <?php } ?>
                              
                            </optgroup>
                          <?php } ?>
                        </select>
                        <span class="custom-error" id="err_facility"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Lounge <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" multiple="multiple" name="lounge[]" id="lounge">
                          <?php foreach ($fac_arr as $key => $value) {
                            $getFacility = $this->FacilityModel->GetFacilitiesById('facilitylist', $value); 
        
                           $getLounge = $this->LoungeModel->GetLoungeByFAcility($value); ?>
                            <optgroup label="<?= $getFacility['FacilityName'] ?>">
                              <?php foreach ($getLounge as $key2 => $value2) { ?>
                                <option value="<?= $getFacility['PRIDistrictCode'] ?>-<?= $value ?>-<?= $value2['loungeId'] ?>" <?php if (in_array($value2['loungeId'], $lounge_arr)) { echo 'selected'; } ?>><?= $value2['loungeName']; ?></option>
                              <?php } ?>
                              
                            </optgroup>
                          <?php } ?>
                        </select>
                        <span class="custom-error" id="err_lounge"></span>
                        
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
                    <label>Menu Group <span class="red">*</span></label>
                    <div class="controls">
                      <select class="select2 form-control" multiple="multiple" name="menu_group[]" id="menu_group" data-validation-required-message="This field is required">
                        <?php foreach ($menuGroup as $key => $value) {?>
                          <option value ="<?php echo $value['id']?>" <?php if(in_array($value['id'], $key_arr)) { echo "selected"; } ?>><?php echo $value['groupName'] ?></option>
                        <?php } ?>
                      </select>
                      <span class="custom-error" id="err_menu_group"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Status <span class="red">*</span></label>
                    <div class="controls">
                      <select class="select2 form-control" name="status" id="status">
                          
                          <option value="1" <?php if($GetCoachData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($GetCoachData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                      </select>
                      <span class="custom-error" id="err_status"></span>
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