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
      $getPdfLink          = $this->load->BabyModel->getBabyRecord($babyData['BabyID']); 

      // set baby file id and sncu number respect of type
         $GetFacility = $this->FacilityModel->GetFacilitiesID($babyAdmissionData['LoungeID']);
            if($GetFacility['type'] == 1){
              $babyRegNumberHeading   = "SNCU&nbsp;Reg.&nbsp;Number";
              $babyFileId             = !empty($getPdfLink['temperoryFileId']) ? $getPdfLink['temperoryFileId'] : 'N/A';
            }else{
              $babyRegNumberHeading   = "Baby&nbsp;File&nbsp;ID";
              $babyFileId             = !empty($getPdfLink['BabyFileID']) ? $getPdfLink['BabyFileID'] : 'N/A';
            }
      // end setup file id

      $GetLounge           = $this->load->FacilityModel->GetFacilitiesID($getPdfLink['LoungeID']);
      //$get_last_assessment = $this->FacilityModel->GetBabyDanger($babyData['BabyID']);
      $get_last_assessment = $this->BabyModel->getMonitoringExistData($babyAdmissionData['BabyID'],$babyAdmissionData['id'],$babyAdmissionData['LoungeID']);
      $babyIconStatus      = $this->DangerSignModel->getBabyIcon($get_last_assessment);

      if($babyIconStatus == '1') {
          $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>";
      }else if($babyIconStatus == '0'){
          $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
      }else{
        $icon ="";
      }
       
      $MotherName = $this->load->BabyModel->getMotherDataById('mother_registration',$babyData['MotherID']);
      echo $icon;
      ?>

       Baby Of&nbsp;<?php echo ($MotherName['MotherName'] != "") ? ucwords($MotherName['MotherName']).' ('.$GetLounge['LoungeName'].')' : "Unknown Mother (".$GetLounge['LoungeName'].")";?>
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
                            
     <font size="4" style="color:black;">MCTS No:&nbsp;<?php echo ($babyData['BabyMCTSNumber'] != "") ? $babyData['BabyMCTSNumber'] : 'N/A' ; ?>,&nbsp;<?php echo $babyRegNumberHeading; ?>:&nbsp;<?php echo $babyFileId; ?></font>
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
                           <li><a href="" id="step5" data-toggle="tab">KMC Nutrition</a></li>
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
                     $checkMonitoringOrNot = $this->db->get_where('dailybabymonitoring',array('BabyID'=>$babyData['BabyID']))->num_rows();
                       if($checkMonitoringOrNot > 0){ ?> 
                          <div class="col-md-12" style="margin-top:10px;">Admission Form Report&nbsp;<a target="_blank" href="<?php echo base_url();?>assets/PdfFile/<?php echo $babyAdmissionData['BabyPDFFileName'];?>">Download</a></div>
                     <?php } ?>
                        </div>
                         </div>
                          <div class="form-group" style="margin-top:5px;">
                              <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $babyRegNumberHeading; ?></label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control" readonly value="<?php echo $babyFileId; ?>" style="background-color:white;">
                              </div>
                              <label for="inputEmail3" class="col-sm-2 control-label">Baby's MCTS ID</label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control" readonly value="<?php echo $babyData['BabyMCTSNumber']?>" style="background-color:white;">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Baby's Photo</label>
                              <div class="col-sm-4">
                                  <?php if($babyData['BabyPhoto' ]== 'NULL' || $babyData['BabyPhoto' ] == ' NULL') { ?>
                                  <img  src="<?php echo base_url();?>assets/images/baby.png"   style="height:200px;width:200px;margin-top:5px;">
                                  <?php }else{?>
                                  <img  src="<?php echo base_url();?>assets/images/baby_images/<?php echo $babyData['BabyPhoto']; ?>" class="img-responsive">
                                  <?php } ?>
                              </div>
                              <label for="inputEmail3" class="col-sm-2 control-label">Delivery Date<br/>(dd-mm-yyyy)</label>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" readonly value="<?php echo $babyData['DeliveryDate']?>" style="background-color:white;">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Delivery Time</label>
                              <div class="col-sm-4">
                              <input type="text" class="form-control" readonly value="<?php echo date('g:i A',strtotime($babyData['DeliveryTime'])); ?>" style="background-color:white;">
                              </div>
                              <label for="inputEmail3" class="col-sm-2 control-label">Sex</label>
                              <div class="col-sm-4 ">
                              <input type="text" class="form-control" readonly value="<?php echo $babyData['BabyGender']?>" style="background-color:white;">
                              </div>
                          </div> 

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Baby Birth Weight Available</label>
                              <div class="col-sm-4">
                                <?php if($babyData['BirthWeightAvail']=='1'){?>
                                <input type="text" class="form-control" readonly value="<?php echo 'Yes';?>" style="background-color:white;">
                                <?php } else if($babyData['BirthWeightAvail']=='2') {?>
                                   <input type="text" class="form-control" readonly value="<?php echo 'No';?>" style="background-color:white;"><br/>
                                   <textarea cols="3" rows="3" readonly class="form-control"><?php echo $babyData['Reason'];?></textarea>
                                <?php } ?>
                              </div>
                              <label for="inputEmail3" class="col-sm-2 control-label">Baby Birth Weight in grams</label>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" readonly value="<?php echo $babyData['BabyWeight']?>" style="background-color:white;">
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Delivery Type</label>
                              <div class="col-sm-4">
                              <input type="text" class="form-control" readonly value="<?php echo $babyData['DeliveryType']?>" style="background-color:white;">
                              </div>
                              <label for="inputEmail3" class="col-sm-2 control-label">Did the Baby cry immediately after birth?</label>
                              <div class="col-sm-4">
                              <input type="text" class="form-control" readonly value="<?php echo $babyData['BabyCryAfterBirth']?>" style="background-color:white;">
                              </div>
                          </div>

                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Did the Baby need resuscitation</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" readonly value="<?php echo $babyData['BabyNeedBreathingHelp']?>" style="background-color:white;">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Time of First Feed?</label>
                            <div class="col-sm-4">
                               <input type="text" class="form-control" readonly value="<?php echo $babyData['FirstTimeFeed']?>" style="background-color:white;">
                            </div>
                            <div class="col-md-12" style="height:100px"></div>
                          </div> 
                      </div>
