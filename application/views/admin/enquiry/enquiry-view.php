<?php 
$sessionData = $this->session->userdata('adminData'); 
$userPermittedMenuData = array();
$userPermittedMenuData = $this->session->userdata('userPermission');

if(($sessionData['Type']==2) && (in_array(13, $userPermittedMenuData) && !in_array(68, $userPermittedMenuData))){
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

<?php
  $generated_on =     $this->load->FacilityModel->time_ago_in_php($GetData['addDate']);
  $last_updated =     $this->load->FacilityModel->time_ago_in_php($GetData['modifyDate']);
?>


<!-- Input Validation start -->
<section class="input-validation">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $pageHeading; ?> Enquiry</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>enquiryM/enquiryList">Enquiry</a>
                </li>
                <li class="breadcrumb-item active"><?php echo $pageHeading; ?> Enquiry
                </li>
              </ol>
              <p style="float: right; color: black;"> <b>Request Date</b> : <a class="tooltip nonclick_link"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($GetData['addDate'])) ?></span></a> | <b>Response Date</b> : <?php if ($GetData['responseGivenBy'] != '') { ?> 
                <a class="tooltip nonclick_link"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($GetData['modifyDate'])) ?></span></a>
                <?php  } else { echo "--"; } ?></p>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('enquiryM/takeAction'); ?>/<?php echo $GetData['id']; ?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Enquiry Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Ticket ID </label>
                      <div class="controls">
                        <input type="text" class="form-control" value="<?php echo $GetData['id']; ?>" placeholder="Ticket ID" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District </label>
                      <div class="controls">
                        <input type="text" class="form-control" value="<?php echo (!empty($district))?$district:"--" ?>" placeholder="District" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility </label>
                      <div class="controls">
                        <input type="text" class="form-control" value="<?php echo (!empty($facilityName))?$facilityName:"--" ?>" placeholder="Facility" readonly>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Lounge </label>
                      <div class="controls">
                        <input type="text" class="form-control" value="<?php echo (!empty($loungeName))?$loungeName:"--" ?>" placeholder="Lounge" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Location </label>
                      <div class="controls">
                        <textarea class="form-control" rows="3" placeholder="Location" readonly><?php echo $GetData['location']; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>Remark <span class="red">*</span></label>
                      <div class="controls">
                        <textarea class="form-control" name="remark" rows="3" required="" data-validation-required-message="This field is required" placeholder="Remark" <?php echo $inputDisable; ?>><?php echo $GetData['remark']; ?></textarea>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Status <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="status" id="status" required="" data-validation-required-message="This field is required" <?php echo $dropdownDisable; ?>>
                          <option value="">Select Status</option>
                          <option value="1" <?php if($GetData['status'] == 1) { echo 'selected'; } ?>>Pending</option>
                          <option value="2" <?php if($GetData['status'] == 2) { echo 'selected'; } ?>>Closed</option>
                          <option value="3" <?php if($GetData['status'] == 3) { echo 'selected'; } ?>>Cancelled</option>
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


    