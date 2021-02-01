<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MoveToUnitStatusChange extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/AllMixPdf');
        $this->load->model('api/DischargeModel');
        $this->load->model('api/MotherBabyAdmissionModel');
      
    }
    public function index()
    {
        $requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        //New lines for MD5
        // $allEncrypt         = md5(json_encode($requestJson[APP_NAME])); 
        // $encryptData        = trim($requestJson['md5Data']);
        //echo $allEncrypt.'||'.$encryptData;exit();
        $data['babyId']         = trim($requestJson[APP_NAME]['babyId']);   
        $data['loungeId']       = trim($requestJson[APP_NAME]['loungeId']);
        
        
        $checkRequestKeys = array(                
                                '0' => 'babyId',
                                '1' => 'loungeId'
                            );
        $resultJson = validateJson($requestJson, $checkRequestKeys); 
      //New lines for MD5
        // $checkRequestKeys2 = array(                                                                      
        //                             '0' => APP_NAME,
        //                             '1' => 'md5Data'
        //                             );
        // $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2); 
 // for headers security   
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$requestJson[APP_NAME]['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array(); 
        if($allEncrypt == $encryptData)
        {  
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                    if ($resultJson == 1) {
                        $DischargeFromPost = $this->DischargeModel->MoveToUnitStatusChange($data);
                        if($DischargeFromPost == '1')
                            {
                                generateServerResponse('1','S');
                            }elseif($DischargeFromPost=='2'){
                                generateServerResponse('0','134');
                            }else{
                                generateServerResponse('0','E');
                            }
                    }else{
                        generateServerResponse('0','101');              
                    }
               } else{
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
