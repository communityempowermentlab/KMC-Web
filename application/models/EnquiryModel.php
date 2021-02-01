<?php
class EnquiryModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}



   public function getData($table_name, $con = array(), $id = false) {
      
    if (!empty($id)) {
      
      $query = $this->db
              ->select('*')
              ->from($table_name)
              ->where($con)
              ->get()
              ->row_array();
    } else {
      $query = $this->db
              ->select('*')
              ->from($table_name)
              ->order_by('id', 'desc')
              ->where($con)
              ->get()
              ->result_array();
    }
    
    return $query;
  }


  public function getDataByDistrict($district){
    $query = $this->db
              ->select('stuckData.*')
              ->from('stuckData')
              ->order_by('stuckData.id', 'desc')
              ->join('loungeMaster','stuckData.loungeId=loungeMaster.loungeId')
              ->join('facilitylist','loungeMaster.facilityId=facilitylist.FacilityID')
              ->where(array('facilitylist.PRIDistrictCode' => $district ))
              ->get()
              ->result_array();
    return $query;
  }


  public function getDataByFacility($facilityId){
    $query = $this->db
              ->select('stuckData.*')
              ->from('stuckData')
              ->order_by('stuckData.id', 'desc')
              ->join('loungeMaster','stuckData.loungeId=loungeMaster.loungeId')
              ->where(array('loungeMaster.facilityId' => $facilityId ))
              ->get()
              ->result_array(); 
    return $query;
  }

  
  public function getDataByFacilityKeyword($facilityId, $keyword){
    return $this
            ->db
            ->query("SELECT `stuckData`.* FROM `stuckData` JOIN `loungeMaster` ON `stuckData`.`loungeId`=`loungeMaster`.`loungeId` WHERE `loungeMaster`.`facilityId` = '".$facilityId."' AND (stuckData.`location` Like '%{$keyword}%' OR loungeMaster.`loungeName` Like '%{$keyword}%') ORDER BY `stuckData`.`id` DESC")->result_array();
  }

  public function getDataByDistrictKeyword($district, $keyword){
    return $this
            ->db
            ->query("SELECT `stuckData`.* FROM `stuckData` JOIN `loungeMaster` ON `stuckData`.`loungeId`=`loungeMaster`.`loungeId` JOIN `facilitylist` ON `loungeMaster`.`facilityId`=`facilitylist`.`FacilityID` WHERE `facilitylist`.`PRIDistrictCode` = '".$district."' AND (stuckData.`location` Like '%{$keyword}%' OR loungeMaster.`loungeName` Like '%{$keyword}%') ORDER BY `stuckData`.`id` DESC")->result_array();
  }


  public function getDataByKeyword($keyword){
    return $this
            ->db
            ->query("SELECT `stuckData`.* FROM `stuckData` JOIN `loungeMaster` ON `stuckData`.`loungeId`=`loungeMaster`.`loungeId` WHERE (stuckData.`location` Like '%{$keyword}%' OR loungeMaster.`loungeName` Like '%{$keyword}%') ORDER BY `stuckData`.`id` DESC")->result_array();
  }

}
?>