<!--         assessment tab start   -->
                      <div id="stepp2" style="display:none; margin-top:15px;">
                        <div class="col-sm-12" style="overflow: auto;">                       
                            <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                                <thead>
                                  <tr>
                                       <th>S&nbsp;No.</th>
                                      <!--   <th>HC(cm)</th> -->
                                      <!--  <th>Breath<br/>Count(/min)</th> -->
                                      <!--  <th>Is&nbsp;POx&nbsp;Device<br/>Available?</th> -->
                                       <th>Raspiratory&nbsp;Rate</th>
                                       <th>SpO2(%)</th>
                                       <th>Heart&nbsp;Beat(ppm)</th> <!--or pulse rate -->
                                       <th>Is&nbsp;Temperature&nbsp;Avail</th>
                                       <th>Temperature(<sup>0</sup>F)</th>
                                       <th>Thermometer&nbsp;Image</th> 
                                       <th>Thermometer&nbsp;Reason</th> 

        <!--                                <th>Have&nbsp;any<br/>pustules/boils?</th> 
                                       <th>Location&nbsp;of<br>Pustules/boils</th> 
                                       <th>Size&nbsp;of<br>Pustules/boils</th> 
                                       <th>Number&nbsp;of<br/>pustules/boils</th> 
                                       <th>Observe&nbsp;danger<br/>Sign</th>                                       
                                       <th>Examine&nbsp;skin&nbsp;color?</th> 
                                       <th>Breast/Nipple<br/>Pain</th> 
                                       <th>Milk&nbsp;without<br/>wearing&nbsp;if?</th> 
                                       <th>Breast&nbsp;State</th> 
                                       <th>Attachment</th> 
                                       <th>Sucking</th> 
                                       <th>Swallowing</th>  -->

                                       <th>Is&nbsp;head&nbsp;Circumference</th> 
                                       <th>Head&nbsp;Circumference&nbsp;Value</th> 
                                       <th>Head&nbsp;Circumference&nbsp;Reason</th> 
                                       <th>Is&nbsp;Weighing&nbsp;Machine&nbsp;Avail</th> 
                                       <th>Baby&nbsp;Measured&nbsp;Weight</th> 
                                       <th>Weighing&nbsp;Image</th> 
                                       <th>Weighing&nbsp;Machine&nbsp;Reason</th> 
                                       <th>Is&nbsp;Bleeding</th> 
                                       <th>Bleeding&nbsp;Val</th> 
                                       
                                       <th>Bulging&nbsp;Anterior&nbsp;Fontanel</th> 
                                       <th>FlowR&nbsp;ate</th> 
                                       <th>Dignosys</th> 
                                       <th>AgaAgs</th> 
                                       <th>CrtVal</th> 
                                       <th>Downes&nbsp;Score</th> 
                                       <th>Activity</th> 
                                       <th>Levnes&nbsp;Score</th> 
                                       <th>Blood&nbsp;Pressure</th> 
                                       <th>Blood&nbsp;Glucose</th> 
                                       <th>Fl02</th> 
                                       <th>Abdominal&nbsp;Girth</th> 
                                       <th>R.T.&nbsp;Aspirate</th> 
                                       <th>IV&nbsp;Patency</th> 
                                       <th>Blood&nbsp;Collection</th> 
                                       <th>Blood&nbsp;Suger</th> 
                                       <th>Oxygen&nbsp;Saturation</th> 
                                       <th>Is&nbsp;Cft&nbsp;Greater&nbsp;Three</th> 
                                       <th>Is&nbsp;Any&nbsp;Complication&nbsp;AtBirth</th> 
                                       <th>Other&nbsp;Complications</th> 
                                       <th>Last24Hrs&nbsp;PassedUrine</th> 
                                       <th>Last24Hrs&nbsp;PassedStool</th> 
                                       <th>Type&nbsp;Of&nbsp;Stool</th> 
                                       <th>Is&nbsp;Taking&nbsp;Breast&nbsp;Feeds</th> 
                                       <th>General&nbsp;Condition</th> 
                                       <th>Tone</th> 
                                       <th>Convulsions</th> 
                                       <th>Umbilicus</th> 
                                       <th>Skin&nbsp;Pustules</th> 
                                       <th>Abdominal&nbsp;Distension</th> 
                                       <th>Cold&nbsp;Periphery</th> 
                                       <th>Weak&nbsp;Pulse</th> 
                                       <th>Specify&nbsp;Other</th> 
                                       <th>CVS&nbsp;Val</th> 
                                       <th>Per&nbsp;Abdomen</th> 
                                       <th>CNS&nbsp;Val</th> 
                                       <th>Other&nbsp;Significant&nbsp;Finding</th> 
                                       <th>Apnea&nbsp;Or&nbsp;Gasping</th> 
                                       <th>Sucking</th> 
                                       <th>Grunting</th> 
                                       <th>Chest&nbsp;Indrawing</th> 
                                       <th>Color</th> 
                                       <th>Is&nbsp;Jaundice</th> 
                                       <th>Jaundice&nbsp;Val</th>  

                                       <th>Other&nbsp;observation/<br>comments</th> 
                                       <th>AssesmentDate<br>&&nbsp;Time</th> 
                                       <th>Type</th>
                                       <th>StaffName/<br>Staff&nbsp;Sign</th> 
                                  </tr>
                               </thead>
                               <tbody>
                                    <?php $getBaby = $this->load->BabyModel->getBabysBYAdmisionId($babyData['BabyID'],$babyAdmissionData['id']);
                                    $counter=1;
                                    foreach($getBaby as $key => $value) {
                                        $staffName = $this->load->BabyModel->getStaffNameBYID($value['StaffID']);
                                        $LoungeName = $this->load->BabyModel->GetLoungeById($value['LoungeID']);
                                        $FacilityName = $this->load->FacilityModel->GetFacilityName($LoungeName['FacilityID']);
                                        $MotherID = $this->load->FacilityModel->getBabyById($value['BabyID']);
                                        $MotherName = $this->load->BabyModel->getMotherDataById('mother_registration',$MotherID['MotherID']);
                                        $getFirstAssessment = $this->db->query("select * from dailybabymonitoring where BabyID=".$value['BabyID']." order by id asc limit 0,1")->row_array();
                                        $GetLastAdmittedBaby = $this->load->FacilityModel->GetLastAdmittedBaby($value['BabyID']);
                                        $dischargeTimeDName = $this->load->BabyModel->getStaffNameBYID($GetLastAdmittedBaby['DischargeByDoctor']);
                                      
                                     ?>
                                     <tr>
                                       <td style="width:70px;"><?php echo $counter++;?></td>
                                      <!--  <td><?php echo !empty($value['BabyHeadCircumference']) ? $value['BabyHeadCircumference'] : 'N/A';?></td> -->
                                      <!--  <td><?php echo !empty($value['BabyRespiratoryRate']) ? $value['BabyRespiratoryRate'] : 'N/A';?></td> -->
                                      <!--  <td><?php echo !empty($value['IsPulseOximatoryDeviceAvailable']) ? $value['IsPulseOximatoryDeviceAvailable'] : 'N/A';?></td> -->
                                    
                                       <td><?php echo !empty($value['respiratory']) ? $value['respiratory'] : 'N/A';?></td>
                                      
                                       <td><?php echo !empty($value['spo2']) ? $value['spo2'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['pulseRate']) ? $value['pulseRate'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['isThermometerAvail']) ? $value['isThermometerAvail'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['temperatureVal']) ? $value['temperatureVal'].'&nbsp;<sup>0</sup>F' : 'N/A';?></td>
                                       <td><?php echo !empty($value['thermometerImage']) ? "<img src='".MOTHER_IMAGE.$value['thermometerImage']."' style='width:100px;height:100px;'>" : 'N/A';?></td>
                                       <td><?php echo !empty($value['thermometerReason']) ? $value['thermometerReason'] : 'N/A';?></td>
                                      
                                      <!-- <td><?php echo !empty($value['BabyHavePustulesOrBoils']) ? $value['BabyHavePustulesOrBoils'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['LocationOfPusrulesOrBoils']) ? $value['LocationOfPusrulesOrBoils'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['SizeOfPusrulesOrBoils']) ? $value['SizeOfPusrulesOrBoils'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['NumberOfPusrulesOrBoils']) ? $value['NumberOfPusrulesOrBoils'] : 'N/A';?></td>
                                       <td>
                                          
                                        <?php
                                          $data =json_decode($value['BabyOtherDangerSign'], true);
                                             if(count($data) > 0){
                                                $count=1; ?>
                                                <?php 
                                                   foreach ($data as $key => $val) {?>
                                                      <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></br/>
                                                     <?php } ?>
                                       <?php } else { ?>
                                            <?php echo 'No Danger Sign';?>
                                         <?php }?> 

                                      </td>
                                       <td><?php echo !empty($value['SkinColor']) ? $value['SkinColor'] : 'N/A'; ?></td>
                                       <td><?php echo !empty($value['MotherBreastPain']) ? $value['MotherBreastPain'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['MotherBreastCondition']) ? $value['MotherBreastCondition'] : 'N/A'; ?></td>
                                       <td><?php echo !empty($value['MotherBreastStatus']) ? $value['MotherBreastStatus'].'&nbsp;bpm' : 'N/A';?></td>
                                       <td><?php echo !empty($value['BabyMilkConsumption1']) ? $value['BabyMilkConsumption1'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['BabyMilkConsumption2']) ? $value['BabyMilkConsumption2'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['BabyMilkConsumption3']) ? $value['BabyMilkConsumption3'] : 'N/A';?></td>
                                          -->
                   
                                      <!-- new fields add-->

                                       <td><?php echo !empty($value['isheadCircumference']) ? $value['isheadCircumference'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['headCircumferenceVal']) ? $value['headCircumferenceVal'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['headCircumferenceReason']) ? $value['headCircumferenceReason'] : 'N/A';?></td>
                                       
                                       <td><?php echo !empty($value['isWeighingMachineAvail']) ? $value['isWeighingMachineAvail'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['babyMeasuredWeight']) ? $value['babyMeasuredWeight'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['weighingImage']) ? "<img src='".MOTHER_IMAGE.$value['weighingImage']."' style='width:100px;height:100px;'>" : 'N/A';?></td>
                                       <td><?php echo !empty($value['weighingMachineReason']) ? $value['weighingMachineReason'] : 'N/A';?></td>
                                  
                                      
                                       <td><?php echo !empty($value['isBleeding']) ? $value['isBleeding'] : 'N/A';?></td>
                                       <td><?php echo !empty($value['bleedingVal']) ? $value['bleedingVal'] : 'N/A';?></td>


                                      <td><?php echo !empty($value['bulgingAnteriorFontanel']) ? $value['bulgingAnteriorFontanel'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['flowRate']) ? $value['flowRate'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['dignosys']) ? $value['dignosys'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['agaAgs']) ? $value['agaAgs'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['crtVal']) ? $value['crtVal'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['downesScore']) ? $value['downesScore'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['activity']) ? $value['activity'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['levnesScore']) ? $value['levnesScore'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['bloodPressure']) ? $value['bloodPressure'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['bloodGlucose']) ? $value['bloodGlucose'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['fl02']) ? $value['fl02'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['abdominalGirth']) ? $value['abdominalGirth'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['rtAspirate']) ? $value['rtAspirate'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['ivPatency']) ? $value['ivPatency'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['bloodCollection']) ? $value['bloodCollection'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['bloodSuger']) ? $value['bloodSuger'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['oxygenSaturation']) ? $value['oxygenSaturation'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['isCftGreaterThree']) ? $value['isCftGreaterThree'] : 'N/A'; ?></td>
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
                                    
                                      <td><?php echo !empty($value['otherComplications']) ? $value['otherComplications'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['last24HrsPassedUrine']) ? $value['last24HrsPassedUrine'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['last24HrsPassedStool']) ? $value['last24HrsPassedStool'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['typeOfStool']) ? $value['typeOfStool'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['isTakingBreastFeeds']) ? $value['isTakingBreastFeeds'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['generalCondition']) ? $value['generalCondition'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['tone']) ? $value['tone'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['convulsions']) ? $value['convulsions'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['umbilicus']) ? $value['umbilicus'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['skinPustules']) ? $value['skinPustules'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['abdominalDistension']) ? $value['abdominalDistension'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['coldPeriphery']) ? $value['coldPeriphery'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['weakPulse']) ? $value['weakPulse'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['specifyOther']) ? $value['specifyOther'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['cvsVal']) ? $value['cvsVal'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['perAbdomen']) ? $value['perAbdomen'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['cnsVal']) ? $value['cnsVal'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['otherSignificantFinding']) ? $value['otherSignificantFinding'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['apneaOrGasping']) ? $value['apneaOrGasping'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['sucking']) ? $value['sucking'] : 'N/A';?></td>
                                      <td><?php echo !empty($value['grunting']) ? $value['grunting'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['chestIndrawing']) ? $value['chestIndrawing'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['color']) ? $value['color'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['isJaundice']) ? $value['isJaundice'] : 'N/A'; ?></td>
                                      <td><?php echo !empty($value['jaundiceVal']) ? $value['jaundiceVal'] : 'N/A'; ?></td>
                                  <!-- new fields add ends-->
                                  
                                       <td><?php echo !empty($value['otherComments']) ? $value['otherComments'] : 'N/A'; ?></td>
                                       <td><?php echo (($value['AssesmentDate'] != '') ? date('d-m-Y',strtotime($value['AssesmentDate'])) : "N/A").'<br>'.(($value['AssesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['AssesmentTime']))) : "N/A");?></td>
                                       <td> <?php echo($value['Type'] == '1') ? "Monitoring" : "Discharged"; ?> </td>  
                                       <td><?php (empty($staffName['Name'])) ? $staffName = "N/A" : $staffName = $staffName['Name']; ?>
                                         <?php 
                                            if($value['Type'] != "1") {
                                                echo $staffName."<br><img src='".base_url()."assets/images/sign/".$GetLastAdmittedBaby['DoctorSign']."' style='width:100px;height:100px;'' class='signatureSize'>";
                                              } else if ($value['StaffSign'] == '') {
                                                echo 'N/A'; 
                                             } else { 
                                               echo $staffName."<br><img src='".base_url()."assets/images/sign/".$value['StaffSign']."' style='width:100px;height:100px;'' class='signatureSize'>";
                                             }  ?>
                                       </td>  
                                </tr>
                               <?php } ?>
                               </tbody>
                            </table>
                        </div>
                      </div>
<!--        Daily Weight tab start   -->
                      <div id="stepp3" style="display:none;margin-top:15px;">
  
                     <?php $getBaby = $this->load->BabyModel->getBabysWeightBYAdmissionID($babyData['BabyID'],$babyAdmissionData['id']); 
                            $checkNurseData = $this->db->get_where('baby_weight_master',array('baby_admissionID'=>$babyAdmissionData['id']))->row_array();
                               if((count($getBaby) > 0) && $checkNurseData['NurseId'] != ""){  ?>
                               <div class="col-md-12">
                                <p style="float:right;">
                                  
                                  Daily Weight Report&nbsp;<a target="_blank" href="<?php echo base_url();?>assets/PdfFile/<?php echo $babyAdmissionData['BabyWeightPdfName']; ?>">Download</a>
                                 
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
                                  $nurseName = singlerowparameter2('Name','StaffID',$value['NurseId'],'staff_master');
                                  ?>
                                  <tr>
                                    <td><?php echo $counter++;?></td>
                                    <td><?php echo date('d-m-Y',$value['AddDate']); ?></td>
                                    <td><?php echo $value['BabyWeight'].'&nbsp;grams';?></td>
                                    <td><?php echo $nurseName;?></td>
                                  </tr>
                                  <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
<!--      KMC status tab start   -->
                      <div id="stepp4" style="display:none;margin-top:15px">
                      <?php $getBaby = $this->load->BabyModel->getBabysSkinBYAdmissionID($babyData['BabyID'],$babyAdmissionData['id']); 
                           if(count($getBaby) > 0){  ?>
                        <div class="col-md-12">
                          <p style="float:right;">
                            Daily KMC Report&nbsp;<a target="_blank" href="<?php echo base_url();?>assets/PdfFile/<?php echo $babyAdmissionData['BabyKMCPdfName']; ?>">Download</a>
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
                                $nurseName = singlerowparameter2('Name','StaffID',$value['NurseId'],'staff_master');
                                $getKMCTime = $this->load->BabyModel->totalKmcBYID($value['ID']);
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
                                <td><?php echo date('d-m-Y',$value['AddDate']); ?></td>
                                <td><?php echo strtoupper(date('h:i a', strtotime($value['StartTime']))); ?></td>
                                <td><?php echo strtoupper(date('h:i a', strtotime($value['EndTime']))); ?></td>
                                <td><?php echo $totalKmcTime;?></td>
                                <td><?php echo $value['ByWhom'];?></td>
                                <td><?php echo $nurseName;?></td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                          
                        </div>
                      </div> 
<!--      Feeding tab start   -->
                <div id="stepp5" style="display:none; margin-top:15px;">    
                  <?php $getBaby = $this->load->BabyModel->getBabysFeedingBYAdmissionID($babyData['BabyID'],$babyAdmissionData['id']); 
                     if(count($getBaby) > 0){  ?>                    
                      <div class="col-md-12">
                        <p style="float:right;">
                         Daily Feeding Report&nbsp;<a target="_blank" href="<?php echo base_url();?>assets/PdfFile/<?php echo $babyAdmissionData['BabyFeedingPdfName']; ?>">Download</a>
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
                                <th>Time(min)</th>
                                <th>Quantity&nbsp;(ml)</th>
                                <th>Type</th>
                                <th>Nurse Name</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                                $nurseName = singlerowparameter2('Name','StaffID',$value['NurseId'],'staff_master');
                                if($value['MilkQuantity'] == '0.00'){
                                   $totalMilk    = 'N/A';
                                }else{
                                   $totalMilk    = !empty($value['MilkQuantity']) ? $value['MilkQuantity'].' ml' : '--';
                                }
                              ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td><?php echo date('d-m-Y',strtotime($value['FeedDate'])); ?></td>
                                  <td><?php echo strtoupper(date('h:i a', strtotime($value['FeedTime']))); ?></td>
                                  <td><?php echo $value['BreastFeedMethod'];?></td>
                                  <td><?php echo $value['BreastFeedDuration'].'&nbsp;min';?></td>
                                  <td><?php echo $totalMilk; ?></td>
                                  <td><?php if($value['FeedingType']=='1') { 
                                   echo"Direct";  ?>
                                  <?php } else if($value['FeedingType']=='2'){
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
                        <?php $getInvestigationData = $this->db->get_where('investigation',array('BabyID'=>$babyData['BabyID']))->result_array(); ?>
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
                                  $nurseName = singlerowparameter2('Name','StaffID',$value['nurseId'],'staff_master');
                                ?>
                                  <tr>
                                    <td><?php echo $counter++;?></td>
                                    <td><?php echo !empty($value['investigationName']) ? $value['investigationName'] : 'N/A' ;?></td>
                                    <td><?php echo !empty($value['sampleComment']) ? $value['sampleComment'] : 'N/A'; ?></td>
                                    <td><?php echo !empty($value['sampleImage']) ? '<img src="'.base_url().'assets/images/'.$value['sampleImage'].'" width="80" height="80">' : 'N/A'; ?></td>
                                    <td><?php echo !empty($value['result']) ? $value['result'] : 'N/A'; ?></td>
                                    <td><?php echo !empty($value['resultImage']) ? '<img src="'.base_url().'assets/images/investigation_images/'.$value['resultImage'].'" width="80" height="80">' : 'N/A'; ?></td>
                                    <td><?php echo !empty($value['nurseComment']) ? $value['nurseComment'] : 'N/A'; ?></td>
                                    <td><?php echo !empty($nurseName) ? $nurseName : 'N/A'; ?></td>
                                    <td><?php echo date("d-m-Y g:i A",$value['addDate']);?></td>         
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
                              <?php //$getBaby = $this->load->BabyModel->getBabysSupplimentBYAdmissionID($babyData['BabyID'],$babyAdmissionData['id']);
                              $getBaby = $this->db->get_where('prescription_nursewise',array('status'=>1,'BabyID'=>$babyData['BabyID']))->result_array();
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                                $nurseName = singlerowparameter2('Name','StaffID',$value['nurseId'],'staff_master');
                              ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td><?php echo !empty($value['prescriptionName']) ? $value['prescriptionName'] : 'N/A'; ?></td>
                                  <td><?php echo !empty($value['quantity']) ? $value['quantity'].'&nbsp;ml' : 'N/A'; ?></td>
                                  <td><?php echo !empty($value['comment']) ? $value['comment'] : 'N/A'; ?></td>
                                  <td><?php echo !empty($nurseName) ? $nurseName : 'N/A'; ?></td>
                                  <td><?php echo date('d-m-Y g:i A',$value['addDate']) ?></td>
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
                    <?php $getBaby = $this->load->BabyModel->getBabysVaccinationBYAdmissionID($babyData['BabyID'],$babyAdmissionData['id']);
                    $counter=1;
                    foreach($getBaby as $key => $value) { 
                    ?>
                      <tr>
                        <td><?php echo $counter++;?></td>
                        <td><?php echo date('d-m-Y',strtotime($value['VaccinationDate']));?></td>
                        <td><?php echo date('g:i A',strtotime($value['VaccinationTime']));?></td>
                        <td><?php echo $value['VaccinationName'];?></td>
                        <td><?php echo $value['Quantity'].'&nbsp;ml';?></td>
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
                 $DoctorName = $this->load->MotherModel->getStaffNameBYID($dischargeData['DischargeByDoctor']);
                 $NurseName  = $this->load->MotherModel->getStaffNameBYID($dischargeData['DischargeByNurse']);                
                 $DischargeType = trim($dischargeData['TypeOfDischarge'], '"');?>


                      <div class="col-md-12" style="margin-top:10px;">
                       <p style="float:right;">
                        Discharge Report&nbsp;<a target="_blank" href="<?php echo base_url();?>assets/PdfFile/<?php echo $babyAdmissionData['BabyDischargePdfName']; ?>">Download</a>
                       </p>
                      </div>



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
                                 <input type="text" class="form-control" value="<?php echo $DoctorName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Staff Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $NurseName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['Transportation'];?>" readonly style="background-color:white;">
                                 </div>
      
                             </div>


                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",$dischargeData['modify_date']);?>" readonly style="background-color:white;">
                                 </div>
      
                             </div>

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Check List</label>
                                 <div class="col-sm-10">
                                          <?php 
                                              $data = json_decode($dischargeData['DischargeChecklist'], true);
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
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['DoctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                                 <div class="col-sm-3">
                                 Family Member Signature
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['SignOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                     <div class="col-sm-3">
                      <?php if($dischargeData['AshaSign'] != "") { ?>
                                 Asha Signature
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['AshaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
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
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['ReferredReason'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DoctorName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Nurse Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $NurseName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['Transportation'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",$dischargeData['modify_date']);?>" readonly style="background-color:white;">
                                 </div>
                             </div>

                               <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Check List</label>
                                 <div class="col-sm-10">
                                          <?php 
                                              $data =json_decode($dischargeData['DischargeChecklist'], true);
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
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['DoctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                                 <div class="col-sm-3">
                                 Family Member Signature
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['SignOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                     <div class="col-sm-3">
                      <?php if($dischargeData['AshaSign'] != "") { ?>
                                 Asha Signature
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['AshaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
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
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Follow UP</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date('d-m-Y',strtotime($dischargeData['DateOfFollowUpVisit']));?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Facility</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['ReferredFacilityName'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                              <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Address Of Facility</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['ReferredFacilityAddress'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Reason For Referal</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['ReferredReason'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                            
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $DoctorName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Staff Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $NurseName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 


                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $dischargeData['Transportation'];?>" readonly style="background-color:white;">
                                 </div>
                                
                             </div>

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",$dischargeData['modify_date']);?>" readonly style="background-color:white;">
                                 </div>
                             </div>

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Check List</label>
                                 <div class="col-sm-10">
                                              <?php 
                                              $data =json_decode($dischargeData['DischargeChecklist'], true);
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
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['DoctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                                 <div class="col-sm-3">
                                 Family Member Signature
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['SignOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                 </div>
                     <div class="col-sm-3">
                      <?php if($dischargeData['AshaSign'] != "") { ?>
                                 Asha Signature
                                 <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['AshaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
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
              
              $getTreatmentRecord     = $this->db->get_where('doctor_baby_prescription',array('babyId'=>$babyData['BabyID']))->result_array();
                    $getInvestigationRecord = $this->db->get_where('investigation',array('BabyID'=>$babyData['BabyID']))->result_array();
           
               ?>
                <div class="col-md-12" style="overflow: auto;">
                <!--   Treatment All Records -->
                  <div style="margin: 0px 0px 10px 0px !important;">
                    <b>Treatment Report</b> <a href="<?php echo base_url('/assets/PdfFile/').$getPdfLink['BabyTreatmentPdfName']; ?>" target="_blank">Download</a>
                    
                  </div>  
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
                        
                        $doctorName = singlerowparameter2('Name','StaffID',$value['doctorId'],'staff_master');
                       
                        $motherName = $this->db->query("select mr.MotherName from mother_registration as mr inner join babyRegistration as br on br.MotherID=mr.MotherID where br.BabyID=".$value['babyId']."")->row_array();
                      ?>
                        <tr>
                          <td><?php echo $counter++;?></td>
                          <td><?php echo !empty($doctorName) ? $doctorName : 'N/A';?></td>
                          <!--<td><?php echo !empty($motherName['MotherName']) ? $motherName['MotherName'] : 'N/A'; ?></td>-->
                          <td><?php echo !empty($value['prescription_name']) ? $value['prescription_name'] : 'N/A'; ?></td>
                          <td><?php echo !empty($value['comment']) ? $value['comment'] : 'N/A'; ?></td>
                          <td><?php echo !empty($value['image']) ? "<img src='".IMAGE_URL.$value['image']."' width='100' height='120'>" : 'N/A'; ?></td>
                          <td><?php echo date("d-m-Y g:i A",$value['addDate']);?></td>         
                        </tr>
                      <?php }?>
                    </tbody>
                  </table><br/>
                  <hr>

                <!--   Investigation All Records -->
                  <div style="margin: 0px 0px 10px 0px !important;">
                    <b>Investigation Report</b> <a href="<?php echo base_url('/assets/PdfFile/').$getPdfLink['BabyPrescriptionPdfName']; ?>" target="_blank">Download</a>
                    <br/>
                    
                  </div>  
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
                        $doctorName = singlerowparameter2('Name','StaffID',$value['doctorId'],'staff_master');
                        $motherName = $this->db->query("select mr.MotherName from mother_registration as mr inner join babyRegistration as br on br.MotherID=mr.MotherID where br.BabyID=".$value['BabyID']."")->row_array();
                      ?>
                        <tr>
                          <td><?php echo $counter++;?></td>
                          <td><?php echo !empty($doctorName) ? $doctorName : 'N/A';?></td>
                          <!--<td><?php echo !empty($motherName['MotherName']) ? $motherName['MotherName'] : 'N/A'; ?></td>-->
                          <td><?php echo !empty($value['investigationName']) ? $value['investigationName'] : 'N/A'; ?></td>
                          <td><?php echo !empty($value['doctorComment']) ? $value['doctorComment'] : 'N/A'; ?></td>
                          
                          <td><?php echo date("d-m-Y g:i A",$value['addDate']);?></td>         
                        </tr>
                      <?php }?>
                    </tbody>
                  </table>                  
                </div> 
            </div>

<!-- Comment Data -->

            <div id="stepp11" style="display:none; margin-top:15px;">
              <?php $getCommentData = $this->BabyModel->getCommentList(1,2,$babyData['BabyID'],$babyAdmissionData['id']); ?>
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
                        $nurseName = singlerowparameter2('Name','StaffID',$value['doctorID'],'staff_master');
                      ?>
                        <tr>
                          <td><?php echo $counter++;?></td>
                          <td><?php echo $nurseName;?></td>
                          <td><?php echo $value['comment']; ?></td>
                          <td><?php echo date("d-m-Y g:i A",$value['addDate']);?></td>         
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
</script>