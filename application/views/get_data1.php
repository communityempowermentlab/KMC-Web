<?php
if(isset($_REQUEST['FeedbackId']))
{
$id=$_REQUEST['FeedbackId'];
$FacilitiesTypeData = $this->load->FacilityModel->GetFacilitiesTypeById('facilitytype',$id); 
?>
                 <form class="form-horizontal" name='Lounge' action="<?php echo site_url('facility/UpdateFacilitiesTypePost'); ?>/<?php echo $id; ?>" method="post">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label" >Facility Type Name<span style="color:red"> *</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" required name="FacilityTypeName"  value="<?php echo $FacilitiesTypeData['FacilityTypeName']; ?>" placeholder="Facility Name" required> 
                          <span style="color: red;"><?php echo form_error('facility_name');?></span>                 
                      </div>
                    </div>

                <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label" > Priority<span style="color:red">  *</span> </label>
                  <div class="col-sm-8">
                      
                             <select class="form-control" name="priority">
                              
                              <option value="1" <?php if( $FacilitiesTypeData['Priority'] == '1') { echo "selected"; } ?>>1</option>
                              <option value="2" <?php if( $FacilitiesTypeData['Priority'] == '2') { echo "selected"; } ?>>2</option>
                              <option value="3" <?php if( $FacilitiesTypeData['Priority'] == '3') { echo "selected"; } ?>>3</option>
                              <option value="4" <?php if( $FacilitiesTypeData['Priority'] == '4') { echo "selected"; } ?>>4</option>
                              <option value="5" <?php if( $FacilitiesTypeData['Priority'] == '5') { echo "selected"; } ?>>5</option> 
                            </select> 
                      
                      <span style="color: red;"><?php echo form_error('Priority');?></span>                 
                  </div>
                </div>
              <div class="box-footer">               
                <input type="submit" class="btn btn-info pull-right" value="update">
              </div>
            </form>
<?php } ?>
<?php
if(isset($_REQUEST['Suppliment']))
{
 $id=$_REQUEST['Suppliment'];
$sublimentData = $this->load->FacilityModel->GetSupplimentById($id); 
 ?>
                <form class="form-horizontal" action="<?php echo base_url() ?>supplimentM/AddUpdateSuppliment/<?php echo $sublimentData['ID']; ?>" method="post" >
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Supplement Name: <?php echo REQUIRED;?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php echo $sublimentData['Name']; ?>" name="suppliment_name" placeholder="Suppliment Name" required>
                            <input type="hidden" name="SupplimentID" value="<?php echo $sublimentData['ID']; ?>">
                            <div class="text-red"><span id="Suppliment_name_err"></span></div>
                        </div>
                    </div>

                <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Number Of Days: <?php echo REQUIRED;?></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" value="<?php echo $sublimentData['Duration']; ?>" name="number_days" placeholder="Number Of Days" required>
                            <input type="hidden" name="FacilityTypeID">
                            <div class="text-red"><span id="number_days_err"></span></div>
                        </div>
                    </div>
              <div class="box-footer">               
                <input type="submit" class="btn btn-info pull-right" value="update">
              </div>
            </form>
<?php } ?>
<?php
if(isset($_REQUEST['video_typeID']))
{
  $id=$_REQUEST['video_typeID'];
  $videoData = $this->load->FacilityModel->GetVideoTypeById($id); 
 ?>
                <form class="form-horizontal" action="<?php echo base_url() ?>videoM/UpdateVideoTypeData/<?php echo $id; ?>" method="post" >
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Video Type Name: <?php echo REQUIRED;?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="video_name" value="<?php echo $videoData['VideoTypeName']; ?>" placeholder="Enter Video  Name" required>
                            <div class="text-red"><span id="video_name_err"></span></div>
                        </div>
                    </div>

              <div class="box-footer">               
                <input type="submit" class="btn btn-info pull-right" value="update">
              </div>
            </form>
<?php } ?>
<?php
if(isset($_REQUEST['Staff_typeID']))
{
  $id=$_REQUEST['Staff_typeID'];
  $StaffData = $this->load->FacilityModel->GetStaffTypeById($id); 
 ?>
                  <?php if($StaffData['ParentID']=='0'){?>
                <form class="form-horizontal" action="<?php echo base_url() ?>staffM/UpdateStaffTypeData/<?php echo $id; ?>" method="post" >
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Staff Type Name: <?php echo REQUIRED;?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="StaffTypeNameEnglish" value="<?php echo $StaffData['StaffTypeNameEnglish']; ?>" placeholder="Enter Video  Name" required>
            
                        </div>
                    </div>
                     <div class="box-footer">               
                <input type="submit" class="btn btn-info pull-right" value="update">
              </div>
              </form>
            <?php } else{?>
            <form class="form-horizontal" action="<?php echo base_url() ?>staffM/UpdateStaffTypeData2/<?php echo $id; ?>" method="post" >
                        <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Parent Staff Type Name: </label>
                        <div class="col-sm-8">
                        <select class="form-control" name="type" required>
                         <option value="">--Select Staff Type--</option>
                           <?php $GetStaffType=$this->load->FacilityModel->GetStaffType1();
                           foreach ($GetStaffType as $key => $value) { ?>
                           <option value="<?php echo $value['StaffTypeID'];?>"<?php echo ($value['StaffTypeID']== $StaffData['ParentID']?'selected':'')?>><?php echo $value['StaffTypeNameEnglish'];?></option> 
                         
                        <?php } ?>
                      </select>
                        </div>
                    </div>
                       <div class="form-group">
                          <label class="control-label col-sm-4" for="email">Staff Type Name: <?php echo REQUIRED;?></label>
                             <div class="col-sm-8">
                               <input type="text" class="form-control" name="StaffTypeNameEnglish" value="<?php echo $StaffData['StaffTypeNameEnglish']; ?>" placeholder="Enter Video  Name" required>
                             </div>
                       </div>
                   <div class="box-footer">               
                   <input type="submit" class="btn btn-info pull-right" value="update">
                  </div>
            </form>
                    <?php }?>      
             
<?php } ?>


