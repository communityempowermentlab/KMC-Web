<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
class LoungeServices extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/LoungeModel'); 
    }

    public function index()
    {
        $requestData              = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson              = json_decode($requestData, true);
        
        $allEncrypt               = createMd5OfString($requestJson[APP_NAME]); 
        $encryptData              = trim($requestJson['md5Data']);
        $data['serviceData']      = $requestJson[APP_NAME]['serviceData'];
        $data['loungeId']         = trim($requestJson[APP_NAME]['loungeId']);   
        // echo $allEncrypt .'|||'.$encryptData ;die;
        $validateRequestKeys = array(                                        
                                    '0' => 'serviceData',
                                    '1' => 'loungeId'
                                    );
        $resultJson = validateJson($requestJson, $validateRequestKeys); 

        //New lines for MD5
        $validateRequestKeysMain = array(                                              
                                    '0' =>  APP_NAME,
                                    '1' => 'md5Data'
                                    );

        $resultJsonMain = validateJsonMd5($requestJson, $validateRequestKeysMain); 
       
        //for headers security  
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster',array('loungeId'=>$data['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array();  
        if($allEncrypt == $encryptData)
        {          
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                    if ($resultJson == 1 && $resultJsonMain == 1) {
                        $post = array() ;
                        $response = array();
                        $loungeAssessment = $this->LoungeModel->postLoungeServices($data);
                            if($loungeAssessment != 0){
                                generateServerResponse('1','S');
                            }else{ 
                                generateServerResponse('0','W');
                            }
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
        }else{ 
            generateServerResponse('0','212');        
        }           
    }
}