<style type="text/css">
  table, th, td {
    border:1px solid #cec9c9;
    border-collapse: collapse;
  }
  th, td {
    padding: 6px;
  }
  .formLabel{ font-size: 13px; }
  .hideDiv{ display: none; }
  .showDiv{ display: block; }
</style>
<?php $sessionData = $this->session->userdata('adminData'); ?>
<div class="app-content content">
  <div class="content-overlay"></div>
    <div class="content-wrapper">
      <!-- <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
          <div class="row breadcrumbs-top">
            <div class="col-12">
              <h5 class="content-header-title float-left pr-1 mb-0">Main report</h5>
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb p-0 mb-0">
                  <li class="breadcrumb-item"><a href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/html/ltr/horizontal-menu-template/index.html"><i class="bx bx-home-alt"></i></a>
                  </li>
                  <li class="breadcrumb-item active"> Discharge Report </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <div class="content-body">
      <section id="page-account-settings">
          <div class="row">
              <div class="col-12">
                  <div class="row">
                      <!-- left content section -->
                      <div class="col-md-5">
                          <div class="card">
                              <div class="card-content">
                                  <div class="card-body">
                                    <table>
                                      <tr>
                                        <td><b>Facility Name</b></td>
                                        <td><?php echo $motherDischargeData['FacilityName']; ?></td>

                                        <td><b>Mother's Name</b></td>
                                        <td><?php echo $motherDischargeData['motherName']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Father's Name</b></td>
                                        <td><?php echo $motherDischargeData['fatherName']; ?></td>

                                        <td><b>Mother Mobile Number</b></td>
                                        <td><?php echo $motherDischargeData['motherMobileNumber']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Father Mobile Number</b></td>
                                        <td><?php echo $motherDischargeData['fatherMobileNumber']; ?></td>

                                        <td><b>Guardian Name</b></td>
                                        <td><?php echo $motherDischargeData['guardianName']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Relationship with Child</b></td>
                                        <td><?php echo $motherDischargeData['guardianRelation']; ?></td>

                                        <td><b>Guardian Phone Number</b></td>
                                        <td><?php echo $motherDischargeData['guardianNumber']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Mother accompanied during admission</b></td>
                                        <td><?php echo $motherDischargeData['isMotherAdmitted']; ?></td>

                                        <td><b>Religion</b></td>
                                        <td><?php echo $motherDischargeData['motherReligion']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Caste</b></td>
                                        <td><?php echo $motherDischargeData['motherCaste']; ?></td>

                                        <td><b>District</b></td>
                                        <td>
                                        <?php 
                                        $GetPresentDistrictName = $this->load->MotherModel->GetPresentDistrictName($motherDischargeData['presentDistrictName']);
                                        echo $GetPresentDistrictName['DistrictNameProperCase']; ?>
                                        </td>
                                      </tr>
                                      <?php if($motherDischargeData['presentResidenceType'] == "Rural"){ ?>
                                        <tr>
                                          <td><b>Rural Block</b></td>
                                          <td><?php echo $motherDischargeData['presentBlockName']; ?></td>

                                          <td><b>Rural Gram</b></td>
                                          <td><?php echo $motherDischargeData['presentVillageName']; ?></td>
                                        </tr>
                                      <?php } ?>
                                      <tr>
                                        <td><b>Address</b></td>
                                        <td colspan="3"><?php echo $motherDischargeData['presentAddress']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Delivery Date</b></td>
                                        <td><?php echo date('d-m-Y',strtotime($motherDischargeData['deliveryDate'])); ?></td>

                                        <td><b>Delivery Time</b></td>
                                        <td><?php echo date('h:i A',strtotime($motherDischargeData['deliveryTime'])); ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Gender</b></td>
                                        <td><?php echo $motherDischargeData['babyGender']; ?></td>

                                        <td><b>Birth Weight(gm)</b></td>
                                        <td><?php echo $motherDischargeData['babyWeight']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Type of Admission</b></td>
                                        <td><?php echo $motherDischargeData['typeOfBorn']; ?></td>

                                        <td><b>Type of Delivery</b></td>
                                        <td><?php echo $motherDischargeData['deliveryType']; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Admission Date</b></td>
                                        <td><?php echo date('d-m-Y',strtotime($motherDischargeData['admissionDate'])); ?></td>

                                        <td><b>Admission Time</b></td>
                                        <td><?php echo date('h:i A',strtotime($motherDischargeData['admissionDate'])); ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>Discharge Type</b></td>
                                        <td><?php echo $motherDischargeData['typeOfDischarge']; ?></td>

                                        <td><b>Discharge Date and Time</b></td>
                                        <td><?php echo date('d-m-Y h:i A',strtotime($motherDischargeData['dateOfDischarge'])); ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>KMC Given</b></td>
                                        <td><?php echo $motherDischargeData['trainForKMCAtHome']; ?></td>
                                      </tr>
                                    </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- right content section -->
                      <div class="col-md-7">
                          <div class="card">
                              <div class="card-content">
                                  <div class="card-body">

                                    <form class="form-horizontal" method="post" novalidate action="<?php echo site_url('FeedbackManagement/saveMotherFeedbacks');?>" enctype="multipart/form-data">

                                      <div class="col-12">
                                        <h5 class="float-left pr-1">Mother's Feedback Form</h5>
                                      </div>
                                      
                                      <div class="row col-12">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">जानकारी लेने की दिनांक <span class="red">*</span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control dateOfCallFeedback" name="dateOfCall" id="dateOfCall" value="<?php echo date('d F, Y'); ?>" required="">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">जानकारी लेने का समय <span class="red">*</span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control timeOfCallFeedback" name="timeOfCall" id="timeOfCall" value="<?php echo date('h:i A'); ?>" required="">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <?php
                                                if($sessionData['Type'] == 4){
                                                  $empId = $sessionData['Id'];
                                                  $empDisable = "disabled";
                                                  $empRequired = "";
                                                }else{
                                                  $empId = $lastFeedbackData['employeeId'];
                                                  $empDisable = "";
                                                  $empRequired = "*";
                                                }
                                              ?>
                                              <label class="formLabel">जानकारी लेने वाले सदस्य का नाम <span class="red"><?php echo $empRequired; ?></span></label>
                                              <div class="controls">
                                                <select class="form-control" name="dataCollectorID" id="dataCollectorID" required <?php echo $empDisable; ?>>
                                                  <option value="">कृपया चयन करें</option>
                                                  <?php foreach($employeeList as $employeeData){ ?>
                                                    <option value="<?php echo $employeeData['id']; ?>" <?php if($empId == $employeeData['id']){ echo "selected"; } ?>><?php echo $employeeData['name']; ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">शिशु की माता का नाम <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="hidden" class="form-control" name="childMotherId" id="childMotherId" value="<?php echo $motherDischargeData['motherId']; ?>">

                                                <input type="text" class="form-control" name="childMotherName" id="childMotherName" value="<?php echo $motherDischargeData['motherName']; ?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">शिशु के पिता का नाम <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control" name="childFatherName" id="childFatherName" <?php echo $motherDischargeData['fatherName']; ?> readonly>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">प्रसव स्थान का नाम <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control" name="deliveryPlace" id="deliveryPlace" value="<?php if(($motherDischargeData['infantComingFrom'] == 'Other') || ($motherDischargeData['infantComingFrom'] == 'अन्य')){ echo $motherDischargeData['infantComingFromOther']; }else{ echo $motherDischargeData['infantComingFrom']; } ?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">प्रसव दिनांक <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control" name="deliveryDate" id="deliveryDate" value="<?php echo date('d-m-Y',strtotime($motherDischargeData['deliveryDate'])); ?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">अस्पताल से डिस्चार्ज होने की दिनांक <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control" name="dischargeDate" id="dischargeDate" value="<?php echo date('d-m-Y h:i A',strtotime($motherDischargeData['dateOfDischarge'])); ?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">कॉल की स्थिति <span class="red">*</span></label>
                                              <div class="controls">
                                                <select class="form-control" name="callStatus" id="callStatus" onchange="validateCallStatus(this.value);" required="">
                                                  <option value="">कृपया चयन करें</option>
                                                  <option value="call_connected" <?php if($lastFeedbackData['callStatus']== "call_connected"){ echo "selected"; } ?>>कॉल कनेक्टेड (कॉल लग गयी)</option>
                                                  <option value="call_not_connected" <?php if($lastFeedbackData['callStatus']== "call_not_connected"){ echo "selected"; } ?>>कॉल नॉट कनेक्टेड (कॉल नहीं लगी)</option>
                                                  <option value="refusal" <?php if($lastFeedbackData['callStatus']== "refusal"){ echo "selected"; } ?>>बात करने से मना कर दिया</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6 hideDiv" id="refusalReasonDiv">
                                            <div class="form-group">
                                              <label class="formLabel">बात करने से मना करने का कारण <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control" name="refusalReason" id="refusalReason" value="<?php echo $lastFeedbackData['refusalReason']; ?>">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-6 hideDiv" id="babyCurrStatusDiv">
                                            <div class="form-group">
                                              <label class="formLabel">बच्चे की वर्तमान स्थिति <span class="red"></span></label>
                                              <div class="controls">
                                                <select class="form-control" name="babyCurrStatus" id="babyCurrStatus" onchange="showBabyDeathOption(this.value)">
                                                  <option value="">कृपया चयन करें</option>
                                                  <option value="healthy" <?php if($lastFeedbackData['babyCurrStatus']== "healthy"){ echo "selected"; } ?>>स्वस्थ</option>
                                                  <option value="unhealthy" <?php if($lastFeedbackData['babyCurrStatus']== "unhealthy"){ echo "selected"; } ?>>अस्वस्थ</option>
                                                  <option value="dead" <?php if($lastFeedbackData['babyCurrStatus']== "dead"){ echo "selected"; } ?>>मृत</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6 hideDiv" id="babyDeathDateDiv">
                                            <div class="form-group">
                                              <label class="formLabel">बच्चे की मृत्यु की दिनांक <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control dateOfCallFeedback" name="babyDeathDate" id="babyDeathDate" value="<?php echo ($lastFeedbackData['babyDeathDate'] != "" && $lastFeedbackData['babyDeathDate'] != "0000-00-00") ? date('d F, Y',strtotime($lastFeedbackData['babyDeathDate'])) : ""; ?>">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-6 hideDiv" id="motherCurrStatusDiv">
                                            <div class="form-group">
                                              <label class="formLabel">माँ की वर्तमान स्थिति <span class="red"></span></label>
                                              <div class="controls">
                                                <select class="form-control" name="motherCurrStatus" id="motherCurrStatus" onchange="showMotherDeathOption(this.value)">
                                                  <option value="">कृपया चयन करें</option>
                                                  <option value="healthy" <?php if($lastFeedbackData['motherCurrStatus']== "healthy"){ echo "selected"; } ?>>स्वस्थ</option>
                                                  <option value="unhealthy" <?php if($lastFeedbackData['motherCurrStatus']== "unhealthy"){ echo "selected"; } ?>>अस्वस्थ</option>
                                                  <option value="dead" <?php if($lastFeedbackData['motherCurrStatus']== "dead"){ echo "selected"; } ?>>मृत</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6 hideDiv" id="motherDeathDateDiv">
                                            <div class="form-group">
                                              <label class="formLabel">माँ की मृत्यु की दिनांक <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control dateOfCallFeedback" name="motherDeathDate" id="motherDeathDate" value="<?php echo ($lastFeedbackData['motherDeathDate'] != "" && $lastFeedbackData['motherDeathDate'] != "0000-00-00") ? date('d F, Y',strtotime($lastFeedbackData['motherDeathDate'])) : ""; ?>">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div class="hideDiv" id="hospitalExperienceDiv">
                                        <div class="col-12">
                                          <h5 class="float-left pr-1"> मैं आपसे आपके अस्पताल के अनुभवों के बारे में बात करना चाहूँगी / चाहूँगा</h5>
                                        </div>

                                        <div class="row col-12">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="formLabel">आपको अस्पताल में रुकने के दौरान क्या-क्या अच्छा लगा ? <span class="red"></span></label>
                                                <div class="controls">
                                                  <input type="text" class="form-control" name="likedInHosp" id="likedInHosp" value="<?php echo $lastFeedbackData['likedInHosp']; ?>">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="formLabel">आपको अस्पताल में रुकने के दौरान क्या अच्छा नहीं लगा ? <span class="red"></span></label>
                                                <div class="controls">
                                                  <input type="text" class="form-control" name="notLikedInHosp" id="notLikedInHosp" value="<?php echo $lastFeedbackData['notLikedInHosp']; ?>">
                                                </div>
                                              </div>
                                            </div>
                                        </div>

                                        <div class="row col-12">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="formLabel">आपको अस्पताल में रुकने के दौरान वहां के स्वास्थ्यकर्मियों का व्यवहार कैसा लगा ? <span class="red"></span></label>
                                                <div class="controls">
                                                  <input type="text" class="form-control" name="staffBehaviour" id="staffBehaviour" value="<?php echo $lastFeedbackData['staffBehaviour']; ?>">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="formLabel">आपने अस्पताल में रुकने के दौरान क्या-क्या सीखा ? <span class="red"></span></label>
                                                <div class="controls">
                                                  <input type="text" class="form-control" name="whatLearnt" id="whatLearnt" value="<?php echo $lastFeedbackData['whatLearnt']; ?>">
                                                </div>
                                              </div>
                                            </div>
                                        </div>

                                        <div class="row col-12">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="formLabel">आपको KMC के बारे में क्या पता है ? <span class="red"></span></label>
                                                <div class="controls">
                                                  <input type="text" class="form-control" name="kMCKnowledge" id="kMCKnowledge" value="<?php echo $lastFeedbackData['kMCKnowledge']; ?>">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="formLabel">आपको क्या लगता है कि अस्पताल में किन चीज़ों में सुधार किया जाना चाहिये ? <span class="red"></span></label>
                                                <div class="controls">
                                                  <input type="text" class="form-control" name="suggestions" id="suggestions" value="<?php echo $lastFeedbackData['suggestions']; ?>">
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                      </div>

                                      <div class="row col-12">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label class="formLabel">यदि कोई टिप्पणी हो <span class="red"></span></label>
                                              <div class="controls">
                                                <input type="text" class="form-control" name="remarks" id="remarks" value="<?php echo $lastFeedbackData['remarks']; ?>">
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <button type="submit" class="btn btn-primary">Submit</button>

                                    </form>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </section>
    
    </div>
  </div>
</div>

<script type="text/javascript">
  $( document ).ready(function() {
      validateCallStatus('<?php echo $lastFeedbackData['callStatus']; ?>');
      showBabyDeathOption('<?php echo $lastFeedbackData['babyCurrStatus']; ?>');
      showMotherDeathOption('<?php echo $lastFeedbackData['motherCurrStatus']; ?>');
  });

  function validateCallStatus(val){
    if(val == "refusal"){
      $('#refusalReasonDiv').removeClass('hideDiv').addClass('showDiv');
      $('#babyCurrStatusDiv').removeClass('showDiv').addClass('hideDiv');
      $('#motherCurrStatusDiv').removeClass('showDiv').addClass('hideDiv');
      $('#babyDeathDateDiv').removeClass('showDiv').addClass('hideDiv');
      $('#motherDeathDateDiv').removeClass('showDiv').addClass('hideDiv');
      $('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');
    }else if(val == "call_connected"){
      $('#refusalReasonDiv').removeClass('showDiv').addClass('hideDiv');
      $('#babyCurrStatusDiv').removeClass('hideDiv').addClass('showDiv');
      $('#motherCurrStatusDiv').removeClass('hideDiv').addClass('showDiv');
      $('#babyDeathDateDiv').removeClass('showDiv').addClass('hideDiv');
      $('#motherDeathDateDiv').removeClass('showDiv').addClass('hideDiv');
      $('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');

      // $('#babyCurrStatus').val('');
      // $('#motherCurrStatus').val('');
      // $('#babyDeathDate').val('');
      // $('#motherDeathDate').val('');
    }else{
      $('#refusalReasonDiv').removeClass('showDiv').addClass('hideDiv');
      $('#babyCurrStatusDiv').removeClass('showDiv').addClass('hideDiv');
      $('#motherCurrStatusDiv').removeClass('showDiv').addClass('hideDiv');
      $('#babyDeathDateDiv').removeClass('showDiv').addClass('hideDiv');
      $('#motherDeathDateDiv').removeClass('showDiv').addClass('hideDiv');
      $('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');
    }
  }

  function showBabyDeathOption(val){
    if(val == "dead"){
      $('#babyDeathDateDiv').removeClass('hideDiv').addClass('showDiv');
    }else{
      $('#babyDeathDateDiv').removeClass('showDiv').addClass('hideDiv');
    }
  }

  function showMotherDeathOption(val){
    if(val == "dead"){
      $('#motherDeathDateDiv').removeClass('hideDiv').addClass('showDiv');
      $('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');
    }else{
      $('#motherDeathDateDiv').removeClass('showDiv').addClass('hideDiv');

      var callstatus = $('#callStatus').val();
      //var motherCurrStatus = $('#motherCurrStatus').val();
      if(callstatus == "call_connected" && (val != "dead") && (val != "")){
        $('#hospitalExperienceDiv').removeClass('hideDiv').addClass('showDiv');
      }else{
        $('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');
      }
    }
  }

  // function showDeathOption(val,id){
  //   if(val == "dead"){ alert("aa");
  //     $('#'+id).removeClass('hideDiv').addClass('showDiv');
  //     //$('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');
  //   }else{ alert("bb");
  //     if((val != "") && (id=="motherDeathDateDiv")){ alert("cc");
  //       var callstatus = $('#callStatus').val();
  //       var motherCurrStatus = $('#motherCurrStatus').val();
  //       if(callstatus == "call_connected" && (motherCurrStatus != "dead")){
  //         $('#hospitalExperienceDiv').removeClass('hideDiv').addClass('showDiv');
  //       }else{
  //         $('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');
  //       }
        
  //     }else{ alert("dd");
  //       //$('#hospitalExperienceDiv').removeClass('showDiv').addClass('hideDiv');
  //     }

  //     $('#'+id).removeClass('showDiv').addClass('hideDiv');
  //   }
  // }
</script>
