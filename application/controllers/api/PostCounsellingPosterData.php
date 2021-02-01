<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
class PostCounsellingPosterData extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
      
    }
    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input'); 
        $requestJson        = json_decode($requestData, true); 
        //New lines for MD5
        $allEncrypt               = createMd5OfString($requestJson[APP_NAME]); 
        $encryptData              = trim($requestJson['md5Data']);
        // echo $allEncrypt.'||'.$encryptData;die;
        $data['counsellingData']       = $requestJson[APP_NAME]['counsellingData'];
       
        $checkRequestKeys = array(                
                                    '0' => 'counsellingData'                         
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        
        
        //New lines for MD5
        $checkRequestKeys2 = array(                                              
                                    '0' => APP_NAME,
                                    '1' => 'md5Data'
                                    );
        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);

        // for headers security   
        $headers    = apache_request_headers();
        //for Acknowledgement Process
        if($allEncrypt == $encryptData)
        {          

          if(!empty($headers['token']) && !empty($headers['package']))
          {
            if($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))
            { 
        		if ($resultJson == 1 && $resultJson2 == 1) {
        			$this->ApiModel->postCounsellingPosterData($data);
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
                generateServerResponse('0','212');        
            } 	     
    }
}
