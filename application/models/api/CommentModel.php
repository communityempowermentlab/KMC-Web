<?php
class CommentModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		date_default_timezone_set("Asia/KolKata");
	}
 // Post comment data
	public function commentPost($request)
	{
        if($request['userType'] == '0'){
         $request['loungeId'] = $request['loungeId'];
         $staffId = $request['loungeId'];
        }else{
           // $staffId = $request['loungeId'];
            $loungeData          = getStaffLoungeId($request['loungeId']); // call function using api_helper
            $request['loungeId'] = $loungeData['loungeId'];
        }
	   $countData = count($request['commentData']);
       if($countData > 0){
	       	$param1 = array();
	       	$param  = array();
	       	$checkDataForAllUpdate = 1;  // check for all data synced or not
	       	foreach ($request['commentData'] as $key => $request) {
	       		$checkDuplicateData =  $this->db->get_where('comments',array('androidUuid'=>$request['localId']))->num_rows();
	       		if($checkDuplicateData == 0){
	       		    $checkDataForAllUpdate = 2;	
					$array = array();
					if($request['type'] == '1')
					{
						$array['doctorId'] 	         = $request['doctorId'];
						//$array['loungeId'] 	         = $request['loungeId'];
						$array['type'] 	             = $request['type'];
						$array['admissionId'] 	 = $request['motherOrBabyId'];
						$array['androidUuid']        = ($request['localId']!='') ? $request['localId']:NULL;

			         $this->db->order_by('id','desc');
			         $getAdmisionID=$this->db->get_where('motherAdmission', array('motherId'=>$request['motherOrBabyId']))->row_array();


						$array['admissionId']        = $getAdmisionID['id'];
						$array['comment']            = $request['comment'];
						$array['status']             = $request['status'];
						$array['addDate']             = $request['localDateTime'];
						$array['lastSyncedTime']      = date('Y-m-d : H:i:s');
						$array['modifyDate'] 	   	  = date('Y-m-d : H:i:s');

			            $inserted = $this->db->insert('comments', $array);
						$lastID            = $this->db->insert_id();
						$listID['id']      = $lastID;
						$listID['localId'] = $request['localId'];;
						$param1[]          = $listID;

			         }else if($request['type'] == '2') {
						$array['doctorId'] 	         = $request['doctorId'];
						//$array['loungeId'] 	         = $request['loungeId'];
						$array['type'] 	             = $request['type'];
						$array['admissionId'] 	 = $request['motherOrBabyId'];
						$array['androidUuid']       = ($request['localId']!='') ? $request['localId']:NULL;
			         $this->db->order_by('id','desc');
			         $getAdmisionID=$this->db->get_where('babyAdmission', array('babyId'=>$request['motherOrBabyId']))->row_array();

						$array['admissionId']        = $getAdmisionID['id'];
						$array['comment']            = $request['comment'];
						$array['status']             = $request['status'];
						$array['addDate']             = $request['localDateTime'];
						$array['lastSyncedTime']      = date('Y-m-d : H:i:s');
						$array['modifyDate'] 	   	 = date('Y-m-d : H:i:s');

			            $inserted = $this->db->insert('comments', $array);  
						$lastID            = $this->db->insert_id();
						$listID['id']      = $lastID;
						$listID['localId'] = $request['localId'];;
						$param1[]          = $listID;   	
			         }
			    }else {               // update code here 
					$array = array();
					if($request['type'] == '1')
					{
						$array['doctorId'] 	         = $request['doctorId'];
						//$array['loungeId'] 	         = $request['loungeId'];
						$array['type'] 	             = $request['type'];
						$array['admissionId'] 	 = $request['motherOrBabyId'];
						$array['androidUuid']       = ($request['localId']!='') ? $request['localId']:NULL;
			         $this->db->order_by('id','desc');
			         $getAdmisionID=$this->db->get_where('motherAdmission', array('motherId'=>$request['motherOrBabyId']))->row_array();


						$array['admissionId']        = $getAdmisionID['id'];
						$array['comment']            = $request['comment'];
						$array['status']             = $request['status'];
						$array['addDate']             = $request['localDateTime'];
						$array['lastSyncedTime']       = date('Y-m-d : H:i:s');
						$array['modifyDate'] 	   	  = date('Y-m-d : H:i:s');

						$this->db->where('androidUuid',$request['localId']);
						$this->db->update('comments', $array);
						$lastID = $this->db->get_where('comments',array('androidUuid'=>$request['localId']))->row_array();
						$listID['id']      = $lastID['id'];
						$listID['localId'] = $request['localId'];
						$param1[] = $listID; 

			         }else if($request['type'] == '2') {
						$array['doctorId'] 	         = $request['doctorId'];
						//$array['loungeId'] 	         = $request['loungeId'];
						$array['type'] 	             = $request['type'];
						$array['admissionId'] 	 = $request['motherOrBabyId'];
						$array['androidUuid']        = ($request['localId']!='') ? $request['localId']:NULL;
			         $this->db->order_by('id','desc');
			         $getAdmisionID=$this->db->get_where('babyAdmission', array('babyId'=>$request['motherOrBabyId']))->row_array();


						$array['admissionId']        = $getAdmisionID['id'];
						$array['comment']            = $request['comment'];
						$array['status']             = $request['status'];
						$array['addDate']             = $request['localDateTime'];
						$array['lastSyncedTime']       = date('Y-m-d : H:i:s');
						$array['modifyDate'] 	   	  = date('Y-m-d : H:i:s');

						$this->db->where('androidUuid',$request['localId']);
						$this->db->update('comments', $array);
						$lastID = $this->db->get_where('comments',array('androidUuid'=>$request['localId']))->row_array();
						$listID['id']      = $lastID['id'];
						$listID['localId'] = $request['localId'];
						$param1[] = $listID;  	
			         }
			    }  
	        }if($checkDataForAllUpdate == 1 || $checkDataForAllUpdate == 2){
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
// get All Comment via Doctor
	public function getAllCommentViaLounge($request)
	{		
      if($request['type'] == '1'){
      	$this->db->order_by('id','desc');
      	$getMotherName = $this->db->get_where('motherAdmission',array('motherId'=>$request['id']))->row_array();	
      	$GetData = $this->db->query("select * from comments where admissionId=".$getMotherName['id']." order by id DESC")->result_array();
		 $arrayName = array();
		 	if(count($GetData) > 0)
		 	{   
			 	foreach ($GetData as $key => $value){
			 		 $getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$value['admissionId']))->row_array();	 		
	                 $Hold['name']             = $getMotherName['motherName']; 		 		
			 		
	               $getDoctorData = $this->db->get_where('staffMaster',array('staffId'=>$value['doctorId']))->row_array();

	                $Hold['doctorName']            = $getDoctorData['name'];              
	                $Hold['doctorImage']           = ($getDoctorData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getDoctorData['profilePicture'] : '';

	                $Hold['comment']               = $value['comment'];
	                $Hold['addDate']               = $value['addDate'];
			 		$arrayName[] = $Hold;
			 	}
		 	}
		 	$response['data'] = $arrayName;
		 	$response['md5Data'] = md5(json_encode($response['data']));
		 	(count($response['data']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
      }else if($request['type'] == '2')
      {
			  	$this->db->order_by('id','desc');
			  	$getbabyData = $this->db->get_where('babyAdmission',array('babyId'=>$request['id']))->row_array(); 		
			  	$GetData = $this->db->query("select * from comments where admissionId=".$getbabyData['id']." order by id DESC")->result_array();
				
				 $arrayName = array();
				 	if(count($GetData) > 0)
				 	{   
					 	foreach ($GetData as $key => $value){

					 		$getbabyData = $this->db->get_where('babyRegistration',array('babyId'=>$value['admissionId']))->row_array();
			                $getMotherName = $this->db->get_where('motherRegistration',array('motherId'=>$getbabyData['motherId']))->row_array(); 
			                 $Hold['id']               = $value['admissionId']; 
			                 $Hold['name']             = 'B/O '.$getMotherName['motherName']; 

			               $getDoctorData = $this->db->get_where('staffMaster',array('staffId'=>$value['doctorId']))->row_array();

			                $Hold['doctorName']            = $getDoctorData['name'];              
			                $Hold['doctorImage']           = ($getDoctorData['profilePicture'] != '') ? base_url().'assets/nurse/'.$getDoctorData['profilePicture'] : '';

			                $Hold['comment']               = $value['comment'];
			                $Hold['addDate']               = $value['addDate'];
					 		$arrayName[] = $Hold;
					 	}
				 	}

				 	$response['data'] = $arrayName;
                    $response['md5Data'] = md5(json_encode($response['data']));
				 	(count($response['data']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
      }


	}
// get detail via nurse
	public function getDetailViaNurse($nurseId)
	{		
		 $GetData = $this->db->query("select * from staffMaster where staffId=".$nurseId."")->row_array();
         $getFacility  = $this->db->query("select * from facilitylist where facilityId=".$GetData['facilityId']."")->row_array();
         $GetStafftype = $this->db->query("select * from staffType where staffTypeId=".$GetData['Stafftype']."")->row_array();
         $GetStaffSubtype = $this->db->query("select * from staffType where staffTypeId=".$GetData['staffSubType']."")->row_array();
         $GetJobtype   = $this->db->query("select * from masterData where id=".$GetData['jobType']."")->row_array();
	 	 $arrayName = array();
                $arrayName['facilityName']    = $getFacility['FacilityName'];              
                $arrayName['staffType']       = $GetStafftype['StafftypeNameEnglish'];              
                $arrayName['staffSubtype']    = $GetStaffSubtype['StafftypeNameEnglish'];              
                $arrayName['jobtype']         = $GetJobtype['name'];              
                $arrayName['name']            = $GetData['name'];              
                $arrayName['image']           = ($GetData['profilePicture'] != '') ? base_url().'assets/nurse/'.$GetData['profilePicture'] : '';

                $arrayName['moblieNo']              = $GetData['staffMobileNumber'];
                $arrayName['emergencyNo']           = $GetData['emergencyContactNumber'];
                $arrayName['staffaddress']               = $GetData['staffAddress'];
                $arrayName['addDate']               = $GetData['addDate'];
	 	($GetData > 0) ? generateServerResponse('1','S',$arrayName) : generateServerResponse('0','E');
	 }

// update Profile via nurse
	public function updateDetailViaNurse($request)
	{		
		 $GetData = $this->db->query("select * from staffMaster where staffId=".$request['nurseId']."")->row_array();
	 	 $arrayName = array();

              if(!empty($request['image'])){
                  $image          = $request['image'];
                  $get_http = explode(':',$image);
                  if($get_http[0] == 'http' || $get_http[0] == 'https') {
                    $pic      =   $GetData['profilePicture'];
                  }else {
					$folder  = 'nurse';
					$pic   = ($request['image']!='') ? saveDynamicImage($request['image'],$folder) :'';
                  }
              }else {
                $pic="";
              }


                $arrayName['name']                       = $request['name'];              
                $arrayName['profilePicture']                 = ($pic != '') ? $pic : '';

                $arrayName['emergencyContactNumber']   = $request['emergencyContactNumber'];
                $arrayName['staffAddress']               = $request['staffaddress'];
                $arrayName['modifyDate']                = date('Y-m-d : H:i:s');

           $this->db->where('staffId',$request['nurseId']);
           $res = $this->db->update('staffMaster',$arrayName);
           $GetUpdatedData = $this->db->query("select * from staffMaster where staffId=".$request['nurseId']."")->row_array();
                $array = array();
                $array['name']            = $GetUpdatedData['name'];              
                $array['image']           = ($GetUpdatedData['profilePicture'] != '') ? base_url().'assets/nurse/'.$GetUpdatedData['profilePicture'] : '';
                $array['moblieNo']              = $GetUpdatedData['staffMobileNumber'];
                $array['emergencyNo']           = $GetUpdatedData['emergencyContactNumber'];
                $array['staffaddress']               = $GetUpdatedData['staffAddress'];
                $array['addDate']               = $GetUpdatedData['addDate'];

	 	($res > 0) ? generateServerResponse('1','S',$array) : generateServerResponse('0','E');
	 }	 



	public function postLikeOrDislike($request)
	{
        if($request['userType'] == '0'){
            $request['loungeId'] = $request['loungeId'];
            $data = $this->db->get_where('likeDislikeMaster',array('timelineId'=>$request['timelineId'],'loungeId'=>$request['loungeId'],'userType'=>0));
        }else{
            $data = $this->db->get_where('likeDislikeMaster',array('timelineId'=>$request['timelineId'],'loungeId'=>$request['loungeId'],'userType'=>1));

        }	
		

		$checkExist = $data->num_rows();
		$getData  = $data->row_array();
		$array = array();
		if($checkExist > 0)
		{
		$array['loungeId'] 	         = $request['loungeId'];
		$array['type'] 	             = $request['type'];
		$array['userType'] 	         = $request['userType'];
		$array['timelineId'] 	     = $request['timelineId'];
		$array['modifyDate']          = date('Y-m-d : H:i:s');
		$this->db->where('id',$getData['id']);
		$res = $this->db->update('likeDislikeMaster',$array);
			if($res > 0){
	           generateServerResponse('1','S');
			  }
			else{
				generateServerResponse('0','F');
			}
		} else{
			$array['loungeId'] 	         = $request['loungeId'];
			$array['type'] 	             = $request['type'];
			$array['userType'] 	         = $request['userType'];
			$array['timelineId'] 	     = $request['timelineId'];
			$array['addDate']           = date('Y-m-d : H:i:s');
			$array['modifyDate']         = date('Y-m-d : H:i:s');
			$res = $this->db->insert('likeDislikeMaster',$array);
				if($res > 0){
		           generateServerResponse('1','S');
				  }
				else{
					generateServerResponse('0','F');
				}	
		}	        
	}

	public function postCommentTimeline($request)
	{
        if($request['userType'] == '0'){
         $request['loungeId'] = $request['loungeId'];
         $staffId = $request['loungeId'];
        }else{
            $staffId = $request['loungeId'];
            $loungeData          = getStaffLoungeId($request['loungeId']); // call function using api_helper
            $request['loungeId'] = $loungeData['loungeId'];
        }

		$array = array();
		$array['loungeId'] 	         = $staffId;
		$array['comment'] 	         = $request['comment'];
		$array['timelineId'] 	     = $request['timelineId'];
		$array['userType'] 	         = $request['userType'];
		$array['addDate']            = date('Y-m-d : H:i:s');
		$array['modifyDate']          = date('Y-m-d : H:i:s');
		$res = $this->db->insert('timelineComment',$array);
		$lastID = $this->db->insert_id();
		$GetLastData = $this->db->query("select * from timelineComment where id=".$lastID."")->row_array();
		if($request['userType'] == '0'){
		  $GetLoungeData = $this->db->query("select * from loungeMaster where loungeId=".$request['loungeId']."")->row_array();
		    $GetLastData['loungeId']    = $GetLastData['loungeId'];
		    $GetLoungeData['loungeName'] = $GetLoungeData['loungeName'];
		    $GetLoungeData['LoungePic'] = !empty($GetLoungeData['LoungePic']) ? imageDirectoryUrl.$GetLoungeData['LoungePic'] : '';
	      }else{
            $GetLastData['loungeId'] = $staffId;
            $getstaffId  = $this->db->query("select * from staffMaster where staffId=".$staffId."")->row_array();
            $GetLoungeData['loungeName'] = $getstaffId['name'];
            $GetLoungeData['LoungePic'] = !empty($getstaffId['profilePicture']) ? nurseDirectoryUrl.$getstaffId['profilePicture'] : '';
	      }

		$Hold = array();
		$Hold['id']                  = $GetLastData['id'];
		$Hold['loungeId']            = $GetLastData['loungeId'];
		$Hold['name']                = $GetLoungeData['loungeName'];
		$Hold['image']               = $GetLoungeData['LoungePic'];
		$Hold['userType']            = $request['userType'];
		$Hold['timelineId']          = $GetLastData['timelineId'];
		$Hold['comment']             = $GetLastData['comment'];
		$Hold['addDate']     		 = $GetLastData['addDate'];
		$Hold['modifyDate']          = $GetLastData['modifyDate'];
		if($res > 0){
           generateServerResponse('1','S',$Hold);
		  }
		else{
			generateServerResponse('0','F');
		} 	        
	}


// get All TimeLine Comment via timelineId
public function getAllTimelineComment($request)
   {

            $query = $this->getTimelineComentViaPaging($request['timelineId'],$request['offset']);
            $array  = array();
            $arr    = array();
          foreach ($query as $value) {
			if($value['userType'] == '0'){
			    $GetLoungeData = $this->db->query("select * from loungeMaster where loungeId=".$value['loungeId']."")->row_array();
			    $GetLoungeData1['loungeId']     = $GetLoungeData['loungeId'];
			    $GetLoungeData1['loungeName']   = $GetLoungeData['loungeName'];
			    $GetLoungeData1['image']   		=  '';
		      }else{
	            $staffId = $value['loungeId'];
	            $getstaffId  = $this->db->query("select * from staffMaster where staffId=".$staffId."")->row_array();
	            $GetLoungeData1['loungeId']   = $staffId;
	            $GetLoungeData1['loungeName'] = $getstaffId['name'];
	            $GetLoungeData1['image']  = !empty($getstaffId['profilePicture']) ? imageDirectoryUrl.$getstaffId['profilePicture'] : '';
		      }
          	
	 		$Hold['id']                  = $value['id'];
	 		$Hold['loungeId']            = $GetLoungeData1['loungeId'];
	 		$Hold['name']                = $GetLoungeData1['loungeName'];
	 		$Hold['image']               = $GetLoungeData1['image'];
	 		$Hold['timelineId']          = $value['timelineId'];
	 		$Hold['comment']             = $value['comment'];
	 		$Hold['addDate']     		 = $value['addDate'];
	 		$Hold['modifyDate']          = $value['modifyDate'];
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

    public function getTimelineComentViaPaging($timelineId,$offset) {
        $offset = ($offset!='') ? $offset : 0;
        $limit  = 50 ;
        return $this->db->query("select * from timelineComment where timelineId=".$timelineId." order by id desc limit ".$offset.",".$limit."")->result_array();
    }
}