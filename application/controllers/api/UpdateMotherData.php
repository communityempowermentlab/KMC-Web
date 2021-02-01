<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UpdateMotherData extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherModel');
      
    }
    public function index()
    {
        $requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        $param = array();
        $data['monitoringData']             =  $requestJson[APP_NAME]['monitoringData'];
        $data['loungeId']                   = trim($requestJson[APP_NAME]['loungeId']);   
         //echo md5('com.mncu.android');die();
        // $request['motherData']      = $data;
        $checkRequestKeys = array(                                        
                                    '0' => 'monitoringData',
                                    '1' => 'loungeId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);

 // for headers security   
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$data['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array(); 
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
            		if ($resultJson == 1) {
            			$post = array();
            			$response = array();
            			$MotherMonitering = $this->MotherModel->updateMotherData($data);
            				if($MotherMonitering != 0){
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
	     
    }
}