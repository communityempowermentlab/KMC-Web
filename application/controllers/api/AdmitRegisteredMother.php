<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');

class AdmitRegisteredMother extends CI_Controller
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
        

        $data['loungeId']   = trim($requestJson[APP_NAME]['loungeId']);
        $data['localId']    = trim($requestJson[APP_NAME]['localId']);
        

        $checkRequestKeys = array(
            '0' => 'motherId',
            '1' => 'loungeId',
            '2' => 'localId'
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
                            $isMotherAdmitted = $this->db->get_where('motherAdmission', array('motherId' => $data['motherId']))->row_array();
                            // type = 1=>SNCU and 2 is Lounges
                            if (!empty($isMotherAdmitted))
                            {
                                generateServerResponse('0', '220');
                            }
                            else
                            {
                                $motherRegistration = $this
                                    ->BabyModel
                                    ->AdmitRegisteredMother($data);
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

