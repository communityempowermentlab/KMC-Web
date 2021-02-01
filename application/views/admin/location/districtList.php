<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Revenue District'; ?> 
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
                  <th>State Name</th>                             
                  <th>State Code</th>
                  <th>PRI District Code</th>
                  <th>District Name</th>
                  <th>Block Count</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                  foreach ($GetList as $value) {
                    $getUrbanBlock = $this->LocationModel->getUrbanBlockByDistrict($value['PRIDistrictCode']);
                    $getRuralBlock = $this->LocationModel->getRuralBlockByDistrict($value['PRIDistrictCode']);
                ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['StateNameProperCase']; ?></td>
                  <td><?php echo $value['StateCode']; ?></td>
                  <td> <?php echo $value['PRIDistrictCode']; ?> </td>
                  <td><?php echo $value['DistrictNameProperCase']; ?></td>
                  <td><a href="<?php echo base_url() ?>Location/urbanBlock/<?php echo $value['PRIDistrictCode']; ?>">Urban (<?php echo count($getUrbanBlock); ?>)</a><br>
                      <a href="<?php echo base_url() ?>Location/ruralBlock/<?php echo $value['PRIDistrictCode']; ?>">Rural (<?php echo count($getRuralBlock); ?>)</a>
                  </td>
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




