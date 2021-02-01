<?php 
  $adminData  = $this->session->userdata('adminData');  
  $QuickEmail = $this->load->FacilityModel->getQuickEmail();
 ?>
 <style type="text/css">
   table tr td{
    border-top: 1px solid #f4e2e2 !important;
   }
 </style>
 <link rel="stylesheet" href="<?php echo base_url('assets/script/designScript.css'); ?>"> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lounge Wise All PDF 
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <section class="content">



      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
                  <?php
                    foreach ($totalLounges as $key => $val) {
                      $getFacilityName  = $this->db->query("select * from facilitylist where FacilityID='".$val['FacilityID']."'")->row_array();
                      
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
                               <span style="color: blue;font-size: 18px;"><?php echo $val['LoungeName']; ?> - </span>
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
                             $startDate    = strtotime(date($yearName.'-'.$monthName.'-01',strtotime($array[$i])));
                                $daycountViamonth = cal_days_in_month(CAL_GREGORIAN, $monthName, $yearName);
                                    // check the month are 30 or 31 or 28
                                     if($daycountViamonth == '28'){
                                       $endDate      = strtotime(date($yearName.'-'.$monthName.'-28',strtotime($array[$i])));
                                     }else  if($daycountViamonth == '29'){
                                        $endDate     = strtotime(date($yearName.'-'.$monthName.'-29',strtotime($array[$i])));
                                     }else if($daycountViamonth == '30'){
                                        $endDate     = strtotime(date($yearName.'-'.$monthName.'-30',strtotime($array[$i])));
                                     }else{
                                        $endDate     = strtotime(date($yearName.'-'.$monthName.'-31',strtotime($array[$i])));
                                     }
                                $query        = $this->db->query("select ba.*,ba.`status` as StatusDis from baby_admission as ba inner join babyRegistration as br on ba.`BabyID`= br.`BabyID` where ba.`LoungeID`=".$val['LoungeID']." and ba.`status`='2' and  ba.`add_date` between ".$startDate." and ".$endDate."")->num_rows();
                                 $query1        = $this->db->query("select ba.`BabyPDFFileName` from baby_admission as ba inner join babyRegistration as br on ba.`BabyID`= br.`BabyID` where ba.`LoungeID`=".$val['LoungeID']." and ba.`status`='2' and  ba.`add_date` between ".$startDate." and ".$endDate."")->result_array();
                      
                                 foreach ($query1 as $data) { ?>
                                      <a href="<?php echo base_url('assets/PdfFile/').$data['BabyPDFFileName'] ?>" download="<?php echo $data['BabyPDFFileName'] ?>" class="download_file<?php echo str_replace(' ','',$array[$i].'_'.$val['LoungeName']); ?>">
                                        <img src="<?php echo base_url('assets/PdfFile/').$data['BabyPDFFileName'] ?>" style="display: none;"></a>
                                <?php } ?>

                               
                          <tr>
                            <td><?php echo $array[$i]; ?></td>
                            <td>(<?php echo $query; ?> Files)</td>
                            <td><a href="<?php echo base_url('Admin/createzip/').$startDate.'/'.$endDate.'/'.$val['LoungeID']; ?>">Create zip</a></td>
                            <td><a href="#" id="<?php echo str_replace(' ','',$array[$i].'_'.$val['LoungeName']); ?>" class="demo">Download</a></td>
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
  </div>         
</body>
<script type="text/javascript">
  $(document).ready(function() { 
  $('.demo').click(function() {
      var id = $(this).attr('id');
      var downloadLink = "a.download_file"+id+" > img";

     // alert(downloadLink);
      $(downloadLink).each(function() {
        $(this).trigger( "click" );
      });
 
    return false; //cancel navigation
  });
});
</script>
</script>
</html>
