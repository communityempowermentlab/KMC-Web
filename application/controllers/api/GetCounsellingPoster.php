<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetCounsellingPoster extends CI_Controller
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
                    $getPosterDetails = $this ->ApiModel ->GetCounsellingPoster($data);
                    if (count($getPosterDetails) > 0)
                    {
                        $x = 1;
                        foreach ($getPosterDetails as $key => $value)
                        {
                            $dataArray['id'] = $value['id'];
                            $dataArray['posterType'] = $value['posterType'];
                            $dataArray['videoTitle'] = $value['videoTitle'];
                            $dataArray['videoName'] = videoDirectoryUrl . $value['videoName'];
                            $dataArray['modifyDate'] = $value['modifyDate'];
                            $dataArray['status'] = $value['status'];
                            $arrayName[] = $dataArray;
                            $x++;
                        }
                        $response['posters'] = $arrayName;
                        $response['md5Data'] = md5(json_encode($response['posters']));
                        generateServerResponse('1', '222', $response, $synctime);
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

