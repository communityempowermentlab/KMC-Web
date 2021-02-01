

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add Staff Type</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staffM/staffType/">Staff Type</a>
                </li>
                <li class="breadcrumb-item active">Add Staff Type
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('staffM/addStaffType/');?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Staff Type Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Staff Type Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="staff_type_name" id="staff_type_name" placeholder="Staff Type Name" required="" data-validation-required-message="This field is required">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Parent Staff Type</label>
                      <div class="controls">
                        
                        <select class="select2 form-control" name="parent_staff_type" id="parent_staff_type">
                          <option value="">Select Parent Staff Type</option>
                          <?php $GetStaffType=$this->load->FacilityModel->GetNoParentStaffType();

                             foreach ($GetStaffType as $key => $value) { ?>
                           <option value="<?php echo $value['staffTypeId'] ?>"><?php echo $value['staffTypeNameEnglish'] ?></option>
                          <?php } ?>
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


    