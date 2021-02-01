<style type="text/css">
.project-tab .nav-link {
  font-size: 13px !important;
}
.project-tab .nav-link{
  padding-left: 11px !important;padding-right: 11px !important;
}
</style>
   
    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">

  <?php  
      $getFourLevelVar = $this->uri->segment(4);
      $getPdfLink          = $this->load->BabyModel->getBabyRecord($babyData['babyId']); 

      // set baby file id and sncu number respect of type
      $GetFacility = $this->FacilityModel->GetFacilitiesID($babyAdmissionData['loungeId']);
        if($GetFacility['type'] == 1){
          $babyRegNumberHeading   = "SNCU&nbsp;Reg.&nbsp;Number";
          $babyFileId             = !empty($getPdfLink['temporaryFileId']) ? $getPdfLink['temporaryFileId'] : 'N/A';
        }else{
          $babyRegNumberHeading   = "Infant&nbsp;File&nbsp;ID";
          $babyFileId             = !empty($getPdfLink['babyFileId']) ? $getPdfLink['babyFileId'] : 'N/A';
      }
      // end setup file id

      $GetLounge           = $this->load->FacilityModel->GetFacilitiesID($getPdfLink['loungeId']);
      //$get_last_assessment = $this->FacilityModel->GetBabyDanger($babyData['BabyID']);
      $get_last_assessment = $this->BabyModel->getMonitoringExistData($babyAdmissionData['babyId'],$babyAdmissionData['id'],$babyAdmissionData['loungeId']);
      $babyIconStatus      = $this->DangerSignModel->getBabyIcon($get_last_assessment);

      if($babyIconStatus == '1') {
        $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
      }else if($babyIconStatus == '0'){
        $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
      }else{
        $icon ="";
      }
       
      $MotherName = $this->load->BabyModel->getMotherDataById('motherRegistration',$babyData['motherId']);
      
  ?>


