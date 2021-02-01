<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');

class MultipleBabyRegistration extends CI_Controller
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
        $requestData = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        //New lines for MD5
        $allEncrypt = createMd5OfString($requestJson[APP_NAME]);
        $encryptData = trim($requestJson['md5Data']);

        
        $data['motherId'] = trim($requestJson[APP_NAME]['motherId']);
        $data['hospitalRegistrationNumber'] = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);
        $data['staffId'] = trim($requestJson[APP_NAME]['staffId']);
        
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['localId'] = trim($requestJson[APP_NAME]['localId']);
        $data['babyPhoto']  = trim($requestJson[APP_NAME]['babyPhoto']);
        $data['birthWeightAvail']  = trim($requestJson[APP_NAME]['birthWeightAvail']);
        $data['typeOfBorn']        = trim($requestJson[APP_NAME]['typeOfBorn']);
        $data['typeOfOutBorn']     = trim($requestJson[APP_NAME]['typeOfOutBorn']);
        $data['reason']            = trim($requestJson[APP_NAME]['reason']);
        $data['deliveryDate']   = trim($requestJson[APP_NAME]['deliveryDate']);
        $data['deliveryTime']   = trim($requestJson[APP_NAME]['deliveryTime']);
        $data['babyGender']     = trim($requestJson[APP_NAME]['babyGender']);
        $data['deliveryType']   = trim($requestJson[APP_NAME]['deliveryType']);
        $data['babyWeight']     = trim($requestJson[APP_NAME]['babyWeight']);

        $checkRequestKeys = array(
            '0' => 'deliveryType',
            '1' => 'babyWeight',
            '2' => 'motherId',
            '3' => 'hospitalRegistrationNumber',
            '4' => 'deliveryTime',
            '5' => 'babyGender',
            '6' => 'staffId',
            '7' => 'deliveryDate',
            '8' => 'loungeId',
            '9' => 'localId',
            '10' => 'babyPhoto',
            '11' => 'birthWeightAvail',
            '12' => 'typeOfBorn',
            '13' => 'typeOfOutBorn',
            '14' => 'reason'
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
                            $post = array();
                            $response = array();

                            // type = 1=>SNCU and 2 is Lounges
                            if ($getLoungeData['type'] == 1)
                            {
                                $isBabyExistInAdmission = checkUniqueValue('babyAdmission', 'babyFileId', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                                $isMotherExistInAdmission = checkUniqueValue('motherAdmission', 'hospitalRegistrationNumber', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                            }
                            else
                            {
                                $isBabyExistInAdmission = checkUniqueValue('babyAdmission', 'babyFileId', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                                $isMotherExistInAdmission = checkUniqueValue('motherAdmission', 'hospitalRegistrationNumber', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                            }

                            if ($isMotherExistInAdmission == 0 && $isBabyExistInAdmission == 0)
                            {
                                $motherRegistration = $this
                                    ->BabyModel
                                    ->multipleBabyRegistration($data);
                            }
                            else
                            {
                                generateServerResponse('0', '136');
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

