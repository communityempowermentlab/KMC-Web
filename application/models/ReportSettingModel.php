<?php
class ReportSettingModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  // get all staffs data in desc order
  public function reportSetting(){
    $adminData = $this->session->userdata('adminData');  
    $this->db->order_by('staffId','desc');
    if ($adminData['type']=='1') {
      return $this->db->get_where('reportsetting')->result_array(); 
    }     
  } 

  // get staff data via facilityId
  public function getReportSettingData($type,$limit='',$offset=''){ 
    
      if ($type == '1') { 
        $this->db->select('*');
        $result = $this->db->query("SELECT * FROM reportsetting order by id desc")->result_array();
        return $result;
       
      } else { 
        return $this->db->query("SELECT * FROM reportsetting order by id desc LIMIT ".$offset.", ".$limit."")->result_array();
      } 
       
  } 

  // get staff data with search and limit
  public function getStaffDataWhereSearching($type,$keyword,$limit='',$offset=''){
    if ($type == '1') {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%')")->num_rows(); 
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where (sm.`Name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%') LIMIT ".$offset.", ".$limit."")->result_array();
       
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
    if ($type == '1') {
     return  $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where (fl.`PRIDistrictCode` = $district)")->num_rows(); 
      
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where (fl.`PRIDistrictCode` = $district) LIMIT ".$offset.", ".$limit."")->result_array();
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
    if ($type == '1') {
     return  $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`staffType` where ((fl.`PRIDistrictCode` = $district) AND (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%'))")->num_rows(); 
      
    } else {
      return $this->db->query("SELECT * from staffMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join staffType as st on st.`staffTypeId` = sm.`StaffType` where ((fl.`PRIDistrictCode` = $district) AND (sm.`name` Like '%{$keyword}%' OR st.`staffTypeNameEnglish` Like '%{$keyword}%' OR sm.`staffMobileNumber` Like '%{$keyword}%' OR sm.`emergencyContactNumber` Like '%{$keyword}%' OR sm.`staffAddress` Like '%{$keyword}%')) LIMIT ".$offset.", ".$limit."")->result_array();
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
  public function GetReportById($id){
    return $this->db->get_where('reportsetting', array('id'=>$id))->row_array();
  }

  public function GetFacilityByReportId($id)
  {
    $this->db->select('facilityId');
    return $this->db->get_where('reportfacilities', array('reportsettingId'=>$id))->result_array();
  }

  public function GetEmailByReportId($id)
  {
    $this->db->select('email');
    return $this->db->get_where('reportemail', array('reportsettingId'=>$id))->result_array();
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
  public function AddReportData($data){
    $fields                             =       array();
    

    $fields['subject']                     =       $data['subject'];
    $fields['body']               =       $data['body'];
    $fields['emailFrom']                =       $data['emailFrom'];
    $fields['subscription']             =       $data['subscription'];
    
    $this->db->insert('reportsetting',$fields);
    $id = $this->db->insert_id();
    foreach($data['facilityId'] as $value)
    {
      $fields2                   =       array();
      $fields2['reportsettingId']       =       $id;
      $fields2['facilityId']            =       $value;
      $this->db->insert('reportfacilities',$fields2);
    }

$emails = explode(",",$data['email']);
    foreach($emails as $values)
    {
      $fields3                   =       array();
      $fields3['reportsettingId']       =       $id;
      $fields3['email']            =       $values;
      $this->db->insert('reportemail',$fields3);
    }
    
    
    
    return 1;
 
  }

  // update staff data
  public function UpdateReport($data,$id){
    $fields                       =       array();
    

    $fields['subject']            =       $data['subject'];
    $fields['body']               =       $data['body'];
    $fields['emailFrom']          =       $data['emailFrom'];
    $fields['subscription']       =       $data['subscription'];
    $this->db->where('id',$id);
    $this->db->update('reportsetting',$fields);

    $this->db->where('reportsettingId', $id);
    $this->db->delete('reportfacilities');

    $this->db->where('reportsettingId', $id);
    $this->db->delete('reportemail');


    foreach($data['facilityId'] as $value)
    {
      $fields2                   =       array();
      $fields2['reportsettingId']       =       $id;
      $fields2['facilityId']            =       $value;
      $this->db->insert('reportfacilities',$fields2);
    }

    $emails = explode(",",$data['email']);
    foreach($emails as $values)
    {
      $fields3                   =       array();
      $fields3['reportsettingId']       =       $id;
      $fields3['email']            =       $values;
      $this->db->insert('reportemail',$fields3);
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