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
</style>
  <div class="content-wrapper">
    <section class="content-header">
    <h1>
      <?php  
      $getFourLevelVar = $this->uri->segment(4);
        $GetLounge      = $this->load->FacilityModel->GetFacilitiesID($motherAdmitData['LoungeID']);

        $motherID       = $motherData['MotherID'];
        $Type           = $this->load->MotherModel->GetMotherType($motherID);

        $dischargeData  = $this->load->MotherModel->GetMotherStatus($motherAdmitData['id']);
        $get_last_assessment  = $this->load->MotherModel->GetLastAsessmentBabyOrMother('mother_monitoring','MotherID',$motherID,$motherAdmitData['id']);
        // mother danger sign
        $motherIconStatus     = $this->load->DangerSignModel->getMotherIcon($get_last_assessment);
            if($motherIconStatus == '1'){
           echo $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'> ";
            }else if($motherIconStatus == '0'){
           echo   $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'> ";
            }else{ echo $icon=''; }

        $getPdfLink     = $this->load->MotherModel->getpdflinkFormBabyAdm($motherID);
        $Baby           = $this->load->MotherModel->GetBabyPdfByMotherID($motherData['MotherID']);
        echo ucwords($motherData['MotherName']);
      if(!empty($motherData['MotherName'])){
        $bday = new DateTime($motherData['MotherDOB']);
        $date= date("Y-m-d H:i:s");
        $today = new DateTime($date); // for testing purposes
        $diff = $today->diff($bday);
       ?>
        <?php if(!empty($motherData['MotherAge'])){?>
        (<?php echo $motherData['MotherAge'];?>) (<?php echo $GetLounge['LoungeName']; ?>)<?php } else { ?>(<?php printf('%d years, %d month', $diff->y, $diff->m);?>) (<?php echo $GetLounge['LoungeName']; ?>)<?php }?>
        <?php } else { echo'Unknown Mother '.'('.$GetLounge['LoungeName'].')'; } ?>
    </h1>
        <font size="4" style="color:black;">
          Registration No:&nbsp;<?php if(!empty($motherAdmitData['HospitalRegistrationNumber'])) {
             echo ($motherAdmitData['HospitalRegistrationNumber'] != "") ? $FilesIDS=$motherAdmitData['HospitalRegistrationNumber'] : "--" ; }
             ?>,&nbsp;MCTS No:&nbsp;<?php  if(empty($motherData['MotherMCTSNumber'])){ echo"--";} else { echo $motherData['MotherMCTSNumber'];  }?>
        </font>

        <ol class="breadcrumb">
          <li id="assesment" style="text-align:right;display:none;">
            <small style="margin-top: 35px;">
            <b>Temperature:</b>&nbsp;(< 95.9 - > 99.5)<b>&nbsp;|&nbsp;</b><b>Heart Beat:&nbsp;</b>(< 50 - > 120)<b>&nbsp;|&nbsp;</b><b>Systolic:</b>&nbsp;(>= 140 - <= 90)<b>&nbsp;|&nbsp;</b><b>Diastolic:</b>&nbsp;(>= 90 - <= 60)
            </small>
          </li>
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
                           <li class="<?php echo ($getFourLevelVar == 'comment') ? '' : 'active'; ?>"><a href="" id="step1" data-toggle="tab">Registration</a></li>
                        <?php if ($Type['Type'] == '1' || $Type['Type'] == '3') { ?>
                            <li><a href="" id="step2" data-toggle="tab">Contact Details</a></li>
                            <li><a href="" id="step5" data-toggle="tab">Mother Assessment</a></li>
                      
                          <?php 
                              if($dischargeData['status'] == '2'){?>
                          <li><a href="" id="step6" data-toggle="tab">Discharged</a></li> 
                         <?php  } } ?> 
                         <li class="<?php echo ($getFourLevelVar == 'comment') ? 'active' : ''; ?>"><a href="" id="step7" data-toggle="tab">Comments</a></li> 
                      </ul>
                      </div>
                      <div class="tab-content no-padding">

                         <div id="stepp1">
                             <?php if ($Type['Type'] == '1' || $Type['Type'] == '3') { ?>
                                  <div class="row">
                                    <div class="col-md-6"><div class="col-md-12"><h4>Mother Registration:</h4></div></div>
                                    <div class="col-md-6" style="text-align:right;"> </div>
                                  </div> 

                              <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Name</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherName']) ? 'UNKNOWN' : $motherData['MotherName'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Father Name</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['FatherName']) ? 'N/A' : $motherData['FatherName'];?>"readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Aadhar Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherAadharNumber']) ? 'N/A' : $motherData['MotherAadharNumber'];?>" readonly style="background-color:white;">
                                </div>
                              </div>

                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Father Aadhar Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['FatherAadharNumber']) ? 'N/A' : $motherData['FatherAadharNumber'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother to be admitted?</label>
                                  <?php if($motherData['MotherAdmission'] =='Yes' || $motherData['MotherAdmission'] == 'yes'){?>
                                    <input type="text" class="form-control" value="<?php echo $motherData['MotherAdmission'];?>" readonly style="background-color:white;">
                                  <?php  } else {?>
                                    <input type="text" class="form-control" value="<?php echo $motherData['MotherAdmission'];?>" readonly style="background-color:white;"><br/>
                                    <textarea cols="9" rows="9" readonly class="form-control"><?php echo empty($motherData['reason_for_not_admitted']) ? 'N/A' : $motherData['reason_for_not_admitted']; ?></textarea>
                                  <?php  } ?>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Photo</label>
                                  <?php if(empty($motherData['MotherPicture'])){
                                            $img_url = base_url().'assets/images/user.png';
                                          } else {
                                            $img_url = base_url().'assets/images/mother_images/'.$motherData['MotherPicture'];
                                          }
                                    ?>

                                    <div class="set_div_img00" id="" style="display: <?php if($motherData['MotherPicture'] != '') { echo "block"; } else { echo "none"; } ?>">
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
                                  <label for="inputEmail3" class="control-label">Hospital&nbsp;Registration Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($FilesIDS) ? 'N/A' : $FilesIDS; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother MCTS Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherMCTSNumber']) ? 'N/A' : $motherData['MotherMCTSNumber']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother DOB&nbsp;(dd-mm-yyyy)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherDOB']) ? 'N/A' : $motherData['MotherDOB'];?>" readonly style="background-color:white;">
                                </div>
                              </div>


                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Age(in case DOB not known)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherDOB']) ? 'N/A' : $motherData['MotherDOB'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother's Education</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherEducation']) ? 'N/A' : $motherData['MotherEducation']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Religion</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherReligion']) ? 'N/A' : $motherData['MotherReligion'];?>" readonly style="background-color:white;">
                                </div>
                              </div>


                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Caste Category</label>
                                  <input type="text" class="form-control" value="<?php echo  empty($motherData['MotherCaste']) ? 'N/A' : $motherData['MotherCaste']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Multiple Births</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MultipleBirth']) ? 'N/A' : $motherData['MultipleBirth'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Total Pregnancies?(Gravida)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['Gravida']) ? 'N/A' : $motherData['Gravida'];?>" readonly style="background-color:white;">
                                </div>
                              </div>


                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">No.of births?(Para)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['Para']) ? 'N/A' : $motherData['Para'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">No. of miscarriage or abortion (Abortion)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['Abortion']) ? 'N/A' : $motherData['Abortion'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Total no. of children who are currently alive? (Live)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['Live']) ? 'N/A' : $motherData['Live']; ?>" readonly style="background-color:white;">
                                </div>
                              </div>
                             
                             
                             <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother's Weight(Kg.)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherWeight']) ? 'N/A' : $motherData['motherWeight'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Age At Marriage(Yrs)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['ageOfMarriage']) ? 'N/A' : $motherData['ageOfMarriage'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Birth Spacing</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['birthSpacing']) ? 'N/A' : $motherData['birthSpacing'];?>" readonly style="background-color:white;">
                                </div>
                              </div>
                             
                              
                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Consanguinity</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['consanguinity']) ? 'N/A' : $motherData['consanguinity']; ?>" readonly style="background-color:white;">
                                </div>
                                
                              </div>

                             

                             


                           <?php } else { ?>
                                       <div class="col-md-12"><h4>Unknown Registration:</h4></div>
                                       <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Guardian Name</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['GuardianName']) ? 'N/A' : $motherData['GuardianName'];?>" readonly style="background-color:white;">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Guardian Mobile Number</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['GuardianNumber']) ? 'N/A' : $motherData['GuardianNumber'];?>" readonly style="background-color:white;">
                                             </div>
                                        </div>
                                        <div class="form-group">
  
                                            <label for="inputEmail3" class="col-sm-2 control-label">Organisation Number</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['OrganizationNumber']) ? 'N/A' : $motherData['OrganizationNumber'];?>" readonly style="background-color:white;">
                                             </div>                         
                                             <label for="inputEmail3" class="col-sm-2 control-label">Organisation Name</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['OrganizationName']) ? 'N/A' : $motherData['OrganizationName'];?>" readonly style="background-color:white;">
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Organisation Address</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['OrganizationAddress']) ? 'N/A' : $motherData['OrganizationAddress']; ?>" readonly style="background-color:white;">
                                            </div>
                                            <div class="col-md-12" style="height:100px"></div>
                                        </div>
                                        
                            </div>

                             <?php } ?>

               </div>


                         <div id="stepp2" style="display:none;">

                            <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Mobile Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['MotherMoblieNo']) ? 'N/A' : $motherData['MotherMoblieNo'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Father Mobile Number</label>
                                  <input type="text" class="form-control"value="<?php echo empty($motherData['FatherMoblieNo']) ? 'N/A' : $motherData['FatherMoblieNo'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Guardian Relation</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['GuardianRelation']) ? 'N/A' : $motherData['GuardianRelation'];?>" readonly style="background-color:white;">
                                </div>
                            </div>


                            <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Guardian Name</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['GuardianName']) ? 'N/A' : $motherData['GuardianName'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Guardian Mobile Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['GuardianNumber']) ? 'N/A' : $motherData['GuardianNumber'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Family Ration Card Type</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['RationCardType']) ? 'N/A' : $motherData['RationCardType'];?>" readonly style="background-color:white;">
                                </div>
                            </div>



                            <div class="col-md-12"><h4>Present Address:</h4></div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Present Address Type</label>
                                  <input type="text" class="form-control"  value="<?php echo $motherData['PresentResidenceType'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Country</label>
                                  <?php  if(empty($motherData['PresentCountry'])){?>
                                      <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                  <?php } else {?>
                                      <input type="text" class="form-control" value="<?php echo empty($motherData['PresentCountry']) ? 'N/A' : $motherData['PresentCountry']; ?>" readonly style="background-color:white;">
                                  <?php } ?>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">State</label>
                                  <?php  if(empty($motherData['PresentState'])){?>
                                    <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                  <?php } else {?>
                                    <input type="text" class="form-control" value="<?php echo empty($motherData['PresentState']) ? 'N/A' : $motherData['PresentState'];?>" readonly style="background-color:white;">
                                  <?php } ?>
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">District</label>
                                  <?php $GetPresentDistrictName = $this->load->MotherModel->GetPresentDistrictName($motherData['PresentDistrictName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($GetPresentDistrictName['DistrictNameProperCase']) ? 'N/A' : $GetPresentDistrictName['DistrictNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Block</label>
                                   <?php $PresentBlockName = $this->load->MotherModel->GetPresentBlockName($motherData['PresentBlockName']);?> 
                                   <input type="text" class="form-control" value="<?php echo empty($PresentBlockName['BlockPRINameProperCase']) ? 'N/A' : $PresentBlockName['BlockPRINameProperCase']; ?>" readonly style="background-color:white;">
                                  
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Gram Sabha/Town or City</label>
                                  <?php $PresentVillageName = $this->load->MotherModel->GetPresentVillageName($motherData['PresentVillageName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($PresentVillageName['GPNameProperCase']) ? 'N/A' : $PresentVillageName['GPNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                            </div>

                            
                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Address</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['PresentAddress']) ? 'N/A' : $motherData['PresentAddress'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Pincode</label>
                                   <input type="text" class="form-control" value="<?php echo empty($motherData['PresentPinCode']) ? 'N/A' : $motherData['PresentPinCode']; ?>" readonly style="background-color:white;">
                                  
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Near By Location</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['PresentAddressNearBy']) ? 'N/A' : $motherData['PresentAddressNearBy'];?>" readonly style="background-color:white;">
                                </div>
                            </div>

                            
                            
                            <div class="col-md-12" style="margin-top:10px;"><h4>Permanent Address:</h4></div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Permanent Address Type</label>
                                  <input type="text" class="form-control"  value="<?php echo empty($motherData['PermanentResidenceType']) ? 'N/A' : $motherData['PermanentResidenceType'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Country</label>
                                    <?php  if(empty($motherData['PermanentCountry'])){?>
                                      <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                    <?php } else {?>
                                      <input type="text" class="form-control" value="<?php echo empty($motherData['PermanentCountry']) ? 'N/A' : $motherData['PermanentCountry']; ?>" readonly style="background-color:white;">
                                    <?php } ?>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">State</label>
                                  <?php  if(empty($motherData['PermanentState'])){?>
                                    <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                    <?php } else {?>
                                    <input type="text" class="form-control" value="<?php echo empty($motherData['PermanentState']) ? 'N/A' : $motherData['PermanentState']; ?>" readonly style="background-color:white;">
                                    <?php } ?>
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">District</label>
                                  <?php $GetPermanentDistrictName = $this->load->MotherModel->GetPermanentDistrictName($motherData['PermanentDistrictName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($GetPermanentDistrictName['DistrictNameProperCase']) ? 'N/A' : $GetPermanentDistrictName['DistrictNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Block</label>
                                  <?php $PermanentBlockName = $this->load->MotherModel->GetPermanentBlockName($motherData['PermanentBlockName']);?> 
                                    <input type="text" class="form-control" value="<?php echo empty($PermanentBlockName['BlockPRINameProperCase']) ? 'N/A' : $PermanentBlockName['BlockPRINameProperCase'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Gram Sabha/Town or City</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['PermanentVillageName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($PermanentVillageName['GPNameProperCase']) ? 'N/A' : $PermanentVillageName['GPNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Address</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['PermanentAddress']) ? 'N/A' : $motherData['PermanentAddress']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Pincode</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['PermanentPinCode']) ? 'N/A' : $motherData['PermanentPinCode']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Near By Location</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['PermanentVillageName']);?> 
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['PermanentAddressNearBy']) ? 'N/A' : $motherData['PermanentAddressNearBy']; ?>" readonly style="background-color:white;">
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="margin-top:10px;"><h4>Delivery Address:</h4></div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Nurse</label>
                                  <?php  
                                    $staffName = $this->load->MotherModel->getStaffNameBYID($motherData['StaffId']);
                                  ?>
                                  <input type="text" class="form-control" readonly value="<?php echo empty($staffName['Name']) ? 'N/A' : $staffName['Name'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Asha</label>
                                  <input type="text" class="form-control" readonly value="<?php echo empty($motherData['AshaName']) ? 'N/A' : $motherData['AshaName'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Asha Name</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['PermanentVillageName']);?> 
                                  <input type="text" class="form-control"  readonly value="<?php echo $motherData['AshaName'];?>" style="background-color:white;">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Asha Number</label>
                                  <input type="text" class="form-control"  readonly value="<?php echo empty($motherData['AshaNumber']) ? 'N/A' : $motherData['AshaNumber'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother LMP Date (dd-mm-yyyy)</label>
                                  <input type="text" class="form-control" readonly value="<?php echo empty($motherData['MotherLmpDate']) ? 'N/A' : $motherData['MotherLmpDate'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Place Of Birth</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['PermanentVillageName']);?> 
                                  <?php if(($motherData['FacilityID'] == '0') || ($motherData['FacilityID'] == '')) { ?>
                                    <input type="text" class="form-control"  readonly value="Hospital" style="background-color:white;">
                                  <?php } else { ?>
                                    <input type="text" class="form-control"  readonly value="<?php echo empty($motherData['MotherDeliveryPlace']) ? 'N/A' : $motherData['MotherDeliveryPlace'];?>" style="background-color:white;">
                                  <?php } ?>
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                              <?php  
                                $FacilityName = $this->load->MotherModel->getFacilityNameBYID($motherData['FacilityID']);
                                $DistrictName = $this->load->MotherModel->GetPresentDistrictName($motherData['MotherDeliveryDistrict']);
                              ?>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">District</label>
                                  <input type="text" class="form-control" readonly value="<?php echo  empty($DistrictName['DistrictNameProperCase']) ? 'N/A' : $DistrictName['DistrictNameProperCase'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Facility</label>
                                  <input type="text" class="form-control" readonly value="<?php echo ($FacilityName['FacilityName'] == null) ? 'Other' : $FacilityName['FacilityName']; ?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Place Of Delivery</label>
                                  <input type="text" class="form-control" readonly value="<?php echo  empty($motherData['MotherDeliveryPlace']) ? 'N/A' : $motherData['MotherDeliveryPlace'];?>" style="background-color:white;">
                                </div>
                            </div>
                           
                            
                            <div class="form-group col-sm-12">
                                <div class="col-sm-10 col-xs-10">
                                  <label for="inputEmail3" class="control-label">Check List</label>
                                  <?php 
                                    $data =json_decode($dischargeData['DischargeChecklist'], true);
                                      if(count($data) > 0){
                                        $count=1; ?>
                                      <?php 
                                      foreach ($data as $key => $val) {?>
                                        <textarea rows="3" class="form-control" readonly="" style="background-color:white;"> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
                                  <?php } ?>
                                  <?php } else {  echo 'N/A'; } ?>
                                </div>
                                
                            </div>
                           
                              


                         </div>
                         <div id="stepp5" style="display:none;">
                            <?php $BabyWeight = $this->load->MotherModel->GetBabyWeightPDF($Baby['BabyID']);
                               ?>

                              <div class="col-sm-12" style="overflow: auto;margin-top:15px;">
                                <table cellpadding="0" cellspacing="0" border="0"
                                class="table-striped table table-bordered editable-datatable example " id="example">
                                <thead>
                                   <tr>
                                       <th>S&nbsp;No.</th>
                                       <th>Systolic<br>(mm&nbsp;Hg)</th>
                                       <th>Diastolic<br>(mm&nbsp;Hg)</th>
                                       <th>Heart&nbsp;Beat<br>(/min)</th>
                                       <th>Uterine<br>tone</th>
                                       <th>Temperature<br>(<sup>0</sup>F)</th> 
                                       <th>Episiotomy<br>Stiches</th> 
                                       <th>Did&nbsp;the&nbsp;Urinate/Pass<br/>Urine&nbsp;after&nbsp;delivery</th> 
                                       <th>How&nbsp;much&nbsp;is&nbsp;Pad&nbsp;full?</th> 
                                       <th>Is&nbsp;it<br>smelly?</th> 
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
                             <th>AmnieddValueotic Fluid</th> 
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
                                          <?php $MotherAssessment = $this->load->MotherModel->GetMotherAssessmentDataBYID($motherData['MotherID'],$motherAdmitData['id']);
                                          $counter=1;
                                        foreach($MotherAssessment as $key => $value) {
                                          $staffName = $this->load->MotherModel->getStaffNameBYID($value['StaffID']);
                                         // $longName = $this->load->MotherModel->GetLoungeById($value['LoungeID']);
                                          $MotherName = $this->load->MotherModel->getMotherDataById('mother_registration',$value['MotherID']);
                                         // $FacilityName       = $this->load->FacilityModel->GetFacilityName($longName['FacilityID']);
                                          $getFirstAssessment = $this->load->FacilityModel->GetMotherForChecklist($value['MotherID']);                                   
                                     ?>
                                     <tr>
                                       <td style="width:70px;"><?php echo $counter++;?></td>
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
                                         <td><?php echo ($value['adhValue']!='')?$value['adhValue'] :'N/A' ;?> </td>
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
                                       <td><?php echo (($value['AssesmentDate'] != '') ? date('d-m-Y', strtotime($value['AssesmentDate'])) : "N/A").'<br>'.(($value['AssesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['AssesmentTime']))) : "N/A");?></td>

                                       <td> <?php 
                                        $type = $value['Type'];
                                       echo ($type=='1') ? 'Monitoring' : 'Discharged';
                                        ?>
                                        </td>
                                       <?php $nurseName = (($staffName['Name']!='')?$staffName['Name'] :'N/A') ;?>
                                       <td>
                                         <?php if($value['AdmittedSign']==''){
                                               echo $nurseName."<br>N/A";
                                             ?>
                                         <?php } else { echo $nurseName.'<br>' ?>
                                                <img src="<?php echo base_url();?>assets/images/sign/<?php echo $value['AdmittedSign']; ?>" style="width:100px;height:100px;">
                                         <?php } ?>
                                      </td>                                       
                                     </tr>
                                     <?php } ?>
                                   </tbody>
                                 </table>
                             </div>
                        </div>
                    <div id="stepp6" style="display:none;">
                      <?php 
  
                      $DoctorName = $this->load->MotherModel->getStaffNameBYID($dischargeData['DischargeByDoctor']);
                      $NurseName  = $this->load->MotherModel->getStaffNameBYID($dischargeData['DischargeByNurse']);
                      ?>
                         <?php 
                          $DischargeType = trim($dischargeData['TypeOfDischarge'], '"');
                  if($DischargeType=='Other') { ?>

                         <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Type Of Discharge</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? 'N/A' : $DischargeType;?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 
                             <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Specify</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['ReferredReason']) ? 'N/A' : $dischargeData['ReferredReason'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($DoctorName['Name']) ? 'N/A' : $DoctorName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Nurse Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($NurseName['Name']) ? 'N/A' : $NurseName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['Transportation']) ? 'N/A' : $dischargeData['Transportation'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",$motherAdmitData['modify_date']);?>" readonly style="background-color:white;">
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
                                                   <textarea rows="3" class="form-control" readonly=""> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
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

                  <?php } else if($DischargeType=='Died' || $DischargeType=='Mother absconded' || $DischargeType=='Leave against medical advice(LAMA)' || $DischargeType=='Discharged by facility staff') {?>

                         <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Type Of Discharge</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? 'N/A' : $DischargeType;?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($DoctorName['Name']) ? 'N/A' : $DoctorName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Staff Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($NurseName['Name']) ? 'N/A' : $NurseName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div>  
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['Transportation']) ? 'N/A' :$dischargeData['Transportation'];?>" readonly style="background-color:white;">
                                 </div>
      
                             </div>


                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",$motherAdmitData['modify_date']);?>" readonly style="background-color:white;">
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

                                                           <textarea rows="3" class="form-control" readonly="" style="background-color: white;"> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
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
                  
                      
                      <?php } else {
                      $getFacilityData = $this->db->query("select fl.FacilityName,fl.Address from facilitylist as fl inner join lounge_master as lm on lm.FacilityID = fl.FacilityID where lm.LoungeID =".$getPdfLink['LoungeID']."")->row_array();
                        ?>
                       <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Type Of Discharge</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? 'N/A' : $DischargeType;?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Follow UP</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['DateOfFollowUpVisit']) ? 'N/A' : $dischargeData['DateOfFollowUpVisit'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Facility</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($getFacilityData['FacilityName']) ? 'N/A' : $getFacilityData['FacilityName'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                              <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Address Of Facility</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo !empty($getFacilityData['Address']) ? $getFacilityData['Address'] : 'N/A' ;?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Reason For Referal</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['ReferredReason']) ? 'N/A' : $dischargeData['ReferredReason'];?>" readonly style="background-color:white;">
                                 </div>
                             </div>
                            
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Doctor Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($DoctorName['Name']) ? 'N/A' : $DoctorName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                             </div> 
                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Staff Name</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($NurseName['Name']) ? 'N/A' : $NurseName['Name'];?>" readonly style="background-color:white;">
                                 </div>
                                 
                             </div> 


                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['Transportation']) ? 'N/A' : $dischargeData['Transportation'];?>" readonly style="background-color:white;">
                                 </div>
                                
                             </div>

                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",$motherAdmitData['modify_date']);?>" readonly style="background-color:white;">
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
                                                             <textarea rows="3" class="form-control"> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
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


                     <?php  } ?>


                        </div>

<!-- Comments Data -->

            <div id="stepp7" style="display:none; margin-top:15px;">
              <?php $getCommentData = $this->BabyModel->getCommentList(1,1,$motherData['MotherID'],$motherAdmitData['id']); ?>
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
        $("#assesment").hide();
        $("#stepp1").show();
        $("#stepp2").hide();  
        $("#stepp3").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp4").hide();
        });
        $("#step2").click(function(){
        $("#assesment").hide();          
        $("#stepp2").show();
        $("#stepp1").hide();
        $("#stepp3").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp4").hide();
        });
        $("#step3").click(function(){
        $("#assesment").hide();          
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp3").show();
        });
        $("#step4").click(function(){
        $("#assesment").hide();         
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp4").show();
        });
        $("#step5").click(function(){
          
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp6").hide();
        $("#stepp7").hide();
        $("#stepp5").show();
        $("#assesment").show();
        });
        $("#step6").click(function(){
        $("#assesment").hide();          
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp7").hide();
        $("#stepp6").show();
        });
        $("#step7").click(function(){
        $("#assesment").hide();         
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").show();
        });

    });

</script>
<?php if ($getFourLevelVar == 'comment') { ?>
<script>
        $("#assesment").hide();         
        $("#stepp1").hide();
        $("#stepp2").hide();
        $("#stepp3").hide();
        $("#stepp4").hide();
        $("#stepp5").hide();
        $("#stepp6").hide();
        $("#stepp7").show();
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