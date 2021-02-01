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
  
      
      <h1><?php echo 'Duty Change History'; ?> </h1>
      
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
                      <th>Nurse&nbsp;Name</th>
                      <th>At&nbsp;The&nbsp;Time&nbsp;of</th>
                      <th>Selfie</th>
                      <th>Room&nbsp;Temperature</th>
                      <th>Food&nbsp;Assessment</th>
                      <th>Cleanliness</th>
                      <th>Comment</th>
                      <th>Nurse&nbsp;Sign</th>
                      <th>Date&nbsp;Time</th>
                      
                   </tr>
                </thead>
                <tbody>
                 <?php 
                 $counter ="1";
                 foreach ($getDutyHistory as $value ) {
                   $getStaffName = $this->db->get_where('staffMaster',array('staffId'=>$value['nurseId']))->row_array();
                   // type 1-CheckIn and 2-CheckOut
                   if($value['type'] == '1'){
                     $loungePic = !empty($value['selfie']) ? "<img src='".signDirectoryUrl.$value['selfie']."' style='width:100px;height:100px;'' class='signatureSize'>" : 'N/A';
                     $nurseSign = !empty($value['nurseSign']) ? "<img src='".signDirectoryUrl.$value['nurseSign']."' style='width:100px;height:100px;'' class='signatureSize'>" : 'N/A';
                     $dateTime  = !empty($value['addDate']) ? date("d-m-Y g:i A", strtotime($value['addDate'])) : '--';
                   }else{
                     $loungePic = !empty($value['selfie']) ? "<img src='".signDirectoryUrl.$value['selfie']."' style='width:100px;height:100px;'' class='signatureSize'>" : 'N/A';
                     $nurseSign = !empty($value['nurseSignCheckOut']) ? "<img src='".signDirectoryUrl.$value['nurseSignCheckOut']."' style='width:100px;height:100px;'' class='signatureSize'>" : 'N/A';
                     $dateTime  = !empty($value['checkOutTime']) ? date("d-m-Y g:i A", strtotime($value['checkOutTime'])) : '--';
                   }
                 ?> 
                   <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo !empty($getStaffName['name']) ? "<a href='".base_url()."staffM/updateStaff/".$value['nurseId']."'>".$getStaffName['name']."</a>" : '--'; ?></td>
                     <td><?php echo ($value['type'] == 1) ? 'Checked In' : 'Checked Out'; ?></td>
                     <td><?php echo $loungePic; ?></td>
                     <td><?php echo !empty($value['roomTemperature']) ? $value['roomTemperature'] : 'N/A'; ?></td>
                     <td><?php echo !empty($value['foodAssessment']) ? $value['foodAssessment'] : 'N/A'; ?></td>
                     <td><?php echo !empty($value['cleanliness']) ? $value['cleanliness'] : 'N/A'; ?></td>
                     <td><?php echo !empty($value['comment']) ? $value['comment'] : 'N/A'; ?></td>
                     <td><?php echo $nurseSign; ?></td>
                     <td><?php echo $dateTime; ?></td>
                     
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

