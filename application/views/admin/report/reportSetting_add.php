
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
 <?php //print_r($GetFacilities); ?>  
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
                    <label>Body </label>
                    <div class="controls">
                      <textarea class="form-control" id="body" rows="3" placeholder="Enter Body" name="body" required=""></textarea>
                    </div>
                  </div>
                </div>

                <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="facilityId[]" id="facilityId" required="" data-validation-required-message="This field is required"  multiple="multiple">
                          <?php
                            foreach ($GetFacilities as $key => $value) {?>
                              <option value="<?php echo $value['FacilityID']; ?>"><?php echo $value['FacilityName']; ?></option>
                          <?php } ?>
                        </select>
                        
                      </div>
                    </div>
                  </div> -->
                  
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" multiple="multiple" name="district[]" id="district" onchange="getMultipleFacility('<?php echo base_url('coachM/getFacility/') ?>')">
                          <?php foreach ($GetDistrict as $key => $value) {?>
                            <option value ="<?php echo $value['PRIDistrictCode']?>" ><?php echo $value['DistrictNameProperCase'] ?></option>
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
                          
                        </select>
                        <span class="custom-error" id="err_lounge"></span>
                        
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Email To <span class="red">*</span></label>
                      <div class="controls">
                        <textarea class="form-control" id="email" rows="3" placeholder="Email To" name="email" required=""></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>Email From</label>
                      <div class="controls">
                        <input type="Email" class="form-control" name="emailFrom" id="emailFrom" placeholder="email From">
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


    