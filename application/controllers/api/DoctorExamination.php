<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
class DoctorExamination extends CI_Controller {
    
    public function __construct()
    {
      parent::__construct();         
      $this->load->model('api/MotherBabyAdmissionModel');
    }
    
    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt                      = createMd5OfString($requestJson[APP_NAME]); 
        $encryptData                     = trim($requestJson['md5Data']);

        $data['loungeId']                = trim($requestJson[APP_NAME]['loungeId']);
        $data['localId']                 = trim($requestJson[APP_NAME]['localId']);
        $data['dignosys']                = trim($requestJson[APP_NAME]['dignosys']);
        $data['agaSga']                  = trim($requestJson[APP_NAME]['agaSga']);
        $data['cvsVal']                  = trim($requestJson[APP_NAME]['cvsVal']);
        $data['cnsVal']                  = trim($requestJson[APP_NAME]['cnsVal']);
        $data['systemicRespiratoryRate'] = trim($requestJson[APP_NAME]['systemicRespiratoryRate']);
        $data['perAbdomen']              = trim($requestJson[APP_NAME]['perAbdomen']);
        $data['otherSignificantFinding'] = trim($requestJson[APP_NAME]['otherSignificantFinding']);
        $data['doctorId']                = trim($requestJson[APP_NAME]['doctorId']);
        $data['doctorSign']              = trim($requestJson[APP_NAME]['doctorSign']);
        $data['comment']                 = trim($requestJson[APP_NAME]['comment']);
        $data['babyAdmissionId']         = trim($requestJson[APP_NAME]['babyAdmissionId']);
        $data['prescriptions']           = $requestJson[APP_NAME]['prescriptions'];
        $data['investigation']           = $requestJson[APP_NAME]['investigation'];

        $data['localDateTime']           = trim($requestJson[APP_NAME]['localDateTime']);
       
        $checkRequestKeys = array(                
                                    '0' => 'loungeId',
                                    '1' => 'localId',                         
                                    '2' => 'dignosys',                         
                                    '3' => 'agaSga',                         
                                    '4' => 'cvsVal',                         
                                    '5' => 'cnsVal',                         
                                    '6' => 'systemicRespiratoryRate',                         
                                    '7' => 'perAbdomen',                         
                                    '8' => 'otherSignificantFinding',                         
                                    '9' => 'doctorId',                         
                                    '10' => 'doctorSign',                         
                                    '11' => 'comment',                         
                                    '12' => 'babyAdmissionId',                         
                                    '13' => 'prescriptions',                         
                                    '14' => 'investigation',                         
                                    '15' => 'localDateTime'                      
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
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$data['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array();  
        //for Acknowledgement Process
        if($allEncrypt == $encryptData)
        {          
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
            		if ($resultJson == 1 && $resultJson2 == 1) {
            			$this->MotherBabyAdmissionModel->postExaminationDataViaDoctor($data);
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
