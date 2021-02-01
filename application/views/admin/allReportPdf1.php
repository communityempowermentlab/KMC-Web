
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
            
                $date1 = '2018-04-01';
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
                  $startDate = strtotime(date('Y-m-01',strtotime($array[$i])));
                  $endDate = strtotime(date('Y-m-30',strtotime($array[$i])));
                  $query =  $this->db->query("select ba.*,ba.`status` as StatusDis from baby_admission as ba inner join babyRegistration as br on ba.`BabyID`= br.`BabyID` where ba.`LoungeID`=".$val['LoungeID']." and ba.`status`='2' and  ba.`add_date` between ".$startDate." and ".$endDate."")->num_rows();
                 ?>
            <tr>
              <td><?php echo $array[$i]; ?></td>
              <td>(<?php echo $query;//date('Y-m',strtotime($array[$i])); ?> Files)</td>
              <td><a href="#<?php //echo base_url();?>">Download</a></td>

            </tr>

            <?php    }
            echo'</table>';

             echo'</div>';   

 }
           //  $query =  $this->db->query("select ba.*,ba.`status` as StatusDis from baby_admission as ba inner join babyRegistration as br on ba.`BabyID`= br.`BabyID` where ba.`LoungeID`='15' and ba.`status`='2' order by ba.`id` desc")->result_array(); 
            // $getLounge  = $this->db->query("select * from lounge_master where LoungeID='15'")->row_array();
              //foreach ($query as $key => $value) {
               ?>

       <!--        <tr>
                <td><?php //echo $count++; ?></td>
                <td><?php echo $getLounge['LoungeName']; ?></td>
                <td><?php echo $value['StatusDis']; ?></td>
                <td><a target="_blank" href="<?php echo base_url();?>assets/PdfFile/<?php echo $value['BabyDischargePdfName']; ?>">Download<?php echo $count++; ?></a></td>
                <td><a href="<?php echo base_url();?>FinalPdf/FinalpdfGenerate/<?php echo $value['LoungeID']; ?>/<?php echo $value['id']; ?>" class="btn btn-info btn-xs">DischargedPdf<?php echo $count1++; ?></a></td>
              </tr> -->
         



              </div>
            </div>
          </div>
        </div>
      </div>
    </section>





  </div>         

</body>
</html>
