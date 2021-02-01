<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 header('content-type:application/json;charset=utf-8');
 class UnknownMotherRegistration extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherModel');
      
    }
    public function index()
    {
        $requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);

        //New lines for MD5
        $allEncrypt         = createMd5OfString($requestJson[APP_NAME]);
        $encryptData        = trim($requestJson['md5Data']);
        //echo $allEncrypt.'||'.$encryptData;exit();

        $data['guardianName']               = trim($requestJson[APP_NAME]['guardianName']);
        $data['guardianNumber']             = trim($requestJson[APP_NAME]['guardianNumber']);
        $data['organisationName']           = trim($requestJson[APP_NAME]['organisationName']);
        $data['organisationNumber']         = trim($requestJson[APP_NAME]['organisationNumber']);
        $data['organisationAddress']        = trim($requestJson[APP_NAME]['organisationAddress']);
        $data['type']                       = trim($requestJson[APP_NAME]['type']);
        $data['loungeId']                   = trim($requestJson[APP_NAME]['loungeId']);
        $data['localId']                    = trim($requestJson[APP_NAME]['localId']);

        $checkRequestKeys = array(                                        
                                    '0' => 'type',
                                    '1' => 'organisationName',
                                    '2' => 'organisationNumber',
                                    '3' => 'organisationAddress',
                                    '4' => 'guardianName',
                                    '5' => 'guardianNumber',
                                    '6' => 'loungeId',
                                    '7' => 'localId'
                                );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
    //New lines for MD5
        $checkRequestKeys2 = array(                                   
                                    '0' => APP_NAME,
                                    '1' => 'md5Data'
                                    );

        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);
 // for headers security   
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$requestJson[APP_NAME]['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array(); 
        if($allEncrypt == $encryptData)
        {            
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {   
                    if ($resultJson == 1 && $resultJson2 == 1) {
                        $post = array();
                        $response = array();
                        $result = $this->MotherModel->unknowMotherRegistration($data);
                        if($result != 0){
                            $response['ids'] = $result;
                            generateServerResponse('1','128',$response);
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
         }else{
                generateServerResponse('0','212');        
            }   
         
    }
}