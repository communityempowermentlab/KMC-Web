<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CheckIMEI extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
    }

    public function index()
    {
        $requestData        = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);


        $data['imeiNumber'] = trim($requestJson[APP_NAME]['imeiNumber']);   

        $checkRequestKeys   = array('imeiNumber');

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        // for headers security   
        $headers    = apache_request_headers();
        if(!empty($headers['package']))
        {
          if(($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
          {
              if ($resultJson == 1) {
                   $this->ApiModel->checkImei($data);
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
}