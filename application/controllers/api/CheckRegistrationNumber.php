<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CheckRegistrationNumber extends CI_Controller
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

        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['registrationNumber'] = trim($requestJson[APP_NAME]['registrationNumber']);

        $checkRequestKeys = array('loungeId','registrationNumber');
        $resultJson = validateJson($requestJson, $checkRequestKeys);

        // for headers security
        $headers = apache_request_headers();

        if (!empty($headers['package']))
        {
            if (($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
            {
                if ($resultJson == 1)
                {
                    // lounge id validation
                    $validateLoungeData = $this->db->get_where('loungeMaster', array('loungeId' => $requestJson[APP_NAME]['loungeId'],'status' => '1'))->row_array();
                    if(empty($validateLoungeData)){
                        generateServerResponse('0', '211');
                    }

                    $post = array();
                    $response = array();
                    
                    $getRegistrationNumber = $this ->ApiModel ->validateRegistrationNumber($data);
                    if ($getRegistrationNumber > 0)
                    {
                        generateServerResponse('0', '230');
                    }
                    else
                    {
                        generateServerResponse('1', '231');
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

