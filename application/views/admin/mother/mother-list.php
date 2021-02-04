

    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">


<?php
  $loungeId      = $this->uri->segment('3');
  $GetFacility   = $this->FacilityModel->GetFacilitiesID($loungeId);
  
    if($GetFacility['type'] == 1){
      $regNumberHeading   = "SNCU&nbsp;Reg.&nbsp;Number";
    }else{
      $regNumberHeading   = "Reg.&nbsp;No.";
    }
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

  if(isset($_GET['motherStatus'])){
    $motherStatus = $_GET['motherStatus']; 
  } else {
    $motherStatus = '';
  }
?>



<!-- Column selectors with Export Options and print table -->
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-6 pull-left">
                      <h5 class="content-header-title float-left pr-1 mb-0">Mothers</h5>
                      <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0 breadcrumb-white">
                          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                          </li>
                          <li class="breadcrumb-item active">Mothers
                          </li>
                        </ol>
                      </div>
                    </div>
                    <div class="col-6 pull-right">
                        <p>Resources [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/ManageMotherDFD.png', 'Mothers Data Flow Diagram (DFD)')">Data Flow Diagram</a>] [<a href="javascript:void(0)" onclick="facilityDfd('<?php echo base_url(); ?>assets/dfdAndFunctionalDiagram/MotherRegistrationProcess.png', 'Mothers Functional Diagram')">Functional Diagram</a>]</p>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        
                        <div id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
                        <div class="row search pl-1">
                          <div class="col-md-12">
                            <form action="" method="GET">
                              <div class="row">
                                <div class="col-md-10">
                                  <div class="row">
                                    <div class="col-md-2 p-0">
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control pickadate-months-year" placeholder="Start Date" name="fromDate" value="<?= $fromDate; ?>">
                                        <div class="form-control-position calendar-position">
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                      </fieldset>
                                    </div>
                                    <div class="col-md-2 p-0">
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control pickadate-months-year" placeholder="End Date" name="toDate" value="<?= $toDate; ?>">
                                        <div class="form-control-position calendar-position">
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                      </fieldset>
                                    </div>
                                    <div class="col-md-2 p-0">
                                      <select class="select2 form-control" name="district" onchange="getFacility(this.value, '<?php echo base_url('loungeM/getFacility/') ?>')">
                                        <option value="">Select District</option>
                                        <?php
                                          foreach ($GetDistrict as $key => $value) {?>
                                            <option value="<?php echo $value['PRIDistrictCode']; ?>" <?php if($district == $value['PRIDistrictCode']) { echo 'selected'; } ?>><?php echo $value['DistrictNameProperCase']; ?></option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                    <div class="col-md-2 p-0">
                                      <select class="select2 form-control" name="facilityname" id="facilityname" onchange="getLounge(this.value, '<?php echo base_url('motherM/getLounge/') ?>'), getNurse(this.value, '<?php echo base_url('motherM/getNurse/') ?>')">
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
                                <div class="col-md-2 p-0">
                                  <div class="col-md-12 p-0">
                                      <select class="select2 form-control" name="motherStatus" id="motherStatus">
                                        <option value="">Select Status</option>
                                        <option value="admitted" <?php echo ($motherStatus == 'admitted') ? 'selected' : ''; ?>>Admitted</option>
                                        <option value="referred" <?php echo ($motherStatus == 'referred') ? 'selected' : ''; ?>>Referred</option>
                                        <option value="dischargedMother" <?php echo ($motherStatus == 'dischargedMother') ? 'selected' : ''; ?>>Discharged</option>
                                        <option value="notAdmtted" <?php echo ($motherStatus == 'notAdmtted') ? 'selected' : ''; ?>>Not Admitted</option>
                                      </select>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-8 p-0">
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
                        <div class="table-responsive" style="overflow-y: hidden;">
                            <table class="table table-striped dataex-html5-selectors-mother">
                                <thead>
                                    <tr>
                                      <th style="padding: 1.15rem 1.25rem;">S&nbsp;No.</th>
                                      <th style="padding: 1.15rem 1.25rem;">Status</th> 
                                      <th style="padding: 1.15rem 1.25rem;">Reason</th> 
                                      <th>Action</th>
                                      <th>District</th>
                                      <th>Facility</th>
                                      <?php if($loungeId == 'all'){ ?>
                                        <th>Lounge</th>
                                      <?php } ?>
                                      <th>Nurse</th>  
                                      <th>Mother's Name</th>
                                      <th>Mother's Photo</th>
                                      <th>Infant's Photo</th>
                                      <!-- <th><?php echo $regNumberHeading; ?></th> -->
                                      <th>Reg.&nbsp;At</th>  
                                      <th>Assessment&nbsp;At</th>  
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                  ($pageNo == '1') ? $counter = '1' : $counter = ((($pageNo*DATA_PER_PAGE)-DATA_PER_PAGE) + 1); 
                                  $chkArr = array();
                                  foreach ($results as $val) { 
                                    //if (in_array($val['motherId'], $chkArr) == false) {
                                    $getAdmissionData     = $this->MotherModel->GetMotherAdmission($val['motherId']); 
                                    
                                    $get_last_assessment = array();
                                    if(!empty($getAdmissionData)){
                                      $get_last_assessment  = $this->MotherModel->GetLastAsessmentBabyOrMother('motherId',$getAdmissionData['id']); 
                                    }
                                    $GetAllBaby           = $this->MotherModel->GetAllBabiesViaMother('babyRegistration',$val['motherId']);
                                    $GetAllBabies         = $this->MotherModel->getMotherData('babyRegistration',$val['motherId']);
                                    $latestAdmitBaby      = $this->MotherModel->getBabyAdmission($GetAllBabies[0]['babyId']);

                                    if(!empty($getAdmissionData)){
                                      $GetFacility   = $this->FacilityModel->GetFacilitiesID($getAdmissionData['loungeId']);
                                    } else {
                                       $GetFacility   = $this->FacilityModel->GetFacilitiesID($latestAdmitBaby['loungeId']); 
                                    }
                                    // mother danger sign
                                    $Facility = $this->db->query("SELECT * FROM `facilitylist` where FacilityID='".$GetFacility['facilityId']."'")->row_array();
                                    $District = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$Facility['PRIDistrictCode']."'")->row_array();
                                      // set mother name
                                      if($val['type'] == '1' || $val['type'] == '3'){

                                        if(!empty($val['motherAge'])) {
                                          $motherAge = 'Age: '.$val['motherAge'].' years';
                                        } else if(!empty($val['motherDOB'])) {
                                          $date1 = date_create(date("Y-m-d",strtotime($val['motherDOB']))); 
                                          $date2 = date_create(date("Y-m-d"));
                                          $diff  = date_diff($date1 , $date2);
                                          $motherAge = 'Age: '.$diff->format("%y years, %m month, %d days");
                                        } else{
                                          $motherAge = 'N/A';
                                        }
                                        $motherName = (empty($val['motherName'])) ? 'N/A' : $val['motherName'];
                                      } else {
                                        $motherName     = "UNKNOWN";
                                      }

                                      // mother icon
                                      if(!empty($get_last_assessment)){
                                        $motherIconStatus     = $this->DangerSignModel->getMotherIcon($get_last_assessment); 
                                        if($motherIconStatus == '1'){
                                          $mother_icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
                                          $topMargin = "";
                                        } else if($motherIconStatus == '0'){
                                          $mother_icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                                          $topMargin = "";
                                        } else {  $mother_icon='';
                                          $topMargin = "margin-top:5%";
                                        }
                                      } else {
                                        $mother_icon='';
                                        $topMargin = "margin-top:5%";
                                      }
                                    // set mother picture
                                     $motherPicture = empty($val['motherPicture']) ? base_url()."assets/images/user.png" : motherDirectoryUrl.$val['motherPicture'];

                                    // set total babies of mother
                                      if($GetAllBaby == 0){
                                        $totalBabies = 0;
                                      }else{
                                        $totalBabies = "<a href='".base_url()."BabyManagenent/registeredBaby/particularMother/".$loungeId."/".$val['motherId']."'>".$GetAllBaby."</a>";
                                      }
                                      
                                    // Last monitoring date
                                      if(!empty($get_last_assessment)) {
                                        $lastAssessment = (!empty($get_last_assessment['addDate'])) ? $this->FacilityModel->time_ago_in_php($get_last_assessment['addDate']) :'N/A';
                                      } else {
                                        $lastAssessment = 'N/A';
                                      }
                                         
                                        
                                        // set mother status
                                         if($val['type'] == '1') { 
                                             $motherStatus = '<span class="badge badge-pill badge-light-success mr-1 mb-span"> L</span>';
                                         } else if($val['type'] == '2') { 
                                            $motherStatus =  '<span class="badge badge-pill badge-light-warning mr-1 mb-span"> U</span>';
                                           } else if($val['type'] == '3') {
                                            //$motherStatus =  '<span class="badge badge-pill badge-light-danger mr-1 mb-span"> O</span>';
                                            $motherStatus =  '';
                                         } 

                                        if($val['isMotherAdmitted']=='Yes') { 
                                          if($getAdmissionData['status'] == 1){
                                            $motherStatus2 = '<span class="badge badge-pill badge-light-warning mr-1 mb-span"> A</span>';
                                          } else if($getAdmissionData['status'] == 2){
                                            $getLastBabyId = $this->db->query("select br.`babyId` from babyRegistration as br inner join motherRegistration as mr on br.`motherId` = mr.`motherId` where mr.`motherId`=".$val['motherId']." order by br.`babyId` desc limit 1")->row_array();
                                            $getPdfName = $this->db->query("select babyDischargePdfName from babyAdmission where babyId=".$getLastBabyId['babyId']." order by id desc limit 1")->row_array(); 
                                            $typeOfDischarge = $getAdmissionData['typeOfDischarge'];
                                            $motherStatus2 = "<span class='badge badge-pill badge-light-success mr-1 mb-span'> DC</span>
                                             <a href='".base_url()."assets/PdfFile/".$getPdfName['babyDischargePdfName']."'target='_blank' style='font-size:10px;'>View Report</a>";
                                              if($typeOfDischarge == 'Referral') {
                                                $motherStatus2 = "<span class='badge badge-pill badge-light-success mr-1 mb-span'> DC (R)</span>
                                                <a href='".base_url()."assets/PdfFile/".$getPdfName['babyDischargePdfName']."'target='_blank' style='font-size:10px;'>View Report</a>";
                                              }
                                          } else if($getAdmissionData['status'] == 3){
                                            $motherStatus2 = '<span class="badge badge-pill badge-light-info mr-1 mb-span"> R</span>';
                                          }
                                        } else {
                                         $motherStatus2 = '<span class="badge badge-pill badge-light-danger mr-1 mb-span">NA</span>';
                                        }
                                       

                                      //  echo "<b>".$val['Type'];exit;
                                      $getTotalBabys = ""; 
                                      $getTotalBabys .= '<div class="row" style="width:200px !important;margin-bottom:inherit;" >';
                                      $defaultImage = base_url('assets/images/baby.png');

                                      foreach ($GetAllBabies as $key => $vals) {

                                        // Baby icon
                                        $latestAdmitBaby      = $this->MotherModel->getBabyAdmission($vals['babyId']);
                                        $get_baby_last_assessment = $this->BabyModel->getMonitoringExistData($latestAdmitBaby['id']);
                                        $babyIconStatus      = $this->DangerSignModel->getBabyIcon($get_baby_last_assessment);

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
                                        /************/
                                        
                                        $babyPhoto    = empty($vals['babyPhoto']) ? $defaultImage : babyDirectoryUrl.$vals['babyPhoto'];

                                        $this->db->order_by('id','desc');
                                        $getbabyAdmisionId = $this->db->get_where('babyAdmission',array('babyId'=>$vals['babyId']))->row_array();
                                        $getTotalBabys .= "<div class='col-sm-4'><a href='".base_url()."babyM/viewBaby/".$getbabyAdmisionId['id']."/".$vals['status']."'><span style='left:55%;position:relative;top:16px'>".$icon."</span><img src='".$babyPhoto."' width='45' height='45' style='margin-bottom: 2px;'></a></div>";

                                        if($key == 0){
                                          $nurseId = $getbabyAdmisionId['staffId'];
                                        }
                                      }
                                      $getTotalBabys .= '</div>&nbsp;'; 
                                      
                                      if(!empty($nurseId)) {
                                        $getStaffName = $this->db->get_where('staffMaster',array('staffId'=>$nurseId))->row_array();
                                        $nurseName = $getStaffName['name']; 
                                      } else {
                                        $nurseName = 'N/A';
                                      }
                                        

                                      $reg_date          = $this->FacilityModel->time_ago_in_php($val['addDate']);
                                      $url = $motherPicture;
                                    ?>
                                    <tr>
                                      <td style="padding: 1.15rem 1.25rem;"><?php echo $counter; ?></td>
                                      <td style="padding: 1.15rem 1.25rem;"><?php echo $motherStatus.' '.$motherStatus2; ?></td>
                                      <td><?php echo empty($val['notAdmittedReason']) ? 'N/A' : $val['notAdmittedReason']; ?></td>
                                      <td><a href="<?php echo base_url() ?>motherM/viewMother/<?= $val['motherId'] ?>" class="btn btn-sm btn-info">View</a></td>
                                      <td><?php echo $District['DistrictNameProperCase']; ?></td>
                                      <td><?php echo $Facility['FacilityName']; ?></td>
                                      <?php if($loungeId == 'all'){ ?>
                                        <td><?= $GetFacility['loungeName']; ?></td>
                                      <?php } ?>
                                      <td><?php echo $nurseName; ?></td>
                                      
                                      
                                      <!-- <td><?php 

                                      echo '<span style="left:78%;position:relative;top:3px;">'.$icon.'</span>'.$motherPicture; ?></td> -->
                                      <td><?php echo $motherName; ?><!-- <span class="hover-image" onclick="showMotherImage('<?= $url ?>')"><i class="bx bx-paperclip cursor-pointer mr-50"></i></span> --></td>
                                      <td style="vertical-align: middle;">
                                        <?php if(!empty($val['motherPicture'])){ ?>
                                          <span style="left:50%;position:relative;top:16px;"><?php echo $mother_icon; ?></span><img src="<?= $url ?>" onclick="showMotherImage('<?= $url ?>')" width="45" height="45" style="cursor: pointer;margin-bottom:auto;">
                                        <?php }else{ echo "N/A"; } ?>
                                      </td>
                                      
                                      <td><?php echo $getTotalBabys; ?></td>
                                      <!-- <td><?php echo $HospitalNo; ?></td> -->
                                      
                                      
                                      <td><a class="tooltip nonclick_link"><?php echo $reg_date; ?><span class="tooltiptext"><?php echo date("m/d/y, h:i A",strtotime($val['addDate'])) ?></span></a></td>
                                      <td><?php echo $lastAssessment; ?></td>
                                      
                                    </tr>
                                  
                                <?php array_push($chkArr, $val['motherId']); $counter ++ ; } //} ?>
                                    
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
                    
                    <p class="mt-1 black pull-left">*L : Live, A : Admitted, R : Referred, NA : Not Admitted, DC : Discharge</p>
                    <p class="mt-1 black pull-right"><b>Temperature:</b> (< 95.9 - > 99.5) | <b>Pulse Rate:</b> (< 50 - > 120) |  <b>Systolic:</b> (>= 140 - <= 90) | <b>Diastolic:</b> (>= 90 - <= 60)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Column selectors with Export Options and print table -->

