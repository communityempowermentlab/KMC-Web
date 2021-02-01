

   
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
          <div class="col-sm-12">
            <h5 class="content-header-title float-left pr-1 mb-0"><?= $GetLoungeData['loungeName'] ?> Amenities</h5>
            <div class="breadcrumb-wrapper col-sm-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>loungeM/manageLounge">Lounges</a>
                </li>
                <li class="breadcrumb-item active">Lounge Amenities
                </li>
              </ol>
              <p style="float: right; color: black;"> <b>Verified Mobile</b> : <?php if(!empty($GetLounge['verifiedMobile'])) { echo $GetLounge['verifiedMobile']; } else { echo 'N/A'; } ?> |
                <b>Last Updated On:&nbsp;</b><?php if(!empty($GetLounge)) { ?><a href="<?php echo base_url(); ?>loungeM/viewAmenitiesLog/<?php echo $GetLoungeData['loungeId']; ?>"><?php echo date("F d ",strtotime($GetLounge['modifyDate'])).'at '.date("h:i A",strtotime($GetLounge['modifyDate']));?></a>
              <?php } else {  echo "Not Updated"; } ?>
            </p>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo site_url();?>loungeM/updateLoungeAmenities/<?php echo $GetLoungeData['loungeId'];?>/<?php echo $facility_id; ?>" onsubmit="return validateAmenities()">


              <!-- first row of form start -->
              <div class="col-sm-12 row mb-1">
                <div class="col-sm-6 row" style="margin-right: 15px;">
                  <div class="col-sm-12">
                    <h6 class="py-50">Reclining Beds (Semi fowler beds with mattress)</h6>
                  </div>
                  
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Total Numbers <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" name="bed_total_number" id="bed_total_number" value="<?php echo $GetLounge['totalRecliningBeds'];?>" maxlength="4" placeholder="">
                          <span id="err_bed_total_number" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" name="bed_functional" id="bed_functional" value="<?php echo $GetLounge['functionalRecliningBeds'];?>">
                          <span id="err_bed_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Non Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" name="bed_non_functional" id="bed_non_functional" value="<?php echo $GetLounge['nonFunctionalRecliningBeds'];?>">
                          <span id="err_bed_non_functional" class="custom-error"></span>
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
                        <label>Total Numbers <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" name="table_total_number" id="table_total_number" value="<?php echo $GetLounge['totalBedsideTable'];?>">
                          <span id="err_table_total_number" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" name="table_functional" id="table_functional" value="<?php echo $GetLounge['functionalBedsideTable'];?>">
                          <span id="err_table_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" name="table_non_functional" id="table_non_functional" value="<?php echo $GetLounge['nonFunctionalBedsideTable'];?>">
                          <span id="err_table_non_functional" class="custom-error"></span>
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
                            <input type="radio" class="bedsheet_option" name="bedsheet_option" value="1" id="radio1" onclick="showDataDiv('1', this.value)" <?php if($GetLounge['coloredBedsheetAvailability'] == 1) { echo 'checked'; } ?>>
                            <label for="radio1">Yes</label>

                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" class="bedsheet_option" name="bedsheet_option" value="2" id="radio2" onclick="showDataDiv('1', this.value)" <?php if($GetLounge['coloredBedsheetAvailability'] == 2) { echo 'checked'; } ?>>
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
                        <label>Total Numbers <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" id="bedsheet_total_number" name="bedsheet_total_number" value="<?php echo $GetLounge['totalColoredBedsheet'];?>">
                          <span id="err_bedsheet_total_number" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" id="bedsheet_functional" name="bedsheet_functional" value="<?php echo $GetLounge['functionalColoredBedsheet'];?>">
                          <span id="err_bedsheet_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" maxlength="4" placeholder="" id="bedsheet_non_functional" name="bedsheet_non_functional" value="<?php echo $GetLounge['nonFunctionalColoredBedsheet'];?>">
                          <span id="err_bedsheet_non_functional" class="custom-error"></span>
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
                        <label>Reason <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="form-control" placeholder="Reason" id="bedsheet_reason" name="bedsheet_reason" value="<?php echo $GetLounge['coloredBedsheetReason'];?>">
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="chair_total_number" name="chair_total_number" value="<?php echo $GetLounge['totalRecliningChair'];?>" maxlength="4" placeholder="">
                        <span id="err_chair_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="chair_functional" name="chair_functional" value="<?php echo $GetLounge['functionalRecliningChair'];?>" maxlength="4" placeholder="">
                        <span id="err_chair_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="chair_non_functional" name="chair_non_functional" value="<?php echo $GetLounge['nonFunctionalRecliningChair'];?>" maxlength="4" placeholder="">
                        <span id="err_chair_non_functional" class="custom-error"></span>
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
                            <input type="radio" id="radio3" class="nurse_table_option" name="nurse_table_option" value="1" onclick="showDataDiv('2', this.value)" <?php if($GetLounge['nursingStationAvailability'] == 1) { echo 'checked'; } ?>>
                            <label for="radio3">Yes</label>
                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" id="radio4" class="nurse_table_option" name="nurse_table_option" value="2" onclick="showDataDiv('2', this.value)" <?php if($GetLounge['nursingStationAvailability'] == 2) { echo 'checked'; } ?>>
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
                        <label>Total Numbers <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="nurse_table_total_number" name="nurse_table_total_number" value="<?php echo $GetLounge['totalNursingStation'];?>" maxlength="4" placeholder="">
                          <span id="err_nurse_table_total_number" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="nurse_table_functional" name="nurse_table_functional" value="<?php echo $GetLounge['functionalNursingStation'];?>" maxlength="4" placeholder="">
                          <span id="err_nurse_table_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="nurse_table_non_functional" name="nurse_table_non_functional" value="<?php echo $GetLounge['nonFunctionalNursingStation'];?>" maxlength="4" placeholder="">
                          <span id="err_nurse_table_non_functional" class="custom-error"></span>
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
                        <label>Reason <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="form-control" placeholder="Reason" id="nurse_table_reason" name="nurse_table_reason" value="<?php echo $GetLounge['nursingStationReason'];?>">
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
                            <input type="radio" id="radio5" class="highstool_option" name="highstool_option" value="1" onclick="showDataDiv('3', this.value)" <?php if($GetLounge['highStoolAvailability'] == 1) { echo 'checked'; } ?> >
                            <label for="radio5">Yes</label>
                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" id="radio6" class="highstool_option" name="highstool_option" value="2" onclick="showDataDiv('3', this.value)" <?php if($GetLounge['highStoolAvailability'] == 2) { echo 'checked'; } ?>>
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
                        <label>Total Numbers <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="highstool_total_number" name="highstool_total_number" value="<?php echo $GetLounge['totalHighStool'];?>" maxlength="4" placeholder="">
                          <span id="err_highstool_total_number" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="highstool_functional" name="highstool_functional" value="<?php echo $GetLounge['functionalHighStool'];?>" maxlength="4" placeholder="">
                          <span id="err_highstool_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="highstool_non_functional" name="highstool_non_functional" value="<?php echo $GetLounge['nonFunctionalHighStool'];?>" maxlength="4" placeholder="">
                          <span id="err_highstool_non_functional" class="custom-error"></span>
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
                        <label>Reason <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="form-control" placeholder="Reason" id="highstool_reason" name="highstool_reason" value="<?php echo $GetLounge['highStoolReason'];?>">
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="cubord_total_number" name="cubord_total_number" value="<?php echo $GetLounge['totalCubord'];?>" maxlength="4" placeholder="">
                        <span id="err_cubord_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="cubord_functional" name="cubord_functional" value="<?php echo $GetLounge['functionalCubord'];?>" maxlength="4" placeholder="">
                        <span id="err_cubord_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="cubord_non_functional" name="cubord_non_functional" value="<?php echo $GetLounge['nonFunctionalCubord'];?>" maxlength="4" placeholder="">
                        <span id="err_cubord_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="ac_total_number" name="ac_total_number" value="<?php echo $GetLounge['totalAC'];?>"  maxlength="4" placeholder="">
                        <span id="err_ac_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="ac_functional" name="ac_functional" value="<?php echo $GetLounge['functionalAC'];?>" maxlength="4" placeholder="">
                        <span id="err_ac_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="ac_non_functional" name="ac_non_functional" value="<?php echo $GetLounge['nonFunctionalAC'];?>" maxlength="4" placeholder="">
                        <span id="err_ac_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="room_heater_total_number" name="room_heater_total_number" value="<?php echo $GetLounge['totalRoomHeater'];?>" maxlength="4" placeholder="">
                        <span id="err_room_heater_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="room_heater_functional" name="room_heater_functional" value="<?php echo $GetLounge['functionalRoomHeater'];?>" maxlength="4" placeholder="">
                        <span id="err_room_heater_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="room_heater_non_functional" name="room_heater_non_functional" value="<?php echo $GetLounge['nonFunctionalRoomHeater'];?>" maxlength="4" placeholder="">
                        <span id="err_room_heater_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="weighing_scale_total_number" name="weighing_scale_total_number" value="<?php echo $GetLounge['totalDigitalWeigh'];?>" maxlength="1" placeholder="">
                        <span id="err_weighing_scale_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="weighing_scale_functional" name="weighing_scale_functional" value="<?php echo $GetLounge['functionalDigitalWeigh'];?>" maxlength="1" placeholder="">
                        <span id="err_weighing_scale_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="weighing_scale_non_functional" name="weighing_scale_non_functional" value="<?php echo $GetLounge['nonFunctionalDigitalWeigh'];?>" maxlength="1" placeholder="">
                        <span id="err_weighing_scale_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-2" id="fan_total_number" name="fan_total_number" value="<?php echo $GetLounge['totalFans'];?>" maxlength="2" placeholder="">
                        <span id="err_fan_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-2" id="fan_functional" name="fan_functional" value="<?php echo $GetLounge['functionalFans'];?>" maxlength="2" placeholder="">
                        <span id="err_fan_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-2" id="fan_non_functional" name="fan_non_functional" value="<?php echo $GetLounge['nonFunctionalFans'];?>" maxlength="2" placeholder="">
                        <span id="err_fan_non_functional" class="custom-error"></span>
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
                            <input type="radio" id="radio7" class="thermometer_option" name="thermometer_option" value="1" onclick="showDataDiv('4', this.value)" <?php if($GetLounge['roomThermometerAvailability'] == 1) { echo 'checked'; } ?>>
                            <label for="radio7">Yes</label>
                          </div>
                        </fieldset>
                      </li>
                      <li class="d-inline-block mr-2 mb-1">
                        <fieldset>
                          <div class="radio">
                            <input type="radio" id="radio8" class="thermometer_option" name="thermometer_option" value="2" onclick="showDataDiv('4', this.value)" <?php if($GetLounge['roomThermometerAvailability'] == 2) { echo 'checked'; } ?>>
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
                        <label>Total Numbers <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="thermometer_total_number" name="thermometer_total_number" value="<?php echo $GetLounge['totalRoomThermometer'];?>" maxlength="4" placeholder="">
                          <span id="err_thermometer_total_number" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="thermometer_functional" name="thermometer_functional" value="<?php echo $GetLounge['functionalRoomThermometer'];?>" maxlength="4" placeholder="">
                          <span id="err_thermometer_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="thermometer_non_functional" name="thermometer_non_functional" value="<?php echo $GetLounge['nonFunctionalRoomThermometer'];?>" maxlength="4" placeholder="">
                          <span id="err_thermometer_non_functional" class="custom-error"></span>
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
                        <label>Reason <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="form-control" placeholder="Reason" id="thermometer_reason" name="thermometer_reason" value="<?php echo $GetLounge['roomThermometerReason'];?>">
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
                              <input type="radio" id="radio9" class="mask_supply_option" name="mask_supply_option" value="1" <?php if($GetLounge['maskSupplyAvailability'] == 1) { echo 'checked'; } ?>>
                              <label for="radio9">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" id="radio10" class="mask_supply_option" name="mask_supply_option" value="2" <?php if($GetLounge['maskSupplyAvailability'] == 2) { echo 'checked'; } ?>>
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
                              <input type="checkbox" name="inverter" class="checkbox-input" value="1" id="check1" <?php if($GetLounge['powerBackupInverter'] == 1) { echo 'checked'; } ?>>
                              <label for="check1">Invertor</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="checkbox">
                              <input type="checkbox" class="checkbox-input" name="generator" value="1" id="check2" <?php if($GetLounge['powerBackupGenerator'] == 1) { echo 'checked'; } ?>>
                              <label for="check2">Generator</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="checkbox">
                              <input type="checkbox" class="checkbox-input" name="solar" value="1" id="check3" <?php if($GetLounge['powerBackupSolar'] == 1) { echo 'checked'; } ?>>
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

                  <div id="div_3_1" class="row" style="<?= $display3_1; ?>padding-left: 15px;padding-right: 15px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Total Numbers <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="highstool_total_number" name="highstool_total_number" value="<?php echo $GetLounge['totalHighStool'];?>" maxlength="4" placeholder="">
                          <span id="err_highstool_total_number" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="highstool_functional" name="highstool_functional" value="<?php echo $GetLounge['functionalHighStool'];?>" maxlength="4" placeholder="">
                          <span id="err_highstool_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Non Functional <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="touchspin-min-max-4" id="highstool_non_functional" name="highstool_non_functional" value="<?php echo $GetLounge['nonFunctionalHighStool'];?>" maxlength="4" placeholder="">
                          <span id="err_highstool_non_functional" class="custom-error"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php $display3_2 = 'display: none;'; if($GetLounge['highStoolAvailability'] == 2) { 
                    $display3_2 = '';
                  } ?>

                  <!-- <div id="div_3_2" class="row col-sm-12" style="<?= $display3_2; ?>padding-left: 15px;padding-right: 0px;margin-right: 0;">
                    <div class="col-md-12" style="padding-right: 0;">
                      <div class="form-group">
                        <label>Reason <span class="red">*</span></label>
                        <div class="controls">
                          <input type="text" class="form-control" placeholder="Reason" id="highstool_reason" name="highstool_reason" value="<?php echo $GetLounge['highStoolReason'];?>">
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
                              <input type="radio" id="radio11" class="babykit_supply_option" name="babykit_supply_option" value="1" <?php if($GetLounge['babyKitSupply'] == 1) { echo 'checked'; } ?>>
                              <label for="radio11">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" id="radio12" class="babykit_supply_option" name="babykit_supply_option" value="2" <?php if($GetLounge['babyKitSupply'] == 2) { echo 'checked'; } ?>>
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
                              <input type="radio" id="radio13" class="blanket_supply_option" name="blanket_supply_option" value="1" <?php if($GetLounge['adultBlanketSupply'] == 1) { echo 'checked'; } ?>>
                              <label for="radio13">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" id="radio14" class="blanket_supply_option" name="blanket_supply_option" value="2" <?php if($GetLounge['adultBlanketSupply'] == 2) { echo 'checked'; } ?>>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" name="digital_thermo_total_number" id="digital_thermo_total_number" value="<?php echo $GetLounge['totalDigitalThermometer'];?>" maxlength="1" placeholder="">
                        <span id="err_digital_thermo_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" name="digital_thermo_functional" id="digital_thermo_functional" value="<?php echo $GetLounge['functionalDigitalThermometer'];?>" maxlength="1" placeholder="">
                        <span id="err_digital_thermo_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" name="digital_thermo_non_functional" id="digital_thermo_non_functional" value="<?php echo $GetLounge['nonFunctionalDigitalThermometer'];?>" maxlength="1" placeholder="">
                        <span id="err_digital_thermo_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="oximeter_total_number" name="oximeter_total_number" value="<?php echo $GetLounge['totalPulseOximeter'];?>" maxlength="1" placeholder="">
                        <span id="err_oximeter_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="oximeter_functional" name="oximeter_functional" value="<?php echo $GetLounge['functionalPulseOximeter'];?>" maxlength="1" placeholder="">
                        <span id="err_oximeter_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="oximeter_non_functional" name="oximeter_non_functional" value="<?php echo $GetLounge['nonFunctionalPulseOximeter'];?>" maxlength="1" placeholder="">
                        <span id="err_oximeter_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="bp_total_number" name="bp_total_number" value="<?php echo $GetLounge['totalBPMonitor'];?>" maxlength="1" placeholder="">
                        <span id="err_bp_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="bp_functional" name="bp_functional" value="<?php echo $GetLounge['functionalBPMonitor'];?>" maxlength="1" placeholder="">
                        <span id="err_bp_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-1" id="bp_non_functional" name="bp_non_functional" value="<?php echo $GetLounge['nonFunctionalBPMonitor'];?>" maxlength="1" placeholder="">
                        <span id="err_bp_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="tv_total_number" name="tv_total_number" value="<?php echo $GetLounge['totalTV'];?>" maxlength="4" placeholder="">
                        <span id="err_tv_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="tv_functional" name="tv_functional" value="<?php echo $GetLounge['functionalTV'];?>" maxlength="4" placeholder="">
                        <span id="err_tv_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="tv_non_functional" name="tv_non_functional" value="<?php echo $GetLounge['nonFunctionalTV'];?>" maxlength="4" placeholder="">
                        <span id="err_tv_non_functional" class="custom-error"></span>
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
                      <label>Total Numbers <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="clock_total_number" name="clock_total_number" value="<?php echo $GetLounge['totalWallClock'];?>" maxlength="4" placeholder="">
                        <span id="err_clock_total_number" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="clock_functional" name="clock_functional" value="<?php echo $GetLounge['functionalWallClock'];?>" maxlength="4" placeholder="">
                        <span id="err_clock_functional" class="custom-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Non Functional <span class="red">*</span></label>
                      <div class="controls">
                        <input type="text" class="touchspin-min-max-4" id="clock_non_functional" name="clock_non_functional" value="<?php echo $GetLounge['nonFunctionalWallClock'];?>" maxlength="4" placeholder="">
                        <span id="err_clock_non_functional" class="custom-error"></span>
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
                              <input type="radio" id="radio15" class="kmc_register" name="kmc_register" value="1" <?php if($GetLounge['kmcRegisterAvailabilty'] == 1) { echo 'checked'; } ?>>
                              <label for="radio15">Yes</label>
                            </div>
                          </fieldset>
                        </li>
                        <li class="d-inline-block mr-2 mb-1">
                          <fieldset>
                            <div class="radio">
                              <input type="radio" id="radio16" class="kmc_register" name="kmc_register" value="2" <?php if($GetLounge['kmcRegisterAvailabilty'] == 2) { echo 'checked'; } ?>>
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


    