<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetSupplementList extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
      
    }
    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);

        $data['type']       = trim($requestJson[APP_NAME]['type']);   
        $data['babyId']     = trim($requestJson[APP_NAME]['babyId']);
         $data['loungeId']  = trim($requestJson[APP_NAME]['loungeId']);
        $data['Date']       = trim($requestJson[APP_NAME]['date']);
        $data['userType']   = trim($requestJson[APP_NAME]['userType']);
       
        
        $checkRequestKeys = array(                
                                '0' => 'type',
                                '1' => 'babyId',
                                '2' => 'date',
                                '3' => 'loungeId',
                                '4' => 'userType'
                                );
                                
        $resultJson = validateJson($requestJson, $checkRequestKeys);
// for header security 
        $headers    = apache_request_headers();
        $headers    = apache_request_headers();
        if($data['userType'] == '0'){ // for lounge
   
           $loungeData = tokenVerification($data['userType'],$data['loungeId']);
        }else if($data['userType'] == '1'){ // for staff
           $loungeData = tokenVerification($data['userType'],$data['loungeId']);
        }else{
            generateServerResponse('0','218');  
        }
        $getLoungeData = $loungeData->row_array(); 
       // print_r($getLoungeData);exit;
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {       
            		if ($resultJson == 1) {
            			 $this->BabyModel->getSupplementList($data);
            		}else{
             		    generateServerResponse('0','101');				
            		}
                }else{
                   generateServerResponse('0','210');
                }  
            }else{
                generateServerResponse('0','W');
              }  
        }else{
            generateServerResponse('0','211');        
              }     
    }
}
