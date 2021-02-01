

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit Newborn Care Unit</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Miscellaneous/manageNBCU">Newborn Care Unit</a>
                </li>
                <li class="breadcrumb-item active">Edit Newborn Care Unit
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('Miscellaneous/editNBCU'); ?>/<?php echo $GetNBCUData['id']; ?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Newborn Care Unit Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>NBCU Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="form-control" name="nbcu_name" id="nbcu_name" placeholder="NBCU Name" required="" data-validation-required-message="This field is required" value="<?php echo $GetNBCUData['name']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Status <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="status" id="status" required="" data-validation-required-message="This field is required">
                          <option value="">Select Status</option>
                          <option value="1" <?php if($GetNBCUData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                          <option value="2" <?php if($GetNBCUData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
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


    