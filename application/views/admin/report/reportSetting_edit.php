<?php 
$sessionData = $this->session->userdata('adminData'); 
$userPermittedMenuData = array();
$userPermittedMenuData = $this->session->userdata('userPermission');

if(($sessionData['Type']==2) && (in_array(70, $userPermittedMenuData) && !in_array(71, $userPermittedMenuData))){
  $pageHeading = "View";
  $inputDisable = "readonly";
  $dropdownDisable = "disabled";
  $buttonDisable = "display:none;";
}else{
  $pageHeading = "Update";
  $inputDisable = "";
  $dropdownDisable = "";
  $buttonDisable = "";
}
?>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}


</style>
   
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
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $pageHeading; ?> Report</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staffM/manageStaff/">Generate Report</a>
                </li>
                <li class="breadcrumb-item active"><?php echo $pageHeading; ?> Report
                </li>
              </ol>
              
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url();?>GenerateReportM/UpdateReportPost/<?php echo $GetReport['id'];?>" enctype="multipart/form-data">

              <div class="col-12">
                <h5 class="float-left pr-1">Generate Report Information</h5>
              </div>

              <div class="row col-12">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Report Type <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="category" id="category">
                          <option value="">Select Report Category</option>
                          <?php
                            foreach ($reportCategory as $key => $value) {?>
                              <option value="<?php echo $value['id']; ?>" <?php if($GetReport['category'] == $value['id']) { echo 'selected'; } ?>><?php echo $value['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Subject <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" required="" data-validation-required-message="This field is required" name="subject" id="subject" value="<?php echo $GetReport['subject']; ?>" placeholder="Subject" <?php echo $inputDisable; ?>>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Body <span class="red">*</span></label>
                      <div class="controls">
                        <textarea class="form-control" id="body" rows="3" placeholder="Enter Body" name="body" required="" <?php echo $inputDisable; ?>><?php echo $GetReport['body']; ?></textarea>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Email To <span class="red">*</span></label>
                      <div class="controls">
                        <textarea class="form-control" id="email" rows="3" placeholder="Email To" name="email" required="" <?php echo $inputDisable; ?>><?php echo implode(",",$emails); ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>Email From <span class="red">*</span></label>
                      <div class="controls">
                        <input type="Email" class="form-control" name="emailFrom" id="emailFrom" placeholder="email From" value="<?php echo $GetReport['emailFrom']; ?>" <?php echo $inputDisable; ?>>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                  <div class="form-group">
                    <label>Subscribe </label>
                    <div class="controls">
                      <label class="switch">
                        <input type="checkbox" <?php if($GetReport['subscription']=="Yes"){ ?> checked=""<?php } ?> name="subscription" value="Yes" <?php echo $dropdownDisable; ?>>
                        <span class="slider round"></span>
                      </label>
                      
                    </div>
                  </div>
                </div>
              </div>
              <hr>

              <?php foreach ($GetDistrict as $key => $districtValue) { 
                $GetFacilities = $this->ReportSettingModel->GetFacilityByDistrict($districtValue['PRIDistrictCode']);
                ?>
                <div class="row col-12">
                  <div class="col-md-3">
                    <div class="form-group">
                      <?php if($key == 0){ ?>
                        <label>District</label>
                      <?php } ?>
                      <div class="controls">
                        <input type="text" class="form-control" value="<?php echo $districtValue['DistrictNameProperCase'] ?>" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <?php if($key == 0){ ?>
                        <label>Facility</label>
                      <?php } ?>
                      <div class="controls">
                        <select class="select2 form-control" multiple="multiple" name="facility[]" id="facility<?php echo $districtValue['PRIDistrictCode'] ?>" onchange="getFacilityMultipleLounge('<?php echo $districtValue['PRIDistrictCode'] ?>','<?php echo base_url('GenerateReportM/getFacilityMultipleLounge') ?>','<?php echo $reportid; ?>');" <?php echo $dropdownDisable; ?>>
                          <?php $facilityArray = array(); foreach($GetFacilities as $GetFacilitiesData){
                            if (in_array($GetFacilitiesData['FacilityID'], $fac_arr)){ 
                              array_push($facilityArray, $GetFacilitiesData['FacilityID']);
                            }
                          ?>
                            <option value="<?php echo $GetFacilitiesData['FacilityID']?>" <?php if (in_array($GetFacilitiesData['FacilityID'], $fac_arr)) { echo 'selected'; } ?>><?php echo $GetFacilitiesData['FacilityName'] ?></option>
                          <?php } ?>
                        </select>
                        <span class="custom-error" id="err_facility"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <?php if($key == 0){ ?>
                        <label>Lounge</label>
                      <?php } ?>
                      <div class="controls">
                        <select class="select2 form-control" multiple="multiple" name="lounge[]" id="lounge<?php echo $districtValue['PRIDistrictCode'] ?>" <?php echo $dropdownDisable; ?>>

                          <?php foreach ($facilityArray as $key => $value) {
                            $getFacility = $this->FacilityModel->GetFacilitiesById('facilitylist', $value); 
        
                           $getLounge = $this->ReportSettingModel->GetLoungeByFAcility($value); ?>
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

              <?php } ?>
              
              <button type="submit" class="btn btn-primary" style="<?php echo $buttonDisable; ?>">Submit</button>
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

  function openOtherStaffSubType(str){ 

    var selected_value = $('option:selected', str).attr('typevalue');
    if((selected_value == 'other') || (selected_value == 'others')){
      $('#staff_sub_type_other_div').show();
      $('#job_type_div1').hide();
      $('#job_type_div2').show();
      $('#staff_sub_type_val').val('Other');
    }else{
      $('#staff_sub_type_other_div').hide();
      $('#job_type_div1').show();
      $('#job_type_div2').hide();
      $('#staff_sub_type_val').val('');
    }
  }
</script>


    