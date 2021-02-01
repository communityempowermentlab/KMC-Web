<?php
 $loungeId     = $this->uri->segment('3');
 $GetFacility  = $this->FacilityModel->GetFacilitiesID($loungeId);
?>
<style type="text/css">
  th{
     valign:top !important;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"> 
      <h1><?php echo 'Mothers Assessments'; ?> (<?php echo $GetFacility['LoungeName']; ?>)</h1>
      <ol class="breadcrumb">
        <li>
          <small>
            <b>Temperature:</b>&nbsp;(< 95.9 - > 99.5)<b>&nbsp;|&nbsp;</b><b>Heart Beat:&nbsp;</b>(< 50 - > 120)<b>&nbsp;|&nbsp;</b><b>Systolic:</b>&nbsp;(>= 140 - <= 90)<b>&nbsp;|&nbsp;</b><b>Diastolic:</b>&nbsp;(>= 90 - <= 60)
          </small>
        </li>
      </ol>      
    </section>
    <!-- Main content -->
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
                        <br><span style="font-size:12px;">Search via: Mother Name, Systolic, Diastolic, Heart Beat, Temperature and Mother's Uterine tone etc.</span> 
                  </form>
                 </div>
                </div> 
            <div class="box-body">
              <div class="col-sm-12" style="overflow: auto;">
                 <table class="table-striped table table-bordered example" id="example" style="width: 100% !important;">
                      <thead>
                         <tr>
                             <th>S&nbsp;No.</th>
                             <th>Mother&nbsp;Name&nbsp;</th>
                             <th>Systolic<br>(mm&nbsp;Hg)</th>
                             <th>Diastolic<br>(mm&nbsp;Hg)</th>
                             <th>Heart&nbsp;Beat<br>(/min)</th>
                             <th>Uterine<br>tone</th>
                             <th>Temperature<br>(<sup>0</sup>F)</th> 
                             <th>Episiotomy<br>Stiches</th> 
                             <th>Did&nbsp;the&nbsp;Urinate/Pass<br/>Urine&nbsp;after&nbsp;delivery</th> 
                             <th>How&nbsp;much&nbsp;is&nbsp;Pad&nbsp;full?</th> 
                             <th>Is&nbsp;it<br/>smelly?</th> 
                             <th>EDD Value</th> 
                             <th>Antenatal Visit's</th> 
                             <th>T.T Doses</th> 
                             <th>Hb</th> 
                             <th>Blood Group</th> 
                             <th>Is&nbsp;Pih<br/>Avail</th> 
                             <th>Pih Value</th> 
                             <th>Drug Avail</th> 
                             <th>Drug</th> 
                             <th>Radiation</th> 
                             <th>Illness Value</th> 
                        
                             <th>APH</th> 
                             <th>GDM</th> 
                             <th>Thyroid</th> 
                             <th>VDRL</th> 
                             <th>HbsAg</th> 
                             <th>HIV Testing</th> 
                             <th>Amniotic<br/>Fluid Volume</th> 
                             <th>other<br/>Significant Info</th> 
                             <th>Antenatal<br/>Steroids Avail</th> 
                             <th>Antenatal<br/>Steroids Value</th> 
                             <th>Number<br/>Of Doses</th> 
                             <th>Time&nbsp;Between<br/>Last Dose Delivery</th> 
                             <th>HO Fever</th> 
                             <th>Foul<br/>Smelling Discharge</th> 
                             <th>Leaking PV</th> 
                             <th>Uterine Tenderness</th> 
                             <th>PIH Labour</th> 
                             <th>PPH</th> 
                             <th>Amniotic Fluid</th> 
                             <th>Presentation</th> 
                             <th>Labour</th> 
                             <th>Course<br/>Of Labour</th> 
                             <th>Eo<br/>Feotal Distress</th> 
                             <th>Indication<br/>For Caesarean</th> 
                             <th>Indication<br/>Applicable Value</th> 
                             <th>Delivery<br/>Attended By</th> 
                             <th>Delivery Type</th> 
                             <th>Other&nbsp;Significant<br/>Value For Labour</th> 
                

                             <th>Other&nbsp;observation/<br>comments</th> 
                             <th>Assesment&nbsp;Date<br>&&nbsp;Time</th>  
                             <th>Type</th> 
                             <th>Staff&nbsp;Name/<br>Assessment&nbsp;Sign</th>  
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
                                        $staffName          = $this->MotherModel->getStaffNameBYID($value['StaffID']);
                                        $longName           = $this->MotherModel->GetLoungeById($value['LoungeID']);
                                        $MotherName         = $this->MotherModel->getMotherDataById('mother_registration',$value['MotherID']);
                                        $FacilityName       = $this->FacilityModel->GetFacilityName($longName['FacilityID']);
                                        $getFirstAssessment = $this->FacilityModel->GetMotherForChecklist($value['MotherID']);
                                       ?>
                                       <tr>
                                         <td><?php echo $counter++;?></td>
                                         <td> 
                                          <?php
                                           $motherIconStatus     = $this->DangerSignModel->getMotherIcon($value); 
                                           if($motherIconStatus == '1'){ ?>
                                                <img src="<?php echo base_url();?>assets/images/happy-face.png" class='iconSet'>
                                           <?php } else if($motherIconStatus == '0'){ ?>
                                                <img src="<?php echo base_url();?>assets/images/sad-face.png" class='iconSet'>
                                           <?php }else { echo '';} ?>
                                          <?php  if($MotherName['Type'] == '1'|| $MotherName['Type'] == '3') {?>
                                                <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $getFirstAssessment['mother_admissionID']; ?>"><?php echo $MotherName['MotherName'];?></a>
                                          <?php }  else { ?>
                                           <a href="<?php echo base_url();?>motherM/viewMother/<?php echo $getFirstAssessment['mother_admissionID']; ?>">UNKNOWN</a>
                                          <?php } ?>
                                       </td>
                                        
                                           <?php  if ($value['MotherSystolicBP'] >= 140 || $value['MotherSystolicBP'] <= 90) { ?>
                                                 <td style="color:red;"> <?php echo $value['MotherSystolicBP'].'&nbsp;mm&nbsp;Hg';?> </td>
                                            <?php } else { ?>
                                                  <td><?php echo ($value['MotherSystolicBP'] != "") ? $value['MotherSystolicBP']."&nbsp;mm&nbsp;Hg" : "N/A";?></td>
                                            <?php } ?>

                                            <?php  if ($value['MotherDiastolicBP'] >=90 || $value['MotherDiastolicBP']<=60) { ?>
                                                 <td style="color:red;"> <?php echo $value['MotherDiastolicBP'].'&nbsp;mm&nbsp;Hg';?> </td>
                                            <?php } else { ?>
                                                <td><?php echo ($value['MotherDiastolicBP'] != "") ? $value['MotherDiastolicBP']."&nbsp;mm&nbsp;Hg" : "N/A";?></td>
                                            <?php } ?>


                                            <?php  if ($value['MotherPulse'] < 50 || $value['MotherPulse'] >120) { ?>
                                                 <td style="color:red;"> <?php echo $value['MotherPulse'].'&nbsp;/min';?> </td>
                                            <?php } else { ?>
                                                <td> <?php echo ($value['MotherPulse'] != "") ? $value['MotherPulse']."&nbsp;/min" : "N/A";?></td>
                                            <?php } ?>

                                        
                                         <td><?php echo ($value['MotherUterineTone'] != '') ? $value['MotherUterineTone'] : 'N/A'; ?></td>


                                          <?php  if ($value['MotherTemperature'] > 95.9 && $value['MotherTemperature'] < 99.5) { ?>
                                             <td> <?php echo $value['MotherTemperature'].'&nbsp;<sup>0</sup>F';?> </td>
                                          <?php } else { ?>
                                             <td style="color:red;"> <?php echo ($value['MotherTemperature'] != "") ? $value['MotherTemperature']."&nbsp;<sup>0</sup>F" : "N/A";?></td>
                                          <?php } ?>


                                         <td><?php echo ($value['EpisitomyCondition'] != '') ? $value['EpisitomyCondition'] : 'N/A'; ?></td>
                                         <td><?php echo ($value['MotherUrinationAfterDelivery'] != '') ? $value['MotherUrinationAfterDelivery'] : 'N/A'; ?></td>
                                         <td><?php echo ($value['SanitoryPadStatus'] != '') ? $value['SanitoryPadStatus'] : 'N/A'; ?></td>
                                         <td><?php echo ($value['IsSanitoryPadStink'] != '') ? $value['IsSanitoryPadStink'] : 'N/A'; ?></td>


                                         <td><?php echo ($value['eddValue']!='')?$value['eddValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['antenatalVisits']!='')?$value['antenatalVisits'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['ttDoses']!='')?$value['ttDoses'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['hbValue']!='')?$value['hbValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['bloodGroup']!='')?$value['bloodGroup'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['isPihAvail']!='')?$value['isPihAvail'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['pihValue']!='')?$value['pihValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['isDrugAvail']!='')?$value['isDrugAvail'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['drugValue']!='')?$value['drugValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['radiation']!='')?$value['radiation'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['isIllnessAvail']!='')?$value['isIllnessAvail'] :'N/A' ;?> </td>
                                        <!--  <td><?php echo ($value['illnessValue']!='')?$value['illnessValue'] :'N/A' ;?> </td> -->
                                         <td><?php echo ($value['aphValue']!='')?$value['aphValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['gdmValue']!='')?$value['gdmValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['thyroid']!='')?$value['thyroid'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['vdrlValue']!='')?$value['vdrlValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['hbsAgValue']!='')?$value['hbsAgValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['hivTesting']!='')?$value['hivTesting'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['amnioticFluidVolume']!='')?$value['amnioticFluidVolume'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['otherSignificantInfo']!='')?$value['otherSignificantInfo'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['isAntenatalSteroids']!='')?$value['isAntenatalSteroids'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['antenatalSteroidsValue']!='')?$value['antenatalSteroidsValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['numberOfDoses']!='')?$value['numberOfDoses'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['timeBetweenLastDoseDelivery']!='')?$value['timeBetweenLastDoseDelivery'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['hoFever']!='')?$value['hoFever'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['foulSmellingDischarge']!='')?$value['foulSmellingDischarge'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['leakingPv']!='')?$value['leakingPv'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['uterineTenderness']!='')?$value['uterineTenderness'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['pihLabour']!='')?$value['pihLabour'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['pphValue']!='')?$value['pphValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['amnioticFluid']!='')?$value['amnioticFluid'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['presentation']!='')?$value['presentation'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['labour']!='')?$value['labour'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['courseOfLabour']!='')?$value['courseOfLabour'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['eoFeotalDistress']!='')?$value['eoFeotalDistress'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['indicationForCaesarean']!='')?$value['indicationForCaesarean'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['indicationApplicableValue']!='')?$value['indicationApplicableValue'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['deliveryAttendedBy']!='')?$value['deliveryAttendedBy'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['typeOfDelivery']!='')?$value['typeOfDelivery'] :'N/A' ;?> </td>
                                         <td><?php echo ($value['otherSignificantValueForLabour']!='')?$value['otherSignificantValueForLabour'] :'N/A' ;?> </td>


                                        <td><?php echo ($value['Other']!='')?$value['Other'] :'N/A' ;?> </td>
                                         <td><?php echo (($value['AssesmentDate'] != '') ? date('d-m-Y',strtotime($value['AssesmentDate'])) : "N/A").'<br>'.(($value['AssesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['AssesmentTime']))) : "N/A");?></td>


                                         <td> <?php 
                                          $type = $value['Type'];
                                         echo ($type=='1') ? 'Monitoring' : 'Discharged';
                                          ?>
                                          </td>
                                         <?php  $nurseName = (($staffName['Name']!='')?$staffName['Name'] :'N/A') ;?>
                                         <td>
                                          <?php
                                            if($value['AdmittedSign']==''){
                                                 echo $nurseName."<br>N/A";
                                               ?>
                                           <?php } else { echo $nurseName.'<br>'; ?>
                                                  <img src="<?php echo base_url();?>assets/images/sign/<?php echo $value['AdmittedSign']; ?>" style="width:100px;height:100px;">
                                           <?php } ?>
                                        </td>                                       
                                       </tr>
                                       <?php } ?>
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

