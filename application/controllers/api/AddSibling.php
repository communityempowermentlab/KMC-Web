<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');

class AddSibling extends CI_Controller
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
        

         // echo $allEncrypt.'||'.$encryptData;exit;
        $data['motherId'] = trim($requestJson[APP_NAME]['motherId']);
        $data['staffId'] = trim($requestJson[APP_NAME]['staffId']);
        
        $data['hospitalRegistrationNumber'] = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);

        $data['loungeId']   = trim($requestJson[APP_NAME]['loungeId']);
        $data['localId']    = trim($requestJson[APP_NAME]['localId']);
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
        $data['infantComingFrom']     = trim($requestJson[APP_NAME]['infantComingFrom']);
        

        $checkRequestKeys = array(
            '0' => 'motherId',
            '1' => 'staffId',
            '2' => 'hospitalRegistrationNumber',
            '3' => 'loungeId',
            '4' => 'localId',
            '5' => 'babyPhoto',
            '6' => 'birthWeightAvail',
            '7' => 'typeOfBorn',
            '8' => 'typeOfOutBorn',
            '9' => 'reason',
            '10' => 'deliveryDate',
            '11' => 'deliveryTime',
            '12' => 'babyGender',
            '13' => 'deliveryType',
            '14' => 'babyWeight',
            '15' => 'infantComingFrom'
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
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId' => $requestJson[APP_NAME]['loungeId'],'status' => '1'));
        $getLoungeData = $loungeData->row_array();

        // nurse id validation
        $validateNurseData = $this->db->get_where('staffMaster', array('staffId' => $requestJson[APP_NAME]['staffId'],'status' => '1'))->row_array();
        if(empty($validateNurseData)){
            generateServerResponse('0', '227');
        }

        // mother id validation
        $validateMotherData = $this->db->get_where('motherRegistration', array('motherId' => $requestJson[APP_NAME]['motherId'],'status' => '1'))->row_array();
        if(empty($validateMotherData)){
            generateServerResponse('0', '229');
        }

        // validate lounge and nurse facility is same
        if($getLoungeData['facilityId'] != $validateNurseData['facilityId']){
            generateServerResponse('0','225');
        }

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
                                // $isMotherExistInAdmission = checkUniqueValue('motherAdmission', 'hospitalRegistrationNumber', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                            }
                            else
                            {
                                $isBabyExistInAdmission = checkUniqueValue('babyAdmission', 'babyFileId', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                                // $isMotherExistInAdmission = checkUniqueValue('motherAdmission', 'hospitalRegistrationNumber', $data['hospitalRegistrationNumber'], 'loungeId', $data['loungeId']);
                            }

                            if ($isBabyExistInAdmission == 0)
                            {
                                $motherRegistration = $this
                                    ->BabyModel
                                    ->addSibling($data);
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

