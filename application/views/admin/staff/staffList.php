<style>
  .green_dot {
    height: 10px;
    width: 10px;
    background-color: green;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
  }
</style>
<?php $adminData = $this->session->userdata('adminData');?>
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Staff'; ?>
      
      <?php 
          if($adminData['Type'] == '1'){ ?>
                <a href="<?php echo base_url('staffM/addStaff/');?>" class="btn btn-info" style="float: right; padding-right: 10px;margin-right:15px;">Add Staff</a>
      
      <?php }  ?>
      <!-- <a href="<?php echo base_url('staffM/staffType/');?>" class="btn btn-primary" style="float: right; padding-right: 10px; margin-right:15px;"> Staff Type</a> -->
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <?php if($facility_id != 'all') { ?>
              <div class="col-xs-12" style="padding-bottom: 15px; padding-top: 15px;"><b>Facility Name: <a  href="<?php echo base_url();?>facility/updateFacility/<?php echo $facility_id;?>"><?= $GetFacility['FacilityName']; ?></a></b></div>  
            <?php } ?>
           <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="row" style="padding-right: 25px; padding-left: 25px;margin-top: 5px;">
            <div class="col-md-4">
             <span style="font-size: 20px;">Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
                <?php if(!empty($totalResult)) { 
                    ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                    echo '<br>Showing '.$counter.' to '.((($pageNo*100)-100) + 100).' of '.count($totalResult).' entries';
                 } ?>
             </div> 
             <div class="col-md-8">
                <form action="" method="GET">
                    <div class="col-md-3" style="padding: 0;">
                      <input type="text" class="form-control" placeholder="Enter Keyword Value" 
                               name="keyword" value="<?php
                               if (!empty($_GET['keyword'])) {
                                   echo $_GET['keyword'];
                               }
                               ?>">
                      
                    </div>

                    <div class="col-md-4" style="padding: 0;">
                      <select class="form-control selectpicker" name="district_name" id="district_name" data-live-search="true" data-live-search-style="startsWith" aria-required="true" onchange="getFacility(this.value)">
                        <option value="">--Select District--</option>
                        <?php
                          foreach ($GetDistrict as $key => $value) { ?>
                            <option <?php if (!empty($_GET['district_name'])) { if($_GET['district_name'] == $value['PRIDistrictCode']) { echo 'selected'; } }?> value="<?php echo $value['PRIDistrictCode']; ?>"><?php echo $value['DistrictNameProperCase']; ?></option>
                        <?php } ?>
                      </select>
                      
                    </div>

                    <div class="col-md-5" style="padding: 0;">
                      <div class="input-group pull-right">
                        <select class="form-control" name="facility" id="facility">
                          <option value="">Select Facility</option>
                          <?php if(!empty($facilityList)){
                            foreach ($facilityList as $key => $value) { ?>
                            <option <?php if (!empty($_GET['facility'])) { if($_GET['facility'] == $value['FacilityID']) { echo 'selected'; } }?> value="<?php echo $value['FacilityID']; ?>"><?php echo $value['FacilityName']; ?></option>
                          <?php } 
                          } ?>
                        </select>

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </span>
                      </div>

                    </div>
                     <br><span style="font-size:12px;">Search via: Facility, Staff Name, Mobile Number etc.</span>
                </form>
             </div>
            </div>    
            <div class="box-body">
             <div class="col-sm-12" style="overflow: auto;"> 
              <table class="table-striped table table-bordered example2" id="example">
                <thead>
                <tr>
                  <th>S&nbsp;No.</th>
                  <th>Staff&nbsp;Name</th>
                  <?php if($facility_id == 'all') { ?>
                    <th>District&nbsp;Name</th>
                    <th>Facility&nbsp;Name</th>
                  <?php } ?>
                  <th>Status</th>
                  <th>Action</th>
                  <th>Staff&nbsp;Photo</th>
                  <!-- <th>Staff&nbsp;Name</th> -->
                  <!-- <th>Staff&nbsp;Type</th> -->
                  <!-- <th>Staff&nbsp;Job&nbsp;Type</th> -->
                  <th>Staff&nbsp;Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <!-- <th>Emergency&nbsp;Number</th> -->
                  <!-- <th>Staff&nbsp;Address</th> -->
                  
                  <th>Last&nbsp;Updated&nbsp;On</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                if(!empty($results)) { 
                foreach ($results as $value) {
                  // 3 for staff login
                  $GetLastLogin          = $this->FacilityModel->getLastLogin(3,$value['staffId']);
                  $GetFacility           = $this->UserModel->GetFacilitiesName2($value['staffId']); 
                  $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$GetFacility['PRIDistrictCode']."'")->row_array();
                  $GetStaffName          = $this->UserModel->GetStaffName($value['staffType']);
                  $GetStaffSubName       = $this->UserModel->GetStaffSubName($value['staffSubType']);
                  $GetLastCheckin        = $this->FacilityModel->getLastCheckin($value['staffId']);
                  $last_updated          = $this->FacilityModel->time_ago_in_php($value['modifyDate']);

                  $greenIcon = '';
                  if($GetLastCheckin['type'] == 1){
                    $greenIcon = '<div class="green_dot"></div>';
                  }
                 
                 ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $greenIcon.$value['name']; ?></td>
                  <?php if($facility_id == 'all') { ?>
                    <td><?php echo $District['DistrictNameProperCase']; ?></td>
                    <td><?= $GetFacility['FacilityName']; ?></td>
                  <?php } ?>
                  <td>
                   <?php if($value['status'] == 1) { ?> 
                      <span class="label label-success label-sm">
                        Activated
                      </span>
                    <?php } else { ?>
                        <span class="label label-warning label-sm">
                          Deactivated  
                       </span>  
                    <?php } ?>
                  </td>
                  <td><a href="<?php echo base_url(); ?>staffM/updateStaff/<?php echo $value['staffId']; ?>" title="Edit Staff Information" class="btn btn-info btn-sm">View/Edit</a></td>
                  <td style="width:70px;height:50px;">
                    <?php  if(empty($value['profilePicture'])) {
                        if($GetStaffName['staffTypeNameEnglish'] == 'Nurse') {
                     ?>
                     <img  src="<?php echo base_url();?>assets/nurse/default_nurse.png" style="height:100px;width:100px;margin-top:5px;">
                   <?php } else if($GetStaffName['staffTypeNameEnglish'] == 'Doctor') { ?>
                      <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:100px;width:100px;margin-top:5px;">
                    <?php } else { ?>
                      <img  src="<?php echo base_url();?>assets/nurse/default_user.png" style="height:100px;width:100px;margin-top:5px;">
                    <?php } } else { ?>
                      <img  src="<?php echo base_url();?>assets/nurse/<?php echo $value['profilePicture']?>" class="img-responsive">
                    <?php } ?>
                 </td>
                  <!-- <td><?php echo !empty($value['Name']) ? $value['Name'] : 'N/A'; ?></td> -->
                  <!-- <td><?php echo $GetStaffName['staffTypeNameEnglish'];?>-<?php echo $GetStaffSubName['staffTypeNameEnglish'];?></td> -->
                  <!-- <td><?php echo ($value['jobType'] == '10') ? "Permanent" : "Contractual"; ?></td> -->
                  <td><?php echo !empty($value['staffMobileNumber']) ? $value['staffMobileNumber'] : 'N/A'; ?>
                  </td>
                  <!-- <td><?php echo !empty($value['emergencyContactNumber']) ? $value['emergencyContactNumber'] : 'N/A'; ?></td> -->
                  
                  <!-- <td><?php echo !empty($value['staffAddress']) ? $value['staffAddress'] : 'N/A'; ?></td> -->
                  
                  <td><a class="tooltip" href="<?php echo base_url(); ?>staffM/viewStaffLog/<?php echo $value['staffId']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a></td>
                  
                </tr>
                  <?php $counter ++ ; } } else {
                    echo '<tr><td colspan="13" style="text-align:center;">No Records Found!</td></tr>';
                  } ?>
                </tbody>
               </table>
                   <ul class="pagination pull-right">
                    <?php
                    if(!empty($links)){
                      foreach ($links as $link) {
                          echo "<li>" . $link . "</li>";
                      }
                    }
                     ?>
                  </ul> 
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
          <h4 class="modal-title">Staff Functional Diagram</h4>
        </div>
        <div class="modal-body" >
         <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageStaff.png') ;?>" style="height:720px;width:100%;"> 
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:900px !important">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Staff DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body" style="padding:0px !important;">
          <img src="<?php echo base_url('assets/dfdAndFunctionalDiagram/ManageStaffDFD.png') ;?>" style="height:auto;width:100%;">
        </div>
      </div>
    </div>
  </div>

<script>
// $('.click_btn').on('click', function(){
//         var get_id = $(this).attr('id');
//         var s_id = $(this).attr('s_id');
//         var status = $(this).attr('status');
//         var table = 'staffMaster';
//         var s_url = '<?php echo base_url('Admin/changeStatus'); ?>';
//         if(status == '1'){
//             var text = 'Deactivate';     
//         } else {
//             var text = 'Activate';    
//         }
//         var r =  confirm("Are you sure! You want to "+text+" this Staff?");
//        // alert(status);
//         var image;
//         if (r) {
//             $.ajax({
//                 data: {'table': table, 'id': s_id,'tbl_id':'staffId'},
//                 url: s_url,
//                 type: 'post',
//                 success: function(data){
//                     if (data == 1) {
//                         image = '<a href="#" class="btn btn-success btn-sm">Activated</a>';
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
//                       setTimeout(function() { $("#MDG").hide(); }, 2000);
//                     }
//                 }
//             });
//         }
// });


function getFacility(districtId){
      var url = '<?php echo base_url('loungeM/getFacility/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'districtId': districtId},
            success: function(result) {
                //alert(result);
                $("#facility").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

  
</script>