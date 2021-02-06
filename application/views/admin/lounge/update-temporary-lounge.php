

   
    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">

  <?php 
    $sessionData = $this->session->userdata('adminData'); 
    $userPermittedMenuData = array();
    $userPermittedMenuData = $this->session->userdata('userPermission');

    $Facility = $this->db->query("SELECT * FROM `facilitylist` where FacilityID='".$GetLounge['facilityId']."'")->row_array();
    $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$Facility['PRIDistrictCode']."'")->row_array();
    $Lounge = $this->db->query("SELECT * FROM `loungeMaster` where loungeId='".$GetLounge['loungeId']."'")->row_array();

    // if($GetLounge['status'] == 1){
    //   $readonlyStatus = "";
    //   $disableStatus = "";
    // }else{
    //   $readonlyStatus = "readonly";
    //   $disableStatus = "disabled";
    // }

    if(($sessionData['Type']==2) && (in_array(62, $userPermittedMenuData) && !in_array(63, $userPermittedMenuData)) || ($GetLounge['status'] != 1) ){
      $readonlyStatus = "readonly";
      $disableStatus = "disabled";
      $buttonDisable = "display:none;";
    }
    elseif(($sessionData['Type']==1) && ($GetLounge['status'] != 1)){
      $readonlyStatus = "readonly";
      $disableStatus = "disabled";
      $buttonDisable = "display:none;";
    }
    else{
      $readonlyStatus = "";
      $disableStatus = "";
      $buttonDisable = "";
    }
  ?>


