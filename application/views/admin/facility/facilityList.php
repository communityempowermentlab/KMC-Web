<style>
table.dataTable th:nth-child(3) {
  width: 120px;
}
table.dataTable td:nth-child(3){
  width: 120px;
}

</style>

<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Facilities'; ?>
      <a href="<?php echo base_url('facility/AddFacility/');?>" class="btn btn-info" style="float: right; padding-right: 10px;  "> Add Facility<?php #echo NEW_FACILITY ?></a> 
      <!-- <a href="<?php echo base_url('facility/facilityType/');?>" class="btn btn-success" style="float: right; padding-right: 10px; margin-right:15px  "> Facility Type</a> -->
      
      <!-- <a href="<?php echo base_url('staffM/manageTemplate/');?>" class="btn btn-warning" style="float: right; padding-right: 10px;margin-right:15px;"> SMS Template</a> -->
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div class="" id="MDG"></div>
           <span style="font-size: 20px; padding-left: 20px;">Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
            <div class="box-body" >
              <div class="col-sm-12" style="overflow: auto;">
                
                <table class="table-striped table table-bordered example" id="example">
                <thead>
                   <tr>
                      <th>S&nbsp;No.</th>
                      <th>Facility&nbsp;Name</th>
                      <!-- <th>Lounges&nbsp;List&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
                      <!-- <th>Staff&nbsp;List&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> -->
                      <th>Status</th>
                      <th >Action</th>
                      <th>Facility&nbsp;type</th>
                      <!-- <th>New&nbsp;Born&nbsp;Care&nbsp;Unit </th>
                      <th>Management&nbsp;Type</th>
                      <th>Govt&nbsp;OR&nbsp;Non&nbsp;Govt</th>
                      <th>KMC&nbsp;Lounge&nbsp;Status</th>
                      <th>KMC&nbsp;Unit&nbsp;Start</th>
                      <th>KMC&nbsp;Unit&nbsp;Close</th> -->
                      <th>Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      <!-- <th>Administration</th> -->
                      <th>CMS&nbsp;MOIC&nbsp;Name</th>
                      <th>CMS/MOIC</th>
                      <th>Last&nbsp;Updated&nbsp;On&nbsp;&nbsp;&nbsp;</th>
                   </tr>
                </thead>
                <tbody>
                 <?php 
                 $counter ="1";
                 //echo "<pre>";
                 //print_r($GetFacilities); exit;
                 foreach ($GetFacilities as$key=> $value ) {

                   
                      $FacilityManagement = $this->load->FacilityModel->GetDataById('masterData',$value['FacilityManagement']);
                      $BlockName = $this->load->FacilityModel->GetBlockName2($value['PRIBlockCode']);
                     /* echo $BlockName; exit;*/
                      $DistrictName = $this->load->FacilityModel->GetDistrictName($value['PRIDistrictCode']);
                      $Village = $this->load->FacilityModel->GetVillageName($value['GPPRICode']);
                      $state = $this->load->FacilityModel->GetStateName($value['StateID']);
                      $address = $value['Address'].' '.$Village.' '.$BlockName.' '.$DistrictName.', '.$state;
                      $last_updated =     $this->load->FacilityModel->time_ago_in_php($value['ModifyDate']);
                   ?>
                   <tr>
                     <td><?php echo $counter; ?></td>
                     <td><?php echo $value['FacilityName']; ?></td>
                     
                     <td>
                          <?php $status = ($value['Status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                          if($value['Status'] =='1'){?>
                                <span class="label label-success label-sm">Activated
                                </span>
                          <?php } else { ?>
                                 <span class="label label-warning label-sm">
                                  Deactivated  
                                 </span>
                          <?php } ?>
                      </td>
                      <td><a href="<?php echo base_url(); ?>facility/updateFacility/<?php echo $value['FacilityID']; ?>" title="Edit Facility Information" class="btn btn-info btn-sm">View/Edit</a>
                      </td>
                     <td><?php echo $value['FacilityType']; ?></td>
                     
                      <td><?php echo $address; ?></td>
                      <!-- <td><?php if(!empty($value['AdministrativeMoblieNo'])) { 
                          echo $value['AdministrativeMoblieNo'];  } ?>
                      </td>   -->
                      <td><?php echo $value['CMSOrMOICName']?></td>
                      <td><?php echo $value['CMSOrMOICMoblie']?></td>
                      <td><a href="<?php echo base_url(); ?>facility/viewFacilityLog/<?php echo $value['FacilityID']; ?>" class="tooltip"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['ModifyDate'])) ?></span></a></td>
                     
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



  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Facilities Functional Diagram</h4>
        </div>
        <div class="modal-body">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageFacilities.png') ;?>" style="height:500px;width:100%;">
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
          <h4 class="modal-title">Facilities DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body text-center" style="padding:0px !important;">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/facilitydfd.png') ;?>" style="height:598px;width:100%;">
        </div>
      </div>
      
    </div>
  </div>

<script>


// $('.click_btn').on('click', function(){
//         var get_id = $(this).attr('id');
//         var s_id = $(this).attr('s_id');
//         var status = $(this).attr('status');
//         var table = 'facilitylist';
//         var s_url = '<?php echo base_url('facility/changeFacilityStatus'); ?>';
//         if(status == '1'){
//             var text = 'Deactivate';     
//         } else {
//             var text = 'Activate';    
//         }
//         var r =  confirm("Are you sure! You want to "+text+" this Facility?");
//        // alert(status);
//         var image;
//         if (r) {
//             $.ajax({
//                 data: {'table': table, 'id': s_id,'tbl_id':'FacilityID'},
//                 url: s_url,
//                 type: 'post',
//                 success: function(data){ 
//                     if (data == 1) {
//                          image = '<a href="#" class="btn btn-success btn-sm">Activated</a>';
//                         $('#'+get_id).html(image);
//                         $('#MDG').css('color', 'green').html('<div class="alert alert-success">Activated successfully.</div>').show();
//                             if (status == '1') {
//                             $('#'+get_id).attr('status', '0');
//                           } else {
//                             $('#'+get_id).attr('status', '1');
//                           }
//                           setTimeout(function() { $("#MDG").hide(); }, 2000);
//                     } else if (data == 2) {
//                       image = '<a href="#" class="btn btn-warning btn-sm">Deactivated</a>';
//                         $('#'+get_id).html(image);
//                           $('#MDG').css('color', 'red').html('<div class="alert alert-success">Deactivated successfully.</div>').show();
//                          if (status == '0') {
//                             $('#'+get_id).attr('status', '1');
//                           } else {
//                             $('#'+get_id).attr('status', '0');
//                           }
//                         setTimeout(function() { $("#MDG").hide(); }, 2000);
//                     }

//                 }
//             });
//         }

// });
             
  
</script>
