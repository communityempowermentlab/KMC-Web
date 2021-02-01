<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//header("Content-type: application/json");
class GetStaff extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this ->load ->model('api/ApiModel');
    }

    public function index()
    {
        $requestData = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        $data['loungeId'] = trim($requestJson[APP_NAME]['loungeId']);
        $data['timestamp'] = trim($requestJson[APP_NAME]['timestamp']);
        $checkRequestKeys = array( 'loungeId','timestamp');

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        // for header security
        $headers = apache_request_headers();

        $loungeData = $this
            ->db
            ->get_where('loungeMaster', array(
            'loungeId' => $requestJson[APP_NAME]['loungeId'],
            'status' => '1'
        ));

        $getLoungeData = $loungeData->row_array();
        
        if ($loungeData->num_rows() != 0)
        {
            if (!empty($headers['token']) && !empty($headers['package']))
            {
                if (($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                    if ($resultJson == 1)
                    {
                        $arrayName = array();
                        $response = array();
                        $synctime = '';

                        $GetStaff = $this
                            ->ApiModel
                            ->getStaff($data);

                        if (count($GetStaff) > 0)
                        {
                            $x = 1;
                            foreach ($GetStaff as $key => $arrayName)
                            {
                                $getStafftype = $this
                                    ->db
                                    ->get_where('staffType', array(
                                    'staffTypeId' => $arrayName['staffType']
                                ))->row_array();

                                $arrayName['staffTypeName'] = $getStafftype['staffTypeNameEnglish'];
                                $arrayName['profilePicture'] =($arrayName['profilePicture'] != '') ? base_url() . 'assets/nurse/' . $arrayName['profilePicture'] : '';
                                if ($x == 1 && $data['timestamp'] != '')
                                {
                                    $synctime = getHighestValue('modifyDate', 'staffMaster', 'modifyDate');
                                }

                                $response['staffDetails'][] = $arrayName;
                            }

                            $response['md5Data'] = md5(json_encode($response['staffDetails']));
                            
                            generateServerResponse('1', 'S', $response, $synctime);
                        }
                        else
                        {
                            generateServerResponse('0', 'E');
                        }
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