<!-- Input Validation start -->
<section class="input-validation">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-sm-12">
            <h5 class="content-header-title float-left pr-1 mb-0">Amenities Information Details</h5>
            <div class="breadcrumb-wrapper col-sm-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/temporaryLounge">Amenities Information</a>
                </li>
                <li class="breadcrumb-item active">Amenities Information Details
                </li>
              </ol>
              
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo site_url();?>loungeM/editTemporaryLounge/<?php echo $GetLounge['id'];?>" onsubmit="return checkFormSubmit()">

              <div class="col-sm-12 row mb-1">
                  <div class="col-sm-12">
                    <h6 class="py-50">Lounge Information</h6>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                        <label>District </label>
                        <div class="controls">
                          <input type="text" class="form-control" value="<?php echo $District['DistrictNameProperCase']; ?>" readonly>
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                        <label>Facility </label>
                        <div class="controls">
                          <input type="text" class="form-control" value="<?php echo $Facility['FacilityName']; ?>" readonly>
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                        <label>Lounge </label>
                        <div class="controls">
                          <input type="text" class="form-control" value="<?php echo $Lounge['loungeName']; ?>" readonly>
                          <input type="hidden" name="loungeId" value="<?= $GetLounge['loungeId']; ?>">
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                        <label>Verified Mobile </label>
                        <div class="controls">
                          <input type="text" class="form-control" name="verifiedMobile" value="<?php echo (!empty($GetLounge['verifiedMobile'])) ? $GetLounge['verifiedMobile']:"N/A";; ?>" readonly>
                        </div>
                      </div>
                  </div>
              </div>

              <!-- first row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Reclining Beds (Semi fowler beds with mattress)</h6>
                  </div>
                  
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Total Numbers </label>
                        <div class="controls">
                          <input type="text" name="totalRecliningBeds" id="totalRecliningBeds" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalRecliningBeds'];?>" onblur="checkNumberCount('totalRecliningBeds', 'functionalRecliningBeds', 'nonFunctionalRecliningBeds')">
                          <span id="err_totalRecliningBeds" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Functional </label>
                        <div class="controls">
                          <input type="text" name="functionalRecliningBeds" id="functionalRecliningBeds" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalRecliningBeds'];?>" onblur="checkNumberCount('totalRecliningBeds', 'functionalRecliningBeds', 'nonFunctionalRecliningBeds')">
                          <span id="err_functionalRecliningBeds" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Non Functional </label>
                        <div class="controls">
                          <input type="text" name="nonFunctionalRecliningBeds" id="nonFunctionalRecliningBeds" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalRecliningBeds'];?>" onblur="checkNumberCount('totalRecliningBeds', 'functionalRecliningBeds', 'nonFunctionalRecliningBeds')">
                          <span id="err_nonFunctionalRecliningBeds" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Bedside Table</h6>
                  </div>
                  
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Total Numbers </label>
                        <div class="controls">
                          <input type="text" name="totalBedsideTable" id="totalBedsideTable" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalBedsideTable'];?>" onblur="checkNumberCount('totalBedsideTable', 'functionalBedsideTable', 'nonFunctionalBedsideTable')">
                          <span id="err_totalBedsideTable" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional </label>
                        <div class="controls">
                          <input type="text" name="functionalBedsideTable" id="functionalBedsideTable" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalBedsideTable'];?>" onblur="checkNumberCount('totalBedsideTable', 'functionalBedsideTable', 'nonFunctionalBedsideTable')">
                          <span id="err_functionalBedsideTable" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional </label>
                        <div class="controls">
                          <input type="text" name="nonFunctionalBedsideTable" id="nonFunctionalBedsideTable" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalBedsideTable'];?>" onblur="checkNumberCount('totalBedsideTable', 'functionalBedsideTable', 'nonFunctionalBedsideTable')">
                          <span id="err_nonFunctionalBedsideTable" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  
                </div>
              </div>
              <!-- first row of form end -->
              
              <!-- second row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content; float: left;">Colored Bedsheet & Pillow Cover (VIBGYOR)</h6>
                    <ul class="list-unstyled mb-0 ml-1" style="float: left;margin-top: 5px;">
                      <li class="d-inline-block mr-2">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="coloredBedsheetAvailability" class="bedsheet_option" value="1" id="radio1" onclick="openDetails(this.value,'1')" <?php if($GetLounge['coloredBedsheetAvailability'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio1">Yes</label>

                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="coloredBedsheetAvailability" class="bedsheet_option" value="2" id="radio2" onclick="openDetails(this.value,'1')" <?php if($GetLounge['coloredBedsheetAvailability'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio2">No</label>

                          </div>
                        </fieldset>
                      </li>
                    </ul>
                  </div>
                  <div class="col-sm-12"><span id="err_bedsheet_option" class="custom-error"></span></div>
                  
                  <?php $display1_1 = 'display: none;'; if($GetLounge['coloredBedsheetAvailability'] == 1) { 
                      $display1_1 = ''; }
                  ?>

                  <div id="div_1_1" class="row" style="<?= $display1_1; ?>padding-left: 15px;padding-right: 15px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Total Numbers </label>
                        <div class="controls">
                          <input type="text" name="totalColoredBedsheet" id="totalColoredBedsheet" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalColoredBedsheet'];?>" onblur="checkNumberCount('totalColoredBedsheet', 'functionalColoredBedsheet', 'nonFunctionalColoredBedsheet')">
                          <span id="err_totalColoredBedsheet" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional </label>
                        <div class="controls">
                          <input type="text" name="functionalColoredBedsheet" id="functionalColoredBedsheet" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalColoredBedsheet'];?>" onblur="checkNumberCount('totalColoredBedsheet', 'functionalColoredBedsheet', 'nonFunctionalColoredBedsheet')">
                          <span id="err_functionalColoredBedsheet" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional </label>
                        <div class="controls">
                          <input type="text" name="nonFunctionalColoredBedsheet" id="nonFunctionalColoredBedsheet" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalColoredBedsheet'];?>" onblur="checkNumberCount('totalColoredBedsheet', 'functionalColoredBedsheet', 'nonFunctionalColoredBedsheet')">
                          <span id="err_nonFunctionalColoredBedsheet" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php $display1_2 = 'display: none;'; if($GetLounge['coloredBedsheetAvailability'] == 2) {
                      $display1_2 = ''; }
                  ?>

                  <div id="div_1_2" class="row col-sm-12" style="<?= $display1_2; ?>padding-left: 15px;padding-right: 0px;margin-right: 0;">
                    <div class="col-md-12" style="padding-right: 0;">
                      <div class="form-group">
                        <label>Reason </label>
                        <div class="controls">
                          <input type="text" name="coloredBedsheetReason" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['coloredBedsheetReason'];?>">
                          <span id="err_bedsheet_reason" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Reclining Chair</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalRecliningChair" id="totalRecliningChair" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalRecliningChair'];?>" onblur="checkNumberCount('totalRecliningChair', 'functionalRecliningChair', 'nonFunctionalRecliningChair')">
                        <span id="err_totalRecliningChair" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalRecliningChair" id="functionalRecliningChair" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalRecliningChair'];?>" onblur="checkNumberCount('totalRecliningChair', 'functionalRecliningChair', 'nonFunctionalRecliningChair')">
                        <span id="err_functionalRecliningChair" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalRecliningChair" id="nonFunctionalRecliningChair" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalRecliningChair'];?>" onblur="checkNumberCount('totalRecliningChair', 'functionalRecliningChair', 'nonFunctionalRecliningChair')">
                        <span id="err_nonFunctionalRecliningChair" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- second row of form end -->

              <!-- third row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content; float: left;">Chair & Table for Nurse (Nursing Station)</h6>
                    <ul class="list-unstyled mb-0 ml-1" style="float: left;margin-top: 5px;">
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="nursingStationAvailability" id="radio3" class="nurse_table_option" value="1" onclick="openDetails(this.value,'2')" <?php if($GetLounge['nursingStationAvailability'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio3">Yes</label>
                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="nursingStationAvailability" id="radio4" class="nurse_table_option" value="2" onclick="openDetails(this.value,'2')" <?php if($GetLounge['nursingStationAvailability'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio4">No</label>
                          </div>
                        </fieldset>
                      </li>
                    </ul>
                    
                  </div>
                  <div class="col-sm-12"><span id="err_nurse_table_option" class="custom-error"></span></div>

                  <?php $display2_1 = 'display: none;'; if($GetLounge['nursingStationAvailability'] == 1) { 
                      $display2_1 = '';
                  } ?>

                  <div id="div_2_1" class="row" style="<?= $display2_1; ?>padding-left: 15px;padding-right: 15px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Total Numbers </label>
                        <div class="controls">
                          <input type="text" name="totalNursingStation" id="totalNursingStation" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalNursingStation'];?>" onblur="checkNumberCount('totalNursingStation', 'functionalNursingStation', 'nonFunctionalNursingStation')">
                          <span id="err_totalNursingStation" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional </label>
                        <div class="controls">
                          <input type="text" name="functionalNursingStation" id="functionalNursingStation" class="form-control" value="<?php echo $GetLounge['functionalNursingStation'];?>" <?php echo $readonlyStatus; ?> onblur="checkNumberCount('totalNursingStation', 'functionalNursingStation', 'nonFunctionalNursingStation')">
                          <span id="err_functionalNursingStation" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional </label>
                        <div class="controls">
                          <input type="text" name="nonFunctionalNursingStation" id="nonFunctionalNursingStation" class="form-control" value="<?php echo $GetLounge['nonFunctionalNursingStation'];?>" <?php echo $readonlyStatus; ?> onblur="checkNumberCount('totalNursingStation', 'functionalNursingStation', 'nonFunctionalNursingStation')">
                          <span id="err_nonFunctionalNursingStation" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php $display2_2 = 'display: none;'; if($GetLounge['nursingStationAvailability'] == 2) { 
                      $display2_2 = '';
                  } ?>

                  <div id="div_2_2" class="row col-sm-12" style="<?= $display2_2; ?>padding-left: 15px;padding-right: 0px;margin-right: 0;">
                    <div class="col-md-12" style="padding-right: 0;">
                      <div class="form-group">
                        <label>Reason </label>
                        <div class="controls">
                          <input type="text" name="nursingStationReason" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nursingStationReason'];?>">
                          <span id="err_nurse_table_reason" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content; float: left;">High Stool for Weighing Scale</h6>
                    <ul class="list-unstyled mb-0 ml-1" style="float: left;margin-top: 5px;">
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="highStoolAvailability" id="radio5" class="highstool_option" value="1" onclick="openDetails(this.value,'3')" <?php if($GetLounge['highStoolAvailability'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio5">Yes</label>
                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="highStoolAvailability" id="radio6" class="highstool_option" value="2" onclick="openDetails(this.value,'3')" <?php if($GetLounge['highStoolAvailability'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio6">No</label>
                          </div>
                        </fieldset>
                      </li>
                    </ul>
                    
                  </div>
                  <div class="col-sm-12"><span id="err_highstool_option" class="custom-error"></span></div>
                  <?php $display3_1 = 'display: none;'; if($GetLounge['highStoolAvailability'] == 1) { 
                    $display3_1 = '';
                  } ?>

                  <div id="div_3_1" class="row" style="<?= $display3_1; ?>padding-left: 15px;padding-right: 15px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Total Numbers </label>
                        <div class="controls">
                          <input type="text" name="totalHighStool" id="totalHighStool" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalHighStool'];?>" onblur="checkNumberCount('totalHighStool', 'functionalHighStool', 'nonFunctionalHighStool')">
                          <span id="err_totalHighStool" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional </label>
                        <div class="controls">
                          <input type="text" name="functionalHighStool" id="functionalHighStool" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalHighStool'];?>" onblur="checkNumberCount('totalHighStool', 'functionalHighStool', 'nonFunctionalHighStool')">
                          <span id="err_functionalHighStool" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional </label>
                        <div class="controls">
                          <input type="text" name="nonFunctionalHighStool" id="nonFunctionalHighStool" class="form-control" value="<?php echo $GetLounge['nonFunctionalHighStool'];?>" <?php echo $readonlyStatus; ?> onblur="checkNumberCount('totalHighStool', 'functionalHighStool', 'nonFunctionalHighStool')">
                          <span id="err_nonFunctionalHighStool" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php $display3_2 = 'display: none;'; if($GetLounge['highStoolAvailability'] == 2) { 
                    $display3_2 = '';
                  } ?>

                  <div id="div_3_2" class="row col-sm-12" style="<?= $display3_2; ?>padding-left: 15px;padding-right: 0px;margin-right: 0;">
                    <div class="col-md-12" style="padding-right: 0;">
                      <div class="form-group">
                        <label>Reason </label>
                        <div class="controls">
                          <input type="text" name="highStoolReason" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['highStoolReason'];?>">
                          <span id="err_highstool_reason" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- third row of form end -->

              <!-- fourth row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Cupboard</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalCubord" id="totalCubord" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalCubord'];?>" onblur="checkNumberCount('totalCubord', 'functionalCubord', 'nonFunctionalCubord')">
                        <span id="err_totalCubord" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalCubord" id="functionalCubord" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalCubord'];?>" onblur="checkNumberCount('totalCubord', 'functionalCubord', 'nonFunctionalCubord')">
                        <span id="err_functionalCubord" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalCubord" id="nonFunctionalCubord" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalCubord'];?>" onblur="checkNumberCount('totalCubord', 'functionalCubord', 'nonFunctionalCubord')">
                        <span id="err_nonFunctionalCubord" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Air Conditioner</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalAC" id="totalAC" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalAC'];?>" onblur="checkNumberCount('totalAC', 'functionalAC', 'nonFunctionalAC')">
                        <span id="err_totalAC" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalAC" id="functionalAC" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalAC'];?>" onblur="checkNumberCount('totalAC', 'functionalAC', 'nonFunctionalAC')">
                        <span id="err_functionalAC" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalAC" id="nonFunctionalAC" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalAC'];?>" onblur="checkNumberCount('totalAC', 'functionalAC', 'nonFunctionalAC')">
                        <span id="err_nonFunctionalAC" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- fourth row of form end -->
              
              <!-- fifth row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Room Heater (Oil Filter)</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalRoomHeater" id="totalRoomHeater" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalRoomHeater'];?>" onblur="checkNumberCount('totalRoomHeater', 'functionalRoomHeater', 'nonFunctionalRoomHeater')">
                        <span id="err_totalRoomHeater" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalRoomHeater" id="functionalRoomHeater" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalRoomHeater'];?>" onblur="checkNumberCount('totalRoomHeater', 'functionalRoomHeater', 'nonFunctionalRoomHeater')">
                        <span id="err_functionalRoomHeater" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalRoomHeater" id="nonFunctionalRoomHeater" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalRoomHeater'];?>" onblur="checkNumberCount('totalRoomHeater', 'functionalRoomHeater', 'nonFunctionalRoomHeater')">
                        <span id="err_nonFunctionalRoomHeater" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Digital Weighing Scale</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalDigitalWeigh" id="totalDigitalWeigh" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalDigitalWeigh'];?>" onblur="checkNumberCount('totalDigitalWeigh', 'functionalDigitalWeigh', 'nonFunctionalDigitalWeigh')">
                        <span id="err_totalDigitalWeigh" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalDigitalWeigh" id="functionalDigitalWeigh" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalDigitalWeigh'];?>" onblur="checkNumberCount('totalDigitalWeigh', 'functionalDigitalWeigh', 'nonFunctionalDigitalWeigh')">
                        <span id="err_functionalDigitalWeigh" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalDigitalWeigh" id="nonFunctionalDigitalWeigh" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalDigitalWeigh'];?>" onblur="checkNumberCount('totalDigitalWeigh', 'functionalDigitalWeigh', 'nonFunctionalDigitalWeigh')">
                        <span id="err_nonFunctionalDigitalWeigh" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- fifth row of form end -->
              
              <!-- sixth row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Fans</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalFans" id="totalFans" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalFans'];?>" onblur="checkNumberCount('totalFans', 'functionalFans', 'nonFunctionalFans')">
                        <span id="err_totalFans" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalFans" id="functionalFans" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalFans'];?>" onblur="checkNumberCount('totalFans', 'functionalFans', 'nonFunctionalFans')">
                        <span id="err_functionalFans" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalFans" id="nonFunctionalFans" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalFans'];?>" onblur="checkNumberCount('totalFans', 'functionalFans', 'nonFunctionalFans')">
                        <span id="err_nonFunctionalFans" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content; float: left;">Room Thermometer With Digital Clocks</h6>
                    <ul class="list-unstyled mb-0 ml-1" style="float: left;margin-top: 5px;">
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="roomThermometerAvailability" id="radio7" class="thermometer_option" value="1" onclick="openDetails(this.value,'4')" <?php if($GetLounge['roomThermometerAvailability'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio7">Yes</label>
                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" name="roomThermometerAvailability" id="radio8" class="thermometer_option" value="2" onclick="openDetails(this.value,'4')" <?php if($GetLounge['roomThermometerAvailability'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                            <label for="radio8">No</label>
                          </div>
                        </fieldset>
                      </li>
                    </ul>
                    
                  </div>
                  <div class="col-sm-12"><span id="err_thermometer_option" class="custom-error"></span></div>
                  <?php $display4_1 = 'display: none;'; if($GetLounge['roomThermometerAvailability'] == 1) { 
                    $display4_1 = '';
                  } ?>

                  <div id="div_4_1" class="row" style="<?= $display4_1; ?>padding-left: 15px;padding-right: 15px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Total Numbers </label>
                        <div class="controls">
                          <input type="text" name="totalRoomThermometer" id="totalRoomThermometer" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalRoomThermometer'];?>" onblur="checkNumberCount('totalRoomThermometer', 'functionalRoomThermometer', 'nonFunctionalRoomThermometer')">
                          <span id="err_totalRoomThermometer" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional </label>
                        <div class="controls">
                          <input type="text" name="functionalRoomThermometer" id="functionalRoomThermometer" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalRoomThermometer'];?>" onblur="checkNumberCount('totalRoomThermometer', 'functionalRoomThermometer', 'nonFunctionalRoomThermometer')">
                          <span id="err_functionalRoomThermometer" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional </label>
                        <div class="controls">
                          <input type="text" name="nonFunctionalRoomThermometer" id="nonFunctionalRoomThermometer" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalRoomThermometer'];?>" onblur="checkNumberCount('totalRoomThermometer', 'functionalRoomThermometer', 'nonFunctionalRoomThermometer')">
                          <span id="err_nonFunctionalRoomThermometer" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php $display4_2 = 'display: none;'; if($GetLounge['roomThermometerAvailability'] == 2) { 
                    $display4_2 = '';
                  } ?>

                  <div id="div_4_2" class="row col-sm-12" style="<?= $display4_2; ?>padding-left: 15px;padding-right: 0px;margin-right: 0;">
                    <div class="col-md-12" style="padding-right: 0;">
                      <div class="form-group">
                        <label>Reason </label>
                        <div class="controls">
                          <input type="text" name="roomThermometerReason" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['roomThermometerReason'];?>">
                          <span id="err_thermometer_reason" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- sixth row of form start -->

              <!-- seventh row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content; ">Regular Supply Of Masks, Shoe Covers & Slippers</h6>
                    <div class="row">
                      <ul class="list-unstyled mb-0 ml-1" style="margin-top: 5px;">
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="maskSupplyAvailability" id="radio9" class="mask_supply_option" value="1" <?php if($GetLounge['maskSupplyAvailability'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio9">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="maskSupplyAvailability" id="radio10" class="mask_supply_option" value="2" <?php if($GetLounge['maskSupplyAvailability'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio10">No</label>
                            </div>
                          </fieldset>
                        </li>
                      </ul>
                      <span id="err_mask_supply_option" class="custom-error"></span>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content;">Power Backup Facility in the Hospital</h6>
                    <div class="row">
                      <ul class="list-unstyled mb-0 ml-1" style="margin-top: 5px;">
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="checkbox">
                              <input type="checkbox" name="powerBackupInverter" class="checkbox-input" value="1" id="check1" <?php if($GetLounge['powerBackupInverter'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="check1">Invertor</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="checkbox">
                              <input type="checkbox" name="powerBackupGenerator" class="checkbox-input" value="1" id="check2" <?php if($GetLounge['powerBackupGenerator'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="check2">Generator</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="checkbox">
                              <input type="checkbox" name="powerBackupSolar" class="checkbox-input" value="1" id="check3" <?php if($GetLounge['powerBackupSolar'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="check3">Solar</label>
                            </div>
                          </fieldset>
                        </li>
                      </ul>
                      <span id="err_checkbox-input" class="custom-error"></span>
                    </div>
                  </div>
                  
                  <?php $display3_1 = 'display: none;'; if($GetLounge['highStoolAvailability'] == 1) { 
                    $display3_1 = '';
                  } ?>

                  <!-- <div id="div_3_1" class="row" style="<?= $display3_1; ?>padding-left: 15px;padding-right: 15px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Total Numbers </label>
                        <div class="controls">
                          <input type="text" name="totalHighStool" id="totalHighStool" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalHighStool'];?>" onblur="checkNumberCount('totalHighStool', 'functionalHighStool', 'nonFunctionalHighStool')">
                          <span id="err_totalHighStool" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional </label>
                        <div class="controls">
                          <input type="text" name="functionalHighStool" id="functionalHighStool" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalHighStool'];?>" onblur="checkNumberCount('totalHighStool', 'functionalHighStool', 'nonFunctionalHighStool')">
                          <span id="err_functionalHighStool" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional </label>
                        <div class="controls">
                          <input type="text" name="nonFunctionalHighStool" id="nonFunctionalHighStool" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalHighStool'];?>" onblur="checkNumberCount('totalHighStool', 'functionalHighStool', 'nonFunctionalHighStool')">
                          <span id="err_nonFunctionalHighStool" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div> -->

                  <?php $display3_2 = 'display: none;'; if($GetLounge['highStoolAvailability'] == 2) { 
                    $display3_2 = '';
                  } ?>

                  <!-- <div id="div_3_2" class="row col-sm-12" style="<?= $display3_2; ?>padding-left: 15px;padding-right: 0px;margin-right: 0;">
                    <div class="col-md-12" style="padding-right: 0;">
                      <div class="form-group">
                        <label>Reason </label>
                        <div class="controls">
                          <input type="text" class="form-control" placeholder="Reason" readonly value="<?php echo $GetLounge['highStoolReason'];?>">
                          <span id="err_highstool_reason" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
              </div>
              <!-- seventh row of form end -->

              <!-- eigth row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content;">Regular Supply Of Baby Blanket/Wrap, Gown & KMC Baby Kit</h6>
                    <div class="row">
                      <ul class="list-unstyled mb-0 ml-1" style="margin-top: 5px;">
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="babyKitSupply" id="radio11" class="babykit_supply_option" value="1" <?php if($GetLounge['babyKitSupply'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio11">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="babyKitSupply" id="radio12" class="babykit_supply_option" value="2" <?php if($GetLounge['babyKitSupply'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio12">No</label>
                            </div>
                          </fieldset>
                        </li>
                      </ul>
                      <span id="err_babykit_supply_option" class="custom-error"></span>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content;">Regular Supply Of Adult Blankets</h6>
                    <div class="row">
                      <ul class="list-unstyled mb-0 ml-1" style="margin-top: 5px;">
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="adultBlanketSupply" id="radio13" class="blanket_supply_option" value="1" <?php if($GetLounge['adultBlanketSupply'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio13">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="adultBlanketSupply" id="radio14" class="blanket_supply_option" value="2" <?php if($GetLounge['adultBlanketSupply'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio14">No</label>
                            </div>
                          </fieldset>
                        </li>
                      </ul>
                      <span id="err_blanket_supply_option" class="custom-error"></span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- eigth row of form end -->

              <!-- ninth row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Digital Thermometer For Baby & Mother</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalDigitalThermometer" id="totalDigitalThermometer" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalDigitalThermometer'];?>" onblur="checkNumberCount('totalDigitalThermometer', 'functionalDigitalThermometer', 'nonFunctionalDigitalThermometer')">
                        <span id="err_totalDigitalThermometer" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalDigitalThermometer" id="functionalDigitalThermometer" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalDigitalThermometer'];?>" onblur="checkNumberCount('totalDigitalThermometer', 'functionalDigitalThermometer', 'nonFunctionalDigitalThermometer')">
                        <span id="err_functionalDigitalThermometer" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalDigitalThermometer" id="nonFunctionalDigitalThermometer" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalDigitalThermometer'];?>" onblur="checkNumberCount('totalDigitalThermometer', 'functionalDigitalThermometer', 'nonFunctionalDigitalThermometer')">
                        <span id="err_nonFunctionalDigitalThermometer" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Pulse Oximeter</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalPulseOximeter" id="totalPulseOximeter" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalPulseOximeter'];?>" onblur="checkNumberCount('totalPulseOximeter', 'functionalPulseOximeter', 'nonFunctionalPulseOximeter')">
                        <span id="err_totalPulseOximeter" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalPulseOximeter" id="functionalPulseOximeter" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalPulseOximeter'];?>" onblur="checkNumberCount('totalPulseOximeter', 'functionalPulseOximeter', 'nonFunctionalPulseOximeter')">
                        <span id="err_functionalPulseOximeter" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalPulseOximeter" id="nonFunctionalPulseOximeter" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalPulseOximeter'];?>" onblur="checkNumberCount('totalPulseOximeter', 'functionalPulseOximeter', 'nonFunctionalPulseOximeter')">
                        <span id="err_nonFunctionalPulseOximeter" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ninth row of form end -->

              <!-- tenth row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Blood Pressure Monitor</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalBPMonitor" id="totalBPMonitor" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalBPMonitor'];?>" onblur="checkNumberCount('totalBPMonitor', 'functionalBPMonitor', 'nonFunctionalBPMonitor')">
                        <span id="err_totalBPMonitor" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalBPMonitor" id="functionalBPMonitor" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalBPMonitor'];?>" onblur="checkNumberCount('totalBPMonitor', 'functionalBPMonitor', 'nonFunctionalBPMonitor')">
                        <span id="err_functionalBPMonitor" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalBPMonitor" id="nonFunctionalBPMonitor" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalBPMonitor'];?>" onblur="checkNumberCount('totalBPMonitor', 'functionalBPMonitor', 'nonFunctionalBPMonitor')">
                        <span id="err_nonFunctionalBPMonitor" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Television</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalTV" id="totalTV" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalTV'];?>" onblur="checkNumberCount('totalTV', 'functionalTV', 'nonFunctionalTV')">
                        <span id="err_totalTV" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalTV" id="functionalTV" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalTV'];?>" onblur="checkNumberCount('totalTV', 'functionalTV', 'nonFunctionalTV')">
                        <span id="err_functionalTV" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalTV" id="nonFunctionalTV" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalTV'];?>" onblur="checkNumberCount('totalTV', 'functionalTV', 'nonFunctionalTV')">
                        <span id="err_nonFunctionalTV" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- tenth row of form end -->

              <!-- eleventh row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Wall Clock</h6>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Numbers </label>
                      <div class="controls">
                        <input type="text" name="totalWallClock" id="totalWallClock" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['totalWallClock'];?>" onblur="checkNumberCount('totalWallClock', 'functionalWallClock', 'nonFunctionalWallClock')">
                        <span id="err_totalWallClock" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional </label>
                      <div class="controls">
                        <input type="text" name="functionalWallClock" id="functionalWallClock" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['functionalWallClock'];?>" onblur="checkNumberCount('totalWallClock', 'functionalWallClock', 'nonFunctionalWallClock')">
                        <span id="err_functionalWallClock" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional </label>
                      <div class="controls">
                        <input type="text" name="nonFunctionalWallClock" id="nonFunctionalWallClock" class="form-control" <?php echo $readonlyStatus; ?> value="<?php echo $GetLounge['nonFunctionalWallClock'];?>" onblur="checkNumberCount('totalWallClock', 'functionalWallClock', 'nonFunctionalWallClock')">
                        <span id="err_nonFunctionalWallClock" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 row" style="margin-left: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50" style="max-width: max-content;">Availability Of KMC Register</h6>
                    <div class="row">
                      <ul class="list-unstyled mb-0 ml-1" style="margin-top: 5px;">
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="kmcRegisterAvailabilty" id="radio15" class="kmc_register" value="1" <?php if($GetLounge['kmcRegisterAvailabilty'] == 1) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio15">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" name="kmcRegisterAvailabilty" id="radio16" class="kmc_register" value="2" <?php if($GetLounge['kmcRegisterAvailabilty'] == 2) { echo 'checked'; } ?> <?php echo $disableStatus; ?>>
                              <label for="radio16">No</label>
                            </div>
                          </fieldset>
                        </li>
                      </ul>
                      <span id="err_kmc_register" class="custom-error"></span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- eleventh row of form end -->

              <div class="col-sm-12 row mb-1">
                  <div class="col-sm-12">
                    <h6 class="py-50">Verify Amenities Information</h6>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                        <label>Verification Status <span class="red"></span></label>
                        <div class="controls">
                          <select class="select2 form-control" name="verification_status" id="verification_status" required="" data-validation-required-message="This field is required" onchange="showReasonBox(this.value)" <?php echo $disableStatus; ?>>
                            <option value="1" <?php if($GetLounge['status'] == 1) { echo 'selected'; } ?>>Pending</option>
                            <option value="2" <?php if($GetLounge['status'] == 2) { echo 'selected'; } ?>>Approve</option>
                            <option value="3" <?php if($GetLounge['status'] == 3) { echo 'selected'; } ?>>Reject</option>
                          </select>
                        </div>
                      </div>
                  </div>

                  <?php  
                    if($GetLounge['status'] == 3) {
                      $style = '';
                    } else {
                      $style = 'display: none;';
                    }
                  ?>

                  <div class="col-sm-4" id="reason_box" style="<?= $style; ?>">
                      <div class="form-group">
                        <label>Reason <span class="red"></span></label>
                        <div class="controls">
                          <textarea class="form-control" rows="3" name="reason" id="reason" <?php echo $disableStatus; ?>><?= $GetLounge['reason'] ?></textarea>
                          <span class="custom-error" id="err_reason"></span>
                        </div>
                      </div>
                  </div>
                  
              </div>


              
              <button type="submit" id="submitButton" class="btn btn-primary" style="<?php echo $buttonDisable; ?>">Submit</button>
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

  function openDetails(value,id){             
    if(value==1){  
      var other_value = 2;
    }else{
      var other_value = 1;
    }
    $('#div_'+id+"_"+value).show();
    $('#div_'+id+"_"+other_value).hide();
  }

  function checkNumberCount(id1, id2, id3){
    var val1 = $('#'+id1).val();
    var val2 = $('#'+id2).val();
    var val3 = $('#'+id3).val();
    if(val1 != '' && val2 != '' && val3 != ''){
      if(parseInt(val1) != parseInt(val2)+parseInt(val3)){
        $('#err_'+id1).html('Total numbers must be equal to sum of functional & non functional.').show();
        $('#submitButton').prop('disabled', true);
        
        return false;
      } else {
        $('#err_'+id1).html('').hide();
        $('#submitButton').prop('disabled', false);
      }
    }
  }
</script>