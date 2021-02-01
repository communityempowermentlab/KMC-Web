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
   <script type="text/javascript">
    window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
    }
    </script>
    <section class="content-header">
      <h1>Manage Settings 
        <a href="<?php echo base_url('admin/loginImage/');?>" class="btn btn-info" style="float: right; padding-right: 10px;  "> Manage Login Image </a> 
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">  
               <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
             <!--         //     SMS  setting section        -->
         <div class="box box-info"> 
          <form class="form-horizontal" action="<?php echo site_url('Admin/updateSmsSettingData/');?>" method="POST">
           <div class="box-body">
              <div class="col-md-12"><h4>SMS API Settings</h4></div>
              <div class="form-group" >
                     <label for="inputPassword3" class="col-sm-2 control-label">Route</label>
                     <div class="col-sm-4">
                      <input type="text" required="" class="form-control" name="route" value="<?php echo $Settings['route']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Sender ID
                     </label>
                     <div class="col-sm-4">
                      <input type="text" required="" class="form-control" name="senderID" value="<?php echo  $Settings['senderId']; ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Username
                     </label>
                     <div class="col-sm-4">
                      <input type="text" class="form-control" name="username" value="<?php echo  $Settings['userName']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Password
                     </label>
                     <div class="col-sm-4">
                      <input type="text" required="" class="form-control" name="password" value="<?php echo $Settings['password']; ?>" >
                     </div>
                </div>

              <div class="col-md-12"><h4>SMS Format</h4></div>
              <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Admission Time Message<br>
                         <label class="switch"style="margin-left:12px;margin-top:12px;"><br>
                          <?php if($Settings['smsPermissionFirst'] == '1'){ ?>
                           <input type="checkbox" name="smsPermissionFirst" value="1" checked>
                         <?php } else { ?>
                           <input type="checkbox" name="smsPermissionFirst" value="1">
                         <?php } ?>
                           <span class="slider round"></span>
                       </label>
                     </label>
                     <div class="col-sm-4">
                      <textarea name="smsFormatSecond" class="form-control" rows="4"><?php echo $Settings['smsFormatSecond']; ?></textarea> 
                      Note :<span style="color:red"> Square bracket and that inside value no update!!</span>
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Monitoring Time Message<br>
                        <label class="switch"style="margin-left:12px;margin-top:12px;"><br>
                          <?php if($Settings['smsPermissionSecond'] == '1'){ ?>
                           <input type="checkbox" name="smsPermissionSecond" value="1" checked>
                         <?php } else { ?>
                           <input type="checkbox" name="smsPermissionSecond" value="1">
                         <?php } ?>
                           <span class="slider round"></span>
                       </label>
                     </label>
                     <div class="col-sm-4">
                      <textarea name="smsFormatFirst" class="form-control" rows="4"><?php echo $Settings['smsFormatFirst']; ?></textarea>
                      Note :<span style="color:red"> Square bracket and that inside value no update!!</span> 
                     </div>
              </div>
           </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
             </form> 
        </div>  

            



          
 <div class="box box-info">
   <form class="form-horizontal" action="<?php echo site_url('Admin/updateSettingData/');?>" method="POST">
              <div class="box-body">
                <div class="col-md-12"><h4>Mother Monitoring Notification Time: (24 Hrs Format)</h4></div>
                <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">First Time</label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="MotherMointoringOneTime" value="<?php echo $Settings['motherMonitoringFirstTime']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Second Time
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="MotherMointoringSecondTime" value="<?php echo  $Settings['motherMonitoringSecondTime']; ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Third Time
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="MotherMointoringThirdTime" value="<?php echo  $Settings['motherMonitoringThirdTime']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Fourth Time
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="MotherMointoringFourthTime" value="<?php echo $Settings['motherMonitoringFourthTime']; ?>" >
                     </div>
                </div>



                 <div class="col-md-12"><h4>Baby Monitoring Notification Time: (24 Hrs Format)</h4></div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label"> First Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="BabyMointoringOneTime" value="<?php echo  $Settings['babyMonitoringFirstTime']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Second Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="BabyMointoringSecondTime" value="<?php echo  $Settings['babyMonitoringSecondTime']; ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Third Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="BabyMointoringThirdTime" value="<?php echo $Settings['babyMonitoringThirdTime']; ?>">
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Fourth Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="BabyMointoringFourthTime" value="<?php echo $Settings['babyMonitoringFourthTime'];  ?>">
                     </div>
                </div>

                 <div class="col-md-12"><h4>Room Temperature Notification Time: (24 Hrs Format)</h4></div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label"> First Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="RoomTempOneTime" value="<?php echo  $Settings['roomTempFirstTime']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Second Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="RoomTempTwoTime" value="<?php echo  $Settings['roomTempSecondTime']; ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Third Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="RoomTempThreeTime" value="<?php echo $Settings['roomTempThirdTime']; ?>">
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Fourth Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="RoomTempFourTime" value="<?php echo $Settings['roomTempFourthTime'];  ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Fifth Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="RoomTempFiveTime" value="<?php echo $Settings['roomTempFifthTime']; ?>">
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Six Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="RoomTempSixTime" value="<?php echo $Settings['roomTempSixthTime'];  ?>">
                     </div>
                </div>


                 <div class="col-md-12"><h4>Food Notification Time: (24 Hrs Format)</h4></div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label"> Breakfast Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="BreakfastTime" value="<?php echo  $Settings['breakfastTime']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Lunch Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="LunchTime" value="<?php echo  $Settings['lunchTime']; ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Dinner Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="DinnerTime" value="<?php echo $Settings['dinnerTime']; ?>">
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label"></label>
                     <div class="col-sm-4"></div>
                </div>


                 <div class="col-md-12"><h4>Lounge Cleaning Notification Time: (24 Hrs Format)</h4></div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label"> First Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="LoungeCleaningOneTime" value="<?php echo  $Settings['loungeCleaningFirstTime']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Second Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="LoungeCleaningTwoTime" value="<?php echo  $Settings['loungeCleaningSecondTime']; ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Third Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="LoungeCleaningThreeTime" value="<?php echo $Settings['loungeCleaningThirdTime']; ?>">
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label"></label>
                     <div class="col-sm-4"></div>
                </div>

                 <div class="col-md-12"><h4>Duty Change Notification Time: (24 Hrs Format)</h4></div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label"> First Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="DutyShiftOneTime" value="<?php echo  $Settings['morningDutyChange']; ?>" >
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label">Second Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="DutyShiftTwoTime" value="<?php echo  $Settings['dayDutyChange']; ?>">
                     </div>
                </div>
                 <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Third Time 
                     </label>
                     <div class="col-sm-4">
                      <input type="text" readonly required="" maxlength="4" class="form-control" name="DutyShiftThreeTime" value="<?php echo $Settings['nightDutyChange']; ?>">
                     </div>
                     <label for="inputPassword3" class="col-sm-2 control-label"></label>
                     <div class="col-sm-4"></div>
                </div>



                <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Quick Email Receive
                     <span style="color:red"> *</span>
                     </label>
                     <div class="col-sm-10  ">
                      <input type="text" required="" class="form-control"  name="QuickEmail" value="<?php echo  $Settings['quickEmail']; ?>">
                     </div>
                </div>
     
                 
            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Submit</button>
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

 

  