<?php 
  $adminData  = $this->session->userdata('adminData');  
  $QuickEmail = $this->load->FacilityModel->getQuickEmail();
 ?>
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
 <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

<table class="table table-bordered">
  <tr>
    <th>Sr no</th>
    <th>Lounge Name</th>
    <th>Status</th>
    <th>PDF Link</th>
    <th>Generate PDF</th>
  </tr>
            <?php
              $count=1;
              $count1=1;
             $query =  $this->db->query("select ba.*,ba.`status` as StatusDis from baby_admission as ba inner join babyRegistration as br on ba.`BabyID`= br.`BabyID` where ba.`LoungeID`='12' and ba.`status`='2' order by ba.`id` desc")->result_array(); 
             $getLounge  = $this->db->query("select * from lounge_master where LoungeID='12'")->row_array();
              foreach ($query as $key => $value) { ?>

              <tr>
                <td><?php //echo $count++; ?></td>
                <td><?php echo $getLounge['LoungeName']; ?></td>
                <td><?php echo $value['StatusDis']; ?></td>
                <td><a target="_blank" href="<?php echo base_url();?>assets/PdfFile/<?php echo $value['BabyDischargePdfName']; ?>">Download<?php echo $count++; ?></a></td>
                <td><a href="<?php echo base_url();?>FinalPdf/FinalpdfGenerate/<?php echo $value['LoungeID']; ?>/<?php echo $value['id']; ?>" class="btn btn-info btn-xs">DischargedPdf<?php echo $count1++; ?></a></td>
              </tr>

            <?php } ?>
</table>
  </div>         
      </div>
      </div>
 </section>
</body>
</html>
