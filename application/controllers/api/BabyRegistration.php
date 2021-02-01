<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:application/json;charset=utf-8');
class BabyRegistration extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/BabyModel');
        $this->load->model('api/MotherBabyAdmissionModel'); 
      
    }

    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
       
        $data['motherId']       = trim($requestJson[APP_NAME]['motherId']);
        $data['babyFileId']     = trim($requestJson[APP_NAME]['babyFileId']);
        $data['babyMCTSNumber'] = trim($requestJson[APP_NAME]['babyMCTSNumber']);
        $data['deliveryDate']   = trim($requestJson[APP_NAME]['deliveryDate']);
        $data['deliveryTime']   = trim($requestJson[APP_NAME]['deliveryTime']);
        $data['babyGender']     = trim($requestJson[APP_NAME]['babyGender']);
        $data['deliveryType']   = trim($requestJson[APP_NAME]['deliveryType']);
        $data['babyWeight']     = trim($requestJson[APP_NAME]['babyWeight']);
        $data['firstTimeFeed']  = trim($requestJson[APP_NAME]['firstTimeFeed']);
        $data['babyCryAfterBirth']  = trim($requestJson[APP_NAME]['babyCryAfterBirth']);

        $data['babyNeedBreathingHelp'] = trim($requestJson[APP_NAME]['babyNeedBreathingHelp']);
        $data['babyPhoto']  = trim($requestJson[APP_NAME]['babyPhoto']);
        
        $data['birthWeightAvail']  = trim($requestJson[APP_NAME]['birthWeightAvail']);
        $data['reason']            = trim($requestJson[APP_NAME]['reason']);
        $data['loungeId']          = trim($requestJson[APP_NAME]['loungeId']);
        $data['typeOfBorn']        = trim($requestJson[APP_NAME]['typeOfBorn']);
        $data['typeOfOutBorn']     = trim($requestJson[APP_NAME]['typeOfOutBorn']);
        $data['vitaminKGiven']     = trim($requestJson[APP_NAME]['vitaminKGiven']);
        $data['wasApgarScoreRecorded']  = trim($requestJson[APP_NAME]['wasApgarScoreRecorded']);
        $data['apgarScoreVal']          = trim($requestJson[APP_NAME]['apgarScoreVal']);


        $data['localId']           = trim($requestJson[APP_NAME]['localId']);
        $data['temporaryFileId']   = trim($requestJson[APP_NAME]['temporaryFileId']);
     
        $checkRequestKeys = array(                                   
                                    
                                    '0' => 'motherId',
                                    '1' => 'babyMCTSNumber',
                                    '2' => 'deliveryDate',
                                    '3' => 'deliveryTime',
                                    '4' => 'babyGender',
                                    '5' => 'deliveryType',
                                    '6' => 'babyNeedBreathingHelp',
                                    '7' => 'babyWeight',
                                    '8' => 'babyCryAfterBirth',
                                    '9' => 'babyPhoto',
                                    '10' => 'birthWeightAvail',
                                    '11' => 'reason',
                                    '12' => 'babyFileId',
                                    '13' => 'firstTimeFeed',
                                    '14' => 'loungeId',
                                    '15' => 'typeOfBorn',
                                    '16' => 'typeOfOutBorn',
                                    '17' => 'wasApgarScoreRecorded',
                                    '18' => 'apgarScoreVal',
                                    '19' => 'vitaminKGiven',
                                    '20' => 'localId',
                                    '21' => 'temporaryFileId'
                                    );

        $resultJson = validateJsonMd5($requestJson[APP_NAME], $checkRequestKeys);

        //New lines for MD5
        $checkRequestKeys2 = array(                                   
                                    
                                    '0' => APP_NAME,
                                    '1' => 'md5Data'
                                    );

        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);
 
        //New lines for MD5
        $allEncrypt               = createMd5OfString($requestJson[APP_NAME]);
        $encryptData              = trim($requestJson['md5Data']);
        //echo $allEncrypt.'||'.$encryptData;exit;

    
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
						   $badyData = $this->BabyModel->babyRegistration($data);
							if($badyData != 0){
								$response['babyIds'] = $badyData;
								generateServerResponse('1','129',$response);

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