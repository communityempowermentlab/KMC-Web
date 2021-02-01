<style>
  .green_dot {
    height: 10px;
    width: 10px;
    background-color: green;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
  }
  .open > .dropdown-menu {
    z-index: 5555;
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
        <h1>Lounges
        <a href="<?php echo base_url('loungeM/addLounge/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Lounge</a>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="col-xs-12">
         <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           <div id="MDG"></div>

                    <span style="font-size: 20px;">Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
          <div class="box-body">
            
            <div class="col-sm-12" style="overflow: auto;">
              <table cellpadding="0" cellspacing="0" border="0"
                class="table-striped table table-bordered editable-datatable example " id="example" >
                 <thead>
                     <tr>
                        <th>S&nbsp;No.</th>
                        <th>District&nbsp;Name</th>
                        <th>Facility&nbsp;Name</th>
                        <th>Type</th>
                        <th>Lounge&nbsp;Name</th>
                        <th>Lounge&nbsp;Phone</th>
                        <th>Status</th>
                        <th style="width: 220px;">Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Available&nbsp;Staff</th>
                        <th>Last&nbsp;App&nbsp;Login&nbsp;At</th>
                        <th>Last&nbsp;Lounge&nbsp;Updated&nbsp;On</th>
                        <th>Last&nbsp;Amenities&nbsp;Updated&nbsp;On</th>
                        <th>Last&nbsp;Doctor&nbsp;Visit&nbsp;At</th>
                        
                        
                     </tr>
                  </thead>
                 <tbody>
                    <?php 
                    $counter ="1";
                    foreach ($GetLounge as $value) {
                    $GetFacility = $this->UserModel->GetFacilitiesName($value['loungeId']);
                    $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$GetFacility['PRIDistrictCode']."'")->row_array();
                    $GetLoginDatails = $this->FacilityModel->GetLoginDatails($value['loungeId']);
                    $getDoctorDetails = $this->db->query("SELECT * FROM `doctorRound` INNER JOIN babyAdmission on `doctorRound`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId='".$value['loungeId']."' ORDER BY doctorRound.`id` DESC")->row_array();
                    //print_r($getDoctorDetails);exit;
                     if(!empty($getDoctorDetails)) {
                      $getStaffDetails = $this->db->query("SELECT * from staffMaster where StaffID=".$getDoctorDetails['staffId']."")->row_array();
                     }
                     $GetLastAmenitiesLog = $this->LoungeModel->GetLastAmenitiesLog($value['loungeId']);
                     if(!empty($GetLastAmenitiesLog)){
                      $amenities_update = $this->load->FacilityModel->time_ago_in_php($GetLastAmenitiesLog['addDate']);
                      $updatedOn = '<a class="tooltip" href="'.base_url().'loungeM/viewAmenitiesLog/'.$value['loungeId'].'">'.$amenities_update.'<span class="tooltiptext">'.date("m/d/y, h:i A",strtotime($GetLastAmenitiesLog['addDate'])).'</span></a>';
                     } else {
                      $updatedOn = 'Not Updated.';
                     }
                     $greenIcon = '';
                     if($GetLoginDatails['status'] == 1){
                      $greenIcon = '<div class="green_dot"></div>';
                     }
                     $last_login =     $this->load->FacilityModel->time_ago_in_php($GetLoginDatails['loginTime']);
                     $lounge_updated_on = $this->load->FacilityModel->time_ago_in_php($value['modifyDate']);
                     $doctor_visit = $this->load->FacilityModel->time_ago_in_php($getDoctorDetails['addDate']);
                     $GetAvailStaff = $this->LoungeModel->GetAvailableStaff($value['loungeId']);
                    ?>


                  <tr>
                      <td><?php echo $counter; ?></td>
                      <td><?php echo $District['DistrictNameProperCase']; ?></td>
                      <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $GetFacility['FacilityID'];?>"><?php echo $GetFacility['FacilityName'];?></td>
                      <td><?php if($value['type'] == 1){
                                echo 'SNCU';
                           }else{
                            echo 'Lounge';
                           } ?></td>
                      <td><?php echo $greenIcon.$value['loungeName']; ?></td>
                      <td> <?php echo !empty($value['loungeContactNumber']) ? $value['loungeContactNumber'] : 'N/A'; ?></a>
                        
                       
                      </td>
                      <td>
                          <?php $status = ($value['status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                          if($value['status'] == 1){?>
                                <span class="label label-success label-sm">
                                  Activated  
                                </span>
                                </span>
                          <?php } else { ?>
                                <span class="label label-warning label-sm">
                                  Deactivated
                                </span>
                            <?php } ?> </td>
                            <td>  

                              <div class="btn-group">
                                <button type="button" class="btn btn-info">Setting</button>
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="caret"></span>
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/updateLounge/<?php echo $value['loungeId']; ?>">Lounge View/Edit</a>
                                  </li>
                                  <li><a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeAmenities/<?php echo $value['loungeId']; ?>">Amenities For Lounge</a>
                                  </li>
                                  <li><a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeNurseCheckin/<?php echo $value['loungeId']; ?>">Nurse CheckIn</a>
                                  </li>
                                  <li><a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeAssessment/<?php echo $value['loungeId']; ?>">Assessment</a>
                                  </li>
                                  <li><a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeBirthReview/<?php echo $value['loungeId']; ?>">Birth Review</a>
                                  </li>
                                </ul>
                              </div>

                            </td>
                            <td>
                              <?php 
                                  $html = "";

                                  $html .= '<ul style="padding-left:18px;">';

                                    foreach($GetAvailStaff as $staff_data)
                                    {
                                      $html .= '<li style="list-style: disc;"><a title="Add/Update Staff" href="'.base_url('staffM/updateStaff/'.$staff_data['staffId']).'">'.$staff_data['name'].'</a></li>';
                                    } 
                                    $html .= '</ul>';


                                    echo $html;
                              ?>
                            </td>
                            <td><?php if($value['loungeId']==$GetLoginDatails['loungeMasterId']){?>
                              <a class="tooltip" href="<?php echo base_url()?>facility/loungeLoginHistory/<?php echo $value['loungeId'];?>"><?php echo $last_login;?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($GetLoginDatails['loginTime'])) ?></span></a>
                              <?php  } ?>
                            </td>
                            <td><a class="tooltip" href="<?php echo base_url(); ?>loungeM/viewLoungeLog/<?php echo $value['loungeId']; ?>"><?php echo $lounge_updated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a>
                            </td>
                              
                            <td><?php echo $updatedOn;  ?></td>
  
                      

                      <td> <?php if(!empty($getDoctorDetails)) { ?> <?php echo $getStaffDetails['name']; ?></a>
                      <br/>&nbsp;<a class="tooltip" href="<?php echo base_url()?>loungeM/dutylistPage/<?php echo $value['loungeId'];?>"><?php echo $doctor_visit; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($getDoctorDetails['addDate'])) ?></span></a>
                      <?php } else { echo 'N/A'; } ?>
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

