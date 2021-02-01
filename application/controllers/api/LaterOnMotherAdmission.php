<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LaterOnmotherAdmission extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/CommonModel');
      
    }
    public function index()
    {
        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
   
        $data['motherId']           = trim($requestJson[APP_NAME]['motherId']);    
        $data['babyId']             = trim($requestJson[APP_NAME]['babyId']);    
        $data['loungeId']  = trim($requestJson[APP_NAME]['loungeId']); 

        $checkRequestKeys = array(                                        
                                    '0' => 'motherId',
                                    '1' => 'babyId',
                                    '2' => 'loungeId'
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
                           $res = $this->CommonModel->motherAdmission($data);
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