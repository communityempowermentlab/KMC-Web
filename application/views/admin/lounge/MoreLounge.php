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
</style>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Amenities For <?php echo $GetLounge['loungeName'];?> <?php echo 'Lounge';  ?>
      </h1>
      <small><b>Contact Number:&nbsp;<?php echo $GetLounge['loungeContactNumber'];?></b></small>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <form class="form-horizontal" action="<?php echo site_url();?>loungeM/UpdateMoreLoungePost/<?php echo $GetLounge['loungeId'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

              <?php  $FacilityID = $GetLounge['facilityId'];
              $FacilitiesName = $this->UserModel->GetFacilitiesById($FacilityID);
               ?>
               <div class="col-md-12"><b style="font-size:18px;">Amenities Details:</b></div>
               <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Number Of Beds</label>
                     <div class="col-sm-2">
                        <input type="number" class="form-control" name="NumberOfBed" value="<?php echo $GetLounge['numberOfBed']; ?>">
                     </div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Number Of Chairs </label>
                     <div class="col-sm-2">
                       <input type="number" class="form-control" name="NumberOfChair" value="<?php echo $GetLounge['numberOfChair']; ?>">
                     </div>

                  <label for="inputEmail3" class="col-sm-2 control-label">Number Of Tables</label>
                     <div class="col-sm-2">
                       <input type="number" class="form-control" name="NumberOfTable" value="<?php echo $GetLounge['numberOfTable']; ?>">
                     </div>
                </div>
           
               <div class="form-group">
                   <label for="inputEmail3" class="col-sm-3 control-label">AC Availability</label>
                     <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                         <?php  $ACAvailability=$GetLounge['acAvailability']; 
                            if($ACAvailability=='yes'){?>
                              <input type="checkbox" name="ACAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="ACAvailability" value="yes">
                           <?php } ?>
                              <span class="slider round"></span>
                       </label>
                     </div>
                  <label for="inputEmail3" class="col-sm-3 control-label">Room Heater Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $RoomHeaterAvailability=$GetLounge['roomHeaterAvailability']; 
                            if($RoomHeaterAvailability=='yes'){?>
                              <input type="checkbox" name="RoomHeaterAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="RoomHeaterAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>

                  <label for="inputEmail3" class="col-sm-3 control-label">Digital Weighing Scale Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $DigitalWeighingScaleAvailability=$GetLounge['isDigitalWeighingScaleAvail']; 
                            if($DigitalWeighingScaleAvailability=='yes'){?>
                              <input type="checkbox" name="DigitalWeighingScaleAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="DigitalWeighingScaleAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
              </div>
              <div class="form-group">
                   <label for="inputEmail3" class="col-sm-3 control-label">Room Thermometer Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $RoomThermometerAvailability=$GetLounge['roomThermometerAvailability']; 
                            if($RoomThermometerAvailability=='yes'){?>
                              <input type="checkbox" name="RoomThermometerAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="RoomThermometerAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
                  <label for="inputEmail3" class="col-sm-3 control-label">Wall Clock Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $WallClockAvailability=$GetLounge['wallClockAvailability']; 
                            if($WallClockAvailability=='yes'){?>
                              <input type="checkbox" name="WallClockAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="WallClockAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>

                  <label for="inputEmail3" class="col-sm-3 control-label">TV Availability</label>
                     <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                            <?php  $TVAvailability=$GetLounge['tvAvailability']; 
                               if($TVAvailability=='yes'){?>
                                <input type="checkbox" name="TVAvailability" value="yes" checked>
                              <?php }else{?>
                               <input type="checkbox" name="TVAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
              </div>

              <div class="form-group">
                   <label for="inputEmail3" class="col-sm-3 control-label">Music System Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $MusicSystemAvailability=$GetLounge['musicSystemAvailability']; 
                            if($MusicSystemAvailability=='yes'){?>
                               <input type="checkbox" name="MusicSystemAvailability" value="yes" checked>
                            <?php }else{?>
                               <input type="checkbox" name="MusicSystemAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
                  <label for="inputEmail3" class="col-sm-3 control-label">Almirah Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $AlmirahAvailability=$GetLounge['almirahAvailability']; 
                            if($AlmirahAvailability=='yes'){?>
                              <input type="checkbox" name="AlmirahAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="AlmirahAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>

                  <label for="inputEmail3" class="col-sm-3 control-label">Charging Screen Availability</label>
                     <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $ChargingScreenAvailability=$GetLounge['chargingPointAvailability']; 
                            if($ChargingScreenAvailability=='yes'){?>
                              <input type="checkbox" name="ChargingScreenAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="ChargingScreenAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
              </div>

               <div class="form-group">
                   <label for="inputEmail3" class="col-sm-3 control-label">Nursing Station Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $NursingStationAvailability=$GetLounge['nursingStationAvailability']; 
                            if($NursingStationAvailability=='yes'){?>
                              <input type="checkbox" name="NursingStationAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="NursingStationAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
                  <label for="inputEmail3" class="col-sm-3 control-label">Lockers Availabilty</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $LockersAvailabilty=$GetLounge['lockersAvailabilty']; 
                            if($LockersAvailabilty=='yes'){?>
                              <input type="checkbox" name="LockersAvailabilty" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="LockersAvailabilty" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>

                  <label for="inputEmail3" class="col-sm-3 control-label">Tablet And Lounge AppAvailability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch" style="margin-left:12px;">
                        <?php  $TabletAndLoungeAppAvailability=$GetLounge['tabletLoungeAppAvailability']; 
                            if($TabletAndLoungeAppAvailability=='yes'){?>
                              <input type="checkbox" name="TabletAndLoungeAppAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="TabletAndLoungeAppAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
              </div>

              <div class="form-group">
                   <label for="inputEmail3" class="col-sm-3 control-label">Power Backup Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $PowerBackupAvailability=$GetLounge['powerBackupAvailability']; 
                            if($PowerBackupAvailability=='yes'){?>
                              <input type="checkbox" name="PowerBackupAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="PowerBackupAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
                    <label for="inputEmail3" class="col-sm-3 control-label">Thermometer Availability</label>
                      <div class="col-sm-1" style="margin-top:10px;">
                       <label class="switch"style="margin-left:12px;">
                        <?php  $ThermometerAvailability=$GetLounge['thermometerAvailability']; 
                            if($ThermometerAvailability=='yes'){?>
                              <input type="checkbox" name="ThermometerAvailability" value="yes" checked>
                            <?php }else{?>
                              <input type="checkbox" name="ThermometerAvailability" value="yes">
                           <?php } ?>
                         <span class="slider round"></span>
                       </label>
                     </div>
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

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga);
  })();

</script>



  