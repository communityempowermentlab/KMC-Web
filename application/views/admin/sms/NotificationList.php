<?php
  $loungeId      = $this->uri->segment('3');
  $GetFacility   = $this->FacilityModel->GetFacilitiesID($loungeId);
?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Notification Center'; ?> (<?php echo $GetFacility['loungeName']; ?>)</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="row" style="padding-right: 25px; padding-left: 25px;margin-top: 5px;">
            <div class="col-md-6">
             <span style="font-size: 20px;">Manage Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
                <?php if(isset($totalResult)) { 
                    ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                    echo '<br>Showing '.$counter.' to '.((($pageNo*100)-100) + 100).' of '.$totalResult.' entries';
                 } ?>
             </div> 
             <div class="col-md-6">
                <form action="" method="GET">
                    <div class="input-group pull-right">
                        <input type="text" class="form-control" placeholder="Enter Keyword Value" 
                               name="keyword" value="<?php
                               if (!empty($_GET['keyword'])) {
                                   echo $_GET['keyword'];
                               }
                               ?>">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </span>

                    </div>
                     <br><span style="font-size:12px;">Search via: Mother Name, Message etc.</span>
                </form>
             </div>
            </div> 
            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Type&nbsp;Of&nbsp;Notification</th>
                  <th>Mother&nbsp;Name</th>
                  <th>Message&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </th>
                  <th>Last&nbsp;Assessment&nbsp;Date&nbsp;&&nbsp;Time</th> 
                  <th>Notification&nbsp;Date</th> 
                  <th>Status</th> 
                  <th>Perform&nbsp;Date&nbsp;&&nbsp;Time</th> 
                </tr>
                </thead>
                <tbody>

                <?php 
                ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                foreach ($results as $value) {
                  $LoungeName = $this->load->SmsModel->GetLoungeById($value['loungeId']);
                  ?>
                <tr>
                   <td><?php echo $counter;?></td>
                   <td>
                    <?php if($value['typeOfNotification']=='1'){
                              echo"Mother Monitoring";
                          } else if($value['typeOfNotification']=='2'){
                              echo"Baby Monitoring";
                          }else if($value['typeOfNotification']=='3'){
                              echo"Food Notification";
                          }else if($value['typeOfNotification']=='4'){
                              echo"Room Notification";
                          }else if($value['typeOfNotification']=='5'){
                              echo"Lounge Notification";
                          }else if($value['typeOfNotification']=='6'){
                              echo"Duty Notification";
                          }
                    ?>
                  </td>
                   <?php 
                     if($value['typeOfNotification']=='1'){
                        $MotherName = $this->load->SmsModel->getMotherDataById('motherRegistration',$value['motherId']);?>
                        <?php if($MotherName['motherName']==''){?>
                            <td>N/A</td>
                          <?php } else{?>
                              <td><a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName['motherId'] ;?>"><?php echo $MotherName['motherName'] ;?></a></td>
                    <?php } } else if($value['typeOfNotification']=='2') {
                         $getMotherID = $this->load->SmsModel->getBabyById($value['babyId']);
                         $MotherName2 = $this->load->SmsModel->getMotherDataById('motherRegistration',$getMotherID['motherId']);
                       ?>
                       <?php if($MotherName2['motherName']==''){?>
                            <td>N/A</td>
                          <?php } else{?>
                         <td><a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName2['motherId'] ;?>"><?php echo $MotherName2['motherName'] ;?></a></td>
                     <?php } } else if($value['typeOfNotification']=='3'|| $value['typeOfNotification']=='4' || $value['typeOfNotification']=='5'|| $value['typeOfNotification']=='6') { ?>
                    <td>N/A</td>
                    <?php } ?>
                   <td>
                        <?php if($value['typeOfNotification']=='1'){?>
                            <img src="<?php echo base_url();?>assets/images/Mother-Dashboard.png" style="width:20px;height:20px;">
                       <?php } else if($value['typeOfNotification']=='2'){ ?>
                            <img src="<?php echo base_url();?>assets/images/Child-Dashboard.png" style="width:20px;height:20px;">
                       <?php } else {?>
                            <img src="<?php echo base_url();?>assets/images/Lounge-Dashboard.png" style="width:20px;height:20px;">
                        <?php } ?>
                    <?php echo $value['message'] ;?>

                  </td>
                   <td><?php if($value['lastAssessmentDate']=='0000-00-00') {
                          echo $value['lastAssessmentDate'];?>&nbsp; <?php echo date('g:i A', strtotime($value['lastAssessmentTime'])); ?><?php 
                       }elseif($value['lastAssessmentDate']==''){
                        echo"N/A";
                       }
                       else{

                        echo $new_date = date('d-m-Y', strtotime($value['lastAssessmentDate'])); ?>&nbsp;<?php echo date('g:i A', strtotime($value['lastAssessmentTime']));?>
                       <?php } ?>
                   </td>
                   <td>
                    <?php echo date("d-m-Y g:i A",$value['addDate']);?>
                  </td>

                   <td>
                      <?php 
                         if($value['status']=='1'){
                          echo "<span class='label label-warning'>Pending</span>";
                         }else if($value['status']=='2'){
                          echo "<span class='label label-success'>Done</span>";
                         }else{
                          echo "<span class='label label-danger'>Undone</span>";
                         }
                       ?>
                    
                   </td>

                   <td> <?php echo (($value['status']=='1' && $value['status']=='') ? 'N/A' : ($value['status']=='2') ? (!empty($value['modifyDate']) ? date('d-m-Y g:i A',$value['modifyDate']) : 'N/A' ): (!empty($value['modifyDate']) ? date('d-m-Y g:i A',$value['modifyDate']) : 'N/A' )); ?></td>
                </tr>
                  <?php  $counter ++ ; } ?>
                </tbody>
               </table>
                   <ul class="pagination pull-right">
                    <?php
                      foreach ($links as $link) {
                          echo "<li>" . $link . "</li>";
                      }
                     ?>
                  </ul>
               </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md" style="width:800px !important">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Notification Functional Diagram</h4>
        </div>
        <div class="modal-body text-center" >
     
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ntfunctional.png') ;?>" style="height:450px;width:100%;">   
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-md" style="width:800px !important">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Notification DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body text-center" style="padding:0px !important;">
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/notificationDFD.png') ;?>" style="height:600px;width:100%;"> 
        </div>
      </div>
    </div>
  </div>

