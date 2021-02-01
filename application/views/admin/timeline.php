<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo 'Manage TimeLine'; ?>
  <!--     <a href="<?php echo base_url('facility/AddFacility/');?>" class="btn btn-info" style="float: right; padding-right: 10px;  "> Add Facility<?php #echo NEW_FACILITY ?></a> 
       <a href="<?php echo base_url('facility/facilityType/');?>" class="btn btn-success" style="float: right; padding-right: 10px; margin-right:15px  "> Manage TimeLine</a> -->

      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->FeedModel->session->flashdata('activate'); ?></div>
           <div class="" id="MDG"></div>
           <span style="font-size: 20px;">Manage Resources:</span> [<a href="" data-toggle="modal" data-target="#dfdModal">DataFlow Diagram</a>][<a href="" data-toggle="modal" data-target="#myModal">Functional Diagram</a>]
            <div class="box-body" >
              <div class="col-sm-12" style="overflow: auto;">
                
                <table class="table-striped table table-bordered example" id="example">
                <thead>
                   <tr>
                      <th>S&nbsp;No.</th>
                      <th>Lounge&nbsp;Name</th>
                      <th>Photo</th>
                      <th style="width: 300px !important;">Timeline</th>
                      <th>Timeline&nbsp;By</th>
                      <th>Birth&nbsp;Weight(gram)</th>
                      <th>Current&nbsp;Weight(gram)</th>
                      <th>Age(Days)</th>
                      <th>Likes/Comments</th>
                      <th>DateTime</th>
                   </tr>
                </thead>
                <tbody>
                 <?php 
                 $counter ="1";
                 foreach ($timelineData as $key=> $value ) {
                  $getloungeName = $this->FeedModel->db->get_where('loungeMaster',array('loungeId'=>$value['loungeId']))->row_array();

            if($value['type']=='1'){
                $getBabyAdmission           = $this->FeedModel->getBabyAdmissionData($value['grantedForId']);
                $getBabyRegistration        = $this->FeedModel->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->FeedModel->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->FeedModel->getCurrentBabyWeight($value['grantedForId']);
                $getNurseData               = $this->FeedModel->getStaffData($getMotherRegistration['staffId']);
                $babyAgeInDays              = $this->FeedModel->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->FeedModel->getLoungeData($value['loungeId']);
                
                $totalComment                = $this->FeedModel->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->FeedModel->countRows('likeDislikeMaster',$value['id'],'1');
             
                   $selfLike                    = $this->FeedModel->countLikeNew('likeDislikeMaster',1,$value['id'],1);
                /*else{
                    $selfLike                   = $this->FeedModel->countLikeNew('likeDislikeMaster',$value['loungeId'],$value['id'],$value['userType']);
                }*/
                
                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileID']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? $getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliveryType']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['image']) ? $getCurrentWeight['image'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getMotherRegistration['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = "";
                $Hold['thermoMeterImage']   = "";
                $Hold['thermometerAvail']   = "";
                $Hold['thermometerReason']  = "";
                $Hold['familyMemberSign']   = "";  
                $Hold['ashaSign']           = "";  
                $Hold['doctorSign']         = ""; 
                $Hold['dischargeDateTime']  = ""; 
                $Hold['currentNurse']       = "";
                $Hold['nextNurse']          = ""; 
                $Hold['currentNurseID']     = "";
                $Hold['nextNurseID']        = "";
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = ""; 
                $Hold['baby_weight']        = array();
                $Hold['sst_detail']         = array();  


                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 

            }else if($value['type']=='2'){
                $getBabyAdmission           = $this->FeedModel->getBabyAdmissionData($value['babyAdmissionId']);
                $getBabyRegistration        = $this->FeedModel->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->FeedModel->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->FeedModel->getCurrentBabyWeight($value['babyAdmissionId']);
                $getNurseData               = $this->FeedModel->getStaffData($getCurrentWeight['nurseId']);
                $babyAgeInDays              = $this->FeedModel->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate']))); 
                $loungeData                 = $this->FeedModel->getLoungeData($value['loungeId']);
          
                $totalComment                = $this->FeedModel->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->FeedModel->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->FeedModel->countLike('likeDislikeMaster',$value['loungeId'],$value['id']);
                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileID']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? $getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliveryType']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['image']) ? $getCurrentWeight['image'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getNurseData['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = "";
                $Hold['thermoMeterImage']   = "";
                $Hold['thermometerAvail']   = "";
                $Hold['thermometerReason']  = "";
                $Hold['familyMemberSign']   = "";  
                $Hold['ashaSign']           = "";  
                $Hold['doctorSign']         = ""; 
                $Hold['dischargeDateTime']  = ""; 
                $Hold['currentNurseID']       = "";
                $Hold['nextNurseID']          = "";
                $Hold['currentNurse']       = "";
                $Hold['nextNurse']          = ""; 
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = ""; 
                $data['loungeId']           = $getBabyAdmission['loungeId'];
                $data['babyId']             = $getBabyAdmission['babyId'];
               // weight value calculate
                $Hold['baby_weight']    = array();

                $days1 = $this->FeedModel->calculateDays($getBabyRegistration['deliveryDate']);
                 for($i = 0 ; $i < $days1 ; $i++){
                    $date = date('Y-m-d', strtotime("+".$i."day",strtotime($getBabyRegistration['deliveryDate'])));
                    $BabyWeight = $this->FeedModel->GetBabyWeight2($getBabyAdmission['babyId'],'Asc',$date,$getBabyAdmission['id']);                         
                    $baby  = array();
                    if($i=='0'){
                        $baby['day']    = '0';
                        $baby['weigth'] = $getBabyRegistration['babyWeight'];
                    }else{
                        $baby['day']    = $i;
                        $baby['weigth'] = ($BabyWeight['babyWeight']>0)? $BabyWeight['babyWeight']:'0';
                    }
                    $Hold['baby_weight'][] = $baby;                
                }

                $Hold['sst_detail']        = array();  

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
            }else if($value['type']=='3'){
                $getMonitoringData          = $this->FeedModel->getMonitoringData($value['grantedForId']);
                $getBabyAdmission           = $this->FeedModel->getBabyAdmissionData($value['babyAdmissionId']);
                $getBabyRegistration        = $this->FeedModel->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->FeedModel->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->FeedModel->getCurrentBabyWeight($value['babyAdmissionId']);
                $getNurseData               = $this->FeedModel->getStaffData($getMonitoringData ['staffId']);
                $babyAgeInDays              = $this->FeedModel->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->FeedModel->getLoungeData($value['loungeId']);
                $totalComment                = $this->FeedModel->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->FeedModel->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->FeedModel->countLike('likeDislikeMaster',$value['loungeId'],$value['id']);
                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileID']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? $getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliveryType']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['image']) ? $getCurrentWeight['image'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getMonitoringData ['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = "";
                $Hold['thermoMeterImage']   = $getMonitoringData['thermometerImage'];
                $Hold['thermometerAvail']   = $getMonitoringData['isThermometerAvailable'];
                $Hold['thermometerReason']  = $getMonitoringData['thermometerNotAvailableReason'];
                $Hold['familyMemberSign']   = "";  
                $Hold['ashaSign']           = "";  
                $Hold['doctorSign']         = ""; 
                $Hold['dischargeDateTime']  = ""; 
                $Hold['currentNurseID']       = "";
                $Hold['nextNurseID']          = "";
                $Hold['currentNurse']       = "";
                $Hold['nextNurse']          = "";  
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = ""; 
                $Hold['baby_weight']       = array();
                $Hold['sst_detail']        = array();  

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
            }else if($value['type']=='4'){
                $getMonitoringData          = $this->FeedModel->getMonitoringData($value['grantedForId']);
                $getSkinTouchData           = $this->FeedModel->getSkinTouchData($value['babyAdmissionId']);
                $getBabyAdmission           = $this->FeedModel->getBabyAdmissionData($value['babyAdmissionId']);
                $getBabyRegistration        = $this->FeedModel->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->FeedModel->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->FeedModel->getCurrentBabyWeight($value['babyAdmissionId']);
                $getNurseData               = $this->FeedModel->getStaffData($getSkinTouchData['nurseId']);
                $babyAgeInDays              = $this->FeedModel->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->FeedModel->getLoungeData($value['loungeId']);
                $totalComment                = $this->FeedModel->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->FeedModel->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->FeedModel->countLike('likeDislikeMaster',$value['loungeId'],$value['id']);
                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileID']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? $getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliveryType']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['image']) ? $getCurrentWeight['image'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getSkinTouchData['nurseId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = "";
                $Hold['thermoMeterImage']   = (!empty($getMonitoringData['thermometerImage']) ? $getMonitoringData['thermometerImage'] : '');
                $Hold['thermometerAvail']   = $getMonitoringData['isThermometerAvailable'];
                $Hold['thermometerReason']  = $getMonitoringData['thermometerNotAvailableReason'];
                $Hold['familyMemberSign']   = "";  
                $Hold['ashaSign']           = "";  
                $Hold['doctorSign']         = ""; 
                $Hold['dischargeDateTime']  = ""; 
                $Hold['currentNurseID']       = "";
                $Hold['nextNurseID']          = "";
                $Hold['currentNurse']       = "";
                $Hold['nextNurse']          = "";  
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = ""; 
                $data['loungeId']           = $getBabyAdmission['loungeId'];
                $data['babyId']             = $getBabyAdmission['babyId'];

                $Hold['baby_weight']       = array();
           
                
                $Hold['sst_detail'] = array();
                $days = $this->FeedModel->calculateDays($getBabyRegistration['deliveryDate']);

                for ($k = 0 ; $k < $days ; $k++) { 
                    $SST['day_time'] = $k;
                    $date = date('Y-m-d', strtotime("+".$k."day",strtotime($getBabyRegistration['deliveryDate'])));
                    $SSTDetail = $this->FeedModel->GetSSTDetail($data,$date,$getBabyAdmission['id']);
                    $SST['duration'] = $SSTDetail;
                    $Hold['sst_detail'][] = $SST;
                }
                //Skin to Skin Detail List  

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
            }else if($value['type']=='6'){
                $getMonitoringData          = $this->FeedModel->getMonitoringData($value['grantedForId']);
                $getBabyAdmission           = $this->FeedModel->getBabyAdmissionData($value['grantedForId']);
                $getBabyRegistration        = $this->FeedModel->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->FeedModel->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->FeedModel->getCurrentBabyWeight($value['grantedForId']);
                $getNurseData               = $this->FeedModel->getStaffData($getBabyAdmission['dischargeByNurse']);
                $babyAgeInDays              = $this->FeedModel->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->FeedModel->getLoungeData($value['loungeId']);
               
                $totalComment                = $this->FeedModel->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->FeedModel->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->FeedModel->countLike('likeDislikeMaster',$value['loungeId'],$value['id']);
                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileID']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['BabyPhoto']) ? $getBabyRegistration['BabyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliveryType']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['image']) ? $getCurrentWeight['image'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getBabyAdmission['dischargeByNurse'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = "";
                $Hold['thermoMeterImage']   = (!empty($getMonitoringData['thermometerImage']) ? $getMonitoringData['thermometerImage'] : '');
                $Hold['thermometerAvail']   = $getMonitoringData['isThermometerAvailable'];
                $Hold['thermometerReason']  = $getMonitoringData['thermometerNotAvailableReason'];
                $Hold['familyMemberSign']   = (!empty($getBabyAdmission['signOfFamilyMember']) ? signDirectoryUrl.$getBabyAdmission['signOfFamilyMember'] : '');  
                $Hold['ashaSign']           = (!empty($getBabyAdmission['ashaSign']) ? signDirectoryUrl.$getBabyAdmission['ashaSign'] : '');  
                $Hold['doctorSign']         = (!empty($getBabyAdmission['doctorSign']) ? signDirectoryUrl.$getBabyAdmission['doctorSign'] : '');  
                $Hold['dischargeDateTime']  = $getBabyAdmission['modifyDate']; 
                $Hold['currentNurseID']       = "";
                $Hold['nextNurseID']          = "";
                $Hold['currentNurse']       = "";
                $Hold['nextNurse']          = "";
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = ""; 
                $Hold['baby_weight']       = array();
                $Hold['sst_detail']        = array();

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
            }else if($value['type'] == '7'){
                $getdutyChangeData          = $this->FeedModel->dutyChangeData($value['grantedForId']);
                $getCurrentNurseName        = $this->FeedModel->getStaffData($getdutyChangeData['currentDutyNurseId']);
                $getNextNurseName           = $this->FeedModel->getStaffData($getdutyChangeData['nextDutyNurseId']);
                $loungeData                 = $this->FeedModel->getLoungeData($value['loungeId']);
                $totalComment                = $this->FeedModel->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->FeedModel->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->FeedModel->countLike('likeDislikeMaster',$value['loungeId'],$value['id']);
                $Hold['id']                 = $value['id'];
                $Hold['motherName']         = "";
                $Hold['babyId']             = "";
                $Hold['name']               = "";  
                $Hold['babyFileID']         = "";
                $Hold['babyGender']         = "";
                $Hold['babyPhoto']          = "";
                $Hold['babyBirthWeight']    = "";   
                $Hold['deliveryType']       = "";   
                $Hold['babyCurrentWeight']  = "";  
                $Hold['babyWeightImage']    = "";
                $Hold['babyAge']            = "";
                $Hold['nurseId']            = $getCurrentNurseName['staffId'];
                $Hold['nurseName']          = $getCurrentNurseName['name'];
                $Hold['nurseMobile']        = $getCurrentNurseName['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getCurrentNurseName['profilePicture'] != '') ? base_url().'assets/nurse/'.$getCurrentNurseName['profilePicture'] : '';
                $Hold['nurseAddress']       = $getCurrentNurseName['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = $getdutyChangeData['changeDutyDateTime'];
                $Hold['thermoMeterImage']   = "";
                $Hold['thermometerAvail']   = "";
                $Hold['thermometerReason']  = "";
                $Hold['familyMemberSign']   = "";  
                $Hold['ashaSign']           = "";  
                $Hold['doctorSign']         = ""; 
                $Hold['dischargeDateTime']  = "";  

                $Hold['currentNurseID']       = $getCurrentNurseName['staffId'];
                $Hold['nextNurseID']          = $getNextNurseName['staffId'];

                $Hold['currentNurse']       = $getCurrentNurseName['name'];
                $Hold['nextNurse']          = $getNextNurseName['name'];
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = imageDirectoryUrl.$getdutyChangeData['image']; 
                $Hold['baby_weight']       = array();
                $Hold['sst_detail']        = array(); 

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                  $Hold['totalRecord']        = ""; 
            }else if($value['type'] == '8'){
                $getDoctorRoundData         = $this->FeedModel->getDoctorRoundData($value['grantedForId']);
                $getNurseData               = $this->FeedModel->getStaffData($getDoctorRoundData['staffId']);
                $loungeData                 = $this->FeedModel->getLoungeData($value['loungeId']);
               
                $totalComment                = $this->FeedModel->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->FeedModel->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->FeedModel->countLike('likeDislikeMaster',$value['loungeId'],$value['id']);
               
                $Hold['id']                 = $value['id'];
                $Hold['motherName']         = "";
                $Hold['babyId']             = "";
                $Hold['name']               = "";  
                $Hold['babyFileID']         = "";
                $Hold['babyGender']         = "";
                $Hold['babyPhoto']          = "";
                $Hold['babyBirthWeight']    = "";   
                $Hold['deliveryType']       = "";   
                $Hold['babyCurrentWeight']  = "";  
                $Hold['babyWeightImage']    = "";
                $Hold['babyAge']            = "";
                $Hold['nurseId']            = $getNurseData['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = (!empty($getDoctorRoundData['staffSignature']) ? $getDoctorRoundData['staffSignature'] : '');  
                $Hold['dutyDateTime']       = $getDoctorRoundData['roundDateTime'];
                $Hold['thermoMeterImage']   = "";
                $Hold['thermometerAvail']   = "";
                $Hold['thermometerReason']  = "";
                $Hold['familyMemberSign']   = "";  
                $Hold['ashaSign']           = "";  
                $Hold['doctorSign']         = ""; 
                $Hold['dischargeDateTime']  = ""; 
                $Hold['currentNurseID']       = "";
                $Hold['nextNurseID']          = "";
                $Hold['currentNurse']       = "";
                $Hold['nextNurse']          = ""; 
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = ""; 
                $Hold['baby_weight']       = array();
                $Hold['sst_detail']        = array(); 

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
            }
     
         
                   ?>
                   <tr>
                     <td><?php echo $counter; ?></td>
                     <td><a href="<?php echo base_url() ?>/loungeM/updateLounge/<?php echo $value['loungeId']; ?>"><?php echo $getloungeName['loungeName']; ?></a></td>
                     <td>
                        <?php if($value['type'] == '2')
                        { 
                     
                        if(!empty($Hold['babyWeightImage'])) { ?>
                            <img src="<?php echo motherDirectoryUrl.$Hold['babyWeightImage']; ?>" width="300" height="220">
                            <?php } else { echo '--'; }
                        }  else { 

                            if(!empty($Hold['babyPhoto'])) { ?>
                            <img src="<?php echo babyDirectoryUrl.$Hold['babyPhoto']; ?>" width="300" height="220">
                            <?php } else { echo '--'; }
                             } ?>
                    </td>
                     <td style="width: 300px !important;"><?php echo $value['feed']; ?></td>
                     <td><?php echo !empty($Hold['nurseName']) ? $Hold['nurseName'] : '--' ; ?></td>
                     <td><?php echo empty($Hold['babyBirthWeight']) ? '--' : $Hold['babyBirthWeight']; ?></td>
                     <td><?php echo empty($Hold['babyCurrentWeight']) ? '--' : $Hold['babyCurrentWeight']; ?></td>
                     <td><?php echo empty($Hold['babyAge']) ? '--' : $Hold['babyAge']; ?></td>
                
                   
                     <td><?php echo empty($Hold['totalLike']) ? 'NA' : '<a href="'.base_url().'smsM/likeList/'.$value['id'].'">'.$Hold['totalLike'].'</a>'; ?>/<?php echo empty($Hold['totalComment']) ? 'NA' : '<a href="'.base_url().'smsM/commentList/'.$value['id'].'">'.$Hold['totalComment'].'</a>'; ?></td>
                    
                     <td><?php echo date("d-m-Y g:i A", strtotime($value['addDate']));?></td>

                  </tr>
                  <?php $counter ++ ; } ?>
                </tbody>
               </table>
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



  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TimeLine Functional Diagram</h4>
        </div>
        <div class="modal-body  text-center">
            <h3>Coming Soon...</h3><br>
          <!-- <img src="<?php //echo base_url('assets/dfdAndFunctionalDiagram/ManageFacilities.png') ;?>" style="height:500px;width:100%;"> -->
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="dfdModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">TimeLine DataFlow Diagram (DFD)</h4>
        </div>
        <div class="modal-body text-center" style="padding:0px !important;">
          <!-- <img src="<?php //echo base_url('assets/dfdAndFunctionalDiagram/facilitydfd.png') ;?>" style="height:598px;width:100%;"> -->
          <h3>Coming Soon...</h3><br>
        </div>
      </div>
      
    </div>
  </div>


