<?php
class StaffModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  // get all staffs data in desc order
  public function staff(){
    $adminData = $this->session->userdata('adminData');  
    $this->db->order_by('staffId','desc');
    if ($adminData['type']=='1') {
      return $this->db->get_where('staffMaster')->result_array(); 
    }     
  } 

  // get staff data via facilityId
  public function getStaffData($type,$limit='',$offset='',$facility_id){ 
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    $where_facility = "";
    if(!empty($getCoachFacilities['coachFacilityArray'])){ 
      $where_facility = 'where facilityId in '.$getCoachFacilities['coachFacilityArrayString'].' ';
    }

    if($facility_id == 'all'){
      if ($type == '1') { 
        $this->db->select('*');
        $result = $this->db->query("SELECT * FROM staffMaster ".$where_facility." order by staffId desc")->num_rows();
        return $result;
       
      } else { 
        return $this->db->query("SELECT * FROM staffMaster ".$where_facility." order by staffId desc LIMIT ".$offset.", ".$limit."")->result_array();
      } 
    } else {
      if ($type == '1') { 
        $this->db->select('*');
        $result = $this->db->get_where('staffMaster', array('facilityId'=>$facility_id))->num_rows(); 
        return $result;
       
      } else { 
        return $this->db->query("SELECT * FROM staffMaster where facilityId = ".$facility_id." order by staffId desc LIMIT ".$offset.", ".$limit."")->result_array();
      } 
    }      
  } 

  // get staff data with search and limit
  public function getStaffDataWhereSearching($type,$keyword,$limit='',$offset=''){
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    $where_facility = "";
    if(!empty($getCoachFacilities['coachFacilityArray'])){ 
      $where_facility = 'and (sm.facilityId in '.$getCoachFacilities['coachFacilityArrayString'].')';
    }

    if ($type == '1') {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%') ".$where_facility." ")->num_rows(); 
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where (sm.`Name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%') ".$where_facility." LIMIT ".$offset.", ".$limit."")->result_array();
       
    }       
  } 

  
  public function getStaffDataWhereFacility($type,$facility,$limit='',$offset=''){
    if ($type == '1') {
     return  $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where (fl.`facilityId` = $facility)")->num_rows(); 
      
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where (fl.`facilityId` = $facility) LIMIT ".$offset.", ".$limit."")->result_array();
    }       
  }


  public function getStaffDataWhereDistrict($type,$district,$limit='',$offset=''){
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    $where_facility = "";
    if(!empty($getCoachFacilities['coachFacilityArray'])){ 
      $where_facility = 'and (sm.facilityId in '.$getCoachFacilities['coachFacilityArrayString'].')';
    }

    if ($type == '1') {
     return  $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where (fl.`PRIDistrictCode` = $district) ".$where_facility." ")->num_rows(); 
      
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where (fl.`PRIDistrictCode` = $district) ".$where_facility." LIMIT ".$offset.", ".$limit."")->result_array();
    }   
  }

  public function getStaffDataWhereFacilitySearch($type,$keyword,$facility,$limit='',$offset=''){
    if ($type == '1') {
     return  $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where ((sm.`facilityId` = $facility) AND (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%'))")->num_rows(); 
      
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where ((sm.`facilityId` = $facility) AND (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%')) LIMIT ".$offset.", ".$limit."")->result_array();
    }    
  }


  public function getStaffDataWhereDistrictSearch($type,$keyword,$district,$limit='',$offset=''){
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    $where_facility = "";
    if(!empty($getCoachFacilities['coachFacilityArray'])){ 
      $where_facility = 'and (sm.facilityId in '.$getCoachFacilities['coachFacilityArrayString'].')';
    }

    if ($type == '1') {
     return  $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where ((fl.`PRIDistrictCode` = $district) AND (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%')) ".$where_facility." ")->num_rows(); 
      
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where ((fl.`PRIDistrictCode` = $district) AND (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%')) ".$where_facility." LIMIT ".$offset.", ".$limit."")->result_array();
    }    
  }


  // get facility data where FacilityName is not blank
  public function GetFacilities(){
    return $this->db->query("SELECT * FROM `facilitylist` where FacilityName!='' ORDER BY `FacilityName` ASC")->result_array();
  }

  // get facility data via FacilityID
  public function GetFacilitiName($FacilityID){
    return $this->db->query("SELECT * FROM `facilitylist` where FacilityID = ".$FacilityID)->row_array();
  }
  
  // get staffType data with no parent
  public function GetStaffType(){
    $this->db->order_by("staffTypeNameEnglish", "asc");
    return $this->db->get_where('staffType',array('parentId'=>'0','status'=>1))->result_array(); 
  }

  // get masterData data with type = job type
  public function GetJobType(){
    $this->db->order_by("name", "asc");
    return $this->db->get_where('masterData',array('type'=>'4'))->result_array(); 
  }
  
  // get staff data via staffId
  public function GetStaffById($id){
    return $this->db->get_where('staffMaster', array('staffId'=>$id))->row_array();
  }

  // get staffType data via staffTypeId
  public function GetStaffTypeById($id){
    return $this->db->get_where('staffType', array('staffTypeId'=>$id))->row_array();
  }

  // get data from loungeMaster
  public function GetLounge(){
    return $this->db->get_where('loungeMaster')->result_array();
  }

  // insert data into staffMaster and smsMaster
  public function AddstaffData($data){
    $fields                             =       array();
    if($_FILES['image']['name']){
      $fileName   = $_FILES['image']['name'];
      $extension  = explode('.',$fileName);
      $extension  = strtolower(end($extension));
      $uniqueName = time().'.'.$extension;
      $tmp_name   = $_FILES['image']['tmp_name'];
      $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/nurse/".$uniqueName; 
      $InsertImg = utf8_encode(trim($uniqueName));
      move_uploaded_file($tmp_name,$targetlocation);
    } else {
      $InsertImg = '';
    }

    $fields['name']                     =       $data['Name'];
    $fields['facilityId']               =       $data['facilityname'];
    $fields['staffType']                =       $data['type'];
    $fields['staffSubType']             =       $data['sub_type'];
    $fields['staffSubTypeOther']        =       $data['staff_sub_type_other'];

    if($data['staff_sub_type_val'] == "")
    {
      $job_type         = $data['job_type'];
    }
    else
    {
      $job_type         = $data['job_type1'];
    }


    $fields['staffMobileNumber']        =       $data['staff_contact_number'];
    $fields['staffAddress']             =       $data['address'];
    $fields['staffPassword']            =       NULL;
    $password                           =       $data['password'];
    $fields['emergencyContactNumber']   =       $data['emergency_contact_number'];
    $fields['jobType']                  =       $job_type;
    $fields['profilePicture']           =       $InsertImg;
    $fields['addDate']                  =       date('Y-m-d H:i:s');
    $fields['modifyDate']               =       date('Y-m-d H:i:s');
    $this->db->insert('staffMaster',$fields);
    $id = $this->db->insert_id();
    
    return 1;
 
  }

  // update staff data
  public function UpdateStaff($data,$id){
    $fields                             =       array();

    if($_FILES['image']['name'] != ""){      
      $fileName   = $_FILES['image']['name'];
      $extension  = explode('.',$fileName);
      $extension  = strtolower(end($extension));
      $uniqueName = time().'.'.$extension;
      $tmp_name   = $_FILES['image']['tmp_name'];
      $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/nurse/".$uniqueName; 
     
      $InsertImg = utf8_encode(trim($uniqueName));
      move_uploaded_file($tmp_name,$targetlocation);
    }else{
      $InsertImg = $data['prevFile'];
    }

    $getOldData = $this->db->get_where('staffMaster', array('staffId'=>$id))->row_array();

    $fields['name']                       =       $data['Name'];
    $fields['facilityId']                 =       $data['facilityname'];
    $fields['staffType']                  =       $data['type'];
    $fields['staffSubType']               =       $data['sub_type'];
    $fields['staffSubTypeOther']          =       $data['staff_sub_type_other'];
    $fields['staffMobileNumber']          =       $data['staff_contact_number'];
    $fields['staffAddress']               =       $data['address'];
    $fields['emergencyContactNumber']     =       $data['emergency_contact_number'];

    if($data['staff_sub_type_val'] == "")
    {
      $job_type         = $data['job_type'];
    }
    else
    {
      $job_type         = $data['job_type1'];
    }

    $fields['jobType']                    =       $job_type;
    $fields['status']                     =       $data['status'];
    $fields['profilePicture']             =       $InsertImg;
    $fields['modifyDate']                 =       date('Y-m-d H:i:s');
    $this->db->where('staffId',$id);
    $this->db->update('staffMaster',$fields);

    $loginId = $this->session->userdata('adminData')['Id'];
    $type = $this->session->userdata('adminData')['Type'];
    $ip = $this->input->ip_address(); 

    $logData = array();

    $logData['tableReference']        = 3;
    $logData['tableReferenceId']      = $id;
    $logData['updatedBy']             = $loginId;
    $logData['type']                  = $type;
    $logData['deviceInfo']            = $ip;
    
    $logData['addDate']               = date('Y-m-d H:i:s');
    $logData['lastSyncedTime']        = date('Y-m-d H:i:s');

    if($getOldData['name'] != $data['Name']) {
      $logData['columnName']           = 'Staff Name';
      $logData['oldValue']             = $getOldData['name'];
      $logData['newValue']             = $data['Name'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['facilityId'] != $data['facilityname']) {
      $logData['columnName']           = 'Facility';
      $logData['oldValue']             = $getOldData['facilityId'];
      $logData['newValue']             = $data['facilityname'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['staffType'] != $data['type']) {
      $logData['columnName']           = 'Staff Type';
      $logData['oldValue']             = $getOldData['staffType'];
      $logData['newValue']             = $data['type'];

      $this->db->insert('logData',$logData);
    }
   
    if($getOldData['staffSubType'] != $data['sub_type']) { 
      $logData['columnName']           = 'Staff Sub Type';
      $logData['oldValue']             = $getOldData['staffSubType'];
      $logData['newValue']             = $data['sub_type'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['staffSubTypeOther'] != $data['staff_sub_type_other']) { 
      $logData['columnName']           = 'Staff Sub Type Other';
      $logData['oldValue']             = $getOldData['staffSubTypeOther'];
      $logData['newValue']             = $data['staff_sub_type_other'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['staffMobileNumber'] != $data['staff_contact_number']) {
      $logData['columnName']           = 'Staff Mobile Number';
      $logData['oldValue']             = $getOldData['staffMobileNumber'];
      $logData['newValue']             = $data['staff_contact_number'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['staffAddress'] != $data['address']) {
      $logData['columnName']           = 'Staff Address';
      $logData['oldValue']             = $getOldData['staffAddress'];
      $logData['newValue']             = $data['address'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['emergencyContactNumber'] != $data['emergency_contact_number']) {
      $logData['columnName']           = 'Emergency Contact Number';
      $logData['oldValue']             = $getOldData['emergencyContactNumber'];
      $logData['newValue']             = $data['emergency_contact_number'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['jobType'] != $data['job_type']) {
      $logData['columnName']           = 'Job Type';
      $logData['oldValue']             = $getOldData['jobType'];
      $logData['newValue']             = $data['job_type'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['profilePicture'] != $InsertImg) {
      $logData['columnName']           = 'Staff Photo';
      $logData['oldValue']             = $getOldData['profilePicture'];
      $logData['newValue']             = $InsertImg;

      $this->db->insert('logData',$logData);
    }

    if($getOldData['status'] != $data['status']) {
      $logData['columnName']           = 'Status';
      $logData['oldValue']             = $getOldData['status'];
      $logData['newValue']             = $data['status'];

      $this->db->insert('logData',$logData);
    }

    return 1;
  }

  public function GetTemporaryStaff(){
    $this->db->order_by("staffId", "desc");
    return $this->db->get_where('temporaryStaffMaster')->result_array(); 
  }

  public function GetTempStaffById($id){
    return $this->db->get_where('temporaryStaffMaster',array('staffId'=>$id))->row_array();
  }
   
  public function getStaffLastUpdate($id, $type){
    if($type == 1){
        $this->db->order_by('id','desc');
        return $this->db->get_where('logData',array('tableReferenceId'=>$id, 'tableReference'=>3))->row_array();
    } else {
        $this->db->order_by('id','desc');
        return $this->db->get_where('logData',array('tableReferenceId'=>$id, 'tableReference'=>3))->result_array();
    }
  }

}
 ?>