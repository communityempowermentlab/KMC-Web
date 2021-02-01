<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class RegisteredBabyAdmission extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        //$this->load->model('api/ApiModel');
        // this modal for generate pdf
        $this->load->model('api/BabyModel'); 
      
    }

    public function index()
    {
        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt         = md5(json_encode($requestJson[APP_NAME]));
        $encryptData        = trim($requestJson['md5Data']);

        $data['babyId']              = trim($requestJson[APP_NAME]['babyId']); 
        $data['hospitalRegistrationNumber']             = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);
        $data['loungeId']            = trim($requestJson[APP_NAME]['loungeId']);  
        $data['localId']             = trim($requestJson[APP_NAME]['localId']);
        $data['nurseId']             = trim($requestJson[APP_NAME]['nurseId']);
        
        $checkRequestKeys = array(             
                                    '0' => 'babyId',
                                    '1' => 'hospitalRegistrationNumber',
                                    '2' => 'loungeId',
                                    '3' => 'localId',
                                    '4' => 'nurseId'
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
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$requestJson[APP_NAME]['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array(); 

        // baby id validation
        $validateBabyData = $this->db->get_where('babyRegistration', array('babyId' => $requestJson[APP_NAME]['babyId'],'status' => '1'))->row_array();
        if(empty($validateBabyData)){
            generateServerResponse('0', '228');
        }

        // nurse id validation
        $validateNurseData = $this->db->get_where('staffMaster', array('staffId' => $requestJson[APP_NAME]['nurseId'],'status' => '1'))->row_array();
        if(empty($validateNurseData)){
            generateServerResponse('0', '227');
        }

        // validate lounge and nurse facility is same
        if($getLoungeData['facilityId'] != $validateNurseData['facilityId']){
            generateServerResponse('0','225');
        }

        if($allEncrypt == $encryptData)
        {  
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                    if ($resultJson == 1 && $resultJson2 == 1) {
                        $arrayName = array();
                        $response  = array();
                        $synctime  = '';
                       
                        $result = $this->BabyModel->RegisteredBabyAdmission($data);

                        if($result > 0)
                        {
                            generateServerResponse('1','S');      
                        }else{
                            generateServerResponse('0','E');      
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