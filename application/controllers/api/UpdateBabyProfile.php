<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class UpdateBabyProfile extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/BabyModel');
        $this->load->model('api/MotherBabyAdmissionModel');
        $this->load->model('api/BabyAdmissionPDF');
    }
    public function index()
    {
    	$requestData       	= isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        	= json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt         = md5(json_encode($requestJson[APP_NAME]));
        $encryptData        = trim($requestJson['md5Data']);
       
        $data['babyId']            = trim($requestJson[APP_NAME]['babyId']);
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
        $data['babyFileId']          = trim($requestJson[APP_NAME]['babyFileId']);


        $checkRequestKeys = array(                                   
                                    '0' => 'babyId',
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
                                    '12' => 'firstTimeFeed',
                                    '13' => 'loungeId',
                                    '14' => 'typeOfBorn',
                                    '15' => 'typeOfOutBorn',
                                    '16' => 'wasApgarScoreRecorded',
                                    '17' => 'apgarScoreVal',
                                    '18' => 'vitaminKGiven',
                                    '19' => 'babyFileId'
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
        //echo $allEncrypt.'<br>'.$encryptData;exit();
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
            				//echo "aa"; exit;
            			$babyFileId =  $this->BabyModel->CheckUniqueBabyFileId($data['babyFileId'],$data['babyId'],$data['loungeId']);
                        if($babyFileId == 0){
            			    $baby_reg = $this->BabyModel->updateBabyProfile($data);
            				if($baby_reg != 0){
            					generateServerResponse('1','152');
            				}else{
            					generateServerResponse('0','W');
            				}
            			}else{
            				generateServerResponse('0','137');
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

