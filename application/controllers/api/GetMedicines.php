<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetMedicines extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/ApiModel');
    }

    public function index()
    {
        $requestData = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        $data['timestamp'] = trim($requestJson[APP_NAME]['timestamp']);

        $checkRequestKeys = array('timestamp');
        $resultJson = validateJson($requestJson, $checkRequestKeys);

        // for headers security
        $headers = apache_request_headers();
        if (!empty($headers['package']))
        {
            if (($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
            {
                if ($resultJson == 1)
                {
                    $post = array();
                    $response = array();
                    $synctime = date('Y-m-d H:i:s');
                    $getMedicineList = $this->ApiModel->GetMedicines($data);
                    if (count($getMedicineList) > 0)
                    {
                        $x = 1;
                        foreach ($getMedicineList as $key => $value)
                        {
                            $dataArray['id'] = $value['id'];
                            $dataArray['name'] = $value['name'];
                            $arrayName[] = $dataArray;
                            $x++;
                        }
                        $response['medicines'] = $arrayName;
                        $response['md5Data'] = md5(json_encode($response['medicines']));
                        generateServerResponse('1', '236', $response, $synctime);
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
}

