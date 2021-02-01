

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add Facility Type</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>facility/facilityType/">Facility Type</a>
                </li>
                <li class="breadcrumb-item active">Add Facility Type
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('facility/addFacilityType/');?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Facility Type Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility Type Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="facility_type_name" id="facility_type_name" placeholder="Facility Type Name" required="" data-validation-required-message="This field is required">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Set Priority <span class="red">*</span></label>
                      <div class="controls">
                        <input type="hidden" name="status" value="1">
                        <select class="select2 form-control" name="priority" id="priority" required="" data-validation-required-message="This field is required">
                          <option value="">Set Priority</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
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


    