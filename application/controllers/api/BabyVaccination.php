<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
class BabyVaccination extends CI_Controller
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

        $allEncrypt = createMd5OfString($requestJson[APP_NAME]);
        $encryptData = trim($requestJson['md5Data']);

        $data['vaccinationData'] = $requestJson[APP_NAME]['vaccinationData'];
        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);

        $checkRequestKeys = array(
            '0' => 'vaccinationData',
            '1' => 'loungeId'
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
            'loungeId' => $data['loungeId'],
            'status' => '1'
        ));
        $getLoungeData = $loungeData->row_array();
        //for Acknowledgement Process
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
                            $this
                                ->BabyModel
                                ->postBabyVaccination($data);
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

