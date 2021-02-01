<style type="text/css">
.sticky {
  position: fixed !important;
  top: 50px !important;
  width: 95% !important;
  padding-right: 15% !important;
  bottom: 5%;
  overflow: hidden;
  z-index: 99999999;
  height: 50px;
}div.scrollmenu {
  overflow-x: scroll;
  display: inline;
  white-space: nowrap;
}
.nav-tabs {
    background-color: #fff;
  }
 #example_filter label, .paging_simple_numbers .pagination {float: right;} 
</style>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <input type="hidden" id="scriptFileName" value="list">
    <h1>
    <?php  
      $getFourLevelVar = $this->uri->segment(4);
      $getPdfLink          = $this->load->BabyModel->getBabyRecord($babyData['babyId']); 

      // set baby file id and sncu number respect of type
         $GetFacility = $this->FacilityModel->GetFacilitiesID($babyAdmissionData['loungeId']);
          if($GetFacility['type'] == 1){
            $babyRegNumberHeading   = "SNCU&nbsp;Reg.&nbsp;Number";
            $babyFileId             = !empty($getPdfLink['temporaryFileId']) ? $getPdfLink['temporaryFileId'] : 'N/A';
          }else{
            $babyRegNumberHeading   = "Baby&nbsp;File&nbsp;ID";
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
      echo $icon;
      ?>

       Baby Of&nbsp;<?php echo ($MotherName['motherName'] != "") ? ucwords($MotherName['motherName']).' ('.$GetLounge['loungeName'].')' : "Unknown Mother (".$GetLounge['loungeName'].")";?>
     </h1> 
     
       <?php  $kmcViaBaby     = $this->load->BabyModel->totalKmcBYAdmissionID($babyAdmissionData['id']);
              $getMilkQty     = $this->load->BabyModel->getTotalMilk($babyAdmissionData['id']);
                    // latest 24 four hrs kmc timing
              if(!empty($kmcViaBaby['kmcTimeLatest'])){
                $hours  = floor($kmcViaBaby['kmcTimeLatest'] / 3600);
                ($hours == '1') ?  $unit = "Hr" : $unit = "Hrs";
             
                $minutes = floor(($kmcViaBaby['kmcTimeLatest'] / 60) % 60);
                $totalKmcTime1 = $hours.' '.$unit.' '.$minutes.' Mins';
              }else{
                $totalKmcTime1 = '--';
              }

            // total milk consumed
             $totalMilk    = !empty($getMilkQty['quantityOFMilk']) ? $getMilkQty['quantityOFMilk'].' ml' : '--';
          ?>
                            
     <font size="4" style="color:black;">MCTS No:&nbsp;<?php echo ($babyData['babyMCTSNumber'] != "") ? $babyData['babyMCTSNumber'] : 'N/A' ; ?>,&nbsp;<?php echo $babyRegNumberHeading; ?>:&nbsp;<?php echo $babyFileId; ?></font>
       <ol class="breadcrumb" style="margin-top: 35px;">
        <li id="assesment" style="text-align:right;display:none;"><small style="float: right;color:black;font-size:12px;"><b>Temperature:</b>&nbsp;(&lt; 95.9 - &gt; 99.5)&nbsp;<b>|</b>&nbsp; <b>SpO2:</b>&nbsp;(&lt; 95)&nbsp;<b>|</b>&nbsp; <b>Heart Beat:</b>&nbsp;(&lt; 75 - &gt; 200)&nbsp;<b>|</b>&nbsp; <b>Breath Count:</b>&nbsp;(&lt; 30 - &gt; 60)</small></li>

        <li id="kmcValues" style="text-align:right;display:none;"><small style="float: right;color:black;font-size:12px;"><b>Total KMC Time:</b>&nbsp;<?php echo $totalKmcTime1; ?></small></li>    

      <li id="milkValues" style="text-align:right;display:none;"><small style="float: right;color:black;font-size:12px;"><b>Total Milk Consumed:</b>&nbsp;<?php echo $totalMilk; ?></small></li>
      </ol>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-md-12">
           <div class="box box-info">
             <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('Admin/Add_Lounge/');?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
               <div class="box-body">
                 <div class="nav-tabs-custom">
                    <div id="myHeader" class="">
                      <ul class="nav nav-tabs pull-center">
                           <li class="<?php echo ($getFourLevelVar == 'comment') ? '' : 'active'; ?>"><a href="" id="step1" data-toggle="tab">Baby Birth Information</a></li>
                           <li><a href="" id="step2" data-toggle="tab">Baby Assessment</a></li>
                           <li><a href="" id="step3" data-toggle="tab">Daily Weight</a></li>
                           <li><a href="" id="step4" data-toggle="tab">KMC Position</a></li> 
                           <li><a href="" id="step5" data-toggle="tab">Nutrition</a></li>
                           <li><a href="" id="step6" data-toggle="tab">Investigation</a></li>  
                           <li><a href="" id="step7" data-toggle="tab">Treatment</a></li>   
                           <li><a href="" id="step8" data-toggle="tab">Vaccination</a></li>   
                          <?php if($getPdfLink['status'] == '2'){ ?>
                            <li><a href="" id="step9" data-toggle="tab">Discharged</a></li> 
                          <?php } ?> 
                           <li><a href="" id="step10" data-toggle="tab">Doctor Round</a></li>   
                           <li class="<?php echo ($getFourLevelVar == 'comment') ? 'active' : ''; ?>"><a href="" id="step11" data-toggle="tab">Comments</a></li> 
                      </ul>
                    </div>  
                  <div class="tab-content no-padding">
<!--         Birth Information tab start   -->
                      <div id="stepp1">
                        <div class="form-group">

                        <div class="col-md-12" style="text-align:right;">
                    <?php
                     $checkMonitoringOrNot = $this->db->get_where('babyDailyMonitoring',array('babyAdmissionId'=>$babyAdmissionData['id']))->num_rows();
                       ?> 
                      <?php if($babyAdmissionData['babyPdfFileName'] != '') { ?>
                        <div class="col-md-12" style="margin-top:10px;">Admission Form Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyPdfFileName'];?>">Download</a></div>
                        
                      <?php } ?>
                      </div>
                         </div>

                        <div class="form-group col-sm-12">
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label"><?php echo $babyRegNumberHeading; ?></label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyFileId; ?>" style="background-color:white;">
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Baby's MCTS ID</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['babyMCTSNumber']?>" style="background-color:white;">
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Baby's Photo</label>
                            <?php if(empty($babyData['babyPhoto'])){
                                    $img_url = base_url().'assets/images/baby.png';
                                  } else {
                                    $img_url = babyDirectoryUrl.$babyData['babyPhoto' ];
                                  }
                            ?>

                              <div class="set_div_img00" id="" style="display: <?php if($babyData['babyPhoto' ] != '') { echo "block"; } else { echo "none"; } ?>">
                                <img src="<?php echo $img_url; ?>" class="img-responsive" alt="img">
                                <p class="set_img">
                                  <?php
                                    $img_modal_url = $img_url;
                                  ?>
                                  <i class="fa fa-eye" aria-hidden="true" style="color: red; cursor: pointer;" onclick="showImgModal('<?php echo $img_modal_url; ?>')"></i>                                 
                                </p>                             
                              </div>
                          </div>
                        </div>

                        
                        <div class="form-group col-sm-12">
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Delivery Date (dd-mm-yyyy)</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['deliveryDate']?>" style="background-color:white;">
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Delivery Time</label>
                            <input type="text" class="form-control" readonly value="<?php echo date('g:i A',strtotime($babyData['deliveryTime'])); ?>" style="background-color:white;">
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Sex</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['babyGender']?>" style="background-color:white;">
                          </div>
                        </div>


                        <div class="form-group col-sm-12">
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Baby Birth Weight Available</label>
                            <?php if($babyData['birthWeightAvail']=='1'){?>
                              <input type="text" class="form-control" readonly value="<?php echo 'Yes';?>" style="background-color:white;">
                            <?php } else if($babyData['birthWeightAvail']=='2') {?>
                              <input type="text" class="form-control" readonly value="<?php echo 'No';?>" style="background-color:white;"><br/>
                              <textarea cols="3" rows="3" readonly class="form-control"><?php echo $babyData['reason'];?></textarea>
                            <?php } ?>
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Baby Birth Weight in grams</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['babyWeight']?>" style="background-color:white;">
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Delivery Type</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['deliveryType']?>" style="background-color:white;">
                          </div>
                        </div>


                        <div class="form-group col-sm-12">
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Type Of Admission</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['typeOfBorn']?>" style="background-color:white;">
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Type Of Outborn</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['typeOfBorn'] != "Inborn" ? $babyData['typeOfOutBorn'] : "N/A"?>" style="background-color:white;">
                          </div>
                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Did the Baby cry immediately after birth?</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['babyCryAfterBirth']?>" style="background-color:white;">
                          </div>
                          
                        </div>
                          

                        <div class="form-group col-sm-12">

                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Was Vitamin K Given?</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['vitaminKGiven']?>" style="background-color:white;">
                          </div>

                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Date & Time of First Feed?</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['firstTimeFeed']?>" style="background-color:white;">
                          </div>

                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Did the Baby need resuscitation</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['babyNeedBreathingHelp']?>" style="background-color:white;">
                          </div>
                          
                        </div>

                        <div class="form-group col-sm-12">

                          <div class="col-sm-4 col-xs-4">
                            <label for="inputEmail3" class="control-label">Was Apgar Score Recorded?</label>
                            <input type="text" class="form-control" readonly value="<?php echo $babyData['wasApgarScoreRecorded']?>" style="background-color:white;">
                          </div>

                          <?php if($babyData['wasApgarScoreRecorded'] == 'Yes') { ?>
                            <div class="col-sm-4 col-xs-4">
                              <label for="inputEmail3" class="control-label">Was Apgar Score Recorded?</label>
                              <input type="text" class="form-control" readonly value="<?php echo $babyData['apgarScoreVal']?>" style="background-color:white;">
                            </div>
                          <?php } ?>

                          <div class="col-md-12" style="height:100px"></div>
                        </div>

                          

                          <div class="form-group">
                           
                            
                            
                          </div> 
                      </div>
<!--         assessment tab start   -->
                      <div id="stepp2" style="display:none; margin-top:15px;">
                        <div class="col-sm-12" style="overflow: auto;">    
                          <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable  " id="example">
                                <thead>
                                  <?php $getBaby = $this->load->BabyModel->getBabysBYAdmisionId($babyData['babyId'],$babyAdmissionData['id']); ?>

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
                                    <td><b>Respiratory&nbsp;Rate</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['respiratoryRate']) ? $value['respiratoryRate'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Is&nbsp;Thermometer&nbsp;Available</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['isThermometerAvailable']) ? $value['isThermometerAvailable'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Temperature(<sup>0</sup>F)</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['temperatureValue']) ? $value['temperatureValue'].'&nbsp;<sup>0</sup>F' : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Thermometer&nbsp;Image</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['thermometerImage']) ? "<img src='".babyTemperaturetDirectoryUrl.$value['thermometerImage']."' style='width:100px;height:100px;'>" : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  
                                  <tr>
                                    <td><b>Thermometer&nbsp;Reason</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['thermometerNotAvailableReason']) ? $value['thermometerNotAvailableReason'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 


                                  <tr>
                                    <td><b>Pulse&nbsp;Oximeter&nbsp;Device&nbsp;Available</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['isPulseOximatoryDeviceAvail']) ? $value['isPulseOximatoryDeviceAvail'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 


                                  <tr>
                                    <td><b>SpO2(%)</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['spo2']) ? $value['spo2'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Pulse&nbsp;Rate(bpm)</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['pulseRate']) ? $value['pulseRate'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Blood Pressure</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['bloodPressure']) ? $value['bloodPressure'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Capillary&nbsp;Filling&nbsp;Time(CFT)&nbsp;Knowledge</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['cftKnowledge']) ? $value['cftKnowledge'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Is&nbsp;Cft&nbsp;Greater&nbsp;Three</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['isCftGreaterThree']) ? $value['isCftGreaterThree'] : 'N/A'; ?></td>
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
                                    <td><b>Is&nbsp;Any&nbsp;Complication&nbsp;At Birth</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td>
                                        <?php
                                          $data =json_decode($value['isAnyComplicationAtBirth'], true);
                                             if(count($data) > 0){
                                                $count=1; ?>
                                                <?php 
                                                   foreach ($data as $key => $val) {?>
                                                      <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></br/>
                                                     <?php } ?>
                                       <?php } else { ?>
                                            <?php echo 'N/A';?>
                                         <?php }?> 
                                      </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Other&nbsp;Complications</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['otherComplications']) ? $value['otherComplications'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Last 24Hrs&nbsp;Passed Urine</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['urinePassedIn24Hrs']) ? $value['urinePassedIn24Hrs'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Last 24Hrs&nbsp;Passed Stool</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['stoolPassedIn24Hrs']) ? $value['stoolPassedIn24Hrs'] : 'N/A'; ?></td>
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
                                    <td><b>Muscle&nbsp;Tone</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['tone']) ? $value['tone'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Convulsions</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['convulsions']) ? $value['convulsions'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Sucking</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['sucking']) ? $value['sucking'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Apnea&nbsp;Or&nbsp;Gasping</b></td>
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
                                    <td><b>Color</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['color']) ? $value['color'] : 'N/A'; ?></td>
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
                                    <td><b>Is&nbsp;Bleeding</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['isBleeding']) ? $value['isBleeding'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Bleeding&nbsp;Value</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['bleedingValue']) ? $value['bleedingValue'] : 'N/A';?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Bulging&nbsp;Anterior&nbsp;Fontanel</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['bulgingAnteriorFontanel']) ? $value['bulgingAnteriorFontanel'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>
              
                                  <tr>
                                    <td><b>Umbilicus</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                     <td><?php echo !empty($value['umbilicus']) ? $value['umbilicus'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Skin&nbsp;Pustules</b></td>
                                    <?php foreach($getBaby as $key => $value) { ?>
                                      <td><?php echo !empty($value['skinPustules']) ? $value['skinPustules'] : 'N/A'; ?></td>
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
                                  </tr>

                                  <tr>
                                    <td><b>AssesmentDate<br>&&nbsp;Time</b></td>
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
                                    <td><b>StaffName/ Staff&nbsp;Sign</b></td>
                                    <?php foreach($getBaby as $key => $value) {
                                         $staffName = $this->load->BabyModel->getStaffNameBYID($value['staffId']);
                                     ?>
                                      <td><?php (empty($staffName['name'])) ? $staffName = "N/A" : $staffName = $staffName['name']; ?>
                                         <?php 
                                            if($value['type'] != "1") {
                                                echo $staffName."<br><img src='".signDirectoryUrl.$GetLastAdmittedBaby['doctorSign']."' style='width:100px;height:100px;'' class='signatureSize'>";
                                              } else if ($value['staffSign'] == '') {
                                                echo 'N/A'; 
                                             } else { 
                                               echo $staffName."<br><img src='".signDirectoryUrl.$value['staffSign']."' style='width:100px;height:100px;'' class='signatureSize'>";
                                             }  ?>
                                       </td>     
                                    <?php } ?>
                                  </tr>

                                  
                                  
                               </tbody>
                            </table>
                        </div>
                      </div>
<!--        Daily Weight tab start   -->
                      <div id="stepp3" style="display:none;margin-top:15px;">
  
                     <?php $getBaby = $this->load->BabyModel->getBabysWeightBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']); 
                            $checkNurseData = $this->db->get_where('babyDailyWeight',array('babyAdmissionId'=>$babyAdmissionData['id']))->row_array();
                               if(!empty($babyAdmissionData['babyWeightPdfName'])){  ?>
                               <div class="col-md-12">
                                <p style="float:right;">
                                  
                                  Daily Weight Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyWeightPdfName']; ?>">Download</a>
                                 
                                </p>  </div>
                              
                      <?php } ?>

                         <!--     <div class="col-md-12" style="text-align:right;"></div><br> -->
                              
                        <div class="col-sm-12" style="overflow: auto;">
                          <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">S&nbsp;No.</th>
                                <th>Date</th>
                                <th>Baby&nbsp;Weight</th>
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
<!--      KMC status tab start   -->
                      <div id="stepp4" style="display:none;margin-top:15px">
                      <?php $getBaby = $this->load->BabyModel->getBabysSkinBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']); 
                           if(count($getBaby) > 0){  ?>
                        <div class="col-md-12">
                          <p style="float:right;">
                            Daily KMC Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyKMCPdfName']; ?>">Download</a>
                          </p>
                        </div>
                       <?php } ?>
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">S&nbsp;No.</th>
                                <th>Date</th>
                                <th>Start&nbsp;Time</th>
                                <th>Stop&nbsp;Time</th>
                                <th>KMC&nbsp;Time</th>
                                <th>Provider</th>
                                <th>Nurse Name</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $counter = 1;

                              foreach($getBaby as $key => $value) { 
                                $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['nurseId'],'staffMaster');
                                $getKMCTime = $this->load->BabyModel->totalKmcBYID($value['id']);
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
                                <td><?php echo date('d-m-Y', strtotime($value['addDate'])); ?></td>
                                <td><?php echo strtoupper(date('h:i a', strtotime($value['startTime']))); ?></td>
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
<!--      Feeding tab start   -->
                <div id="stepp5" style="display:none; margin-top:15px;">    
                  <?php $getBaby = $this->load->BabyModel->getBabysFeedingBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']); 
                     if(count($getBaby) > 0){  ?>                    
                      <div class="col-md-12">
                        <p style="float:right;">
                         Daily Feeding Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyFeedingPdfName']; ?>">Download</a>
                        </p>
                       </div> 
                   <?php } ?>                
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
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
<!-- Investigation tab start   -->
                      <div id="stepp6" style="display:none; margin-top:15px;">
                        <?php $getInvestigationData = $this->db->get_where('investigation',array('babyAdmissionId'=>$babyAdmissionData['id']))->result_array(); ?>
                          <div class="col-md-12" style="overflow: auto;">
                            <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
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
<!--    Treatment/supplement tab start   -->
                      <div id="stepp7" style="display:none; margin-top:15px;">
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
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
                              <?php //$getBaby = $this->load->BabyModel->getBabysSupplimentBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']);
                              $getBaby = $this->db->get_where('prescriptionNurseWise',array('status'=>1,'babyAdmissionId'=>$babyAdmissionData['id']))->result_array();
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                                $nurseName = $this->BabyModel->singlerowparameter2('name','staffId',$value['nurseId'],'staffMaster');
                              ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td><?php echo !empty($value['prescriptionName']) ? $value['prescriptionName'] : 'N/A'; ?></td>
                                  <td><?php echo !empty($value['quantity']) ? $value['quantity'].'&nbsp;ml' : 'N/A'; ?></td>
                                  <td><?php echo !empty($value['comment']) ? $value['comment'] : 'N/A'; ?></td>
                                  <td><?php echo !empty($nurseName) ? $nurseName : 'N/A'; ?></td>
                                  <td><?php echo date('d-m-Y g:i A', strtotime($value['addDate'])) ?></td>
                                </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div>  


<!--   Vaccination Data -->

            <div id="stepp8" style="display:none;">
              <div class="col-md-12" style="overflow: auto;">
                <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
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
                    <?php $getBaby = $this->load->BabyModel->getBabysVaccinationBYAdmissionID($babyData['babyId'],$babyAdmissionData['id']);
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

<!-- Discharge Data -->

            <div id="stepp9" style="display:none; margin-top:15px;">
                <?php 
                 $dischargeData = $this->load->BabyModel->getBabyRecordByAdmisonId($babyAdmissionData['id']);
                 $DoctorName = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByDoctor']);
                 $NurseName  = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByNurse']);                
                 $DischargeType = trim($dischargeData['typeOfDischarge'], '"');?>

                    <?php  if($babyAdmissionData['babyDischargePdfName'] != ''){ ?>
                      <div class="col-md-12" style="margin-top:10px;">
                       <p style="float:right;">
                        Discharge Report&nbsp;<a target="_blank" href="<?php echo pdfDirectoryUrl.$babyAdmissionData['babyDischargePdfName']; ?>">Download</a>
                       </p>
                      </div>
                    <?php } ?>

                <?php if($DischargeType=='Died' || $DischargeType=='Mother absconded' || $DischargeType=='Leave against medical advice(LAMA)' || $DischargeType=='Discharged by facility staff'){
                ?>

                          <div class="form-group" style="margin-top:15px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Type Of Discharged</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Staff Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly style="background-color:white;">
                                 </div>
      
                             </div>


                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['dateOfDischarge']));?>" readonly style="background-color:white;">
                                 </div>
      
                             </div>

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Check List</label>
                                 <div class="col-sm-10">
                                          <?php 
                                              $data = json_decode($dischargeData['dischargeChecklist'], true);
                                                   if(count($data) > 0){
                                                      $count=1; ?>
                                                      <?php 
                                                         foreach ($data as $key => $val) {?>
                                                   <textarea rows="3" class="form-control" readonly="" style="background-color:white;"><?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
                                                           <?php } ?>
                                             <?php } else {  echo 'N/A'; } ?>
                                   
                                 </div>
      
                             </div>
                      
                   
                             <div class="form-group">
                                 <div class="col-sm-2 text-right">
                                 <label for="inputEmail3" class="control-label">Signature</label>
                       
                                 </div>
                                 <div class="col-sm-3">
                                 Doctor Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['doctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                                 <div class="col-sm-3">
                                 Family Member Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['signOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                     <div class="col-sm-3">
                      <?php if($dischargeData['ashaSign'] != "") { ?>
                                 Asha Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['ashaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                      <?php } ?> 
                                 </div>
                             </div>

                                                   
                           <div class="form-group">
                                 <div class="col-md-12" style="height:100px"></div>
                             </div>               
              <?php } else if($DischargeType=='Other') {?>

                         <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Type Of Discharge</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 
                             <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Specify</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['referredReason'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Nurse Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['modifyDate']));?>" readonly style="background-color:white;">
                                 </div>
                             </div>

                               <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Check List</label>
                                 <div class="col-sm-10">
                                    <?php 
                                      $data =json_decode($dischargeData['dischargeChecklist'], true);
                                        if(count($data) > 0){
                                            $count=1; ?>
                                            <?php 
                                               foreach ($data as $key => $val) {?>
                                        <textarea rows="1" class="form-control"> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea>
                                      <?php } ?>
                                    <?php } else {  echo 'N/A'; } ?>
                                   
                                 </div>
      
                             </div>                    
                   
                             <div class="form-group">
                                 <div class="col-sm-2 text-right">
                                 <label for="inputEmail3" class="control-label">Signature</label>
                       
                                 </div>
                                 <div class="col-sm-3">
                                 Doctor Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['doctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                                 <div class="col-sm-3">
                                 Family Member Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['signOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                     <div class="col-sm-3">
                      <?php if($dischargeData['ashaSign'] != "") { ?>
                                 Asha Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['ashaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                      <?php } ?> 
                                 </div>
                             </div>

                                                   
                           <div class="form-group">
                                 <div class="col-md-12" style="height:100px"></div>
                             </div>
              <?php } else { ?>
                       <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Type Of Discharge</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DischargeType;?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 
                             <!-- <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Follow UP</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date('d-m-Y',strtotime($dischargeData['dateOfFollowUpVisit']));?>" readonly style="background-color:white;">
                                 </div>
                             </div>  -->
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Facility</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['referredFacilityName'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                              <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Address Of Facility</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['referredFacilityAddress'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Reason For Referal</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['referredReason'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                            
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Staff Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 


                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly style="background-color:white;">
                                 </div>
                                
                             </div>

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($dischargeData['modifyDate']));?>" readonly style="background-color:white;">
                                 </div>
                             </div>

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Check List</label>
                                 <div class="col-sm-10">
                                              <?php 
                                              $data =json_decode($dischargeData['dischargeChecklist'], true);
                                                   if(count($data) > 0){
                                                      $count=1; ?>
                                                      <?php 
                                                         foreach ($data as $key => $val) {?>
                                                   <textarea rows="1" class="form-control"> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea>
                                                           <?php } ?>
                                             <?php } else {  echo 'N/A'; } ?>
                                   
                                 </div>
      
                             </div>                      
                   
                             <div class="form-group">
                                 <div class="col-sm-2 text-right">
                                 <label for="inputEmail3" class="control-label">Signature</label>
                       
                                 </div>
                                 <div class="col-sm-3">
                                 Doctor Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['doctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                                 <div class="col-sm-3">
                                 Family Member Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['signOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                     <div class="col-sm-3">
                      <?php if($dischargeData['ashaSign'] != "") { ?>
                                 Asha Signature
                                 <img src="<?php echo signDirectoryUrl.$dischargeData['ashaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                      <?php } ?> 
                                 </div>
                             </div>

                                                   
                           <div class="form-group">
                                 <div class="col-md-12" style="height:100px"></div>
                             </div>

              <?php } ?>
            </div>
 
 <!-- Doctor Round Data -->

            <div id="stepp10" style="display:none;margin-top:15px;">
            <?php 
              
              $getTreatmentRecord     = $this->db->get_where('doctorBabyPrescription',array('babyAdmissionId'=>$babyAdmissionData['id']))->result_array();
              $getInvestigationRecord = $this->db->get_where('investigation',array('babyAdmissionId'=>$babyAdmissionData['id']))->result_array();
           
            ?>
                <div class="col-md-12" style="overflow: auto;">
                <!--   Treatment All Records -->
                <?php if($getPdfLink['babyPrescriptionPdfName'] != '') { ?>
                  <!-- <div style="margin: 0px 0px 10px 0px !important;">
                    <b>Treatment Report</b> <a href="<?php echo pdfDirectoryUrl.$getPdfLink['babyPrescriptionPdfName']; ?>" target="_blank">Download</a>
                  </div>  --> 
                <?php } ?>
                  <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example" id="example">
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
                  </table><br/>
                  <hr>

                <!--   Investigation All Records -->
                <?php if($getPdfLink['babyTreatmentPdfName'] != '') { ?>
                  <!-- <div style="margin: 0px 0px 10px 0px !important;">
                    <b>Investigation Report</b> <a href="<?php echo pdfDirectoryUrl.$getPdfLink['babyTreatmentPdfName']; ?>" target="_blank">Download</a>
                    <br/>
                  </div>   -->
                <?php } ?>
                  <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
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

<!-- Comment Data -->

            <div id="stepp11" style="display:none; margin-top:15px;">
              <?php $getCommentData = $this->BabyModel->getCommentList(1,2,$babyData['babyId'],$babyAdmissionData['id']); ?>
                <div class="col-md-12" style="overflow: auto;">
                  <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                    <thead>
                      <tr>
                        <th style="width:70px;">S&nbsp;No.</th>
                        <th>Comments&nbsp;By</th>
                        <th>Comment</th>
                        <th>Comment&nbsp;DateTime</th>
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

                      </div>
                  </div>
               </div>
             </form>
           </div>
          </div>
        </div>
    </section>
 </div>

 <div id="myImgModal1" class="modal" style="padding-top: 25px;">
  <span class="close" onclick="closeImgModal1()">&times;</span>
  <center><div style="color: #fff;margin-bottom: 10px;">
    <!-- <i class="fa fa-undo" aria-hidden="true" style="font-size: 22px; cursor: pointer;"></i> -->
    </div>
  </center>
  <img class="modal-content" id="img02" style="width: 500px; height: 500px; margin-top: 20px;">
  <div id="caption"></div>
</div>


<script>
    $(document).ready(function(){
        $("#step1").click(function(){
        $("#stepp1").show();
        $("#assesment").hide();        
        $("#kmcValues").hide();        
        $("#milkValues").hide();        
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });
        $("#step2").click(function(){
        $("#scriptFileName").val('Asssement_List');
        $("#kmcValues").hide();
        $("#stepp2").show();
        $("#assesment").show();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });
        $("#step3").click(function(){
        $("#stepp3").show();
        $("#assesment").hide();         
        $("#kmcValues").hide();  
        $("#milkValues").hide();          
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });
        $("#step4").click(function(){
        $("#stepp4").show();
        $("#assesment").hide();         
        $("#kmcValues").show(); 
        $("#milkValues").hide();          
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });
        $("#step5").click(function(){
        $("#stepp5").show();
        $("#assesment").hide();         
        $("#kmcValues").hide();  
        $("#milkValues").show();          
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });
        $("#step6").click(function(){
        $("#stepp6").show();
        $("#assesment").hide();
        $("#kmcValues").hide();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });
        $("#step7").click(function(){
        $("#stepp7").show();
        $("#assesment").hide();
        $("#kmcValues").hide();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });
        $("#step8").click(function(){
        $("#stepp8").show();
        $("#assesment").hide();
        $("#kmcValues").hide();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });   
        $("#step9").click(function(){
        $("#stepp9").show();
        $("#assesment").hide();
        $("#kmcValues").hide();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();
        });   
        $("#step10").click(function(){
        $("#stepp10").show();
        $("#assesment").hide();
        $("#kmcValues").hide();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp11").hide();
        }); 
        $("#step11").click(function(){
        $("#stepp11").show();
        $("#assesment").hide();
        $("#kmcValues").hide();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp9").hide();
        $("#stepp10").hide();
        }); 

    });

</script>
<?php if ($getFourLevelVar == 'comment') { ?>
<script>
        $("#stepp9").show();
        $("#assesment").hide();
        $("#kmcValues").hide();
        $("#milkValues").hide();   
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp8").hide();
        $("#stepp10").hide();
        $("#stepp11").hide();

</script>
<?php } ?>
<script>
  window.onscroll = function() {myFunction()};
  var header = document.getElementById("myHeader");
  var sticky = header.offsetTop;

  function myFunction() {
    if (window.pageYOffset > sticky) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
  }

function showImgModal(src){ 
  $("#img02").attr({ "src": src });
  $('#myImgModal1').show();
}

function closeImgModal1(){
    $('#myImgModal1').hide();
}
</script>