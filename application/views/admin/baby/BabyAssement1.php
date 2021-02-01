<?php
 $loungeId     = $this->uri->segment('3');
 $GetFacility  = $this->FacilityModel->GetFacilitiesID($loungeId);
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo 'Babies Assessments'; ?> (<?php echo $GetFacility['LoungeName']; ?>)</h1>
      <ol class="breadcrumb">
        <li style="text-align:right;"><small style="float: right;color:black;font-size:12px;"><b>Temperature:</b>&nbsp;(&lt; 95.9 - &gt; 99.5)&nbsp;<b>|</b>&nbsp; <b>SpO2:</b>&nbsp;(&lt; 95)&nbsp;<b>|</b>&nbsp; <b>Heart Beat:</b>&nbsp;(&lt; 75 - &gt; 200)&nbsp;<b>|</b>&nbsp; <b>Breath Count:</b>&nbsp;(&lt; 30 - &gt; 60)</small></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
              <div class="row" style="padding-right: 25px; padding-left: 25px;margin-top: 5px;">
                 <div class="col-md-6">
                <?php if(isset($totalResult)) { 
                    ($pageNo == '1') ?  $counter = '1' : $counter = ((($pageNo*100)-100) + 1);
                    echo '<br>Showing '.$counter.' to '.((($pageNo*100)-100) + 100).' of '.$totalResult.' entries';
                 } ?>
                 </div>
                 <div class="col-md-6">
                  <form action="" method="GET">
                      <div class="input-group pull-right">
                          <input type="text" class="form-control" placeholder="Enter Keyword Value" 
                                 name="keyword" value="<?php
                                 if (!empty($_GET['keyword'])) {
                                     echo $_GET['keyword'];
                                 }
                                 ?>">
                          <span class="input-group-btn">
                              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                          </span>
                      </div>
                        <br><span style="font-size:12px;">Search via: Head Circumference, Breath Count, Sp02, Heart Beat  etc.</span> 
                  </form>
                 </div>
             </div> 
            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
               <table class="table-striped table table-bordered example" id="example" style="width: 100% !important;">
                        <thead>
                           <tr>
                               <th>S&nbsp;No.</th>
                               <th>Baby&nbsp;of&nbsp;&&nbsp;BabyDetail</th>
                              <!--   <th>HC(cm)</th> -->
                              <!--  <th>Breath<br/>Count(/min)</th> -->
                              <!--  <th>Is&nbsp;POx&nbsp;Device<br/>Available?</th> -->
                               <th>Raspiratory&nbsp;Rate</th>
                               <th>SpO2(%)</th>
                               <th>Heart&nbsp;Beat(ppm)</th> <!--or pulse rate -->
                               <th>Heart&nbsp;Rate(/min)</th> 
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
                           <?php
                            if($pageNo == '1'){
                               $counter = '1'; 
                              }else{
                                $counter = ((($pageNo*100)-100) + 1);
                              }

                            foreach($results as $key => $value) {
                                $staffName           = $this->load->BabyModel->getStaffNameBYID($value['StaffID']);
                                $GetLastAdmittedBaby = $this->load->FacilityModel->GetLastAdmittedBaby($value['BabyID']);
                                $getMotherName       = $this->db->query("select MotherName from mother_registration as mr inner join babyRegistration as br on mr.`MotherID` = br.`MotherID` where br.`BabyID`=".$value['BabyID']."")->row_array();
                                $babyIconStatus      = $this->DangerSignModel->getBabyIcon($value);
                                $icon                = ($babyIconStatus == '1') ? "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'>" : "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'>";
                             ?>
                             <tr>
                               <td><?php echo $counter;?></td>
                               <td><?php echo !empty($getMotherName['MotherName']) ? 'B/O '.$getMotherName['MotherName'] : 'B/O Unknown'; ?><br>
                                 <?php echo $icon ?> <a href="<?php echo base_url();?>babyM/viewBaby/<?php echo $value['baby_admissionID']; ?>"><span class="label label-info">Baby Detail</span></a>
                               </td>

                              <!--  <td><?php echo !empty($value['BabyHeadCircumference']) ? $value['BabyHeadCircumference'] : 'N/A';?></td> -->
                              <!--  <td><?php echo !empty($value['BabyRespiratoryRate']) ? $value['BabyRespiratoryRate'] : 'N/A';?></td> -->
                              <!--  <td><?php echo !empty($value['IsPulseOximatoryDeviceAvailable']) ? $value['IsPulseOximatoryDeviceAvailable'] : 'N/A';?></td> -->
                            
                               <td><?php echo !empty($value['breatheCount']) ? $value['breatheCount'] : 'N/A';?></td>
                              
                               <td><?php echo !empty($value['spo2']) ? $value['spo2'] : 'N/A';?></td>
                               <td><?php echo !empty($value['pulseRate']) ? $value['pulseRate'] : 'N/A';?></td>
                               <td><?php echo !empty($value['heartRate']) ? $value['heartRate'] : 'N/A';?></td>
                               <td><?php echo !empty($value['isThermometerAvail']) ? $value['isThermometerAvail'] : 'N/A';?></td>
                               <td><?php echo !empty($value['temperatureVal']) ? $value['temperatureVal'].'&nbsp;<sup>0</sup>F' : 'N/A';?></td>
                               <td><?php echo !empty($value['thermometerImage']) ? "<img src='".MOTHER_IMAGE.$value['thermometerImage']."' class='signatureSize'>" : 'N/A';?></td>
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
                               <td><?php echo !empty($value['weighingImage']) ? "<img src='".MOTHER_IMAGE.$value['weighingImage']."' class='signatureSize'>" : 'N/A';?></td>
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
                                        echo $staffName."<br><img src='".base_url()."assets/images/sign/".$GetLastAdmittedBaby['DoctorSign']."' class='signatureSize'>";
                                      } else if ($value['StaffSign'] == '') {
                                        echo 'N/A'; 
                                     } else { 
                                       echo $staffName."<br><img src='".base_url()."assets/images/sign/".$value['StaffSign']."' class='signatureSize'>";
                                     }  ?>
                               </td>                                
                             </tr>
                             <?php $counter++; } ?>
                        </tbody>
                     </table>
                     <ul class="pagination pull-right">
                      <?php
                        foreach ($links as $link) {
                            echo "<li>" . $link . "</li>";
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