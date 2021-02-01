<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: application/json");
class GetToken extends CI_Controller {
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
                $data['loungeId']      = trim($requestJson[APP_NAME]['loungeId']);  
                $data['loungePassword']= trim($requestJson[APP_NAME]['loungePassword']);

                $checkRequestKeys = array(                                        
                                            '0' => 'loungeId',
                                            '1' => 'loungePassword'
                                            );
                $resultJson = validateJson($requestJson, $checkRequestKeys);
                
                /*print_r($requestJson);exit;*/

        		if ($resultJson == 1) {
        			
        			$LoungeDetail = $this->ApiModel->generateToken($data);
        			    if($LoungeDetail!=0){
                            $response['loginDetails'] = $LoungeDetail;
                            generateServerResponse('1','S', $response);

                        } else {
                            generateServerResponse('3','P');
                        }
        		}else{
        		    
        		    generateServerResponse('0','101');				
        		}
            }  else{

                generateServerResponse('0','W');
            }

        } else{
                generateServerResponse('0','W');
        }
	     
    }
}