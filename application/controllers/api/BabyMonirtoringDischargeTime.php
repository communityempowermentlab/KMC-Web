<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class BabyMonirtoringDischargeTime extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/MotherBabyAdmissionModel');
        $this->load->model('api/BabyModel');
      
    }
    public function index()
    {
    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
        //New lines for MD5
        $allEncrypt         = md5(json_encode($requestJson[APP_NAME]));
        $encryptData        = trim($requestJson['md5Data']);
        //echo $allEncrypt.'||'.$encryptData;exit();

      	#====================== Baby Monitoring ======================#

      /*  $data['motherId']            = trim($requestJson[APP_NAME]['motherId']);*/
        $data['loungeId']            = trim($requestJson[APP_NAME]['loungeId']);    
        $data['babyId']              = trim($requestJson[APP_NAME]['babyId']);
        $data['babyAdmissionWeight'] = trim($requestJson[APP_NAME]['babyWeight']);
 


        $data['BabyRespiratoryRate'] 	= trim($requestJson[APP_NAME]['baby_respiratory_rate']);
        $data['BabyOtherDangerSign'] 	= json_encode($requestJson[APP_NAME]['other_danger_symtoms'],JSON_UNESCAPED_UNICODE);
        $data['BabyPulseSpO2']  	 	= trim($requestJson[APP_NAME]['baby_spo2']);
        $data['BabyPulseRate'] 	 	 	= trim($requestJson[APP_NAME]['baby_motherPulse']);
        $data['BabyTemperature']  	 	= trim($requestJson[APP_NAME]['baby_temp']);
        $data['MotherBreastcondition']	= trim($requestJson[APP_NAME]['mother_breast_condition']);
        $data['MotherBreastPain'] 		= trim($requestJson[APP_NAME]['mother_breast_pain']);
        $data['MotherBreastStatus']		= trim($requestJson[APP_NAME]['mother_breast_status']);
        $data['BabyMilkConsumption1'] 	= trim($requestJson[APP_NAME]['baby_milk_consumption1']);
        $data['BabyMilkConsumption2'] 	= trim($requestJson[APP_NAME]['baby_milk_consumption2']);
        $data['BabyMilkConsumption3'] 	= trim($requestJson[APP_NAME]['baby_milk_consumption3']);
        $data['Other'] 					= trim($requestJson[APP_NAME]['other']);
        $data['staffId']                = trim($requestJson[APP_NAME]['staffId']);

        $data['type']                   = trim($requestJson[APP_NAME]['type']);
        $data['BabyHeadCircumference']  = trim($requestJson[APP_NAME]['head_circumference']);
        $data['SkinColor']  		    = trim($requestJson[APP_NAME]['skincolor']);
        
        
        $data['UrinationAfterLastAssesment'] = trim($requestJson[APP_NAME]['urination_after_last_assessment']);
        $data['StoolAfterLastAssesment']     = trim($requestJson[APP_NAME]['stool_after_last_assessment']);
        
        
        
        $data['NumberOfPusrulesOrBoils']   = trim($requestJson[APP_NAME]['number_pustules']);
        $data['LocationOfPusrulesOrBoils'] = trim($requestJson[APP_NAME]['location_pustules']);

        $data['SizeOfPusrulesOrBoils']= trim($requestJson[APP_NAME]['size_pustules']);
        $data['BabyHavePustulesOrBoils']= trim($requestJson[APP_NAME]['baby_have_pustule_or_boil']);
 	    $data['IsPulseOximatoryDeviceAvailable'] = trim($requestJson[APP_NAME]['oximatory_device']);
         // for monitoring
        $data['IsThermometerAvail']   = trim($requestJson[APP_NAME]['thermometer_avail']);
        $data['thermometer_reason']   = trim($requestJson[APP_NAME]['thermometer_reason']);
        $data['thermometerImage']     = trim($requestJson[APP_NAME]['thermometer_image']);
        // for weight 
        $data['isDeviceAvailAndWorking']   = trim($requestJson[APP_NAME]['isDeviceAvailAndWorking']);
        $data['weight_reason']             = trim($requestJson[APP_NAME]['weight_reason']);
        $data['weight_image']              = trim($requestJson[APP_NAME]['weight_image']);

        $data['IsHeadCircumferenceAvail']  = trim($requestJson[APP_NAME]['isHeadCircumferenceAvail']);
        $data['headCircumferencereason']   = trim($requestJson[APP_NAME]['headCircumferencereason']);
        $data['temperatureUnit']           = trim($requestJson[APP_NAME]['temperatureUnit']);


        $checkRequestKeys = array(                        
                                    '0' => 'staffId',
                                    '1' => 'loungeId',
                                    '2' => 'babyId',
                                    '3' => 'babyWeight',
                                    '4' => 'baby_respiratory_rate',
                                    '5' => 'other_danger_symtoms',
                                    '6' => 'baby_spo2',
                                    '7' => 'baby_motherPulse',
                                    '8' => 'baby_temp',
                                    '9' => 'mother_breast_condition',
                                    '10' => 'mother_breast_status',
                                    '11' => 'baby_milk_consumption1',
                                    '12' => 'baby_milk_consumption2',
                                    '13' => 'baby_milk_consumption3',
                                    '14' => 'mother_breast_pain',
                                    '15' => 'other',
                                    '16' => 'type',
                                    '17' => 'head_circumference',
                                    '18' => 'skincolor',
                                    '19' => 'urination_after_last_assessment',
                                    '20' => 'stool_after_last_assessment',
                                    '21' => 'size_pustules',
                                    '22' => 'location_pustules',
                                    '23' => 'number_pustules',
                                    '24' => 'baby_have_pustule_or_boil',
                                    '25' => 'oximatory_device',
                                    '26' => 'thermometer_avail', 
                                    '27' => 'thermometer_reason', 
                                    '28' => 'thermometer_image', 
                                    '29' => 'isDeviceAvailAndWorking', 
                                    '30' => 'weight_reason', 
                                    '31' => 'weight_image',
                                    '32' => 'isHeadCircumferenceAvail', 
                                    '33' => 'headCircumferencereason', 
                                    '34' => 'temperatureUnit'                             
                                  );
                                  
        $resultJson = validateJson($requestJson, $checkRequestKeys);

      //New lines for MD5
        $checkRequestKeys2 = array(                                                                      
                                    '0' => APP_NAME,
                                    '1' => 'md5Data'
                                    );
        $resultJson2 = validateJsonMd5($requestJson, $checkRequestKeys2);

//for headers security
        $headers    = apache_request_headers();
        $loungeData = $this->db->get_where('loungeMaster', array('loungeId'=>$data['loungeId'],'status'=>'1'));
        $getLoungeData = $loungeData->row_array();
        if($allEncrypt == $encryptData)
        {           
            if($loungeData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getLoungeData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
                		if ($resultJson == 1) {			
                			$response = array();
                			$baby_reg = $this->MotherBabyAdmissionModel->babyMonitoringDischargeTime($data);
                			
                			//print_r($baby_reg); exit;
                				if($baby_reg != 0){
                				            $DischargeStatus = '0';

                                            $babyWeightForDiscgarge = $this->BabyModel->getBabyWeight($data['babyId'],'Desc',$data['loungeId'],'3');
                				
                			//print_r($babyWeightForDiscgarge);	
                                            $BabyFeedDetail = $this->BabyModel->BabyFeedDeatil($data['babyId'],$data['loungeId']);
                                            
                                             //print_r($BabyFeedDetail); exit;
                                                if(count($BabyFeedDetail)>0)
                	                           {
                	
                	                                foreach ($BabyFeedDetail as $key => $value) {
                	                                    if($value['feedingType']=='3')
                	                                    {
                	                                        $DischargeStatus = '1' ;
                	                                        $baby_reg['breastfeed'] = 'fail';
                	                                        break;
                	                                    }
                	                                }
                	                            }else{
                	                                $baby_reg['breastfeed'] = 'fail';
                	                            }

                                            // condition to check Baby stay three days in lounge 
                                            if(count($babyWeightForDiscgarge)>=3)
                                            {
                                            
                                                    $WeightDiffer =  $babyWeightForDiscgarge['1']['babyWeight'] - $babyWeightForDiscgarge['2']['babyWeight'];

                	                                if($WeightDiffer > '15'){
                	                                     $WeightDiffer2 =  $babyWeightForDiscgarge['0']['babyWeight'] - $babyWeightForDiscgarge['1']['babyWeight'];
                	
                	                                    if($WeightDiffer2 > '15'){
                	                                                $DischargeStatus = '0' ;
                	                                                $baby_reg['weight'] = 'pass';
                	                                        }else{
                	                                            $DischargeStatus = '1' ;
                	                                            $baby_reg['weight'] = 'fail';
                	                                        }
                	                                    }else{
                	                                        $DischargeStatus = '1' ;
                	                                        $baby_reg['weight'] = 'fail';
                	                                    }

                                                $baby_reg['discharge_status'] = $DischargeStatus;
                                                // Get last 3 Monitoring Data for Discharge     
                                                $GetLastThreeMonitoring = $this->BabyModel->getBabyMonitoringData($data['babyId'],$data['loungeId'],'Desc','3');

                                                //print_r($GetLastThreeMonitoring);exit;
                                                if($DischargeStatus!='1')
                                                {
                                                    # condition for Respiratory Rate 
                                                    foreach ($GetLastThreeMonitoring as $key => $value){

                                                        if(($value['BabyRespiratoryRate']<30)||($value['BabyRespiratoryRate']>60 )){
                                                            $DischargeStatus ='0';
                                                            $baby_reg['discharge_status'] = $DischargeStatus;
                                                            $baby_reg['respiratory'] = 'pass';
                                                            break;
                                                        }else{
                                                            $baby_reg['respiratory'] = 'fail';
                                                        }
                                                    }

                                                    # condition for Temperature 
                                                    foreach ($GetLastThreeMonitoring as $key => $value){

                                                        if(($value['BabyTemperature']<95.9)||($value['BabyRespiratoryRate']>99.5 )){

                                                            $DischargeStatus ='0';
                                                            $baby_reg['discharge_status'] = $DischargeStatus;
                                                            $baby_reg['temperature'] = 'pass';
                                                            break;
                                                        }else{
                                                            $baby_reg['temperature'] = 'fail';
                                                        }   
                                                    }
                                                    # condition for Other Danger Sysmtoms
                                                    foreach ($GetLastThreeMonitoring as $key => $value){

                                                     if($value['BabyOtherDangerSign']==array()){
                                                            $DischargeStatus ='0';
                                                            $baby_reg['discharge_status'] = $DischargeStatus;
                                                            $baby_reg['danger_symtoms'] = 'pass';
                                                            break;
                                                        }else{
                                                            $baby_reg['danger_symtoms'] = 'fail';
                                                        }
                                                    }
                                                }else{
                                                
                                                	$baby_reg['temperature'] 	= 'fail';
                                                	$baby_reg['danger_symtoms'] 	= 'fail';
                                                	$baby_reg['respiratory'] 	= 'fail';
                                                }
                                                
                                            }else{
                                                $baby_reg['discharge_status']   = '1';
                                                $baby_reg['weight'] 		= 'fail';
                                                $baby_reg['temperature'] 	= 'fail';
                                                $baby_reg['danger_symtoms'] 	= 'fail';
                                                $baby_reg['respiratory'] 	= 'fail';
                                                $baby_reg['breastfeed'] 	= 'fail';
                                            }
                					generateServerResponse('1','S',$baby_reg);
                				}else{
                					generateServerResponse('0','W');
                				}
                		} else{
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