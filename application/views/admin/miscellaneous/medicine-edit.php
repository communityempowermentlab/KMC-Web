<?php 
$sessionData = $this->session->userdata('adminData'); 
$userPermittedMenuData = array();
$userPermittedMenuData = $this->session->userdata('userPermission');

if(($sessionData['Type']==2) && (in_array(88, $userPermittedMenuData) && !in_array(89, $userPermittedMenuData))){
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
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $pageHeading; ?> Medicine</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Miscellaneous/manageMedicine">Medicine</a>
                </li>
                <li class="breadcrumb-item active"><?php echo $pageHeading; ?> Medicine
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/editMedicine'); ?>/<?php echo $GetNBCUData['id']; ?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Medicine Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Medicine Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="nbcu_name" id="nbcu_name" placeholder="Medicine Name" required="" data-validation-required-message="This field is required" value="<?php echo $GetNBCUData['name']; ?>" <?php echo $inputDisable; ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Status <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="status" id="status" required="" data-validation-required-message="This field is required" <?php echo $dropdownDisable; ?>>
                          <option value="">Select Status</option>
                          <option value="1" <?php if($GetNBCUData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($GetNBCUData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
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


    