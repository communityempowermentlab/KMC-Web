<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//header("Content-type: application/json");
class GetMonthlyDashboardData extends CI_Controller
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
        $data['type'] = trim($requestJson[APP_NAME]['type']);
        
        if($data['type'] == 1){
            $checkRequestKeys = array( 'loungeId');
        } else {
            $data['coachId'] = trim($requestJson[APP_NAME]['coachId']);
            $checkRequestKeys = array(                                        
                                    '0' => 'coachId',
                                    '1' => 'loungeId'
                                    );
        }

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        // for header security
        $headers = apache_request_headers();

        $loungeData = $this
                ->db
                ->get_where('loungeMaster', array(
                'loungeId' => $requestJson[APP_NAME]['loungeId'],
                'status' => '1'
            ));

        if($data['type'] == 1){
            

            $getLoungeData = $loungeData->row_array();
            $token = $getLoungeData['token'];
        } else {
            $coachData = $this->db->get_where('coachMaster', array('id'=>$data['coachId'],'status'=>'1'));
            $getCoachData = $coachData->row_array();
            $token = $getCoachData['token'];
        }
        
        if ($loungeData->num_rows() != 0)
        {
            if (!empty($headers['token']) && !empty($headers['package']))
            {
                if (($headers['token'] == $token) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                    if ($resultJson == 1)
                    {
                        
                        $result = $this
                            ->ApiModel
                            ->getMonthlyDashboardData($data);

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

