

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
                      <h5 class="content-header-title float-left pr-1 mb-0">Downoad PDF Report  </h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Downoad PDF Report  
                          </li>
                        </ol>
                      </div>
                    </div>
                    
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <?php
                    foreach ($totalLounges as $key => $val) {
                      $getFacilityName  = $this->db->query("select * from facilitylist where FacilityID='".$val['facilityId']."'")->row_array();
                      
                          $date1 = '2018-05-05';
                          $date2 = date("Y-m-d");

                          $ts1 = strtotime($date1);
                          $ts2 = strtotime($date2);

                          $year1 = date('Y', $ts1);
                          $year2 = date('Y', $ts2);

                          $month1 = date('m', $ts1);
                          $month2 = date('m', $ts2);

                          $diff = ((($year2 - $year1) * 12) + ($month2 - $month1)) + 1; 

                    ?>
                      <div class="row well">
                        <div style="border-bottom: 1px solid gray; width: 100%;">
                          <span style="color: blue;font-size: 18px;"><?php echo $val['loungeName']; ?> - </span>
                          <span><?php echo $getFacilityName['FacilityName']; ?></span>
                        </div>
                              
                        <table class="table" style="">
                          <?php
                              for ($i = 0; $i < $diff; $i++) {
                                $month=date("M Y", strtotime("-$i month"));
                                $array[]=$month;
                                $yearName     = date('Y',strtotime($array[$i])); 
                                $monthName    = date('m',strtotime($array[$i])); 
                                //echo date($yearName.'-'.$monthName.'-28',strtotime($array[$i]));exit;
                                $startDate    = date($yearName.'-'.$monthName.'-01',strtotime($array[$i]));
                                $daycountViamonth = cal_days_in_month(CAL_GREGORIAN, $monthName, $yearName);
                                    // check the month are 30 or 31 or 28
                                     if($daycountViamonth == '28'){
                                       $endDate      = date($yearName.'-'.$monthName.'-28',strtotime($array[$i]));
                                     }else  if($daycountViamonth == '29'){
                                        $endDate     = date($yearName.'-'.$monthName.'-29',strtotime($array[$i]));
                                     }else if($daycountViamonth == '30'){
                                        $endDate     = date($yearName.'-'.$monthName.'-30',strtotime($array[$i]));
                                     }else{
                                        $endDate     = date($yearName.'-'.$monthName.'-31',strtotime($array[$i]));
                                     } 
                                $query        = $this->db->query("select ba.*,ba.`status` as StatusDis from babyAdmission as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` where ba.`loungeId`=".$val['loungeId']." and ba.`status`='2' and  ba.`addDate` between '".$startDate."' and '".$endDate."'")->num_rows(); 
                                  ?>
                               
                          <tr>
                            <td><?php echo $array[$i]; ?></td>
                            <td>(<?php echo $query; ?> Files)</td>
                              <td>

                               <a href="<?php echo base_url('BabyManagenent/generateAllAdmissionPDF/').$startDate.'/'.$endDate.'/'.$val['loungeId']; ?>" <?php echo ($query == '0') ? 'style="pointer-events: none;"' : '' ?>>Create Admission PDF</a>
                            </td>
                            <td>
                              <a href="<?php echo base_url('Admin/createZipPdfReports/').$startDate.'/'.$endDate.'/'.$val['loungeId']; ?>" <?php echo ($query == '0') ? 'style="pointer-events: none;"' : '' ?>>Download</a>
                            </td>


                           
                          <!--   <a href="#" id="<?php //echo str_replace(' ','',$array[$i].'_'.$val['loungeName']); ?>" class="demo">Download</a> -->
                          </tr>
                      <?php }
                          echo'</table>';
                          echo'</div>'; 
                        } 
                      ?>
                        
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