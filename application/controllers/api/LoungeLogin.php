<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: application/json");
class LoungeLogin extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
      
    }
    public function index()
    {
        $requestData           = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson           = json_decode($requestData, true);
       
        $data['loungeId']      = trim($requestJson[APP_NAME]['loungeId']);  
        $data['loungePassword']= trim($requestJson[APP_NAME]['loungePassword']);
        $data['deviceId']      = trim($requestJson[APP_NAME]['deviceId']); 
        $data['imeiNumber']    = trim($requestJson[APP_NAME]['imeiNumber']); 
        $data['latitude']      = trim($requestJson[APP_NAME]['latitude']); 
        $data['longitude']     = trim($requestJson[APP_NAME]['longitude']); 
        $data['fcmId']         = trim($requestJson[APP_NAME]['fcmId']); 

        $checkRequestKeys = array(                                        
                                    '0' => 'loungeId',
                                    '1' => 'loungePassword',
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
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$data['loungeId'],'status'=>'1'));

        /*$loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$data['loungeId'],'imeiNumber'=>$data['imeiNumber'],'status'=>'1'));*/
       
        if($loungeData->num_rows() != 0 )
        {
            $getLoungeData = $loungeData->row_array();
              if(!empty($headers['token']) && !empty($headers['package'])){
                if($headers['token'] == $getLoungeData['token'] && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))){
                            if ($resultJson == 1) { 

                                // validate staff available
                                $getStaffAvailable = $this->db->get_where('staffMaster', array('facilityId' => $getLoungeData['facilityId'],'status' => '1'))->row_array();
                                if(empty($getStaffAvailable)){
                                    generateServerResponse('0', '232');
                                }

                                // validate lounge amenities
                                $getAmenitiesAvailable = $this->db->get_where('loungeAmenities', array('loungeId' => $getLoungeData['loungeId']))->row_array();
                                if(empty($getAmenitiesAvailable)){
                                    generateServerResponse('0', '233');
                                }

                                $loungeDetail = $this->ApiModel->loungeLogin($data);
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