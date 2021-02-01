<?php 
  $adminData  = $this->session->userdata('adminData');  
  $QuickEmail = $this->load->FacilityModel->getQuickEmail();
?>

<link rel="stylesheet" href="<?php echo base_url('assets/script/designScript.css'); ?>"> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
          Lounge Wise SMS
        </h1>
   </section>
    <!-- Main content -->
    <section class="content">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <?php echo $this->session->flashdata('activate'); ?>
      </div>     
      <div class="row">
           <?php 
           foreach($totalLounges as $key => $value) {
            $getFacilityName = $this->SmsModel->GetFacilityName($value['facilityId']);
            $countSMS        = $this->SmsModel->getSmsData('1',$value['loungeId']);
            $lastSms         = $this->SmsModel->getLastDateTime($value['loungeId']);
            if(!empty($lastSms['addDate'])){
            $sTime           = strtotime($lastSms['addDate']) - 5;
            $eTime           = strtotime($lastSms['addDate']) + 5;
            $getLastSms      = $this->db->query("select * from smsMaster where babyId=".$lastSms['babyId']." and addDate between ".$sTime." and ".$eTime."")->result_array();
           }else{
            $getLastSms = [];
           }

            ?>
           <section class="col-lg-6 connectedSortable">
             <div class="boxSetting boxHeight">  
               <div class="row rowSize">
                 <div class="col-md-6" style="padding: 1px 5px 12px 18px;">
                       <span class="info textFormat">
                        <a href="<?php echo base_url();?>loungeM/updateLounge/<?php echo $value['loungeId'];?>">
                         <?php echo $value['loungeName']; ?>
                        </a>
                      </span><br>
                    
                     
                </div>
                <div class="col-md-6 text-right" style="padding: 10px 17px 15px 0px">
                   <span class="setLineHeight">Facility Name: </span>  
                     <?php if($getFacilityName['FacilityName'] != '') { ?>
                       <a href="<?php echo base_url();?>facility/updateFacility/<?php echo $value['facilityId'];?>"><?php echo $getFacilityName['FacilityName']; ?></a>
                      <?php } else { echo 'N/A'; } ?>
                  
                </div>
              </div>  
           <!--       </div> -->
                 <div class="info-box incode">
                      <div class="box-header with-border">
                        <h3 class="box-title" style="margin-left: 3px;">Total SMS Sent: <?php echo $countSMS;?></h3><br>
                        <span style="margin-left: 3px;">Last SMS sent at: <?php echo !empty($lastSms['addDate']) ? date('d-m-Y g:i A', strtotime($lastSms['addDate'])) : 'N/A'; ?></span>
                        <a href="<?php echo base_url('/smsM/sentSms/').$value['loungeId']; ?>" class="buttonSetting" style="margin-top: -20px;">
                        View All</a> 
                      </div>

                     <div class="box-body" style="height: 240px;overflow-y:auto;">
                      <?php $countDown = 1;
                      foreach ($getLastSms as $key => $value1) {
                        $getStaffData = $this->db->query("select * from staffMaster where staffMobileNumber=".$value1['sendTo']."")->row_array();
                            ?>
 
                        <div class="col-md-8">
                          <b><?php echo $countDown++; ?>-&nbsp;Doctor Name: </b><?php echo $getStaffData['name']; ?></div>
                        <div class="col-md-4"><b>Mobile No: </b> <?php echo $getStaffData['staffMobileNumber']; ?></div>
                      <br>
                    <?php } ?>
                    <div class="col-md-12" style="margin-top: 5px;"></div>
                    &nbsp;<b>Last Sent SMS:</b><br>
                        <div class="col-md-12">
                      <?php echo  $lastSms['message']; ?>
                      </div>
                     </div>
                 
                </div>
             </div>   
        </section>   
        
        <section class="col-lg-6 connectedSortable">       
            <div class="box box-success boxHeight">
                <div class="box-header with-border">
                 <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal<?php echo $value['loungeId']; ?>"><span class="fa fa-info-circle"></span></a> Total Sent SMS<?php echo ($value['loungeName'] != "") ? '('.$value['loungeName'].')' : ''; ?></h3>
                </div>
                <div class="box-body">
                <div class="chart<?php echo $value['loungeId']; ?>">
                <canvas id="barChart<?php echo $value['loungeId']; ?>" style="height:230px"></canvas>
                <ul class="fc-color-picker" id="color-chooser">
                    <li style="line-height: 0px;"><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Sent SMS (<?php echo $countSMS; ?>)</span></li> 
                  </ul>
               </div>
               </div>
            </div> 
        </section>  

  <div class="modal fade" id="myModal<?php echo $value['loungeId']; ?>" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Sent SMS (<?php echo $value['loungeName']; ?>)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of send SMS in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of send SMS.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of send SMS.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select sm.`id` from smsMaster as sm inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`='11'
           </li>
            <li><span style="color:#000;font-weight:bold">2. </span>select sm.`id` from smsMaster as sm inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`='11' and (sm.`addDate` BETWEEN (month start date time) AND (month end date time))</li>
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
                      $GetLM = $this->load->SmsModel->countingTOSMS($FirstDayTimeStamp,$LastDayTimeStamp,$value['loungeId']);
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
                      
                    $GetLM1 = $this->load->SmsModel->countingTOSMS($FirstDay_1,$LastDay_1,$value['loungeId']);
                    $GetLM2 = $this->load->SmsModel->countingTOSMS($FirstDay_2,$LastDay_2,$value['loungeId']);
                    $GetLM3 = $this->load->SmsModel->countingTOSMS($FirstDay_3,$LastDay_3,$value['loungeId']);
                    $GetLM4 = $this->load->SmsModel->countingTOSMS($FirstDay_4,$LastDay_4,$value['loungeId']);
                    $GetLM5 = $this->load->SmsModel->countingTOSMS($FirstDay_5,$LastDay_5,$value['loungeId']);    
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
      scaleShowGridLines: true,
      scaleGridLineColor: "rgba(0,0,0,.05)",
      scaleGridLineWidth: 1,
      scaleShowHorizontalLines: true,
      scaleShowVerticalLines: true,
      barShowStroke: true,
      barStrokeWidth: 2,
      barValueSpacing: 5,
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
