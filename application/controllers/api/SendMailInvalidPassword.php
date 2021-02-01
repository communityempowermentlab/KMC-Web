<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SendMailInvalidPassword extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->model('api/ApiModel');
    }

    public function index()
    {
        $requestData = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson = json_decode($requestData, true);

        $allEncrypt               = createMd5OfString($requestJson[APP_NAME]); 
        $encryptData              = trim($requestJson['md5Data']);
        // echo $allEncrypt ;die;
        $data['loungeId'] = $requestJson[APP_NAME]['loungeId'];

        $checkRequestKeys = array(
            'loungeId'
        );

        $resultJson = validateJson($requestJson, $checkRequestKeys);

        //New lines for MD5
        $validateRequestKeysMain = array(                                              
                                    '0' =>  APP_NAME,
                                    '1' => 'md5Data'
                                    );

        $resultJsonMain = validateJsonMd5($requestJson, $validateRequestKeysMain); 

        $headers = apache_request_headers();
        if($allEncrypt == $encryptData)
        { 
          if (!empty($headers['package']))
          {
              if ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE)))
              {
                  if ($resultJson == 1)
                  {
                      $post = array() ;
                      $response = array();
                      $result = $this->ApiModel->SendMailInvalidPassword($data);
                      if($result != 0){
                          generateServerResponse('1','S');
                      }else{ 
                          generateServerResponse('0','W');
                      }
                  }
                  else
                  {

                      generateServerResponse('0', '101');
                  }
              }
              else
              {
                  generateServerResponse('0', '210');
              }
          }
          else
          {
              generateServerResponse('0', 'W');
          }
        } else{ 
            generateServerResponse('0','212');        
        } 
    }
}

