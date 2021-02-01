<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: application/json");
class Logout extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
    }
    public function index()
    {
    	$requestData           = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson            = json_decode($requestData, true);
       
        $data['loungeId']      = trim($requestJson[APP_NAME]['loungeId']);  
        $data['loginId']       = trim($requestJson[APP_NAME]['loginId']); 

        $checkRequestKeys = array(                                        
                                    '0' => 'loungeId',
                                    '1' => 'loginId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        // for header code 
         $headers    = apache_request_headers();
            if(!empty($headers['package']))
            {
                if(($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {  
                    if ($resultJson == 1) { 
                     $this->ApiModel->loungeLogout($data);
                    }else{
                      generateServerResponse('0','101');              
                    }
                }else{
                   generateServerResponse('0','210');
                }  
            }else{
                generateServerResponse('0','W');
              }  
    }
}