<?php
class LongeModel extends CI_Model {
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


}