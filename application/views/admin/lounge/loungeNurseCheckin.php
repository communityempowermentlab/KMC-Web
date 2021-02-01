<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<style type="text/css">
   .ratingpoint{
    color: red;
    }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
  }
#example_filter label, .paging_simple_numbers .pagination {float: right;}
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php
       $ID      = $this->uri->segment(3);
       $Lounge  = $this->FacilityModel->GetLoungeById($ID);?>
      <h1><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Lounge Nurse Checkin'; ?>
      
      </h1>
      
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div class="" id="MDG"></div>
            <div class="box-body" >
              <div class="col-sm-12" style="overflow: auto;">
                <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example">
                <thead>
                   <tr>
                      <th>Sr.&nbsp;No.</th>
                      <th>Nurse</th>
                      <th>At&nbsp;The&nbsp;Time&nbsp;Of</th>
                      <th>Selfie</th>
                      <th>Date&nbsp;&&nbsp;Time</th>
                   </tr>
                </thead>
                <tbody>
                <?php 
                  $counter ="1";
                  foreach ($GetCheckinData as $value ) {
                  $loungePic = !empty($value['checkin']['selfie']) ? "<img src='".signDirectoryUrl.$value['checkin']['selfie']."' style='width:100px;height:100px;'' class='signatureSize'>" : 'N/A';
                  if(empty($value['checkin'])){
                    $dateTime  = '--';
                  } else{ 
                    if($value['checkin']['type'] == 1){
                      $dateTime  = !empty($value['checkin']['addDate']) ? '<a href="'.base_url().'loungeM/nurseCheckIn/'.$value['staffId'].'">'.date("F d ",strtotime($value['checkin']['addDate'])).'at '.date("h:i A",strtotime($value['checkin']['addDate'])).'</a>' : '--';
                    } else {
                      $dateTime  = !empty($value['checkin']['modifyDate']) ? '<a href="'.base_url().'loungeM/nurseCheckIn/'.$value['staffId'].'">'.date("F d ",strtotime($value['checkin']['modifyDate'])).'at '.date("h:i A",strtotime($value['checkin']['modifyDate'])).'</a>' : '--';
                    }
                  }
                ?>
                  <tr>
                     <td><?php echo $counter; ?></td>
                     <td><a href="<?php echo base_url();?>staffM/updateStaff/<?php echo $value['staffId'] ?>"><?php echo ucwords($value['name']); ?></td>
                     <td><?php if(empty($value['checkin'])) { echo 'Not Checkin Yet.'; } else if($value['checkin']['type'] == 1) { echo 'Checked In'; } else { echo 'Checked Out'; } ?></td>
                     <td><?php echo $loungePic; ?></td>
                     <td><?php echo $dateTime; ?></td>
                  </tr>  
                  <?php $counter ++ ; } ?>
                </tbody>
               </table>
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