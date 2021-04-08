<?php
class MotherBabyAdmissionModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->database();
            date_default_timezone_set("Asia/KolKata");
    }
    public function checkHospitalRegistrationNumber($HospitalReg, $loungeId = '', $id = '')
    {
        if ($id != '')
        {
            return $this
                ->db
                ->get_where('motherAdmission', array(
                'hospitalRegistrationNumber' => $HospitalReg,
                'motherId !=' => $id,
                'loungeId' => $loungeId
            ))->num_rows();
        }
        else
        {
            return $this
                ->db
                ->get_where('motherAdmission', array(
                'hospitalRegistrationNumber' => $HospitalReg,
                'loungeId' => $loungeId
            ))->num_rows();
        }
    }

    public function motherDischargeAssessment($request)
    {

        // check Exist data
        #+++++++++   check Hospipal Reg No. Existing value  +++++++++++++++
        $this
            ->db
            ->order_by('id', 'desc');
        $checkMotherAdmitSameLounge = $this
            ->db
            ->get_where('motherAdmission', array(
            'status' => 2,
            'motherId' => $request['motherId']
        ))->num_rows();

        if ($checkMotherAdmitSameLounge == '0' && $request['type'] == '3')
        {
            $hospitalRegistrationNumber = $this->checkHospitalRegistrationNumber($request['hospitalRegistrationNumber'], $request['loungeId']);
            if ($hospitalRegistrationNumber == 1 && $request['type'] == '3')
            {
                generateServerResponse('0', '136');
            }
        }

        $mother = array();
        $baby = array();
        $baby_monitor = array();

        $ImageOfadmittedPersonSign = ($request['admittedSign'] != '') ? saveImage($request['admittedSign'], signDirectory) : '';
        $padPicture = ($request['padPicture'] != '') ? saveDynamicImage($request['padPicture'], imageDirectory) : '';

        $mother['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
        //$mother['doctorIncharge'] = ($request['doctorIncharge'] != '') ? $request['doctorIncharge'] : NULL;
        $mother['motherId'] = ($request['motherId'] != '') ? $request['motherId'] : NULL;
        $mother['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
        $mother['addDate'] = date('Y-m-d H:i:s');
        $mother['modifyDate'] = date('Y-m-d H:i:s');

        //get last mother AdmissionId
        $this
            ->db
            ->order_by('id', 'desc');
        $motherAdmisionLastId = $this
            ->db
            ->get_where('motherAdmission', array(
            'motherId' => $request['motherId']
        ))->row_array();

        $motherAdmission['motherAdmissionId'] = ($motherAdmisionLastId['id'] != '') ? $motherAdmisionLastId['id'] : NULL;

        //$motherAdmission['motherId'] = ($request['motherId'] != '') ? $request['motherId'] : NULL;
        //$motherAdmission['loungeId'] = ($request['loungeId'] != '') ? $request['loungeId'] : NULL;
        $motherAdmission['motherTemperature'] = ($request['motherTemperature'] != '') ? $request['motherTemperature'] : NULL;
        $motherAdmission['temperatureUnit'] = ($request['temperatureUnit'] != '') ? $request['temperatureUnit'] : NULL;
        $motherAdmission['padNotChangeReason'] = ($request['padNotChangeReason'] != '') ? $request['padNotChangeReason'] : NULL;

        $motherAdmission['androidUuid'] = ($request['localId'] != '') ? $request['localId'] : NULL;
        $motherAdmission['motherSystolicBP'] = ($request['motherSystolicBP'] != '') ? $request['motherSystolicBP'] : NULL;
        $motherAdmission['motherDiastolicBP'] = ($request['motherDiastolicBP'] != '') ? $request['motherDiastolicBP'] : NULL;
        $motherAdmission['motherUterineTone'] = ($request['motherUterineTone'] != '') ? $request['motherUterineTone'] : NULL;
        $motherAdmission['motherPulse'] = ($request['motherPulse'] != '') ? $request['motherPulse'] : NULL;
        $motherAdmission['motherUrinationAfterDelivery'] = ($request['motherUrinationAfterDelivery'] != '') ? $request['motherUrinationAfterDelivery'] : NULL;
        $motherAdmission['episitomyCondition'] = ($request['episitomyCondition'] != '') ? $request['episitomyCondition'] : NULL;

        $motherAdmission['sanitoryPadStatus'] = ($request['sanitoryPadStatus'] != '') ? $request['sanitoryPadStatus'] : NULL;
        $motherAdmission['isSanitoryPadStink'] = ($request['isSanitoryPadStink'] != '') ? $request['isSanitoryPadStink'] : NULL;

        $motherAdmission['other'] = ($request['other'] != '') ? $request['other'] : NULL;
        $motherAdmission['padPicture'] = ($padPicture != '') ? $padPicture : NULL;
        $motherAdmission['type'] = $request['type'];
        $motherAdmission['addDate'] = date('Y-m-d H:i:s');
        $motherAdmission['modifyDate'] = date('Y-m-d H:i:s');

        $getCount = $this
            ->db
            ->query("SELECT * FROM motherMonitoring where motherAdmissionId ='" . $motherAdmisionLastId['id']. "'")->num_rows();

        $motherAdmission['assesmentDate'] = date('Y-m-d');
        $motherAdmission['assesmentNumber'] = $getCount+1;
        $motherAdmission['assesmentTime'] = date('H:i:s');

        $mother_addmission = $this
            ->db
            ->insert('motherMonitoring', $motherAdmission);
        $motherId['motherAdmissionId'] = $motherAdmisionLastId['id'];
        $motherId['monitoringId'] = $this
            ->db
            ->insert_id();
        return $motherId;
    }

    
    public function GetMotherAllData($motherId)
    {
        return $this
            ->db
            ->query("SELECT * FROM motherRegistration AS MR LEFT JOIN motherAdmission AS MA ON MR.`motherId` = MA.`motherId`  WHERE MR.`motherId` = '" . $motherId . "'")->row_array();
    }

    public function GetBabyAllData($babyId)
    {
        return $this
            ->db
            ->query("SELECT *,BA.`addDate` as addDate FROM  babyRegistration AS BR LEFT JOIN babyAdmission AS BA ON BR.`babyId` = BA.`babyId`  WHERE BR.`babyId` = '" . $babyId . "' order by BA.`id` desc")->row_array();
        // echo $this->db->last_query();exit;
        
    }

    //Use
    public function babyMonitoringDischargeTime($request)
    {

        $getCount = $this
            ->db
            ->query("SELECT * FROM babyDailyMonitoring where loungeId ='" . $request['loungeId'] . "' And babyId ='" . $request['babyId'] . "' ")->num_rows();
        $baby = array();
        $baby_monitor = array();

        $baby_monitor['babyId'] = $request['babyId'];
        $baby_monitor['loungeId'] = $request['loungeId'];
        $baby_monitor['BabyRespiratoryRate'] = $request['BabyRespiratoryRate'];
        $baby_monitor['BabyOtherDangerSign'] = $request['BabyOtherDangerSign'];
        $baby_monitor['BabyPulseSpO2'] = $request['BabyPulseSpO2'];
        $baby_monitor['BabyPulseRate'] = $request['BabyPulseRate'];
        $baby_monitor['BabyTemperature'] = $request['BabyTemperature'];
        $baby_monitor['babyMeasuredWeight'] = $request['babyAdmissionWeight'];

        if ($request['IsHeadCircumferenceAvail'] == 'Yes')
        {
            $baby_monitor['IsHeadCircumferenceAvail'] = $request['IsHeadCircumferenceAvail'];
            $baby_monitor['headCircumferencereason'] = null;
        }
        else
        {
            $baby_monitor['headCircumferencereason'] = $request['headCircumferencereason'];
            $baby_monitor['IsHeadCircumferenceAvail'] = $request['IsHeadCircumferenceAvail'];;
        }
        $baby_monitor['temperatureUnit'] = $request['temperatureUnit'];

        $baby_monitor['MotherBreastcondition'] = $request['MotherBreastcondition'];
        $baby_monitor['MotherBreastPain'] = $request['MotherBreastPain'];
        $baby_monitor['MotherBreastStatus'] = $request['MotherBreastStatus'];
        $baby_monitor['BabyMilkConsumption1'] = $request['BabyMilkConsumption1'];
        $baby_monitor['BabyMilkConsumption2'] = $request['BabyMilkConsumption2'];
        $baby_monitor['BabyMilkConsumption3'] = $request['BabyMilkConsumption3'];
        $baby_monitor['Other'] = $request['Other'];
        $baby_monitor['BabyHeadCircumference'] = $request['BabyHeadCircumference'];
        $baby_monitor['UrinationAfterLastAssesment'] = $request['UrinationAfterLastAssesment'];
        $baby_monitor['StoolAfterLastAssesment'] = $request['StoolAfterLastAssesment'];
        $baby_monitor['IsPulseOximatoryDeviceAvailable'] = $request['IsPulseOximatoryDeviceAvailable'];
        $baby_monitor['SkinColor'] = $request['SkinColor'];
        $baby_monitor['assesmentNumber'] = $getCount + 1;
        $baby_monitor['staffId'] = $request['staffId'];
        $baby_monitor['type'] = $request['type'];
        $baby_monitor['addDate'] = time();
        $baby_monitor['status'] = '2';
        $baby_monitor['modifyDate'] = time();

        //get last Baby AdmissionId
        $this
            ->db
            ->order_by('id', 'desc');
        $babyAdmisionLastId = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId']
        ))->row_array();
        $baby_monitor['babyAdmissionId'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;

        $BabyMonitoring = $this
            ->db
            ->insert('babyDailyMonitoring', $baby_monitor);
        $Baby_id['baby_assess_id'] = $this
            ->db
            ->insert_id();

        $GetNoticfictaionEntry = $this
            ->db
            ->query("SELECT * From notification where  loungeId = '" . $request['loungeId'] . "'  AND  babyId = '" . $request['babyId'] . "' AND status = '1' AND typeOfNotification='2' order by id desc limit 0, 1")->result_array();

        $GetNoticfictaionEntry1 = $this
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
                if (count($GetNoticfictaionEntry) == 1)
                {
                    $this
                        ->db
                        ->where('id', $GetNoticfictaionEntry1['id']);
                    $this
                        ->db
                        ->update('notification', array(
                        'status' => '2',
                        'modifyDate' => $curDateTime
                    ));
                }

            }
            else if ($secondMonitoringTime <= $curDateTime && $secondEndTiming > $curDateTime)
            {

                if (count($GetNoticfictaionEntry) == 1)
                {
                    $this
                        ->db
                        ->where('id', $GetNoticfictaionEntry1['id']);
                    $this
                        ->db
                        ->update('notification', array(
                        'status' => '2',
                        'modifyDate' => $curDateTime
                    ));
                }
            }
            else if ($thirdMonitoringTime <= $curDateTime && $thirdEndTiming > $curDateTime)
            {
                if (count($GetNoticfictaionEntry) == 1)
                {
                    $this
                        ->db
                        ->where('id', $GetNoticfictaionEntry1['id']);
                    $this
                        ->db
                        ->update('notification', array(
                        'status' => '2',
                        'modifyDate' => $curDateTime
                    ));
                }
            }
            else if ($fourthMonitoringTime <= $curDateTime && $fourthEndTime > $curDateTime)
            {
                if (count($GetNoticfictaionEntry) == 1)
                {
                    $this
                        ->db
                        ->where('id', $GetNoticfictaionEntry1['id']);
                    $this
                        ->db
                        ->update('notification', array(
                        'status' => '2',
                        'modifyDate' => $curDateTime
                    ));
                }
            }

        }

        return $Baby_id;

    }

    public function babyWeightPdfFile($loungeId, $id, $type = '')
    {

        error_reporting(0);

        $babyDetails = $this
            ->db
            ->get_where('babyAdmission', array(
            'id' => $id
        ))->row_array();

        /*echo $loungeId ."   ". $babyId; exit;*/
        $babyMotherDetails = $this
            ->db
            ->query("SELECT MR.`motherName`, BR.`deliveryDate`, BR.`babyWeight` FROM motherRegistration as MR LEFT JOIN babyRegistration as BR  on BR.`motherId` =  MR.`motherId`  WHERE BR.`babyId` = '" . $babyDetails['babyId'] . "'")->row_array();

        $getBabyAllWeigth = $this
            ->db
            ->get_where('babyDailyWeight', array(
            'babyAdmissionId' => $babyDetails['id']
        ))->result_array();

        /* echo "<pre>"; print_r($getBabyAllWeigth); exit;*/

        $html = '';
        $html .= '
                <!DOCtype html>
                <html>
                <head>
                <style>

                  table,th,td,tr{
                    border-collapse:collapse;
                    }

                </style>
                </head>
                <body>
                <table >
                <tr><th style="text-align: center;font-family: sans-serif;"><u><h3>FORM D : DAILY WEIGHT MONITORING FORM</h3></u></th></tr>
                <tr><td style="text-align: left;"><strong ><i>Objective:</i></strong><i style="font-family: serif;"> To record the pre-feed weight of the baby admitted in the KMC unit,and compare it with the weight of the previous day and admission weight.To be filled by nurse on duty in the KMC room after weighing.</i> </td></tr>

                </table>

                <table style="margin-top:   10px;width: 100%" >
                <tr>
                    <td style="width: 50%;text-align: left; padding:5px "><b> Hospital Registration Number: </b> ' . $babyDetails['babyFileId'] . ' </td>
                <th style="width: 50%;text-align: left"></th></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "> <b> Mother Name:</b> ' . $babyMotherDetails['motherName'] . '</td>
                  <td style="width: 50%;text-align: right; padding:5px; float:right !important;  "><b>Date of Birth(dd/mm/yyyy):</b> ' . date("d/m/Y", strtotime($babyMotherDetails['deliveryDate'])) . '</td></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "><b>Birth Weight(in grams): </b>' . $babyMotherDetails['babyWeight'] . '</td>
                  <th style="width: 50%;text-align: left"></th></tr>

                </table>
                <table style="margin-top:10px;border:1px solid;width: 100% " >
                  
                    <tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center;border:1px solid; padding: 8px"><b>Day</b></td>
                    <td style="width: 12%;text-align: center;border:1px solid ; padding: 8px"><b>Date<br>(dd/mm/yy)</b></td>
                    <td style="width: 12%;text-align: center;border:1px solid ; padding: 8px"><b>Time of<br>weighing</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Weight of baby<br>without clothes<br>(in grams)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Todays weight-<br>yesterdays weight<br><br>(+,- or unchanged)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Net gain/loss since admission<br>(Todays weight-<br>Admission<br>weight)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Remarks</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Nurse Name</b></td>
                    <td style="width: 11%;text-align: center;border:1px solid ; padding: 8px"><b>Signature<br>or nurse<br>talking<br>weight</b></td>
                  </tr>';
        $i = 1;

        foreach ($getBabyAllWeigth as $key => $value)
        {
            $nurseName = getSingleRowFromTable('name', 'staffId', $value['nurseId'], 'staffMaster');
            // print_r(date('g:i A',$value['addDate']));exit;
            ######## conditions Baby weigth gain loss #########
            if ($i >= 2)
            {
                $previousBabyWeigth = $getBabyAllWeigth[$i - 2]['babyWeight'];

                $currentBabyWeigth = $value['babyWeight'];
                $weigthDifference = '';
                if ($previousBabyWeigth > $currentBabyWeigth)
                {
                    $difference = $previousBabyWeigth - $currentBabyWeigth;
                    $weigthDifference = '-' . $difference;
                }
                else
                {
                    $difference = $currentBabyWeigth - $previousBabyWeigth;
                    $weigthDifference = '+' . $difference;
                }
            }

            ######## conditions Baby weigth gain loss #########
            ##### conditions FOR Net Baby weigth gain loss since admission #########
            if ($i > 1)
            {

                if ($getBabyAllWeigth[0]['babyWeight'] > $value['babyWeight'])
                {
                    $difference = $getBabyAllWeigth[0]['babyWeight'] - $value['babyWeight'];
                    $gainLose = $difference . ' loss';
                }
                else
                {
                    $difference = $value['babyWeight'] - $getBabyAllWeigth[0]['babyWeight'];
                    $gainLose = $difference . ' gain';
                }
            }
            ##### conditions FOR Net Baby weigth gain loss since admission #########
            

            $html .= '<tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center ;border:1px solid;padding: 11px ; padding: 7px">' . $i . '</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">' . date('d/m/Y', strtotime($value['weightDate'])) . '</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">' . date('g:i A', $value['addDate']) . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $value['babyWeight'] . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $weigthDifference . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $gainLose . '</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid "></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">' . $nurseName . '</td>
                    <td style="width: 11%;text-align: center;border:1px solid "></td>
                  </tr>';

            $i++;

        }
        if ($type == 'discharge')
        {
            $dischargeTime = ($babyDetails['dateOfDischarge'] != '') ? date('d/m/Y', strtotime($babyDetails['dateOfDischarge'])) : 'N/A';
            $dischargeWeightsGainOrLoss = ($babyDetails['babyDischargeWeight'] != '') ? $babyDetails['weightGainLosePostAdmission'] : 'N/A';
            $html .= '</table>
                <table style="width: 100%;margin-top: 10px" >
                <tr>
                  <th style="text-align: left;font-family: sans-serif;">Date of discharge(dd/mm/yy):' . $dischargeTime . '
                    <span style="padding-left: 20px">Weight of discharge(in grams):</span><input type="text" value="' . $babyDetails['babyDischargeWeight'] . '" id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>
                <tr>
                  <th style="text-align: left;font-family: sans-serif">Net gain/loss since admission(in grams)(+/-):<input type="text"  id="fname" value="' . $dischargeWeightsGainOrLoss . '"  name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>

                </table>';
        }
        else
        {
            $html .= '</table>
                        <table style="width: 100%;margin-top: 10px" >
                        <tr>
                          <th style="text-align: left;font-family: sans-serif;">Date of discharge(dd/mm/yy):-----/-----/-----
                            <span style="padding-left: 20px">Weight of discharge(in grams):</span><input type="text"  id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                        </tr>
                        <tr>
                          <th style="text-align: left;font-family: sans-serif">Net gain/loss since admission(in grams)(+/-):<input type="text"  id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                        </tr>

                        </table>
                        </body>
                        </html>';
        }

        $pdfFilePath = pdfDirectory . "b_" . $babyDetails['id'] . "_weigth.pdf";

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('utf-8', 'A4-L');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F");
        return "b_" . $babyDetails['id'] . "_weigth.pdf";
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

    public function pdfconventer($filename = '', $lastID)
    {
        error_reporting(0);
        // get last baby record at the time of admission
        $getlastAdmissiondata = $this
            ->db
            ->get_where('babyAdmission', array(
            'id' => $lastID
        ))->row_array();
        // get baby reg data
        $getMotherId = $this
            ->db
            ->get_where('babyRegistration', array(
            'babyId' => $getlastAdmissiondata['babyId']
        ))->row_array();

        $MotherData = $this->GetMotherAllData($getMotherId['motherId']);
        $BabyData = $this->GetBabyAllData($getlastAdmissiondata['babyId']);

        $gestationAge = getLmpDeliveryDifference(strtotime($BabyData['deliveryDate']) , strtotime($MotherData['motherLmpDate']));
        $GestationalAge = ($gestationAge == '0') ? 'UNKNOWN' : $gestationAge;

        $getFirstAseessmentbabyData = $this
            ->db
            ->get_where('admissionCheckList', array(
            'babyAdmissionId' => $getlastAdmissiondata['id']
        ))->row_array();

        //$getHospitalInMA=$this->db->get_where('motherAdmission',array('motherId'=>$MotherData['motherId']))->row_array();
        $GR_NAME = ($MotherData['guardianName'] != '') ? $MotherData['guardianName'] : '  ____________________________________________________';
        $GR_Relation = ($MotherData['guardianRelation'] != '') ? $MotherData['guardianRelation'] : '___________________';
        $MCTS = ($MotherData['motherMCTSNumber'] != NULL) ? ' ' . $MotherData['motherMCTSNumber'] : ' --';

        $District_Name = $this->DistrictVillageBlock($MotherData['presentDistrictName'], 3);
        $Dname = ($District_Name != '') ? $District_Name : '';
        $State = ($MotherData['permanentState'] != '') ? $MotherData['permanentState'] : '';
        $Country = ($MotherData['presentCountry'] != '') ? $MotherData['presentCountry'] : '';

        $Block_Name = $this->DistrictVillageBlock($MotherData['presentBlockName'], 2);
        $Bname = ($MotherData['presentBlockName'] != '') ? $MotherData['presentBlockName'] : '';

        $Village_Name = $this->DistrictVillageBlock($MotherData['presentVillageName'], 1);
        $Vname = ($Village_Name != '') ? $Village_Name : '_________________________________';

        $date = date('d/m/Y', $BabyData['addDate']);
        $time = date('h:i A', $BabyData['addDate']);
        $BirthWeigth = ($BabyData['babyWeight'] != '') ? $BabyData['babyWeight'] . ' grams' : '';

        $AdmissionBirthWeigth = ($getlastAdmissiondata['babyAdmissionWeight'] != '') ? $getlastAdmissiondata['babyAdmissionWeight'] . ' grams' : '';

        $deliveryPlace = (($MotherData['facilityId'] == '0') || ($MotherData['facilityId'] == '')) ? ucwords($MotherData['deliveryPlace']) : 'Hospital';

        $FacilityName = ($MotherData['facilityId'] != '0' && $MotherData['facilityId'] != NULL) ? getSingleRowFromTable('FacilityName', 'facilityId', $MotherData['facilityId'], 'facilitylist') : 'Other';

        $RuralUrban = ($MotherData['presentResidenceType'] != '') ? " " . $MotherData['presentResidenceType'] : '  _______________  ';
        $Pincode = ($MotherData['presentPinCode'] != '') ? " " . $MotherData['presentPinCode'] : '  _______________  ';

        $NearBy = ($MotherData['presentAddNearByLocation'] != '') ? " " . $MotherData['presentAddNearByLocation'] : '  _______________  ';
        $Address = ($MotherData['presentAddress'] != '') ? " " . $MotherData['presentAddress'] : '  _______________  ';
        $ashaName = ($MotherData['ashaName'] != '') ? " " . $MotherData['ashaName'] : '  _______________  ';
        $ashaNumber = ($MotherData['ashaNumber'] != '') ? " " . $MotherData['ashaNumber'] : '  _______________  ';

        $Signatures = base_url() . 'assets/images/sign/' . $getFirstAseessmentbabyData['NurseDigitalSign'];

        $NurseSign = ($MotherData['staffId'] != '') ? getSingleRowFromTable('name', 'staffId', $MotherData['staffId'], 'staffMaster') . '<br> ' . date('d/m/Y h:i A') . '<br>' : ' __________________________________________________';

        $MotherNo = ($MotherData['motherMoblieNumber'] != '') ? $MotherData['motherMoblieNumber'] : '____________________________________________________';

        $FatherNo = ($MotherData['fatherMoblieNumber'] != '') ? $MotherData['fatherMoblieNumber'] : '____________________________________________________';

        $Father = ($MotherData['fatherMoblieNumber'] != '') ? 'Father' : ' __________________';
        $Mother = ($MotherData['motherMoblieNumber'] != '') ? 'Mother' : ' __________________';

        if ($MotherData['motherName'] != '')
        {

            $motherName = ($MotherData['motherName'] != '') ? ucwords($MotherData['motherName']) : '__________________';
        }
        elseif ($MotherData['motherName'] == NULL && $MotherData['guardianName'] == NULL)
        {
            $motherName = '__________________';

        }
        elseif ($MotherData['type'] == '2')
        {
            $motherName = 'Unknown';
            $MotherName2 = ($MotherData['motherName'] == NULL) ? '__________________' : $MotherData['motherName'];
            $GR_Relation = 'Unknown';
        }

        if ($MotherData['type'] == '3' || $MotherData['type'] == '1')
        {
            $motherName = $MotherData['motherName'];
            $MotherName2 = ($motherName != 'Unknown') ? $motherName : '';
        }
        else
        {
            $motherName = 'Unknown';
            $MotherName2 = ($motherName == 'Unknown') ? '__________________' : '';
        }

        //$Mname = ($MotherData['type']=='2')? $MotherData['motherName'] : $motherName;
        $fatherName = ($MotherData['fatherName'] != '') ? ucwords($MotherData['fatherName']) : '__________________';

        if ($MotherData['guardianName'] == NULL && $MotherData['guardianNumber'] == NULL)
        {
            if ($GR_Relation == 'Father')
            {

                $GR_NAME = $fatherName;
            }
            else
            {
                $GR_NAME = $MotherData['motherName'];
            }

        }
        else
        {

            $GR_NAME = ($MotherData['guardianName'] != '') ? $MotherData['guardianName'] : '  _________________________________________________';

        }
        $motherName00 = ($MotherData['motherName'] != '') ? ucwords($MotherData['motherName']) : '_____________________';

        $fatherName00 = ($MotherData['fatherName'] != '') ? ucwords($MotherData['fatherName']) : '_____________________';

        $OrganisationName = ($MotherData['OrganizationName'] != '') ? $MotherData['OrganizationName'] : "_____________________";
        $OrganisationAddress = ($MotherData['OrganizationAddress'] != '') ? $MotherData['OrganizationAddress'] : "______________________";

        $OrganisationNumber = ($MotherData['OrganizationNumber'] != '') ? $MotherData['OrganizationNumber'] : "______________________";

        $LMPDate = ($MotherData['motherLmpDate'] != NULL) ? date('d/m/Y', strtotime($MotherData['motherLmpDate'])) : '_____________________';

        //echo $this->db->last_query();
        if ($GestationalAge != 'UNKNOWN')
        {
            $weekPlural = ($GestationalAge > 1) ? 'Weeks' : 'Week';
        }
        //echo $FacilityName;exit;
        /*echo $GestationalAge; exit;*/

        $html = '';
        $html .= '<!DOCtype html>
        <html>
        <head>
          <title>FORM A: KMC UNIT ADMISSION FORM</title>

          <style>
            table, th, td {

                border-collapse: collapse;
            }
        </style>

        </head>
        <body>
          <div style="">
       
            <h3 style ="text-align: center; margin-top:-5px !important"><u> FORM A: KMC UNIT ADMISSION FORM</u> </h3>
            <p style="font-size: 14px"> <b>Objective:</b> To be filled at the time of admission to the KMC unit, before starting long-duration KMC. The form contains information on eligibility of the baby of KMC and detail required for follow-up. </p>
            <p style=" font-size: 14px ; padding-bottom:-5px !important ;"><b><u><i> Information to be collect by nurse on duty in KMC unit from the case sheet, health officials, mother and caregivers. </i></u></b></p>
            <span style="margin-top:-10px">--------------------------------------------------------------------------------------------------------------------------------------------------------</span>
         <div>
            <div style=" padding-bottom: 5px; padding-top: 5px">
                <label> <b>Hospital Reg. No.:</b>' . $getlastAdmissiondata['babyFileId'] . '</label> <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>  MCTS No.:</b> ' . $MCTS . '</label>
            </div> 
            <div style=" padding-bottom: 7px">
              <label><b> Baby of:</b> ' . $motherName . '<label> 
            </div>  
            
            <div>
             <label><b>Date of admission to KMC unit</b> (dd/mm/yyyy): ' . $date . '</label>&nbsp;<label><b>Time of admission</b> (am/pm): ' . $time . '</label>
            </div>
            <br> 
          <div>
            <b>1- </b> <label>BACKGROUND INFORMATION </label>
            <br>
              <div style="margin-top: 15px; margin-left:20px">
                <b> 1.1 Date of Birth</b> (dd/mm/yyyy): ' . date('d/m/Y', strtotime($BabyData['deliveryDate'])) . ' 
              </div>
                <br>
               <div style="margin-top: 2px; margin-left:20px">
                <b> 1.2 Sex: </b> ' . $BabyData['babyGender'] . '
              </div>  
              <br>
          
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.3 Time of Birth </b>(am/pm): ' . $BabyData['deliveryTime'] . '
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
                <br>
              <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.4 type of admission: </b> Inborn/ Outborn
              
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.5 Weight at birth</b> (in grams): ' . $BirthWeigth . '
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.6 Place of birth: </b>' . $deliveryPlace . ' 
            </div>  
            <br> 

            <div style="margin-top: 3px; margin-left:35px">
              <b> 1.6.1 Name and address of birth facility: </b>' . $FacilityName . '         
            </div>   
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 1.7 type of birth: </b> ' . ucwords($BabyData['deliveryType']) . '              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

               </div>   
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
            
                <b> 1.8  Term of birth:</b> Full Term/ Preterm  
            </div>  

            <br>
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.9 LMP </b> (first day of last menstrual period - dd/mm/yyyy): ' . date("d/m/Y", strtotime($MotherData['motherLmpDate'])) . '
              
            </div>
            <br>   
            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.10  Gestational age  </b>(in weeks): ' . $GestationalAge . ' ' . $weekPlural . ' 
            </div>
            <br>

             <div style="margin-top: 3px; margin-left:20px">
              <b> 1.11 Weigth of baby at admission to KMC unit</b> (in grams): ' . $AdmissionBirthWeigth . '

            </div>  
            <br> 

            
            <div style="margin-top: 3px; margin-left:20px">

                <div style="width: 150px"><b>1.12</b></div>
                <div style="margin-left:50px; width: 300px">
                    <table width="100%" cellpadding="5" style="text-align: center;margin-top: -15px;" border="1">
                        <tr>
                            <th>G</th>
                            <th>P</th>
                            <th>A</th>
                            <th>L</th>
                        </tr>
                        <tr>
                            <td>' . $MotherData['gravida'] . '</td>
                            <td>' . $MotherData['para'] . '</td>
                            <td>' . $MotherData['abortion'] . '</td>
                            <td>' . $MotherData['live'] . '</td>
                        </tr>
                    </table>
                </div>  
              
            </div><br>

            <div style="margin-top: 3px; margin-left:20px">
              <b> 1.13   Is the Baby stable? </b>  &nbsp;&nbsp; Yes&nbsp; /&nbsp; No
              <br>
              Is the baby on medication at time of admission? (Specify name and dosage)
              <br>
              <span style="margin-left:20px">1. ______________________________________________</span><br>
              <span style="margin-left:20px">2. ______________________________________________</span><br>
              <span style="margin-left:20px">3. ______________________________________________</span><br>
            </div>   
            <br>


          <div>

          <br>
            <b>2- </b> <label>FAMILY DETAIL (For Follow Up)</label>
            <br>
              <div style="margin-top: 15px; margin-left:20px">
                <b> 2.1 Name of the mother: </b> ' . $motherName00 . '
              </div>
                <br>
              <div style="margin-top: 3px; margin-left:20px">
                <b> 2.2 Name of the father: </b> ' . $fatherName00 . '
              </div>  
              
              <br>
          
            <div style="margin-top: 3px; margin-left:20px">
              <b> 2.3 Name & relation of accompanying family member(s)</b>
              <br><br>
                    <div style="width:60%; float: left;padding-left:15px">
                    ' . $GR_NAME . '
                    </div>   
                    <div style="width:35%; float: right;">
                    ' . $GR_Relation . '
                    </div>    

                    <div style="width:60%; float: left;padding-left:15px">
                    
                    </div>   
                    <div style="width:35%; float: right;">
                    
                    </div>    
                    <div style="width:60%; float: left;padding-left:15px">
                    
                    </div>   
                    <div style="width:35%; float: right;">
                    
                    </div>   
                </div>
                <br>
              <div style="margin-top: 10px; margin-left:20px">    
              <b> 2.4 Contact detail (At least 2 close contact numbers)</b> 
              <br>
              

                    <div style="width:60%; float: left;padding-left:15px">
                     <b> Phone / Mobile Number</b> 
                    </div> 
                    <div style="width:35%; float: right;">
                        <b> Relations</b>   
                    </div> 
                    <br>    
                    <div style="width:60%; float: left;padding-left:15px">
                    ' . $MotherNo . '
                    </div>   
                    <div style="width:35%; float: right;">
                    ' . $MotherName2 . '</div> 
                    

                    <div style="width:60%; float: left;padding-left:15px">
                    ' . $FatherNo . '
                    </div>   
                    <div style="width:35%; float: right;">
                     ' . $fatherName . '                    </div> 
                    <br>   
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:35px">
              <b> 2.4.1 Name and Number of ASHA: </b> ' . ucwords($ashaName) . "&nbsp;&nbsp;&nbsp; " . $ashaNumber . '
            </div>
            <br>
            <div style="margin-top: 3px; margin-left:20px">    
              <b> 2.5 Religion:</b> ' . $MotherData['motherReligion'] . '
            </div>  
            <br> 

            <div style="margin-top: 3px; margin-left:20px">
              <b> 2.6 Caste: </b> ' . $MotherData['motherCaste'] . '         
            </div>   
             <br>';

        if ($MotherData['motherAdmission'] == NULL && $MotherData['notAdmittedreason'] == NULL && $MotherData['type'] == '2')
        {
            $html .= '<div style="margin-top: 3px; margin-left:20px">    
              <b> 2.7 Address: </b>
              <br><br>
              <b> Rural/Urban: </b> ' . $RuralUrban . '<br>
              <b> State/Country: </b> ' . $State . ', ' . $Country . '<br>
              <b> District: </b> ' . $Dname . '<br>
              <b> Block/ Area/ Muhalla:</b> ' . $Bname . '<br>
              <b> Gram Sabha-Hamlet/ House NO.:</b> ' . $Vname . '<br>
              <b> Address:</b>' . $Address . '<br>
              <b> Pin Code:</b>' . $Pincode . '<br>
              <b> Near:</b>' . $NearBy . '<br>

            </div>         
            <br>
            <b> 3- </b> <label> ORGANISATION DETAIL </label>
            <br>  
            <div style="margin-top: 15px; margin-left:20px">
                
                <b>  3.1 Organisation Name: </b> ' . $OrganisationName . '<br>
                <b>  3.2 Organisation Number: </b>' . $OrganisationNumber . '<br>
                <b>  3.3 Organisation Address:</b> ' . $OrganisationAddress . '<br>
                </div>   
               <br>';

        }
        else
        {

            $html .= '<div style="margin-top: 3px; margin-left:20px">    
              <b> 2.7 Address: </b>
              <br><br>
              <b> Rural/Urban: </b> ' . $RuralUrban . '<br>
              <b> State/Country: </b> ' . $State . ', ' . $Country . '<br>
              <b> District: </b> ' . $Dname . '<br>
              <b> Block/ Area/ Muhalla:</b> ' . $Bname . '<br>
              <b> Gram Sabha-Hamlet/ House NO.:</b> ' . $Vname . '<br>
              <b> Address:</b>' . $Address . '<br>
              <b> Pin Code:</b>' . $Pincode . '<br>
              <b> Near:</b>' . $NearBy . '<br>

            </div>         
            <br>';

        }

        $html .= '<div style="margin-top: 15px; margin-left:20px"> 

                    <div style="width:70%; float: left;">
                    <b> Signature of Nurse at the time of admission. </b>
                    </div>   
                    <div style="width:30%; float: right;">
                    <b style="float: right;"> Signature of Doctor </b>
                    </div>   
            
            </div>  
            <br> 

            <div style="margin-top: 3px; margin-left:20px">

            <div style="width:55%;   float: left; margin-left: 5px">' . $NurseSign . '<br>
          
           </div>   
            <div style="width:30%; float: right;"> _______________________  
           </div>   
            </div>   
            <br>
          </div>

        </div>
          
      </div>

    </body>
    </html>';

        /*$fileName = "b_".$BabyData['babyId'].".pdf";*/
        $pdfFilePath = pdfDirectory . $filename;
        //echo $pdfFilePath;
        //load mPDF library
        $this
            ->load
            ->library('m_pdf');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        //generate the PDF from html
        $this
            ->m_pdf
            ->pdf
            ->WriteHTML($PDFContent);

        //download PDF
        $this
            ->m_pdf
            ->pdf
            ->Output($pdfFilePath, "F");

        return $filename;
    }



    //Used
    //CheckList at the time of Admission
    public function admissionCheckList($request)
    {
        $array = array();
        $nurseSign = ($request['nurseDigitalSign'] != '') ? saveImage($request['nurseDigitalSign'], signDirectory) : '';

        $array['checkList']             = $request['checkList'];
        $array['androidUuid']           = trim($request['localId'] != '') ? $request['localId'] : NULL;
        //$array['motherId']              = $request['motherId'];
        $array['nurseId']               = $request['nurseId'];
        //$array['babyId']                = $request['babyId'];
        $array['nurseDigitalSign']      = $nurseSign;

        $array['addDate']               = date('Y-m-d H:i:s');
        //$array['modifyDate']            = date('Y-m-d H:i:s');

        //get last Baby AdmissionId
        $this
            ->db
            ->order_by('id', 'desc');
        $babyAdmisionLastId = $this
            ->db
            ->get_where('babyAdmission', array(
            'babyId' => $request['babyId']
        ))->row_array();

        //get last mother AdmissionId
        $this
            ->db
            ->order_by('id', 'desc');
        $motherAdmisionLastId = $this
            ->db
            ->get_where('motherAdmission', array(
            'motherId' => $request['motherId']
        ))->row_array();


        $array['motherAdmissionId']     = ($motherAdmisionLastId['id'] != '') ? $motherAdmisionLastId['id'] : NULL;
        $array['babyAdmissionId']       = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;

        $inserted = $this
            ->db
            ->insert('admissionCheckList', $array);

        if ($inserted > 0)
        {
            /*$getLastBabyID = $this
                ->db
                ->query("select * from babyAdmission where babyId=" . $request['babyId'] . " order by id desc limit 0,1")->row_array();*/

            $getMotherData = $this
                ->db
                ->query("select motherName from motherRegistration where motherId=" . $request['motherId'] . "")->row_array();

            $getNurseData = $this
                ->db
                ->query("select name from staffMaster where staffId=" . $request['nurseId'] . "")->row_array();

            // create feed registration time
            $param = array();
            $param['type']              = '1';
            $param['loungeId']          = $request['loungeId'];
            $param['babyAdmissionId']   = $babyAdmisionLastId['id'];
            $param['grantedForId']      = $babyAdmisionLastId['id'];
            $param['feed']              = "B/O " . (!empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'UNKNOWN') . " has been admitted by " . $getNurseData['name'] . ".";
            $param['status']            = '1';
            $param['addDate']           = date('Y-m-d H:i:s');
            $param['modifyDate']        = date('Y-m-d H:i:s');

            $this
                ->db
                ->insert('timeline', $param);

            /*$getLastMotherID = $this
                ->db
                ->query("select * from motherAdmission where motherId=" . $request['motherId'] . " order by id desc limit 0,1")->row_array();*/

            $getBabyLastMonitoringId = $this
                ->db
                ->query("select * from babyDailyMonitoring where babyAdmissionId=" . $array['babyAdmissionId'] . " order by id desc limit 0,1")->row_array();

             /*$getMotherAdmissionId = $this
                ->db
                ->query("SELECT MA.id FROM motherAdmission as MA 
                        INNER join motherRegistration as MR 
                        INNER join babyRegistration as BR
                        INNER join babyAdmission as BA
                        on ( BR.babyId = BA.babyId and  BR.motherId = MR.motherId and  MR.motherId = MA.motherId) where  BA.id =" . $array['babyAdmissionId'] )->row_array();*/
            
                
            ############# create weight file #################
            $this
                ->db
                ->where('babyAdmissionId', $babyAdmisionLastId['id']);
            $this
                ->db
                ->order_by('id', 'asc');
            $this
                ->db
                ->update('babyDailyWeight', array(
                'nurseId' => $request['nurseId']
            ));

            //$this->BabyAdmissionPDF->pdfGenerate($babyAdmisionLastId['id']);

            //$PdfName = $this ->babyWeightPdfFile($request['loungeId'], $babyAdmisionLastId['id']);

            // create final pdf
            /*$CheckListPDF = $this
                ->GeneratePdfSNCU
                ->createFinalSNCUPdf($babyAdmisionLastId['id'], $request['nurseId']);*/

            $sehmatiPatraImage = ($request['sehmatiPatr'] != '') ? saveDynamicImage($request['sehmatiPatr'], sehmatiPatra) : '';

            $this
                ->db
                ->where('id', $babyAdmisionLastId['id']);
            $this
                ->db
                ->update('babyAdmission', array(
                'admittedPersonSign' => $nurseSign,
                'attendantStaffId' => $request['nurseId'],
                'sehmatiPatr' => $sehmatiPatraImage
            ));

        
            $this
                ->db
                ->where('id', $getBabyLastMonitoringId['id']);
            $this
                ->db
                ->update('babyDailyMonitoring', array(
                'staffSign' => $nurseSign,
                'staffId' => $request['nurseId']
            ));

            if(!empty($motherAdmisionLastId))
            {
                 $this
                    ->db
                    ->where('id', $motherAdmisionLastId['id']);
                $this
                    ->db
                    ->update('motherAdmission', array(
                    'admittedPersonSign' => $nurseSign
                ));


                 $getMotherLastMonitoringId = $this
                ->db
                ->query("select * from motherMonitoring where motherAdmissionId=" . $motherAdmisionLastId['id'] . " order by id desc limit 0,1")->row_array();

                 // generate pdf here
                $this
                    ->db
                    ->where('id', $getMotherLastMonitoringId['id']);
                $this
                    ->db
                    ->update('motherMonitoring', array(
                    'staffId' => $request['nurseId'],
                    'admittedSign' => $nurseSign
                ));
            }

            return 1;
        }
    }


   // submit doctor examination data 
   public function postExaminationDataViaDoctor($request)
    {   
        $param1 = array();
        $param  = array();
        $arrayName = array();

        $getBabyRecord = $this->db->get_where('babyAdmission',array('id'=>$request['babyAdmissionId']))->row_array();
        $getDataRecord = $this->db->get_where('doctorRound',array('androidUuid'=>$request['localId']))->num_rows();
        
         if($getDataRecord > 0)
         {
            $arrayName['androidUuid']         = $request['localId']; 
            $arrayName['loungeId']            = $request['loungeId'];
            $arrayName['babyId']              = $getBabyRecord['babyId'];
            $arrayName['staffId']             = $request['doctorId'];
            $arrayName['comment']             = $request['comment'];

            
            if($request['doctorSign']!=''){
                $loungeImg=  saveDynamicImage($request['doctorSign'],imageDirectory);
                $arrayName['staffSignature']  =  ($loungeImg!='') ? $loungeImg : NULL;
            }else{
                $arrayName['staffSignature']  =  NULL;
            }       


            $arrayName['addDate']                      = $request['localDateTime'];
            $arrayName['lastSyncedTime']               = date('Y-m-d H:i:s');
            //get last Baby AdmissionId
            $inserted = $this->db->insert('doctorRound', $arrayName);
            $lastID   = $this->db->insert_id();

            $paramsArray['loungeId']                     = $request['loungeId'];
            $paramsArray['dignosys']                     = $request['dignosys'];
            $paramsArray['agaSga']                       = $request['agaSga'];
            $paramsArray['cvsVal']                       = $request['cvsVal'];
            $paramsArray['systemicRespiratoryRate']      = $request['systemicRespiratoryRate'];
            $paramsArray['perAbdomen']                   = $request['perAbdomen'];
            $paramsArray['cnsVal']                       = $request['cnsVal'];
            $paramsArray['otherSignificantFinding']      = $request['otherSignificantFinding'];

            //get last Baby AdmissionId
            $this->db->order_by('id','desc');
            $this->db->where('babyAdmissionId',$request['babyAdmissionId']);
            $inserted = $this->db->update('babyDailyMonitoring', $paramsArray);

            $prescriptionCount       = count($request['prescriptions']);
            // $vaccinationCount  = count($request['vaccination']);
            $investigationCount      = count($request['investigation']);

            for ($i=0; $i < $prescriptionCount; $i++) { 
                $param = array();
                $param['androidUuid']           = $request['prescriptions'][$i]['localId']; 
                $param['loungeId']              = $request['prescriptions'][$i]['loungeId'];
                $param['roundId']               = $lastID; 
                $param['prescriptionName']     = $request['prescriptions'][$i]['prescriptionName'];
                $param['comment']               = $request['prescriptions'][$i]['comment'];
                $param['image']                 = ($request['prescriptions'][$i]['image']!='') ? saveDynamicImage($request['prescriptions'][$i]['image'],babyDirectory) :'';

                $param['doctorId']              = $request['doctorId'];
                $param['babyId']                = $getBabyRecord['babyId'];;
                $param['addDate']               = $request['prescriptions'][$i]['localDateTime'];
                $param['modifyDate']            = date('Y-m-d H:i:s');
                $param['status']                = 1;
                $param['lastSyncedTime']        = date('Y-m-d H:i:s');

                $result = $this->db->insert('doctorBabyPrescription', $param);
            }

            //medicalTest data Post
            for ($k=0; $k < $investigationCount; $k++) { 
                $param2 = array();
                $param2['androidUuid']          = $request['investigation'][$k]['localId']; 
                $param2['loungeId']             = $request['investigation'][$k]['loungeId'];
                $param2['roundId']              = $lastID;
                
                $param2['investigationName']    = $request['investigation'][$k]['investigationName'];
                $param2['doctorId']             = $request['doctorId'];
                $param2['babyId']               = $getBabyRecord['babyId'];
                $param2['doctorComment']        = $request['investigation'][$k]['comment'];
                $param2['status']               = '1';
                $param2['addDate']              = $request['investigation'][$k]['localDateTime'];
                $param2['modifyDate']            = date('Y-m-d H:i:s');
                $param2['lastSyncedTime']       = date('Y-m-d H:i:s');

                $result = $this->db->insert('investigation', $param2);
                
            } 

            
            $listID['localId'] = $request['localId'];;
            $listID['id']      = $lastID;
            $param1[]          = $listID;

            if($result > 0){
               generateServerResponse('1','S');
            }   else{
             generateServerResponse('0','W');
           } 
        }else{
            generateServerResponse('1','S');
        }       
    }


}

