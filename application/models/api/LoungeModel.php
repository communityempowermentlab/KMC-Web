<?php
class LoungeModel extends CI_Model {
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
	 	(count($response['data']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
	 }

	public function dutyChangeViaNurse($request)
	{
		$array= array();
		$ImageOfCurrentNurseSign   = ($request['CurrentNurseSign']!='') ? saveImage($request['CurrentNurseSign'],imageDirectory) :'';
		$ImageOfNewNurseSign       = ($request['NewNurseSign']!='') ? saveImage($request['NewNurseSign'],imageDirectory) :'';

		$array['loungeId'] 	         = $request['loungeId'];
		$array['CurrentDutyNurseId'] = $request['CurrentDutyNurseId'];
		$array['NextDutyNurseId']    = $request['NextDutyNurseId'];
		$array['Handover'] 	         = $request['Handover'];
		$array['CurrentNurseSign']   = $ImageOfCurrentNurseSign;
		$array['NewNurseSign']       = $ImageOfNewNurseSign;
		$array['addDate'] 	   	     = time();
		$array['modifyDate'] 	     = time();


		$inserted   = $this->db->insert('nurseDutyChange', $array);
         $lastID    = $this->db->insert_id();
        $getpoints  = $this->db->get_where('pointmaster',array('type'=>'14','status'=>'1'))->row_array();
		if($getpoints > 0)
		{    
			$field = array();
			$field['loungeId']              = $request['loungeId'];
			$field['nurseId']               = $request['CurrentDutyNurseId'];
			$field['Points']                = $getpoints['Point'];
            $field['grantedForId']          = $lastID;
			$field['type']                  = $getpoints['type'];
			$field['TransactionStatus']     = 'Credit';
			$field['addDate']               = time();
			$field['modifyDate']            = time();
			$this->db->insert('pointstransactions',$field);
			
			$field = array();
			$field['loungeId']              = $request['loungeId'];
			$field['nurseId']               = $request['NextDutyNurseId'];
			$field['Points']                = $getpoints['Point'];
			$field['type']                  = $getpoints['type'];
			$field['grantedForId']          = $lastID;
			$field['TransactionStatus']     = 'Credit';
			$field['addDate']               = time();
			$field['modifyDate']            = time();
			$this->db->insert('pointstransactions',$field);			
		}

		if($inserted > 0)
		 {


            $GetNoticfictaionEntry = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."' AND status = '1' AND typeOfNotification='6' order by id desc limit 0, 1")->result_array();
            $GetNoticfictaionEntry1 = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."' AND status = '1' AND typeOfNotification='6' order by id desc limit 0, 1")->row_array();
      
	              
	                $settingDetail =  getAllData('settings','id','1');
			
           			$secondShift     = $settingDetail['DutyShiftTwoTime'];
			        $secondTiming        = date('Y-m-d '.$secondShift.':00:00');
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
                           if(count($GetNoticfictaionEntry)==1){
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

		 	
			generateServerResponse('1','S');
		 }else{
		 	generateServerResponse('0','E');
		 }
    }
   public function GetRankViaLoungeId($request)
	{
		$tesdate = date('2018-06-01 00:00:01');
		$juneDate = strtotime($tesdate);
		$currentDate              = date('Y-m-d');
		$StartCurrentdateTime     = date($currentDate.' 00:00:01'); 
		$EndCurrentdateTime       = date($currentDate.' 23:59:59'); 
		$DateStart                = strtotime($StartCurrentdateTime);
		$DateEnd                  = strtotime($EndCurrentdateTime);
        $GetData            = $this->db->query("SELECT distinct b.loungeId, (SELECT sum(`Points`) FROM pointstransactions where `loungeId` = b.loungeId and `TransactionStatus` = 'Credit') as points FROM pointstransactions as b order by points desc")->result_array();
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
        // $nurseDutyChange = $this->db->query("SELECT * from nurseDutyChange where loungeId=".$request['loungeId']." and (addDate between ".$MonthDateStartTiming." and ".$MonthDateLastTiming.") order by addDate desc")->result_array();
	 	//for baby counting
	 	 $getStable = $this->db->query("SELECT * from babyAdmission where loungeId=".$request['loungeId']." and status='1'")->result_array();
	 	 $TotalBaby = count($this->db->query("SELECT * from babyAdmission where status='1' and loungeId=".$request['loungeId']."")->result_array());
	 	
           $TotalAdmittedMother = count($this->db->query("SELECT * from motherAdmission where status='1' and loungeId=".$request['loungeId']."")->result_array());
           
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
				//$totalSumPoint                     = $this->db->query("SELECT distinct b.loungeId, (SELECT sum(`Points`) FROM pointstransactions where `loungeId` = b.loungeId and `TransactionStatus` = 'Credit' and nurseId=".$value['staffId'].") as points FROM pointstransactions as b order by points desc")->row_array();
				//$totalSumPoint                     = $value['AllPoints'];
				$field5['points']                   = $value['AllPoints'];
				$hold4[]                           = $field5;
	           }

		// for nurseDutyChange
		/*		 	  $hold3        =   array(); 
		 	  foreach ($nurseDutyChange as $key => $value) {
				$field4['CurrentDutyNurseId']                 = $value['CurrentDutyNurseId'];
				$field4['NextDutyNurseId']                    = $value['NextDutyNurseId'];
				$field4['Handover']                           = $value['Handover'];
				$field4['NewNurseSign']                       = ($value['NewNurseSign'] != "") ? base_url().'assets/nurse/'.$value['NewNurseSign'] : "";
				$field4['CurrentNurseSign']                   = ($value['CurrentNurseSign'] != "") ? base_url().'assets/nurse/'.$value['CurrentNurseSign'] : "";
				$field4['status']                             = $value['status'];
				$field4['addDate']                            = $value['addDate'];
				$hold3[]                                      = $field4;
	           }*/

		// for stable 
	              $stablecount = 1 ;
	              $unstablecount = 1;
	              $stable=0;
	              $unstable=0;
	              $status1=0;
	              $status2=0;
	              $status3=0;
		 	  foreach ($getStable as $key => $value) {
		 	  	
		 	  	  $getLastAssessment = $this->db->query("SELECT * from babyDailyMonitoring where loungeId=".$request['loungeId']." and babyId=".$value['babyId']." order by id desc limit 0,1")->row_array();
				if($getLastAssessment['BabyRespiratoryRate'] > 60 || $getLastAssessment['BabyRespiratoryRate'] < 30){
				  $status1 = '1';
                          
				 }

				if($getLastAssessment['BabyTemperature'] < 95.9 || $getLastAssessment['BabyTemperature'] > 99.5){
				  $status2 = '1';

				 }
				if($getLastAssessment['BabyPulseSpO2'] < 95 && $getLastAssessment['IsPulseOximatoryDeviceAvailable']=="Yes"){
				  $status3 = '1';

				 }			        	
				if($status1 == '1' && $status2 == '1' && $status3 == '1'){ 
				  $unstable += $unstablecount;
				}else{
                                   $stable += $stablecount;
                                    }
			 }
 		// get unstable
    
