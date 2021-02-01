<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: application/json");
class CoachLogin extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
      
    }
    public function index()
    {
        $requestData           = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson           = json_decode($requestData, true);
       
        $data['mobileNumber']      = trim($requestJson[APP_NAME]['mobileNumber']);  
        $data['password']       = trim($requestJson[APP_NAME]['password']);
        $data['deviceId']       = trim($requestJson[APP_NAME]['deviceId']); 
        $data['imeiNumber']     = trim($requestJson[APP_NAME]['imeiNumber']); 
        $data['latitude']       = trim($requestJson[APP_NAME]['latitude']); 
        $data['longitude']      = trim($requestJson[APP_NAME]['longitude']); 
        $data['fcmId']          = trim($requestJson[APP_NAME]['fcmId']); 

        $checkRequestKeys = array(                                        
                                    '0' => 'mobileNumber',
                                    '1' => 'password',
                                    '2' => 'deviceId',
                                    '3' => 'imeiNumber',
                                    '4' => 'latitude',
                                    '5' => 'longitude',
                                    '6' => 'fcmId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
        // for header code 
        $headers    = apache_request_headers();
       // check for header 
        $coachData = $this->db->get_where('coachMaster', array('mobile'=>$data['mobileNumber'],'status'=>'1'));

        /*$loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$data['loungeId'],'imeiNumber'=>$data['imeiNumber'],'status'=>'1'));*/
       
        if($coachData->num_rows() != 0 )
        {
            $getCoachData = $coachData->row_array();
              if(!empty($headers['token']) && !empty($headers['package'])){
                if($headers['token'] == $getCoachData['token'] && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))){
                            if ($resultJson == 1) { 
                                $loungeDetail = $this->ApiModel->coachLogin($data);
                                    if($loungeDetail != 0){
                                         $response['loungeDetails'] = $loungeDetail;
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