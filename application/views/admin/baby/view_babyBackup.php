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
                            
     <font size="4" style="color:black;">MCTS No:&nbsp;<?php echo ($babyData['BabyMCTSNumber'] != "") ? $babyData['BabyMCTSNumber'] : 'N/A' ; ?>,&nbsp;Baby File ID:&nbsp;<?php echo $babyAdmissionData['BabyFileID']; ?></font>
       <ol class="breadcrumb">
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
                    <div id="myHeader">
                      <ul class="nav nav-tabs pull-center">
                           <li class="<?php echo ($getFourLevelVar == 'comment') ? '' : 'active'; ?>"><a href="" id="step1" data-toggle="tab">Baby Birth Information</a></li>
                           <li><a href="" id="step2" data-toggle="tab">Baby Assessment</a></li>
                           <li><a href="" id="step3" data-toggle="tab">Daily Weight</a></li>
                           <li><a href="" id="step4" data-toggle="tab">KMC Status</a></li> 
                           <li><a href="" id="step5" data-toggle="tab">Breast Feeding</a></li>
                           <li><a href="" id="step6" data-toggle="tab">Supplement</a></li>  
                           <li><a href="" id="step7" data-toggle="tab">Baby Vaccination</a></li>   
                          <?php 
                             if($getPdfLink['status'] == '2'){?>
                          <li><a href="" id="step8" data-toggle="tab">Discharged</a></li> 
                         <?php  } ?> 
                         <li class="<?php echo ($getFourLevelVar == 'comment') ? 'active' : ''; ?>"><a href="" id="step9" data-toggle="tab">Comments</a></li> 

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
                              <label for="inputEmail3" class="col-sm-2 control-label">Baby File ID</label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control" readonly value="<?php echo $babyAdmissionData['BabyFileID'];?>" style="background-color:white;">
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
                                       <th>Weight(gram)</th>
                                       <th>HC(cm)</th>
                                       <th>Breath<br/>Count(/min)</th>
                                       <th>Is&nbsp;POx&nbsp;Device<br/>Available?</th>
                                       <th>Temperature(<sup>0</sup>F)</th>
                                       <th>SpO2(%)</th>
                                       <th>Heart&nbsp;Beat(ppm)</th>
                                       <th>Have&nbsp;any<br/>pustules/boils?</th> 
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
                                       <th>Swallowing</th> 
                                       <th>Other&nbsp;observation/<br>comments</th> 
                                       <th>AssesmentDate<br>&&nbsp;Time</th> 
                                       <th>Type</th>
                                       <!-- <th>Check&nbsp;List&nbsp;Data&nbsp;of&nbsp;Baby&nbsp;Monitoring</th> -->                         
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
                                       <!-- <td><a href="<?php //echo base_url();?>facility/updateFacility/<?php //echo $FacilityName['FacilityID'];?>"><?php //echo $FacilityName['FacilityName'];?></a></td>
                                       <td><a href="<?php //echo base_url();?>loungeM/updateLounge/<?php// echo $LoungeName['LoungeID'];?>"><?php //echo $LoungeName['LoungeName'];?></a></td> -->
                                       
                                       <td><?php echo ($value['BabyMeasuredWeight'] != "") ? $value['BabyMeasuredWeight']."&nbsp;grams" : "N/A";?></td>
                                       <td><?php echo ($value['BabyHeadCircumference'] != "") ? $value['BabyHeadCircumference']."&nbsp;cm" : "N/A";?></td>
                                        
                                          <?php  if ($value['respiratory'] > 60 || $value['respiratory']<30) { ?>
                                             <td style="color:red;"> <?php echo $value['respiratory'].'&nbsp/min';?> </td>
                                          <?php } else { ?>
                                             <td> <?php echo ($value['respiratory'] != "") ? $value['respiratory']."&nbsp;/min" : "N/A";?></td>
                                          <?php } ?>

                                      <td><?php echo $value['isPulseOximatoryDeviceAvailable'];?></td>

                                          <?php  if ($value['temperatureVal'] > 95.9 && $value['temperatureVal'] < 99.5) { ?>
                                             <td> <?php echo $value['temperatureVal'].'&nbsp;<sup>0</sup>F';?> </td>
                                          <?php } else { ?>
                                             <td style="color:red;"> <?php echo ($value['temperatureVal'] != "") ? $value['temperatureVal']."&nbsp;<sup>0</sup>F" : "N/A";?></td>
                                          <?php } ?>

                                          <?php if(($value['spo2'] != null) && ($value['spo2'] < 95)) { ?>
                                            <td style="color:red;"><?php echo $value['spo2'].'&nbsp;%';?></td>
                                          <?php } else { ?>
                                             <td> <?php echo ($value['spo2'] != "") ? $value['spo2'].'&nbsp;%' : "N/A";?></td>
                                          <?php } ?>

                                          <?php if(($value['pulseRate'] != null) && ($value['pulseRate'] < 75 || $value['pulseRate'] > 200)) { ?>
                                            <td style="color:red;"> <?php echo $value['pulseRate'].'&nbsp;ppm';?> </td>
                                          <?php } else { ?>
                                            <td> <?php echo ($value['pulseRate'] != "") ? $value['pulseRate']."&nbsp;ppm" : "N/A";?></td>
                                          <?php } ?>                                  
                                      
                                       
                                       
                                       <td><?php echo ($value['BabyHavePustulesOrBoils'] != "") ? $value['BabyHavePustulesOrBoils'] : "N/A";?></td>
                                       <td><?php echo ($value['LocationOfPusrulesOrBoils'] != "") ? $value['LocationOfPusrulesOrBoils'] : "N/A";?></td>
                                       <td><?php echo ($value['SizeOfPusrulesOrBoils'] != "") ? $value['SizeOfPusrulesOrBoils'] : "N/A";?></td>
                                       <td><?php echo ($value['NumberOfPusrulesOrBoils'] != "") ? $value['NumberOfPusrulesOrBoils'] : "N/A";?></td>
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
                                       <td><?php echo ($value['SkinColor'] != "") ? $value['SkinColor'] : "N/A";?></td>
                                       <td><?php echo ($value['MotherBreastPain'] != "") ? $value['MotherBreastPain'] : "N/A";?></td>
                                       <td><?php echo ($value['MotherBreastCondition'] != "") ? $value['MotherBreastCondition'] : "N/A";?></td>
                                       <td><?php echo ($value['MotherBreastStatus'] != "") ? $value['MotherBreastStatus'] : "N/A";?></td>
                                       <td><?php echo ($value['BabyMilkConsumption1'] != "") ? $value['BabyMilkConsumption1'] : "N/A";?></td>
                                       <td><?php echo ($value['BabyMilkConsumption2'] != "") ? $value['BabyMilkConsumption2'] : "N/A";?></td>
                                       <td><?php echo ($value['BabyMilkConsumption3'] != "") ? $value['BabyMilkConsumption3'] : "N/A";?></td>
                                       <td><?php echo ($value['Other'] != "") ? $value['Other'] : "N/A";?></td>
                                       <td><?php echo (($value['AssesmentDate'] != '') ? date('d-m-Y',strtotime($value['AssesmentDate'])) : "N/A").'<br>'.(($value['AssesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['AssesmentTime']))) : "N/A");?></td>
                                       <td> <?php echo($value['Type'] == '1') ? "Monitoring" : "Discharged"; ?> </td>   
                         <!--               <td>
                                        <?php 
                                          if($getFirstAssessment['id'] == $value['id'])
                                          { 
                                              $getrecord = $this->db->query("select CheckList from checklistmaster where BabyAdminID=".$value['BabyID']."")->row_array();                                 
                                                $data =json_decode($getrecord['CheckList'], true);
                                                   if(count($data) > 0){
                                                      $count=1; ?>
                                                      <?php 
                                                         foreach ($data as $key => $val) {?>
                                                            <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></br/>
                                                           <?php } ?>
                                             <?php } } else { ?>
                                            <?php echo 'N/A';?>
                                         <?php }?>
                                      </td> -->

                                      <?php 
                                        if($value['Type'] != "1") { 
                                          $staffName = $dischargeTimeDName['Name'];
                                        }
                                        else if (empty($staffName['Name'])) {
                                             $staffName = "N/A";
                                        } else {
                                              $staffName = $staffName['Name'];
                                          }
                                       ?> 
                                  <td> 
                                    <?php 
                                      if($value['Type'] != "1") { 
                                         echo $staffName."<br><img src='".base_url()."assets/images/sign/".$GetLastAdmittedBaby['DoctorSign']."' style='height:100px; width:100px;'>";
                                      } else if ($value['StaffSign'] == '') {
                                         echo 'N/A'; 
                                      } else { 
                                         echo $staffName."<br><img src='".base_url()."assets/images/sign/".$value['StaffSign']."' style='height:100px; width:100px;'>";
                                      } ?>
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
                               if(count($getBaby) > 0){  ?>
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
                              ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td><?php echo date('d-m-Y',strtotime($value['FeedDate'])); ?></td>
                                  <td><?php echo strtoupper(date('h:i a', strtotime($value['FeedTime']))); ?></td>
                                  <td><?php echo $value['BreastFeedMethod'];?></td>
                                  <td><?php echo $value['BreastFeedDuration'].'&nbsp;min';?></td>
                                  <td><?php echo $value['MilkQuantity'].'&nbsp;ml';?></td>
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
<!--      supplement tab start   -->
                      <div id="stepp6" style="display:none; margin-top:15px;">
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">S&nbsp;No.</th>
                                <th>Supplement&nbsp;Date</th>
                                <th>Supplement&nbsp;Time</th>
                                <th>Vitamins</th>
                                <th>No.&nbsp;Of&nbsp;Drops</th>
                                <th>Quantity(ml)</th>
                                <th>Nurse&nbsp;Name</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $getBaby = $this->load->BabyModel->getBabysSupplimentBYAdmissionID($babyData['BabyID'],$babyAdmissionData['id']);
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                                $nurseName = singlerowparameter2('Name','StaffID',$value['NurseId'],'staff_master');
                              ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td><?php echo date('d-m-Y',$value['AddDate']) ?></td>
                                  <td><?php echo $value['SupplimentTime'];?></td>
                                  <td><?php echo $value['SupplimentName'];?></td>
                                  <td><?php echo $value['DoseInDrop'];?></td>
                                  <td><?php echo $value['DoseInML'].'&nbsp;ml';?></td>
                                  <td><?php echo $nurseName;?></td>
                                </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div> 
<!--      vaccination tab start   -->
                      <div id="stepp7" style="display:none; margin-top:15px;">
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


<!--   Discharged Data -->

            <div id="stepp8" style="display:none;">
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

<!-- Comments Data -->

            <div id="stepp9" style="display:none; margin-top:15px;">
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
                                                                                
                        <div id="stepp" style="display:none;">

                            <?php $BabyAssessment = $this->load->BabyModel->GetBabyAssessmentData($babyData['BabyID']);?>  
                            <div class="col-md-12" style="margin-top:10px;"><h4>KMC Admission Weight:</h4></div>
                            <div class="form-group">
                               <label for="inputEmail3" class="col-sm-2 control-label">Baby Weight in gm</label>
                               <div class="col-sm-10">
                               <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['BabyMeasuredWeight'];?>" style="background-color:white;">
                               </div>
                            </div> 
                            <div class="col-md-12"><h4>Head Circumference of baby:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Head Circumference of baby</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['BabyHeadCircumference'];?>" style="background-color:white;">
                                </div>
                            </div>  
                            <div class="col-md-12"><h4>Measure  the  breath count:</h4></div>
                            <div class="form-group">
                               <label for="inputEmail3" class="col-sm-2 control-label">Measure  the  breath count</label>
                               <div class="col-sm-10">
                               <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['BabyMeasuredWeight'];?>" style="background-color:white;">
                               </div>
                            </div>
                            <div class="col-md-12"><h4>Next check ups should be done in KMC Position,Please cover the baby with blanket:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Baby's Photo</label>
                                 <div class="col-sm-4">
                                 <img  src="<?php echo base_url();?>assets/images/baby_images/<?php echo $babyData['BabyPhoto']?>" class="form-control"  style="height:200px;width:200px;margin-top:5px;" >
                                 </div>
                            </div>
                            <div class="col-md-12"><h4>Heart   Beat   Oxidation Check:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Sp02 in %</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['BabyPulseSpO2'];?>" style="background-color:white;">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Heart Beat in ppm</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['BabyPulseRate'];?>" style="background-color:white;">
                                </div>
                            </div>
                            <div class="col-md-12"><h4>Measure  the  axillary temprature,Please thermometer vertically in axila:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Temperature in <sup>0</sup>&nbsp;F</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['BabyTemperature'];?>" style="background-color:white;">
                                </div>
                            </div> 
                            <div class="col-md-12"><h4>Other Danger Signs:</h4></div>
                            <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Observe baby for any danger sign</label>
                                  <div class="col-sm-10">
                                      <?php  $string = $BabyAssessment['BabyOtherDangerSign'];;
                                      $data =json_decode($string, true);
                                      if(count($data) > 0){
                                          $count=1;
                                          foreach ($data as $key => $value) {?>
                                           <ul>
                                              <li style="font-size:15px;"><b style="color:red;"><?php echo $count++;?>&nbsp;</b><?php echo $value['name'];?></li>
                                            </ul>
                                               
                                         <?php }} else {?>
                                            <input type="text" class="form-control" value="<?php echo 'No Danger Sign';?>" readonly style="background-color:white;">
                                       <?php }?>
                                  </div>
                            </div>
                            <div class="col-md-12"><h4>Examine the baby if its skin color is bluish,observed:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Baby Skin Color</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['SkinColor'];?>" style="background-color:white;">
                                </div>
                            </div>
                            <div class="col-md-12"><h4>Breast Examination observe mother's breast with her consent:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Breast/Nipple Pain?</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $BabyAssessment['MotherBreastPain'];?>" style="background-color:white;">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Breast directly into the baby's mouth</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['BabyFeedBreastMilkDirect'];?>" style="background-color:white;">
                                </div>
                            </div> 
                            <div class="form-group">
                               <label for="inputEmail3" class="col-sm-2 control-label">Breast/Nipple Position</label>
                               <div class="col-sm-10">
                               <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['MotherBreastStatus'];?>" style="background-color:white;">
                               </div>
                            </div>
                            <div class="col-md-12"><h4>Observe  baby's ability of  sucking and swallowing breastmilk:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Attachment</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" readonly value="" style="background-color:white;">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Sucking</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" readonly value="" style="background-color:white;">
                                </div>
                            </div> 
                            <div class="form-group">
                               <label for="inputEmail3" class="col-sm-2 control-label">Swallowing</label>
                               <div class="col-sm-10">
                               <input type="text" class="form-control" readonly value="" style="background-color:white;">
                               </div>
                            </div> 
                            <div class="col-md-12"><h4>Other observation/comments:</h4></div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Other observation/comments</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" readonly value="<?php echo $BabyAssessment['Other'];?>" style="background-color:white;">
                                </div>
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