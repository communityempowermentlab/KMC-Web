

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add CEL Employee</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>employeeM/manageEmployee">CEL Employees</a>
                </li>
                <li class="breadcrumb-item active">Add CEL Employee
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo site_url('employeeM/addEmployee/');?>" enctype="multipart/form-data" onsubmit="return celEmpValidate('1')">

              <div class="col-12">
                <h5 class="float-left pr-1">Employee Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Name">
                        <span class="custom-error" id="err_employee_name"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="mobileDiv">
                      <label>Mobile Number <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" onkeypress="checkNum(event)" onblur="checkCelEmpMobile(this.value)" maxlength="10" name="employee_mobile_number" id="employee_mobile_number" placeholder="Mobile Number"  >
                        <span class="custom-error" id="err_employee_mobile_number"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="emailDiv">
                      <label>Email Id <span class="red">*</span></label>
                      <div class="controls">
                        <input type="email" class="form-control" onblur="checkCelEmpEmail(this.value, '<?php echo base_url('employeeM/checkLogInEmail');?>')" name="employee_email" id="employee_email" placeholder="Email Id" >
                        <span class="custom-error" id="err_employee_email"></span>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Employee Code <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="employee_code" id="employee_code" placeholder="Employee Code" onblur="checkCelEmpCode(this.value, '<?php echo base_url('employeeM/checkEmpCode');?>')">
                        <span class="custom-error" id="err_employee_code"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="tabDiv">
                      <label>Password <span class="red">*</span></label>
                      <div class="controls">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        <span class="custom-error" id="err_password"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Employee Photo </label>
                      <div class="controls">
                        <input type="file" class="form-control" name="image" id="fileupload" >
                        <span class="custom-error" id="err_fileupload"></span>
                        <div id="dvPreview"></div>
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
                      <select class="select2 form-control" multiple="multiple" name="menu_group[]" id="menu_group">
                        <?php foreach ($menuGroup as $key => $value) {?>
                          <option value ="<?php echo $value['id']?>" ><?php echo $value['groupName'] ?></option>
                        <?php } ?>
                      </select>
                      <span class="custom-error" id="err_menu_group"></span>
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


    