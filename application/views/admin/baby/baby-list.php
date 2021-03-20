

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">


<?php
 $loungeId    = $this->uri->segment('4');
 $GetFacility = $this->FacilityModel->GetFacilitiesID($loungeId);
 if(isset($_GET['district'])){
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
    $Lounge = $this->LoungeModel->GetLoungeByFAcility($facilityname); 
    $Staff = $this->LoungeModel->GetNurseByFacility($facilityname); 
  } else {
    $facilityname = '';
    $Lounge = array();
    $Staff = array();
  }

  if(isset($_GET['loungeid'])){
    $loungeid = $_GET['loungeid']; 
  } else {
    $loungeid = '';
  }

  if(isset($_GET['nurseid'])){
    $nurseid = $_GET['nurseid']; 
  } else {
    $nurseid = '';
  }

  if(isset($_GET['babyStatus'])){
    $babyStatus = $_GET['babyStatus']; 
  } else {
    $babyStatus = '';
  }

  if(isset($_GET['admissionTypeFilterValue'])){
    $admissionTypeFilterValue = $_GET['admissionTypeFilterValue']; 
  } else {
    $admissionTypeFilterValue = '';
  }

  if(isset($_GET['dischargeTypeFilterValue'])){
    $dischargeTypeFilterValue = $_GET['dischargeTypeFilterValue']; 
  } else {
    $dischargeTypeFilterValue = '';
  }

  $adminData = $this->session->userdata('adminData'); 
  if($adminData['Type'] == 3){
    $loungeDetails = $this->UserModel->getCoachFacilities();
    $district = @$loungeDetails['coachDistrictArray'][0];
    $Facility = $this->LoungeModel->GetFacilityByDistrict($district);
    $facilityname = @$loungeDetails['coachFacilityArray'][0];
    $Lounge = $this->LoungeModel->GetLoungeByFAcility($facilityname); 
    $Staff = $this->LoungeModel->GetNurseByFacility($facilityname);
    $loungeid = @$loungeDetails['coachLoungeArray'][0];
  }
?>


