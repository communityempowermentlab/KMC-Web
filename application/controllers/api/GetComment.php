<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GetComment extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/CommentModel');
    }
    public function index()
    {

        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
  
  
        $data['type']                   = trim($requestJson[APP_NAME]['type']);    
        $data['id']                     = trim($requestJson[APP_NAME]['id']);    
        $data['loungeId']               = trim($requestJson[APP_NAME]['loungeId']);    
        $data['coachId']                = trim($requestJson[APP_NAME]['coachId']);    

        $checkRequestKeys = array(                                        
                                    '0' => 'type',
                                    '1' => 'id',
                                    '2' => 'loungeId',
                                    '3' => 'coachId'
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
                        $res = $this->CommentModel->getAllCommentViaLounge($data);
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