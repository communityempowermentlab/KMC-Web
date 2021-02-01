

   
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
            <h5 class="content-header-title float-left pr-1 mb-0">Add Facility</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>facility/manageFacility">Facilities</a>
                </li>
                <li class="breadcrumb-item active">Add Facility
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('facility/AddFacility/insert');?>">

              <div class="col-12">
                <h5 class="float-left pr-1">Facility Information</h5>
              </div>
              
              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility Name <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" name="facility_name" class="form-control" required="" 
                          data-validation-required-message="This field is required" placeholder="Facility Name">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility Type <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="facility_type" required="" data-validation-required-message="This field is required" onchange="hideBlock(this.value)">
                          <option value="">Select Facility Type</option>
                          <?php foreach ($GetFacilities2 as $key => $value) {?>
                            <option value ="<?php echo $value['id']?>" ><?php echo $value['facilityTypeName'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Newborn Care Unit Type <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" name="newborn_caring_type" required="" data-validation-required-message="This field is required">
                          <option value="">Select Newborn Care Unit Type</option>
                          <?php foreach ($NewBorn as $key => $value) {?>
                            <option value ="<?php echo $value['id']?>" ><?php echo $value['name'] ?></option>
                          <?php } ?>
                          
                        </select>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Management Type</label>
                      <div class="controls">
                        <select class="select2 form-control" name="facility_mange_type" >
                          <option value="">Select Management Type</option>
                          <?php foreach ($Management as $key => $value) {?>
                            <option value ="<?php echo $value['id']?>" ><?php echo $value['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Govt OR Non Govt</label>
                      <div class="controls">
                        <select class="select2 form-control" name="governmentOrNot">
                          <option value="">Select Govt OR Non Govt</option>
                          <?php foreach ($GovtORNot as $key => $value) {?>
                            <option value ="<?php echo $value['id']; ?>" ><?php echo $value['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>KMC Unit Start</label>
                      <div class="controls">
                        <fieldset class="form-group position-relative has-icon-left">
                          <input type="text" class="form-control pickadate-months-year" placeholder="Select Start Date" name="kmcunitstart">
                          <div class="form-control-position calendar-position">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                          </div>
                        </fieldset>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>KMC Unit Close</label>
                    <div class="controls">
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control pickadate-months-year" placeholder="Select Close Date" name="kmcunitclose">
                        <div class="form-control-position calendar-position">
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <h5 class="float-left pr-1">Address Information</h5>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>State <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" id="state_name" required="" data-validation-required-message="This field is required" name="state_name" onchange="getDistrict(this.value, '<?php echo base_url('Admin/getDistrict/')?>')">
                          <option value="">Select State</option>
                          <?php
                            foreach ($selectState as $key => $value) {?>
                              <option value="<?php echo $value['stateCode']; ?>"><?php echo $value['stateName']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>District <span class="red">*</span></label>
                      <div class="controls">
                        <select class="select2 form-control" id="district_name" name="district_name" required="" data-validation-required-message="This field is required" onchange="getBlockList(this.value, '<?php echo base_url('Admin/getBlock/')?>', '<?php echo base_url('Admin/getVillageByDistrict')?>')">
                          <option value="">Select District</option>
                          
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4" id="blockDiv">
                    <div class="form-group">
                      <label>Block </label>
                      <div class="controls">
                        <select class="select2 form-control" id="block_name" name="block_name" onchange="getVillageIfBlock(this.value, '<?php echo base_url('Admin/getVillage/')?>')">
                          <option value="">Select Block</option>
                          
                        </select>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="row col-12">
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Village/Town/City </label>
                      <div class="controls">
                        <select class="select2 form-control" id="vill_town_city" name="vill_town_city">
                          <option value="">Select Village/Town/City</option>
                          
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Facility Postal Address <span class="red">*</span></label>
                      <div class="controls">
                        <textarea class="form-control" id="horizontalTextarea" rows="3" placeholder="Facility Postal Address" required="" data-validation-required-message="This field is required" name="facility_address"></textarea>
                      </div>
                    </div>
                  </div>
              </div>
                  
              <div class="col-12">
                <h5 class="float-left pr-1">Admin Information</h5>
              </div>

              <div class="row col-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>CMS/MOIC Name </label>
                      <div class="controls">
                        <input type="text" class="form-control" name="cms_moic_name" placeholder="CMS/MOIC Name ">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>CMS/MOIC Phone Number</label>
                      <div class="controls">
                        <input type="text" class="form-control" name="phone_cms_moic_name" data-validation-regex-regex="([^a-z]*[A-Z]*)*" data-validation-containsnumber-regex="([^0-9]*[0-9]+)+"
                        maxlength="10" minlength="10" placeholder="CMS/MOIC Phone Number">
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


    