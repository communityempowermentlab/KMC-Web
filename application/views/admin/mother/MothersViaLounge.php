<?php 
  $adminData  = $this->session->userdata('adminData');  
  $QuickEmail = $this->load->FacilityModel->getQuickEmail();
?>

<link rel="stylesheet" href="<?php echo base_url('assets/script/designScript.css'); ?>"> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
          Lounge Wise Mothers
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
   </section>
    <!-- Main content -->
    <section class="content">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <?php echo $this->session->flashdata('activate'); ?>
      </div>     
      <div class="row">
          <?php 
            $stable         = 0;
            $unstable       = 0;
           foreach($totalLounges as $key => $value) {
            $getFacilityName        = $this->db->query("SELECT * from facilitylist where FacilityID='".$value['facilityId']."'")->row_array();
            $getStable              = $this->db->query("SELECT distinct ma.`id`,mr.`motherId`,ma.`loungeId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' and ma.`loungeId`=".$value['loungeId']."")->result_array();         
            $motherIconCounting   = $this->MotherModel->countMotherIcon($getStable);
            $lastDoctorId         = $this->db->query("SELECT * FROM `doctorRound` INNER JOIN babyAdmission on `doctorRound`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId='".$value['loungeId']."' ORDER BY doctorRound.`id` DESC")->row_array(); 
            $lastDoctorName = $this->db->query("SELECT * from staffMaster where staffId ='".$lastDoctorId['staffId']."'")->row_array(); 
            $lastDoctorTime = date('d M Y, h:i A', strtotime($lastDoctorId['addDate']));
            $currentNurseId = $this->db->query("SELECT * FROM `nurseDutyChange` where loungeId ='".$value['loungeId']."' ORDER BY nurseDutyChange.`id` DESC")->row_array(); 
            $currentNurseName = $this->db->query("SELECT * from staffMaster where staffId='".$currentNurseId['nurseId']."'")->row_array(); 
            $currentNurseTime = date('d M Y, h:i A', strtotime($currentNurseId['addDate']));
          ?>
           <section class="col-lg-6 connectedSortable">
             <div class="boxSetting boxHeight">  
               <div class="row rowSize">
                 <div class="col-md-7" style="padding: 1px 5px 6px 18px;">
                       <span class="info textFormat">
                        <a href="<?php echo base_url();?>loungeM/updateLounge/<?php echo $value['loungeId'];?>">
                         <?php echo $value['loungeName']; ?>
                        </a>

                      </span>
                      <span class="setLineHeight">Facility Name: </span>  
                     <?php if($getFacilityName['FacilityName'] != '') { ?>
                       <a class="text-info" href="<?php echo base_url();?>facility/updateFacility/<?php echo $value['facilityId'];?>"><?php echo $getFacilityName['FacilityName']; ?></a>
                      <?php } else { echo 'N/A'; } ?>
                </div>
                <div class="col-md-5 text-right" style="padding: 10px 17px 6px 0px">
                  <span class="setLineHeight">
                        <img src="<?php echo base_url();?>assets/images/sad-face.png" class="setSize" data-toggle="tooltip" title="Unstable Mothers">&nbsp; 
                        <?php echo $motherIconCounting['unstable'] ; ?>&nbsp;
                         <img src="<?php echo base_url();?>assets/images/happy-face.png" class="setSize" data-toggle="tooltip" title="Stable Mothers">&nbsp;
                         <?php echo $motherIconCounting['stable']; ?>
                     </span><br>
                  
                </div>
                <div class="col-md-12" style="padding-bottom: 10px;">
                  <div class="col-md-9" style="padding-left: 5px;">
                     <span class="setLineHeight">Last Doctor On Round: </span><?php if($lastDoctorName['name'] != '') { ?>
                         <a href="<?php echo base_url();?>loungeM/dutylistPage/<?php echo $value['loungeId'];?>"><?php echo $lastDoctorName['name']; ?> <?php echo $lastDoctorTime; ?></a>
                        <?php } else { echo 'N/A'; } ?> <br>
                     <span class="setLineHeight">Current Nurse On Duty: </span> 
                     <?php if($currentNurseName['name'] != '') { ?>
                        <a href="<?php echo base_url();?>staffM/manageDutyChangeModule/<?php echo $value['loungeId'];?>"><?php echo $currentNurseName['name']; ?> <?php echo $currentNurseTime; ?></a>
                      <?php } else { echo 'N/A'; } ?>
                    </div>
                    
                    <div class="col-md-3" style="padding-right: 5px;">
                      <a href="<?php echo base_url('/motherM/currentMotherGridView/').$value['loungeId']; ?>" class="buttonSetting" style="margin-top: 5px;padding: 5px 15px 5px 15px;">
                        View All</a> 
                    </div>
                </div>
              </div>  
           <!--       </div> -->
                 <div class="info-box incode">
                   <?php 
                      $totallyAdmittedMothers   = $this->DashboardDataModel->totallyAdmittedMothers($value['loungeId']); 
                      $LoungeWiseTotalMothers   = $this->DashboardDataModel->getAllMothersViaLounge($value['loungeId']); 
                      $dischargeMothers         = $this->DashboardDataModel->getAllAdmittedMothersViaLounge($value['loungeId'],2); 
                      $LatestMother             = $this->FacilityModel->getLatestMotherViaLoungeID($value['loungeId'],4); // 4 is limit

                      if(count($LatestMother) > 0){ ?>                  
                      <div class="box-header with-border">
                        <div class="row rowSize">
                           <div class="col-md-6 hovered">
                            <center>
                               <a href="<?php echo base_url('/motherM/registeredMother/').$value['loungeId']."/all"; ?>" style="color: #000;">
                                <span class="">
                                  <b class="setLineHeight"><img src="<?php echo base_url(); ?>assets/images/icons/total.png" style="width: 30px;"></b>
                                  &nbsp;Total: <span class="text-info"><?php echo $LoungeWiseTotalMothers; ?></span>
                                </span>  
                              </a>
                            </center>
                           </div>

                           <div class="col-md-6 hovered">
                             <center>
                              <a href="<?php echo base_url('/motherM/registeredMother/').$value['loungeId'].'/admitted'; ?>" style="color: #000;">
                                <span class="">
                                 <img src="<?php echo base_url(); ?>assets/images/icons/admitted.png" style="width:13px;">
                                 &nbsp;Total Admitted:
                                   <span class="text-info"><?php echo $totallyAdmittedMothers; ?></span>
                                 </span>
                              </a>
                            </center>
                           </div>
                        
                         <div class="col-md-6 hovered">
                          <center>
                            <a href="<?php echo base_url('/motherM/registeredMother/').$value['loungeId'].'/currentlyAvail'; ?>" style="color: #000;">
                            <span class="">
                            <img src="<?php echo base_url(); ?>assets/images/icons/CurrentlyAdmitted.png" style="width: 18px;">
                             &nbsp;Currently Admitted:
                               <span class="text-info"><?php echo $motherIconCounting['admittedMother']; ?></span>
                             </span>
                            </a>
                          </center>
                         </div>

                         <div class="col-md-6 hovered">
                          <center>
                            <a href="<?php echo base_url('/motherM/registeredMother/').$value['loungeId'].'/dischargedMother'; ?>" style="color: #000;">
                              <span class="">
                               <img src="<?php echo base_url(); ?>assets/images/icons/discharged.png" style="width: 15px;">
                                 &nbsp;Discharged: <span class="text-info"><?php echo $dischargeMothers; ?></span>
                              </span>
                            </a>
                          </center>
                         </div>

                        </div>
                      </div>
                      <div class="box-header with-border">
                        <h3 class="box-title" style="margin-left: 3px;">Latest Registered Mothers</h3>
                        
                      </div>
                     <div class="box-body">
                        <ul class="users-list clearfix" style="min-height: auto;">
                        <?php 

                            foreach ($LatestMother as $key => $val) { 
                              $this->db->order_by('id','desc'); 
                              $getAdmissionId = $this->db->get_where('motherAdmission',array('motherId'=>$val['motherId']))->row_array(); 
                             
                              $this->db->order_by('id','desc');  
                              $get_last_assessment  = $this->db->get_where('motherMonitoring',array('motherAdmissionId'=>$getAdmissionId['id']))->row_array(); 
                              $motherIconStatus     = $this->DangerSignModel->getMotherIcon($get_last_assessment);
                                  
                                  if($motherIconStatus == '1'){
                                    $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                                  }else if($motherIconStatus == '0'){
                                    $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                                  }else{ echo $icon=""; }
                            ?>
                            <li>
                              <center>
                                <a href="" id="stableIcon<?=$val['motherId']?>">
                                  <span>
                                    <?php  echo $icon;  ?>
                                  </span>
                                </a>
                              <?php  if($val['motherPicture']==NULL){ ?>
                               <img src="<?php echo base_url();?>assets/images/user.png" alt="User Image" class="img-responsive" style="height:65px;width:65px; <?php if(empty($icon)){ echo 'margin-top:-26%'; }  ?>">   
                                <?php } else { ?>
                                  <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $getAdmissionId['id'];?>">
                                    <img src="<?php echo motherDirectoryUrl.$val['motherPicture']; ?>" alt="User Image" class="img-responsive" style="height:65px;width:65px;<?php if(empty($icon)){ echo 'margin-top:-26%'; }  ?>">
                                  </a>
                                <?php } ?>
                                </center>
                              <a class="users-list-name" href="<?php echo base_url();?>motherM/viewMother/<?php echo $getAdmissionId['id'];?>">
                                <?php
                                 echo (!empty($val['motherName'])) ? ucwords($val['motherName']) : '';?></a>
                              <span class="users-list-date"><?php echo date('d-m-Y g:i A', strtotime($val['addDate'])) ?></span>
                            </li>
                            <div class="modal fade" id="stableModal<?=$val['motherId']?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-header btn-primary" style="padding:7px;">
                                    <h4 class="modal-title text-center" style="color:#fff;">Stability Description</h4>
                                  </div>
                                  <div class="modal-body">

                                    <p style="width: 50%; float: left;"><b>Mother Name:</b> <?php echo $val['motherName']; ?></p>
                                    <p style="width: 50%; float: right;"><b>Assessment Date & Time:</b><?php if(!empty($get_last_assessment['addDate'])) { ?> <?php echo date('d-m-Y g:i A', strtotime($get_last_assessment['addDate'])); } else { echo 'N/A'; } ?></p>

                                    <?php if($get_last_assessment['motherPulse'] < 50 || $get_last_assessment['motherPulse'] > 120){
                                          $color1 = 'red';
                                        } else {
                                          $color1 = 'black';
                                        }
                                       if($get_last_assessment['motherTemperature'] < 95.9 || $get_last_assessment['motherTemperature'] > 99.5){
                                          $color2 = 'red';
                                        } else {
                                          $color2 = 'black';
                                        }
                                       if($get_last_assessment['motherSystolicBP'] >= 140 || $get_last_assessment['motherSystolicBP'] <= 90){
                                          $color3 = 'red';
                                        } else {
                                          $color3 = 'black';
                                        }
                                      if($get_last_assessment['motherDiastolicBP'] <= 60 || $get_last_assessment['motherDiastolicBP'] >= 90){
                                          $color4 = 'red';
                                        } else {
                                          $color4 = 'black';
                                        }
                                      ?>

                                    <table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th>Test name</th>
                                          <th>Results</th>
                                          <th>Units</th>
                                          <th>Bio. Ref. Interval</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td>Heart Beat</td>
                                          <td style="color: <?= $color1; ?>"><?php echo ($get_last_assessment['motherPulse']!='')?$get_last_assessment['motherPulse'] :'N/A'; ?></td>
                                          <td>/min</td>
                                          <td>50 - 120</td>
                                        </tr>
                                        <tr>
                                          <td>Temperature</td>
                                          <td style="color: <?= $color2; ?>"><?php echo ($get_last_assessment['motherTemperature']!='')?$get_last_assessment['motherTemperature'] :'N/A'; ?></td>
                                          <td><sup>0</sup>F</td>
                                          <td>95.9 - 99.5</td>
                                        </tr>
                                        <tr>
                                          <td>Systolic BP</td>
                                          <td style="color: <?= $color3; ?>"><?php echo ($get_last_assessment['motherSystolicBP']!='')?$get_last_assessment['motherSystolicBP'] :'N/A'; ?></td>
                                          <td>/min</td>
                                          <td>90 - 140</td>
                                        </tr>
                                        <tr>
                                          <td>Diastolic BP</td>
                                          <td style="color: <?= $color4; ?>"><?php echo ($get_last_assessment['motherDiastolicBP']!='')?$get_last_assessment['motherDiastolicBP'] :'N/A'; ?></td>
                                          <td>/min</td>
                                          <td>60 - 90</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    
                                  </div>
                                  <div class="modal-footer" style="padding:7px;">
                                    <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
                                  </div>
                                </div>
                                
                              </div>
                            </div>

                            <script type="text/javascript">
                              $(document).ready(function(){
                                  $( "#stableIcon<?=$val['motherId']; ?>" ).hover(function() {
                                         $('#stableModal<?php echo $val['motherId']; ?>').modal({
                                      show: true
                                  });
                                });  
                              });
                            </script>
                        <?php }?>
                        </ul>
                     </div>
                 <?php } else { echo "<center><p style='padding-top:100px;font-size:20px;'>No Data Found</p></center>"; } ?>
                </div>
             </div>   
        </section>   
            <section class="col-lg-6 connectedSortable">       
                <div class="box box-success boxHeight">
                    <div class="box-header with-border">
                     <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal<?php echo $value['loungeId']; ?>"><span class="fa fa-info-circle"></span></a> Registered Mothers<?php echo ($value['loungeName'] != "") ? '('.$value['loungeName'].')' : ''; ?></h3>
                    </div>
                    <div class="box-body">
                    <div class="chart<?php echo $value['loungeId']; ?>">
                    <canvas id="barChart<?php echo $value['loungeId']; ?>" style="height:230px"></canvas>
                    <ul class="fc-color-picker" id="color-chooser">
                        <li style="line-height: 0px;"><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Mothers (<?php echo $LoungeWiseTotalMothers; ?>)</span></li> 
                      </ul>
                   </div>
                   </div>
                </div> 
            </section>  

   

  <div class="modal fade" id="myModal<?php echo $value['loungeId']; ?>" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Registered Mothers (<?php echo $value['loungeName']; ?>)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of mothers registered in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of mother registered.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of mothers registered.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select mr.`motherId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId` = mr.`motherId` where ma.`loungeId`=11
           </li>
            <li><span style="color:#000;font-weight:bold">2. </span>select * from motherRegistration WHERE addDate BETWEEN (month start date time) AND (month end date time) and loungeId='11'</li>
          </ul>
        </div>
        <div class="modal-footer" style="padding:7px;">
          <a href="" class="btn btn-primary btn-md" data-dismiss="modal">Close</a>
        </div>
      </div>
      
    </div>
  </div>
              <?php 
                $latestMonth = date('M Y');
                    for ($i = 1; $i < 6; $i++) 
                    {
                       $array[] = date("M Y", strtotime( date( 'Y-m-01' )." -$i months"));
                    }
                      $FirstDayTimeStamp = date('Y-m-01 00:00:00');  
                      $LastDayTimeStamp  = date('Y-m-t 23:59:59');  
                      $GetLM = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDayTimeStamp,$LastDayTimeStamp,$value['loungeId']);
                      $first_day_this_month = date('Y-m-01 00:00:00');
                      $date = new DateTime(date('Y-m-01 00:00:00'));
                      $date->modify('-1 month');
                      $FirstDay_1 = $date->format('Y-m-d H:i:s');
                      $date->modify('-1 month');
                      $FirstDay_2 = $date->format('Y-m-d H:i:s');
                      $date->modify('-1 month');
                      $FirstDay_3 = $date->format('Y-m-d H:i:s');
                      $date->modify('-1 month');
                      $FirstDay_4 = $date->format('Y-m-d H:i:s');
                      $date->modify('-1 month');
                      $FirstDay_5 = $date->format('Y-m-d H:i:s');

                         $date = new DateTime(date('Y-m-t 23:59:59'));
                           $monthNumber = date('m', strtotime($array[0]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                           }
                           else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         
                         $LastDay_1= $date->format('Y-m-d H:i:s');
                          $monthNumber =date('m', strtotime($array[1]));
                         if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                        
                         $LastDay_2= $date->format('Y-m-d H:i:s');
                            $monthNumber =date('m', strtotime($array[2]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         $LastDay_3= $date->format('Y-m-d H:i:s');
                            $monthNumber =date('m', strtotime($array[3]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
            
                         $LastDay_4= $date->format('Y-m-d H:i:s');
                            $monthNumber =date('m', strtotime($array[4]));
                        if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         $LastDay_5 = $date->format('Y-m-d H:i:s');
                      
                    $GetLM1 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_1,$LastDay_1,$value['loungeId']);
                    $GetLM2 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_2,$LastDay_2,$value['loungeId']);
                    $GetLM3 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_3,$LastDay_3,$value['loungeId']);
                    $GetLM4 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_4,$LastDay_4,$value['loungeId']);
                    $GetLM5 = $this->load->DashboardDataModel->GetCurrentMonthRegistredMother($FirstDay_5,$LastDay_5,$value['loungeId']);    
           ?>
                           

            <canvas id="areaChart<?php echo $value['loungeId']; ?>" style="height:250px;display:none;"></canvas>

 <script>
  // registered mother and baby
  $(function () {
    var areaChartCanvas<?php echo $value['loungeId']; ?> = $("#areaChart<?php echo $value['loungeId']; ?>").get(0).getContext("2d");
    var areaChart<?php echo $value['loungeId']; ?> = new Chart(areaChartCanvas<?php echo $value['loungeId']; ?>);
    var areaChartData<?php echo $value['loungeId']; ?> = {
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
        }
      ]
    };
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas<?php echo $value['loungeId']; ?> = $("#barChart<?php echo $value['loungeId']; ?>").get(0).getContext("2d");
    var barChart<?php echo $value['loungeId']; ?>       = new Chart(barChartCanvas<?php echo $value['loungeId']; ?>);
    var barChartData<?php echo $value['loungeId']; ?>   = areaChartData<?php echo $value['loungeId']; ?>;
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].fillColor = "#f390bd";
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].strokeColor = "#f390bd";
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].pointColor = "#f390bd";
    var barChartOptions<?php echo $value['loungeId']; ?> = {
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
    barChartOptions<?php echo $value['loungeId']; ?>.datasetFill = false;
    barChart<?php echo $value['loungeId']; ?>.Bar(barChartData<?php echo $value['loungeId']; ?>, barChartOptions<?php echo $value['loungeId']; ?>);
  });
</script>
 <?php } ?>
  </div>         
 </div>
</div>
</section>
</body>
</html>
