<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Revenue Rural Block'; ?> 
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
                  <th>PRI District Code</th>
                  <th>District Name</th>
                  <th>PRI Block Code</th>                             
                  <th>Block Name</th>
                  <th>Village Count</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                  foreach ($GetList as $value) {
                    $getUrbanVillage = $this->LocationModel->getUrbanVillageByBlock($value['BlockPRICode']);
                    $getRuralVillage = $this->LocationModel->getRuralVillageByBlock($value['BlockPRICode']);
                ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['PRIDistrictCode']; ?></td>
                  <td><?php echo $value['DistrictNameProperCase']; ?></td>
                  <td> <?php echo $value['BlockPRICode']; ?> </td>
                  <td><?php echo $value['BlockPRINameProperCase']; ?></td>
                  <td><a href="<?php echo base_url() ?>Location/urbanVillage/<?php echo $value['BlockPRICode']; ?>">Urban (<?php echo count($getUrbanVillage); ?>)</a><br>
                      <a href="<?php echo base_url() ?>Location/ruralVillage/<?php echo $value['BlockPRICode']; ?>">Rural (<?php echo count($getRuralVillage); ?>)</a>
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




