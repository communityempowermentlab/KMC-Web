 <?php error_reporting('1'); ?>
 
<style type="text/css">
   .ratingpoint{
    color: red;
    }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
  }
</style>
<style>
style type="text/css">
   .ratingpoint{
    color: red;
    }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
  }
   #example_filter label, .paging_simple_numbers .pagination {float: right;}
</style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <span></span>
      <h1><?php echo 'Babies Assessments'; ?> </h1>
      <ol class="breadcrumb">
        <li><small style="float: right;color:black;font-size:12px;"><b>Temperature:</b>&nbsp;(&lt; 95.9 - &gt; 99.5)&nbsp;<b>|</b>&nbsp; <b>SpO2:</b>&nbsp;(&lt; 95)&nbsp;<b>|</b>&nbsp; <b>Heart Beat:</b>&nbsp;(&lt; 75 - &gt; 200)&nbsp;<b>|</b>&nbsp; <b>Breath Count:</b>&nbsp;(&lt; 30 - &gt; 60)</small></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-md-12">
           <div class="box box-info">
             <form class="form-horizontal" name='Lounge'  action="<?php echo site_url('Admin/Add_Lounge/');?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
               <div class="box-body">
                 <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs pull-center">
                           <li class="active"><a href="" id="step2" data-toggle="tab">Baby Assessment</a></li>
                           <li><a href="" id="step3" data-toggle="tab">Daily Weight</a></li>
                           <li><a href="" id="step4" data-toggle="tab">KMC Status</a></li> 
                           <li><a href="" id="step5" data-toggle="tab">Breast Feeding</a></li>
                           <li><a href="" id="step6" data-toggle="tab">Get Supplements</a></li>  
                           <li><a href="" id="step7" data-toggle="tab">Baby Vaccination</a></li>                                                    
                      </ul>
                  <div class="tab-content no-padding">
