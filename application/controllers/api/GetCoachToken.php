<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: application/json");
class GetCoachToken extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
    }
    public function index()
    {
     $headers = apache_request_headers();
     if(!empty($headers['package'])){
         if($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))){
            	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
                $requestJson        = json_decode($requestData, true);
                $data['mobileNumber']      = trim($requestJson[APP_NAME]['mobileNumber']);  
                $data['password']= trim($requestJson[APP_NAME]['password']);

                $checkRequestKeys = array(                                        
                                            '0' => 'mobileNumber',
                                            '1' => 'password'
                                            );
                $resultJson = validateJson($requestJson, $checkRequestKeys);
                
                /*print_r($requestJson);exit;*/

        		if ($resultJson == 1) {
        			
        			$CoachDetail = $this->ApiModel->generateCoachToken($data);
        			    if($CoachDetail!=0){
                             $response['loginDetails'] = $CoachDetail;
                            generateServerResponse('1','S', $response);

                        }else{
                            generateServerResponse('0','P');
                        }
        		}else{
        		    
        		    generateServerResponse('0','101');				
        		}
            }  else{

                generateServerResponse('0','W');
            }

       }else{
                generateServerResponse('0','W');
        }
	     
    }
}