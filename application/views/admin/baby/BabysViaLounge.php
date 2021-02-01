<?php 
  $adminData  = $this->session->userdata('adminData');  
  $QuickEmail = $this->load->FacilityModel->getQuickEmail();
 ?>
 <style type="text/css">
   .leftSetting1{
    padding-left: 12px;
   }
   .babyImgSize{
    height:85px !important;
    width:85px !important;
    margin-top: -42% !important;
   }
 </style>
 <link rel="stylesheet" href="<?php echo base_url('assets/script/designScript.css'); ?>"> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
          <h1>
            Lounge Wise Babies 
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
           foreach($totalLounges as $key => $value) {
               $getFacilityName      = $this->db->query("select * from facilitylist where FacilityID='".$value['facilityId']."'")->row_array();
               $getStable            = $this->db->query("SELECT Distinct ba.`babyId`,ba.`id`,ba.`loungeId` from babyAdmission as ba inner join babyRegistration as br on br.`babyId`=ba.`babyId` where ba.`loungeId`=".$value['loungeId']." and ba.`status`='1'")->result_array();
                $babyIconCounting     = $this->MotherModel->countBabySign($getStable);   
                $lastDoctorId         = $this->db->query("SELECT * FROM `doctorRound` INNER JOIN babyAdmission on `doctorRound`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId='".$value['loungeId']."' ORDER BY doctorRound.`id` DESC")->row_array(); 
                $lastDoctorName = $this->db->query("SELECT * from staffMaster where staffId ='".$lastDoctorId['staffId']."'")->row_array(); 
                $lastDoctorTime = date('d M Y, h:i A', strtotime($lastDoctorId['addDate']));
                $currentNurseId = $this->db->query("SELECT * FROM `nurseDutyChange` where loungeId ='".$value['loungeId']."' ORDER BY `id` DESC")->row_array(); 
                $currentNurseName = $this->db->query("SELECT * from staffMaster where staffId='".$currentNurseId['currentDutyNurseId']."'")->row_array(); 
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
                             <a href="<?php echo base_url();?>facility/updateFacility/<?php echo $value['facilityId'];?>"><?php echo $getFacilityName['FacilityName']; ?></a>
                            <?php } else { echo 'N/A'; } ?>
                            
                           
                       
                      </div>
                      <div class="col-md-5 text-right" style="padding: 10px 17px 6px 0px">
                        <span class="setLineHeight">
                              <img src="<?php echo base_url();?>assets/images/sad-face.png" class="setSize" data-toggle="tooltip" title="Unstable Mothers">&nbsp; 
                              <?php echo $babyIconCounting['unstable'] ; ?>&nbsp;
                               <img src="<?php echo base_url();?>assets/images/happy-face.png" class="setSize" data-toggle="tooltip" title="Stable Mothers">&nbsp;
                               <?php echo $babyIconCounting['stable']; ?>
                           </span><br>
                      </div>
                      <div class="col-md-12" style="padding-bottom: 10px;">
                      <div class="col-md-9" style="padding-left: 5px;">
                         <span class="setLineHeight">Last Doctor On Round: </span><?php if($lastDoctorName['name'] != '') { ?>
                             <a href="<?php echo base_url();?>loungeM/dutylistPage/<?php echo $value['loungeId'];?>"><?php echo $lastDoctorName['name']; ?> <?php echo $lastDoctorTime; ?></a>
                            <?php } else { echo 'N/A'; } ?> <br>
                         <span class="setLineHeight">Last Nurse On Duty: </span> 
                         <?php if($currentNurseName['name'] != '') { ?>
                            <a href="<?php echo base_url();?>staffM/manageDutyChangeModule/<?php echo $value['loungeId'];?>"><?php echo $currentNurseName['name']; ?> <?php echo $currentNurseTime; ?></a>
                          <?php } else { echo 'N/A'; } ?>
                        </div>
                        
                        <div class="col-md-3" style="padding-right: 5px;">
                          <a href="<?php echo base_url('babyM/registeredBaby/4/').$value['loungeId']; ?>" class="buttonSetting" style="margin-top: 5px;padding: 5px 15px 5px 15px;">
                              View All</a>
                        </div>
                    </div>
                    </div>  
                       <div class="info-box incode">
                         <?php 
                            $LoungeWiseBabys      = $this->BabyModel->countAllBabies($value['loungeId']); 
                            $AdmittedBabys        = $this->BabyModel->countBabiesWhereStatus($value['loungeId'],1,1); 
                            $dischargeBabys       = $this->BabyModel->countBabiesWhereStatus($value['loungeId'],2,1); 
                            $LatestBaby           = $this->FacilityModel->getLatestBabyViaLoungeID($value['loungeId'],4); // 4 is data fetch limit
                            if(count($LatestBaby) > 0){ ?>                  
                            <div class="box-header with-border">
                              <div class="row rowSize">
                                 <div class="col-md-4 hovered">
                                   <a href="<?php echo base_url('BabyManagenent/registeredBaby/1/').$value['loungeId']; ?>" style="color: #000;">
                                    <span class="leftSetting1">
                                      <b class="setLineHeight"><img src="<?php echo base_url(); ?>assets/images/icons/total.png" style="width: 30px;"></b>
                                      &nbsp;Total: <span class="text-info"><?php echo $LoungeWiseBabys; ?></span>
                                    </span>  
                                  </a>
                                 </div>

                                 <div class="col-md-4 hovered">
                                  <a href="<?php echo base_url('BabyManagenent/registeredBaby/2/').$value['loungeId']; ?>" style="color: #000;">
                                  <span class="leftSetting1">
                                   <img src="<?php echo base_url(); ?>assets/images/icons/admitted.png" style="width:13px;">
                                   &nbsp;Admitted:
                                     <span class="text-info"><?php echo $babyIconCounting['admittedBaby'];//echo $AdmittedBabys; ?></span>
                                   </span>
                                 </a>
                                 </div>

                                 <div class="col-md-4 hovered">
                                  <a href="<?php echo base_url('BabyManagenent/registeredBaby/3/').$value['loungeId']; ?>" style="color: #000;">
                                  <span class="leftSetting1">
                                   <img src="<?php echo base_url(); ?>assets/images/icons/discharged.png" style="width: 15px;">
                                   &nbsp;Discharged:
                                     <span class="text-info"><?php echo $dischargeBabys; ?></span>
                                   </span>
                                 </a>
                                 </div>

                              </div>
                            </div>
                            <div class="box-header with-border">
                              <h3 class="box-title" style="margin-left: 3px;">Latest Registered Babies</h3>
                              
                            </div>
                           <div class="box-body">
                              <ul class="users-list clearfix" style="min-height: auto;">
                              <?php 
                                foreach ($LatestBaby as $key => $val) { 
                                    $this->db->order_by('id','desc'); 
                                     $getAdmissionId      = $this->db->get_where('babyAdmission',array('babyId'=>$val['babyId']))->row_array(); 
                                     $motherData          = $this->db->get_where('motherRegistration',array('motherId'=>$val['motherId']))->row_array(); 
                                     //$get_last_assessment = $this->load->FacilityModel->GetBabyDanger($val['BabyID']);
                                      $get_last_assessment = $this->BabyModel->getMonitoringExistData($val['babyId'],$getAdmissionId['id'],$getAdmissionId['loungeId']);
                                      $babyIconStatus      = $this->DangerSignModel->getBabyIcon($get_last_assessment);
                                      if($babyIconStatus == '1'){
                                      $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                                      $topMargin = '';
                                      }else if($babyIconStatus == '0'){
                                        $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                                        $topMargin = '';
                                      }else{
                                        $icon      = "";
                                        $topMargin = 'margin-top:-23% !important;';
                                      }
                                  ?>
                                  <li>
                                    <center>
                                        <span>
                                          <?php  echo $icon;  ?>
                                        </span>
                                    <?php  if($val['babyPhoto']==NULL){ ?>
                                       <img src="<?php echo base_url();?>assets/images/user.png" alt="User Image" class="img-responsive babyImgSize" style="<?php echo $topMargin; ?>">   
                                      <?php } else {?>
                                        <img src="<?php echo babyDirectoryUrl.$val['babyPhoto']; ?>" alt="User Image" class="img-responsive babyImgSize" style="<?php echo $topMargin; ?>">
                                      <?php } ?>
                                      </center>
                                <a class="users-list-name" href="<?php echo base_url();?>babyM/viewBaby/<?php echo $getAdmissionId['id'];?>/<?php echo $getAdmissionId['status'];?>"><?php
                                 echo 'B/O '.(!empty($motherData['motherName']) ? ucwords($motherData['motherName']) : 'UNKNOWN');?></a>
                                    <span class="users-list-date"><?php echo date('d-m-Y g:i A',strtotime($val['addDate'])) ?></span>
                                  </li>
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
                     <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal<?php echo $value['loungeId']; ?>"><span class="fa fa-info-circle"></span></a> Registered Babies <?php echo ($value['loungeName'] != "") ? '('.$value['loungeName'].')' : ''; ?></h3>
                    </div>
                    <div class="box-body">
                    <div class="chart<?php echo $value['loungeId']; ?>">
                    <canvas id="barChart<?php echo $value['loungeId']; ?>" style="height:230px"></canvas>
                    <ul class="fc-color-picker" id="color-chooser">
                        <li style="line-height: 0px;"><a class="" href="#" style="font-size:15px;color:#0073b7;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Babies (<?php echo $LoungeWiseBabys; ?>)</span></li> 
                      </ul>
                   </div>
                   </div>
                </div> 
            </section>  

  <div class="modal fade" id="myModal<?php echo $value['loungeId']; ?>" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Registered Babies (<?php echo $value['loungeName']; ?>)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of baby registered in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#0073b7;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of baby registered.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of baby registered.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select distinct br.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` and LoungeId='11'
             </li>
           <li><span style="color:#000;font-weight:bold">4. </span>select * from babyRegistration WHERE add_date BETWEEN (month start date time) AND (month end date time) and LoungeId='11'</li>
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
                      $GetLB = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDayTimeStamp,$LastDayTimeStamp,$value['loungeId']);
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
                      
                    $GetLB1 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_1,$LastDay_1,$value['loungeId']);
                    $GetLB2 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_2,$LastDay_2,$value['loungeId']);
                    $GetLB3 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_3,$LastDay_3,$value['loungeId']);
                    $GetLB4 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_4,$LastDay_4,$value['loungeId']);
                    $GetLB5 = $this->load->DashboardDataModel->GetCurrentMonthRegistredBabies($FirstDay_5,$LastDay_5,$value['loungeId']);    
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
    var barChartCanvas<?php echo $value['loungeId']; ?> = $("#barChart<?php echo $value['loungeId']; ?>").get(0).getContext("2d");
    var barChart<?php echo $value['loungeId']; ?>       = new Chart(barChartCanvas<?php echo $value['loungeId']; ?>);
    var barChartData<?php echo $value['loungeId']; ?>   = areaChartData<?php echo $value['loungeId']; ?>;
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].fillColor = "#0073b7";
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].strokeColor = "#0073b7";
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].pointColor = "#0073b7";
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