<!-- Input Validation start -->
<section class="input-validation">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0">View Infant Details</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>babyM/registeredBaby/1/all">Infants</a>
                </li>
                <li class="breadcrumb-item active">View Infant Details
                </li>
              </ol>
              <p style="float: right;  color: black;">Infant of<b>&nbsp;<?php echo ($MotherName['motherName'] != "") ? ucwords($MotherName['motherName']).' ('.$GetLounge['loungeName'].')' : "Unknown Mother (".$GetLounge['loungeName'].")";?></b>
                <span style="">[<?php echo $babyRegNumberHeading; ?>:&nbsp;<?php echo $babyFileId; ?>]</span>
              </p>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <section id="tabs" class="project-tab">
            <div class="container" style="padding: 0;">
                <div class="row">
                    <div class="col-md-12">
                      <div class="scroller scroller-left"><i class="bx bx-chevron-left"></i></div>
                        <div class="scroller scroller-right"><i class="bx bx-chevron-right"></i></div>
                          <div class="wrapper">
                            <nav>
                                <div class="nav nav-tabs nav-fill list" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-birth-info-tab" data-toggle="tab" href="#nav-birth-info" role="tab" aria-controls="nav-birth-info" aria-selected="true">Birth Info</a>
                                  
                                    <a class="nav-item nav-link" id="nav-assessment-tab" data-toggle="tab" href="#nav-assessment" role="tab" aria-controls="nav-assessment" aria-selected="false">Assessment</a>
                                    <a class="nav-item nav-link" id="nav-baseline-tab" data-toggle="tab" href="#nav-baseline" role="tab" aria-controls="nav-baseline" aria-selected="true">Baseline Info</a>
                                    <a class="nav-item nav-link" id="nav-daily-weight-tab" data-toggle="tab" href="#nav-daily-weight" role="tab" aria-controls="nav-daily-weight" aria-selected="false">Daily Wgt</a>
                                    <a class="nav-item nav-link" id="nav-kmc-position-tab" data-toggle="tab" href="#nav-kmc-position" role="tab" aria-controls="nav-kmc-position" aria-selected="false">KMC Position</a>
                                    <a class="nav-item nav-link" id="nav-nutrition-tab" data-toggle="tab" href="#nav-nutrition" role="tab" aria-controls="nav-nutrition" aria-selected="false">Nutrition</a>
                                    <a class="nav-item nav-link" id="nav-investigation-tab" data-toggle="tab" href="#nav-investigation" role="tab" aria-controls="nav-investigation" aria-selected="false">Investigation</a>
                                    <a class="nav-item nav-link" id="nav-treatment-tab" data-toggle="tab" href="#nav-treatment" role="tab" aria-controls="nav-treatment" aria-selected="false">Treatment</a>
                                    <a class="nav-item nav-link" id="nav-vaccination-tab" data-toggle="tab" href="#nav-vaccination" role="tab" aria-controls="nav-vaccination" aria-selected="false">Vaccine</a>
                                    <a class="nav-item nav-link" id="nav-doctor-round-tab" data-toggle="tab" href="#nav-doctor-round" role="tab" aria-controls="nav-doctor-round" aria-selected="false">Doc Round</a>
                                    <a class="nav-item nav-link" id="nav-comment-tab" data-toggle="tab" href="#nav-comment" role="tab" aria-controls="nav-comment" aria-selected="false">Comment</a>
                                  <?php if($getPdfLink['status'] == '2'){ ?>
                                    <a class="nav-item nav-link" id="nav-discharge-tab" data-toggle="tab" href="#nav-discharge" role="tab" aria-controls="nav-discharge" aria-selected="false">Discharge</a>
                                  <?php } ?> 
                                </div>
                            </nav>
                          </div>
                        </div>
                      </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-birth-info" role="tabpanel" aria-labelledby="nav-birth-info-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Infant Birth Information</h5>
                                  <?php if($babyAdmissionData['babyPdfFileName'] != '') { ?>
                                    <div class="float-right mt-1">Admission Form Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyPdfFileName'];?>" style="color: #3c8dbc;">Download</a></div>
                                    
                                  <?php } ?>
                                </div>

                                <div class="row col-12">
                                  <div class="col-md-4">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Infant's Photo </label>
                                        <?php if(empty($babyData['babyPhoto'])){
                                                $img_url = base_url().'assets/images/baby.png';
                                              } else {
                                                $img_url = babyDirectoryUrl.$babyData['babyPhoto'];
                                              }
                                        ?>

                                        <div class="set_div_img00" id="" style="padding: 5px 1px;">
                                          <span class="hover-image cursor-pointer" onclick="showBabyImage('<?= $img_url; ?>')">
                                            <img src="<?php echo $img_url; ?>" class="img-responsive" alt="img">
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Baby Birth Weight Available </label>
                                        <div class="controls">
                                          <?php  if($babyData['birthWeightAvail']=='1') { ?>
                                            <input type="text" class="form-control" value="<?php echo 'Yes';?>" readonly placeholder="Baby Birth Weight Available">
                                          <?php } 
                                              else if($babyData['birthWeightAvail']=='2') { ?>
                                            <input type="text" class="form-control" value="<?php echo 'No';?>" readonly placeholder="Baby Birth Weight Available">
                                            <br/>
                                            <textarea cols="3" rows="3" readonly class="form-control"><?php echo $babyData['reason'];?></textarea>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div> -->
                                    
                                  </div>
                                  <div class="col-md-4">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label><?php echo $babyRegNumberHeading; ?> </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyFileId; ?>" readonly placeholder="<?php echo $babyRegNumberHeading; ?>">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Delivery Time </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo date('g:i A',strtotime($babyData['deliveryTime'])); ?>" readonly placeholder="Delivery Time">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Infant Birth Weight in grams </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyData['babyWeight']?>" readonly placeholder="Infant Birth Weight in grams">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Type Of Admission </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyData['typeOfBorn']?>" readonly placeholder="Type Of Admission">
                                        </div>
                                      </div>
                                    </div>          
                                  </div>
                                  <div class="col-md-4">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Delivery Date (dd-mm-yyyy) </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo date("d-m-Y",strtotime($babyData['deliveryDate'])); ?>" readonly placeholder="Delivery Date (dd-mm-yyyy)">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Sex</label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyData['babyGender']?>" readonly placeholder="Sex">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Delivery Type</label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyData['deliveryType']?>" readonly placeholder="Delivery Type">
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>
                                          <?php if($babyData['typeOfBorn'] == "Inborn"){ echo "In Which Ward Infant was before"; }else{ echo "Birth place of the Infant"; } ?>
                                        </label>
                                        <div class="controls">
                                          <textarea class="form-control" readonly><?php if(($babyAdmissionData['infantComingFrom'] == 'Other') || ($babyAdmissionData['infantComingFrom'] == 'अन्य')){ echo $babyAdmissionData['infantComingFromOther']; }else{ echo $babyAdmissionData['infantComingFrom']; } ?></textarea>
                                        </div>
                                      </div>
                                    </div>  
                                    
                                  </div>
                                </div>
              
                                <div class="row col-12">
                                  
                                    
                                    
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Baby's MCTS ID </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyData['babyMCTSNumber']?>" readonly placeholder="Baby's MCTS ID">
                                        </div>
                                      </div>
                                    </div> -->
                                    
                                    
                                </div>
                                <div class="row col-12">
                                    
                                    
                                    
                                    
                                </div>
                                <div class="row col-12">
                                    
                                    
                                    
                                </div>
                                <div class="row col-12">
                                    
                                    
                                    <!-- <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Did the Baby cry immediately after birth?</label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyData['babyCryAfterBirth']?>" readonly placeholder="Did the Baby cry immediately after birth?">
                                        </div>
                                      </div>
                                    </div> -->
                                </div>
                                
                                <?php if($MotherName['motherName'] == ''){ ?>
                                  <h5 class="float-left mb-2 mt-1 pr-1">Organisation Information</h5>
                                  <div class="row col-12">
                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Guardian Name </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo $MotherName['guardianName'] != "Inborn" ? $MotherName['guardianName'] : "N/A"?>" readonly placeholder="Guardian Name">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Guardian Contact Number </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo $MotherName['guardianNumber'] != "Inborn" ? $MotherName['guardianNumber'] : "N/A"?>" readonly placeholder="Guardian Contact Number">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Organisation Name </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo $MotherName['organisationName'] != "Inborn" ? $MotherName['organisationName'] : "N/A"?>" readonly placeholder="Organisation Name">
                                          </div>
                                        </div>
                                      </div>
                                      
                                  </div>
                                  <div class="row col-12">
                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Organisation Number </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo $MotherName['organisationNumber'] != "Inborn" ? $MotherName['organisationNumber'] : "N/A"?>" readonly placeholder="Organisation Number">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Organisation Address </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo $MotherName['organisationAddress'] != "Inborn" ? $MotherName['organisationAddress'] : "N/A"?>" readonly placeholder="Organisation Address">

                                         

                                          </div>
                                        </div>
                                      </div>

                                  </div>
                                <?php } ?>
                                
                            </div>


                            <div class="tab-pane fade" id="nav-assessment" role="tabpanel" aria-labelledby="nav-assessment-tab">
                              <div class="table-responsive">
                                  <table class="table ">
                                      <thead>
                                        <?php $getBaby = $this->load->BabyModel->getBabysBYAdmisionId($babyData['babyId'],$babyAdmissionData['id']);
                                          $count = count($getBaby)+1;
                                        ?>

                                        <tr>
                                          <th>Value</th>
                                          <?php $c = 1; if(!empty($getBaby)){ foreach($getBaby as $key => $value) { ?>
                                            <th>Assesment <?= $c; ?></th>
                                          <?php $c++; } } else {
                                            echo '<th style="text-align:center;">Assesment</th>';
                                          } ?>
                                        </tr> 
                                      </thead>
                                      <tbody>

                                  <tr>
                                    <td><b>Assesment&nbsp;Date<br>&&nbsp;Time</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo (($value['assesmentDate'] != '') ? date('d-m-Y',strtotime($value['assesmentDate'])) : "N/A").'<br>'.(($value['assesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['assesmentTime']))) : "N/A");?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Type</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td> <?php echo($value['type'] == '1') ? "Monitoring" : "Discharged"; ?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Staff Name</b></td>
                                    <?php foreach($getBaby as $key => $value) {
                                         $staffName = $this->load->BabyModel->getStaffNameBYID($value['staffId']);
                                     ?>
                                      <td><?php (empty($staffName['name'])) ? $staffName = "N/A" : $staffName = $staffName['name']; ?>
                                         <?php echo $staffName; ?>
                                       </td>     
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td colspan="<?= $count; ?>" class="td-heading">Temperature</td>
                                  </tr>

                                  <tr>
                                    <td><b>Is&nbsp;Thermometer&nbsp;Available</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['isThermometerAvailable']) ? $value['isThermometerAvailable'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Reason</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td>
                                      <?php if($value['isThermometerAvailable'] == "No"){ 
                                              if(!empty($value['reasonValue']) && $value['reasonValue'] != "Other"){ echo $value['reasonValue']; }elseif($value['reasonValue'] == "Other"){ echo $value['otherValue']; }else{ echo "N/A"; }
                                            }else{ echo "N/A"; }
                                      ?>
                                     </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Temperature (<sup>0</sup>F)</b></td>
                                    <?php $c = 1; foreach($getBaby as $key => $value) { 
                                      if(!empty($value['temperatureValue'])){
                                      if (($value['temperatureUnit'] == "F") && ($value['temperatureValue'] < 95.9 || $value['temperatureValue'] > 99.5)) { ?>
                                        <td style="color:red;"> <?php echo $value['temperatureValue'].'&nbsp;<sup>0</sup>'.$value['temperatureUnit'].'';?> </td>
                                    <?php }elseif (($value['temperatureUnit'] == "C") && ($value['temperatureValue'] < 32.2 || $value['temperatureValue'] > 41.6)) { ?>
                                        <td style="color:red;"> <?php echo $value['temperatureValue'].'&nbsp;<sup>0</sup>'.$value['temperatureUnit'].'';?> </td>
                                    <?php } else { ?>
                                      <td> <?php echo ($value['temperatureValue'] != "") ? $value['temperatureValue']."&nbsp;<sup>0</sup>".$value['temperatureUnit']."" : "N/A";?></td>
                                    <?php } }else{ ?>
                                      <td> <?php echo "N/A";?></td>
                                    <?php } } ?>
                                  </tr> 

                                  <tr>
                                    <td colspan="<?= $count; ?>" class="td-heading">Respiratory Count</td>
                                  </tr> 

                                  <tr>
                                    <td><b>Respiratory&nbsp;Rate</b></td>
                                    <?php foreach($getBaby as $key => $value) {
                                      if(!empty($value['respiratoryRate'])){
                                      if ($value['respiratoryRate'] < 30 || $value['respiratoryRate'] > 60) { ?>
                                        <td style="color:red;"> <?php echo $value['respiratoryRate'].'/min';?> </td>
                                      <?php } else { ?>
                                        <td> <?php echo ($value['respiratoryRate'] != "") ? ($value['respiratoryRate']."/min") : "N/A";?></td>
                                    <?php } }else{ ?>
                                      <td><?php echo "N/A"; ?></td>
                                    <?php } } ?>
                                  </tr>

                                  <tr>
                                    <td colspan="<?= $count; ?>" class="td-heading">Pulse Oximetry</td>
                                  </tr>

                                  <tr>
                                    <td><b>Pulse&nbsp;Oximeter&nbsp;Device&nbsp;Available</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['isPulseOximatoryDeviceAvail']) ? $value['isPulseOximatoryDeviceAvail'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>  

                                  <tr>
                                    <td><b>Reason</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td>
                                      <?php if($value['isPulseOximatoryDeviceAvail'] == "No"){ 
                                              if(!empty($value['pulseReasonValue']) && $value['pulseReasonValue'] != "Other"){ echo $value['pulseReasonValue']; }elseif($value['pulseReasonValue'] == "Other"){ echo $value['pulseOtherValue']; }else{ echo "N/A"; }
                                            }else{ echo "N/A"; }
                                      ?>
                                     </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>SpO2(%)</b></td>
                                    <?php foreach($getBaby as $key => $value) {
                                      if(!empty($value['spo2'])){
                                      if ($value['spo2'] < 95) { ?>
                                        <td style="color:red;"> <?php echo $value['spo2'].'%';?> </td>
                                      <?php } else { ?>
                                        <td> <?php echo ($value['spo2'] != "") ? ($value['spo2']."%") : "N/A";?></td>
                                    <?php } }else{ ?>
                                      <td><?php echo "N/A"; ?></td>
                                    <?php } } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Pulse&nbsp;Rate(bpm)</b></td>
                                    <?php foreach($getBaby as $key => $value) {
                                      if(!empty($value['pulseRate'])){
                                      if ($value['pulseRate'] < 75 || $value['pulseRate'] > 200) { ?>
                                        <td style="color:red;"> <?php echo $value['pulseRate'].'&nbsp;bpm';?> </td>
                                      <?php } else { ?>
                                        <td> <?php echo ($value['pulseRate'] != "") ? ($value['pulseRate']."&nbsp;bpm") : "N/A";?></td>
                                    <?php } }else{ ?>
                                      <td><?php echo "N/A"; ?></td>
                                    <?php } } ?>
                                  </tr>

                                  <tr>
                                    <td colspan="<?= $count; ?>" class="td-heading">Capillary Refill Time</td>
                                  </tr>

                                  <tr>
                                    <td><b>Capillary&nbsp;Refill&nbsp;Time (CRT)&nbsp;Knowledge</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['crtKnowledge']) ? $value['crtKnowledge'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Is&nbsp;CRT&nbsp;Greater&nbsp;than 3 secs</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['isCrtGreaterThree']) ? $value['isCrtGreaterThree'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>


                                  <tr>
                                    <td><b>Gestational&nbsp;Age</b></td>
                                    <!-- <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['gestationalAge']) ? $value['gestationalAge'] : 'N/A'; ?></td>
                                    <?php } ?> -->
                                    
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php if($key != 0){ echo "N/A"; }else{ echo !empty($babyAdmissionData['gestationalAge']) ? $babyAdmissionData['gestationalAge'] : 'N/A'; } ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Alertness</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['alertness']) ? $value['alertness'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Muscle&nbsp;Tone</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['tone']) ? $value['tone'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Color</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['color']) ? $value['color'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>


                                  <tr>
                                    <td><b>Apnea</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['apneaOrGasping']) ? $value['apneaOrGasping'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Grunting</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['grunting']) ? $value['grunting'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Chest&nbsp;Indrawing</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['chestIndrawing']) ? $value['chestIndrawing'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>
                                      

                                  <tr>
                                    <td><b>Interest&nbsp;In&nbsp;Feeding</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['interestInFeeding']) ? $value['interestInFeeding'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>


                                  <tr>
                                    <td><b>Is&nbsp;Mother&nbsp;Having&nbsp;Sufficient&nbsp;Lactation</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['sufficientLactation']) ? $value['sufficientLactation'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Sucking</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['sucking']) ? $value['sucking'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Umbilicus</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['umbilicus']) ? $value['umbilicus'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Skin rash or Pustules</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['skinPustules']) ? $value['skinPustules'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Is&nbsp;Any&nbsp;Complication&nbsp;At Birth</b></td>
                                      <?php foreach($getBaby as $key => $value) { ?>
                                      <td>
                                        <?php
                                        if($key != 0){ echo "N/A";}
                                        else{
                                          $data =json_decode($babyAdmissionData['isAnyComplicationAtBirth'], true);
                                             if(!empty($data) && count($data) > 0){
                                                $count=1; ?>
                                                <?php 
                                                   foreach ($data as $key => $val) {?>
                                                      <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></br/>
                                                     <?php } ?>
                                       <?php } else { ?>
                                            <?php echo 'N/A';?>
                                         <?php } }?> 
                                      </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Bulging&nbsp;Anterior&nbsp;Fontanelle</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['bulgingAnteriorFontanel']) ? $value['bulgingAnteriorFontanel'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Convulsions</b></td>
                                    <!-- <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['convulsions']) ? $value['convulsions'] : 'N/A'; ?></td>
                                    <?php } ?> -->
                                    <?php foreach($getBaby as $key => $value) { ?>
                                    <td><?php if($key != 0){ echo "N/A"; }else{ echo !empty($babyAdmissionData['convulsions']) ? $babyAdmissionData['convulsions'] : 'N/A'; } ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Bleeding&nbsp;From&nbsp;Any&nbsp;Site</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['isBleeding']) ? $value['isBleeding'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td colspan="<?= $count; ?>" class="td-heading">Micturition and Bowel Movements</td>
                                  </tr>

                                  <tr>
                                    <td><b>Urine passed in your shift</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['urinePassedIn24Hrs']) ? $value['urinePassedIn24Hrs'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Stool passed in your shift</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['stoolPassedIn24Hrs']) ? $value['stoolPassedIn24Hrs'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>








                                  <!-- <tr>
                                    <td><b>Is&nbsp;Weighing&nbsp;Machine&nbsp;Available</b></td>
                                    <?php if(!empty($getBaby)){ foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['isWeighingMachineAvailable']) ? $value['isWeighingMachineAvailable'] : 'N/A';?></td>
                                    
                                    <?php } } else {
                                      echo '<td style="text-align:center;">No Record Found.</td>';
                                    }  ?>
                                  </tr>

                                  <tr>
                                    <td><b>Baby&nbsp;Measured&nbsp;Weight</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['babyMeasuredWeight']) ? $value['babyMeasuredWeight'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>  

                                  <tr>
                                    <td><b>Weighing&nbsp;Image</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['weighingImage']) ? "<img src='".babyWeightDirectoryUrl.$value['weighingImage']."' style='width:100px;height:100px;'>" : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Weighing&nbsp;Machine&nbsp;Reason</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['weightMachineNotAvailReason']) ? $value['weightMachineNotAvailReason'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Is&nbsp;head&nbsp;Circumference</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['isHeadMeasurngTapeAvailable']) ? $value['isHeadMeasurngTapeAvailable'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Head&nbsp;Circumference&nbsp;Value</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['headCircumferenceVal']) ? $value['headCircumferenceVal'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Head&nbsp;Circumference&nbsp;Reason</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['measuringTapeNotAvailReason']) ? $value['measuringTapeNotAvailReason'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  




                                  

                                  <tr>
                                    <td><b>Blood Pressure</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['bloodPressure']) ? $value['bloodPressure'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  
                                  <tr>
                                    <td><b>O2 Flow Rate</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['flowRate']) ? $value['flowRate'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>FIO2</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['fl02']) ? $value['fl02'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>


                                  <tr>
                                    <td><b>Abdominal Girth</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['abdominalGirth']) ? $value['abdominalGirth'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>R.T. Aspirate</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['rtAspirate']) ? $value['rtAspirate'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>I.V. Patency</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['ivPatency']) ? $value['ivPatency'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Activity</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['activity']) ? $value['activity'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Levene's Score</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['levnesScore']) ? $value['levnesScore'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Downe's Score</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['downesScore']) ? $value['downesScore'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  

                                  <tr>
                                    <td><b>Other&nbsp;Complications</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['otherComplications']) ? $value['otherComplications'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  

                                  <tr>
                                    <td><b>Type&nbsp;Of&nbsp;Stool</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['typeOfStool']) ? $value['typeOfStool'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Is&nbsp;Baby&nbsp;Taking&nbsp;Breast&nbsp;Feeds</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['isBabyTakingBreastFeed']) ? $value['isBabyTakingBreastFeed'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>General&nbsp;Condition</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['generalCondition']) ? $value['generalCondition'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  
                                  

                                  <tr>
                                    <td><b>Is&nbsp;Jaundice</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['isJaundice']) ? $value['isJaundice'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Jaundice&nbsp;Value</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['jaundiceVal']) ? $value['jaundiceVal'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  
                                  

                                  <tr>
                                    <td><b>Abdominal&nbsp;Distension</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['abdominalDistension']) ? $value['abdominalDistension'] : 'N/A'; ?></td>    
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Cold&nbsp;Periphery</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['coldPeriphery']) ? $value['coldPeriphery'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Weak&nbsp;Pulse</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['weakPulse']) ? $value['weakPulse'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>
                                 
                                  <tr>
                                    <td><b>Specify&nbsp;Other</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['specifyOther']) ? $value['specifyOther'] : 'N/A'; ?></td>    
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Other&nbsp;observation/<br>comments</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['otherComment']) ? $value['otherComment'] : 'N/A'; ?></td>   
                                    <?php } ?>
                                  </tr> -->

                                  

                                  
                                  
                               </tbody>
                                  </table>
                              </div>
                            </div>

                            <div class="tab-pane fade show" id="nav-baseline" role="tabpanel" aria-labelledby="nav-baseline-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Baseline Information</h5>
                                  
                                </div>

              
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Infant's Weight </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyAdmissionData['babyAdmissionWeight']; ?>" readonly placeholder="Infant's Weight">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Infantometer Availability </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyAdmissionData['isLengthMeasurngTapeAvailable']?>" readonly placeholder="Infantometer Availability">
                                        </div>
                                      </div>
                                    </div>
                                    <?php if(!empty($babyAdmissionData['isLengthMeasurngTapeAvailable']) && $babyAdmissionData['isLengthMeasurngTapeAvailable'] == "Yes"){ ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Infant's Length (cm)</label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo $babyAdmissionData['lengthValue'] != "" ? $babyAdmissionData['lengthValue'] : "N/A"?>" readonly placeholder="Infant's Length">
                                          </div>
                                        </div>
                                      </div>
                                    <?php }else{ 
                                        if($babyAdmissionData['isLengthMeasurngTapeAvailable'] == "No"){ 
                                          if(!empty($babyAdmissionData['lengthMeasureNotAvlReason']) && $babyAdmissionData['lengthMeasureNotAvlReason'] != "Other"){ $lengthMeasureNotAvlReasonValue = $babyAdmissionData['lengthMeasureNotAvlReason']; }elseif($babyAdmissionData['lengthMeasureNotAvlReason'] == "Other"){ $lengthMeasureNotAvlReasonValue = $babyAdmissionData['lengthMeasureNotAvlReasonOther']; }else{ $lengthMeasureNotAvlReasonValue = "N/A"; }
                                        }else{ $lengthMeasureNotAvlReasonValue = "N/A"; }
                                    ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Reason</label>
                                          <div class="controls">
                                            <textarea class="form-control" readonly><?php echo $lengthMeasureNotAvlReasonValue; ?></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    <?php } ?>
                                </div>
                                
                                <div class="row col-12">
                                    
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Measuring Tape Availability </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $babyAdmissionData['isHeadMeasurngTapeAvailable']?>" readonly placeholder="Measuring Tape Availability">
                                        </div>
                                      </div>
                                    </div>

                                    <?php if(!empty($babyAdmissionData['isHeadMeasurngTapeAvailable']) && $babyAdmissionData['isHeadMeasurngTapeAvailable'] == "Yes"){ ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Head Circumference (cm)</label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo $babyAdmissionData['headCircumferenceVal'] != "" ? $babyAdmissionData['headCircumferenceVal'] : "N/A"?>" readonly>
                                          </div>
                                        </div>
                                      </div>
                                    <?php }else{ 
                                        if($babyAdmissionData['isHeadMeasurngTapeAvailable'] == "No"){ 
                                          if(!empty($babyAdmissionData['headMeasureNotAvlReason']) && $babyAdmissionData['headMeasureNotAvlReason'] != "Other"){ $headMeasureNotAvlReasonValue = $babyAdmissionData['headMeasureNotAvlReason']; }elseif($babyAdmissionData['headMeasureNotAvlReason'] == "Other"){ $headMeasureNotAvlReasonValue = $babyAdmissionData['headMeasureNotAvlReasonOther']; }else{ $headMeasureNotAvlReasonValue = "N/A"; }
                                        }else{ $headMeasureNotAvlReasonValue = "N/A"; }
                                    ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Reason</label>
                                          <div class="controls">
                                            <textarea class="form-control" readonly><?php echo $headMeasureNotAvlReasonValue; ?></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    <?php } ?>

                                </div>
                                
                            </div>

                            <div class="tab-pane fade" id="nav-daily-weight" role="tabpanel" aria-labelledby="nav-daily-weight-tab">
                              <?php $getBaby = $this->load->BabyModel->getBabysWeightBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']); 
                                  $checkNurseData = $this->db->get_where('babyDailyWeight',array('babyAdmissionId'=>$babyAdmissionData['id']))->row_array();
                                  if(!empty($babyAdmissionData['babyWeightPdfName'])){  ?>
                                     <div class="col-12 mt-1">
                                      <p style="float:right;"> 
                                        Daily Weight Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyWeightPdfName']; ?>" style="color: #3c8dbc;">Download</a>
                                      </p> 
                                    </div>
                              
                              <?php } ?>
                             
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                      <thead>
                                        <tr>
                                          <th style="width:70px;">S&nbsp;No.</th>
                                          <th>Date</th>
                                          <th>Infant&nbsp;Weight</th>
                                          <th>Nurse&nbsp;Name</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                          <?php 
                                          $counter=1;
                                          foreach($getBaby as $key => $value) { 
                                          $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['nurseId'],'staffMaster');
                                          ?>
                                          <tr>
                                            <td><?php echo $counter++;?></td>
                                            <td><?php echo date('d-m-Y', strtotime($value['addDate'])); ?></td>
                                            <td><?php echo $value['babyWeight'].'&nbsp;grams';?></td>
                                            <td><?php echo $nurseName;?></td>
                                          </tr>
                                          <?php } ?>
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-kmc-position" role="tabpanel" aria-labelledby="nav-kmc-position-tab">
                              <?php $getBaby = $this->load->BabyModel->getBabysSkinBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']); 
                                if(count($getBaby) > 0) {  ?>
                                <div class="col-12 mt-1">
                                  <p style="float:right;">
                                    Daily KMC Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyKMCPdfName']; ?>" style="color: #3c8dbc;">Download</a>
                                  </p>
                                </div>
                              <?php } ?>
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                      <thead>
                                        <tr>
                                          <th style="width:70px;">S&nbsp;No.</th>
                                          <th>Start&nbsp;Date</th>
                                          <th>Start&nbsp;Time</th>
                                          <th>Stop&nbsp;Date</th>
                                          <th>Stop&nbsp;Time</th>
                                          <th>KMC&nbsp;Time</th>
                                          <th>Provider</th>
                                          <th>Nurse&nbsp;Name</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
                                        $counter = 1;

                                        foreach($getBaby as $key => $value) { 
                                          $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['nurseId'],'staffMaster');
                                          $endTime = $value['endDate'].' '.$value['endTime'];
                                          $startTime = $value['startDate'].' '.$value['startTime'];
                                          
                                          $getKMCTime = $this->load->BabyModel->totalKmcBYID($value['id'], $startTime, $endTime);
                                          
                                          if(!empty($getKMCTime['kmcTime'])){

                                               $vals = explode(':', $getKMCTime['kmcTime']);
                                               (ltrim($vals[0],'0') == '1') ? $unit = ' Hr' : $unit = ' Hrs';
                                               if ( $vals[0] == 0 ){
                                                  $totalKmcTime = ltrim($vals[1],'0') . ' Mins';
                                               }
                                              else if($vals[1] == 0){
                                                $totalKmcTime = ltrim($vals[0],'0').$unit;
                                              }else{
                                                $totalKmcTime = ltrim($vals[0],'0').$unit.' '.ltrim($vals[1],'0') . ' Mins';
                                              }
                                          }else{
                                            $totalKmcTime = '--';
                                          }
                                        ?>
                                        <tr>
                                          <td><?php echo $counter++;?></td>
                                          <td><?php echo date('d-m-Y', strtotime($value['startDate'])); ?></td>
                                          <td><?php echo strtoupper(date('h:i a', strtotime($value['startTime']))); ?></td>
                                          <td><?php echo date('d-m-Y', strtotime($value['endDate'])); ?></td>
                                          <td><?php echo strtoupper(date('h:i a', strtotime($value['endTime']))); ?></td>
                                          <td><?php echo $totalKmcTime;?></td>
                                          <td><?php echo $value['provider'];?></td>
                                          <td><?php echo $nurseName;?></td>
                                        </tr>
                                        <?php }?>
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-nutrition" role="tabpanel" aria-labelledby="nav-nutrition-tab">
                              <?php $getBaby = $this->load->BabyModel->getBabysFeedingBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']);
                                if(count($getBaby) > 0){  ?>                    
                                <div class="col-12 mt-1">
                                  <p style="float:right;">
                                   Daily Feeding Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyFeedingPdfName']; ?>" style="color: #3c8dbc;">Download</a>
                                  </p>
                                </div> 
                              <?php } ?> 
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                    <thead>
                                      <tr>
                                        <th style="width:70px;">S&nbsp;No.</th>
                                        <th>Feeding&nbsp;Date</th>
                                        <th>Feeding&nbsp;Time</th>
                                        <th>Feeding&nbsp;Method</th>
                                        <!-- <th>Time(min)</th> -->
                                        <th>Quantity&nbsp;(ml)</th>
                                        <th>Type</th>
                                        <th>Nurse Name</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                      $counter=1;
                                      foreach($getBaby as $key => $value) { 
                                        $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['nurseId'],'staffMaster');
                                        if($value['milkQuantity'] == '0.00'){
                                           $totalMilk    = 'N/A';
                                        }else{
                                           $totalMilk    = !empty($value['milkQuantity']) ? $value['milkQuantity'].' ml' : '--';
                                        }
                                      ?>
                                        <tr>
                                          <td><?php echo $counter++;?></td>
                                          <td><?php echo date('d-m-Y',strtotime($value['feedDate'])); ?></td>
                                          <td><?php echo strtoupper(date('h:i a', strtotime($value['feedTime']))); ?></td>
                                          <td><?php echo $value['breastFeedMethod'];?></td>
                                          <!-- <td><?php echo $value['breastFeedDuration'].'&nbsp;min';?></td> -->
                                          <td><?php echo $totalMilk; ?></td>
                                          <td><?php if($value['feedingType']=='1') { 
                                           echo"Direct";  ?>
                                          <?php } else if($value['feedingType']=='2'){
                                             echo"Expressed";
                                          } else {
                                              echo"Other";?>
                                          <?php }?> 
                                          </td>  
                                          <td><?php echo $nurseName;?></td>                      
                                        </tr>
                                      <?php }?>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-investigation" role="tabpanel" aria-labelledby="nav-investigation-tab">
                              <?php $getInvestigationData = $this->db->get_where('investigation',array('babyAdmissionId'=>$babyAdmissionData['id']))->result_array(); ?>

                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                    <thead>
                                      <tr>
                                        <th style="width:70px;">S&nbsp;No.</th>
                                        <th>Investigation&nbsp;Name</th>
                                        <th>Sample&nbsp;Comment</th>
                                        <th>Sample&nbsp;Image</th>
                                        <th>Result</th>
                                        <th>Result&nbsp;Image</th>
                                        <th>Comment</th>
                                        <th>Submitted&nbsp;By</th>
                                        <th>Date&nbsp;&&nbsp;Time</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                      $counter=1;
                                      foreach($getInvestigationData as $key => $value) { 
                                        $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['nurseId'],'staffMaster');
                                      ?>
                                        <tr>
                                          <td><?php echo $counter++;?></td>
                                          <td><?php echo !empty($value['investigationName']) ? $value['investigationName'] : 'N/A' ;?></td>
                                          <td><?php echo !empty($value['sampleComment']) ? $value['sampleComment'] : 'N/A'; ?></td>
                                          <td><?php echo !empty($value['sampleImage']) ? '<img src="'.investigationDirectoryUrl.$value['sampleImage'].'" width="80" height="80">' : 'N/A'; ?></td>
                                          <td><?php echo !empty($value['result']) ? $value['result'] : 'N/A'; ?></td>
                                          <td><?php echo !empty($value['resultImage']) ? '<img src="'.investigationDirectoryUrl.$value['resultImage'].'" width="80" height="80">' : 'N/A'; ?></td>
                                          <td><?php echo !empty($value['nurseComment']) ? $value['nurseComment'] : 'N/A'; ?></td>
                                          <td><?php echo !empty($nurseName) ? $nurseName : 'N/A'; ?></td>
                                          <td><?php echo date("d-m-Y g:i A", strtotime($value['addDate']));?></td>         
                                        </tr>
                                      <?php }?>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-treatment" role="tabpanel" aria-labelledby="nav-treatment-tab">
                              <?php 
                                $getBaby = $this->db->get_where('prescriptionNurseWise',array('status'=>1,'babyAdmissionId'=>$babyAdmissionData['id']))->result_array();
                                
                              ?>
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                    <thead>
                                      <tr>
                                        <th style="width:70px;">S&nbsp;No.</th>
                                        <th>Treatment</th>
                                        <th>Quantity(ml)</th>
                                        <th>Comment</th>
                                        <th>Nurse&nbsp;Name</th>
                                        <th>Date & Time</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php  $counter=1;
                                          foreach($getBaby as $key => $value) { 
                                            $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['nurseId'],'staffMaster'); ?>
                                      <tr>
                                        <td><?php echo $counter++;?></td>
                                        <td><?php echo !empty($value['prescriptionName']) ? $value['prescriptionName'] : 'N/A'; ?></td>
                                        <td><?php echo !empty($value['quantity']) ? $value['quantity'].'&nbsp;ml' : 'N/A'; ?></td>
                                        <td><?php echo !empty($value['comment']) ? $value['comment'] : 'N/A'; ?></td>
                                        <td><?php echo !empty($nurseName) ? $nurseName : 'N/A'; ?></td>
                                        <td><?php echo date('d-m-Y g:i A', strtotime($value['addDate'])) ?></td>
                                      </tr>
                                    <?php } ?>
                                    
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-vaccination" role="tabpanel" aria-labelledby="nav-vaccination-tab">
                              <?php $getBaby = $this->load->BabyModel->getBabysVaccinationBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']);
                              ?>
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                    <thead>
                                      <tr>
                                        <th style="width:70px;">S&nbsp;No.</th>
                                        <th>Vaccination&nbsp;Date</th>
                                        <th>Vaccination&nbsp;Time</th>
                                        <th>Vaccination&nbsp;Name</th>
                                        <th>Quantity(ml)</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                        $counter=1;
                                        foreach($getBaby as $key => $value) { 
                                      ?>
                                        <tr>
                                          <td><?php echo $counter++;?></td>
                                          <td><?php echo date('d-m-Y',strtotime($value['vaccinationDate']));?></td>
                                          <td><?php echo date('g:i A',strtotime($value['vaccinationTime']));?></td>
                                          <td><?php echo $value['vaccinationName'];?></td>
                                          <td><?php echo $value['quantity'].'&nbsp;ml';?></td>
                                        </tr>
                                      <?php }?>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-doctor-round" role="tabpanel" aria-labelledby="nav-doctor-round-tab">
                              <?php  
                                $getTreatmentRecord     = $this->db->get_where('doctorBabyPrescription',array('babyAdmissionId'=>$babyAdmissionData['id']))->result_array();
                                $getInvestigationRecord = $this->db->get_where('investigation',array('babyAdmissionId'=>$babyAdmissionData['id']))->result_array();
                              ?>
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                    <thead>
                                      <tr>
                                        <th style="width:70px;">S&nbsp;No.</th>
                                        <th>Doctor&nbsp;Name</th>
                                        <!--<th>Baby&nbsp;Of</th>-->
                                        <th>Treatment</th>
                                        <th>Comment</th>
                                        <th>Photo&nbsp;of&nbsp;Note</th>
                                        <th>Date&nbsp;&&nbsp;Time</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                      $counter=1;
                                      foreach($getTreatmentRecord as $key => $value) { 
                                        
                                        $doctorName = $this->BabyModel->singlerowparameter2('name','staffId',$value['doctorId'],'staffMaster');
                                       
                                        $motherName = $this->db->query("select mr.motherName from motherRegistration as mr inner join babyRegistration as br on br.motherId=mr.motherId where br.babyId=".$babyData['babyId']."")->row_array();
                                      ?>
                                        <tr>
                                          <td><?php echo $counter++;?></td>
                                          <td><?php echo !empty($doctorName) ? $doctorName : 'N/A';?></td>
                                          <td><?php echo !empty($value['prescriptionName']) ? $value['prescriptionName'] : 'N/A'; ?></td>
                                          <td><?php echo !empty($value['comment']) ? $value['comment'] : 'N/A'; ?></td>
                                          <td><?php echo !empty($value['image']) ? "<img src='".investigationDirectoryUrl.$value['image']."' width='100' height='120'>" : 'N/A'; ?></td>
                                          <td><?php echo date("d-m-Y g:i A", strtotime($value['addDate']));?></td>         
                                        </tr>
                                      <?php }?>
                                    </tbody>
                                  </table>
                              </div>
                              <br/><hr>
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                    <thead>
                                      <tr>
                                        <th style="width:70px;">S&nbsp;No.</th>
                                        <th>Doctor&nbsp;Name</th>
                                        <!--<th>Baby&nbsp;Of</th>-->
                                        <th>Investigation</th>
                                        <th>Comment</th>
                                        <th>Date&nbsp;&&nbsp;Time</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                      $counter=1;
                                      foreach($getInvestigationRecord as $key => $value) { 
                                        $doctorName = $this->BabyModel->singlerowparameter2('name','staffId',$value['doctorId'],'staffMaster');
                                        $motherName = $this->db->query("select mr.motherName from motherRegistration as mr inner join babyRegistration as br on br.motherId=mr.motherId where br.babyId=".$babyData['babyId']."")->row_array();
                                      ?>
                                        <tr>
                                          <td><?php echo $counter++;?></td>
                                          <td><?php echo !empty($doctorName) ? $doctorName : 'N/A';?></td>
                                          <!--<td><?php echo !empty($motherName['MotherName']) ? $motherName['MotherName'] : 'N/A'; ?></td>-->
                                          <td><?php echo !empty($value['investigationName']) ? $value['investigationName'] : 'N/A'; ?></td>
                                          <td><?php echo !empty($value['doctorComment']) ? $value['doctorComment'] : 'N/A'; ?></td>
                                          
                                          <td><?php echo date("d-m-Y g:i A", strtotime($value['addDate']));?></td>         
                                        </tr>
                                      <?php }?>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">
                              <?php $getCommentData = $this->BabyModel->getCommentList(1,2,$babyData['babyId'],$babyAdmissionData['id']); ?>
                              <div class="table-responsive">
                                  <table class="table table-striped dataex-html5-selectors-log">
                                    <thead>
                                      <tr>
                                        <th style="width:70px;">S&nbsp;No.</th>
                                        <th>Comments&nbsp;By</th>
                                        <th>Comment</th>
                                        <th>Comment&nbsp;Date Time</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                      $counter=1;
                                      foreach($getCommentData as $key => $value) { 
                                        $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['doctorId'],'staffMaster');
                                      ?>
                                        <tr>
                                          <td><?php echo $counter++;?></td>
                                          <td><?php echo $nurseName;?></td>
                                          <td><?php echo $value['comment']; ?></td>
                                          <td><?php echo date("d-m-Y g:i A", strtotime($value['addDate']));?></td>  

                                        </tr>
                                      <?php }?>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                          <?php if($getPdfLink['status'] == '2'){ ?>

                            <?php 
                             $dischargeData = $this->load->BabyModel->getBabyRecordByAdmisonId($babyAdmissionData['id']);
                             $DoctorName = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByDoctor']);
                             $NurseName  = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByNurse']);                
                             $DischargeType = trim($dischargeData['typeOfDischarge'], "'");
                            ?>

                            <div class="tab-pane fade" id="nav-discharge" role="tabpanel" aria-labelledby="nav-discharge-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Discharge Information</h5>
                                  <?php if($babyAdmissionData['babyDischargePdfName'] != ''){ ?>
                                    <div class="float-right mt-1">Discharge Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyDischargePdfName']; ?>" style="color: #3c8dbc;">Download</a></div>
                                    
                                  <?php } ?>
                                </div>

                                <?php if($DischargeType == 'Died'){
                                ?>
                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Type Of Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly placeholder="Type Of Discharge">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Doctor Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="Doctor Name">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="Nurse Name">
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Body Handed Over </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['bodyHandover'];?>" readonly placeholder="Body Handed Over">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Guardian Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="Guardian Name">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Relationship with Infant </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithInfant'];?>" readonly placeholder="Relationship with Infant">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                        <?php if($dischargeData['relationWithInfant'] == "Other"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Other Relationship </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['otherRelation'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharge Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="Discharge Date & Time">
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-12">
                                        <h5 class="float-left mb-2 mt-1 pr-1">Signature </h5>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Signature </label>
                                              <div class="controls">
                                                <img src="<?php echo signDirectoryUrl.$dischargeData['nurseDischargeSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                <?php } else if($DischargeType == 'Absconded') { ?>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Type Of Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly placeholder="Type Of Discharge">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Mother/Family member absconded along with baby </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['isAbsconded'];?>" readonly placeholder="Is Absconded">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="Nurse Name">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharge Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="Discharge Date & Time">
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-12">
                                        <h5 class="float-left mb-2 mt-1 pr-1">Signature </h5>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Signature </label>
                                              <div class="controls">
                                                <img src="<?php echo signDirectoryUrl.$dischargeData['nurseDischargeSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                <?php } else if($DischargeType == "Doctor's discretion" || $DischargeType == "DOPR") { ?>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Type Of Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly placeholder="Type Of Discharge">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Doctor Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="Doctor Name">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="Nurse Name">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Guardian Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="Guardian Name">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Relationship with Infant </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithInfant'];?>" readonly placeholder="Relationship with Infant">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['relationWithInfant'] == "Other"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Other Relationship </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['otherRelation'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                      </div>

                                      <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Training for KMC at Home </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['trainForKMCAtHome'];?>" readonly placeholder="Discharge Notes">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Infantometer Availability </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['infantometerAvailability'];?>" readonly placeholder="Infantometer Availability">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['infantometerAvailability'] == "Yes"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Baby Length(cm) </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['babyLength'];?>" readonly placeholder="Baby Length">
                                              </div>
                                            </div>
                                          </div>
                                        <?php }else{ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Infantometer Not Availability Reason </label>
                                              <div class="controls">
                                                <textarea class="form-control" readonly><?php if($dischargeData['lengthMeasureNotAvlReasonDischarge'] == "Other" || $dischargeData['lengthMeasureNotAvlReasonDischarge'] == "अन्य"){ echo $dischargeData['lengthMeasureNotAvlReasonOtherDischarge']; }else{ echo $dischargeData['lengthMeasureNotAvlReasonDischarge']; } ?></textarea>
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                      </div>

                                      <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Measuring Tape Availability </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['measuringTapeAvailability'];?>" readonly placeholder="Measuring Tape Availability">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['measuringTapeAvailability'] == "Yes"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Head Circumference(cm) </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['headCircumference'];?>" readonly placeholder="Head Circumference">
                                              </div>
                                            </div>
                                          </div>
                                        <?php }else{ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Measuring Tape Not Availability Reason </label>
                                              <div class="controls">
                                                <textarea class="form-control" readonly><?php if($dischargeData['headMeasureNotAvlReasonDischarge'] == "Other" || $dischargeData['headMeasureNotAvlReasonDischarge'] == "अन्य"){ echo $dischargeData['headMeasureNotAvlReasonOtherDischarge']; }else{ echo $dischargeData['headMeasureNotAvlReasonDischarge']; } ?></textarea>
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharge Notes </label>
                                            <div class="controls">
                                              <textarea class="form-control" readonly><?php echo $dischargeData['dischargeNotes'];?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row col-12">
                                        <?php if($DischargeType == "Doctor's discretion"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Early Discharge Reason </label>
                                              <div class="controls">
                                                <textarea class="form-control" readonly><?php echo $dischargeData['earlyDishargeReason'];?></textarea>
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Transportation </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="Transportation">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharge Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="Discharge Date & Time">
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-12">
                                        <h5 class="float-left mb-2 mt-1 pr-1">Signature </h5>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Signature </label>
                                              <div class="controls">
                                                <img src="<?php echo signDirectoryUrl.$dischargeData['nurseDischargeSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                <?php } else if($DischargeType == "LAMA") { ?>
                                   
                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Type Of Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly placeholder="Type Of Discharge">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Doctor Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="Doctor Name">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="Nurse Name">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Training for KMC at Home </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['trainForKMCAtHome'];?>" readonly>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Transportation </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="Transportation">
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Discharge Notes </label>
                                              <div class="controls">
                                                <textarea class="form-control" readonly><?php echo $dischargeData['dischargeNotes'];?></textarea>
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Mother Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['isMotherDischarge'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Discharge Date & Time </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="Discharge Date & Time">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      
                                      <div class="row">
                                        <div class="col-md-4">
                                          <div class="col-12">
                                            <h5 class="float-left mb-2 mt-1 pr-1">Signature </h5>
                                          </div>

                                          <div class="row col-12">
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label>Nurse Signature </label>
                                                  <div class="controls">
                                                    <img src="<?php echo signDirectoryUrl.$dischargeData['nurseDischargeSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                          <div class="col-12">
                                            <h5 class="float-left mb-2 mt-1 pr-1">Consent Form </h5>
                                          </div>

                                          <div class="row col-12">
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label>Consent Form </label>
                                                  <div class="controls">
                                                    <span class="hover-image cursor-pointer" onclick="showZoomImage('<?php echo babyDirectoryUrl.$dischargeData['sehmatiPatr'];?>','Consent Form')">
                                                      <img src="<?php echo babyDirectoryUrl.$dischargeData['sehmatiPatr'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                                    </span>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                <?php } else if($DischargeType == "Referral") { 
                                  $FacilityDetails = $this->db->query("SELECT * FROM `facilitylist` where FacilityID='".$dischargeData['dischargeReferredFacility']."'")->row_array();
                                  $DistrictDetails = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$dischargeData['dischargeReferredDistrict']."'")->row_array();
                                  ?>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Type Of Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly placeholder="Type Of Discharge">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Doctor Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="Doctor Name">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="Nurse Name">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Guardian Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="Guardian Name">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Relationship with Infant </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithInfant'];?>" readonly placeholder="Relationship with Infant">
                                              </div>
                                            </div>
                                          </div>
                                          <?php if($dischargeData['relationWithInfant'] == "Other"){ ?>
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label>Other Relationship </label>
                                                <div class="controls">
                                                  <input type="text" class="form-control" value="<?php echo $dischargeData['otherRelation'];?>" readonly placeholder="">
                                                </div>
                                              </div>
                                            </div>
                                          <?php } ?>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Referred District </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DistrictDetails['DistrictNameProperCase'];?>" readonly placeholder="Referred District">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Referred Facility </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $FacilityDetails['FacilityName'];?>" readonly placeholder="Referred Facility">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Discharge Notes </label>
                                              <div class="controls">
                                                <textarea class="form-control" readonly><?php echo $dischargeData['dischargeNotes'];?></textarea>
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Mother Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['isMotherDischarge'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>

                                          <?php if($dischargeData['isMotherDischarge'] == "No"){ ?>
                                              <div class="col-md-4">
                                                <div class="form-group">
                                                  <label>Referred Reason </label>
                                                  <div class="controls">
                                                    <textarea class="form-control" readonly><?php echo $dischargeData['referredReason'];?></textarea>
                                                  </div>
                                                </div>
                                              </div>
                                          <?php } ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Transportation </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="Transportation">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Discharge Date & Time </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="Discharge Date & Time">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="col-12">
                                        <h5 class="float-left mb-2 mt-1 pr-1">Signature </h5>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Signature </label>
                                              <div class="controls">
                                                <img src="<?php echo signDirectoryUrl.$dischargeData['nurseDischargeSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                <?php } ?>

                            </div>
                          <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Input Validation end -->
        </div>
      </div>
    </div>
    <!-- END: Content-->


    <script type="text/javascript">
      var hidWidth;
      var scrollBarWidths = 0;

      var widthOfList = function(){ 
        var itemsWidth = 0;
        $('.list .nav-item').each(function(){
          var itemWidth = $(this).outerWidth();
          itemsWidth+=itemWidth;
        });
        return itemsWidth;
      };

      var widthOfHidden = function(){
        return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
      };

      var getLeftPosi = function(){
        return $('.list').position().left;
      };

      var reAdjust = function(){
        if (($('.wrapper').outerWidth()) < widthOfList()) {
          $('.scroller-right').show();
        }
        else {
          $('.scroller-right').hide();
        }
        
        if (getLeftPosi()<0) {
          $('.scroller-left').show();
        }
        else {
          $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
          $('.scroller-left').hide();
        }
      }

      reAdjust();

      $(window).on('resize',function(e){  
          reAdjust();
      });

      $('.scroller-right').click(function() {
        
        $('.scroller-left').fadeIn('slow');
        $('.scroller-right').fadeOut('slow');
        
        $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){

        });
      });

      $('.scroller-left').click(function() {
        
        $('.scroller-right').fadeIn('slow');
        $('.scroller-left').fadeOut('slow');
        
          $('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
          
          });
      });    
    </script>


    