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
      <h1><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Lounge Birth Review'; ?>
      
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
                      <th>Shift</th>
                      <th>Total&nbsp;Live&nbsp;Birth</th>
                      <th>Total&nbsp;Stable&nbsp;Babies</th>
                      <th>Total&nbsp;Unstable&nbsp;Babies</th>
                      <!-- <th>Latitude</th>
                      <th>Longitude</th> -->
                      <th>Review&nbsp;Date&nbsp;&&nbsp;Time</th>
                   </tr>
                </thead>
                <tbody>
                <?php 
                  $counter ="1";
                  foreach ($GetBirthReview as $value ) {
                  $getStaffDetails = $this->db->query("SELECT * from staffMaster where StaffID=".$value['nurseId']."")->row_array();
                  $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                ?>
                  <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo ucwords($getStaffDetails['name']); ?></td>
                     <td><?php if($value['shift'] == 1) { echo '8 AM - 2 PM'; } else if($value['shift'] == 2) { echo '2 PM - 8 PM'; } else { echo '8 PM - 8 AM'; } ?></td>
                     <td><?php echo $value['totalLiveBirth']; ?></td>
                     <td><?php echo $value['totalStableBabies']; ?></td>
                     <td><?php echo $value['totalUnstableBabies']; ?></td>
                     <!-- <td><?php echo $value['latitude']; ?></td>
                     <td><?php echo $value['longitude']; ?></td> -->
                     <td><a href="javascript:void(0);" class="tooltip"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
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