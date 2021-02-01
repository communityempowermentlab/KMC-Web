<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetLounge extends CI_Controller
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
                    $synctime = '';
                    $getloungeDetailss = $this ->ApiModel ->allLounge($data);
                    if (count($getloungeDetailss) > 0)
                    {
                        $x = 1;
                        foreach ($getloungeDetailss as $key => $loungeDetails)
                        {
                            $loungeDetails['facilityName'] = $this->db->query("select facilityName from facilitylist where facilityId = " . $loungeDetails['facilityId'])->row_array()['facilityName'];
                            $loungeDetails['amenitiesData'] = $this->db->query("select * from loungeAmenities where loungeId = " . $loungeDetails['loungeId'])->row_array();

                            if ($x == 1 && $data['timestamp'] != '')
                            {
                                $synctime = getHighestValue('modifyDate', 'loungeMaster', 'modifyDate');
                            }

                            $response['loungDetail'][] = $loungeDetails;
                            $x++;
                        }

                        $response['md5Data'] = md5(json_encode($response['loungDetail']));
                        generateServerResponse('1', '103', $response, $synctime);
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

