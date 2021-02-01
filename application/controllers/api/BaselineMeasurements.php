<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BaselineMeasurements extends CI_Controller {
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
        // print_r(json_encode($requestJson[APP_NAME]));die;
        $allEncrypt         = createMd5OfString($requestJson[APP_NAME]);
        $encryptData        = trim($requestJson['md5Data']);
        // echo $allEncrypt.'||'.$encryptData;exit();
         //echo md5('com.mncu.android');die();

        $data['babyAdmissionWeight']                = trim($requestJson[APP_NAME]['babyAdmissionWeight']);  
        $data['isLengthMeasurngTapeAvailable']      = trim($requestJson[APP_NAME]['isLengthMeasurngTapeAvailable']); 
        $data['lengthValue']                        = trim($requestJson[APP_NAME]['lengthValue']);     
        $data['lengthMeasureNotAvlReason']          = trim($requestJson[APP_NAME]['lengthMeasureNotAvlReason']);     
        $data['lengthMeasureNotAvlReasonOther']     = trim($requestJson[APP_NAME]['lengthMeasureNotAvlReasonOther']);     
        $data['isHeadMeasurngTapeAvailable']        = trim($requestJson[APP_NAME]['isHeadMeasurngTapeAvailable']); 
        $data['headCircumferenceVal']               = trim($requestJson[APP_NAME]['headCircumferenceVal']);     
        $data['headMeasureNotAvlReason']          = trim($requestJson[APP_NAME]['headMeasureNotAvlReason']);     
        $data['headMeasureNotAvlReasonOther']     = trim($requestJson[APP_NAME]['headMeasureNotAvlReasonOther']);   
        $data['babyId']              = trim($requestJson[APP_NAME]['babyId']); 
        $data['nurseId']             = trim($requestJson[APP_NAME]['nurseId']);
        $data['loungeId']            = trim($requestJson[APP_NAME]['loungeId']);  
        $data['latitude']            = trim($requestJson[APP_NAME]['latitude']);
        $data['longitude']           = trim($requestJson[APP_NAME]['longitude']);  
        $data['weightDate']          = trim($requestJson[APP_NAME]['weightDate']);  
        $data['localId']             = trim($requestJson[APP_NAME]['localId']);
        $data['localDateTime']       = trim($requestJson[APP_NAME]['localDateTime']);
        
        
        $checkRequestKeys = array(             
                                    '0' => 'babyAdmissionWeight',
                                    '1' => 'isLengthMeasurngTapeAvailable',
                                    '2' => 'lengthValue',
                                    '3' => 'isHeadMeasurngTapeAvailable',
                                    '4' => 'headCircumferenceVal',
                                    '5' => 'babyId',
                                    '6' => 'nurseId', 
                                    '7' => 'loungeId',
                                    '8' => 'localId',
                                    '9' => 'weightDate', 
                                    '10' => 'latitude',
                                    '11' => 'longitude',
                                    '12' => 'localDateTime',
                                    '13' => 'lengthMeasureNotAvlReason',
                                    '14' => 'lengthMeasureNotAvlReasonOther',
                                    '15' => 'headMeasureNotAvlReason',
                                    '16' => 'headMeasureNotAvlReasonOther'
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
                       
                        $result = $this->BabyModel->BaselineMeasurements($data);

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
        }
        else{ 
                generateServerResponse('0','212');        
        } 
    }
}