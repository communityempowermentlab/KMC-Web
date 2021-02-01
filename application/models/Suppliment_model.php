<?php
class Suppliment_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
  
public function AddUpdateSuppliment($data){
        $arrayName = array();
        $arrayName['Name'] = $data['suppliment_name'];
        $arrayName['Duration'] = $data['number_days'];
        $arrayName['Status ']      = '1';
        if (!empty($data['SupplimentID'])) {
           $arrayName['ModifyDate'] = time();
           $this->db->where('ID',$data['SupplimentID']);
           $this->db->update('supplimentmaster',$arrayName); 
          return 'update';
        } else {
            $arrayName['AddDate']    = time();
            $this->db->insert('supplimentmaster',$arrayName); 
          return 'insert';
        }
    }
public function checkSupplimentName($name, $id){
  if(!empty($id)){
    return $this->db->get_where('supplimentmaster',array('Name'=>$name, 'ID!=' => $id))->row_array(); 
  } else {
    return $this->db->get_where('supplimentmaster',array('Name'=>$name))->row_array(); 
  }
}

}
 ?>