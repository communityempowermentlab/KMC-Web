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
       $ID = $this->uri->segment(3);
       $getStaffName = $this->db->get_where('staffMaster',array('staffId'=>$staff_id))->row_array();
       //$Lounge  = $this->FacilityModel->GetLoungeById($ID);?>
      <h1><?php echo $getStaffName['name'];?>&nbsp;<?php echo 'Login History'; ?>
      
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
                      <th>Device&nbsp;ID</th>
                      <th>Login&nbsp;Date&nbsp;&&nbsp;Time</th>
                      <th>Logout&nbsp;Date&nbsp;&&nbsp;Time</th>
                      
                   </tr>
                </thead>
                <tbody>
                 <?php 
                 $counter ="1";
                 foreach ($GetLoungeHistory as $value ) {
                    ?>
                   <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo $value['deviceId']; ?></td>
                     <td><?php echo $date=date("d-m-Y g:i A", strtotime($value['loginTime'])); ?></td>
                     <td><?php $date1=$value['logoutTime']; 
                     echo (!empty($date1) ? date("d-m-Y g:i A", strtotime($date1)) : '--'); ?></td>
                     
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