<!--         assessment tab start   -->
                       <div id="stepp2" style="margin-top:10px;">
                        <div class="col-sm-12" style="overflow: auto;">                       
                            <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                                <thead>
                                   <tr>
                                       <th style="width:70px;">SrNo.</th>
                                       <th>Mother&nbsp;Name</th>
                                       <th>Facility&nbsp;Name</th>
                                       <th>Lounge&nbsp;Name</th>
                                       <th>Baby&nbsp;Weight(grams)</th>
                                       <th>Head&nbsp;Circumference&nbsp;of&nbsp;baby(cm)</th>
                                       <th>Breath&nbsp;Count(/min)</th>
                                       <th>Is&nbsp;Pulse&nbsp;Oximatory&nbsp;Device&nbsp;Available?</th>
                                       <th>Temperature(<sup>0</sup>F)</th>
                                       <th>SpO2(%)</th>
                                       <th>Heart&nbsp;Beat(ppm)</th>
                                       <th>Does&nbsp;the&nbsp;baby&nbsp;have&nbsp;any&nbsp;pustules/boils?</th> 
                                       <th>Location&nbsp;of&nbsp;pustules/boils</th> 
                                       <th>Size&nbsp;of&nbsp;pustules/boils</th> 
                                       <th>Number&nbsp;of&nbsp;pustules/boils</th> 
                                       <th>Observe&nbsp;baby&nbsp;for&nbsp;any&nbsp;danger&nbsp;Sign</th>                                       
                                       <th>Examine&nbsp;the&nbsp;baby&nbsp;skin&nbsp;color?</th> 
                                       <th>Breast/Nipple&nbsp;Pain</th> 
                                       <th>Milk&nbsp;without&nbsp;baby&nbsp;wearing&nbsp;if?</th> 
                                       <th>Breast&nbsp;State</th> 
                                       <th>Attachment</th> 
                                       <th>Sucking</th> 
                                       <th>Swallowing</th> 
                                       <th>Other&nbsp;observation/comments</th> 
                                       <th>AssesmentDate</th> 
                                       <th>AssesmentTime</th>
                                       <th>Type</th>
                                       <th>Check&nbsp;List&nbsp;Data&nbsp;of&nbsp;Baby&nbsp;Monitoring</th> 
                                       <th>StaffName</th> 
                                       <th>Staff&nbsp;Sign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                      $counter=1;
                                    foreach($getBabyAss as $key => $value) {
                                        $staffName          = $this->load->BabyModel->getStaffNameBYID($value['StaffID']);
                                        $LoungeName         = $this->load->BabyModel->GetLoungeById($value['LoungeID']);
                                        $FacilityName       = $this->load->FacilityModel->GetFacilityName($LoungeName['FacilityID']);
                                        $MotherID           = $this->load->FacilityModel->getBabyById($value['BabyID']);
                                        $MotherName         = $this->load->BabyModel->getMotherDataById('mother_registration',$MotherID['MotherID']);
                                        $getFirstAssessment = $this->load->FacilityModel->GetBabyForChecklist($value['BabyID']);
                                        $GetLastAdmittedBaby = $this->load->FacilityModel->GetLastAdmittedBaby($value['BabyID']);
                                        $dischargeTimeDName = $this->load->BabyModel->getStaffNameBYID($GetLastAdmittedBaby['DischargeByDoctor']);
                                     ?>
                                     <tr>
                                       <td style="width:70px;"><?php echo $counter++;?></td>
                                       <td>
                                            <?php if($MotherName['MotherName'] == ""){
                                              echo 'UNKNOWN';
                                            } else { ?>
                                              <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName['MotherID'];?>"><?php echo $MotherName['MotherName']; ?></a>
                                            <?php  } ?>
                                       </td>
                                       <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $FacilityName['FacilityID'];?>"><?php echo $FacilityName['FacilityName'];?></a></td>
                                       
                                       <td><a href="<?php echo base_url();?>loungeM/updateLounge/<?php echo $LoungeName['LoungeID'];?>"><?php echo $LoungeName['LoungeName'];?></a></td>
                                       
                                       <td><?php echo ($value['BabyMeasuredWeight'] != "") ? $value['BabyMeasuredWeight']."&nbsp;grams" : "N/A";?></td>
                                       <td><?php echo ($value['BabyHeadCircumference'] != "") ? $value['BabyHeadCircumference']."&nbsp;cm" : "N/A";?></td>
                                        
                                          <?php  if ($value['BabyRespiratoryRate'] >60 || $value['BabyRespiratoryRate']<30) { ?>
                                             <td style="color:red;"> <?php echo $value['BabyRespiratoryRate'].'&nbsp/min';?> </td>
                                          <?php } else { ?>
                                             <td> <?php echo ($value['BabyRespiratoryRate'] != "") ? $value['BabyRespiratoryRate']."&nbsp;/min" : "N/A";?></td>
                                          <?php } ?>

                                      <td><?php echo $value['IsPulseOximatoryDeviceAvailable'];?></td>

                                          <?php  if ($value['BabyTemperature'] > 95.9 && $value['BabyTemperature'] < 99.5) { ?>
                                             <td> <?php echo $value['BabyTemperature'].'&nbsp;<sup>0</sup>F';?> </td>
                                          <?php } else { ?>
                                             <td style="color:red;"> <?php echo ($value['BabyTemperature'] != "") ? $value['BabyTemperature']."&nbsp;<sup>0</sup>F" : "N/A";?></td>
                                          <?php } ?>

         

                                          <?php if(($value['BabyPulseSpO2'] != null) && ($value['BabyPulseSpO2'] < 95)) { ?>
                                            <td style="color:red;"><?php echo $value['BabyPulseSpO2'].'&nbsp;%';?></td>
                                          <?php } else { ?>
                                             <td> <?php echo ($value['BabyPulseSpO2'] != "") ? $value['BabyPulseSpO2'].'&nbsp;%' : "N/A";?></td>
                                          <?php } ?>

                                          <?php if(($value['BabyPulseRate'] != null) && ($value['BabyPulseRate'] < 75 || $value['BabyPulseRate'] > 200)) { ?>
                                            <td style="color:red;"> <?php echo $value['BabyPulseRate'].'&nbsp;ppm';?> </td>
                                          <?php } else { ?>
                                            <td> <?php echo ($value['BabyPulseRate'] != "") ? $value['BabyPulseRate']."&nbsp;ppm" : "N/A";?></td>
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
                                       <td><?php echo ($value['AssesmentDate'] != '') ? date('d-m-Y',strtotime($value['AssesmentDate'])) : "N/A";?></td>
                                       <td><?php echo ($value['AssesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['AssesmentTime']))) : "N/A";?></td>
                                       <td> <?php $type = $value['Type'];
                                             if($type=='1'){
                                              echo"Monitoring";
                                             }else{
                                              echo"Discharged";
                                             }?>
                                      </td> 
                                       <td>
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
                                      </td>
                                       <td><?php 
                                              if($value['Type'] != "1") { 
                                                 echo $dischargeTimeDName['Name'];
                                              }
                                              else if (empty($staffName['Name'])) {
                                                   echo"N/A";
                                              } else {
                                                   echo $staffName['Name'];
                                                }?>  
                                        </td>
                                     <td><?php 
                                      if($value['Type'] != "1") { ?>
                                       <img src="<?php echo base_url();?>assets/images/sign/<?php echo $GetLastAdmittedBaby['DoctorSign'];?>" style="height:100px; width:100px;">
                                     <?php } else if ($value['StaffSign']=='') {
                                     echo 'N/A'; } else { ?> 
                                     <img src="<?php echo base_url();?>assets/images/sign/<?php echo $value['StaffSign'];?>" style="height:100px; width:100px;">
                                    <?php }  ?>
                                    </td> 
                                     </tr>
                                     <?php }?>
                                </tbody>
                            </table>
                        </div>
                      </div> 
<!--        Daily Weight tab start   -->
                     <div id="stepp3" style="display:none; margin-top:10px;">
                        <div class="col-sm-12" style="overflow: auto;">
                          <table cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">SrNo.</th>
                                <th>Mother&nbsp;Name</th>
                                <th>Facility&nbsp;Name</th>
                                <th>Lounge&nbsp;Name</th>
                                <th>Date</th>
                                <th>Baby&nbsp;Weight</th>
                              </tr>
                            </thead>
                            <tbody>
                                  <?php 
                                  $getBaby = $this->load->BabyModel->getAllTbleBabyAssessment('baby_weight_master');
                                  $counter=1;
                                  foreach($getBaby as $key => $value) { 
                                  $MotherID = $this->load->FacilityModel->getBabyById($value['BabyID']);
                                  $MotherName = $this->load->BabyModel->getMotherDataById('mother_registration',$MotherID['MotherID']); 
                                  $LoungeName = $this->load->BabyModel->GetLoungeById($value['LoungeID']);
                                  $FacilityName = $this->load->FacilityModel->GetFacilityName($LoungeName['FacilityID']);
                                
                                  ?>
                                  <tr>
                                    <td><?php echo $counter++;?></td>
                                    <td>
                                        <?php if($MotherName['MotherName'] == ""){
                                          echo 'UNKNOWN';
                                        } else { ?>
                                          <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName['MotherID'];?>"><?php echo $MotherName['MotherName']; ?></a>
                                        <?php  } ?>
                                    </td>
                                    <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $FacilityName['FacilityID'];?>"><?php echo $FacilityName['FacilityName'];?></a></td>                    
                                    <td><a href="<?php echo base_url().'loungeM/moreLounge/'.$value['LoungeID']; ?>"><?php echo $LoungeName['LoungeName'];?></a></td>
                                    <td><?php echo date('d-m-Y',$value['AddDate']); ?></td>
                                    <td><?php echo $value['BabyWeight'].'&nbsp;grams';?></td>
                                  </tr>
                                  <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
<!--      KMC status tab start   -->
                      <div id="stepp4" style="display:none;margin-top:10px">
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">SrNo.</th>
                                <th>Mother&nbsp;Name</th>
                                <th>Facility&nbsp;Name</th>
                                <th>Lounge&nbsp;Name</th>
                                <th>Date</th>
                                <th>Start&nbsp;Time</th>
                                <th>Stop&nbsp;Time</th>
                                <th>Provider</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $getBaby = $this->load->BabyModel->getAllTbleBabyAssessment('babyDailyKMC');
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                              $MotherID = $this->load->FacilityModel->getBabyById($value['BabyID']);
                              $MotherName = $this->load->BabyModel->getMotherDataById('mother_registration',$MotherID['MotherID']);
                              $LoungeName = $this->load->BabyModel->GetLoungeById($value['LoungeID']);
                              $FacilityName = $this->load->FacilityModel->GetFacilityName($LoungeName['FacilityID']);
                              ?>
                              <tr>
                                <td><?php echo $counter++;?></td>
                                <td>
                                    <?php if($MotherName['MotherName'] == ""){
                                      echo 'UNKNOWN';
                                    } else { ?>
                                      <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName['MotherID'];?>"><?php echo $MotherName['MotherName']; ?></a>
                                    <?php  } ?>
                                </td>
                                <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $FacilityName['FacilityID'];?>"><?php echo $FacilityName['FacilityName'];?></a></td>
                                <td><a href="<?php echo base_url().'loungeM/moreLounge/'.$value['LoungeID']; ?>"><?php echo $LoungeName['LoungeName'];?></a></td>
                                <td><?php echo date('d-m-Y',$value['AddDate']); ?></td>
                                <td><?php echo strtoupper(date('h:i a', strtotime($value['StartTime']))); ?></td>
                                <td><?php echo strtoupper(date('h:i a', strtotime($value['EndTime']))); ?></td>
                                <td><?php echo $value['ByWhom'];?></td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div> 
<!--      Feeding tab start   -->
                  <div id="stepp5" style="display:none; margin-top:10px;">
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">SrNo.</th>
                                <th>Mother&nbsp;Name</th>
                                <th>Facility&nbsp;Name</th>
                                <th>Lounge&nbsp;Name</th>
                                <th>Feeding&nbsp;Date</th>
                                <th>Feeding&nbsp;Time</th>
                                <th>Feeding&nbsp;Method</th>
                                <th>Time(min)</th>
                                <th>Quantity&nbsp;(ml)</th>
                                <th>Type</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $getBaby = $this->load->BabyModel->getAllTbleBabyAssessment('babyDailyNutrition');
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                              $MotherID = $this->load->FacilityModel->getBabyById($value['BabyID']);
                              $MotherName = $this->load->BabyModel->getMotherDataById('mother_registration',$MotherID['MotherID']);  
                              $LoungeName = $this->load->BabyModel->GetLoungeById($value['LoungeID']);
                             $FacilityName = $this->load->FacilityModel->GetFacilityName($LoungeName['FacilityID']);
                                 ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td>
                                      <?php if($MotherName['MotherName'] == ""){
                                        echo 'UNKNOWN';
                                      } else { ?>
                                        <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName['MotherID'];?>"><?php echo $MotherName['MotherName']; ?></a>
                                      <?php  } ?>
                                  </td>
                                  <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $FacilityName['FacilityID'];?>"><?php echo $FacilityName['FacilityName'];?></a></td>
                                  <td><a href="<?php echo base_url().'loungeM/moreLounge/'.$value['LoungeID']; ?>"><?php echo $LoungeName['LoungeName'];?></a></td>
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
                                </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>  
                      </div>  
<!--      supplement tab start   -->
                     <div id="stepp6" style="display:none; margin-top:10px;">
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">SrNo.</th>
                                <th>Mother&nbsp;Name</th>
                                <th>Facility&nbsp;Name</th>
                                <th>Lounge&nbsp;Name</th>
                                <th>Supplement&nbsp;Date</th>
                                <th>Supplement&nbsp;Time</th>
                                <th>Vitamins</th>
                                <th>No.&nbsp;Of&nbsp;Drops</th>
                                <th>Quantity(ml)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $getBaby = $this->load->BabyModel->getAllTbleBabyAssessment('babysuppliments');
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                              $MotherID = $this->load->FacilityModel->getBabyById($value['BabyID']);
                              $MotherName = $this->load->BabyModel->getMotherDataById('mother_registration',$MotherID['MotherID']);  
                              $LoungeName = $this->load->BabyModel->GetLoungeById($value['LoungeID']);
                              $FacilityName = $this->load->FacilityModel->GetFacilityName($LoungeName['FacilityID']);
                                
                              ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td>
                                      <?php if($MotherName['MotherName'] == ""){
                                        echo 'UNKNOWN';
                                      } else { ?>
                                        <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName['MotherID'];?>"><?php echo $MotherName['MotherName']; ?></a>
                                      <?php  } ?>
                                  </td>
                                  <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $FacilityName['FacilityID'];?>"><?php echo $FacilityName['FacilityName'];?></a></td>
                                  <td><a href="<?php echo base_url().'loungeM/moreLounge/'.$value['LoungeID']; ?>"><?php echo $LoungeName['LoungeName'];?></a></td>
                                  <td><?php echo date('d-m-Y',$value['AddDate']) ?></td>
                                  <td><?php echo $value['SupplimentTime'];?></td>
                                  <td><?php echo $value['SupplimentName'];?></td>
                                  <td><?php echo ($value['DoseInDrop'] != "") ? $value['DoseInDrop']:'N/A' ;?></td>
                                  <td><?php echo $value['DoseInML'].'&nbsp;ml';?></td>
                                </tr>
                              <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div>  
<!--      vaccination tab start   -->
                     <div id="stepp7" style="display:none; margin-top:10px;">
                        <div class="col-md-12" style="overflow: auto;">
                          <table  cellpadding="0" cellspacing="0" border="0" class="table-striped table table-bordered editable-datatable example " id="example">
                            <thead>
                              <tr>
                                <th style="width:70px;">SrNo.</th>
                                <th>Mother&nbsp;Name</th>
                                <th>Facility&nbsp;Name</th>
                                <th>Lounge&nbsp;Name</th>
                                <th>Vaccination&nbsp;Date</th>
                                <th>Vaccination&nbsp;Time</th>
                                <th>Vaccination&nbsp;Name</th>
                                <th>Quantity(ml)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $getBaby = $this->load->BabyModel->getAllTbleBabyAssessment('babyvaccination');
                              $counter=1;
                              foreach($getBaby as $key => $value) { 
                              $MotherID = $this->load->FacilityModel->getBabyById($value['BabyID']);
                              $MotherName = $this->load->BabyModel->getMotherDataById('mother_registration',$MotherID['MotherID']);  
                              $LoungeName = $this->load->BabyModel->GetLoungeById($value['LoungeID']);
                              $FacilityName = $this->load->FacilityModel->GetFacilityName($LoungeName['FacilityID']);
                                
                              ?>
                                <tr>
                                  <td><?php echo $counter++;?></td>
                                  <td>
                                      <?php if($MotherName['MotherName'] == ""){
                                        echo 'UNKNOWN';
                                      } else { ?>
                                        <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $MotherName['MotherID'];?>"><?php echo $MotherName['MotherName']; ?></a>
                                      <?php  } ?>
                                  </td>
                                  <td><a href="<?php echo base_url();?>facility/updateFacility/<?php echo $FacilityName['FacilityID'];?>"><?php echo $FacilityName['FacilityName'];?></a></td>
                                  <td><a href="<?php echo base_url().'loungeM/moreLounge/'.$value['LoungeID']; ?>"><?php echo $LoungeName['LoungeName'];?></a></td>
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
                                                                                                       
                      </div>
                  </div>
               </div>
             </form>
           </div>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>

<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/BannerStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Lounge ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Lounge ?");}
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
    }
  }
</script>
  <script>
    $(document).ready(function(){
        $("#step2").click(function(){
        $("#stepp2").show();
        $("#assesment").show();
        $("#stepp1").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        });
        $("#step3").click(function(){
        $("#stepp3").show();
        $("#assesment").hide();         
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        });
        $("#step4").click(function(){
        $("#stepp4").show();
        $("#assesment").hide();         
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        });
        $("#step5").click(function(){
        $("#stepp5").show();
        $("#assesment").hide();         
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        });
        $("#step6").click(function(){
        $("#stepp6").show();
        $("#assesment").hide();
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp7").hide();
        });
        $("#step7").click(function(){
        $("#stepp7").show();
        $("#assesment").hide();
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        });
    });
</script>
