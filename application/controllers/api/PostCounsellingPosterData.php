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

                    // validate data
                    foreach($data['counsellingData'] as $key_poster => $counsellingDataList){
                        // baby id validation
                        $validateBabyData = $this->db->get_where('babyRegistration', array('babyId' => $counsellingDataList['babyId'],'status' => '1'))->row_array();
                        if(empty($validateBabyData)){
                            generateServerResponse('0', '228');
                        }

                        // lounge id validation
                        $validateLoungeData = $this->db->get_where('loungeMaster', array('loungeId' => $counsellingDataList['loungeId'],'status' => '1'))->row_array();
                        if(empty($validateLoungeData)){
                            generateServerResponse('0', '211');
                        }

                        // poster id validation
                        $validatePosterData = $this->db->get_where('counsellingMaster', array('id' => $counsellingDataList['posterId'],'videoType'=>3,'status' => '1'))->row_array();
                        if(empty($validatePosterData)){
                            generateServerResponse('0', '235');
                        }
                    }

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
