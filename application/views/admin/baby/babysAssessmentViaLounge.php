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
             Baby Assessment Via Lounge
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
               $getFacilityName      = $this->db->query("select * from facilitylist where FacilityID='".$value['FacilityID']."'")->row_array();
               $getStable            = $this->db->query("SELECT ba.`BabyID`,ba.`id`,ba.`LoungeID` from baby_admission as ba inner join babyRegistration as br on br.`BabyID`=ba.`BabyID` where ba.`LoungeID`=".$value['LoungeID']." and ba.`status`='1'")->result_array();
               $babyIconCounting     = $this->BabyModel->countBabySign($getStable);         
            ?>
                 <section class="col-lg-6 connectedSortable">
                   <div class="boxSetting boxHeight">  
                     <div class="row rowSize">
                       <div class="col-md-7" style="padding: 1px 5px 12px 18px;">
                             <span class="info textFormat">
                              <a href="<?php echo base_url();?>loungeM/updateLounge/<?php echo $value['LoungeID'];?>">
                               <?php echo $value['LoungeName']; ?>
                              </a>
                            </span><br>
                           <span class="setLineHeight">Facility Name: </span>  
                           <?php if($getFacilityName['FacilityName'] != '') { ?>
                             <a href="<?php echo base_url();?>facility/updateFacility/<?php echo $value['FacilityID'];?>"><?php echo $getFacilityName['FacilityName']; ?></a>
                            <?php } else { echo 'N/A'; } ?>
                            <br>
                           <div style="margin-top: 6px;">
                           <span class="setLineHeight">
                              <img src="<?php echo base_url();?>assets/images/sad-face.png" class="setSize" data-toggle="tooltip" title="Unstable Mothers">&nbsp; 
                              <?php echo $babyIconCounting['unstable'] ; ?>&nbsp;
                               <img src="<?php echo base_url();?>assets/images/happy-face.png" class="setSize" data-toggle="tooltip" title="Stable Mothers">&nbsp;
                               <?php echo $babyIconCounting['stable']; ?>
                           </span><br>
                         </div>
                       
                      </div>
                      <div class="col-md-5 text-right" style="padding: 10px 17px 15px 0px">
                        <a href="<?php echo base_url('babyM/babyAssessment/').$value['LoungeID']; ?>" class="buttonSetting">
                              View All</a>
                      </div>
                    </div>  
                       <div class="info-box incode">
                         <?php 
                            $LoungeWiseBabys      = $this->BabyModel->countAllBabies($value['LoungeID']); 
                            $AdmittedBabys        = $this->BabyModel->countBabiesWhereStatus($value['LoungeID'],1,1); 
                            $dischargeBabys       = $this->BabyModel->countBabiesWhereStatus($value['LoungeID'],2,1); 
                            $LatestBaby           = $this->FacilityModel->getFourLatestBabyViaLoungeID($value['LoungeID']);
                            $totalBabyAssessment  = $this->DashboardDataModel->totollyBabyAssessmnts($value['LoungeID']);
                            if(count($LatestBaby) > 0){ ?>                  
                            <div class="box-header with-border">
                              <div class="row rowSize">
                                 <div class="col-md-4 hovered">
                                   <a href="<?php echo base_url('BabyManagenent/registeredBaby/1/').$value['LoungeID']; ?>">
                                    <span class="leftSetting1">
                                      <b class="setLineHeight"><span class="fa fa-female iconFormating"></span></b>
                                      &nbsp;Total <?php echo $LoungeWiseBabys; ?>
                                    </span>  
                                  </a>
                                 </div>

                                 <div class="col-md-4 hovered">
                                  <a href="<?php echo base_url('BabyManagenent/registeredBaby/2/').$value['LoungeID']; ?>">
                                  <span class="leftSetting1">
                                   <img src="<?php echo base_url();?>assets/images/svg/Registration-01.svg" class="setSize">
                                   &nbsp;Admitted
                                     <?php echo $AdmittedBabys; ?>
                                   </span>
                                 </a>
                                 </div>

                                 <div class="col-md-4 hovered">
                                  <a href="<?php echo base_url('BabyManagenent/registeredBaby/3/').$value['LoungeID']; ?>">
                                  <span class="leftSetting1">
                                   <img src="<?php echo base_url();?>assets/images/svg/Registration-01.svg" class="setSize">
                                   &nbsp;Discharged
                                     <?php echo $dischargeBabys; ?>
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
                                     $getAdmissionId      = $this->db->get_where('baby_admission',array('BabyID'=>$val['BabyID']))->row_array(); 
                                     $motherData          = $this->db->get_where('mother_registration',array('MotherID'=>$val['MotherID']))->row_array(); 
                                     //$get_last_assessment = $this->load->FacilityModel->GetBabyDanger($val['BabyID']);
                                      $get_last_assessment = $this->BabyModel->getMonitoringExistData($val['BabyID'],$getAdmissionId['id'],$getAdmissionId['LoungeID']);
                                     $babyIconStatus      = $this->DangerSignModel->getBabyIcon($get_last_assessment);
                                      if($babyIconStatus == '1'){
                                      $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                                      $topMargin = "margin-top:5%";
                                      }else if($babyIconStatus == '0'){
                                        $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                                        $topMargin = "";
                                      }else{
                                        $icon = "";
                                        $topMargin = 'margin-top:-23% !important;';
                                      }
                                  ?>
                                  <li>
                                    <center>
                                        <span>
                                          <?php  echo $icon;  ?>
                                        </span>
                                    <?php  if($val['BabyPhoto']==NULL){ ?>
                                       <img src="<?php echo base_url();?>assets/images/user.png" alt="User Image" class="img-responsive babyImgSize" style="<?php echo $topMargin; ?>">   
                                      <?php } else {?>
                                        <img src="<?php echo base_url();?>assets/images/baby_images/<?php echo $val['BabyPhoto']; ?>" alt="User Image" class="img-responsive babyImgSize" style="<?php echo $topMargin; ?>">
                                      <?php } ?>
                                      </center>
                                <a class="users-list-name" href="<?php echo base_url();?>babyM/viewBaby/<?php echo $getAdmissionId['id'];?>/<?php echo $getAdmissionId['status'];?>"><?php
                                 echo 'B/O '.ucwords($motherData['MotherName']);?></a>
                                    <span class="users-list-date"><?php echo date('d-m-Y g:i A',$val['add_date']) ?></span>
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
                     <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal<?php echo $value['LoungeID']; ?>"><span class="fa fa-info-circle"></span></a> Total Baby Assessment<?php echo ($value['LoungeName'] != "") ? ' ('.$value['LoungeName'].')' : ''; ?></h3> 

                    </div>
                    <div class="box-body">
                    <div class="chart<?php echo $value['LoungeID']; ?>">
                    <canvas id="barChart<?php echo $value['LoungeID']; ?>" style="height:230px"></canvas>
                    <ul class="fc-color-picker" id="color-chooser">
                        <li style="line-height: 0px;"><a class="" href="#" style="font-size:15px;color:#ADD8E6;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Total Baby Assessment (<?php echo $totalBabyAssessment; ?>)</span></li> 
                      </ul>
                   </div>
                   </div>
                </div> 
            </section>  

  <div class="modal fade" id="myModal<?php echo $value['LoungeID']; ?>" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Registered Babies (<?php echo $value['LoungeName']; ?>)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of Baby Assements in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#ADD8E6;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of Total Baby Assements.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of Baby Assements.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select * from baby_monitoring WHERE add_date BETWEEN (month start date time) AND (month end date time) and LoungeId='11'</li>
            <li><span style="color:#000;font-weight:bold">2. </span>select * from baby_monitoring WHERE LoungeId='11'</li>
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
                      $FirstDayTimeStamp = strtotime(date('Y-m-01 00:00:00'));  
                      $LastDayTimeStamp  = strtotime(date('Y-m-t 23:59:59'));  
                      $GetLB = $this->load->DashboardDataModel->getMothlyBabyAsssement($FirstDayTimeStamp,$LastDayTimeStamp,$value['LoungeID']);
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
                           $monthNumber = date('m', strtotime($array[0]));
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
                         $LastDay_5 = strtotime($date->format('Y-m-d H:i:s'));
                      
                    $GetLB1 = $this->load->DashboardDataModel->getMothlyBabyAsssement($FirstDay_1,$LastDay_1,$value['LoungeID']);
                    $GetLB2 = $this->load->DashboardDataModel->getMothlyBabyAsssement($FirstDay_2,$LastDay_2,$value['LoungeID']);
                    $GetLB3 = $this->load->DashboardDataModel->getMothlyBabyAsssement($FirstDay_3,$LastDay_3,$value['LoungeID']);
                    $GetLB4 = $this->load->DashboardDataModel->getMothlyBabyAsssement($FirstDay_4,$LastDay_4,$value['LoungeID']);
                    $GetLB5 = $this->load->DashboardDataModel->getMothlyBabyAsssement($FirstDay_5,$LastDay_5,$value['LoungeID']);    
           ?>
                           

            <canvas id="areaChart<?php echo $value['LoungeID']; ?>" style="height:250px;display:none;"></canvas>

 <script>
  // registered mother and baby
  $(function () {
    var areaChartCanvas<?php echo $value['LoungeID']; ?> = $("#areaChart<?php echo $value['LoungeID']; ?>").get(0).getContext("2d");
    var areaChart<?php echo $value['LoungeID']; ?> = new Chart(areaChartCanvas<?php echo $value['LoungeID']; ?>);
    var areaChartData<?php echo $value['LoungeID']; ?> = {
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
    var barChartCanvas<?php echo $value['LoungeID']; ?> = $("#barChart<?php echo $value['LoungeID']; ?>").get(0).getContext("2d");
    var barChart<?php echo $value['LoungeID']; ?>       = new Chart(barChartCanvas<?php echo $value['LoungeID']; ?>);
    var barChartData<?php echo $value['LoungeID']; ?>   = areaChartData<?php echo $value['LoungeID']; ?>;
    barChartData<?php echo $value['LoungeID']; ?>.datasets[0].fillColor = "#ADD8E6";
    barChartData<?php echo $value['LoungeID']; ?>.datasets[0].strokeColor = "#ADD8E6";
    barChartData<?php echo $value['LoungeID']; ?>.datasets[0].pointColor = "#ADD8E6";
    var barChartOptions<?php echo $value['LoungeID']; ?> = {
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

    barChartOptions<?php echo $value['LoungeID']; ?>.datasetFill = false;
    barChart<?php echo $value['LoungeID']; ?>.Bar(barChartData<?php echo $value['LoungeID']; ?>, barChartOptions<?php echo $value['LoungeID']; ?>);
  });
</script>


     <?php } ?>
  </div>         
      </div>
      </div>
 </section>

</body>
</html>
