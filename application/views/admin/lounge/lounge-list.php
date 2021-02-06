<?php
  if(isset($_GET['district']) && !empty($_GET['district'])){
    $district = $_GET['district']; 
  } else {
    $district = '';
  }

  if(isset($_GET['facilityname']) && !empty($_GET['facilityname'])){
    $facilityname = $_GET['facilityname']; 
  } else {
    $facilityname = '';
  }

  $sessionData = $this->session->userdata('adminData'); 
  $userPermittedMenuData = array();
  $userPermittedMenuData = $this->session->userdata('userPermission');
?>

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">

<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Lounges</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Lounges
                          </li>
                        </ol>
                      </div>
                    </div>
                    <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/loungeERDiagram.png', 'Lounge Data Flow Diagram (DFD)')">Data Flow Diagram</a>] [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/loungeFlowDiagram.png', 'Lounge Functional Diagram')">Functional Diagram</a>]</p>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

                        <div class="table-responsive">
                          <div class="row col-md-10 search pl-1" style="float: right;">
                            <div class="col-md-12">
                              <form action="" method="GET">
                                <div class="row">
                                  <div class="col-md-5"></div>
                                  <div class="col-md-7">
                                    <div class="row">
                                      <div class="col-md-3 p-0">
                                        <select class="select2 form-control" name="district" onchange="getFacility(this.value, '<?php echo base_url('loungeM/getFacility/') ?>')">
                                          <option value="">Select District</option>
                                          <?php
                                            foreach ($GetDistrict as $key => $value) {?>
                                              <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($district == $value['PRIDistrictCode']) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      <div class="col-md-3 p-0">
                                        <select class="select2 form-control" name="facilityname" id="facilityname" onchange="getLounge(this.value, '<?php echo base_url('motherM/getLounge/') ?>'), getNurse(this.value, '<?php echo base_url('motherM/getNurse/') ?>')">
                                          <option value="">Select Facility</option>
                                          <?php
                                            foreach ($Facility as $key => $value) {?>
                                              <option value="<?php echo $value['FacilityID']; ?>" <?php if($facilityname == $value['FacilityID']) { echo 'selected'; } ?>><?php echo $value['FacilityName']; ?></option>
                                          <?php } ?>
                                        </select>
                                        <input type="hidden" id="searched_facilityname" value="<?php echo $facilityname; ?>">
                                      </div>
                                      
                                      <div class="col-md-5 p-0">
                                        <fieldset>
                                          <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Keywords" aria-describedby="button-addon2" name="keyword" value="<?php
                                             if (!empty($_GET['keyword'])) {
                                                 echo $_GET['keyword'];
                                             }
                                             ?>">
                                            <div class="input-group-append" id="button-addon2">
                                              <button class="btn btn-sm btn-primary" type="submit"><i class="bx bx-search"></i></button>
                                            </div>
                                          </div>
                                        </fieldset>
                                      </div>
                                      
                                    </div>
                                  </div>
                                  
                                </div>
                                
                              </form>
                            </div>
                          </div>
                            <table class="table table-striped dataex-html5-selectors-lounge">
                                <thead>
                                    <tr>
                                      <th>S.No.</th>
                                      <th>District</th>
                                      <th>Facility</th>
                                      <!-- <th>Type</th> -->
                                      <th>Lounge</th>
                                      <th>Lounge Mobile</th>
                                      <th>Verified Mobile</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                      <th>Available&nbsp;Staff</th>
                                      <th>App&nbsp;Login&nbsp;At</th>
                                      <!-- <th>Updated&nbsp;On</th> -->
                                      <th>Amenities&nbsp;Updated&nbsp;On</th>
                                      <th>Doctor&nbsp;Visit&nbsp;At</th>
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

                                       $getAmenitiesDetails = $this->db->query("SELECT * FROM `loungeAmenities` where `loungeAmenities`.loungeId='".$value['loungeId']."'")->row_array();
                                  ?>


                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $District['DistrictNameProperCase']; ?></td>
                                    <td><?php echo $GetFacility['FacilityName'];?></td>
                                    <!-- <td><?php if($value['type'] == 1){
                                              echo 'SNCU';
                                         }else{
                                          echo 'Lounge';
                                         } ?></td> -->
                                    <td><?php echo $greenIcon.$value['loungeName']; ?></td>
                                    <td> <?php echo !empty($value['loungeContactNumber']) ? $value['loungeContactNumber'] : 'N/A'; ?></a></td>
                                    <td> <?php echo !empty($getAmenitiesDetails['verifiedMobile']) ? $getAmenitiesDetails['verifiedMobile'] : 'N/A'; ?></a></td>
                                    <td>
                                        <?php $status = ($value['status'] == '1') ? 'assets/act.png' :'assets/delete.png';
                                        if($value['status'] == 1){?>
                                              <span class="badge badge-pill badge-light-success mr-1">
                                                Activated  
                                              </span>
                                              
                                        <?php } else { ?>
                                              <span class="badge badge-pill badge-light-warning mr-1">
                                                Deactivated
                                              </span>
                                          <?php } ?> </td>
                                          <td>  

                                            <div class="dropdown">
                                              <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/updateLounge/<?php echo $value['loungeId']; ?>">Lounge 
                                                  <?php if(($sessionData['Type']==1) || in_array(8, $userPermittedMenuData)){
                                                    echo VIEW_BUTTON;
                                                  }
                                                  if(($sessionData['Type']==1) || (in_array(8,$userPermittedMenuData) && in_array(60,$userPermittedMenuData)))
                                                  {
                                                    echo "/";
                                                  }
                                                  if(($sessionData['Type']==1) || in_array(60, $userPermittedMenuData)){
                                                    echo EDIT_BUTTON;
                                                  }
                                                  ?>
                                                </a>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeAmenities/<?php echo $value['loungeId']; ?>">Amenities For Lounge</a>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeNurseCheckin/<?php echo $value['loungeId']; ?>">Nurse CheckIn/Checkout</a>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeAssessment/<?php echo $value['loungeId']; ?>">Lounge Assessment</a>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeBirthReview/<?php echo $value['loungeId']; ?>">Facility Birth Review</a>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>loungeM/loungeServices/<?php echo $value['loungeId']; ?>">Lounge Services</a>
                                              </div>
                                            </div>

                                          </td>
                                          <td>
                                            <?php 
                                              if(!empty($GetAvailStaff)) {
                                                $html = "";

                                                $html .= '<ul style="padding-left:18px;">';

                                                  foreach($GetAvailStaff as $staff_data)
                                                  {
                                                    $html .= '<li style="list-style: disc;">'.$staff_data['name'].'</li>';
                                                  } 
                                                  $html .= '</ul>';


                                                  echo $html;
                                                } else {
                                                  echo "N/A";
                                                }
                                            ?>
                                          </td>
                                          <td><?php if($value['loungeId']==$GetLoginDatails['loungeMasterId']){?>
                                            <a class="tooltip" href="<?php echo base_url()?>facility/loungeLoginHistory/<?php echo $value['loungeId'];?>"><?php echo $last_login;?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($GetLoginDatails['loginTime'])) ?></span></a>
                                            <?php  } else { echo "N/A"; } ?>
                                          </td>
                                          <!-- <td><a class="tooltip" href="<?php echo base_url(); ?>loungeM/viewLoungeLog/<?php echo $value['loungeId']; ?>"><?php echo $lounge_updated_on; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a>
                                          </td> -->
                                            
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->
<?php if(($sessionData['Type']==1) || in_array(7, $userPermittedMenuData)){ ?>
  <div class="add-new">
    <a href="<?php echo base_url('loungeM/addLounge/');?>" class="btn btn btn-danger align-items-center">
        <i class="bx bx-plus"></i>&nbsp; Add New Lounge
    </a>
  </div>
<?php } ?>

<script type="text/javascript">
$( document ).ready(function() {
  var district = '<?php echo $district; ?>';
  if(district != ""){
    getFacility('<?php echo $district ?>', '<?php echo base_url('loungeM/getFacility/') ?>');
  }
});
</script>