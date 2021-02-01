<?php $this->load->model('UserModel');?>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 28px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(20px);
  -ms-transform: translateX(20px);
  transform: translateX(20px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 24px;
}

.slider.round:before {
  border-radius: 50%;
}
.divPadding{
  padding: 0;
}
h4 {margin-bottom: 0;}

.radioCSS .form-radio
{
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     display: inline-block;
     position: relative;
     background-color: #f1f1f1;
     color: #666;
     top: 10px;
     height: 30px;
     width: 30px;
     border: 0;
     border-radius: 50px;
     cursor: pointer;     
     margin-right: 7px;
     outline: none;
}
.radioCSS .form-radio:checked::before
{
     position: absolute;
     font: 13px/1 'Open Sans', sans-serif;
     left: 11px;
     top: 7px;
     content: '\02143';
     transform: rotate(40deg);
}
.radioCSS .form-radio:hover
{
     background-color: #f7f7f7;
}
.radioCSS .form-radio:checked
{
     background-color: #f1f1f1;
}
.radioCSS label
{
     font: 15px/1.7 'Open Sans', sans-serif;
     color: #333;
     -webkit-font-smoothing: antialiased;
     -moz-osx-font-smoothing: grayscale;
     cursor: pointer;
} 

.radioCSS .form-checkbox
{
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     display: inline-block;
     position: relative;
     background-color: #f1f1f1;
     color: #666;
     top: 10px;
     height: 30px;
     width: 30px;
     border: 0;
     cursor: pointer;     
     margin-right: 7px;
     outline: none;
}
.radioCSS .form-checkbox:checked::before
{
     position: absolute;
     font: 13px/1 'Open Sans', sans-serif;
     left: 11px;
     top: 7px;
     content: '\02143';
     transform: rotate(40deg);
}
.radioCSS .form-checkbox:hover
{
     background-color: #f7f7f7;
}
.radioCSS .form-checkbox:checked
{
     background-color: #f1f1f1;
}

input[type=radio]:focus {
    outline: none !important;
}

input[type=checkbox]:focus {
    outline: none !important;
}
  
.radioCSS{
  margin-bottom: 25px;
}

