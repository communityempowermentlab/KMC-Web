<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'States'; ?> 
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
                  <th>State Code</th>
                  <th>Census Code 2001</th>
                  <th>Census Code 2011</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                  foreach ($GetList as $value) {
                    
                ?>
                <tr id="update<?php echo $value['id'];?>">
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['stateName']; ?></td>
                  <td><?php echo $value['stateCode']; ?></td>
                  <td> <?php echo $value['censusCode2001']; ?> </td>
                  <td><?php echo $value['censusCode2011']; ?></td>
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