<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Infants</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Infants
                          </li>
                        </ol>
                      </div>
                    </div>
                    <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/ManagebabyDfd.png', 'Infants Data Flow Diagram (DFD)')">Data Flow Diagram</a>] [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/BabyRegistrationProcess.png', 'Infants Functional Diagram')">Functional Diagram</a>]</p>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
                        <div class="row search pl-1">
                          <div class="col-md-12">
                            <form action="" method="GET">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="row">
                                    <div class="col-md-4 p-0">
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control datetime" placeholder="Select Date" name="fromDate" id="fromDate" value="<?= $fromDate; ?>" readonly>
                                        <div class="form-control-position calendar-position">
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                      </fieldset>
                                    </div>
                                    <!-- <div class="col-md-2 p-0">
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control pickadate-months-year" placeholder="End Date" name="toDate" value="<?= $toDate; ?>">
                                        <div class="form-control-position calendar-position">
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                      </fieldset>
                                    </div> -->
                                    <div class="col-md-2 p-0">
                                      <select class="select2 form-control" name="district" onchange="getFacility(this.value, '<?php echo base_url('babyM/getFacility') ?>')">
                                        <option value="">Select District</option>
                                        <?php
                                          foreach ($GetDistrict as $key => $value) {?>
                                            <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($district == $value['PRIDistrictCode']) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                    <div class="col-md-2 p-0">
                                      <select class="select2 form-control" name="facilityname" id="facilityname" onchange="getLounge(this.value, '<?php echo base_url('babyM/getLounge') ?>'), getNurse(this.value, '<?php echo base_url('babyM/getNurse') ?>')">
                                        <option value="">Select Facility</option>
                                        <?php
                                          foreach ($Facility as $key => $value) {?>
                                            <option value="<?php echo $value['FacilityID']; ?>" <?php if($facilityname == $value['FacilityID']) { echo 'selected'; } ?>><?php echo $value['FacilityName']; ?></option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                    <div class="col-md-2 p-0">
                                      <select class="select2 form-control" name="loungeid" id="loungeid">
                                        <option value="">Select Lounge</option>
                                        <?php
                                          foreach ($Lounge as $key => $value) {?>
                                            <option value="<?php echo $value['loungeId']; ?>" <?php if($loungeid == $value['loungeId']) { echo 'selected'; } ?>><?php echo $value['loungeName']; ?></option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                    <div class="col-md-2 p-0">
                                      <select class="select2 form-control" name="nurseid" id="nurseid">
                                        <option value="">Select Nurse</option>
                                        <?php
                                          foreach ($Staff as $key => $value) {?>
                                            <option value="<?php echo $value['staffId']; ?>" <?php if($nurseid == $value['staffId']) { echo 'selected'; } ?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4 p-0"></div>
                                <div class="col-md-2 p-0">
                                  <div class="col-md-11 p-0">
                                      <select class="select2 form-control" name="babyStatus" id="babyStatus" onchange="openSubFilterBox(this.value);">
                                        <option value="">Select Status</option>
                                        <option value="1" <?php echo ($babyStatus == '1') ? 'selected' : ''; ?>>Admitted</option>
                                        <option value="3" <?php echo ($babyStatus == '3') ? 'selected' : ''; ?>>Admission</option>
                                        <option value="2" <?php echo ($babyStatus == '2') ? 'selected' : ''; ?>>Discharged</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="col-md-2 p-0" id="admissionTypeFilterBox" style="display: <?php echo ($babyStatus == "1" || $babyStatus == "3")?"block":"none"; ?>">
                                  <div class="col-md-11 p-0">
                                    <select class="select2 form-control" name="admissionTypeFilterValue" id="admissionTypeFilterValue">
                                      <option value="">Select Type</option>
                                      <option value="1" <?php echo ($admissionTypeFilterValue == '1') ? 'selected' : ''; ?>>Referral</option>
                                      <option value="2" <?php echo ($admissionTypeFilterValue == '2') ? 'selected' : ''; ?>>Mother accompanied</option>
                                      <option value="3" <?php echo ($admissionTypeFilterValue == '3') ? 'selected' : ''; ?>>Dead</option>
                                      <option value="4" <?php echo ($admissionTypeFilterValue == '4') ? 'selected' : ''; ?>>Baby was referred & mother did not accompanied</option>
                                      <option value="5" <?php echo ($admissionTypeFilterValue == "5") ? 'selected' : ''; ?>>Mother is in a different ward in same hospital</option>
                                      <option value="6" <?php echo ($admissionTypeFilterValue == '6') ? 'selected' : ''; ?>>Unknown/ Baby is an orphan</option>
                                      <option value="7" <?php echo ($admissionTypeFilterValue == '7') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2 p-0" id="dischargeTypeFilterBox" style="display: <?php echo ($babyStatus == "2")?"block":"none"; ?>">
                                  <div class="col-md-11 p-0">
                                    <select class="select2 form-control" name="dischargeTypeFilterValue" id="dischargeTypeFilterValue">
                                      <option value="">Select Discharge Type</option>
                                      <option value="Referral" <?php echo ($dischargeTypeFilterValue == 'Referral') ? 'selected' : ''; ?>>Referral</option>
                                      <option value="LAMA" <?php echo ($dischargeTypeFilterValue == 'LAMA') ? 'selected' : ''; ?>>LAMA</option>
                                      <option value="DOPR" <?php echo ($dischargeTypeFilterValue == 'DOPR') ? 'selected' : ''; ?>>DOPR</option>
                                      <option value="Doctor's discretion" <?php echo ($dischargeTypeFilterValue == "Doctor's discretion") ? 'selected' : ''; ?>>Doctor discretion</option>
                                      <option value="Absconded" <?php echo ($dischargeTypeFilterValue == 'Absconded') ? 'selected' : ''; ?>>Absconded</option>
                                      <option value="Died" <?php echo ($dischargeTypeFilterValue == 'Died') ? 'selected' : ''; ?>>Died</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4 p-0">
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
                            </form>
                          </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped dataex-html5-selectors-baby">
                                <thead>
                                    <tr>
                                      <th style="padding: 1.15rem 1.25rem;">S&nbsp;No.</th>
                                      <th style="padding: 1.15rem 1.25rem;">Status</th>
                                      <th>Admission Type</th>
                                      <th>Discharge Type</th>
                                      <th>Action</th>
                                      <th>District</th>
                                      <th>Facility</th>
                                      <?php if($loungeId == 'all') { ?>
                                        <th>Lounge</th>
                                      <?php } ?>
                                      <th>Nurse</th>  
                                      <th>PDF</th>
                                      <th>Photo</th>
                                      <th>Infant&nbsp;Of</th>
                                      <th>Reg.&nbsp;No.</th>
                                      <!-- <th>Total&nbsp;KMC&nbsp;Time</th> -->
                                      <!-- <th>Latest&nbsp;24 Hrs&nbsp;KMC</th>
                                      <th>Total&nbsp;Milk&nbsp;Qty.</th>
                                      <th>Comments</th> -->
                                      <th>Delivery&nbsp;At</th>
                                      <!-- <th>Gender</th> -->
                                      
                                      <th>Reg.&nbsp;At</th>  
                                      <th>Assessment&nbsp;At</th>  
                                      
                                      
                                    </tr>
                                </thead>
                                <tbody>

                                
                                  <?php 
                                  
                                  ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*DATA_PER_PAGE)-DATA_PER_PAGE) + 1);  
                                  foreach ($results as $value1) { 
                                    $babyRecord          = $this->BabyModel->GetBabyViaBabyId('babyRegistration',$value1['babyId']);
                                    $babyAdmissionRecord          = $this->BabyModel->GetBabyViaBabyId('babyAdmission',$value1['babyId']);

                                    // admission type
                                    $motherRegistrationDetails          = $this->BabyModel->getMotherRegistration($babyRecord['motherId']);
                                    $searchTextEng1 = "Dead";
                                    $searchTextHin1 = "मृत";
                                    $searchTextEng2 = "Baby was referred";
                                    $searchTextHin2 = "बेबी को रेफर किया";
                                    $searchTextEng3 = "Mother is in a different";
                                    $searchTextHin3 = "माँ एक ही अस्पताल";  
                                    $searchTextEng4 = "Other";
                                    $searchTextHin4 = "अन्य";  

                                    if($motherRegistrationDetails['isMotherAdmitted']=="Yes" && $motherRegistrationDetails['type']=="1" && $babyAdmissionRecord['status']=="3"){
                                      $motherAdmissionType = "Referral";
                                    }elseif($motherRegistrationDetails['isMotherAdmitted']=="Yes" && $motherRegistrationDetails['type']=="1"){
                                      $motherAdmissionType = "Mother Accompanying";
                                    }elseif($motherRegistrationDetails['isMotherAdmitted']=="No" && $motherRegistrationDetails['type']=="3" && (preg_match("/{$searchTextEng1}/i", $motherRegistrationDetails['notAdmittedReason']) || preg_match("/{$searchTextHin1}/i", $motherRegistrationDetails['notAdmittedReason']))){
                                      $motherAdmissionType = "Dead";
                                    }elseif($motherRegistrationDetails['isMotherAdmitted']=="No" && $motherRegistrationDetails['type']=="3" && (preg_match("/{$searchTextEng2}/i", $motherRegistrationDetails['notAdmittedReason']) || preg_match("/{$searchTextHin2}/i", $motherRegistrationDetails['notAdmittedReason']))){
                                      $motherAdmissionType = "Baby was referred & mother did not accompanied";
                                    }elseif($motherRegistrationDetails['isMotherAdmitted']=="No" && $motherRegistrationDetails['type']=="3" && (preg_match("/{$searchTextEng3}/i", $motherRegistrationDetails['notAdmittedReason']) || preg_match("/{$searchTextHin3}/i", $motherRegistrationDetails['notAdmittedReason']))){
                                      $motherAdmissionType = "Mother is in a different ward in same hospital";
                                    }elseif($motherRegistrationDetails['isMotherAdmitted']=="No" && $motherRegistrationDetails['type']=="2"){
                                      $motherAdmissionType = "Unknown/ Baby is an orphan";
                                    }elseif($motherRegistrationDetails['isMotherAdmitted']=="No" && $motherRegistrationDetails['type']=="3" && (preg_match("/{$searchTextEng4}/i", $motherRegistrationDetails['notAdmittedReason']) || preg_match("/{$searchTextHin4}/i", $motherRegistrationDetails['notAdmittedReason']))){
                                      $motherAdmissionType = "Other";
                                    }else{
                                      $motherAdmissionType = "N/A";
                                    }

                                    // if($motherRegistrationDetails['type'] == "3"){
                                    //   $motherAdmissionType = "Referred";
                                    // }elseif($motherRegistrationDetails['isMotherAdmitted'] == "Yes" && $motherRegistrationDetails['type'] == "1"){
                                    //   $motherAdmissionType = "Mother Accompanying";
                                    // }elseif($motherRegistrationDetails['isMotherAdmitted'] == "No"){
                                    //   $motherAdmissionType = $motherRegistrationDetails['notAdmittedReason'];
                                    // }else{
                                    //   $motherAdmissionType = "N/A";
                                    // }

                                    $babyAdmissionData   = $this->BabyModel->getBabyRecordByAdmisonId($value1['id']);
                                    
                                    $get_last_assessment = $this->BabyModel->getMonitoringExistData($value1['id'],$value1['babyId'],$value1['loungeId']);

                                    $getCommentData = $this->BabyModel->getCommentList(2,2,$value1['babyId'],$value1['id']);
                                    
                                    $babyIconStatus      = $this->DangerSignModel->getBabyIcon($get_last_assessment);
                                    $motherName          = $this->BabyModel->singlerowparameter2('motherName','motherId',$babyRecord['motherId'],'motherRegistration');
                                    $getKMCTime          = $this->DashboardDataModel->getTotalKmc($value1['id']);
                                    $getMilkQty          = $this->BabyModel->getTotalMilk($value1['id']);
                                    if(!empty($babyRecord['motherId'])){
                                      $lastAdmissionID     = $this->MotherModel->GetLastAsessment('motherAdmission','motherId',$babyRecord['motherId']);
                                    }
                            
                                    $latestEndKmcTime    = time();
                                    $latestStartKmcTime  = strtotime(date("Y-m-d H:m:s", strtotime('-24 hours',time())));
                                    $latestKMCTime       = $this->DashboardDataModel->getLatestKMC($latestStartKmcTime,$latestEndKmcTime,$value1['id']);

                                    $getAdmissionData = $this->db->get_where('motherAdmission',array('motherId'=>$babyRecord['motherId']));
                                    $checkAdmission = $getAdmissionData->num_rows();

                                    $GetFacility   = $this->FacilityModel->GetFacilitiesID($value1['loungeId']);

                                    $Facility = $this->db->query("SELECT * FROM `facilitylist` where FacilityID='".$GetFacility['facilityId']."'")->row_array();
                                    $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$Facility['PRIDistrictCode']."'")->row_array();

                                    // set variables for td


                                    $babyOf   = !empty($motherName) ? $motherName : "UNKNOWN";

                                    if($GetFacility['type'] == 1){
                                      $babyFileId   = !empty($value1['temporaryFileId']) ? $value1['temporaryFileId'] : 'N/A';
                                    }else{
                                      $babyFileId   = !empty($value1['babyFileId']) ? $value1['babyFileId'] : 'N/A';
                                    }


                                      // set danger Icon and mother photo
                                      if($babyIconStatus == '1') { 
                                        $topMargin = "";
                                        $icon="<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                                      }else if($babyIconStatus == '0') {
                                        $topMargin = "";
                                        $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                                      }else{
                                        $icon = "";
                                        $topMargin = "margin-top:5%";
                                      }
                                      $defaultImage = base_url('assets/images/baby.png');
                                      $babyPhoto    = empty($babyRecord['babyPhoto']) ? "<img src='".$defaultImage."' class='img-responsive babyImage' style=".$topMargin.">" : "<img  src='".babyDirectoryUrl.$babyRecord['babyPhoto']."' class='img-responsive babyImage' style=".$topMargin.">";
                                    
                                    if(!empty($getKMCTime['kmcTime'])){
                                      $hours  = floor($getKMCTime['kmcTime'] / 3600);
                                      ($hours == '1') ?  $unit = "Hr" : $unit = "Hrs";
                                   
                                      $minutes = floor(($getKMCTime['kmcTime'] / 60) % 60);
                                      $totalKmcTime = $hours.' '.$unit.' '.$minutes.' Mins';
                                    }else{
                                      $totalKmcTime = '--';
                                    }

                                    // latest 24 four hrs kmc timing
                                    if(!empty($latestKMCTime['kmcTimeLatest'])){
                                      $hours  = floor($latestKMCTime['kmcTimeLatest'] / 3600);
                                      ($hours == '1') ?  $unit = "Hr" : $unit = "Hrs";
                                   
                                      $minutes = floor(($latestKMCTime['kmcTimeLatest'] / 60) % 60);
                                      $totalKmcTime1 = $hours.' '.$unit.' '.$minutes.' Mins';
                                    }else{
                                      $totalKmcTime1 = '--';
                                    }


                                    
                                     if($getMilkQty['quantityOFMilk'] == '0.00'){
                                       $totalMilk    = 'N/A';
                                     }else{
                                       $totalMilk    = !empty($getMilkQty['quantityOFMilk']) ? $getMilkQty['quantityOFMilk'].' ml' : '--';
                                     }

                                    $deliveryDateT = $babyRecord['deliveryDate'].'&nbsp;'.date('g:i A',strtotime($babyRecord['deliveryTime']));        
                                    $LstMonitoring = !empty($get_last_assessment['addDate']) ? $this->FacilityModel->time_ago_in_php($get_last_assessment['addDate']) : 'N/A';        
                                    
                                    if($babyAdmissionData['status'] == '2') { 
                                      $status           = '<span class="badge badge-pill badge-light-success mr-1 mb-span">DC</span>';

                                      $typeOfDischarge = $babyAdmissionData['typeOfDischarge'];

                                      if($typeOfDischarge == 'Referral') {
                                       $status           = '<span class="badge badge-pill badge-light-success mr-1 mb-span">DC (R)</span>';
                                      }
                                      
                                    }else if($babyAdmissionData['status'] == '1'){ 
                                      
                                      $nurseName        = $getStaffName1['name'];
                                      $status           = '<span class="badge badge-pill badge-light-warning mr-1 mb-span">A</span>';

                                      $chkIfRefer = $this->db->query("SELECT * FROM `babyAdmission`  where id < ".$babyAdmissionData['id']." and babyId = ".$babyAdmissionData['babyId']." ORDER BY `babyAdmission`.`id`  DESC")->row_array();

                                      if(!empty($chkIfRefer)) {
                                        if($chkIfRefer['typeOfDischarge'] == 'Referral') {
                                          $status           = '<span class="badge badge-pill badge-light-warning mr-1 mb-span">A (R)</span>';
                                        }
                                      }

                                    } else if($babyAdmissionData['status'] == '3'){ 
                                      $status           = '<span class="badge badge-pill badge-light-info mr-1 mb-span">R</span>';

                                    }


                                    if(!empty($babyAdmissionData['staffId'])){
                                      $getStaffName     = $this->db->get_where('staffMaster',array('staffId'=>$babyAdmissionData['staffId']))->row_array(); 
                                      $nurseName        = $getStaffName['name'];
                                    } else {
                                      $nurseName        = "N/A";
                                    }


                                     $getNurseSign =  $this->db->order_by('id', 'desc')->get_where('admissionCheckList',array('babyAdmissionId'=>$value1['id']))->row_array();
                                     $nurseSign    =  empty($getNurseSign['nurseDigitalSign']) ? "N/A" : "<img  src='".signDirectoryUrl.$getNurseSign['nurseDigitalSign']."' class='signatureSize'>";
                                     $reg_date          = $this->FacilityModel->time_ago_in_php($value1['addDate']);

                                     if(!empty($babyRecord['babyPhoto'])){
                                        $url = "'".babyDirectoryUrl.$babyRecord['babyPhoto']."'";
                                     }else{
                                        $url = "'".$defaultImage."'";
                                     }
                                     
                                    ?>
                                    <tr>

  
                                      <td style="padding: 1.15rem 1.25rem;"><?php echo $counter; ?></td>
                                      <td style="padding: 1.15rem 1.25rem;"><?php echo $status ; ?></td>
                                      <td><?php echo $motherAdmissionType; ?></td>
                                      <td><?php echo empty($babyAdmissionData['typeOfDischarge']) ? '-' : $babyAdmissionData['typeOfDischarge']; ?></td>
                                      <td><a href="<?php echo base_url();?>babyM/viewBaby/<?php echo $value1['id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                      <td><?php echo $District['DistrictNameProperCase']; ?></td>
                                      <td><?php echo $Facility['FacilityName']; ?></td>
                                      <?php if($loungeId == 'all') { ?>
                                        <td><?= $GetFacility['loungeName']; ?></td>
                                      <?php } ?>
                                      <td><?php echo $nurseName; ?></td>
                                      <td>
                                        <div class="dropdown">
                                          <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                          <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="<?php echo base_url();?>babyM/BabyAdmissionPDF/<?php echo $value1['id'] ?>">Admission PDF</a>
                                            <a class="dropdown-item" href="<?php echo base_url();?>babyM/BabyWeightPDF/<?php echo $value1['id'] ?>">DailyWeight PDF</a>
                                            <a class="dropdown-item" href="<?php echo base_url();?>babyM/BabyKmcPDF/<?php echo $value1['id'] ?>">DailyKMC PDF</a>
                                            <a class="dropdown-item" href="<?php echo base_url();?>babyM/BabyFeedingPDF/<?php echo $value1['id'] ?>">Feeding PDF</a>
                                            <?php if($value1['status'] == '2') { ?>
                                              <a class="dropdown-item" href="<?php echo base_url();?>babyM/BabyDischargePdf/<?php echo $value1['id'] ?>">Discharged PDF</a>
                                            <?php } ?>
                                          </div>
                                        </div>

                                        
                                      </td>
                                      <td><?php echo '<span style="left:70%;position:relative;top:16px">'.$icon.'</span><span class="hover-image cursor-pointer" onclick="showBabyImage('.$url.')">'.$babyPhoto; ?></span></td>
                                      <td><?php echo $babyOf; ?></td>
                                      <td><?php echo $babyFileId; ?></td>
                                      <td><?php echo $deliveryDateT ?></td>
                            
                                      <td><a class="tooltip nonclick_link"><?php echo $reg_date; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($value1['addDate'])) ?></span></a></td>
                                      <td><?php if($LstMonitoring != 'N/A') { ?> 
                                        <a class="tooltip nonclick_link"><?php echo $LstMonitoring; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($get_last_assessment['addDate'])) ?></span></a>
                                      <?php } else { echo $LstMonitoring; } ?></td>
                                      
                                      
                                    </tr>
                                 <?php $counter ++ ; } ?>
                                    
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
                        <p class="mt-1 black pull-left">*A : Admitted, R : Referred, DC : Discharge</p>
                        <p class="mt-1 black pull-right"><b>Temperature:</b> (< 95.9 - > 99.5) |  <b>SpO2:</b> (< 95) |  <b>Pulse Rate:</b> (< 75 - > 200) |  <b>Respiratory Count:</b> (< 30 - > 60)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

<script type="text/javascript">
  function openSubFilterBox(val){
    if(val == "2"){
      $('#dischargeTypeFilterBox').show();
      $('#admissionTypeFilterBox').hide();
    }else if(val == "1" || val == "3"){
      $('#admissionTypeFilterBox').show();
      $('#dischargeTypeFilterBox').hide();
    }else{
      $('#dischargeTypeFilterBox').hide();
      $('#admissionTypeFilterBox').hide();
    }
  }

  $( document ).ready(function() {
    var searchDate = '<?php echo $fromDate; ?>';
    if(searchDate != ""){
      $('#fromDate').val(searchDate);
    }else{
      $('#fromDate').val("");
    }
    
  });
</script>