.errorMessage{
  color: red;
  font-style: italic;
}
</style>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Amenities For <?php echo $GetLoungeData['loungeName'];?> <?php echo 'Lounge';  ?>
       <small style="font-size: 80% !important;padding-top: 5px;"><b>
        <?php if(!empty($GetLounge)) { ?>
        <a href="<?php echo base_url(); ?>loungeM/viewAmenitiesLog/<?php echo $GetLoungeData['loungeId']; ?>">Last Updated On:&nbsp;<?php echo date("F d ",strtotime($GetLounge['modifyDate'])).'at '.date("h:i A",strtotime($GetLounge['modifyDate']));?></a>
          <?php } else {  echo "Not Updated"; } ?>
        </b></small>
      </h1>
      
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <form class="form-horizontal" action="<?php echo site_url();?>loungeM/updateLoungeAmenities/<?php echo $GetLoungeData['loungeId'];?>/<?php echo $facility_id; ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
              <div class="box-body">

              
               <div class="col-md-12"><b style="font-size:18px;">Amenities Details:</b></div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Reclining Beds (Semi fowler beds with mattress)</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" name="bed_total_number" id="bed_total_number" value="<?php echo $GetLounge['totalRecliningBeds'];?>">
                    <span class="errorMessage" id="err_bed_total_number"><?php echo form_error('bed_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" name="bed_functional" id="bed_functional" value="<?php echo $GetLounge['functionalRecliningBeds'];?>">
                    <span class="errorMessage" id="err_bed_functional"><?php echo form_error('bed_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" name="bed_non_functional" id="bed_non_functional" value="<?php echo $GetLounge['nonFunctionalRecliningBeds'];?>">
                    <span class="errorMessage" id="err_bed_non_functional"><?php echo form_error('bed_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Bedside Table</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" name="table_total_number" id="table_total_number" value="<?php echo $GetLounge['totalBedsideTable'];?>">
                    <span class="errorMessage" id="err_table_total_number"><?php echo form_error('table_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" name="table_functional" id="table_functional" value="<?php echo $GetLounge['functionalBedsideTable'];?>">
                    <span class="errorMessage" id="err_table_functional"><?php echo form_error('table_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" name="table_non_functional" id="table_non_functional" value="<?php echo $GetLounge['nonFunctionalBedsideTable'];?>">
                    <span class="errorMessage" id="err_table_non_functional"><?php echo form_error('table_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Colored Bedsheet & Pillow Cover (VIBGYOR)</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio" name="bedsheet_option" value="1" class="form-radio bedsheet_option" <?php if($GetLounge['coloredBedsheetAvailability'] == 1) { echo 'checked'; } ?> onclick="showDataDiv('1', this.value)"><label for="radio-one">Yes</label>
                  <input type="radio" name="bedsheet_option" value="2"  class="form-radio bedsheet_option" <?php if($GetLounge['coloredBedsheetAvailability'] == 2) { echo 'checked'; } ?> onclick="showDataDiv('1', this.value)"><label for="radio-one">No</label>
                  <div><span id="err_bedsheet_option" class="errorMessage"></span></div>
                </div>

                <?php $display1_1 = 'display: none;'; if($GetLounge['coloredBedsheetAvailability'] == 1) { 
                  $display1_1 = ''; }
                ?>

                  <div id="div_1_1" style="<?= $display1_1; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="bedsheet_total_number" name="bedsheet_total_number" value="<?php echo $GetLounge['totalColoredBedsheet'];?>">
                        <span class="errorMessage" id="err_bedsheet_total_number"><?php echo form_error('bedsheet_total_number');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="bedsheet_functional" name="bedsheet_functional" value="<?php echo $GetLounge['functionalColoredBedsheet'];?>">
                        <span class="errorMessage" id="err_bedsheet_functional"><?php echo form_error('bedsheet_functional');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="bedsheet_non_functional" name="bedsheet_non_functional" value="<?php echo $GetLounge['nonFunctionalColoredBedsheet'];?>">
                        <span class="errorMessage" id="err_bedsheet_non_functional"><?php echo form_error('bedsheet_non_functional');?></span>
                      </div>
                    </div>
                  </div>
               

                <?php $display1_2 = 'display: none;'; if($GetLounge['coloredBedsheetAvailability'] == 2) {
                  $display1_2 = ''; }
                ?>
                  <div id="div_1_2" style="<?= $display1_2; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Reason <span style="color:red">  *</span></label>
                        <input type="text" class="form-control" placeholder="Reason" id="bedsheet_reason" name="bedsheet_reason" value="<?php echo $GetLounge['coloredBedsheetReason'];?>">
                        <span class="errorMessage" id="err_bedsheet_reason"><?php echo form_error('bedsheet_reason');?></span>
                      </div>
                    </div>
                  </div>
                
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Reclining Chair</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="chair_total_number" name="chair_total_number" value="<?php echo $GetLounge['totalRecliningChair'];?>">
                    <span class="errorMessage" id="err_chair_total_number"><?php echo form_error('chair_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="chair_functional" name="chair_functional" value="<?php echo $GetLounge['functionalRecliningChair'];?>">
                    <span class="errorMessage" id="err_chair_functional"><?php echo form_error('chair_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="chair_non_functional" name="chair_non_functional" value="<?php echo $GetLounge['nonFunctionalRecliningChair'];?>">
                    <span class="errorMessage" id="err_chair_non_functional"><?php echo form_error('chair_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Chair & Table for Nurse (Nursing Station)</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio" name="nurse_table_option" value="1"  class="form-radio nurse_table_option" <?php if($GetLounge['nursingStationAvailability'] == 1) { echo 'checked'; } ?> onclick="showDataDiv('2', this.value)"><label for="radio-7">Yes</label>
                  <input type="radio" name="nurse_table_option" value="2"  class="form-radio nurse_table_option" <?php if($GetLounge['nursingStationAvailability'] == 2) { echo 'checked'; } ?> onclick="showDataDiv('2', this.value)"><label for="radio-8">No</label>
                  <div><span id="err_nurse_table_option" class="errorMessage"></span></div>
                </div>

                <?php $display2_1 = 'display: none;'; if($GetLounge['nursingStationAvailability'] == 1) { 
                  $display2_1 = '';
                 } ?>
                  <div id="div_2_1" style="<?= $display2_1; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="nurse_table_total_number" name="nurse_table_total_number" value="<?php echo $GetLounge['totalNursingStation'];?>">
                        <span class="errorMessage" id="err_nurse_table_total_number"><?php echo form_error('nurse_table_total_number');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="nurse_table_functional" name="nurse_table_functional" value="<?php echo $GetLounge['functionalNursingStation'];?>">
                        <span class="errorMessage" id="err_nurse_table_functional"><?php echo form_error('nurse_table_functional');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="nurse_table_non_functional" name="nurse_table_non_functional" value="<?php echo $GetLounge['nonFunctionalNursingStation'];?>">
                        <span class="errorMessage" id="err_nurse_table_non_functional"><?php echo form_error('nurse_table_non_functional');?></span>
                      </div>
                    </div>
                  </div>
                

                <?php $display2_2 = 'display: none;'; if($GetLounge['nursingStationAvailability'] == 2) { 
                  $display2_2 = '';
                } ?>
                  <div id="div_2_2" style="<?= $display2_2; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Reason <span style="color:red">  *</span></label>
                        <input type="text" class="form-control" placeholder="Reason" id="nurse_table_reason" name="nurse_table_reason" value="<?php echo $GetLounge['nursingStationReason'];?>">
                        <span class="errorMessage" id="err_nurse_table_reason"><?php echo form_error('nurse_table_reason');?></span>
                      </div>
                    </div>
                  </div>
                
              </div>


              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">High Stool for Weighing Scale</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio" name="highstool_option" value="1" class="form-radio highstool_option" <?php if($GetLounge['highStoolAvailability'] == 1) { echo 'checked'; } ?> onclick="showDataDiv('3', this.value)"><label for="radio-7">Yes</label>
                  <input type="radio" name="highstool_option" value="2" class="form-radio highstool_option" <?php if($GetLounge['highStoolAvailability'] == 2) { echo 'checked'; } ?> onclick="showDataDiv('3', this.value)"><label for="radio-8">No</label>
                  <div><span id="err_highstool_option" class="errorMessage"></span></div>
                </div>

                <?php $display3_1 = 'display: none;'; if($GetLounge['highStoolAvailability'] == 1) { 
                    $display3_1 = '';
                } ?>
                  <div id="div_3_1" style="<?= $display3_1; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="highstool_total_number" name="highstool_total_number" value="<?php echo $GetLounge['totalHighStool'];?>">
                        <span class="errorMessage" id="err_highstool_total_number"><?php echo form_error('highstool_total_number');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="highstool_functional" name="highstool_functional" value="<?php echo $GetLounge['functionalHighStool'];?>">
                        <span class="errorMessage" id="err_highstool_functional"><?php echo form_error('highstool_functional');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="highstool_non_functional" name="highstool_non_functional" value="<?php echo $GetLounge['nonFunctionalHighStool'];?>">
                        <span class="errorMessage" id="err_highstool_non_functional"><?php echo form_error('highstool_non_functional');?></span>
                      </div>
                    </div>
                  </div>
                

                <?php $display3_2 = 'display: none;'; if($GetLounge['highStoolAvailability'] == 2) { 
                  $display3_2 = '';
                } ?>
                  <div id="div_3_2" style="<?= $display3_2; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Reason <span style="color:red">  *</span></label>
                        <input type="text" class="form-control" placeholder="Reason" id="highstool_reason" name="highstool_reason" value="<?php echo $GetLounge['highStoolReason'];?>">
                        <span class="errorMessage" id="err_highstool_reason"><?php echo form_error('highstool_reason');?></span>
                      </div>
                    </div>
                  </div>
                
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Cubord</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="cubord_total_number" name="cubord_total_number" value="<?php echo $GetLounge['totalCubord'];?>">
                    <span class="errorMessage" id="err_cubord_total_number"><?php echo form_error('cubord_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="cubord_functional" name="cubord_functional" value="<?php echo $GetLounge['functionalCubord'];?>">
                    <span class="errorMessage" id="err_cubord_functional"><?php echo form_error('cubord_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="cubord_non_functional" name="cubord_non_functional" value="<?php echo $GetLounge['nonFunctionalCubord'];?>" >
                    <span class="errorMessage" id="err_cubord_non_functional"><?php echo form_error('cubord_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Air Conditioner</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="ac_total_number" name="ac_total_number" value="<?php echo $GetLounge['totalAC'];?>" >
                    <span class="errorMessage" id="err_ac_total_number"><?php echo form_error('ac_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="ac_functional" name="ac_functional" value="<?php echo $GetLounge['functionalAC'];?>" >
                    <span class="errorMessage" id="err_ac_functional"><?php echo form_error('ac_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="ac_non_functional" name="ac_non_functional" value="<?php echo $GetLounge['nonFunctionalAC'];?>">
                    <span class="errorMessage" id="err_ac_non_functional"><?php echo form_error('ac_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Room Heater (Oil Filter)</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label "> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="room_heater_total_number" name="room_heater_total_number" value="<?php echo $GetLounge['totalRoomHeater'];?>">
                    <span class="errorMessage" id="err_room_heater_total_number"><?php echo form_error('room_heater_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label "> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="room_heater_functional" name="room_heater_functional" value="<?php echo $GetLounge['functionalRoomHeater'];?>">
                    <span class="errorMessage" id="err_room_heater_functional"><?php echo form_error('room_heater_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="room_heater_non_functional" name="room_heater_non_functional" value="<?php echo $GetLounge['nonFunctionalRoomHeater'];?>">
                    <span class="errorMessage" id="err_room_heater_non_functional"><?php echo form_error('room_heater_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Digital Weighing Scale</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="1" id="weighing_scale_total_number" name="weighing_scale_total_number" value="<?php echo $GetLounge['totalDigitalWeigh'];?>">
                    <span class="errorMessage" id="err_weighing_scale_total_number"><?php echo form_error('weighing_scale_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="1" id="weighing_scale_functional" name="weighing_scale_functional" value="<?php echo $GetLounge['functionalDigitalWeigh'];?>">
                    <span class="errorMessage" id="err_weighing_scale_functional"><?php echo form_error('weighing_scale_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="1" id="weighing_scale_non_functional" name="weighing_scale_non_functional" value="<?php echo $GetLounge['nonFunctionalDigitalWeigh'];?>">
                    <span class="errorMessage" id="err_weighing_scale_non_functional"><?php echo form_error('weighing_scale_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Fans</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="2" id="fan_total_number" name="fan_total_number" value="<?php echo $GetLounge['totalFans'];?>">
                    <span class="errorMessage" id="err_fan_total_number"><?php echo form_error('fan_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="2" id="fan_functional" name="fan_functional" value="<?php echo $GetLounge['functionalFans'];?>">
                    <span class="errorMessage" id="err_fan_functional"><?php echo form_error('fan_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="2" id="fan_non_functional" name="fan_non_functional" value="<?php echo $GetLounge['nonFunctionalFans'];?>">
                    <span class="errorMessage" id="err_fan_non_functional"><?php echo form_error('fan_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Room Thermometer With Digital Clocks</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio" name="thermometer_option" value="1" class="form-radio thermometer_option" onclick="showDataDiv('4', this.value)" <?php if($GetLounge['roomThermometerAvailability'] == 1) { echo 'checked'; } ?>><label for="radio-7">Yes</label>
                  <input type="radio" name="thermometer_option" value="2" class="form-radio thermometer_option" onclick="showDataDiv('4', this.value)" <?php if($GetLounge['roomThermometerAvailability'] == 2) { echo 'checked'; } ?>><label for="radio-8">No</label>
                  <div><span id="err_thermometer_option" class="errorMessage"></span></div>
                </div>

                <?php $display4_1 = 'display: none;'; if($GetLounge['roomThermometerAvailability'] == 1) { 
                  $display4_1 = '';
                } ?>
                  <div id="div_4_1" style="<?= $display4_1; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="thermometer_total_number" name="thermometer_total_number" value="<?php echo $GetLounge['totalRoomThermometer'];?>">
                        <span class="errorMessage" id="err_thermometer_total_number"><?php echo form_error('thermometer_total_number');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="thermometer_functional" name="thermometer_functional" value="<?php echo $GetLounge['functionalRoomThermometer'];?>">
                        <span class="errorMessage" id="err_thermometer_functional"><?php echo form_error('thermometer_functional');?></span>
                      </div>

                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                        <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="thermometer_non_functional" name="thermometer_non_functional" value="<?php echo $GetLounge['nonFunctionalRoomThermometer'];?>">
                        <span class="errorMessage" id="err_thermometer_non_functional"><?php echo form_error('thermometer_non_functional');?></span>
                      </div>
                    </div>
                  </div>
                

                <?php $display4_2 = 'display: none;'; if($GetLounge['roomThermometerAvailability'] == 2) { 
                  $display4_2 = '';
                } ?>
                  <div id="div_4_2" style="<?= $display4_2; ?>">
                    <div class="col-sm-12 col-xs-12 form-group">
                      <div class="col-sm-4 col-xs-4">
                        <label for="inputPassword3" class="control-label"> Reason <span style="color:red">  *</span></label>
                        <input type="text" class="form-control" id="thermometer_reason" name="thermometer_reason" placeholder="Reason" value="<?php echo $GetLounge['roomThermometerReason'];?>">
                        <span class="errorMessage" id="err_thermometer_reason"><?php echo form_error('thermometer_reason');?></span>
                      </div>
                    </div>
                  </div>
              </div>


              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Regular Supply Of Masks, Shoe Covers & Slippers</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio"  value="1" name="mask_supply_option" class="form-radio mask_supply_option"  <?php if($GetLounge['maskSupplyAvailability'] == 1) { echo 'checked'; } ?>><label for="radio-7">Yes</label>
                  <input type="radio"  value="2" name="mask_supply_option" class="form-radio mask_supply_option"  <?php if($GetLounge['maskSupplyAvailability'] == 2) { echo 'checked'; } ?>><label for="radio-8">No</label>
                  <div><span id="err_mask_supply_option" class="errorMessage"></span></div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Power Backup Facility in the Hospital</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="checkbox" name="inverter" value="1" id="check1" class="form-checkbox"  <?php if($GetLounge['powerBackupInverter'] == 1) { echo 'checked'; } ?>><label for="radio-7">Invertor</label>
                  <input type="checkbox" name="generator" value="1" id="check2" class="form-checkbox"  <?php if($GetLounge['powerBackupGenerator'] == 1) { echo 'checked'; } ?>><label for="radio-8">Generator</label>
                  <input type="checkbox" name="solar" value="1" id="check3" class="form-checkbox"  <?php if($GetLounge['powerBackupSolar'] == 1) { echo 'checked'; } ?>><label for="radio-8">Solar</label>
                  <div><span id="err_power_backup_option" class="errorMessage"></span></div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Regular Supply Of Baby Blanket/Wrap, Gown & KMC Baby Kit</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio" name="babykit_supply_option" value="1" class="form-radio babykit_supply_option"  <?php if($GetLounge['babyKitSupply'] == 1) { echo 'checked'; } ?>><label for="radio-7">Yes</label>
                  <input type="radio" name="babykit_supply_option" value="2" class="form-radio babykit_supply_option"  <?php if($GetLounge['babyKitSupply'] == 2) { echo 'checked'; } ?>><label for="radio-8">No</label>
                  <div><span id="err_babykit_supply_option" class="errorMessage"></span></div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Regular Supply Of Adult Blankets</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio" name="blanket_supply_option" value="1" class="form-radio blanket_supply_option"  <?php if($GetLounge['adultBlanketSupply'] == 1) { echo 'checked'; } ?>><label for="radio-7">Yes</label>
                  <input type="radio" name="blanket_supply_option" value="2" class="form-radio blanket_supply_option"  <?php if($GetLounge['adultBlanketSupply'] == 2) { echo 'checked'; } ?>><label for="radio-8">No</label>
                  <div><span id="err_blanket_supply_option" class="errorMessage"></span></div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Digital Thermometer For Baby & Mother</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="1" name="digital_thermo_total_number" id="digital_thermo_total_number"value="<?php echo $GetLounge['totalDigitalThermometer'];?>">
                    <span class="errorMessage" id="err_digital_thermo_total_number"><?php echo form_error('digital_thermo_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="1" name="digital_thermo_functional" id="digital_thermo_functional" value="<?php echo $GetLounge['functionalDigitalThermometer'];?>">
                    <span class="errorMessage" id="err_digital_thermo_functional"><?php echo form_error('digital_thermo_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="1" name="digital_thermo_non_functional" id="digital_thermo_non_functional" value="<?php echo $GetLounge['nonFunctionalDigitalThermometer'];?>">
                    <span class="errorMessage" id="err_digital_thermo_non_functional"><?php echo form_error('digital_thermo_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Pulse Oximeter</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="1" id="oximeter_total_number" name="oximeter_total_number" value="<?php echo $GetLounge['totalPulseOximeter'];?>">
                    <span class="errorMessage" id="err_oximeter_total_number"><?php echo form_error('oximeter_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="1" id="oximeter_functional" name="oximeter_functional" value="<?php echo $GetLounge['functionalPulseOximeter'];?>">
                    <span class="errorMessage" id="err_oximeter_functional"><?php echo form_error('oximeter_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="1" id="oximeter_non_functional" name="oximeter_non_functional" value="<?php echo $GetLounge['nonFunctionalPulseOximeter'];?>">
                    <span class="errorMessage" id="err_oximeter_non_functional"><?php echo form_error('oximeter_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Blood Pressure Monitor</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="1" id="bp_total_number" name="bp_total_number" value="<?php echo $GetLounge['totalBPMonitor'];?>">
                    <span class="errorMessage" id="err_bp_total_number"><?php echo form_error('bp_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="1" id="bp_functional" name="bp_functional" value="<?php echo $GetLounge['functionalBPMonitor'];?>">
                    <span class="errorMessage" id="err_bp_functional"><?php echo form_error('bp_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="1" id="bp_non_functional" name="bp_non_functional" value="<?php echo $GetLounge['nonFunctionalBPMonitor'];?>">
                    <span class="errorMessage" id="err_bp_non_functional"><?php echo form_error('bp_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Television</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="tv_total_number" name="tv_total_number" value="<?php echo $GetLounge['totalTV'];?>">
                    <span class="errorMessage" id="err_tv_total_number"><?php echo form_error('tv_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="tv_functional" name="tv_functional" value="<?php echo $GetLounge['functionalTV'];?>">
                    <span class="errorMessage" id="err_tv_functional"><?php echo form_error('tv_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="tv_non_functional" name="tv_non_functional" value="<?php echo $GetLounge['nonFunctionalTV'];?>">
                    <span class="errorMessage" id="err_tv_non_functional"><?php echo form_error('tv_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Wall Clock</h4>

                <div class="col-sm-12 col-xs-12 form-group">
                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Total Numbers <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Total Numbers" maxlength="4" id="clock_total_number" name="clock_total_number" value="<?php echo $GetLounge['totalWallClock'];?>">
                    <span class="errorMessage" id="err_clock_total_number"><?php echo form_error('clock_total_number');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Functional  <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Functional" maxlength="4" id="clock_functional" name="clock_functional" value="<?php echo $GetLounge['functionalWallClock'];?>">
                    <span class="errorMessage" id="err_clock_functional"><?php echo form_error('clock_functional');?></span>
                  </div>

                  <div class="col-sm-4 col-xs-4">
                    <label for="inputPassword3" class="control-label"> Non Functional   <span style="color:red">  *</span></label>
                    <input type="text" class="form-control m_b_n" placeholder="Non Functional" maxlength="4" id="clock_non_functional" name="clock_non_functional" value="<?php echo $GetLounge['nonFunctionalWallClock'];?>">
                    <span class="errorMessage" id="err_clock_non_functional"><?php echo form_error('clock_non_functional');?></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-xs-12 divPadding">
                <h4 style="padding-left: 15px;">Availability Of KMC Register</h4>

                <div class="input-field col-sm-12 col-xs-12 radioCSS">
                  <input type="radio" name="kmc_register" value="1"  class="form-radio kmc_register" <?php if($GetLounge['kmcRegisterAvailabilty'] == 1) { echo 'checked'; } ?>><label for="radio-7">Yes</label>
                  <input type="radio" name="kmc_register" value="2"  class="form-radio kmc_register" <?php if($GetLounge['kmcRegisterAvailabilty'] == 2) { echo 'checked'; } ?>><label for="radio-8">No</label>
                  <div><span id="err_kmc_register" class="errorMessage"></span></div>
                </div>
              </div>
            
              <!-- /.input group -->

            </div>

                     
              <div class="box-footer">
                <input type="submit" class="btn btn-info pull-right" value="Submit">
              </div>
              <!-- /.box-footer -->
          </form>
          </div>
          <!-- /.box -->
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/chung-timepicker.css" />

<script src="<?php echo base_url();?>assets/admin/js/chung-timepicker.js" type="text/javascript" charset="utf-8"></script>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript">
          $('.timepicker').chungTimePicker();
</script> 
<script type="text/javascript">

  function showDataDiv(id, val) { 
    if(val == 1){
      $('#div_'+id+'_2').hide();
      $('#div_'+id+'_1').show();
    } else {
      $('#div_'+id+'_1').hide();
      $('#div_'+id+'_2').show();
    }
  }

  $(".m_b_n").keypress(function (e) {
        var id = $(this).attr('id');
        var value = $('#'+id).val();
        
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           
            return false;
        }
    });


  function validateForm(){
    var bed_total_number = $('#bed_total_number').val();
    if(bed_total_number == ''){
      $('#err_bed_total_number').html('This field is required.').show();
      $('#bed_total_number').focus();
      return false;
    } else {
      $('#err_bed_total_number').html('').hide();
    }


    var bed_functional = $('#bed_functional').val();
    if(bed_functional == ''){
      $('#err_bed_functional').html('This field is required.').show();
      $('#bed_functional').focus();
      return false;
    } else {
      $('#err_bed_functional').html('').hide();
    }

    var bed_non_functional = $('#bed_non_functional').val();
    if(bed_non_functional == ''){
      $('#err_bed_non_functional').html('This field is required.').show();
      $('#bed_non_functional').focus();
      return false;
    } else {
      $('#err_bed_non_functional').html('').hide();
    }

    if(parseInt(bed_total_number) != parseInt(bed_functional)+parseInt(bed_non_functional)){
      $('#err_bed_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#bed_total_number').focus();
      return false;
    } else {
      $('#err_bed_total_number').html('').hide();
    }

    var table_total_number = $('#table_total_number').val();
    if(table_total_number == ''){
      $('#err_table_total_number').html('This field is required.').show();
      $('#table_total_number').focus();
      return false;
    } else {
      $('#err_table_total_number').html('').hide();
    }


    var table_functional = $('#table_functional').val();
    if(table_functional == ''){
      $('#err_table_functional').html('This field is required.').show();
      $('#table_functional').focus();
      return false;
    } else {
      $('#err_table_functional').html('').hide();
    }

    var table_non_functional = $('#table_non_functional').val();
    if(table_non_functional == ''){
      $('#err_table_non_functional').html('This field is required.').show();
      $('#table_non_functional').focus();
      return false;
    } else {
      $('#err_table_non_functional').html('').hide();
    }

    if(parseInt(table_total_number) != parseInt(table_functional)+parseInt(table_non_functional)){
      $('#err_table_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#table_total_number').focus();
      return false;
    } else {
      $('#err_table_total_number').html('').hide();
    }

    if($('.bedsheet_option').is(':checked')){
      $('#err_bedsheet_option').html('').hide();
      var bedsheet_option = $('input[name="bedsheet_option"]:checked').val(); 
      if(bedsheet_option == 1){
        var bedsheet_total_number = $('#bedsheet_total_number').val();
        if(bedsheet_total_number == ''){
          $('#err_bedsheet_total_number').html('This field is required.').show();
          $('#bedsheet_total_number').focus();
          return false;
        } else {
          $('#err_bedsheet_total_number').html('').hide();
        }


        var bedsheet_functional = $('#bedsheet_functional').val();
        if(bedsheet_functional == ''){
          $('#err_bedsheet_functional').html('This field is required.').show();
          $('#bedsheet_functional').focus();
          return false;
        } else {
          $('#err_bedsheet_functional').html('').hide();
        }

        var bedsheet_non_functional = $('#bedsheet_non_functional').val();
        if(bedsheet_non_functional == ''){
          $('#err_bedsheet_non_functional').html('This field is required.').show();
          $('#bedsheet_non_functional').focus();
          return false;
        } else {
          $('#err_bedsheet_non_functional').html('').hide();
        }

        if(parseInt(bedsheet_total_number) != parseInt(bedsheet_functional)+parseInt(bedsheet_non_functional)){
          $('#err_bedsheet_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#bedsheet_total_number').focus();
          return false;
        } else {
          $('#err_bedsheet_total_number').html('').hide();
        }

      } else {
        var bedsheet_reason = $('#bedsheet_reason').val();
        if(bedsheet_reason == ''){
          $('#err_bedsheet_reason').html('This field is required.').show();
          $('#bedsheet_reason').focus();
          return false;
        } else {
          $('#err_bedsheet_reason').html('').hide();
        }
      }
    } else {
      $('#err_bedsheet_option').html('This field is required.').show();
      $('.bedsheet_option').focus();
      return false;
    }

    var chair_total_number = $('#chair_total_number').val();
    if(chair_total_number == ''){
      $('#err_chair_total_number').html('This field is required.').show();
      $('#chair_total_number').focus();
      return false;
    } else {
      $('#err_chair_total_number').html('').hide();
    }


    var chair_functional = $('#chair_functional').val();
    if(chair_functional == ''){
      $('#err_chair_functional').html('This field is required.').show();
      $('#chair_functional').focus();
      return false;
    } else {
      $('#err_chair_functional').html('').hide();
    }

    var chair_non_functional = $('#chair_non_functional').val();
    if(chair_non_functional == ''){
      $('#err_chair_non_functional').html('This field is required.').show();
      $('#chair_non_functional').focus();
      return false;
    } else {
      $('#err_chair_non_functional').html('').hide();
    }

    if(parseInt(chair_total_number) != parseInt(chair_functional)+parseInt(chair_non_functional)){
      $('#err_chair_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#chair_total_number').focus();
      return false;
    } else {
      $('#err_chair_total_number').html('').hide();
    }

    if($('.nurse_table_option').is(':checked')){
      $('#err_nurse_table_option').html('').hide();
      var nurse_table_option = $('input[name="nurse_table_option"]:checked').val(); 
      if(nurse_table_option == 1){
        var nurse_table_total_number = $('#nurse_table_total_number').val();
        if(nurse_table_total_number == ''){
          $('#err_nurse_table_total_number').html('This field is required.').show();
          $('#nurse_table_total_number').focus();
          return false;
        } else {
          $('#err_nurse_table_total_number').html('').hide();
        }


        var nurse_table_functional = $('#nurse_table_functional').val();
        if(nurse_table_functional == ''){
          $('#err_nurse_table_functional').html('This field is required.').show();
          $('#nurse_table_functional').focus();
          return false;
        } else {
          $('#err_nurse_table_functional').html('').hide();
        }

        var nurse_table_non_functional = $('#nurse_table_non_functional').val();
        if(nurse_table_non_functional == ''){
          $('#err_nurse_table_non_functional').html('This field is required.').show();
          $('#nurse_table_non_functional').focus();
          return false;
        } else {
          $('#err_nurse_table_non_functional').html('').hide();
        }

        if(parseInt(nurse_table_total_number) != parseInt(nurse_table_functional)+parseInt(nurse_table_non_functional)){
          $('#err_nurse_table_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#nurse_table_total_number').focus();
          return false;
        } else {
          $('#err_nurse_table_total_number').html('').hide();
        }

      } else {
        var nurse_table_reason = $('#nurse_table_reason').val();
        if(nurse_table_reason == ''){
          $('#err_nurse_table_reason').html('This field is required.').show();
          $('#nurse_table_reason').focus();
          return false;
        } else {
          $('#err_nurse_table_reason').html('').hide();
        }
      }
    } else {
      $('#err_nurse_table_option').html('This field is required.').show();
      $('.nurse_table_option').focus();
      return false;
    }

    if($('.highstool_option').is(':checked')){
      $('#err_highstool_option').html('').hide();
      var highstool_option = $('input[name="highstool_option"]:checked').val(); 
      if(highstool_option == 1){
        var highstool_total_number = $('#highstool_total_number').val();
        if(highstool_total_number == ''){
          $('#err_highstool_total_number').html('This field is required.').show();
          $('#highstool_total_number').focus();
          return false;
        } else {
          $('#err_highstool_total_number').html('').hide();
        }


        var highstool_functional = $('#highstool_functional').val();
        if(highstool_functional == ''){
          $('#err_highstool_functional').html('This field is required.').show();
          $('#highstool_functional').focus();
          return false;
        } else {
          $('#err_highstool_functional').html('').hide();
        }

        var highstool_non_functional = $('#highstool_non_functional').val();
        if(highstool_non_functional == ''){
          $('#err_highstool_non_functional').html('This field is required.').show();
          $('#highstool_non_functional').focus();
          return false;
        } else {
          $('#err_highstool_non_functional').html('').hide();
        }

        if(parseInt(highstool_total_number) != parseInt(highstool_functional)+parseInt(highstool_non_functional)){
          $('#err_highstool_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#highstool_total_number').focus();
          return false;
        } else {
          $('#err_highstool_total_number').html('').hide();
        }

      } else {
        var highstool_reason = $('#highstool_reason').val();
        if(highstool_reason == ''){
          $('#err_highstool_reason').html('This field is required.').show();
          $('#highstool_reason').focus();
          return false;
        } else {
          $('#err_highstool_reason').html('').hide();
        }
      }
    } else {
      $('#err_highstool_option').html('This field is required.').show();
      $('.highstool_option').focus();
      return false;
    }

    var cubord_total_number = $('#cubord_total_number').val();
    if(cubord_total_number == ''){
      $('#err_cubord_total_number').html('This field is required.').show();
      $('#cubord_total_number').focus();
      return false;
    } else {
      $('#err_cubord_total_number').html('').hide();
    }


    var cubord_functional = $('#cubord_functional').val();
    if(cubord_functional == ''){
      $('#err_cubord_functional').html('This field is required.').show();
      $('#cubord_functional').focus();
      return false;
    } else {
      $('#err_cubord_functional').html('').hide();
    }

    var cubord_non_functional = $('#cubord_non_functional').val();
    if(cubord_non_functional == ''){
      $('#err_cubord_non_functional').html('This field is required.').show();
      $('#cubord_non_functional').focus();
      return false;
    } else {
      $('#err_cubord_non_functional').html('').hide();
    }

    if(parseInt(cubord_total_number) != parseInt(cubord_functional)+parseInt(cubord_non_functional)){
      $('#err_cubord_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#cubord_total_number').focus();
      return false;
    } else {
      $('#err_cubord_total_number').html('').hide();
    }

    var ac_total_number = $('#ac_total_number').val();
    if(ac_total_number == ''){
      $('#err_ac_total_number').html('This field is required.').show();
      $('#ac_total_number').focus();
      return false;
    } else {
      $('#err_ac_total_number').html('').hide();
    }


    var ac_functional = $('#ac_functional').val();
    if(ac_functional == ''){
      $('#err_ac_functional').html('This field is required.').show();
      $('#ac_functional').focus();
      return false;
    } else {
      $('#err_ac_functional').html('').hide();
    }

    var ac_non_functional = $('#ac_non_functional').val();
    if(ac_non_functional == ''){
      $('#err_ac_non_functional').html('This field is required.').show();
      $('#ac_non_functional').focus();
      return false;
    } else {
      $('#err_ac_non_functional').html('').hide();
    }

    if(parseInt(ac_total_number) != parseInt(ac_functional)+parseInt(ac_non_functional)){
      $('#err_ac_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#ac_total_number').focus();
      return false;
    } else {
      $('#err_ac_total_number').html('').hide();
    }

    var room_heater_total_number = $('#room_heater_total_number').val();
    if(room_heater_total_number == ''){
      $('#err_room_heater_total_number').html('This field is required.').show();
      $('#room_heater_total_number').focus();
      return false;
    } else {
      $('#err_room_heater_total_number').html('').hide();
    }


    var room_heater_functional = $('#room_heater_functional').val();
    if(room_heater_functional == ''){
      $('#err_room_heater_functional').html('This field is required.').show();
      $('#room_heater_functional').focus();
      return false;
    } else {
      $('#err_room_heater_functional').html('').hide();
    }

    var room_heater_non_functional = $('#room_heater_non_functional').val();
    if(room_heater_non_functional == ''){
      $('#err_room_heater_non_functional').html('This field is required.').show();
      $('#room_heater_non_functional').focus();
      return false;
    } else {
      $('#err_room_heater_non_functional').html('').hide();
    }

    if(parseInt(room_heater_total_number) != parseInt(room_heater_functional)+parseInt(room_heater_non_functional)){
      $('#err_room_heater_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#room_heater_total_number').focus();
      return false;
    } else {
      $('#err_room_heater_total_number').html('').hide();
    }

    var weighing_scale_total_number = $('#weighing_scale_total_number').val();
    if(weighing_scale_total_number == ''){
      $('#err_weighing_scale_total_number').html('This field is required.').show();
      $('#weighing_scale_total_number').focus();
      return false;
    } else {
      $('#err_weighing_scale_total_number').html('').hide();
    }


    var weighing_scale_functional = $('#weighing_scale_functional').val();
    if(weighing_scale_functional == ''){
      $('#err_weighing_scale_functional').html('This field is required.').show();
      $('#weighing_scale_functional').focus();
      return false;
    } else {
      $('#err_weighing_scale_functional').html('').hide();
    }

    var weighing_scale_non_functional = $('#weighing_scale_non_functional').val();
    if(weighing_scale_non_functional == ''){
      $('#err_weighing_scale_non_functional').html('This field is required.').show();
      $('#weighing_scale_non_functional').focus();
      return false;
    } else {
      $('#err_weighing_scale_non_functional').html('').hide();
    }

    if(parseInt(weighing_scale_total_number) != parseInt(weighing_scale_functional)+parseInt(weighing_scale_non_functional)){
      $('#err_weighing_scale_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#weighing_scale_total_number').focus();
      return false;
    } else {
      $('#err_weighing_scale_total_number').html('').hide();
    }

    var fan_total_number = $('#fan_total_number').val();
    if(fan_total_number == ''){
      $('#err_fan_total_number').html('This field is required.').show();
      $('#fan_total_number').focus();
      return false;
    } else {
      $('#err_fan_total_number').html('').hide();
    }


    var fan_functional = $('#fan_functional').val();
    if(fan_functional == ''){
      $('#err_fan_functional').html('This field is required.').show();
      $('#fan_functional').focus();
      return false;
    } else {
      $('#err_fan_functional').html('').hide();
    }

    var fan_non_functional = $('#fan_non_functional').val();
    if(fan_non_functional == ''){
      $('#err_fan_non_functional').html('This field is required.').show();
      $('#fan_non_functional').focus();
      return false;
    } else {
      $('#err_fan_non_functional').html('').hide();
    }

    if(parseInt(fan_total_number) != parseInt(fan_functional)+parseInt(fan_non_functional)){
      $('#err_fan_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#fan_total_number').focus();
      return false;
    } else {
      $('#err_fan_total_number').html('').hide();
    }

    if($('.thermometer_option').is(':checked')){
      $('#err_thermometer_option').html('').hide();
      var thermometer_option = $('input[name="thermometer_option"]:checked').val(); 
      if(thermometer_option == 1){
        var thermometer_total_number = $('#thermometer_total_number').val();
        if(thermometer_total_number == ''){
          $('#err_thermometer_total_number').html('This field is required.').show();
          $('#thermometer_total_number').focus();
          return false;
        } else {
          $('#err_thermometer_total_number').html('').hide();
        }


        var thermometer_functional = $('#thermometer_functional').val();
        if(thermometer_functional == ''){
          $('#err_thermometer_functional').html('This field is required.').show();
          $('#thermometer_functional').focus();
          return false;
        } else {
          $('#err_thermometer_functional').html('').hide();
        }

        var thermometer_non_functional = $('#thermometer_non_functional').val();
        if(thermometer_non_functional == ''){
          $('#err_thermometer_non_functional').html('This field is required.').show();
          $('#thermometer_non_functional').focus();
          return false;
        } else {
          $('#err_thermometer_non_functional').html('').hide();
        }

        if(parseInt(thermometer_total_number) != parseInt(thermometer_functional)+parseInt(thermometer_non_functional)){
          $('#err_thermometer_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
          $('#thermometer_total_number').focus();
          return false;
        } else {
          $('#err_thermometer_total_number').html('').hide();
        }

      } else {
        var thermometer_reason = $('#thermometer_reason').val();
        if(thermometer_reason == ''){
          $('#err_thermometer_reason').html('This field is required.').show();
          $('#thermometer_reason').focus();
          return false;
        } else {
          $('#err_thermometer_reason').html('').hide();
        }
      }
    } else {
      $('#err_thermometer_option').html('This field is required.').show();
      $('.thermometer_option').focus();
      return false;
    }

    if($('.mask_supply_option').is(':checked')){
      $('#err_mask_supply_option').html('').hide();
    } else {
      $('#err_mask_supply_option').html('This field is required.').show();
      $('.mask_supply_option').focus();
      return false;
    }

    if ($(".form-checkbox:checked").length > 0){
      $('#err_power_backup_option').html('').hide();
    } else {
      $('#err_power_backup_option').html('This field is required.').show();
      $('.form-checkbox').focus();
      return false;
    }

    if($('.babykit_supply_option').is(':checked')){
      $('#err_babykit_supply_option').html('').hide();
    } else {
      $('#err_babykit_supply_option').html('This field is required.').show();
      $('.babykit_supply_option').focus();
      return false;
    }

    if($('.blanket_supply_option').is(':checked')){
      $('#err_blanket_supply_option').html('').hide();
    } else {
      $('#err_blanket_supply_option').html('This field is required.').show();
      $('.blanket_supply_option').focus();
      return false;
    }

    var digital_thermo_total_number = $('#digital_thermo_total_number').val();
    if(digital_thermo_total_number == ''){
      $('#err_digital_thermo_total_number').html('This field is required.').show();
      $('#digital_thermo_total_number').focus();
      return false;
    } else {
      $('#err_digital_thermo_total_number').html('').hide();
    }


    var digital_thermo_functional = $('#digital_thermo_functional').val();
    if(digital_thermo_functional == ''){
      $('#err_digital_thermo_functional').html('This field is required.').show();
      $('#digital_thermo_functional').focus();
      return false;
    } else {
      $('#err_digital_thermo_functional').html('').hide();
    }

    var digital_thermo_non_functional = $('#digital_thermo_non_functional').val();
    if(digital_thermo_non_functional == ''){
      $('#err_digital_thermo_non_functional').html('This field is required.').show();
      $('#digital_thermo_non_functional').focus();
      return false;
    } else {
      $('#err_digital_thermo_non_functional').html('').hide();
    }

    if(parseInt(digital_thermo_total_number) != parseInt(digital_thermo_functional)+parseInt(digital_thermo_non_functional)){
      $('#err_digital_thermo_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#digital_thermo_total_number').focus();
      return false;
    } else {
      $('#err_digital_thermo_total_number').html('').hide();
    }


    var oximeter_total_number = $('#oximeter_total_number').val();
    if(oximeter_total_number == ''){
      $('#err_oximeter_total_number').html('This field is required.').show();
      $('#oximeter_total_number').focus();
      return false;
    } else {
      $('#err_oximeter_total_number').html('').hide();
    }


    var oximeter_functional = $('#oximeter_functional').val();
    if(oximeter_functional == ''){
      $('#err_oximeter_functional').html('This field is required.').show();
      $('#oximeter_functional').focus();
      return false;
    } else {
      $('#err_oximeter_functional').html('').hide();
    }

    var oximeter_non_functional = $('#oximeter_non_functional').val();
    if(oximeter_non_functional == ''){
      $('#err_oximeter_non_functional').html('This field is required.').show();
      $('#oximeter_non_functional').focus();
      return false;
    } else {
      $('#err_oximeter_non_functional').html('').hide();
    }

    if(parseInt(oximeter_total_number) != parseInt(oximeter_functional)+parseInt(oximeter_non_functional)){
      $('#err_oximeter_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#oximeter_total_number').focus();
      return false;
    } else {
      $('#err_oximeter_total_number').html('').hide();
    }

    var bp_total_number = $('#bp_total_number').val();
    if(bp_total_number == ''){
      $('#err_bp_total_number').html('This field is required.').show();
      $('#bp_total_number').focus();
      return false;
    } else {
      $('#err_bp_total_number').html('').hide();
    }


    var bp_functional = $('#bp_functional').val();
    if(bp_functional == ''){
      $('#err_bp_functional').html('This field is required.').show();
      $('#bp_functional').focus();
      return false;
    } else {
      $('#err_bp_functional').html('').hide();
    }

    var bp_non_functional = $('#bp_non_functional').val();
    if(bp_non_functional == ''){
      $('#err_bp_non_functional').html('This field is required.').show();
      $('#bp_non_functional').focus();
      return false;
    } else {
      $('#err_bp_non_functional').html('').hide();
    }

    if(parseInt(bp_total_number) != parseInt(bp_functional)+parseInt(bp_non_functional)){
      $('#err_bp_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#bp_total_number').focus();
      return false;
    } else {
      $('#err_bp_total_number').html('').hide();
    }


    var tv_total_number = $('#tv_total_number').val();
    if(tv_total_number == ''){
      $('#err_tv_total_number').html('This field is required.').show();
      $('#tv_total_number').focus();
      return false;
    } else {
      $('#err_tv_total_number').html('').hide();
    }


    var tv_functional = $('#tv_functional').val();
    if(tv_functional == ''){
      $('#err_tv_functional').html('This field is required.').show();
      $('#tv_functional').focus();
      return false;
    } else {
      $('#err_tv_functional').html('').hide();
    }

    var tv_non_functional = $('#tv_non_functional').val();
    if(tv_non_functional == ''){
      $('#err_tv_non_functional').html('This field is required.').show();
      $('#tv_non_functional').focus();
      return false;
    } else {
      $('#err_tv_non_functional').html('').hide();
    }

    if(parseInt(tv_total_number) != parseInt(tv_functional)+parseInt(tv_non_functional)){
      $('#err_tv_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#tv_total_number').focus();
      return false;
    } else {
      $('#err_tv_total_number').html('').hide();
    }
    
    var clock_total_number = $('#clock_total_number').val();
    if(clock_total_number == ''){
      $('#err_clock_total_number').html('This field is required.').show();
      $('#clock_total_number').focus();
      return false;
    } else {
      $('#err_clock_total_number').html('').hide();
    }


    var clock_functional = $('#clock_functional').val();
    if(clock_functional == ''){
      $('#err_clock_functional').html('This field is required.').show();
      $('#clock_functional').focus();
      return false;
    } else {
      $('#err_clock_functional').html('').hide();
    }

    var clock_non_functional = $('#clock_non_functional').val();
    if(clock_non_functional == ''){
      $('#err_clock_non_functional').html('This field is required.').show();
      $('#clock_non_functional').focus();
      return false;
    } else {
      $('#err_clock_non_functional').html('').hide();
    }

    if(parseInt(clock_total_number) != parseInt(clock_functional)+parseInt(clock_non_functional)){
      $('#err_clock_total_number').html('Total numbers must be equal to sum of functional & non functional.').show();
      $('#clock_total_number').focus();
      return false;
    } else {
      $('#err_clock_total_number').html('').hide();
    }

    if($('.kmc_register').is(':checked')){
      $('#err_kmc_register').html('').hide();
    } else {
      $('#err_kmc_register').html('This field is required.').show();
      $('.kmc_register').focus();
      return false;
    }
    
  }

</script>



  