<?php
class EmployeeModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

 
  
  // get employess list
  public function GetEmployees(){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('employeesData')->result_array(); 
  }

  public function GetEmployeeLog($id){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('employeesDataLog', array('employeeId' => $id))->result_array(); 
  }

  /* check if login mobile number already exists */
  public function checkLogInColumn($mobile, $table, $column, $id, $id_column){
    if($id == ''){
      return $this->db->get_where($table,array($column => $mobile))->row_array(); 
    } else {
      return $this->db->get_where($table,array($column => $mobile, $id_column.'!=' => $id))->row_array(); 
    }
  }
  
  // get staff data via staffId
  public function GetDataById($table, $cond){
    return $this->db->get_where($table, $cond)->row_array();
  }


  public function GetData($table, $cond){
    return $this->db->get_where($table, $cond)->result_array();
  }

  public function GetDataOrderByAsc($table, $cond, $col){
    $this->db->order_by($col, "ASC");
    return $this->db->get_where($table, $cond)->result_array();
  }

  
  public function insertData($table, $data){
    $this->db->insert($table,$data);
    $id = $this->db->insert_id();
    return $id;
  }

  
  public function updateData($table, $data, $cond){
    $this->db->where($cond);
    $this->db->update($table,$data); 
    return 1;
  }

  public function deleteData($table, $cond){
    $this->db->where($cond);
    $this->db->delete($table);
    return 1;
  }

  public function getMenuGroup($menuGroup){ 
    return $this->db->query("SELECT groupName from manageMenuGroupSetting where id in (".$menuGroup.")")->result_array();
  }

  public function getLastLogin($id){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('employeeLoginMaster', array('employeeId'=>$id))->row_array(); 
  }

  public function GetFacilityByDistrict($district){

    $this->db->select('facilitylist.*');
    $this->db->order_by('FacilityName','asc');
    return $getFacilityList = $this->db->get_where('facilitylist',array('PRIDistrictCode'=>$district,'status'=>1))->result_array();
  }

  public function GetFacilityByEmployeeId($id)
  {
    return $this->db->get_where('employeeDistrictFacilityLounge', array('masterId'=>$id))->result_array();
  }

  public function GetLoungeByFAcility($facilityId){

    $this->db->select('loungeMaster.*');
    $this->db->order_by('loungeName','asc');
    return $getLoungeList = $this->db->get_where('loungeMaster',array('facilityId'=>$facilityId,'status'=>1))->result_array();
  }

  public function getDistrict(){
    return $query=$this->db->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` ORDER BY DistrictNameProperCase asc")->result_array();
  }

  // get facility data where FacilityName is not blank
  public function GetFacilities(){
    return $this->db->query("SELECT * FROM `facilitylist` where FacilityName!='' ORDER BY `FacilityName` ASC")->result_array();
  }

}
 ?>