<script>
$('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var status = $(this).attr('status');
        var table = 'loungeMaster';
        var s_url = '<?php echo base_url('Admin/changeStatus'); ?>';
        if(status == '1'){
            var text = 'Deactivate';     
        } else {
            var text = 'Activate';    
        }
        var r =  confirm("Are you sure! You want to "+text+" this Lounge?");
       // alert(status);
        var image;
        if (r) {
            $.ajax({
                data: {'table': table, 'id': s_id,'tbl_id':'LoungeID'},
                url: s_url,
                type: 'post',
                success: function(data){

                    if (data == 1) {
                         image = '<a href="#" class="btn btn-success btn-sm">Activated</a>';
                        $('#'+get_id).html(image);
                        $('#MDG').css('color', 'green').html('<div class="alert alert-success">Activated successfully.</div>').show();
                            if (status == '1') {
                            $('#'+get_id).attr('status', '0');
                          } else {
                            $('#'+get_id).attr('status', '1');
                          }
                          setTimeout(function() { $("#MDG").hide(); }, 2000);
                    } else if (data == 2) {
                      image = '<a href="#" class="btn btn-warning btn-sm">Deactivated</a>';
                        $('#'+get_id).html(image);
                          $('#MDG').css('color', 'red').html('<div class="alert alert-success">Deactivated successfully.</div>').show();
                         if (status == '0') {
                            $('#'+get_id).attr('status', '1');
                          } else {
                            $('#'+get_id).attr('status', '0');
                          }
                      setTimeout(function() { $("#MDG").hide(); }, 2000);
                    }
                }
            });
        }

    });
</script>