<?php
class DischargeModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('api/GeneratePdfSNCU');	
		$this->load->model('api/BabyAdmissionPDF'); 
      	$this->load->model('api/BabyWeightPDF');
      	$this->load->model('api/BabyKmcPDF'); 
      	$this->load->model('api/BabyFeedingPDF');
      	$this->load->model('api/BabyDischargePdf'); 	
		date_default_timezone_set("Asia/KolKata");
	}

	public function DischargeFromPost($request)
	{
		$DigitalSign = ($request['signOfFamilyMember']!='') ? saveImage($request['signOfFamilyMember'],signDirectory) :NULL;
		$ashaSign    = ($request['ashaSign']!='') ? saveImage($request['ashaSign'],signDirectory)  :NULL;
		$doctorSign  = ($request['doctorSign']!='') ? saveImage($request['doctorSign'],signDirectory) :NULL;
		$arrayName  = array();
			$arrayName['referredFacilityName'] = ($request['referredFacilityName'] != '') ? $request['referredFacilityName'] : NULL;
                   
			$arrayName['typeOfDischarge'] 	= ($request['typeOfDischarge'] != '') ? $request['typeOfDischarge'] : NULL;

			$arrayName['referredFacilityAddress'] = ($request['referredFacilityAddress'] != '') ? $request['referredFacilityAddress'] : NULL;
			$arrayName['referredReason'] 	= ($request['referredReason'] != '') ? $request['referredReason'] : NULL;
			$arrayName['dischargeByDoctor'] = ($request['dischargeByDoctor'] != '') ? $request['dischargeByDoctor'] : NULL;
			$arrayName['dischargeByNurse']   = ($request['dischargeByNurse'] != '') ? $request['dischargeByNurse'] : NULL;

			$arrayName['transportation']     = ($request['transportation'] != '') ? $request['transportation'] : NULL;
			$arrayName['signOfFamilyMember'] = $DigitalSign;
			$arrayName['doctorSign'] 		 = $doctorSign;
			// $arrayName['DischargeChecklist'] = $request['DischargeChecklist'];

			$arrayName['dateOfDischarge']	  = date('Y-m-d H:i:s');
			// $arrayName['DateOFFollowUpVisit'] = ($request['DateOFFollowUpVisit']!='')? date('Y-m-d',strtotime($request['DateOFFollowUpVisit'])): date('Y-m-d');
			$arrayName['ashaSign'] 			  = $ashaSign;


			/***** new added fields   *****/

			$arrayName['referralIndication'] = ($request['referralIndication'] != '') ? $request['referralIndication'] : NULL;
			$arrayName['treatmentOxygen'] 	= ($request['treatmentOxygen'] != '') ? $request['treatmentOxygen'] : NULL;
			$arrayName['treatmentOxygenDuration']  	= ($request['treatmentOxygenDuration'] != '') ? $request['treatmentOxygenDuration'] : NULL;
			$arrayName['treatmentPhototherapy']   = ($request['treatmentPhototherapy'] != '') ? $request['treatmentPhototherapy'] : NULL;

			$arrayName['treatmentPhototherapyDuration']    = ($request['treatmentPhototherapyDuration'] != '') ? $request['treatmentPhototherapyDuration'] : NULL;

			$arrayName['treatmentStepDown'] 		= ($request['treatmentStepDown'] != '') ? $request['treatmentStepDown'] : NULL;
			$arrayName['treatmentStepDownDuration']= ($request['treatmentStepDownDuration'] != '') ? $request['treatmentStepDownDuration'] : NULL;

			$arrayName['treatmentKMC'] 				= ($request['treatmentKMC'] != '') ? $request['treatmentKMC'] : NULL;
			$arrayName['treatmentKMCDuration'] 	 	= ($request['treatmentKMCDuration'] != '') ? $request['treatmentKMCDuration'] : NULL;
			$arrayName['treatmentAntibiotics']  	= ($request['treatmentAntibiotics'] != '') ? $request['treatmentAntibiotics'] : NULL;
			$arrayName['treatmentAntibioticsDetails']   	= ($request['treatmentAntibioticsDetails'] != '') ? $request['treatmentAntibioticsDetails'] : NULL;

			$arrayName['additionalTreatment']     	= ($request['additionalTreatment'] != '') ? $request['additionalTreatment'] : NULL;
			
			$arrayName['courseDuringTreatment'] 	= ($request['courseDuringTreatment'] != '') ? $request['courseDuringTreatment'] : NULL;
			$arrayName['relevantInvestigation'] 	= ($request['relevantInvestigation'] != '') ? $request['relevantInvestigation'] : NULL;
			$arrayName['condition'] 	= ($request['condition'] != '') ? $request['condition'] : NULL;
			$arrayName['riCard'] 		= ($request['riCard'] != '') ? $request['riCard'] : NULL;
			$arrayName['BCG'] 			= ($request['BCG'] != '') ? $request['BCG'] : NULL;
			$arrayName['OPV'] 			= ($request['OPV'] != '') ? $request['OPV'] : NULL;
			$arrayName['hepatitisB'] 		= ($request['hepatitisB'] != '') ? $request['hepatitisB'] : NULL;
			$arrayName['treatmentAdvised'] 	= ($request['treatmentAdvised'] != '') ? $request['treatmentAdvised'] : NULL;
			$arrayName['dischargeChecklist'] 	= ($request['dischargeChecklist'] != '') ? $request['dischargeChecklist'] : NULL;


			/***** new added fields   *****/		
			
			/*$arrayName['modifyDate'] = time();	*/
            // type 1 for mother discharge
			if($request['type'] == '1') {
		
				$this->db->order_by('id','desc');
				$getStatus = $this->db->get_where('motherAdmission',array('motherId'=>$request['motherOrBabyId'],'loungeId'=>$request['loungeId']))->row_array();

				$arrayName['status'] = '2';
				$arrayName['modifyDate'] = date('Y-m-d : H:i:s');
				$this->db->where(array('id'=>$getStatus['id']));
				$this->db->update('motherAdmission', $arrayName);

				

	            $GetNoticfictaionEntry = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."'  AND  motherId = '".$request['motherOrBabyId']."' AND status = '1' AND typeOfNotification='1' order by id desc limit 0, 1")->result_array();
	            $GetNoticfictaionEntry1 = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."'  AND  motherId = '".$request['motherOrBabyId']."' AND status = '1' AND typeOfNotification='1' order by id desc limit 0, 1")->row_array();
	              
	                $settingDetail =  getAllData('settings','id','1');
			
           			$secondMonitoring     = $settingDetail['motherMonitoringSecondTime'];  
			        $secondTiming         = date('Y-m-d '.$secondMonitoring.':00:00');
			        $secondMonitoringTime = strtotime($secondTiming);

			        $secondEnddate       = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$secondMonitoringTime)));
			        $secondEndTiming     = strtotime($secondEnddate);

                    $thirdMonitoing      = $settingDetail['motherMonitoringThirdTime'];  
			        $thirdTiming         = date('Y-m-d '.$thirdMonitoing.':00:00');
			        $thirdMonitoringTime = strtotime($thirdTiming);

			        $thirdEndDate      = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$thirdMonitoringTime)));
			        $thirdEndTiming    = strtotime($thirdEndDate);			        

			        $fourthMonitoring     = $settingDetail['motherMonitoringFourthTime'];  
			        $fourthTiming         = date('Y-m-d '.$fourthMonitoring.':00:00');
			        $fourthMonitoringTime = strtotime($fourthTiming);

			        $fourthEndDate       = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$fourthMonitoringTime)));
			        $fourthEndTime       = strtotime($fourthEndDate);		

			        $curDateTime         = time();	        
		        
                   if($settingDetail > 0)
                   {
				        $firstMonitoring    = $settingDetail['motherMonitoringFirstTime'];  
				        $firstTiming        = date('Y-m-d '.$firstMonitoring.':00:00');
				        $firstMonitoringTime = strtotime($firstTiming);
					    
				        $firstEnddate        = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$firstMonitoringTime)));
				        $firstEndTiming      = strtotime($firstEnddate);
					
						if($firstMonitoringTime <= $curDateTime && $firstEndTiming > $curDateTime)
						 { 
                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('id', $GetNoticfictaionEntry1['id']);
								$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
                           }

						 }else if($secondMonitoringTime <= $curDateTime && $secondEndTiming > $curDateTime)
						 {
                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('id', $GetNoticfictaionEntry1['id']);
								$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
                           }						 	
						 }else if($thirdMonitoringTime <= $curDateTime && $thirdEndTiming > $curDateTime)
						 {
                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('id', $GetNoticfictaionEntry1['id']);
								$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
                           }						 	
						 }else if($fourthMonitoringTime <= $curDateTime && $fourthEndTime > $curDateTime)
						 {
                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('id', $GetNoticfictaionEntry1['id']);
								$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
                           }						 	
						}			
                     } 
				
				return 1;

			}else {	
						$getLoungetype = $this->db->get_where('loungeMaster',array('loungeId'=>$request['loungeId']))->row_array();


						    $this->db->order_by('id','desc');
							$getStatus = $this->db->get_where('babyAdmission',array('babyId'=>$request['motherOrBabyId'],'loungeId'=>$request['loungeId']))->row_array();
				         // Create feed for kmc position || skin to skin touch

							$getMotherData   = $this->db->query("select MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId`  where  BA.`babyId` ='".$request['motherOrBabyId']."'")->row_array();
				            $paramArray                 = array();
				            $paramArray['type']         = '6';
				            $paramArray['loungeId']     = $request['loungeId'];
				            $paramArray['babyAdmissionId'] = $getStatus['id'];
				            $paramArray['grantedForId']     = $getStatus['id'];
				            $paramArray['feed']             = "B/O ".(!empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'UNKNOWN')." has been discharged.\n reason ".$request['typeOfDischarge'].".";
				            $paramArray['status']	   = '1';
							$paramArray['addDate']	  = date('Y-m-d : H:i:s');
							$paramArray['modifyDate']  = date('Y-m-d : H:i:s');
				            $this->db->insert('timeline',$paramArray);
							
							$arrayName['weightGainLosePostAdmission']= ($request['weightGainLosePostAdmission'] != '') ? $request['weightGainLosePostAdmission'] : NULL;
							$arrayName['babyDischargeWeight'] 	= ($request['babyDischargeWeight'] != '') ? $request['babyDischargeWeight'] : NULL;
							$arrayName['babyDischargeAge'] 		= ($request['babyDischargeAge'] != '') ? $request['babyDischargeAge'] : NULL;
							$arrayName['status'] = '2';
							$arrayName['modifyDate']= date('Y-m-d : H:i:s');

							$this->db->where(array('id'=>$getStatus['id']));
							$this->db->update('babyAdmission', $arrayName);
							
							//$pdf = $this->DischargePdf($request['motherOrBabyId'],$request['type']);
							if($getLoungetype['type'] == 1){   // SNCU
								$pdf = $this->GeneratePdfSNCU->createFinalSNCUPdf($getStatus['id'], '1');
							} else if($getLoungetype['type'] == 2){    // KMC
								//$pdf = $this->AllMixPdf->finalPdfDischargeTime($request['loungeId'],$getStatus['id'],$request['type']);
								//$pdf = 
								$this->BabyDischargePdf->FinalpdfGenerate($getStatus['id']);
							}
							
							//$this->db->where(array('id'=>$getStatus['id']));
							//$this->db->update('babyAdmission',array('babyDischargePdfName'=>$pdf));

							
							//echo $pdf;die;
			      		
			      		############   Notification Section Manage    #########################

						 $GetNoticfictaionEntry = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."'  AND  babyId = '".$request['motherOrBabyId']."' AND status = '1' AND typeOfNotification='2' order by id desc limit 0, 1")->result_array();

						 $GetNoticfictaionEntry1 = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."'  AND  babyId = '".$request['motherOrBabyId']."' AND status = '1' AND typeOfNotification='2' order by id desc limit 0, 1")->row_array();	                

						 $settingDetail =  getAllData('settings','id','1');
			           			$secondMonitoring     = $settingDetail['babyMonitoringSecondTime'];  
						        $secondTiming         = date('Y-m-d '.$secondMonitoring.':00:00');
						        $secondMonitoringTime = strtotime($secondTiming);

						        $secondEnddate       = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$secondMonitoringTime)));
						        $secondEndTiming     = strtotime($secondEnddate);

						        $thirdMonitoing      = $settingDetail['babyMonitoringThirdTime'];  
						        $thirdTiming         = date('Y-m-d '.$thirdMonitoing.':00:00');
						        $thirdMonitoringTime = strtotime($thirdTiming);

						        $thirdEndDate      = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$thirdMonitoringTime)));
						        $thirdEndTiming    = strtotime($thirdEndDate);			        

						        $fourthMonitoring     = $settingDetail['babyMonitoringFourthTime'];  
						        $fourthTiming         = date('Y-m-d '.$fourthMonitoring.':00:00');
						        $fourthMonitoringTime = strtotime($fourthTiming);

						        $fourthEndDate       = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$fourthMonitoringTime)));
						        $fourthEndTime       = strtotime($fourthEndDate);				        

						        $curDateTime          = time();		        
					        
			                   if($settingDetail > 0)
			                   {
						        $firstMonitoring    = $settingDetail['babyMonitoringFirstTime'];  
						        $firstTiming        = date('Y-m-d '.$firstMonitoring.':00:00');

						        $firstMonitoringTime = strtotime($firstTiming);
						        $firstEnddate        = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$firstMonitoringTime)));
						        $firstEndTiming      = strtotime($firstEnddate);
								
									if($firstMonitoringTime <= $curDateTime && $firstEndTiming > $curDateTime)
									 { 
			                           if(count($GetNoticfictaionEntry)==1){
											$this->db->where('id', $GetNoticfictaionEntry1['id']);
											$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
			                           }

									 }else if($secondMonitoringTime <= $curDateTime && $secondEndTiming > $curDateTime)
									 {

			                           if(count($GetNoticfictaionEntry)==1){
											$this->db->where('id', $GetNoticfictaionEntry1['id']);
											$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
			                           }						 	
									 }else if($thirdMonitoringTime <= $curDateTime && $thirdEndTiming > $curDateTime)
									 {
			                           if(count($GetNoticfictaionEntry)==1){
											$this->db->where('id', $GetNoticfictaionEntry1['id']);
											$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
			                           }						 	
									 }else if($fourthMonitoringTime <= $curDateTime && $fourthEndTime > $curDateTime)
									 {
			                           if(count($GetNoticfictaionEntry)==1){
											$this->db->where('id', $GetNoticfictaionEntry1['id']);
											$this->db->update('notification',array('status'=>'3','modifyDate'=>$curDateTime));                              	 
			                           }						 	
									 }			

			                     } 


							//$PdfName = $this->MotherBabyAdmissionModel->babyWeightPdfFile($request['loungeId'],$getStatus['id'],'discharge');
							
							//$this->db->where('id',$getStatus['id']);
							//$this->db->update('babyAdmission',array('babyWeightPdfName'=>$PdfName));

			                $this->BabyWeightPDF->WeightpdfGenerate($getStatus['id']);
			                
							return 1;

			}
	}
	
	
	public function DischargeList($request)
	{
		$start = ($request['start_date']!='') ? strtotime(date($request['start_date'].' 00:00:01')) :'';
		$end   = ($request['end_date']!='') ? strtotime(date($request['end_date'].' 23:59:59')) :'';

		if($request['type']=='1')
		{
			# condition 1 TFF
			if($request['search_data']!='' && $start=='' && $end==''){
				$MotherData = $this->db->query("SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MR.`motherName` LIKE '".$request['search_data']."%'  OR 
				MR.`fatherName`  LIKE '".$request['search_data']."%' OR
				MR.`motherMCTSNumber`= '".$request['search_data']."'  OR 
				MA.`hospitalRegistrationNumber`= '".$request['search_data']."' OR
				MR.`motherAadharNumber`= '".$request['search_data']."' OR
				MR.`motherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherAadharNumber`= '".$request['search_data']."' AND MA.`status` = '2' ")->result_array();
			}elseif($request['search_data']!='' && $start!='' && $end==''){

				# condition 2 TTF
				$MotherData = $this->db->query("SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MR.`motherName` LIKE '".$request['search_data']."%'  OR 
				MR.`fatherName`  LIKE '".$request['search_data']."%' OR
				MR.`motherMCTSNumber`= '".$request['search_data']."'  OR 
				MA.`hospitalRegistrationNumber`= '".$request['search_data']."' OR
				MR.`motherAadharNumber`= '".$request['search_data']."' OR
				MR.`motherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherAadharNumber`= '".$request['search_data']."' AND MA.`status` = '2' AND MA.`addDate` >= '".$start."' ")->result_array();
			}elseif($request['search_data']!='' && $start!='' && $end!=''){

				# condition 3 TTT
				$MotherData = $this->db->query("SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MR.`motherName` LIKE '".$request['search_data']."%'  OR 
				MR.`fatherName`  LIKE '".$request['search_data']."%' OR
				MR.`motherMCTSNumber`= '".$request['search_data']."'  OR 
				MA.`hospitalRegistrationNumber`= '".$request['search_data']."' OR
				MR.`motherAadharNumber`= '".$request['search_data']."' OR
				MR.`motherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherAadharNumber`= '".$request['search_data']."' AND MA.`status` = '2' AND MA.`addDate` >= '".$start."'  AND MA.`addDate` <= '".$end."' ")->result_array();

			}elseif($request['search_data']=='' && $start!='' && $end==''){

				
				$MotherData = $this->db->query(" SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MA.`status` = '2' AND MA.`addDate` >= '".$start."' ")->result_array();

			}elseif($request['search_data']=='' && $start!='' && $end!=''){
            
				# condition 5 FTT
				$MotherData = $this->db->query(" SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MA.`status` = '2' AND MA.`addDate` >= '".$start."' AND MA.`addDate` <= '".$end."' ")->result_array();
			//echo $this->db->last_query();exit;
			}elseif($request['search_data']!='' && $start=='' && $end!=''){

				# condition 6 TFT
				$MotherData = $this->db->query(" SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MR.`motherName` LIKE '".$request['search_data']."%'  OR 
				MR.`fatherName`  LIKE '".$request['search_data']."%' OR
				MR.`motherMCTSNumber`= '".$request['search_data']."'  OR 
				MA.`hospitalRegistrationNumber`= '".$request['search_data']."' OR
				MR.`motherAadharNumber`= '".$request['search_data']."' OR
				MR.`motherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherMoblieNumber`= '".$request['search_data']."' OR
				MR.`fatherAadharNumber`= '".$request['search_data']."' AND 
				MA.`status` = '2' AND MA.`addDate` <= '".$end."'  ")->result_array();
				
		}   elseif($request['search_data']!='' && $start!='' && $end==''){

				# condition 7 FFT
				$MotherData = $this->db->query(" SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MA.`status` = '2' AND MA.`addDate` <= '".$end."'  ")->result_array();
				
			}else{

				$MotherData = $this->db->query("SELECT * FROM `motherRegistration` as MR Left Join motherAdmission as MA on MA.`motherId`  = MR.`motherId`  where 
				MA.`loungeId` = '".$request['loungeId']."'  AND MA.`status` = '2' ORDER BY MA.`id` DESC ")->result_array();

			}
			 	$arrayName = array();
	            $hold      = array();
	            foreach($MotherData as $key => $value){
	                $hold['motherId']      = $value['motherId'];
	                $hold['motherName']    = $value['motherName'];
	                $hold['mother_pic']     = motherDirectoryUrl.$value['motherPicture'];
	                $hold['mother_mcts']    = $value['motherMCTSNumber'];
	                $hold['mother_aaadhar'] = $value['motherAadharNumber'];
	                $hold['mother_mcts']    = $value['motherMCTSNumber'];
	                $hold['mother_aaadhar'] = $value['motherAadharNumber'];
	                $hold['last_lounge_id'] = getLastEnteredData('loungeId','motherId',$value['motherId'],'motherAdmission','1');
	                $hold['loungeName']    = getSingleRowFromTable('loungeName','loungeId',$hold['last_lounge_id'],'loungeMaster');
	                $hold['lounge_address'] = $this->getFacilityAddress($hold['last_lounge_id']);
	                $hold['admission_date'] = getLastEnteredData('addDate','motherId',$value['motherId'],'motherAdmission','1');
	                $dateOfDischarge         = $this->DischargeDate($hold['last_lounge_id'],$hold['motherId'],'1');
	               
	                $hold['dateOfDischarge'] = ($value['dateOfDischarge']!='') ? strtotime($value['dateOfDischarge']):'';
	                //echo  $hold['dateOfDischarge']; exit;

	                $hold['last_monitoring_date'] =  getLastEnteredData('addDate','motherId',$value['motherId'],'motherMonitoring','1');
	                $babyCount 	 = $this->GetAllMotherBabies($hold['motherId'],'2');
	              
	                $hold['reg_pdf'] = '';
                    $hold['discharge_pdf'] = '';

                     $GetMotherBaby = $this->GetAllMotherBabies($hold['motherId']);

		                $Baby  = array();
			            $hold2 = array();
			            foreach ($GetMotherBaby as $key => $babies) {

		                    $Baby['babyId']        = $babies['babyId'];
		                    $Baby['babyDirectoryUrl']     = babyDirectoryUrl.getSingleRowFromTable('babyPhoto','babyId',$babies['babyId'],'babyRegistration');
		                    $Baby['admission_date'] = $babies['addDate'];
		                    $Baby['dateOfDischarge'] = $this->DischargeDate($babies['loungeId'],$Baby['babyId'] ,'2');
		                    $Baby['loungeId']      = $babies['loungeId'];

		                    $Baby['loungeName']    = getSingleRowFromTable('loungeName','loungeId',$babies['loungeId'],'loungeMaster');

		                    $Baby['lounge_address'] = $this->getFacilityAddress($babies['loungeId']);

		                    $Baby['last_monitoring_date'] =  getLastEnteredData('addDate','babyId',$babies['babyId'],'babyDailyMonitoring','1');

		                    $Baby['reg_pdf']            = ($babies['babyPdfFileName']!='')? pdfDirectoryUrl.$babies['babyPdfFileName'] :'';
		                    $Baby['weigth_pdf']         = ($babies['babyWeightPdfName']!='')? pdfDirectoryUrl.$babies['babyWeightPdfName'] :'';
						    $Baby['kmc_pdf']            = ($babies['BabyKMCPdfName']!='')? pdfDirectoryUrl.$babies['BabyKMCPdfName'] :'';
						    $Baby['daily_intake_pdf']   = ($babies['BabyFeedingPdfName']!='')? pdfDirectoryUrl.$babies['BabyFeedingPdfName'] :'';
						    $Baby['discharge_pdf']      = ($babies['BabyDischargePdfName']!='')? pdfDirectoryUrl.$babies['BabyDischargePdfName'] :'';

				   $Baby['status'] = $babies['status'];
				                
			               $hold2[] =  $Baby;
			            }
			             $hold['babies'] =  $hold2;

                  
                $arrayName[] = $hold;
                }

			$response['discharge_list']= $arrayName;
			if(count($response['discharge_list'])>0)
            {
                generateServerResponse('1','135', $response);
            }else{
                generateServerResponse('0','E');
            }


		}elseif($request['type'] == '2'){


			if($request['search_data']!=''){
				$GetMotherBaby = $this->db->query("SELECT * FROM `babyRegistration` as BR Left Join babyAdmission as BA on BA.`babyId`  = BR.`babyId`  where 
				BA.`babyFileId` LIKE '".$request['search_data']."%'  OR 
				BR.`babyMCTSNumber` LIKE '".$request['search_data']."%'  AND BA.`status` = '2' ")->result_array();
			}else{

				$GetMotherBaby = $this->db->query("SELECT * FROM `babyRegistration` as BR Left Join babyAdmission as BA on BA.`babyId`  = BR.`babyId`  where 
				BA.`loungeId` = '".$request['loungeId']."'  AND BA.`status` = '2' ORDER BY BA.`id` DESC ")->result_array();

			}
			 	$Baby  = array();
	            $hold2 = array();
	            foreach ($GetMotherBaby as $key => $babies) {
                    $Baby['babyId']        = $babies['babyId'];
                    $Baby['babyDirectoryUrl']     = babyDirectoryUrl.getSingleRowFromTable('babyPhoto','babyId',$babies['babyId'],'babyRegistration');
                    $Baby['admission_date'] = date('d M y', $babies['addDate']);
                    $Baby['dateOfDischarge'] =  $this->DischargeDate($babies['loungeId'],$Baby['babyId'] ,'2');
                    $Baby['loungeId']      = $babies['loungeId'];

                    $Baby['loungeName']    = getSingleRowFromTable('loungeName','loungeId',$babies['loungeId'],'loungeMaster');

                    $Baby['lounge_address'] = $this->getFacilityAddress($babies['loungeId']);

                    $Baby['last_monitoring_date'] = date('d M y', getLastEnteredData('addDate','babyId',$babies['babyId'],'babyDailyMonitoring','1'));

                    $Baby['reg_pdf'] = ($babies['babyPdfFileName']!='')? pdfDirectoryUrl.$babies['babyPdfFileName'] :'';
                    $Baby['weigth_pdf'] = ($babies['babyWeightPdfName']!='')? pdfDirectoryUrl.$babies['babyWeightPdfName'] :'';
					$Baby['kmc_pdf'] = '';
					$Baby['daily_intake_pdf'] = '';
					$Baby['discharge_pdf'] = '';
		                
	               $hold2[] =  $Baby;
	              
	            }
	             $arrayName = $hold2;
				$response['discharge_list']= $arrayName;
			if(count($response['discharge_list'])>0)
            {
                generateServerResponse('2','135', $response);
            }else{
                generateServerResponse('0','E');
            }

		}
	}


	 public function getFacilityAddress($loungeId)
    {
        $this->db->query("SELECT FL.`Address` FROM loungeMaster as LM LEFT JOIN  facilitylist as FL ON LM.`facilityId` = FL.`facilityId` WHERE loungeId = '".$loungeId."'")->row_array();
    }

    public function DischargeDate($loungeId,$motherId, $type)
    {
        $this->db->select('dateOfDischarge');
        $this->db->order_by('DischargeID','Desc');
        $query = $this->db->get_where('dischargemaster', array('loungeId'=>$loungeId,'motherOrBabyId'=>$motherId,'type'=>$type))->row_array();

    }

    public function GetAllMotherBabies($motherId ,$DataTye='')
    {
    	$status = ($DataTye!= '') ? ' AND BA.`status` =  2':'';
       	$query =  $this->db->query("SELECT BR.`babyId` ,BA.`loungeId`,BA.`status`, BA.`addDate` , BA.`babyPdfFileName`,BA.`BabyFeedingPdfName`,BA.`BabyKMCPdfName`,BA.`BabyDischargePdfName`,BA.`babyWeightPdfName`, BA.`status` FROM `babyRegistration` as BR LEFT JOIN  `babyAdmission` as BA ON BR.`babyId` = BA.`babyId`  where BR.`motherId` =  '".$motherId."'  ".$status."  Order By BA.`id` desc  limit 0,1")->result_array();
        return $query;
    }

     public function DischargePdf($motherOrBabyId , $type)
     {
     	error_reporting(0);

     	if($type == 1)
     	{

     		$GetData = $this->db->query("SELECT * from  motherRegistration as MR LEFT JOIN motherAdmission as MA On BA.`motherId` = MR.`motherId`  Where Mr.`motherId` = '".$motherOrBabyId."' order by MA.`id` Desc ")->row_array();
             $LastAdmissionID = $GetData['id'];
     		 $filename = "m_".$LastAdmissionID."_discharge.pdf";
     		 $Hospitalreg = $GetData['hospitalRegistrationNumber'];
     		 $MCTSNo = $GetData['hospitalRegistrationNumber'];
     		 $DischargeDate = ($GetData['dateOfDischarge'] != '') ? date('d/m/Y',strtotime($GetData['dateOfDischarge'])) : 'N/A';
     		 $Day = '________';
     		 $WeigthOnDischarge = '_______________________';
     	}else{
     		$GetData = $this->db->query("SELECT * from motherRegistration as MR LEFT JOIN babyRegistration as BR On BR.`motherId` = MR.`motherId` LEFT JOIN babyAdmission as BA On BR.`babyId` = BA.`babyId` Where BA.`babyId` = '".$motherOrBabyId."' order by BA.`id` Desc ")->row_array();
     		$LastAdmissionID = $GetData['id'];
     		$filename = "b_".$LastAdmissionID."_discharge.pdf";
     		$Hospitalreg = $GetData['babyFileId'];
			$MCTSNo = $GetData['babyMCTSNumber'];


			$Day = getDateDifferenceWithCurrent($GetData['addDate']);
			$WeigthOnDischarge = ($GetData['babyDischargeWeight'] != '') ? $GetData['babyDischargeWeight'].' grams' : 'N/A';

			$NetGain = $WeigthOnDischarge - $GetData['babyWeight'];  
			$reffered = $GetData['referredFacilityName']." ".$GetData['referredFacilityAddress'];
			$refferedReson = ($GetData['referredReason']!='') ? $GetData['referredReason'] :'_________________________';

                $DischargeDate    = ($GetData['dateOfDischarge'] != '') ? date('d/m/Y',strtotime($GetData['dateOfDischarge'])) : 'N/A';
                $dischargeWeightsGainOrLoss = ($GetData['babyDischargeWeight'] != '') ? $GetData['weightGainLosePostAdmission'] : 'N/A';


				$discharge = json_decode($GetData['DischargeChecklist'],true);
	          foreach ($discharge as $key => $value) {
	       
	          }
			

     	}
  		
     	$html.='';
     	$html.='
			<!DOCtype html>
			<html>
			<head>
			<title>DISCHARGE CHECKLIST FOR KMC UNIT</title>
			<style>

			
			</style>
			</head>
			<body>


			  <div>
			    <h3 style= "text-align:  center"> <u>DISCHARGE CHECKLIST FOR KMC UNIT</u> </h3>
			  </div>


			   

			    <div  style="padding-bottom: 2px; padding-top: 2px">
			      
			      <label style="padding-right: 10%"> <b>Hospital Reg. No.:</b>  '. $Hospitalreg.'</label> 
			      <label style=" padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MCTS NO.</b>: '.$MCTSNo.'</label>
			      </div>
			      <br> 
			  		</div>
			    

			    <div  style="padding-bottom: 2px; padding-top: 2px">
			      <label style="width: 40%; padding-right: 10%"> <b>Name of mother:</b> '. $GetData['motherName'].'</label> 
			      <label style="width: 40%; padding-left: 10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Date of discharge :</b>'.$DischargeDate.'</label>
			      </div>
			      <br> 
			    </div>
			    <div>
			    <div  style="padding-bottom: 2px; padding-top: 2px">
			      
			      <label><b>Number of days spend in KMC room (excluding days spent in SNCU/ NBSU):</b>  '.$Day.' days</label> 
			      <br>
			      <label> <b>weight on discharge(in grams):</b>  '.$WeigthOnDischarge.'</label>
			      </div>
			      <br> 
			    </div>

			    <div>


			    <div  style="padding-bottom: 2px; padding-top: 2px">
			      
			      <label ><b>Net weight gain/loss since admission(in grams):</b>  '.$dischargeWeightsGainOrLoss.' </label> 
			    
			      </div>
			      <br> 
			    </div>

			     <div  style="padding-bottom: 2px; padding-top: 2px">
			      
			      <label ><b>type of discharge :</b>  '.$GetData['typeOfDischarge'].'</label> 
			     
			      </div>
			      <br> 
			    </div>

			    <div  style="padding-bottom: 2px; padding-top: 2px">
			      <h4><u>In case of referral</u> </h4>
			 
			      <label ><b>Name and address of facility reffered to:</b> '.$reffered.'</label> 

			      </div>
			      <br> 
			       <label ><b>reason for referral:</b> '.$refferedReson.'</label> 

			      </div>
			      <br> 
			    </div>

			    <div>

			    <div>
			      <h3 style= "text-align:  center"> DISCHARGE CHECKLIST FOR KMC UNIT </h3>
			    </div>


			   <div>

			      <div  style="padding-bottom: 2px; padding-top: 2px">';
						$discharge = json_decode($GetData['DischargeChecklist'],true);
						$count = 1;
						foreach ($discharge as $key => $value) {
                          $html.='</span><p><b>'.$count++.'.</b> '.$value['name'].'</p>';
						}
			      $html.=' </div>
			      <div style="width:100%;">

						     <div style="float:left;width:50%;">
						       <p>________________________</p>
						        <p style="">Signature of Nurse/Doctor</p>
		                      </div>

		   				     <div style="width:50%;">
						       <p style="margin-left:125px;">________________________</p>
						        <p style="margin-left:125px;">Signature of Family Member</p>
		                      </div>                   
				      </div>
				    </div>

				    <div>

				    
				</body>
				</html>';

		/*$fileName = "b_".$BabyData['babyId'].".pdf";*/
		$pdfFilePath =  pdfDirectory."b_".$LastAdmissionID."discharge.pdf";
		//echo $pdfFilePath;

		/*echo $pdfFilePath;*/ 

		//load mPDF library
		$this->load->library('m_pdf');
		$PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		//generate the PDF from html
		$this->m_pdf->pdf->WriteHTML($PDFContent);

		//download PDF
		$this->m_pdf->pdf->Output($pdfFilePath, "F"); 

		return  "b_".$LastAdmissionID."discharge.pdf";
    }


    public function MoveToUnitPost($request)
	{
			$DigitalSign = ($request['signOfFamilyMember']!='') ? saveImage($request['signOfFamilyMember'],signDirectory) :NULL;
			
			$doctorSign  = ($request['doctorSign']!='') ? saveImage($request['doctorSign'],signDirectory) :NULL;
			$arrayName  = array();
			$arrayName['MoveToUnit'] = $request['MoveToUnit'];
			$arrayName['typeOfDischarge'] 		  = $request['typeOfDischarge'];

			
			$arrayName['Movereason'] 	 	= $request['Movereason'];
			$arrayName['dischargeByDoctor']  = $request['dischargeByDoctor'];
			$arrayName['dischargeByNurse']   = $request['dischargeByNurse'];

			
			$arrayName['signOfFamilyMember'] = $DigitalSign;
			$arrayName['doctorSign'] 		 = $doctorSign;
			// $arrayName['DischargeChecklist'] = $request['DischargeChecklist'];

			$arrayName['dateOfDischarge']	  = ($request['dateOfDischarge']!='')  ? date('Y-m-d H:i:s',strtotime($request['dateOfDischarge'])) : date('Y-m-d H:i:s');
						

			$getLoungetype = $this->db->get_where('loungeMaster',array('loungeId'=>$request['loungeId']))->row_array();


			$this->db->order_by('id','desc');
			$getStatus = $this->db->get_where('babyAdmission',array('babyId'=>$request['babyId'],'loungeId'=>$request['loungeId']))->row_array();
				         // Create feed for kmc position || skin to skin touch

			$getMotherData   = $this->db->query("select MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId`  where  BA.`babyId` ='".$request['motherOrBabyId']."'")->row_array();
			// $paramArray                 = array();
			// $paramArray['type']         = '6';
			// $paramArray['loungeId']     = $request['loungeId'];
			// $paramArray['babyAdmissionId'] = $getStatus['id'];
			// $paramArray['grantedForId']     = $getStatus['id'];
			// $paramArray['feed']             = "B/O ".(!empty($getMotherData['motherName']) ? $getMotherData['motherName'] : 'UNKNOWN')." has been discharged.\n reason ".$request['typeOfDischarge'].".";
			// $paramArray['status']	   = '1';
			// $paramArray['addDate']	   = time();
			// $paramArray['modifyDate']  = time();
			// $this->db->insert('timeline',$paramArray);
							
			
			$arrayName['MoveStatus'] = '1';
			$arrayName['modifyDate'] = time();


			$this->db->where(array('id'=>$getStatus['id']));
			$this->db->update('babyAdmission', $arrayName);
							
			return 1;
	}


	public function MoveToUnitStatusChange($request){
		
			$arrayName  = array();
						
			$getLoungetype = $this->db->get_where('loungeMaster',array('loungeId'=>$request['loungeId']))->row_array();


			$this->db->order_by('id','desc');
			$getStatus = $this->db->get_where('babyAdmission',array('babyId'=>$request['babyId'],'MoveToUnit'=>$request['loungeId']))->row_array();

			$getMotherData   = $this->db->query("select MR.`motherId`, MR.`motherName`, BA.`babyId` FROM  babyRegistration AS BA LEFT JOIN  motherRegistration AS MR  On BA.`motherId` = MR.`motherId`  where  BA.`babyId` ='".$request['motherOrBabyId']."'")->row_array();

			if($getStatus['MoveStatus'] == '1'){

				$arrayName['MoveStatus'] = '2';
				$arrayName['modifyDate'] = time();

				$this->db->where(array('id'=>$getStatus['id']));
				$this->db->update('babyAdmission', $arrayName);	

			}
					
			return 1;

	}


	public function MoveToUnitDetails($request){


			$this->db->order_by('id','desc');
			$getBabyList = $this->db->query("SELECT * FROM `babyAdmission` WHERE `MoveToUnit` = '".$request['loungeId']."' AND MoveStatus = '1' ORDER BY `id` ASC LIMIT ".$request['Index'].",20")->result_array();
			$arrayName = array();
			
			foreach ($getBabyList as $key => $value) { 
				
				$GetData = $this->db->query("SELECT * FROM `babyRegistration` WHERE `babyId` = '".$value['babyId']."'")->row_array(); 
			    
			    $GetData1 = $this->db->get_where('babyAdmission',array('id'=>$value['id']))->row_array();
     
			 	if(count($GetData) > 0)
			 	{
		             
				 		$Hold['babyId']                      = $GetData['babyId'];
				 		$Hold['babyFileId']                  = $GetData1['babyFileId'];
				 		$Hold['babyPhoto']                   = base_url().'assets/images/babyDirectoryUrls/'.$GetData['babyPhoto'];
				 		$Hold['motherId']                    = $GetData['motherId'];
				 		$Hold['babyMCTSNumber']              = $GetData['babyMCTSNumber'];
				 		$Hold['deliveryDate']                = $GetData['deliveryDate'];
				 		$Hold['deliveryTime']                = $GetData['deliveryTime'];
				 		$Hold['babyGender']                  = $GetData['babyGender'];
				 		$Hold['deliveryType']                = $GetData['deliveryType'];

				 		$Hold['babyWeight']                  = $GetData['babyWeight'];
				 		$Hold['birthWeightAvail']            = $GetData['birthWeightAvail'];
				 		$Hold['reason']                      = $GetData['reason'];

				 		$Hold['DeliveryPlace']               = $GetData['DeliveryPlace'];
				 		$Hold['DeliveryFacilityID']          = $GetData['DeliveryFacilityID'];

				 		$Hold['babyCryAfterBirth']           = $GetData['babyCryAfterBirth'];
				 		$Hold['babyNeedBreathingHelp']       = $GetData['babyNeedBreathingHelp'];

				 		$Hold['typeOfBorn']           		 = $GetData['typeOfBorn'];
				 		$Hold['typeOfOutBorn']       		 = $GetData['typeOfOutBorn'];
				 		$Hold['apgarAtOneMinute']            = $GetData['apgarAtOneMinute'];
				 		$Hold['apgarAtFiveMinute']       	 = $GetData['apgarAtFiveMinute'];
				 		$Hold['wasApgarScoreRecorded']       = $GetData['wasApgarScoreRecorded'];
				 		$Hold['apgarScoreVal']       	 	 = $GetData['apgarScoreVal'];
				 		$Hold['vitaminKGiven']       	 	 = $GetData['vitaminKGiven'];

				 		$Hold['registrationDateTime']        = $GetData['registrationDateTime'];
				 		$Hold['firstTimeFeed']               = $GetData['firstTimeFeed'];
				 		$Hold['status']                      = $GetData['status'];
				 		$Hold['registrationDateTime']        = $GetData['addDate'];
					       $this->db->order_by('id','desc');
					       $babyAddmison = $this->db->get_where('babyAdmission',array('id'=>$value['id']))->row_array();
		                
		                $Hold['babyAddmisonID']                  = $babyAddmison['id'];
		                $Hold['loungeId']                        = $babyAddmison['loungeId'];
		                $Hold['AdmissionDateTime']               = $babyAddmison['AdmissionDateTime'];
		                $Hold['BabyBirthStatus']                 = $babyAddmison['BabyBirthStatus'];
		                //$Hold['CongenitalProblem']               = $babyAddmison['CongenitalProblem'];
		                $Hold['babyAdmissionWeight']             = $babyAddmison['babyAdmissionWeight'];
		                $Hold['admittedPersonSign']              = $babyAddmison['admittedPersonSign'];
		                //$Hold['attendantStaffId']                = $babyAddmison['attendantStaffId'];
		                $Hold['referredFacilityName']            = $babyAddmison['referredFacilityName'];
		                $Hold['referredFacilityAddress']         = $babyAddmison['referredFacilityAddress'];
		                $Hold['weightGainLosePostAdmission']  = $babyAddmison['weightGainLosePostAdmission'];
		                $Hold['babyDischargeWeight']             = $babyAddmison['babyDischargeWeight'];
		                $Hold['babyDischargeAge']             	 = $babyAddmison['babyDischargeAge'];
		                $Hold['typeOfDischarge']                 = $babyAddmison['typeOfDischarge'];
		                $Hold['referredReason']                  = $babyAddmison['referredReason'];
		                $Hold['dischargeByDoctor']               = $babyAddmison['dischargeByDoctor'];
		                $Hold['dischargeByNurse']                = $babyAddmison['dischargeByNurse'];
		                $Hold['transportation']                  = $babyAddmison['transportation'];
		                $Hold['signOfFamilyMember']              = $babyAddmison['signOfFamilyMember'];
		                $Hold['DischargeChecklist']              = $babyAddmison['DischargeChecklist'];
		                $Hold['DateOfFollowUpVisit']             = $babyAddmison['DateOfFollowUpVisit'];
		                $Hold['doctorSign']                      = $babyAddmison['doctorSign'];
		                $Hold['DischargeDateTime']               = $babyAddmison['dateOfDischarge'];
		                $Hold['ashaName']                        = $babyAddmison['ashaName'];
		                $Hold['ashaSign']                        = $babyAddmison['ashaSign'];

		                $Hold['referralIndication']               = $babyAddmison['referralIndication'];
		                $Hold['treatmentOxygen']                  = $babyAddmison['treatmentOxygen'];
		                $Hold['treatmentOxygenDuration']          = $babyAddmison['treatmentOxygenDuration'];
		                $Hold['treatmentPhototherapy']            = $babyAddmison['treatmentPhototherapy'];
		                $Hold['treatmentPhototherapyDuration']    = $babyAddmison['treatmentPhototherapyDuration'];
		                $Hold['treatmentStepDown']          	  = $babyAddmison['treatmentStepDown'];
		                $Hold['treatmentStepDownDuration']        = $babyAddmison['treatmentStepDownDuration'];
		                $Hold['treatmentKMC']    				  = $babyAddmison['treatmentKMC'];
		                $Hold['treatmentKMCDuration']          	  = $babyAddmison['treatmentKMCDuration'];
		                $Hold['treatmentAntibiotics']        		= $babyAddmison['treatmentAntibiotics'];
		                $Hold['treatmentAntibioticsDetails']    	= $babyAddmison['treatmentAntibioticsDetails'];
		                $Hold['additionalTreatment']          	  	= $babyAddmison['additionalTreatment'];
		                $Hold['courseDuringTreatment']        		= $babyAddmison['courseDuringTreatment'];
		                $Hold['relevantInvestigation']    			= $babyAddmison['relevantInvestigation'];
		                $Hold['condition']          	  			= $babyAddmison['condition'];
		                $Hold['riCard']        					= $babyAddmison['riCard'];
		                $Hold['BCG']    							= $babyAddmison['BCG'];
		                $Hold['OPV']          	  					= $babyAddmison['OPV'];
		                $Hold['hepatitisB']    					= $babyAddmison['hepatitisB'];
		                $Hold['treatmentAdvised']          	  		= $babyAddmison['treatmentAdvised'];
		                
		                $Hold['babyWeightPdfName']               = $babyAddmison['babyWeightPdfName'];
		                $Hold['BabyFeedingPdfName']              = $babyAddmison['BabyFeedingPdfName'];
		                $Hold['BabyKMCPdfName']                  = $babyAddmison['BabyKMCPdfName'];
		                $Hold['BabyTreatmentPdfName']            = $babyAddmison['BabyTreatmentPdfName'];
		                $Hold['BabyPrescriptionPdfName']         = $babyAddmison['BabyPrescriptionPdfName'];
		                $Hold['BabyDischargePdfName']            = $babyAddmison['BabyDischargePdfName'];

		                $Hold['MoveToUnit']           		 	 = $babyAddmison['MoveToUnit'];
		                $Hold['MoveStatus']            			 = $babyAddmison['MoveStatus'];
		                $Hold['Movereason']         			 = $babyAddmison['Movereason'];
		                
		                $Hold['babyPdfFileName']            	 = $babyAddmison['babyPdfFileName'];
		                $Hold['BabyNurseOrderPdfName']           = $babyAddmison['BabyNurseOrderPdfName'];
		                $Hold['babyMonitoringSheet']           	 = $babyAddmison['babyMonitoringSheet'];
		                $Hold['sehmatiPatr']           	 		 = $babyAddmison['sehmatiPatr'];

						$mothRegist  = $this->db->get_where('motherRegistration',array('motherId'=>$GetData['motherId']))->row_array();
						$this->db->order_by('id','desc');
						$mothRegist1 = $this->db->get_where('motherAdmission',array('motherId'=>$GetData['motherId']))->row_array();               
								 
				 		$Hold['motherId']                    = $mothRegist['motherId'];
				 		$Hold['motherName']                  = $mothRegist['motherName'];
				 		$Hold['motherAdmission']             = $mothRegist['motherAdmission'];
				 		$Hold['reasonNotAdmitted']     		 = $mothRegist['notAdmittedreason'];
				 		$Hold['motherPicture']               = base_url().'assets/images/motherDirectoryUrls/'.$mothRegist['motherPicture'];
				 		$Hold['hospitalRegistrationNumber']  = $mothRegist1['hospitalRegistrationNumber'];
				 		$Hold['motherMCTSNumber']            = $mothRegist['motherMCTSNumber'];
				 		$Hold['motherAadharNumber']          = $mothRegist['motherAadharNumber'];
				 		$Hold['motherDOB']                   = $mothRegist['motherDOB'];
				 		$Hold['motherAge']                   = $mothRegist['motherAge'];
				 		$Hold['motherEducation']             = $mothRegist['motherEducation'];
				 		$Hold['motherCaste']                 = $mothRegist['motherCaste'];
				 		$Hold['motherReligion']              = $mothRegist['motherReligion'];
				 		$Hold['motherMoblieNumber']              = $mothRegist['motherMoblieNumber'];
				 		$Hold['fatherName']                  = $mothRegist['fatherName'];
				 		$Hold['fatherAadharNumber']          = $mothRegist['fatherAadharNumber'];
				 		$Hold['MotherLMP']                   = $mothRegist['motherLmpDate'];	 			 		
				 		//$Hold['father_dob']                  = $mothRegist['father_dob'];
				 		//$Hold['father_age']                  = $mothRegist['father_age'];
				 		$Hold['fatherMoblieNumber']              = $mothRegist['fatherMoblieNumber'];
				 		$Hold['rationCardType']              = $mothRegist['rationCardType'];
				 		$Hold['guardianName']                = $mothRegist['guardianName'];
				 		$Hold['guardianNumber']              = $mothRegist['guardianNumber'];
				 		$Hold['guardianRelation']            = $mothRegist['guardianRelation'];
				 		$Hold['presentCountry']              = $mothRegist['presentCountry'];
				 		$Hold['permanentState']              = $mothRegist['permanentState'];
				 		$Hold['presentAddress']              = $mothRegist['presentAddress'];
				 		$Hold['presentResidenceType']        = $mothRegist['presentResidenceType'];
				 		//$Hold['PresentHamletName']           = $mothRegist['PresentHamletName'];
				 		$Hold['presentVillageName']          = $mothRegist['presentVillageName'];
				 		$Hold['presentBlockName']            = $mothRegist['presentBlockName'];
				 		$Hold['presentDistrictName']         = $mothRegist['presentDistrictName'];
				 		$Hold['permanentResidenceType']      = $mothRegist['permanentResidenceType'];
				 		$Hold['permanentCountry']            = $mothRegist['permanentCountry'];
				 		$Hold['permanentState']              = $mothRegist['permanentState'];
				 		$Hold['permanentAddress']            = $mothRegist['permanentAddress'];
				 		$Hold['PermanentHamletName']         = $mothRegist['PermanentHamletName'];
				 		$Hold['permanentVillageName']        = $mothRegist['permanentVillageName'];
				 		$Hold['permanentBlockName']          = $mothRegist['permanentBlockName'];
				 		$Hold['permanentDistrictName']       = $mothRegist['permanentDistrictName'];
				 		$Hold['presentPinCode']              = $mothRegist['presentPinCode'];
				 		$Hold['permanentPinCode']            = $mothRegist['permanentPinCode'];
				 		$Hold['ashaId']                      = $mothRegist['ashaId'];
				 		$Hold['MotherashaName']                    = $mothRegist['ashaName'];
				 		$Hold['ashaNumber']                  = $mothRegist['ashaNumber'];
				 		$Hold['sameAddress']        		 = $mothRegist['sameAddress'];
				 		$Hold['presentAddNearByLocation']        = $mothRegist['presentAddNearByLocation'];
				 		$Hold['permanentAddNearByLocation']      = $mothRegist['permanentAddNearByLocation'];
				 		$Hold['staffId']                     = $mothRegist['staffId'];
				 		$Hold['type']                        = $mothRegist['type'];
				 		$Hold['OrganizationName']            = $mothRegist['OrganizationName'];
				 		$Hold['OrganizationNumber']          = $mothRegist['OrganizationNumber'];
				 		$Hold['OrganizationAddress']         = $mothRegist['OrganizationAddress'];
				 		$Hold['status']                      = $mothRegist['status'];
				 		$Hold['para']                        = $mothRegist['para'];
				 		$Hold['abortion']                    = $mothRegist['abortion'];
				 		$Hold['live']                        = $mothRegist['live'];
				 		$Hold['multipleBirth']               = $mothRegist['multipleBirth'];
				 		$Hold['AdmittedSign']                = $mothRegist['AdmittedSign'];
				 		$Hold['gravida']                     = $mothRegist['gravida'];
				 		$Hold['motherWeight']                = $mothRegist['motherWeight'];
				 		$Hold['ageAtMarriage']               = $mothRegist['ageAtMarriage'];

				 		$Hold['birthSpacing']                = $mothRegist['birthSpacing'];
				 		$Hold['consanguinity']               = $mothRegist['consanguinity'];
				 		$Hold['estimatedDateOfDelivery']     = $mothRegist['estimatedDateOfDelivery'];


				 		$Hold['addDate']                     = $mothRegist['addDate'];
				 		$Hold['modifyDate']                 = $mothRegist['modifyDate'];
				 		$Hold['motherLmpDate']               = $mothRegist['motherLmpDate'];
				 		$Hold['deliveryPlace']         = $mothRegist['deliveryPlace'];
				 		$Hold['deliveryDistrict']      = $mothRegist['deliveryDistrict'];
				 		$Hold['facilityId']                  = $mothRegist['facilityId'];
				 		
			              $this->db->order_by('id','desc');
			              $mothAdmision = $this->db->get_where('motherAdmission',array('motherId'=>$GetData['motherId']))->row_array();

				 		$Hold['motherAdmissionID']          = $mothAdmision['id']; 
				 		$Hold['MotherLoungeID']                   = $mothAdmision['loungeId']; 
				 		$Hold['deliveryDateTime']           = $mothAdmision['deliveryDateTime']; 
				 		$Hold['MotherdeliveryType']         = $mothAdmision['deliveryType']; 
				 		$Hold['NumberOfBabies']             = $mothAdmision['NumberOfBabies']; 
				 		$Hold['LMPDate']                    = $mothAdmision['LMPDate']; 
				 		$Hold['FirstPregnancy']             = $mothAdmision['FirstPregnancy']; 
				 		$Hold['MotherBleedingStatus']       = $mothAdmision['MotherBleedingStatus']; 
				 		$Hold['motherTemperature']          = $mothAdmision['motherTemperature']; 
				 		$Hold['MotheradmittedPersonSign']         = $mothAdmision['admittedPersonSign']; 
				 		$Hold['MotherreferredFacilityName']       = $mothAdmision['referredFacilityName']; 
				 		$Hold['MotherreferredFacilityAddress']    = $mothAdmision['referredFacilityAddress']; 
				 		$Hold['MothertypeOfDischarge']            = $mothAdmision['typeOfDischarge']; 
				 		$Hold['MotherreferredReason']             = $mothAdmision['referredReason']; 
				 		$Hold['MotherdischargeByDoctor']          = $mothAdmision['dischargeByDoctor']; 
				 		$Hold['MotherdischargeByNurse']           = $mothAdmision['dischargeByNurse']; 
				 		$Hold['Mothertransportation']             = $mothAdmision['transportation']; 
				 		$Hold['MothersignOfFamilyMember']         = $mothAdmision['signOfFamilyMember']; 
				 		$Hold['MotherDischargeChecklist']         = $mothAdmision['DischargeChecklist']; 
				 		$Hold['MotherDateOfFollowUpVisit']        = $mothAdmision['DateOfFollowUpVisit']; 
				 		$Hold['MotherdoctorSign']                 = $mothAdmision['doctorSign']; 
				 		$Hold['MotherdateOfDischarge']             = $mothAdmision['dateOfDischarge']; 
				 		$Hold['MotherashaSign']                   = $mothAdmision['ashaSign']; 

				 		$Hold['MotherreferralIndication']         		= $mothAdmision['referralIndication']; 
				 		$Hold['MothertreatmentOxygen']             		= $mothAdmision['treatmentOxygen']; 
				 		$Hold['MothertreatmentOxygenDuration']        	= $mothAdmision['treatmentOxygenDuration']; 
				 		$Hold['MothertreatmentPhototherapy']          	= $mothAdmision['treatmentPhototherapy']; 
				 		$Hold['MothertreatmentPhototherapyDuration']    = $mothAdmision['treatmentPhototherapyDuration']; 
				 		$Hold['MothertreatmentStepDown']         		= $mothAdmision['treatmentStepDown']; 
				 		$Hold['MothertreatmentStepDownDuration']      	= $mothAdmision['treatmentStepDownDuration']; 
				 		$Hold['MothertreatmentKMC']        				= $mothAdmision['treatmentKMC']; 
				 		$Hold['MothertreatmentKMCDuration']           	= $mothAdmision['treatmentKMCDuration']; 
				 		$Hold['MothertreatmentAntibiotics']           	= $mothAdmision['treatmentAntibiotics']; 
				 		$Hold['MothertreatmentAntibioticsDetails']    	= $mothAdmision['treatmentAntibioticsDetails']; 
				 		$Hold['MotheradditionalTreatment']      		= $mothAdmision['additionalTreatment']; 
				 		$Hold['MothercourseDuringTreatment']        	= $mothAdmision['courseDuringTreatment']; 
				 		$Hold['MotherrelevantInvestigation']         	= $mothAdmision['relevantInvestigation']; 
				 		$Hold['Mothercondition']           				= $mothAdmision['condition']; 
				 		$Hold['MotherriCard']    						= $mothAdmision['riCard']; 
				 		$Hold['MotherBCG']        						= $mothAdmision['BCG']; 
				 		$Hold['MotherOPV']          					= $mothAdmision['OPV']; 
				 		$Hold['MotherhepatitisB']           			= $mothAdmision['hepatitisB']; 
				 		$Hold['MothertreatmentAdvised']    				= $mothAdmision['treatmentAdvised']; 

				 		
				 		$arrayName[] = $Hold;
				 	
			 	}

	 	
			}
					
		$response['data'] = $arrayName;
	 	$response['md5Data'] = md5(json_encode($response['data']));
	 	(count($response['data']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
	}


	public function SaveDischarge($request){

		$this->db->order_by('id','desc');
		$babyAdmission = $this->db->get_where('babyAdmission',array('babyId'=>$request['babyId']))->row_array();

		$signOfNurse  		= (isset($request['signOfNurse']) && $request['signOfNurse']!='') ? saveImage($request['signOfNurse'],signDirectory) :NULL;
		$babyHandoverImage  = (isset($request['babyHandoverImage']) && $request['babyHandoverImage']!='') ? saveImage($request['babyHandoverImage'],babyDirectory) :NULL;
		$guardianIdImage  	= (isset($request['babyHandoverImage']) && $request['guardianIdImage']!='') ? saveImage($request['guardianIdImage'],babyDirectory) :NULL;
		$sehmatiPatr  	= (isset($request['sehmatiPatr']) && $request['sehmatiPatr']!='') ? saveImage($request['sehmatiPatr'],babyDirectory) :NULL;

		$arrayName  = array();
			$arrayName['trainForKMCAtHome'] = (isset($request['trainForKMCAtHome']) && $request['trainForKMCAtHome'] != '') ? $request['trainForKMCAtHome'] : NULL;

			$arrayName['bodyHandover'] = (isset($request['bodyHandover']) && $request['bodyHandover'] != '') ? $request['bodyHandover'] : NULL;
                   
			$arrayName['infantometerAvailability'] 	= (isset($request['infantometerAvailability']) && $request['infantometerAvailability'] != '') ? $request['infantometerAvailability'] : NULL;

			$arrayName['babyLength'] = (isset($request['babyLength']) && $request['babyLength'] != '') ? $request['babyLength'] : NULL;
			$arrayName['measuringTapeAvailability'] 	= (isset($request['measuringTapeAvailability']) && $request['measuringTapeAvailability'] != '') ? $request['measuringTapeAvailability'] : NULL;
			$arrayName['headCircumference'] = (isset($request['headCircumference']) && $request['headCircumference'] != '') ? $request['headCircumference'] : NULL;
			

			$arrayName['dischargeNotes']     	= (isset($request['dischargeNotes']) && $request['dischargeNotes'] != '') ? $request['dischargeNotes'] : NULL;
			$arrayName['attendantName']     	= (isset($request['attendantName']) && $request['attendantName'] != '') ? $request['attendantName'] : NULL;
			$arrayName['relationWithInfant']    = (isset($request['relationWithInfant']) && $request['relationWithInfant'] != '') ? $request['relationWithInfant'] : NULL;
			$arrayName['otherRelation']     	= (isset($request['otherRelation']) && $request['otherRelation'] != '') ? $request['otherRelation'] : NULL;
			$arrayName['dischargeByDoctor']     = (isset($request['dischargeByDoctor']) && $request['dischargeByDoctor'] != '') ? $request['dischargeByDoctor'] : NULL;

			$arrayName['dischargeByNurse']    	= (isset($request['dischargeByNurse']) && $request['dischargeByNurse'] != '') ? $request['dischargeByNurse'] : NULL;
			$arrayName['transportation']     	= (isset($request['transportation']) && $request['transportation'] != '') ? $request['transportation'] : NULL;
			$arrayName['typeOfDischarge']     	= (isset($request['typeOfDischarge']) && $request['typeOfDischarge'] != '') ? $request['typeOfDischarge'] : NULL;
			
			$arrayName['nurseDischargeSign'] 		 	= $signOfNurse;
			// $arrayName['DischargeChecklist'] = $request['DischargeChecklist'];

			$arrayName['dateOfDischarge']	  	= date('Y-m-d H:i:s');
			// $arrayName['DateOFFollowUpVisit'] = ($request['DateOFFollowUpVisit']!='')? date('Y-m-d',strtotime($request['DateOFFollowUpVisit'])): date('Y-m-d');
			

			/***** new added fields   *****/

			$arrayName['guardianName'] 			= (isset($request['guardianName']) && $request['guardianName'] != '') ? $request['guardianName'] : NULL;
			$arrayName['babyHandoverImage'] 	= $babyHandoverImage;
			$arrayName['guardianIdImage']  		= $guardianIdImage;
			$arrayName['dischargeReferredDistrict']   	= (isset($request['referredDistrict']) && $request['referredDistrict'] != '') ? $request['referredDistrict'] : NULL;

			$arrayName['dischargeReferredFacility']  = (isset($request['referredFacility']) && $request['referredFacility'] != '') ? $request['referredFacility'] : NULL;

			$arrayName['referredUnit'] 			= (isset($request['referredUnit']) && $request['referredUnit'] != '') ? $request['referredUnit'] : NULL;
			$arrayName['referredReason']		= (isset($request['referredReason']) && $request['referredReason'] != '') ? $request['referredReason'] : NULL;

			$arrayName['referralNotes'] 		= (isset($request['referralNotes']) && $request['referralNotes'] != '') ? $request['referralNotes'] : NULL;
			$arrayName['sehmatiPatr'] 	 		= $sehmatiPatr;
			$arrayName['earlyDishargeReason']  	= (isset($request['earlyDishargeReason']) && $request['earlyDishargeReason'] != '') ? $request['earlyDishargeReason'] : NULL;

			$arrayName['isAbsconded']     		= (isset($request['isAbsconded']) && $request['isAbsconded'] != '') ? $request['isAbsconded'] : NULL;
			$arrayName['status']           		= '2';

			$arrayName['lengthMeasureNotAvlReasonDischarge']    		= (isset($request['lengthMeasureNotAvlReasonDischarge']) && $request['lengthMeasureNotAvlReasonDischarge'] != '') ? $request['lengthMeasureNotAvlReasonDischarge'] : NULL;
			$arrayName['lengthMeasureNotAvlReasonOtherDischarge']    	= (isset($request['lengthMeasureNotAvlReasonOtherDischarge']) && $request['lengthMeasureNotAvlReasonOtherDischarge'] != '') ? $request['lengthMeasureNotAvlReasonOtherDischarge'] : NULL;
			$arrayName['headMeasureNotAvlReasonDischarge']    			= (isset($request['headMeasureNotAvlReasonDischarge']) && $request['headMeasureNotAvlReasonDischarge'] != '') ? $request['headMeasureNotAvlReasonDischarge'] : NULL;
			$arrayName['headMeasureNotAvlReasonOtherDischarge']    		= (isset($request['headMeasureNotAvlReasonOtherDischarge']) && $request['headMeasureNotAvlReasonOtherDischarge'] != '') ? $request['headMeasureNotAvlReasonOtherDischarge'] : NULL;

			$arrayName['isMotherDischarge']           		= (isset($request['isMotherDischarge']) && $request['isMotherDischarge'] != '') ? $request['isMotherDischarge'] : NULL;
			
			$this->db->where(array('id'=>$babyAdmission['id']));
			$this->db->update('babyAdmission', $arrayName);

			/***** new added fields   *****/		
			
			/*$arrayName['modifyDate'] = time();	*/
            // type 1 for mother discharge
			if($request['isMotherDischarge'] == 'Yes') {
			
				$getStatus = $this->db->get_where('babyRegistration',array('babyId'=>$request['babyId']))->row_array();

				$this->db->order_by('id','desc');
				$motherAdmission = $this->db->get_where('motherAdmission',array('motherId'=>$getStatus['motherId']))->row_array();

				$arrayName2  = array();
				$arrayName2['status'] = '2';
				$arrayName2['typeOfDischarge']     	= (isset($request['typeOfDischarge']) && $request['typeOfDischarge'] != '') ? $request['typeOfDischarge'] : NULL;
				$arrayName2['modifyDate'] 			= date('Y-m-d H:i:s');
				$arrayName2['dateOfDischarge'] 		= date('Y-m-d H:i:s');
				$arrayName2['dischargeByDoctor']    = (isset($request['dischargeByDoctor']) && $request['dischargeByDoctor'] != '') ? $request['dischargeByDoctor'] : NULL;
				$arrayName2['dischargeByNurse']    	= (isset($request['dischargeByNurse']) && $request['dischargeByNurse'] != '') ? $request['dischargeByNurse'] : NULL;
				$arrayName2['trainForKMCAtHome'] 	= (isset($request['trainForKMCAtHome']) && $request['trainForKMCAtHome'] != '') ? $request['trainForKMCAtHome'] : NULL;
				$arrayName2['dischargeNotes']     	= (isset($request['dischargeNotes']) && $request['dischargeNotes'] != '') ? $request['dischargeNotes'] : NULL;
				$arrayName2['transportation']     	= (isset($request['transportation']) && $request['transportation'] != '') ? $request['transportation'] : NULL;
				$arrayName2['nurseDischargeSign'] 	= $signOfNurse;

				$mothersehmatiPatr  	= (isset($request['sehmatiPatr']) && $request['sehmatiPatr']!='') ? saveImage($request['sehmatiPatr'],motherDirectory) :NULL;
				$arrayName2['sehmatiPatr'] 	 		= $mothersehmatiPatr;

				$arrayName2['dischargeReferredDistrict']   	= (isset($request['referredDistrict']) && $request['referredDistrict'] != '') ? $request['referredDistrict'] : NULL;

				$arrayName2['dischargeReferredFacility']  = (isset($request['referredFacility']) && $request['referredFacility'] != '') ? $request['referredFacility'] : NULL;
				$arrayName2['guardianName'] 			= (isset($request['guardianName']) && $request['guardianName'] != '') ? $request['guardianName'] : NULL;

				$this->db->where(array('id'=>$motherAdmission['id']));
				$this->db->update('motherAdmission', $arrayName2);

			} 

			// generate pdf
			// $admissionPdf = $this->BabyAdmissionPDF->pdfGenerate($babyAdmission['id']);
			// $weightPdf = $this->BabyWeightPDF->WeightpdfGenerate($babyAdmission['id']);
			// $kmcPdf = $this->BabyKmcPDF->KMCpdfGenerate($babyAdmission['id']);
			// $feedingPdf = $this->BabyFeedingPDF->FeedingpdfGenerate($babyAdmission['id']);
			// $dischargePdf = $this->BabyDischargePdf->FinalpdfGenerate($babyAdmission['id']);

			return 1;
	}


	public function SaveMotherDischarge($request){

		$this->db->order_by('id','desc');
		$motherAdmission = $this->db->get_where('motherAdmission',array('motherId'=>$request['motherId']))->row_array();

		$signOfNurse  		= (isset($request['signOfNurse']) && $request['signOfNurse']!='') ? saveImage($request['signOfNurse'],signDirectory) :NULL;
		$sehmatiPatr  	= (isset($request['sehmatiPatr']) && $request['sehmatiPatr']!='') ? saveImage($request['sehmatiPatr'],motherDirectory) :NULL;

		$arrayName  = array();
		
		$arrayName['trainForKMCAtHome']    	= (isset($request['trainForKMCAtHome']) && $request['trainForKMCAtHome'] != '') ? $request['trainForKMCAtHome'] : NULL;
		$arrayName['bodyHandover']    		= (isset($request['bodyHandover']) && $request['bodyHandover'] != '') ? $request['bodyHandover'] : NULL;
		$arrayName['dischargeNotes']     	= (isset($request['dischargeNotes']) && $request['dischargeNotes'] != '') ? $request['dischargeNotes'] : NULL;
		$arrayName['attendantName']     	= (isset($request['attendantName']) && $request['attendantName'] != '') ? $request['attendantName'] : NULL;
		$arrayName['relationWithMother']    = (isset($request['relationWithMother']) && $request['relationWithMother'] != '') ? $request['relationWithMother'] : NULL;
		$arrayName['otherRelation']     	= (isset($request['otherRelation']) && $request['otherRelation'] != '') ? $request['otherRelation'] : NULL;
		$arrayName['dischargeByDoctor']     = (isset($request['dischargeByDoctor']) && $request['dischargeByDoctor'] != '') ? $request['dischargeByDoctor'] : NULL;

		$arrayName['dischargeByNurse']    	= (isset($request['dischargeByNurse']) && $request['dischargeByNurse'] != '') ? $request['dischargeByNurse'] : NULL;
		$arrayName['transportation']     	= (isset($request['transportation']) && $request['transportation'] != '') ? $request['transportation'] : NULL;
		$arrayName['typeOfDischarge']     	= (isset($request['typeOfDischarge']) && $request['typeOfDischarge'] != '') ? $request['typeOfDischarge'] : NULL;
		
		$arrayName['nurseDischargeSign'] 		 	= $signOfNurse;
		// $arrayName['DischargeChecklist'] = $request['DischargeChecklist'];

		$arrayName['dateOfDischarge']	  	= date('Y-m-d H:i:s');
		// $arrayName['DateOFFollowUpVisit'] = ($request['DateOFFollowUpVisit']!='')? date('Y-m-d',strtotime($request['DateOFFollowUpVisit'])): date('Y-m-d');
			

		/***** new added fields   *****/

		$arrayName['guardianName'] 			= (isset($request['guardianName']) && $request['guardianName'] != '') ? $request['guardianName'] : NULL;
			
		$arrayName['dischargeReferredDistrict']   	= (isset($request['referredDistrict']) && $request['referredDistrict'] != '') ? $request['referredDistrict'] : NULL;

		$arrayName['dischargeReferredFacility']  = (isset($request['referredFacility']) && $request['referredFacility'] != '') ? $request['referredFacility'] : NULL;

		$arrayName['referredUnit'] 			= (isset($request['referredUnit']) && $request['referredUnit'] != '') ? $request['referredUnit'] : NULL;
		$arrayName['referredReason']		= (isset($request['referredReason']) && $request['referredReason'] != '') ? $request['referredReason'] : NULL;

		$arrayName['referralNotes'] 		= (isset($request['referralNotes']) && $request['referralNotes'] != '') ? $request['referralNotes'] : NULL;
		
		$arrayName['earlyDishargeReason']  	= (isset($request['earlyDishargeReason']) && $request['earlyDishargeReason'] != '') ? $request['earlyDishargeReason'] : NULL;

		$arrayName['isAbsconded']     		= (isset($request['isAbsconded']) && $request['isAbsconded'] != '') ? $request['isAbsconded'] : NULL;
		$arrayName['status']           		= '2';
		$arrayName['sehmatiPatr'] 	 		= $sehmatiPatr;
			
		$this->db->where(array('id'=>$motherAdmission['id']));
		$this->db->update('motherAdmission', $arrayName);

		/***** new added fields   *****/		
			
			

		return 1;
	}

}