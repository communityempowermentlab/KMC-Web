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
      <h1><?php echo $GetStaffData['name'];?>&nbsp;<?php echo ' Nurse Checkin'; ?></h1>
      
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
                      <th>At&nbsp;The&nbsp;Time&nbsp;Of</th>
                      <th>Selfie</th>
                      <th>Date&nbsp;&&nbsp;Time</th>
                   </tr>
                </thead>
                <tbody>
                <?php 
                  $counter ="1";
                  foreach ($GetCheckinData as $value ) {
                  $loungePic = !empty($value['selfie']) ? "<img src='".signDirectoryUrl.$value['selfie']."' style='width:100px;height:100px;'' class='signatureSize'>" : 'N/A';
                  if($value['type'] == 1) {
                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                    $generated_on_txt = '<a href="javascript:void(0);" class="tooltip">'.$generated_on.'<span class="tooltiptext">'.date("m/d/y, h:i A",strtotime($value['addDate'])).'</span></a>';
                    $dateTime  = !empty($value['addDate']) ? $generated_on_txt : '--';
                  } else {
                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);
                    $generated_on_txt = '<a href="javascript:void(0);" class="tooltip">'.$generated_on.'<span class="tooltiptext">'.date("m/d/y, h:i A",strtotime($value['modifyDate'])).'</span></a>';
                    $dateTime  = !empty($value['modifyDate']) ? $generated_on_txt : '--';
                  }
                ?>
                  <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php if($value['type'] == 1) { echo 'Checked In'; } else { echo 'Checked Out'; } ?></td>
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