<?php
class SupplimentModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
  
  // add or update suppliment data
  public function AddUpdateSuppliment($data){
    $arrayName = array();
    $arrayName['name'] = $data['suppliment_name'];
    $arrayName['duration'] = $data['number_days'];
    $arrayName['status ']      = '1';
    if (!empty($data['SupplimentID'])) {
      $arrayName['modifyDate'] = time();
      $this->db->where('id',$data['SupplimentID']);
      $this->db->update('supplementMaster',$arrayName); 
      return 'update';
    } else {
      $arrayName['addDate']    = time();
      $this->db->insert('supplementMaster',$arrayName); 
      return 'insert';
    }
  }

  // get suppliment data via id
  public function checkSupplimentName($name, $id){
    if(!empty($id)){
      return $this->db->get_where('supplementMaster',array('name'=>$name, 'id!=' => $id))->row_array(); 
    } else {
      return $this->db->get_where('supplementMaster',array('name'=>$name))->row_array(); 
    }
  }

}
 ?>