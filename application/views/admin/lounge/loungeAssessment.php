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
      <h1><?php echo $Lounge['loungeName'];?>&nbsp;<?php echo 'Lounge Assessment'; ?>
      
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
                      <!-- <th>Lounge&nbsp;Picture</th> -->
                      <th>Mother&nbsp;Permission</th>
                      <th>Lounge&nbsp;Temperature</th>
                      <th>Lounge&nbsp;Thermometer&nbsp;Condition</th>
                      <th>Lounge&nbsp;Safety</th>
                      <th>Toilet&nbsp;Condition</th>
                      <th>Washroom&nbsp;Condition</th>
                      <th>Common&nbsp;Area&nbsp;Condition</th>
                      <!-- <th>Latitude</th>
                      <th>Longitude</th> -->
                      <th>Assessment&nbsp;Date&nbsp;&&nbsp;Time</th>
                      
                   </tr>
                </thead>
                <tbody>
                <?php 
                  $counter ="1";
                  foreach ($GetAssessment as $value ) {
                    $url = loungeDirectoryUrl.$value['loungePicture'];
                    $getStaffDetails = $this->db->query("SELECT * from staffMaster where StaffID=".$value['nurseId']."")->row_array();
                    $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                ?>
                  <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo ucwords($getStaffDetails['name']); ?></td>
                     <!-- <td><img src="<?php echo loungeDirectoryUrl; ?><?php echo $value['loungePicture']; ?>" width="160" height="120" style="border: 1px solid #e3dfdf;"></td> -->
                     <td><?php if($value['motherPermission'] == 1) { ?> Permission Taken. <span onmouseover="showImage('<?= $url ?>')"><i class="fa fa-paperclip" aria-hidden="true"></i></span><?php } else { echo 'Permission Not Taken'; } ?></td>
                     <td><?php echo $value['loungeTemperature']; ?></td>
                     <td><?php if($value['loungeThermometerCondition'] == 1) { echo 'Working'; } else { echo 'Not Working'; } ?></td>
                     <td><?php if($value['loungeSafety'] == 1) { echo 'Safe'; } else { echo 'Unsafe'; } ?></td>
                     <td><?php if($value['toiletCondition'] == 1) { echo 'Good'; } else { echo 'Not Good'; } ?></td>
                     <td><?php if($value['washroomCondition'] == 1) { echo 'Maintained'; } else { echo 'Not Maintained'; } ?></td>
                     <td><?php if($value['commonAreaCondition'] == 1) { echo 'Maintained'; } else { echo 'Not Maintained'; } ?></td>
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

  <!-- Image Modal -->
  <div id="myModal" class="modal showImgOnHover">
    <span class="close" data-dismiss="modal">&times;</span>
    <img class="modal-content" id="img01">
  </div>


  <script>

    function showImage(url){
      $('#img01').attr('src',url);
      $('#myModal').modal('show');
    }
  </script>