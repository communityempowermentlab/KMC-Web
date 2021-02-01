<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SearchBabyViaFacilityId extends CI_Controller {
  public function __construct()
    {
      parent::__construct();         
      $this->load->model('api/BabyModel');
    }
    public function index()
    {
        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);

        $data['loungeId']             = trim($requestJson[APP_NAME]['loungeId']); 
        $data['searchingFacilityId']  = trim($requestJson[APP_NAME]['searchingFacilityId']); 
        $data['deliveryDate']         = trim($requestJson[APP_NAME]['deliveryDate']);  
        $data['motherName']           = trim($requestJson[APP_NAME]['motherName']);  
        $data['hospitalRegistrationNumber']          = trim($requestJson[APP_NAME]['hospitalRegistrationNumber']);  
        $data['offset']               = trim($requestJson[APP_NAME]['offset']);  

        $checkRequestKeys = array(                                        
                                    '0' => 'loungeId',
                                    '1' => 'searchingFacilityId',
                                    '2' => 'deliveryDate',
                                    '3' => 'motherName',
                                    '4' => 'hospitalRegistrationNumber',
                                    '5' => 'offset'
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
                      $res = $this->BabyModel->findBabyWhereFacilityId($data);
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