<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?= $GetLoungeData['loungeName'] ?> Lounge Information Update History
        
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="col-xs-12">
         <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div id="MDG"></div>

                    
          <div class="box-body">
            
            <div class="col-sm-12" style="overflow: auto;">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                 <thead>
                     <tr>
                        <th>S&nbsp;No.</th>
                        <th>Facility&nbsp;Name</th>
                        <th>Type</th>
                        <th>IMEI Number</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Lounge Address</th>
                        <th>Status</th>
                        <th>&nbsp;&nbsp;&nbsp;Lounge&nbsp;Phone&nbsp;&nbsp;</th>
                        <th>Date&nbsp;&&nbsp;Time</th>
                        <th>Added&nbsp;By</th>
                        <th>IP&nbsp;Address</th>
                        
                        
                     </tr>
                  </thead>
                 <tbody>
                    <?php 
                    $counter ="1";
                    foreach ($GetLounge as $value) {
                      $GetFacility = $this->UserModel->GetFacilitiesName($value['loungeId']);
                      $addedBy = $this->load->FacilityModel->GetDataById('adminMaster',$value['addedBy']);
                      $generated_on =     $this->load->FacilityModel->time_ago_in_php($value['addDate']);
                    ?>


                  <tr>
                      <td><?php echo $counter; ?></td>
                      <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $GetFacility['FacilityID'];?>"><?php echo $GetFacility['FacilityName'];?></td>
                      <td><?php if($value['type'] == 1){
                                echo 'SNCU';
                           }else{
                            echo 'Lounge';
                           } ?></td>
                      <td><?php echo $value['imeiNumber']; ?></td>
                      <td><?php echo $value['latitude']; ?></td>
                      <td><?php echo $value['longitude']; ?></td>
                      <td><?php echo $value['address']; ?></td>
                      <td>
                        
                          <?php $status = ($value['status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                          if($value['status'] == 1){?>
                                <span class="label label-success label-sm">
                               Activated
                                </span>
                                
                          <?php } else { ?>
                            <span class="label label-warning label-sm">
                             Deactivated
                             </span>
                            <?php } ?> </td>
                            

  
                      <td> <?php echo !empty($value['loungeContactNumber']) ? $value['loungeContactNumber'] : 'N/A'; ?></td>
                      <td><a href="javascript:void(0);" class="tooltip"><?php echo $generated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['addDate'])) ?></span></a></td>
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


  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Lounges Functional Diagram</h4>
        </div>
        <div class="modal-body">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageLounge.png') ;?>" style="height:450px;width:100%;">
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Lounge DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/manageLoungeDFD.png') ;?>" style="height:600px;width:100%;">
        </div>
      </div>
    </div>
  </div>

