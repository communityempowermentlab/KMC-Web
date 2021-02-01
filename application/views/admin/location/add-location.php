

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add Location</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Location/manageRevenue">Revenue District (U.P)</a>
                </li>
                <li class="breadcrumb-item active">Add Location
                </li>
              </ol>
              
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo site_url('Location/AddLocation/'); ?>" onsubmit="return validateAddLocation()">

              <div class="col-12">
                <h5 class="float-left pr-1">Locality Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>State </label>
                      <div class="controls">
                        <select class="select2 form-control" name="state" id="state" disabled="">
                          <option value="">Select State</option>
                          <?php foreach ($GetStates as $key => $value) { ?>
                            <option value="<?= $value['stateCode']; ?>" <?php if($value['stateCode'] == 9) { echo 'selected'; } ?>><?= $value['stateName']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="district" id="district" onchange="showNewDistrict(this.value)">
                          <option value="">Select District</option>
                          <?php foreach ($GetDistrict as $key => $value) { ?>
                            <option value="<?= $value['PRIDistrictCode']; ?>"><?= $value['DistrictNameProperCase']; ?></option>
                          <?php } ?>
                          <option value="new">Add New District</option>
                        </select>
                        <span id="err_district" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Area Type <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="area_type" id="area_type" onchange="getAreaTypeBlock(this.value, '<?php echo base_url('Location/getBlockByArea/')?>')">
                          <option value="">Select Area Type</option>
                          <option value="Rural">Rural</option>
                          <option value="Urban">Urban</option>
                        </select>
                        <span id="err_area_type" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12" style="display: none;" id="newDistrictDiv">
                <!-- <div class="col-12">
                  <h6 class="float-left pr-1" style="font-size: 0.8rem;">New District Information</h6>
                </div> -->

                <div class="col-md-4">
                  <div class="form-group" id="tabDiv">
                    <label>District Name Proper Case <span class="red">*</span></label>
                    <div class="controls">
                      <input type="text" class="form-control" name="district_name" id="district_name" placeholder="District Name Proper Case" onblur="checkUniqueName(this.value, '<?php echo base_url('Location/checkUniqueName/')?>', 'DistrictNameProperCase', 'district_name', '')">
                      <span id="err_district_name" class="custom-error"></span>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group" id="tabDiv">
                    <label>PRI District Code <span class="red">*</span></label>
                    <div class="controls">
                      <input type="text" class="form-control" name="district_code" id="district_code" placeholder="PRI District Code" onblur="checkUniqueName(this.value, '<?php echo base_url('Location/checkUniqueName/')?>', 'PRIDistrictCode', 'district_code', '')">
                      <span id="err_district_code" class="custom-error"></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Block <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="block" id="block" onchange="showBlockDiv(this.value)">
                          <option value="">Select Block</option>
                          
                        </select>
                        <span id="err_block" class="custom-error"></span>
                      </div>
                    </div>
                  </div>

                  <div id="blockDiv" style="display: none;" class="col-md-8 row">
                    <div class="col-md-6">
                      <div class="form-group" id="tabDiv">
                        <label>Block PRI Name Proper Case <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="form-control" name="block_name" id="block_name" placeholder="Block PRI Name Proper Case" onblur="checkBlockUniqueName(this.value, '<?php echo base_url('Location/checkBlockUniqueName/')?>', 'BlockPRINameProperCase', 'block_name')">
                          <span id="err_block_name" class="custom-error"></span>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group" id="tabDiv">
                        <label>Block PRI Code <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="form-control" name="block_code" id="block_code" placeholder="Block PRI Code" onblur="checkUniqueName(this.value, '<?php echo base_url('Location/checkUniqueName/')?>', 'BlockPRICode', 'block_code', '')">
                          <span id="err_block_code" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
              </div>

              <div class="col-12">
                <h6 class="float-left pr-1" style="font-size: 0.8rem;">Village/Town/City Information</h6>
              </div>

              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group" id="">
                    <label>GP Name Proper Case <span class="red">*</span></label>
                    <div class="controls">
                      <input type="text" class="form-control" name="village" id="village" placeholder="GP Name Proper Case" onblur="checkVillageUniqueName(this.value, '<?php echo base_url('Location/checkVillageUniqueName/')?>', 'GPNameProperCase', 'village')">
                      <span id="err_village" class="custom-error"></span>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group" id="">
                    <label>GP PRI Code <span class="red">*</span></label>
                    <div class="controls">
                      <input type="text" class="form-control" name="village_code" id="village_code" placeholder="GP PRI Code" onblur="checkUniqueName(this.value, '<?php echo base_url('Location/checkUniqueName/')?>', 'GPPRICode', 'village_code', '')">
                      <span id="err_village_code" class="custom-error"></span>
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


    