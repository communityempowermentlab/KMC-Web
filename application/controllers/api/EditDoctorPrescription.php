<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
class EditDoctorPrescription extends CI_Controller {
  public function __construct()
    {
      parent::__construct();         
      $this->load->model('api/NurseModel');
      $this->load->model('api/CreatePdf');
    }
    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt               = createMd5OfString($requestJson[APP_NAME]); 
        $encryptData              = trim($requestJson['md5Data']);
       // echo $allEncrypt.'||'.$encryptData;exit;
        //echo md5('com.mncu.android');exit();
        
        $data['loungeId']               = trim($requestJson[APP_NAME]['loungeId']);
        $data['localId']                = $requestJson[APP_NAME]['localId'];
        $data['prescriptionId']         = $requestJson[APP_NAME]['prescriptionId'];
        $data['roundId']                = $requestJson[APP_NAME]['roundId'];
        $data['treatmentName']          = $requestJson[APP_NAME]['treatmentName'];
        $data['comment']                = $requestJson[APP_NAME]['comment'];
        $data['image']                  = $requestJson[APP_NAME]['image'];
        $data['doctorId']               = $requestJson[APP_NAME]['doctorId'];
        $data['babyId']                 = $requestJson[APP_NAME]['babyId'];
        $data['localDateTime']          = $requestJson[APP_NAME]['localDateTime'];


       
        $checkRequestKeys = array(                
                                    '0' => 'loungeId',
                                    '1' => 'localId', 
                                    '2' => 'roundId',
                                    '3' => 'treatmentName',
                                    '4' => 'comment',
                                    '5' => 'image',
                                    '6' => 'doctorId',
                                    '7' => 'babyId',
                                    '8' => 'localDateTime',
                                    '9' => 'prescriptionId'                     
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
            			$this->NurseModel->editDoctorPrescription($data);
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
