<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//header("Content-type: application/json");
class GetVideo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/ApiModel');

    }
    public function index()
    {
        $requestData = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);
        if(empty($requestJson)){
            $requestJson = json_decode('{"kmcV2": {"timestamp": ""}}',true);
        }

        if(isset($requestJson[APP_NAME]['timestamp'])){
            $data['timestamp'] = trim($requestJson[APP_NAME]['timestamp']);
        }else{
            $data['timestamp'] = "";
        }
        
        if(isset($requestJson[APP_NAME]['timestamp'])){
            $checkRequestKeys = array('timestamp');
        }else{
            $checkRequestKeys = "";
        }
        
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        
        // for headers security
        $headers = apache_request_headers();
        if (!empty($headers['package']))
        {
            if ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))
            {
                if ($resultJson == 1)
                {
                    if(isset($data['timestamp']) && !empty($data['timestamp'])){
                        $videos = $this->db->get_where('counsellingMaster', array('modifyDate >='=>$data['timestamp'],'videoType !='=>3,'status'=>'1'))->result_array();
                    }else{
                        $videos = $this->db->get_where('counsellingMaster', array('videoType !='=>3,'status'=>'1'))->result_array();
                    }
                    $synctime = date('Y-m-d H:i:s');
                    $arrayName = array();
                    foreach ($videos as $key => $value)
                    {
                        $Hold['id'] = $value['id'];
                        $Hold['videoType'] = $value['videoType'];
                        $Hold['videoTitle'] = $value['videoTitle'];
                        $Hold['videoName'] = videoDirectoryUrl . $value['videoName'];
                        $Hold['modifyDate'] = $value['modifyDate'];
                        $arrayName[] = $Hold;
                    }
                    $response['videos'] = $arrayName;
                    if (count($response['videos']) > 0)
                    {
                        $response['md5Data'] = md5(json_encode($response['videos']));
                        generateServerResponse('1', 'S', $response, $synctime);
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

