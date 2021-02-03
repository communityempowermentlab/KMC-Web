<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetBabyCounsellingPoster extends CI_Controller
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

        $checkRequestKeys = array('loungeId');
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
                    
                    $posterList = $this->ApiModel->GetBabyCounsellingPoster($data);
                    if (!empty($posterList))
                    {
                        foreach ($posterList as $key => $value)
                        {
                            $dataArray['babyId'] = $value['babyId'];
                            $dataArray['loungeId'] = $value['loungeId'];
                            $dataArray['posterType'] = $value['posterType'];
                            $dataArray['posterId'] = $value['posterId'];
                            $dataArray['videoTitle'] = $value['videoTitle'];
                            $dataArray['duration'] = $value['duration'];
                            $dataArray['addDate'] = $value['addDate'];
                            
                            $arrayName[] = $dataArray;
                        }
                        $response['posters'] = $arrayName;
                        generateServerResponse('1', '222',$response);
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

