<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<?php
$id = $this->uri->segment(3);
$getLoungeName = $this->FacilityModel->GetLoungeById($id);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $getLoungeName['loungeName']; ?> Lounge Doctor Round Visit History
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="col-xs-12">
         <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div id="MDG"></div>

                    <!-- <span style="font-size: 20px;">Manage Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>] -->
          <div class="box-body">
            <div class="col-sm-12" style="overflow: auto;">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                 <thead>
                     <tr>
                        <th>S&nbsp;No.</th>
                        <th>Doctor&nbsp;Name</th>
                        <th>Doctor&nbsp;Signature</th>
                        <th>Visit&nbsp;Date&nbsp;&&nbsp;Time</th>
                        
                     </tr>
                  </thead>
                 <tbody>
                    <?php 
                    $counter ="1";
                    foreach ($dutyData as $value) {
                    $doctorData = $this->db->get_where('staffMaster',array('staffId'=>$value['staffId']))->row_array();
                    ?>


                  <tr>
                      <td><?php echo $counter; ?></td>
                      <td><a href="<?php echo base_url();?>staffM/updateStaff/<?php echo $doctorData['staffId'];?>"><?php echo $doctorData['name'];?></td>
                      <td><?php if(!empty($value['staffSignature'])) { ?> 
                        <img src="<?php echo signDirectoryUrl.$value['staffSignature']; ?>" width="160" height="120" style="border: 1px solid #e3dfdf;">
                       <?php } else { echo 'N/A'; } ?>
                      </td>
                      <td><?php echo !empty($value['addDate']) ? date("d-m-Y g:i A", strtotime($value['addDate'])) : 'N/A'; ?></td>
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


