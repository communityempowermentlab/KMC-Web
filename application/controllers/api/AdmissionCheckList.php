<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AdmissionCheckList extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        //$this->load->model('api/ApiModel');
        // this modal for generate pdf
        $this->load->model('api/MotherBabyAdmissionModel'); 
        $this->load->model('api/BabyAdmissionPDF');
      
    }

    public function index()
    {
        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt         = md5(json_encode($requestJson[APP_NAME]));
        $encryptData        = trim($requestJson['md5Data']);
        //echo $allEncrypt.'||'.$encryptData;exit();
         //echo md5('com.mncu.android');die();

        $data['checkList']           = json_encode($requestJson[APP_NAME]['checkList'],JSON_UNESCAPED_UNICODE); 
        $data['nurseDigitalSign']    = trim($requestJson[APP_NAME]['nurseDigitalSign']);  
        $data['motherId']            = trim($requestJson[APP_NAME]['motherId']);   
        $data['babyId']              = trim($requestJson[APP_NAME]['babyId']); 
        $data['nurseId']             = trim($requestJson[APP_NAME]['nurseId']);
        $data['loungeId']            = trim($requestJson[APP_NAME]['loungeId']);  
        $data['sehmatiPatr']         = trim($requestJson[APP_NAME]['sehmatiPatr']);  
        $data['localId']             = trim($requestJson[APP_NAME]['localId']);
        $checkRequestKeys = array(             
                                    '0' => 'checkList',
                                    '1' => 'nurseDigitalSign',
                                    '2' => 'motherId',
                                    '3' => 'babyId',
                                    '4' => 'nurseId', 
                                    '5' => 'loungeId', 
                                    '6' => 'sehmatiPatr', 
                                    '7' => 'localId'
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

        // mother id validation
        $validateMotherData = $this->db->get_where('motherRegistration', array('motherId' => $requestJson[APP_NAME]['motherId'],'status' => '1'))->row_array();
        if(empty($validateMotherData)){
            generateServerResponse('0', '229');
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
                       
                        $CheckList = $this->MotherBabyAdmissionModel->admissionCheckList($data);

                         if($CheckList > 0)
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