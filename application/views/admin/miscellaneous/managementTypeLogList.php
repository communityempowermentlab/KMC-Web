<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Management Type Log'; ?>
      
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="" id="MDG"></div>
            <div class="box-body">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                <thead>


                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Name</th>      
                  <th>Status</th>                        
                  <th>Date&nbsp;&&nbsp;Time</th>
                  <th>Added&nbsp;By</th>
                  <th>IP&nbsp;Address</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                  foreach ($GetLog as $value) {
                     $addedBy = $this->load->UserModel->GetDataById('adminMaster',$value['addedBy']);
                ?>
                <tr id="update<?php echo $value['id'];?>">
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td>
                      <?php $status = ($value['status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                      if($value['status'] =='1'){?>
                            <span class="label label-success label-sm">Activated
                            </span>
                      <?php } else { ?>
                             <span class="label label-warning label-sm">
                              Deactivated  
                             </span>
                      <?php } ?>
                  </td>
                  <td><?php echo date("F d ",strtotime($value['addDate'])).'at '.date("h:i A",strtotime($value['addDate'])); ?></td>
                  <td><?php echo ucwords($addedBy['name']);?></td>
                  <td><?php echo $value['ipAddress']?></td>
                </tr>
                  <?php $counter ++ ; } ?>
                </tbody>
               </table>
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






