

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit Staff</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staffM/manageStaff/">Staff</a>
                </li>
                <li class="breadcrumb-item active">Edit Staff
                </li>
              </ol>
              <p style="float: right; color: black;"> <b>Verified Mobile</b> : <?php if(!empty($GetStaff['verifiedMobile'])) { echo $GetStaff['verifiedMobile']; } else { echo "N/A"; } ?></p>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url();?>staffM/UpdateStaffPost/<?php echo $GetStaff['staffId'];?>" enctype="multipart/form-data">

              <div class="col-12">
                <h5 class="float-left pr-1">Staff Information</h5>
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
                              <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($district_id == $value['PRIDistrictCode']) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
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
                             <option value="<?= $value['FacilityID']; ?>" <?php if($value['FacilityID'] == $GetStaff['facilityId']) { echo 'selected'; } ?>><?= $value['FacilityName']; ?></option>
                           <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Staff Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" data-validation-required-message="This field is required" name="Name" id="staff_name" placeholder="Staff Name" value="<?php echo $GetStaff['name'];?>">
                      </div>
                    </div>
                  </div>
                  
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Staff Type <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="type" id="staff_type" required="" data-validation-required-message="This field is required" onchange="getStaffSubType('<?php echo base_url('Admin/getStaffTypeList')?>', this.value)">
                          <option value="">Select Staff Type</option>
                          <?php foreach ($GetStaffType as $key => $value) { ?>
                            <option value="<?php echo $value['staffTypeId'] ?>" <?php echo ($GetStaff['staffType']== $value['staffTypeId']?'selected':'')?>><?php echo $value['staffTypeNameEnglish'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>Staff Sub Type</label>
                      <div class="controls">
                        <select class="select2 form-control" name="sub_type" id="sub_staff_type" onchange="openOtherStaffSubType(this);">
                          <option value="0">Select Staff Sub Type</option>
                          <?php  $GetStaffSubType = $this->load->UserModel->GetStaffSubType($GetStaff['staffType']);?>
                            <?php foreach ($GetStaffSubType as $key => $value) {?> 
                             <option value="<?php echo $value['staffTypeId'];?>"<?php echo ($GetStaff['staffSubType']== $value['staffTypeId']?'selected':'')?> typevalue="<?php echo strtolower($value['staffTypeNameEnglish']);?>"><?php echo $value['staffTypeNameEnglish'];?></option> 
                        <?php } ?>
                        </select>

                      </div>
                    </div>
                  </div>

                  <?php 
                  $staffType = $this->db->get_where('staffType',array('staffTypeId'=>$GetStaff['staffSubType']))->row_array();
                  if(strtolower($staffType['staffTypeNameEnglish']) == "other" || strtolower($staffType['staffTypeNameEnglish']) == "others"){
                    $sub_type_other_visible = "block";
                    $job_type1_visible = "none";
                    $job_type2_visible = "block";
                    $staff_sub_type_val = "Other";
                  } else{
                    $sub_type_other_visible = "none";
                    $job_type1_visible = "block";
                    $job_type2_visible = "none";
                    $staff_sub_type_val = "";
                  }

                  ?>

                  <div class="col-md-4" id="staff_sub_type_other_div" style="display:<?php echo $sub_type_other_visible; ?>">
                    <div class="form-group">
                      <label>Other Sub Type</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="staff_sub_type_other" id="staff_sub_type_other" placeholder="Other Sub Type" value="<?php echo $GetStaff['staffSubTypeOther'];?>">
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="staff_sub_type_val" name="staff_sub_type_val" value="<?php echo $staff_sub_type_val; ?>">

                  <div class="col-md-4" id="job_type_div1" style="display:<?php echo $job_type1_visible; ?>">
                    <div class="form-group">
                      <label>Job Type</label>
                      <div class="controls">
                        <select class="select2 form-control" name="job_type" id="job_type">
                          <option value="">Select Job Type</option>
                          <?php foreach ($GetJobType as $key => $value) { ?>
                            <option value="<?php echo $value['id'] ?>" <?php echo ($GetStaff['jobType']== $value['id']?'selected':'')?>><?php echo $value['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">

                <div class="col-md-4" id="job_type_div2" style="display:<?php echo $job_type2_visible; ?>">
                  <div class="form-group">
                    <label>Job Type</label>
                    <div class="controls">
                      <select class="select2 form-control" name="job_type1" id="job_type1">
                        <option value="">Select Job Type</option>
                        <?php foreach ($GetJobType as $key => $value) { ?>
                          <option value="<?php echo $value['id'] ?>" <?php echo ($GetStaff['jobType']== $value['id']?'selected':'')?>><?php echo $value['name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Staff Mobile Number <span class="red">*</span></label>
                    <div class="controls">
                      <input type="text" class="form-control" required="" data-validation-regex-regex="([^a-z]*[A-Z]*)*" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" value="<?php echo $GetStaff['staffMobileNumber'];?>"
                        maxlength="10" minlength="10" name="staff_contact_number" id="staff_contact_number" placeholder="Staff Mobile Number">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group" id="passwordDiv">
                    <label>Emergency Contact Number </label>
                    <div class="controls">
                      <input type="text" class="form-control" data-validation-regex-regex="([^a-z]*[A-Z]*)*" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+" value="<?php echo $GetStaff['emergencyContactNumber'];?>"
                        maxlength="10" minlength="10" name="emergency_contact_number" id="emergency_contact_number" placeholder="Emergency Contact Number">
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
                      <input type="file" class="form-control" name="image" id="fileupload" >
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
                      <textarea class="form-control" id="address" rows="3" placeholder="Staff Address" name="address"><?php echo $GetStaff['staffAddress'];?></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Status</label>
                    <div class="controls">
                      <select class="select2 form-control" name="status" id="status" data-validation-required-message="This field is required">
                        <option value="">Select Status</option>
                        <option value="1" <?php if($GetStaff['status'] == 1) { echo 'selected'; } ?>>Active</option>
                        <option value="2" <?php if($GetStaff['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                      </select>
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


    