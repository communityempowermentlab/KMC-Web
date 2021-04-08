<?php 
$sessionData = $this->session->userdata('adminData'); 
$userPermittedMenuData = array();
$userPermittedMenuData = $this->session->userdata('userPermission');
?>

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">


<?php
  if(isset($_GET['district']) && !empty($_GET['district'])){
    $district = $_GET['district']; 
    $Facility = $this->LoungeModel->GetFacilityByDistrict($district); 
  } else {
    $district = '';
    $Facility = array();
  }

  if(isset($_GET['fromDate'])){
    $fromDate = $_GET['fromDate'];
  } else {
    $fromDate = '';
  }

  if(isset($_GET['toDate'])){
    $toDate = $_GET['toDate'];
  } else {
    $toDate = '';
  }

  if(isset($_GET['facilityname'])){
    $facilityname = $_GET['facilityname']; 
  } else {
    $facilityname = '';
  }


?>




<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Staff</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Staff
                          </li>
                        </ol>
                      </div>
                    </div>
                    <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/staffDFD.png', 'Staff Data Flow Diagram (DFD)')">Data Flow Diagram</a>] [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/staffFlowChart.png', 'Staff Functional Diagram')">Functional Diagram</a>]</p>
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
                                  <div class="col-md-2"></div>
                                  <div class="col-md-10">
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
                                      </div>
                                      <div class="col-md-6 p-0">
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
                                      <th>S&nbsp;No.</th>
                                      <th>Name</th>
                                      <?php if($facility_id == 'all') { ?>
                                        <th>District</th>
                                        <th>Facility</th>
                                      <?php } ?>
                                      <th>Total<br/>Shift</th>
                                      <th>On time</th>
                                      <th>Late</th>
                                      <th>Happy<br/>Mood</th>
                                      <th>Average<br/>Mood</th>
                                      <th>Not<br/>Happy<br/>Mood</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                      <!-- <th>Photo</th> -->
                                      <th>Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                      <th>Updated&nbsp;On</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*DATA_PER_PAGE)-DATA_PER_PAGE) + 1);
                                  if(!empty($results)) { 
                                  foreach ($results as $value) {
                                    // 3 for staff login
                                    $GetLastLogin          = $this->FacilityModel->getLastLogin(3,$value['staffId']);
                                    $GetFacility           = $this->UserModel->GetFacilitiesName2($value['staffId']); 
                                    $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$GetFacility['PRIDistrictCode']."'")->row_array();
                                    $GetStaffName          = $this->UserModel->GetStaffName($value['staffType']);
                                    $GetStaffSubName       = $this->UserModel->GetStaffSubName($value['staffSubType']);
                                    $GetLastCheckin        = $this->FacilityModel->getLastCheckin($value['staffId']);

                                    $get_last_update = $this->StaffModel->getStaffLastUpdate($value['staffId'], 1);

                                    $last_updated          = $this->FacilityModel->time_ago_in_php($get_last_update['addDate']);

                                    $getNurseFeelings = $this->LoungeModel->getNurseFeelingsData($value['staffId']);

                                    if($value['staffType'] == 2){
                                      $nurseCheckinTotal = $this->LoungeModel->NurseCheckinCountData($value['staffId']);
                                      $totalShift = $nurseCheckinTotal['totalShift'];
                                      $onTime = $nurseCheckinTotal['onTime'];
                                      $late = $nurseCheckinTotal['late'];

                                      $total_happy = $getNurseFeelings['happy'];
                                      $total_fine = $getNurseFeelings['fine'];
                                      $total_not_good = $getNurseFeelings['not_good'];
                                    }else{
                                      $totalShift = "-";
                                      $onTime = "-";
                                      $late = "-";

                                      $total_happy = "-";
                                      $total_fine = "-";
                                      $total_not_good = "-";
                                    }

                                    

                                    $greenIcon = '';
                                    if($GetLastCheckin['type'] == 1){
                                      $greenIcon = '<div class="green_dot"></div>';
                                    }

                                    $url = base_url()."assets/nurse/".$value['profilePicture'];
                 
                                ?>
                                  <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $greenIcon.$value['name']; if(!empty($value['profilePicture'])) { ?> 
                                      <span onclick="showEmployeeImage('<?= $url ?>', 'Staff Picture')" class="hover-image"><i class="bx bx-paperclip cursor-pointer mr-50"></i></span> <?php } ?>
                                    </td>
                                    <?php if($facility_id == 'all') { ?>
                                      <td><?php echo $District['DistrictNameProperCase']; ?></td>
                                      <td><?= $GetFacility['FacilityName']; ?></td>
                                    <?php } ?>
                                    <td><?php echo $totalShift; ?></td>
                                    <td><?php echo $onTime; ?></td>
                                    <td><?php echo $late; ?></td>
                                    <td><?php echo $total_happy; ?></td>
                                    <td><?php echo $total_fine; ?></td>
                                    <td><?php echo $total_not_good; ?></td>
                                    <td>
                                     <?php if($value['status'] == 1) { ?> 
                                        <span class="badge badge-pill badge-light-success mr-1">
                                          Activated  
                                        </span>
                                      <?php } else { ?>
                                          <span class="badge badge-pill badge-light-warning mr-1">
                                            Deactivated
                                          </span>
                                      <?php } ?>
                                    </td>
                                    <td><a href="<?php echo base_url(); ?>staffM/updateStaff/<?php echo $value['staffId']; ?>" title="Edit Staff Information" class="btn btn-info btn-sm">
                                      <?php if(($sessionData['Type']==1) || in_array(11, $userPermittedMenuData)){
                                        echo VIEW_BUTTON;
                                      }
                                      if(($sessionData['Type']==1) || (in_array(11,$userPermittedMenuData) && in_array(64,$userPermittedMenuData)))
                                      {
                                        echo "/";
                                      }
                                      if(($sessionData['Type']==1) || in_array(64, $userPermittedMenuData)){
                                        echo EDIT_BUTTON;
                                      }
                                      ?>
                                    </a></td>
                                    <!-- <td style="width:70px;height:50px;">
                                      <?php  if(empty($value['profilePicture'])) {
                                          if($GetStaffName['staffTypeNameEnglish'] == 'Nurse') {
                                       ?>
                                       <img  src="<?php echo base_url();?>assets/nurse/default_nurse.png" style="height:100px;width:100px;margin-top:5px;">
                                     <?php } else if($GetStaffName['staffTypeNameEnglish'] == 'Doctor') { ?>
                                        <img  src="<?php echo base_url();?>assets/nurse/default.png" style="height:100px;width:100px;margin-top:5px;">
                                      <?php } else { ?>
                                        <img  src="<?php echo base_url();?>assets/nurse/default_user.png" style="height:100px;width:100px;margin-top:5px;">
                                      <?php } } else { ?>
                                        <img style="height:100px;width:100px;margin-top:5px;" src="<?php echo base_url();?>assets/nurse/<?php echo $value['profilePicture']?>" class="img-responsive">
                                      <?php } ?>
                                   </td> -->
                                    
                                    <td><?php echo !empty($value['staffMobileNumber']) ? $value['staffMobileNumber'] : 'N/A'; ?>
                                    </td>
                                    
                                    
                                    <td><?php if(!empty($get_last_update)) { ?><a class="tooltip" href="<?php echo base_url(); ?>staffM/viewStaffLog/<?php echo $value['staffId']; ?>"><?php echo $last_updated; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value['modifyDate'])) ?></span></a><?php } else { echo "N/A"; } ?> </td>
                                    
                                  </tr>
                                    <?php $counter ++ ; } } else {
                                      echo '<tr><td colspan="13" style="text-align:center;">No Records Found!</td></tr>';
                                    } ?>
                                    
                                </tbody>
                                
                            </table>
                            <?php if(!empty($totalResult)) { 
                            ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*DATA_PER_PAGE)-DATA_PER_PAGE) + 1);
                            echo '<br>Showing '.$counter.' to '.(intval($counter)+intval(count($results))-1).' of '.$totalResult.' entries';
                            } ?>
                            <ul class="pagination pull-right">
                              <?php
                              if(!empty($links)){
                                foreach ($links as $link) {
                                    echo "<li >" . $link . "</li>";
                                }
                              }
                               ?>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

<?php if(($sessionData['Type']==1) || in_array(10, $userPermittedMenuData)){ ?>
  <div class="add-new">
    <a href="<?php echo base_url('staffM/addStaff/');?>" class="btn btn btn-danger align-items-center">
        <i class="bx bx-plus"></i>&nbsp; Add New Staff
    </a>
  </div>
<?php } ?>