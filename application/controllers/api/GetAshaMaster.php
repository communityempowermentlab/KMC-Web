<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetAshaMaster extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/ApiModel');
      
    }
    public function index()
    {
        $headers    = apache_request_headers();
              if(!empty($headers['package']))
              {
                if(($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {    
                    $arrayName = array();
                    $response = array();
                    $synctime  = '';                 
                    $getAsha = $this->ApiModel->GetAshaViaTimestamp();
                         if(count($getAsha) > 0)
                         {
                            foreach ($getAsha as $key => $value) {
                              $arrayName['ashaId']          = $value['ashaId'];
                              $arrayName['ashaName']        = $value['ashaName'];
                              $arrayName['blockName']       = $value['ashaBlockName'];
                              $arrayName['mobileNumber']    = $value['ashaMobileNumber1'];
                              $response['ashaList'][]       = $arrayName;
                            }   
                       $response['md5Data'] = md5(json_encode($response['ashaList']));    
                      generateServerResponse('1','S',$response, $synctime);
                    }else{
                      generateServerResponse('0','E');
                    }
                }else{
                   generateServerResponse('0','210');
                }  
              }else{
                generateServerResponse('0','W');
              }          
    }
    
}
