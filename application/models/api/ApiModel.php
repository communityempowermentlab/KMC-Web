<?php
class ApiModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->database();
            date_default_timezone_set("Asia/KolKata");

        $this->email->initialize(array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'noreply@celworld.org',
            'smtp_pass' => 'Community#2050',
            'mailtype' => 'html',
            'wordwrap' => TRUE,
            'smtp_port' => 465,
            'crlf'      => "\r\n", 
            'smtp_crypto'  => 'ssl',
            'newline'   => "\r\n"
        ));
    }

    //Get all Staff Data via Lounge Id
    public function getStaff($request)
    {
        $GETDATA = $this
            ->db
            ->select('facilityId')
            ->get_where('loungeMaster', array(
            'loungeId' => $request['loungeId']
        ))->row_array();
            
        $GetFailityId = getSingleRowFromTable('facilityId', 'facilityId', $GETDATA['facilityId'], 'facilitylist');
        /*echo ; exit;*/
        if ($request['timestamp'] != '')
        {
            $this
                ->db
                ->order_by('modifyDate', 'DESC');
            return $this
                ->db
                ->get_where('staffMaster', array(
                'facilityId' => $GetFailityId,
                'modifyDate >=' => $request['timestamp'],
                'status' => 1
            ))->result_array();
        }
        else
        {

            $this
                ->db
                ->order_by('modifyDate', 'DESC');
            return $this
                ->db
                ->get_where('staffMaster', array(
                'facilityId' => $GetFailityId,
                'status' => 1
            ))->result_array();

        }
    }

    public function getAshaDetail($request)
    {
        $this
            ->db
            ->select('recId');
        $this
            ->db
            ->select('ashaId');
        $this
            ->db
            ->select('ashaName');
        $this
            ->db
            ->select('ashaMobileNumber1');
        $this
            ->db
            ->select('ashaBlockName');
        $this
            ->db
            ->order_by('ashaName', 'ASC');
        return $this
            ->db
            ->get_where('ashaProfiling', array(
            'ashaBlockName' => $request['blockName']
        ))->result_array();

        /*"SELECT * FROM  ashaProfiling where  ashaBlockName = ".$request['blockName']."  "*/
    }

    //Lounge Login via id and Password with Unique IMEI number
    public function loungeLogin($request)
    {
        $loungeId = $request['loungeId'];
        $loungePassword = md5($request['loungePassword']);
        $loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $loungeId,
            'loungePassword' => $loungePassword,
            'status' => '1'
        ));

        /*$loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $loungeId,
            'loungePassword' => $loungePassword,
            'status' => '1',
            'imeiNumber' => $request['imeiNumber']
        ));*/

        if ($loungeData->num_rows() != 0)
        {
            $loginMasterData = array();
            $loginMasterData['loungeMasterId'] = $request['loungeId'];
            $loginMasterData['deviceId'] = $request['deviceId'];
            $loginMasterData['latitude'] = $request['latitude'];
            $loginMasterData['longitude'] = $request['longitude'];
            $loginMasterData['fcmId'] = $request['fcmId'];
            $loginMasterData['loginTime'] = date('Y-m-d H:i:s');

            $this
                ->db
                ->insert('loginMaster', $loginMasterData);
            $loginId = $this
                ->db
                ->insert_id();
            $loungeDetail = $loungeData->row_array();
            $array['loginId'] = $loginId;
            $array['facilityId'] = $loungeDetail['facilityId'];
            $array['facilityName'] = getSingleRowFromTable('facilityName', 'facilityId', $loungeDetail['facilityId'], 'facilitylist');
            return $array;
        }
        else
        {
            return 0;
        }
    }

    //generate token code
    public function generateToken($request)
    {
        $loungeId = $request['loungeId'];
        $loungePassword = md5($request['loungePassword']);
        $loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $loungeId,
            'loungePassword' => $loungePassword,
            'status' => '1'
        ));
        //echo $loungeData->num_rows(); exit;
        if ($loungeData->num_rows() != 0)
        {
            $verifyUserData = $loungeData->row_array();
            //$userToken      = generateUniqueCode().'&!$@#';
            $userToken = md5($loungeId . $loungePassword);
            $this
                ->db
                ->where('loungeId', $verifyUserData['loungeId']);
            $updateQuery = $this
                ->db
                ->update('loungeMaster', array(
                'token' => $userToken
            ));
            if ($updateQuery > 0)
            {
                $param['token'] = $userToken;
                generateServerResponse('1', 'S', $param);
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }

    }

   

    public function LoungeDetail($request = '')
    {
        return $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $request['loungeId'],
            'status !=' => '2'
        ))->result_array();
    }

    public function allLounge($resquest)
    {
        if ($resquest['timestamp'] != '')
        {
            $this
                ->db
                ->order_by('loungeName', 'asc');
            return $this
                ->db
                ->get_where('loungeMaster', array(
                'status' => '1',
                'modifyDate >=' => $resquest['timestamp']
            ))->result_array();
        }
        else
        {
            $this
                ->db
                ->order_by('loungeName', 'asc');
            return $this
                ->db
                ->get_where('loungeMaster', array(
                'status' => '1'
            ))
                ->result_array();

        }

    }

    public function GetCounsellingPoster($resquest)
    {
        if ($resquest['timestamp'] != '')
        {
            $this
                ->db
                ->order_by('id', 'asc');
            return $this
                ->db
                ->get_where('counsellingMaster', array(
                'videoType' => 3,
                'modifyDate >=' => $resquest['timestamp']
            ))->result_array();
        }
        else
        {
            $this
                ->db
                ->order_by('id', 'asc');
            return $this
                ->db
                ->get_where('counsellingMaster', array(
                'videoType' => 3
            ))
                ->result_array();

        }

    }

    public function LoungeMonitoring($request)
    {
        //print_r($request); exit;
        $request['status'] = '1';
        $request['addDate'] = date('Y-m-d H:i:s');
        
        $insert = $this
            ->db
            ->insert('lounge_monitoring', $request);
        return $insert;
    }

   
    public function GetAshaViaTimestamp()
    {
        $this->db->order_by('recId','DESC');
        return $this->db->get_where('ashaProfiling')->result_array();
    }

    public function TestDate($date1)
    {
        $now = time();
        $your_date = strtotime($date1);
        $datediff = $now - $your_date;
        return round($datediff / (60 * 60 * 24));
    }
   
   
    // code for logout app
    public function loungeLogout($request)
    {
        $this
            ->db
            ->where('id', $request['loginId']);
        $this
            ->db
            ->update('loginMaster', array(
            'status' => 2,
            'logoutTime' => date('Y-m-d H:i:s')
        ));

        $array['loginId'] = $request['loginId'];
        $array['status'] = "2";
        generateServerResponse('1', '214', $array);
    }


    //Used
    public function checkImei($request)
    {

        /*$query = $this
            ->db
            ->get_where('loungeMaster', array(
            'imeiNumber' => $request['imeiNumber'],
            'status' => 1
        ));*/

        $query = $this
            ->db
            ->get_where('loungeMaster', array(
            'status' => 1
        ));
        $checkImeiNumber = $query->num_rows();
        $loungeData = $query->row_array();
        if ($checkImeiNumber > 0)
        {
            $array['status'] = 1;
            generateServerResponse('1', 'S', $array);
        }
        else
        {
            generateServerResponse('0', '215');
        }

    }


    // staff Login code here
    public function staffLogin($request)
    {
        $pass = md5($request['password']);
        $verify = $this
            ->db
            ->get_where('staffMaster', array(
            'staffMobileNumber' => $request['mobileNumber'],
            'staffPassword' => $pass,
            'status' => '1'
        ));

        $getData = $verify->row_array();
        if ($verify->num_rows() != 0)
        {
            //echo "aaa"; exit;
            $getLoungeID = $this
                ->db
                ->get_where('loungeMaster', array(
                'facilityId' => $getData['facilityId']
            ))->row_array();
                
            $getFacility = $this
                ->db
                ->get_where('facilitylist', array(
                'facilityId' => $getData['facilityId']
            ))->row_array();
            $loginMasterData = array();
            $loginMasterData['loungeMasterId'] = $getData['staffId'];
            $loginMasterData['deviceId'] = $request['deviceId'];
            $loginMasterData['fcmId'] = $request['fcmId'];
            $loginMasterData['token'] = md5($getData['staffId'] . $request['deviceId']);
            $loginMasterData['type'] = 3; // for doctor or staff
            $loginMasterData['loginTime']  = date('H:i:s');

            $this
                ->db
                ->insert('loginMaster', $loginMasterData);
            $loginId = $this
                ->db
                ->insert_id();
                
            $GetJobtype = $this
                ->db
                ->query("select * from masterData where id=" . $getData['jobType'] . "")->row_array();
                
            $GetStafftype = $this
                ->db
                ->query("select * from staffType where staffTypeId=" . $getData['staffType'] . "")->row_array();
                
            $GetStaffSubtype = $this
                ->db
                ->query("select * from staffType where staffTypeId=" . $getData['staffSubType'] . "")->row_array();

            $arrayName = array();
            $arrayName['loginId'] = $loginId;
            $arrayName['staffId'] = $getData['staffId'];
            $arrayName['loungeId'] = $getLoungeID['loungeId'];
            $arrayName['loungeName'] = $getLoungeID['loungeName'];
            $arrayName['token'] = $loginMasterData['token'];
            $arrayName['name'] = $getData['name'];
            $arrayName['facilityId'] = $getData['facilityId'];
            $arrayName['facilityName'] = $getFacility['FacilityName'];
            $arrayName['staffSubTypeId'] = $getData['staffSubType'];
            $arrayName['staffType'] = $GetStafftype['staffTypeNameEnglish'];
            $arrayName['staffTypeId'] = $getData['staffType'];
            $arrayName['staffSubType'] = $GetStaffSubtype['staffTypeNameEnglish'];
            $arrayName['jobType'] = $GetJobtype['name'];
            $arrayName['profilePicture'] = ($getData['profilePicture'] != '') ? base_url() . 'assets/nurse/' . $verify['profilePicture'] : '';
            $arrayName['staffMobileNumber'] = $getData['staffMobileNumber'];
            $arrayName['emergencyContactNumber'] = $getData['emergencyContactNumber'];
            $arrayName['staffAddress'] = $getData['staffAddress'];
            $arrayName['addDate'] = $getData['addDate'];
            return $arrayName;
        }
        else
        {
            return 0;
        }
    }

    // get master tests records
    public function GetMasterTest($request = '')
    {
        return $this
            ->db
            ->get_where('investigation_master', array(
            'status' => '1'
        ))
            ->result_array();
    }

    public function PostNurseKnowledge($request)
    {
        $countData = count($request['nurseKnowledgeData']);
        if ($countData > 0)
        {
            $param1 = array();
            $arrayName = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['nurseKnowledgeData'] as $key => $val)
            {
                $arrayName['nurseId'] = $val['nurser_id'];

                $arrayName['doctorId'] = $val['doctorId'];

                $arrayName['loungeId'] = $val['loungeId'];
                $arrayName['type'] = $val['type'];
                $arrayName['ConfirmationStatus'] = $val['confirmation_status'];
                $arrayName['ActionTaken'] = $val['action_taken'];

                $arrayName['Message'] = $val['message'];
                $arrayName['QuestionID'] = $val['question_id'];
                $arrayName['androidUuid'] = $val['localId'];
                $arrayName['status'] = '1';

                $arrayName['modifyDate']  = date('Y-m-d H:i:s');

                $checkDuplicateData = $this
                    ->db
                    ->get_where('nurse_knowledge_device_avaiability', array(
                    'androidUuid' => $val['localId']
                ))->num_rows();
                if ($checkDuplicateData > 0)
                {
                    $checkDataForAllUpdate = 2;
                    $this
                        ->db
                        ->where('androidUuid', $val['localId']);
                    $this
                        ->db
                        ->update('nurse_knowledge_device_avaiability', $arrayName);

                    $lastID = $this
                        ->db
                        ->get_where('nurse_knowledge_device_avaiability', array(
                        'androidUuid' => $val['localId']
                    ))->row_array();
                    $listID['id'] = $lastID['id'];
                    $listID['localId'] = $val['localId'];
                    $param1[] = $listID;

                }
                else
                {
                    $arrayName['addDate']  = date('Y-m-d H:i:s');

                    $inserted = $this
                        ->db
                        ->insert('nurse_knowledge_device_avaiability', $arrayName);
                    $lastID = $this
                        ->db
                        ->insert_id();
                    $listID['id'] = $lastID;
                    $listID['localId'] = $val['localId'];
                    $param1[] = $listID;
                }

            }
        }

        if ($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2)
        {
            $data['id'] = $param1;
            generateServerResponse('1', 'S', $data);
        }
        else
        {
            generateServerResponse('0', '213');
        }

    }

    // post stuck data 
    public function PostStuckData($request){
        $countData = count($request['stuckData']);
        if ($countData > 0)
        {
            $param1 = array();
            $arrayName = array();
            $notification = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['stuckData'] as $key => $val)
            {
                $arrayName['loungeId']  = ($val['loungeId'] != '') ? $val['loungeId'] : NULL; 

                $arrayName['latitude']  = ($val['latitude'] != '') ? $val['latitude'] : NULL; 
                $arrayName['longitude'] = ($val['longitude'] != '') ? $val['longitude'] : NULL; 
                $arrayName['location']  = ($val['location'] != '') ? $val['location'] : NULL; 
                
               
                $arrayName['androidUuid']   = $val['localId'];
                $arrayName['status']        = '1';
                $arrayName['addDate']       = $val['localDateTime'];
                $arrayName['modifyDate']    = $val['localDateTime'];
                $arrayName['lastSyncedTime'] = date('Y-m-d H:i:s');

                $checkDuplicateData = $this
                    ->db
                    ->get_where('stuckData', array(
                    'androidUuid' => $val['localId']
                ))->num_rows();

                if(!empty($val['loungeId'])){
                    $loungeName = $this
                                ->db
                                ->get_where('loungeMaster', array(
                                'loungeId' => $val['loungeId']
                                ))->row_array();
                    $text = "<span class='text-bold-500'>New App/Tab Related Enquiry</span> has been generated by ".$loungeName['loungeName']." from ".$val['location'].' at '.date('h:i A').' on '.date('M d, Y').'.';
                    $alertSms = 'A new App/Tab Related enquiry has been generated by '.$loungeName['loungeName'].' from '.$val['location'].' at '.date('h:i A').' on '.date('M d, Y').'.';
                } else {
                    $text = "<span class='text-bold-500'>New App/Tab Related Enquiry</span> has been generated from ".$val['location'].' at '.date('h:i A').' on '.date('M d, Y').'.';
                    $alertSms = 'A new App/Tab Related enquiry has been generated from '.$val['location'].' at '.date('h:i A').' on '.date('M d, Y').'.';
                }

                // Send war room sms
                $settingData = $this->db->get_where('settings', array('id' => 1))->row_array();
                if(($settingData['newEnquiryNotification'] == "1") && (!empty($settingData['newEnquiryNotificationMobiles']))){
                    $explodeMobile = explode(",",$settingData['newEnquiryNotificationMobiles']);

                    if(!empty($explodeMobile)){
                        foreach($explodeMobile as $explodeMobileNumber){
                            if(!empty($explodeMobileNumber)){
                                sendMobileMessage($explodeMobileNumber, $alertSms);
                            }
                        }
                    }
                }



                $notification['androidUuid']    = $val['localId'];
                $notification['type']           = 1;
                $notification['text']           = $text;
                
                $notification['status']         = 1;
                $notification['addDate']        = date('Y-m-d H:i:s');
                $notification['modifyDate']     = date('Y-m-d H:i:s');
                    

                if ($checkDuplicateData > 0)
                {
                    $checkDataForAllUpdate = 2;
                    $this
                        ->db
                        ->where('androidUuid', $val['localId']);
                    $this
                        ->db
                        ->update('stuckData', $arrayName);

                    

                    $lastID = $this
                        ->db
                        ->get_where('stuckData', array(
                        'androidUuid' => $val['localId']
                    ))->row_array();

                    $url = base_url()."enquiryM/takeAction/".$lastID['id'];
                    $notification['tableId']        = $lastID['id'];
                    $notification['url']        = $url;
                    
                    $this
                        ->db
                        ->where('androidUuid', $val['localId']);
                    $this
                        ->db
                        ->update('adminNotification', $notification);


                    $listID['id'] = $lastID['id'];
                    $listID['localId'] = $val['localId'];
                    $param1[] = $listID;

                }
                else
                {
                    $arrayName['addDate']       = $val['localDateTime'];
                    $arrayName['modifyDate']    = $val['localDateTime'];
                    $arrayName['lastSyncedTime'] = date('Y-m-d H:i:s');

                    $inserted = $this
                        ->db
                        ->insert('stuckData', $arrayName);
                    $lastID = $this
                        ->db
                        ->insert_id();

                    $url = base_url()."enquiryM/takeAction/".$lastID;
                    $notification['tableId']        = $lastID;
                    $notification['url']        = $url;

                    $this
                        ->db
                        ->insert('adminNotification', $notification);

                    $listID['id'] = $lastID;
                    $listID['localId'] = $val['localId'];
                    $param1[] = $listID;
                }

            }
        }

        if ($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2)
        {
            $data['id'] = $param1;
            generateServerResponse('1', 'S', $data);
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }


    public function GetRevenueData($resquest)
    {
        if ($resquest['timestamp'] != '')
        {
            $timestampDate = "'".$resquest['timestamp']."'";
            $stateData = $this
               ->db
               ->query("SELECT DISTINCT StateCode, StateNameProperCase, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` Where modifyDate >= ".$timestampDate." ")
                 ->result_array();


            $districtData = $this
                ->db
                ->query("SELECT DISTINCT StateCode, StateNameProperCase, PRIDistrictCode , DistrictNameProperCase, UrbanRural, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` Where modifyDate >= ".$timestampDate."")
                ->result_array();


            $blockData = $this
                ->db
                ->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase, BlockPRICode , BlockPRINameProperCase, UrbanRural, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` Where modifyDate >= ".$timestampDate."")
                ->result_array();


            $villageData = $this
                ->db
                ->query("SELECT DISTINCT BlockPRICode , BlockPRINameProperCase, GPPRICode, GPNameProperCase, UrbanRural, STATUS FROM `revenuevillagewithblcoksandsubdistandgs` Where modifyDate >= ".$timestampDate."")
                ->result_array();

        }
        else
        {
            $stateData = $this
                ->db
                ->query("SELECT DISTINCT StateCode, StateNameProperCase, STATUS FROM `revenuevillagewithblcoksandsubdistandgs`")
                ->result_array();

            $districtData = $this
                ->db
                ->query("SELECT DISTINCT StateCode, StateNameProperCase, PRIDistrictCode , DistrictNameProperCase, UrbanRural, STATUS FROM `revenuevillagewithblcoksandsubdistandgs`")
                ->result_array();

            $blockData = $this
                ->db
                ->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase, BlockPRICode , BlockPRINameProperCase, UrbanRural, STATUS FROM `revenuevillagewithblcoksandsubdistandgs`")
                ->result_array();

            $villageData = $this
                ->db
                ->query("SELECT DISTINCT BlockPRICode , BlockPRINameProperCase, GPPRICode, GPNameProperCase, UrbanRural, STATUS FROM `revenuevillagewithblcoksandsubdistandgs`")
                ->result_array();
                
        }

        $count = $this
                ->db
                ->query("SELECT DISTINCT BlockPRICode , BlockPRINameProperCase, GPPRICode, GPNameProperCase, UrbanRural, STATUS FROM `revenuevillagewithblcoksandsubdistandgs`")
                ->num_rows();

        $result['stateData']    = $stateData;
        $result['districtData'] = $districtData;
        $result['blockData']    = $blockData;
        $result['villageData']  = $villageData;
        $result['count']        = $count;
        return $result;


    }


    public function getMonthlyDashboardData($request)
    {
        $loungeId = $request['loungeId'];

        $getTotalAdmission = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1 OR `status` = 2) AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->num_rows(); 

        $getTotalAvgWtBaby = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1 OR `status` = 2) AND (`babyAdmissionWeight` <= '2500' AND `babyAdmissionWeight` >=  '2000') AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->num_rows(); 

        $getTotalLBWBaby = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1 OR `status` = 2) AND `babyAdmissionWeight` < '2000' AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->num_rows(); 

        $getLoungeForRank = $this
                ->db
                ->query("SELECT DISTINCT loungeId FROM `babyAdmission` WHERE (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->result_array();

        $loungeCleaned = $this
                ->db
                ->query("SELECT * FROM `loungeServices` WHERE `loungeId` = ".$loungeId." AND `loungeSanitation` = 'Yes' AND (YEAR(`addDate`) = YEAR(CURRENT_DATE()) AND MONTH(`addDate`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

        $totalNurseCheckin = $this
                ->db
                ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (YEAR(`addDate`) = YEAR(CURRENT_DATE()) AND MONTH(`addDate`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

        $totalDischarge = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND `status` = 2 AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

        $normalDischarge = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND `status` = 2 AND typeOfDischarge = 'Normal Discharge' AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

        $onTimeNurseCheckin = $this
                ->db
                ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (YEAR(`addDate`) = YEAR(CURRENT_DATE()) AND MONTH(`addDate`) = MONTH(CURRENT_DATE())) AND ( (TIME(`addDate`) BETWEEN '07:30:00' AND '08:00:00') OR (TIME(`addDate`) BETWEEN '13:30:00' AND '14:00:00') OR (TIME(`addDate`) BETWEEN '19:30:00' AND '20:00:00')) ")
                ->num_rows();

        $noOfDoctorRound = $this
                ->db
                ->query("SELECT count(dr.`id`) as num, DATE(dr.`addDate`) DateOnly FROM `doctorRound` as dr INNER JOIN `babyAdmission` as ba on dr.`babyAdmissionId` = ba.`id` WHERE ba.`loungeId` = ".$loungeId." AND (YEAR(dr.`addDate`) = YEAR(CURRENT_DATE()) AND MONTH(dr.`addDate`) = MONTH(CURRENT_DATE())) GROUP BY DateOnly")
                ->num_rows();

        $denominator = date('d');

        $doctorRoundPercentage = ($noOfDoctorRound/$denominator) * 100;

        $getLoungeStatus = $this->getInfantStatusByLounge($loungeId);

        $totalWeightGain = $getLoungeStatus['totalWeight']/$denominator; 

        if($normalDischarge != 0){
            $dischargePercentage = ($normalDischarge / $totalDischarge) * 100;
        } else {
            $dischargePercentage = 0;
        }

        $totalKmc = $this
                ->db
                ->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(babyDailyKMC.`endTime`,babyDailyKMC.`startTime`))) as kmcTimeLatest from `babyDailyKMC` INNER JOIN `babyAdmission` on babyDailyKMC.`babyAdmissionId` = babyAdmission.`id` where babyDailyKMC.`startTime` < babyDailyKMC.`endTime` AND babyAdmission.`loungeId` = ".$loungeId." AND (YEAR(babyDailyKMC.`startDate`) = YEAR(CURRENT_DATE()) AND MONTH(babyDailyKMC.`startDate`) = MONTH(CURRENT_DATE()))")
                ->row_array();

        $hours = floor($totalKmc['kmcTimeLatest'] / 3600);
        
        $avgTotalKmc = $hours / $denominator;

        $totalFeeding = $this
                ->db
                ->query("SELECT `babyDailyNutrition`.* FROM `babyDailyNutrition` INNER JOIN babyAdmission on `babyDailyNutrition`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$loungeId." AND (YEAR(`feedDate`) = YEAR(CURRENT_DATE()) AND MONTH(`feedDate`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

        $totalExclusiveFeeding = $this
                ->db
                ->query("SELECT `babyDailyNutrition`.* FROM `babyDailyNutrition` INNER JOIN babyAdmission on `babyDailyNutrition`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$loungeId." AND `babyDailyNutrition`.`breastFeedMethod` = 'EBF' AND (YEAR(`feedDate`) = YEAR(CURRENT_DATE()) AND MONTH(`feedDate`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

        if($totalExclusiveFeeding != 0){
            $percentageOfExpressed = ($totalExclusiveFeeding / $totalFeeding) * 100;
        } else {
            $percentageOfExpressed = 0;
        }

        if($getLoungeStatus['countDailyWeight'] != 0){
            $percentageOfDailyWeight = ($getLoungeStatus['countDailyWeight'] / $getTotalAdmission) * 100;
        } else {
            $percentageOfDailyWeight = 0;
        }

        $weightRankArr = array(); $kmcRankArr = array(); $expressedFeedRankArr = array(); 
        $dailyWeightRankArr = array();  $dischargeRankArr = array(); $timelyAssessmentArr = array(); $timelyAssessmentValue = 0;
        foreach ($getLoungeForRank  as $key => $value) {
            $getLoungeStatus = $this->getInfantStatusByLounge($value['loungeId']);
            $totalWeightGain = $getLoungeStatus['totalWeight']/$denominator;

            $weightRankArr[$key]['loungeId'] = $value['loungeId'];
            $weightRankArr[$key]['totalWeightGain'] = $totalWeightGain;


            $timelyAssessmentArr[$key]['loungeId'] = $value['loungeId'];
            $timelyAssessmentArr[$key]['timelyAssessment'] = $getLoungeStatus['countTimelyAssessment'];

            if($value['loungeId'] == $loungeId){
                $timelyAssessmentValue = $getLoungeStatus['countTimelyAssessment'];
            } 

            $totalKmcRank = $this
                ->db
                ->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(babyDailyKMC.`endTime`,babyDailyKMC.`startTime`))) as kmcTimeLatest from `babyDailyKMC` INNER JOIN `babyAdmission` on babyDailyKMC.`babyAdmissionId` = babyAdmission.`id` where babyDailyKMC.`startTime` < babyDailyKMC.`endTime` AND babyAdmission.`loungeId` = ".$value['loungeId']." AND (YEAR(babyDailyKMC.`startDate`) = YEAR(CURRENT_DATE()) AND MONTH(babyDailyKMC.`startDate`) = MONTH(CURRENT_DATE()))")
                ->row_array();

            $hoursRank = floor($totalKmcRank['kmcTimeLatest'] / 3600);
            
            $avgTotalKmcRank = $hoursRank / $denominator;
            $avgTotalKmcRank = round($avgTotalKmcRank, 2);

            $kmcRankArr[$key]['loungeId'] = $value['loungeId'];
            $kmcRankArr[$key]['avgTotalKmc'] = $avgTotalKmcRank;

            $totalFeedingRank = $this
                ->db
                ->query("SELECT `babyDailyNutrition`.* FROM `babyDailyNutrition` INNER JOIN babyAdmission on `babyDailyNutrition`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$value['loungeId']." AND (YEAR(`feedDate`) = YEAR(CURRENT_DATE()) AND MONTH(`feedDate`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

            $totalExclusiveFeedingRank = $this
                ->db
                ->query("SELECT `babyDailyNutrition`.* FROM `babyDailyNutrition` INNER JOIN babyAdmission on `babyDailyNutrition`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$value['loungeId']." AND `babyDailyNutrition`.`breastFeedMethod` = 'EBF' AND (YEAR(`feedDate`) = YEAR(CURRENT_DATE()) AND MONTH(`feedDate`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

            if($totalExclusiveFeedingRank != 0){
                $percentageOfExpressedRank = ($totalExclusiveFeeding / $totalFeedingRank) * 100;
            } else {
                $percentageOfExpressedRank = 0;
            }

            $expressedFeedRankArr[$key]['loungeId'] = $value['loungeId'];
            $expressedFeedRankArr[$key]['percentageOfExpressed'] = $percentageOfExpressedRank;

            if($getLoungeStatus['countDailyWeight'] != 0){
                $percentageOfDailyWeightRank = ($getLoungeStatus['countDailyWeight'] / $getTotalAdmission) * 100;
            } else {
                $percentageOfDailyWeightRank = 0;
            }

            $dailyWeightRankArr[$key]['loungeId'] = $value['loungeId'];
            $dailyWeightRankArr[$key]['babyDailyWeight'] = $percentageOfDailyWeightRank;

            $totalDischargeRank = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$value['loungeId']." AND `status` = 2 AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

            $normalDischargeRank = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$value['loungeId']." AND `status` = 2 AND typeOfDischarge = 'Normal Discharge' AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->num_rows();

            if($normalDischargeRank != 0){
                $dischargePercentageRank = ($normalDischargeRank / $totalDischargeRank) * 100;
            } else {
                $dischargePercentageRank = 0;
            }

            $dischargeRankArr[$key]['loungeId'] = $value['loungeId'];
            $dischargeRankArr[$key]['dischargePercentage'] = $dischargePercentageRank;

        }
        
        array_multisort(array_column($weightRankArr, 'totalWeightGain'), SORT_DESC, $weightRankArr);
        array_multisort(array_column($kmcRankArr, 'avgTotalKmc'), SORT_DESC, $kmcRankArr); 
        array_multisort(array_column($expressedFeedRankArr, 'percentageOfExpressed'), SORT_DESC, $expressedFeedRankArr); 
        array_multisort(array_column($dailyWeightRankArr, 'babyDailyWeight'), SORT_DESC, $dailyWeightRankArr);
        array_multisort(array_column($dischargeRankArr, 'dischargePercentage'), SORT_DESC, $dischargeRankArr);  
        array_multisort(array_column($timelyAssessmentArr, 'timelyAssessment'), SORT_DESC, $timelyAssessmentArr);


        $weightGainRank = array_search($loungeId, array_column($weightRankArr, 'loungeId')); 
        $avgKMCRank = array_search($loungeId, array_column($kmcRankArr, 'loungeId'));
        $expressedFeedRank = array_search($loungeId, array_column($expressedFeedRankArr, 'loungeId')); 
        $dailyWeightRank = array_search($loungeId, array_column($dailyWeightRankArr, 'loungeId')); 
        $dischargeRank = array_search($loungeId, array_column($dischargeRankArr, 'loungeId')); 
        $timelyAssessmentRank = array_search($loungeId, array_column($timelyAssessmentArr, 'loungeId')); 

        // print_r($allLoungeData);die;
        $result['getTotalAdmission']    = $getTotalAdmission;
        $result['getTotalAvgWtBaby']    = $getTotalAvgWtBaby;
        $result['getTotalLBWBaby']      = $getTotalLBWBaby;
        $result['loungeCleaned']        = $loungeCleaned;
        $result['totalNurseCheckin']    = $totalNurseCheckin;
        $result['onTimeNurseCheckin']   = $onTimeNurseCheckin;
        $result['doctorRoundPercentage']    = round($doctorRoundPercentage, 2);
        $result['totalWeightGain']      = round($totalWeightGain, 2);
        $result['avgTotalKmc']          = round($avgTotalKmc, 2);
        $result['percentageOfExpressed']            = round($percentageOfExpressed, 2);
        $result['percentageOfDailyWeight']          = round($percentageOfDailyWeight, 2);
        $result['dischargePercentage']              = round($dischargePercentage, 2);
        $result['timelyAssessmentInfant']           = $timelyAssessmentValue;
        $result['outOfDay']                 = $denominator;

        $result['weightGainRank']           = $weightGainRank+1;
        $result['avgKMCRank']               = $avgKMCRank+1;
        $result['expressedFeedRank']        = $expressedFeedRank+1;
        $result['dailyWeightRank']          = $dailyWeightRank+1;
        $result['dischargeRank']            = $dischargeRank+1;
        $result['timelyAssessmentRank']     = $timelyAssessmentRank+1;
        
        generateServerResponse('1', 'S', $result);

    }


    public function getInfantStatusByLounge($loungeId){
        $getAllAdmittedBaby = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1 OR `status` = 2) AND (YEAR(`admissionDateTime`) = YEAR(CURRENT_DATE()) AND MONTH(`admissionDateTime`) = MONTH(CURRENT_DATE()))")
                ->result_array();
        $totalWeight = 0; $babyStatus = array(); $countDailyWeight = 0;$countTimelyAssessment = 0;
        foreach ($getAllAdmittedBaby as $key => $value) {
            $GetBabyWeigth = $this
                            ->db
                            ->query("SELECT * FROM `babyDailyWeight` WHERE `babyAdmissionId` = ".$value['id']." AND (YEAR(`weightDate`) = YEAR(CURRENT_DATE()) AND MONTH(`weightDate`) = MONTH(CURRENT_DATE()))")
                            ->result_array();
            $count = count($GetBabyWeigth );
            if($count > 2){
                $prevWeight = $GetBabyWeigth[0]['babyWeight'];
                foreach ($GetBabyWeigth as $weightKey => $weightValue) {
                    
                    $currWeight = $GetBabyWeigth[$weightKey]['babyWeight'];

                    if($currWeight > $prevWeight){
                        $weightGain = $currWeight - $prevWeight;
                        $totalWeight = $totalWeight + $weightGain;
                    }
                    $prevWeight = $currWeight;

                }
            }

            $admissionDate = $value['admissionDateTime'];
            if(!empty($value['dateOfDischarge'])){
                $dischargeDate = $value['dateOfDischarge'];
            } else {
                $dischargeDate = date('Y-m-d H:i:s');
            }
            $datediff = $dischargeDate - $admissionDate;

           $dateCount = round($datediff / (60 * 60 * 24)); 

           $getWeightRecord = $this
                            ->db
                            ->query("SELECT * FROM `babyDailyWeight` WHERE `babyAdmissionId` = ".$value['id']." AND (YEAR(`weightDate`) = YEAR(CURRENT_DATE()) AND MONTH(`weightDate`) = MONTH(CURRENT_DATE()))")
                            ->num_rows();

            if($dateCount == $getWeightRecord) {
                $countDailyWeight = $countDailyWeight + 1;
            }

            $admitDate = date('Y-m-d', strtotime($value['admissionDateTime']));
            if(!empty($value['dateOfDischarge'])) {
                $dischargeDate = date('Y-m-d', strtotime($value['dateOfDischarge']));
            } else {
                $dischargeDate = date('Y-m-d');
            }

            
            while($admitDate == $dischargeDate){
                $chkAssessment = $this->db->query("SELECT * FROM `babyDailyMonitoring` WHERE babyAdmissionId = ".$value['id']." AND assesmentDate = '".$admitDate."' ORDER BY assesmentNumber")->num_rows();

                if($chkAssessment == 4){
                    $countTimelyAssessment++;
                }

                $admitDate = date("Y-m-d", strtotime("+1 day", strtotime($admitDate)));
                
            }
        }
        $babyStatus['countTimelyAssessment'] = $countTimelyAssessment;
        $babyStatus['totalWeight'] = $totalWeight;
        $babyStatus['countDailyWeight'] = $countDailyWeight;
        return $babyStatus;
    }


    public function getNurseDutyData($request){
        $this->db->order_by('id','DESC');
        $getData = $this->db->get_where('nurseDutyChange', array('loungeId' => $request['loungeId']))->result_array();
        $arr    = array();
        foreach ($getData as $key => $value) {
            
            $arr[$key]['id']                    = $value['id'];
            $arr[$key]['androidUuid']           = $value['androidUuid'];
            $arr[$key]['nurseId']               = $value['nurseId'];
            $arr[$key]['loungeId']              = $value['loungeId'];
            $arr[$key]['type']                  = $value['type'];
            $arr[$key]['selfie']                = $value['selfie'];
            $arr[$key]['latitude']              = $value['latitude'];
            $arr[$key]['longitude']             = $value['longitude'];
            $arr[$key]['addDate']               = $value['addDate'];
            $arr[$key]['modifyDate']            = $value['modifyDate'];
            $arr[$key]['lastSyncedTime']        = $value['lastSyncedTime'];
            $arr[$key]['status']                = $value['status'];
            $arr[$key]['checkoutSelfie']        = $value['checkoutSelfie'];
            $arr[$key]['checkoutLatitude']      = $value['checkoutLatitude'];
            $arr[$key]['checkoutLongitude']     = $value['checkoutLongitude'];
        }

        $result['dutyChangeData'] = $arr;
        generateServerResponse('1', 'S', $result);
    }


    


    public function getAdmittedDataByLounge($request){
        $this->db->order_by('id','DESC');
        $getAdmittedBaby = $this->db->get_where('babyAdmission', array('loungeId' => $request['loungeId'], 'status' => 1))->result_array();

        $response = array();

        foreach ($getAdmittedBaby as $key => $value) {
            $this->db->select('babyRegistration.*,motherRegistration.motherName');
            $this->db->join('motherRegistration','motherRegistration.motherId=babyRegistration.motherId');
            $getRegistrationData = $this->db->get_where('babyRegistration', array('babyRegistration.babyId' => $value['babyId']))->row_array();
            $getMotherRegistrationData = $this->db->get_where('motherRegistration', array('motherId' => $getRegistrationData['motherId']))->row_array();
            if($getMotherRegistrationData['isMotherAdmitted'] == 'Yes') {
                $getMotherAdmissionData = $this->db->get_where('motherAdmission', array('motherId' => $getMotherRegistrationData['motherId']))->row_array();
                $response[$key]['motherAdmissionData']   = $getMotherAdmissionData;
                $motherMonitoring = $this->db->get_where('motherMonitoring', array('motherAdmissionId' => $getMotherAdmissionData['id']))->result_array();
                $response[$key]['motherMonitoring']   = $motherMonitoring;
                $motherComments = $this->db->get_where('comments', array('admissionId' => $getMotherAdmissionData['id'], 'type' => 1, 'status!=' => 3))->result_array();
                $response[$key]['motherComments']   = $motherComments;
            }




            $babyDailyKMC = $this->db->get_where('babyDailyKMC', array('babyAdmissionId' => $value['id']))->result_array();

            $babyComments = $this->db->get_where('comments', array('admissionId' => $value['id'], 'type' => 2, 'status!=' => 3))->result_array();

            $babyDailyMonitoring = $this->db->get_where('babyDailyMonitoring', array('babyAdmissionId' => $value['id']))->result_array();

            $babyDailyNutrition = $this->db->get_where('babyDailyNutrition', array('babyAdmissionId' => $value['id']))->result_array();

            $babyDailyWeight = $this->db->get_where('babyDailyWeight', array('babyAdmissionId' => $value['id']))->result_array();

            $doctorRound = $this->db->get_where('doctorRound', array('babyAdmissionId' => $value['id']))->result_array();
            

            foreach ($doctorRound as $key2 => $value2) {
                // $investigation = $this->db->get_where('investigation', array('babyAdmissionId' => $value['id'], 'roundId' => $value2['id']))->result_array();
                $this->db->select('investigation.*, staffMaster.name as doctorName');
                $this->db->from('investigation');
                $this->db->join('staffMaster','staffMaster.staffId=investigation.doctorId');
                $this->db->where(array('babyAdmissionId' => $value['id'], 'roundId' => $value2['id']));
                $investigation = $this->db->get()->result_array();

                $this->db->select('doctorBabyPrescription.*, staffMaster.name as doctorName');
                $this->db->from('doctorBabyPrescription');
                $this->db->join('staffMaster','staffMaster.staffId=doctorBabyPrescription.doctorId');
                $this->db->where(array('babyAdmissionId' => $value['id'], 'roundId' => $value2['id']));
                $prescriptions = $this->db->get()->result_array();

                // $prescriptions = $this->db->get_where('doctorBabyPrescription', array('babyAdmissionId' => $value['id'], 'roundId' => $value2['id']))->result_array();

                $doctorRound[$key2]['investigation'] = array();
                foreach ($investigation as $key3 => $value3) {
                    $doctorRound[$key2]['investigation'][$key3]['localId'] = $value3['androidUuid'];
                    $doctorRound[$key2]['investigation'][$key3]['investigationName'] = $value3['investigationName'];
                    $doctorRound[$key2]['investigation'][$key3]['investigationType'] = $value3['investigationType'];
                    $doctorRound[$key2]['investigation'][$key3]['doctorId'] = $value3['doctorId'];
                    $doctorRound[$key2]['investigation'][$key3]['doctorName'] = $value3['doctorName'];
                    $doctorRound[$key2]['investigation'][$key3]['comment'] = $value3['doctorComment'];
                    $doctorRound[$key2]['investigation'][$key3]['status']  = $value3['status'];
                    $doctorRound[$key2]['investigation'][$key3]['localDateTime'] = $value3['addDate'];
                }

                $doctorRound[$key2]['treatment'] = array();
                foreach ($prescriptions as $key4 => $value4) {
                    $doctorRound[$key2]['treatment'][$key4]['localId'] = $value4['androidUuid'];
                    $doctorRound[$key2]['treatment'][$key4]['treatmentName'] = $value4['prescriptionName'];
                    $doctorRound[$key2]['treatment'][$key4]['comment'] = $value4['comment'];
                    $doctorRound[$key2]['treatment'][$key4]['image'] = $value4['image'];
                    $doctorRound[$key2]['treatment'][$key4]['doctorId'] = $value4['doctorId'];
                    $doctorRound[$key2]['treatment'][$key4]['doctorName'] = $value4['doctorName'];
                    $doctorRound[$key2]['treatment'][$key4]['status']       = $value4['status'];
                    $doctorRound[$key2]['treatment'][$key4]['localDateTime'] = $value4['addDate'];
                }

                
            }

            $response[$key]['doctorRound']          = $doctorRound;


            $babyVaccination = $this->db->get_where('babyVaccination', array('babyAdmissionId' => $value['id']))->result_array();

            $prescriptionNurseWise = $this->db->get_where('prescriptionNurseWise', array('babyAdmissionId' => $value['id']))->result_array();

            // $investigations = $this->db->get_where('investigation', array('babyAdmissionId' => $value['id']))->result_array();

            $this->db->select('investigation.*, staffMaster.name as doctorName');
            $this->db->from('investigation');
            $this->db->join('staffMaster','staffMaster.staffId=investigation.doctorId');
            $this->db->where(array('babyAdmissionId' => $value['id']));
            $investigations = $this->db->get()->result_array();

            $response[$key]['babyAdmissionData']     = $value;
            $response[$key]['babyRegistrationData']  = $getRegistrationData;
            $response[$key]['motherRegistrationData']     = $getMotherRegistrationData;

            $response[$key]['babyDailyKMC']         = $babyDailyKMC;
            $response[$key]['babyDailyMonitoring']  = $babyDailyMonitoring;
            $response[$key]['babyDailyNutrition']     = $babyDailyNutrition;
            $response[$key]['investigation']      = $investigations;
            
            $response[$key]['babyAdmissionData']     = $value;
            $response[$key]['prescriptionNurseWise']     = $prescriptionNurseWise;
            $response[$key]['babyVaccination']   = $babyVaccination;
            $response[$key]['babyComments']   = $babyComments;
            $response[$key]['babyDailyWeight']   = $babyDailyWeight;
            
        }
        $result['babyDirectoryUrl'] = babyDirectoryUrl;
        $result['motherDirectoryUrl'] = motherDirectoryUrl;
        $result['sehmatiPatraUrl'] = sehmatiPatraUrl;

        $result['videoDirectoryUrl'] = videoDirectoryUrl;
        $result['pdfDirectoryUrl'] = pdfDirectoryUrl;

        $result['imageDirectoryUrl'] = imageDirectoryUrl;
        $result['signDirectoryUrl'] = signDirectoryUrl;

        $result['babyWeightDirectoryUrl'] = babyWeightDirectoryUrl;
        $result['babyTemperaturetDirectoryUrl'] = babyTemperaturetDirectoryUrl;

        $result['commentDirectoryUrl'] = commentDirectoryUrl;
        $result['loungeDirectoryUrl'] = loungeDirectoryUrl;
        $result['investigationDirectoryUrl'] = investigationDirectoryUrl;

        $result['result'] = $response;
        generateServerResponse('1', 'S', $result);
    }


     //generate token code
    public function generateCoachToken($request)
    {
        $mobileNumber = $request['mobileNumber']; 
        $password = $request['password'];
        $coachData = $this
            ->db
            ->get_where('coachMaster', array(
            'mobile' => $mobileNumber,
            'password' => md5($password),
            'status' => '1'
        )); 
        //echo $loungeData->num_rows(); exit;
        if ($coachData->num_rows() != 0)
        {
            $verifyUserData = $coachData->row_array();
            //$userToken      = generateUniqueCode().'&!$@#';
            $userToken = md5($verifyUserData['id'] . $password);
            $this
                ->db
                ->where('id', $verifyUserData['id']);
            $updateQuery = $this
                ->db
                ->update('coachMaster', array(
                'token' => $userToken
            ));
            if ($updateQuery > 0)
            {
                $param['token'] = $userToken;
                generateServerResponse('1', 'S', $param);
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }

    }


    public function coachLogin($request)
    {
        $mobileNumber = $request['mobileNumber'];
        $password = md5($request['password']);
        $coachData = $this
            ->db
            ->get_where('coachMaster', array(
            'mobile' => $mobileNumber,
            'password' => $password,
            'status' => '1'
        ));

        /*$loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $loungeId,
            'loungePassword' => $loungePassword,
            'status' => '1',
            'imeiNumber' => $request['imeiNumber']
        ));*/

        if ($coachData->num_rows() != 0)
        {   
            $details = $coachData->row_array();
            $loginMasterData = array();
            $loginMasterData['coachId'] = $details['id'];
            $loginMasterData['deviceId'] = $request['deviceId'];
            $loginMasterData['latitude'] = $request['latitude'];
            $loginMasterData['longitude'] = $request['longitude'];
            $loginMasterData['fcmId'] = $request['fcmId'];
            $loginMasterData['loginTime'] = date('Y-m-d H:i:s');

            $this
                ->db
                ->insert('coachLoginMaster', $loginMasterData);
            $loginId = $this
                ->db
                ->insert_id();
            
            $array['loginId'] = $loginId;
            $array['coachId'] = $details['id'];
            $array['name'] = $details['name'];
            return $array;
        }
        else
        {
            return 0;
        }
    }


    public function getCoachLounge($request){
        $id = $request['coachId'];
        
        $coachData = $this
            ->db
            ->get_where('coachDistrictFacilityLounge', array(
            'masterId' => $id,
            'status' => '1'
        ));

        if ($coachData->num_rows() != 0)
        {  
            $details = $coachData->result_array();
            $lounge = array();
            
            foreach ($details as $key => $value) {
                
                if(!in_array($value['loungeId'], $lounge)){
                    $query=$this->db->query("SELECT * FROM `loungeMaster` where loungeId = ".$value['loungeId']." ")->row_array(); 
                    $lounge[$key]['loungeId'] = $value['loungeId'];
                    $lounge[$key]['loungeName'] = $query['loungeName'];

                    $query2=$this->db->query("SELECT * FROM `facilitylist` where FacilityID = ".$value['facilityId']." ")->row_array(); 

                    $lounge[$key]['facilityId'] = $value['facilityId'];
                    $lounge[$key]['facilityName'] = $query2['FacilityName'];

                    $query3=$this->db->query("SELECT DistrictNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode = ".$value['districtId']." ")->row_array(); 

                    $lounge[$key]['districtId'] = $value['districtId'];
                    $lounge[$key]['districtName'] = $query3['DistrictNameProperCase'];
                }
            }

            
            return $lounge; 
        }
        else
        {
            return 0;
        }
    }


    public function GetLoungeStatusData($request){
        $coachId    = $request['coachId'];
        $loungeId   = $request['loungeId'];
        
        $coachData = $this
            ->db
            ->get_where('coachDistrictFacilityLounge', array(
            'masterId' => $coachId,
            'loungeId' => $loungeId,
            'status' => '1'
        ));

        if ($coachData->num_rows() != 0)
        { 
            $now = new DateTime();
            $begin1 = new DateTime('8:00');
            $end1 = new DateTime('14:00');

            $begin2 = new DateTime('14:00');
            $end2 = new DateTime('20:00');

            if ($now >= $begin1 && $now <= $end1) {
                $shift = 1;
                $from = date('Y-m-d 08:00:01');
                $to = date('Y-m-d 14:00:00');

                $fromTotal = date('Y-m-d 08:00:01');
                $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                
            } else if ($now >= $begin2 && $now <= $end2) {
                $shift = 2;
                $from = date('Y-m-d 14:00:01');
                $to = date('Y-m-d 20:00:00');

                $fromTotal = date('Y-m-d 08:00:01');
                $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                
            } else {
                $shift = 3;

                $begin3 = new DateTime('20:00');
                $end3 = new DateTime('00:00');


                if ($now >= $begin3 && $now <= $end3) {
                    $from = date('Y-m-d 20:00:01');
                    $to = date("Y-m-d 08:00:00", strtotime("+ 1 day"));

                    $fromTotal = date('Y-m-d 08:00:01');
                    $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                    
                } else {
                    $from = date("Y-m-d 20:00:01", strtotime("- 1 day"));
                    $to = date("Y-m-d 08:00:00");

                    $fromTotal = date('Y-m-d 08:00:01', strtotime("- 1 day"));
                    $toTotal = date('Y-m-d 08:00:00');
                    
                }
            }

            $getLoungeAssessmentCount = $this
                    ->db
                    ->query("SELECT * FROM `loungeAssessment` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$from."' AND '".$to."')")
                    ->num_rows(); 

            $getLoungeAssessmentCountTotal = $this
                    ->db
                    ->query("SELECT * FROM `loungeAssessment` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
                    ->num_rows(); 

            $getLoungeBirthReviewCount = $this
                    ->db
                    ->query("SELECT * FROM `loungeBirthReview` WHERE `loungeId` = ".$loungeId." AND `shift` = ".$shift." AND (`addDate` BETWEEN '".$from."' AND '".$to."')")
                    ->num_rows();

            $getLoungeBirthReviewCountTotal = $this
                    ->db
                    ->query("SELECT * FROM `loungeBirthReview` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
                    ->num_rows(); 

            $getLoungeServicesCount = $this
                    ->db
                    ->query("SELECT * FROM `loungeServices` WHERE `loungeId` = ".$loungeId." AND `shift` = ".$shift." AND (`addDate` BETWEEN '".$from."' AND '".$to."')")
                    ->num_rows(); 

            $getLoungeServicesCountTotal = $this
                    ->db
                    ->query("SELECT * FROM `loungeServices` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
                    ->num_rows(); 

            $getBabyAssessmentCount = $this
                    ->db
                    ->query("SELECT * FROM `babyDailyMonitoring` INNER JOIN `babyAdmission` ON `babyDailyMonitoring`.babyAdmissionId = `babyAdmission`.id WHERE `babyAdmission`.`loungeId` = ".$loungeId." AND (`babyDailyMonitoring`.`addDate` BETWEEN '".$from."' AND '".$to."') GROUP BY `babyDailyMonitoring`.babyAdmissionId, `babyDailyMonitoring`.assesmentNumber")
                    ->num_rows(); 

            $getMotherAssessmentCount = $this
                    ->db
                    ->query("SELECT * FROM `motherMonitoring` INNER JOIN `motherAdmission` ON `motherMonitoring`.motherAdmissionId = `motherAdmission`.id WHERE `motherAdmission`.`loungeId` = ".$loungeId." AND (`motherMonitoring`.`addDate` BETWEEN '".$from."' AND '".$to."') GROUP BY `motherMonitoring`.motherAdmissionId, `motherMonitoring`.assesmentNumber")
                    ->num_rows(); 

            $getTotalBabyAdmission = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1)")
                ->num_rows();

            $getTotalMotherAdmission = $this
                ->db
                ->query("SELECT * FROM `motherAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1)")
                ->num_rows(); 

            $getLoungeAmenities = $this
                ->db
                ->query("SELECT * FROM `loungeAmenities` WHERE `loungeId` = ".$loungeId."")
                ->row_array(); 

            if(!empty($getLoungeAmenities)){
                if($getTotalBabyAdmission > $getLoungeAmenities['totalRecliningBeds']) {
                    $bedOccupancy = 0;
                } else {
                    $bedOccupancy = $getLoungeAmenities['totalRecliningBeds'] - $getTotalBabyAdmission;
                }
            } else {
                $bedOccupancy = 0;
            }

            $getDoctorDetails = $this->db->query("SELECT * FROM `doctorRound` INNER JOIN babyAdmission on `doctorRound`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId='".$loungeId."' ORDER BY doctorRound.`id` DESC")->row_array();

            $lastDoctorRound = array();

            if(!empty($getDoctorDetails)) {
                $getStaffDetails = $this->db->query("SELECT * from staffMaster where StaffID=".$getDoctorDetails['staffId']."")->row_array();
                $lastDoctorRound[0]['staffId'] = $getStaffDetails['staffId'];
                $lastDoctorRound[0]['name']    = $getStaffDetails['name'];
                $lastDoctorRound[0]['profilePicture'] = ($getStaffDetails['profilePicture'] != '') ? base_url() . 'assets/nurse/' . $getStaffDetails['profilePicture'] : '';
                $lastDoctorRound[0]['roundDateTime']    = $getDoctorDetails['roundDateTime'];
            }

            $currentNurse = $this->db
                            ->distinct()
                            ->select('staffMaster.*')
                            ->from('staffMaster')
                            ->join('nurseDutyChange','staffMaster.staffId=nurseDutyChange.nurseId')
                            ->where(array('nurseDutyChange.loungeId' => $loungeId, 'nurseDutyChange.type' => 1))
                            ->get()
                            ->result_array();

            $nurseList = array();
            foreach ($currentNurse as $key => $value) {
                $nurseList[$key]['staffId'] = $value['staffId'];
                $nurseList[$key]['name']    = $value['name'];
                $nurseList[$key]['profilePicture'] =($value['profilePicture'] != '') ? base_url() . 'assets/nurse/' . $value['profilePicture'] : '';
            }


            $getLastSync = $this->db->query("SELECT MAX(MaxDate) FROM (
                                SELECT MAX(`addDate`) AS MaxDate FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." 
                                UNION
                                SELECT MAX(`babyDailyKMC`.lastSyncedTime) AS MaxDate FROM `babyDailyKMC` INNER JOIN `babyAdmission` ON `babyDailyKMC`.`babyAdmissionId` = `babyAdmission`.`id`
                                UNION
                                SELECT MAX(babyDailyMonitoring.lastSyncedTime) AS MaxDate FROM babyDailyMonitoring INNER JOIN babyAdmission ON babyDailyMonitoring.babyAdmissionId = babyAdmission.id
                                UNION
                                SELECT MAX(babyDailyNutrition.lastSyncedTime) AS MaxDate FROM babyDailyNutrition INNER JOIN babyAdmission ON babyDailyNutrition.babyAdmissionId = babyAdmission.id
                                UNION
                                SELECT MAX(babyDailyWeight.lastSyncedTime) AS MaxDate FROM babyDailyWeight INNER JOIN babyAdmission ON babyDailyWeight.babyAdmissionId = babyAdmission.id
                                UNION
                                SELECT MAX(babySupplement.lastSyncedTime) AS MaxDate FROM babySupplement INNER JOIN babyAdmission ON babySupplement.babyAdmissionId = babyAdmission.id
                                UNION
                                SELECT MAX(babyVaccination.lastSyncedTime) AS MaxDate FROM babyVaccination INNER JOIN babyAdmission ON babyVaccination.babyAdmissionId = babyAdmission.id
                                UNION
                                SELECT MAX(loungeAssessment.lastSyncedTime) AS MaxDate FROM loungeAssessment WHERE loungeId = ".$loungeId."
                                UNION
                                SELECT MAX(loungeBirthReview.lastSyncedTime) AS MaxDate FROM loungeBirthReview WHERE loungeId = ".$loungeId."
                                UNION
                                SELECT MAX(loungeServices.lastSyncedTime) AS MaxDate FROM loungeServices WHERE loungeId = ".$loungeId."
                                ) AS X")->row_array();

            $result['lastSyncedTime']                   = $getLastSync['MAX(MaxDate)'];

            $result['loungeAssessmentCount']            = $getLoungeAssessmentCount;
            $result['loungeBirthReviewCount']           = $getLoungeBirthReviewCount;
            $result['loungeServicesCount']              = $getLoungeServicesCount;

            $result['loungeAssessmentCountTotal']       = $getLoungeAssessmentCountTotal;
            $result['loungeBirthReviewCountTotal']      = $getLoungeBirthReviewCountTotal;
            $result['loungeServicesCountTotal']         = $getLoungeServicesCountTotal;

            $result['babyAssessmentCount']              = $getBabyAssessmentCount;
            $result['motherAssessmentCount']            = $getMotherAssessmentCount;

            $result['totalBabyAdmission']               = $getTotalBabyAdmission;
            $result['totalMotherAdmission']             = $getTotalMotherAdmission;
            $result['bedOccupancy']                     = $bedOccupancy;
            $result['nurseList']                        = $nurseList;
            
            $result['lastDoctorRound']                  = $lastDoctorRound;
            generateServerResponse('1', 'S', $result);
        }
    }


    public function GetLoungeServicesData($request){
        $coachId    = $request['coachId'];
        $loungeId   = $request['loungeId'];
        
        $coachData = $this
            ->db
            ->get_where('coachDistrictFacilityLounge', array(
            'masterId' => $coachId,
            'loungeId' => $loungeId,
            'status' => '1'
        ));

        if ($coachData->num_rows() != 0)
        {
            $now = new DateTime();
            $begin1 = new DateTime('8:00');
            $end1 = new DateTime('14:00');

            $begin2 = new DateTime('14:00');
            $end2 = new DateTime('20:00');

            if ($now >= $begin1 && $now <= $end1) {
                
                $fromTotal = date('Y-m-d 08:00:01');
                $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                
            } else if ($now >= $begin2 && $now <= $end2) {
                
                $fromTotal = date('Y-m-d 08:00:01');
                $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                
            } else {
                
                $begin3 = new DateTime('20:00');
                $end3 = new DateTime('00:00');


                if ($now >= $begin3 && $now <= $end3) {
                    
                    $fromTotal = date('Y-m-d 08:00:01');
                    $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                    
                } else {
                    
                    $fromTotal = date('Y-m-d 08:00:01', strtotime("- 1 day"));
                    $toTotal = date('Y-m-d 08:00:00');
                    
                }
            }


            $getLoungeServices = $this
                ->db
                ->query("SELECT * FROM `loungeServices` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
                ->result_array();
            if(!empty($getLoungeServices)){
                $result['loungeServices']   = $getLoungeServices;
                generateServerResponse('1', 'S', $result);
            } else {
                generateServerResponse('0', 'E');
            }
        }

    }


    public function GetTodayDashboardData($request){
        $coachId    = $request['coachId'];
        $loungeId   = $request['loungeId'];
        
        $coachData = $this
            ->db
            ->get_where('coachDistrictFacilityLounge', array(
            'masterId' => $coachId,
            'loungeId' => $loungeId,
            'status' => '1'
        ));

        if ($coachData->num_rows() != 0)
        {
            $curr_date = date('Y-m-d');

            $now = new DateTime();
            $begin1 = new DateTime('8:00');
            $end1 = new DateTime('14:00');

            $begin2 = new DateTime('14:00');
            $end2 = new DateTime('20:00');

            if ($now >= $begin1 && $now <= $end1) {
                $shift = 1;
                $from = date('Y-m-d 08:00:01');
                $to = date('Y-m-d 14:00:00');

                $fromTotal = date('Y-m-d 08:00:01');
                $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                
            } else if ($now >= $begin2 && $now <= $end2) {
                $shift = 2;
                $from = date('Y-m-d 14:00:01');
                $to = date('Y-m-d 20:00:00');

                $fromTotal = date('Y-m-d 08:00:01');
                $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                
            } else {
                $shift = 3;

                $begin3 = new DateTime('20:00');
                $end3 = new DateTime('00:00');


                if ($now >= $begin3 && $now <= $end3) {
                    $from = date('Y-m-d 20:00:01');
                    $to = date("Y-m-d 08:00:00", strtotime("+ 1 day"));

                    $fromTotal = date('Y-m-d 08:00:01');
                    $toTotal = date('Y-m-d 08:00:00', strtotime("+ 1 day"));
                    
                } else {
                    $from = date("Y-m-d 20:00:01", strtotime("- 1 day"));
                    $to = date("Y-m-d 08:00:00");

                    $fromTotal = date('Y-m-d 08:00:01', strtotime("- 1 day"));
                    $toTotal = date('Y-m-d 08:00:00');
                    
                }
            }


            $totalLiveBirth = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` INNER JOIN `babyRegistration` ON `babyAdmission`.babyId = `babyRegistration`.babyId WHERE `babyAdmission`.`loungeId` = ".$loungeId." AND (`babyAdmission`.`status` = 1) AND (`babyRegistration`.`deliveryDate` = '".$curr_date."')")
                ->num_rows(); 

            $getTotalAvgWtBaby = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` INNER JOIN `babyRegistration` ON `babyAdmission`.babyId = `babyRegistration`.babyId WHERE `babyAdmission`.`loungeId` = ".$loungeId." AND (`babyAdmission`.`status` = 1) AND (`babyAdmission`.`babyAdmissionWeight` <= '2500' AND `babyAdmissionWeight` >=  '2000') AND (`babyRegistration`.`deliveryDate` = '".$curr_date."')")
                ->num_rows(); 

            $getTotalLBWBaby = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` INNER JOIN `babyRegistration` ON `babyAdmission`.babyId = `babyRegistration`.babyId WHERE `babyAdmission`.`loungeId` = ".$loungeId." AND (`babyAdmission`.`status` = 1) AND `babyAdmission`.`babyAdmissionWeight` < '2000' AND (`babyRegistration`.`deliveryDate` = '".$curr_date."')")
                ->num_rows(); 

            $totalAdmission = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` INNER JOIN `babyRegistration` ON `babyAdmission`.babyId = `babyRegistration`.babyId WHERE `babyAdmission`.`loungeId` = ".$loungeId." AND (`babyAdmission`.`status` = 1) AND (`babyRegistration`.`deliveryDate` = '".$curr_date."')")
                ->num_rows(); 

            $notAdmitted = $totalLiveBirth - $totalAdmission;

            $shiftOne = $this
                ->db
                ->query("SELECT * FROM `loungeServices` WHERE `loungeId` = ".$loungeId." AND `shift` = 1 AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
                ->row_array();

            $shiftTwo = $this
                ->db
                ->query("SELECT * FROM `loungeServices` WHERE `loungeId` = ".$loungeId." AND `shift` = 2 AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
                ->row_array();

            $shiftThree = $this
                ->db
                ->query("SELECT * FROM `loungeServices` WHERE `loungeId` = ".$loungeId." AND `shift` = 3 AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
                ->row_array();

            if(!empty($shiftOne)){
                $loungeSanitationShiftOne = $shiftOne['loungeSanitation'];
            } else {
                $loungeSanitationShiftOne = "";
            }

            if(!empty($shiftTwo)){
                $loungeSanitationShiftTwo = $shiftTwo['loungeSanitation'];
            } else {
                $loungeSanitationShiftTwo = "";
            }

            if(!empty($shiftThree)){
                $loungeSanitationShiftThree = $shiftThree['loungeSanitation'];
            } else {
                $loungeSanitationShiftThree = "";
            }

            $getTotalAdmissionBaby = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1)")
                ->num_rows(); 

            $getTotalAdmissionMother = $this
                ->db
                ->query("SELECT * FROM `motherAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1)")
                ->num_rows();

            $kmcStatus = $this
                ->db
                ->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(babyDailyKMC.`endTime`,babyDailyKMC.`startTime`))) > 43200 as kmcTimeLatest from `babyDailyKMC` INNER JOIN `babyAdmission` ON `babyDailyKMC`.babyAdmissionId = `babyAdmission`.id WHERE `babyAdmission`.loungeId = ".$loungeId." AND startDate = '".$curr_date."' GROUP by babyAdmissionId")
                ->result_array(); 
            $count = 0;
            foreach ($kmcStatus as $key => $value) {
                if($value['kmcTimeLatest'] == 1){
                    $count++;
                }
            }

            $getLoungeAmenities = $this
                ->db
                ->query("SELECT * FROM `loungeAmenities` WHERE `loungeId` = ".$loungeId."")
                ->row_array(); 

            if(!empty($getLoungeAmenities)){
                
                $bedCount = $getLoungeAmenities['totalRecliningBeds'];
                
            } else {
                $bedCount = 0;
            }

            $totalExclusiveFeeding = $this
                ->db
                ->query("SELECT `babyDailyNutrition`.* FROM `babyDailyNutrition` INNER JOIN babyAdmission on `babyDailyNutrition`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$loungeId." AND `babyDailyNutrition`.`breastFeedMethod` = 'EBF' AND `babyDailyNutrition`.`feedDate` = '".$curr_date."' GROUP by `babyDailyNutrition`.babyAdmissionId")
                ->num_rows();

             $infantsWeightCount = $this
                ->db
                ->query("SELECT `babyDailyWeight`.* FROM `babyDailyWeight` INNER JOIN babyAdmission on `babyDailyWeight`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$loungeId." AND `babyDailyWeight`.`babyWeight` != '' AND `babyDailyWeight`.`weightDate` = '".$curr_date."' GROUP by `babyDailyWeight`.babyAdmissionId")
                ->num_rows();

            $infantsAssessedByDoctor = $this
                ->db
                ->query("SELECT `doctorRound`.* FROM `doctorRound` INNER JOIN babyAdmission on `doctorRound`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$loungeId." AND DATE(doctorRound.`roundDateTime`) = '".$curr_date."' GROUP by `doctorRound`.babyAdmissionId")
                ->num_rows();

            $onTimeAssessmentBaby = $this
                ->db
                ->query("SELECT `babyDailyMonitoring`.* FROM `babyDailyMonitoring` INNER JOIN babyAdmission on `babyDailyMonitoring`.`babyAdmissionId` = babyAdmission.`id` WHERE babyAdmission.`loungeId` = ".$loungeId." AND `babyDailyMonitoring`.`assesmentDate` = '".$curr_date."' GROUP by `babyDailyMonitoring`.babyAdmissionId, `babyDailyMonitoring`.assesmentNumber")
                ->num_rows();

            $onTimeAssessmentMother = $this
                ->db
                ->query("SELECT `motherMonitoring`.* FROM `motherMonitoring` INNER JOIN motherAdmission on `motherMonitoring`.`motherAdmissionId` = motherAdmission.`id` WHERE motherAdmission.`loungeId` = ".$loungeId." AND `motherMonitoring`.`assesmentDate` = '".$curr_date."' GROUP by `motherMonitoring`.motherAdmissionId, `motherMonitoring`.assesmentNumber")
                ->num_rows();

            if($shift == 1) {

                $onTimeNurseCheckinShiftOne = $this
                    ->db
                    ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') AND ( (TIME(`addDate`) BETWEEN '07:30:00' AND '08:00:00')) GROUP BY nurseId")
                    ->num_rows();

                if($onTimeNurseCheckinShiftOne == 0) {
                    $onTimeDutyCheckInShiftOne = 'No';
                } else {
                    $onTimeDutyCheckInShiftOne = 'Yes';
                }

                $onTimeDutyCheckInShiftTwo = '';
                $onTimeDutyCheckInShiftThree = '';
            } else if($shift == 2) {
                $onTimeNurseCheckinShiftOne = $this
                    ->db
                    ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') AND ( (TIME(`addDate`) BETWEEN '07:30:00' AND '08:00:00')) GROUP BY nurseId")
                    ->num_rows();

                if($onTimeNurseCheckinShiftOne == 0) {
                    $onTimeDutyCheckInShiftOne = 'No';
                } else {
                    $onTimeDutyCheckInShiftOne = 'Yes';
                }

                $onTimeNurseCheckinShiftTwo = $this
                ->db
                ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') AND ((TIME(`addDate`) BETWEEN '13:30:00' AND '14:00:00')) GROUP BY nurseId")
                ->num_rows();

                if($onTimeNurseCheckinShiftTwo == 0) {
                    $onTimeDutyCheckInShiftTwo = 'No';
                } else {
                    $onTimeDutyCheckInShiftTwo = 'Yes';
                }

                $onTimeDutyCheckInShiftThree = '';
            } else if($shift == 3) {
                $onTimeNurseCheckinShiftOne = $this
                    ->db
                    ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') AND ( (TIME(`addDate`) BETWEEN '07:30:00' AND '08:00:00')) GROUP BY nurseId")
                    ->num_rows();

                if($onTimeNurseCheckinShiftOne == 0) {
                    $onTimeDutyCheckInShiftOne = 'No';
                } else {
                    $onTimeDutyCheckInShiftOne = 'Yes';
                }

                $onTimeNurseCheckinShiftTwo = $this
                ->db
                ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') AND ((TIME(`addDate`) BETWEEN '13:30:00' AND '14:00:00')) GROUP BY nurseId")
                ->num_rows();

                if($onTimeNurseCheckinShiftTwo == 0) {
                    $onTimeDutyCheckInShiftTwo = 'No';
                } else {
                    $onTimeDutyCheckInShiftTwo = 'Yes';
                }

                $onTimeNurseCheckinShiftThree = $this
                ->db
                ->query("SELECT * FROM `nurseDutyChange` WHERE `loungeId` = ".$loungeId." AND (`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') AND ((TIME(`addDate`) BETWEEN '19:30:00' AND '20:00:00')) GROUP BY nurseId")
                ->num_rows(); 

                if($onTimeNurseCheckinShiftThree == 0) {
                    $onTimeDutyCheckInShiftThree = 'No';
                } else {
                    $onTimeDutyCheckInShiftThree = 'Yes';
                }
            }

            $getTotalAdmissionList = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeId." AND (`status` = 1)")
                ->result_array(); 

            $happyBaby = 0; $sadBaby = 0;
            foreach ($getTotalAdmissionList as $key => $value) {
                $get_last_assessment = $this
                                ->db
                                ->query("SELECT * FROM `babyDailyMonitoring` WHERE `babyAdmissionId` = ".$value['id']." ORDER BY id desc")
                                ->row_array(); 
                $checkupCount1 = '0';
                $checkupCount2 = '0';
                $checkupCount3 = '0';
                if(!empty($get_last_assessment['id'])){
                    if($get_last_assessment['respiratoryRate'] > 60 || $get_last_assessment['respiratoryRate'] < 30){
                      $checkupCount1 = 1;
                    }

                    if($get_last_assessment['temperatureValue'] < 95.9 || $get_last_assessment['temperatureValue'] > 99.5){
                      $checkupCount2 = 1;
                    }

                    if($get_last_assessment['spo2'] < 95 && $get_last_assessment['isPulseOximatoryDeviceAvail']=="Yes"){
                       $checkupCount3 = 1;
                    }

                    if($checkupCount1 == 1 || $checkupCount2 == 1 || $checkupCount3 == 1){
                       $sadBaby++; // for danger or unstable (sad)
                    }else{
                       $happyBaby++; // for happy or stable icon
                    }
                }   
            }


            

            $result['totalLiveBirth']               = $totalLiveBirth;
            $result['getTotalAvgWtBaby']            = $getTotalAvgWtBaby;
            $result['getTotalLBWBaby']              = $getTotalLBWBaby;

            $result['newAdmission']                 = $totalAdmission;
            $result['notAdmitted']                  = $notAdmitted;
            $result['loungeSanitationShiftOne']     = $loungeSanitationShiftOne;

            $result['loungeSanitationShiftTwo']     = $loungeSanitationShiftTwo;
            $result['loungeSanitationShiftThree']   = $loungeSanitationShiftThree;

            $result['totalAdmissionBaby']           = $getTotalAdmissionBaby;
            $result['totalAdmissionMother']         = $getTotalAdmissionMother;
            $result['kmcStatus']                    = $count;
            $result['bedCount']                     = $bedCount;
            
            $result['totalExclusiveFeeding']        = $totalExclusiveFeeding;
            $result['infantsWeightCount']           = $infantsWeightCount;
            $result['infantsAssessedByDoctor']      = $infantsAssessedByDoctor;

            $result['onTimeAssessmentBaby']         = $onTimeAssessmentBaby;
            $result['onTimeAssessmentMother']       = $onTimeAssessmentMother;


            $result['onTimeDutyCheckInShiftOne']    = $onTimeDutyCheckInShiftOne;
            $result['onTimeDutyCheckInShiftTwo']    = $onTimeDutyCheckInShiftTwo;
            $result['onTimeDutyCheckInShiftThree']  = $onTimeDutyCheckInShiftThree;

            $result['infantHappyStatus']    = $happyBaby;
            $result['infantSadStatus']    = $sadBaby;

            generateServerResponse('1', 'S', $result);
        }

    }


    function SendMailInvalidPassword($request){
        $loungeId   = $request['loungeId'];
        $this->email->from('noreply@celworld.org');
        $this->email->to('nehashukla0310@gmail.com');
        $this->email->subject('Multiple Login Attempts With Invalid Credentials.');
        $this->email->message('Multiple Login Attempts With Invalid Credentials Message '.$loungeId .' .');
        
        $this->email->send(); 
        return 1;
    }

    public function postCounsellingPosterData($request)
    {
       $countData = count($request['counsellingData']);
       if($countData > 0){
            $param1 = array();
            $param  = array();
            $checkDataForAllUpdate = 1;  // check for all data synced or not
            foreach ($request['counsellingData'] as $key => $request) {

                $checkExist = $this->db->get_where('babyCounsellingPosterLog',array('babyId'=>$request['babyId'],'loungeId'=>$request['loungeId'],'counsellingType'=>$request['counsellingType'],'posterId'=>$request['posterId'],'duration'=>$request['duration'],'addDate'=>$request['addDate']))->row_array();
                if(empty($checkExist)){
                    $arrayName['babyId']                = $request['babyId'];
                    $arrayName['loungeId']              = $request['loungeId'];
                    $arrayName['counsellingType']       = $request['counsellingType'];
                    $arrayName['posterId']              = $request['posterId'];
                    $arrayName['duration']              = $request['duration'];
                    $arrayName['addDate']               = $request['addDate'];
                    $arrayName['modifyDate']            = $request['addDate'];

                    $inserted = $this->db->insert('babyCounsellingPosterLog', $arrayName);
                    $lastID   = $this->db->insert_id();
                }
            }

            generateServerResponse('1','S');           
       }else{
            generateServerResponse('0','223');
        }   
    }

    // validate baby registration number
    public function validateRegistrationNumber($data){
        return $this->db->get_where('babyAdmission',array('loungeId'=>$data['loungeId'],'babyFileId'=>$data['registrationNumber']))->num_rows();
    }

    // baby counselling posters
    public function GetBabyCounsellingPoster($data){
        $this->db->select('babyCounsellingPosterLog.*,counsellingMaster.videoTitle,counsellingMaster.posterType,babyAdmission.babyId as admissionBabyId');
        $this->db->join('counsellingMaster','counsellingMaster.id=babyCounsellingPosterLog.posterId');
        $this->db->join('babyAdmission','babyAdmission.babyId=babyCounsellingPosterLog.babyId');
        $this->db->where(array('counsellingMaster.videoType'=>3,'counsellingMaster.status'=>1,'babyAdmission.status'=>1));
        return $this->db->get_where('babyCounsellingPosterLog',array('babyCounsellingPosterLog.loungeId'=>$data['loungeId']))->result_array();
    }

}