<?php
 if(isset($_REQUEST['loungeWiseValue'])){

      $counting            = $this->load->user_model->getCount();
      $getLoungeName       = $this->db->get_where('lounge_master',array('LoungeID'=>$_REQUEST['loungeWiseValue']))->row_array();
      $LoungeWiseMothers   = $this->load->DashboardDataModel->getAllMothersViaLounge($_REQUEST['loungeWiseValue']);    
      $LoungeWiseBabys     = $this->load->DashboardDataModel->getAllBabysViaLounge($_REQUEST['loungeWiseValue']);
      $getFacilityId       = $this->load->FacilityModel->GetLoungeById($_REQUEST['loungeWiseValue']);
      $LatestBaby       = $this->load->FacilityModel->getLatestBabyViaLoungeID($_REQUEST['loungeWiseValue']);  
      $LatestMother        = $this->load->FacilityModel->getLatestMotherViaLoungeID($_REQUEST['loungeWiseValue']);
      $getFacilityData     = $this->load->FacilityModel->FindMobileForResend($getFacilityId['FacilityID']);     
      $totalLounges1        = $this->load->DashboardDataModel->getAllLonges();  

      $TotalMilk = $this->load->FacilityModel->overAllMilkQuantity($_REQUEST['loungeWiseValue']);
      $TotalKMC = $this->load->FacilityModel->overAllKMC($_REQUEST['loungeWiseValue']);    
      $TotalAdmittedChild = $this->load->FacilityModel->getTotalAdmittedChild($_REQUEST['loungeWiseValue']);
      // for SSC timing graph like 0-4,4-8,.... hrs as well as
      $getSSCTime = $this->load->FacilityModel->getCurrentBabyInHour($_REQUEST['loungeWiseValue']);

              $skinStatus1=0;
              $skinStatus2=0;
              $skinStatus3=0;
              $skinStatus4=0;
              $skinStatus5=0;
              $skinStatus6=0;
              $totalsscHrs=0;
              $receivedSccBabyCounting = 0;
              foreach ($getSSCTime as $key => $value) {
                $skinTimePerBaby = floor(($value['totalseconds']/60)/60);
                if($skinTimePerBaby > 0 && $skinTimePerBaby < 4){
                  $skinStatus1++;
                }if($skinTimePerBaby >= 4 && $skinTimePerBaby < 8){
                  $skinStatus2++;
                }if($skinTimePerBaby >= 8 && $skinTimePerBaby < 12){
                  $skinStatus3++;
                }if($skinTimePerBaby >= 12 && $skinTimePerBaby < 16){
                  $skinStatus4++;
                }if($skinTimePerBaby >= 16 && $skinTimePerBaby < 20){
                  $skinStatus5++;
                }if($skinTimePerBaby >= 20 && $skinTimePerBaby < 24){
                  $skinStatus6++;
                }
                  $totalsscHrs += $skinTimePerBaby;
                  $receivedSccBabyCounting++;
              }

 

      // bottom graph code
                           $latestMonth=date('M Y');
                       for ($i = 1; $i < 6; $i++) {
                           $month=date(" M Y", strtotime("-$i month"));
                        $array[]=$month;
                        }
                           $FirstDayTimeStamp = strtotime(date('Y-m-01 00:00:00'));  
                           $LastDayTimeStamp = strtotime(date('Y-m-t 23:59:59'));  
                           $GetLM=$this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDayTimeStamp,$LastDayTimeStamp,$_REQUEST['loungeWiseValue']);
                           $GetLB=$this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDayTimeStamp,$LastDayTimeStamp,$_REQUEST['loungeWiseValue']);
                           $first_day_this_month = date('Y-m-01 00:00:00');

                               $date = new DateTime(date('Y-m-01 00:00:00'));
                                  $date->modify('-1 month');
                               $FirstDay_1 = strtotime($date->format('Y-m-d H:i:s'));
                                  $date->modify('-1 month');
                               $FirstDay_2 = strtotime($date->format('Y-m-d H:i:s'));
                                  $date->modify('-1 month');
                               $FirstDay_3 = strtotime($date->format('Y-m-d H:i:s'));
                                  $date->modify('-1 month');
                               $FirstDay_4 = strtotime($date->format('Y-m-d H:i:s'));
                                  $date->modify('-1 month');
                               $FirstDay_5 = strtotime($date->format('Y-m-d H:i:s'));

                               $date = new DateTime(date('Y-m-t 23:59:59'));
                                 $monthNumber =date('m', strtotime($array[0]));
                                 if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                                    $date->modify('-31 day');
                                }
                               else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                                    $date->modify('-30 day');
                                  }else{
                                    $date->modify('-28 day');
                                }
                               
                               $LastDay_1= strtotime($date->format('Y-m-d H:i:s'));
                                $monthNumber =date('m', strtotime($array[1]));
                               if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                                    $date->modify('-31 day');
                                }
                               else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                                    $date->modify('-30 day');
                                  }else{
                                    $date->modify('-28 day');
                                }
                              
                               $LastDay_2= strtotime($date->format('Y-m-d H:i:s'));
                                  $monthNumber =date('m', strtotime($array[2]));
                                 if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                                    $date->modify('-31 day');
                                }
                               else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                                    $date->modify('-30 day');
                                  }else{
                                    $date->modify('-28 day');
                                }
                               $LastDay_3= strtotime($date->format('Y-m-d H:i:s'));
                                  $monthNumber =date('m', strtotime($array[3]));
                                 if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                                    $date->modify('-31 day');
                                }
                               else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                                    $date->modify('-30 day');
                                  }else{
                                    $date->modify('-28 day');
                                }
                  
                               $LastDay_4= strtotime($date->format('Y-m-d H:i:s'));
                                  $monthNumber =date('m', strtotime($array[4]));
                              if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                                    $date->modify('-31 day');
                                }
                               else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                                    $date->modify('-30 day');
                                  }else{
                                    $date->modify('-28 day');
                                }
                               $LastDay_5= strtotime($date->format('Y-m-d H:i:s'));
                            
                          $GetLM1 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_1,$LastDay_1,$_REQUEST['loungeWiseValue']);
                          $GetLB1 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_1,$LastDay_1,$_REQUEST['loungeWiseValue']);

                          $GetLM2 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_2,$LastDay_2,$_REQUEST['loungeWiseValue']);
                          $GetLB2 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_2,$LastDay_2,$_REQUEST['loungeWiseValue']);

                          $GetLM3 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_3,$LastDay_3,$_REQUEST['loungeWiseValue']);
                          $GetLB3 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_3,$LastDay_3,$_REQUEST['loungeWiseValue']);

                          $GetLM4 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_4,$LastDay_4,$_REQUEST['loungeWiseValue']);
                          $GetLB4 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_4,$LastDay_4,$_REQUEST['loungeWiseValue']);

                          $GetLM5 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_5,$LastDay_5,$_REQUEST['loungeWiseValue']);
                          $GetLB5 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_5,$LastDay_5,$_REQUEST['loungeWiseValue']);
              

                  // for kmc timing graph

                          $lastesMonthKmc  = $this->load->DashboardDataModel->GetCurrentMonthKMC($FirstDayTimeStamp,$LastDayTimeStamp,$_REQUEST['loungeWiseValue']);
                          $lastesMonthKmc1 = $this->load->DashboardDataModel->GetCurrentMonthKMC($FirstDay_1,$LastDay_1,$_REQUEST['loungeWiseValue']);
                          $lastesMonthKmc2 = $this->load->DashboardDataModel->GetCurrentMonthKMC($FirstDay_2,$LastDay_2,$_REQUEST['loungeWiseValue']);
                          $lastesMonthKmc3 = $this->load->DashboardDataModel->GetCurrentMonthKMC($FirstDay_3,$LastDay_3,$_REQUEST['loungeWiseValue']);
                          $lastesMonthKmc4 = $this->load->DashboardDataModel->GetCurrentMonthKMC($FirstDay_4,$LastDay_4,$_REQUEST['loungeWiseValue']);
                          $lastesMonthKmc5 = $this->load->DashboardDataModel->GetCurrentMonthKMC($FirstDay_5,$LastDay_5,$_REQUEST['loungeWiseValue']);

                          $lastesMonthKmc  = floor(($lastesMonthKmc['totalseconds']/60)/60);
                          $lastesMonthKmc1 = floor(($lastesMonthKmc1['totalseconds']/60)/60);
                          $lastesMonthKmc2 = floor(($lastesMonthKmc2['totalseconds']/60)/60);
                          $lastesMonthKmc3 = floor(($lastesMonthKmc3['totalseconds']/60)/60);
                          $lastesMonthKmc4 = floor(($lastesMonthKmc4['totalseconds']/60)/60);
                          $lastesMonthKmc5 = floor(($lastesMonthKmc5['totalseconds']/60)/60);
     
                  // for baby feeding status bar chart

                          $lastesMonthMilk  = $this->load->FacilityModel->GetCurrentMonthMilk($FirstDayTimeStamp,$LastDayTimeStamp,$_REQUEST['loungeWiseValue']);
                     
                          $lastesMonthMilk1 = $this->load->FacilityModel->GetCurrentMonthMilk($FirstDay_1,$LastDay_1,$_REQUEST['loungeWiseValue']);
                          $lastesMonthMilk2 = $this->load->FacilityModel->GetCurrentMonthMilk($FirstDay_2,$LastDay_2,$_REQUEST['loungeWiseValue']);
                          $lastesMonthMilk3 = $this->load->FacilityModel->GetCurrentMonthMilk($FirstDay_3,$LastDay_3,$_REQUEST['loungeWiseValue']);
                          $lastesMonthMilk4 = $this->load->FacilityModel->GetCurrentMonthMilk($FirstDay_4,$LastDay_4,$_REQUEST['loungeWiseValue']);
                          $lastesMonthMilk5 = $this->load->FacilityModel->GetCurrentMonthMilk($FirstDay_5,$LastDay_5,$_REQUEST['loungeWiseValue']);
           
                 // for Breast Feeding graph in current date
                          $StartCurrentdateTime     = date("Y-m-d H:i:s", strtotime('-24 hours', time()));; 
                          $EndCurrentdateTime       = date("Y-m-d H:i:s"); 
                          $DateStart                = strtotime($StartCurrentdateTime);
                          $DateEnd                  = strtotime($EndCurrentdateTime);

                          $getExclusiveCurrentDateFeeding = $this->load->FacilityModel->getExCurrentDateFeeding($DateStart,$DateEnd,$_REQUEST['loungeWiseValue']);
                          $getExistFeeding = $this->load->FacilityModel->getExexistingFeeding($DateStart,$DateEnd,$_REQUEST['loungeWiseValue']);
                          $getNonExclusiveCurrentDateFeeding = $this->load->FacilityModel->getNonExCurrentDateFeeding($DateStart,$DateEnd,$_REQUEST['loungeWiseValue']);
                 // for KMC Given or not       
                          $getKMCGiven = $this->load->FacilityModel->getGivenKMC($DateStart,$DateEnd,$_REQUEST['loungeWiseValue']);         

 
  ?>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-handshake-o"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Facilities &<br> Total Lounges</span>
                    <span class="info-box-number"><a href="<?php echo base_url('facility/manageFacility'); ?>"><?php echo $counting['facility']; ?>/<?php echo $counting['lounge']; ?></a></span>
                  </div>
                 </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Staff</span>
                    <span class="info-box-number"><a href="<?php echo base_url('staffM/manageStaff'); ?>"><?php echo $counting['staff']; ?></a></span>
                  </div>
                 </div>
              </div>


              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-female"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Mothers <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></span>
                    <span class="info-box-number"><a href="<?php echo base_url('motherM/registeredMother'); ?>"><?php echo $LoungeWiseMothers; ?></a></span>
                  </div>
                 </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-child"></i></span>
                    <div class="info-box-content">
                     <span class="info">Total Babies <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></span>
                    <span class="info-box-number"><a href="<?php echo base_url('babyM/registeredBaby'); ?>"><?php echo $LoungeWiseBabys; ?></a></span>
                  </div>
                 </div>
              </div>

      <section class="col-lg-6 connectedSortable">       
           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal"><span class="fa fa-info-circle"></span></a> Registered Mothers And Babies <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Mothers (<?php echo $LoungeWiseMothers; ?>).</span></li> 
                    </ul>
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-blue" href="#" style="font-size:15px;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Babies (<?php echo $LoungeWiseBabys; ?>).</span></li> 
                    </ul>
                 </div>
                 </div>
           </div>

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal2"><span class="fa fa-info-circle"></span></a> Baby Feeding Status <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart2" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#A3CC23  "><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Total MiLk (<?php echo floor($TotalMilk['quantityOFMilk']); ?> ml)</span></li> 
                    </ul>
                 </div>
                 </div>
           </div>

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal4"><span class="fa fa-info-circle"></span></a> Baby Breast Feeding In (24 hrs) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                     <div id="container" style="width:100%;height:300px;"></div>
                 </div>
           </div>

          <div class="box box-info">
            <form action="<?php echo base_url('Facility/SendMail')?>" method="POST" enctype ="multipart/form-data">
                   <div class="box-header">
                      <i class="fa fa-envelope"></i>
                       <h3 class="box-title">Quick Email </h3>
                        <div class="pull-right box-tools">
                             <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                              title="Remove">
                              <i class="fa fa-times"></i></button>
                              </div>
                              </div>
                              <div class="box-body">
                              <div class="form-group">
                              <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                              </div>
                            <div>
                            <textarea class="textarea"  name ="Message" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                          </div>
                         </div>
                        <div class="box-footer clearfix">
                       <input type="submit" class="pull-right btn btn-default" value="Send">
                     </div>
                </form>
          </div>


            <style type="text/css">
              .iconSet{
                position: relative;
                top: 8%;
                left: 36px;
                width: 25px;
                height: 25px;
              }
            </style>
        <?php if(count($LatestBaby) > 0) { ?>
          <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Registered Babys <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                     <?php //print_r($LatestMother);
                    foreach ($LatestBaby as $key => $val) { 
                            $this->db->order_by('id','desc'); 
                             $getAdmissionId = $this->db->get_where('baby_admission',array('BabyID'=>$val['BabyID']))->row_array(); 
                             $motherData = $this->db->get_where('mother_registration',array('MotherID'=>$val['MotherID']))->row_array(); 
                          // echo  $motherData['MotherName'];//print_r($motherData);
                            ?>
                            <li style="min-height: 195px !important;">
                                <span>
                                  <img src="<?php echo base_url();?>assets/images/happy-face.png" class="iconSet">
                                </span>
                              <?php  if($val['BabyPhoto']==NULL){ ?>
                               <img src="<?php echo base_url();?>assets/images/user.png" alt="User Image" class="img-responsive" style="height:100px;width:100px;margin-top: -22px;">   
                                <?php } else {?>
                                <img src="<?php echo base_url();?>assets/images/baby_images/<?php echo $val['BabyPhoto']; ?>" alt="User Image" class="img-responsive" style="height:100px;width:100px;margin-top: -22px;">
                                <?php } ?>

                              <a class="users-list-name" href="<?php echo base_url();?>babyM/viewBaby/<?php echo $getAdmissionId['id'];?>/<?php echo $getAdmissionId['status'];?>"><?php
                                 echo 'B/O '.ucwords($motherData['MotherName']);?></a>
                              <span class="users-list-date"><?php echo date('d-m-Y g:i A',$val['add_date']) ?></span>
                            </li>
                  <?php }?>

                  </ul>
                  <!-- /.users-list -->
                </div>
          </div>
             <?php } ?>


      </section>

      <section class="col-lg-6 connectedSortable">

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal1"><span class="fa fa-info-circle"></span></a> Baby KMC Timing <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart1" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#fdc80f"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Total KMC Timing (<?php echo floor(($TotalKMC['kmcTime']/60)/60); ?> hrs)</span></li> 
                    </ul>
                 </div>
                 </div>
           </div>

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal3"><span class="fa fa-info-circle"></span></a> Current SSC Babies (Skin To Skin) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                  <div class="chart">
                  <canvas id="barChart3" style="height:230px"></canvas>
                  <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="" href="#" style="font-size:15px;color:#4FBDBB"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">X-Axis: <?php echo $totalsscHrs; ?> hrs SSC Given & Y-Axis: <?php echo $receivedSccBabyCounting; ?>&nbsp;Babies SSC received</span><br>
                          <span style="font-size:15px;">Not received SSC: <?php echo $LoungeWiseBabys - $receivedSccBabyCounting; ?> Babies</span>
                      </li> 
                    </ul>
                 </div>
                 </div>
           </div>

           <div class="box box-success">
                  <div class="box-header with-border">
                   <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal5"><span class="fa fa-info-circle"></span></a> KMC Given Or Not Given In (24 hrs) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  </div>
                  <div class="box-body">
                     <div id="container1" style="width:100%;height:300px;"></div>
                 </div>
           </div>


          <div class="box box-solid bg-light-blue-gradient">
              <div class="box-header">
                 <div class="pull-right box-tools">
                 </div>
                 <i class="fa fa-map-marker"></i>
                 <h3 class="box-title">
                  KMC Facilities
                 </h3>
              </div>
               <?php
                   if($_REQUEST['loungeWiseValue'] == 'all'){
                    //echo "ok";exit();
                       foreach($totalLounges1 as $val){ 
                          $getFacilityData = $this->load->FacilityModel->FindMobileForResend($val['FacilityID']);
                          $address_latlng[]=array
                             ( 'title'=>$getFacilityData["Address"],
                               'description'=>'<b>Facility Name:&nbsp;</b>'.$getFacilityData["FacilityName"].'<br/><br/><b>Mobile:</b>&nbsp;'.$getFacilityData["AdministrativeMoblieNo"].'<br/><br/><b>Address:</b>&nbsp;'.$getFacilityData["Address"],
                               'lat'=>$getFacilityData["Latitude"],
                               'lng'=>$getFacilityData["Longitude"]
                             );
                       }
                   }else{
                          $address_latlng[]=array
                             ( 'title'=>$getFacilityData["Address"],
                               'description'=>'<b>Facility Name:&nbsp;</b>'.$getFacilityData["FacilityName"].'<br/><br/><b>Mobile:</b>&nbsp;'.$getFacilityData["AdministrativeMoblieNo"].'<br/><br/><b>Address:</b>&nbsp;'.$getFacilityData["Address"],
                               'lat'=>$getFacilityData["Latitude"],
                               'lng'=>$getFacilityData["Longitude"]
                             );
                        }
                    ?>
                       
                    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAxpNXGcquaqlg4PeuA1lqAU-tl4-KQ-xg&callback=initMap" type="text/javascript"></script>
                    <script type="text/javascript">
                    // <![CDATA[
                    var markers = <?php echo json_encode($address_latlng);?>

                    //window.onload = function () {
                    var mapOptions = {
                    center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                    zoom:10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                    var infoWindow = new google.maps.InfoWindow();
                    var lat_lng = new Array();
                    var latlngbounds = new google.maps.LatLngBounds();
                    for (i = 0; i < markers.length; i++) {
                    var data = markers[i]
                    var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                    lat_lng.push(myLatlng);
                    var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: data.title
                    });
                    latlngbounds.extend(marker.position);
                    (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                    });
                    })(marker, data);
                    }
                    map.setCenter(latlngbounds.getCenter());
                    map.fitBounds(latlngbounds);

                    //}
                   </script>
                  <div id="dvMap" style="width:100%; height: 500px;color:black;"></div>
        </div>
        <?php if(count($LatestMother) > 0) { ?>
          <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Registered Mothers <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h3>

                  <div class="box-tools pull-right">
                   <!--  <span class="label label-danger"><a href="<?php //echo base_url();?>Facility/ViewCalendar" style="color:white;">Calender | View</a></span> -->
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                     <?php //print_r($LatestMother);
                    foreach ($LatestMother as $key => $value) { 
                      $this->db->order_by('id','desc'); 
                      $getAdmissionId = $this->db->get_where('mother_admission',array('MotherID'=>$value['MotherID']))->row_array(); 
                      ?>
                      <li style="min-height: 195px !important;">
                        <span>
                          <img src="<?php echo base_url();?>assets/images/happy-face.png" class="iconSet">
                        </span>
                        <?php  if($value['MotherPicture']==NULL){ ?>
                         <img src="<?php echo base_url();?>assets/images/user.png" alt="User Image" class="img-responsive" style="height:100px;width:100px;margin-top: -22px;">   
                          <?php } else {?>
                          <img src="<?php echo base_url();?>assets/images/mother_images/<?php echo $value['MotherPicture']; ?>" alt="User Image" class="img-responsive" style="height:100px;width:100px;margin-top: -22px;">
                          <?php } ?>
                          
                        <a class="users-list-name" href="<?php echo base_url();?>motherM/viewMother/<?php echo $getAdmissionId['id'];?>"><?php
                           echo ucwords($value['MotherName']);?></a>
                        <span class="users-list-date"><?php echo date('d-m-Y g:i A',$value['AddDate']) ?></span>
                      </li>
                  <?php }?>

                  </ul>
                  <!-- /.users-list -->
                </div>
          </div>
             <?php } ?>
            <br/> 
      </section>




 


      <!--     graph codes here -->

            <script src="https://static.anychart.com/js/8.0.1/anychart-core.min.js"></script>
            <script src="https://static.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
              <canvas id="areaChart" style="height:250px;display:none;"></canvas>
              <canvas id="areaChart1" style="height:250px;display:none;"></canvas>
              <canvas id="areaChart2" style="height:250px;display:none;"></canvas>
              <canvas id="areaChart3" style="height:250px;display:none;"></canvas>
              <canvas id="pieChart" style="height:250px;display:none"></canvas>
              <canvas id="lineChart" style="height:250px;display:none"></canvas>
          
