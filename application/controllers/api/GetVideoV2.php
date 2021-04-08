<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//header("Content-type: application/json");
class GetVideoV2 extends CI_Controller
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
        $data['videoType'] = trim($requestJson[APP_NAME]['videoType']);

        if(empty($requestJson)){
            $requestJson = json_decode('{"kmcV2": {"timestamp": ""}}',true);
        }

        if(isset($requestJson[APP_NAME]['timestamp'])){
            $data['timestamp'] = trim($requestJson[APP_NAME]['timestamp']);
        }else{
            $data['timestamp'] = "";
        }
        
        if(isset($requestJson[APP_NAME]['timestamp'])){
            //$checkRequestKeys = array('timestamp');
        }else{
            //$checkRequestKeys = "";
        }

        $checkRequestKeys = array(
            '0' => 'videoType',
        );
        
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        
                
            // for headers security
        $headers = apache_request_headers();
        if (!empty($headers['package']))
        {
            if ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))
            {
                if ($resultJson == 1)
                {
                    if($data['videoType']=='1' || $data['videoType']=='2')
                    {
                    

                    if(isset($data['timestamp']) && !empty($data['timestamp'])){
                        $videos = $this->db->get_where('counsellingMaster', array('modifyDate >='=>$data['timestamp'],'videoType'=>$data['videoType'],'status'=>'1'))->result_array();
                    }else{
                        $videos = $this->db->get_where('counsellingMaster', array('videoType'=>$data['videoType'],'status'=>'1'))->result_array();
                    }
                    $synctime = date('Y-m-d H:i:s');
                    $arrayName = array();
                    foreach ($videos as $key => $value)
                    {
                        $Hold['id'] = $value['id'];
                        $Hold['videoType'] = $value['videoType'];
                        $titlebreak = explode("|",$value['videoTitle']);

                        $Hold['videoTitle'] = $titlebreak['0'];
                        if(!empty($titlebreak['1'])){
                            $Hold['videoTitleHindi'] = $titlebreak['1'];
                        }
                        
                        $Hold['videoName'] = $value['videoName'];
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
                    generateServerResponse('0', '237');
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

