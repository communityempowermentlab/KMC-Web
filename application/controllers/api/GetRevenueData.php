<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetRevenueData extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this-> load -> model('api/ApiModel');
    }

    public function index()
    {
        $requestData = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        $data['timestamp'] = trim($requestJson[APP_NAME]['timestamp']);

        $checkRequestKeys = array('timestamp' );
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
                    $getRevenueDetails = $this ->ApiModel ->GetRevenueData($data);
                    
                        
                    $response['stateArray']     = $getRevenueDetails['stateData'];
                    $response['districtArray']  = $getRevenueDetails['districtData'];
                    $response['blockArray']     = $getRevenueDetails['blockData'];
                    $response['villageArray']   = $getRevenueDetails['villageData'];
                    $response['count']          = $getRevenueDetails['count'];

                    /*if ($data['timestamp'] != '')
                    {
                        $synctimeRes = $this
                                    ->db
                                    ->query("SELECT modifyDate FROM `revenuevillagewithblcoksandsubdistandgs` ORDER BY modifyDate DESC")
                                    ->row_array();
                        $synctime = $synctimeRes['modifyDate'];
                    }*/
                        

                    //$response['md5Data'] = md5(json_encode($response));
                    generateServerResponseWithoutFilter('1', '219', $response, $synctime);
                    

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

