<?php
class Mother_baby_admission_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	}
	public function CheckHospitalRegNo($HospitalReg, $ID='')
	{
		if($ID!=''){
			return $this->db->get_where('mother_admission', array('HospitalRegistrationNumber'=>$HospitalReg, 'MotherID !='=>$ID))->num_rows();
		}else{
	 		return $this->db->get_where('mother_admission', array('HospitalRegistrationNumber'=>$HospitalReg))->num_rows();
		}
	}

	public function MotherAdmin($request)
	{
       #+++++++++   check Hospipal Reg No. Existing Value  +++++++++++++++
	 $this->db->order_by('id','desc');
     $checkMotherAdmitSameLounge = $this->db->get_where('mother_admission',array('status'=>2,'MotherID'=>$request['MotherID']))->num_rows();
      if($checkMotherAdmitSameLounge == '0' && $request['Type'] == '3'){
	       $hospital_reg_no = $this->CheckHospitalRegNo($request['HospitalRegistrationNumber']);
	       if($hospital_reg_no==1 && $request['Type']=='3'){
	       	 generateServerResponse('0','136');
	        }	
	     }	

		$mother            = array();
		$baby              = array();
		$baby_monitor      = array();

		$ImageOfAdmittedPersonSign = ($request['AdmittedPersonSign']!='') ? saveProfilesImage2($request['AdmittedPersonSign'],IMAGE_DIRECTORY) :'';
		$PadPicture = ($request['PadPicture']!='') ? saveProfilesImage2($request['PadPicture'],IMAGE_DIRECTORY) :'';
		
		
			
			$mother['MotherID'] 		= ($request['MotherID']!='')? $request['MotherID'] : NULL;
			$mother['LoungeID'] 		= ($request['LoungeID']!='')? $request['LoungeID'] : NULL;
            $mother['HospitalRegistrationNumber'] 	= ($request['HospitalRegistrationNumber']!='')?$request['HospitalRegistrationNumber']: NULL;
			$mother['add_date']    				= time();
			$mother['modify_date'] 				= time();

			if($request['Type']=='3'){
				$mother_addmission = $this->db->insert('mother_admission',$mother);			
				$MotherInsertedId = $this->db->insert_id();
            }



       //get last mother AdmissionId

     	$this->db->order_by('id','desc');
        $motherAdmisionLastId =  $this->db->get_where('mother_admission',array('MotherID'=>$request['MotherID']))->row_array();

        $motherAdmission['mother_admissionID']  = ($motherAdmisionLastId['id'] != '') ? $motherAdmisionLastId['id'] : NULL;


			$motherAdmission['MotherID'] 		= ($request['MotherID']!='') ? $request['MotherID'] :NULL;
			$motherAdmission['LoungeID'] 		= ($request['LoungeID']!='') ? $request['LoungeID']:NULL;
			$motherAdmission['MotherTemperature']   = ($request['MotherTemperature']!='') ? $request['MotherTemperature'] :NULL;


			$motherAdmission['MotherSystolicBP'] 	= ($request['MotherSystolicBP']!='')  ? $request['MotherSystolicBP'] : NULL;
			$motherAdmission['MotherDiastolicBP']	= ($request['MotherDiastolicBP']!='') ? $request['MotherDiastolicBP'] : NULL;
			$motherAdmission['MotherUterineTone']	= ($request['MotherUterineTone']!='') ? $request['MotherUterineTone'] : NULL;
			$motherAdmission['MotherPulse'] 	= ($request['MotherPulse']!='') ?$request['MotherPulse'] : NULL;
			$motherAdmission['MotherUrinationAfterDelivery']= ($request['MotherUrinationAfterDelivery']!='')? $request['MotherUrinationAfterDelivery']: NULL;
			$motherAdmission['EpisitomyCondition']	= ($request['EpisitomyCondition']!='')? $request['EpisitomyCondition']: NULL;

			$motherAdmission['SanitoryPadStatus'] 	= ($request['SanitoryPadStatus']!='')? $request['SanitoryPadStatus']: NULL;
			$motherAdmission['IsSanitoryPadStink']	= ($request['IsSanitoryPadStink']!='')? $request['IsSanitoryPadStink']: NULL;

			$motherAdmission['Other'] 		= ($request['Other']!='') ? $request['Other']: NULL;
			$motherAdmission['PadPicture'] 		= ($PadPicture!='') ? $PadPicture: NULL;
			$motherAdmission['Type'] 		=  $request['Type'] ;
			$motherAdmission['add_date'] 				= time() ;
			$motherAdmission['modify_date'] 			= time();
			
			$motherAdmission['AssesmentDate'] 			= date('Y-m-d');    
			$motherAdmission['AssesmentNumber'] 		        = 1;	
			$motherAdmission['AssesmentTime'] 			= date('H:i');

			$mother_addmission = $this->db->insert('mother_monitoring',$motherAdmission);
			$mother_id['mother_id'] = $this->db->insert_id();
			return $mother_id;
		
	}




	public function BabyAdmin($request)
	{
		$baby   = array();
		$baby_monitor  = array();
		if($request['type'] == '1')        //type = 1 - Do 1 entry in baby admission table.Used for readmission of baby 
		{
			$baby['BabyID']  			= ($request['BabyID']!='')? $request['BabyID'] : NULL ;
			$baby['AdmissionDateTime']  = time();
			$baby['LoungeID']			= ($request['LoungeID']!='')? $request['LoungeID']: NULL;
			$baby['BabyFileID']			= ($request['baby_file_id']!='')? $request['baby_file_id']: NULL;
			$baby['BabyAdmissionWeight']= ($request['BabyAdmissionWeight']!='') ? $request['BabyAdmissionWeight'] : NULL;
			$baby['add_date']		    = time();
			$baby['status']			    = '1';
			$baby['modify_date']		= time();

			$BadyAdmission  = $this->db->insert('baby_admission',$baby);
			$BabyinsertedId = $this->db->insert_id();
        }
         else {
         	$this->db->order_by('id','desc');
            $babyAdmisionLastId =  $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID']))->row_array();
            $this->db->where('id',$babyAdmisionLastId['id']);
            $this->db->update('baby_admission',array('BabyAdmissionWeight'=>$request['BabyAdmissionWeight']));
           }

		$baby_monitor['BabyID']  	= ($request['BabyID']!='')   ? $request['BabyID'] : NULL ;
		$baby_monitor['LoungeID']	= ($request['LoungeID']!='') ? $request['LoungeID']: NULL;
		$baby_monitor['BabyRespiratoryRate']  	= ($request['BabyRespiratoryRate']!='') ? $request['BabyRespiratoryRate']: NULL;
		$baby_monitor['BabyOtherDangerSign']  	= ($request['BabyOtherDangerSign']!='') ? $request['BabyOtherDangerSign']: NULL; 
		$baby_monitor['BabyPulseSpO2']  = ($request['BabyPulseSpO2']!='')? $request['BabyPulseSpO2'] : NULL;
		$baby_monitor['BabyPulseRate']  = ($request['BabyPulseRate']!='') ? $request['BabyPulseRate'] : NULL ;
		$baby_monitor['BabyTemperature']= ($request['BabyTemperature']!='')? $request['BabyTemperature']: NULL;
		$baby_monitor['BabyMeasuredWeight']	= ($request['BabyAdmissionWeight']!='') ? $request['BabyAdmissionWeight']: NULL;

		$baby_monitor['MotherBreastCondition']  = ($request['MotherBreastCondition']!='') ? $request['MotherBreastCondition']: NULL;
		$baby_monitor['MotherBreastPain']  = ($request['MotherBreastPain']!='') ? $request['MotherBreastPain']: NULL;
		$baby_monitor['MotherBreastStatus']  = ($request['MotherBreastStatus']!='') ? $request['MotherBreastStatus'] : NULL ;
		$baby_monitor['BabyMilkConsumption1']	= ($request['BabyMilkConsumption1']!='') ? $request['BabyMilkConsumption1']: NULL;
		$baby_monitor['BabyMilkConsumption2']	= ($request['BabyMilkConsumption2']!='') ? $request['BabyMilkConsumption2']: NULL;
		$baby_monitor['BabyMilkConsumption3']	= ($request['BabyMilkConsumption3']!='') ? $request['BabyMilkConsumption3']: NULL;;
		$baby_monitor['Other']	= ($request['Other']!='') ? $request['Other']:NULL;

		$baby_monitor['BabyHeadCircumference']  = ($request['BabyHeadCircumference']!='') ? $request['BabyHeadCircumference']: NULL ;
		$baby_monitor['SkinColor']  = ($request['SkinColor']!='')? $request['SkinColor']: NULL;

		$baby_monitor['BabyHavePustulesOrBoils']  = ($request['BabyHavePustulesOrBoils']!='') ? $request['BabyHavePustulesOrBoils']: NULL;
		$baby_monitor['LocationOfPusrulesOrBoils']= ($request['LocationOfPusrulesOrBoils']!='') ?  $request['LocationOfPusrulesOrBoils']: NULL;

		$baby_monitor['SizeOfPusrulesOrBoils']  = ($request['SizeOfPusrulesOrBoils']!='') ? $request['SizeOfPusrulesOrBoils'] : NULL;
		$baby_monitor['NumberOfPusrulesOrBoils'] = ($request['NumberOfPusrulesOrBoils']!='') ? $request['NumberOfPusrulesOrBoils']: NULL;
		$baby_monitor['IsPulseOximatoryDeviceAvailable']= ($request['IsPulseOximatoryDeviceAvailable']!='')? $request['IsPulseOximatoryDeviceAvailable']: NULL;

		$baby_monitor['StaffID']  				= ($request['StaffID']!='')? $request['StaffID']: NULL;
		$baby_monitor['add_date']			    = time();
		$baby_monitor['status']			    	= '1';
		$baby_monitor['modify_date']			= time();
		$baby_monitor['AssesmentDate'] 			= date('Y-m-d');    
		$baby_monitor['AssesmentNumber'] 		= 1;	
		$baby_monitor['AssesmentTime'] 			= date('H:i');  

//get last Baby AdmissionId

     	$this->db->order_by('id','desc');
        $babyAdmisionLastId =  $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID']))->row_array();

        $baby_monitor['baby_admissionID']  	= ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;


		$BabyMonitoring =  $this->db->insert('baby_monitoring',$baby_monitor);
		$Baby_id['baby_id'] =$this->db->insert_id();

		if($BabyMonitoring > 0){

		 	$fileName = "b_".$babyAdmisionLastId['id'].".pdf";
		 	$GetMotherId = singlerowparameter2('MotherID','BabyID',$request['BabyID'],'baby_registration');


			$PdfFile = $this->pdfconventer($fileName,$babyAdmisionLastId['id']);

 			$this->db->where('id',$babyAdmisionLastId['id']);
 			$this->db->update('baby_admission', array('BabyPDFFileName'=>$PdfFile));
		}
		
		$mothername  = $this->db->query("SELECT MR.`MotherID`, MR.`MotherName`, BA.`BabyID` FROM  baby_registration AS BA LEFT JOIN  mother_registration AS MR  On BA.`MotherID` = MR.`MotherID`  where  BA.`BabyID` ='".$request['BabyID']."'")->row_array();
		$LoungeName  = singlerowparameter2('LoungeName','LoungeID',$request['LoungeID'],'lounge_master'); 
		

		
		$status1 = '0';
		$status2 = '0';
		$status3 = '0';
		if($BabyMonitoring > 0){
			if($request['BabyRespiratoryRate']>60 || $request['BabyRespiratoryRate']<30){
        		$status1 = '1';
        	}
        	if($request['BabyTemperature'] < 95.9 || $request['BabyTemperature'] > 99.5){
        		$status2 = '1';
        	}
        	if($request['BabyPulseSpO2'] < 95){
        		$status3 = '1';
        	}			        	
    		if($status1 == 1 || $status2 == 1 || $status3 == 1)
    		{ 

    			$getNumbers = $this->db->query("SELECT SM.`StaffMoblieNo`, SM.`staff_sub_type`, LM.`FacilityID`, SM.`staff_sub_type` FROM lounge_master as LM LEFT JOIN staff_master as SM  On LM.`FacilityID` = SM.`FacilityID` WHERE SM.`staff_sub_type`= 9  OR SM.`staff_sub_type`= 30 AND  LM.`LoungeID`= '".$request['LoungeID']."'  ")->result_array();
    			
    			//echo count($getNumbers);  
					$message="B/O ".$mothername['MotherName']." from ".$LoungeName."  lounge is  danger,  Respiratory Rate   ".$request['BabyRespiratoryRate']." , Temperature  ".$request['BabyTemperature'].", SpO2 ".$request['BabyPulseSpO2'].". Kindly Assist";
					/*echo  count($getNumbers); exit;*/
        		foreach ($getNumbers as $key => $value) {
        			if($value['StaffMoblieNo']!='' && strlen($value['StaffMoblieNo'])==10){

             // send text message
                        sendMobileMessage($value['StaffMoblieNo'],$message);
					    $insertSms = array(); 
					    $insertSms['FacilityID'] = $value['FacilityID'];
				            $insertSms['Messege'] 	 = $message;
				            $insertSms['BabyID'] 	 = $request['BabyID'];
				            $insertSms['SendTo'] 	 = $value['StaffMoblieNo'];
				            $insertSms['Time'] 		 = date('H:i:00');
				            $insertSms['Date'] 		 = date('Y-m-d');
				            $insertSms['AddDate']    = time();
				            $this->db->insert('smsmaster',$insertSms);
        			}
        		}

        	}

	}
		
		

		
                $this->db->order_by('id','desc');
				$babyAdmisionLastId =  $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID']))->row_array();
		############# ENTRY OF BABAY WEIGTH IN baby_weight_master Table #################
			$baby_weigth = array();
			$baby_weigth['BabyID'] 	 	= $request['BabyID'];
			$baby_weigth['LoungeID'] 	= $request['LoungeID'];
			$baby_weigth['baby_admissionID'] 	= $babyAdmisionLastId['id'];
			$baby_weigth['BabyWeight']  = $request['BabyAdmissionWeight'];
			$baby_weigth['NurseId']  = ($request['StaffID']!='')? $request['StaffID']: NULL;;			                        
			$baby_weigth['WeightDate']  = date('Y-m-d');
			$baby_weigth['AddDate'] 	= time();
			$this->db->insert('baby_weight_master',$baby_weigth);

		############# ENTRY OF BABAY WEIGTH IN baby_weight_master Table #################

				
				$PdfName = $this->BabyWeightPdfFile($request['LoungeID'],$babyAdmisionLastId['id']);

				$this->db->where('id',$babyAdmisionLastId['id']);
				$this->db->update('baby_admission',array('BabyWeightPdfName'=>$PdfName));


		return $Baby_id;
		
	}


	public function GetMotherAllData($MotherID)
	{
		return $this->db->query("SELECT * FROM mother_registration AS MR LEFT JOIN mother_admission AS MA ON MR.`MotherID` = MA.`MotherID`  WHERE MR.`MotherID` = '".$MotherID."'")->row_array();
	}

	public function GetBabyAllData($BabyID)
	{   
		return $this->db->query("SELECT *,BA.`add_date` as AddDate FROM  baby_registration AS BR LEFT JOIN baby_admission AS BA ON BR.`BabyID` = BA.`BabyID`  WHERE BR.`BabyID` = '".$BabyID."' order by BA.`id` desc")->row_array();
	      // echo $this->db->last_query();exit;
	}



	public function BabyMonitoringDischargeTime($request)
	{
		
		$getCount = $this->db->query("SELECT * FROM baby_monitoring where LoungeID ='".$request['LoungeID']."' And BabyID ='".$request['BabyID']."' ")->num_rows();
		$baby   = array();
		$baby_monitor  = array();

		$baby_monitor['BabyID']  				= $request['BabyID'];
		$baby_monitor['LoungeID']			    = $request['LoungeID'];
		$baby_monitor['BabyRespiratoryRate']  	= $request['BabyRespiratoryRate'];
		$baby_monitor['BabyOtherDangerSign']  	= $request['BabyOtherDangerSign'];
		$baby_monitor['BabyPulseSpO2']  		= $request['BabyPulseSpO2'];
		$baby_monitor['BabyPulseRate']			= $request['BabyPulseRate'];
		$baby_monitor['BabyTemperature']		= $request['BabyTemperature'];
		$baby_monitor['BabyMeasuredWeight']		= $request['BabyAdmissionWeight'];

		$baby_monitor['MotherBreastCondition']  = $request['MotherBreastCondition'];
		$baby_monitor['MotherBreastPain']  		= $request['MotherBreastPain'];
		$baby_monitor['MotherBreastStatus']  	= $request['MotherBreastStatus'];
		$baby_monitor['BabyMilkConsumption1']	= $request['BabyMilkConsumption1'];
		$baby_monitor['BabyMilkConsumption2']	= $request['BabyMilkConsumption2'];
		$baby_monitor['BabyMilkConsumption3']	= $request['BabyMilkConsumption3'];
		$baby_monitor['Other']				    = $request['Other'];
		$baby_monitor['BabyHeadCircumference']	= $request['BabyHeadCircumference'];		
		$baby_monitor['UrinationAfterLastAssesment'] = $request['UrinationAfterLastAssesment'];
		$baby_monitor['StoolAfterLastAssesment']	= $request['StoolAfterLastAssesment'];
		$baby_monitor['IsPulseOximatoryDeviceAvailable']= $request['IsPulseOximatoryDeviceAvailable'];
		$baby_monitor['SkinColor']		= $request['SkinColor'];		
		$baby_monitor['AssesmentNumber']		= $getCount + 1;
		$baby_monitor['StaffID']  				= $request['StaffID'];
		$baby_monitor['Type']  					= $request['Type'];
		$baby_monitor['add_date']			    = time();
		$baby_monitor['status']			    	= '2';
		$baby_monitor['modify_date']			= time();

      //get last Baby AdmissionId
     	$this->db->order_by('id','desc');
        $babyAdmisionLastId =  $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID']))->row_array();
		$baby_monitor['baby_admissionID']    = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;



		$BabyMonitoring =  $this->db->insert('baby_monitoring',$baby_monitor);
		$Baby_id['baby_assess_id'] =$this->db->insert_id();


			 $GetNoticfictaionEntry = $this->db->query("SELECT * From notification where  LoungeID = '".$request['LoungeID']."'  AND  BabyID = '".$request['BabyID']."' AND Status = '1' AND TypeOfNotification='2' order by ID desc limit 0, 1")->result_array();

			 $GetNoticfictaionEntry1 = $this->db->query("SELECT * From notification where  LoungeID = '".$request['LoungeID']."'  AND  BabyID = '".$request['BabyID']."' AND Status = '1' AND TypeOfNotification='2' order by ID desc limit 0, 1")->row_array();	                

			 $settingDetail =  allData2('settings','id','1');
           			$secondMonitoring     = $settingDetail['BabyMointoringSecondTime'];  
			        $secondTiming         = date('Y-m-d '.$secondMonitoring.':00:00');
			        $secondMonitoringTime = strtotime($secondTiming);

			        $secondEnddate       = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$secondMonitoringTime)));
			        $secondEndTiming     = strtotime($secondEnddate);

			        $thirdMonitoing      = $settingDetail['BabyMointoringThirdTime'];  
			        $thirdTiming         = date('Y-m-d '.$thirdMonitoing.':00:00');
			        $thirdMonitoringTime = strtotime($thirdTiming);

			        $thirdEndDate      = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$thirdMonitoringTime)));
			        $thirdEndTiming    = strtotime($thirdEndDate);			        

			        $fourthMonitoring     = $settingDetail['BabyMointoringFourthTime'];  
			        $fourthTiming         = date('Y-m-d '.$fourthMonitoring.':00:00');
			        $fourthMonitoringTime = strtotime($fourthTiming);

			        $fourthEndDate       = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$fourthMonitoringTime)));
			        $fourthEndTime       = strtotime($fourthEndDate);				        

			        $curDateTime          = time();		        
		        
                   if($settingDetail > 0)
                   {
			        $firstMonitoring    = $settingDetail['BabyMointoringOneTime'];  
			        $firstTiming        = date('Y-m-d '.$firstMonitoring.':00:00');

			        $firstMonitoringTime = strtotime($firstTiming);
			        $firstEnddate        = date('Y-m-d H:i:s',strtotime('+ 3 hours'.date('Y-m-d H:i:s',$firstMonitoringTime)));
			        $firstEndTiming      = strtotime($firstEnddate);
					
						if($firstMonitoringTime <= $curDateTime && $firstEndTiming > $curDateTime)
						 { 
                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('ID', $GetNoticfictaionEntry1['ID']);
								$this->db->update('notification',array('Status'=>'2','ModifyDate'=>$curDateTime));                              	 
                           }

						 }else if($secondMonitoringTime <= $curDateTime && $secondEndTiming > $curDateTime)
						 {

                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('ID', $GetNoticfictaionEntry1['ID']);
								$this->db->update('notification',array('Status'=>'2','ModifyDate'=>$curDateTime));                              	 
                           }						 	
						 }else if($thirdMonitoringTime <= $curDateTime && $thirdEndTiming > $curDateTime)
						 {
                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('ID', $GetNoticfictaionEntry1['ID']);
								$this->db->update('notification',array('Status'=>'2','ModifyDate'=>$curDateTime));                              	 
                           }						 	
						 }else if($fourthMonitoringTime <= $curDateTime && $fourthEndTime > $curDateTime)
						 {
                           if(count($GetNoticfictaionEntry)==1){
								$this->db->where('ID', $GetNoticfictaionEntry1['ID']);
								$this->db->update('notification',array('Status'=>'2','ModifyDate'=>$curDateTime));                              	 
                           }						 	
						 }			

                     } 

		return $Baby_id;
		
	}


	public function BabyWeightPdfFile($LoungeID,$id,$type='')
    {

        error_reporting(0);

        $getBabyFileId = $this->db->get_where('baby_admission',array('id'=>$id))->row_array();

        /*echo $LoungeID ."   ". $BabyID; exit;*/
        $MotherDetail =  $this->db->query("SELECT MR.`MotherName`, BR.`DeliveryDate`, BR.`BabyWeight` FROM mother_registration as MR LEFT JOIN baby_registration as BR  on BR.`MotherID` =  MR.`MotherID`  WHERE BR.`BabyID` = '".$getBabyFileId['BabyID']."'")->row_array();

         $GetBabyWeigth = $this->db->get_where('baby_weight_master', array('LoungeID'=>$LoungeID,'BabyID'=>$getBabyFileId['BabyID'],'baby_admissionID'=>$getBabyFileId['id']))->result_array();

        /* echo "<pre>"; print_r($GetBabyWeigth); exit;*/

               
        $html ='';
        $html.= '
                <!DOCTYPE html>
                <html>
                <head>
                <style>

                  table,th,td,tr{
                    border-collapse:collapse;
                    }

                </style>
                </head>
                <body>
                <table >
                <tr><th style="text-align: center;font-family: sans-serif;"><u><h3>FORM D : DAILY WEIGHT MONITORING FORM</h3></u></th></tr>
                <tr><td style="text-align: left;"><strong ><i>Objective:</i></strong><i style="font-family: serif;"> To record the pre-feed weight of the baby admitted in the KMC unit,and compare it with the weight of the previous day and admission weight.To be filled by nurse on duty in the KMC room after weighing.</i> </td></tr>

                </table>

                <table style="margin-top:   10px;width: 100%" >
                <tr>
                    <td style="width: 50%;text-align: left; padding:5px "><b> Hospital Registration Number: </b> '.$getBabyFileId['BabyFileID'].' </td>
                <th style="width: 50%;text-align: left"></th></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "> <b> Mother Name:</b> '.$MotherDetail['MotherName'].'</td>
                  <td style="width: 50%;text-align: right; padding:5px; float:right !important;  "><b>Date of Birth(dd/mm/yyyy):</b> '.date("d/m/Y",strtotime($MotherDetail['DeliveryDate'])).'</td></tr>
                <tr>
                  <td style="width: 50%;text-align: left; padding:5px "><b>Birth Weight(in grams): </b>'.$MotherDetail['BabyWeight'].'</td>
                  <th style="width: 50%;text-align: left"></th></tr>

                </table>
                <table style="margin-top:10px;border:1px solid;width: 100% " >
                  
                    <tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center;border:1px solid; padding: 8px"><b>Day</b></td>
                    <td style="width: 12%;text-align: center;border:1px solid ; padding: 8px"><b>Date<br>(dd/mm/yy)</b></td>
                    <td style="width: 12%;text-align: center;border:1px solid ; padding: 8px"><b>Time of<br>weighing</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Weight of baby<br>without clothes<br>(in grams)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Todays weight-<br>yesterdays weight<br><br>(+,- or unchanged)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Net gain/loss since admission<br>(Todays weight-<br>Admission<br>weight)</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Remarks</b></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ; padding: 8px"><b>Nurse Name</b></td>
                    <td style="width: 11%;text-align: center;border:1px solid ; padding: 8px"><b>Signature<br>or nurse<br>talking<br>weight</b></td>
                  </tr>';
                  $i =1;

                foreach ($GetBabyWeigth as $key => $value) {
                	$nurseName = singlerowparameter2('Name','StaffID',$value['NurseId'],'staff_master');
                  // print_r(date('g:i A',$value['AddDate']));exit;
                	######## Conditions Baby weigth gain loss #########  
                  	if($i >= 2){
                  	 	$prev_baby_weigth = $GetBabyWeigth[$i-2]['BabyWeight'];

                  		$curr_baby_weigth = $value['BabyWeight'];
                  		$Weigthdiffer = '';
                  		if($prev_baby_weigth > $curr_baby_weigth )
                  		{
                  			$differ =  $prev_baby_weigth -  $curr_baby_weigth;
                  			$Weigthdiffer = '-'.$differ;
                  		}else{
                  			$differ =  $curr_baby_weigth -  $prev_baby_weigth;
                  			$Weigthdiffer = '+'.$differ;
                  		}
                  	}

                  	######## Conditions Baby weigth gain loss #########
            ##### Conditions FOR Net Baby weigth gain loss since admission #########
                  	if($i > 1){
                  		
                  	if($GetBabyWeigth[0]['BabyWeight'] > $value['BabyWeight'] )
                  		{
                  			$differ =  $GetBabyWeigth[0]['BabyWeight'] -  $value['BabyWeight'];
                  			$gainLose = $differ.' loss';
                  			
                  		}else{
                  			$differ = $value['BabyWeight'] -  $GetBabyWeigth[0]['BabyWeight'];
                  			$gainLose = $differ.' gain';
                  			
                  		}
                  	}
             	##### Conditions FOR Net Baby weigth gain loss since admission #########


                $html.=  '<tr style="border:1px solid" >
                    <td style="width: 11%;text-align: center ;border:1px solid;padding: 11px ; padding: 7px">'.$i.'</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">'.date('d/m/Y',strtotime($value['WeightDate'])).'</td>
                    <td style="width: 12%;text-align: center;border:1px solid ">'.date('g:i A',$value['AddDate']).'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$value['BabyWeight'].'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$Weigthdiffer.'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$gainLose.'</td>
                    <td style="width: 13.5%;text-align: center;border:1px solid "></td>
                    <td style="width: 13.5%;text-align: center;border:1px solid ">'.$nurseName.'</td>
                    <td style="width: 11%;text-align: center;border:1px solid "></td>
                  </tr>';


                  $i++;
                   
                  }
               if($type == 'discharge'){
                 $dischargeTime    = ($getBabyFileId['DateOfDicharge'] != '') ? date('d/m/Y',strtotime($getBabyFileId['DateOfDicharge'])) : 'N/A';
                $dischargeWeightsGainOrLoss = ($getBabyFileId['BabyDischargeWeigth'] != '') ? $getBabyFileId['WeightGainOrLoseAfterAdmission'] : 'N/A';
                $html.=  '</table>
                <table style="width: 100%;margin-top: 10px" >
                <tr>
                  <th style="text-align: left;font-family: sans-serif;">Date of discharge(dd/mm/yy):'.$dischargeTime.'
                    <span style="padding-left: 20px">Weight of discharge(in grams):</span><input type="text" value="'.$getBabyFileId['BabyDischargeWeigth'].'" id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>
                <tr>
                  <th style="text-align: left;font-family: sans-serif">Net gain/loss since admission(in grams)(+/-):<input type="text"  id="fname" value="'.$dischargeWeightsGainOrLoss.'"  name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
                </tr>

                </table>';
               }else{
		                $html.=  '</table>
		                <table style="width: 100%;margin-top: 10px" >
		                <tr>
		                  <th style="text-align: left;font-family: sans-serif;">Date of discharge(dd/mm/yy):-----/-----/-----
		                    <span style="padding-left: 20px">Weight of discharge(in grams):</span><input type="text"  id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
		                </tr>
		                <tr>
		                  <th style="text-align: left;font-family: sans-serif">Net gain/loss since admission(in grams)(+/-):<input type="text"  id="fname" name="firstname" style="border-top: none;border-bottom-width: 2px;border-left: none;border-right: none;border-bottom-color: black"></th>
		                </tr>

		                </table>
		                </body>
		                </html>'; 
                  }

        $pdfFilePath =  INVOICE_DIRECTORY."b_".$getBabyFileId['id']."_weigth.pdf";

        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $mpdf =  new mPDF('utf-8', 'A4-L');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        return "b_".$getBabyFileId['id']."_weigth.pdf";
    }



    public function DistrictVillageBlock($id, $type='')
     {

     	if($type=='1'){
			$query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs` 		where `revenuevillagewithblcoksandsubdistandgs`.`GPPRICode`= '".$id."' limit 0,1")->row_array();
			return $query['GPNameProperCase'];
     	}elseif($type=='2'){
     		$query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
					where `revenuevillagewithblcoksandsubdistandgs`.`BlockPRICode`= '".$id."' limit 0,1")->row_array();
			return $query['BlockPRINameProperCase'];
     	}elseif($type=='3'){
     		$query= $this->db->query("SELECT * FROM `revenuevillagewithblcoksandsubdistandgs`  
					where `revenuevillagewithblcoksandsubdistandgs`.`PRIDistrictCode`= '".$id."' limit 0,1")->row_array();
			return $query['DistrictNameProperCase'];
     	}
     	 
     }


public function pdfconventer($filename ='',$lastID)
  	{
  		 error_reporting(0);
         // get last baby record at the time of admission
         $getlastAdmissiondata = $this->db->get_where('baby_admission',array('id'=>$lastID))->row_array();
         // get baby reg data
         $getMotherId = $this->db->get_where('baby_registration',array('BabyID'=>$getlastAdmissiondata['BabyID']))->row_array();  		 


	 	$MotherData = $this->GetMotherAllData($getMotherId['MotherID']);
		$BabyData   = $this->GetBabyAllData($getlastAdmissiondata['BabyID']);

         $gestationAge = GetDateCorrectDiff2(strtotime($BabyData['DeliveryDate']),strtotime($MotherData['MotherLmpDate']));
	   	 $GestationalAge = $gestationAge; 	

         
         $getFirstAseessmentbabyData = $this->db->get_where('checklistmaster',array('MotherAdminID'=>$MotherData['MotherID']))->row_array();

  		//$getHospitalInMA=$this->db->get_where('mother_admission',array('MotherID'=>$MotherData['MotherID']))->row_array();
  		$GR_NAME=  ($MotherData['GuardianName']!='') ?  $MotherData['GuardianName'] :'  ____________________________________________________';
  		$GR_Relation=  ($MotherData['GuardianRelation']!='') ?  $MotherData['GuardianRelation'] :'___________________';
  		$MCTS = ($MotherData['MotherMCTSNumber']!=NULL)?  ' '.$MotherData['MotherMCTSNumber']: ' --';
  		
  		$District_Name =  $this->DistrictVillageBlock($MotherData['PresentDistrictName'], 3) ;
  		$Dname = ($District_Name!='') ? $District_Name : '';
  		$State = ($MotherData['PresentState']!='') ? $MotherData['PresentState'] : '';
  		$Country = ($MotherData['PresentCountry']!='') ? $MotherData['PresentCountry'] : '';
  		

  		$Block_Name =  $this->DistrictVillageBlock($MotherData['PresentBlockName'], 2) ;
  		$Bname = ($MotherData['PresentBlockName']!='') ? $MotherData['PresentBlockName'] : '';

  		$Village_Name =  $this->DistrictVillageBlock($MotherData['PresentVillageName'], 1) ;
  		$Vname = ($Village_Name!='') ? $Village_Name: '_________________________________';

	   	$date = date('d/m/Y',$BabyData['AddDate']); 
	   	$time = date('h:i A',$BabyData['AddDate']);
	   	$BirthWeigth= ($BabyData['BabyWeight']!='') ? $BabyData['BabyWeight'].' grams' :'';

	   	$AdmissionBirthWeigth = ($getlastAdmissiondata['BabyAdmissionWeight']!='') ? $getlastAdmissiondata['BabyAdmissionWeight'].' grams' :'';


	   	$MotherDeliveryPlace = (($MotherData['FacilityID']=='0') || ($MotherData['FacilityID']=='')) ? ucwords($MotherData['MotherDeliveryPlace']) : 'Hospital';


	   	$FacilityName = ($MotherData['FacilityID']!='0' && $MotherData['FacilityID']!=NULL) ? singlerowparameter2('FacilityName','FacilityID',$MotherData['FacilityID'],'facilitylist') : 'Other';


	   	$RuralUrban = ($MotherData['PresentResidenceType']!='') ? " ". $MotherData['PresentResidenceType'] :  '  _______________  ';
	   	$Pincode 	= ($MotherData['PresentPinCode']!='') ? " ".$MotherData['PresentPinCode'] :  '  _______________  ';

	   	$NearBy 	= ($MotherData['PresentAddressNearBy']!='') ? " ".$MotherData['PresentAddressNearBy'] :  '  _______________  ';
	   	$Address 	= ($MotherData['PresentAddress']!='') ? " ".$MotherData['PresentAddress'] :  '  _______________  ';
		$AshaName	= ($MotherData['AshaName']!='') ? " ".$MotherData['AshaName'] :  '  _______________  ';
		$AshaNumber = ($MotherData['AshaNumber']!='') ? " ".$MotherData['AshaNumber'] :  '  _______________  ';

         $Signatures = base_url().'assets/images/sign/'.$getFirstAseessmentbabyData['NurseDigitalSign'];

		$NurseSign = ($MotherData['StaffId']!='') ? singlerowparameter2('Name','StaffID',$MotherData['StaffId'],'staff_master').'<br> '. date('d/m/Y h:i A').'<br>' : ' __________________________________________________';


		$MotherNo = ($MotherData['MotherMoblieNo']!='') ? $MotherData['MotherMoblieNo'] : '____________________________________________________';

		$FatherNo = ($MotherData['FatherMoblieNo']!='') ? $MotherData['FatherMoblieNo'] : '____________________________________________________';

		$Father = ($MotherData['FatherMoblieNo']!='') ? 'Father' : ' __________________';
		$Mother = ($MotherData['MotherMoblieNo']!='') ? 'Mother' : ' __________________';

		if($MotherData['MotherName']!=''){

		$MotherName = ($MotherData['MotherName']!='') ? ucwords($MotherData['MotherName']) :'__________________';
		}elseif($MotherData['MotherName']==NULL && $MotherData['GuardianName']==NULL ){
			$MotherName  = '__________________';
			
		}elseif($MotherData['Type']=='2'){
			$MotherName   =  'Unknown';
			$MotherName2  =  ($MotherData['MotherName']==NULL) ? '__________________': $MotherData['MotherName'];
			$GR_Relation  =  'Unknown';	
		}

		 if($MotherData['Type']=='3' || $MotherData['Type']=='1' ){
		 			$MotherName   =  $MotherData['MotherName'];
		 			$MotherName2   =  ($MotherName!='Unknown') ? $MotherName :'';
		 }else{
		 		$MotherName    =  'Unknown';
		 		$MotherName2   =  ($MotherName=='Unknown') ? '__________________':'';
		 }

		//$Mname = ($MotherData['Type']=='2')? $MotherData['MotherName'] : $MotherName;

		$FatherName = ($MotherData['FatherName']!='') ? ucwords($MotherData['FatherName']) :'__________________';

	   	if($MotherData['GuardianName']==NULL  && $MotherData['GuardianNumber']==NULL){
  			if($GR_Relation=='Father'){

  				$GR_NAME = $FatherName;
  			}else{
  				$GR_NAME = $MotherData['MotherName'];	
  			}


  		}else{

  			$GR_NAME = ($MotherData['GuardianName']!='') ?  $MotherData['GuardianName'] :'  _________________________________________________';

  		}
  		 $motherName00=  ($MotherData['MotherName']!='') ? ucwords($MotherData['MotherName']) :'_____________________';

  		 $fatherName00=  ($MotherData['FatherName']!='') ? ucwords($MotherData['FatherName']) :'_____________________';  


  		$OrganisationName = ($MotherData['OrganizationName']!='') ? $MotherData['OrganizationName'] :"_____________________";
		$OrganisationAddress = ($MotherData['OrganizationAddress']!='') ? $MotherData['OrganizationAddress'] :"______________________";

		$OrganisationNumber = ($MotherData['OrganizationNumber']!='') ? $MotherData['OrganizationNumber'] :"______________________";

  		$LMPDate = ($MotherData['MotherLmpDate']!=NULL) ? date('d/m/Y', strtotime($MotherData['MotherLmpDate'])) : '_____________________';

	   	//echo $this->db->last_query();
         $weekPlural = ($GestationalAge > 1) ? 'Weeks' : 'Week';
	   	//echo $FacilityName;exit;
		/*echo $GestationalAge; exit;*/


		$html ='';
		$html.= '<!DOCTYPE html>
		<html>
		<head>
		  <title>FORM A: KMC UNIT ADMISSION FORM</title>

		  <style>
			table, th, td {

			    border-collapse: collapse;
			}
		</style>

		</head>
		<body>
		  <div style="">
	   
	        <h3 style ="text-align: center; margin-top:-5px !important"><u> FORM A: KMC UNIT ADMISSION FORM</u> </h3>
	        <p style="font-size: 14px"> <b>Objective:</b> To be filled at the time of admission to the KMC unit, before starting long-duration KMC. The form contains information on eligibility of the baby of KMC and detail required for follow-up. </p>
	        <p style=" font-size: 14px ; padding-bottom:-5px !important ;"><b><u><i> Information to be collect by nurse on duty in KMC unit from the case sheet, health officials, mother and caregivers. </i></u></b></p>
	        <span style="margin-top:-10px">--------------------------------------------------------------------------------------------------------------------------------------------------------</span>
	     <div>
	        <div style=" padding-bottom: 5px; padding-top: 5px">
	            <label> <b>Hospital Reg. No.:</b>'.$getlastAdmissiondata['BabyFileID'].'</label> <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>  MCTS No.:</b> '.$MCTS.'</label>
	        </div> 
	        <div style=" padding-bottom: 7px">
	          <label><b> Baby of:</b> '.$MotherName.'<label> 
	        </div>  
	        
	        <div>
	         <label><b>Date of admission to KMC unit</b> (dd/mm/yyyy): '.$date.'</label>&nbsp;<label><b>Time of admission</b> (am/pm): '.$time.'</label>
	        </div>
	        <br> 
	      <div>
	        <b>1- </b> <label>BACKGROUND INFORMATION </label>
	        <br>
	          <div style="margin-top: 15px; margin-left:20px">
	            <b> 1.1 Date of Birth</b> (dd/mm/yyyy): '.date('d/m/Y', strtotime($BabyData['DeliveryDate'])).' 
	          </div>
	            <br>
	           <div style="margin-top: 2px; margin-left:20px">
	            <b> 1.2 Sex: </b> '.$BabyData['BabyGender'].'
	          </div>  
	          <br>
	      
	        <div style="margin-top: 3px; margin-left:20px">
	          <b> 1.3 Time of Birth </b>(am/pm): '.$BabyData['DeliveryTime'].'
	            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        </div>
	            <br>
	          <div style="margin-top: 3px; margin-left:20px">    
	          <b> 1.4 Type of admission: </b> Inborn/ Outborn
	          
	        </div>
	        <br>
	        <div style="margin-top: 3px; margin-left:20px">
	          <b> 1.5 Weight at birth</b> (in grams): '.$BirthWeigth.'
	        </div>
	        <br>
	        <div style="margin-top: 3px; margin-left:20px">    
	          <b> 1.6 Place of birth: </b>'.$MotherDeliveryPlace.' 
	        </div>  
	        <br> 

	        <div style="margin-top: 3px; margin-left:35px">
	          <b> 1.6.1 Name and address of birth facility: </b>'.$FacilityName.'         
	        </div>   
	        <br>
	        <div style="margin-top: 3px; margin-left:20px">    
	          <b> 1.7 Type of birth: </b> '.ucwords($BabyData['DeliveryType']).'	          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	           </div>   
	        <br>
	        <div style="margin-top: 3px; margin-left:20px">    
	        
	            <b> 1.8  Term of birth:</b> Full Term/ Preterm  
	        </div>  

	        <br>
	        <div style="margin-top: 3px; margin-left:20px">
	          <b> 1.9 LMP </b> (first day of last menstrual period - dd/mm/yyyy): '.date("d/m/Y",strtotime($MotherData['MotherLmpDate'])).'
	          
	        </div>
	        <br>   
	        <div style="margin-top: 3px; margin-left:20px">
	          <b> 1.10  Gestational age  </b>(in weeks): '.$GestationalAge.' '.$weekPlural.' 
	        </div>
	        <br>

	         <div style="margin-top: 3px; margin-left:20px">
	          <b> 1.11 Weigth of baby at admission to KMC unit</b> (in grams): '.$AdmissionBirthWeigth.'

	        </div>  
	        <br> 

	        
	        <div style="margin-top: 3px; margin-left:20px">

				<div style="width: 150px"><b>1.12</b></div>
				<div style="margin-left:50px; width: 300px">
	        		<table width="100%" cellpadding="5" style="text-align: center;margin-top: -15px;" border="1">
		        		<tr>
		        			<th>G</th>
		        			<th>P</th>
		        			<th>A</th>
		        			<th>L</th>
		        		</tr>
		        		<tr>
		        			<td>'.$MotherData['Gravida'].'</td>
		        			<td>'.$MotherData['Para'].'</td>
		        			<td>'.$MotherData['Abortion'].'</td>
		        			<td>'.$MotherData['Live'].'</td>
		        		</tr>
	        		</table>
	        	</div>	
	          
	        </div><br>

	        <div style="margin-top: 3px; margin-left:20px">
	          <b> 1.13   Is the Baby stable? </b>  &nbsp;&nbsp; Yes&nbsp; /&nbsp; No
	          <br>
	          Is the baby on medication at time of admission? (Specify name and dosage)
	          <br>
	          <span style="margin-left:20px">1. ______________________________________________</span><br>
	          <span style="margin-left:20px">2. ______________________________________________</span><br>
	          <span style="margin-left:20px">3. ______________________________________________</span><br>
	        </div>   
	        <br>


	      <div>

	      <br>
	        <b>2- </b> <label>FAMILY DETAIL (For Follow Up)</label>
	        <br>
	          <div style="margin-top: 15px; margin-left:20px">
	            <b> 2.1 Name of the mother: </b> '.$motherName00.'
	          </div>
	            <br>
	          <div style="margin-top: 3px; margin-left:20px">
	            <b> 2.2 Name of the father: </b> '.$fatherName00.'
	          </div>  
	          
	          <br>
	      
	        <div style="margin-top: 3px; margin-left:20px">
	          <b> 2.3 Name & relation of accompanying family member(s)</b>
	          <br><br>
					<div style="width:60%; float: left;padding-left:15px">
					'.$GR_NAME.'
					</div>   
					<div style="width:35%; float: right;">
					'.$GR_Relation.'
					</div>    

					<div style="width:60%; float: left;padding-left:15px">
					
					</div>   
					<div style="width:35%; float: right;">
					
					</div>    
					<div style="width:60%; float: left;padding-left:15px">
					
					</div>   
					<div style="width:35%; float: right;">
					
					</div>   
	        	</div>
	            <br>
	          <div style="margin-top: 10px; margin-left:20px">    
	          <b> 2.4 Contact detail (At least 2 close contact numbers)</b> 
	          <br>
	          

	          		<div style="width:60%; float: left;padding-left:15px">
					 <b> Phone / Mobile Number</b> 
					</div> 
					<div style="width:35%; float: right;">
						<b> Relations</b> 	
					</div> 
					<br> 	
	          		<div style="width:60%; float: left;padding-left:15px">
					'.$MotherNo.'
					</div>   
					<div style="width:35%; float: right;">
					'.$MotherName2.'</div> 
					

					<div style="width:60%; float: left;padding-left:15px">
					'.$FatherNo.'
					</div>   
					<div style="width:35%; float: right;">
					 '.$FatherName.'					</div> 
					<br>   
	        </div>
	        <br>
	        <div style="margin-top: 3px; margin-left:35px">
	          <b> 2.4.1 Name and Number of ASHA: </b> '. ucwords($AshaName) ."&nbsp;&nbsp;&nbsp; ".$AshaNumber.'
	        </div>
	        <br>
	        <div style="margin-top: 3px; margin-left:20px">    
	          <b> 2.5 Religion:</b> ' .$MotherData['MotherReligion'].'
	        </div>  
	        <br> 

	        <div style="margin-top: 3px; margin-left:20px">
	          <b> 2.6 Caste: </b> '.$MotherData['MotherCaste'].'         
	        </div>   
	         <br>';
	    
	   
	    

	    if($MotherData['MotherAdmission']==NULL && $MotherData['reason_for_not_admitted']==NULL && $MotherData['Type']=='2'){
	        $html.='<div style="margin-top: 3px; margin-left:20px">    
	          <b> 2.7 Address: </b>
	          <br><br>
	          <b> Rural/Urban: </b> ' .$RuralUrban.  '<br>
	          <b> State/Country: </b> ' .$State.', '.$Country.'<br>
	          <b> District: </b> ' .$Dname.'<br>
	          <b> Block/ Area/ Muhalla:</b> '.$Bname.'<br>
	          <b> Gram Sabha-Hamlet/ House NO.:</b> '.$Vname.'<br>
	          <b> Address:</b>' . $Address. '<br>
	          <b> Pin Code:</b>' . $Pincode. '<br>
	          <b> Near:</b>' . $NearBy. '<br>

	        </div>         
	        <br>
	        <b> 3- </b> <label> ORGANISATION DETAIL </label>
	        <br>  
	        <div style="margin-top: 15px; margin-left:20px">
	            
	            <b>  3.1 Organisation Name: </b> ' .$OrganisationName.  '<br>
	            <b>  3.2 Organisation Number: </b>' . $OrganisationNumber. '<br>
	            <b>  3.3 Organisation Address:</b> '.$OrganisationAddress.'<br>
	            </div>   
	           <br>';

	        }else{

	        $html.='<div style="margin-top: 3px; margin-left:20px">    
	          <b> 2.7 Address: </b>
	          <br><br>
	          <b> Rural/Urban: </b> ' .$RuralUrban.  '<br>
	          <b> State/Country: </b> ' .$State.', '.$Country.'<br>
	          <b> District: </b> ' .$Dname.'<br>
	          <b> Block/ Area/ Muhalla:</b> '.$Bname.'<br>
	          <b> Gram Sabha-Hamlet/ House NO.:</b> '.$Vname.'<br>
	          <b> Address:</b>' . $Address. '<br>
	          <b> Pin Code:</b>' . $Pincode. '<br>
	          <b> Near:</b>' . $NearBy. '<br>

	        </div>         
	        <br>';

	        }


	       $html.='<div style="margin-top: 15px; margin-left:20px"> 

					<div style="width:70%; float: left;">
					<b> Signature of Nurse at the time of admission. </b>
					</div>   
					<div style="width:30%; float: right;">
					<b style="float: right;"> Signature of Doctor </b>
					</div>   
	        
	        </div>  
	        <br> 

	        <div style="margin-top: 3px; margin-left:20px">

	        <div style="width:55%;   float: left; margin-left: 5px">'.$NurseSign.'<br>
	      
	       </div>   
	        <div style="width:30%; float: right;"> _______________________  
	       </div>   
	        </div>   
	        <br>
	      </div>

	    </div>
	      
	  </div>

	</body>
	</html>'; 

		/*$fileName = "b_".$BabyData['BabyID'].".pdf";*/
		$pdfFilePath =  INVOICE_DIRECTORY.$filename;
		//echo $pdfFilePath;

		//load mPDF library
		$this->load->library('m_pdf');
		$PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		//generate the PDF from html
		$this->m_pdf->pdf->WriteHTML($PDFContent);

		//download PDF
		$this->m_pdf->pdf->Output($pdfFilePath, "F"); 

		return  $filename;
    }


}