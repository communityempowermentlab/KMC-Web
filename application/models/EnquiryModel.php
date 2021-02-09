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
      $getCoachLounge = $this->UserModel->getCoachFacilities();

      if(!empty($getCoachLounge['coachLoungeArray'])){         
        $this->db->where_in('loungeId', $getCoachLounge['coachLoungeArray']);
      }
      $this->db->order_by('id', 'desc');
      $query = $this->db->get_where($table_name,$con)->result_array(); 
    }
    
    return $query;
  }


  public function getDataByDistrict($district){
    $getCoachLounge = $this->UserModel->getCoachFacilities();

    $this->db->select('stuckData.*,loungeMaster.facilityId,facilitylist.FacilityName');
    $this->db->join('loungeMaster','stuckData.loungeId=loungeMaster.loungeId');
    $this->db->join('facilitylist','loungeMaster.facilityId=facilitylist.FacilityID');
    $this->db->where(array('facilitylist.PRIDistrictCode' => $district));
    if(!empty($getCoachLounge['coachLoungeArray'])){         
      $this->db->where_in('stuckData.loungeId', $getCoachLounge['coachLoungeArray']);
    }
    $this->db->order_by('stuckData.id', 'desc');
    return $query = $this->db->get_where('stuckData')->result_array();
  }


  public function getDataByFacility($facilityId){

    $getCoachLounge = $this->UserModel->getCoachFacilities();

    $this->db->select('stuckData.*,loungeMaster.facilityId');
    $this->db->join('loungeMaster','stuckData.loungeId=loungeMaster.loungeId');
    $this->db->where(array('loungeMaster.facilityId' => $facilityId));
    if(!empty($getCoachLounge['coachLoungeArray'])){         
      $this->db->where_in('stuckData.loungeId', $getCoachLounge['coachLoungeArray']);
    }
    $this->db->order_by('stuckData.id', 'desc');
    return $query = $this->db->get_where('stuckData')->result_array(); 
  }

  
  public function getDataByFacilityKeyword($facilityId, $keyword){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = 'and stuckData.loungeId in '.$getCoachLounge['coachLoungeArrayString'].' ';
    }

    return $this
            ->db
            ->query("SELECT `stuckData`.* FROM `stuckData` JOIN `loungeMaster` ON `stuckData`.`loungeId`=`loungeMaster`.`loungeId` WHERE `loungeMaster`.`facilityId` = '".$facilityId."' AND (stuckData.`location` Like '%{$keyword}%' OR loungeMaster.`loungeName` Like '%{$keyword}%') ".$where_lounge." ORDER BY `stuckData`.`id` DESC")->result_array();
  }

  public function getDataByDistrictKeyword($district, $keyword){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = 'and stuckData.loungeId in '.$getCoachLounge['coachLoungeArrayString'].' ';
    }

    return $this
            ->db
            ->query("SELECT `stuckData`.* FROM `stuckData` JOIN `loungeMaster` ON `stuckData`.`loungeId`=`loungeMaster`.`loungeId` JOIN `facilitylist` ON `loungeMaster`.`facilityId`=`facilitylist`.`FacilityID` WHERE `facilitylist`.`PRIDistrictCode` = '".$district."' AND (stuckData.`location` Like '%{$keyword}%' OR loungeMaster.`loungeName` Like '%{$keyword}%') ".$where_lounge." ORDER BY `stuckData`.`id` DESC")->result_array();
  }


  public function getDataByKeyword($keyword){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = 'and loungeId in '.$getCoachLounge['coachLoungeArrayString'].' ';
    }

    return $this
            ->db
            ->query("SELECT `stuckData`.* FROM `stuckData` JOIN `loungeMaster` ON `stuckData`.`loungeId`=`loungeMaster`.`loungeId` WHERE (stuckData.`location` Like '%{$keyword}%' OR loungeMaster.`loungeName` Like '%{$keyword}%') ".$where_lounge." ORDER BY `stuckData`.`id` DESC")->result_array();
  }

}
?>