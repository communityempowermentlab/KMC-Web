

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">






<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Statistics Report  </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Statistics Report  
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="col-12 row">
                          <div class="col-sm-5" style="margin-top: 20px;">
                            <button name="create_excel" id="create_excel" class="btn btn-sm btn-info coloring">Download Report</button>
                          </div>
                          <div class="col-sm-7">
                            <form class="form-horizontal" action="<?php echo site_url('Admin/statisticsReport');?>" method="POST" novalidate>
                              <div class="row">
                                <div class="col-sm-5 padding-left-right-5">
                                  <div class="form-group">
                                    <label>From:</label>
                                    <div class="controls">
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control pickadate-months-year" id="fromDate" value="<?= $fromDate; ?>" placeholder="Select From Date" name="fromDate" required="" data-validation-required-message="This field is required">
                                        <div class="form-control-position calendar-position">
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                      </fieldset>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-5 padding-left-right-5">
                                  <div class="form-group">
                                    <label>To:</label>
                                    <div class="controls">
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control pickadate-months-year" id="toDate" value="<?= $toDate; ?>" placeholder="Select To Date" name="toDate" required="" data-validation-required-message="This field is required">
                                        <div class="form-control-position calendar-position">
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                      </fieldset>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-2 padding-left-right-5" style="margin-top: 20px;">
                                  <button type="submit" class="btn btn-sm btn-primary" >Search</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                        <div class="table-responsive">
                          <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example" id="employee_table">

                            <thead class="nav-tabs">
                               <tr>
                                  <th>Lounge&nbsp;Name</th>
                                    <?php 

                                    $t2   = $date1;
                                    $t1   = $date2; 
                                    
                                    $begin = new DateTime($t1);
                                    $end = new DateTime($t2);

                                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                                    foreach ($daterange as $key => $date) {
                                      $dates[] = $date->format("Y-m-d");
                                    }

                                    $dates = array_reverse($dates);

                                    $number = 0;
                                    foreach($dates as $date){
                                       $alldate = $date;
                                       $t1 = date($alldate. ' 00:00:01');
                                       $t2 = date($alldate. ' 23:59:59');
                                       $Datefrom = strtotime($t1);
                                       $Dateto   = strtotime($t2);
                                        $startTimeStamp   = strtotime("2018/04/12");
                                        $endTimeStamp     = strtotime($t2);
                                        $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                                        $numberDays       = $timeDiff/86400; 
                                        $numberDays       = intval($numberDays);  
                                    ?>

                                        <th style="white-space: nowrap;">
                                         <?= $sendDate = date("d-m-Y",strtotime($date)); ?> 
                                        </th>
                                   
                                                             
                                    <?php } ?>
                               </tr>
                            </thead>
            

                            <tbody> 
                              <?php 
                                    $Startdate     = $date3;  
                                    $EndDate       = $date4;
                                    $DateStart     = $Startdate;
                                    $DateEnd       = $EndDate;
                                ?>
                                
                                  <?php foreach ($Getlounge as $key=> $value) {   
                                    $CountingMother    = count($this->db->query("select * from motherRegistration as mr left join motherAdmission as ma on ma.`motherId`=mr.`motherId` where ma.`loungeId`=".$value['loungeId']." and (mr.`addDate` between '".$DateStart."' and '".$DateEnd."')")->result_array()); 

                                  ?>
                                   <tr> <td><b><?php echo $value['loungeName'].' Mother<br>'; ?>  
                                         <?php echo 'Total: '.$CountingMother; ?> </b></td> 
                                  <?php 
                                   

                                    $CountingBaby     = count($this->db->query("select * from babyRegistration as br left join babyAdmission as ba on br.`babyId`=ba.`babyId` where ba.`loungeId`=".$value['loungeId']." and (br.`addDate` between '".$DateStart."' and '".$DateEnd."')")->result_array()); 


                                    $number = 0;
                                    foreach($dates as $date){ 
                                       $alldate = $date;
                                       $t1 = date($alldate. ' 00:00:01'); 
                                       $t2 = date($alldate. ' 23:59:59'); 
                                       $Datefrom = $t1;
                                       $Dateto   = $t2;
                                        $startTimeStamp   = strtotime("2018/04/12");
                                        $endTimeStamp     = strtotime($t2);
                                        $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                                        $numberDays       = $timeDiff/86400; 
                                        $numberDays       = intval($numberDays);  
                                    
                                
                                        $GetMother    = count($this->db->query("select * from motherRegistration as mr left join motherAdmission as ma on ma.`motherId`=mr.`motherId` where ma.`loungeId`=".$value['loungeId']." and (mr.`addDate` between '".$Datefrom."' and '".$Dateto."')")->result_array()); 
                                                                    
                                     ?>
                                        <td><?php 
                                          if($GetMother == '0'){
                                            echo $GetMother;
                                          }else{
                                            echo "<a href='".base_url('Admin/dateWiseMother/').$value['loungeId'].'/'. $sendDate."'>".$GetMother."</a>";
                                          }
                                         ?></td>
                                        
                                          <?php }
                                            
                                          ?>

                                      </tr>    
                                      <tr> <td><b><?php echo $value['loungeName'].' Baby<br>'; ?>
                                          <?php echo 'Total: '.$CountingBaby; ?> </b> </td> 
                                    <?php  
                                      foreach($dates as $date){ 
                                       $alldate = $date;
                                       $t1 = date($alldate. ' 00:00:01');
                                       $t2 = date($alldate. ' 23:59:59');
                                       $Datefrom = $t1;
                                       $Dateto   = $t2;
                                        $startTimeStamp   = strtotime("2018/04/12");
                                        $endTimeStamp     = strtotime($t2);
                                        $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                                        $numberDays       = $timeDiff/86400; 
                                        $numberDays       = intval($numberDays);  
                                          $maxData = array();
                                         for($i = 0;  $i < count($Getlounge); $i++){
                                               $Getbaby = count($this->db->query("select * from babyRegistration as br left join babyAdmission as ba on br.`babyId`=ba.`BabyId` where ba.`LoungeId`=".$Getlounge[$i]['loungeId']." and (br.`addDate` between '".$Datefrom."' and '".$Dateto."')")->result_array()); 
                                               
                                               $maxData[] = $Getbaby;
                                         }

                                         $Getbaby = count($this->db->query("select * from babyRegistration as br left join babyAdmission as ba on br.`babyId`=ba.`BabyId` where ba.`LoungeId`=".$value['loungeId']." and (br.`addDate` between '".$Datefrom."' and '".$Dateto."')")->result_array());

                                    ?>

                                      <?php 
                                            $temp =  max($maxData);
                                            if($temp == $Getbaby && $temp != 0){
                                             echo "<td style='color:black;background:yellow;' temp='".$temp."'><a href='".base_url('Admin/dateWiseBaby/').$value['loungeId'].'/'. $sendDate."'>".$temp."</a></span></td>";
                                           }else{
                                             if($Getbaby == 0){
                                              echo "<td temp='".$temp."'>".$Getbaby."</td>";
                                             }else{
                                              echo "<td temp='".$temp."'><a href='".base_url('Admin/dateWiseBaby/').$value['loungeId'].'/'. $sendDate."'>".$Getbaby."</a></td>";
                                             }
                                           }
                                          ?>
                                       <?php } ?>
                                      </tr>                        
                                   
                                    <?php } ?>
                                
                              
                            </tbody>

                          </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

<script>  
$(document).ready(function(){  
  $('#create_excel').click(function(){ 
    var s_url = '<?php echo base_url('Admin/generateStatisticsReportExcel?date1='.$date1.'&date2='.$date2.'&date3='.$date3.'&date4='.$date4); ?>'; 
    window.location.href = s_url;
  });
});   
</script>  