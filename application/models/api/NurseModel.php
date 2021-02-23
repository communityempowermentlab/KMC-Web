<?php
class NurseModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		date_default_timezone_set("Asia/KolKata");
	}
	
	public function GetDateWiseNotification($loungeId)
	{		
		$currentDate              = date('Y-m-d');
		$StartCurrentdateTime     = date($currentDate.' 00:00:01'); 
		$EndCurrentdateTime       = date($currentDate.' 23:59:59'); 
		$DateStart                = strtotime($StartCurrentdateTime);
		$DateEnd                  = strtotime($EndCurrentdateTime);
		/*only Done data*/
		 $GetData = $this->db->query("select * from notification where loungeId=".$loungeId." and (addDate between ".$DateStart." and ".$DateEnd.") order by id DESC")->result_array();
	    //echo $this->db->last_query();	exit;
	 	 $arrayName = array();
	 	if(count($GetData)>0)
	 	{   
		 	foreach ($GetData as $key => $value){
		 		$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$value['motherId']))->row_array();
		 		$getbabyData = $this->db->get_where('babyRegistration',array('motherId'=>$value['motherId']))->row_array();
		 		$Hold['id']                    = $value['id'];
		 		$Hold['babyId']                = $value['babyId'];
                $Hold['motherId']              = $value['motherId'];
                $Hold['motherName']            = $getMotherName['motherName'];
                $Hold['MotherPhoto']           = ($getMotherName['motherPicture'] != "") ? base_url().'assets/images/motherDirectoryUrls/'.$getMotherName['motherPicture'] : "";
                $Hold['babyPhoto']             = ($getbabyData['babyPhoto'] != "") ? base_url().'assets/images/babyDirectoryUrls/'.$getbabyData['babyPhoto'] : "";
                $Hold['message']               = $value['message'];              
                $Hold['lastAssessmentDate']    = $value['lastAssessmentDate'];
                $Hold['lastAssessmentTime']    = $value['lastAssessmentTime'];
                $dateFormat                    = $value['lastAssessmentDate'].' '.$value['lastAssessmentTime'];
                $Hold['lastAssessment']        = strtotime($dateFormat);
                $Hold['typeOfNotification']    = $value['typeOfNotification'];
                $Hold['value']                 = $value['value'];
                $Hold['status']                = $value['status'];
                $Hold['addDate']               = $value['addDate'];

		 		$arrayName[] = $Hold;
		 	}
	 	}
	 	$response['data'] = $arrayName;
	 	$response['md5Data'] = md5(json_encode($response['data']));
	 	(count($response['data']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
	 }

	public function dutyChangeViaNurse($request)
	{
       $countData = count($request['postDutyData']);
       if($countData > 0){
       	$param = array();
       	$checkDataForAllUpdate = 1;  
       	foreach ($request['postDutyData'] as $key => $request) {
       		$checkDuplicateData =  $this->db->get_where('nurseDutyChange',array('androidUuid'=>$request['localId']))->num_rows();
       		if($checkDuplicateData == 0) {
				$checkDataForAllUpdate = 2;
				$array                     = array();
				$ImageOfCurrentNurseSign   = ($request['currentNurseSign']!='') ? saveImage($request['currentNurseSign'],signDirectory)  :NULL;
				$ImageOfNewNurseSign       = ($request['newNurseSign']!='') ? saveImage($request['newNurseSign'],signDirectory)  :NULL;
				$Image                     = ($request['image']!='') ? saveDynamicImage($request['image'],loungeDirectory)  :NULL;

				$array['loungeId'] 	         = $request['loungeId'];
				$array['CurrentDutyNurseId'] = $request['currentNurseId'];
				$array['NextDutyNurseId']    = $request['newNurseId'];
				$array['Handover'] 	         = $request['handover'];
				$array['CurrentNurseSign']   = $ImageOfCurrentNurseSign;
				$array['NewNurseSign']       = $ImageOfNewNurseSign;
				$array['image']              = $Image;
				$array['androidUuid']        = $request['localId'];
				$array['changeDutyDateTime'] = $request['dateTime'];
				$array['addDate'] 	   	     = time();
				$array['modifyDate'] 	     = time();

				$this->db->insert('nurseDutyChange', $array);
				$lastID            = $this->db->insert_id();
				$listID['id']      = $lastID;
				$listID['localId'] = $request['localId'];
				$param[]           = $listID;	
                if(!empty($request['currentNurseId'])){
	       		    $oldNurse   = $this->db->query("select name from staffMaster where staffId=".$request['currentNurseId']."")->row_array();
	       		    $newNurse   = $this->db->query("select name from staffMaster where staffId=".$request['newNurseId']."")->row_array();
                }else{

                }
                $oldTiming  = $this->db->query("select * from nurseDutyChange order by id desc limit 1")->row_array();
                
                   
	                $settingDetail   =  getAllData('settings','id','1');

                    $dutyChangeDate = date('H:i:s',$oldTiming['changeDutyDateTime']);   
                    
                   $lastDutychange  = strtotime($dutyChangeDate);

                    $curDateTime     = time();        
           			$secondShift     = $settingDetail['DutyShiftTwoTime'];
			        $secondTiming    = date($secondShift.':00:00');
			        $secondShiftTime = strtotime($secondTiming);

              

			        $thirdShift      = $settingDetail['DutyShiftThreeTime'];  
			        $thirdTiming     = date($thirdShift.':00:00');
			        $thirdShiftTime  = strtotime($thirdTiming);
		        
			        $firstShift         = $settingDetail['DutyShiftOneTime'];  
			        $firstTiming        = date($firstShift.':00:00');
			        $firstShiftTime     = strtotime($firstTiming);

					if($firstShiftTime <= $lastDutychange && $secondShiftTime > $lastDutychange)
					 { 

                       $currentShift   = "8AM - 2PM";
                       $newShift       = "2PM - 8PM";
					 }else if($secondShiftTime <= $lastDutychange && $thirdShiftTime > $lastDutychange)
					 {
                       $currentShift   = "2PM - 8PM";
                       $newShift       = "8PM - 8AM";
   
					 }else if($thirdShiftTime <= $lastDutychange && $firstShiftTime < $lastDutychange)
					 {
                       $currentShift   = "8AM - 2PM";
                       $newShift       = "2PM - 8PM"; 
            
					 }			
              

	             // create feed
	            $paramArray                     = array();
	            $paramArray['type']             = $request['currentNurseId'];      
	            $paramArray['loungeId']         = $request['loungeId'];
	            $paramArray['babyAdmissionId'] = "";
	            $paramArray['grantedForId']     = $lastID;
	            $paramArray['feed']             = "Nurse ".$oldNurse['name']." (".$currentShift.") has handed over duty to ".$newNurse['name']." (".$newShift.").";
	            $paramArray['status']	        = '1';
				$arrayName['addDate'] = date('Y-m-d H:i:s');
				$arrayName['modifyDate'] = date('Y-m-d H:i:s');
	            $this->db->insert('timeline',$paramArray);

				$getOldData  = $this->db->query("SELECT * FROM `nurseDutyChange` order by id desc limit 1,1")->row_array();
				$getLastData = $this->db->get_where('nurseDutyChange',array('id'=>$lastID))->row_array();
				$date2       = date("Y-m-d h:i:s A",$getOldData['addDate']);
				$date1       = date("Y-m-d h:i:s A",$getLastData['addDate']);

				$datetime1 = new DateTime($date1);
				$datetime2 = new DateTime($date2);
				$interval  = $datetime1->diff($datetime2);
				$dutyHrs   = $interval->format('%h').":".$interval->format('%i');


				if($getLastData['NextDutyNurseId'] == $getOldData['CurrentDutyNurseId']){
					$this->db->where('id',$lastID);
					$this->db->update('nurseDutyChange',array('DutyHours'=>$dutyHrs));
				}

				$GetNoticfictaionEntry  = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."' AND status = '1' AND typeOfNotification='6' order by id desc limit 0, 1")->result_array();
				$GetNoticfictaionEntry1 = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."' AND status = '1' AND typeOfNotification='6' order by id desc limit 0, 1")->row_array();

				      
		        $settingDetail   =  getAllData('settings','id','1');
				$secondShift     = $settingDetail['DutyShiftTwoTime'];
		        $secondTiming    = date('Y-m-d '.$secondShift.':00:00');
		        $secondShiftTime = strtotime($secondTiming);

		        $secondEndDate      = date('Y-m-d H:i:s',strtotime('+ 1 hours'.date('Y-m-d H:i:s',$secondShiftTime)));
		        $secondEndTiming    = strtotime($secondEndDate);

		        $thirdShift      = $settingDetail['DutyShiftThreeTime'];  
		        $thirdTiming           = date('Y-m-d '.$thirdShift.':00:00');
		        $thirdShiftTime  = strtotime($thirdTiming);

		        $thirdEndDate      = date('Y-m-d H:i:s',strtotime('+ 1 hours'.date('Y-m-d H:i:s',$thirdShiftTime)));
		        $thirdEndTiming    = strtotime($thirdEndDate);	

		        $curDateTime         = time();        
		    
		       if($settingDetail > 0)
		       {
			        $firstShift    = $settingDetail['DutyShiftOneTime'];  
			        $firstTiming        = date('Y-m-d '.$firstShift.':00:00');
			        $firstShiftTime = strtotime($firstTiming);

			        $firstEnddate        = date('Y-m-d H:i:s',strtotime('+ 1 hours'.date('Y-m-d H:i:s',$firstShiftTime)));
			        $firstEndTiming      = strtotime($firstEnddate);
					if($firstShiftTime <= $curDateTime && $firstEndTiming > $curDateTime)
					 { 
		                if(count($GetNoticfictaionEntry) == 1){
							$this->db->where('id', $GetNoticfictaionEntry1['id']);
				              
							$this->db->update('notification',array('status'=>'2','modifyDate'=>$curDateTime));                              	 
		                }

					 }else if($secondShiftTime <= $curDateTime && $secondEndTiming > $curDateTime)
					 {
		                if(count($GetNoticfictaionEntry)==1){
							$this->db->where('id', $GetNoticfictaionEntry1['id']);
							$this->db->update('notification',array('status'=>'2','modifyDate'=>$curDateTime));                              	 
		                }						 	
					 }else if($thirdShiftTime <= $curDateTime && $thirdEndTiming > $curDateTime)
					 {
		                if(count($GetNoticfictaionEntry)==1){
							$this->db->where('id', $GetNoticfictaionEntry1['id']);
							$this->db->update('notification',array('status'=>'2','modifyDate'=>$curDateTime));                              	 
		                }						 	
					 }		 
		        } 
	        }
	        else{
	        	// update data
	        	$array                     = array();
				$ImageOfCurrentNurseSign   = ($request['currentNurseSign']!='') ? saveImage($request['currentNurseSign'],signDirectory)  :NULL;
				$ImageOfNewNurseSign       = ($request['newNurseSign']!='') ? saveImage($request['newNurseSign'],signDirectory)  :NULL;
				$Image                     = ($request['image']!='') ? saveDynamicImage($request['image'],loungeDirectory)  :NULL;

				$array['loungeId'] 	         = $request['loungeId'];
				$array['CurrentDutyNurseId'] = $request['currentNurseId'];
				$array['NextDutyNurseId']    = $request['newNurseId'];
				$array['Handover'] 	         = $request['handover'];
				$array['CurrentNurseSign']   = $ImageOfCurrentNurseSign;
				$array['NewNurseSign']       = $ImageOfNewNurseSign;
				$array['image']              = $Image;
				$array['androidUuid']        = $request['localId'];
				$array['changeDutyDateTime'] = $request['dateTime'];
				$array['addDate'] 	   	     = time();
				$array['modifyDate'] 	     = time();

                $this->db->where('androidUuid',$request['localId']);
				$this->db->update('nurseDutyChange',$array);
				$lastEntry = $this->db->get_where('nurseDutyChange',array('androidUuid'=>$request['localId']))->row_array();
				$listID['id']      = $lastEntry['id'];
				$listID['localId'] = $request['localId'];
				$param[] = $listID;					

	        }	
	}
 }	
       if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
	       $date['id'] = $param;
           generateServerResponse('1','S', $date);
      }else{
       	   generateServerResponse('0','213');
      }		
}

   public function GetRankViaLoungeId($request)
	{
		$currentDate              = date('Y-m-d');
		$StartCurrentdateTime     = date($currentDate.' 00:00:01'); 
		$EndCurrentdateTime       = date($currentDate.' 23:59:59'); 
		$DateStart                = strtotime($StartCurrentdateTime);
		$DateEnd                  = strtotime($EndCurrentdateTime);
        $GetData            = $this->db->query("SELECT loungeId,sum(`Points`) as points FROM pointstransactions where `TransactionStatus` = 'Credit' GROUP by loungeId order by points desc")->result_array();
        $getFacilityID      = $this->db->query("SELECT * from loungeMaster where loungeId=".$request['loungeId']."")->row_array();
        $getLastDoctorfromdocRound   = $this->db->query("SELECT * from doctorRound where loungeId=".$request['loungeId']." order by id desc limit 0,1")->row_array();
        $getDoctorData       = $this->db->query("SELECT * from staffMaster where staffId='".$getLastDoctorfromdocRound['staffId']."' and status='1'")->row_array();

       //total nurse count via lounge
        $TotalNurse         = count($this->db->query("SELECT * from staffMaster where facilityId=".$getFacilityID['facilityId']." and status='1' and Stafftype='2'")->result_array());
       // $TotalRankViaRank   = $this->db->query("SELECT * from staffMaster where facilityId=".$getFacilityID['facilityId']." and status='1' and Stafftype='2'")->result_array();
        $TotalRankViaRank   = $this->db->query("SELECT sm.`staffId`,(SELECT sum(Points) FROM pointstransactions where loungeId=lm.`loungeId` and nurseId=sm.`staffId` and TransactionStatus = 'Credit') as AllPoints from staffMaster as sm inner JOIN loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where sm.`facilityId`=".$getFacilityID['facilityId']." and sm.`status`='1' and sm.`Stafftype`='2' ORDER BY `AllPoints` DESC")->result_array();
      
       //total nurse point
        $TotalNursePoint    = $this->db->query("SELECT SUM(Points) as allPoint from pointstransactions where nurseId=".$request['nurseId']."")->row_array();
        $getCurrentNurse    = $this->db->query("SELECT * from staffMaster where staffId=".$request['nurseId']."  and status='1'")->row_array();
        $getTodaysTempreture    = $this->db->query("SELECT * from notification where loungeId=".$request['loungeId']." and typeOfNotification='4' and (addDate between ".$DateStart." and ".$DateEnd.")")->result_array();
        $getAllFood     = $this->db->query("SELECT * from notification where loungeId=".$request['loungeId']." and typeOfNotification='3' and (addDate between ".$DateStart." and ".$DateEnd.")")->result_array();
        $getCleanless     = $this->db->query("SELECT * from notification where loungeId=".$request['loungeId']." and typeOfNotification='5' and (addDate between ".$DateStart." and ".$DateEnd.")")->result_array();
       /*   for duty chenge query*/
         $month = date('m');
         $MonthStartDateTime   = date('2018-'.$month.'-01 00:00:01');
         $MonthDateStartTiming = strtotime($MonthStartDateTime);  
                
         $MonthLastDateTime   = date('2018-'.$month.'-30 23:59:59');
         $MonthDateLastTiming = strtotime($MonthLastDateTime);

         $getStable = $this->db->query("SELECT Distinct ba.`babyId`,ba.`id`,ba.`loungeId` from babyAdmission as ba inner join babyRegistration as br on br.`babyId`=ba.`babyId` where ba.`loungeId`=".$request['loungeId']." and ba.`status`='1'")->result_array();

	 	 // get mother via lounge
	 	// $getAdmittedMothers = $this->db->query("SELECT * from motherAdmission where loungeId=".$request['loungeId']." and status='1'")->result_array();
       $getAdmittedMothers = $this->db->query("SELECT distinct ma.`id`,mr.`motherId`,ma.`loungeId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`motherAdmission`='Yes' and ma.`status`='1' and ma.`loungeId`=".$request['loungeId']."")->result_array();

	 	 $TotalBaby = count($this->db->query("SELECT DISTINCT bm.`babyAdmissionId` from babyDailyMonitoring as bm inner join babyAdmission as ba on bm.`babyAdmissionId`=ba.`id` where ba.`loungeId`=".$request['loungeId']." and ba.`status`='1'")->result_array());
	 	//echo $this->db->last_query();exit;
         $TotalAdmittedMother = count($this->db->query("SELECT DISTINCT mm.`motherAdmissionId` from motherMonitoring as mm inner join motherAdmission as ma on mm.`motherAdmissionId` = ma.`id` where ma.`loungeId`=".$request['loungeId']." and ma.`status`='1'")->result_array());
          // echo $this->db->last_query();exit;
         $TotalPendingAssesment = count($this->db->query("SELECT * from notification where status='1' and (addDate between ".$DateStart." and ".$DateEnd.") and loungeId=".$request['loungeId']."")->result_array());

	 	$getLastDutyData = $this->db->query("select * from nurseDutyChange where loungeId=".$request['loungeId']." order by id desc limit 0,1")->row_array();
      
        $getLastDutyNurseName    = $this->db->query("select * from staffMaster where staffId='".$getLastDutyData['NextDutyNurseId']."' and status='1'")->row_array();
	 	 // print_r($getLastDutyData);exit;
	 	  $arrayName = array(); 
	 	  foreach ($GetData as $key => $value) {
			$field['loungeId']             = $value['loungeId'];
			$field['point']                = $value['points'];
			$field['position']             = $key+1;
			$arrayName[]                   = $field;
           }
	// for today temperature
		 	  $hold        =   array(); 
		 	  foreach ($getTodaysTempreture as $key => $value) {
				$field1['temperature']             = $value['value'];
				$field1['message']                 = $value['message'];
				$field1['status']                  = $value['status'];
				$field1['date']                    = $value['addDate'];
				$hold[]                            = $field1;
	           }
	// for today food
		 	  $hold1        =   array(); 
		 	  foreach ($getAllFood as $key => $value) {
				$field2['message']                 = $value['message'];
				$field2['status']                  = $value['status'];				
				$field2['date']                    = $value['addDate'];
				$hold1[]                           = $field2;
	           }

	// for cleanless
		 	  $hold2        =   array(); 
		 	  foreach ($getCleanless as $key => $value) {
				$field3['message']                 = $value['message'];
				$field3['status']                  = $value['status'];
				$field3['date']                    = $value['addDate'];
				$hold2[]                           = $field3;
	           }

	// for nurse ranking
		 	  $hold4        =   array(); 
		 	  foreach ($TotalRankViaRank as $key => $value) {
				$field5['staffId']                 = $value['staffId'];
				$field5['points']                   = $value['AllPoints'];
				$hold4[]                           = $field5;
	           }
	                  // get baby details
	           $babyIconCounting       = $this->countBabySign($getStable);  
	           $motherIconCounting     = $this->countMotherSign($getAdmittedMothers);  

// for breast feeding Bar chart query
                 $latestMonth=date('M Y');
                 for ($i = 1; $i < 6; $i++) {
                    $month=date(" M Y", strtotime("-$i month"));
                    $array[]=$month;
                  }
                     $FirstDayTimeStamp = strtotime(date('Y-m-01 00:00:00'));  
                     $LastDayTimeStamp = strtotime(date('Y-m-t 23:59:59'));  


                         $date = new DateTime(date('Y-m-01 00:00:00'));
                         $date->modify('-1 month');
                         $FirstDay_1 = strtotime($date->format('Y-m-d H:i:s'));
                         $date->modify('-1 month');
                         $FirstDay_2 = strtotime($date->format('Y-m-d H:i:s'));
                         $date->modify('-1 month');
                         $FirstDay_3 = strtotime($date->format('Y-m-d H:i:s'));
                         $date->modify('-1 month');
                         $FirstDay_4 = strtotime($date->format('Y-m-d H:i:s'));
                         $date->modify('-1 month');
                         $FirstDay_5 = strtotime($date->format('Y-m-d H:i:s'));

                         $date = new DateTime(date('Y-m-t 23:59:59'));
                           $monthNumber =date('m', strtotime($array[0]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         
                          $LastDay_1= strtotime($date->format('Y-m-d H:i:s'));
                          $monthNumber =date('m', strtotime($array[1]));
                         if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                        
                            $LastDay_2= strtotime($date->format('Y-m-d H:i:s'));
                            $monthNumber =date('m', strtotime($array[2]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                            $LastDay_3= strtotime($date->format('Y-m-d H:i:s'));
                            $monthNumber =date('m', strtotime($array[3]));
                           if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
            
                            $LastDay_4= strtotime($date->format('Y-m-d H:i:s'));
                            $monthNumber =date('m', strtotime($array[4]));
                        if($monthNumber == '04' || $monthNumber == '02' || $monthNumber == '06' || $monthNumber == '09' || $monthNumber == '11'|| $monthNumber == '12'){
                              $date->modify('-31 day');
                          }
                         else if($monthNumber == '03' || $monthNumber == '05' || $monthNumber == '07'|| $monthNumber == '08'|| $monthNumber == '09'){ 
                              $date->modify('-30 day');
                            }else{
                              $date->modify('-28 day');
                          }
                         $LastDay_5= strtotime($date->format('Y-m-d H:i:s'));


                    $lastesMonthMilk  = $this->DashboardDataModel->GetCurrentMonthMilk($FirstDayTimeStamp,$LastDayTimeStamp,$request['loungeId']);
                    $lastesMonthMilk1 = $this->DashboardDataModel->GetCurrentMonthMilk($FirstDay_1,$LastDay_1,$request['loungeId']);
                    $lastesMonthMilk2 = $this->DashboardDataModel->GetCurrentMonthMilk($FirstDay_2,$LastDay_2,$request['loungeId']);
                    $lastesMonthMilk3 = $this->DashboardDataModel->GetCurrentMonthMilk($FirstDay_3,$LastDay_3,$request['loungeId']);
                    $lastesMonthMilk4 = $this->DashboardDataModel->GetCurrentMonthMilk($FirstDay_4,$LastDay_4,$request['loungeId']);
                    $lastesMonthMilk5 = $this->DashboardDataModel->GetCurrentMonthMilk($FirstDay_5,$LastDay_5,$request['loungeId']);
                   
                    $feeding_array                  = array();
                    $feeding_array['barChartfeedingValue1'] = floor($lastesMonthMilk5['quantityOFMilk']/1000);
                    $feeding_array['barChartfeedingValue2'] = floor($lastesMonthMilk4['quantityOFMilk']/1000);
                    $feeding_array['barChartfeedingValue3'] = floor($lastesMonthMilk3['quantityOFMilk']/1000);
                    $feeding_array['barChartfeedingValue4'] = floor($lastesMonthMilk2['quantityOFMilk']/1000);
                    $feeding_array['barChartfeedingValue5'] = floor($lastesMonthMilk1['quantityOFMilk']/1000);
                    $feeding_array['barChartfeedingValue6'] = floor($lastesMonthMilk['quantityOFMilk']/1000);

// for breast feeding pie chart query

              $StartCurrentdateTime     = date("Y-m-d H:i:s", strtotime('-24 hours', time()));; 
              $EndCurrentdateTime       = date("Y-m-d H:i:s"); 
              $DateStart                = strtotime($StartCurrentdateTime);
              $DateEnd                  = strtotime($EndCurrentdateTime);

              $getExclusiveCurrentDateFeeding = $this->FacilityModel->getExCurrentDateFeeding($DateStart,$DateEnd,$request['loungeId']);
              $getExistFeeding = $this->FacilityModel->getExexistingFeeding($DateStart,$DateEnd,$request['loungeId']);
              $getNonExclusiveCurrentDateFeeding = $this->FacilityModel->getNonExCurrentDateFeeding($DateStart,$DateEnd,$request['loungeId']);
 // for KMC Given or not use in pie chart      
              $getKMCGiven = $this->FacilityModel->getGivenKMC($DateStart,$DateEnd,$request['loungeId']);


// for baby SSC Bar chart query 
		       // for SSC timing graph like 0-4,4-8,.... hrs as well as
		        $getSSCTime = $this->FacilityModel->getCurrentBabyInHour($request['loungeId']);
		        $ssctiming=0;
		        $ssctiming1=0;
		        $ssctiming2=0;
		        $ssctiming3=0;
		        $ssctiming4=0;
		        $ssctiming5=0;
		        $totalsscHrs=0;
		        $receivedSccBabyCounting = 0;
		        foreach ($getSSCTime as $key => $value) {
		          $skinTimePerBaby = floor(($value['totalseconds']/60)/60);
		          if($skinTimePerBaby > 0 && $skinTimePerBaby < 4){
		            $ssctiming++;
		          }if($skinTimePerBaby >= 4 && $skinTimePerBaby < 8){
		            $ssctiming1++;
		          }if($skinTimePerBaby >= 8 && $skinTimePerBaby < 12){
		            $ssctiming2++;
		          }if($skinTimePerBaby >= 12 && $skinTimePerBaby < 16){
		            $ssctiming3++;
		          }if($skinTimePerBaby >= 16 && $skinTimePerBaby < 20){
		            $ssctiming4++;
		          }if($skinTimePerBaby >= 20 && $skinTimePerBaby < 24){
		            $ssctiming5++;
		          }
		            $totalsscHrs += $skinTimePerBaby;
		            $receivedSccBabyCounting++;
		        }

                   $feeding_array1                          = array();
                   $feeding_array1['barChartSSCValue']  = $ssctiming;
                   $feeding_array1['barChartSSCValue1'] = $ssctiming1;
                   $feeding_array1['barChartSSCValue2'] = $ssctiming2;
                   $feeding_array1['barChartSSCValue3'] = $ssctiming3;
                   $feeding_array1['barChartSSCValue4'] = $ssctiming4;
                   $feeding_array1['barChartSSCValue5'] = $ssctiming5;

//All Response
            // start Chart value                
                  $response['exclusiveFeeding']       = $getExclusiveCurrentDateFeeding;                 
                  $response['NonExclusiveFeeding']    = $getNonExclusiveCurrentDateFeeding;                 
                  $response['existFeeding']           = $getExistFeeding; 
                  $response['barChartFeedingData']    = $feeding_array;                 
                  $response['barChartsscData']        = $feeding_array1;  
                  $response['pieChartGivenSSC']        = $getKMCGiven;  

            // end chart value               
                  $response['nurseRanking']       = $hold4;                 
                  $response['data']              = $arrayName;
                  $response['temperature']       = $hold;
                  $response['foodData']          = $hold1;
                  $response['cleanlessData']     = $hold2;
                  $response['dutyChange']        = [];
                  $response['stable']            = $babyIconCounting['stable'];
                  $response['unstable']          = $babyIconCounting['unstable']; 
                  $response['motherStable']            = $motherIconCounting['stable'];
                  $response['motherUnstable']          = $motherIconCounting['unstable'];                                     
                  $response['lastDutyNurseId']            = $getLastDutyData['NextDutyNurseId'];                  
                  $response['lastDutyNurseName']          = $getLastDutyNurseName['name'];                  
                
                  $response['lastDutyNurseTiming']        = $getLastDutyData['addDate'];                  
                  $response['totalBaby']         = $babyIconCounting['admittedBaby'];                  
                  $response['nursePhoto']        = ($getLastDutyNurseName['profilePicture'] != "") ? base_url().'assets/nurse/'.$getLastDutyNurseName['profilePicture'] : "";
                  $response['nursePoint']        = $TotalNursePoint['allPoint'];
                  $response['totalNurse']        = $TotalNurse;                 
                  $response['totalMother']       = $motherIconCounting['admittedMother'];                 
                  $response['pendingAssesment']  = $TotalPendingAssesment;                 
                  $response['doctorName']        = $getDoctorData['name'];                 
                  $response['doctorPhoto']       = ($getDoctorData['profilePicture'] != "") ? base_url().'assets/nurse/'.$getDoctorData['profilePicture'] : "";                 
                  $response['doctorRoundDateTime']       = $getLastDoctorfromdocRound['addDate'];                 
                  $response['bedDays']            = $getFacilityID['NumberOfBed']*date('d');                 
                  $response['bedOccupancy']       = ($response['bedDays'] != '0') ? floor((count($getStable)/$response['bedDays'])*100) : '0';  
                 
                 // print_r(md5(generateServerResponse('1','S',$response)));exit;               
	 	  ($GetData > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
	 }

	public function manageStaffrouns($request)
	{
       $countData = count($request['doctorRoundData']);
       if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
		       	foreach ($request['doctorRoundData'] as $key => $request) {
		       		$checkDuplicateData =  $this->db->get_where('doctorRound',array('androidUuid'=>$request['localId']))->num_rows();
		       		if($checkDuplicateData == 0){
		       		    $checkDataForAllUpdate = 2;	
		       		    //insert data	
		       		    $array                       = array();
						$staffSign                   = ($request['staff_signature']!='') ? saveImage($request['staff_signature'],signDirectory) :'';
						$array['staffId'] 	         = $request['staffId'];
						$array['loungeId'] 	         = $request['loungeId'];
						$array['staffSignature']     = $staffSign;
						$array['roundDateTime'] 	 = $request['dateTime'];
						$array['addDate'] 	   	     = time();
                        $array['androidUuid']        = $request['localId'];
						$inserted = $this->db->insert('doctorRound', $array);
						$lastID   = $this->db->insert_id();

						$listID['id']                = $lastID;
						$listID['localId']           = $request['localId'];;
						$param1[]                    = $listID;
						// Create feed for kmc position || skin to skin touch
						$getNurseData  = $this->db->query("select name from staffMaster where staffId=".$request['staffId']."")->row_array();
			            
			            $paramArray                 = array();
			            $paramArray['type']         = '8';
			            $paramArray['loungeId']     = $request['loungeId'];
			            $paramArray['babyAdmissionId'] = "";
			            $paramArray['grantedForId']     = $lastID;
			            $paramArray['feed']             = "Dr. ".$getNurseData['name']." went on a round.";
			            $paramArray['status']	    = '1';
						$paramArray['addDate']	    = time();
						$paramArray['modifyDate']  = time();
			            $this->db->insert('timeline',$paramArray);
					}else{
					    // update data
					    $array                       = array();
						$staffSign                   = ($request['staff_signature']!='') ? saveImage($request['staff_signature'],signDirectory) : '';
						$array['staffId'] 	         = $request['staffId'];
						$array['loungeId'] 	         = $request['loungeId'];
						$array['staffSignature']     = $staffSign;
						$array['roundDateTime'] 	 = $request['dateTime'];
						$array['addDate'] 	   	     = time();
                        $array['androidUuid']        = $request['localId'];
						$this->db->where('androidUuid',$request['localId']);
						$inserted          = $this->db->update('doctorRound', $array);
				        $lastID            = $this->db->get_where('doctorRound',array('androidUuid'=>$request['localId']))->row_array();
						$listID['id']      = $lastID['id'];
						$listID['localId'] = $request['localId'];
						$param1[]          = $listID;						
					}
				}		 
	    }if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
	       $data['id'] = $param1;
           generateServerResponse('1','S', $data);
       }
	    else{
	 	generateServerResponse('0','213');
	   } 		   
    }



	public function GetPointHistoryViaNurseId($nurseId,$offset)
	{

    	$getAllDataWithStatus = $this->getHistoryByNurseWithPaging($nurseId,$offset);
    	//total nurse credited point
        $TotalCreditNursePoint    = $this->db->query("SELECT SUM(Points) as creditPoint from pointstransactions where nurseId=".$nurseId." and TransactionStatus='Credit'")->row_array();

    	//total nurse debited point
        $TotalDebitNursePoint    = $this->db->query("SELECT SUM(Points) as debitPoint from pointstransactions where nurseId=".$nurseId." and TransactionStatus='Debit'")->row_array();

        $arrayName  = array();
        foreach ($getAllDataWithStatus as $key => $value) {
        	$Hold =array();
            $Hold['nurseId']                   = $value['nurseId'];
            $Hold['grantedForID']	           = $value['grantedForId'];
              $Hold['currentNurse']                 = "";
              $Hold['nextNurse']                    = "";

            if($value['type']=='1'){
            	$getbaby = $this->db->get_where('babyAdmission',array('id'=>$value['grantedForId']))->row_array();
            	$getMother = $this->db->get_where('babyRegistration',array('babyId'=>$getbaby['babyId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
             $Hold['name']                     = (!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');;	
            }else if($value['type']=='2'){
            	$getbaby = $this->db->get_where('babyDailyWeight',array('id'=>$value['grantedForId']))->row_array();
            	$getMother = $this->db->get_where('babyRegistration',array('babyId'=>$getbaby['babyId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
               $Hold['name']                     = (!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');
            }else if($value['type']=='3'){
            	$getbaby = $this->db->get_where('babyDailyMonitoring',array('id'=>$value['grantedForId']))->row_array();
            	$getMother = $this->db->get_where('babyRegistration',array('babyId'=>$getbaby['babyId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
               $Hold['name']                     = (!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');
            }else if($value['type']=='4'){
            	$getbaby = $this->db->get_where('babyDailyKMC',array('id'=>$value['grantedForId']))->row_array();
            	$getMother = $this->db->get_where('babyRegistration',array('babyId'=>$getbaby['babyId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
               $Hold['name']                     = (!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');
            }else if($value['type']=='5'){
            	$getbaby = $this->db->get_where('babyDailyNutrition',array('id'=>$value['grantedForId']))->row_array();
            	$getMother = $this->db->get_where('babyRegistration',array('babyId'=>$getbaby['babyId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
               $Hold['name']                     = (!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');
            }else if($value['type']=='6'){
            	$getbaby = $this->db->get_where('babyvaccination',array('id'=>$value['grantedForId']))->row_array();
            	$getMother = $this->db->get_where('babyRegistration',array('babyId'=>$getbaby['babyId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
               $Hold['name']                     =(!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');
            }else if($value['type']=='7'){
            	$getMother = $this->db->get_where('motherMonitoring',array('id'=>$value['grantedForId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
               $Hold['name']                     = (!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');
            }else if($value['type']=='8'){
            	$getbaby = $this->db->get_where('dischargemaster',array('DischargeID'=>$value['grantedForId']))->row_array();
            	$getMother = $this->db->get_where('babyRegistration',array('babyId'=>$getbaby['motherOrBabyId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
                $Hold['name']                    =(!empty($getMotherName['motherName']) ? "B/O ".$getMotherName['motherName'] : 'B/O UNKNOWN');
            } else if($value['type']=='9'){
            	$getMother = $this->db->get_where('dischargemaster',array('DischargeID'=>$value['grantedForId']))->row_array();
            	$getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getMother['motherId']))->row_array();
                $Hold['name']                    = $getMotherName['motherName'];
            }else if($value['type']=='10'){
            	$getLounge = $this->db->get_where('loungeMaster',array('loungeId'=>$value['loungeId']))->row_array();
                $Hold['name']                    = $getLounge['loungeName'];
            }else if($value['type']=='11'){
            	$getLounge = $this->db->get_where('loungeMaster',array('loungeId'=>$value['loungeId']))->row_array();
                $Hold['name']                    = $getLounge['loungeName'];
            }else if($value['type']=='12'){
            	$getLounge = $this->db->get_where('loungeMaster',array('loungeId'=>$value['loungeId']))->row_array();
                $Hold['name']                    = $getLounge['loungeName'];
            }else if($value['type']=='13'){
            	$getLounge = $this->db->get_where('loungeMaster',array('loungeId'=>$value['loungeId']))->row_array();
                $Hold['name']                    = $getLounge['loungeName'];
            }else if($value['type']=='14'){
            	$getNurse = $this->db->get_where('nurseDutyChange',array('id'=>$value['grantedForId']))->row_array();
                $getCurrentNurseName = $this->db->get_where('staffMaster',array('staffId'=>$getNurse['CurrentDutyNurseId']))->row_array();
                $getNextNurseName = $this->db->get_where('staffMaster',array('staffId'=>$getNurse['NextDutyNurseId']))->row_array();
                $Hold['name']                         = "";              
                $Hold['currentNurse']                 = $getCurrentNurseName['name'];
                $Hold['nextNurse']                    = $getNextNurseName['name'];
            }else if($value['type']=='15'){
                $this->db->select('learningapp_observation_question.question_title');
                $this->db->from('learningapp_observation_question');
                $this->db->join('learningapp_store_answer','learningapp_store_answer.questionid=learningapp_observation_question.id','inner');
                $this->db->where('learningapp_store_answer.id',$value['grantedForId']);
                $getValue = $this->db->get()->row_array();
              $Hold['name']                         = $getValue['question_title'];   
            }else if($value['type'] == 16){
                $getValue = $this->db->query('SELECT * FROM `learningapp_orders` WHERE id='.$value['grantedForId'])->row_array();
              $Hold['name']                         = $getValue['refOrderId'];   
            }
            	
            $Hold['type']                      = $value['type'];
            $Hold['point']                     = $value['Points'];
            $Hold['transactionStatus']         = $value['TransactionStatus'];
            $Hold['dateTime']                  = $value['addDate'];
            $arrayName[]          = $Hold;

        }
       // print_r($arrayName);exit;
            $response['nurseData']     = $arrayName;
            $response['result_found']  = count($getAllDataWithStatus);
            $response['offset']        = count($getAllDataWithStatus)+$offset;
            $response['creditedPoint'] = $TotalCreditNursePoint['creditPoint'];
            $response['debitedPoint']  = $TotalDebitNursePoint['debitPoint'];
            $response['scorePoint']    = ($TotalCreditNursePoint['creditPoint'] - $TotalDebitNursePoint['debitPoint']);
             $response['md5Data'] = md5(json_encode($response['nurseData']));
        if(count($response['nurseData']) > 0)
         {
        	generateServerResponse('1','S', $response);
		 }else{
		 	generateServerResponse('0','E');
		 }
    }

  public function getHistoryByNurseWithPaging($nurseId,$offset) {
        $offsetvalue = ($offset!='') ? $offset : 0;
        $limit =20;
        return $this->db->query("SELECT * FROM pointstransactions WHERE nurseId = ".$nurseId." ORDER BY addDate DESC LIMIT ".$offsetvalue.", ".$limit."")->result_array();
    }

// update profile code via app
	public function updateProfilePic($request)
	{
		$array   = array();
		$folder  = 'nurse';
		$image   = ($request['image']!='') ? saveDynamicImage($request['image'],$folder)  :NULL;

		$array['profileUrl']     = base_url().'assets/'.$folder.'/'.$image;
		$array['profile'] 	     =   $image;
       
		if(!empty($image))
		 {
           $this->db->where('staffId',$request['staffId']);
           $res = $this->db->update('staffMaster',array('profilePicture'=>$image));
		 }else{
		 	generateServerResponse('0','E');
		 }
    }

// count stable and unstable baby code here
  public function countBabySign($getStable){
    $admitted       = 0;
	$danger         = 0;
	$normal         = 0;
	$checkupCount1  = 0;
	$checkupCount2  = 0;
	$checkupCount3  = 0;

    foreach($getStable as $value1) {
      $query = $this->db->query("SELECT * from babyDailyMonitoring where loungeId=".$value1['loungeId']." and babyAdmissionId=".$value1['id']." order by id desc limit 0,1");
      $getLastAssessment1 = $query->row_array();
      $monitoringCheck = $query->num_rows();
        if($monitoringCheck > 0){
         $admitted++;
              if($getLastAssessment1['respiratory'] > 60 || $getLastAssessment1['respiratory'] < 30){
                $checkupCount1 = 1;
              }

            if($getLastAssessment1['temperatureValue'] < 95.9 || $getLastAssessment1['temperatureValue'] > 99.5){
              $checkupCount2 = 1;
            }

           if($getLastAssessment1['spo2'] < 95 && $getLastAssessment1['isPulseOximatoryDeviceAvailable']=="Yes"){
              $checkupCount3 = 1;
            }

            if($checkupCount1 == 1 || $checkupCount2 == 1 || $checkupCount3 == 1){
                 $danger++;
            }else{
            	$normal++;
            }
        }                 
    }
    $res['stable']       =  $normal;
    $res['unstable']     =  $danger;
    $res['admittedBaby'] =  $admitted;
    return $res;
  }


// count stable and unstable Mother code here
  public function countMotherSign($getAdmittedMothers){
	$stablecount1   = 0;
	$unstablecount1 = 0;
	$motherAdmitted = 0;
         foreach ($getAdmittedMothers as $key => $value) {  
            $query = $this->db->query("SELECT * from motherMonitoring where loungeId=".$value['loungeId']." and motherId=".$value['motherId']." and motherAdmissionId=".$value['id']." order by id desc limit 0,1");
            $checkMonitoringOrNot = $query->num_rows();
            $getLastAssessment  = $query->row_array();
            if($checkMonitoringOrNot > 0){
            	$status1 = 0;
                $status2 = 0;
                $status3 = 0;
                $status4 = 0;
                $status5 = 0;
                $status6 = 0;
                $status7 = 0;
                $status8 = 0;
               $motherAdmitted++;
              if($getLastAssessment['motherPulse'] < 50 || $getLastAssessment['motherPulse'] > 120){
               $status1 = '1';
              }

              if($getLastAssessment['motherTemperature'] < 95.9 || $getLastAssessment['motherTemperature'] > 99.5){
               $status2 = '1';
              }


             if($getLastAssessment['motherSystolicBP'] >= 140 || $getLastAssessment['motherSystolicBP'] <= 90){
               $status3 = '1';
              }

              if($getLastAssessment['motherDiastolicBP'] <= 60 || $getLastAssessment['motherDiastolicBP'] >= 90){
               $status4 = '1';
              }

              if($getLastAssessment['motherUterineTone'] == 'Hard/Collapsed (Contracted)'){
               $status5 = '1';
              }

              if(!empty($getLastAssessment['episitomycondition']) && $getLastAssessment['episitomycondition'] == 'Infected'){
               $status6 = '1';
              }                                   

              if(!empty($getLastAssessment['sanitoryPadStatus']) && $getLastAssessment['sanitoryPadStatus'] == "It's FULL"){
               $status7 = '1';
              }   

              if(!empty($getLastAssessment['MotherBleedingStatus']) && $getLastAssessment['MotherBleedingStatus'] == "Yes"){
               $status8 = '1';
              }                      

              if($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1 || $status8 == 1)
              {
                    $unstablecount1++;
              }else{
                    $stablecount1++;                       
              }
            }
        }
    $res['stable']         =  $stablecount1;
    $res['unstable']       =  $unstablecount1;
    $res['admittedMother'] =  $motherAdmitted;
    return $res;
  } 

   //Used
   //CheckIn data post
   public function postNurseCheckInData($request)
	{
	   $countData = count($request['checkInData']);
       if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['checkInData'] as $key => $request) {
	       		$checkDuplicateData =  $this->db->get_where('nurseDutyChange',array('androidUuid'=>$request['localId']))->num_rows();

	       		if($request['loungeId'] == "" || $request['loungeId'] == "0"){
	       			generateServerResponse('0','211');
	       		}

	       		if($request['nurseId'] == "" || $request['nurseId'] == "0"){
	       			generateServerResponse('0','224');
	       		}

	       		$getNurseData = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();
	       		if($getNurseData['staffType'] != "2"){
	       			generateServerResponse('0','224');
	       		}

	       		$getLoungeData = $this->db->get_where('loungeMaster',array('loungeId'=>$request['loungeId']))->row_array();
	       		if($getLoungeData['facilityId'] != $getNurseData['facilityId']){
	       			generateServerResponse('0','225');
	       		}

	       		if(empty($getLoungeData)){
	       			generateServerResponse('0','211');
	       		}

	       		if($checkDuplicateData == 0){
	       		    $checkDataForAllUpdate = 2;			
					$arrayName = array();
			        $arrayName['androidUuid']         = $request['localId']; 
					$arrayName['loungeId'] 		      = $request['loungeId'];
					$arrayName['nurseId'] 		      = $request['nurseId'];
					$arrayName['type'] 		          = 1;
					
					if($request['selfie']!=''){
						$selfie=  saveImage($request['selfie'],signDirectory);

						if($selfie == ""){
			       			generateServerResponse('0','226');
			       		}

						$arrayName['selfie']  =  ($selfie!='') ? $selfie : NULL;
					}else{
						$arrayName['selfie']  =  NULL;
					}		
					$arrayName['status'] 		      = 1;
					$arrayName['latitude']  		  = $request['latitude'];
					$arrayName['longitude']  		  = $request['longitude'];
					$arrayName['addDate']             = $request['localDateTime'];
					$arrayName['lastSyncedTime']      = date('Y-m-d H:i:s');
					$arrayName['feeling']             = isset($request['feeling']) ? $request['feeling'] : "1";

			      	//get last inserted id
			        $inserted = $this->db->insert('nurseDutyChange', $arrayName);
					$lastID   = $this->db->insert_id();
                 	
                 	if(!empty($lastID)){
              			$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

	                 	// generate log history
			            $paramArray                 		= array();
			            $paramArray['tableReference']       = '1';
			            $paramArray['tableReferenceId']     = $lastID;
			           
			            $paramArray['remark']             	= $getNurseName['name']." has checked in at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
			            
						$paramArray['latitude']  		  	= $request['latitude'];
						$paramArray['longitude']  		  	= $request['longitude'];
						$paramArray['addDate'] 				= $request['localDateTime'];
						$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
			            $this->db->insert('logHistory',$paramArray);
			        }

					$listID['id']      = $lastID;
					$listID['localId'] = $request['localId'];
					$param1[]          = $listID;
	            }else{
			        $arrayName1['androidUuid']         	= $request['localId']; 
					$arrayName1['loungeId'] 		    = $request['loungeId'];
					$arrayName1['nurseId'] 		      	= $request['nurseId'];
					if($request['selfie']!=''){
						$selfie=  saveImage($request['selfie'],signDirectory);
						$arrayName1['selfie']  =  ($selfie!='') ? $selfie : NULL;
					}else{
						$arrayName1['selfie']  =  NULL;
					}	
					$arrayName1['type'] 		       	= 1;
					$arrayName1['status'] 		      	= 1;
					$arrayName1['addDate']             	= date('Y-m-d H:i:s');
					
					$arrayName1['latitude']  		   	= $request['latitude'];
					$arrayName1['longitude']  		   	= $request['longitude'];
					$arrayName1['lastSyncedTime']      	= date('Y-m-d H:i:s');
					$arrayName1['feeling']  		   	= isset($request['feeling']) ? $request['feeling'] : "1";

				 	$this->db->where('androidUuid',$request['localId']);
				 	$this->db->update('nurseDutyChange', $arrayName1);	
				 	$lastID = $this->db->get_where('nurseDutyChange',array('androidUuid'=>$request['localId']))->row_array();
					$listID['id']      = $lastID['id'];
					$listID['localId'] = $request['localId'];

					if(!empty($lastID['id'])){
						$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

	                 	// generate log history
			            $paramArray                 		= array();
			            $paramArray['tableReference']       = '1';
			            
			            $paramArray['remark']             	= $getNurseName['name']." has checked in at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
			            
						$paramArray['latitude']  		  	= $request['latitude'];
						$paramArray['longitude']  		  	= $request['longitude'];
						$paramArray['addDate'] 				= $request['localDateTime'];
						$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
			            $this->db->where(array('tableReferenceId' => $lastID['id'], 'tableReference' => '1'));
						$this->db->update('logHistory', $paramArray);	
					}


					$param1[] = $listID;            	
	            }
	        }if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
		       $data['id'] = $param1;
	           generateServerResponse('1','S', $data);
			  }
			else{
				generateServerResponse('0','213');
			} 	        
       }else{
			 generateServerResponse('0','213');
			} 	
    }




// Nurse checkOut data post

   public function postNurseCheckOutData($request)
	{
	   $countData = count($request['checkOutData']);
       if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['checkOutData'] as $key => $request) {
	       		$checkDuplicateData =  $this->db->get_where('nurseDutyChange',array('androidUuid'=>$request['localId'],'type'=>2))->num_rows();

	       		if($request['loungeId'] == "" || $request['loungeId'] == "0"){
	       			generateServerResponse('0','211');
	       		}

	       		if($request['nurseId'] == "" || $request['nurseId'] == "0"){
	       			generateServerResponse('0','224');
	       		}

	       		$getNurseData = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();
	       		if($getNurseData['staffType'] != "2"){
	       			generateServerResponse('0','224');
	       		}

	       		$getLoungeData = $this->db->get_where('loungeMaster',array('loungeId'=>$request['loungeId']))->row_array();
	       		if($getLoungeData['facilityId'] != $getNurseData['facilityId']){
	       			generateServerResponse('0','225');
	       		}

	       		if(empty($getLoungeData)){
	       			generateServerResponse('0','211');
	       		}


	       		if($checkDuplicateData == 0){
	       		    $checkDataForAllUpdate = 2;			
					$arrayName = array();
			        $arrayName['androidUuid']         	= $request['localId']; 
					$arrayName['loungeId'] 		      	= $request['loungeId'];
					$arrayName['nurseId'] 		      	= $request['nurseId'];
					$arrayName['checkoutLatitude']  	= $request['latitude'];
					$arrayName['checkoutLongitude']  	= $request['longitude'];
					$arrayName['type'] 		          	= 2;
					
					if($request['selfie']!=''){
						$loungeImg=  saveImage($request['selfie'],signDirectory);

						if($loungeImg == ""){
			       			generateServerResponse('0','226');
			       		}

						$arrayName['checkoutSelfie']  =  ($loungeImg!='') ? $loungeImg : NULL;
					}else{
						$arrayName['checkoutSelfie']  =  NULL;
					}		


					$arrayName['modifyDate']           = $request['localDateTime'];
					// $arrayName['checkoutTime']         = $request['localDateTime'];
					$arrayName['lastSyncedTime']       = date('Y-m-d H:i:s');
			      	//get last Baby AdmissionId
					$this->db->where("androidUuid",$request['localId']);
					$this->db->update('nurseDutyChange', $arrayName);

	               	$lastID = $this->db->query("select id from nurseDutyChange where androidUuid='".$request['localId']."'")->row_array();
                
              		$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

              		if(!empty($lastID['id']))
              		{
	                 	// generate log history
			            $paramArray                 		= array();
			            $paramArray['tableReference']       = '1';
			            $paramArray['tableReferenceId']     = $lastID['id'];
			           
			            $paramArray['remark']             	= $getNurseName['name']." has checked out at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
			            
						$paramArray['latitude']  		  	= $request['latitude'];
						$paramArray['longitude']  		  	= $request['longitude'];
						$paramArray['addDate'] 				= $request['localDateTime'];
						$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
			            $this->db->insert('logHistory',$paramArray);
			        }

					$listID['id']      = $lastID['id'];
					$listID['localId'] = $request['localId'];
					$param1[]          = $listID;
	            }else{
					$arrayName = array();
			        $arrayName['androidUuid']         = $request['localId']; 
					// $arrayName['loungeId'] 		      = $request['loungeId'];
					$arrayName['nurseId'] 		      = $request['nurseId'];
					$arrayName['type'] 		          = 2;
					if($request['selfie']!=''){
						$loungeImg=  saveImage($request['selfie'],signDirectory);
						$arrayName['checkoutSelfie']  =  ($loungeImg!='') ? $loungeImg : NULL;
					}else{
						$arrayName['checkoutSelfie']  =  NULL;
					}			

					$arrayName['modifyDate']           	= $request['localDateTime'];
					$arrayName['checkoutLatitude']  	= $request['latitude'];
					$arrayName['checkoutLongitude']  	= $request['longitude'];
					// $arrayName['checkoutTime']        = $request['localDateTime'];
					$arrayName['lastSyncedTime']      = date('Y-m-d H:i:s');
			      	//get last Baby AdmissionId
					$this->db->where("androidUuid",$request['localId']);
					$this->db->update('nurseDutyChange', $arrayName);

	               	$lastID = $this->db->query("select id from nurseDutyChange where androidUuid='".$request['localId']."'")->row_array();
	               	$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

	               	if(!empty($lastID['id'])){
		               	// generate log history
			            $paramArray                 		= array();
			            $paramArray['tableReference']       = '1';
			            
			            $paramArray['remark']             	= $getNurseName['name']." has checked out at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
			            
						$paramArray['latitude']  		  	= $request['latitude'];
						$paramArray['longitude']  		  	= $request['longitude'];
						$paramArray['addDate'] 				= $request['localDateTime'];
						$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
			            $this->db->where(array('tableReferenceId' => $lastID['id'], 'tableReference' => '1'));
						$this->db->update('logHistory', $paramArray);	
					}

					$listID['id']      = $lastID['id'];
					$listID['localId'] = $request['localId'];
					$param1[] = $listID;            	
	            }
	        }if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
		       $data['id'] = $param1;
	           generateServerResponse('1','S', $data);
			  }
			else{
				generateServerResponse('0','213');
			} 	        
       }else{
			 generateServerResponse('0','213');
			} 	
    }



// check Out data post
   public function postDoctorRoundData($request)
	{	
		$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
		$requestJson        = json_decode($requestData, true);
	   	$countData = count($request['doctorRoundData']);
       	if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['doctorRoundData'] as $key => $request) {

	       		$validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => trim($request['babyId'])))->row_array();
	       		$validateDoctorId = $this->db->get_where('staffMaster', array('staffId' => trim($request['doctorId']),'staffType'=>1))->row_array();

	       		if((!empty($validateBabyId)) && (!empty($validateDoctorId)) && (trim($request['doctorId']) != "0") && (trim($request['doctorId']) != "")){

		       		$checkDuplicateData =  $this->db->get_where('doctorRound',array('androidUuid'=>$request['localId']))->num_rows();

	                //$babyAdmisionLastId  = $this->CreatePdf->getBabyAdmissionData($request['babyId']);

					$this
			            ->db
			            ->order_by('id', 'desc');
			        $babyAdmisionLastId = $this
			            ->db
			            ->get_where('babyAdmission', array(
			            'babyId' => $request['babyId'],
			            'loungeId' => $request['loungeId']
			        ))->row_array();

		       		if($checkDuplicateData == 0){

		       		    $checkDataForAllUpdate = 2;			
						$arrayName = array();
				        $arrayName['androidUuid']         = $request['localId']; 
						//$arrayName['loungeId'] 		      = $request['loungeId'];
						$arrayName['babyAdmissionId'] 	  = $babyAdmisionLastId['id'];
						$arrayName['staffId'] 		      = $request['doctorId'];
						$arrayName['comment'] 		      = $request['comment'];

						if($request['doctorSign']!=''){
							$loungeImg=  saveImage($request['doctorSign'],signDirectory);
							$arrayName['staffSignature']  =  ($loungeImg!='') ? $loungeImg : NULL;
						}else{
							$arrayName['staffSignature']  =  NULL;
						}		

						$arrayName['addDate']                      = $request['localDateTime'];
						$arrayName['lastSyncedTime']                = date('Y-m-d H:i:s');
				      	//get last Baby AdmissionId
				        $inserted = $this->db->insert('doctorRound', $arrayName);
						$lastID   = $this->db->insert_id();

	                    $prescriptionCount       = count($request['treatment']);
	                    $investigationCount      = count($request['investigation']);
	                   
	                    // update all previous prescription data 2

	     //                $arrayName3 = array('status' => '2', 'modifyDate' => $request['localDateTime'] );
	                    
	     //                $this->db->where(array('doctorId' => $request['doctorId'], 'babyAdmissionId' => $babyAdmisionLastId['id']));
						// $this->db->update('doctorBabyPrescription', $arrayName3);	

	                    for ($i=0; $i < $prescriptionCount; $i++) { 
	                    	$param = array();
							$param['androidUuid']         	= $request['treatment'][$i]['localId']; 
							//$param['loungeId'] 		      	= $request['prescriptions'][$i]['loungeId'];
							$param['roundId'] 		      	= $lastID;
							$param['prescriptionName']   	= $request['treatment'][$i]['treatmentName'];
							$param['comment'] 		      	= $request['treatment'][$i]['comment'];
							$param['image'] 		      	= ($request['treatment'][$i]['image']!='') ? saveDynamicImage($request['treatment'][$i]['image'],reportDirectory) : NULL;
							$param['doctorId'] 		  		= $request['doctorId'];
							$param['babyAdmissionId'] 		= $babyAdmisionLastId['id'];
							$param['addDate']             	= $request['treatment'][$i]['localDateTime'];
							$param['status']			  	= $request['treatment'][$i]['status'];
							$param['lastSyncedTime']      	 = date('Y-m-d H:i:s');

							$this->db->insert('doctorBabyPrescription', $param);
						}

	                 //medicalTest data Post
	                    for ($k=0; $k < $investigationCount; $k++) { 
	                    	$param2 = array();
							$param2['androidUuid']         	= $request['investigation'][$k]['localId']; 
							//$param2['loungeId'] 		   	= $request['investigation'][$k]['loungeId'];
							$param2['roundId'] 		       	= $lastID;
	                        $param2['investigationName'] 	= $request['investigation'][$k]['investigationName'];
	                        $param2['investigationType'] 	= $request['investigation'][$k]['investigationType'];
							$param2['doctorId'] 			= $request['doctorId'];
							$param2['babyAdmissionId'] 		= $babyAdmisionLastId['id'];
							$param2['doctorComment'] 	   	= $request['investigation'][$k]['comment'];
							$param2['status'] 				= $request['investigation'][$k]['status'];
							
							$param2['addDate']             	= $request['investigation'][$k]['localDateTime'];
							$param2['lastSyncedTime']       = date('Y-m-d H:i:s');
							$this->db->insert('investigation', $param2);
							
						} 

	                    // create treatment and investigation pdf
	                    $pdfFileName1       = $this->CreatePdf->generateTreatmentInvestigationPdf($request['babyId'],$request['doctorId']);
	                    $pdfFileName2       = $this->CreatePdf->generateTreatmentPrescriptionPdf($request['babyId'],$request['doctorId']);
	                    $babyAdmissionData  = $this->CreatePdf->getBabyAdmissionData($request['babyId']);
						
						$this->db->where('id',$babyAdmissionData['id']);
						$this->db->update('babyAdmission',array('BabyTreatmentPdfName'=> $pdfFileName1,'BabyPrescriptionPdfName'=> $pdfFileName2));
						
						$listID['id']      = $lastID;
						$listID['localId'] = $request['localId'];;
						$param1[]          = $listID;

						##################################################################################################
						##################################################################################################
						################################## Here Update Part start ################################
						##################################################################################################
						##################################################################################################

		            } else {
						$arrayName1 = array();
				        $arrayName1['androidUuid']         = $request['localId']; 
						//$arrayName1['loungeId'] 		   = $request['loungeId'];
						$arrayName1['babyAdmissionId'] 		= $babyAdmisionLastId['id'];
						$arrayName1['staffId'] 		      = $request['doctorId'];
						$arrayName1['comment'] 		      = $request['comment'];
						
						if($request['doctorSign']!=''){
							$loungeImg=  saveImage($request['doctorSign'],signDirectory);
							$arrayName1['staffSignature']  =  ($loungeImg!='') ? $loungeImg : NULL;
						}else{
							$arrayName1['staffSignature']  =  NULL;
						}		

						$arrayName1['addDate']                      = $request['localDateTime'];
						$arrayName1['lastSyncedTime']               = date('Y-m-d H:i:s');

						 $this->db->where('androidUuid',$request['localId']);
						 $this->db->update('doctorRound', $arrayName1);	
						$lastID = $this->db->get_where('doctorRound',array('androidUuid'=>$request['localId']))->row_array();
						$listID['id']      = $lastID['id'];

	                    $prescriptionCount = count($request['treatment']);
	                    // $vaccinationCount  = count($request['vaccination']);
	                    $investigationCount      = count($request['investigation']);

	                    // update all previous prescription data 2

	     //                $arrayName3 = array('status' => '2', 'modifyDate' => $request['localDateTime'] );
	                    
	     //                $this->db->where(array('doctorId' => $request['doctorId'], 'babyAdmissionId' => $babyAdmisionLastId['id']));
						// $this->db->update('doctorBabyPrescription', $arrayName3);	


	                  	//prescription data Post
	                    for ($i=0; $i < $prescriptionCount; $i++) { 
	                       	$param = array();
							$param['androidUuid']         	= $request['treatment'][$i]['localId']; 
							//$param['loungeId'] 		      	= $request['prescriptions'][$i]['loungeId'];
							$param['roundId'] 		      	= $lastID['id'];
							$param['prescriptionName']   	= $request['treatment'][$i]['treatmentName'];
							$param['comment'] 		      	= $request['treatment'][$i]['comment'];
							$param['image'] 		      	= ($request['treatment'][$i]['image']!='') ? saveDynamicImage($request['treatment'][$i]['image'],reportDirectory) :NULL;
							$param['doctorId'] 		  		= $request['doctorId'];
							$param['babyAdmissionId'] 		= $babyAdmisionLastId['id'];
							$param['addDate']             	= $request['treatment'][$i]['localDateTime'];
							$param['status']			  	= $request['treatment'][$i]['status'];
							$param['lastSyncedTime']      	 = date('Y-m-d H:i:s');
							$this->db->where('androidUuid',$request['treatment'][$i]['localId']);
							$this->db->update('doctorBabyPrescription', $param);

						}


	                 	//investigation data Post
	                    for ($k=0; $k < $investigationCount; $k++) { 
	                    	$param2 = array();
							$param2['androidUuid']         	= $request['investigation'][$k]['localId']; 
							//$param2['loungeId'] 		   	= $request['investigation'][$k]['loungeId'];
							$param2['roundId'] 		       	= $lastID['id'];
							

	                        $param2['investigationName'] 	= $request['investigation'][$k]['investigationName'];
	                        $param2['investigationType'] 	= $request['investigation'][$k]['investigationType'];
							// $param2['nurseId'] 				= $request['investigation'][$k]['nurseId'];
							$param2['doctorId'] 			= $request['doctorId'];
							$param2['babyAdmissionId'] 		= $babyAdmisionLastId['id'];
							$param2['doctorComment'] 	   	= $request['investigation'][$k]['comment'];
							$param2['status'] 				= $request['investigation'][$k]['status'];	
							$param2['addDate']            	= $request['investigation'][$k]['localDateTime'];
							$param2['lastSyncedTime']      = date('Y-m-d H:i:s');
							$this->db->where('androidUuid',$request['investigation'][$k]['localId']);
							$this->db->update('investigation', $param2);
						}

	                    // create treatment and investigation pdf
	                    $pdfFileName1       = $this->CreatePdf->generateTreatmentInvestigationPdf($request['babyId'],$request['doctorId']);
	                    $pdfFileName2       = $this->CreatePdf->generateTreatmentPrescriptionPdf($request['babyId'],$request['doctorId']);
	                   
						$this->db->where('id',$babyAdmissionData['id']);
						$this->db->update('babyAdmission',array('BabyTreatmentPdfName'=> $pdfFileName1,'BabyPrescriptionPdfName'=> $pdfFileName2));
						
						$listID['localId'] = $request['localId'];
						$param1[] = $listID;            	
		        	}
		        }
	   		} 
	   		if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
		       $data['id'] = $param1;
	           generateServerResponse('1','S', $data);
			}
			else{ 
				generateServerResponse('0','213');
			} 	        
        } else{
			 generateServerResponse('0','213');
		} 	
    }


    public function editDoctorPrescription($request)
    {
    	$param = array();
		$param['androidUuid']         	= $request['localId']; 
		//$param['loungeId'] 		      	= $request['prescriptions'][$i]['loungeId'];
		$param['roundId'] 		      	= $request['roundId'];
		$param['prescriptionName']   	= $request['treatmentName'];
		$param['comment'] 		      	= $request['comment'];
		$param['image'] 		      	= ($request['image']!='') ? saveDynamicImage($request['image'],reportDirectory) :NULL;
		$param['doctorId'] 		  		= $request['doctorId'];
		$param['babyAdmissionId'] 		= $request['babyId'];
		$param['modifyDate']            = $request['localDateTime'];
		$param['status']			  	= 1;
		$param['lastSyncedTime']      	 = date('Y-m-d H:i:s');
		$this->db->where(array('id' => $request['prescriptionId'], 'androidUuid' => $request['localId']));
		$this->db->update('doctorBabyPrescription', $param);

		$listID['localId'] = $request['localId'];
		$param1[] = $listID;
		$data['id'] = $param1;
	    generateServerResponse('1','S', $data);
    }


    public function editDoctorInvestigation($request)
    {
    	$param2 = array();
		$param2['androidUuid']         	= $request['localId']; 
		
		$param2['roundId'] 		       	= $request['roundId'];
		

        $param2['investigationName'] 	= $request['investigationName'];
        $param2['investigationType'] 	= $request['investigationType'];
		// $param2['nurseId'] 				= $request['nurseId'];
		$param2['doctorId'] 			= $request['doctorId'];
		$param2['babyAdmissionId'] 		= $request['babyId'];
		$param2['doctorComment'] 	    = $request['comment'];
		$param2['status'] 				= '1';		
		$param2['modifyDate']           = $request['localDateTime'];
		$param2['lastSyncedTime']       = date('Y-m-d H:i:s');
		$this->db->where(array('id' => $request['investigationId'], 'androidUuid' => $request['localId']));
		$this->db->update('investigation', $param2);

		$listID['localId'] = $request['localId'];
		$param1[] = $listID;
		$data['id'] = $param1;
	    generateServerResponse('1','S', $data);
    }


    public function deleteDoctorPrescription($request)
    {
    	$param = array();
		$param['status']			  	= 3;
		$param['modifyDate']            = $request['localDateTime'];
		$param['lastSyncedTime']      	= date('Y-m-d H:i:s');
		$this->db->where(array('id' => $request['prescriptionId'], 'androidUuid' => $request['localId']));
		$this->db->update('doctorBabyPrescription', $param);

		
	    generateServerResponse('1','S');
    }

    public function deleteDoctorInvestigationId($request)
    {
    	$param = array();
		$param['status']			  	= 3;
		$param['modifyDate']            = $request['localDateTime'];
		$param['lastSyncedTime']      	= date('Y-m-d H:i:s');
		$this->db->where(array('id' => $request['investigationId'], 'androidUuid' => $request['localId']));
		$this->db->update('investigation', $param);

		generateServerResponse('1','S');
    }

	public function GetVaccinationData()
	{	
      return $this->db->get_where('vaccination_master',array('status'=>1))->result_array();
	}

	public function getMedicationData()
	{	
      return $this->db->get_where('supplementMaster',array('status'=>1))->result_array();
	}

	//get data for NurseWisePrescription api
	public function postNursePrescriptionData($request)
	{	
		$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
		$requestJson        = json_decode($requestData, true);

	   	$countData = count($request['nursePrescriptionData']);
       	if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not

	       	foreach ($request['nursePrescriptionData'] as $key => $val) {

	       		$validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => trim($val['babyId'])))->row_array();
                $validateNurseId = $this->db->get_where('staffMaster', array('staffId' => trim($val['nurseId']),'staffType'=>2))->row_array();

                if(!empty($validateBabyId)){

	            	$checkDuplicateData =  $this->db->get_where('prescriptionNurseWise',array('androidUuid'=>$val['localId']))->num_rows();
	            	$DuplicateData      =  $this->db->get_where('prescriptionNurseWise',array('androidUuid'=>$val['localId']))->row_array();
	            	
	            	$this
			            ->db
			            ->order_by('id', 'desc');
			        $babyAdmisionLastId = $this
			            ->db
			            ->get_where('babyAdmission', array(
			            'babyId' => $val['babyId'],
			            'loungeId' => $val['loungeId']
			        ))->row_array();


	            	if($checkDuplicateData == 0){
	            		$checkDataForAllUpdate = 2;	
	            		$param = array();

						$param['androidUuid']         	= ($val['localId'] != '') ? $val['localId'] : NULL;
						//$param['loungeId'] 		      	= ($val['loungeId'] != '') ? $val['loungeId'] : NULL;
						$param['prescriptionName']      = ($val['treatmentName'] != '') ? $val['treatmentName'] : NULL;
						$param['prescriptionTime']      = ($val['prescriptionTime'] != '') ? $val['prescriptionTime'] : NULL;
						$param['quantity'] 		      	= ($val['quantity'] != '') ? $val['quantity'] : NULL;
						$param['unit'] 		      		= ($val['unit'] != '') ? $val['unit'] : NULL;
						$param['comment'] 		      	= ($val['comment'] != '') ? $val['comment'] : NULL;
						$param['babyAdmissionId'] 		= ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
						$param['nurseId'] 		  		= ($val['nurseId'] != '') ? $val['nurseId'] : NULL;
						$param['addDate']             	= ($val['localDateTime'] != '') ? $val['localDateTime'] : NULL;
						//$param['modifyDate']            = date('Y-m-d H:i:s');
						$param['status']			  	= 1;
						$param['lastSyncedTime']      	= date('Y-m-d H:i:s');

					  	$this->db->insert('prescriptionNurseWise', $param);
					  	$lastId = $this->db->insert_id();

	                    $pdfFileName1       = $this->CreateNurseOrderPdf->generateNurseOrderPdf($val['babyId'],$val['nurseId']);
	                    $babyAdmissionData  = $this->CreatePdf->getBabyAdmissionData($val['babyId']);
						
						$this->db->where('id',$babyAdmissionData['id']);
						$this->db->update('babyAdmission',array('BabyNurseOrderPdfName'=> $pdfFileName1));
						

						$listID['id'] = $lastId;
						$listID['localId'] = $val['localId']; 
						$param1[] = $listID;   

	            	} else {

	            		$param = array();
						$param['androidUuid']         	= ($val['localId'] != '') ? $val['localId'] : NULL;
						//$param['loungeId'] 		      	= ($val['loungeId'] != '') ? $val['loungeId'] : NULL;
						$param['prescriptionName']      = ($val['treatmentName'] != '') ? $val['treatmentName'] : NULL;
						$param['prescriptionTime']      = ($val['prescriptionTime'] != '') ? $val['prescriptionTime'] : NULL;
						$param['quantity'] 		      	= ($val['quantity'] != '') ? $val['quantity'] : NULL;
						$param['unit'] 		      		= ($val['unit'] != '') ? $val['unit'] : NULL;
						$param['comment'] 		      	= ($val['comment'] != '') ? $val['comment'] : NULL;
						$param['babyAdmissionId'] 		= ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
						$param['nurseId'] 		  		= ($val['nurseId'] != '') ? $val['nurseId'] : NULL;
						$param['addDate']             	= ($val['localDateTime'] != '') ? $val['localDateTime'] : NULL;
						//$param['modifyDate']            = date('Y-m-d H:i:s');
						$param['status']			  	= 1;
						$param['lastSyncedTime']      	= date('Y-m-d H:i:s');

						$this->db->where(array('androidUuid' => $val['localId']));
						$this->db->update('prescriptionNurseWise', $param);	

	                    $pdfFileName1       = $this->CreateNurseOrderPdf->generateNurseOrderPdf($val['babyId'],$val['nurseId']);
	                    $babyAdmissionData  = $this->CreatePdf->getBabyAdmissionData($val['babyId']);
						
						$this->db->where('id',$babyAdmissionData['id']);
						$this->db->update('babyAdmission',array('BabyNurseOrderPdfName'=> $pdfFileName1));
						
						$listID['id'] = $DuplicateData['id'];
						$listID['localId'] = $val['localId']; 
						$param1[] = $listID;  
	            	}
	            }
       		} 	
   		} 
   		if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
	       $data['id']    =   $param1;
           generateServerResponse('1','S', $data);
		}
		else{ 
			generateServerResponse('0','213');
		} 	        
    }  	



    public function postNurseInvestigationData($request)
    {	
	   	$countData          = count($request['nurseInvestigationData']);
       	if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['nurseInvestigationData'] as $key => $val) {

	       		$validateBabyId = $this->db->get_where('babyRegistration', array('babyId' => trim($val['babyId'])))->row_array();
                $validateNurseId = $this->db->get_where('staffMaster', array('staffId' => trim($val['nurseId']),'staffType'=>2))->row_array();
                if((!empty($validateBabyId)) && (!empty($validateNurseId)) && (trim($val['nurseId']) != "0") && (trim($val['nurseId']) != "")){

                	$checkDuplicateData =  $this->db->get_where('investigation',array('androidUuid'=>$val['localId']))->num_rows();
                	$DuplicateData      =  $this->db->get_where('investigation',array('androidUuid'=>$val['localId']))->row_array();
                	
					$this
			            ->db
			            ->order_by('id', 'desc');
			        $babyAdmisionLastId = $this
			            ->db
			            ->get_where('babyAdmission', array(
			            'babyId' => $val['babyId'],
			            'loungeId' => $val['loungeId']
			        ))->row_array();

                	if($checkDuplicateData == 0){
                		$checkDataForAllUpdate = 2;	

                		$param = array();
						$param['androidUuid']         	= ($val['localId'] != '') ? $val['localId'] : NULL;
						//$param['loungeId'] 		      	= ($val['loungeId'] != '') ? $val['loungeId'] : NULL;
						$param['investigationName'] 	= ($val['investigationName'] != '') ? $val['investigationName'] : NULL;
						$param['result'] 		      	= ($val['result'] != '') ? $val['result'] : NULL;
						$param['nurseComment'] 		    = ($val['comment'] != '') ? $val['comment'] : NULL;
						$param['babyAdmissionId'] 		= ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
						$param['nurseId'] 		  		= ($val['nurseId'] != '') ? $val['nurseId'] : NULL;
						$param['addDate']             	= $val['localDateTime'];
						$param['modifyDate']            = date('Y-m-d H:i:s');
						// $param['status']			  	= 1;
						$param['lastSyncedTime']      	= date('Y-m-d H:i:s');

						if($val['resultImage']!=''){
						   $testImage =  saveDynamicImage($val['resultImage'],reportDirectory);
						   $param['resultImage']  	=  ($testImage!='') ? $testImage : NULL;
						} else{
						  	$param['resultImage']  =  NULL;
						}	

                         $this->db->insert('investigation', $param);
                         $lastId = $this->db->insert_id();

						$listID['id'] = $lastId;
						$listID['localId'] = $val['localId']; 
						$param1[] = $listID;   

                	} else {

						$param = array();
						$param['androidUuid']         	= ($val['localId'] != '') ? $val['localId'] : NULL;
						//$param['loungeId'] 		      	= ($val['loungeId'] != '') ? $val['loungeId'] : NULL;
						$param['investigationName'] 	= ($val['investigationName'] != '') ? $val['investigationName'] : NULL;
						$param['result'] 		      	= ($val['result'] != '') ? $val['result'] : NULL;
						$param['nurseComment'] 		    = ($val['comment'] != '') ? $val['comment'] : NULL;
						$param['babyAdmissionId'] 		= ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
						$param['nurseId'] 		  		= ($val['nurseId'] != '') ? $val['nurseId'] : NULL;
						$param['addDate']             	= $val['localDateTime'];
						$param['modifyDate']            = date('Y-m-d H:i:s');
						// $param['status']			  	= 1;
						$param['lastSyncedTime']      	= date('Y-m-d H:i:s');

						if($val['resultImage']!=''){
						   $testImage =  saveDynamicImage($val['resultImage'],reportDirectory);
						   $param['resultImage']  	=  ($testImage!='') ? $testImage : NULL;
						} else{
						  	$param['resultImage']  =  NULL;
						}	
						$this->db->where(array('androidUuid' => $val['localId']));
						$this->db->update('investigation', $param);	

						$listID['id'] = $DuplicateData['id'];
						$listID['localId'] = $val['localId']; 
						$param1[] = $listID;  
                	}
                }
   		    } 
	   		if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
		       $data['id'] = $param1;
	           generateServerResponse('1','S', $data);
			}
			else{ 
				generateServerResponse('0','213');
			} 	        
        } 	
    }


	public function postTakenByNurseData($request)
	{
       $countData = count($request['sampleTakenByNurse']);
       if($countData > 0){
	       	$param = array();
	       	$checkDataForAllUpdate = 1;  
	       	foreach ($request['sampleTakenByNurse'] as $key => $request) {
                $validateNurseId = $this->db->get_where('staffMaster', array('staffId' => trim($request['takenByNurse']),'staffType'=>2))->row_array();
                
                if((!empty($validateNurseId)) && (trim($request['takenByNurse']) != "0") && (trim($request['takenByNurse']) != "")){
		       		
		       		$checkDuplicateData =  $this->db->get_where('investigation',array('androidUuid'=>$request['localId']))->num_rows();
		       		if($checkDuplicateData == 0) {
						$checkDataForAllUpdate = 2;
					    	$arrayName                        = array();
					        $arrayName['androidUuid']        	= ($request['localId'] != '') ? $request['localId'] : NULL;
							//$arrayName['loungeId'] 		     = ($request['localId'] != '') ? $request['localId'] : NULL;
							$arrayName['nurseId'] 		     = ($request['takenByNurse'] != '') ? $request['takenByNurse'] : NULL;
							$arrayName['sampleDate'] 	     = ($request['sampleDate'] != '') ? $request['sampleDate'] : NULL;
							$arrayName['sampleComment'] 	  = ($request['sampleComment'] != '') ? $request['sampleComment'] : NULL;
							$arrayName['status'] 	          = 1;

							if($request['sampleImage']!=''){
								$sampleImg =  saveDynamicImage($request['sampleImage'],reportDirectory);
								$arrayName['sampleImage']  =  ($sampleImg!='') ? $sampleImg : NULL;
							}else{
								$arrayName['sampleImage']  =  NULL;
							}		

							$arrayName['addDate']                     = date('Y-m-d H:i:s');
							$arrayName['modifyDate']                  = date('Y-m-d H:i:s');
							$arrayName['lastSyncedTime']              = date('Y-m-d H:i:s');

					        $this->db->insert('investigation', $arrayName);

						$lastID            = $this->db->insert_id();
						$listID['id']      = $lastID;
						$listID['localId'] = $request['localId'];
						$param[]           = $listID;	
		     
			        }
			        else{
			        	// update data
					    	$arrayName                        = array();

							$arrayName['androidUuid']         = ($request['localId'] != '') ? $request['localId'] : NULL;
							//$arrayName['loungeId'] 		      = ($request['localId'] != '') ? $request['localId'] : NULL;
							$arrayName['nurseId'] 		      = ($request['takenByNurse'] != '') ? $request['takenByNurse'] : NULL;
							$arrayName['sampleDate'] 	      = ($request['sampleDate'] != '') ? $request['sampleDate'] : NULL;
							$arrayName['sampleComment'] 	  = ($request['sampleComment'] != '') ? $request['sampleComment'] : NULL;
							$arrayName['status'] 	          = 1;


							if($request['sampleImage']!=''){
								$sampleImg =  saveDynamicImage($request['sampleImage'],reportDirectory);
								$arrayName['sampleImage']  =  ($sampleImg!='') ? $sampleImg : NULL;
							}else{
								$arrayName['sampleImage']  =  NULL;
							}		

							$arrayName['addDate']          = date('Y-m-d H:i:s');
							$arrayName['modifyDate']       = date('Y-m-d H:i:s');
							$arrayName['lastSyncedTime']   = date('Y-m-d H:i:s');
		                $this->db->where('androidUuid',$request['localId']);
						$this->db->update('investigation',$arrayName);
						$lastEntry = $this->db->get_where('investigation',array('androidUuid'=>$request['localId']))->row_array();
						$listID['id']      = $lastEntry['id'];
						$listID['localId'] = $request['localId'];
						$param[] = $listID;					

			        }
			    }    	
		    }
    }	
     if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
	       $date['id'] = $param;
           generateServerResponse('1','S', $date);
      }else{
       	   generateServerResponse('0','213');
      }		
}

}