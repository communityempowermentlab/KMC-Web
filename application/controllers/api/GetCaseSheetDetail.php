<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class getCaseSheetDetail extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/BabyModel');
    }
    public function index()
    {

    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
		
		//echo md5('com.mncu.android');die();
        $data['babyId'] 		= trim($requestJson[APP_NAME]['babyId']);
        $data['loungeId'] 		= trim($requestJson[APP_NAME]['loungeId']);
        $data['coachId'] 		= trim($requestJson[APP_NAME]['coachId']);
        $data['date'] 			= trim($requestJson[APP_NAME]['date']);
        $checkRequestKeys = array(                
                                    '0' => 'babyId',
                                    '1' => 'loungeId', 
                                    '2' => 'coachId',
                                    '3' => 'date'
                                   );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
		
		// for header security 
        $headers    = apache_request_headers();
       	$coachData = $this->db->get_where('coachMaster', array('id'=>$data['coachId'],'status'=>'1'));

        $getCoachData = $coachData->row_array();
            if($coachData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getCoachData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
						if ($resultJson == 1) {
							
							$getBabyDetail  = $this->BabyModel->getCaseSheetDetail($data);
							
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