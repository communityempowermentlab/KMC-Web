<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LoungeDashboard extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/NurseModel');
        $this->load->model('DashboardDataModel');
        $this->load->model('FacilityModel');
      
    }
    public function index()
    {
        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);

        $data['loungeId']    = trim($requestJson[APP_NAME]['loungeId']);    
        $data['nurseId']     = trim($requestJson[APP_NAME]['nurseId']);    

        $checkRequestKeys = array(                                        
                                    '0' => 'loungeId',
                                    '1' => 'nurseId'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys);

// for header security 
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$requestJson[APP_NAME]['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array(); 
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                { 
                    if ($resultJson == 1) {
                           $res = $this->NurseModel->GetRankViaLoungeId($data);
                    } else {
                        generateServerResponse('0', '101');
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