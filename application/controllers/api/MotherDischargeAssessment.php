<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');

class MotherDischargeAssessment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/MotherBabyAdmissionModel');
    }

    public function index()
    {
        $requestData = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt = createMd5OfString($requestJson[APP_NAME]);
        $encryptData = trim($requestJson['md5Data']);

       
        #=============== Mother Admission =======================#
        $data['motherId'] = trim($requestJson[APP_NAME]['motherId']);
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['motherTemperature'] = trim($requestJson[APP_NAME]['motherTemperature']);


        #=============== Mother Monitoring ======================#
        $data['motherSystolicBP'] = trim($requestJson[APP_NAME]['motherSystolicBP']);
        $data['motherDiastolicBP'] = trim($requestJson[APP_NAME]['motherDiastolicBP']);
        $data['motherUterineTone'] = trim($requestJson[APP_NAME]['motherUterineTone']);
        $data['motherPulse'] = trim($requestJson[APP_NAME]['motherPulse']);
        $data['motherUrinationAfterDelivery'] = trim($requestJson[APP_NAME]['motherUrinationAfterDelivery']);
        $data['episitomyCondition'] = trim($requestJson[APP_NAME]['episitomyCondition']);
        $data['sanitoryPadStatus'] = trim($requestJson[APP_NAME]['sanitoryPadStatus']);
        $data['isSanitoryPadStink'] = trim($requestJson[APP_NAME]['isSanitoryPadStink']);
        $data['admittedSign'] = trim($requestJson[APP_NAME]['admittedSign']);
        $data['other'] = trim($requestJson[APP_NAME]['other']);
        $data['padPicture'] = trim($requestJson[APP_NAME]['padPicture']);
        $data['type'] = trim($requestJson[APP_NAME]['type']);
        $data['hospitalRegistrationNumber'] = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);
        $data['localId'] = trim($requestJson[APP_NAME]['localId']);
        $data['temperatureUnit'] = trim($requestJson[APP_NAME]['temperatureUnit']);
        $data['padNotChangeReason'] = trim($requestJson[APP_NAME]['padNotChangeReason']);
        //$data['doctorIncharge'] = trim($requestJson[APP_NAME]['doctorIncharge']);

        $checkRequestKeys = array(
            '0' => 'motherId',
            '1' => 'loungeId',
            '2' => 'padPicture',
            '3' => 'motherSystolicBP',
            '4' => 'motherDiastolicBP',
            '5' => 'motherUterineTone',
            '6' => 'motherPulse',
            '7' => 'motherUrinationAfterDelivery',
            '8' => 'episitomyCondition',
            '9' => 'sanitoryPadStatus',
            '10' => 'isSanitoryPadStink',
            '11' => 'admittedSign',
            '12' => 'other',
            '13' => 'motherTemperature',
            '14' => 'type',
            '15' => 'hospitalRegistrationNumber',
            '16' => 'localId',
            '17' => 'temperatureUnit',
            '18' => 'padNotChangeReason'
        );
        $resultJson = validateJson($requestJson, $checkRequestKeys);

        //New lines for MD5
        $checkRequestKeys2 = array(
            '0' => APP_NAME,
            '1' => 'md5Data'
        );
        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);

        // for headers security
        $headers = apache_request_headers();
        $loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $requestJson[APP_NAME]['loungeId'],
            'status' => '1'
        ));
        $getLoungeData = $loungeData->row_array();
        if ($allEncrypt == $encryptData)
        {
            if ($loungeData->num_rows() != 0)
            {
                if (!empty($headers['token']) && !empty($headers['package']))
                {
                    if (($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                    {
                        if ($resultJson == 1 && $resultJson2 == 1)
                        {
                            $response = array();
                            $badyData = $this
                                ->MotherBabyAdmissionModel
                                ->motherDischargeAssessment($data);
                            if ($badyData != 0)
                            {
                                generateServerResponse('1', 'S', $badyData);
                            }
                            else
                            {
                                generateServerResponse('0', 'W');
                            }
                        }
                        else
                        {

                            generateServerResponse('0', '101');
                        }
                    }
                    else
                    {
                        generateServerResponse('0', '210');
                    }
                }
                else
                {
                    generateServerResponse('0', 'W');
                }
            }
            else
            {
                generateServerResponse('0', '211');
            }
        }
        else
        {
            generateServerResponse('0', '212');
        }
    }
}

