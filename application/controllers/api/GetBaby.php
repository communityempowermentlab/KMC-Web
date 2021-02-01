<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetBaby extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/BabyModel');
    }

    public function index()
    {
        $requestData = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['coachId'] = trim($requestJson[APP_NAME]['coachId']);
        $checkRequestKeys = array(
            'loungeId',
            'coachId'
        );

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        $headers = apache_request_headers();

        $coachData = $this->db->get_where('coachMaster', array('id'=>$data['coachId'],'status'=>'1'));

        
        if ($coachData->num_rows() != 0)
        {   $getCoachData = $coachData->row_array();
            if (!empty($headers['token']) && !empty($headers['package']))
            {
                if (($headers['token'] == $getCoachData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {

                    if ($resultJson == 1)
                    {
                        $arrayName = array();
                        $response = array();
                        $synctime = '';
                        $getAllBabies = $this
                            ->BabyModel
                            ->getAllBabies($data);

                        if (count($getAllBabies) > 0)
                        {
                            $x = 1;
                            foreach ($getAllBabies as $key => $babyDetails)
                            {
                                $checkMonitoringOrNot = $this
                                    ->db
                                    ->get_where('babyDailyMonitoring', array(
                                    'babyAdmissionId' => $babyDetails['babyAdmissionId']
                                ))->num_rows();
                                if ($checkMonitoringOrNot > 0)
                                {

                                    $lastAssessmentData = $this
                                        ->db
                                        ->query("SELECT * FROM  babyDailyMonitoring  where babyAdmissionId = " . $babyDetails['babyAdmissionId'] . " order by id DESC limit 0,1 ")->row_array();

                                    $image = getSingleRowFromTable('babyPhoto', 'babyId', $babyDetails['babyId'], 'babyRegistration');
                                    $arrayName['babyAdmissionId'] = $babyDetails['babyAdmissionId'];
                                    $arrayName['babyId'] = $babyDetails['babyId'];
                                    $arrayName['motherId'] = getSingleRowFromTable('motherId', 'babyId', $babyDetails['babyId'], 'babyRegistration'); #$babyDetails['motherId'];
                                    $arrayName['motherName'] = getSingleRowFromTable('motherName', 'motherId', $arrayName['motherId'], 'motherRegistration'); #$babyDetails['motherName'];
                                    $arrayName['lastAssessmentDateTime'] = $lastAssessmentData['addDate'];

                                    $arrayName['babyWeight'] = getLastEnteredData('babyMeasuredWeight', 'babyAdmissionId', $babyDetails['babyAdmissionId'], 'babyDailyMonitoring');

                                    $arrayName['babyPhoto'] = ($image != '') ? babyDirectoryUrl . getSingleRowFromTable('babyPhoto', 'babyId', $babyDetails['babyId'], 'babyRegistration') : '';

                                    $this
                                    ->db
                                    ->order_by('id', 'desc');
                                    $getBabyLastWeight = $this
                                        ->db
                                        ->get_where('babyDailyWeight', array(
                                        'babyAdmissionId' => $babyDetails['babyAdmissionId']
                                    ))->row_array();

                                    $babyIconStatus = $this
                                        ->BabyModel
                                        ->getBabyIcon($lastAssessmentData);

                                    if ($babyIconStatus == '0')
                                    {
                                        $arrayName['status'] = 1; // danger
                                    }
                                    else
                                    {
                                        $arrayName['status'] = 0; // safe
                                    }

                                    $arrayName['dob'] = getSingleRowFromTable('deliveryDate', 'babyId', $babyDetails['babyId'], 'babyRegistration');
                                    $arrayName['temperature'] = $lastAssessmentData['temperatureValue'];
                                    $arrayName['pulseRate'] = $lastAssessmentData['pulseRate'];
                                    $arrayName['respiratoryRate'] = $lastAssessmentData['respiratoryRate'];
                                    $arrayName['spO2'] = $lastAssessmentData['spo2'];
                                    $arrayName['isPulseOximatoryDeviceAvail'] = $lastAssessmentData['isPulseOximatoryDeviceAvail'];
                                    $arrayName['addDate'] = $babyDetails['admissionDateTime'];
                                    $arrayName['babyFileId'] = $babyDetails['babyFileId'];
                                    $arrayName['birthWeight'] = getSingleRowFromTable('babyWeight', 'babyId', $babyDetails['babyId'], 'babyRegistration');
                                    $arrayName['currentWeight'] = (!empty($getBabyLastWeight)) ? $getBabyLastWeight['babyWeight'] : '';
                                    $arrayName['babyPhoto'] = ($image != '') ? babyDirectoryUrl . getSingleRowFromTable('babyPhoto', 'babyId', $babyDetails['babyId'], 'babyRegistration') : '';
                                    $response['babyList'][] = $arrayName;

                                    $x++;

                                }
                            }
                            generateServerResponse('1', '130', $response);
                        }
                        else
                        {
                            generateServerResponse('0', 'E');
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

}

