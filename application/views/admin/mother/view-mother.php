
<?php   
  $getFourLevelVar = $this->uri->segment(4);
  $GetLounge      = $this->load->FacilityModel->GetFacilitiesID($motherAdmitData['loungeId']);

  $motherID       = $motherData['motherId']; 
  $Type           = $this->load->MotherModel->GetMotherType($motherID);

  $dischargeData  = $this->load->MotherModel->GetMotherStatus($motherAdmitData['id']);
  $pastInfoData  = $this->load->MotherModel->getMotherPastInfo($motherAdmitData['id']); 
  $get_last_assessment  = $this->load->MotherModel->GetLastAsessmentBabyOrMother('motherMonitoring','motherId',$motherID,$motherAdmitData['id']);

  $getPdfLink     = $this->load->MotherModel->getpdflinkFormBabyAdm($motherID); 

?>

 <script type="text/javascript">
                              function openCounsellingLog(motherId,posterId){
                                $('#allPosterSeenBox').modal('toggle');
                                var url = "<?php echo base_url('motherM/posterLogDetails') ?>";
                                $.ajax({
                                    url: url, 
                                    type: 'post',
                                    data: {'motherId': motherId,posterId:posterId},
                                    success: function(response_data) {
                                      var decode_data = jQuery.parseJSON(response_data);
                                      $('#allPosterSeenDiv').html(decode_data);
                                    }
                                });
                              }
                            </script>
   
    <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
      <div class="content-body">




