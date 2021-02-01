<?php
class VideoModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  // get data from counsellingMaster in desc order
  public function GetVideo() {
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


}
 ?>