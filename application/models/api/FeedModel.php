<?php
class FeedModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        date_default_timezone_set("Asia/KolKata");
    }
    // get timeline or feed data via lounge id
    public function getTimelineDataViaLounge($request)
    {
        if($request['userType'] == '0'){
         $request['loungeId'] = $request['loungeId'];
        }else{
            $staffId = $request['loungeId'];
            $loungeData          = getStaffLoungeId($request['loungeId']); // call function using api_helper
            $request['loungeId'] = $loungeData['loungeId'];
        }

        $getAllDataWithStatus          = $this->getFeedHistoryViaLounge($request['loungeId'],$request['timestamp'],$request['offset']);
        $getFollowingData = $this->db->get_where('followUnfollow',array('loungeId'=>$request['loungeId'],'status'=>1))->result_array();
        $arrayName        = array();
      
        foreach ($getAllDataWithStatus as $key => $value) {
            $Hold                   = array();
            $Hold['grantedForId']   = $value['grantedForId'];
            $Hold['feed']           = $value['feed'];
            $Hold['status']         = $value['status'];
            $Hold['type']           = $value['type'];
            $Hold['loungePic']          = ""; 
            $Hold['dutyTimeLoungePic']          = ""; 
            $Hold['thermometerAvail']          = ""; 

            if($value['type']=='1'){
                $getBabyAdmission           = $this->getBabyAdmissionData($value['grantedForId']);
                $getBabyRegistration        = $this->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->getCurrentbabyWeight($value['grantedForId']);
                $getNurseData               = $this->getStaffData($getMotherRegistration['staffId']);
                $babyAgeInDays              = $this->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->getLoungeData($value['loungeId']);
                
                $totalComment                = $this->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->countRows('likeDislikeMaster',$value['id'],'1');
                if($request['userType'] == '1'){
                   $selfLike                    = $this->countLikeNew('likeDislikeMaster',$staffId,$value['id'],$request['userType']);
                }else{
                    $selfLike                   = $this->countLikeNew('likeDislikeMaster',$request['loungeId'],$value['id'],$request['userType']);
                }
                
                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileId']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? babyDirectoryUrl.$getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliverytype']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['babyWeightImage']) ? babyWeightDirectoryUrl.$getCurrentWeight['babyWeightImage'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getMotherRegistration['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['babyWeight']         = array();
                $Hold['sstDetail']         = array();  


                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
                $Hold['syncDateTime']       = $getBabyAdmission['addDate']; 

            }else if($value['type']=='2'){
                $getBabyAdmission           = $this->getBabyAdmissionData($value['babyAdmissionId']);
                $getBabyRegistration        = $this->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->getCurrentbabyWeight($value['babyAdmissionId']);
                $getNurseData               = $this->getStaffData($getCurrentWeight['nurseId']);
                $babyAgeInDays              = $this->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate']))); 
                $loungeData                 = $this->getLoungeData($value['loungeId']);
          
                $totalComment                = $this->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->countRows('likeDislikeMaster',$value['id'],'1');
                $lastSyncTime                = $this->getLastSyncTime('babyDailyWeight',$value['loungeId'],'id',$value['grantedForId']);
                $selfLike                    = $this->countLike('likeDislikeMaster',$request['loungeId'],$value['id']);



                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileId']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? babyDirectoryUrl.$getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliverytype']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['babyWeightImage']) ? babyWeightDirectoryUrl.$getCurrentWeight['babyWeightImage'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getNurseData['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $data['loungeId']           = $getBabyAdmission['loungeId'];
                $data['babyId']             = $getBabyAdmission['babyId'];
               // weight value calculate
                $Hold['babyWeight']    = array();

                $days1 = calculateDays($getBabyRegistration['deliveryDate']);
                 for($i = 0 ; $i < $days1 ; $i++){
                    $date = date('Y-m-d', strtotime("+".$i."day",strtotime($getBabyRegistration['deliveryDate'])));
                    $babyWeight = $this->BabyModel->babyWeightViaDate($getBabyAdmission['babyId'],'Asc',$date,$getBabyAdmission['id']);                         
                    $baby  = array();
                    if($i=='0'){
                        $baby['day']    = '0';
                        $baby['weigth'] = $getBabyRegistration['babyWeight'];
                    }else{
                        $baby['day']    = $i;
                        $baby['weigth'] = ($babyWeight['babyWeight']>0)? $babyWeight['babyWeight']:'0';
                    }
                    $Hold['babyWeight'][] = $baby;                
                }

                $Hold['sstDetail']        = array();  

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
                $Hold['syncDateTime']       = $lastSyncTime['lastSyncedTime']; 
            }else if($value['type']=='3'){
                $getMonitoringData          = $this->getMonitoringData($value['grantedForId']);
                $getBabyAdmission           = $this->getBabyAdmissionData($value['babyAdmissionId']);
                $getBabyRegistration        = $this->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->getCurrentbabyWeight($value['babyAdmissionId']);
                $getNurseData               = $this->getStaffData($getMonitoringData ['staffId']);
                $babyAgeInDays              = $this->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->getLoungeData($value['loungeId']);
                $totalComment               = $this->countRows('timelineComment',$value['id']);
                $totalLike                  = $this->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                   = $this->countLike('likeDislikeMaster',$request['loungeId'],$value['id']);
                $lastSyncTime               = $this->getLastSyncTime('babyDailyMonitoring',$value['loungeId'],'id',$value['grantedForId']);
                $Hold['id']                 = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileId']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? babyDirectoryUrl.$getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliverytype']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['babyWeightImage']) ? babyWeightDirectoryUrl.$getCurrentWeight['babyWeightImage'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getMonitoringData ['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['thermometerImage']   = babyTemperaturetDirectoryUrl.$getMonitoringData['thermometerImage'];
                $Hold['thermometerAvail']   = $getMonitoringData['isThermometerAvailable'];
                $Hold['thermometerNotAvailableReason']  = $getMonitoringData['thermometerNotAvailableReason'];
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['babyWeight']       = array();
                $Hold['sstDetail']        = array();  

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
                $Hold['syncDateTime']       = $lastSyncTime['lastSyncedTime']; 
            }else if($value['type']=='4'){
                $getMonitoringData          = $this->getMonitoringData($value['grantedForId']);
                $getSkinTouchData           = $this->getSkinTouchData($value['babyAdmissionId']);
                $getBabyAdmission           = $this->getBabyAdmissionData($value['babyAdmissionId']);
                $getBabyRegistration        = $this->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->getCurrentbabyWeight($value['babyAdmissionId']);
                $getNurseData               = $this->getStaffData($getSkinTouchData['nurseId']);
                $babyAgeInDays              = $this->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->getLoungeData($value['loungeId']);
                $totalComment               = $this->countRows('timelineComment',$value['id']);
                $totalLike                  = $this->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                   = $this->countLike('likeDislikeMaster',$request['loungeId'],$value['id']);
                $lastSyncTime               = $this->getLastSyncTime('babyDailyKMC',$value['loungeId'],'id',$value['grantedForId']);

                $Hold['id']                 = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileId']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? babyDirectoryUrl.$getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliverytype']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['babyWeightImage']) ? babyWeightDirectoryUrl.$getCurrentWeight['babyWeightImage'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getSkinTouchData['nurseId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = "";
                $Hold['thermometerImage']   = (!empty($getMonitoringData['thermometerImage']) ? babyTemperaturetDirectoryUrl.$getMonitoringData['thermometerImage'] : '');
                $Hold['thermometerAvail']   = $getMonitoringData['isThermometerAvailable'];
                $Hold['thermometerNotAvailableReason']  = $getMonitoringData['thermometerNotAvailableReason'];
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

                $Hold['babyWeight']       = array();
           
                
                $Hold['sstDetail'] = array();
                $days = calculateDays($getBabyRegistration['deliveryDate']);

                for ($k = 0 ; $k < $days ; $k++) { 
                    $SST['day_time'] = $k;
                    $date = date('Y-m-d', strtotime("+".$k."day",strtotime($getBabyRegistration['deliveryDate'])));
                    $SSTDetail = $this->BabyModel->getKMCDataViaDate($data,$date,$getBabyAdmission['id']);
                    $SST['duration'] = $SSTDetail;
                    $Hold['sstDetail'][] = $SST;
                }
                //Skin to Skin Detail List  

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
                $Hold['syncDateTime']       = $lastSyncTime['lastSyncedTime']; 
            }else if($value['type']=='6'){
                $getMonitoringData          = $this->getMonitoringData($value['grantedForId']);
                $getBabyAdmission           = $this->getBabyAdmissionData($value['grantedForId']);
                $getBabyRegistration        = $this->getBabyRegistrationData($getBabyAdmission['babyId']);
                $getMotherRegistration      = $this->getMotherRegistrationData($getBabyRegistration['motherId']);
                $getCurrentWeight           = $this->getCurrentbabyWeight($value['grantedForId']);
                $getNurseData               = $this->getStaffData($getBabyAdmission['dischargeByNurse']);
                $babyAgeInDays              = $this->calculateDays(date("Y-m-d",strtotime($getBabyRegistration['deliveryDate'])));
                $loungeData                 = $this->getLoungeData($value['loungeId']);
               
                $totalComment                = $this->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->countLike('likeDislikeMaster',$request['loungeId'],$value['id']);
                $Hold['id']                = $value['id'];
                $Hold['motherName']         = !empty($getMotherRegistration['motherName']) ? $getMotherRegistration['motherName'] : 'UNKNOWN';
                $Hold['babyId']             = $getBabyAdmission['babyId'];
                $Hold['name']               = (!empty($getMotherRegistration['motherName']) ? "B/O ".$getMotherRegistration['motherName'] : 'B/O UNKNOWN');  
                $Hold['babyFileId']         = $getBabyAdmission['babyFileId'];
                $Hold['babyGender']         = $getBabyRegistration['babyGender'];
                $Hold['babyPhoto']          = (!empty($getBabyRegistration['babyPhoto']) ? babyDirectoryUrl.$getBabyRegistration['babyPhoto'] : '');
                $Hold['babyBirthWeight']    = $getBabyRegistration['babyWeight'];   
                $Hold['deliverytype']       = $getBabyRegistration['deliveryType'];   
                $Hold['babyCurrentWeight']  = $getCurrentWeight['babyWeight'];  
                $Hold['babyWeightImage']    = (!empty($getCurrentWeight['babyWeightImage']) ? babyWeightDirectoryUrl.$getCurrentWeight['babyWeightImage'] : '');
                $Hold['babyAge']            = substr($babyAgeInDays, 1);
                $Hold['nurseId']            = $getBabyAdmission['dischargeByNurse'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = "";
                $Hold['thermometerImage']   = (!empty($getMonitoringData['thermometerImage']) ? babyTemperaturetDirectoryUrl.$getMonitoringData['thermometerImage'] : '');
                $Hold['thermometerAvail']   = $getMonitoringData['isThermometerAvailable'];
                $Hold['thermometerNotAvailableReason']  = $getMonitoringData['thermometerNotAvailableReason'];
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
                $Hold['babyWeight']       = array();
                $Hold['sstDetail']        = array();

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
                $Hold['syncDateTime']       = $getBabyAdmission['addDate']; 
            }else if($value['type'] == '7'){
                $getdutyChangeData          = $this->dutyChangeData($value['grantedForId']);
                $getCurrentNurseName        = $this->getStaffData($getdutyChangeData['nurseId']);
                //$getNextNurseName           = $this->getStaffData($getdutyChangeData['nextDutyNurseId']);
                $loungeData                 = $this->getLoungeData($value['loungeId']);
                $totalComment               = $this->countRows('timelineComment',$value['id']);
                $totalLike                  = $this->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                   = $this->countLike('likeDislikeMaster',$request['loungeId'],$value['id']);
                $lastSyncTime               = $this->getLastSyncTime('nurseDutyChange',$value['loungeId'],'id',$value['grantedForId']);
                //type 1 for checkin and 2 is checkout
                   if($getdutyChangeData['type'] == '1'){
                     $loungePic = !empty($getdutyChangeData['image']) ? loungeDirectoryUrl.$getdutyChangeData['image'] : '';
                     $dateTime  = !empty($getdutyChangeData['addDate']) ? $getdutyChangeData['addDate'] : '';
                   }else{
                     $loungePic = !empty($getdutyChangeData['loungePicCheckOut']) ? loungeDirectoryUrl.$getdutyChangeData['loungePicCheckOut'] : '';
                     $dateTime  = !empty($getdutyChangeData['checkoutTime']) ? $getdutyChangeData['checkoutTime'] : '';
                   }

                $Hold['id']                 = $value['id'];
                $Hold['motherName']         = "";
                $Hold['babyId']             = "";
                $Hold['name']               = "";  
                $Hold['babyFileId']         = "";
                $Hold['babyGender']         = "";
                $Hold['babyPhoto']          = "";
                $Hold['babyBirthWeight']    = "";   
                $Hold['deliverytype']       = "";   
                $Hold['babyCurrentWeight']  = "";  
                $Hold['babyWeightImage']    = "";
                $Hold['babyAge']            = "";
                $Hold['nurseId']            = $getCurrentNurseName['staffId'];
                $Hold['nurseName']          = $getCurrentNurseName['name'];
                $Hold['nurseMobile']        = $getCurrentNurseName['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getCurrentNurseName['profilePicture'] != '') ? base_url().'assets/nurse/'.$getCurrentNurseName['profilePicture'] : '';
                $Hold['nurseAddress']       = $getCurrentNurseName['staffAddress'];
                $Hold['staff_signature']    = "";  
                $Hold['dutyDateTime']       = $dateTime;
                $Hold['thermometerImage']   = "";
                $Hold['thermometerAvail']   = "";
                $Hold['thermometerNotAvailableReason']  = "";
                $Hold['familyMemberSign']   = "";  
                $Hold['ashaSign']           = "";  
                $Hold['doctorSign']         = ""; 
                $Hold['dischargeDateTime']  = "";  

                $Hold['currentNurseId']       = $getCurrentNurseName['staffId'];
                //$Hold['nextNurseID']          = $getNextNurseName['staffId'];

                $Hold['currentNurse']       = $getCurrentNurseName['name'];
                //$Hold['nextNurse']          = $getNextNurseName['name'];
                $Hold['loungeId']           = $loungeData['loungeId']; 
                $Hold['loungeName']         = $loungeData['loungeName']; 
                $Hold['loungePic']          = ""; 
                $Hold['dutyTimeLoungePic']  = $loungePic; 
                $Hold['babyWeight']       = array();
                $Hold['sstDetail']        = array(); 

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
                $Hold['syncDateTime']       = $lastSyncTime['lastSyncedTime']; 
            }else if($value['type'] == '8'){
                $getDoctorRoundData         = $this->getDoctorRoundData($value['grantedForId']);
                $getNurseData               = $this->getStaffData($getDoctorRoundData['staffId']);
                $loungeData                 = $this->getLoungeData($value['loungeId']);
               
                $totalComment                = $this->countRows('timelineComment',$value['id']);
                $totalLike                   = $this->countRows('likeDislikeMaster',$value['id'],'1');
                $selfLike                    = $this->countLike('likeDislikeMaster',$request['loungeId'],$value['id']);
                $lastSyncTime               = $this->getLastSyncTime('doctorRound',$value['loungeId'],'id',$value['grantedForId']);
                $Hold['id']                 = $value['id'];
                $Hold['motherName']         = "";
                $Hold['babyId']             = "";
                $Hold['name']               = "";  
                $Hold['babyFileId']         = "";
                $Hold['babyGender']         = "";
                $Hold['babyPhoto']          = "";
                $Hold['babyBirthWeight']    = "";   
                $Hold['deliverytype']       = "";   
                $Hold['babyCurrentWeight']  = "";  
                $Hold['babyWeightImage']    = "";
                $Hold['babyAge']            = "";
                $Hold['nurseId']            = $getNurseData['staffId'];
                $Hold['nurseName']          = $getNurseData['name'];
                $Hold['nurseMobile']        = $getNurseData['staffMobileNumber'];
                $Hold['nursePhoto']         = ($getNurseData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getNurseData['profilePicture'] : '';
                $Hold['nurseAddress']       = $getNurseData['staffAddress'];
                $Hold['staff_signature']    = (!empty($getDoctorRoundData['staffSignature']) ? babyDirectoryUrl.$getDoctorRoundData['staffSignature'] : '');  
                $Hold['dutyDateTime']       = $getDoctorRoundData['roundDateTime'];
                $Hold['thermometerImage']   = "";
                $Hold['thermometerAvail']   = "";
                $Hold['thermometerNotAvailableReason']  = "";
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
                $Hold['babyWeight']       = array();
                $Hold['sstDetail']        = array(); 

                $Hold['totalLike']          = $totalLike; 
                $Hold['totalComment']       = $totalComment; 
                $Hold['selfLike']           = $selfLike; 
                $Hold['totalRecord']        = ""; 
                $Hold['syncDateTime']       = $lastSyncTime['lastSyncedTime']; 
            }
            $Hold['dateTime']          = $value['addDate'];
            $arrayName[]               = $Hold;
        }  

          $hold1        =   array(); 
          foreach ($getFollowingData as $key => $val) {
            $getLounge = $this->getLoungeData($val['followingLoungeID']);
            $field2['followingLoungeID']       = $val['followingLoungeID'];
            $field2['loungeName']              = $getLounge['loungeName'];
            $field2['status']                  = $val['status'];                
            $field2['dateTime']                = $val['addDate'];
            $hold1[]                           = $field2;
           }


            $response['followingData']  = $hold1;
            $response['timeLineData']   = $arrayName;
            $response['result_found']   = count($getAllDataWithStatus);
            $response['offset']         = count($getAllDataWithStatus)+$request['offset'];
            //$response['md5Data']       = createMd5OfString($response['timeLineData']);
        if(count($response['timeLineData']) > 0)
         {
            generateServerResponse('1','S', $response);
         }else{
            generateServerResponse('0','E');
         }
    }           

    public function getFeedHistoryViaLounge($loungeId,$timestamp,$offset) {
        $limit = 50;
        $offsetvalue = ($offset!='') ? $offset : 0;
        if($timestamp != ""){
            return $this->db->query("SELECT * FROM timeline WHERE loungeId = ".$loungeId." and addDate >= ".$timestamp." ORDER BY id DESC LIMIT ".$offsetvalue.", ".$limit."")->result_array();
        }else{
            return $this->db->query("SELECT * FROM timeline WHERE loungeId = ".$loungeId." ORDER BY id DESC LIMIT ".$offsetvalue.", ".$limit."")->result_array();
        }
    }

    public function getBabyAdmissionData($admissionId) {
        return $this->db->get_where('babyAdmission',array('id'=>$admissionId))->row_array();
    }

    public function getBabyRegistrationData($babyId) {
        return $this->db->get_where('babyRegistration',array('babyId'=>$babyId))->row_array();
    }

    public function getMotherRegistrationData($motherId) {
        return $this->db->get_where('motherRegistration',array('motherId'=>$motherId))->row_array();
    }

    public function getCurrentbabyWeight($admissionId) {
        $this->db->order_by('id','desc');
        return $this->db->get_where('babyDailyWeight',array('babyAdmissionId'=>$admissionId))->row_array();
    }
    public function getStaffData($staffId) {
        return $this->db->get_where('staffMaster',array('staffId'=>$staffId))->row_array();
    }
    public function getMonitoringData($monitoringId) {
        return $this->db->get_where('babyDailyMonitoring',array('id'=>$monitoringId))->row_array();
    }
    public function getSkinTouchData($skinTouchId) {
        $this->db->order_by('id','desc');
        return $this->db->get_where('babyDailyKMC',array('babyAdmissionId'=>$skinTouchId))->row_array();
    }
    public function dutyChangeData($dutyChangeId) {
        return $this->db->get_where('nurseDutyChange',array('id'=>$dutyChangeId))->row_array();
    }  
    public function getDoctorRoundData($doctorRoundID) {
        return $this->db->get_where('doctorRound',array('id'=>$doctorRoundID))->row_array();
    }  
    public function getLoungeData($loungeId) {
        return $this->db->get_where('loungeMaster',array('loungeId'=>$loungeId))->row_array();
    }        

     public function calculateDays($birthDate) {
       // $date1=date_create("2013-03-15");
        $currentDate = date("Y-m-d");
        $date1 = date_create($birthDate);
        $date2 = date_create($currentDate);
        $diff=date_diff($date1,$date2);
        return $diff->format("%R%a");
    }    

    public function countRows($table,$loungeId,$type='') {
        if($type != ""){
          return $this->db->query("select * from ".$table." where timelineId = ".$loungeId." and type='1'")->num_rows();
        }else{
          return $this->db->query("select * from ".$table." where timelineId = ".$loungeId."")->num_rows();
        }
    }
    public function countLike($table,$loungeId,$timelineId) {
     return $this->db->query("select * from ".$table." where loungeId = ".$loungeId." and type='1' and timelineId=".$timelineId."")->num_rows();
    }
    // check via staff or lounges
    public function countLikeNew($table,$loungeId,$timelineId,$type) {
      return $this->db->query("select * from ".$table." where loungeId = ".$loungeId." and type='1' and timelineId=".$timelineId." and userType=".$type."")->num_rows();
    }
    
    public function getLastSyncTime($table,$loungeId,$colName,$id) {
      return $this->db->query("select * from ".$table." where ".$colName."=".$id."")->row_array();
    }

}