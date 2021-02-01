

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Edit Block</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Location/manageRevenue">Revenue District (U.P)</a>
                </li>
                <li class="breadcrumb-item active">Edit Block
                </li>
              </ol>
              <p style="float: right; color: black;"><b>District Name:</b>&nbsp;<?php echo $GetData['DistrictNameProperCase'] ;?> | <b>District Code:</b>&nbsp;<?php echo $GetData['PRIDistrictCode'] ;?>
              </p>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" onsubmit="return validateEditDistrict()" action="<?php echo site_url('Location/EditBlock/'.$GetData['BlockPRICode']); ?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Block Information</h5>
              </div>
              
              

              <div class="row col-12" >
                <!-- <div class="col-12">
                  <h6 class="float-left pr-1" style="font-size: 0.8rem;">New District Information</h6>
                </div> -->

                <div class="col-md-4">
                  <div class="form-group" id="tabDiv">
                    <label>Block PRI Name Proper Case <span class="red">*</span></label>
                    <div class="controls">
                      <input type="hidden" id="district" name="district" value="<?= $GetData['PRIDistrictCode'] ?>">
                      <input type="text" class="form-control" name="block_name" id="district_name" placeholder="Block PRI Name Proper Case" value="<?= $GetData['BlockPRINameProperCase'] ?>" onblur="checkBlockUniqueName(this.value, '<?php echo base_url('Location/checkUniqueName/')?>', 'BlockPRINameProperCase', 'district_name', '<?= $GetData['BlockPRINameProperCase'] ?>')">
                      <span id="err_district_name" class="custom-error"></span>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group" id="tabDiv">
                    <label>PRI Block Code <span class="red">*</span></label>
                    <div class="controls">
                      <input type="text" class="form-control" name="block_code" id="district_code" placeholder="PRI Block Code" value="<?= $GetData['BlockPRICode'] ?>" onblur="checkUniqueName(this.value, '<?php echo base_url('Location/checkUniqueName/')?>', 'BlockPRICode', 'district_code', '<?= $GetData['BlockPRICode'] ?>')">
                      <span id="err_district_code" class="custom-error"></span>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Status <span class="red">*</span></label>
                    <div class="controls">
                      <select class="select2 form-control" name="status" id="status">
                        <option value="">Select Status</option>
                        <option value="1" <?php if($GetData['status'] == 1) { echo 'selected'; } ?>>Active</option>
                        <option value="2" <?php if($GetData['status'] == 2) { echo 'selected'; } ?>>Deactive</option>
                      </select>
                      <span id="err_status" class="custom-error"></span>
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


    