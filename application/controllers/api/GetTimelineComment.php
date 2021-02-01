<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GetTimeLineComment extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/CommentModel');
    }
    public function index()
    {

        $requestData       = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
  
    
        $data['timelineId']            = trim($requestJson[APP_NAME]['timelineId']);    
        $data['offset']                 = trim($requestJson[APP_NAME]['offset']);    


        $checkRequestKeys = array(                                        
                                    '0' => 'timelineId',
                                    '1' => 'offset'
                                    );
        $resultJson = validateJson($requestJson, $checkRequestKeys); 
// for header security 
        $headers    = apache_request_headers();
          if(!empty($headers['package']))
          {
            if(($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
            {                         
                if ($resultJson == 1) {
                    $res = $this->CommentModel->getAllTimelineComment($data);
                } else {
                    generateServerResponse('0', '101');
                }
              }else{
               generateServerResponse('0','210');
            }  
        }else{
            generateServerResponse('0','W');
          }  
                   
    }
}