<?php 
$sessionData = $this->session->userdata('adminData'); 
$userPermittedMenuData = array();
$userPermittedMenuData = $this->session->userdata('userPermission');

if(($sessionData['Type']==2) && (in_array(38, $userPermittedMenuData) && !in_array(85, $userPermittedMenuData))){
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
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $pageHeading; ?> Facility Type</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>facility/facilityType/">Facility Type</a>
                </li>
                <li class="breadcrumb-item active"><?php echo $pageHeading; ?> Facility Type
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('facility/editFacilityType/'.$GetFacilities['id']);?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Facility Type Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility Type Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="hidden" name="FacilityTypeID" value="<?= $GetFacilities['id']; ?>">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" required="" data-validation-required-message="This field is required" value="<?= $GetFacilities['facilityTypeName'] ?>" <?php echo $inputDisable; ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Set Priority <span class="red">*</span></label>
                      <div class="controls">
                        <input type="hidden" name="status" value="1">
                        <select class="select2 form-control" name="priority" id="priority" required="" data-validation-required-message="This field is required" <?php echo $dropdownDisable; ?>>
                          <option value="">Set Priority</option>
                          <option value="1" <?php if($GetFacilities['priority'] == 1) { echo 'selected'; } ?>>1</option>
                          <option value="2" <?php if($GetFacilities['priority'] == 2) { echo 'selected'; } ?>>2</option>
                          <option value="3" <?php if($GetFacilities['priority'] == 3) { echo 'selected'; } ?>>3</option>
                          <option value="4" <?php if($GetFacilities['priority'] == 4) { echo 'selected'; } ?>>4</option>
                          <option value="5" <?php if($GetFacilities['priority'] == 5) { echo 'selected'; } ?>>5</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Status <span class="red">*</span></label>
                      <div class="controls">
                        <input type="hidden" name="status" value="1">
                        <select class="select2 form-control" name="Status" id="Status" required="" data-validation-required-message="This field is required" <?php echo $dropdownDisable; ?>>
                          <option value="">Select Status</option>
                          <option value="1" <?php if($GetFacilities['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($GetFacilities['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>
              
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


    