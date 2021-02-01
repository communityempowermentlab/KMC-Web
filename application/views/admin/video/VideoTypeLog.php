<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $index2; ?>
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
              <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example" id="" >
                <thead>


                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Video Type Name</th>                                
                  <th>Status</th>
                  <th>Date&nbsp;&&nbsp;Time</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                foreach ($videoType as $value) {
                  $last_updated          = $this->FacilityModel->time_ago_in_php($value['addDate']);
                ?>
                <tr id="update<?php echo $value['id'];?>">
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['videoTypeName']; ?></td>
                  <td>
                   <?php  
                    $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                    if ($value['status'] == 1) { ?> 
                      <span class="label label-success label-sm">
                        Activated
                      </span> 
                    <?php } else { ?>
                      <span class="label label-warning label-sm">
                        Deactivated
                      </span> 
                    <?php } ?>
                  </td>
                  <td><a class="tooltip" href="javascript:void(0);"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
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




