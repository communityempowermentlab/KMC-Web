<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: application/json");
class StaffLogin extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
      
    }
    public function index()
    {
    	$requestData           = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson            = json_decode($requestData, true);
       
        $data['mobileNumber']   = trim($requestJson[APP_NAME]['mobileNumber']);  
        $data['password']       = trim($requestJson[APP_NAME]['password']);
        $data['deviceId']      = trim($requestJson[APP_NAME]['deviceId']); 
        $data['fcmId']          = trim($requestJson[APP_NAME]['fcmId']); 

        $checkRequestKeys = array(                                        
                                    '0' => 'mobileNumber',
                                    '1' => 'password',
                                    '2' => 'deviceId',
                                    '3' => 'fcmId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        // for header code 
        $headers    = apache_request_headers();
       // check for header 

        $query = $this->db->get_where('staffMaster', array('staffMobileNumber'=>$data['mobileNumber'],'status'=>'1'));
        $checkMobile = $query->num_rows();
        $getData     = $query->row_array();

        $getLoungeID  = $this->db->get_where('loungeMaster', array('facilityId'=>$getData['facilityId']))->row_array();
        
        if($checkMobile == 0){
          generateServerResponse('0','217');
        }

       $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$getLoungeID['loungeId'],'status'=>'1'));
       
        if($loungeData->num_rows() != 0 )
        {
            $getLoungeData = $loungeData->row_array();
              if(!empty($headers['package'])){
                if(($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))){
                            if ($resultJson == 1) { 
                                $LoungeDetail = $this->ApiModel->staffLogin($data);
                                    if($LoungeDetail != 0){
                                         $response['loginDetails'] = $LoungeDetail;
                                         generateServerResponse('1','S', $response);
                                    }else{
                                        generateServerResponse('0','P');
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
        }
        else{
           generateServerResponse('0','215');
        }   
	     
    }
}