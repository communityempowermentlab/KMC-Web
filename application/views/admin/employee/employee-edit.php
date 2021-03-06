

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit CEL Employee</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>employeeM/manageEmployee">CEL Employees</a>
                </li>
                <li class="breadcrumb-item active">Edit CEL Employee
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo site_url('employeeM/updateEmployee/'.$GetEmployeeData['id']);?>" enctype="multipart/form-data" onsubmit="return celEmpValidate('2')">

              <div class="col-12">
                <h5 class="float-left pr-1">Employee Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Name" value="<?= $GetEmployeeData['name'] ?>">
                        <span class="custom-error" id="err_employee_name"></span>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label>Mobile Number <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="employee_mobile_number" id="employee_mobile_number" placeholder="Mobile Number" onkeypress="checkNum(event)" onblur="checkCelEmpMobile(this.value)" maxlength="10" value="<?= $GetEmployeeData['contactNumber'] ?>">
                        <span class="custom-error" id="err_employee_mobile_number"></span>
                      </div>
                    </div>
                  </div> -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Email Id <span class="red">*</span></label>
                      <div class="controls">
                        <input type="email" class="form-control" name="employee_email" id="employee_email" placeholder="Email Id" value="<?= $GetEmployeeData['email'] ?>" onblur="validateCelEmpEmail(this.value, '<?= $GetEmployeeData['id'] ?>')">
                        <span class="custom-error" id="err_employee_email"></span>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Employee Code <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="employee_code" id="employee_code" placeholder="Employee Code" value="<?php echo $GetEmployeeData['employeeCode']; ?>" onblur="checkCelEmpCode(this.value, '<?php echo base_url('employeeM/checkEmpCode');?>', '<?= $GetEmployeeData['id'] ?>')">
                        <span class="custom-error" id="err_employee_code"></span>
                      </div>
                    </div>
                  </div>
                  
              </div>

              <div class="row col-12">

                  <div class="col-md-4">
                    <div class="form-group" id="passwordDiv">
                      <label>Password <span class="red">*</span></label>
                      <div class="controls">
                        <fieldset>
                          <div class="input-group">
                            <input type="password" class="form-control hideCls" data-validation-required-message="This field is required" name="password" id="password" placeholder="Password" value="<?php echo base64_decode($GetEmployeeData['password']) ?>">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2-password" onclick="showPassword('password')"><i class="bx bxs-show"></i></span>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Employee Photo </label>
                      <div class="controls">
                        <input type="file" class="form-control" name="image" id="fileupload" >
                        <span class="custom-error" id="err_fileupload"></span>
                        <input type="hidden" name="prevFile" value="<?php echo $GetEmployeeData['profileImage']; ?>">
                        <div id="dvPreview">
                          <?php if(!empty($GetEmployeeData['profileImage'])) { ?>
                            <img src="<?php echo base_url(); ?>assets/employee/<?php echo $GetEmployeeData['profileImage']; ?>">
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="col-12">
                <h5 class="float-left pr-1">Assign Menu Privilege</h5>
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
                          <option value="">Select Status</option>
                          <option value="1" <?php if($GetEmployeeData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($GetEmployeeData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                      </select>
                      <span class="custom-error" id="err_status"></span>
                    </div>
                  </div>
                </div>
              </div>

              <hr>

              <?php foreach ($GetDistrict as $key => $districtValue) { 
                $GetFacilities = $this->EmployeeModel->GetFacilityByDistrict($districtValue['PRIDistrictCode']);
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
                        <select class="select2 form-control" multiple="multiple" name="facility[]" id="facility<?php echo $districtValue['PRIDistrictCode'] ?>" onchange="getFacilityMultipleLounge('<?php echo $districtValue['PRIDistrictCode'] ?>','<?php echo base_url('employeeM/getFacilityMultipleLounge') ?>','<?php echo $employeeid; ?>');">
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
                        <select class="select2 form-control" multiple="multiple" name="lounge[]" id="lounge<?php echo $districtValue['PRIDistrictCode'] ?>">

                          <?php foreach ($facilityArray as $key => $value) {
                            $getFacility = $this->FacilityModel->GetFacilitiesById('facilitylist', $value); 
        
                           $getLounge = $this->EmployeeModel->GetLoungeByFAcility($value); ?>
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
      function validateCelEmpEmail(val,id){
        $.ajax({
          type:"POST",
          url: '<?php echo base_url('employeeM/validateCelEmpEmail'); ?>',
          data: {"email":val,"id": id},
          success: function(html){
            if(html == 0){
              $('#err_employee_email').html("Email id already exist.").show();
              $('#submitButton').prop('disabled', true);
            }else{
              $('#err_employee_email').html("").hide();
              $('#submitButton').prop('disabled', false);
            }
          }
        });
      }
    </script>


    