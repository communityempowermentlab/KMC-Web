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
        $GetLounge      = $this->load->FacilityModel->GetFacilitiesID($motherAdmitData['loungeId']);

        $motherID       = $motherData['motherId']; 
        $Type           = $this->load->MotherModel->GetMotherType($motherID);

        $dischargeData  = $this->load->MotherModel->GetMotherStatus($motherAdmitData['id']);
        $pastInfoData  = $this->load->MotherModel->getMotherPastInfo($motherAdmitData['id']); 
        $get_last_assessment  = $this->load->MotherModel->GetLastAsessmentBabyOrMother('motherMonitoring','motherId',$motherID,$motherAdmitData['id']);
        // mother danger sign
        $motherIconStatus     = $this->load->DangerSignModel->getMotherIcon($get_last_assessment);
            if($motherIconStatus == '1'){
           echo $icon = "<img src='".base_url()."assets/images/happy-face.png' class='iconSet'> ";
            }else if($motherIconStatus == '0'){
           echo   $icon = "<img src='".base_url()."assets/images/sad-face.png' class='iconSet'> ";
            }else{ echo $icon=''; }

        $getPdfLink     = $this->load->MotherModel->getpdflinkFormBabyAdm($motherID); 
        $Baby           = $this->load->MotherModel->GetBabyPdfByMotherID($motherData['motherId']);
        echo ucwords($motherData['motherName']);
      if(!empty($motherData['motherName'])){
        $bday = new DateTime($motherData['motherDOB']);
        $date= date("Y-m-d H:i:s");
        $today = new DateTime($date); // for testing purposes
        $diff = $today->diff($bday);
       ?>
        <?php if(!empty($motherData['motherAge'])){?>
        (<?php echo $motherData['motherAge'];?>) (<?php echo $GetLounge['loungeName']; ?>)<?php } else if(!empty($motherData['motherDOB'])) { ?>(<?php printf('%d years, %d month', $diff->y, $diff->m);?>) (<?php echo $GetLounge['loungeName']; ?>)<?php } else { ?>(N/A)<?php } ?>
        <?php } else { echo'Unknown Mother '.'('.$GetLounge['loungeName'].')'; } ?>
    </h1>
        <font size="4" style="color:black;">
          Registration No:&nbsp;<?php if(!empty($motherAdmitData['hospitalRegistrationNumber'])) {
             echo ($motherAdmitData['hospitalRegistrationNumber'] != "") ? $FilesIDS=$motherAdmitData['hospitalRegistrationNumber'] : "--" ; }
             ?>,&nbsp;MCTS No:&nbsp;<?php  if(empty($motherData['motherMCTSNumber'])){ echo"--";} else { echo $motherData['motherMCTSNumber'];  }?>
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
                        <?php if ($Type['type'] == '1' || $Type['type'] == '3') { ?>
                            <li><a href="" id="step2" data-toggle="tab">Contact Details</a></li>
                            <li><a href="" id="step3" data-toggle="tab">Mother Past Information</a></li>
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
                             <?php if ($Type['type'] == '1' || $Type['type'] == '3') { ?>
                                  <div class="row">
                                    <div class="col-md-6"><div class="col-md-12"><h4>Mother Registration:</h4></div></div>
                                    <div class="col-md-6" style="text-align:right;"> </div>
                                  </div> 

                              <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Name</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherName']) ? 'UNKNOWN' : $motherData['motherName'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Father Name</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['fatherName']) ? 'N/A' : $motherData['fatherName'];?>"readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Aadhar Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherAadharNumber']) ? 'N/A' : $motherData['motherAadharNumber'];?>" readonly style="background-color:white;">
                                </div>
                              </div>

                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Father Aadhar Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['fatherAadharNumber']) ? 'N/A' : $motherData['fatherAadharNumber'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother to be admitted?</label>
                                  <?php if($motherData['isMotherAdmitted'] =='Yes' || $motherData['isMotherAdmitted'] == 'yes'){?>
                                    <input type="text" class="form-control" value="<?php echo $motherData['isMotherAdmitted'];?>" readonly style="background-color:white;">
                                  <?php  } else {?>
                                    <input type="text" class="form-control" value="<?php echo $motherData['isMotherAdmitted'];?>" readonly style="background-color:white;"><br/>
                                    <textarea cols="9" rows="9" readonly class="form-control"><?php echo empty($motherData['notAdmittedReason']) ? 'N/A' : $motherData['notAdmittedReason']; ?></textarea>
                                  <?php  } ?>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Photo</label>
                                  <?php if(empty($motherData['motherPicture'])){
                                            $img_url = base_url().'assets/images/user.png';
                                          } else {
                                            $img_url = motherDirectoryUrl.$motherData['motherPicture'];
                                          }
                                    ?>

                                    <div class="set_div_img00" id="" style="display: <?php if($motherData['motherPicture'] != '') { echo "block"; } else { echo "none"; } ?>">
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
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherMCTSNumber']) ? 'N/A' : $motherData['motherMCTSNumber']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother DOB&nbsp;(yyyy-mm-dd)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherDOB']) ? 'N/A' : $motherData['motherDOB'];?>" readonly style="background-color:white;">
                                </div>
                              </div>


                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Age(in case DOB not known)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherAge']) ? 'N/A' : $motherData['motherAge'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother's Education</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherEducation']) ? 'N/A' : $motherData['motherEducation']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Religion</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherReligion']) ? 'N/A' : $motherData['motherReligion'];?>" readonly style="background-color:white;">
                                </div>
                              </div>


                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Caste Category</label>
                                  <input type="text" class="form-control" value="<?php echo  empty($motherData['motherCaste']) ? 'N/A' : $motherData['motherCaste']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Multiple Births</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['multipleBirth']) ? 'N/A' : $motherData['multipleBirth'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Total Pregnancies?(Gravida)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['gravida']) ? 'N/A' : $motherData['gravida'];?>" readonly style="background-color:white;">
                                </div>
                              </div>


                              <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">No.of births?(Para)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['para']) ? 'N/A' : $motherData['para'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">No. of miscarriage or abortion (Abortion)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['abortion']) ? 'N/A' : $motherData['abortion'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Total no. of children who are currently alive? (Live)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['live']) ? 'N/A' : $motherData['live']; ?>" readonly style="background-color:white;">
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
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['guardianName']) ? 'N/A' : $motherData['guardianName'];?>" readonly style="background-color:white;">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Guardian Mobile Number</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['guardianNumber']) ? 'N/A' : $motherData['guardianNumber'];?>" readonly style="background-color:white;">
                                             </div>
                                        </div>
                                        <div class="form-group">
  
                                            <label for="inputEmail3" class="col-sm-2 control-label">Organisation Number</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['organisationNumber']) ? 'N/A' : $motherData['organisationNumber'];?>" readonly style="background-color:white;">
                                             </div>                         
                                             <label for="inputEmail3" class="col-sm-2 control-label">Organisation Name</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['organisationName']) ? 'N/A' : $motherData['organisationName'];?>" readonly style="background-color:white;">
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Organisation Address</label>
                                             <div class="col-sm-4">
                                             <input type="text" class="form-control" value="<?php echo empty($motherData['organisationAddress']) ? 'N/A' : $motherData['organisationAddress']; ?>" readonly style="background-color:white;">
                                            </div>
                                            <div class="col-md-12" style="height:100px"></div>
                                        </div>
                                        
                            

                             <?php } ?>

               </div>


                         <div id="stepp2" style="display:none;">

                            <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother Mobile Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['motherMobileNumber']) ? 'N/A' : $motherData['motherMobileNumber'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Father Mobile Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['fatherMobileNumber']) ? 'N/A' : $motherData['fatherMobileNumber'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Guardian Relation</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['guardianRelation']) ? 'N/A' : $motherData['guardianRelation'];?>" readonly style="background-color:white;">
                                </div>
                            </div>


                            <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Guardian Name</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['guardianName']) ? 'N/A' : $motherData['guardianName'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Guardian Mobile Number</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['guardianNumber']) ? 'N/A' : $motherData['guardianNumber'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Family Ration Card Type</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['rationCardType']) ? 'N/A' : $motherData['rationCardType'];?>" readonly style="background-color:white;">
                                </div>
                            </div>



                            <div class="col-md-12"><h4>Present Address:</h4></div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Present Address Type</label>
                                  <input type="text" class="form-control"  value="<?php echo $motherData['presentResidenceType'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Country</label>
                                  <?php  if(empty($motherData['presentCountry'])){?>
                                      <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                  <?php } else {?>
                                      <input type="text" class="form-control" value="<?php echo empty($motherData['presentCountry']) ? 'N/A' : $motherData['presentCountry']; ?>" readonly style="background-color:white;">
                                  <?php } ?>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">State</label>
                                  <?php  if(empty($motherData['presentState'])){?>
                                    <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                  <?php } else {?>
                                    <input type="text" class="form-control" value="<?php echo empty($motherData['presentState']) ? 'N/A' : $motherData['presentState'];?>" readonly style="background-color:white;">
                                  <?php } ?>
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">District</label>
                                  <?php $GetPresentDistrictName = $this->load->MotherModel->GetPresentDistrictName($motherData['presentDistrictName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($GetPresentDistrictName['DistrictNameProperCase']) ? 'N/A' : $GetPresentDistrictName['DistrictNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Block</label>
                                   <?php $PresentBlockName = $this->load->MotherModel->GetPresentBlockName($motherData['presentBlockName']);?> 
                                   <input type="text" class="form-control" value="<?php echo empty($PresentBlockName['BlockPRINameProperCase']) ? 'N/A' : $PresentBlockName['BlockPRINameProperCase']; ?>" readonly style="background-color:white;">
                                  
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Gram Sabha/Town or City</label>
                                  <?php $PresentVillageName = $this->load->MotherModel->GetPresentVillageName($motherData['presentVillageName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($PresentVillageName['GPNameProperCase']) ? 'N/A' : $PresentVillageName['GPNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                            </div>

                            
                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Address</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['presentAddress']) ? 'N/A' : $motherData['presentAddress'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Pincode</label>
                                   <input type="text" class="form-control" value="<?php echo empty($motherData['presentPinCode']) ? 'N/A' : $motherData['presentPinCode']; ?>" readonly style="background-color:white;">
                                  
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Near By Location</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['presentAddNearByLocation']) ? 'N/A' : $motherData['presentAddNearByLocation'];?>" readonly style="background-color:white;">
                                </div>
                            </div>

                            
                            
                            <div class="col-md-12" style="margin-top:10px;"><h4>Permanent Address:</h4></div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Permanent Address Type</label>
                                  <input type="text" class="form-control"  value="<?php echo empty($motherData['permanentResidenceType']) ? 'N/A' : $motherData['permanentResidenceType'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Country</label>
                                    <?php  if(empty($motherData['permanentCountry'])){?>
                                      <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                    <?php } else {?>
                                      <input type="text" class="form-control" value="<?php echo empty($motherData['permanentCountry']) ? 'N/A' : $motherData['permanentCountry']; ?>" readonly style="background-color:white;">
                                    <?php } ?>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">State</label>
                                  <?php  if(empty($motherData['permanentState'])){?>
                                    <input type="text" class="form-control" value="<?php echo 'Other'; ?>" readonly style="background-color:white;">
                                    <?php } else {?>
                                    <input type="text" class="form-control" value="<?php echo empty($motherData['permanentState']) ? 'N/A' : $motherData['permanentState']; ?>" readonly style="background-color:white;">
                                    <?php } ?>
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">District</label>
                                  <?php $GetPermanentDistrictName = $this->load->MotherModel->GetPermanentDistrictName($motherData['permanentDistrictName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($GetPermanentDistrictName['DistrictNameProperCase']) ? 'N/A' : $GetPermanentDistrictName['DistrictNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Block</label>
                                  <?php $PermanentBlockName = $this->load->MotherModel->GetPermanentBlockName($motherData['permanentBlockName']);?> 
                                    <input type="text" class="form-control" value="<?php echo empty($PermanentBlockName['BlockPRINameProperCase']) ? 'N/A' : $PermanentBlockName['BlockPRINameProperCase'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Gram Sabha/Town or City</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                  <input type="text" class="form-control"  value="<?php echo empty($PermanentVillageName['GPNameProperCase']) ? 'N/A' : $PermanentVillageName['GPNameProperCase']; ?>" readonly style="background-color:white;">
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Address</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['permanentAddress']) ? 'N/A' : $motherData['permanentAddress']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Pincode</label>
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['permanentPinCode']) ? 'N/A' : $motherData['permanentPinCode']; ?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Near By Location</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                  <input type="text" class="form-control" value="<?php echo empty($motherData['permanentAddNearByLocation']) ? 'N/A' : $motherData['permanentAddNearByLocation']; ?>" readonly style="background-color:white;">
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="margin-top:10px;"><h4>Delivery Address:</h4></div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Nurse</label>
                                  <?php  
                                    $staffName = $this->load->MotherModel->getStaffNameBYID($motherData['staffId']);
                                  ?>
                                  <input type="text" class="form-control" readonly value="<?php echo empty($staffName['name']) ? 'N/A' : $staffName['name'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Asha</label>
                                  <input type="text" class="form-control" readonly value="<?php echo empty($motherData['ashaName']) ? 'N/A' : $motherData['ashaName'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Asha Name</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                  <input type="text" class="form-control"  readonly value="<?php echo $motherData['ashaName'];?>" style="background-color:white;">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Asha Number</label>
                                  <input type="text" class="form-control"  readonly value="<?php echo empty($motherData['ashaNumber']) ? 'N/A' : $motherData['ashaNumber'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Mother LMP Date (yyyy-mm-dd)</label>
                                  <input type="text" class="form-control" readonly value="<?php echo empty($motherData['motherLmpDate']) ? 'N/A' : $motherData['motherLmpDate'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Estimated Date Of Delivery (yyyy-mm-dd)</label>
                                  <input type="text" class="form-control" readonly value="<?php echo empty($motherData['estimatedDateOfDelivery']) ? 'N/A' : $motherData['estimatedDateOfDelivery'];?>" style="background-color:white;">
                                </div>
                                
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Place Of Birth</label>
                                  <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                  <?php if(($motherData['deliveryFacilityId'] == '0') || ($motherData['deliveryFacilityId'] == '')) { ?>
                                    <input type="text" class="form-control"  readonly value="Hospital" style="background-color:white;">
                                  <?php } else { ?>
                                    <input type="text" class="form-control"  readonly value="<?php echo empty($motherData['deliveryPlace']) ? 'N/A' : $motherData['deliveryPlace'];?>" style="background-color:white;">
                                  <?php } ?>
                                </div>
                              <?php  
                                $FacilityName = $this->load->MotherModel->getFacilityNameBYID($motherData['deliveryFacilityId']);
                                $DistrictName = $this->load->MotherModel->GetPresentDistrictName($motherData['deliveryDistrict']);
                              ?>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">District</label>
                                  <input type="text" class="form-control" readonly value="<?php echo  empty($DistrictName['DistrictNameProperCase']) ? 'N/A' : $DistrictName['DistrictNameProperCase'];?>" style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Facility</label>
                                  <input type="text" class="form-control" readonly value="<?php echo ($FacilityName['FacilityName'] == null) ? 'Other' : $FacilityName['FacilityName']; ?>" style="background-color:white;">
                                </div>
                                
                            </div>

                            <div class="form-group col-sm-12">
                              <div class="col-sm-4 col-xs-4">
                                <label for="inputEmail3" class="control-label">Place Of Delivery</label>
                                <input type="text" class="form-control" readonly value="<?php echo  empty($motherData['deliveryPlace']) ? 'N/A' : $motherData['deliveryPlace'];?>" style="background-color:white;">
                              </div>

                            </div>
                           
                            
                            <div class="form-group col-sm-12">
                                <div class="col-sm-10 col-xs-10">
                                  <label for="inputEmail3" class="control-label">Check List</label>
                                  <?php 
                                    $data =json_decode($dischargeData['dischargeChecklist'], true);
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

                         <div id="stepp3" style="display:none;">

                          <div class="col-md-12" style="margin-top:10px;"><h4>Past History and ANC Period:</h4></div>

                            <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Antenatal Visit's</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['antenatalVisits']) ? 'N/A' : $pastInfoData['antenatalVisits'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">T.T Doses</label>
                                  <input type="text" class="form-control"value="<?php echo empty($pastInfoData['ttDoses']) ? 'N/A' : $pastInfoData['ttDoses'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Hb</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hbValue']) ? 'N/A' : $pastInfoData['hbValue'];?>" readonly style="background-color:white;">
                                </div>
                            </div>


                            <div class="form-group col-sm-12" style="margin-top:10px;">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Blood Group</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['bloodGroup']) ? 'N/A' : $pastInfoData['bloodGroup'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">PiH</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isPihAvail']) ? 'N/A' : $pastInfoData['isPihAvail'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">PiH Value</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['pihValue']) ? 'N/A' : $pastInfoData['pihValue'];?>" readonly style="background-color:white;">
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Drug (Allergy)</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isDrugAvail']) ? 'N/A' : $pastInfoData['isDrugAvail'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Radiation</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['radiation']) ? 'N/A' : $pastInfoData['radiation'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Illness</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isIllnessAvail']) ? 'N/A' : $pastInfoData['isIllnessAvail'];?>" readonly style="background-color:white;">
                                </div>
                                
                            </div>



                            

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Illness Value</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['illnessValue']) ? 'N/A' : $pastInfoData['illnessValue'];?>" readonly style="background-color:white;">
                                </div>
                                
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">APH</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['aphValue']) ? 'N/A' : $pastInfoData['aphValue'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">GDM</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['gdmValue']) ? 'N/A' : $pastInfoData['gdmValue'];?>" readonly style="background-color:white;">
                                </div>
                            </div>


                            <div class="form-group col-sm-12">
                                
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Thyroid</label>
                                   <input type="text" class="form-control" value="<?php echo empty($pastInfoData['thyroid']) ? 'N/A' : $pastInfoData['thyroid'];?>" readonly style="background-color:white;">
                                  
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">VDRL</label>
                                  <<input type="text" class="form-control" value="<?php echo empty($pastInfoData['vdrlValue']) ? 'N/A' : $pastInfoData['vdrlValue'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">HbsAg</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hbsAgValue']) ? 'N/A' : $pastInfoData['hbsAgValue'];?>" readonly style="background-color:white;">
                                </div>
                            </div>

                            
                            <div class="form-group col-sm-12">
                                
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">HIV Testing</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hivTesting']) ? 'N/A' : $pastInfoData['hivTesting'];?>" readonly style="background-color:white;">
                                  
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Amniotic Fluid Volume</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['amnioticFluidVolume']) ? 'N/A' : $pastInfoData['amnioticFluidVolume'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Other Significant Info For History</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['otherSignificantInfo']) ? 'N/A' : $pastInfoData['otherSignificantInfo'];?>" readonly style="background-color:white;">
                                </div>
                            </div>

                            

                            
                            
                            <div class="col-md-12" style="margin-top:10px;"><h4>During Labour:</h4></div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Antenatal Steroids</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isAntenatalSteroids']) ? 'N/A' : $pastInfoData['isAntenatalSteroids'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Antenatal Steroids Value</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['antenatalSteroidsValue']) ? 'N/A' : $pastInfoData['antenatalSteroidsValue'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">No. Of Doses</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['numberOfDoses']) ? 'N/A' : $pastInfoData['numberOfDoses'];?>" readonly style="background-color:white;">
                                </div>
                                
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Time Between Last Dose & Delivery</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['timeBetweenLastDoseDelivery']) ? 'N/A' : $pastInfoData['timeBetweenLastDoseDelivery'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">H/O Fever</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hoFever']) ? 'N/A' : $pastInfoData['hoFever'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Foul Smelling Discharge</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['foulSmellingDischarge']) ? 'N/A' : $pastInfoData['foulSmellingDischarge'];?>" readonly style="background-color:white;">
                                </div>
                                
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Uterine Tenderness</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['uterineTenderness']) ? 'N/A' : $pastInfoData['uterineTenderness'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Leaking P.V > 24 Hours</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['leakingPv']) ? 'N/A' : $pastInfoData['leakingPv'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">PPH</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['pphValue']) ? 'N/A' : $pastInfoData['pphValue'];?>" readonly style="background-color:white;">
                                </div>
                                
                            </div>
                            
                            
                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Amniotic Fluid</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['amnioticFluid']) ? 'N/A' : $pastInfoData['amnioticFluid'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Presentation</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['presentation']) ? 'N/A' : $pastInfoData['presentation'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Labour</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['labour']) ? 'N/A' : $pastInfoData['labour'];?>" readonly style="background-color:white;">
                                </div>
                                
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Course Of Labour</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['courseOfLabour']) ? 'N/A' : $pastInfoData['courseOfLabour'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">E/O Feotal Distress</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['eoFeotalDistress']) ? 'N/A' : $pastInfoData['eoFeotalDistress'];?>" readonly style="background-color:white;">
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Delivery Type</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['typeOfDelivery']) ? 'N/A' : $pastInfoData['typeOfDelivery'];?>" readonly style="background-color:white;">
                                </div>
                                
                            </div>


                            <div class="form-group col-sm-12">
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Delivery Attended By</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['deliveryAttendedBy']) ? 'N/A' : $pastInfoData['deliveryAttendedBy'];?>" readonly style="background-color:white;">
                                </div>
                              
                              
                                <div class="col-sm-4 col-xs-4">
                                  <label for="inputEmail3" class="control-label">Other Significant Info</label>
                                  <input type="text" class="form-control" value="<?php echo empty($pastInfoData['otherSignificantValueForLabour']) ? 'N/A' : $pastInfoData['otherSignificantValueForLabour'];?>" readonly style="background-color:white;">
                                </div>
                                
                                
                            </div>

                            

                         </div>

                         <div id="stepp5" style="display:none;">
                            <?php $BabyWeight = $this->load->MotherModel->GetBabyWeightPDF($Baby['babyId']);
                               ?>

                              <div class="col-sm-12" style="overflow: auto;margin-top:15px;">
                                <table cellpadding="0" cellspacing="0" border="0"
                                class="table-striped table table-bordered editable-datatable " id="">
                                <thead>
                                  <?php $MotherAssessment = $this->load->MotherModel->GetMotherAssessmentDataBYID($motherData['motherId'],$motherAdmitData['id']); ?>
                                  <tr>
                                    <th>Value</th>
                                    <?php $c = 1; if(!empty($MotherAssessment)){ foreach($MotherAssessment as $key => $value) { ?>
                                      <th>Assesment <?= $c; ?></th>
                                    <?php $c++; } } else {
                                      echo '<th style="text-align:center;">Assesment</th>';
                                    } ?>
                                  </tr> 

                                </thead>

                                <tbody>

                                  <tr>
                                    <td><b>Pad&nbsp;Not&nbsp;Changed&nbsp;Reason</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                        <td> <?php echo ($value['padNotChangeReason'] != "") ? $value['padNotChangeReason'] : "N/A";?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Systolic (mm&nbsp;Hg)</b></td>
                                    <?php if(!empty($MotherAssessment)){ foreach($MotherAssessment as $key => $value) { 
                                      if ($value['motherSystolicBP'] >= 140 || $value['motherSystolicBP'] <= 90) { ?>
                                        <td style="color:red;"> <?php echo $value['motherSystolicBP'].'&nbsp;mm&nbsp;Hg';?> </td>
                                    <?php } else { ?>
                                        <td><?php echo ($value['motherSystolicBP'] != "") ? $value['motherSystolicBP']."&nbsp;mm&nbsp;Hg" : "N/A";?></td>
                                    <?php } } } else {
                                      echo '<td rowspan="53" style="text-align:center;">No Record Found.</td>';
                                    }  ?>
                                  </tr>

                                  <tr>
                                    <td><b>Diastolic (mm&nbsp;Hg)</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { 
                                      if ($value['motherDiastolicBP'] >=90 || $value['motherDiastolicBP']<=60) { ?>
                                        <td style="color:red;"> <?php echo $value['motherDiastolicBP'].'&nbsp;mm&nbsp;Hg';?> </td>
                                      <?php } else { ?>
                                        <td><?php echo ($value['motherDiastolicBP'] != "") ? $value['motherDiastolicBP']."&nbsp;mm&nbsp;Hg" : "N/A";?></td>
                                    <?php } } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Heart&nbsp;Beat (/min)</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { 
                                      if ($value['motherPulse'] < 50 || $value['motherPulse'] >120) { ?>
                                        <td style="color:red;"> <?php echo $value['motherPulse'].'&nbsp;/min';?> </td>
                                      <?php } else { ?>
                                        <td> <?php echo ($value['motherPulse'] != "") ? $value['motherPulse']."&nbsp;/min" : "N/A";?></td>
                                    <?php } } ?>
                                  </tr>


                                  <tr>
                                    <td><b>Uterine&nbsp;Tone</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                        <td> <?php echo ($value['motherUterineTone'] != "") ? $value['motherUterineTone'] : "N/A";?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Temperature (<sup>0</sup>F)</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { 
                                      if ($value['motherTemperature'] > 95.9 && $value['motherTemperature'] < 99.5) { ?>
                                        <td> <?php echo $value['motherTemperature'].'&nbsp;<sup>0</sup>F';?> </td>
                                    <?php } else { ?>
                                      <td style="color:red;"> <?php echo ($value['motherTemperature'] != "") ? $value['motherTemperature']."&nbsp;<sup>0</sup>F" : "N/A";?></td>
                                    <?php } } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Episiotomy&nbsp;Stitches</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                        <td> <?php echo ($value['episitomyStitchesCondition'] != "") ? $value['episitomyStitchesCondition'] : "N/A";?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Urinate/Pass&nbsp;Urine&nbsp;After&nbsp;Delivery</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                        <td> <?php echo ($value['motherUrinationAfterDelivery'] != "") ? $value['motherUrinationAfterDelivery'] : "N/A";?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>How&nbsp;much&nbsp;is&nbsp;Pad&nbsp;full?</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['sanitoryPadStatus'] != '') ? $value['sanitoryPadStatus'] : 'N/A'; ?></td>
                                      <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Is&nbsp;it smelly?</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['IsSanitoryPadStink'] != '') ? $value['IsSanitoryPadStink'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr>
                                  

                                  <!-- <tr>
                                    <td><b>Antenatal Visit's</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['antenatalVisits']!='')?$value['antenatalVisits'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>  

                                  <tr>
                                    <td><b>T.T Doses</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['ttDoses']!='')?$value['ttDoses'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>  

                                  <tr>
                                    <td><b>Hb</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['hbValue']!='')?$value['hbValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Blood Group</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['bloodGroup']!='')?$value['bloodGroup'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Is&nbsp;Pih Available</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['isPihAvail']!='')?$value['isPihAvail'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>   
                                    
                                  <tr>
                                    <td><b>Pih Value</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['pihValue']!='')?$value['pihValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> 

                                  <tr>
                                    <td><b>Is Drug Available</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['isDrugAvail']!='')?$value['isDrugAvail'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>  

                                  <tr>
                                    <td><b>Drug</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['drugValue']!='')?$value['drugValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>  
                                       
                                  <tr>
                                    <td><b>Radiation</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['radiation']!='')?$value['radiation'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> 
                                  
                                  <tr>
                                    <td><b>Illness Value</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                       <td><?php echo ($value['isIllnessAvail']!='')?$value['isIllnessAvail'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> 
                            
                                  <tr>
                                    <td><b>APH</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                       <td><?php echo ($value['aphValue']!='')?$value['aphValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> 
                             
                                  <tr>
                                    <td><b>GDM</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                       <td><?php echo ($value['gdmValue']!='')?$value['gdmValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Thyroid</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                       <td><?php echo ($value['thyroid']!='')?$value['thyroid'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>VDRL</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                       <td><?php echo ($value['vdrlValue']!='')?$value['vdrlValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>
                        
                                  <tr>
                                    <td><b>HbsAg</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['hbsAgValue']!='')?$value['hbsAgValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>HIV Testing</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['hivTesting']!='')?$value['hivTesting'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>
                             
                                  <tr>
                                    <td><b>Amniotic Fluid Volume</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['amnioticFluidVolume']!='')?$value['amnioticFluidVolume'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>other Significant Info</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['otherSignificantInfo']!='')?$value['otherSignificantInfo'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                   <tr>
                                    <td><b>Antenatal Steroids Avail</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['isAntenatalSteroids']!='')?$value['isAntenatalSteroids'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>
                             
                                  <tr>
                                    <td><b>Antenatal Steroids Value</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['antenatalSteroidsValue']!='')?$value['antenatalSteroidsValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Number Of Doses</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['numberOfDoses']!='')?$value['numberOfDoses'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>
                                  
                                  <tr>
                                    <td><b>Time&nbsp;Between Last Dose Delivery</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['timeBetweenLastDoseDelivery']!='')?$value['timeBetweenLastDoseDelivery'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>
                                  
                                  <tr>
                                    <td><b>HO Fever</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['hoFever']!='')?$value['hoFever'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>
                            
                                  <tr>
                                    <td><b>Foul Smelling Discharge</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['foulSmellingDischarge']!='')?$value['foulSmellingDischarge'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>
                                  
                                  <tr>
                                    <td><b>Uterine Tenderness</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['uterineTenderness']!='')?$value['uterineTenderness'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Leaking PV</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['leakingPv']!='')?$value['leakingPv'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>PPH</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['pphValue']!='')?$value['pphValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Amniotic Fluid</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['amnioticFluid']!='')?$value['amnioticFluid'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Presentation</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['presentation']!='')?$value['presentation'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Labour</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['labour']!='')?$value['labour'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Course Of Labour</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['courseOfLabour']!='')?$value['courseOfLabour'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>E/O Feotal Distress</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['eoFeotalDistress']!='')?$value['eoFeotalDistress'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Delivery Type</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['typeOfDelivery']!='')?$value['typeOfDelivery'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Delivery Attended By</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['deliveryAttendedBy']!='')?$value['deliveryAttendedBy'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Other&nbsp;Significant Value For Labour</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['otherSignificantValueForLabour']!='')?$value['otherSignificantValueForLabour'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> -->

                                  <tr>
                                    <td><b>Other&nbsp;observation/ comments</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['other']!='')?$value['other'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>

                                  <!-- <tr>
                                    <td><b>PIH Labour</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['pihLabour']!='')?$value['pihLabour'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> -->
                                  
                                  
                             
                                  <!-- <tr>
                                    <td><b>Indication For Caesarean</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['indicationForCaesarean']!='')?$value['indicationForCaesarean'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> -->
                             
                                  <!-- <tr>
                                    <td><b>Indication Applicable Value</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['indicationApplicableValue']!='')?$value['indicationApplicableValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr> -->

                                  
                                  <!-- <tr>
                                    <td><b>Uterine tone</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['MotherUterineTone'] != '') ? $value['MotherUterineTone'] : 'N/A'; ?></td>
                                      <?php } ?>
                                  </tr> -->

                                  

                                  <!-- <tr>
                                    <td><b>Episiotomy Stiches</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['EpisitomyCondition'] != '') ? $value['EpisitomyCondition'] : 'N/A'; ?></td>
                                      <?php } ?>
                                  </tr> -->

                                 <!--  <tr>
                                    <td><b>Did&nbsp;the&nbsp;Urinate/Pass Urine&nbsp;after&nbsp;delivery</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['MotherUrinationAfterDelivery'] != '') ? $value['MotherUrinationAfterDelivery'] : 'N/A'; ?></td>
                                      <?php } ?>
                                  </tr> -->

                                  <!-- <tr>
                                    <td><b>How&nbsp;much&nbsp;is&nbsp;Pad&nbsp;full?</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['SanitoryPadStatus'] != '') ? $value['SanitoryPadStatus'] : 'N/A'; ?></td>
                                      <?php } ?>
                                  </tr> -->

                                  <!-- <tr>
                                    <td><b>Is&nbsp;it smelly?</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['IsSanitoryPadStink'] != '') ? $value['IsSanitoryPadStink'] : 'N/A'; ?></td>
                                    <?php } ?>
                                  </tr> -->
                                      
                                  <!-- <tr>
                                    <td><b>EDD Value</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo ($value['eddValue']!='')?$value['eddValue'] :'N/A' ;?> </td>
                                    <?php } ?>
                                  </tr>   -->

                                 

                                  <tr>
                                    <td><b>Assesment&nbsp;Date &&nbsp;Time</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td><?php echo (($value['assesmentDate'] != '') ? date('d-m-Y', strtotime($value['assesmentDate'])) : "N/A").'<br>'.(($value['assesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['assesmentTime']))) : "N/A");?></td>
                                    <?php } ?>
                                  </tr>

                                  <tr>
                                    <td><b>Type</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                      <td> <?php 
                                        $type = $value['type'];
                                       echo ($type=='1') ? 'Monitoring' : 'Discharged';
                                        ?>
                                        </td>
                                    <?php } ?>
                                  </tr>
                            
                                  <tr>
                                    <td><b>Staff&nbsp;Name/ Assessment&nbsp;Sign</b></td>
                                    <?php $c = 1; foreach($MotherAssessment as $key => $value) { 
                                      // $staffName = $this->load->MotherModel->getStaffNameBYID($value['StaffID']);
                                       $nurseName = (($staffName['name']!='')?$staffName['name'] :'N/A') ;?>
                                       <td>
                                         <?php if($value['admittedSign']==''){
                                               echo $nurseName."<br>N/A";
                                             ?>
                                         <?php } else { echo $nurseName.'<br>' ?>
                                          <img src="<?php echo base_url();?>assets/images/sign/<?php echo $value['admittedSign']; ?>" style="width:100px;height:100px;">
                                         <?php } ?>
                                      </td>        
                                    <?php } ?>
                                  
                                
                                
                                   </tbody>
                                 </table>
                             </div>
                        </div>
                    <div id="stepp6" style="display:none;">
                      <?php 
  
                      $DoctorName = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByDoctor']);
                      $NurseName  = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByNurse']);
                      ?>
                         <?php 
                          $DischargeType = trim($dischargeData['typeOfDischarge'], '"');
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
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($motherAdmitData['modifyDate']));?>" readonly style="background-color:white;">
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
                                                   <textarea rows="3" class="form-control" readonly=""> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
                                                           <?php } ?>
                                             <?php } else {  echo 'N/A'; } ?>
                                   
                                 </div>
      
                             </div>                    
                   

                          <?php if($dischargeData['doctorSign'] != NULL || $dischargeData['signOfFamilyMember'] != NULL || $dischargeData['ashaSign'] != "") {  ?>
                             <div class="form-group">
                                 <div class="col-sm-2 text-right">
                                 <label for="inputEmail3" class="control-label">Signature</label>
                       
                                 </div>
                                 <div class="col-sm-3">
                                <?php if($dischargeData['doctorSign'] != NULL) { ?>
                                  Doctor Signature
                                  <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['doctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                <?php } ?> 
                                 </div>
                                 <div class="col-sm-3">
                                  <?php if($dischargeData['signOfFamilyMember'] != NULL) { ?>
                                   Family Member Signature
                                   <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['signOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                  <?php } ?> 
                                 </div>
                               <div class="col-sm-3">
                                 <?php if($dischargeData['ashaSign'] != "") { ?>
                                           Asha Signature
                                           <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['ashaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                <?php } ?> 
                                 </div>
                             </div>
                           <?php } ?>

                                                   
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
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['transportation']) ? 'N/A' :$dischargeData['transportation'];?>" readonly style="background-color:white;">
                                 </div>
      
                             </div>


                             <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($motherAdmitData['modifyDate']));?>" readonly style="background-color:white;">
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

                                                           <textarea rows="3" class="form-control" readonly="" style="background-color: white;"> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
                                                           <?php } ?>
                                             <?php } else {  echo 'N/A'; } ?>
                                   
                                 </div>
      
                             </div>
                      
                            <?php if($dischargeData['doctorSign'] != NULL || $dischargeData['signOfFamilyMember'] != NULL || $dischargeData['ashaSign'] != "") {  ?>
                             <div class="form-group">
                                 <div class="col-sm-2 text-right">
                                 <label for="inputEmail3" class="control-label">Signature</label>
                       
                                 </div>
                                 <div class="col-sm-3">
                                  <?php if($dischargeData['doctorSign'] != NULL) { ?>
                                   Doctor Signature
                                   <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['doctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                  <?php } ?> 
                                 </div>
                                 <div class="col-sm-3">
                                  <?php if($dischargeData['signOfFamilyMember'] != NULL) { ?>
                                   Family Member Signature
                                   <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['signOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                  <?php } ?> 
                                </div>
                                 <div class="col-sm-3">
                                  <?php if($dischargeData['ashaSign'] != "") { ?>
                                             Asha Signature
                                             <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['ashaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                  <?php } ?>           
                                 </div>
                             </div>
                           <?php } ?>

                                                   
                           <div class="form-group">
                                 <div class="col-md-12" style="height:100px"></div>
                             </div>
                  
                      
                      <?php } else {
                      $getFacilityData = $this->db->query("select fl.FacilityName,fl.Address from facilitylist as fl inner join loungeMaster as lm on lm.facilityId = fl.FacilityID where lm.LoungeID =".$getPdfLink['loungeId']."")->row_array();
                        ?>
                              <div class="form-group" style="margin-top:10px;">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Type Of Discharge</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? 'N/A' : $DischargeType;?>" readonly style="background-color:white;">
                                 </div>
                              </div> 

                              <!-- <div class="form-group">
                                   <label for="inputEmail3" class="col-sm-2 control-label">Follow UP</label>
                                   <div class="col-sm-10">
                                   <input type="text" class="form-control" value="<?php echo empty($dischargeData['DateOfFollowUpVisit']) ? 'N/A' : $dischargeData['DateOfFollowUpVisit'];?>" readonly style="background-color:white;">
                                   </div>
                              </div>  -->

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
                                 <input type="text" class="form-control" value="<?php echo empty($DoctorName['name']) ? 'N/A' : $DoctorName['name'];?>" readonly style="background-color:white;">
                                 </div>
                              </div> 
                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Staff Name</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" value="<?php echo empty($NurseName['name']) ? 'N/A' : $NurseName['name'];?>" readonly style="background-color:white;">
                                </div>
                                 
                              </div> 


                              <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Transportation</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo empty($dischargeData['transportation']) ? 'N/A' : $dischargeData['Transportation'];?>" readonly style="background-color:white;">
                                 </div>
                                
                              </div>

                              <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Discharged Date & Time</label>
                                 <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A", strtotime($motherAdmitData['modifyDate']));?>" readonly style="background-color:white;">
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
                                                            <textarea rows="3" class="form-control"> <?php echo $count++;?>.&nbsp;<?php echo $val['name'];?></textarea><br>
                                                           <?php } ?>
                                             <?php } else {  echo 'N/A'; } ?>
                                   
                                 </div>
      
                              </div>                      
                   
                            <?php if($dischargeData['doctorSign'] != NULL || $dischargeData['signOfFamilyMember'] != NULL || $dischargeData['ashaSign'] != "") {  ?>
                             <div class="form-group">
                                 <div class="col-sm-2 text-right">
                                 <label for="inputEmail3" class="control-label">Signature</label>
                       
                                 </div>
                                 <div class="col-sm-3">
                                  <?php if($dischargeData['doctorSign'] != NULL) { ?>
                                   Doctor Signature
                                   <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['doctorSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                  <?php } ?> 
                                 </div>
                                 <div class="col-sm-3">
                                  <?php if($dischargeData['signOfFamilyMember'] != NULL) { ?>
                                   Family Member Signature
                                   <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['signOfFamilyMember'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                  <?php } ?> 
                                 </div>
                                <div class="col-sm-3">
                                  <?php if($dischargeData['ashaSign'] != "") { ?>
                                             Asha Signature
                                             <img src="<?php echo base_url().'assets/images/sign/'.$dischargeData['ashaSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                  <?php } ?> 
                                 </div>
                             </div>
                           <?php } ?>

                                                   
                           <div class="form-group">
                                 <div class="col-md-12" style="height:100px"></div>
                             </div>


                      <?php  } ?>


                    </div>

<!-- Comments Data -->

            <div id="stepp7" style="display:none; margin-top:15px;">
              <?php  if(!empty($motherAdmitData['id'])) { echo 1;die; $getCommentData = $this->BabyModel->getCommentList(1,1,$motherData['motherId'],$motherAdmitData['id']); } ?>
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