<script>
  // registered mother and baby
  $(function () {
    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    var areaChart = new Chart(areaChartCanvas);
    var areaChartData = {
      labels: ["<?php echo $array['4'];?>", "<?php echo $array['3'];?>", "<?php echo $array['2'];?>", "<?php echo $array['1'];?>", "<?php echo $array['0'];?>", "<?php echo $latestMonth;?>"],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $GetLM5;?>, <?php echo $GetLM4;?>, <?php echo $GetLM3;?>, <?php echo $GetLM2;?>, <?php echo $GetLM1;?>, <?php echo $GetLM;?>]
        },
        {
          label: "Digital Goods",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [<?php echo $GetLB5;?>, <?php echo $GetLB4;?>, <?php echo $GetLB3;?>, <?php echo $GetLB2;?>,<?php echo $GetLB1;?>, <?php echo $GetLB;?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#0073b7";
    barChartData.datasets[1].strokeColor = "#0073b7";
    barChartData.datasets[1].pointColor = "#0073b7";
    barChartData.datasets[0].fillColor = "#f390bd";
    barChartData.datasets[0].strokeColor = "#f390bd";
    barChartData.datasets[0].pointColor = "#f390bd";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });


  /********************************* kmc Timing Bar chart *************************************/

  $(function () {
    var areaChartCanvas1 = $("#areaChart1").get(0).getContext("2d");
    var areaChart1 = new Chart(areaChartCanvas1);
    var areaChartData1 = {
      labels: ["<?php echo $array['4'];?>", "<?php echo $array['3'];?>", "<?php echo $array['2'];?>", "<?php echo $array['1'];?>", "<?php echo $array['0'];?>", "<?php echo $latestMonth;?>"],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $lastesMonthKmc5;?>, <?php echo $lastesMonthKmc4;?>, <?php echo $lastesMonthKmc3;?>, <?php echo $lastesMonthKmc2;?>, <?php echo $lastesMonthKmc1;?>, <?php echo $lastesMonthKmc;?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas1 = $("#barChart1").get(0).getContext("2d");
    var barChart1 = new Chart(barChartCanvas1);
    var barChartData1 = areaChartData1;
    barChartData1.datasets[0].fillColor = "#fdc80f";
    barChartData1.datasets[0].strokeColor = "#fdc80f";
    barChartData1.datasets[0].pointColor = "#fdc80f";
    var barChartOptions1 = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions1.datasetFill = false;
    barChart1.Bar(barChartData1, barChartOptions1);
  });

 /********************************* Baby feeding status bar chart *************************************/
  $(function () {
    var areaChartCanvas2 = $("#areaChart2").get(0).getContext("2d");
    var areaChart2 = new Chart(areaChartCanvas2);
    var areaChartData2 = {
      labels: ["<?php echo $array['4'];?>", "<?php echo $array['3'];?>", "<?php echo $array['2'];?>", "<?php echo $array['1'];?>", "<?php echo $array['0'];?>", "<?php echo $latestMonth;?>"],
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo floor($lastesMonthMilk5['quantityOFMilk']);?>, <?php echo floor($lastesMonthMilk4['quantityOFMilk']);?>, <?php echo floor($lastesMonthMilk3['quantityOFMilk']);?>, <?php echo floor($lastesMonthMilk2['quantityOFMilk']);?>, <?php echo floor($lastesMonthMilk1['quantityOFMilk']);?>, <?php echo floor($lastesMonthMilk['quantityOFMilk']);?>]
        }
      ]
    };

    //-------------
    //-
    //-------------
    var barChartCanvas2 = $("#barChart2").get(0).getContext("2d");
    var barChart2 = new Chart(barChartCanvas2);
    var barChartData2 = areaChartData2;
    barChartData2.datasets[0].fillColor = "#A3CC23";
    barChartData2.datasets[0].strokeColor = "#A3CC23";
    barChartData2.datasets[0].pointColor = "#A3CC23";
    var barChartOptions2 = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions2.datasetFill = false;
    barChart2.Bar(barChartData2, barChartOptions2);
  });


 /********************************* SSC Baby BAR CHART *************************************/

  $(function () {
    var areaChartCanvas2 = $("#areaChart3").get(0).getContext("2d");
    var areaChart2 = new Chart(areaChartCanvas2);
    var areaChartData2 = {
      labels: ['0 < 4','4 - 8','8 - 12','12 - 16','16 - 20','20 - 24'],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo floor($skinStatus1);?>,<?php echo floor($skinStatus2);?>,<?php echo floor($skinStatus3);?>,<?php echo floor($skinStatus4);?>,<?php echo floor($skinStatus5);?>,<?php echo floor($skinStatus6);?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas2 = $("#barChart3").get(0).getContext("2d");
    var barChart2 = new Chart(barChartCanvas2);
    var barChartData2 = areaChartData2;
    barChartData2.datasets[0].fillColor = "#4FBDBB";
    barChartData2.datasets[0].strokeColor = "#4FBDBB";
    barChartData2.datasets[0].pointColor = "#4FBDBB";
    var barChartOptions2 = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions2.datasetFill = false;
    barChart2.Bar(barChartData2, barChartOptions2);
  }); 
</script>
<script type="text/javascript">
 // for Breast Feeding pie chart functions
    anychart.onDocumentReady(function() {
    <?php  $notReceive=($TotalAdmittedChild - $getExistFeeding); 
    $notReceivePercent = round(((100*$notReceive)/$TotalAdmittedChild),1).'%';
    $ExclusivePercent  = round(((100*$getExclusiveCurrentDateFeeding)/$TotalAdmittedChild),1).'%';
    $NonExclusivePercent  = round(((100*$getNonExclusiveCurrentDateFeeding)/$TotalAdmittedChild),1).'%';
    ?>
      // set the data
      var data = [
          {x: "Total Babies: <?php echo $TotalAdmittedChild; ?>",
              normal:  {fill: "#E87031"},
              hovered: {fill: "#E87031"}
          },
          {x: "Not Received Babies: <?php echo $notReceive; ?> (<?php echo $notReceivePercent; ?>)", value: <?php echo $notReceive; ?>,
              normal:  {fill: "#F6BE28"},
              hovered: {fill: "#F6BE28"} 
          },
          {x: "Received Babies: <?php echo ($TotalAdmittedChild - $notReceive); ?>",
              normal:  {fill: "#4CAC6E"},
              hovered: {fill: "#4CAC6E"}
          },
          {x: "Exclusive: <?php echo $getExclusiveCurrentDateFeeding; ?> (<?php echo $ExclusivePercent; ?>)", value: <?php echo $getExclusiveCurrentDateFeeding; ?>,
              normal:  {fill: "#A3CC23"},
              hovered: {fill: "#A3CC23"}
           },
          {x: "Non Exclusive: <?php echo $getNonExclusiveCurrentDateFeeding; ?> (<?php echo $NonExclusivePercent; ?>)", value: <?php echo $getNonExclusiveCurrentDateFeeding; ?>,
              normal:  {fill: "#08c108"},
              hovered: {fill: "#08c108"}
          }
      ];

      // create the chart
      var chart = anychart.pie();

      // set the chart title
      chart.title("");

      // add the data
      chart.data(data);
      
      // sort elements
      chart.sort("desc");  
      
      // set legend position
      chart.legend().position("right");
      // set items layout
      chart.legend().itemsLayout("vertical");  

      // display the chart in the container
      chart.container('container');
      chart.draw();

    });

// for KMC given or not given
    anychart.onDocumentReady(function() {
    <?php 
    $kmcNotGiven = ($TotalAdmittedChild - $getKMCGiven);
    $kmcNotGivenPercent = round(((100*$kmcNotGiven)/$TotalAdmittedChild),1).'%';
    $kmcGivenPercent = round(((100*$getKMCGiven)/$TotalAdmittedChild),1).'%';
    ?>
      // set the data
      var data = [
      {x: "Total Babies: <?php echo $TotalAdmittedChild; ?>",
              normal:  {fill: "#E87031"},
              hovered: {fill: "#E87031"}
      },
      {x: "KMC Given: <?php echo $getKMCGiven; ?> (<?php echo $kmcGivenPercent; ?>)", value: <?php echo $getKMCGiven; ?>,
       normal:  {fill: "#F6BE28"},
       hovered: {fill: "#F6BE28"}
      },
      {x: "KMC Not Given: <?php echo $kmcNotGiven; ?> (<?php echo $kmcNotGivenPercent; ?>)", value: <?php echo $kmcNotGiven; ?>,
       normal:  {
                  fill: "#A3CC23",
                  hatchFill: "percent50"        
                },
       hovered: {
                  fill: "#A3CC23",
                  hatchFill: "percent50"
                }
      }
      ];

      // create the chart
      var chart = anychart.pie();

      // set the chart title
      chart.title("");

      // add the data
      chart.data(data);
      
      // sort elements
      chart.sort("desc");  
    chart.normal().fill("#48574", 0.5);
    chart.hovered().fill("#669999", 0.3);

      // set legend position
      chart.legend().position("right");
      // set items layout
      chart.legend().itemsLayout("vertical");  

      // display the chart in the container
      chart.container('container1');
      chart.draw();

    });    
</script>



<?php if($_REQUEST['loungeWiseValue'] == 'all'){ ?>
<!--  Registerd baby and mother bar chart  -->

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Registered Mothers And Babies</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of mothers and babies registered in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of mother registered.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#0073b7;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of baby registered.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of mothers and babies registered.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select distinct br.`BabyID` from babyRegistration as br inner join baby_admission as ba on ba.`BabyID`=br.`BabyID`
             </li>
            <li><span style="color:#000;font-weight:bold">2. </span>select distinct mr.`MotherID` from mother_registration as mr inner join babyRegistration as br on br.`MotherID`=mr.`MotherID` inner join baby_admission as ba on ba.`BabyID`=br.`BabyID`
           </li>
            <li><span style="color:#000;font-weight:bold">3. </span>select * from mother_registration WHERE AddDate BETWEEN (month start date time) AND (month end date time)</li>
            <li><span style="color:#000;font-weight:bold">4. </span>select * from babyRegistration WHERE add_date BETWEEN (month start date time) AND (month end date time)</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>

<!--  Baby KMC Timing bar chart -->

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby KMC Timing</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           Number of hours KMC given, month wise for last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#fdc80f;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of hours KMC given.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of hours.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime and (AddDate BETWEEN 1538332200 AND 1541010599)</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as kmcTime, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>

 <!--  Baby Feeding Status bar chart -->

   <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby Feeding Status</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Total milk provided to babies, month wise for last 6 months. (in ml)
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Total milk provided to babies.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Total milk in ml.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select baby_admissionID,sum(MilkQuantity) as quantityOFMilk FROM `babyDailyNutrition` where AddDate BETWEEN 1538332200 AND 1541010599</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select sum(MilkQuantity) as quantityOFMilk FROM `babyDailyNutrition`</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


   <!--  Baby Feeding Status bar chart -->

   <div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Current SSC Babies (Skin To Skin)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           Total KMC duration provided to babies till now. (in hrs)
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#4FBDBB ;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Total KMC duration provided to babies.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Total SSC given in hrs.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Total babies who recevied SSC till now.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select baby_admissionID,@totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime group by baby_admissionID</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


     <!-- Baby Breast Feeding In (24 hrs) pie chart -->

   <div class="modal fade" id="myModal4" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby Breast Feeding In (24 hrs)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           % of Feeding provided to babies in last 24 hrs as per total number of babies.
           </ul>
          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#E87031;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of baby registered.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#F6BE28;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Not received babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#4CAC6E;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Received babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Exclusive type babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#08c108;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Non-Exclusive type babies.</span></li> 
          </ul>

          <b>Mouse over on graph:</b>
          <ul class="listitem">
            When you mouse over the graph then display babies details with percent value.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' group by bm.`BabyID`</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select BabyID from babyDailyNutrition where FeedingType='1' and (AddDate BETWEEN 1539699236 AND 1539785636) group by BabyID</li>
            <li><span style="color:#000;font-weight:bold">3. </span>select BabyID from babyDailyNutrition where FeedingType != '1' and (AddDate BETWEEN 1539699292 AND 1539785692) group by BabyID</li>
            <li><span style="color:#000;font-weight:bold">4. </span>select BabyID from babyDailyNutrition where AddDate BETWEEN 1539699342 AND 1539785742 group by BabyID</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


       <!-- KMC Given Or Not Given In (24 hrs) pie chart -->

   <div class="modal fade" id="myModal5" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">KMC Given Or Not Given In (24 hrs)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            % of SSC provided to babies in last 24 hrs as per total number of babies.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#E87031;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of baby registered.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#F6BE28;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Not given KMC.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Given KMC.</span></li> 
         </ul>

          <b>Mouse over on graph:</b>
          <ul class="listitem">
            When you mouse over the graph then display babies details with percent value.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' group by bm.`BabyID`</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select BabyID from babyDailyKMC where StartTime < EndTime and (AddDate BETWEEN 1539700699 AND 1539787099) group by BabyID</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>
<?php }else{ ?>
<!--  Registerd baby and mother bar chart  -->

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Registered Mothers And Babies <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of mothers and babies registered in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of mother registered.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#0073b7;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of baby registered.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of mothers and babies registered.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select distinct br.`BabyID` from babyRegistration as br inner join baby_admission as ba on ba.`BabyID`=br.`BabyID` and LoungeId='11'
             </li>
            <li><span style="color:#000;font-weight:bold">2. </span>select distinct mr.`MotherID` from mother_registration as mr inner join babyRegistration as br on br.`MotherID`=mr.`MotherID` inner join baby_admission as ba on ba.`BabyID`=br.`BabyID` and LoungeId='11'
           </li>
            <li><span style="color:#000;font-weight:bold">3. </span>select * from mother_registration WHERE AddDate BETWEEN (month start date time) AND (month end date time) and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">4. </span>select * from babyRegistration WHERE add_date BETWEEN (month start date time) AND (month end date time) and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>

<!--  Baby KMC Timing bar chart -->

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby KMC Timing <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           Number of hours KMC given, month wise for last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#fdc80f;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of hours KMC given.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of hours.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime and (AddDate BETWEEN 1538332200 AND 1541010599) and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as kmcTime, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>

 <!--  Baby Feeding Status bar chart -->

   <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby Feeding Status <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Total milk provided to babies, month wise for last 6 months. (in ml)
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Total milk provided to babies.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Total milk in ml.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select baby_admissionID,sum(MilkQuantity) as quantityOFMilk FROM `babyDailyNutrition` where AddDate BETWEEN 1538332200 AND 1541010599 and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select sum(MilkQuantity) as quantityOFMilk FROM `babyDailyNutrition` and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


   <!--  Baby Feeding Status bar chart -->

   <div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Current SSC Babies (Skin To Skin) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           Total KMC duration provided to babies till now. (in hrs)
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#4FBDBB ;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Total KMC duration provided to babies.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Total SSC given in hrs.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Total babies who recevied SSC till now.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select baby_admissionID,@totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where StartTime < EndTime  and LoungeId='11' group by baby_admissionID</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


     <!-- Baby Breast Feeding In (24 hrs) pie chart -->

   <div class="modal fade" id="myModal4" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Baby Breast Feeding In (24 hrs) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
           % of Feeding provided to babies in last 24 hrs as per total number of babies.
          </ul>
          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#E87031;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of baby registered.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#F6BE28;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Not received babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#4CAC6E;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Received babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Exclusive type babies.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#08c108;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Non-Exclusive type babies.</span></li> 
          </ul>

          <b>Mouse over on graph:</b>
          <ul class="listitem">
            When you mouse over the graph then display babies details with percent value.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' group by bm.`BabyID` and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select BabyID from babyDailyNutrition where FeedingType='1' and (AddDate BETWEEN 1539699236 AND 1539785636) group by BabyID and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">3. </span>select BabyID from babyDailyNutrition where FeedingType != '1' and (AddDate BETWEEN 1539699292 AND 1539785692) group by BabyID and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">4. </span>select BabyID from babyDailyNutrition where AddDate BETWEEN 1539699342 AND 1539785742 group by BabyID and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>


       <!-- KMC Given Or Not Given In (24 hrs) pie chart -->

   <div class="modal fade" id="myModal5" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">KMC Given Or Not Given In (24 hrs) <?php echo ($getLoungeName['LoungeName'] != "") ? '('.$getLoungeName['LoungeName'].')' : ''; ?></h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            % of SSC provided to babies in last 24 hrs as per total number of babies.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#E87031;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of baby registered.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#F6BE28;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Not given KMC.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#A3CC23;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Given KMC.</span></li> 
         </ul>

          <b>Mouse over on graph:</b>
          <ul class="listitem">
            When you mouse over the graph then display babies details with percent value.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' group by bm.`BabyID` and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select BabyID from babyDailyKMC where StartTime < EndTime and (AddDate BETWEEN 1539700699 AND 1539787099) group by BabyID and LoungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>
<?php } ?>

 <?php } ?>