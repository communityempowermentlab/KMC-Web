<?php 
$sessionData = $this->session->userdata('adminData'); 
$userPermittedMenuData = array();
$userPermittedMenuData = $this->session->userdata('userPermission');

if(($sessionData['Type']==2) && (in_array(66, $userPermittedMenuData) && !in_array(67, $userPermittedMenuData))){
  $pageHeading = "View";
  $inputDisable = "readonly";
  $dropdownDisable = "disabled";
  $buttonDisable = "display:none;";
  $verifyButtonDisable = "disabled";
}else{
  $pageHeading = "Update";
  $inputDisable = "";
  $dropdownDisable = "";
  

  if($GetStaff['status'] == 2){
    $verifyButtonDisable = "disabled";
    $buttonDisable = "display:none;";
  }else{
    $verifyButtonDisable = "";
    $buttonDisable = "";
  }
  
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
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $pageHeading; ?> Staff Details</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staffM/temporaryStaff">Not Approved Staff</a>
                </li>
                <li class="breadcrumb-item active"><?php echo $pageHeading; ?> Staff Details
                </li>
              </ol>
              <p style="float: right; color: black;"> <b>Verified Mobile</b> : <?php if(!empty($GetStaff['verifiedMobile'])) { echo $GetStaff['verifiedMobile']; } else { echo "N/A"; } ?>
            </p>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url();?>staffM/editTemporaryStaff/<?php echo $GetStaff['staffId'];?>" onsubmit="return checkFormSubmit()">

              <div class="col-12">
                <h5 class="float-left pr-1">Not Approved Staff Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District </label>
                      <div class="controls">
                        <?php $district = $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('PRIDistrictCode'=>$district_id))->row_array(); ?>
                        <input type="text" class="form-control" readonly="" placeholder="District" value="<?php echo $district['DistrictNameProperCase'];?>">
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility </label>
                      <div class="controls">
                        <?php $facility = $this->db->get_where('facilitylist',array('FacilityID'=>$GetStaff['facilityId']))->row_array(); ?>
                        <input type="text" class="form-control" readonly="" placeholder="Facility" value="<?php echo $facility['FacilityName'];?>">
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Staff Name </label>
                      <div class="controls">
                        <input type="text" class="form-control" readonly="" placeholder="Staff Name" value="<?php echo $GetStaff['name'];?>">
                      </div>
                    </div>
                  </div>
                  
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Staff Type </label>
                      <div class="controls">
                        <?php $staffType = $this->db->get_where('staffType',array('staffTypeId'=>$GetStaff['staffType']))->row_array(); ?>
                        <input type="text" class="form-control" readonly="" placeholder="Staff Type" value="<?php echo $staffType['staffTypeNameEnglish'];?>">
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>Staff Sub Type</label>
                      <div class="controls">
                        <?php $staffType = $this->db->get_where('staffType',array('staffTypeId'=>$GetStaff['staffSubType']))->row_array(); ?>
                        <input type="text" class="form-control" readonly="" placeholder="Staff Sub Type" value="<?php echo $staffType['staffTypeNameEnglish'];?>">
                        
                      </div>
                    </div>
                  </div>

                  <?php if(strtolower($staffType['staffTypeNameEnglish']) == "other" || strtolower($staffType['staffTypeNameEnglish']) == "others"){ ?>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Other Sub Type</label>
                        <div class="controls">
                          <input type="text" class="form-control" readonly="" placeholder="Job Type" value="<?php echo $GetStaff['staffSubTypeOther'];?>">
                        </div>
                      </div>
                    </div>
                  <?php }else{ ?>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Job Type</label>
                        <div class="controls">
                          <?php $jobType = $this->db->get_where('masterData',array('id'=>$GetStaff['jobType']))->row_array(); ?>
                          <input type="text" class="form-control" readonly="" placeholder="Job Type" value="<?php echo $jobType['name'];?>">
                          
                        </div>
                      </div>
                    </div>
                  <?php } ?>
              </div>

              <div class="row col-12">
                <?php if(strtolower($staffType['staffTypeNameEnglish']) == "other" || strtolower($staffType['staffTypeNameEnglish']) == "others"){ ?>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Job Type</label>
                        <div class="controls">
                          <?php $jobType = $this->db->get_where('masterData',array('id'=>$GetStaff['jobType']))->row_array(); ?>
                          <input type="text" class="form-control" readonly="" placeholder="Job Type" value="<?php echo $jobType['name'];?>">
                          
                        </div>
                      </div>
                    </div>
                  <?php }?>

                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Staff Mobile Number </label>
                    <div class="controls">
                      <input type="text" class="form-control" readonly="" value="<?php echo $GetStaff['staffMobileNumber'];?>"
                        placeholder="Staff Mobile Number">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Emergency Contact Number </label>
                    <div class="controls">
                      <input type="text" class="form-control" readonly="" value="<?php echo $GetStaff['emergencyContactNumber'];?>" placeholder="Emergency Contact Number">
                    </div>
                  </div>
                </div>

                
              </div>


              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Staff Photo </label>
                    <div class="controls">
                      <input type="hidden" name="prevFile" value="<?php echo $GetStaff['profilePicture']; ?>">
                      <!-- <input type="file" class="form-control" name="image" id="fileupload" disabled=""> -->
                      <div id="dvPreview">
                        <?php if(!empty($GetStaff['profilePicture'])) { ?>
                          <img src="<?php echo base_url(); ?>assets/nurse/<?php echo $GetStaff['profilePicture']; ?>">
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Staff Address </label>
                    <div class="controls">
                      <textarea class="form-control" id="address" rows="3" disabled=""  placeholder="Staff Address" name="address"><?php echo $GetStaff['staffAddress'];?></textarea>
                    </div>
                  </div>
                </div>

              </div>


              <div class="col-sm-12 row mb-1">
                  <div class="col-sm-12">
                    <h6 class="py-50">Verify Staff Information</h6>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                        <label>Verification Status</label>
                        <div class="controls">
                          <select class="select2 form-control" name="verification_status" id="verification_status" data-validation-required-message="This field is required" <?php echo $verifyButtonDisable; ?> onchange="showReasonBox(this.value)">
                            <option value="1" <?php if($GetStaff['status'] == 1) { echo 'selected'; } ?>>Pending</option>
                            <option value="2" <?php if($GetStaff['status'] == 2) { echo 'selected'; } ?>>Approved</option>
                            <option value="3" <?php if($GetStaff['status'] == 3) { echo 'selected'; } ?>>Rejected</option>
                          </select>
                        </div>
                      </div>
                  </div>

                  <?php  
                    if($GetStaff['status'] == 3) {
                      $style = '';
                    } else {
                      $style = 'display: none;';
                    }
                  ?>

                  <div class="col-sm-4" id="reason_box" style="<?= $style; ?>">
                      <div class="form-group">
                        <label>Reason <span class="red">*</span></label>
                        <div class="controls">
                          <textarea class="form-control" rows="3" <?php echo $verifyButtonDisable; ?>  name="reason" id="reason"><?= $GetStaff['reason'] ?></textarea>
                          <span class="custom-error" id="err_reason"></span>
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


<script>
  function showReasonBox(val){
    if(val == 3){
      $('#reason_box').show();
    } else {
      $('#reason_box').hide();
    }
  }

  function checkFormSubmit(){ 
    var verification_status = $('#verification_status').val();
    if(verification_status == 3){
      var reason = $('#reason').val();
      if(reason == '') {
        $('#err_reason').html('This field is required.').show();
        return false;
      } else {
        $('#err_reason').html('').hide();
      }
    }
  }
</script>   