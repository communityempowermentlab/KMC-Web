<?php
class Baby_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	}
	

	public function GetBabyDetail($request)
	{
		return $this->db->query("SELECT BM.* FROM baby_monitoring as BM LEFT join baby_admission as BA  on BA.`BabyID` = BM.`BabyID`  where  BA.`LoungeID` ='".$request['LoungeID']."' AND BA.`BabyID` ='".$request['BabyID']."'")->result_array();
	}
	public function Baby_Registration($request)
	{
		$arrayName = array();

		$arrayName['BabyMCTSNumber']= ($request['BabyMCTSNumber']!='')? $arrayName['BabyMCTSNumber']= $request['BabyMCTSNumber'] : NULL;
		$arrayName['MotherID'] = ($request['MotherID']!='')? $request['MotherID']:NULL;
		$arrayName['DeliveryDate'] = ($request['DeliveryDate']!='')? $request['DeliveryDate']:NULL;
		$arrayName['DeliveryTime'] = ($request['DeliveryTime']!='')? $request['DeliveryTime']:NULL;
		$arrayName['BabyGender'] = ($request['BabyGender']!='')? $request['BabyGender']:NULL;
		$arrayName['DeliveryType'] = ($request['DeliveryType']!='')? $request['DeliveryType']:NULL;		
		$arrayName['FirstTimeFeed'] = ($request['FirstTimeFeed']!='')? $request['FirstTimeFeed']:NULL;
		$arrayName['BabyCryAfterBirth'] = ($request['BabyCryAfterBirth']!='')? $request['BabyCryAfterBirth']:NULL;
		$arrayName['BabyNeedBreathingHelp'] = ($request['BabyNeedBreathingHelp']!='')? $request['BabyNeedBreathingHelp']:NULL;


		if($request['BirthWeightAvail']=='0'){
			$arrayName['BirthWeightAvail'] = '2';
			$arrayName['BabyWeight'] = NULL;
			$arrayName['Reason'] = $request['Reason'] ;
		}elseif($request['BirthWeightAvail']=='1'){
			$arrayName['BirthWeightAvail'] = '1';
			$arrayName['BabyWeight'] = $request['BabyWeight'] ;
		}
			$arrayName['BabyPhoto']  = ($request['BabyPhoto']!='') ? saveProfilesImage2($request['BabyPhoto'],BABY_DIRECTORY) :NULL;	
			$arrayName['RegistrationDateTime'] = time();
			$arrayName['add_date'] 			 = time();
			$arrayName['modify_date'] 		 = time();
			
			$inserted = $this->db->insert('baby_registration',$arrayName);
			$last_id  = $this->db->insert_id();

		 	$fileName = "b_".$last_id.".pdf";
         // check Unknown Case
            $checkUnknownCase = $this->db->get_where('mother_registration',array('MotherID'=>$request['MotherID']))->row_array();
            if($checkUnknownCase['Type'] == '2'){
            	$this->db->where('MotherID',$request['MotherID']);
            	$this->db->update('mother_registration',array('RegisteredByLoungeId'=>$request['LoungeId']));
            }

		if($inserted>0){
			$baby                       = array();
            $baby['BabyID']  			= $last_id;
			$baby['AdmissionDateTime']  = time();
			$baby['LoungeId']			= ($request['LoungeId']!='')? $request['LoungeId']: NULL;			
			$baby['BabyFileID']			= ($request['BabyFileID']!='')? $request['BabyFileID']: NULL;
			//$baby['BabyAdmissionWeight']= ($request['BabyWeight']!='') ? $request['BabyWeight'] : NULL;
			$baby['add_date']		    = time();
			$baby['status']			    = '1';
			$baby['modify_date']		= time();

			$BadyAdmission  = $this->db->insert('baby_admission',$baby);
			$BabyinsertedId = $this->db->insert_id();

		return $last_id;

		}
		
	}
	
	
	public function CheckUniqueValue($BabyFileID, $BabyID='')
	{
	 	if($BabyID!='')
	 	{
	 		 $this->db->get_where('baby_admission', array('BabyFileID'=>$BabyFileID, 'BabyID !='=>$BabyID))->num_rows();
	        //echo $this->db->last_query();die();
	 	} else{
	 		return $this->db->get_where('baby_admission', array('BabyFileID'=>$BabyFileID))->num_rows();
	 	}
	}
      // these function for update baby reg.
	public function CheckUniqueBabyFileId($BabyFileID, $BabyID='',$lounge_id)
	{
	
        $res = $this->db->get_where('baby_admission', array('BabyID'=>$BabyID,'BabyFileID'=>$BabyFileID,'LoungeID'=>$lounge_id,'status'=>1))->num_rows();
	  	if($res > 0)
	 	{
	 	 return 0;
	 	}else {
		 	$res1 = $this->db->get_where('baby_admission', array('BabyID'=>$BabyID,'LoungeID'=>$lounge_id,'status'=>1))->num_rows();
			 if($res1 > 0)
			 	{
			 		$res2 = $this->db->get_where('baby_admission', array('BabyFileID'=>$BabyFileID))->num_rows();
			      if($res2 > 0)
			      {
			      	return 1;
			      } else {
			      	return 0;
			      }    
			 	}else {
			 		return 0;
			 	}
	    }
	}



	public function Update_Baby_Registration($request)
	{
		
		$arrayName= array();

		$arrayName['BabyMCTSNumber']= ($request['BabyMCTSNumber']!='')? $request['BabyMCTSNumber'] : NULL;
		//$arrayName['MotherID'] = ($request['MotherID']!='')? $request['MotherID']:NULL;
		//$arrayName['BabyFileID'] = ($request['BabyFileID']!='')? $request['BabyFileID']:NULL;
		$arrayName['DeliveryDate'] = ($request['DeliveryDate']!='')? $request['DeliveryDate']:NULL;
		$arrayName['DeliveryTime'] = ($request['DeliveryTime']!='')? $request['DeliveryTime']:NULL;
		$arrayName['BabyGender'] = ($request['BabyGender']!='')? $request['BabyGender']:NULL;
		$arrayName['DeliveryType'] = ($request['DeliveryType']!='')? $request['DeliveryType']:NULL;
		$arrayName['FirstTimeFeed'] = ($request['FirstTimeFeed']!='')? $request['FirstTimeFeed']:NULL;
		$arrayName['BabyCryAfterBirth'] = ($request['BabyCryAfterBirth']!='')? $request['BabyCryAfterBirth']:NULL;
		$arrayName['BabyNeedBreathingHelp'] = ($request['BabyNeedBreathingHelp']!='')? $request['BabyNeedBreathingHelp']:NULL;

		if($request['BirthWeigthAvail']=='1'){
		    $arrayName['BabyWeight'] = ($request['BabyWeight']!='')? $request['BabyWeight']:NULL;
		}else{
			$arrayName['Reason'] = ($request['Reason']!='')? $request['Reason'] : NULL ;
		}
		if ((strpos($request['BabyPhoto'], '.png') != True)&&(strpos($request['BabyPhoto'], '.jpg') != True)){

			if($request['BabyPhoto']!=''){
				$BabyImage=  saveProfilesImage2($request['BabyPhoto'],BABY_DIRECTORY,'b_'.$request['BabyID']);
				$arrayName['BabyPhoto']  =  ($BabyImage!='') ? $BabyImage : NULL;
			}	
		}		
		$arrayName['modify_date'] 		 = time();
		$this->db->where('BabyID', $request['BabyID']);
		$update = $this->db->update('baby_registration',$arrayName);

     	$this->db->order_by('id','desc');
        $babyAdmisionLastId =  $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID'],'LoungeID'=>$request['lounge_id']))->row_array();

        $this->db->where('id',$babyAdmisionLastId['id']);
        $this->db->update('baby_admission',array('BabyFileID'=>$request['BabyFileID']));


		$fileName = "b_".$babyAdmisionLastId['id'].".pdf";
		if($update >0){

			$PdfFile = $this->Mother_baby_admission_model->pdfconventer($fileName,$babyAdmisionLastId['id']);
	 			$this->db->where('id',$babyAdmisionLastId['id']);
	 			$this->db->update('baby_admission', array('BabyPDFFileName'=>$fileName));
		return $request['BabyID'];

		}	
		return 1;
	}

	public function BabyFeedDeatil($BabyID,$LoungeID)
	{
		/*echo date('Y-m-d', strtotime('-3 day')); exit;*/
		return $this->db->query("SELECT * From breast_feeding_master where BabyID ='15' And LoungeID ='".$LoungeID."' And FeedDate >= '".date('Y-m-d', strtotime('-3 day'))."' AND FeedDate <= '".date('Y-m-d')."'")->result_array();
	}


	public function GetBabies($request ='')
	{
		/*SELECT BR.`BabyPhoto`,BR.`MotherID`,MR.`MotherName`,
		BA.`BabyID`, BM.`AssesmentDate`, BM.`AssesmentTime` FROM 
		baby_admission as BA LEFT JOIN baby_registration  as BR on BA.`BabyID` = BA.`BabyID` 
		LEFT JOIN mother_registration as MR on BR.`MotherID` = MR.`MotherID` 
		LEFT JOIN baby_monitoring as BM on BM.`BabyID` = BA.`BabyID`
         where  BA.`LoungeId` = 11 GROUP BY BA.`BabyID` order by BA.`BabyID` desc order by BM.`id` desc*/
		 /*$this->db->query("SELECT BR.`BabyPhoto`,BM.`BabyTemperature`, BM.`BabyRespiratoryRate` , BM.`BabyPulseSpO2`,  BR.`MotherID`, MR.`MotherName`,	BA.`BabyID`, BA.`add_date`,   BA.`id` as baby_admission_table_id , BM.`AssesmentDate`, BM.`AssesmentTime` FROM 
		baby_admission as BA LEFT JOIN baby_registration as BR on BA.`BabyID` = BR.`BabyID` 
		LEFT JOIN mother_registration as MR on BR.`MotherID` = MR.`MotherID` 
		LEFT JOIN baby_monitoring as BM on BM.`BabyID` = BA.`BabyID`
         where  BA.`LoungeId` = '".$request['lounge_id']."' GROUP BY BA.`BabyID` order by BA.`BabyID` desc")->result_array();*/


        return $this->db->query("SELECT  Distinct BA.`BabyID` , BA.`LoungeID`, BA.`BabyAdmissionWeight` , BA.`id` AS baby_admission_table_id FROM baby_admission AS BA  WHERE BA.`LoungeId` =  '".$request['lounge_id']."'  AND BA.`status` !=2 ORDER BY BA.`BabyID` DESC ")->result_array();


        return $this->db->query("SELECT  BR.`BabyPhoto`,BM.`BabyTemperature`, BM.`BabyRespiratoryRate` , BM.`BabyPulseSpO2`, BR.`MotherID`, MR.`MotherName`,	BA.`BabyID`, 	BA.`BabyAdmissionWeight`,   BA.`id` as baby_admission_table_id , BM.`add_date`, BM.`modify_date` FROM 
		baby_admission as BA LEFT JOIN baby_registration as BR on BA.`BabyID` = BR.`BabyID` 
		LEFT JOIN mother_registration as MR on BR.`MotherID` = MR.`MotherID` 
		LEFT JOIN baby_monitoring as BM on BM.`BabyID` = BA.`BabyID`
         where  BA.`LoungeId` = '".$request['lounge_id']."'  AND  BA.`status`!=2 GROUP BY BA.`BabyID` order by BM.`BabyID` desc")->result_array();

//echo $this->db->last_query();exit;
}

 public function GetDetailForYellowSign($BabyID, $LoungeID)
 {
 	return $this->db->query("SELECT * FROM  `baby_weight_master` where BabyID  = '".$BabyID."' AND LoungeID  = '".$LoungeID."'  ")->result_array(); 
 }

	public function BabyMonitering($request)
	{
      //get last Baby AdmissionId
     	$this->db->order_by('id','desc');
        $babyAdmisionLastId =  $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID']))->row_array();

		$getCount = $this->db->query("SELECT * FROM baby_monitoring where LoungeID ='".$request['LoungeID']."' And BabyID ='".$request['BabyID']."' ")->num_rows();
        $request['baby_admissionID'] = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
		$request['StaffSign'] = ($request['StaffSign']!='') ? saveProfilesImage2($request['StaffSign'],SIGN_DIRECTORY) :'NULL';	
		$request['status'] = '1';
		$request['AssesmentDate'] = date('Y-m-d');    
		$request['AssesmentNumber'] = $getCount + 1;	
		$request['AssesmentTime'] = date('H:i');     
		$request['StaffID'] = $request['StaffID'];     
		$request['add_date'] = time();
		$request['modify_date'] = time();
		$ReturnArray = CheckForNullVaLue($request);
		
		$insert = $this->db->insert('baby_monitoring',$ReturnArray);
         $lastAssessmeniID = $this->db->insert_id();
		$mothername = $this->db->query("SELECT MR.`MotherID`, MR.`MotherName`, BA.`BabyID` FROM  baby_registration AS BA LEFT JOIN  mother_registration AS MR  On BA.`MotherID` = MR.`MotherID`  where  BA.`BabyID` ='".$request['BabyID']."'")->row_array();

		$LoungeName  = singlerowparameter2('LoungeName','LoungeID',$request['LoungeID'],'lounge_master'); 
		

		$status1 = '0';
		$status2 = '0';
		$status3 = '0';
		if($insert > 0){



		/*Type = 3 for BabyMonitering*/
		$getpoints = $this->db->get_where('pointmaster',array('Type'=>'3','Status'=>'1'))->row_array();
		if($getpoints > 0)
		{    
			$field = array();
			$field['NurseId']               = $request['StaffID'];
			$field['LoungeId']              = $request['LoungeID'];
			$field['Points']                = $getpoints['Point'];
			$field['GrantedForID']          = $lastAssessmeniID;
			$field['Type']                  = $getpoints['Type'];
			$field['TransactionStatus']     = 'Credit';
			$field['AddDate']               = time();
			$field['ModifyDate']            = time();
			$this->db->insert('pointstransactions',$field);
		}

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


			if($request['BabyRespiratoryRate']>60 || $request['BabyRespiratoryRate']<30){
        		$status1 = '1';
        	}
        	if($request['BabyTemperature'] < 95.9 || $request['BabyTemperature'] > 99.5){
        		$status2 = '1';
        	}
        	if($request['BabyPulseSpO2'] < 95 ){
        		$status3 = '1';
        	}			        	
    		if($status1 == 1 || $status2 == 1 || $status3 == 1)
    		{ 

    			 $getNumbers = $this->db->query("SELECT SM.`StaffMoblieNo`, SM.`staff_sub_type`, LM.`FacilityID`, SM.`staff_sub_type` FROM lounge_master as LM LEFT JOIN staff_master as SM  On LM.`FacilityID` = SM.`FacilityID` WHERE SM.`staff_sub_type`= 9  OR SM.`staff_sub_type`= 30 AND  LM.`LoungeID`= '".$request['LoungeID']."'  ")->result_array();
    			

				$TEXT = "B/o ".$mothername['MotherName']." from ".$LoungeName." lounge is in danger, Respiratory Rate ".$request['BabyRespiratoryRate'].", Temperature ".$request['BabyTemperature'].", Spo2 ".$request['BabyPulseSpO2'].". Kindly Assist";
					/*echo  count($getNumbers); exit;*/
        		foreach ($getNumbers as $key => $value) {
        			if($value['StaffMoblieNo']!='' && strlen($value['StaffMoblieNo'])==10){

                     sendMobileMessage($value['StaffMoblieNo'],$TEXT);
					    $insertSms = array(); 
						$insertSms['FacilityID'] = $value['FacilityID'];
			            $insertSms['Messege'] 	 = $TEXT;
			           
			            $insertSms['SendTo'] 	 = $value['StaffMoblieNo'];
			            $insertSms['Time'] 		 = date('H:i:00');
			            $insertSms['Date'] 		 = date('Y-m-d');
			            $insertSms['AddDate']    = time();
			            $this->db->insert('smsmaster',$insertSms);
				           					
        			}
        		}

        	}

		}
		return $insert;

	}

	public function NewGetBabyDetail($request,$admisionId='')
	{
		return $this->db->query("SELECT BA.`BabyAdmissionWeight` , BA.`BabyFeedingPdfName`, BA.`BabyKMCPdfName`, BA.`BabyWeightPdfName`,  BA.`LoungeID`, BA.`AdmissionDateTime`, BA.`add_date`,BM.* FROM baby_monitoring as BM LEFT join baby_admission as BA  on BA.`BabyID` = BM.`BabyID`  where  BA.`BabyID` ='".$request['BabyID']."' and BA.`id`='".$admisionId."' and BM.`baby_admissionID`='".$admisionId."' order by BM.`id` desc limit 0,1 ")->row_array();
	     //echo $this->db->last_query();exit;
	}


	public function GetBabyWeight($BabyID,$order_by,$LoungeID='',$limit='',$admisionId='')
	{
		($limit!='')  ? $this->db->limit($limit) :'';
		$this->db->order_by('ID',$order_by);
		 if($LoungeID!=''){
			return $this->db->get_where('baby_weight_master',array('BabyID'=>$BabyID,'LoungeID'=>$LoungeID,'baby_admissionID'=>$admisionId))->result_array();
		 	
		 }else{
		 	return $this->db->get_where('baby_weight_master',array('BabyID'=>$BabyID,'baby_admissionID'=>$admisionId))->result_array();
		 }
	}


	public function GetBabyFeedingDetail($BabyID,$LoungeID,$order_by,$limit='')
	{	
		$this->db->select('BreastFeedMethod');
		$this->db->select('FeedingType');
		($limit!='')  ? $this->db->limit($limit) :'';
		$this->db->order_by('ID',$order_by);
		return $this->db->get_where('breast_feeding_master',array('BabyID'=>$BabyID, 'LoungeID'=>$LoungeID))->result_array();
	}


	public function BabyMonitoringData($BabyID,$LoungeID,$order_by,$limit='')
	{
		$this->db->select('BabyRespiratoryRate');
		$this->db->select('BabyTemperature');
		$this->db->select('BabyOtherDangerSign');
		($limit!='')  ? $this->db->limit($limit) :'';
		$this->db->order_by('id',$order_by);
		return $this->db->get_where('baby_monitoring', array('BabyID'=>$BabyID, 'LoungeID'=>$LoungeID))->result_array();

	}
	/*public function GetBabySPO2($BabyID)
	{
		 $this->db->select('BabyPulseSpO2');
		return  $this->db->get_where('baby_monitoring', array('BabyID'=>$BabyID))->result_array();
	}
*/
	public function GetDetailForBaby($request,$admisionID='')
	{
	 	$this->db->select('BabyPulseSpO2');
	 	$this->db->select('BabyRespiratoryRate');
	 	$this->db->select('BabyTemperature');
	 	$this->db->select('BabyPulseRate');
	 	$this->db->select('add_date');
		return  $this->db->get_where('baby_monitoring', array('BabyID'=>$request['BabyID'],'baby_admissionID'=>$admisionID))->result_array();
	}

	public function GetBreastFeedingDetail($request)
	{
		return	$this->db->get_where('breast_feeding_master',array('LoungeID'=>$request['LoungeID'],'BabyID'=>$request['BabyID']))->result_array();
	}


	public function GetBreastFeedingDetail2($request, $date,$admisionID='')
	{
		return	$this->db->query("SELECT SUM(MilkQuantity) as sum   FROM `breast_feeding_master` WHERE `LoungeID` = '".$request['LoungeID']."' AND `BabyID` = '".$request['BabyID']."' AND  `FeedDate` = '".$date."' and `baby_admissionID`='".$admisionID."'")->result_array();
	}




	public function GetSSTDetail($request)
	{
		$this->db->order_by('AddDate','ASC');
		return	$this->db->get_where('skintoskin_touch_master',array('LoungeID'=>$request['LoungeID'],'BabyID'=>$request['BabyID']))->result_array();
	}

	public function GetSSTDetail2($request, $date,$admisionID='')
	{
		$query = $this->db->query("SELECT *  FROM `skintoskin_touch_master` WHERE `LoungeID` = '".$request['LoungeID']."' AND `BabyID` = '".$request['BabyID']."' AND  `SkinDate` = '".$date."' and `baby_admissionID`='".$admisionID."'")->result_array();

		 $sum =array();

		foreach ($query as $key => $value) {
		 	$sum[] =   getTimeDiff($value['StartTime'],$value['EndTime']);
		}
		return (SumOfDuration($sum)!='')? SumOfDuration($sum):'0';
	}
	
	public function GetBabyWeight2($BabyID,$order_by,$WeightDate='',$admisionID='')
	{
		$this->db->order_by('ID',$order_by);
		$this->db->select('BabyWeight');
		return $this->db->get_where('baby_weight_master',array('BabyID'=>$BabyID,'WeightDate'=>$WeightDate,'baby_admissionID'=>$admisionID))->row_array();
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

    
    	public function BabyVaccination($request)
	{
		
		$arrayName = array();
		$arrayName['BabyID'] 		  = $request['BabyID'];
		$arrayName['LoungeID'] 		  = $request['LoungeID'];
		$arrayName['VaccinationName'] = $request['VaccinationName'];
		$arrayName['Quantity'] 		  = $request['Quantity'];
		$arrayName['VaccinationDate'] = date('Y-m-d',strtotime($request['VaccinationDate']));
		$arrayName['VaccinationTime'] = $request['VaccinationTime'];
		$arrayName['AddDate'] 		  = time();
      //get last Baby AdmissionId
     	$this->db->order_by('id','desc');
        $babyAdmisionLastId =  $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID']))->row_array();
		$arrayName['baby_admissionID']    = ($babyAdmisionLastId['id'] != '') ? $babyAdmisionLastId['id'] : NULL;
		$inserted = $this->db->insert('babyvaccination', $arrayName);
	
		($inserted >0) ? generateServerResponse('1','S') : generateServerResponse('0','E');



	}

	public function GetVaccination($request)
	{

	    $this->db->order_by('id','desc');
        $getBabyFileId = $this->db->get_where('baby_admission',array('BabyID'=>$request['BabyID']))->row_array();

	 	$this->db->order_by('ID','DESC');
	 	$GetData = $this->db->get_where('babyvaccination', array('BabyID'=>$request['BabyID'], 'LoungeID'=>$request['LoungeID'],'baby_admissionID'=>$getBabyFileId['id']))->result_array();
	 	$arrayName = array();
	 	if(count($GetData)>0)
	 	{

		 	foreach ($GetData as $key => $value){

		 		$Hold['vaccination_name'] = $value['VaccinationName'];
		 		$Hold['quantity'] = $value['Quantity'];
		 		$Hold['date'] = $value['VaccinationDate'];
		 		$Hold['time'] = $value['VaccinationTime'];


		 		$arrayName[] = $Hold;
		 	}
	 	}

	 	$response['list'] = $arrayName;
	 	(count($response['list'])>0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
	}

}