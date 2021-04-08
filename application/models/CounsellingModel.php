<?php
class CounsellingModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  // get data from counsellingMaster in desc order
  public function GetVideo($type=false) {
    if(!empty($type)){
      $this->db->where('videoType',$type);
    }
    $this->db->order_by("id","desc");
    $query = $this->db->get_where('counsellingMaster');
    return $query->result_array();
  }

  // get data from videoType in desc order
  public function GetVideoList(){
    $this->db->order_by("id", "DESC");
    return $this->db->get_where('videoType')->result_array();
  }

  // insert data into table
  public function AddData($table, $data){
    $this->db->insert($table,$data);
    return 1;
  }

  public function GetVideoLog($id){
    $this->db->order_by("id","desc");
    $query = $this->db->get_where('videoTypeLog', array('videoTypeId' => $id));
    return $query->result_array();
  }

  /* check if login mobile number already exists */
  public function checkVideoName($name, $table, $column, $id, $id_column,$type){
    if($id == ''){
      return $this->db->get_where($table,array($column => $name, "videoType"=> $type))->row_array(); 
    } else {
      return $this->db->get_where($table,array($column => $name, $id_column.'!=' => $id, "videoType"=> $type))->row_array(); 
    }
  }

  public function clickVideoCount($id){
    $query = $this->db->get_where('counsellingVideoLog', array('counsellingMasterId' => $id));
    return $query->num_rows();
  }
  public function clickVideoCountLounge($id,$loungeId){
    $query = $this->db->get_where('counsellingVideoLog', array('counsellingMasterId' => $id,'loungeId' => $loungeId));
    return $query->num_rows();
  }
  public function videoWatchlasttime($id,$loungeId){
    $this->db->order_by("id","desc");
    $this->db->limit("1");
     $query = $this->db->get_where('counsellingVideoLog', array('counsellingMasterId' => $id,'loungeId' => $loungeId));
    return $query->row_array();
  }


  // get data from counsellingMaster in desc order
  public function GetVideoWatchlist($id) {

    $this->db->select('counsellingVideoLog.*,loungeMaster.loungeName as loungeName,counsellingMaster.videoName as videoName, counsellingMaster.videoTitle as videoTitle');
    $this->db->join('counsellingMaster','counsellingMaster.id=counsellingVideoLog.counsellingMasterId');
    $this->db->join('loungeMaster','loungeMaster.loungeId=counsellingVideoLog.loungeId');
    
    $this->db->where('counsellingVideoLog.counsellingMasterId',$id);
    $this->db->order_by("counsellingVideoLog.id","ASC");
    $this->db->group_by("counsellingVideoLog.loungeId");
    $query = $this->db->get_where('counsellingVideoLog');
    return $query->result_array();
  }

}
 ?>