<!-- Input Validation start -->
<section class="input-validation">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0">View Mother</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0 breadcrumb-white" style="max-width: max-content; float: left;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>motherM/registeredMother/all/all">Mothers</a>
                </li>
                <li class="breadcrumb-item active">View Mother
                </li>
              </ol>
              <h5 style="float: right; font-size: 1.2rem;"><?= ucwords($motherData['motherName']); ?>
                <span style="font-size: 1rem;">[MCTS No:&nbsp;<?php  if(empty($motherData['motherMCTSNumber'])){ echo"--";} else { echo $motherData['motherMCTSNumber'];  }?>]</span>
              </h5>
            </div>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-registration-tab" data-toggle="tab" href="#nav-registration" role="tab" aria-controls="nav-registration" aria-selected="true">Registration</a>
                                

                              <?php if ($Type['type'] == '1' || $Type['type'] == '3') { ?>
                                <a class="nav-item nav-link" id="nav-basic-tab" data-toggle="tab" href="#nav-basic" role="tab" aria-controls="nav-basic" aria-selected="true">Basic Information</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact Information</a> 
                                <!-- <a class="nav-item nav-link" id="nav-past-tab" data-toggle="tab" href="#nav-past" role="tab" aria-controls="nav-past" aria-selected="false">Mother Past Information</a> -->
                                <a class="nav-item nav-link" id="nav-assessment-tab" data-toggle="tab" href="#nav-assessment" role="tab" aria-controls="nav-assessment" aria-selected="false">Mother Assessment</a>
                                <a class="nav-item nav-link" id="nav-comment-tab" data-toggle="tab" href="#nav-comment" role="tab" aria-controls="nav-comment" aria-selected="false">Comments</a>
                                <a class="nav-item nav-link" id="nav-counselling-tab" data-toggle="tab" href="#nav-counselling" role="tab" aria-controls="nav-counselling" aria-selected="false">Counselling</a>
                                <?php 
                                  if($dischargeData['status'] == '2'){?>
                                    <a class="nav-item nav-link" id="nav-discharge-tab" data-toggle="tab" href="#nav-discharge" role="tab" aria-controls="nav-discharge" aria-selected="false">Discharged</a>
                                <?php  } } ?> 
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-registration" role="tabpanel" aria-labelledby="nav-registration-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Mother Registration</h5>
                                </div>

                                <?php if($motherData['isMotherAdmitted'] =='Yes') { ?>
              
                                  <div class="row col-12">
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Name </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['motherName']) ? 'UNKNOWN' : $motherData['motherName'];?>" readonly placeholder="Mother Name">
                                          </div>
                                        </div>
                                      </div>

                                    
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Mobile Number </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['motherMobileNumber']) ? '' : $motherData['motherMobileNumber'];?>" readonly placeholder="Mother Mobile Number">
                                          </div>
                                        </div>
                                      </div>

                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother to be admitted? </label>
                                          <div class="controls">
                                            <?php if($motherData['isMotherAdmitted'] =='Yes' || $motherData['isMotherAdmitted'] == 'yes'){?>
                                              <input type="text" class="form-control" value="<?php echo $motherData['isMotherAdmitted'];?>"readonly placeholder="Mother to be admitted?">
                                            <?php  } else { ?>
                                              <input type="text" class="form-control" value="<?php echo $motherData['isMotherAdmitted'];?>"readonly placeholder="Mother to be admitted?">
                                              <br/>
                                              <textarea cols="9" rows="3" readonly class="form-control"><?php echo empty($motherData['notAdmittedReason']) ? '' : $motherData['notAdmittedReason']; ?></textarea>
                                            <?php  } ?>
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                                  <div class="row col-12">
                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Photo </label>
                                          <?php if(empty($motherData['motherPicture'])){
                                              $img_url = base_url().'assets/images/user.png';
                                            } else {
                                              $img_url = motherDirectoryUrl.$motherData['motherPicture'];
                                            }
                                          ?>
                                        <?php if($motherData['motherPicture'] != '') { ?>
                                          <div class="set_div_img00" id="" style="display: <?php if($motherData['motherPicture'] != '') { echo "block"; } else { echo "none"; } ?>">
                                              <img src="<?php echo $img_url; ?>" style="cursor: pointer;" class="img-responsive" alt="img" onclick="showMotherImage('<?= $img_url ?>')">
                                                                      
                                          </div>
                                        <?php } else { ?>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="" readonly placeholder="">
                                          </div>
                                        <?php } ?>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's LMP Date (dd-mm-yyyy) </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['motherLmpDate']) ? '' : date("d-m-Y",strtotime($motherData['motherLmpDate'])); ?>" readonly placeholder="Mother LMP Date (dd-mm-yyyy)">
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                                <?php } else { ?>
                                  <div class="row col-12">
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother Name </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['motherName']) ? 'UNKNOWN' : $motherData['motherName'];?>" readonly placeholder="Mother Name">
                                          </div>
                                        </div>
                                      </div>

                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother to be admitted? </label>
                                          <div class="controls">
                                            <?php if($motherData['isMotherAdmitted'] =='Yes' || $motherData['isMotherAdmitted'] == 'yes'){?>
                                              <input type="text" class="form-control" value="<?php echo $motherData['isMotherAdmitted'];?>"readonly placeholder="Mother to be admitted?">
                                            <?php  } else { ?>
                                              <input type="text" class="form-control" value="<?php echo $motherData['isMotherAdmitted'];?>"readonly placeholder="Mother to be admitted?">
                                              <br/>
                                              <textarea cols="9" rows="3" readonly class="form-control"><?php echo empty($motherData['notAdmittedReason']) ? '' : $motherData['notAdmittedReason']; ?></textarea>
                                            <?php  } ?>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother LMP Date (yyyy-mm-dd) </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['motherLmpDate']) ? '' : $motherData['motherLmpDate'];?>" readonly placeholder="Mother LMP Date (yyyy-mm-dd)">
                                          </div>
                                        </div>
                                      </div>

                                      

                                  </div>

                                  <div class="row col-12">
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Guardian Name </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['guardianName']) ? '' : $motherData['guardianName'];?>" readonly placeholder="Guardian Name">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Guardian Contact Number </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['guardianNumber']) ? '' : $motherData['guardianNumber'];?>" readonly placeholder="Guardian Contact Number">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Relation With Child </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['guardianRelation']) ? '' : $motherData['guardianRelation'];?>" readonly placeholder="Relation With Child">
                                          </div>
                                        </div>
                                      </div>
                                      
                                  </div>


                                <?php } ?>

              
                            </div>



                            <div class="tab-pane fade show" id="nav-basic" role="tabpanel" aria-labelledby="nav-basic-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Mother Basic Information</h5>
                                </div>

              
                                  <div class="row col-12">
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Name </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['motherName']) ? 'UNKNOWN' : $motherData['motherName'];?>" readonly placeholder="Mother Name">
                                          </div>
                                        </div>
                                      </div>

                                    
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Father Name </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['fatherName']) ? '' : $motherData['fatherName'];?>" readonly >
                                          </div>
                                        </div>
                                      </div>

                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Aadhar Number </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['motherAadharNumber']) ? '' : $motherData['motherAadharNumber'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                                  <div class="row col-12">
                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Father's Aadhar Number </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['fatherAadharNumber']) ? '' : $motherData['fatherAadharNumber'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>MCTS Number </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['motherMCTSNumber']) ? '' : $motherData['motherMCTSNumber'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Weight ( in Kgs) </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['motherWeight']) ? '' : $motherData['motherWeight'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                                  <div class="row col-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother DOB (dd-mm-yyyy) </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['motherDOB']) ? '' : date("d-m-Y",strtotime($motherData['motherDOB'])); ?>" readonly placeholder="Mother DOB (dd-mm-yyyy)">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Age (in case DOB not known) </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['motherAge']) ? '' : $motherData['motherAge'];?>"readonly>
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Age at Marriage(in Year) </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['ageAtMarriage']) ? '' : $motherData['ageAtMarriage'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>

                                  </div>
                                  <div class="row col-12">
                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Mother's Education </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['motherEducation']) ? '' : $motherData['motherEducation'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Religion </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['motherReligion']) ? '' : $motherData['motherReligion'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Caste </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['motherCaste']) ? '' : $motherData['motherCaste'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="row col-12">
                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Have you ever had multiple births? </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['multipleBirth']) ? '' : $motherData['multipleBirth'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Total Pregnancies(Gravida) </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['gravida']) ? '' : $motherData['gravida'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>No. of births?(Para) </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['para']) ? '' : $motherData['para'];?>"readonly>
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="row col-12">
                                      
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>No. of miscarriage or abortion</label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['abortion']) ? '' : $motherData['abortion'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Total no. of children who are currently alive?(Live) </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['live']) ? '' : $motherData['live'];?>"readonly>
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Birth Spacing </label>
                                          <div class="controls">
                                            
                                              <input type="text" class="form-control" value="<?php echo empty($motherData['birthSpacing']) ? '' :  $motherData['birthSpacing'];?>"readonly >
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                                

              
                            </div>






                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Contact Details</h5>
                                </div>
              
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Mother Mobile Number </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['motherMobileNumber']) ? '' : $motherData['motherMobileNumber'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Father Mobile Number </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['fatherMobileNumber']) ? '' : $motherData['fatherMobileNumber'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Guardian Relation </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['guardianRelation']) ? '' : $motherData['guardianRelation'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Guardian Name </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['guardianName']) ? '' : $motherData['guardianName'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Guardian Mobile Number </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['guardianNumber']) ? '' : $motherData['guardianNumber'];?>" readonly >
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Family Ration Card Type </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['rationCardType']) ? '' : $motherData['rationCardType'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Present Address</h5>
                                </div>

                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Present Address Type </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo $motherData['presentResidenceType'];?>" readonly >
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Country </label>
                                        <div class="controls">
                                          <?php  if(empty($motherData['presentCountry'])){?>
                                            <input type="text" class="form-control" value="<?php //echo 'Other'; ?>" readonly>
                                          <?php } else { ?>
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['presentCountry']) ? '' : $motherData['presentCountry']; ?>" readonly >
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>State</label>
                                        <div class="controls">
                                          <?php  if(empty($motherData['presentCountry'])){?>
                                            <input type="text" class="form-control" value="<?php //echo 'Other'; ?>" readonly>
                                          <?php } else { ?>
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['presentState']) ? '' : $motherData['presentState'];?>" readonly>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>District </label>
                                        <div class="controls">
                                          <?php $GetPresentDistrictName = $this->load->MotherModel->GetPresentDistrictName($motherData['presentDistrictName']);?>
                                          <input type="text" class="form-control" value="<?php echo empty($GetPresentDistrictName['DistrictNameProperCase']) ? '' : $GetPresentDistrictName['DistrictNameProperCase']; ?>" readonly >
                                        </div>
                                      </div>
                                    </div>
                                    <?php if($motherData['presentResidenceType'] == "Rural"){ ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Block </label>
                                          <div class="controls">
                                            <?php $PresentBlockName = $this->load->MotherModel->GetPresentBlockName($motherData['presentBlockName']);?> 
                                            <input type="text" class="form-control" value="<?php echo empty($PresentBlockName['BlockPRINameProperCase']) ? '' : $PresentBlockName['BlockPRINameProperCase']; ?>" readonly >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Gram Sabha/Town or City</label>
                                          <div class="controls">
                                            <?php $PresentVillageName = $this->load->MotherModel->GetPresentVillageName($motherData['presentVillageName']);?> 
                                            <input type="text" class="form-control" value="<?php echo empty($PresentVillageName['GPNameProperCase']) ? '' : $PresentVillageName['GPNameProperCase']; ?>" readonly>
                                          </div>
                                        </div>
                                      </div>
                                    <?php }else{ ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Address </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['presentAddress']) ? '' : $motherData['presentAddress'];?>" readonly>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Pincode </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['presentPinCode']) ? '' : $motherData['presentPinCode']; ?>" readonly >
                                          </div>
                                        </div>
                                      </div>
                                    <?php } ?>
                                </div>

                                <div class="row col-12">
                                  <?php if($motherData['presentResidenceType'] == "Rural"){ ?>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Address </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['presentAddress']) ? '' : $motherData['presentAddress'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Pincode </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['presentPinCode']) ? '' : $motherData['presentPinCode']; ?>" readonly >
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Near By Location</label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['presentAddNearByLocation']) ? '' : $motherData['presentAddNearByLocation'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Permanent Address</h5>
                                </div>

                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Permanent Address Type </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['permanentResidenceType']) ? '' : $motherData['permanentResidenceType'];?>" readonly >
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Country </label>
                                        <div class="controls">
                                          <?php  if(empty($motherData['permanentCountry'])){?>
                                            <input type="text" class="form-control" value="<?php //echo 'Other'; ?>" readonly>
                                          <?php } else { ?>
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['permanentCountry']) ? '' : $motherData['permanentCountry']; ?>" readonly >
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>State</label>
                                        <div class="controls">
                                          <?php  if(empty($motherData['permanentState'])){?>
                                            <input type="text" class="form-control" value="<?php //echo 'Other'; ?>" readonly>
                                          <?php } else { ?>
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['permanentState']) ? '' : $motherData['permanentState']; ?>" readonly>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>District </label>
                                        <div class="controls">
                                          <?php $GetPermanentDistrictName = $this->load->MotherModel->GetPermanentDistrictName($motherData['permanentDistrictName']);?> 
                                          <input type="text" class="form-control" value="<?php echo empty($GetPermanentDistrictName['DistrictNameProperCase']) ? '' : $GetPermanentDistrictName['DistrictNameProperCase']; ?>" readonly>
                                        </div>
                                      </div>
                                    </div>

                                    <?php if($motherData['permanentResidenceType'] == "Rural"){ ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Block </label>
                                          <div class="controls">
                                            <?php $PermanentBlockName = $this->load->MotherModel->GetPermanentBlockName($motherData['permanentBlockName']);?> 
                                            <input type="text" class="form-control" value="<?php echo empty($PermanentBlockName['BlockPRINameProperCase']) ? '' : $PermanentBlockName['BlockPRINameProperCase'];?>" readonly >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Gram Sabha/Town or City</label>
                                          <div class="controls">
                                            <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                            <input type="text" class="form-control" value="<?php echo empty($PermanentVillageName['GPNameProperCase']) ? '' : $PermanentVillageName['GPNameProperCase']; ?>" readonly>
                                          </div>
                                        </div>
                                      </div>
                                    <?php }else{ ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Address </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['permanentAddress']) ? '' : $motherData['permanentAddress']; ?>" readonly>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Pincode </label>
                                          <div class="controls">
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['permanentPinCode']) ? '' : $motherData['permanentPinCode']; ?>" readonly>
                                          </div>
                                        </div>
                                      </div>
                                    <?php } ?>
                                </div>

                                <div class="row col-12">
                                  <?php if($motherData['permanentResidenceType'] == "Rural"){ ?>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Address </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['permanentAddress']) ? '' : $motherData['permanentAddress']; ?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Pincode </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['permanentPinCode']) ? '' : $motherData['permanentPinCode']; ?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Near By Location </label>
                                        <div class="controls">
                                          <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['permanentAddNearByLocation']) ? '' : $motherData['permanentAddNearByLocation']; ?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <!-- <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Delivery Address</h5>
                                </div> -->

                                <!-- <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Nurse </label>
                                        <div class="controls">
                                          <?php  
                                            $staffName = $this->load->MotherModel->getStaffNameBYID($motherData['staffId']);
                                          ?>
                                          <input type="text" class="form-control" value="<?php echo empty($staffName['name']) ? '' : $staffName['name'];?>" readonly placeholder="Nurse">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Asha </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['ashaName']) ? '' : $motherData['ashaName'];?>" readonly placeholder="Asha">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Asha Name</label>
                                        <div class="controls">
                                          <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?>
                                          <input type="text" class="form-control" value="<?php echo $motherData['ashaName'];?>" readonly placeholder="Asha Name">
                                        </div>
                                      </div>
                                    </div>
                                </div> -->

                                <!-- <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Asha Number </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['ashaNumber']) ? '' : $motherData['ashaNumber'];?>" readonly placeholder="Asha Number">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Mother LMP Date (yyyy-mm-dd) </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['motherLmpDate']) ? '' : $motherData['motherLmpDate'];?>" readonly placeholder="Mother LMP Date (yyyy-mm-dd)">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Estimated Date Of Delivery (yyyy-mm-dd)</label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($motherData['estimatedDateOfDelivery']) ? '' : $motherData['estimatedDateOfDelivery'];?>" readonly placeholder="Estimated Date Of Delivery (yyyy-mm-dd)">
                                        </div>
                                      </div>
                                    </div>
                                </div> -->

                                <!-- <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Place Of Birth </label>
                                        <div class="controls">
                                          <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                          <?php if(($motherData['deliveryFacilityId'] == '0') || ($motherData['deliveryFacilityId'] == '')) { ?>
                                            <input type="text" class="form-control" value="Hospital" readonly >
                                          <?php } else { ?>
                                            <input type="text" class="form-control" value="<?php echo empty($motherData['deliveryPlace']) ? '' : $motherData['deliveryPlace'];?>" >
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                    <?php  
                                      $FacilityName = $this->load->MotherModel->getFacilityNameBYID($motherData['deliveryFacilityId']);
                                      $DistrictName = $this->load->MotherModel->GetPresentDistrictName($motherData['deliveryDistrict']);
                                    ?>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>District </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo  empty($DistrictName['DistrictNameProperCase']) ? '' : $DistrictName['DistrictNameProperCase'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Facility </label>
                                        <div class="controls">
                                          <?php $PermanentVillageName = $this->load->MotherModel->GetPermanentVillageName($motherData['permanentVillageName']);?> 
                                          <input type="text" class="form-control" value="<?php echo ($FacilityName['FacilityName'] == null) ? 'Other' : $FacilityName['FacilityName']; ?>" readonly >
                                        </div>
                                      </div>
                                    </div>
                                </div> -->

                                <!-- <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Place Of Delivery </label>
                                        <div class="controls">
                                          
                                          <input type="text" class="form-control" value="<?php echo  empty($motherData['deliveryPlace']) ? '' : $motherData['deliveryPlace'];?>" readonly >
                                          
                                        </div>
                                      </div>
                                    </div>
                                </div> -->
                            </div>
                            
                            <div class="tab-pane fade" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Past History and ANC Period</h5>
                                </div>
              
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Antenatal Visit's </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['antenatalVisits']) ? '' : $pastInfoData['antenatalVisits'];?>" readonly placeholder="Antenatal Visit's">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>T.T Doses </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['ttDoses']) ? '' : $pastInfoData['ttDoses'];?>" readonly placeholder="T.T Doses">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Hb </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hbValue']) ? '' : $pastInfoData['hbValue'];?>" readonly placeholder="Hb">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Blood Group </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['bloodGroup']) ? '' : $pastInfoData['bloodGroup'];?>" readonly placeholder="Blood Group">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>PiH </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isPihAvail']) ? '' : $pastInfoData['isPihAvail'];?>" readonly placeholder="PiH">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>PiH Value </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['pihValue']) ? '' : $pastInfoData['pihValue'];?>" readonly placeholder="PiH Value">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Blood Group </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['bloodGroup']) ? '' : $pastInfoData['bloodGroup'];?>" readonly placeholder="Blood Group">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>PiH </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isPihAvail']) ? '' : $pastInfoData['isPihAvail'];?>" readonly placeholder="PiH">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>PiH Value </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['pihValue']) ? '' : $pastInfoData['pihValue'];?>" readonly placeholder="PiH Value">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Drug (Allergy) </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isDrugAvail']) ? '' : $pastInfoData['isDrugAvail'];?>" readonly placeholder="Drug (Allergy)">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Radiation </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['radiation']) ? '' : $pastInfoData['radiation'];?>" readonly placeholder="Radiation">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Illness </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isIllnessAvail']) ? '' : $pastInfoData['isIllnessAvail'];?>" readonly placeholder="Illness">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Illness Value </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['illnessValue']) ? '' : $pastInfoData['illnessValue'];?>" readonly placeholder="Illness Value">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>APH </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['aphValue']) ? '' : $pastInfoData['aphValue'];?>" readonly placeholder="APH">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>GDM </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['gdmValue']) ? '' : $pastInfoData['gdmValue'];?>" readonly placeholder="GDM">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Thyroid </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['thyroid']) ? '' : $pastInfoData['thyroid'];?>" readonly placeholder="Thyroid">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>VDRL </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['vdrlValue']) ? '' : $pastInfoData['vdrlValue'];?>" readonly placeholder="VDRL">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>HbsAg </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hbsAgValue']) ? '' : $pastInfoData['hbsAgValue'];?>" readonly placeholder="HbsAg">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>HIV Testing </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hivTesting']) ? '' : $pastInfoData['hivTesting'];?>" readonly placeholder="HIV Testing">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Amniotic Fluid Volume </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['amnioticFluidVolume']) ? '' : $pastInfoData['amnioticFluidVolume'];?>" readonly placeholder="Amniotic Fluid Volume">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Other Significant Info For History </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['otherSignificantInfo']) ? '' : $pastInfoData['otherSignificantInfo'];?>" readonly placeholder="Other Significant Info For History">
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">During Labour</h5>
                                </div>

                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Antenatal Steroids </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['isAntenatalSteroids']) ? '' : $pastInfoData['isAntenatalSteroids'];?>" readonly placeholder="Antenatal Steroids">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Antenatal Steroids Value </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['antenatalSteroidsValue']) ? '' : $pastInfoData['antenatalSteroidsValue'];?>" readonly placeholder="Antenatal Steroids Value">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>No. Of Doses </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['numberOfDoses']) ? '' : $pastInfoData['numberOfDoses'];?>" readonly placeholder="No. Of Doses">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Time Between Last Dose & Delivery </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['timeBetweenLastDoseDelivery']) ? '' : $pastInfoData['timeBetweenLastDoseDelivery'];?>" readonly placeholder="Time Between Last Dose & Delivery">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>H/O Fever </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['hoFever']) ? '' : $pastInfoData['hoFever'];?>" readonly placeholder="H/O Fever">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Foul Smelling Discharge </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['foulSmellingDischarge']) ? '' : $pastInfoData['foulSmellingDischarge'];?>" readonly placeholder="Foul Smelling Discharge">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Uterine Tenderness </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['uterineTenderness']) ? '' : $pastInfoData['uterineTenderness'];?>" readonly placeholder="Uterine Tenderness">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Leaking P.V > 24 Hours </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['leakingPv']) ? '' : $pastInfoData['leakingPv'];?>" readonly placeholder="Leaking P.V > 24 Hours">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>PPH </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['pphValue']) ? '' : $pastInfoData['pphValue'];?>" readonly placeholder="PPH">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Amniotic Fluid </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['amnioticFluid']) ? '' : $pastInfoData['amnioticFluid'];?>" readonly placeholder="Amniotic Fluid">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Presentation </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['presentation']) ? '' : $pastInfoData['presentation'];?>" readonly placeholder="Presentation">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Labour </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['labour']) ? '' : $pastInfoData['labour'];?>" readonly placeholder="Labour">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Course Of Labour </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['courseOfLabour']) ? '' : $pastInfoData['courseOfLabour'];?>" readonly placeholder="Course Of Labour">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>E/O Feotal Distress </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['eoFeotalDistress']) ? '' : $pastInfoData['eoFeotalDistress'];?>" readonly placeholder="E/O Feotal Distress">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Delivery Type </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['typeOfDelivery']) ? '' : $pastInfoData['typeOfDelivery'];?>" readonly placeholder="Delivery Type">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Delivery Attended By </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['deliveryAttendedBy']) ? '' : $pastInfoData['deliveryAttendedBy'];?>" readonly placeholder="Delivery Attended By">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Other Significant Info </label>
                                        <div class="controls">
                                          <input type="text" class="form-control" value="<?php echo empty($pastInfoData['otherSignificantValueForLabour']) ? '' : $pastInfoData['otherSignificantValueForLabour'];?>" readonly placeholder="E/O Feotal Distress">
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-assessment" role="tabpanel" aria-labelledby="nav-assessment-tab">
                                <div class="table-responsive">
                                  <table class="table table-striped amenitiesLog">
                                      <thead>
                                        <?php 
                                        if(!empty($motherAdmitData)){
                                          $MotherAssessment = $this->load->MotherModel->GetMotherAssessmentDataBYID($motherData['motherId'],$motherAdmitData['id']); 
                                        }else{
                                          $MotherAssessment = array();
                                        }
                                        ?>
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

                                        <!-- <tr>
                                          <td><b>Pad&nbsp;Not&nbsp;Changed&nbsp;Reason</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                              <td> <?php echo ($value['padNotChangeReason'] != "") ? $value['padNotChangeReason'] : "";?></td>
                                          <?php } ?>
                                        </tr> -->

                                        <tr>
                                          <td><b>Systolic (mm&nbsp;Hg)</b></td>
                                          <?php if(!empty($MotherAssessment)){ foreach($MotherAssessment as $key => $value) { 
                                            if ($value['motherSystolicBP'] >= 140 || $value['motherSystolicBP'] <= 90) { ?>
                                              <td style="color:red;"> <?php echo $value['motherSystolicBP'].'&nbsp;mm&nbsp;Hg';?> </td>
                                          <?php } else { ?>
                                              <td><?php echo ($value['motherSystolicBP'] != "") ? $value['motherSystolicBP']."&nbsp;mm&nbsp;Hg" : "";?></td>
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
                                              <td><?php echo ($value['motherDiastolicBP'] != "") ? $value['motherDiastolicBP']."&nbsp;mm&nbsp;Hg" : "";?></td>
                                          <?php } } ?>
                                        </tr>

                                        <tr>
                                          <td><b>Pulse&nbsp;Rate (bpm)</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { 
                                            if ($value['motherPulse'] < 50 || $value['motherPulse'] > 120) { ?>
                                              <td style="color:red;"> <?php echo $value['motherPulse'].'&nbsp;bpm';?> </td>
                                            <?php } else { ?>
                                              <td> <?php echo ($value['motherPulse'] != "") ? $value['motherPulse']."&nbsp;bpm" : "";?></td>
                                          <?php } } ?>
                                        </tr>


                                        <tr>
                                          <td><b>Uterine&nbsp;Tone</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                              <td> <?php echo ($value['motherUterineTone'] != "") ? $value['motherUterineTone'] : "";?></td>
                                          <?php } ?>
                                        </tr>

                                        <tr>
                                          <td><b>Temperature (<sup>0</sup>F)</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { 
                                            if ($value['motherTemperature'] > 95.9 && $value['motherTemperature'] < 99.5) { ?>
                                              <td> <?php echo $value['motherTemperature'].'&nbsp;<sup>0</sup>F';?> </td>
                                          <?php } else { ?>
                                            <td style="color:red;"> <?php echo ($value['motherTemperature'] != "") ? $value['motherTemperature']."&nbsp;<sup>0</sup>F" : "";?></td>
                                          <?php } } ?>
                                        </tr>

                                        <!-- <tr>
                                          <td><b>Episiotomy&nbsp;Stitches</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                              <td> <?php echo ($value['episitomyStitchesCondition'] != "") ? $value['episitomyStitchesCondition'] : "";?></td>
                                          <?php } ?>
                                        </tr> -->

                                        <!-- <tr>
                                          <td><b>Urinate/Pass&nbsp;Urine&nbsp;After&nbsp;Delivery</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                              <td> <?php echo ($value['motherUrinationAfterDelivery'] != "") ? $value['motherUrinationAfterDelivery'] : "";?></td>
                                          <?php } ?>
                                        </tr> -->

                                        <!-- <tr>
                                          <td><b>How&nbsp;much&nbsp;is&nbsp;Pad&nbsp;full?</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                            <td><?php echo ($value['sanitoryPadStatus'] != '') ? $value['sanitoryPadStatus'] : ''; ?></td>
                                            <?php } ?>
                                        </tr>

                                        <tr>
                                          <td><b>Is&nbsp;it smelly?</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                            <td><?php echo ($value['IsSanitoryPadStink'] != '') ? $value['IsSanitoryPadStink'] : ''; ?></td>
                                          <?php } ?>
                                        </tr> -->
                                  
                                        <tr>
                                          <td><b>Other&nbsp;observation/ comments</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                            <td><?php echo ($value['other']!='')?$value['other'] :'' ;?> </td>
                                          <?php } ?>
                                        </tr>

                                        <tr>
                                          <td><b>Assesment&nbsp;Date &&nbsp;Time</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) { ?>
                                            <td><?php echo (($value['assesmentDate'] != '') ? date('d-m-Y', strtotime($value['assesmentDate'])) : "").'<br>'.(($value['assesmentTime'] != '') ? strtoupper(date('h:i a', strtotime($value['assesmentTime']))) : "");?></td>
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
                                          <td><b>Staff&nbsp;Name</b></td>
                                          <?php $c = 1; foreach($MotherAssessment as $key => $value) {
                                              $staffName = $this->load->MotherModel->getStaffNameBYID($value['staffId']);
                                              $nurseName = (($staffName['name']!='')?$staffName['name'] :'') ;?>
                                             <td>
                                              <?php echo $nurseName; ?>
                                               <!-- <?php if($value['admittedSign']==''){
                                                     echo $nurseName."<br>";
                                                   ?>
                                               <?php } else { echo $nurseName.'<br>' ?>
                                                <img src="<?php echo base_url();?>assets/images/sign/<?php echo $value['admittedSign']; ?>" style="width:100px;height:100px;">
                                               <?php } ?> -->
                                            </td>        
                                          <?php } ?>
                                        </tr>
                                  
                                   </tbody>
                                 
                                  </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">
                                <div class="table-responsive">
                                  <?php
                                  $getCommentData = array();
                                  if(!empty($motherAdmitData['id'])) { $getCommentData = $this->BabyModel->getCommentList(1,1,$motherData['motherId'],$motherAdmitData['id']); }  ?>
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

                            <div class="tab-pane fade" id="nav-counselling" role="tabpanel" aria-labelledby="nav-counselling-tab">
                                <div class="table-responsive">
                                  
                                  <table class="table table-striped dataex-html5-selectors-log">
                                      <thead>
                                          <tr>
                                            <th style="width:70px;">S&nbsp;No.</th>
                                            <th>Counselling&nbsp;Category</th>
                                            <th>Poster Name</th>
                                            <th>Last Seen</th>
                                            <th>Total Seen&nbsp;Time</th>
                                          </tr>
                                      </thead>
                                      <tbody>

                                      <?php 
                                        $counter=1;
                                        
                                        foreach($GetAllCounsellingList as $key => $counsellingValue) { 
                                        $counsellingCategoryArr = array('1'=>'What is KMC','2'=>'KMC Position','3'=>'KMC Nutrition','4'=>'KMC Hygiene','5'=>'KMC Monitoring','6'=>'KMC Respect');

                                        $getCounsellingPosterData      = $this->MotherModel->getPosterCounsellingPosterLogs($babyIds,$counsellingValue['posterId']);
                                        $totalSeenTime = 0;
                                        foreach($getCounsellingPosterData as $getCounsellingPosterDataList){
                                          $totalSeenTime = $totalSeenTime+$getCounsellingPosterDataList['duration'];
                                          $hours = floor($totalSeenTime / 3600);
                                          $mins = floor($totalSeenTime / 60 % 60);
                                          $secs = floor($totalSeenTime % 60);
                                          $timeFormat = $hours."h"." ".$mins."m"." ".$secs."s";
                                        }

                                      ?>
                                      <tr>
                                        <td><?php echo $counter++;?></td>
                                        <td><?php echo $counsellingCategoryArr[$counsellingValue['counsellingType']];?></td>
                                        <td><?php echo $counsellingValue['videoTitle']; ?></td>
                                        <td>
                                          <a style="font-weight:normal;" class="tooltip nonclick_link"><?php echo date("d-m-Y g:i A", strtotime($counsellingValue['addDate']));?><span class="tooltiptext"><?php echo date("d-m-Y g:i A", strtotime($counsellingValue['addDate']));?></span></a>
                                        </td>         
                                        <td>                                           
                                          <a style="color:#5A8DEE;font-weight:normal;cursor: pointer;" onclick="openCounsellingLog('<?php echo $motherId; ?>','<?php echo $counsellingValue['posterId']; ?>')"><?php echo $timeFormat; ?></a>
                                        </td>
                                      </tr>
                                      <?php }?>
                                          
                                      </tbody>
                                      
                                  </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-discharge" role="tabpanel" aria-labelledby="nav-discharge-tab">
                                <div class="col-12">
                                  <h5 class="float-left mb-2 mt-1 pr-1">Discharge Information</h5>
                                </div>

                                <?php 
                                  $DoctorName = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByDoctor']);
                                  $NurseName  = $this->load->MotherModel->getStaffNameBYID($dischargeData['dischargeByNurse']);
                                
                                  $DischargeType = trim($dischargeData['typeOfDischarge'], '"');

                                  if($DischargeType == 'Died'){ ?>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Type Of Discharge </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? '' : $DischargeType;?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Doctor Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nurse Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Guardian Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Relationship with Mother </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithMother'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['relationWithMother'] == "Other"){ ?>
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
                                            <label>Body Handed Over </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['bodyHandover'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharged Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
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


                                  <?php } elseif($DischargeType == 'Absconded'){ ?>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Type Of Discharge </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? '' : $DischargeType;?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nurse Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Mother/Family member absconded along with baby </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['isAbsconded'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharged Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
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

                                  <?php } elseif($DischargeType == "Doctor's discretion"){ ?>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Type Of Discharge </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? '' : $DischargeType;?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Doctor Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nurse Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Early Discharge Reason </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['earlyDishargeReason'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Training for KMC at Home </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['trainForKMCAtHome'];?>" readonly placeholder="">
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
                                            <label>Guardian Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Relationship with Mother </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithMother'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['relationWithMother'] == "Other"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Other Relationship </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['otherRelation'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        <?php }else{ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Transportation </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                    </div>

                                    <div class="row col-12">
                                      <?php if($dischargeData['relationWithMother'] == "Other"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Transportation </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharged Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
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

                                  <?php } elseif($DischargeType == 'DOPR'){ ?>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Type Of Discharge </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? '' : $DischargeType;?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Doctor Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nurse Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Training for KMC at Home </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['trainForKMCAtHome'];?>" readonly placeholder="">
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
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Transportation </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Guardian Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Relationship with Mother </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithMother'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['relationWithMother'] == "Other"){ ?>
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
                                            <label>Discharged Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
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

                                  <?php } elseif($DischargeType == 'LAMA'){ ?>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Type Of Discharge </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? '' : $DischargeType;?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Doctor Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nurse Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Training for KMC at Home </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['trainForKMCAtHome'];?>" readonly placeholder="">
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
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Transportation </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharged Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
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
                                                    <span class="hover-image cursor-pointer" onclick="showZoomImage('<?php echo motherDirectoryUrl.$dischargeData['sehmatiPatr'];?>','Consent Form')">
                                                      <img src="<?php echo motherDirectoryUrl.$dischargeData['sehmatiPatr'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                                    </span>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                  <?php } elseif($DischargeType == 'Referral'){ 

                                          $FacilityDetails = $this->db->query("SELECT * FROM `facilitylist` where FacilityID='".$dischargeData['dischargeReferredFacility']."'")->row_array();
                                          $DistrictDetails = $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode='".$dischargeData['dischargeReferredDistrict']."'")->row_array();
                                  ?>

                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Type Of Discharge </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? '' : $DischargeType;?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Doctor Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Nurse Name </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
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
                                              <label>Referred Notes </label>
                                              <div class="controls">
                                                <textarea class="form-control" readonly><?php echo $dischargeData['dischargeNotes'];?></textarea>
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Guardian Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Relationship with Mother </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithMother'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['relationWithMother'] == "Other"){ ?>
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
                                            <label>Transportation </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Discharged Date & Time </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
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

                                  <?php } elseif($DischargeType == 'Normal Discharge'){ ?>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Type Of Discharge </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo empty($DischargeType) ? '' : $DischargeType;?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Doctor Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $DoctorName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nurse Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $NurseName['name'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Training for KMC at Home </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['trainForKMCAtHome'];?>" readonly placeholder="">
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
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Transportation </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['transportation'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Guardian Name </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['guardianName'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Relationship with Mother </label>
                                            <div class="controls">
                                              <input type="text" class="form-control" value="<?php echo $dischargeData['relationWithMother'];?>" readonly placeholder="">
                                            </div>
                                          </div>
                                        </div>
                                        <?php if($dischargeData['relationWithMother'] == "Other"){ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Other Relationship </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo $dischargeData['otherRelation'];?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        <?php }else{ ?>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Discharged Date & Time </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        <?php } ?>
                                    </div>

                                    <?php if($dischargeData['relationWithMother'] == "Other"){ ?>
                                      <div class="row col-12">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Discharged Date & Time </label>
                                              <div class="controls">
                                                <input type="text" class="form-control" value="<?php echo date("d-m-Y g:i A",strtotime($dischargeData['dateOfDischarge']));?>" readonly placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                    <?php } ?>

                                    <div class="col-12">
                                      <h5 class="float-left mb-2 mt-1 pr-1">Signature </h5>
                                    </div>

                                    <div class="row col-12">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Nurse Signature </label>
                                            <div class="controls">
                                              <?php if(!empty($dischargeData['nurseDischargeSign'])){ ?>
                                                <img src="<?php echo signDirectoryUrl.$dischargeData['nurseDischargeSign'];?>" style="width:100%;height:200px;border:1px;border: 1px solid gray;">
                                              <?php }else{ echo ""; } ?>
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                  <?php } ?>

                            </div>
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

    <!-- *******modal **-->

      <div class="modal fade" id="allPosterSeenBox" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
              <h4 class="modal-title">Counselling Log</h4>
            </div>
            <div class="modal-body" id="allPosterSeenDiv">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>

      <!-- ************* -->

   



    