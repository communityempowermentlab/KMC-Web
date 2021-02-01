<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PostCommentOnTimeline extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/CommentModel');
    }
    public function index()
    {

        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
  
  
        $data['loungeId']            = trim($requestJson[APP_NAME]['loungeId']);    
        $data['timelineId']          = trim($requestJson[APP_NAME]['timelineId']);    
        $data['comment']              = trim($requestJson[APP_NAME]['comment']);    
        $data['userType']             = trim($requestJson[APP_NAME]['userType']);    
 

        $checkRequestKeys = array(                                        
                                    '0' => 'loungeId',
                                    '1' => 'timelineId',
                                    '2' => 'comment',
                                    '3' => 'userType'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys); 
// for header security 
        $headers    = apache_request_headers();
        if($data['userType'] == '0'){ // for lounge
           $loungeData = tokenVerification($data['userType'],$data['loungeId']);
        }else if($data['userType'] == '1'){ // for staff
           $loungeData = tokenVerification($data['userType'],$data['loungeId']);
        }else{
            generateServerResponse('0','218');  
        }
        $getLoungeData = $loungeData->row_array(); 
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {                     
                    if ($resultJson == 1) {
                        $res = $this->CommentModel->postCommentTimeline($data);
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