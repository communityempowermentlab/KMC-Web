
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add Report</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staffM/manageStaff/">Generate Report</a>
                </li>
                <li class="breadcrumb-item active">Add Report
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('GenerateReportM/AddGenerateReportPost/');?>" enctype="multipart/form-data">

              <div class="col-12">
                <h5 class="float-left pr-1">Report Information</h5>
              </div>
              
              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Subject <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" required="" data-validation-required-message="This field is required" name="subject" id="subject" placeholder="Subject">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Body <span class="red">*</span></label>
                      <div class="controls">
                        <textarea class="form-control" id="body" rows="3" placeholder="Enter Body" name="body" required=""></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Email To <span class="red">*</span></label>
                      <div class="controls">
                        <textarea class="form-control" id="email" rows="3" placeholder="Email To" name="email" required=""></textarea>
                      </div>
                    </div>
                  </div>
                  
              </div>

              <div class="row col-12">

                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>Email From <span class="red">*</span></label>
                      <div class="controls">
                        <input type="Email" class="form-control" name="emailFrom" id="emailFrom" placeholder="Email From">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Subscribe </label>
                      <div class="controls">
                        <label class="switch">
                          <input type="checkbox" name="subscription" value="Yes">
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
                        <select class="select2 form-control" multiple="multiple" name="facility[]" id="facility<?php echo $districtValue['PRIDistrictCode'] ?>" onchange="getFacilityMultipleLounge('<?php echo $districtValue['PRIDistrictCode'] ?>','<?php echo base_url('GenerateReportM/getFacilityMultipleLounge') ?>','');">
                          <?php foreach($GetFacilities as $GetFacilitiesData){ ?>
                            <option value="<?php echo $GetFacilitiesData['FacilityID']?>"><?php echo $GetFacilitiesData['FacilityName'] ?></option>
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
                        <select class="select2 form-control" multiple="multiple" name="lounge[]" id="lounge<?php echo $districtValue['PRIDistrictCode'] ?>"></select>
                        <span class="custom-error" id="err_lounge"></span>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              
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
</script>


    