		//All Response
                  $response['nurseRanking']       = $hold4;                 
                  $response['data']              = $arrayName;
                  $response['temperature']       = $hold;
                  $response['foodData']          = $hold1;
                  $response['cleanlessData']     = $hold2;
                  $response['dutyChange']        = [];
                  $response['stable']            = $stable;
                  $response['unstable']          = $unstable;                  
                  $response['lastDutyNurseId']            = $getLastDutyData['NextDutyNurseId'];                  
                  $response['lastDutyNurseName']          = $getLastDutyNurseName['name'];                  
                 // $response['lastDutyNurseSignature']     = ($getLastDutyNurseName['staffSignature'] != "") ? base_url().'assets/nurse/'.$getLastDutyNurseName['staffSignature'] : "";                  
                 // $response['lastDutyNursePhoto']         = ($getLastDutyNurseName['profilePicture'] != "") ? base_url().'assets/nurse/'.$getLastDutyNurseName['profilePicture'] : "";                  
                  $response['lastDutyNurseTiming']        = $getLastDutyData['addDate'];                  
                  $response['totalBaby']         = $TotalBaby;                 
                  $response['nursePhoto']        = ($getLastDutyNurseName['profilePicture'] != "") ? base_url().'assets/nurse/'.$getLastDutyNurseName['profilePicture'] : "";
                  $response['nursePoint']        = $TotalNursePoint['allPoint'];
                  $response['totalNurse']        = $TotalNurse;                 
                  $response['totalMother']       = $TotalAdmittedMother;                 
                  $response['pendingAssesment']  = $TotalPendingAssesment;                 
                  $response['doctorName']        = $getDoctorData['name'];                 
                  $response['doctorPhoto']       = ($getDoctorData['profilePicture'] != "") ? base_url().'assets/nurse/'.$getDoctorData['profilePicture'] : "";                 
                  $response['doctorRoundDateTime']       = $getLastDoctorfromdocRound['addDate'];                 
                  $response['bedDays']            = $getFacilityID['NumberOfBed']*date('d');                 
                  $response['bedOccupancy']       = ($response['bedDays'] != '0') ? floor((count($getStable)/$response['bedDays'])*100) : '0';                 
	 	  ($GetData > 0) ? generateServerResponse('1','S',$response ) : generateServerResponse('0','E');
	 }

	public function manageStaffrouns($request)
	{
		$array= array();
		$staffSign                   = ($request['staffSignature']!='') ? saveImage($request['staffSignature'],imageDirectory) :'';

		$array['staffId'] 	         = $request['staffId'];
		$array['loungeId'] 	         = $request['loungeId'];
		$array['staffSignature']     = $staffSign;
		$array['addDate'] 	   	     = time();


		$inserted = $this->db->insert('doctorRound', $array);
		if($inserted>0)
		 {
			generateServerResponse('1','S');
		 }else{
		 	generateServerResponse('0','E');
		 }
    }
	// update profile code via app
	public function updateProfilePic($request)
	{
		$array   = array();
		$folder  = 'nurse';
		$image   = ($request['image']!='') ? saveDynamicImage($request['image'],$folder) :'';

		$array['profileUrl']     = base_url().'assets/'.$folder.'/'.$image;
		$array['profile'] 	     =   $image;
       
		if(!empty($image))
		 {
           $this->db->where('staffId',$request['staffId']);
           $res = $this->db->update('staffMaster',array('profilePicture'=>$image));
		/*           if($res > 0){
           	generateServerResponse('1','S',$array);
           }	*/
		 }else{
		 	generateServerResponse('0','E');
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
            $Hold['grantedForId']	           = $value['grantedForId'];
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

	public function changeWorkingViaNurse($request)
	{
		$array= array();
		$getAvailNurseInLounge = $this->db->query("SELECT * FROM nurseDutyChange WHERE loungeId = ".$request['loungeId']." ORDER BY id DESC")->row_array();
		$newSign   = ($request['nurseSign']!='') ? saveImage($request['nurseSign'],imageDirectory) :'';
          
		$array['loungeId'] 	         = $request['loungeId'];
		$array['NextDutyNurseId'] 	 = $request['nurseId'];
		$array['CurrentDutyNurseId'] = $getAvailNurseInLounge['NextDutyNurseId'];
		$array['Handover'] 	         = $getAvailNurseInLounge['Handover'];
		$array['NewNurseSign']   	 = $newSign;
		$array['CurrentNurseSign']   = $getAvailNurseInLounge['NewNurseSign'];
		$array['addDate'] 	   	     = time();
		$array['modifyDate'] 	     = time();


		$inserted   = $this->db->insert('nurseDutyChange', $array);
         $lastID    = $this->db->insert_id();
        $getpoints  = $this->db->get_where('pointmaster',array('type'=>'14','status'=>'1'))->row_array();
		if($getpoints > 0)
		{    
			$field = array();
			$field['loungeId']              = $request['loungeId'];
			$field['nurseId']               = $request['nurseId'];
			$field['Points']                = $getpoints['Point'];
            $field['grantedForId']          = $lastID;
			$field['type']                  = $getpoints['type'];
			$field['TransactionStatus']     = 'Credit';
			$field['addDate']               = time();
			$field['modifyDate']            = time();
			$this->db->insert('pointstransactions',$field);
			
			$field = array();
			$field['loungeId']              = $request['loungeId'];
			$field['nurseId']               = $getAvailNurseInLounge['NextDutyNurseId'];
			$field['Points']                = $getpoints['Point'];
			$field['type']                  = $getpoints['type'];
			$field['grantedForId']          = $lastID;
			$field['TransactionStatus']     = 'Credit';
			$field['addDate']               = time();
			$field['modifyDate']            = time();
			$this->db->insert('pointstransactions',$field);			
		}

		if($inserted > 0)
		 {


            $GetNoticfictaionEntry = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."' AND status = '1' AND typeOfNotification='6' order by id desc limit 0, 1")->result_array();
            $GetNoticfictaionEntry1 = $this->db->query("SELECT * From notification where  loungeId = '".$request['loungeId']."' AND status = '1' AND typeOfNotification='6' order by id desc limit 0, 1")->row_array();
      
	              
	                $settingDetail =  getAllData('settings','id','1');
			
           			$secondShift     = $settingDetail['DutyShiftTwoTime'];
			        $secondTiming        = date('Y-m-d '.$secondShift.':00:00');
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
                           if(count($GetNoticfictaionEntry)==1){
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

		 	
			generateServerResponse('1','S');
		 }else{
		 	generateServerResponse('0','E');
		 }
    }



    public function postLoungeAssessment($request)
	{	
		$requestData       = isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
		$requestJson        = json_decode($requestData, true);
	   	$countData = count($request['assessmentData']);
       	if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['assessmentData'] as $key => $request) {
	       		$checkDuplicateData =  $this->db->get_where('loungeAssessment',array('androidUuid'=>$request['localId']))->num_rows();

	       		if($checkDuplicateData == 0){

	       		    $checkDataForAllUpdate = 2;			
					$arrayName = array();
			        $arrayName['androidUuid']         	= $request['localId']; 
					$arrayName['loungeId'] 		      	= $request['loungeId'];
					$arrayName['nurseId'] 		      	= $request['nurseId'];
					
					$arrayName['motherPermission']      = ($request['motherPermission'] != '') ? $request['motherPermission'] : NULL; 
					// 1 = permission taken; 2 = permission not taken 
					$arrayName['loungeTemperature'] 	= ($request['loungeTemperature'] != '') ? $request['loungeTemperature'] : NULL; 
					$arrayName['loungeThermometerCondition'] 	= ($request['loungeThermometerCondition'] != '') ? $request['loungeThermometerCondition'] : NULL; // 1 = working; 2 = not working 


					$arrayName['noFilthLyingAround'] 			= ($request['noFilthLyingAround'] != '') ? $request['noFilthLyingAround'] : NULL;
					$arrayName['noOutsideShoesWornInside'] 		= ($request['noOutsideShoesWornInside'] != '') ? $request['noOutsideShoesWornInside'] : NULL; 
					$arrayName['noOneWithInfection'] 			= ($request['noOneWithInfection'] != '') ? $request['noOneWithInfection'] : NULL;
					$arrayName['sanitizerAvailability'] 		= ($request['sanitizerAvailability'] != '') ? $request['sanitizerAvailability'] : NULL; 
					$arrayName['cleanlinessMaintained'] 		= ($request['cleanlinessMaintained'] != '') ? $request['cleanlinessMaintained'] : NULL; 
					$arrayName['loungeSafety'] 			= ($request['loungeSafety'] != '') ? $request['loungeSafety'] : NULL; 
					// 1 = safe; 2 = unsafe 

					$arrayName['toiletClean'] 				= ($request['toiletClean'] != '') ? $request['toiletClean'] : NULL;
					$arrayName['runningWaterToilet'] 		= ($request['runningWaterToilet'] != '') ? $request['runningWaterToilet'] : NULL; 
					$arrayName['toiletFloorClean'] 			= ($request['toiletFloorClean'] != '') ? $request['toiletFloorClean'] : NULL;
					$arrayName['handwashAvailability'] 		= ($request['handwashAvailability'] != '') ? $request['handwashAvailability'] : NULL; 
					$arrayName['dustinPresenceToilet'] 		= ($request['dustinPresenceToilet'] != '') ? $request['dustinPresenceToilet'] : NULL;

					$arrayName['toiletCondition'] 			= ($request['toiletCondition'] != '') ? $request['toiletCondition'] : NULL; 
					// 1 = good; 2 = not good 

					$arrayName['washroomClean'] 			= ($request['washroomClean'] != '') ? $request['washroomClean'] : NULL;
					$arrayName['cleanBucketPresent'] 		= ($request['cleanBucketPresent'] != '') ? $request['cleanBucketPresent'] : NULL; 
					$arrayName['runningWaterWashroom'] 		= ($request['runningWaterWashroom'] != '') ? $request['runningWaterWashroom'] : NULL;
					$arrayName['soapAvailability'] 			= ($request['soapAvailability'] != '') ? $request['soapAvailability'] : NULL; 
					$arrayName['dustinPresenceWashroom'] 	= ($request['dustinPresenceWashroom'] != '') ? $request['dustinPresenceWashroom'] : NULL;

					$arrayName['washroomCondition'] 	= ($request['washroomCondition'] != '') ? $request['washroomCondition'] : NULL; 
					// 1 = maintained; 2 = not maintained 

					$arrayName['commonAreaClean'] 			= ($request['commonAreaClean'] != '') ? $request['commonAreaClean'] : NULL;
					$arrayName['washingAreaClean'] 			= ($request['washingAreaClean'] != '') ? $request['washingAreaClean'] : NULL; 
					
					$arrayName['dustinPresenceCommonArea'] 	= ($request['dustinPresenceCommonArea'] != '') ? $request['dustinPresenceCommonArea'] : NULL;

					$arrayName['commonAreaCondition'] 	= ($request['commonAreaCondition'] != '') ? $request['commonAreaCondition'] : NULL;
					// 1 = maintained; 2 = not maintained 

					$arrayName['ppeAvailable'] 	= ($request['ppeAvailable'] != '') ? $request['ppeAvailable'] : NULL;

					$arrayName['latitude'] 				= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$arrayName['longitude'] 			= ($request['longitude'] != '') ? $request['longitude'] : NULL; 
					

					if($request['loungePicture']!=''){
						$loungePicture=  saveImage($request['loungePicture'],loungeDirectory);
						$arrayName['loungePicture']  =  ($loungePicture!='') ? $loungePicture : NULL;
					}else{
						$arrayName['loungePicture']  =  NULL;
					}		

					$arrayName['addDate']                      	= $request['localDateTime'];
					$arrayName['lastSyncedTime']                = date('Y-m-d H:i:s');
			      	//get inserted lounge assessment id
			        $inserted = $this->db->insert('loungeAssessment', $arrayName);
					$lastID   = $this->db->insert_id();

					$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

					// generate log history
		            $paramArray                 		= array();
		            $paramArray['tableReference']       = '5';
		            $paramArray['tableReferenceId']     = $lastID;
		           	$paramArray['type']       			= '3';
		           	$paramArray['updatedBy']       		= $request['nurseId'];
		            $paramArray['remark']             	= $getNurseName['name']." has completed the lounge assessment at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
		            
					$paramArray['latitude']  		  	= $request['latitude'];
					$paramArray['longitude']  		  	= $request['longitude'];
					$paramArray['addDate'] 				= $request['localDateTime'];
					$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
					$paramArray['oldValue']      		= ''; 

					if($request['motherPermission'] != '') {
						$paramArray['columnName']      	= 'Mother Permission'; 
						$paramArray['newValue']      	= $request['motherPermission']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['loungeTemperature'] != '') {
						$paramArray['columnName']      	= 'Lounge Temperature'; 
						$paramArray['newValue']      	= $request['loungeTemperature']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['loungeThermometerCondition'] != '') {
						$paramArray['columnName']      	= 'Lounge Thermometer Condition'; 
						$paramArray['newValue']      	= $request['loungeThermometerCondition']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['noFilthLyingAround'] != '') {
						$paramArray['columnName']      	= 'No Filth Lying Around'; 
						$paramArray['newValue']      	= $request['noFilthLyingAround']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['noOutsideShoesWornInside'] != '') {
						$paramArray['columnName']      	= 'No Outside Shoes Worn Inside'; 
						$paramArray['newValue']      	= $request['noOutsideShoesWornInside']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['noOneWithInfection'] != '') {
						$paramArray['columnName']      	= 'No One With Infection'; 
						$paramArray['newValue']      	= $request['noOneWithInfection']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['sanitizerAvailability'] != '') {
						$paramArray['columnName']      	= 'Sanitizer Availability'; 
						$paramArray['newValue']      	= $request['sanitizerAvailability']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['cleanlinessMaintained'] != '') {
						$paramArray['columnName']      	= 'Cleanliness Maintained'; 
						$paramArray['newValue']      	= $request['cleanlinessMaintained']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['loungeSafety'] != '') {
						$paramArray['columnName']      	= 'Lounge Safety'; 
						$paramArray['newValue']      	= $request['loungeSafety']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['toiletClean'] != '') {
						$paramArray['columnName']      	= 'Toilet Clean'; 
						$paramArray['newValue']      	= $request['toiletClean']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['runningWaterToilet'] != '') {
						$paramArray['columnName']      	= 'Running Water Toilet'; 
						$paramArray['newValue']      	= $request['runningWaterToilet']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['toiletFloorClean'] != '') {
						$paramArray['columnName']      	= 'Toilet Floor Clean'; 
						$paramArray['newValue']      	= $request['toiletFloorClean']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['handwashAvailability'] != '') {
						$paramArray['columnName']      	= 'Handwash Availability'; 
						$paramArray['newValue']      	= $request['handwashAvailability']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['dustinPresenceToilet'] != '') {
						$paramArray['columnName']      	= 'Dustin Presence Toilet'; 
						$paramArray['newValue']      	= $request['dustinPresenceToilet']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['toiletCondition'] != '') {
						$paramArray['columnName']      	= 'Toilet Condition'; 
						$paramArray['newValue']      	= $request['toiletCondition']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['washroomClean'] != '') {
						$paramArray['columnName']      	= 'Washroom Clean'; 
						$paramArray['newValue']      	= $request['washroomClean']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['cleanBucketPresent'] != '') {
						$paramArray['columnName']      	= 'Clean Bucket Present'; 
						$paramArray['newValue']      	= $request['cleanBucketPresent']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['runningWaterWashroom'] != '') {
						$paramArray['columnName']      	= 'Running Water Washroom'; 
						$paramArray['newValue']      	= $request['runningWaterWashroom']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['soapAvailability'] != '') {
						$paramArray['columnName']      	= 'Soap Availability'; 
						$paramArray['newValue']      	= $request['soapAvailability']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['dustinPresenceWashroom'] != '') {
						$paramArray['columnName']      	= 'Dustin Presence Washroom'; 
						$paramArray['newValue']      	= $request['dustinPresenceWashroom']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['washroomCondition'] != '') {
						$paramArray['columnName']      	= 'Washroom Condition'; 
						$paramArray['newValue']      	= $request['washroomCondition']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['commonAreaClean'] != '') {
						$paramArray['columnName']      	= 'Common Area Clean'; 
						$paramArray['newValue']      	= $request['commonAreaClean']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['washingAreaClean'] != '') {
						$paramArray['columnName']      	= 'Washing Area Clean'; 
						$paramArray['newValue']      	= $request['washingAreaClean']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['dustinPresenceCommonArea'] != '') {
						$paramArray['columnName']      	= 'Dustin Presence Common Area'; 
						$paramArray['newValue']      	= $request['dustinPresenceCommonArea']; 
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['commonAreaCondition'] != '') {
						$paramArray['columnName']      	= 'Common Area Condition'; 
						$paramArray['newValue']      	= $request['commonAreaCondition']; 
						$this->db->insert('logData', $paramArray);
					}

					if($request['ppeAvailable'] != '') {
						$paramArray['columnName']      	= 'PPE Available'; 
						$paramArray['newValue']      	= $request['ppeAvailable']; 
						$this->db->insert('logData', $paramArray);
					}

					$listID['id']      = $lastID;
					$listID['localId'] = $request['localId'];;
					$param1[]          = $listID;

					##################################################################################################
					##################################################################################################
					################################## Here Update Part start ################################
					##################################################################################################
					##################################################################################################

	            } else {
	            	$getDuplicateData =  $this->db->get_where('loungeAssessment',array('androidUuid'=>$request['localId']))->row_array();

					$arrayName1 = array();
			        $arrayName1['androidUuid']         	= $request['localId']; 
					$arrayName1['loungeId'] 		   	= $request['loungeId'];
					$arrayName1['nurseId'] 		      	= $request['nurseId'];
					
					$arrayName['motherPermission']      = ($request['motherPermission'] != '') ? $request['motherPermission'] : NULL; 
					// 1 = permission taken; 2 = permission not taken
					$arrayName['loungeTemperature'] 	= ($request['loungeTemperature'] != '') ? $request['loungeTemperature'] : NULL; 
					$arrayName['loungeThermometerCondition'] 	= ($request['loungeThermometerCondition'] != '') ? $request['loungeThermometerCondition'] : NULL; // 1 = working; 2 = not working
					
					$arrayName['noFilthLyingAround'] 			= ($request['noFilthLyingAround'] != '') ? $request['noFilthLyingAround'] : NULL;
					$arrayName['noOutsideShoesWornInside'] 		= ($request['noOutsideShoesWornInside'] != '') ? $request['noOutsideShoesWornInside'] : NULL; 
					$arrayName['noOneWithInfection'] 			= ($request['noOneWithInfection'] != '') ? $request['noOneWithInfection'] : NULL;
					$arrayName['sanitizerAvailability'] 		= ($request['sanitizerAvailability'] != '') ? $request['sanitizerAvailability'] : NULL; 
					$arrayName['cleanlinessMaintained'] 		= ($request['cleanlinessMaintained'] != '') ? $request['cleanlinessMaintained'] : NULL; 
					$arrayName['loungeSafety'] 			= ($request['loungeSafety'] != '') ? $request['loungeSafety'] : NULL; 
					// 1 = safe; 2 = unsafe 

					$arrayName['toiletClean'] 				= ($request['toiletClean'] != '') ? $request['toiletClean'] : NULL;
					$arrayName['runningWaterToilet'] 		= ($request['runningWaterToilet'] != '') ? $request['runningWaterToilet'] : NULL; 
					$arrayName['toiletFloorClean'] 			= ($request['toiletFloorClean'] != '') ? $request['toiletFloorClean'] : NULL;
					$arrayName['handwashAvailability'] 		= ($request['handwashAvailability'] != '') ? $request['handwashAvailability'] : NULL; 
					$arrayName['dustinPresenceToilet'] 		= ($request['dustinPresenceToilet'] != '') ? $request['dustinPresenceToilet'] : NULL;

					$arrayName['toiletCondition'] 			= ($request['toiletCondition'] != '') ? $request['toiletCondition'] : NULL; 
					// 1 = good; 2 = not good 

					$arrayName['washroomClean'] 			= ($request['washroomClean'] != '') ? $request['washroomClean'] : NULL;
					$arrayName['cleanBucketPresent'] 		= ($request['cleanBucketPresent'] != '') ? $request['cleanBucketPresent'] : NULL; 
					$arrayName['runningWaterWashroom'] 		= ($request['runningWaterWashroom'] != '') ? $request['runningWaterWashroom'] : NULL;
					$arrayName['soapAvailability'] 			= ($request['soapAvailability'] != '') ? $request['soapAvailability'] : NULL; 
					$arrayName['dustinPresenceWashroom'] 	= ($request['dustinPresenceWashroom'] != '') ? $request['dustinPresenceWashroom'] : NULL;

					$arrayName['washroomCondition'] 	= ($request['washroomCondition'] != '') ? $request['washroomCondition'] : NULL; 
					// 1 = maintained; 2 = not maintained 

					$arrayName['commonAreaClean'] 			= ($request['commonAreaClean'] != '') ? $request['commonAreaClean'] : NULL;
					$arrayName['washingAreaClean'] 			= ($request['washingAreaClean'] != '') ? $request['washingAreaClean'] : NULL; 
					
					$arrayName['dustinPresenceCommonArea'] 	= ($request['dustinPresenceCommonArea'] != '') ? $request['dustinPresenceCommonArea'] : NULL;

					$arrayName['commonAreaCondition'] 	= ($request['commonAreaCondition'] != '') ? $request['commonAreaCondition'] : NULL;
					// 1 = maintained; 2 = not maintained 

					$arrayName['ppeAvailable'] 	= ($request['ppeAvailable'] != '') ? $request['ppeAvailable'] : NULL;

					$arrayName['latitude'] 				= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$arrayName['longitude'] 			= ($request['longitude'] != '') ? $request['longitude'] : NULL; 
					
					if($request['loungePicture']!=''){
						$loungePicture=  saveImage($request['loungePicture'],loungeDirectory);
						$arrayName1['loungePicture']  =  ($loungePicture!='') ? $loungePicture : NULL;
					}else{
						$arrayName1['loungePicture']  =  NULL;
					}			

					$arrayName1['addDate']                      = $request['localDateTime'];
					$arrayName1['lastSyncedTime']               = date('Y-m-d H:i:s');

					$this->db->where('androidUuid',$request['localId']);
					$this->db->update('loungeAssessment', $arrayName1);	
					$lastID = $this->db->get_where('loungeAssessment',array('androidUuid'=>$request['localId']))->row_array();
					$listID['id']      = $lastID['id'];

					$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

					// generate log history
		            $paramArray                 		= array();
		            $paramArray['tableReference']       = '5';
		            $paramArray['tableReferenceId']     = $lastID['id'];
		           	$paramArray['type']       			= '3';
		           	$paramArray['updatedBy']       		= $request['nurseId'];
		            $paramArray['remark']             	= $getNurseName['name']." has completed the lounge assessment at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
		            
					$paramArray['latitude']  		  	= $request['latitude'];
					$paramArray['longitude']  		  	= $request['longitude'];
					$paramArray['addDate'] 				= $request['localDateTime'];
					$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
					
					if($request['motherPermission'] != $getDuplicateData['motherPermission']) {
						$paramArray['columnName']      	= 'Mother Permission'; 
						$paramArray['newValue']      	= $request['motherPermission']; 
						$paramArray['oldValue']      	= $getDuplicateData['motherPermission']; 

						$this->db->insert('logData', $paramArray);
					}

					if($request['loungeTemperature'] != $getDuplicateData['loungeTemperature']) {
						$paramArray['columnName']      	= 'Lounge Temperature'; 
						$paramArray['newValue']      	= $request['loungeTemperature']; 
						$paramArray['oldValue']      	= $getDuplicateData['loungeTemperature'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['loungeThermometerCondition'] != $getDuplicateData['loungeThermometerCondition']) {
						$paramArray['columnName']      	= 'Lounge Thermometer Condition'; 
						$paramArray['newValue']      	= $request['loungeThermometerCondition']; 
						$paramArray['oldValue']      	= $getDuplicateData['loungeThermometerCondition'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['noFilthLyingAround'] != $getDuplicateData['noFilthLyingAround']) {
						$paramArray['columnName']      	= 'No Filth Lying Around'; 
						$paramArray['newValue']      	= $request['noFilthLyingAround']; 
						$this->db->insert('logData', $paramArray);
						$paramArray['oldValue']      	= $getDuplicateData['noFilthLyingAround'];
					}
					
					if($request['noOutsideShoesWornInside'] != $getDuplicateData['noOutsideShoesWornInside']) {
						$paramArray['columnName']      	= 'No Outside Shoes Worn Inside'; 
						$paramArray['newValue']      	= $request['noOutsideShoesWornInside']; 
						$paramArray['oldValue']      	= $getDuplicateData['noOutsideShoesWornInside'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['noOneWithInfection'] != $getDuplicateData['noOneWithInfection']) {
						$paramArray['columnName']      	= 'No One With Infection'; 
						$paramArray['newValue']      	= $request['noOneWithInfection']; 
						$paramArray['oldValue']      	= $getDuplicateData['noOneWithInfection'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['sanitizerAvailability'] != $getDuplicateData['sanitizerAvailability']) {
						$paramArray['columnName']      	= 'Sanitizer Availability'; 
						$paramArray['newValue']      	= $request['sanitizerAvailability']; 
						$paramArray['oldValue']      	= $getDuplicateData['sanitizerAvailability'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['cleanlinessMaintained'] != $getDuplicateData['cleanlinessMaintained']) {
						$paramArray['columnName']      	= 'Cleanliness Maintained'; 
						$paramArray['newValue']      	= $request['cleanlinessMaintained']; 
						$paramArray['oldValue']      	= $getDuplicateData['cleanlinessMaintained'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['loungeSafety'] != $getDuplicateData['loungeSafety']) {
						$paramArray['columnName']      	= 'Lounge Safety'; 
						$paramArray['newValue']      	= $request['loungeSafety']; 
						$paramArray['oldValue']      	= $getDuplicateData['loungeSafety'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['toiletClean'] != $getDuplicateData['toiletClean']) {
						$paramArray['columnName']      	= 'Toilet Clean'; 
						$paramArray['newValue']      	= $request['toiletClean']; 
						$paramArray['oldValue']      	= $getDuplicateData['toiletClean'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['runningWaterToilet'] != $getDuplicateData['runningWaterToilet']) {
						$paramArray['columnName']      	= 'Running Water Toilet'; 
						$paramArray['newValue']      	= $request['runningWaterToilet']; 
						$paramArray['oldValue']      	= $getDuplicateData['runningWaterToilet'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['toiletFloorClean'] != $getDuplicateData['toiletFloorClean']) {
						$paramArray['columnName']      	= 'Toilet Floor Clean'; 
						$paramArray['newValue']      	= $request['toiletFloorClean']; 
						$paramArray['oldValue']      	= $getDuplicateData['toiletFloorClean'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['handwashAvailability'] != $getDuplicateData['handwashAvailability']) {
						$paramArray['columnName']      	= 'Handwash Availability'; 
						$paramArray['newValue']      	= $request['handwashAvailability']; 
						$paramArray['oldValue']      	= $getDuplicateData['handwashAvailability'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['dustinPresenceToilet'] != $getDuplicateData['dustinPresenceToilet']) {
						$paramArray['columnName']      	= 'Dustin Presence Toilet'; 
						$paramArray['newValue']      	= $request['dustinPresenceToilet']; 
						$paramArray['oldValue']      	= $getDuplicateData['dustinPresenceToilet'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['toiletCondition'] != $getDuplicateData['toiletCondition']) {
						$paramArray['columnName']      	= 'Toilet Condition'; 
						$paramArray['newValue']      	= $request['toiletCondition']; 
						$paramArray['oldValue']      	= $getDuplicateData['toiletCondition'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['washroomClean'] != $getDuplicateData['washroomClean']) {
						$paramArray['columnName']      	= 'Washroom Clean'; 
						$paramArray['newValue']      	= $request['washroomClean']; 
						$paramArray['oldValue']      	= $getDuplicateData['washroomClean'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['cleanBucketPresent'] != $getDuplicateData['cleanBucketPresent']) {
						$paramArray['columnName']      	= 'Clean Bucket Present'; 
						$paramArray['newValue']      	= $request['cleanBucketPresent']; 
						$paramArray['oldValue']      	= $getDuplicateData['cleanBucketPresent'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['runningWaterWashroom'] != $getDuplicateData['runningWaterWashroom']) {
						$paramArray['columnName']      	= 'Running Water Washroom'; 
						$paramArray['newValue']      	= $request['runningWaterWashroom']; 
						$paramArray['oldValue']      	= $getDuplicateData['runningWaterWashroom'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['soapAvailability'] != $getDuplicateData['soapAvailability']) {
						$paramArray['columnName']      	= 'Soap Availability'; 
						$paramArray['newValue']      	= $request['soapAvailability']; 
						$paramArray['oldValue']      	= $getDuplicateData['soapAvailability'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['dustinPresenceWashroom'] != $getDuplicateData['dustinPresenceWashroom']) {
						$paramArray['columnName']      	= 'Dustin Presence Washroom'; 
						$paramArray['newValue']      	= $request['dustinPresenceWashroom']; 
						$paramArray['oldValue']      	= $getDuplicateData['dustinPresenceWashroom'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['washroomCondition'] != $getDuplicateData['washroomCondition']) {
						$paramArray['columnName']      	= 'Washroom Condition'; 
						$paramArray['newValue']      	= $request['washroomCondition']; 
						$paramArray['oldValue']      	= $getDuplicateData['washroomCondition'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['commonAreaClean'] != $getDuplicateData['commonAreaClean']) {
						$paramArray['columnName']      	= 'Common Area Clean'; 
						$paramArray['newValue']      	= $request['commonAreaClean']; 
						$paramArray['oldValue']      	= $getDuplicateData['commonAreaClean'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['washingAreaClean'] != $getDuplicateData['washingAreaClean']) {
						$paramArray['columnName']      	= 'Washing Area Clean'; 
						$paramArray['newValue']      	= $request['washingAreaClean']; 
						$paramArray['oldValue']      	= $getDuplicateData['washingAreaClean'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['dustinPresenceCommonArea'] != $getDuplicateData['dustinPresenceCommonArea']) {
						$paramArray['columnName']      	= 'Dustin Presence Common Area'; 
						$paramArray['newValue']      	= $request['dustinPresenceCommonArea']; 
						$paramArray['oldValue']      	= $getDuplicateData['dustinPresenceCommonArea'];
						$this->db->insert('logData', $paramArray);
					}
					
					if($request['commonAreaCondition'] != $getDuplicateData['commonAreaCondition']) {
						$paramArray['columnName']      	= 'Common Area Condition'; 
						$paramArray['newValue']      	= $request['commonAreaCondition']; 
						$paramArray['oldValue']      	= $getDuplicateData['commonAreaCondition'];
						$this->db->insert('logData', $paramArray);
					}

					if($request['ppeAvailable'] != $getDuplicateData['ppeAvailable']) {
						$paramArray['columnName']      	= 'PPE Available'; 
						$paramArray['newValue']      	= $request['ppeAvailable']; 
						$paramArray['oldValue']      	= $getDuplicateData['ppeAvailable'];
						$this->db->insert('logData', $paramArray);
					}	
					
                   
					$listID['localId'] = $request['localId'];
					$param1[] = $listID;            	
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


    public function postLoungeBirthReview($request){
    	$requestData       	= isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
		$requestJson        = json_decode($requestData, true);
	   	$countData = count($request['reviewData']);
       	if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['reviewData'] as $key => $request) {
	       		$checkDuplicateData =  $this->db->get_where('loungeBirthReview',array('androidUuid'=>$request['localId']))->num_rows();

	       		if($checkDuplicateData == 0){

	       		    $checkDataForAllUpdate = 2;			
					$arrayName = array();
			        $arrayName['androidUuid']         	= $request['localId']; 
					$arrayName['loungeId'] 		      	= $request['loungeId'];
					$arrayName['nurseId'] 		      	= $request['nurseId'];
					
					$arrayName['shift']      			= ($request['shift'] != '') ? $request['shift'] : NULL; 
					// 1 = 8 AM to 2PM; 2 = 2 PM to 8 PM; 3 = 8 PM to 8 AM 
					$arrayName['totalLiveBirth'] 		= ($request['totalLiveBirth'] != '') ? $request['totalLiveBirth'] : NULL; 
					$arrayName['totalStableBabies'] 	= ($request['totalStableBabies'] != '') ? $request['totalStableBabies'] : NULL; 
					// total babies between 2000 to 2500 g
					$arrayName['totalUnstableBabies'] 	= ($request['totalUnstableBabies'] != '') ? $request['totalUnstableBabies'] : NULL; 
					// total babies below 2000 g 
					
					$arrayName['latitude'] 				= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$arrayName['longitude'] 			= ($request['longitude'] != '') ? $request['longitude'] : NULL; 
						

					$arrayName['addDate']               = $request['localDateTime'];
					$arrayName['lastSyncedTime']        = date('Y-m-d H:i:s');
			      	//get inserted lounge assessment id
			        $inserted = $this->db->insert('loungeBirthReview', $arrayName);
					$lastID   = $this->db->insert_id();

					$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

					// generate log history
		            $paramArray                 		= array();
		            $paramArray['tableReference']       = '3';
		            $paramArray['tableReferenceId']     = $lastID;
		           
		            $paramArray['remark']             	= $getNurseName['name']." has completed the lounge birth review at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
		            
					$paramArray['latitude']  		  	= $request['latitude'];
					$paramArray['longitude']  		  	= $request['longitude'];
					$paramArray['addDate'] 				= $request['localDateTime'];
					$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
		            $this->db->insert('logHistory',$paramArray);

                    

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
			        $arrayName1['androidUuid']         	= $request['localId']; 
					$arrayName1['loungeId'] 		   	= $request['loungeId'];
					$arrayName1['nurseId'] 		      	= $request['nurseId'];
					
					$arrayName1['shift']      			= ($request['shift'] != '') ? $request['shift'] : NULL; 
					// 1 = 8 AM to 2PM; 2 = 2 PM to 8 PM; 3 = 8 PM to 8 AM 
					$arrayName1['totalLiveBirth'] 		= ($request['totalLiveBirth'] != '') ? $request['totalLiveBirth'] : NULL; 
					$arrayName1['totalStableBabies'] 	= ($request['totalStableBabies'] != '') ? $request['totalStableBabies'] : NULL; 
					// total babies between 2000 to 2500 g
					$arrayName1['totalUnstableBabies'] 	= ($request['totalUnstableBabies'] != '') ? $request['totalUnstableBabies'] : NULL;
					// total babies below 2000 g 

					$arrayName1['latitude'] 			= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$arrayName1['longitude'] 			= ($request['longitude'] != '') ? $request['longitude'] : NULL; 	

					$arrayName1['addDate']              = $request['localDateTime'];
					$arrayName1['lastSyncedTime']       = date('Y-m-d H:i:s');

					$this->db->where('androidUuid',$request['localId']);
					$this->db->update('loungeBirthReview', $arrayName1);	
					$lastID = $this->db->get_where('loungeBirthReview',array('androidUuid'=>$request['localId']))->row_array();
					$listID['id']      = $lastID['id'];

					$getNurseName = $this->db->get_where('staffMaster',array('staffId'=>$request['nurseId']))->row_array();

					// generate log history
		            $paramArray                 		= array();
		            $paramArray['tableReference']       = '3';
		            
		            $paramArray['remark']             	= $getNurseName['name']." has completed the lounge assessment at ".date('d M Y, g:i A',strtotime($request['localDateTime'])).".";
		            
					$paramArray['latitude']  		  	= $request['latitude'];
					$paramArray['longitude']  		  	= $request['longitude'];
					$paramArray['addDate'] 				= $request['localDateTime'];
					$paramArray['lastSyncedTime']      	= date('Y-m-d H:i:s');
		            $this->db->where(array('tableReferenceId' => $lastID['id'], 'tableReference' => '3'));
					$this->db->update('logHistory', $paramArray);	
					
                   
					$listID['localId'] = $request['localId'];
					$param1[] = $listID;            	
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


    public function postLoungeServices($request){
    	$requestData       	= isset($HTTpres_RAW_POST_DATA) ? $HTTpres_RAW_POST_DATA : file_get_contents('php://input');
		$requestJson        = json_decode($requestData, true);
	   	$countData = count($request['serviceData']);
       	if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['serviceData'] as $key => $request) {
	       		$checkDuplicateData =  $this->db->get_where('loungeServices',array('androidUuid'=>$request['localId']))->num_rows();

	       		if($checkDuplicateData == 0){

	       		    $checkDataForAllUpdate = 2;			
					$arrayName = array(); $logData = array();
			        $arrayName['androidUuid']         	= $request['localId']; 
					$arrayName['loungeId'] 		      	= $request['loungeId'];
					$arrayName['nurseId'] 				= $request['nurseId'];
					
					$arrayName['shift']      			= ($request['shift'] != '') ? $request['shift'] : NULL; 

					$today = date('Y-m-d');

					$checkIfDataExist = $this->db->query("SELECT * FROM `loungeServices` where loungeId = ".$request['loungeId']." AND shift = ".$request['shift']." AND addDate like '".$today."%' ")->row_array();

					if($request['type'] == 1) {
						// 1 = 8 AM to 2PM; 2 = 2 PM to 8 PM; 3 = 8 PM to 8 AM 
						$arrayName['dailyBedsheetChangeNurseId'] = $request['nurseId'];
						$arrayName['dailyBedsheetChange'] 	= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      		= 'Daily Bedsheet Change'; 
						$logData['oldValue']      			= (!empty($checkIfDataExist['dailyBedsheetChange'])) ? $checkIfDataExist['dailyBedsheetChange'] : NULL;
					} else if($request['type'] == 2) {
						// 1 = Yes; 2 = No
						$arrayName['loungeSanitationNurseId'] = $request['nurseId'];
						$arrayName['loungeSanitation'] 		= ($request['value'] != '') ? $request['value'] : NULL; 
						$logData['columnName']      		= 'Lounge Sanitation'; 
						$logData['oldValue']      			= (!empty($checkIfDataExist['loungeSanitation'])) ? $checkIfDataExist['loungeSanitation'] : NULL;
					} else if($request['type'] == 3) {
						// 1 = Yes; 2 = No
						$arrayName['toiletSanitationNurseId'] = $request['nurseId'];
						$arrayName['toiletSanitation'] 		= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      		= 'Toilet Sanitation';  
						$logData['oldValue']      			= (!empty($checkIfDataExist['toiletSanitation'])) ? $checkIfDataExist['toiletSanitation'] : NULL;
					} else if($request['type'] == 4) {
						// 1 = Yes; 2 = No
						$arrayName['commonAreaSanitationNurseId'] = $request['nurseId'];
						$arrayName['commonAreaSanitation'] 	= ($request['value'] != '') ? $request['value'] : NULL; 
						$logData['columnName']      		= 'Common Area Sanitation'; 
						$logData['oldValue']      			= (!empty($checkIfDataExist['commonAreaSanitation'])) ? $checkIfDataExist['commonAreaSanitation'] : NULL;
					} else if($request['type'] == 5) {
						// 1 = Yes; 2 = No
						$arrayName['mealsProvisionNurseId'] = $request['nurseId'];
						$arrayName['mealsProvision'] 		= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      		= 'Meals Provision'; 
						$logData['oldValue']      			= (!empty($checkIfDataExist['mealsProvision'])) ? $checkIfDataExist['mealsProvision'] : NULL;
					} else if($request['type'] == 6) {
						// 1 = Yes; 2 = No
						$arrayName['cleanWaterAvailabilityNurseId'] = $request['nurseId'];
						$arrayName['cleanWaterAvailability']	= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      			= 'Clean Water Availability'; 
						$logData['oldValue']      				= (!empty($checkIfDataExist['cleanWaterAvailability'])) ? $checkIfDataExist['cleanWaterAvailability'] : NULL;
					}

					$arrayName['latitude'] 				= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$arrayName['longitude'] 			= ($request['longitude'] != '') ? $request['longitude'] : NULL;

					$arrayName['lastSyncedTime']        = date('Y-m-d H:i:s');

					if(!empty($checkIfDataExist)) {
						$arrayName['modifyDate']            = $request['localDateTime'];

						$this->db->where('id',$checkIfDataExist['id']);
    					$this->db->update('loungeServices',$arrayName);

    					$lastID   = $checkIfDataExist['id'];
					} else {
						$arrayName['addDate']               = $request['localDateTime'];
						$arrayName['modifyDate']            = $request['localDateTime'];

						//get inserted lounge assessment id
				        $inserted = $this->db->insert('loungeServices', $arrayName);
						$lastID   = $this->db->insert_id();
					}


					$logData['tableReference']        	= 4;
					$logData['tableReferenceId']      	= $lastID;
					$logData['newValue']      			= ($request['value'] != '') ? $request['value'] : NULL;
					$logData['type']      				= 3;
					$logData['updatedBy']      			= $request['nurseId'];
					$logData['latitude'] 				= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$logData['longitude'] 				= ($request['longitude'] != '') ? $request['longitude'] : NULL;
					$logData['addDate']               	= $request['localDateTime'];
					$logData['lastSyncedTime']        	= date('Y-m-d H:i:s');

					$this->db->insert('logData', $logData);
					
					$listID['id']      = $lastID;
					$listID['localId'] = $request['localId'];;
					$param1[]          = $listID;

					##################################################################################################
					##################################################################################################
					################################## Here Update Part start ################################
					##################################################################################################
					##################################################################################################

	            } else {
	            	$getDuplicateData =  $this->db->get_where('loungeServices',array('androidUuid'=>$request['localId']))->row_array();

					$arrayName1 = array(); $logData = array();
			        $arrayName1['androidUuid']         	= $request['localId']; 
					$arrayName1['loungeId'] 		   	= $request['loungeId'];
					$arrayName1['nurseId'] 				= $request['nurseId'];
					
					$arrayName1['shift']      			= ($request['shift'] != '') ? $request['shift'] : NULL; 
					if($request['type'] == 1) {
						// 1 = 8 AM to 2PM; 2 = 2 PM to 8 PM; 3 = 8 PM to 8 AM 
						$arrayName1['dailyBedsheetChangeNurseId'] = $request['nurseId'];
						$arrayName1['dailyBedsheetChange'] 	= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      		= 'Daily Bedsheet Change'; 
						$logData['oldValue']      			= (!empty($getDuplicateData['dailyBedsheetChange'])) ? $getDuplicateData['dailyBedsheetChange'] : NULL;
					} else if($request['type'] == 2) {
						// 1 = Yes; 2 = No
						$arrayName1['loungeSanitationNurseId'] 	= $request['nurseId'];
						$arrayName1['loungeSanitation'] 		= ($request['value'] != '') ? $request['value'] : NULL; 
						$logData['columnName']      		= 'Lounge Sanitation'; 
						$logData['oldValue']      			= (!empty($getDuplicateData['loungeSanitation'])) ? $getDuplicateData['loungeSanitation'] : NULL;
					} else if($request['type'] == 3) {
						// 1 = Yes; 2 = No
						$arrayName1['toiletSanitationNurseId'] 	= $request['nurseId'];
						$arrayName1['toiletSanitation'] 		= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      		= 'Toilet Sanitation';  
						$logData['oldValue']      			= (!empty($getDuplicateData['toiletSanitation'])) ? $getDuplicateData['toiletSanitation'] : NULL;
					} else if($request['type'] == 4) {
						// 1 = Yes; 2 = No
						$arrayName1['commonAreaSanitationNurseId'] 	= $request['nurseId'];
						$arrayName1['commonAreaSanitation'] 	= ($request['value'] != '') ? $request['value'] : NULL; 
						$logData['columnName']      		= 'Common Area Sanitation'; 
						$logData['oldValue']      			= (!empty($getDuplicateData['commonAreaSanitation'])) ? $getDuplicateData['commonAreaSanitation'] : NULL;
					} else if($request['type'] == 5) {
						// 1 = Yes; 2 = No
						$arrayName1['mealsProvisionNurseId'] = $request['nurseId'];
						$arrayName1['mealsProvision'] 		= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      		= 'Meals Provision'; 
						$logData['oldValue']      			= (!empty($getDuplicateData['mealsProvision'])) ? $getDuplicateData['mealsProvision'] : NULL;
					} else if($request['type'] == 6) {
						// 1 = Yes; 2 = No
						$arrayName1['cleanWaterAvailabilityNurseId'] = $request['nurseId'];
						$arrayName1['cleanWaterAvailability']	= ($request['value'] != '') ? $request['value'] : NULL;
						$logData['columnName']      			= 'Clean Water Availability'; 
						$logData['oldValue']      				= (!empty($getDuplicateData['cleanWaterAvailability'])) ? $getDuplicateData['cleanWaterAvailability'] : NULL;
					}

					$arrayName1['latitude'] 			= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$arrayName1['longitude'] 			= ($request['longitude'] != '') ? $request['longitude'] : NULL; 	

					$arrayName1['addDate']              = $request['localDateTime'];
					$arrayName1['modifyDate']           = $request['localDateTime'];
					$arrayName1['lastSyncedTime']       = date('Y-m-d H:i:s');

					$this->db->where('androidUuid',$request['localId']);
					$this->db->update('loungeServices', $arrayName1);	
					$lastID = $this->db->get_where('loungeServices',array('androidUuid'=>$request['localId']))->row_array();
					$listID['id']      = $lastID['id'];


					$logData['tableReference']        	= 4;
					$logData['tableReferenceId']      	= $lastID['id'];
					$logData['newValue']      			= ($request['value'] != '') ? $request['value'] : NULL;
					$logData['type']      				= 3;
					$logData['updatedBy']      			= $request['nurseId'];
					$logData['latitude'] 				= ($request['latitude'] != '') ? $request['latitude'] : NULL; 
					$logData['longitude'] 				= ($request['longitude'] != '') ? $request['longitude'] : NULL;
					$logData['addDate']               	= $request['localDateTime'];
					$logData['lastSyncedTime']        	= date('Y-m-d H:i:s');

					$this->db->insert('logData', $logData);
					
                   
					$listID['localId'] = $request['localId'];
					$param1[] = $listID;            	
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



    public function updateLoungePassword($request){

    	$getLoungeData =  $this->db->get_where('loungeMaster',array('loungeId'=>$request['loungeId']))->row_array();

    	$oldPassword = $getLoungeData['loungePassword'];

    	if($oldPassword == md5($request['oldPassword'])) {

	    	$loungeData = array('loungePassword' 	=> md5($request['newPassword']), 
	    						'modifyDate' 		=> date('Y-m-d H:i:s')
	    				  );

	    	$this->db->where('loungeId',$request['loungeId']);
	    	$this->db->update('loungeMaster',$loungeData);

	    	$logData = array( 'tableReference' => 2,
	    					  'tableReferenceId' => $request['loungeId'],
	    					  'columnName' 	=> 'Lounge Password',
	    					  'oldValue' 	=> $oldPassword,
	    					  'newValue' 	=> md5($request['newPassword']),
	    					  'updatedBy' 	=> $request['nurseId'],
	    					  'type' 	    => '3',
	    					  'addDate' 		=> date('Y-m-d H:i:s'),
	    					  'lastSyncedTime'  => date('Y-m-d H:i:s')
	    			 );

	    	$inserted = $this->db->insert('logData', $logData);

	    	$listID['loungeId']     = $request['loungeId'];
			$listID['nurseId'] 		= $request['nurseId'];
			$param1[]          		= $listID;

			$data['id'] = $param1; 
            generateServerResponse('1','S', $data);

	    } else {
	    	generateServerResponse('0','221');
	    }
    }


}