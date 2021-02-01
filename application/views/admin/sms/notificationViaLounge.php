<style type="text/css">
  .setLeftMargin{
    margin-left: 20px !important;
  }
</style>
<link rel="stylesheet" href="<?php echo base_url('assets/script/designScript.css'); ?>"> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Lounge Wise Notification
        </h1>
   </section>
    <!-- Main content -->
    <section class="content">  
      <div class="row">
           <?php 

                function time_elapsed_string($datetime, $full = false) {
                  $now = new DateTime;
                  $ago = new DateTime($datetime);
                  $diff = $now->diff($ago);

                  $diff->w = floor($diff->d / 7);
                  $diff->d -= $diff->w * 7;

                  $string = array(
                      'y' => 'year',
                      'm' => 'month',
                      'w' => 'week',
                      'd' => 'day',
                      'h' => 'hour',
                      'i' => 'minute',
                      's' => 'second',
                  );
                  foreach ($string as $k => &$v) {
                      if ($diff->$k) {
                          $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                      } else {
                          unset($string[$k]);
                      }
                  }

                  if (!$full) $string = array_slice($string, 0, 1);
                  return $string ? implode(', ', $string) . ' ago' : 'just now';
                }
           foreach($totalLounges as $key => $value) {
            $getFacilityName     = $this->SmsModel->GetFacilityName($value['facilityId']);
            $countNotification   = $this->SmsModel->getNotificationData('1',$value['loungeId']);
            $lastNotification    = $this->SmsModel->getNotificaitonLastDateTime($value['loungeId']);
            $pending             = $this->SmsModel->notificationViaType('1',$value['loungeId']);
            $done                = $this->SmsModel->notificationViaType('2',$value['loungeId']);
            $undone              = $this->SmsModel->notificationViaType('3',$value['loungeId']);
            $getAllPending       = $this->SmsModel->getPending($value['loungeId']);
            ?>
           <section class="col-lg-6 connectedSortable">
             <div class="boxSetting boxHeight">  
               <div class="row rowSize">
                 <div class="col-md-7" style="padding: 1px 5px 12px 18px;">
                       <span class="info textFormat">
                        <a href="<?php echo base_url();?>loungeM/updateLounge/<?php echo $value['loungeId'];?>">
                         <?php echo $value['loungeName']; ?>
                        </a>
                      </span><br>
                     
                     <div style="margin-top: 6px;">
                   </div>
                 
                </div>
                <div class="col-md-5 text-right" style="padding: 10px 17px 15px 0px">
                  <span class="setLineHeight">Facility Name: </span>  
                     <?php if($getFacilityName['FacilityName'] != '') { ?>
                       <a href="<?php echo base_url();?>facility/updateFacility/<?php echo $value['facilityId'];?>"><?php echo $getFacilityName['FacilityName']; ?></a>
                      <?php } else { echo 'N/A'; } ?>
                  
                </div>
              </div>  
           <!--       </div> -->
                 <div class="info-box incode">
                      <div class="box-header with-border">
                        <h3 class="box-title" style="margin-left: 3px;">Total Notification Sent: <?php echo $countNotification;?></h3><br>
                        <span style="margin-left: 3px;">Last Notification sent at: <?php echo !empty($lastNotification['addDate']) ? date('d-m-Y g:i A',$lastNotification['addDate']) : 'N/A'; ?></span>
                        <a href="<?php echo base_url('/smsM/notificationCenter/').$value['loungeId']; ?>" class="buttonSetting" style="margin-top: -20px;">
                        View All</a> 
                      </div>

                      <div class="box-header with-border">
                        <div class="setLeftMargin">
                          <div class="col-md-4" style="margin:0px; padding: 0px;"><b>Pending: </b><?php echo $pending; ?></div>
                          <div class="col-md-4"><b>Done: </b> <?php echo $done; ?></div>
                          <div class="col-md-4"><b>Undone: </b> <?php echo $undone; ?></div>
                        </div>
                      </div>

                     <div class="box-body" style="height: 192px;overflow-y:auto;">

                      <?php $countDown = 1;

                      foreach ($getAllPending as $key => $value1) {
                       ?>
                      <div class="setLeftMargin">
                       <div class="col-md-12" style="margin:0px; padding: 0px;">
                          <b><?php if($value1['typeOfNotification']=='1'){?>
                            <img src="<?php echo base_url();?>assets/images/Mother-Dashboard.png" style="width:20px;height:20px;">
                       <?php } else if($value1['typeOfNotification']=='2'){ ?>
                            <img src="<?php echo base_url();?>assets/images/Child-Dashboard.png" style="width:20px;height:20px;">
                       <?php } else {?>
                            <img src="<?php echo base_url();?>assets/images/Lounge-Dashboard.png" style="width:20px;height:20px;">
                        <?php } ?>

                          &nbsp;</b><?php echo $value1['Messege']; ?><br>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo time_elapsed_string('@'.$value1['addDate']); ?>
                        </div>
                      </div><br>
                    <?php } ?>
                      
                     </div>
                 
                </div>
             </div>   
        </section>   
            <section class="col-lg-6 connectedSortable">       
                <div class="box box-success boxHeight">
                    <div class="box-header with-border">
                     <h3 class="box-title"><a href="" data-toggle="modal" data-target="#myModal<?php echo $value['loungeId']; ?>"><span class="fa fa-info-circle"></span></a> Total Sent Notification<?php echo ($value['loungeName'] != "") ? '('.$value['loungeName'].')' : ''; ?></h3>
                    </div>
                    <div class="box-body">
                    <div class="chart<?php echo $value['loungeId']; ?>">
                    <canvas id="barChart<?php echo $value['loungeId']; ?>" style="height:230px"></canvas>
                    <ul class="fc-color-picker" id="color-chooser">
                        <li style="line-height: 0px;"><a href="#" style="font-size:15px;color:#228B22;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Done (<?php echo $done; ?>)</span></li> 
                        <li style="line-height: 0px;"><a href="#" style="font-size:15px;color:#FF6347;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Undone (<?php echo $undone; ?>)</span></li> 
                    </ul>
                   </div>
                   </div>
                </div> 
            </section>  

  <div class="modal fade" id="myModal<?php echo $value['loungeId']; ?>" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header btn-primary" style="padding:7px;">
          <h4 class="modal-title text-center" style="color:#fff;">Sent Notification (<?php echo $value['LoungeName']; ?>)</h4>
        </div>
        <div class="modal-body">
          <b>Specification:</b>
          <ul class="listitem">
            Number of send Notification in last 6 months.
          </ul>

          <b>Color:</b>
          <ul class="listitem">
              <li><a class="" href="#" style="font-size:15px;color:#228B22;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of done notification.</span></li> 
              <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">&nbsp;Number of undone notification.</span></li> 
          </ul>

          <b>X-Axis:</b>
          <ul class="listitem">
            Last 6 months in MMM YYYY format.
          </ul>

          <b>Y-Axis:</b>
          <ul class="listitem">
            Number of send Notification.
          </ul>

          <b>Database query:</b>
          <ul class="listitem">
            <li><span style="color:#000;font-weight:bold">1. </span>select * from notification where `loungeId`='11' and `Status`='2' and (AddDate BETWEEN (month start date time) AND (month end date time))
           </li>
            <li><span style="color:#000;font-weight:bold">2. </span>select * from notification where `loungeId`='11' and `Status`='3' and (AddDate BETWEEN (month start date time) AND (month end date time))</li>
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

                    $doneNotif      = $this->load->SmsModel->countingNotificationViaMonth('1',$FirstDayTimeStamp,$LastDayTimeStamp,$value['loungeId']);
                    $doneNotif1     = $this->load->SmsModel->countingNotificationViaMonth('1',$FirstDay_1,$LastDay_1,$value['loungeId']);
                    $doneNotif2     = $this->load->SmsModel->countingNotificationViaMonth('1',$FirstDay_2,$LastDay_2,$value['loungeId']);
                    $doneNotif3     = $this->load->SmsModel->countingNotificationViaMonth('1',$FirstDay_3,$LastDay_3,$value['loungeId']);
                    $doneNotif4     = $this->load->SmsModel->countingNotificationViaMonth('1',$FirstDay_4,$LastDay_4,$value['loungeId']);
                    $doneNotif5     = $this->load->SmsModel->countingNotificationViaMonth('1',$FirstDay_5,$LastDay_5,$value['loungeId']);    

                    $undoneNotific  = $this->load->SmsModel->countingNotificationViaMonth('2',$FirstDayTimeStamp,$LastDayTimeStamp,$value['loungeId']);
                    $undoneNotific1 = $this->load->SmsModel->countingNotificationViaMonth('2',$FirstDay_1,$LastDay_1,$value['loungeId']);
                    $undoneNotific2 = $this->load->SmsModel->countingNotificationViaMonth('2',$FirstDay_2,$LastDay_2,$value['loungeId']);
                    $undoneNotific3 = $this->load->SmsModel->countingNotificationViaMonth('2',$FirstDay_3,$LastDay_3,$value['loungeId']);
                    $undoneNotific4 = $this->load->SmsModel->countingNotificationViaMonth('2',$FirstDay_4,$LastDay_4,$value['loungeId']);
                    $undoneNotific5 = $this->load->SmsModel->countingNotificationViaMonth('2',$FirstDay_5,$LastDay_5,$value['loungeId']);   

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
          data: [<?php echo $doneNotif5;?>, <?php echo $doneNotif4;?>, <?php echo $doneNotif3;?>, <?php echo $doneNotif2;?>, <?php echo $doneNotif1;?>, <?php echo $doneNotif;?>]
        },
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $undoneNotific5;?>, <?php echo $undoneNotific4;?>, <?php echo $undoneNotific3;?>, <?php echo $undoneNotific2;?>, <?php echo $undoneNotific1;?>, <?php echo $undoneNotific;?>]
        }
      ]
    };
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas<?php echo $value['loungeId']; ?> = $("#barChart<?php echo $value['loungeId']; ?>").get(0).getContext("2d");
    var barChart<?php echo $value['loungeId']; ?>       = new Chart(barChartCanvas<?php echo $value['loungeId']; ?>);
    var barChartData<?php echo $value['loungeId']; ?>   = areaChartData<?php echo $value['loungeId']; ?>;
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].fillColor = "#228B22";
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].strokeColor = "#228B22";
    barChartData<?php echo $value['loungeId']; ?>.datasets[0].pointColor = "#228B22";

    barChartData<?php echo $value['loungeId']; ?>.datasets[1].fillColor = "#FF6347";
    barChartData<?php echo $value['loungeId']; ?>.datasets[1].strokeColor = "#FF6347";
    barChartData<?php echo $value['loungeId']; ?>.datasets[1].pointColor = "#FF6347";

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
