<?php
class CommonModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		date_default_timezone_set("Asia/KolKata");
	}
	
public function GetMotherDetail($request)
   {
            $query = $this->getMotherViaPaging($request['loungeId'],$request['offset']);
            $array  = array();
            $arr    = array();
          foreach ($query as $value) {

		 		$Hold['motherId']                    = $value['motherId'];
		 		$Hold['motherName']                  = $value['motherName'];
		 		$Hold['motherAdmission']             = $value['motherAdmission'];
		 		$Hold['reasonNotAdmitted']     		 = $value['notAdmittedreason'];
		 		$Hold['motherPicture']               = base_url().'assets/images/motherDirectoryUrls/'.$value['motherPicture'];
		 		$Hold['hospitalRegistrationNumber']  = $value['hospitalRegistrationNumber'];
		 		$Hold['motherMCTSNumber']            = $value['motherMCTSNumber'];
		 		$Hold['motherAadharNumber']          = $value['motherAadharNumber'];
		 		$Hold['motherDOB']                   = $value['motherDOB'];
		 		$Hold['motherAge']                   = $value['motherAge'];
		 		$Hold['motherEducation']             = $value['motherEducation'];
		 		$Hold['motherCaste']                 = $value['motherCaste'];
		 		$Hold['motherReligion']              = $value['motherReligion'];
		 		$Hold['motherMoblieNumber']              = $value['motherMoblieNumber'];
		 		$Hold['fatherName']                  = $value['fatherName'];
		 		$Hold['fatherAadharNumber']          = $value['fatherAadharNumber'];
		 		//$Hold['father_dob']                  = $value['father_dob'];
		 		//$Hold['father_age']                  = $value['father_age'];
		 		$Hold['fatherMoblieNumber']              = $value['fatherMoblieNumber'];
		 		$Hold['rationCardType']              = $value['rationCardType'];
		 		$Hold['guardianName']                = $value['guardianName'];
		 		$Hold['guardianNumber']              = $value['guardianNumber'];
		 		$Hold['guardianRelation']            = $value['guardianRelation'];
		 		$Hold['presentCountry']              = $value['presentCountry'];
		 		$Hold['presentState']            	 = $value['presentState'];
		 		$Hold['permanentCountry']            = $value['permanentCountry'];
		 		$Hold['permanentState']              = $value['permanentState'];
		 		$Hold['presentResidenceType']        = $value['presentResidenceType'];
		 		//$Hold['PresentHamletName']           = $value['PresentHamletName'];
		 		$Hold['presentVillageName']          = $value['presentVillageName'];
		 		$Hold['presentBlockName']            = $value['presentBlockName'];
		 		$Hold['presentDistrictName']         = $value['presentDistrictName'];
		 		$Hold['permanentResidenceType']      = $value['permanentResidenceType'];
		 		$Hold['permanentAddress']            = $value['permanentAddress'];
		 		$Hold['PermanentHamletName']         = $value['PermanentHamletName'];
		 		$Hold['permanentVillageName']        = $value['permanentVillageName'];
		 		$Hold['permanentBlockName']          = $value['permanentBlockName'];
		 		$Hold['permanentDistrictName']       = $value['permanentDistrictName'];
		 		$Hold['presentPinCode']              = $value['presentPinCode'];
		 		$Hold['permanentPinCode']            = $value['permanentPinCode'];
		 		$Hold['ashaId']                      = $value['ashaId'];
		 		$Hold['ashaName']                    = $value['ashaName'];
		 		$Hold['ashaNumber']                  = $value['ashaNumber'];
		 		//$Hold['registrationDateTime']        = $value['registrationDateTime'];
		 		$Hold['presentAddNearByLocation']        = $value['presentAddNearByLocation'];
		 		$Hold['permanentAddNearByLocation']      = $value['permanentAddNearByLocation'];
		 		$Hold['staffId']                     = $value['staffId'];
		 		$Hold['type']                        = $value['type'];
		 		$Hold['OrganizationName']            = $value['OrganizationName'];
		 		$Hold['OrganizationNumber']          = $value['OrganizationNumber'];
		 		$Hold['OrganizationAddress']         = $value['OrganizationAddress'];
		 		$Hold['status']                      = $value['status'];
		 		$Hold['para']                        = $value['para'];
		 		$Hold['abortion']                    = $value['abortion'];
		 		$Hold['live']                        = $value['live'];
		 		$Hold['multipleBirth']               = $value['multipleBirth'];
		 		$Hold['AdmittedSign']                = $value['AdmittedSign'];
		 		$Hold['gravida']                     = $value['gravida'];
		 		$Hold['addDate']                     = $value['addDate'];
		 		$Hold['modifyDate']                 = $value['modifyDate'];
		 		$Hold['motherLmpDate']               = $value['motherLmpDate'];
		 		$Hold['deliveryPlace']         = $value['deliveryPlace'];
		 		$Hold['deliveryDistrict']      = $value['deliveryDistrict'];
		 		$Hold['facilityId']                  = $value['facilityId'];
		 		


		 		$Hold['loungeId']                    = $value['loungeId'];
		 		//$Hold['deliveryDateTime']            = $value['deliveryDateTime'];
		 		//$Hold['deliveryType']                = $value['deliveryType'];
		 		//$Hold['NumberOfBabies']              = $value['NumberOfBabies'];
		 		//$Hold['LMPDate']                     = $value['LMPDate'];
		 		//$Hold['FirstPregnancy']              = $value['FirstPregnancy'];
		 		//$Hold['MotherBleedingStatus']        = $value['MotherBleedingStatus'];
		 		//$Hold['motherTemperature']           = $value['motherTemperature'];
		 		$Hold['admittedPersonSign']          = $value['admittedPersonSign'];
		 		$Hold['referredFacility']        = $value['referredFacility'];
		 		$Hold['referredFacilityAddress']     = $value['referredFacilityAddress'];
		 		$Hold['typeOfDischarge']             = $value['typeOfDischarge'];
		 		$Hold['referredReason']              = $value['referredReason'];
		 		$Hold['dischargeByDoctor']           = $value['dischargeByDoctor'];
		 		$Hold['dischargeByNurse']            = $value['dischargeByNurse'];
		 		$Hold['transportation']              = $value['transportation'];
		 		$Hold['signOfFamilyMember']          = $value['signOfFamilyMember'];
		 		$Hold['DischargeChecklist']          = $value['DischargeChecklist'];
		 		$Hold['DateOfFollowUpVisit']         = $value['DateOfFollowUpVisit'];
		 		$Hold['doctorSign']                  = $value['doctorSign'];
		 		$Hold['dateOfDischarge']              = $value['dateOfDischarge'];
		 		$Hold['ashaSign']                    = $value['ashaSign'];
		 		$Hold['status']                      = $value['status'];
		 		$Hold['addDate']                    = $value['addDate'];
		 		$Hold['modifyDate']                 = $value['modifyDate'];

                $arr[] = $Hold;
            }
           
               $resposne['data']          = $arr;
               $resposne['md5Data']       = md5(json_encode($resposne['data']));
               $resposne['result_found']  = count($query);
               $resposne['offset']        = count($query)+$request['offset'];

                   if (count($resposne['data']) > 0) {

                       generateServerResponse('1','S',$resposne);

                   } else {

                       generateServerResponse('0','E');
                    }

}


  public function getMotherViaPaging($loungeId,$offset) {
        $offset = ($offset!='') ? $offset : 0;
        $limit =10 ;
        return $this->db->query("select mr.*,ma.* from motherRegistration as mr right join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeId." and ma.`status`='2' order by id desc limit ".$offset.",".$limit."")->result_array();
      }

	public function GetBabyDetail($loungeId)
	{

        $this->db->order_by('id','desc');
		$this->db->select('babyAdmission.*,babyRegistration.*');
		$this->db->from('babyAdmission');
		$this->db->join('babyRegistration','babyRegistration.babyId=babyAdmission.babyId','inner');
		$this->db->where('babyAdmission.loungeId',$loungeId);
		$this->db->where('babyAdmission.status',2);
		$this->db->where('`babyAdmission.babyId` NOT IN (SELECT `babyId` FROM `babyAdmission` where status= 1)');
		$getBabyDetails=$this->db->get()->result_array();
                $arrayName = array();
	 	if(count($getBabyDetails)>0)
	 	{
             
		 	foreach ($getBabyDetails as $key => $value){

		 		$Hold['babyId']                      = $value['babyId'];
		 		$Hold['babyPhoto']                   = base_url().'assets/images/babyDirectoryUrls/'.$value['babyPhoto'];
		 		$Hold['motherId']                    = $value['motherId'];
		 		$getMother = $this->db->get_where('motherRegistration',array('motherId'=>$value['motherId']))->row_array();
		 		$Hold['motherName']                  = $getMother['motherName'];
		 		$Hold['motherPicture']               = base_url().'assets/images/motherDirectoryUrls/'.$getMother['motherPicture'];
		 		$Hold['loungeId']                    = $value['loungeId'];
		 		$getLounge = $this->db->get_where('loungeMaster',array('loungeId'=>$value['loungeId']))->row_array();
		 		$Hold['loungeName']                  = $getLounge['loungeName'];
		 		$Hold['AdmissionDateTime']           = $value['AdmissionDateTime'];
		 		$Hold['DischargeDateTime']           = $value['dateOfDischarge'];
		 		$DoctorName = $this->db->get_where('staffMaster',array('staffId'=>$value['dischargeByDoctor']))->row_array();
		 		$Hold['dischargeByDoctor']           = $DoctorName['Name'];


		 		$arrayName[] = $Hold;
		 	}
	 	}

	 	 $response['data']       = $arrayName;
	 	 $response['md5Data']    = md5(json_encode($response['data']));
	 	(count($response['data']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
	}

	public function GetMoreRecord($babyId)
	{

       $getBabyDetails = $this->db->get_where('babyRegistration',array('babyId'=>$babyId))->row_array();
       
       $this->db->order_by('id','desc');
       $babyAdmissionDetails = $this->db->get_where('babyAdmission',array('babyId'=>$babyId))->row_array();
     
      // echo $this->db->last_query();exit;
        $arrayName = array();
	 	if(count($getBabyDetails) > 0)
	 	{
             
		 		$Hold['babyId']                      = $getBabyDetails['babyId'];
		 		$Hold['babyFileId']                  = $babyAdmissionDetails['babyFileId'];
		 		$Hold['babyPhoto']                   = babyDirectoryUrl.$getBabyDetails['babyPhoto'];
		 		$Hold['motherId']                    = $getBabyDetails['motherId'];
		 		$Hold['deliveryDate']                = $getBabyDetails['deliveryDate'];
		 		$Hold['deliveryTime']                = $getBabyDetails['deliveryTime'];
		 		$Hold['babyGender']                  = $getBabyDetails['babyGender'];
		 		$Hold['deliveryType']                = $getBabyDetails['deliveryType'];
		 		$Hold['babyWeight']                  = $getBabyDetails['babyWeight'];

		 		$Hold['birthWeightAvail']            = $getBabyDetails['birthWeightAvail'];
		 		$Hold['reason']                      = $getBabyDetails['reason'];
		 		$Hold['typeOfBorn']           		 = $getBabyDetails['typeOfBorn'];
		 		$Hold['typeOfOutBorn']       		 = $getBabyDetails['typeOfOutBorn'];
		 		$Hold['registrationDateTime']        = $getBabyDetails['registrationDateTime'];
		 		$Hold['status']                      = $getBabyDetails['status'];
		 		$Hold['addDate']        			 = $getBabyDetails['addDate'];
		 		
		     
                $Hold['babyAdmissionId']          		 = $babyAdmissionDetails['id'];
                $Hold['loungeId']                        = $babyAdmissionDetails['loungeId'];
                $Hold['admissionDateTime']               = $babyAdmissionDetails['admissionDateTime'];

				$motherDetails  = $this->db->get_where('motherRegistration',array('motherId'=>$getBabyDetails['motherId']))->row_array();
				$this->db->order_by('id','desc');
				$motherData = $this->db->get_where('motherAdmission',array('motherId'=>$getBabyDetails['motherId']))->row_array();               
						 
		 		$Hold['motherId']                    = $motherDetails['motherId'];
		 		$Hold['motherName']                  = $motherDetails['motherName'];
		 		$Hold['isMotherAdmitted']            = $motherDetails['isMotherAdmitted'];
		 		$Hold['notAdmittedReason']     		 = $motherDetails['notAdmittedReason'];
		 		$Hold['motherPicture']               = motherDirectoryUrl.$motherDetails['motherPicture'];
		 		$Hold['motherMobileNumber']          = $motherDetails['motherMobileNumber'];
		 		$Hold['motherLmpDate']               = $motherDetails['motherLmpDate'];	 
		 		$Hold['guardianName']                = $motherDetails['guardianName'];
		 		$Hold['guardianNumber']              = $motherDetails['guardianNumber'];
		 		$Hold['guardianRelation']            = $motherDetails['guardianRelation'];
		 		$Hold['guardianRelationOther']       = $motherDetails['guardianRelationOther'];
		 		$Hold['type']                        = $motherDetails['type'];
		 		$Hold['organisationName']            = $motherDetails['organisationName'];
		 		$Hold['organisationNumber']          = $motherDetails['organisationNumber'];
		 		$Hold['organisationAddress']         = $motherDetails['organisationAddress'];
		 		$Hold['status']                      = $motherDetails['status'];
		 		$Hold['motherLmpDate']              = $motherDetails['motherLmpDate'];
		 		
		 		$arrayName[] = $Hold;
		 	
	 	}

	 	$response['data'] = $arrayName;
	 	$response['md5Data'] = md5(json_encode($response['data']));
	 	(count($response['data']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
	}


	public function editFeedingData($request)
	{
	   $countData = count($request['feedingData']);
       if($countData > 0){
	       	foreach ($request['feedingData'] as $key => $request) {		
		        $array                        = array();
				$array['milkQuantity'] 		  = $request['milk_qty']; 
				$array['breastFeedDuration']  = $request['duration'];
			    $array['BreastFeedMethod'] 	  = $request['feeding_method'];        
			    $array['FeedTime'] 	          = date("H:i", strtotime($request['time'])); 

			    $this->db->where('id',$request['id']);
			    $sql = $this->db->update('babyDailyNutrition',$array); 
			}
		    if($sql > 0){
		    	generateServerResponse('1','S');
		    } else{
		    	generateServerResponse('0','W');
		    }			
		}	    
	}

	public function editKmcData($request)
	{
	   $countData = count($request['skinData']);
       if($countData > 0){
	       	foreach ($request['skinData'] as $key => $request) {
				$array= array();
				$array['startTime'] 		= $request['startTime'];
				$array['ByWhom']			= $request['bywhom'];
				$array['endTime'] 			= $request['endTime']; 
				$array['startDate'] 	 		= date("Y-m-d",strtotime($request['skin_date']));

			    $this->db->where('id',$request['id']);
			    $sql = $this->db->update('babyDailyKMC',$array); 
			}
		    if($sql > 0){
		    	generateServerResponse('1','S');
		    } else{
		    	generateServerResponse('0','W');
		    }			
		}		    
	}	

	public function motherAdmission($request)
	{
        $this->db->order_by('id','desc');
        $getLastbabyData = $this->db->get_where('babyAdmission',array('babyId'=>$request['babyId']))->row_array();
		
		$array                      = array();
		$array['motherId'] 		    = $request['motherId'];
		//$array['babyId']			= $request['babyId'];
		$array['loungeId']			= $getLastbabyData['loungeId'];
		$array['hospitalRegistrationNumber'] = $getLastbabyData['babyFileId'];
		$array['addDate'] 		    = time();
		$array['modifyDate'] 	    = time();

		    $this->db->where('motherId',$request['motherId']);
		    $sql = $this->db->update('motherRegistration',array('motherAdmission'=>'Yes')); 
		    $sql = $this->db->insert('motherAdmission',$array); 
		    if($sql > 0){
		    	generateServerResponse('1','S');
		    } else{
		    	generateServerResponse('0','W');
		    }
	}		

	public function postFollowUnfollowData($request)
	{

		$data = $this->db->get_where('followUnfollow',array('loungeId'=>$request['loungeId'],'followingLoungeID'=>$request['followingLoungeID']));
		$checkExist = $data->num_rows();
		$getData    = $data->row_array();
		$array      = array();
			// type 1 follow,2 unfollow
		if($checkExist > 0)
		{		
			$array['loungeId'] 		    = $request['loungeId'];
			$array['followingLoungeID']	= $request['followingLoungeID'];
			$array['status']			= $request['type'];
			$array['modifyDate'] 	    = time(); 
		    $this->db->where('id',$getData['id']);
		    $sql = $this->db->update('followUnfollow',$array);
			    if($sql > 0){
			    	generateServerResponse('1','S');
			    } else{
			    	generateServerResponse('0','W');
			    }
		}else{
			$array['loungeId'] 		    = $request['loungeId'];
			$array['followingLoungeID']	= $request['followingLoungeID'];
			$array['status']			= $request['type'];
			$array['addDate'] 		    = time();
			$array['modifyDate'] 	    = time(); 
			   $sql = $this->db->insert('followUnfollow',$array); 
			    if($sql > 0){
			    	generateServerResponse('1','S');
			    } else{
			    	generateServerResponse('0','W');
			    }	
		}	    
	}

	public function getFollowLoungeData($request)
	{
		if($request['keyword'] != ""){
		$getData = $this->db->query("select * from loungeMaster as lm inner join facilitylist as fl on lm.`facilityId`=fl.`facilityId` where lm.`status`='1' and lm.`loungeId` != ".$request['loungeId']." and (lm.`loungeName` Like '%".$request['keyword']."%' OR fl.`Address` Like '%".$request['keyword']."%' OR fl.`FacilityName` Like '%".$request['keyword']."%')")->result_array();
	   }else{
		$getData = $this->db->query("select * from loungeMaster as lm inner join facilitylist as fl on lm.`facilityId`=fl.`facilityId` where lm.`status`='1' and lm.`loungeId` != ".$request['loungeId']."")->result_array();
	   }
		//echo $this->db->last_query();exit;
		$array   = array();
		$arr     = array();
		foreach ($getData as $key => $value) {
            $checkFollowUnfollow = $this->db->query("select * from followUnfollow where status='1' and loungeId=".$request['loungeId']." and followingLoungeID=".$value['loungeId']."");
			$checkExistData      = $checkFollowUnfollow->num_rows();
			$getFollowedData     = $checkFollowUnfollow->row_array();
			if($checkExistData > 0)
			{
	            $GetLoungeData       = $this->db->query("select * from loungeMaster where loungeId=".$getFollowedData['followingLoungeID']."")->row_array();
				$array['loungeId'] 	 = !empty($getFollowedData['followingLoungeID']) ? $getFollowedData['followingLoungeID'] : '';
				$array['loungeName'] = !empty($GetLoungeData['loungeName']) ? $GetLoungeData['loungeName'] : '';
				$array['followStatus'] = $checkExistData;
				$array['loungeImage'] = !empty($GetLoungeData['LoungePic']) ? imageDirectoryUrl.$GetLoungeData['LoungePic'] : '';
				$array['followDateTime'] = $getFollowedData['addDate'];	
			$arr[]    = $array;
			}else{
				$GetLoungeData       = $this->db->query("select * from loungeMaster where loungeId=".$value['loungeId']."")->row_array();
				$array['loungeId'] 	 = $GetLoungeData['loungeId'];
				$array['loungeName'] = !empty($GetLoungeData['loungeName']) ? $GetLoungeData['loungeName'] : '';
				$array['followStatus'] = $checkExistData;
				$array['loungeImage'] = !empty($GetLoungeData['LoungePic']) ? imageDirectoryUrl.$GetLoungeData['LoungePic'] : '';
				$array['followDateTime'] = '';	
			$arr[]    = $array;
			}

	     }
             $response['getAllDataWithStatus'] = $arr;
		    if(count($getData) > 0){
		    	generateServerResponse('1','S',$response);
		    } else{
		    	generateServerResponse('0','E');
		    }
	}	

// get following lounge basic details

	public function getFollowingLoungeDetail($request)
	{
		$getData = $this->db->query("select * from followUnfollow where loungeId=".$request['loungeId']." and status='1'")->result_array();
		$array = array();
		$arr   = array();
		$stablecount1   = 0;
		$unstablecount1 = 0;
		foreach ($getData as $key => $value) {
	        $GetLoungeData = $this->db->query("select * from loungeMaster where loungeId=".$value['followingLoungeID']."")->row_array();

			$LoungeWiseTotalMothers   = $this->CountingModel->getAllMothersViaLounge($value['followingLoungeID']); 
			$totallyAdmittedMothers   = $this->CountingModel->totallyAdmittedMothers($value['followingLoungeID']); 
			$currentlyAvailMothers    = $this->CountingModel->getAllAdmittedMothersViaLounge($value['followingLoungeID'],1); 
			$dischargeMothers         = $this->CountingModel->getAllAdmittedMothersViaLounge($value['followingLoungeID'],2); 
            $getAdmittedMothers       = $this->db->query("select mr.`motherId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`motherAdmission`='Yes' and ma.`status`='1' and ma.`loungeId`=".$value['followingLoungeID']."")->result_array();

	        $LoungeWiseBabies          = $this->CountingModel->getAllBabysViaLounge($value['followingLoungeID']); 
	        $AdmittedBabies            = $this->CountingModel->getAllAdmittedBabysViaLounge($value['followingLoungeID'],1); 
	        $dischargeBabies           = $this->CountingModel->getAllAdmittedBabysViaLounge($value['followingLoungeID'],2); 


			$array['followingLoungeId']        = $value['followingLoungeID'];
			$array['followingLoungeName']      = $GetLoungeData['loungeName'];
			$array['followingLoungePic']       = !empty($GetLoungeData['LoungePic']) ? imageDirectoryUrl.$GetLoungeData['LoungePic'] : '';
			$array['totalMothers']             = $LoungeWiseTotalMothers;
			$array['totalAdmittedMothers']     = $totallyAdmittedMothers;
			$array['currentlyAvailMothers']    = $currentlyAvailMothers;
			$array['dischargedMothers']        = $dischargeMothers;
			$array['totalBabies']              = $LoungeWiseBabies;
			$array['totalAdmittedBabies']      = $AdmittedBabies;
			$array['dischargedBabies']         = $dischargeBabies;
			$array['followingDateTime']        = $value['addDate'];
             
	        foreach ($getAdmittedMothers as $key => $val) {  
                $getLastAssessment = $this->db->query("SELECT * from motherMonitoring where loungeId=".$value['followingLoungeID']." and motherId=".$val['motherId']." order by id desc limit 0,1")->row_array();
	        	$status1 = 0;
	            $status2 = 0;
	            $status3 = 0;
	            $status4 = 0;
	            $status5 = 0;
	            $status6 = 0;
	            $status7 = 0;
	            $status8 = 0;
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

                  if(($status1 == 1) || ($status2 == 1) || ($status3 == 1) || ($status4 == 1) || ($status5 == 1) || ($status6 == 1) || ($status7 == 1) || ($status8 == 1))
                  {
                     $unstablecount1++;
                  }else
                  {
                     $stablecount1++;                       
                  }
	        }
			$array['stableMothers']      = $stablecount1;
			$array['unstableMothers']    = $unstablecount1;
			$array['stableBabies']       = 0;
			$array['unstableBabies']     = 0;
		   $arr[] = $array;
	     }
             $response['getAllDataWithStatus'] = $arr;
		    if(count($getData) > 0){
		    	generateServerResponse('1','S',$response);
		    } else{
		    	generateServerResponse('0','E');
		    }
	}		



// get dashboard data
	
	public function getDashboardData($request)
	{
		$numberOfMonths = date('m');
		$yearCode       = date('Y');
		$months         = array();
		$num = date("n",strtotime($yearCode.'-01-01 00:00:01'));
		array_push($months, date("F", strtotime($yearCode.'-01-01 00:00:01')));

		for($i = ($num + 1); $i <= $numberOfMonths; $i++){
		    $dateObj = DateTime::createFromFormat('!m', $i);
		    array_push($months, $dateObj->format('F'));
		}

		
        $data  = array();
        $field =  array();
		foreach ($months as $key => $value) {
			$inbornCounting        =  $this->DashboardDataModel->getTotalInbornOutborn($request['loungeId'],'Inborn',date("Y-m",strtotime($value)));
			$outBornCounting       =  $this->DashboardDataModel->getTotalInbornOutborn($request['loungeId'],'Outborn',date("Y-m",strtotime($value)));
			$getLamaDischarge      =  $this->db->get_where('babyAdmission',array('status'=>2,'typeOfDischarge'=>'Leave against medical advice(LAMA)','loungeId'=>$request['loungeId'],'addDate'=>date("Y-m",strtotime($value)) ))->num_rows();
			$getTotalDischarge     =  $this->db->get_where('babyAdmission',array('status'=>2,'loungeId'=>$request['loungeId'],'addDate'=>date("Y-m",strtotime($value)) ))->num_rows();
			$getMaleBabies         =  $this->db->query("select distinct ba.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` where br.`babyGender`='Male' and ba.`loungeId`=".$request['loungeId']." and FROM_UNIXTIME(ba.addDate,'%Y-%m')='".date("Y-m",strtotime($value))."'")->num_rows();
			$getFemaleBabies       =  $this->db->query("select distinct ba.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` where br.`babyGender`='Female' and ba.`loungeId`=".$request['loungeId']." and FROM_UNIXTIME(ba.addDate,'%Y-%m')='".date("Y-m",strtotime($value))."'")->num_rows();
			if($getLamaDischarge == 0){
				$lamaRate = 0;
			}else{
				$lamaRate = ($getLamaDischarge*100/$getTotalDischarge);
			}
			$numberLowBirthWeightBabies =  count($this->DashboardDataModel->getLowBirthWeightBabies($request['loungeId'],date("Y-m",strtotime($value))));
			$array['outBornAdmission']                    = $outBornCounting;
			$array['inBornAdmission']                     = $inbornCounting;
			$array['bedAccupancyRate']                    = "";
			$array['lowBirthWeight']                      = $numberLowBirthWeightBabies;
			$array['survivalRate']                        = "";
			$array['antibioticUseRate']                   = "";
			$array['percentageOfEnvironmetalSwabCulture'] = "";
			$array['lamaRate']                            = $lamaRate;
			$array['percentageOfDeathAmongInborn']        = "";
			$array['attendantSatisfactionScore']          = "";
			$array['averageStayTime']                     = "";
			$array['numberOfNewBornResuscitated']         = "";
			$array['ProportionOfFemaleAdmitted']          = $getMaleBabies;
			$array['ProportionOfMaleAdmitted']            = $getFemaleBabies;
			//date("Y-m",strtotime($value))
			$field[]                                      = $array;
		}
      
	        $response['getAllDataWithStatus'] = $field;
		    if(count($months) > 0){
		    	generateServerResponse('1','S',$response);
		    } else{
		    	generateServerResponse('0','E');
		    }
    }

}