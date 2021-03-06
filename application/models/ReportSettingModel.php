<?php
class ReportSettingModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  // get all Report data in desc order
  public function reportSetting(){
    $adminData = $this->session->userdata('adminData');  
    $this->db->order_by('staffId','desc');
    if ($adminData['type']=='1') {
      return $this->db->get_where('reportsetting')->result_array(); 
    }     
  } 

  public function reportCategory(){ 
    
      return $this->db->get_where('reportCategory')->result_array(); 
        
  } 

  // get Report Settin data via facilityId
  public function getReportSettingData($type,$limit='',$offset=''){ 
    
      if ($type == '1') { 
        $this->db->select('*');
        $result = $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` order by reportsetting.id desc")->result_array();
        return $result;
       
      } else { 
        return $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` order by reportsetting.id desc LIMIT ".$offset.", ".$limit."")->result_array();
      } 
       
  } 

  // get Report Download data via facilityId
  public function getReportDownloadData($type,$limit='',$offset='', $reportSettingId="1"){ 
    
      if ($type == '1') { 
        $this->db->select('*');
        $result = $this->db->query("SELECT * FROM reportLogs where `reportSettingId`= $reportSettingId order by id desc")->result_array();
        return $result;
       
      } else { 
        return $this->db->query("SELECT * FROM reportLogs  where `reportSettingId`=$reportSettingId order by id desc LIMIT ".$offset.", ".$limit."")->result_array();
      } 
       
  }

  public function getReportSettingDataWhereCategory($type,$category,$limit='',$offset=''){ 
    
      if ($type == '1') { 
        $this->db->select('*');
        $result = $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` where reportsetting.`category`= $category order by reportsetting.id desc")->result_array();
        return $result;
       
      } else { 
        return $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` where reportsetting.`category`= $category  order by reportsetting.id desc LIMIT ".$offset.", ".$limit."")->result_array();
      } 
       
  } 



  // get staff data with search and limit
  public function getReportSettingDataWhereSearching($type,$keyword,$limit='',$offset=''){
    if ($type == '1') {
      return $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` where  (reportsetting.`subject` Like '%{$keyword}%')")->num_rows(); 
    } else {
      return $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` where  (reportsetting.`subject` Like '%{$keyword}%') LIMIT ".$offset.", ".$limit."")->result_array();
       
    }       
  } 

  

  public function getReportSettingWhereFacilitySearch($type,$keyword,$category,$limit='',$offset=''){
    if ($type == '1') {
     return  $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` where reportsetting.`category`= $category AND reportsetting.`subject` Like '%{$keyword}%'")->num_rows(); 
      
    } else {
      return $this->db->query("SELECT reportsetting.*, reportCategory.name as categoryName FROM reportsetting left join reportCategory on reportsetting.`category`=reportCategory.`id` where reportsetting.`category`= $category AND reportsetting.`subject` Like '%{$keyword}%' LIMIT ".$offset.", ".$limit."")->result_array();
    }    
  }

  // get total Lounge where application has launched
  public function GettotalLaunchLounge(){
    return  $this->db->query("SELECT * FROM loungeMaster where `phase` in (1,2,3) AND `status` = 1")->num_rows(); 
  }

  public function GettotalLoungeAddInReport($reportsettingId){
    return  $this->db->query("SELECT * FROM reportfacilities where `reportsettingId` = $reportsettingId")->num_rows(); 
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
    //$this->db->select('facilityId');
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
    $fields = array();
    

    $fields['subject']            =       $data['subject'];
    $fields['body']               =       $data['body'];
    $fields['emailFrom']          =       $data['emailFrom'];
    $fields['subscription']       =       $data['subscription'];
    $fields['category']       =       $data['category'];
    $fields['addDate']            =       date("Y-m-d H:i:s");
    
    $this->db->insert('reportsetting',$fields);
    $id = $this->db->insert_id();
    foreach($data['lounge'] as $value)
    {
      $explode = explode("-",$value); 
      $district = $explode[0];
      $facility = $explode[1];
      $lounge   = $explode[2];

      $fields2                   =       array();
      $fields2['reportsettingId']       =       $id;
      $fields2['districtId']            =       $district;
      $fields2['facilityId']            =       $facility;
      $fields2['loungeId']            =       $lounge;
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
    //echo date("Y-m-d H:i:s"); die;
    $fields                       =       array();
    

    $fields['subject']            =       $data['subject'];
    $fields['body']               =       $data['body'];
    $fields['emailFrom']          =       $data['emailFrom'];
    $fields['subscription']       =       $data['subscription'];
    $fields['category']       =       $data['category'];
    $fields['addDate']       =       date("Y-m-d H:i:s");
    $this->db->where('id',$id);
    $this->db->update('reportsetting',$fields);

    $this->db->where('reportsettingId', $id);
    $this->db->delete('reportfacilities');

    $this->db->where('reportsettingId', $id);
    $this->db->delete('reportemail');


    foreach($data['lounge'] as $value)
    {
      $explode = explode("-",$value); 
      $district = $explode[0];
      $facility = $explode[1];
      $lounge   = $explode[2];

      $fields2                   =       array();
      $fields2['reportsettingId']       =       $id;
      $fields2['districtId']            =       $district;
      $fields2['facilityId']            =       $facility;
      $fields2['loungeId']            =       $lounge;
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

  public function getDistrict(){
    return $query=$this->db->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` ORDER BY DistrictNameProperCase asc")->result_array();
  }

  public function GetFacilityByDistrict($district){

    $this->db->select('facilitylist.*');
    $this->db->order_by('FacilityName','asc');
    return $getFacilityList = $this->db->get_where('facilitylist',array('PRIDistrictCode'=>$district,'status'=>1))->result_array();
  }

  public function GetLoungeByFAcility($facilityId){

    $this->db->select('loungeMaster.*');
    $this->db->order_by('loungeName','asc');
    return $getLoungeList = $this->db->get_where('loungeMaster',array('facilityId'=>$facilityId,'status'=>1))->result_array();
  }

}
 ?>