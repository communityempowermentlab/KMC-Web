<?php
class BabyModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->database();
        date_default_timezone_set("Asia/KolKata");
    }

    public function GetBabyDetail($request)
    {
        return $this
            ->db
            ->query("SELECT BM.* FROM babyDailyMonitoring as BM LEFT join babyAdmission as BA  on BA.`babyId` = BM.`babyId`  where  BA.`loungeId` ='" . $request['loungeId'] . "' AND BA.`babyId` ='" . $request['babyId'] . "'")->result_array();
    }

    //New baby registration
    public function babyRegistration($request)
    {
        $existData = $this
            ->db
            ->get_where('babyRegistration', array(
            'androidUuid' => $request['localId']
        ))->num_rows();
        if ($existData > 0)
        {
            generateServerResponse('0', '213');
        }

        $arrayName = array();

        $arrayName['babyMCTSNumber'] = ($request['babyMCTSNumber'] != '') ? $arrayName['babyMCTSNumber'] = $request['babyMCTSNumber'] : NULL;
        $arrayName['motherId'] = ($request['motherId'] != '') ? $request['motherId'] : NULL;
        $arrayName['deliveryDate'] = ($request['deliveryDate'] != '') ? $request['deliveryDate'] : NULL;
        $arrayName['deliveryTime'] = ($request['deliveryTime'] != '') ? $request['deliveryTime'] : NULL;
        $arrayName['babyGender'] = ($request['babyGender'] != '') ? $request['babyGender'] : NULL;
        $arrayName['deliveryType'] = ($request['deliveryType'] != '') ? $request['deliveryType'] : NULL;
        $arrayName['firstTimeFeed'] = ($request['firstTimeFeed'] != '') ? $request['firstTimeFeed'] : NULL;
        $arrayName['typeOfBorn'] = ($request['typeOfBorn'] != '') ? $request['typeOfBorn'] : NULL;
        $arrayName['typeOfOutBorn'] = ($request['typeOfOutBorn'] != '') ? $request['typeOfOutBorn'] : NULL;
        $arrayName['babyCryAfterBirth'] = ($request['babyCryAfterBirth'] != '') ? $request['babyCryAfterBirth'] : NULL;
        $arrayName['babyNeedBreathingHelp'] = ($request['babyNeedBreathingHelp'] != '') ? $request['babyNeedBreathingHelp'] : NULL;
        $arrayName['wasApgarScoreRecorded'] = ($request['wasApgarScoreRecorded'] != '') ? $request['wasApgarScoreRecorded'] : NULL;
        $arrayName['apgarScoreVal'] = ($request['apgarScoreVal'] != '') ? $request['apgarScoreVal'] : NULL;
        $arrayName['vitaminKGiven'] = ($request['vitaminKGiven'] != '') ? $request['vitaminKGiven'] : NULL;
        $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;

        if ($request['birthWeightAvail'] == '1')
        {
            $arrayName['birthWeightAvail'] = '1';
            $arrayName['babyWeight'] = $request['babyWeight'];
        }
        else
        {
            $arrayName['birthWeightAvail'] = '2';
            $arrayName['babyWeight'] = NULL;
            $arrayName['reason'] = $request['reason'];
        }
        
        $arrayName['babyPhoto'] = ($request['babyPhoto'] != '') ? saveDynamicImage($request['babyPhoto'], babyDirectory) : NULL;
        $arrayName['registrationDateTime'] = date('Y-m-d H:i:s');
        $arrayName['addDate'] = date('Y-m-d H:i:s');
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        // check file id duplicate and type 1= SNCU and 2 Lounges
        $loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $request['loungeId']
        ))->row_array();

        if ($loungeData['type'] == 1)
        {
            $checkFileId = $this->checkUniqueValue($request['temporaryFileId']);
            if ($checkFileId > 0)
            {
                generateServerResponse('0', '137');
            }
        }
        else
        {
            $checkFileId = $this->checkUniqueValue($request['babyFileId']);
            if ($checkFileId > 0)
            {
                generateServerResponse('0', '137');
            }
        }

        $inserted = $this
            ->db
            ->insert('babyRegistration', $arrayName);

        $babyId = $this
            ->db
            ->insert_id();

        $fileName = "b_" . $babyId . ".pdf";

        // check Unknown Case
        $checkUnknownCase = $this
            ->db
            ->get_where('motherRegistration', array(
            'motherId' => $request['motherId']
        ))->row_array();

        if ($checkUnknownCase['type'] == '2')
        {
            $this
                ->db
                ->where('motherId', $request['motherId']);
            $this
                ->db
                ->update('motherRegistration', array(
                'loungeId' => $request['loungeId']
            ));
        }

        if ($inserted > 0)
        {
            $baby = array();
            $baby['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
            $baby['babyId'] = $babyId;
            $baby['admissionDateTime'] = date('Y-m-d : H:i:s');
            $baby['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;

            // type 1= SNCU, 2= Lounges
            if ($loungeData['type'] == 1)
            {
                $baby['babyFileId'] = NULL ;
                $baby['temporaryFileId'] = ($request['temporaryFileId'] != '') ? $request['temporaryFileId'] : NULL;
            }
            else
            {
                $baby['temporaryFileId'] = NULL ; 
                $baby['babyFileId'] = ($request['babyFileId'] != '') ? $request['babyFileId'] : NULL;
            }

            $baby['addDate'] = date('Y-m-d H:i:s');
            $baby['status'] = '1';
            $baby['modifyDate'] = date('Y-m-d H:i:s');

            $badyAdmission = $this
                ->db
                ->insert('babyAdmission', $baby);
            $babyLastInsertedId = $this
                ->db
                ->insert_id();

            if ($request['birthWeightAvail'] == '1')
            {
                ############# ENTRY OF BABAY WEIGTH IN babyDailyWeight Table #################
                $baby_weigth = array();
                $baby_weigth['babyId'] = $babyId;
                $baby_weigth['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
                $baby_weigth['loungeId'] =  ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
                $baby_weigth['isDeviceAvailAndWorking'] = 'Yes';
                $baby_weigth['babyAdmissionId'] = $babyLastInsertedId;
                $baby_weigth['babyWeight'] = $request['babyWeight'];
                $baby_weigth['weightDate'] = $request['deliveryDate'];
                $baby_weigth['addDate'] = date('Y-m-d H:i:s');
                $this
                    ->db
                    ->insert('babyDailyWeight', $baby_weigth);
            }       

            $response['babyAdmissionId'] = $babyLastInsertedId;
            $response['babyId'] = $babyId;
            generateServerResponse('1', '129', $response);
        }

    }

    //Check if same babyFileId data is available in Admission Table or not
    public function checkUniqueValue($babyFileId)
    {
        return $this
            ->db
            ->get_where('babyAdmission', array(
            'babyFileId' => $babyFileId
        ))->num_rows();
    }

    // these function for update baby reg.
    public function CheckUniqueBabyFileId($babyFileId, $babyId = '', $loungeId)
    {

        $res = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $babyId,
            'babyFileId' => $babyFileId,
            'loungeId' => $loungeId,
            'status' => 1
        ))->num_rows();
        if ($res > 0)
        {
            return 0;
        }
        else
        {
            $res1 = $this
                ->db
                ->get_where('babyAdmission', array(
                'babyId' => $babyId,
                'loungeId' => $loungeId,
                'status' => 1
            ))->num_rows();
            if ($res1 > 0)
            {
                $res2 = $this
                    ->db
                    ->get_where('babyAdmission', array(
                    'babyFileId' => $babyFileId,
                    'loungeId' => $loungeId
                ))->num_rows();
                if ($res2 > 0)
                {
                    return 1;
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
    }

    public function updateBabyProfile($request)
    {
        $arrayName = array();
        $arrayName['babyMCTSNumber'] = ($request['babyMCTSNumber'] != '') ? $request['babyMCTSNumber'] : NULL;
        $arrayName['deliveryDate'] = ($request['deliveryDate'] != '') ? $request['deliveryDate'] : NULL;
        $arrayName['deliveryTime'] = ($request['deliveryTime'] != '') ? $request['deliveryTime'] : NULL;
        $arrayName['babyGender'] = ($request['babyGender'] != '') ? $request['babyGender'] : NULL;
        $arrayName['deliveryType'] = ($request['deliveryType'] != '') ? $request['deliveryType'] : NULL;
        $arrayName['firstTimeFeed'] = ($request['firstTimeFeed'] != '') ? $request['firstTimeFeed'] : NULL;
        $arrayName['babyCryAfterBirth'] = ($request['babyCryAfterBirth'] != '') ? $request['babyCryAfterBirth'] : NULL;
        $arrayName['babyNeedBreathingHelp'] = ($request['babyNeedBreathingHelp'] != '') ? $request['babyNeedBreathingHelp'] : NULL;
        $arrayName['wasApgarScoreRecorded'] = ($request['wasApgarScoreRecorded'] != '') ? $request['wasApgarScoreRecorded'] : NULL;
        $arrayName['apgarScoreVal'] = ($request['apgarScoreVal'] != '') ? $request['apgarScoreVal'] : NULL;
        $arrayName['vitaminKGiven'] = ($request['vitaminKGiven'] != '') ? $request['vitaminKGiven'] : NULL;
        $arrayName['typeOfBorn'] = ($request['typeOfBorn'] != '') ? $request['typeOfBorn'] : NULL;
        $arrayName['typeOfOutBorn'] = ($request['typeOfOutBorn'] != '') ? $request['typeOfOutBorn'] : NULL;

        if ($request['birthWeightAvail'] == '1')
        {
            $arrayName['babyWeight'] = ($request['babyWeight'] != '') ? $request['babyWeight'] : NULL;
        }
        else
        {
            $arrayName['reason'] = ($request['reason'] != '') ? $request['reason'] : NULL;
        }

        if ((strpos($request['babyPhoto'], '.png') != True) && (strpos($request['babyPhoto'], '.jpg') != True))
        {

            if ($request['babyPhoto'] != '')
            {
                $BabyImage = saveDynamicImage($request['babyPhoto'], babyDirectory);
                $arrayName['babyPhoto'] = ($BabyImage != '') ? $BabyImage : NULL;
            }
        }

        $arrayName['modifyDate'] = date('Y-m-d H:i:s');
        $this
            ->db
            ->where('babyId', $request['babyId']);
        $update = $this
            ->db
            ->update('babyRegistration', $arrayName);

        $this
            ->db
            ->order_by('id', 'desc');
        $babyAdmisionLastId = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId'],
            'loungeId' => $request['loungeId']
        ))->row_array();

        $this
            ->db
            ->where('id', $babyAdmisionLastId['id']);
        $this
            ->db
            ->update('babyAdmission', array(
            'babyFileId' => $request['babyFileId']
        ));

        $fileName = "b_" . $babyAdmisionLastId['id'] . ".pdf";
        if ($update > 0)
        {

            /*$PdfFile = $this
                ->MotherBabyAdmissionModel
                ->pdfconventer($fileName, $babyAdmisionLastId['id']);
            $this
                ->db
                ->where('id', $babyAdmisionLastId['id']);
            $this
                ->db
                ->update('babyAdmission', array(
                'babyPdfFileName' => $fileName
            ));*/

            $this
                ->BabyAdmissionPDF
                ->pdfGenerate($babyAdmisionLastId['id']);

            return $request['babyId'];

        }
        return 1;
    }

    public function BabyFeedDeatil($babyId, $loungeId)
    {
        /*echo date('Y-m-d', strtotime('-3 day')); exit;*/
        return $this
            ->db
            ->query("SELECT * From babyDailyNutrition where babyId ='15' And loungeId ='" . $loungeId . "' And feedDate >= '" . date('Y-m-d', strtotime('-3 day')) . "' AND feedDate <= '" . date('Y-m-d') . "'")->result_array();
    }

    // Get All Babies as per LoungeId or StaffId of a particular Lounge
    public function getAllBabies($request = '')
    {
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

            return $this
                ->db
                ->query("SELECT  Distinct BA.`babyId` , BA.`loungeId`, BA.`babyAdmissionWeight` , BA.`id` AS babyAdmissionId,BA.`admissionDateTime` as admissionDateTime, BA.`babyFileId` FROM babyAdmission AS BA  WHERE BA.`loungeId` =  '" . $request['loungeId'] . "'  AND BA.`status` !=2 ORDER BY BA.`babyId` DESC ")->result_array();

            return $this
                ->db
                ->query("SELECT  BR.`babyPhoto`,BM.`temperatureValue`, BM.`respiratoryRate` , BM.`spo2`, BR.`motherId`, MR.`motherName`,    BA.`babyId`,    BA.`babyAdmissionWeight`,   BA.`id` as babyAdmissionId,BA.`addDate` as admissionDateTime, BM.`addDate`, BM.`modifyDate` FROM 
            babyAdmission as BA LEFT JOIN babyRegistration as BR on BA.`babyId` = BR.`babyId` 
            LEFT JOIN motherRegistration as MR on BR.`motherId` = MR.`motherId` 
            LEFT JOIN babyDailyMonitoring as BM on BM.`babyId` = BA.`babyId`
             where  BA.`loungeId` = '" . $request['loungeId'] . "'  AND  BA.`status`!=2 GROUP BY BA.`babyId` order by BM.`babyId` desc")->result_array();
        } else {
            generateServerResponse('0','L');
        }
    }


    public function GetDetailForYellowSign($babyId, $loungeId)
    {
        return $this
            ->db
            ->query("SELECT * FROM  `babyDailyWeight` where babyId  = '" . $babyId . "' AND loungeId  = '" . $loungeId . "'  ")->result_array();
    }

    //Used
    public function babyMonitoringBkup($request)
    {

        $countData = count($request['monitoringData']);

        //get last mother AdmissionId
        if ($countData > 0)
        {
            $param = array();
            $checkSyncedData = 1; // check for all data synced or not
            foreach ($request['monitoringData'] as $key => $request)
            {

                $this
                    ->db
                    ->order_by('id', 'desc');
                $checkIfBabyIsAdmittedOrNot = $this
                    ->db
                    ->get_where('babyAdmission', array(
                    'status' => 2,
                    'babyId' => $request['babyId']
                ))->num_rows();

                if ($checkIfBabyIsAdmittedOrNot == '0' && $request['type'] == '1')
                {
                    $babyFileId = $this->checkUniqueValue($request['babyFileId']);
                    if ($babyFileId == '1' && $request['type'] == '1')
                    {
                        generateServerResponse('0', '137');
                    }
                }

                if ($request['type'] == '1') //type = 1 - Do 1 entry in baby admission table.Used for readmission of baby
                {
                    $baby['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
                    $baby['babyId'] = ($request['babyId'] != '') ? $request['babyId'] : NULL;
                    $baby['admissionDateTime'] = date('Y-m-d : H:i:s');
                    $baby['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
                    $unittype = $this->getUnittype($request['loungeId']);

                    ///1 = SNCU, 2 = KMC Lounge
                    if ($unittype['type'] == '1')
                    {
                        $baby['temporaryFileId'] = !empty($request['babyFileId']) ? $request['babyFileId'] : NULL;
                    }
                    else
                    {
                        $baby['babyFileId'] = !empty($request['babyFileId']) ? $request['babyFileId'] : NULL;
                    }
                    $baby['babyAdmissionWeight'] = ($request['babyMeasuredWeight'] != '') ? $request['babyMeasuredWeight'] : NULL;
                    $baby['addDate'] = date('Y-m-d : H:i:s');
                    $baby['status'] = '1';
                    $baby['modifyDate'] = date('Y-m-d : H:i:s');

                    $badyAdmission = $this
                        ->db
                        ->insert('babyAdmission', $baby);

                    $babyLastInsertedId = $this
                        ->db
                        ->insert_id();

                }

                    //get last Baby Admission id with respect to Baby id
                    $this
                        ->db
                        ->order_by('id', 'desc');
                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();

                    $getCount = $this
                        ->db
                        ->query("SELECT * FROM babyDailyMonitoring where babyAdmissionId ='" . $babyAdmisionLastId['id'] . "'")->num_rows();

                    $paramsArray['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                    $paramsArray['staffId'] = $request['staffId'];
                    //$paramsArray['loungeId'] = $request['loungeId'];
                    //$paramsArray['babyId'] = $request['babyId'];
                    $paramsArray['androidUuid'] = $request['localId'];

                    //Check weighing maching values
                    if ($request['isWeighingMachineAvailable'] == 'Yes')
                    {
                        $paramsArray['isWeighingMachineAvailable'] = $request['isWeighingMachineAvailable'];
                        $paramsArray['babyMeasuredWeight'] = $request['babyMeasuredWeight'];
                        $paramsArray['weighingImage'] = ($request['weighingImage']) ? saveDynamicImage($request['weighingImage'], babyWeightDirectory) : NULL;
                        $paramsArray['weightMachineNotAvailReason'] = NULL;
                    }
                    else
                    {
                        $paramsArray['isWeighingMachineAvailable'] = $request['isWeighingMachineAvailable'];
                        $paramsArray['weightMachineNotAvailReason'] = $request['weightMachineNotAvailReason'];
                    }

                    // check head circumference values
                    if ($request['isHeadMeasurngTapeAvailable'] == 'Yes')
                    {
                        $paramsArray['isHeadMeasurngTapeAvailable'] = $request['isHeadMeasurngTapeAvailable'];
                        $paramsArray['headCircumferenceVal'] = $request['headCircumferenceVal'];
                        $paramsArray['measuringTapeNotAvailReason'] = NULL;
                    }
                    else
                    {
                        $paramsArray['headCircumferenceVal'] = NULL;
                        $paramsArray['isHeadMeasurngTapeAvailable'] = 'No';
                        $paramsArray['measuringTapeNotAvailReason'] = $request['measuringTapeNotAvailReason'];
                    }

                     // check head circumference values
                    if ($request['isLengthMeasurngTapeAvailable'] == 'Yes')
                    {
                        $paramsArray['isLengthMeasurngTapeAvailable'] = $request['isLengthMeasurngTapeAvailable'];
                        $paramsArray['lengthValue'] = $request['lengthValue'];
                        $paramsArray['lengthTapeNotAvailReason'] = NULL;
                    }
                    else
                    {
                        $paramsArray['lengthValue'] = NULL;
                        $paramsArray['isLengthMeasurngTapeAvailable'] = 'No';
                        $paramsArray['lengthTapeNotAvailReason'] = $request['lengthTapeNotAvailReason'];
                    }

                    // check thermometer values
                    if ($request['isThermometerAvailable'] == 'Yes')
                    {
                        $paramsArray['isThermometerAvailable'] = $request['isThermometerAvailable'];
                        $paramsArray['temperatureValue'] = $request['temperatureValue'];
                        $paramsArray['temperatureUnit'] = $request['temperatureUnit'];
                        $paramsArray['thermometerImage'] = ($request['thermometerImage']) ? saveDynamicImage($request['thermometerImage'], babyTemperaturetDirectory) : NULL;
                        $paramsArray['thermometerNotAvailableReason'] = NULL;
                    }
                    else
                    {
                        $paramsArray['isThermometerAvailable'] = $request['isThermometerAvailable'];
                        $paramsArray['thermometerNotAvailableReason'] = $request['thermometerNotAvailableReason'];
                    }

                    // check isPulseOximatoryDeviceAvail values
                    if ($request['isPulseOximatoryDeviceAvailable'] == 'Yes')
                    {
                        $paramsArray['isPulseOximatoryDeviceAvail'] = $request['isPulseOximatoryDeviceAvailable'];
                        $paramsArray['spo2'] = $request['spo2'];
                        $paramsArray['pulseRate'] = $request['pulseRate'];
                    }
                    else
                    {
                        $paramsArray['isPulseOximatoryDeviceAvail'] = 'No';
                    }

                    $paramsArray['commentPhoto'] = ($request['commentPhoto']) ? saveDynamicImage($request['commentPhoto'], commentDirectory) : NULL;

                    $paramsArray['cftKnowledge'] = $request['cftKnowledge'];
                    $paramsArray['respiratoryRate'] = $request['respiratoryRate'];
                    $paramsArray['bloodSugar'] = $request['bloodSugar'];
                    $paramsArray['isCftGreaterThree'] = $request['isCftGreaterThree'];
                    $paramsArray['isAnyComplicationAtBirth'] = $request['isAnyComplicationAtBirth'];
                    $paramsArray['otherComplications'] = $request['otherComplications'];
                    $paramsArray['urinePassedIn24Hrs'] = $request['urinePassedIn24Hrs'];
                    $paramsArray['stoolPassedIn24Hrs'] = $request['stoolPassedIn24Hrs'];
                    $paramsArray['typeOfStool'] = $request['typeOfStool'];
                    $paramsArray['isBabyTakingBreastFeed'] = $request['isTakingBreastFeeds'];
                    $paramsArray['generalcondition'] = $request['generalcondition'];
                    $paramsArray['tone'] = $request['tone'];
                    $paramsArray['convulsions'] = $request['convulsions'];
                    $paramsArray['sucking'] = $request['sucking'];
                    $paramsArray['apneaOrGasping'] = $request['apneaOrGasping'];
                    $paramsArray['grunting'] = $request['grunting'];
                    $paramsArray['chestIndrawing'] = $request['chestIndrawing'];
                    $paramsArray['color'] = $request['color'];
                    $paramsArray['isJaundice'] = $request['isJaundice'];
                    $paramsArray['jaundiceVal'] = $request['jaundiceVal'];
                    $paramsArray['isBleeding'] = $request['isBleeding'];
                    $paramsArray['bleedingValue'] = $request['bleedingValue'];
                    $paramsArray['bulgingAnteriorFontanel'] = $request['bulgingAnteriorFontanel'];
                    $paramsArray['umbilicus'] = $request['umbilicus'];
                    $paramsArray['skinPustules'] = $request['skinPustules'];
                    $paramsArray['abdominalDistension'] = $request['abdominalDistension'];
                    $paramsArray['coldPeriphery'] = $request['coldPeriphery'];
                    $paramsArray['weakPulse'] = $request['weakPulse'];
                    $paramsArray['specifyOther'] = $request['specifyOther'];

                    $paramsArray['otherComment'] = $request['otherComment'];
                    $paramsArray['congenitalYes'] = $request['congenitalYes'];

                    $paramsArray['status'] = '1';
                    $paramsArray['assesmentDate'] = date('Y-m-d');
                    $paramsArray['assesmentNumber'] = $getCount + 1;
                    $paramsArray['assesmentTime'] = date('H:i:s');
                    $paramsArray['addDate'] = $request['localDateTime'];
                    $paramsArray['lastSyncedTime'] = date('Y-m-d : H:i:s');
                    $paramsArray['modifyDate'] = date('Y-m-d : H:i:s');

                    $returnArray = isBlankOrNull($paramsArray);

                $checkDuplicateWeightData = $this
                    ->db
                    ->get_where('babyDailyWeight', array(
                    'androidUuid' => $request['localId']
                ))->num_rows();

                if(checkDuplicateWeightData ==0)
                {
                    $this
                        ->db
                        ->order_by('id', 'desc');

                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();

                    $array = array();
                    $array['androidUuid'] = $request['localId'];
                    $array['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                    //$array['babyId'] = $request['babyId'];
                    //$array['loungeId'] = $request['loungeId'];
                    $array['nurseId'] = $request['staffId'];

                    $array['weightDate'] = date('Y-m-d');

                    //Check weighing maching values
                    if ($request['isWeighingMachineAvailable'] == 'Yes')
                    {
                        $array['isDeviceAvailAndWorking'] = $request['isWeighingMachineAvailable'];
                        $array['babyWeight'] = $request['babyMeasuredWeight'];
                        $array['babyWeightImage'] = ($request['weighingImage']) ? saveDynamicImage($request['weighingImage'], babyWeightDirectory) : NULL;
                        $array['reasonIfNotWorking'] = NULL;
                    }
                    else
                    {
                        $array['babyWeightImage'] = NULL; 
                        $array['babyWeight'] = NULL;
                        $array['isDeviceAvailAndWorking'] = $request['isWeighingMachineAvailable'];
                        $array['reasonIfNotWorking'] = $request['weightMachineNotAvailReason'];
                    }


                    $array['addDate'] = $request['localDateTime'];
                    $array['lastSyncedTime'] = date('Y-m-d H:i:s');
                    $inserted = $this
                        ->db
                        ->insert('babyDailyWeight', $array);
                }


                $checkDuplicateData = $this
                    ->db
                    ->get_where('babyDailyMonitoring', array(
                    'androidUuid' => $request['localId']
                ))->num_rows();

                if ($checkDuplicateData == 0)
                {

                    $checkSyncedData = 2;

                    $insert = $this
                        ->db
                        ->insert('babyDailyMonitoring', $returnArray);

                    // create monitoring PDF
                    $monitoringPdf = $this
                        ->CreateMonitoringSheet
                        ->generatePdf($babyAdmisionLastId['id']);

                    $this
                        ->db
                        ->where('id', $babyAdmisionLastId['id']);

                    $this
                        ->db
                        ->update('babyAdmission', array(
                        'babyMonitoringSheet' => $monitoringPdf
                    ));

                    $weightData['babyAdmissionWeight'] = ($request['babyMeasuredWeight'] != '') ? $request['babyMeasuredWeight'] : NULL;
                
                    $this
                        ->db
                        ->where('id', $babyAdmisionLastId['id']);

                    $this
                        ->db
                        ->update('babyAdmission', $weightData);

                    $lastAssessmentId = $this
                        ->db
                        ->insert_id();

                    $listID['id'] = $lastAssessmentId;
                    $listID['localId'] = $request['localId'];
                    $param[] = $listID;
                    
                }
                else
                {
                    $this
                        ->db
                        ->where('androidUuid', $request['localId']);

                    $this
                        ->db
                        ->update('babyDailyMonitoring', $returnArray);

                    // update monitoring PDF
                    $monitoringPdf = $this
                        ->CreateMonitoringSheet
                        ->generatePdf($babyAdmisionLastId['id']);

                    $this
                        ->db
                        ->where('id', $babyAdmisionLastId['id']);

                    $this
                        ->db
                        ->update('babyAdmission', array(
                        'babyMonitoringSheet' => $monitoringPdf
                    ));

                    $weightData['babyAdmissionWeight'] = ($request['babyMeasuredWeight'] != '') ? $request['babyMeasuredWeight'] : NULL;
                
                    $this
                        ->db
                        ->where('id', $babyAdmisionLastId['id']);
                        
                    $this
                        ->db
                        ->update('babyAdmission', $weightData);

                    $lastAssessmentId = $this
                        ->db
                        ->get_where('babyDailyMonitoring', array(
                        'androidUuid' => $request['localId']
                    ))->row_array();

                    $listID['id'] = $lastAssessmentId['id'];
                    $listID['localId'] = $request['localId'];
                    $param[] = $listID;
                }



                //this query for feed
                $motherData = $this
                    ->db
                    ->query("SELECT MR.`motherId`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId`  where  BA.`babyId` ='" . $request['babyId'] . "'")->row_array();
                $loungeName = getSingleRowFromTable('loungeName', 'loungeId', $request['loungeId'], 'loungeMaster');

                $status1 = '0';
                $status2 = '0';
                $status3 = '0';

                $getNoticfictaionEntry = $this
                    ->db
                    ->query("SELECT * From notification where  loungeId = '" . $request['loungeId'] . "'  AND  babyId = '" . $request['babyId'] . "' AND status = '1' AND typeOfNotification='2' order by id desc limit 0, 1")->result_array();

                $getNoticfictaionLastEntry = $this
                    ->db
                    ->query("SELECT * From notification where  loungeId = '" . $request['loungeId'] . "'  AND  babyId = '" . $request['babyId'] . "' AND status = '1' AND typeOfNotification='2' order by id desc limit 0, 1")->row_array();

                $settingDetail = getAllData('settings', 'id', '1');

                $secondMonitoring = $settingDetail['babyMonitoringSecondTime'];
                $secondTiming = date('Y-m-d ' . $secondMonitoring . ':00:00');
                $secondMonitoringTime = strtotime($secondTiming);

                $secondEnddate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $secondMonitoringTime)));
                $secondEndTiming = strtotime($secondEnddate);

                $thirdMonitoing = $settingDetail['babyMonitoringThirdTime'];
                $thirdTiming = date('Y-m-d ' . $thirdMonitoing . ':00:00');
                $thirdMonitoringTime = strtotime($thirdTiming);

                $thirdEndDate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $thirdMonitoringTime)));
                $thirdEndTiming = strtotime($thirdEndDate);

                $fourthMonitoring = $settingDetail['babyMonitoringFourthTime'];
                $fourthTiming = date('Y-m-d ' . $fourthMonitoring . ':00:00');
                $fourthMonitoringTime = strtotime($fourthTiming);

                $fourthEndDate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $fourthMonitoringTime)));
                $fourthEndTime = strtotime($fourthEndDate);

                $curDateTime = time();

                if ($settingDetail > 0)
                {
                    $firstMonitoring = $settingDetail['babyMonitoringFirstTime'];
                    $firstTiming = date('Y-m-d ' . $firstMonitoring . ':00:00');

                    $firstMonitoringTime = strtotime($firstTiming);
                    $firstEnddate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $firstMonitoringTime)));
                    $firstEndTiming = strtotime($firstEnddate);

                    if ($firstMonitoringTime <= $curDateTime && $firstEndTiming > $curDateTime)
                    {
                        if (count($getNoticfictaionEntry) == 1)
                        {
                            $this
                                ->db
                                ->where('id', $getNoticfictaionLastEntry['id']);
                            $this
                                ->db
                                ->update('notification', array(
                                'status' => '2',
                                'modifyDate' => $curDateTime
                            ));
                            $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                        }

                    }
                    else if ($secondMonitoringTime <= $curDateTime && $secondEndTiming > $curDateTime)
                    {

                        if (count($getNoticfictaionEntry) == 1)
                        {
                            $this
                                ->db
                                ->where('id', $getNoticfictaionLastEntry['id']);
                            $this
                                ->db
                                ->update('notification', array(
                                'status' => '2',
                                'modifyDate' => $curDateTime
                            ));
                            $this->givenPointsAtMonitoring($request, $lastAssessmentId);

                        }
                    }
                    else if ($thirdMonitoringTime <= $curDateTime && $thirdEndTiming > $curDateTime)
                    {
                        if (count($getNoticfictaionEntry) == 1)
                        {
                            $this
                                ->db
                                ->where('id', $getNoticfictaionLastEntry['id']);
                            $this
                                ->db
                                ->update('notification', array(
                                'status' => '2',
                                'modifyDate' => $curDateTime
                            ));
                            $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                        }
                    }
                    else if ($fourthMonitoringTime <= $curDateTime && $fourthEndTime > $curDateTime)
                    {
                        if (count($getNoticfictaionEntry) == 1)
                        {
                            $this
                                ->db
                                ->where('id', $getNoticfictaionLastEntry['id']);
                            $this
                                ->db
                                ->update('notification', array(
                                'status' => '2',
                                'modifyDate' => $curDateTime
                            ));
                            $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                        }
                    }

                }

                if ($request['respiratoryRate'] > 60 || $request['respiratoryRate'] < 30)
                {
                    $status1 = '1';
                }
                if ($request['temperatureValue'] < 95.9 || $request['temperatureValue'] > 99.5)
                {
                    $status2 = '1';
                }
                if ($request['isPulseOximatoryDeviceAvail'] == 'Yes' && $request['spo2'] < 95)
                {
                    $status3 = '1';
                }
                if ($status1 == 1 || $status2 == 1 || $status3 == 1)
                {

                    $getNumbers = $this
                        ->db
                        ->query("select * from staffMaster as sm left join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where (sm.`staffSubType`= '9'  OR sm.`staffSubType`= '30' OR sm.`staffSubType`= '6') and lm.`loungeId`=" . $request['loungeId'] . "")->result_array();
                    // $getNumbers = $this->db->query("SELECT SM.`staffMobileNumber`, SM.`staffSubType`, LM.`facilityId`, SM.`staffSubType` FROM loungeMaster as LM LEFT JOIN staffMaster as SM  On LM.`facilityId` = SM.`facilityId` WHERE SM.`staffSubType`= 9  OR SM.`staffSubType`= 30 OR SM.`staffSubType`= 6 AND  LM.`loungeId`= '".$request['loungeId']."'  ")->result_array();
                    $motherNameAs = !empty($motherData['motherName']) ? $motherData['motherName'] : 'UNKNOWN';
                    $message1 = str_replace("[motherName]", $motherNameAs, $settingDetail['smsFormatFirst']);
                    $message2 = str_replace("[loungeName]", $loungeName, $message1);
                    $message3 = str_replace("[RespiratoryRate]", $request['respiratoryRate'], $message2);
                    $message4 = str_replace("[Temperature]", $request['temperatureValue'], $message3);
                    if ($request['respiratoryRate'] == 'Yes')
                    {
                        $message = str_replace("[SpO2]", $request['spo2'], $message4);
                    }
                    else
                    {
                        $message = str_replace(", SpO2 [SpO2]", $request['spo2'], $message4);
                    }

                    foreach ($getNumbers as $key => $value)
                    {
                        if ($value['staffMobileNumber'] != '' && strlen($value['staffMobileNumber']) == 10)
                        {
                            if ($settingDetail['smsPermissionSecond'] == '1')
                            {

                                sendMobileMessage($value['staffMobileNumber'], $message);

                                $insertSms = array();
                                $insertSms['facilityId'] = $value['facilityId'];
                                $insertSms['message'] = $message;

                                $insertSms['sendTo'] = $value['staffMobileNumber'];
                                $insertSms['time'] = date('H:i:00');
                                $insertSms['date'] = date('Y-m-d');
                                $insertSms['addDate'] = date('Y-m-d : H:i:s');
                                $this
                                    ->db
                                    ->insert('smsMaster', $insertSms);
                            }

                        }
                    }
                }
            }
        }  

        if ($checkSyncedData == 1 || $checkSyncedData == 2)
        {
            $date['babyAdmissionId'] = $babyAdmisionLastId['id'];
            $date['id'] = $param;
            generateServerResponse('1', 'S', $date);
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }



    // baby daily monitoring
    public function babyDailyMonitoring($request)
    {
        $countData = count($request['monitoringData']);
        //get last mother AdmissionId
        if ($countData > 0)
        {
            $param = array();
            $checkSyncedData = 1; // check for all data synced or not
            foreach ($request['monitoringData'] as $key => $request)
            {

                $checkSyncedData = 2;
                //get last Baby AdmissionId
                $this
                    ->db
                    ->order_by('id', 'desc');

                $babyAdmisionLastId = $this
                    ->db
                    ->get_where('babyAdmission', array(
                    'babyId' => $request['babyId']
                ))->row_array();

                $getCount = $this
                        ->db
                        ->query("SELECT * FROM babyDailyMonitoring where babyAdmissionId ='" . $babyAdmisionLastId['id'] . "'")->num_rows();


                $paramsArray['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                $paramsArray['staffId'] = $request['staffId'];
                //$paramsArray['loungeId'] = $request['loungeId'];
                //$paramsArray['babyId'] = $request['babyId'];
                $paramsArray['staffSign'] = ($request['staffSign'] != '') ? saveImage($request['staffSign'], signDirectory) : 'NULL';
                $paramsArray['androidUuid'] = $request['localId'];

                $paramsArray['color'] = $request['color'];
                $paramsArray['respiratoryRate'] = $request['respiratoryRate'];

                $paramsArray['apneaOrGasping'] = $request['apneaGasping'];
                $paramsArray['grunting'] = $request['grunting'];
                $paramsArray['convulsions'] = $request['convulsions'];

                $paramsArray['crtVal'] = $request['crtVal'];
                $paramsArray['cftKnowledge'] = $request['cftKnowledge'];
                $paramsArray['activity'] = $request['activity'];
                $paramsArray['downesScore'] = $request['downesScore'];
                $paramsArray['levnesScore'] = $request['levnesScore'];
                $paramsArray['bloodPressure'] = $request['bloodPressure'];
                $paramsArray['bloodGlucose'] = $request['bloodGlucose'];
                $paramsArray['flowRate'] = $request['flowRate'];
                $paramsArray['fl02'] = $request['fl02'];
                $paramsArray['abdominalGirth'] = $request['abdominalGirth'];
                $paramsArray['rtAspirate'] = $request['rtAspirate'];
                $paramsArray['ivPatency'] = $request['ivPatency'];
                $paramsArray['bloodCollection'] = $request['bloodCollection'];
                $paramsArray['isPulseOximatoryDeviceAvail'] = $request['isPulseOximatoryDeviceAvail'];
                $paramsArray['spo2'] = $request['spo2'];
                $paramsArray['urinePassedIn24Hrs'] = $request['urinePassedIn24Hrs'];
                $paramsArray['stoolPassedIn24Hrs'] = $request['stoolPassedIn24Hrs'];
                $paramsArray['otherComment'] = $request['otherComments'];

                // check thermometer values
                if ($request['isThermometerAvailable'] == 'Yes')
                {
                    $paramsArray['isThermometerAvailable'] = $request['isThermometerAvailable'];
                    $paramsArray['temperatureValue'] = $request['temperatureValue'];
                    $paramsArray['temperatureUnit'] = $request['temperatureUnit'];
                    $paramsArray['thermometerImage'] = ($request['thermometerImage']) ? saveDynamicImage($request['thermometerImage'], babyTemperaturetDirectory) : NULL;
                    $paramsArray['thermometerNotAvailableReason'] = NULL;
                }
                else
                {
                    $paramsArray['isThermometerAvailable'] = $request['isThermometerAvailable'];
                    $paramsArray['thermometerNotAvailableReason'] = $request['thermometerNotAvailableReason'];
                }

                // check isPulseOximatoryDeviceAvail values
                if ($request['isPulseOximatoryDeviceAvail'] == 'Yes')
                {
                    $paramsArray['isPulseOximatoryDeviceAvail'] = $request['isPulseOximatoryDeviceAvail'];
                    $paramsArray['spo2'] = $request['spo2'];
                    $paramsArray['pulseRate'] = $request['pulseRate'];
                }

                $paramsArray['commentPhoto'] = ($request['commentPhoto']) ? saveDynamicImage($request['commentPhoto'], commentDirectory) : NULL;
                // check thermometer values
                

                $paramsArray['status'] = '1';
                $paramsArray['assesmentDate'] = date('Y-m-d');
                $paramsArray['assesmentNumber'] = $getCount + 1;
                $paramsArray['assesmentTime'] = date('H:i');
                $paramsArray['addDate'] = $request['localDateTime'];
                $paramsArray['lastSyncedTime']  = date('Y-m-d H:i:s');
                $paramsArray['modifyDate']  = date('Y-m-d H:i:s');

                $returnArray = isBlankOrNull($paramsArray);


                $checkDuplicateData = $this
                    ->db
                    ->get_where('babyDailyMonitoring', array(
                    'androidUuid' => $request['localId']
                ))->num_rows();

                if ($checkDuplicateData == 0)
                {
                
                    $insert = $this
                        ->db
                        ->insert('babyDailyMonitoring', $returnArray);

                    $lastAssessmentId = $this
                        ->db
                        ->insert_id();
                    $listID['id'] = $lastAssessmentId;
                    $listID['localId'] = $request['localId'];
                    $param[] = $listID;
                    $getMotherData = $this
                        ->db
                        ->query("select MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId` where  BA.`babyId` ='" . $request['babyId'] . "'")->row_array();

                    $getNurseData = $this
                        ->db
                        ->query("select name from staffMaster where staffId=" . $request['staffId'] . "")->row_array();

                    // create feed
                    $param1Array = array();
                    $param1Array['type'] = '3';
                   // $param1Array['loungeId'] = $request['loungeId'];
                    $param1Array['babyAdmissionId'] = $babyAdmisionLastId['id'];
                    $param1Array['grantedForId'] = $lastAssessmentId;
                    $param1Array['feed'] = "B/O " . (!empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'UNKNOWN') . " routine assessment has been done by " . $getNurseData['name'] . ".";
                    $param1Array['status'] = '1';
                    $param1Array['addDate']  = date('Y-m-d H:i:s');
                    $param1Array['modifyDate'] = date('Y-m-d H:i:s');

                    $this
                        ->db
                        ->insert('timeline', $param1Array);

                    $motherData = $this
                        ->db
                        ->query("SELECT MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId`  where  BA.`babyId` ='" . $request['babyId'] . "'")->row_array();
                        
                    $loungeName = getSingleRowFromTable('loungeName', 'loungeId', $request['loungeId'], 'loungeMaster');

                    $status1 = '0';
                    $status2 = '0';
                    $status3 = '0';

                    $getNoticfictaionEntry = $this
                        ->db
                        ->query("SELECT * From notification where  loungeId = '" . $request['loungeId'] . "'  AND  babyId = '" . $request['babyId'] . "' AND status = '1' AND typeOfNotification='2' order by id desc limit 0, 1")->result_array();
                    $getNoticfictaionLastEntry = $this
                        ->db
                        ->query("SELECT * From notification where  loungeId = '" . $request['loungeId'] . "'  AND  babyId = '" . $request['babyId'] . "' AND status = '1' AND typeOfNotification='2' order by id desc limit 0, 1")->row_array();
                    $settingDetail = getAllData('settings', 'id', '1');

                    $secondMonitoring = $settingDetail['babyMonitoringSecondTime'];
                    $secondTiming = date('Y-m-d ' . $secondMonitoring . ':00:00');
                    $secondMonitoringTime = strtotime($secondTiming);

                    $secondEnddate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $secondMonitoringTime)));
                    $secondEndTiming = strtotime($secondEnddate);

                    $thirdMonitoing = $settingDetail['babyMonitoringThirdTime'];
                    $thirdTiming = date('Y-m-d ' . $thirdMonitoing . ':00:00');
                    $thirdMonitoringTime = strtotime($thirdTiming);

                    $thirdEndDate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $thirdMonitoringTime)));
                    $thirdEndTiming = strtotime($thirdEndDate);

                    $fourthMonitoring = $settingDetail['babyMonitoringFourthTime'];
                    $fourthTiming = date('Y-m-d ' . $fourthMonitoring . ':00:00');
                    $fourthMonitoringTime = strtotime($fourthTiming);

                    $fourthEndDate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $fourthMonitoringTime)));
                    $fourthEndTime = strtotime($fourthEndDate);

                    $curDateTime = time();

                    if ($settingDetail > 0)
                    {
                        $firstMonitoring = $settingDetail['babyMonitoringFirstTime'];
                        $firstTiming = date('Y-m-d ' . $firstMonitoring . ':00:00');

                        $firstMonitoringTime = strtotime($firstTiming);
                        $firstEnddate = date('Y-m-d H:i:s', strtotime('+ 3 hours' . date('Y-m-d H:i:s', $firstMonitoringTime)));
                        $firstEndTiming = strtotime($firstEnddate);

                        if ($firstMonitoringTime <= $curDateTime && $firstEndTiming > $curDateTime)
                        {
                            if (count($getNoticfictaionEntry) == 1)
                            {
                                $this
                                    ->db
                                    ->where('id', $getNoticfictaionLastEntry['id']);
                                $this
                                    ->db
                                    ->update('notification', array(
                                    'status' => '2',
                                    'modifyDate' => date('Y-m-d H:i:s')));
                                    
                                $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                            }

                        }
                        else if ($secondMonitoringTime <= $curDateTime && $secondEndTiming > $curDateTime)
                        {

                            if (count($getNoticfictaionEntry) == 1)
                            {
                                $this
                                    ->db
                                    ->where('id', $getNoticfictaionLastEntry['id']);
                                $this
                                    ->db
                                    ->update('notification', array(
                                    'status' => '2',
                                    'modifyDate' => date('Y-m-d H:i:s')
                                ));
                                $this->givenPointsAtMonitoring($request, $lastAssessmentId);

                            }
                        }
                        else if ($thirdMonitoringTime <= $curDateTime && $thirdEndTiming > $curDateTime)
                        {
                            if (count($getNoticfictaionEntry) == 1)
                            {
                                $this
                                    ->db
                                    ->where('id', $getNoticfictaionLastEntry['id']);
                                $this
                                    ->db
                                    ->update('notification', array(
                                    'status' => '2',
                                    'modifyDate' => date('Y-m-d H:i:s')
                                ));
                                $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                            }
                        }
                        else if ($fourthMonitoringTime <= $curDateTime && $fourthEndTime > $curDateTime)
                        {
                            if (count($getNoticfictaionEntry) == 1)
                            {
                                $this
                                    ->db
                                    ->where('id', $getNoticfictaionLastEntry['id']);
                                $this
                                    ->db
                                    ->update('notification', array(
                                    'status' => '2',
                                    'modifyDate' => date('Y-m-d H:i:s')
                                ));
                                $this->givenPointsAtMonitoring($request, $lastAssessmentId);
                            }
                        }

                    }

                    if ($request['respiratoryRate'] > 60 || $request['respiratoryRate'] < 30)
                    {
                        $status1 = '1';
                    }
                    if ($request['temperatureValue'] < 95.9 || $request['temperatureValue'] > 99.5)
                    {
                        $status2 = '1';
                    }
                    if ($request['isPulseOximatoryDeviceAvail'] == 'Yes' && $request['spo2'] < 95)
                    {
                        $status3 = '1';
                    }
                    if ($status1 == 1 || $status2 == 1 || $status3 == 1)
                    {

                        $getNumbers = $this
                            ->db
                            ->query("select * from staffMaster as sm left join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where (sm.`staffSubType`= '9'  OR sm.`staffSubType`= '30' OR sm.`staffSubType`= '6') and lm.`loungeId`=" . $request['loungeId'] . "")->result_array();
                        // $getNumbers = $this->db->query("SELECT SM.`staffMobileNumber`, SM.`staffSubType`, LM.`facilityId`, SM.`staffSubType` FROM loungeMaster as LM LEFT JOIN staffMaster as SM  On LM.`facilityId` = SM.`facilityId` WHERE SM.`staffSubType`= 9  OR SM.`staffSubType`= 30 OR SM.`staffSubType`= 6 AND  LM.`loungeId`= '".$request['loungeId']."'  ")->result_array();
                        $motherNameAs = !empty($motherData['motherName']) ? $motherData['motherName'] : 'UNKNOWN';
                        $message1 = str_replace("[motherName]", $motherNameAs, $settingDetail['smsFormatFirst']);
                        $message2 = str_replace("[loungeName]", $loungeName, $message1);
                        $message3 = str_replace("[RespiratoryRate]", $request['respiratoryRate'], $message2);
                        $message4 = str_replace("[Temperature]", $request['temperatureValue'], $message3);
                        if ($request['respiratoryRate'] == 'Yes')
                        {
                            $message = str_replace("[SpO2]", $request['spo2'], $message4);
                        }
                        else
                        {
                            $message = str_replace(", SpO2 [SpO2]", $request['spo2'], $message4);
                        }

                        foreach ($getNumbers as $key => $value)
                        {
                            if ($value['staffMobileNumber'] != '' && strlen($value['staffMobileNumber']) == 10)
                            {
                                if ($settingDetail['smsPermissionSecond'] == '1')
                                {

                                    sendMobileMessage($value['staffMobileNumber'], $message);

                                    $insertSms = array();
                                    $insertSms['facilityId'] = $value['facilityId'];
                                    $insertSms['message'] = $message;

                                    $insertSms['sendTo'] = $value['staffMobileNumber'];
                                    $insertSms['time'] = date('H:i:00');
                                    $insertSms['date'] = date('Y-m-d');
                                    $insertSms['addDate'] =  date('Y-m-d H:i:s');
                                    $this
                                        ->db
                                        ->insert('smsMaster', $insertSms);
                                }

                            }
                        }
                    }
                }
                else
                {
                    $this
                        ->db
                        ->where('androidUuid', $request['localId']);
                    $this
                        ->db
                        ->update('babyDailyMonitoring', $returnArray);
                    $lastAssessmentId = $this
                        ->db
                        ->get_where('babyDailyMonitoring', array(
                        'androidUuid' => $request['localId']
                    ))->row_array();
                    $listID['id'] = $lastAssessmentId['id'];
                    $listID['localId'] = $request['localId'];
                    $param[] = $listID;
                }

            }
        }
        if ($checkSyncedData == 1 || $checkSyncedData == 2)
        {
            $date['id'] = $param;
            generateServerResponse('1', 'S', $date);
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }

    public function getBabyCombinedDetail($request, $admisionId = '')
    {
        return $this
            ->db
            ->query("SELECT BA.*,BM.* FROM babyDailyMonitoring as BM LEFT join babyAdmission as BA  on BA.`id` = BM.`babyAdmissionId`  where  BA.`babyId` ='" . $request['babyId'] . "' and BA.`id`='" . $admisionId . "' and BM.`babyAdmissionId`='" . $admisionId . "' order by BM.`id` desc limit 0,1 ")->row_array();
        //echo $this->db->last_query();exit;
        
    }

    public function getBabyWeight($babyId, $order_by, $loungeId = '', $limit = '', $admisionId = '')
    {
        ($limit != '') ? $this
            ->db
            ->limit($limit) : '';
        $this
            ->db
            ->order_by('id', $order_by);
        if ($loungeId != '')
        {
            return $this
                ->db
                ->get_where('babyDailyWeight', array(
                'babyAdmissionId' => $admisionId
            ))->result_array();

        }
        else
        {
            return $this
                ->db
                ->get_where('babyDailyWeight', array(
                'babyId' => $babyId,
                'babyAdmissionId' => $admisionId
            ))->result_array();
        }
    }

    public function babyWeightViaDate($babyId, $order_by, $weightDate = '', $admisionID = '')
    {
        $this
            ->db
            ->order_by('id', $order_by);
        $this
            ->db
            ->select('babyWeight');
        return $this
            ->db
            ->get_where('babyDailyWeight', array(
            'weightDate' => $weightDate,
            'babyAdmissionId' => $admisionID
        ))->row_array();
    }

    public function GetBabyFeedingDetail($babyId, $loungeId, $order_by, $limit = '')
    {
        $this
            ->db
            ->select('breastFeedMethod');
        $this
            ->db
            ->select('wayOfFeed');
        ($limit != '') ? $this
            ->db
            ->limit($limit) : '';
        $this
            ->db
            ->order_by('id', $order_by);
        return $this
            ->db
            ->get_where('babyDailyNutrition', array(
            'babyId' => $babyId,
            'loungeId' => $loungeId
        ))->result_array();
    }

    public function getBabyMonitoringData($babyId, $loungeId, $order_by, $limit = '')
    {
        $this
            ->db
            ->select('respiratoryRate');
        $this
            ->db
            ->select('temperatureValue');
        $this
            ->db
            ->select('otherComment');
        ($limit != '') ? $this
            ->db
            ->limit($limit) : '';
        $this
            ->db
            ->order_by('id', $order_by);
        return $this
            ->db
            ->get_where('babyDailyMonitoring', array(
            'babyAdmissionId' => $babyId
        ))->result_array();

    }
    /*public function GetBabySPO2($babyId)
    {
    $this->db->select('BabyPulseSpO2');
    return  $this->db->get_where('babyDailyMonitoring', array('babyId'=>$babyId))->result_array();
    }
    */

    public function getBabyMonitoringSpecificData($request, $admisionID = '')
    {
        
        return $this
            ->db
            ->query("SELECT `spo2`, `respiratoryRate`, `temperatureValue`, `temperatureUnit`, `pulseRate`, `assesmentDate`, `addDate` FROM `babyDailyMonitoring` WHERE `babyAdmissionId` = ".$admisionID." GROUP BY assesmentDate")
            ->result_array(); 
    }


    public function getAssessmentDataFromDOB($admisionID, $dob)
    {
        $date = date("Y-m-d");
        $return['respiratoryRate'] = array(); $return['pulseRate'] = array(); $return['spo2'] = array(); $return['temperature'] = array(); $return['breastFeeding'] = array();
        $assesmentDate = $dob;
        
        while($assesmentDate <= $date){ 
            $getAssessment = $this->db->query("select count(*) as count , sum(respiratoryRate) as respiratoryRate, sum(pulseRate) as pulseRate, sum(spo2) as spo2 FROM `babyDailyMonitoring` WHERE `babyAdmissionId` = ".$admisionID." AND assesmentDate = '".$assesmentDate."'")->row_array();

            $getFeeding = $this->db->query("select sum(milkQuantity) as milkQuantity , feedDate FROM `babyDailyNutrition` WHERE `babyAdmissionId` = ".$admisionID." AND feedDate = '".$assesmentDate."'")->row_array();

            $BreastFeeding['feedDate'] = $assesmentDate;
            if(!empty($getFeeding['milkQuantity'])){
                $BreastFeeding['milkQuantity'] = $getFeeding['milkQuantity'];
            } else {
                $BreastFeeding['milkQuantity'] = 0;
            }
            
            $getFUnitTotal = $this->db->query("select count(*) as count , sum(temperatureValue) as temperatureValue FROM `babyDailyMonitoring` WHERE `babyAdmissionId` = ".$admisionID." AND `temperatureUnit` = 'F' AND assesmentDate = '".$assesmentDate."'")->row_array();

            $fTotal = $getFUnitTotal['temperatureValue'];

            $fCount = $getFUnitTotal['count'];
                
            $getCUnit = $this->db->query("select temperatureValue FROM `babyDailyMonitoring` WHERE `babyAdmissionId` = ".$admisionID." AND `temperatureUnit` = 'C' AND assesmentDate = '".$assesmentDate."'")->result_array();

            $cCount = count($getCUnit);
            $CTotal = 0;
            foreach ($getCUnit as $key => $value) {
                $f = ($value['temperatureValue'] * 9/5) + 32 ;
                $CTotal = $CTotal + $f;

            }

            $totalCount = $fCount + $cCount;
            $tempTotal = $fTotal+$CTotal;

            $datediff =  strtotime($assesmentDate) - strtotime($dob);

            $BreastFeeding['age'] = $RespiratoryRate['age'] = $PulseRate['age'] = $SpO2['age'] = $BabyTemperature['age'] = round($datediff / (60 * 60 * 24));
            $RespiratoryRate['assesmentDate'] = $PulseRate['assesmentDate'] = $SpO2['assesmentDate'] = $BabyTemperature['assesmentDate'] = $assesmentDate;

            if($totalCount != 0){
                $avgTemp = $tempTotal/$totalCount;
                $BabyTemperature['temperature'] = $avgTemp;
            } else {
                $BabyTemperature['temperature'] = 0;
            }

            if(!empty($getAssessment['respiratoryRate'])){
                $avgRespiratoryRate = $getAssessment['respiratoryRate']/$getAssessment['count'];
                $RespiratoryRate['respiratoryRate']= $avgRespiratoryRate;
            } else {
                $RespiratoryRate['respiratoryRate']= 0;
            }

            if(!empty($getAssessment['pulseRate'])){
                $avgPulseRate = $getAssessment['pulseRate']/$getAssessment['count'];
                $PulseRate['pulseRate']= $avgPulseRate;
            } else {
                $PulseRate['pulseRate']= 0;
            }

            if(!empty($getAssessment['spo2'])){
                $avgSpo2 = $getAssessment['spo2']/$getAssessment['count'];
                $SpO2['spo2']= $avgSpo2;
            } else {
                $SpO2['spo2']= 0;
            }

            $return['breastFeeding'][] = $BreastFeeding;
            $return['respiratoryRate'][] = $RespiratoryRate;
            $return['pulseRate'][] = $PulseRate;
            $return['spo2'][] = $SpO2;
            $return['temperature'][] = $BabyTemperature;

            $assesmentDate = date("Y-m-d", strtotime("+1 day", strtotime($assesmentDate)));
                
        }
       
        return $return;
    }

    public function getFeedingDataViaBabyId($request, $date, $admisionID = '')
    {
        return $this
            ->db
            ->query("SELECT SUM(milkQuantity) as sum   FROM `babyDailyNutrition` WHERE `feedDate` = '" . $date . "' and `babyAdmissionId`='" . $admisionID . "'")->result_array();
    }


    public function getKMCDataViaDate($request, $date, $admisionID = '')
    {
        $query = $this
            ->db
            ->query("SELECT *  FROM `babyDailyKMC` WHERE `startDate` = '" . $date . "' and `babyAdmissionId`='" . $admisionID . "'")->result_array();

        $sum = array();

        foreach ($query as $key => $value)
        {
            $sum[] = getTimeDiff($value['startTime'], $value['endTime']);
        }
        return (totalduration($sum) != '') ? totalduration($sum) : '0';
    }

   

    public function DistrictVillageBlock($id, $type = '')
    {

        if ($type == '1')
        {
            $query = $this
                ->db
                ->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`        where `revenuevillagewithblcoksandsubdistandgs`.`GPPRICode`= '" . $id . "' limit 0,1")->row_array();
            return $query['GPNameProperCase'];
        }
        elseif ($type == '2')
        {
            $query = $this
                ->db
                ->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
                    where `revenuevillagewithblcoksandsubdistandgs`.`BlockPRICode`= '" . $id . "' limit 0,1")->row_array();
            return $query['BlockPRINameProperCase'];
        }
        elseif ($type == '3')
        {
            $query = $this
                ->db
                ->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
                    where `revenuevillagewithblcoksandsubdistandgs`.`PRIDistrictCode`= '" . $id . "' limit 0,1")->row_array();
            return $query['DistrictNameProperCase'];
        }

    }

    public function babyVaccination($request)
    {
        $countData = count($request['vaccinationData']);
        if ($countData > 0)
        {
            $param1 = array();
            $param = array();
            $checkSyncedData = 1; // check for all data synced or not
            foreach ($request['vaccinationData'] as $key => $request)
            {
                $checkDuplicateData = $this
                    ->db
                    ->get_where('babyVaccination', array(
                    'androidUuid' => $request['localId']
                ))->num_rows();
                if ($checkDuplicateData == 0)
                {
                    $checkSyncedData = 2;
                    $arrayName = array();
                    $arrayName['androidUuid'] = $request['localId'];
                    $arrayName['babyId'] = $request['babyId'];
                    $arrayName['loungeId'] = $request['loungeId'];
                    $arrayName['nurseId'] = $request['nurseId'];
                    $arrayName['VaccinationName'] = $request['vaccination_name'];
                    $arrayName['Quantity'] = $request['quantity'];
                    $arrayName['VaccinationDate'] = date('Y-m-d', strtotime($request['date']));
                    $arrayName['VaccinationTime'] = $request['time'];
                    $arrayName['addDate'] = $request['localDateTime'];
                    $arrayName['lastSyncedTime']  = date('Y-m-d H:i:s');
                    //get last Baby AdmissionId
                    $this
                        ->db
                        ->order_by('id', 'desc');
                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();
                    $arrayName['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                    $inserted = $this
                        ->db
                        ->insert('babyVaccination', $arrayName);
                    $lastID = $this
                        ->db
                        ->insert_id();
                    $listID['id'] = $lastID;
                    $listID['localId'] = $request['localId'];;
                    $param1[] = $listID;
                }
                else
                {
                    $arrayName = array();
                    $arrayName['androidUuid'] = $request['localId'];
                    $arrayName['babyId'] = $request['babyId'];
                    $arrayName['nurseId'] = $request['nurseId'];
                    $arrayName['loungeId'] = $request['loungeId'];
                    $arrayName['VaccinationName'] = $request['vaccination_name'];
                    $arrayName['Quantity'] = $request['quantity'];
                    $arrayName['VaccinationDate'] = date('Y-m-d', strtotime($request['date']));
                    $arrayName['VaccinationTime'] = $request['time'];
                    $arrayName['addDate'] = $request['localDateTime'];
                    $arrayName['lastSyncedTime']  = date('Y-m-d H:i:s');
                    //get last Baby AdmissionId
                    $this
                        ->db
                        ->order_by('id', 'desc');
                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();
                    $arrayName['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                    $this
                        ->db
                        ->where('androidUuid', $request['localId']);
                    $this
                        ->db
                        ->update('babyVaccination', $arrayName);
                    $lastID = $this
                        ->db
                        ->get_where('babyVaccination', array(
                        'androidUuid' => $request['localId']
                    ))->row_array();
                    $listID['id'] = $lastID['id'];
                    $listID['localId'] = $request['localId'];
                    $param1[] = $listID;
                }
            }
          

            if ($checkSyncedData == 1 || $checkSyncedData == 2)
            {
                $data['id'] = $param1;
                generateServerResponse('1', 'S', $data);
            }
            else
            {
                generateServerResponse('0', '213');
            }
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }

    public function GetVaccination($request)
    {
        if ($request['userType'] == '0')
        {
            $request['loungeId'] = $request['loungeId'];
        }
        else
        {
            $loungeData = getStaffLoungeId($request['loungeId']); // call function using api_helper
            $request['loungeId'] = $loungeData['loungeId'];
        }
        $this
            ->db
            ->order_by('id', 'desc');
        $getBabyAdmissionData = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId']
        ))->row_array();

        $this
            ->db
            ->order_by('id', 'DESC');
        $GetData = $this
            ->db
            ->get_where('babyVaccination', array(
            'babyId' => $request['babyId'],
            'loungeId' => $request['loungeId'],
            'babyAdmissionId' => $getBabyAdmissionData['id']
        ))->result_array();
        $arrayName = array();
        //echo $this->db->last_query();exit();
        if (count($GetData) > 0)
        {

            foreach ($GetData as $key => $value)
            {
                $Hold['vaccination_name'] = $value['VaccinationName'];
                $Hold['quantity'] = $value['Quantity'];
                $Hold['date'] = $value['VaccinationDate'];
                $Hold['time'] = $value['VaccinationTime'];
                $arrayName[] = $Hold;
            }
        }

        $response['list'] = $arrayName;
        $response['md5Data'] = md5(json_encode($response['list']));
        (count($response['list']) > 0) ? generateServerResponse('1', 'S', $response) : generateServerResponse('0', 'E');
    }

    public function givenPointsAtMonitoring($request, $lastAssessmentId)
    {
        /*type = 3 for BabyMonitering*/
        $getpoints = $this
            ->db
            ->get_where('pointmaster', array(
            'type' => '3',
            'status' => '1'
        ))
            ->row_array();
        if ($getpoints > 0)
        {
            $field = array();
            $field['nurseId'] = $request['staffId'];
            $field['loungeId'] = $request['loungeId'];
            $field['Points'] = $getpoints['Point'];
            $field['grantedForId'] = $lastAssessmentId;
            $field['type'] = $getpoints['type'];
            $field['Transactionstatus'] = 'Credit';
            $field['addDate'] = time();
            $field['modifyDate'] = time();
            $this
                ->db
                ->insert('pointstransactions', $field);
        }
        return 1;
    }

    // get babys where lounge wise, deliveryDate, regNumber and motherName searching
    public function findBabyWhereLoungeId($request)
    {
        $getAllDataWithStatus = $this->searchBabyViaPaging($request);

        //echo $this->db->last_query();
        //exit();


        $arrayName = array();
        if (count($getAllDataWithStatus) > 0)
        {
            foreach ($getAllDataWithStatus as $key => $value)
            {
                $Hold['babyId'] = $value['babyId'];
                $Hold['babyPhoto'] = babyDirectoryUrl. $value['babyPhoto'];
                $Hold['motherId'] = $value['motherId'];
                $getMother = $this
                    ->db
                    ->get_where('motherRegistration', array(
                    'motherId' => $value['motherId']
                ))->row_array();
                $Hold['motherName'] = $getMother['motherName'];
                $Hold['motherPicture'] = motherDirectoryUrl. $getMother['motherPicture'];
                $Hold['loungeId'] = $value['loungeId'];
                $getLounge = $this
                    ->db
                    ->get_where('loungeMaster', array(
                    'loungeId' => $value['loungeId']
                ))->row_array();
                $Hold['loungeName'] = $getLounge['loungeName'];
                $Hold['admissionDateTime'] = $value['admissionDateTime'];
                $Hold['dischargeDateTime'] = $value['dateOfDischarge'];
                $DoctorName = $this
                    ->db
                    ->get_where('staffMaster', array(
                    'staffId' => $value['dischargeByDoctor']
                ))->row_array();
                $Hold['dischargeByDoctor'] = $DoctorName['name'];
                $arrayName[] = $Hold;
            }
        }
        $response['babyData'] = $arrayName;
        $response['resultCount'] = count($getAllDataWithStatus);
        $response['offset'] = count($getAllDataWithStatus) + $request['offset'];
        if (count($response['babyData']) > 0)
        {
            generateServerResponse('1', 'S', $response);
        }
        else
        {
            generateServerResponse('0', 'E');
        }
    }

    public function getUnittype($loungeId)
    {
        return $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $loungeId
        ))->row_array();
    }

    public function searchBabyViaPaging($request)
    {
        $loungeId = $request['searchingLoungeId'];
        $deliveryDate = $request['deliveryDate'];
        $motherName = $request['motherName'];
        $regNumber = $request['regNumber'];
        $offset = $request['offset'];

        $limit = 10;
        $offsetvalue = ($offset != '') ? $offset : 0;

        if (!empty($loungeId) && empty($deliveryDate) && empty($motherName) && empty($regNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`status`='2' and ba.`loungeId`=" . $loungeId . " and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) ORDER BY ba.`id` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

        else if (!empty($loungeId) && !empty($deliveryDate) && empty($motherName) && empty($regNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`status`='2' and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) and (br.`deliveryDate` Like '%{$deliveryDate}%') and ba.`loungeId`=" . $loungeId . " ORDER BY ba.`id` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

        else if (!empty($loungeId) && empty($deliveryDate) && empty($motherName) && !empty($regNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`status`='2' and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) and (ba.`babyFileId` Like '%{$regNumber}%') and ba.`loungeId`=" . $loungeId . " ORDER BY ba.`id` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

        else if (!empty($loungeId) && empty($deliveryDate) && !empty($motherName) && empty($regNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join motherRegistration as mr on mr.`motherId`=br.`motherId` where ba.`status`='2' and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) and ba.`loungeId`=" . $loungeId . " and mr.`motherName` Like '%{$motherName}%' ORDER BY ba.`id` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

        /*        else if(empty($loungeId) && !empty($deliveryDate) && empty($motherName) && empty($regNumber)){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`status`='1' and br.`deliveryDate`='".$deliveryDate."' ORDER BY ba.`id` DESC LIMIT ".$offsetvalue.", ".$limit."")->result_array();
        }
        
         else if(empty($loungeId) && empty($deliveryDate) && empty($motherName) && !empty($regNumber)){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`status`='1' and ba.`babyFileId`='".$regNumber."' ORDER BY ba.`id` DESC LIMIT ".$offsetvalue.", ".$limit."")->result_array();
        }
          else if(empty($loungeId) && empty($deliveryDate) && !empty($motherName) && empty($regNumber)){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join motherRegistration as mr on mr.`motherId`=br.`motherId` where ba.`status`='1' and mr.`motherName`='".$motherName."' ORDER BY ba.`id` DESC LIMIT ".$offsetvalue.", ".$limit."")->result_array();
        }*/
    }

      public function getBabyIcon($lastAssessmentData)
      {
       $checkupCount1 = '0';
       $checkupCount2 = '0';
       $checkupCount3 = '0';
          if(!empty($lastAssessmentData['id'])){
              if($lastAssessmentData['respiratoryRate'] > 60 || $lastAssessmentData['respiratoryRate'] < 30){
                $checkupCount1 = 1;
              }

              if($lastAssessmentData['temperatureValue'] < 95.9 || $lastAssessmentData['temperatureValue'] > 99.5){
                $checkupCount2 = 1;
              }

              if($lastAssessmentData['spo2'] < 95 && $lastAssessmentData['isPulseOximatoryDeviceAvail']=="Yes"){
                 $checkupCount3 = 1;
              }

              if($checkupCount1 == 1 || $checkupCount2 == 1 || $checkupCount3 == 1){
                 return '0'; // for danger or unstable (sad)
              }else{
                 return '1'; // for happy or stable icon
              }
          }  
        
      }


   /* Suppliment data post*/
    public function BabySuppliment($request)
    {
        $countData = count($request['suplementData']);
        if ($countData > 0)
        {
            $param1 = array();
            $param = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['suplementData'] as $key => $request)
            {
                $checkDuplicateData = $this
                    ->db
                    ->get_where('babySuppliment', array(
                    'androidUuid' => $request['localId']
                ))->num_rows();
                if ($checkDuplicateData == 0)
                {
                    $checkDataForAllUpdate = 2;
                    //get last Baby AdmissionId
                    $this
                        ->db
                        ->order_by('id', 'desc');
                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();

                    $param['loungeId'] = $request['loungeId'];
                    $param['babyId'] = $request['babyId'];
                    $param['androidUuid'] = $request['localId'];
                    $param['SupplimentTime'] = $request['suppliment_time'];
                    $param['nurseId'] = $request['nurseId'];
                    $param['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                    $param['SupplimentDate'] = date('Y-m-d');
                    $param['addDate'] = $request['localDateTime'];
                    $param['lastSyncedTime'] = date('Y-m-d H:i:s');
                    $inserted = $this
                        ->db
                        ->insert('babySuppliment', $param);
                    $lastID = $this
                        ->db
                        ->insert_id();

                    $listID['id'] = $lastID;
                    $listID['localId'] = $request['localId'];;
                    $param1[] = $listID;

                    $getpoints = $this
                        ->db
                        ->get_where('pointmaster', array(
                        'type' => '6',
                        'status' => '1'
                    ))
                        ->row_array();
                    if ($getpoints > 0)
                    {
                        $field = array();
                        $field['loungeId'] = $request['loungeId'];
                        $field['nurseId'] = $request['nurseId'];
                        $field['Points'] = $getpoints['Point'];
                        $field['grantedForId'] = $lastID;
                        $field['type'] = $getpoints['type'];
                        $field['TransactionStatus'] = 'Credit';
                        $field['addDate'] = time();
                        $field['modifyDate'] = time();
                        $this
                            ->db
                            ->insert('pointstransactions', $field);
                    }
                }
                else
                {
                    // update data
                    $this
                        ->db
                        ->order_by('id', 'desc');
                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();

                    $param['loungeId'] = $request['loungeId'];
                    $param['babyId'] = $request['babyId'];
                    $param['androidUuid'] = $request['localId'];
                    $param['SupplimentTime'] = $request['suppliment_time'];
                    $param['SupplimentTime'] = $request['suppliment_time'];
                    $param['nurseId'] = $request['nurseId'];
                    $param['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                    $param['SupplimentDate'] = date('Y-m-d');
                    $param['addDate'] = $request['localDateTime'];
                    $param['lastSyncedTime'] = date('Y-m-d H:i:s');
                    $this
                        ->db
                        ->where('androidUuid', $request['localId']);
                    $inserted = $this
                        ->db
                        ->update('babySuppliment', $param);
                    $lastID = $this
                        ->db
                        ->get_where('babySuppliment', array(
                        'androidUuid' => $request['localId']
                    ))->row_array();

                    $listID['id'] = $lastID['id'];
                    $listID['localId'] = $request['localId'];
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


     /* Baby weight post */ //Used
    public function submitBabyWeight($request)
    {
        $countData = count($request['babyWeightData']);
        if ($countData > 0)
        {
            $param  = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['babyWeightData'] as $key => $request)
            {
                $validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => trim($request['babyId'])))->row_array();
                $validateNurseId = $this->db->get_where('staffMaster', array('staffId' => trim($request['nurseId']),'staffType'=>2))->row_array();

                if(!empty($validateBabyId)){
                    $checkDuplicateData = $this
                        ->db
                        ->get_where('babyDailyWeight', array(
                        'androidUuid' => $request['localId']
                    ))->num_rows();

                    if ($checkDuplicateData == 0)
                    {
                        $checkDataForAllUpdate = 2;
                        //get last Baby AdmissionId

                        $this
                            ->db
                            ->order_by('id', 'desc');

                        $babyAdmisionLastId = $this
                            ->db
                            ->get_where('babyAdmission', array(
                            'babyId' => $request['babyId']
                        ))->row_array();

                        $array = array();
                        $array['androidUuid'] = $request['localId'];
                        $array['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                        //$array['babyId'] = $request['babyId'];
                        $array['babyWeight'] = $request['babyWeight'];
                        //$array['loungeId'] = $request['loungeId'];
                        $array['nurseId'] = $request['nurseId'];

                        $array['weightDate'] = $request['weightDate'];

                        if ($request['isDeviceAvailAndWorking'] == 'Yes')
                        {
                            $array['babyWeightImage'] = ($request['image']) ? saveDynamicImage($request['image'], babyWeightDirectory) : NULL;
                            $array['isDeviceAvailAndWorking'] = $request['isDeviceAvailAndWorking'];
                            $array['reasonIfNotWorking'] = NULL;
                        }
                        else
                        {
                            $array['babyWeightImage'] = NULL;
                            $array['reasonIfNotWorking'] = $request['reason'];
                            $array['isDeviceAvailAndWorking'] = $request['isDeviceAvailAndWorking'];
                        }

                        $array['addDate'] = $request['localDateTime'];
                        $array['lastSyncedTime'] = date('Y-m-d H:i:s');
                        $inserted = $this
                            ->db
                            ->insert('babyDailyWeight', $array);

                        $lastID = $this
                            ->db
                            ->insert_id();
                        $listID['id'] = $lastID;
                        $listID['localId'] = $request['localId'];

                        $param[] = $listID;
                        
                        $getMotherData = $this
                            ->db
                            ->query("select mr.`motherName` from motherRegistration as mr inner join babyRegistration as br on mr.`motherId`=br.`motherId` where br.`babyId`=" . $request['babyId'] . "")->row_array();

                        // create timeline feed
                        $paramArray = array();
                        $paramArray['type'] = '2';
                        //$paramArray['loungeId'] = $request['loungeId'];
                        $paramArray['babyAdmissionId'] = $babyAdmisionLastId['id'];
                        $paramArray['grantedForId'] = $lastID;

                        if ($request['isDeviceAvailAndWorking'] == 'Yes')
                        {
                            $paramArray['feed'] = "B/O " . (!empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'UNKNOWN') . " current weight is " . $request['babyWeight'] . " gram.";
                        }
                        else
                        {
                            $paramArray['feed'] = "B/O " . (!empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'UNKNOWN') . " weight is not taken with reason " . $request['reason'] . ".";
                        }
                        $paramArray['status'] = '1';
                        $paramArray['addDate'] = date('Y-m-d H:i:s');
                        $paramArray['modifyDate'] = date('Y-m-d H:i:s');

                        $this
                            ->db
                            ->insert('timeline', $paramArray);

                        $this->BabyWeightPDF->WeightpdfGenerate($babyAdmisionLastId['id']);

                        /*$this
                            ->db
                            ->order_by('id', 'desc');

                        $PdfName = $this
                            ->MotherBabyAdmissionModel
                            ->babyWeightPdfFile($request['loungeId'], $babyAdmisionLastId['id']);

                        $this
                            ->db
                            ->where('id', $babyAdmisionLastId['id']);

                        $this
                            ->db
                            ->update('babyAdmission', array(
                            'babyWeightPdfName' => $PdfName
                        ));*/
                    }
                    else
                    {
                        //get last Baby AdmissionId
                        $this
                            ->db
                            ->order_by('id', 'desc');

                        $babyAdmisionLastId = $this
                            ->db
                            ->get_where('babyAdmission', array(
                            'babyId' => $request['babyId']
                        ))->row_array();

                        $array = array();
                        $array['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                        //$array['babyId'] = $request['babyId'];
                        $array['babyWeight'] = $request['babyWeight'];
                        //$array['loungeId'] = $request['loungeId'];
                        $array['nurseId'] = $request['nurseId'];
                        $array['androidUuid'] = $request['localId'];

                        $array['weightDate'] = $request['weightDate'];
                        if ($request['isDeviceAvailAndWorking'] == 'Yes')
                        {
                            $array['babyWeightImage'] = ($request['image']) ? saveDynamicImage($request['image'], babyWeightDirectory) : NULL;
                            $array['isDeviceAvailAndWorking'] = $request['isDeviceAvailAndWorking'];
                            $array['reasonIfNotWorking'] = NULL;
                        }
                        else
                        {
                            $array['babyWeightImage'] = NULL;
                            $array['reasonIfNotWorking'] = $request['reason'];
                            $array['isDeviceAvailAndWorking'] = $request['isDeviceAvailAndWorking'];
                        }

                        $array['addDate'] = $request['localDateTime'];
                        $array['lastSyncedTime'] = date('Y-m-d H:i:s');

                        $this
                            ->db
                            ->where('androidUuid', $request['localId']);

                        $this
                            ->db
                            ->update('babyDailyWeight', $array);

                        $lastID = $this
                            ->db
                            ->get_where('babyDailyWeight', array(
                            'androidUuid' => $request['localId']
                        ))->row_array();

                        $listID['id'] = $lastID['id'];
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;

                        $this->BabyWeightPDF->WeightpdfGenerate($babyAdmisionLastId['id']);

                        /*$this
                            ->db
                            ->order_by('id', 'desc');

                        $PdfName = $this
                            ->MotherBabyAdmissionModel
                            ->babyWeightPdfFile($request['loungeId'], $babyAdmisionLastId['id']);

                        $this
                            ->db
                            ->where('id', $babyAdmisionLastId['id']);
                        $this
                            ->db
                            ->update('babyAdmission', array(
                            'babyWeightPdfName' => $PdfName
                        ));*/
                    }
                }
            }
            if ($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2)
            {
                $data['id'] = $param;
                generateServerResponse('1', 'S', $data);
            }
            else
            {
                generateServerResponse('0', '213');
            }
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }
    /* Breast Feeding data post */
    public function postFeedingData($request)
    {
        $countData = count($request['feedingData']);
        if ($countData > 0)
        {
            $param = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['feedingData'] as $key => $request)
            {
                $validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => $request['babyId']))->row_array();

                if(!empty($validateBabyId)){
                    $checkDuplicateData = $this
                        ->db
                        ->get_where('babyDailyNutrition', array(
                        'androidUuid' => $request['localId']
                    ))->num_rows();

                    $checkDataForAllUpdate = 2;
                    $array = array();
                    //$array['babyId'] = $request['babyId'];
                    //$array['loungeId'] = $request['loungeId'];
                    $array['nurseId'] = $request['nurseId'];
                    $array['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
                    $array['breastFeedDuration'] = NULL;
                    $array['milkQuantity'] = NULL;
                    $array['feedingType'] = $request['feedingType'];
                    $array['specify'] = NULL;

                    if ($request['feedingType'] == '1')
                    {
                        $array['breastFeedDuration'] = NULL;
                        $array['milkQuantity'] = NULL;
                    }
                    else
                    {
                        $array['milkQuantity']  = $request['milkQuantity'];
                    }

                    if (isset($request['specify']))
                    {
                        $array['specify'] = $request['specify'];
                    }

                    $array['breastFeedMethod']  = $request['breastFeedMethod'];
                    $array['fluid']             = $request['fluid'];

                    $array['feedTime'] = date("H:i", strtotime($request['feedTime']));
                    $array['feedDate'] = date("Y-m-d");
                    $array['addDate'] = $request['localDateTime'];
                    $array['lastSyncedTime']  = date('Y-m-d H:i:s');

                    if ($checkDuplicateData == 0)
                    {
                        
                        //get last Baby AdmissionId
                        $this
                            ->db
                            ->order_by('id', 'desc');

                        $babyAdmisionLastId = $this
                            ->db
                            ->get_where('babyAdmission', array(
                            'babyId' => $request['babyId']
                        ))->row_array();

                        $array['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;

                        $inserted = $this
                            ->db
                            ->insert('babyDailyNutrition', $array);

                        $lastID = $this
                            ->db
                            ->insert_id();

                        $listID['id'] = $lastID;
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;
                       
                        $this->BabyFeedingPDF->FeedingpdfGenerate($babyAdmisionLastId['id']);

                        /*$PdfName = $this->babyDailyFeedPDFFile($request['loungeId'], $babyAdmisionLastId['id']);
                        $this
                            ->db
                            ->where('id', $babyAdmisionLastId['id']);
                        $this
                            ->db
                            ->update('babyAdmission', array(
                            'babyFeedingPdfName' => $PdfName
                        ));*/
                    }
                    else
                    {
                        $this
                            ->db
                            ->order_by('id', 'desc');
                        $babyAdmisionLastId = $this
                            ->db
                            ->get_where('babyAdmission', array(
                            'babyId' => $request['babyId']
                        ))->row_array();
                        $array['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;

                        $this
                            ->db
                            ->where('androidUuid', $request['localId']);
                        $this
                            ->db
                            ->update('babyDailyNutrition', $array);
                        $lastID = $this
                            ->db
                            ->get_where('babyDailyNutrition', array(
                            'androidUuid' => $request['localId']
                        ))->row_array();
                
                        $listID['id'] = $lastID['id'];
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;

                        $this->BabyFeedingPDF->FeedingpdfGenerate($babyAdmisionLastId['id']);

                        /*$this
                            ->db
                            ->order_by('id', 'desc');

                        $PdfName = $this->babyDailyFeedPDFFile($request['loungeId'], $babyAdmisionLastId['id']);
                        
                        $this
                            ->db
                            ->where('id', $babyAdmisionLastId['id']);
                        $this
                            ->db
                            ->update('babyAdmission', array(
                            'babyFeedingPdfName' => $PdfName
                        ));*/
                    }
                }
            }

            if ($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2)
            {
                $data['id'] = $param;
                generateServerResponse('1', 'S', $data);
            }
            else
            {
                generateServerResponse('0', '213');
            }
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }

    public function postKMCData($request)
    {
        $countData = count($request['kmcData']);
        if ($countData > 0)
        {
            $param = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not
            foreach ($request['kmcData'] as $key => $request)
            {
                $checkDuplicateData = $this
                    ->db
                    ->get_where('babyDailyKMC', array(
                    'androidUuid' => $request['localId']
                ))->num_rows();

                $validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => $request['babyId']))->row_array();
                $validateNurseId = $this->db->get_where('staffMaster', array('staffId' => trim($request['nurseId']),'staffType'=>2))->row_array();

                // kmc data is not less than admission date time
                $babyAdmissionData = $this->db->get_where('babyAdmission', array('babyId' => $request['babyId']))->row_array();
                $kmcStartDateTime = strtotime($request['startDate']." ".$request['startTime']);
                $kmcEndDateTime = strtotime($request['endDate']." ".$request['endTime']);
                
                // kmc start date should be greator than last end date time
                $this->db->order_by('babyDailyKMC.id','desc');
                $babyLastKmcData = $this->db->get_where('babyDailyKMC', array('babyDailyKMC.babyAdmissionId' => $babyAdmissionData['id'],'babyDailyKMC.isDataValid'=>1))->row_array();
                if(!empty($babyLastKmcData['endDate'])){
                    $kmcLastDateTime = strtotime($babyLastKmcData['endDate']." ".$babyLastKmcData['endTime']);
                }else{
                    $kmcLastDateTime = "0";
                }
                
                //if((strtotime($babyAdmissionData['admissionDateTime']) <= $kmcStartDateTime) && ($kmcEndDateTime >= $kmcStartDateTime) && ($kmcStartDateTime >= $kmcLastDateTime) && (!empty($validateBabyId)) && (!empty($validateNurseId)) && (trim($request['nurseId']) != "0") && (trim($request['nurseId']) != "") && (trim($request['startDate']) != "0000-00-00") && (trim($request['startDate']) != "") && (trim($request['endDate']) != "0000-00-00") && (trim($request['endDate']) != "")){
                    if ($checkDuplicateData == 0)
                    {
                        // set data valid status
                        if((strtotime($babyAdmissionData['admissionDateTime']) <= $kmcStartDateTime) && ($kmcEndDateTime >= $kmcStartDateTime) && ($kmcStartDateTime >= $kmcLastDateTime) && (!empty($validateBabyId)) && (!empty($validateNurseId)) && (trim($request['nurseId']) != "0") && (trim($request['nurseId']) != "") && (trim($request['startDate']) != "0000-00-00") && (trim($request['startDate']) != "") && (trim($request['endDate']) != "0000-00-00") && (trim($request['endDate']) != "")){

                            $getKmcDataAlreadyExist = $this->db->get_where('babyDailyKMC', array('babyAdmissionId'=>$babyAdmisionLastId['id'],'nurseId'=>trim($request['nurseId']),'startDate'=>trim($request['startDate']),'startTime'=>trim($request['startTime']),'endDate'=>trim($request['endDate']),'endTime'=>trim($request['endTime'])))->row_array();
                            if(empty($getKmcDataAlreadyExist)){
                                $dataValidStatus = 1;
                            }
                            else{
                                $dataValidStatus = 0;
                            }
                        }
                        else{
                            $dataValidStatus = 0;
                        }

                        //get last Baby AdmissionId
                        $this
                            ->db
                            ->order_by('id', 'desc');

                        $babyAdmisionLastId = $this
                            ->db
                            ->get_where('babyAdmission', array(
                            'babyId' => $request['babyId']
                        ))->row_array();

                        // check kmc data already exist 
                        //$getKmcDataAlreadyExist = $this->db->get_where('babyDailyKMC', array('babyAdmissionId'=>$babyAdmisionLastId['id'],'nurseId'=>$request['nurseId'],'startDate'=>$request['startDate'],'startTime'=>$request['startTime'],'endDate'=>$request['endDate'],'endTime'=>$request['endTime']))->row_array();

                        //if(empty($getKmcDataAlreadyExist)){
                            $checkDataForAllUpdate = 2;
                            $Start = $request['startTime'];
                            $End = $request['endTime'];
                            $array = array();
                            $array['androidUuid'] = $request['localId'];
                            //$array['babyId'] = $request['babyId'];
                            $array['nurseId'] = trim($request['nurseId']);

                            //$array['loungeId'] = $request['loungeId'];
                            $array['startTime'] = $request['startTime'];
                            $array['provider']  = $request['provider'];
                            $array['endDate']   =  $request['endDate'];
                            $array['endTime'] = $request['endTime'];
                            $array['startDate'] = date("Y-m-d", strtotime($request['startDate']));
                            $array['addDate'] = $request['localDateTime'];
                            $array['lastSyncedTime'] = date('Y-m-d H:i:s');
                            $array['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                            $array['latitude'] = (isset($request['latitude'])) ? trim($request['latitude']):NULL;
                            $array['longitude']  = (isset($request['longitude'])) ? trim($request['longitude']):NULL;
                            $array['isDataValid']  = $dataValidStatus;

                            $inserted = $this
                                ->db
                                ->insert('babyDailyKMC', $array);

                            $lastID = $this
                                ->db
                                ->insert_id();

                            $listID['id'] = $lastID;
                            $listID['localId'] = $request['localId'];
                            $param[] = $listID;

                            $motherData = $this
                                ->db
                                ->query("select MR.motherId, MR.motherName, BA.babyId FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.motherId = MR.motherId  where  BA.babyId ='" . $request['babyId'] . "'")->row_array();

                            // $getNurseData = $this
                            //     ->db
                            //     ->query("select name from staffMaster where staffId=" . trim($request['nurseId']) . "")->row_array();

                            $totalSscHrs = $this
                                ->db
                                ->query("select babyAdmissionId,@totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as totalSeconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where startTime < endTime and babyAdmissionId=" . $babyAdmisionLastId['id'] . " group by babyAdmissionId")->row_array();

                            $SscHrs = floor(($totalSscHrs['totalSeconds'] / 60) / 60);
                            $paramArray = array();
                            $paramArray['type'] = '4';
                            $paramArray['loungeId'] = $request['loungeId'];
                            $paramArray['babyAdmissionId'] = $babyAdmisionLastId['id'];
                            $paramArray['grantedForId'] = $lastID;
                            $paramArray['feed'] = "B/O " . (!empty($motherData['motherName']) ? $motherData['motherName'] : 'UNKNOWN') . " has been on KMC position for " . $SscHrs . " hrs today 8 AM onwards.";
                            $paramArray['status'] = '1';
                            $paramArray['addDate']  = date('Y-m-d H:i:s');
                            $paramArray['modifyDate']  = date('Y-m-d H:i:s');
                            $this
                                ->db
                                ->insert('timeline', $paramArray);

                            $this->BabyKmcPDF->KMCpdfGenerate($babyAdmisionLastId['id']);

                            /*$this
                                ->db
                                ->where('id', $babyAdmisionLastId['id']);
                            $this
                                ->db
                                ->update('babyAdmission', array(
                                'babyKMCPdfName' => $PdfName
                            ));*/
                        //}
                    }
                    else
                    { 
                        // set data valid status
                        if((strtotime($babyAdmissionData['admissionDateTime']) <= $kmcStartDateTime) && ($kmcEndDateTime >= $kmcStartDateTime) && (!empty($validateBabyId)) && (!empty($validateNurseId)) && (trim($request['nurseId']) != "0") && (trim($request['nurseId']) != "") && (trim($request['startDate']) != "0000-00-00") && (trim($request['startDate']) != "") && (trim($request['endDate']) != "0000-00-00") && (trim($request['endDate']) != "")){
                            $dataValidStatusUpdate = 1;
                        }
                        else{
                            $dataValidStatusUpdate = 0;
                        }

                        $Start = $request['startTime'];
                        $End = $request['endTime'];
                        $array = array();
                        $array['androidUuid'] = $request['localId'];
                        //$array['babyId'] = $request['babyId'];
                        $array['nurseId'] = trim($request['nurseId']);

                        //$array['loungeId'] = $request['loungeId'];
                        $array['startTime'] = $request['startTime'];
                        $array['provider'] = $request['provider'];
                        $array['endTime'] = $request['endTime'];
                        $array['endDate']   =  $request['endDate'];
                        $array['startDate'] = date("Y-m-d", strtotime($request['startDate']));
                        $array['addDate'] = $request['localDateTime'];
                        $array['lastSyncedTime']  = date('Y-m-d H:i:s');
                        $array['latitude'] = (isset($request['latitude'])) ? trim($request['latitude']):NULL;
                        $array['longitude']  = (isset($request['longitude'])) ? trim($request['longitude']):NULL;
                        $array['isDataValid']  = $dataValidStatusUpdate;

                        //get last Baby AdmissionId
                        $this
                            ->db
                            ->order_by('id', 'desc');

                        $babyAdmisionLastId = $this
                            ->db
                            ->get_where('babyAdmission', array(
                            'babyId' => $request['babyId']
                        ))->row_array();

                        $array['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;

                        $this
                            ->db
                            ->where('androidUuid', $request['localId']);

                        $this
                            ->db
                            ->update('babyDailyKMC', $array);

                        $lastID = $this
                            ->db
                            ->get_where('babyDailyKMC', array(
                            'androidUuid' => $request['localId']
                        ))->row_array();

                        $listID['id'] = $lastID['id'];
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;

                        $this->BabyKmcPDF->KMCpdfGenerate($babyAdmisionLastId['id']);

                        /*$PdfName = $this->generateBabyKMCPdfFile($request['loungeId'], $babyAdmisionLastId['id']);
                        $this
                            ->db
                            ->where('id', $babyAdmisionLastId['id']);
                        $this
                            ->db
                            ->update('babyAdmission', array(
                            'babyKMCPdfName' => $PdfName
                        ));*/
                    }
                //}
            }
            if ($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2)
            {
                $data['id'] = $param;
                generateServerResponse('1', 'S', $data);
            }
            else
            {
                generateServerResponse('0', '213');
            }
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }

    #  Get Suppliment List
    public function getSupplementList($request)
    {
        if ($request['userType'] == '0')
        {
            $request['loungeId'] = $request['loungeId'];
        }
        else
        {
            $loungeData = getStaffLoungeId($request['loungeId']); // call function using api_helper
            $request['loungeId'] = $loungeData['loungeId'];
        }
        # type 1 is for Fetchdata from BabySuppliment Table
        $this
            ->db
            ->order_by('id', 'desc');
        $getBabyAdmissionData = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId']
        ))->row_array();
        if ($request['type'] == '1')
        {
            //$Data = ($request['date']!='')? date('Y-m-d',strtotime($request['date'])) : date('Y-m-d');
            $date = ($request['date'] != '') ? date('Y-m-d', strtotime($request['date'])) : date('Y-m-d');
            $GetData = $this
                ->db
                ->get_where('prescriptionNurseWise', array(
                'babyId' => $request['babyId'],
                'loungeId' => $request['loungeId'],
                'FROM_UNIXTIME(addDate,"%Y-%m-%d")' => $date
            ))->result_array();

            $arrayName = array();
            if (count($GetData) > 0)
            {
                foreach ($GetData as $key => $value)
                {
                    $hold['name'] = $value['prescriptionName'];
                    $hold['quantity'] = $value['quantity'];
                    $hold['time'] = date("g:i A", $value['addDate']);
                    $hold['date'] = date("Y-m-d", $value['addDate']);

                    $arrayName[] = $hold;
                }
                $response['supplementList'] = $arrayName;
                $response['md5Data'] = md5(json_encode($response['supplementList']));
                generateServerResponse('1', 'S', $response);
            }
            else
            {
                generateServerResponse('0', 'E');
            }

        }
        elseif ($request['type'] == '2')
        {

            # type 2  is for Fetch data from Suppliment Master Table
            $GetData = $this
                ->db
                ->get_where('supplementMaster')
                ->result_array();

            $arrayName = array();
            foreach ($GetData as $key => $value)
            {
                $hold['id'] = $value['id'];
                $hold['name'] = $value['name'];
                $hold['time'] = $value['duration'];
                $arrayName[] = $hold;
            }
            $response['supplementList'] = $arrayName;
            $response['md5Data'] = md5(json_encode($response['supplementList']));
            ($response['suppliment_list'] > 0) ? generateServerResponse('2', 'S', $response) : generateServerResponse('0', 'E');

        }
    }

    public function generateBabyKMCPdfFile($loungeId, $lastID)
    {
        error_reporting(0);
        $getBabyAdmissionData = $this
            ->db
            ->get_where('babyAdmission', array(
            'id' => $lastID
        ))->row_array();

        $babyId = $getBabyAdmissionData['babyId'];
        $babyMotherDetails = $this
            ->db
            ->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '" . $babyId . "'")->row_array();

        $GetDay = $this
            ->db
            ->query("SELECT Distinct startDate FROM `babyDailyKMC` where  babyAdmissionId = '" . $getBabyAdmissionData['id'] . "'")->result_array();

        $html .= '<html>
        <head>
        <title>FORM C: DAILY KMC COMPLIANCE FORM</title>
        <style>
        table,th,td,tr{
            border-collapse:collapse;
        }

        </style>
        </head>
        <body>';
        $y = '0';
        foreach ($GetDay as $key => $value)
        {

            $html .= '<table style="width: 100%;margin-bottom: -11px;border-bottom:none;" >
            <tr><th style="text-align: center;font-family: sans-serif;" colspan= "7"><u><h3>FORM C: DAILY KMC COMPLIANCE FORM</h3></u></th></tr>
            <tr><td style="text-align: left; " colspan= "8"><strong ><i>Objective:</i></strong><i style="font-family: serif;"> To record the number of hour of KMC given to the baby admitted in the KMC unit in 24 hours (8AM - 8AM ), the duration of each session and the reason for not giving continuous KMC. To be collected by nurse on duty in KMC room via direct observation or from mother/caregiver</i> </td></tr>


            <tr>
            <td style="width: 100%;text-align: left; padding:5px ;font-family: sans-serif"  >
            <b style="margin-right: 40px" >Day:</b> ' . date('l', strtotime($value['startDate'])) . '
            <b style="margin-left: 30px" >Hospital Reg. No.:</b> ' . $getBabyAdmissionData['babyFileId'] . '  
            </td>
            </tr>
            <tr>
            <td style="width: 50%;text-align: left; padding:5px ;font-family: sans-serif" colspan= "3"><b>Date of Birth(dd/mm/yy) :</b>  ' . date("d/m/Y", strtotime($babyMotherDetails['deliveryDate'])) . '
            <b style="padding-left: 50px" >Mothers Name:</b> ' . $babyMotherDetails['motherName'] . ' </td>
            </tr>
            </table>



            <table style="margin-top:10px;border:1px solid;width: 100% " >

            <tr style="border:1px solid" >
            <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;"><b>S.No</b></td>
            <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Starting time<br>of KMC</b></td>
            <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Stopping time<br>of KMC</b></td>
            <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>duration of KMC per<br>episode</b><br><span>(if KMC duration>=1hour<br>then record in hours if <1<br>hour please record in<br> minutes)</span>
            </td>
            <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>reason for pausing KMC</b><br><span>(Breast feeding,doctorcheckup,mothers<br>mealtime,mothers personal care,family<br>visit,discomfort,complications,etc.)</span></td>
            <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>KMC<br>Provider</b></td>
            <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Name</b></td>
            <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"><b>Nurse<br>Signature</b></td>
            </tr>';

            $getKMCData = $this
                ->db
                ->query("SELECT * FROM `babyDailyKMC`  where  startDate = '" . $value['startDate'] . "' AND babyAdmissionId = '" . $getBabyAdmissionData['id'] . "'")->result_array();

            $i = 1;
            $Time = array();
            $rowCount = count($getKMCData) + 1;
            $getRowCount = 7 - $rowCount;

            foreach ($getKMCData as $key => $value2)
            {

                $nurseName = getSingleRowFromTable('name', 'staffId', $value2['nurseId'], 'staffMaster');
                $differ = getTimeDiff($value2['startTime'], $value2['endTime']);
                $html .= '<tr style="border:1px solid" >
                <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">' . $i . '</td>
                <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">' . date('g:i A', strtotime($value2['startTime'])) . '</td>
                <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">' . date('g:i A', strtotime($value2['endTime'])) . '</td>
                <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">' . $differ . '</td>
                <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">' . $value2['provider'] . '</td>
                <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;">' . $nurseName . '</td>
                <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                </tr>';

                $Time[] = $differ;
                $i++;
            }

            if (($getRowCount < 7) && ($getRowCount > 0))
            {
                for ($z = $rowCount;$z <= 8;$z++)
                {
                    $html .= '<tr style="border:1px solid" >  
                    <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">' . $z . '</td>
                    <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    <td style="width: 13%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    <td style="width: 20%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    <td style="width: 25%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    <td style="width: 8%;text-align: center;border:1px solid ; padding: 11px;border-bottom:none;"></td>
                    </tr>';
                }

            }

            $GetTotalTime = totalTime($Time);
            $html .= '<tr>
            <td style="text-align: left;width: 5.4%;border:1px solid "></td>
            <td style="text-align: left;padding:5px" colspan = "6" >
            Total KMC duration in 24 hours (8 am to 8 am):<br><br>
            ' . $GetTotalTime . '
            </td>
            <td style="text-align: left;width: 8.7%;border:1px solid "></td>
            </tr>
            </table>';
            $y++;
        }
        $html .= '</body>
        </html>';

        $pdfFilePath = pdfDirectory . "b_" . $getBabyAdmissionData['id'] . "_KMC.pdf";

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('utf-8', 'A4-L');

        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F");

        return "b_" . $getBabyAdmissionData['id'] . "_KMC.pdf";
    }


 // get skintoskin data via last admission id
    public function KMCListing($request, $starteDate)
    {
        if ($request['userType'] == '0')
        { //for lounge
            $request['loungeId'] = $request['loungeId'];
        }
        else
        { //for staff
            $loungeData = getStaffLoungeId($request['loungeId']); // call function using api_helper
            $request['loungeId'] = $loungeData['loungeId'];
        }
        $this
            ->db
            ->order_by('id', 'desc');
        $getBabyAdmissionData = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId']
        ))->row_array();

        return $this
            ->db
            ->query("SELECT * FROM `babyDailyKMC` WHERE `loungeId` = '" . $request['loungeId'] . "' AND `babyId` = '" . $request['babyId'] . "' AND `startDate`='" . $starteDate . "' AND `babyAdmissionId`='" . $getBabyAdmissionData['id'] . "'")->result_array();
    }

    /* Get Baby Breast Feeding Data via Date*/ //used
    public function breastFeedingList($request, $starteDate, $endDate)
    {

        if ($request['userType'] == '0')
        { //for lounge
            $request['loungeId'] = $request['loungeId'];
        }
        else
        { //for staff
            $loungeData = getStaffLoungeId($request['loungeId']); // call function using api_helper
            $request['loungeId'] = $loungeData['loungeId'];
        }

        $this
            ->db
            ->order_by('id', 'desc');
            
        $getBabyAdmissionData = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId']
        ))->row_array();

        return $this
            ->db
            ->query("SELECT * FROM `babyDailyNutrition` WHERE `loungeId` = '" . $request['loungeId'] . "' AND `babyId` = '" . $request['babyId'] . "' AND `addDate` between " . $starteDate . " And " . $endDate . " AND `babyAdmissionId`='" . $getBabyAdmissionData['id'] . "'")->result_array();
    }



    public function babyDailyFeedPDFFile($loungeId, $lastID)
    {
        error_reporting(0);
        $getBabyAdmissionData = $this
            ->db
            ->get_where('babyAdmission', array(
            'id' => $lastID
        ))->row_array();

        $babyId = $getBabyAdmissionData['babyId'];

        $babyMotherDetails = $this
            ->db
            ->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '" . $babyId . "'")->row_array();

        $age = $this->getAge($babyMotherDetails['deliveryDate']);

        $babyAge = ($age > 0) ? $age . ' days' : '_______________________';

        $html .= '<html>
        <head>
        <title>FORM B: DAILY INTAKE MONITORING RECORD</title>
        <style>
        table,th,td,tr{
            border-collapse:collapse;
        }

        td{
            width: 6%;text-align: center;border:1px solid ; padding: 13px;
        }

        </style>
        </head>
        <body>';
        $y = '0';

        $GetDay = $this
            ->db
            ->query("SELECT Distinct feedDate FROM `babyDailyNutrition` where babyAdmissionId = '" . $getBabyAdmissionData['id'] . "'")->result_array();

        //echo $this->db->last_query(); exit;
        foreach ($GetDay as $key => $value)
        {

            $html .= '<body>
            <div>
            <h2 style= "text-align:center"><u>FORM B: DAILY INTAKE MONITORING RECORD </u></h2>
            <p style="font-size: 14px"> <b>Objective:</b> To record the quantity and frequency of feeding of the baby admitted in the KMC unit in 24 hours (8 AM - 8 Am), so as to compare the total quantity to the total feeding requirement. To be filled by nurse on duty in the KMC </p>
            </div>
            <div>
            <div style=" padding-bottom: 5px; padding-top: 5px">
            <label> <b>Day :</b> ' . date('l', time()) . '</label> 
            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hospital Reg. No.:</b>  ' . $getBabyAdmissionData['babyFileId'] . '</label> 
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date (dd/mm/yyyy)</b>: ' . date('d/m/Y', strtotime($value['feedDate'])) . '</label>
            </div>

            <div>

            <div style=" padding-bottom: 5px; padding-top: 5px">
            <label> <b>Mother Name :</b>  ' . ucwords($babyMotherDetails['motherName']) . '</label> 
            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Baby age(in days):</b> ' . $babyAge . ' </label> 
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total feeding requirement for the day</b>: _________________________________</label>
            </div>

            <div>  

            <table width="100%" border="1" style="text-align: center">
            <tr>
            <th rowspan="3" style="width: 10px">S.No.</th>
            <th rowspan="3" style="width: 100px">Time of feeding<br>( From, to)</th>
            <th colspan="8" style="width: 650px">Feeding method and measurement <br>(fill in where applicable) </th>
            <th colspan="5" rowspan="2">Supplements Received<br>(name and dose)</th>
            <th rowspan="2" style="width: 80px">Nurse Signature</th>
            </tr>

            <tr>

            <th rowspan="2" style="width: 100px">Direct breast feeding (in min)  </th>
            <th rowspan="2" style="width: 100px">Expressed breast feed (EBF) (in ml)  </td>
            <th colspan="4">Mixed Feeding (in ml)</th>
            <th colspan="2">Other:* IV type</th>
            </tr>

            <tr>
            <th>EBF</th>
            <th>Formula</th>
            <th>Other</th>
            <th>Net</th>
            <th>In ml/hr</th>
            <th>In drop/min</th>
            <th>Vit D3</th>
            <th>Calcium</th>
            <th>HMF</th>
            <th>Iron</th>
            <th>Other</th>
            <th></th>
            </tr>';

            $getFeedingData = $this
                ->db
                ->query("SELECT * FROM `babyDailyNutrition` where feedDate = '" . $value['feedDate'] . "' AND babyAdmissionId = '" . $getBabyAdmissionData['id'] . "'")->result_array();

            $i = 1;

            $Time = array();
            $rowCount = count($getFeedingData) + 1;
            $getRowCount = 11 - $rowCount;

            /*$($value['feedingType'] ==1)? $*/

            foreach ($getFeedingData as $key => $value2)
            {

                $html .= '<tr>
                <td>' . $i . '</td>
                <td>' . date('g:i A', strtotime($value2['feedTime'])) . '</td>
                <td>' . $value2['breastFeedDuration'] . '</td>
                <td>' . $value2['milkQuantity'] . '</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>';
                $i++;
            }

            if (($getRowCount < 11) && ($getRowCount > 0))
            {
                for ($z = $rowCount;$z <= 11;$z++)
                {
                    $html .= '<tr style="border:1px solid" >  
                    <td style="width: 5%;text-align: center;border:1px solid; padding: 11px;border-bottom:none;">' . $z . '</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>';
                }
            }
            $html .= '</table>';
        }

        $html .= '</body>
        </html>';

        $pdfFilePath = pdfDirectory . "b_" . $getBabyAdmissionData['id'] . "_Feeding.pdf";

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('utf-8', 'A4-L');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($PDFContent);
        $mpdf->Output($pdfFilePath, "F");

        return "b_" . $getBabyAdmissionData['id'] . "_Feeding.pdf";
    }

    /*vaccination data post*/

    public function postBabyVaccination($request)
    {
        $countData = count($request['vaccinationData']);
        if ($countData > 0)
        {
            $param = array();
            $checkDataForAllUpdate = 1; // check for all data synced or not

            foreach ($request['vaccinationData'] as $key => $request)
            {
                $validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => trim($request['babyId'])))->row_array();
                $validateNurseId = $this->db->get_where('staffMaster', array('staffId' => trim($request['nurseId']),'staffType'=>2))->row_array();

                if(!empty($validateBabyId)){
                    $checkDuplicateData = $this
                        ->db
                        ->get_where('babyVaccination', array(
                        'androidUuid' => $request['localId']
                    ))->num_rows();

                    $checkDataForAllUpdate = 2;
                    $array = array();


                    $arrayName = array();
                    $arrayName['androidUuid'] = $request['localId'];
                    //$arrayName['babyId'] = $request['babyId'];
                    //$arrayName['loungeId'] = $request['loungeId'];
                    $arrayName['vaccinationName'] = $request['vaccinationName'];
                    $arrayName['quantity'] = $request['quantity'];
                    $arrayName['vaccinationDate'] = $request['date'];
                    $arrayName['VaccinationTime'] = $request['time'];
                    $arrayName['nurseId'] = $request['nurseId'];
                   

                    //get last Baby AdmissionId
                    $this
                        ->db
                        ->order_by('id', 'desc');
                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();

                    $arrayName['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;

                    if ($checkDuplicateData == 0)
                    {   
                        $arrayName['addDate'] = date('Y-m-d H:i:s');

                        $inserted = $this
                        ->db
                        ->insert('babyVaccination', $arrayName);
                        $lastInsertID            = $this->db->insert_id();

                        $lastID = $this
                            ->db
                            ->get_where('babyVaccination', array(
                            'androidUuid' => $request['localId']
                        ))->row_array();
                
                        $listID['id'] = $lastInsertID;
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;
                    }
                    else
                    { 
                        $inserted = $this
                        ->db
                        ->insert('babyVaccination', $arrayName);
                        $lastInsertID            = $this->db->insert_id();
                    //($inserted > 0) ? generateServerResponse('1', 'S') : generateServerResponse('0', 'E');

                        // $this
                        //     ->db
                        //     ->where('androidUuid', $request['localId']);
                        // $this
                        //     ->db
                        //     ->update('babyVaccination', $arrayName);

                        $lastID = $this
                            ->db
                            ->get_where('babyVaccination', array(
                            'androidUuid' => $request['localId']
                        ))->row_array();
                
                        $listID['id'] = $lastInsertID;
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;
                    }
                }
            }

            if ($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2)
            {
                $data['id'] = $param;
                generateServerResponse('1', 'S', $data);
            }
            else
            {
                generateServerResponse('0', '213');
            }
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }
    
    
    /*vaccination data get*/
    public function getBabyVaccination($request)
    {
        $this
            ->db
            ->order_by('id', 'DESC');
        $GetData = $this
            ->db
            ->get_where('babyVaccination', array(
            'babyId' => $request['babyId'],
            'loungeId' => $request['loungeId']
        ))->result_array();
        $arrayName = array();
        if (count($arrayName) > 0)
        {

            foreach ($GetData as $key => $value)
            {

                $Hold['id'] = $value['id'];
                $Hold['babyId'] = $value['babyId'];
                $Hold['loungeId'] = $value['loungeId'];
                $Hold['vaccinationName'] = $value['vaccinationName'];
                $Hold['date'] = $value['VaccinationDate'];
                $Hold['time'] = $value['VaccinationTime'];

                $arrayName[] = $Hold;
            }
        }

        $response['list'] = $arrayName;
        (count($response['list']) > 0) ? generateServerResponse('1', 'S', $response) : generateServerResponse('0', 'E');
    }

    public function getAge($date)
    {
        $now = time();
        $your_date = strtotime($date);
        $datediff = $now - $your_date;
        return round($datediff / (60 * 60 * 24));
    }

    public function motherBabyRegistration($request)
    {
        // check duplicateData
        $existData = $this
            ->db
            ->get_where('motherRegistration', array(
            'androidUuid' => $request['localId']
        ))->num_rows();

        if ($existData > 0)
        {
            generateServerResponse('0', '213');
        }

        $response = array();
        $arrayName = array();
        $deliveryPlace = '';

        $loungeData = $this
                ->db
                ->get_where('loungeMaster', array(
                'loungeId' => $request['loungeId']
            ))->row_array();

        $getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['staffId']))->row_array();

        if($request['type'] == '1'||$request['type'] == '3')
        {
            $arrayName['motherName'] = ($request['motherName'] != '') ? $request['motherName'] : NULL;
            $arrayName['isMotherAdmitted'] = ($request['isMotherAdmitted'] != '') ? $request['isMotherAdmitted'] : NULL;
            
            if ($request['isMotherAdmitted'] == 'Yes' || $request['isMotherAdmitted'] == 'yes')
            {
                $arrayName['motherPicture'] = ($request['motherPicture']) ? saveDynamicImage($request['motherPicture'], motherDirectory) : NULL;
            }
            else
            {
                $arrayName['notAdmittedReason'] = ($request['notAdmittedReason'] != '') ? $request['notAdmittedReason'] : NULL;
            }


            $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;

            // if ($request['type'] == '3')
            // {
            //     $arrayName['isMotherAdmitted'] = NULL;
            //     $arrayName['notAdmittedreason'] = NULL;
            // }

            $arrayName['motherMobileNumber'] = ($request['motherMobileNumber'] != '') ? $request['motherMobileNumber'] : NULL;
            $arrayName['motherLmpDate'] = ($request['motherLmpDate'] != '') ? $request['motherLmpDate'] : NULL;
            
            $arrayName['type'] = ($request['type'] != '') ? $request['type'] : NULL;
            // $arrayName['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
            $arrayName['status'] = '1'; 
            $arrayName['addDate'] = date('Y-m-d H:i:s');
            $arrayName['modifyDate'] = date('Y-m-d H:i:s');

            $arrayName['guardianRelation']  = ($request['guardianRelation'] != '') ? $request['guardianRelation'] : NULL;
            $arrayName['guardianRelationOther']  = ($request['guardianRelationOther'] != '') ? $request['guardianRelationOther'] : NULL;
            $arrayName['guardianName']      = ($request['guardianName'] != '') ? $request['guardianName'] : NULL;
            $arrayName['guardianNumber']    = ($request['guardianNumber'] != '') ? $request['guardianNumber'] : NULL;

            $resultArray = isBlankOrNull($arrayName);
            $inserted = $this
                ->db
                ->insert('motherRegistration', $resultArray);
            $motherId = $this
                ->db
                ->insert_id();


            // generate log history
            $paramArray                         = array();
            $paramArray['tableReference']       = '4';
            $paramArray['tableReferenceId']     = $motherId;
           
            $paramArray['remark']               = $getNurseName['name']." has registered a new mother at ".date('d M Y, g:i A',strtotime(date('Y-m-d H:i:s'))).".";
            
            // $paramArray['latitude']             = $request['latitude'];
            // $paramArray['longitude']            = $request['longitude'];
            $paramArray['addDate']              = date('Y-m-d H:i:s');
            $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
            $this->db->insert('logHistory',$paramArray);
            
            $response['motherId'] = $motherId;

            $mother = array();
            $mother['motherId'] = $motherId;
            $mother['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
            $mother['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;

            // type 1= SNCU, 2= Lounges
            // if ($loungeData['type'] == 1)
            // {
            //     $mother['hospitalRegistrationNumber'] = NULL ;
            //     $mother['temporaryFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            // }
            // else
            // {
            //     $mother['temporaryFileId'] =  NULL ;
            //     $mother['hospitalRegistrationNumber'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            // }
            $mother['status'] = '4'; // for draft status
            $mother['addDate'] = date('Y-m-d H:i:s');
            $mother['modifyDate'] = date('Y-m-d H:i:s');

            if ($request['type'] == '1'){

                $mother_addmission = $this
                    ->db
                    ->insert('motherAdmission', $mother);

                $response['motherAdmissionId'] = $this
                    ->db
                    ->insert_id();
            



                // generate log history
                $paramArray                         = array();
                $paramArray['tableReference']       = '5';
                $paramArray['tableReferenceId']     = $response['motherAdmissionId'];
               
                $paramArray['remark']               = $getNurseName['name']." has admitted a new mother at ".date('d M Y, g:i A',strtotime(date('Y-m-d H:i:s'))).".";
                
                // $paramArray['latitude']             = $request['latitude'];
                // $paramArray['longitude']            = $request['longitude'];
                $paramArray['addDate']              = date('Y-m-d H:i:s');
                $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
                $this->db->insert('logHistory',$paramArray);
            }
        }
        else if($request['type'] == '2')
        {
            $arrayName['motherName'] = ($request['motherName'] != '') ? $request['motherName'] : NULL;
            $arrayName['isMotherAdmitted'] = ($request['isMotherAdmitted'] != '') ? $request['isMotherAdmitted'] : NULL;
            
            if ($request['isMotherAdmitted'] == 'Yes' || $request['isMotherAdmitted'] == 'yes')
            {
                $arrayName['motherPicture'] = ($request['motherPicture']) ? saveDynamicImage($request['motherPicture'], motherDirectory) : NULL;
            }
            else
            {
                $arrayName['notAdmittedReason'] = ($request['notAdmittedReason'] != '') ? $request['notAdmittedReason'] : NULL;
            }
            
            $arrayName['androidUuid']       = ($request['localId'] != '') ? $request['localId'] : NULL;
            $arrayName['guardianRelation']  = ($request['guardianRelation'] != '') ? $request['guardianRelation'] : NULL;
            $arrayName['guardianRelationOther']  = ($request['guardianRelationOther'] != '') ? $request['guardianRelationOther'] : NULL;
            $arrayName['guardianName']      = ($request['guardianName'] != '') ? $request['guardianName'] : NULL;
            $arrayName['guardianNumber']    = ($request['guardianNumber'] != '') ? $request['guardianNumber'] : NULL;
            $arrayName['organisationName']  = ($request['organisationName'] != '') ? $request['organisationName'] : NULL;
            $arrayName['organisationNumber'] = ($request['organisationNumber'] != '') ? $request['organisationNumber'] : NULL;
            $arrayName['organisationAddress'] = ($request['organisationAddress'] != '') ? $request['organisationAddress'] : NULL;
            $arrayName['motherLmpDate'] = ($request['motherLmpDate'] != '') ? $request['motherLmpDate'] : NULL;
            
            $arrayName['type'] = ($request['type'] != '') ? $request['type'] : NULL;
            // $arrayName['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
            $arrayName['status'] = '1'; 
            $arrayName['addDate'] = date('Y-m-d H:i:s');
            $arrayName['modifyDate'] = date('Y-m-d H:i:s');

            $resultArray = isBlankOrNull($arrayName);
            $inserted = $this
                ->db
                ->insert('motherRegistration', $resultArray);
            $motherId = $this
                ->db
                ->insert_id();

            // generate log history
            $paramArray                         = array();
            $paramArray['tableReference']       = '4';
            $paramArray['tableReferenceId']     = $motherId;
           
            $paramArray['remark']               = $getNurseName['name']." has registered a new mother at ".date('d M Y, g:i A',strtotime(date('Y-m-d H:i:s'))).".";
            
            // $paramArray['latitude']             = $request['latitude'];
            // $paramArray['longitude']            = $request['longitude'];
            $paramArray['addDate']              = date('Y-m-d H:i:s');
            $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
            $this->db->insert('logHistory',$paramArray);
            
            $response['motherId'] = $motherId;
            $response['motherAdmissionId']='';

        }

        $existData = $this
            ->db
            ->get_where('babyRegistration', array(
            'androidUuid' => $request['localId']
        ))->num_rows();

        if ($existData > 0)
        {
            generateServerResponse('0', '213');
        }

        $arrayName = array();

        $arrayName['motherId'] = $response['motherId'];
        
        $arrayName['deliveryDate'] = ($request['deliveryDate'] != '') ? $request['deliveryDate'] : NULL;
        $arrayName['deliveryTime'] = ($request['deliveryTime'] != '') ? $request['deliveryTime'] : NULL;
        $arrayName['babyGender'] = ($request['babyGender'] != '') ? $request['babyGender'] : NULL;
        $arrayName['deliveryType'] = ($request['deliveryType'] != '') ? $request['deliveryType'] : NULL;
        $arrayName['typeOfBorn'] = ($request['typeOfBorn'] != '') ? $request['typeOfBorn'] : NULL;
        // $arrayName['typeOfOutBorn'] = ($request['typeOfOutBorn'] != '') ? $request['typeOfOutBorn'] : NULL;
        $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;

        if ($request['birthWeightAvail'] == '1')
        {
            $arrayName['birthWeightAvail'] = '1';
            $arrayName['babyWeight'] = $request['babyWeight'];
        }
        else
        {
            $arrayName['birthWeightAvail'] = '2';
            $arrayName['babyWeight'] = NULL;
            $arrayName['reason'] = $request['reason'];
        }
        
        $arrayName['babyPhoto'] = ($request['babyPhoto'] != '') ? saveDynamicImage($request['babyPhoto'], babyDirectory) : NULL;
        $arrayName['registrationDateTime'] = date('Y-m-d H:i:s');
        $arrayName['status'] = '1'; 
        $arrayName['addDate'] = date('Y-m-d H:i:s');
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        $inserted = $this
            ->db
            ->insert('babyRegistration', $arrayName);

        $babyId = $this
            ->db
            ->insert_id();

        // generate log history
        $paramArray                         = array();
        $paramArray['tableReference']       = '6';
        $paramArray['tableReferenceId']     = $babyId;
       
        $paramArray['remark']               = $getNurseName['name']." has registered a new baby at ".date('d M Y, g:i A',strtotime(date('Y-m-d H:i:s'))).".";
        
        // $paramArray['latitude']             = $request['latitude'];
        // $paramArray['longitude']            = $request['longitude'];
        $paramArray['addDate']              = date('Y-m-d H:i:s');
        $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
        $this->db->insert('logHistory',$paramArray);

        $fileName = "b_" . $babyId . ".pdf";

        // check Unknown Case
        // $checkUnknownCase = $this
        //     ->db
        //     ->get_where('motherRegistration', array(
        //     'motherId' => $response['motherId']
        // ))->row_array();

        // if ($checkUnknownCase['type'] == '2')
        // {
        //     $this
        //         ->db
        //         ->where('motherId', $response['motherId']);
        //     $this
        //         ->db
        //         ->update('motherAdmission', array(
        //         'loungeId' => $request['loungeId']
        //     ));
        // }

        if ($inserted > 0)
        {
            $baby = array();
            $baby['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
            $baby['babyId'] = $babyId;
            $baby['admissionDateTime'] = date('Y-m-d : H:i:s');
            $baby['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
            $baby['staffId'] = ($request['staffId'] != '') ? $request['staffId'] : NULL;

            // type 1= SNCU, 2= Lounges
            if ($loungeData['type'] == 1)
            {
                $baby['babyFileId'] = NULL ;
                $baby['temporaryFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            }
            else
            {
                $baby['temporaryFileId'] = NULL ; 
                $baby['babyFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            }
            $baby['infantComingFrom'] = ($request['infantComingFrom']) ? $request['infantComingFrom'] : NULL;
            $baby['infantComingFromOther'] = ($request['infantComingFromOther']) ? $request['infantComingFromOther'] : NULL;
            $baby['addDate'] = date('Y-m-d H:i:s');
            $baby['status'] = '4'; // for draft status
            $baby['modifyDate'] = date('Y-m-d H:i:s');

            $badyAdmission = $this
                ->db
                ->insert('babyAdmission', $baby);
            $babyLastInsertedId = $this
                ->db
                ->insert_id();

            // generate log history
            $paramArray                         = array();
            $paramArray['tableReference']       = '7';
            $paramArray['tableReferenceId']     = $babyLastInsertedId;
           
            $paramArray['remark']               = $getNurseName['name']." has admitted a new baby at ".date('d M Y, g:i A',strtotime(date('Y-m-d H:i:s'))).".";
            
            // $paramArray['latitude']             = $request['latitude'];
            // $paramArray['longitude']            = $request['longitude'];
            $paramArray['addDate']              = date('Y-m-d H:i:s');
            $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
            $this->db->insert('logHistory',$paramArray);

            if ($request['birthWeightAvail'] == '1')
            {
                ############# ENTRY OF BABY WEIGTH IN babyDailyWeight Table #################
                $baby_weigth = array();
                //$baby_weigth['babyId'] = $babyId;
                $baby_weigth['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
                //$baby_weigth['loungeId'] =  ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
                $baby_weigth['isDeviceAvailAndWorking'] = 'Yes';
                $baby_weigth['babyAdmissionId'] = $babyLastInsertedId;
                $baby_weigth['babyWeight'] = $request['babyWeight'];
                $baby_weigth['weightDate'] = $request['deliveryDate'];
                $baby_weigth['addDate'] = date('Y-m-d H:i:s');
                $this
                    ->db
                    ->insert('babyDailyWeight', $baby_weigth);
            }       

            $response['babyAdmissionId'] = $babyLastInsertedId;
            $response['babyId'] = $babyId;
            generateServerResponse('1', '129', $response);
        }
    }

    public function multipleBabyRegistration($request)
    {
        $response = array();
        $arrayName = array();
        $deliveryPlace = '';

        $loungeData = $this
                ->db
                ->get_where('loungeMaster', array(
                'loungeId' => $request['loungeId']
            ))->row_array();


        $existData = $this
            ->db
            ->get_where('babyRegistration', array(
            'androidUuid' => $request['localId']
        ))->num_rows();

        if ($existData > 0)
        {
            generateServerResponse('0', '213');
        }

        $arrayName = array();

        $arrayName['motherId'] = $request['motherId'];
        $arrayName['deliveryDate'] = ($request['deliveryDate'] != '') ? $request['deliveryDate'] : NULL;
        $arrayName['deliveryTime'] = ($request['deliveryTime'] != '') ? $request['deliveryTime'] : NULL;
        $arrayName['babyGender'] = ($request['babyGender'] != '') ? $request['babyGender'] : NULL;
        $arrayName['deliveryType'] = ($request['deliveryType'] != '') ? $request['deliveryType'] : NULL;
        $arrayName['typeOfBorn'] = ($request['typeOfBorn'] != '') ? $request['typeOfBorn'] : NULL;
        $arrayName['typeOfOutBorn'] = ($request['typeOfOutBorn'] != '') ? $request['typeOfOutBorn'] : NULL;
        $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;

        if ($request['birthWeightAvail'] == '1')
        {
            $arrayName['birthWeightAvail'] = '1';
            $arrayName['babyWeight'] = $request['babyWeight'];
        }
        else
        {
            $arrayName['birthWeightAvail'] = '2';
            $arrayName['babyWeight'] = NULL;
            $arrayName['reason'] = $request['reason'];
        }
        
        $arrayName['babyPhoto'] = ($request['babyPhoto'] != '') ? saveDynamicImage($request['babyPhoto'], babyDirectory) : NULL;
        $arrayName['registrationDateTime'] = date('Y-m-d H:i:s');
        $arrayName['addDate'] = date('Y-m-d H:i:s');
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        $inserted = $this
            ->db
            ->insert('babyRegistration', $arrayName);

        $babyId = $this
            ->db
            ->insert_id();

        if ($inserted > 0)
        {
            $baby = array();
            $baby['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
            $baby['babyId'] = $babyId;
            $baby['admissionDateTime'] = date('Y-m-d : H:i:s');
            $baby['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;

            // type 1= SNCU, 2= Lounges
            if ($loungeData['type'] == 1)
            {
                $baby['babyFileId'] = NULL ;
                $baby['temporaryFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            }
            else
            {
                $baby['temporaryFileId'] = NULL ; 
                $baby['babyFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            }

            $baby['addDate'] = date('Y-m-d H:i:s');
            $baby['status'] = '1';
            $baby['modifyDate'] = date('Y-m-d H:i:s');

            $badyAdmission = $this
                ->db
                ->insert('babyAdmission', $baby);
            $babyLastInsertedId = $this
                ->db
                ->insert_id();

            if ($request['birthWeightAvail'] == '1')
            {
                ############# ENTRY OF BABAY WEIGTH IN babyDailyWeight Table #################
                $baby_weigth = array();
                //$baby_weigth['babyId'] = $babyId;
                $baby_weigth['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
                //$baby_weigth['loungeId'] =  ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
                $baby_weigth['isDeviceAvailAndWorking'] = 'Yes';
                $baby_weigth['babyAdmissionId'] = $babyLastInsertedId;
                $baby_weigth['babyWeight'] = $request['babyWeight'];
                $baby_weigth['weightDate'] = $request['deliveryDate'];
                $baby_weigth['addDate'] = date('Y-m-d H:i:s');
                $this
                    ->db
                    ->insert('babyDailyWeight', $baby_weigth);
            }       

            $response['babyAdmissionId'] = $babyLastInsertedId;
            $response['babyId'] = $babyId;
            generateServerResponse('1', '129', $response);
        }
    }


    // baby daily monitoring
    public function AdmissionTimeMonitoring($request)
    {
        $countData = count($request['monitoringData']);
        //get last mother AdmissionId
        if ($countData > 0)
        {
            $param = array();
            $checkSyncedData = 1; // check for all data synced or not
            foreach ($request['monitoringData'] as $key => $request)
            {

                $checkSyncedData = 2;
                //get last Baby AdmissionId
                $this
                    ->db
                    ->order_by('id', 'desc');

                $babyAdmisionLastId = $this
                    ->db
                    ->get_where('babyAdmission', array(
                    'babyId' => $request['babyId']
                ))->row_array();

                $getCount = $this
                        ->db
                        ->query("SELECT * FROM babyDailyMonitoring where babyAdmissionId ='" . $babyAdmisionLastId['id'] . "'")->num_rows();


                $paramsArray['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                $paramsArray['staffId'] = $request['staffId'];
                //$paramsArray['loungeId'] = $request['loungeId'];
                //$paramsArray['babyId'] = $request['babyId'];
                $paramsArray['staffSign'] = ($request['staffSign'] != '') ? saveImage($request['staffSign'], signDirectory) : 'NULL';
                $paramsArray['androidUuid'] = $request['localId'];

                $paramsArray['isThermometerAvailable'] = $request['isThermometerAvailable'];

                if ($request['isThermometerAvailable'] == 'Yes')
                {
                    $paramsArray['temperatureValue']    = $request['temperatureValue'];
                    $paramsArray['temperatureUnit']     = $request['temperatureUnit'];
                }
                else
                {
                    $paramsArray['temperatureValue']    = NULL;
                    $paramsArray['temperatureUnit']     = NULL;
                }

                $paramsArray['reasonValue'] = $request['reasonValue'];
                $paramsArray['otherValue'] = $request['otherValue'];
                $paramsArray['pulseReasonValue'] = $request['pulseReasonValue'];
                $paramsArray['pulseOtherValue'] = $request['pulseOtherValue'];
                //$paramsArray['crtReason'] = $request['crtReason'];
                //$paramsArray['crtOtherReason'] = $request['crtOtherReason'];

                $paramsArray['respiratoryRate'] = $request['respiratoryRate'];
                $paramsArray['isPulseOximatoryDeviceAvail'] = $request['isPulseOximatoryDeviceAvail'];
                if ($request['isPulseOximatoryDeviceAvail'] == 'Yes')
                {
                    $paramsArray['spo2'] = $request['spo2'];
                    $paramsArray['pulseRate'] = $request['pulseRate'];
                }
                else
                {
                    $paramsArray['spo2'] = NULL;
                    $paramsArray['pulseRate'] = NULL;
                }

                $paramsArray['crtKnowledge']        = ($request['crtKnowledge'] != '') ? $request['crtKnowledge'] : NULL;
                $paramsArray['isCrtGreaterThree']   = ($request['isCrtGreaterThree'] != '') ? $request['isCrtGreaterThree'] : NULL;

                
                $paramsArray['tone']            = ($request['tone'] != '') ? $request['tone'] : NULL;
                $paramsArray['alertness']       = ($request['alertness'] != '') ? $request['alertness'] : NULL;
                $paramsArray['color']           = ($request['color'] != '') ? $request['color'] : NULL;
                

                $paramsArray['apneaOrGasping']  = ($request['apneaGasping'] != '') ? $request['apneaGasping'] : NULL;
                $paramsArray['grunting']        = ($request['grunting'] != '') ? $request['grunting'] : NULL;
                $paramsArray['chestIndrawing']  = ($request['chestIndrawing'] != '') ? $request['chestIndrawing'] : NULL;

                $paramsArray['interestInFeeding']   = ($request['interestInFeeding'] != '') ? $request['interestInFeeding'] : NULL;
                $paramsArray['sufficientLactation'] = ($request['sufficientLactation'] != '') ? $request['sufficientLactation'] : NULL;
                $paramsArray['sucking']         = ($request['sucking'] != '') ? $request['sucking'] : NULL;

                $paramsArray['umbilicus']       = ($request['umbilicus'] != '') ? $request['umbilicus'] : NULL;
                $paramsArray['skinPustules']    = ($request['skinPustules'] != '') ? $request['skinPustules'] : NULL;

                
                

                $paramsArray['bulgingAnteriorFontanel']     = ($request['bulgingAnteriorFontanel'] != '') ? $request['bulgingAnteriorFontanel'] : NULL;

                
                $paramsArray['isBleeding']                  = ($request['isBleeding'] != '') ? $request['isBleeding'] : NULL;

                $paramsArray['urinePassedIn24Hrs']          = ($request['urinePassedIn24Hrs'] != '') ? $request['urinePassedIn24Hrs'] : NULL;
                $paramsArray['stoolPassedIn24Hrs']          = ($request['stoolPassedIn24Hrs'] != '') ? $request['stoolPassedIn24Hrs'] : NULL;
                

                $paramsArray['status'] = '1';
                $paramsArray['assesmentDate'] = date('Y-m-d');
                $paramsArray['assesmentNumber'] = $getCount + 1;
                $paramsArray['assesmentTime'] = date('H:i');
                $paramsArray['addDate'] = $request['localDateTime'];
                $paramsArray['lastSyncedTime']  = date('Y-m-d H:i:s');
                $paramsArray['modifyDate']  = $request['localDateTime'];

                $returnArray = isBlankOrNull($paramsArray);

                // update baby and mother status

                $babyArray['convulsions']   = ($request['convulsions'] != '') ? $request['convulsions'] : NULL;
                $babyArray['gestationalAge']  = ($request['gestationalAge'] != '') ? $request['gestationalAge'] : NULL;
                $babyArray['isAnyComplicationAtBirth']    = ($request['isAnyComplicationAtBirth'] != '') ? $request['isAnyComplicationAtBirth'] : NULL;
                $babyArray['otherComplications']    = ($request['otherComplications'] != '') ? $request['otherComplications'] : NULL;
                
                $babyArray['status']        = $request['status'];
                $babyArray['modifyDate']    = $request['localDateTime'];
                // $babyArray['lastSyncedTime']  = date('Y-m-d H:i:s');

                $this->db->where(array('id' => $babyAdmisionLastId['id']));
                $this->db->update('babyAdmission', $babyArray);

                $babyRegistrationData = $this
                    ->db
                    ->get_where('babyRegistration', array(
                    'babyId' => $request['babyId']
                ))->row_array();

                $motherId = $babyRegistrationData['motherId'];

                $motherArray['status']        = $request['status'];
                $motherArray['modifyDate']    = $request['localDateTime'];
                // $motherArray['lastSyncedTime']  = date('Y-m-d H:i:s');

                $this->db->where(array('motherId' => $motherId));
                $this->db->update('motherAdmission', $motherArray);

                // update baby and mother status


                $checkDuplicateData = $this
                    ->db
                    ->get_where('babyDailyMonitoring', array(
                    'androidUuid' => $request['localId']
                ))->num_rows();

                if ($checkDuplicateData == 0)
                {
                
                    $insert = $this
                        ->db
                        ->insert('babyDailyMonitoring', $returnArray);

                    $lastAssessmentId = $this
                        ->db
                        ->insert_id();
                    $listID['id'] = $lastAssessmentId;
                    $listID['localId'] = $request['localId'];
                    $param[] = $listID;

                    // generate log history
                    $getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['staffId']))->row_array();

                    $logArray                         = array();
                    $logArray['tableReference']       = '9';
                    $logArray['tableReferenceId']     = $lastAssessmentId;
                    
                    $logArray['remark']               = $getNurseName['name']." has completed the baby assessment at the time of admission at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
                    
                    $logArray['latitude']             = $request['latitude'];
                    $logArray['longitude']            = $request['longitude'];
                    $logArray['addDate']              = $request['localDateTime'];
                    $logArray['lastSyncedTime']       = date('Y-m-d H:i:s');
                    $this->db->insert('logHistory',$logArray);  
                    

                    $getMotherData = $this
                        ->db
                        ->query("select MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId` where  BA.`babyId` ='" . $request['babyId'] . "'")->row_array();

                    $getNurseData = $this
                        ->db
                        ->query("select name from staffMaster where staffId=" . $request['staffId'] . "")->row_array();

                    // create feed
                    $param1Array = array();
                    $param1Array['type'] = '3';
                   // $param1Array['loungeId'] = $request['loungeId'];
                    $param1Array['babyAdmissionId'] = $babyAdmisionLastId['id'];
                    $param1Array['grantedForId'] = $lastAssessmentId;
                    $param1Array['feed'] = "B/O " . (!empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'UNKNOWN') . " routine assessment has been done by " . $getNurseData['name'] . ".";
                    $param1Array['status'] = '1';
                    $param1Array['addDate']  = date('Y-m-d H:i:s');
                    $param1Array['modifyDate'] = date('Y-m-d H:i:s');

                    $this
                        ->db
                        ->insert('timeline', $param1Array);

                    $motherData = $this
                        ->db
                        ->query("SELECT MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId`  where  BA.`babyId` ='" . $request['babyId'] . "'")->row_array();
                        
                    $loungeName = getSingleRowFromTable('loungeName', 'loungeId', $request['loungeId'], 'loungeMaster');
                    
                    
                }
                else
                {
                    $this
                        ->db
                        ->where('androidUuid', $request['localId']);
                    $this
                        ->db
                        ->update('babyDailyMonitoring', $paramsArray);
                    $lastAssessmentId = $this
                        ->db
                        ->get_where('babyDailyMonitoring', array(
                        'androidUuid' => $request['localId']
                    ))->row_array();

                    // generate log history
                    $getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['staffId']))->row_array();

                    $logArray                         = array();
                    $logArray['tableReference']       = '9';
                    
                    $logArray['remark']               = $getNurseName['name']." has completed the baby assessment at the time of admission at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
                    
                    $logArray['latitude']             = $request['latitude'];
                    $logArray['longitude']            = $request['longitude'];
                    $logArray['addDate']              = $request['localDateTime'];
                    $logArray['lastSyncedTime']       = date('Y-m-d H:i:s');
                    $this->db->where(array('tableReferenceId' => $lastAssessmentId['id'], 'tableReference' => '9'));
                    $this->db->update('logHistory', $logArray);
                    

                    $listID['id'] = $lastAssessmentId['id'];
                    $listID['localId'] = $request['localId'];
                    $param[] = $listID;
                }

            }
        }
        if ($checkSyncedData == 1 || $checkSyncedData == 2)
        {
            $date['id'] = $param;
            generateServerResponse('1', 'S', $date);
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }


    public function BabyReferral($request){
        
        $param = array();
        $arrayName = array();
        
        $arrayName['referredFacility']      = $request['referredFacility'];
        $arrayName['referredFacilityAddress']   = $request['referredFacilityAddress'];
        $arrayName['referredDistrict']          = $request['referredDistrict'];
        $arrayName['dischargeByNurse']          = $request['nurseId'];
        $arrayName['modifyDate']                = date('Y-m-d H:i:s');
        $arrayName['status']                    = '3'; // for referred status

        $this
            ->db
            ->where('babyId', $request['babyId']);
        $res = $this
            ->db
            ->update('babyAdmission', $arrayName);

        $listID['babyId'] = $request['babyId'];
        $param[] = $listID;
            
        

        if ($res == 1)
        {
            $data['id'] = $param;
            generateServerResponse('1', 'S', $data);
        }
        else
        {
            generateServerResponse('0', '213');
        }
        
    }


    public function BaselineMeasurements($request){
        $param = array();
        $arrayName = array();
        
        $arrayName['babyAdmissionWeight']               = ($request['babyAdmissionWeight'] != '') ? $request['babyAdmissionWeight'] : NULL;
        $arrayName['isLengthMeasurngTapeAvailable']     = ($request['isLengthMeasurngTapeAvailable'] != '') ? $request['isLengthMeasurngTapeAvailable'] : NULL;
        if($request['isLengthMeasurngTapeAvailable'] == 'Yes'){
            $arrayName['lengthValue']                       = ($request['lengthValue'] != '') ? $request['lengthValue'] : NULL;
        } else {
            $arrayName['lengthValue']                       = NULL;
            $arrayName['lengthMeasureNotAvlReason']         = ($request['lengthMeasureNotAvlReason'] != '') ? $request['lengthMeasureNotAvlReason'] : '';
            $arrayName['lengthMeasureNotAvlReasonOther']    = ($request['lengthMeasureNotAvlReasonOther'] != '') ? $request['lengthMeasureNotAvlReasonOther'] : '';
        }
        $arrayName['isHeadMeasurngTapeAvailable']       = ($request['isHeadMeasurngTapeAvailable'] != '') ? $request['isHeadMeasurngTapeAvailable'] : NULL;
        if($request['isHeadMeasurngTapeAvailable'] == 'Yes'){
            $arrayName['headCircumferenceVal']              = ($request['headCircumferenceVal'] != '') ? $request['headCircumferenceVal'] : NULL;
        } else {
            $arrayName['headCircumferenceVal']              = NULL;
            $arrayName['headMeasureNotAvlReason']           = ($request['headMeasureNotAvlReason'] != '') ? $request['headMeasureNotAvlReason'] : '';
            $arrayName['headMeasureNotAvlReasonOther']      = ($request['headMeasureNotAvlReasonOther'] != '') ? $request['headMeasureNotAvlReasonOther'] : '';
        }
        
        $arrayName['modifyDate']                        = date('Y-m-d H:i:s');
        

        $this
            ->db
            ->where(array('status' => 1, 'babyId' => $request['babyId']));
        $res = $this
            ->db
            ->update('babyAdmission', $arrayName);

        $listID['babyId'] = $request['babyId'];
        $param[] = $listID;

        $this->db->order_by('id','DESC');
        $getAdmittedBaby = $this->db->get_where('babyAdmission', array('babyId' => $request['babyId'], 'status' => 1))->row_array();

        if(!empty($request['babyAdmissionWeight'])){

            $baby_weigth = array();
            $baby_weigth['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
            $baby_weigth['nurseId']     =  ($request['nurseId'] != '') ? $request['nurseId'] : NULL;
            $baby_weigth['isDeviceAvailAndWorking'] = 'Yes';
            $baby_weigth['babyAdmissionId']         = $getAdmittedBaby['id'];
            $baby_weigth['babyWeight']  = $request['babyAdmissionWeight'];
            $baby_weigth['weightDate']  = $request['weightDate'];
            $baby_weigth['addDate']     = $request['localDateTime'];
            $baby_weigth['latitude']    = ($request['latitude'] != '') ? $request['latitude'] : NULL;
            $baby_weigth['longitude']   =  ($request['longitude'] != '') ? $request['longitude'] : NULL;
            $baby_weigth['lastSyncedTime']          = date('Y-m-d H:i:s');
            $this
                ->db
                ->insert('babyDailyWeight', $baby_weigth);

        }
            
        

        if ($res == 1)
        {
            $data['id'] = $param;
            generateServerResponse('1', 'S', $data);
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }


     // baby daily monitoring
    public function babyMonitoring($request)
    {
        $countData = count($request['monitoringData']);
        //get last mother AdmissionId
        if ($countData > 0)
        {
            $param = array();
            $checkSyncedData = 1; // check for all data synced or not
            foreach ($request['monitoringData'] as $key => $request)
            {
                $validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => trim($request['babyId'])))->row_array();
                $validateStaffId = $this->db->get_where('staffMaster', array('staffId' => trim($request['staffId'])))->row_array();

                if((!empty($validateBabyId)) && (!empty($validateStaffId)) && (trim($request['staffId']) != "0") && (trim($request['staffId']) != "")){

                    $checkSyncedData = 2;
                    //get last Baby AdmissionId
                    $this
                        ->db
                        ->order_by('id', 'desc');

                    $babyAdmisionLastId = $this
                        ->db
                        ->get_where('babyAdmission', array(
                        'babyId' => $request['babyId']
                    ))->row_array();

                    $getCount = $this
                            ->db
                            ->query("SELECT * FROM babyDailyMonitoring where babyAdmissionId ='" . $babyAdmisionLastId['id'] . "'")->num_rows();
                    

                    $paramsArray['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
                    $paramsArray['staffId'] = $request['staffId'];
                    //$paramsArray['loungeId'] = $request['loungeId'];
                    //$paramsArray['babyId'] = $request['babyId'];
                    $paramsArray['staffSign'] = ($request['staffSign'] != '') ? saveImage($request['staffSign'], signDirectory) : 'NULL';
                    $paramsArray['androidUuid'] = $request['localId'];

                    $paramsArray['isThermometerAvailable'] = $request['isThermometerAvailable'];

                    if ($request['isThermometerAvailable'] == 'Yes')
                    {
                        $paramsArray['temperatureValue']    = $request['temperatureValue'];
                        $paramsArray['temperatureUnit']     = $request['temperatureUnit'];
                    }
                    else
                    {
                        $paramsArray['temperatureValue']    = NULL;
                        $paramsArray['temperatureUnit']     = NULL;
                    }

                    $paramsArray['respiratoryRate'] = $request['respiratoryRate'];
                    $paramsArray['isPulseOximatoryDeviceAvail'] = $request['isPulseOximatoryDeviceAvail'];
                    if ($request['isPulseOximatoryDeviceAvail'] == 'Yes')
                    {
                        $paramsArray['spo2'] = $request['spo2'];
                        $paramsArray['pulseRate'] = $request['pulseRate'];
                    }
                    else
                    {
                        $paramsArray['spo2'] = NULL;
                        $paramsArray['pulseRate'] = NULL;
                    }

                    $paramsArray['crtKnowledge']        = ($request['crtKnowledge'] != '') ? $request['crtKnowledge'] : NULL;
                    $paramsArray['isCrtGreaterThree']   = ($request['isCrtGreaterThree'] != '') ? $request['isCrtGreaterThree'] : NULL;

                    // $paramsArray['gestationalAge']  = ($request['gestationalAge'] != '') ? $request['gestationalAge'] : NULL;
                    $paramsArray['tone']            = ($request['tone'] != '') ? $request['tone'] : NULL;
                    $paramsArray['alertness']       = ($request['alertness'] != '') ? $request['alertness'] : NULL;
                    $paramsArray['color']           = ($request['color'] != '') ? $request['color'] : NULL;
                    

                    $paramsArray['apneaOrGasping']  = ($request['apneaGasping'] != '') ? $request['apneaGasping'] : NULL;
                    $paramsArray['grunting']        = ($request['grunting'] != '') ? $request['grunting'] : NULL;
                    $paramsArray['chestIndrawing']  = ($request['chestIndrawing'] != '') ? $request['chestIndrawing'] : NULL;

                    $paramsArray['interestInFeeding']   = ($request['interestInFeeding'] != '') ? $request['interestInFeeding'] : NULL;
                    $paramsArray['sufficientLactation'] = ($request['sufficientLactation'] != '') ? $request['sufficientLactation'] : NULL;
                    $paramsArray['sucking']         = ($request['sucking'] != '') ? $request['sucking'] : NULL;

                    $paramsArray['umbilicus']       = ($request['umbilicus'] != '') ? $request['umbilicus'] : NULL;
                    $paramsArray['skinPustules']    = ($request['skinPustules'] != '') ? $request['skinPustules'] : NULL;

                    // $paramsArray['isAnyComplicationAtBirth']    = ($request['isAnyComplicationAtBirth'] != '') ? $request['isAnyComplicationAtBirth'] : NULL;
                    

                    $paramsArray['bulgingAnteriorFontanel']     = ($request['bulgingAnteriorFontanel'] != '') ? $request['bulgingAnteriorFontanel'] : NULL;

                    // $paramsArray['convulsions']                 = ($request['convulsions'] != '') ? $request['convulsions'] : NULL;
                    $paramsArray['isBleeding']                  = ($request['isBleeding'] != '') ? $request['isBleeding'] : NULL;

                    $paramsArray['urinePassedIn24Hrs']          = ($request['urinePassedIn24Hrs'] != '') ? $request['urinePassedIn24Hrs'] : NULL;
                    $paramsArray['stoolPassedIn24Hrs']          = ($request['stoolPassedIn24Hrs'] != '') ? $request['stoolPassedIn24Hrs'] : NULL;
                    

                    $paramsArray['status'] = '1';
                    $paramsArray['assesmentDate'] = date('Y-m-d');
                    $paramsArray['assesmentNumber'] = $getCount + 1;
                    $paramsArray['assesmentTime'] = date('H:i');
                    $paramsArray['addDate'] = $request['localDateTime'];
                    $paramsArray['lastSyncedTime']  = date('Y-m-d H:i:s');
                    $paramsArray['modifyDate']  = $request['localDateTime'];

                    $returnArray = isBlankOrNull($paramsArray);


                    $checkDuplicateData = $this
                        ->db
                        ->get_where('babyDailyMonitoring', array(
                        'androidUuid' => $request['localId']
                    ))->num_rows();

                    if ($checkDuplicateData == 0)
                    {
                    
                        $insert = $this
                            ->db
                            ->insert('babyDailyMonitoring', $returnArray);

                        $lastAssessmentId = $this
                            ->db
                            ->insert_id();
                        $listID['id'] = $lastAssessmentId;
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;

                        // generate log history
                        $getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['staffId']))->row_array();

                        $logArray                         = array();
                        $logArray['tableReference']       = '9';
                        $logArray['tableReferenceId']     = $lastAssessmentId;
                        
                        $logArray['remark']               = $getNurseName['name']." has completed the baby assessment at the time of admission at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
                        
                        $logArray['latitude']             = $request['latitude'];
                        $logArray['longitude']            = $request['longitude'];
                        $logArray['addDate']              = $request['localDateTime'];
                        $logArray['lastSyncedTime']       = date('Y-m-d H:i:s');
                        $this->db->insert('logHistory',$logArray);  
                        

                        $getMotherData = $this
                            ->db
                            ->query("select MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId` where  BA.`babyId` ='" . $request['babyId'] . "'")->row_array();

                        $getNurseData = $this
                            ->db
                            ->query("select name from staffMaster where staffId=" . $request['staffId'] . "")->row_array();

                        

                        $motherData = $this
                            ->db
                            ->query("SELECT MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId`  where  BA.`babyId` ='" . $request['babyId'] . "'")->row_array();
                            
                        $loungeName = getSingleRowFromTable('loungeName', 'loungeId', $request['loungeId'], 'loungeMaster');
                        
                        
                    }
                    else
                    {
                        $this
                            ->db
                            ->where('androidUuid', $request['localId']);
                        $this
                            ->db
                            ->update('babyDailyMonitoring', $paramsArray);
                        $lastAssessmentId = $this
                            ->db
                            ->get_where('babyDailyMonitoring', array(
                            'androidUuid' => $request['localId']
                        ))->row_array();

                        // generate log history
                        $getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['staffId']))->row_array();

                        $logArray                         = array();
                        $logArray['tableReference']       = '9';
                        
                        $logArray['remark']               = $getNurseName['name']." has completed the baby assessment at the time of admission at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
                        
                        $logArray['latitude']             = $request['latitude'];
                        $logArray['longitude']            = $request['longitude'];
                        $logArray['addDate']              = $request['localDateTime'];
                        $logArray['lastSyncedTime']       = date('Y-m-d H:i:s');
                        $this->db->where(array('tableReferenceId' => $lastAssessmentId['id'], 'tableReference' => '9'));
                        $this->db->update('logHistory', $logArray);
                        

                        $listID['id'] = $lastAssessmentId['id'];
                        $listID['localId'] = $request['localId'];
                        $param[] = $listID;
                    }
                }

            }
        }
        if ($checkSyncedData == 1 || $checkSyncedData == 2)
        {
            $date['id'] = $param;
            generateServerResponse('1', 'S', $date);
        }
        else
        {
            generateServerResponse('0', '213');
        }
    }


    public function addSibling($request)
    {
        

        $response = array();
        $arrayName = array();
        $deliveryPlace = '';

        $loungeData = $this
                ->db
                ->get_where('loungeMaster', array(
                'loungeId' => $request['loungeId']
            ))->row_array();

        $getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['staffId']))->row_array();

        $existData = $this
            ->db
            ->get_where('babyRegistration', array(
            'androidUuid' => $request['localId']
        ))->num_rows();

        if ($existData > 0)
        {
            generateServerResponse('0', '213');
        }

        $arrayName = array();

        $arrayName['motherId']  = $request['motherId'];
        
        $arrayName['deliveryDate'] = ($request['deliveryDate'] != '') ? $request['deliveryDate'] : NULL;
        $arrayName['deliveryTime'] = ($request['deliveryTime'] != '') ? $request['deliveryTime'] : NULL;
        $arrayName['babyGender'] = ($request['babyGender'] != '') ? $request['babyGender'] : NULL;
        $arrayName['deliveryType'] = ($request['deliveryType'] != '') ? $request['deliveryType'] : NULL;
        $arrayName['typeOfBorn'] = ($request['typeOfBorn'] != '') ? $request['typeOfBorn'] : NULL;
        $arrayName['typeOfOutBorn'] = ($request['typeOfOutBorn'] != '') ? $request['typeOfOutBorn'] : NULL;
        $arrayName['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;

        if ($request['birthWeightAvail'] == '1')
        {
            $arrayName['birthWeightAvail'] = '1';
            $arrayName['babyWeight'] = $request['babyWeight'];
        }
        else
        {
            $arrayName['birthWeightAvail'] = '2';
            $arrayName['babyWeight'] = NULL;
            $arrayName['reason'] = $request['reason'];
        }
        
        $arrayName['babyPhoto'] = ($request['babyPhoto'] != '') ? saveDynamicImage($request['babyPhoto'], babyDirectory) : NULL;
        $arrayName['registrationDateTime'] = date('Y-m-d H:i:s');
        $arrayName['status'] = '1'; 
        $arrayName['addDate'] = date('Y-m-d H:i:s');
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        $inserted = $this
            ->db
            ->insert('babyRegistration', $arrayName);

        $babyId = $this
            ->db
            ->insert_id();

        // generate log history
        $paramArray                         = array();
        $paramArray['tableReference']       = '6';
        $paramArray['tableReferenceId']     = $babyId;
       
        $paramArray['remark']               = $getNurseName['name']." has registered a new baby at ".date('d M Y, g:i A',strtotime(date('Y-m-d H:i:s'))).".";
        
        // $paramArray['latitude']             = $request['latitude'];
        // $paramArray['longitude']            = $request['longitude'];
        $paramArray['addDate']              = date('Y-m-d H:i:s');
        $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
        $this->db->insert('logHistory',$paramArray);

        $fileName = "b_" . $babyId . ".pdf";

        if ($inserted > 0)
        {
            $baby = array();
            $baby['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
            $baby['babyId'] = $babyId;
            $baby['admissionDateTime'] = date('Y-m-d : H:i:s');
            $baby['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
            $baby['staffId']   = $request['staffId'];
            $baby['infantComingFrom'] = ($request['infantComingFrom'] != '') ? $request['infantComingFrom'] : NULL;

            // type 1= SNCU, 2= Lounges
            if ($loungeData['type'] == 1)
            {
                $baby['babyFileId'] = NULL ;
                $baby['temporaryFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            }
            else
            {
                $baby['temporaryFileId'] = NULL ; 
                $baby['babyFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            }

            $baby['addDate'] = date('Y-m-d H:i:s');
            $baby['status'] = '4'; // for draft status
            $baby['modifyDate'] = date('Y-m-d H:i:s');

            $badyAdmission = $this
                ->db
                ->insert('babyAdmission', $baby);
            $babyLastInsertedId = $this
                ->db
                ->insert_id();

            // generate log history
            $paramArray                         = array();
            $paramArray['tableReference']       = '7';
            $paramArray['tableReferenceId']     = $babyLastInsertedId;
           
            $paramArray['remark']               = $getNurseName['name']." has admitted a new baby at ".date('d M Y, g:i A',strtotime(date('Y-m-d H:i:s'))).".";
            
            // $paramArray['latitude']             = $request['latitude'];
            // $paramArray['longitude']            = $request['longitude'];
            $paramArray['addDate']              = date('Y-m-d H:i:s');
            $paramArray['lastSyncedTime']       = date('Y-m-d H:i:s');
            $this->db->insert('logHistory',$paramArray);

            if ($request['birthWeightAvail'] == '1')
            {
                ############# ENTRY OF BABY WEIGTH IN babyDailyWeight Table #################
                $baby_weigth = array();
                //$baby_weigth['babyId'] = $babyId;
                $baby_weigth['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
                //$baby_weigth['loungeId'] =  ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
                $baby_weigth['isDeviceAvailAndWorking'] = 'Yes';
                $baby_weigth['babyAdmissionId'] = $babyLastInsertedId;
                $baby_weigth['babyWeight'] = $request['babyWeight'];
                $baby_weigth['weightDate'] = $request['deliveryDate'];
                $baby_weigth['addDate'] = date('Y-m-d H:i:s');
                $this
                    ->db
                    ->insert('babyDailyWeight', $baby_weigth);
            }       

            $response['motherId'] = $request['motherId'];
            $response['babyAdmissionId'] = $babyLastInsertedId;
            $response['babyId'] = $babyId;
            generateServerResponse('1', '129', $response);
        }
    }


    public function AdmitRegisteredMother($request){
        $mother = array();
        $mother['motherId'] = $request['motherId'];
        $mother['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
        $mother['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;

        
        $mother['status'] = '1'; 
        $mother['addDate'] = date('Y-m-d H:i:s');
        $mother['modifyDate'] = date('Y-m-d H:i:s');

            
        $mother_addmission = $this
            ->db
            ->insert('motherAdmission', $mother);

        $response['motherAdmissionId'] = $this
            ->db
            ->insert_id();

        $response['motherId'] = $request['motherId'];
           
        generateServerResponse('1', '128', $response);
            
    }


    // get babys via facility wise, deliveryDate, hospitalRegistrationNumber and motherName searching
    public function findBabyWhereFacilityId($request)
    {
        $getAllDataWithStatus = $this->searchFacilityBabyViaPaging($request);

        //echo $this->db->last_query();
        //exit();


        $arrayName = array();
        if (count($getAllDataWithStatus) > 0)
        {
            foreach ($getAllDataWithStatus as $key => $value)
            {
                $getBaby = $this
                    ->db
                    ->get_where('babyAdmission', array(
                    'babyId' => $value['babyId']
                ))->row_array();
                $Hold['babyId'] = $value['babyId'];
                $Hold['babyPhoto'] = babyDirectoryUrl. $value['babyPhoto'];
                $Hold['babyFileId'] = $getBaby['babyFileId'];
                $Hold['status'] = $getBaby['status'];
                $Hold['motherId'] = $value['motherId'];
                $getMother = $this
                    ->db
                    ->get_where('motherRegistration', array(
                    'motherId' => $value['motherId']
                ))->row_array();
                $Hold['motherName'] = $getMother['motherName'];
                $Hold['motherPicture'] = motherDirectoryUrl. $getMother['motherPicture'];
                $Hold['loungeId'] = $value['loungeId'];
                $getLounge = $this
                    ->db
                    ->get_where('loungeMaster', array(
                    'loungeId' => $value['loungeId']
                ))->row_array();
                $Hold['loungeName'] = $getLounge['loungeName'];
                $Hold['admissionDateTime'] = $value['admissionDateTime'];
                $Hold['dischargeDateTime'] = $value['dateOfDischarge'];
                $DoctorName = $this
                    ->db
                    ->get_where('staffMaster', array(
                    'staffId' => $value['dischargeByDoctor']
                ))->row_array();
                $Hold['dischargeByDoctor'] = $DoctorName['name'];
                $arrayName[] = $Hold;
            }
        }
        $response['babyData'] = $arrayName;
        $response['resultCount'] = count($getAllDataWithStatus);
        $response['offset'] = count($getAllDataWithStatus) + $request['offset'];
        if (count($response['babyData']) > 0)
        {
            generateServerResponse('1', 'S', $response);
        }
        else
        {
            generateServerResponse('0', 'E');
        }
    }



    public function searchFacilityBabyViaPaging($request)
    {
        $facilityId     = $request['searchingFacilityId'];
        $deliveryDate   = $request['deliveryDate'];
        $motherName     = $request['motherName'];
        $hospitalRegistrationNumber      = $request['hospitalRegistrationNumber'];
        $offset         = $request['offset'];

        $limit = 10;
        $offsetvalue = ($offset != '') ? $offset : 0;

        if (!empty($facilityId) && empty($deliveryDate) && empty($motherName) && empty($hospitalRegistrationNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join loungeMaster lm on ba.loungeId = lm.loungeId where (ba.`status`='2' or ba.`status`='3') and lm.`facilityId`=" . $facilityId . " and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) ORDER BY ba.`status` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

        else if (!empty($facilityId) && !empty($deliveryDate) && empty($motherName) && empty($hospitalRegistrationNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join loungeMaster lm on ba.loungeId = lm.loungeId where (ba.`status`='2' or ba.`status`='3') and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) and (br.`deliveryDate` Like '%{$deliveryDate}%') and lm.`facilityId`=" . $facilityId . " ORDER BY ba.`status` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

        else if (!empty($facilityId) && empty($deliveryDate) && empty($motherName) && !empty($hospitalRegistrationNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join loungeMaster lm on ba.loungeId = lm.loungeId where (ba.`status`='2' or ba.`status`='3') and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) and (ba.`babyFileId` Like '%{$hospitalRegistrationNumber}%') and lm.`facilityId`=" . $facilityId . " ORDER BY ba.`status` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

        else if (!empty($facilityId) && empty($deliveryDate) && !empty($motherName) && empty($hospitalRegistrationNumber))
        {
            return $this
                ->db
                ->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join motherRegistration as mr on mr.`motherId`=br.`motherId` inner join loungeMaster lm on ba.loungeId = lm.loungeId where (ba.`status`='2' or ba.`status`='3') and ba.`babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1) and lm.`facilityId`=" . $facilityId . " and (mr.`motherName` Like '%{$motherName}%' OR mr.`motherName` SOUNDS Like '%{$motherName}%') ORDER BY ba.`id` DESC LIMIT " . $offsetvalue . ", " . $limit . "")->result_array();
        }

    }



    public function RegisteredBabyAdmission($request){
        // check duplicateData
        $existData = $this
            ->db
            ->get_where('babyAdmission', array(
            'androidUuid' => $request['localId']
        ))->num_rows();


        $existData2 = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId'], 'status' => 1
        ))->num_rows();

        if ($existData > 0 || $existData2 > 0)
        {
            generateServerResponse('0', '213');
        }


        $response = array();
        $baby = array();
        $baby['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
        $baby['babyId'] = $request['babyId'];
        $baby['staffId'] = $request['nurseId'];
        $baby['admissionDateTime'] = date('Y-m-d : H:i:s');
        $baby['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;

            
        $baby['babyFileId'] = ($request['hospitalRegistrationNumber'] != '') ? $request['hospitalRegistrationNumber'] : NULL;
            

        $baby['addDate'] = date('Y-m-d : H:i:s');
        $baby['status'] = '4'; // for draft status
        $baby['modifyDate'] = date('Y-m-d H:i:s');

        $badyAdmission = $this
            ->db
            ->insert('babyAdmission', $baby);
        $babyLastInsertedId = $this
            ->db
            ->insert_id();


        $response['babyAdmissionId'] = $babyLastInsertedId;
        $response['babyId'] = $request['babyId'];
        generateServerResponse('1', '129', $response);


    }


    public function postBabyWiseCounselling($request){
        $requestData        = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        $countData = count($request['counsellingData']);
        if($countData > 0){
            $param1 = array();
            $param  = array();
            $checkDataForAllUpdate = 1;  // check for all data synced or not
            foreach ($request['counsellingData'] as $key => $request) {
                
                    
                $arrayName = array();
                
                // if($request['type'] == 1){
                //     $arrayName['kmcPosition']               = ($request['value'] != '') ? $request['value'] : NULL; 
                // } else if($request['type'] == 2){
                //     $arrayName['kmcMonitoring']             = ($request['value'] != '') ? $request['value'] : NULL; 
                // } else if($request['type'] == 3){
                //     $arrayName['kmcNutrition']              = ($request['value'] != '') ? $request['value'] : NULL; 
                // } else if($request['type'] == 4){
                //     $arrayName['kmcRespect']                = ($request['value'] != '') ? $request['value'] : NULL; 
                // } else if($request['type'] == 5){
                //     $arrayName['kmcHygiene']                = ($request['value'] != '') ? $request['value'] : NULL; 
                // }

                if($request['type'] == 1){
                    $arrayName['whatisKmc']                 = ($request['value'] != '') ? $request['value'] : NULL; 
                } else if($request['type'] == 2){
                    $arrayName['kmcPosition']               = ($request['value'] != '') ? $request['value'] : NULL; 
                } else if($request['type'] == 3){
                    $arrayName['kmcNutrition']              = ($request['value'] != '') ? $request['value'] : NULL; 
                } else if($request['type'] == 4){
                    $arrayName['kmcHygiene']                = ($request['value'] != '') ? $request['value'] : NULL; 
                } else if($request['type'] == 5){
                    $arrayName['kmcMonitoring']             = ($request['value'] != '') ? $request['value'] : NULL; 
                } else if($request['type'] == 6){
                    $arrayName['kmcRespect']                = ($request['value'] != '') ? $request['value'] : NULL; 
                }
                
                
                $arrayName['modifyDate']            = $request['localDateTime'];
                

                $this->db->where(array('babyId' => $request['babyId'], 'androidUuid' => $request['localId']));
                $this->db->update('babyAdmission',$arrayName);

                
                $listID['babyId']       = $request['babyId'];
                $listID['localId']      = $request['localId'];;
                $param1[]               = $listID;

                
            } 
            if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
               $data['id'] = $param1; 
               generateServerResponse('1','S', $data);
            }
            else{ 
                generateServerResponse('0','213');
            }           
        } else{ 
             generateServerResponse('0','213');
        }   
    }


    public function getCaseSheetDetail($request = '')
    {
        $coachId    = $request['coachId'];
        $loungeId   = $request['loungeId'];
        $babyId     = $request['babyId'];
        $date       = $request['date'];

        $coachData = $this
            ->db
            ->get_where('coachDistrictFacilityLounge', array(
            'masterId' => $coachId,
            'loungeId' => $loungeId,
            'status' => '1'
        ));

        if ($coachData->num_rows() != 0)
        {
            $registrationData = $this
                ->db
                ->query("SELECT * FROM `babyRegistration` WHERE `babyId` = ".$babyId."")
                ->row_array();

            $this->db->order_by('id','DESC');
            $admissionData = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `babyId` = ".$babyId."")
                ->row_array();

            $birthWeight = $registrationData['babyWeight'];

            $this->db->order_by('id','DESC');
            $currentWeightData = $this->db->get_where('babyDailyWeight', array('babyAdmissionId' => $admissionData['id'], 'weightDate' => $date))->row_array();

            $this->db->order_by('id','DESC');
            $currentWeightDataForP = $this->db->get_where('babyDailyWeight', array('babyAdmissionId' => $admissionData['id']))->row_array();


            if(!empty($currentWeightData)) {
                $currentWeight = $currentWeightData['babyWeight'];
                $currentWeightForP = $currentWeightData['babyWeight'];
                $dailyWeighing = 1;
            } else {
                $currentWeight = 0;
                $dailyWeighing = 0;
                if(!empty($currentWeightDataForP)){
                    $currentWeightForP = $currentWeightDataForP['babyWeight'];
                } else {
                    $currentWeightForP = $birthWeight;
                }
            }

            $datediff =  strtotime(date('Y-m-d')) - strtotime($registrationData['deliveryDate']);

            $days = round($datediff / (60 * 60 * 24));

            $prescribedFeeding = $this->getQuantity($currentWeightForP, $days);



            if($birthWeight > $currentWeight) {
                $weightChangeSinceBirthStatus = 1;
            } else if($birthWeight < $currentWeight) {
                $weightChangeSinceBirthStatus = 2;
            } else {
                $weightChangeSinceBirthStatus = 3;
            }

            $weightChangeSinceBirth = $currentWeight - $birthWeight;

            $day_before = date('Y-m-d', strtotime($date.' -1 day'));

            $this->db->order_by('id','DESC');
            $prevWeightData = $this->db->get_where('babyDailyWeight', array('babyAdmissionId' => $admissionData['id'], 'weightDate' => $day_before))->row_array();


            if(!empty($prevWeightData)) {
                $prevWeight = $prevWeightData['babyWeight'];
            } else {
                $prevWeight = $birthWeight;
            }

            if($prevWeight > $currentWeight) {
                $weightChangeSinceYesterdayStatus = 1;
            } else if($prevWeight < $currentWeight) {
                $weightChangeSinceYesterdayStatus = 2;
            } else {
                $weightChangeSinceYesterdayStatus = 3;
            }

            $weightChangeSinceYesterday = $currentWeight-$prevWeight;

            $totalKmc = $this
                ->db
                ->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(babyDailyKMC.`endTime`,babyDailyKMC.`startTime`))) as kmcTimeLatest from `babyDailyKMC` where babyDailyKMC.`startTime` < babyDailyKMC.`endTime` AND babyDailyKMC.`babyAdmissionId` = ".$admissionData['id']." AND babyDailyKMC.startDate = '".$date."'")
                ->row_array();

            if(!empty($totalKmc['kmcTimeLatest'])){
                $hours  = floor($totalKmc['kmcTimeLatest'] / 3600);

                if($hours == 0){
                    $hours = '00';
                } else if($hours < 10){
                    $hours = '0'.$hours;
                }
                
                $minutes = floor(($totalKmc['kmcTimeLatest'] / 60) % 60);
                if($minutes == 0){
                    $minutes = '00';
                } else if($minutes < 10){
                    $minutes = '0'.$minutes;
                }
                $totalKmcTime = $hours.':'.$minutes;
            } else{
                $totalKmcTime = '00:00';
            }
                
            

            $feedingTimes = $this->db->get_where('babyDailyNutrition', array('babyAdmissionId' => $admissionData['id'], 'feedDate' => $date))->num_rows();

            $feedingQuantity = $this
                            ->db
                            ->query("SELECT SUM(milkQuantity) as sum   FROM `babyDailyNutrition` WHERE `feedDate` = '" . $date . "' and `babyAdmissionId`='" . $admissionData['id'] . "'")->row_array();

            $assessmentCount = $this->db->get_where('babyDailyMonitoring', array('babyAdmissionId' => $admissionData['id'], 'assesmentDate' => $date))->num_rows();

            $babySupplement = $this->db->get_where('babySupplement', array('babyAdmissionId' => $admissionData['id'], 'supplementDate' => $date))->result_array();

            $babyVaccination = $this->db->get_where('babyVaccination', array('babyAdmissionId' => $admissionData['id'], 'vaccinationDate' => $date))->result_array();

            $get_test_orders = $this
                            ->db
                            ->query("SELECT `investigation`.* FROM `investigation` WHERE `investigation`.`babyAdmissionId` = ".$admissionData['id']." AND ((DATE(`investigation`.addDate) = '".$date."') OR (DATE(`investigation`.modifyDate) = '".$date."')) ORDER BY `investigation`.id desc")
                            ->num_rows(); 

            $get_test_result = $this
                            ->db
                            ->query("SELECT `investigation`.* FROM `investigation` WHERE `investigation`.`babyAdmissionId` = ".$admissionData['id']." AND ((DATE(`investigation`.addDate) = '".$date."') OR (DATE(`investigation`.modifyDate) = '".$date."')) AND `investigation`.`result` != '' ORDER BY `investigation`.id desc")
                            ->num_rows(); 

            $get_test_sample = $this
                            ->db
                            ->query("SELECT `investigation`.* FROM `investigation` WHERE `investigation`.`babyAdmissionId` = ".$admissionData['id']." AND ((DATE(`investigation`.addDate) = '".$date."') OR (DATE(`investigation`.modifyDate) = '".$date."')) AND `investigation`.`sampleComment` != '' ORDER BY `investigation`.id desc")
                            ->num_rows(); 

            $this->db->order_by('id','DESC');
            $getLastAssessment = $this->db->get_where('babyDailyMonitoring', array('babyAdmissionId' => $admissionData['id'], 'assesmentDate' => $date))->row_array();


            $result['weightChangeSinceBirth']               = $weightChangeSinceBirth;
            $result['weightChangeSinceBirthStatus']         = $weightChangeSinceBirthStatus;
            $result['lastMonitoringData']                   = $getLastAssessment;

            $result['weightChangeSinceYesterday']           = $weightChangeSinceYesterday;
            $result['weightChangeSinceYesterdayStatus']     = $weightChangeSinceYesterdayStatus;
            $result['kmcHours']             = $totalKmcTime;

            $result['feedingTimes']         = $feedingTimes;
            $result['feedingQuantity']      = ($feedingQuantity['sum'] != '') ? $feedingQuantity['sum'] : '0';

            $result['dailyWeighing']        = $dailyWeighing;
            $result['prescribedFeeding']        = $prescribedFeeding;

            $result['assessmentCount']      = $assessmentCount;
            $result['babySupplement']       = $babySupplement;
            $result['babyVaccination']      = $babyVaccination;


            $result['orderCount']           = $get_test_orders;
            $result['resultCount']          = $get_test_result;
            $result['sampleCount']          = $get_test_sample;

            generateServerResponse('1', 'S', $result);
            
        } else {
            generateServerResponse('0','L');
        }
    }



    public function getBabyDetailByType($request){
        $coachId    = $request['coachId'];
        $loungeId   = $request['loungeId'];
        $babyId     = $request['babyId'];
        $type       = $request['type'];
        $date       = $request['date'];

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
            

            if ($now >= $begin1) {
               

                $fromTotal = $date.' 08:00:01';
                $toTotal = date('Y-m-d 08:00:00', strtotime($date.' +1 day'));
                
            }  else {
                

                $fromTotal = date('Y-m-d 08:00:01', strtotime($date.' -1 day'));
                $toTotal = $date.' 08:00:00';
                    
                
            }

            $getBabyAdmissionData = $this
                ->db
                ->query("SELECT * FROM `babyAdmission` WHERE `babyId` = ".$babyId."")
                ->row_array();

            if($type == 1){ // get kmc data
                $get_kmc_data = $this
                                ->db
                                ->query("SELECT `babyDailyKMC`.*,`staffMaster`.name as nurseName FROM `babyDailyKMC` inner join staffMaster on `babyDailyKMC`.nurseId = `staffMaster`.staffId WHERE `babyDailyKMC`.`babyAdmissionId` = ".$getBabyAdmissionData['id']." AND (`babyDailyKMC`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')  ORDER BY `babyDailyKMC`.id desc")
                                ->result_array(); 
                $result['kmcData']      = $get_kmc_data;

               
            } else if($type == 2){ // get feeding data
                $get_feeding_data = $this
                                ->db
                                ->query("SELECT `babyDailyNutrition`.*,`staffMaster`.name as nurseName FROM `babyDailyNutrition` inner join staffMaster on `babyDailyNutrition`.nurseId = `staffMaster`.staffId WHERE `babyDailyNutrition`.`babyAdmissionId` = ".$getBabyAdmissionData['id']." AND (`babyDailyNutrition`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')  ORDER BY `babyDailyNutrition`.id desc")
                                ->result_array(); 
                $result['feedingData']      = $get_feeding_data;
            } else if($type == 3){ // get feeding data
                $get_vaccination_data = $this
                                ->db
                                ->query("SELECT `babyVaccination`.*,`staffMaster`.name as nurseName FROM `babyVaccination` inner join staffMaster on `babyVaccination`.nurseId = `staffMaster`.staffId WHERE `babyVaccination`.`babyAdmissionId` = ".$getBabyAdmissionData['id']." ORDER BY `babyVaccination`.id desc")
                                ->result_array(); 
                $result['vaccinationData']      = $get_vaccination_data;

                $get_prescription_data = $this
                                ->db
                                ->query("SELECT `prescriptionNurseWise`.*,`staffMaster`.name as nurseName FROM `prescriptionNurseWise` inner join staffMaster on `prescriptionNurseWise`.nurseId = `staffMaster`.staffId WHERE `prescriptionNurseWise`.`babyAdmissionId` = ".$getBabyAdmissionData['id']." ORDER BY `prescriptionNurseWise`.id desc")
                                ->result_array(); 
                $result['prescriptionData']      = $get_prescription_data;
            } else if($type == 4){ // get feeding data
                $result['weightImageURL']      = babyWeightDirectoryUrl;

                $get_weight_data = $this
                                ->db
                                ->query("SELECT `babyDailyWeight`.*,`staffMaster`.name as nurseName FROM `babyDailyWeight` inner join staffMaster on `babyDailyWeight`.nurseId = `staffMaster`.staffId WHERE `babyDailyWeight`.`babyAdmissionId` = ".$getBabyAdmissionData['id']." ORDER BY `babyDailyWeight`.id desc")
                                ->result_array(); 
                $result['weightData']      = $get_weight_data;

                $get_assessment_data = $this
                                ->db
                                ->query("SELECT `babyDailyMonitoring`.*,`staffMaster`.name as nurseName FROM `babyDailyMonitoring` inner join staffMaster on `babyDailyMonitoring`.staffId = `staffMaster`.staffId WHERE `babyDailyMonitoring`.`babyAdmissionId` = ".$getBabyAdmissionData['id']." ORDER BY `babyDailyMonitoring`.id desc")
                                ->result_array(); 
                $result['assessmentData']      = $get_assessment_data;

                $get_investigation_data = $this
                                ->db
                                ->query("SELECT `investigation`.*,`staffMaster`.name as doctorName FROM `investigation` inner join staffMaster on `investigation`.doctorId = `staffMaster`.staffId WHERE `investigation`.`babyAdmissionId` = ".$getBabyAdmissionData['id']." ORDER BY `investigation`.id desc")
                                ->result_array(); 

                foreach ($get_investigation_data as $key => $value) {
                    if(!empty($value['nurseId'])) {
                        $get_nurse_name = $this
                                ->db
                                ->query("SELECT `staffMaster`.name as nurseName FROM staffMaster WHERE `staffMaster`.`staffId` = ".$value['nurseId']."")
                                ->row_array(); 
                        $get_investigation_data[$key]['nurseName']      = $get_nurse_name['nurseName'];
                    } else {
                        $get_investigation_data[$key]['nurseName']      = "";
                    }
                }

                $result['investigationData']      = $get_investigation_data;
            }
            generateServerResponse('1', 'S', $result);
        } else {
            generateServerResponse('0','L');
        }
    }


    public function getQuantity($weight,$age) {

        $quantity=0;

        if($weight<1500)
        {
            if($age<6)
            {
                $exp1 = $weight / 1000;
                $exp2 = 80+($age*15);
                $quantity = $exp1*$exp2;
            }
            else
            {
                $exp1 = $weight / 1000;
                $exp2 = 150;
                $quantity = $exp1*$exp2;
            }
        }
        else if($weight>1500)
        {
            if($age<7)
            {
                $exp1 = $weight / 1000;
                $exp2 = 60+($age*15);
                $quantity = $exp1*$exp2;
            }
            else
            {
                $exp1 = $weight / 1000;
                $exp2 = 150;
                $quantity = $exp1*$exp2;
            }
        }

        return $quantity/2;
    }


    public function postBabyWiseCounsellingAll($request){
        $requestData        = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        $countData = count($request['counsellingData']);
        if($countData > 0){
            $param1 = array();
            $param  = array();
            $checkDataForAllUpdate = 1;  // check for all data synced or not
            foreach ($request['counsellingData'] as $key => $request) {
                
                    
                $arrayName = array();
                
                
                $arrayName['kmcPosition']       = ($request['kmcPosition'] != '') ? $request['kmcPosition'] : NULL; 
                $arrayName['kmcMonitoring']     = ($request['kmcMonitoring'] != '') ? $request['kmcMonitoring'] : NULL; 
                $arrayName['kmcNutrition']      = ($request['kmcNutrition'] != '') ? $request['kmcNutrition'] : NULL; 
                $arrayName['kmcRespect']        = ($request['kmcRespect'] != '') ? $request['kmcRespect'] : NULL; 
                $arrayName['kmcHygiene']        = ($request['kmcHygiene'] != '') ? $request['kmcHygiene'] : NULL; 
                $arrayName['whatisKmc']         = ($request['whatisKmc'] != '') ? $request['whatisKmc'] : NULL; 
                
                
                $arrayName['modifyDate']            = $request['localDateTime'];
                

                $this->db->where(array('babyId' => $request['babyId'], 'androidUuid' => $request['localId']));
                $this->db->update('babyAdmission',$arrayName);

                
                $listID['babyId']       = $request['babyId'];
                $listID['localId']      = $request['localId'];;
                $param1[]               = $listID;

                
            } 
            if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
               $data['id'] = $param1; 
               generateServerResponse('1','S', $data);
            }
            else{ 
                generateServerResponse('0','213');
            }           
        } else{ 
             generateServerResponse('0','213');
        }   
    }

}