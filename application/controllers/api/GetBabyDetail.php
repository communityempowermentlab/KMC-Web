<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class getBabyDetail extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/BabyModel');
    }
    public function index()
    {

    	$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
        $requestJson        = json_decode($requestData, true);
		
		//echo md5('com.mncu.android');die();
        $data['babyId'] 		= trim($requestJson[APP_NAME]['babyId']);
        $data['loungeId'] 		= trim($requestJson[APP_NAME]['loungeId']);
        $data['coachId'] 		= trim($requestJson[APP_NAME]['coachId']);
        $checkRequestKeys = array(                
                                    '0' => 'babyId',
                                    '1' => 'loungeId', 
                                    '2' => 'coachId' 
                                   );
        $resultJson = validateJson($requestJson, $checkRequestKeys);
		
		// for header security 
        $headers    = apache_request_headers();
       	$coachData = $this->db->get_where('coachMaster', array('id'=>$data['coachId'],'status'=>'1'));

        $getCoachData = $coachData->row_array();
            if($coachData->num_rows() != 0)
            {
              if(!empty($headers['token']) && !empty($headers['package']))
              {
                if(($headers['token'] == $getCoachData['token']) && ($headers['package'] == strtolower(md5(PACKAGE)) || $headers['package'] == strtoupper(md5(PACKAGE))))
                {
						if ($resultJson == 1) {
							$arrayName = array();
							$response  = array();

							$this->db->order_by('id','desc');
							$babyAdmissionData = $this->db->get_where('babyAdmission',array('babyId'=>$data['babyId']))->row_array();

							$getBabyDetail  = $this->BabyModel->getBabyCombinedDetail($data,$babyAdmissionData['id']);
							$babyRegistrationData = $this->db->get_where('babyRegistration',array('babyId'=>$data['babyId']))->row_array();
							$motherId = getSingleRow('motherId','babyId',$data['babyId'],'babyRegistration');

							$getMotherDetail = $this->db->get_where('motherRegistration',array('motherId'=>$motherId))->row_array();

							$now = new DateTime();
				            $begin1 = new DateTime('8:00');
				            
				            $date = date('Y-m-d');
				            if ($now >= $begin1) {
				                $fromTotal = $date.' 08:00:01';
				                $toTotal = date('Y-m-d 08:00:00', strtotime($date.' +1 day'));
				            }  else {
				                $fromTotal = date('Y-m-d 08:00:01', strtotime($date.' -1 day'));
				                $toTotal = $date.' 08:00:00';
				            }



								if(count($getBabyDetail) > 0){
									$arrayName['babyFileId'] 	 	= $babyAdmissionData['babyFileId'];	

									$arrayName['kmcPosition'] 	 	= $babyAdmissionData['kmcPosition'];		
									$arrayName['kmcMonitoring'] 	= $babyAdmissionData['kmcMonitoring'];		
									$arrayName['kmcNutrition'] 	 	= $babyAdmissionData['kmcNutrition'];		
									$arrayName['kmcRespect'] 	 	= $babyAdmissionData['kmcRespect'];		
									$arrayName['kmcHygiene'] 	 	= $babyAdmissionData['kmcHygiene'];		


									

									$arrayName['isMotherAdmitted']  = $getMotherDetail['isMotherAdmitted'];		

									$arrayName['babyId']   	 		= $babyAdmissionData['babyId'];	
									$arrayName['babyPhoto']  	 	= babyDirectoryUrl.$babyRegistrationData['babyPhoto'];

									$arrayName['motherId']		 	= $babyRegistrationData['motherId'];
									$arrayName['babyMCTSNumber']	= $babyRegistrationData['babyMCTSNumber'];
									$arrayName['motherMCTSNumber']	= $getMotherDetail['motherMCTSNumber'];
									$arrayName['motherLmpDate']	 	= $getMotherDetail['motherLmpDate'];
									
									$arrayName['birthWeight'] 		= $babyRegistrationData['babyWeight'];
									$arrayName['wasApgarScoreRecorded'] = $babyRegistrationData['wasApgarScoreRecorded'];
									$arrayName['apgarScoreVal'] 	= $babyRegistrationData['apgarScoreVal'];
									$arrayName['babyAdmissionWeight']  	= $getBabyDetail['babyAdmissionWeight'];
									$arrayName['babyGender']   		= $babyRegistrationData['babyGender'];
									$arrayName['deliveryType'] 		= $babyRegistrationData['deliveryType'];
									$arrayName['deliveryDate']  	= $babyRegistrationData['deliveryDate'];
									$arrayName['deliveryTime']  	= $babyRegistrationData['deliveryTime'];

									$arrayName['infantComingFrom'] 	 	= $babyAdmissionData['infantComingFrom'];

									$arrayName['babyCryAfterBirth'] 	= $babyRegistrationData['babyCryAfterBirth'];
									$arrayName['babyNeedBreathingHelp'] = $babyRegistrationData['babyNeedBreathingHelp'];
									$arrayName['reason']  		        = $babyRegistrationData['reason'];
									$arrayName['firstTimeFeed']  		= $babyRegistrationData['firstTimeFeed'];
									$arrayName['admissionDateTime']  	= $babyAdmissionData['addDate'];

									$arrayName['babyPdfFileName']  = ($getBabyDetail['babyPdfFileName']!='')? pdfDirectoryUrl.$getBabyDetail['babyPdfFileName'] :'';
									$arrayName['babyFeedingPdfName']     = ($getBabyDetail['babyFeedingPdfName']!='')? pdfDirectoryUrl.$getBabyDetail['babyFeedingPdfName'] :'';
									$arrayName['babyKMCPdfName']        = ($getBabyDetail['babyKMCPdfName']!='')? pdfDirectoryUrl.$getBabyDetail['babyKMCPdfName'] :'';
									$arrayName['babyWeightPdfName']     = ($getBabyDetail['babyWeightPdfName']!='')? pdfDirectoryUrl.$getBabyDetail['babyWeightPdfName'] :'';

									$arrayName['ashaId']            = $getMotherDetail['ashaId'];
									$arrayName['ashaName']          = $getMotherDetail['ashaName'];
									$arrayName['ashaNumber']        = $getMotherDetail['ashaNumber'];
									$arrayName['type']              = $getMotherDetail['type'];

									$hold['isWeighingMachineAvailable'] = $getBabyDetail['isWeighingMachineAvailable'];
						            $hold['babyMeasuredWeight'] 	= $getBabyDetail['babyMeasuredWeight'];
						         	$hold['weightMachineNotAvailReason'] 	= $getBabyDetail['weightMachineNotAvailReason'];
						         	$hold['isHeadMeasurngTapeAvailable'] 	= $getBabyDetail['isHeadMeasurngTapeAvailable'];
						         	$hold['headCircumferenceVal'] 	= $getBabyDetail['headCircumferenceVal'];
						         	$hold['measuringTapeNotAvailReason']= $getBabyDetail['measuringTapeNotAvailReason'];
						         	$hold['isThermometerAvailable'] 	= $getBabyDetail['isThermometerAvailable'];
						         	$hold['temperatureValue'] 	    = $getBabyDetail['temperatureValue'];
						         	$hold['temperatureUnit'] 	    = $getBabyDetail['temperatureUnit'];
						         	$hold['thermometerNotAvailableReason']      = $getBabyDetail['thermometerNotAvailableReason'];
						         	$hold['isPulseOximatoryDeviceAvail']   = $getBabyDetail['isPulseOximatoryDeviceAvail'];
						         	$hold['spo2'] 	                      = $getBabyDetail['spo2'];
						         	$hold['pulseRate'] 	                  = $getBabyDetail['pulseRate'];
									//$hold['breatheCount']                 = $getBabyDetail['breatheCount'];
									$hold['bloodSugar']                   = $getBabyDetail['bloodSugar'];
									$hold['oxygenSaturation']             = $getBabyDetail['oxygenSaturation'];
									$hold['isCrtGreaterThree']            = $getBabyDetail['isCrtGreaterThree'];

									$hold['isAnyComplicationAtBirth']     = $getBabyDetail['isAnyComplicationAtBirth'];
									//$paramsArray['isAnyComplicationAtBirth']     = json_encode($request['isAnyComplicationAtBirth'],JSON_UNESCAPED_UNICODE);
									$hold['otherComplications']           = $getBabyDetail['otherComplications'];
									$hold['urinePassedIn24Hrs']         = $getBabyDetail['urinePassedIn24Hrs'];
									$hold['stoolPassedIn24Hrs']         = $getBabyDetail['stoolPassedIn24Hrs'];
									$hold['typeOfStool']                  = $getBabyDetail['typeOfStool'];
									$hold['isBabyTakingBreastFeed']          = $getBabyDetail['isBabyTakingBreastFeed'];
									$hold['generalCondition']             = $getBabyDetail['generalCondition'];
									$hold['tone']                         = $getBabyDetail['tone'];
									$hold['convulsions']                  = $getBabyDetail['convulsions'];
									$hold['sucking']                      = $getBabyDetail['sucking'];
									$hold['apneaOrGasping']               = $getBabyDetail['apneaOrGasping'];
									$hold['grunting']                     = $getBabyDetail['grunting'];
									$hold['chestIndrawing']               = $getBabyDetail['chestIndrawing'];
									$hold['color']                        = $getBabyDetail['color'];
									$hold['isJaundice']                   = $getBabyDetail['isJaundice'];
									$hold['jaundiceVal']                  = $getBabyDetail['jaundiceVal'];
									$hold['isBleeding']                   = $getBabyDetail['isBleeding'];
									$hold['bleedingValue']                  = $getBabyDetail['bleedingValue'];
									$hold['bulgingAnteriorFontanel']      = $getBabyDetail['bulgingAnteriorFontanel'];
									$hold['umbilicus']                    = $getBabyDetail['umbilicus'];
									$hold['skinPustules']                 = $getBabyDetail['skinPustules'];
									$hold['abdominalDistension']          = $getBabyDetail['abdominalDistension'];
									$hold['coldPeriphery']                = $getBabyDetail['coldPeriphery'];
									$hold['weakPulse']                    = $getBabyDetail['weakPulse'];
									$hold['specifyOther']                 = $getBabyDetail['specifyOther'];
									$hold['cvsVal']                       = $getBabyDetail['cvsVal'];
									$hold['respiratoryRate']                  = $getBabyDetail['respiratoryRate'];
									$hold['perAbdomen']                   = $getBabyDetail['perAbdomen'];
									$hold['cnsVal']                       = $getBabyDetail['cnsVal'];
									$hold['otherSignificantFinding']      = $getBabyDetail['otherSignificantFinding'];
									$hold['otherComment']                = $getBabyDetail['otherComment'];
									//$arrayName['addDate']  	= date('d m y', $babyAdmissionData['addDate']);

									$totalKmc = $this
					                ->db
					                ->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(babyDailyKMC.`endTime`,babyDailyKMC.`startTime`))) as kmcTimeLatest from `babyDailyKMC` where babyDailyKMC.`startTime` < babyDailyKMC.`endTime` AND babyDailyKMC.`babyAdmissionId` = ".$babyAdmissionData['id']." AND (`babyDailyKMC`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')")
					                ->row_array();

					                if(!empty($totalKmc['kmcTimeLatest'])){
					                	$hours  = floor($totalKmc['kmcTimeLatest'] / 3600);
				                        if($hours == 0){
						                    $hours = '00';
						                } else if($hours < 10){
						                    $hours = '0'.$hours;
						                }
						                
						                $minutes = floor(($totalKmc['kmcTimeLatest'] / 60) % 60);
						                if($minutes == 0){
						                    $minutes = '00';
						                } else if($minutes < 10){
						                    $minutes = '0'.$minutes;
						                }
						                $totalKmcTime = $hours.':'.$minutes;
			                      	} else{
				                        $totalKmcTime = '0:00';
			                      	}
				                	
						            
						            $arrayName['totalKMC'] 	 			= $totalKmcTime;

						            $get_today_feeding = $this
		                                ->db
		                                ->query("SELECT sum(milkQuantity) as total FROM `babyDailyNutrition` WHERE `babyDailyNutrition`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND (`babyDailyNutrition`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')  ORDER BY `babyDailyNutrition`.id desc")
		                                ->row_array();


		                            $get_last_feeding = $this
		                                ->db
		                                ->query("SELECT * FROM `babyDailyNutrition` WHERE `babyDailyNutrition`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND (`babyDailyNutrition`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')  ORDER BY `babyDailyNutrition`.id desc")
		                                ->row_array();


		                			$arrayName['todayFeedingQuantity']      	= ($get_today_feeding['total'] != '') ? $get_today_feeding['total'] : '0';
		                			$arrayName['modeOfFeeding']      			= $get_last_feeding['breastFeedMethod'];
		                			$arrayName['fluid']      			= $get_last_feeding['fluid'];

		                			$arrayName['feedingFrequency']  = $this
		                                ->db
		                                ->query("SELECT * FROM `babyDailyNutrition` WHERE `babyDailyNutrition`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND feedingType = 1 AND (`babyDailyNutrition`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')  ORDER BY `babyDailyNutrition`.id desc")
		                                ->num_rows();
		                			
		                			$get_vaccination_data = $this
	                                ->db
	                                ->query("SELECT `babyVaccination`.* FROM `babyVaccination` WHERE `babyVaccination`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND (`babyVaccination`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') ORDER BY `babyVaccination`.id desc")
	                                ->row_array(); 
                					$arrayName['vaccinationName']      = $get_vaccination_data['vaccinationName'];

		                			$get_supplement_data = $this
		                                ->db
		                                ->query("SELECT `babySupplement`.*,`staffMaster`.name as nurseName FROM `babySupplement` inner join staffMaster on `babySupplement`.nurseId = `staffMaster`.staffId WHERE `babySupplement`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND (`babySupplement`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') ORDER BY `babySupplement`.id desc")
		                                ->row_array(); 
                					$arrayName['supplementName']      = $get_supplement_data['supplementName'];

                					$get_weight_data = $this
		                                ->db
		                                ->query("SELECT `babyDailyWeight`.* FROM `babyDailyWeight` WHERE `babyDailyWeight`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND (`babyDailyWeight`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') ORDER BY `babyDailyWeight`.id desc")
		                                ->num_rows(); 
		                            if($get_weight_data != 0){
	                					$arrayName['dailyWeighing']      = 'Yes';
		                            } else {
		                            	$arrayName['dailyWeighing']      = 'No';
		                            }

		                            $this->db->order_by('id','DESC');
            						$currentWeightDataForP = $this->db->get_where('babyDailyWeight', array('babyAdmissionId' => $babyAdmissionData['id']))->row_array();

            						if(!empty($currentWeightDataForP['babyWeight'])) {
            							$currentWeight = $currentWeightDataForP['babyWeight'];
            						} else {
            							$currentWeight = $babyRegistrationData['babyWeight'];
            						}


            						$datediff =  strtotime(date('Y-m-d')) - strtotime($babyRegistrationData['deliveryDate']);

						            $days = round($datediff / (60 * 60 * 24));

						            $prescribedFeeding = $this->BabyModel->getQuantity($currentWeight, $days);

	                				$get_assessment_data = $this
			                                ->db
			                                ->query("SELECT `babyDailyMonitoring`.* FROM `babyDailyMonitoring` WHERE `babyDailyMonitoring`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND (`babyDailyMonitoring`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') ORDER BY `babyDailyMonitoring`.id desc")
			                                ->row_array(); 
			                		$arrayName['significantFinding']      = $get_assessment_data['otherSignificantFinding'];

			                		$assessmentIcon  = $this->BabyModel->getBabyIcon($get_assessment_data);
			                		if(!empty($assessmentIcon)){
			                			$arrayName['assessmentIcon']  = $assessmentIcon ;
			                		} else {
			                			$arrayName['assessmentIcon']  = 0;
			                		}


			                		$get_test_orders = $this
			                                ->db
			                                ->query("SELECT `investigation`.* FROM `investigation` WHERE `investigation`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND ((`investigation`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') OR (`investigation`.`modifyDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')) ORDER BY `investigation`.id desc")
			                                ->num_rows(); 
			                		$arrayName['orderCount']      = $get_test_orders;

			                		$get_test_result = $this
			                                ->db
			                                ->query("SELECT `investigation`.* FROM `investigation` WHERE `investigation`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND ((`investigation`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') OR (`investigation`.`modifyDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')) AND `investigation`.`result` != '' ORDER BY `investigation`.id desc")
			                                ->num_rows(); 
			                		$arrayName['resultCount']      = $get_test_result;

			                		$get_test_sample = $this
			                                ->db
			                                ->query("SELECT `investigation`.* FROM `investigation` WHERE `investigation`.`babyAdmissionId` = ".$babyAdmissionData['id']." AND ((`investigation`.`addDate` BETWEEN '".$fromTotal."' AND '".$toTotal."') OR (`investigation`.`modifyDate` BETWEEN '".$fromTotal."' AND '".$toTotal."')) AND `investigation`.`sampleComment` != '' ORDER BY `investigation`.id desc")
			                                ->num_rows(); 
			                		$arrayName['sampleCount']      = $get_test_sample;
			                		$arrayName['prescribedFeeding']      = $prescribedFeeding;

			                		$this->db->order_by('id','Desc');
									$getCommentData = $this->db->get_where('comments', array('admissionId'=>$babyAdmissionData['id'], 'type'=>'2'))->row_array();

									if(!empty($getCommentData)){
										$detDoctorName = $this->db->get_where('staffMaster', array('staffId'=>$getCommentData['doctorId']))->row_array();
										$getCommentData['doctorName'] = $detDoctorName['name'];

									} 
									$arrayName['commentData'] = $getCommentData;


									$hold = $this
                        			->db
                        			->query("SELECT * From babyDailyMonitoring where  babyAdmissionId = '" . $babyAdmissionData['id'] . "'   order by id desc limit 0, 1")->row_array();

									$hold['staffName']= getSingleRow('name','staffId',$getBabyDetail['staffId'],'staffMaster');

									$arrayName['monitoringDetails'][] = $hold;

									$arrayName['babyWeigthAvailable']  		= $this->getBabyWeight($data,$babyAdmissionData['id']);

				                            //print_r($arrayName['monitoring_detail']);exit;
									### LAST MONIIORING DETAIL END ####


										$arrayName['babyWeight'] = array();
										$days = getDateDifferenceWithCurrent(strtotime($babyRegistrationData['deliveryDate']));
										for($i = 0 ; $i < $days ; $i++){
											$date = date('Y-m-d', strtotime("+".$i."day",strtotime($babyRegistrationData['deliveryDate'])));
											$babyWeight = $this->BabyModel->babyWeightViaDate($data['babyId'],'Asc',$date,$babyAdmissionData['id']);							
											$baby= array();
											if($i=='0'){
												$baby['day'] 	= '0';
												$baby['weigth'] = $babyRegistrationData['babyWeight'];
											}else{
												$baby['day'] 	= $i;
												$baby['weigth'] = ($babyWeight['babyWeight']>0)? $babyWeight['babyWeight']:'0';
											}
											$arrayName['babyWeight'][] = $baby;				
										}

										
										$days = getDateDifferenceWithCurrent(strtotime($babyRegistrationData['deliveryDate']));

										// for ($i=0 ; $i < $days ; $i++) { 
										// 	$date = date('Y-m-d', strtotime("+".$i."day",strtotime($babyRegistrationData['deliveryDate'])));
										// 	$BreastFeeding = $this->BabyModel->getFeedingDataViaBabyId($data,$date,$babyAdmissionData['id']);
											
										// 	$Feeding['day'] = $i;
										// 	$Feeding['milkQuantity'] = ($BreastFeeding['0']['sum']!='')?$BreastFeeding['0']['sum'] :'0';

										// 	$arrayName['breastFeeding'][] = $Feeding;
										//   }
										

										//Skin to Skin Detail List	
										
										$arrayName['kmcData'] =array();
										$$days = getDateDifferenceWithCurrent(strtotime($babyRegistrationData['deliveryDate']));

										for ($i=0 ; $i < $days ; $i++) { 
											$SST['day'] = $i;
											$date = date('Y-m-d', strtotime("+".$i."day",strtotime($babyRegistrationData['deliveryDate'])));
											$SSTDetail = $this->BabyModel->getKMCDataViaDate($data,$date,$babyAdmissionData['id']);
											$SST['duration'] = $SSTDetail;
											$arrayName['kmcData'][] = $SST;
										}

										//Skin to Skin Detail List	

										$getBabyDetail = $this->BabyModel->getBabyMonitoringSpecificData($data,$babyAdmissionData['id']);

										$getAssessmentDataFromDOB = $this->BabyModel->getAssessmentDataFromDOB($babyAdmissionData['id'], $babyRegistrationData['deliveryDate']); 

										$arrayName['breastFeeding'] = $getAssessmentDataFromDOB['breastFeeding'];

										$arrayName['respiratoryRate'] = $getAssessmentDataFromDOB['respiratoryRate'];
										$arrayName['pulseRate'] = $getAssessmentDataFromDOB['pulseRate'];
										$arrayName['spo2'] = $getAssessmentDataFromDOB['spo2'];
										$arrayName['temperature'] = $getAssessmentDataFromDOB['temperature'];

										//Respiratory Rate Array End

										//Temperature Rate Array Starte
											// $arrayName['temperature']   = array();
											// foreach ($getBabyDetail as $key => $value) {
											//  	$BabyTemperature['dateTime'] = $value['addDate'];
											//  	$BabyTemperature['temperature']	  = $value['temperatureValue'];
											//  	$BabyTemperature['temperatureUnit']	  = $value['temperatureUnit'];
											//  	$arrayName['temperature'][]   = $BabyTemperature;
											// } 

										//Temperature Rate Array End


										//Pulse Rate Array Starte
											// $arrayName['pulseRate'] = array();
											// foreach ($getBabyDetail as $key => $value) {
											//  	$PulseRate['dateTime'] 	= $value['addDate'];
											//  	$PulseRate['pulseRate']	= $value['pulseRate'];
											//  	$arrayName['pulseRate'][] = $PulseRate;
											// } 

										//Pulse Rate Array End
										//SpO2 Rate Array Starte
											// $arrayName['spo2'] = array();
											// foreach ($getBabyDetail as $key => $value) {
											//  	$SpO2['dateTime'] 	= $value['addDate'];
											//  	$SpO2['spo2']			= $value['spo2'];
											//  	$arrayName['spo2'][] =  $SpO2;
											// } 

										//SpO2 Rate Array End\\

											$DischargeStatus = '0';

											$babyWeightForDiscgarge = $this->BabyModel->getBabyWeight($data['babyId'],'Desc',$data['loungeId'],'3',$babyAdmissionData['id']);

											// condition to check Baby stay three days in lounge 
											if(count($babyWeightForDiscgarge)>=3){
																					
												//Checking Last 3 Day Baby Weight For  Discharge
												if($babyWeightForDiscgarge['1']['babyWeight']>$babyWeightForDiscgarge['2']['babyWeight']){

													if($babyWeightForDiscgarge['0']['babyWeight']>$babyWeightForDiscgarge['1']['babyWeight']){
															$DischargeStatus = '0' ;
														}else{
															$DischargeStatus = '1' ;
														}
													}else{
														$DischargeStatus = '1' ;
													}

											
											// Get last 3 Monitoring Data for Discharge   	
											$GetLastThreeMonitoring = $this->BabyModel->getBabyMonitoringData($babyAdmissionData['id'],$data['loungeId'],'Desc','3');

												//print_r($GetLastThreeMonitoring);exit;
												if($DischargeStatus!='1')
												{
													# condition for Respiratory Rate 
													foreach ($GetLastThreeMonitoring as $key => $value){

														if(($value['respiratoryRate']<30)||($value['respiratoryRate']>60 )){
															$DischargeStatus ='0';
												  			break;
												  		}
														
													}

													# condition for Temperature 
													foreach ($GetLastThreeMonitoring as $key => $value){

														if(($value['temperatureValue']<95.9)||($value['temperatureValue']>99.5 )){

															$DischargeStatus ='0';
												  			break;
												  		}	
														
													}
													# condition for Other Danger Sysmtoms
													foreach ($GetLastThreeMonitoring as $key => $value){

													 if($value['otherComment']==array()){

															$DischargeStatus ='0';
												  			break;
														}
													}
												}
											}else{
												$arrayName['dischargeStatus'] = '1';
												
											}

										$response['babyDetails'] = $arrayName;
										$response['md5Data'] = md5(json_encode($response['babyDetails']));

										if(count($response['babyDetails']) > 0)
										{
											generateServerResponse('1','S',$response);
										}else{
											generateServerResponse('0','E');
										} 

								} else{
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
    }

    
    public function getBabyWeight($request='',$admissionId)
    {
    	$currentdata = strtotime(date("d-M-Y 00:00:00"));
    	$row = $this->db->get_where('babyDailyWeight', array('addDate >='=>$currentdata,'babyAdmissionId'=>$admissionId))->num_rows();
    	 return ($row >'0')? 'yes':'no';
    }

}