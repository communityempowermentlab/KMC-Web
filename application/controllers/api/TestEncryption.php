<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
class TestEncryption extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherBabyAdmissionModel');
        $this->load->library('Enryption');
    }
    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true); 
        //New lines for MD5
        // $allEncrypt               = createMd5OfString($requestJson[APP_NAME]);
        // $encryptData              = trim($requestJson['md5Data']);
       //echo $allEncrypt.'||'.$encryptData;exit;
    
         //echo json_encode($requestJson[APP_NAME]) ;exit;
      	#=============== Baby Admission======================#
        // echo base64_decode('d0cbc0323624b3db4f6280968fcc6f94fc6732281a7a252d6b6cd82f4de3df96');die;
       
        // $data['loungeId']            = trim($requestJson[APP_NAME]['loungeId']);    
        $data['text']               = trim($requestJson[APP_NAME]['text']);    
        
        $checkRequestKeys = array(                        
                                    '0' => 'text'
                                     );

        $resultJson = validateJson($requestJson, $checkRequestKeys);
      //New lines for MD5
        // $checkRequestKeys2 = array(                                           
        //                             '0' => APP_NAME,
        //                             '1' => 'md5Data'
        //                             );
        // $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);
//for headers security
        // $headers    = apache_request_headers();
        // $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$requestJson[APP_NAME]['loungeId'],'status'=>'1'));
        // $getLoungeData = $loungeData->row_array(); 
        // if($allEncrypt == strtolower($encryptData) || $allEncrypt == strtoupper($encryptData))
        // {  
            // if($loungeData->num_rows() != 0)
            // {
            //   if(!empty($headers['token']) && !empty($headers['package']))
            //   {
            //     if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
            //     {
            		if ($resultJson == 1) { 
                        $mcrypt = new Enryption();
                            
                        $array = array();

                        // $encrypted = $mcrypt->encrypt($data['text']);
                        // $array['encrypted'] = $encrypted;
                        
                        #Decrypt
                        $decrypted = $mcrypt->decrypt($data['text']);
                        // $array['decrypted'] = $decrypted;


                        $string = preg_replace('/[\x00-\x1F\x7F]/u', '', $decrypted);
                        // $string = utf8_decode(trim($string));
                        $array['decrypted'] = $string;
                        $array['encrypted'] = $data['text'];
                        
                        generateServerResponse('1','S',$array);
                         
                    }else{
            		    
            		    generateServerResponse('0','101');				
            		}
            //     }else{
            //        generateServerResponse('0','210');
            //     }  
            //   }else{
            //     generateServerResponse('0','W');
            //   }  
            // }else{
            //     generateServerResponse('0','211');        
            //   } 
         // }else{
         //        generateServerResponse('0','212');        
         //    }   
	     
    }
}