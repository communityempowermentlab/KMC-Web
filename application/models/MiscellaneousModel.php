<?php
class MiscellaneousModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  
  public function getMenuByPos($table_name, $con = array(), $id = false) {
      
        if (!empty($id)) {
          
          $query = $this->db
                  ->select('*')
                  ->from($table_name)
                  ->order_by('posId', 'asc')
                  ->where($con)
                  ->get()
                  ->row_array();
        } else {
          $query = $this->db
                  ->select('*')
                  ->from($table_name)
                  ->order_by('posId', 'asc')
                  ->where($con)
                  ->get()
                  ->result_array();
        }
        
        return $query;
  }

  public function addMenuHeading($data)
  {
      $this->db->insert('manageSitemap', $data);
      $heading_menu_id = $this->db->insert_id();
      return $heading_menu_id;
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
              ->where($con)
              ->get()
              ->result_array();
    }
    
    return $query;
  }


  public function getSettingData(){
    $query = $this->db
              ->select('*')
              ->from('settings')
              
              ->get()
              ->row_array();
    return $query;
  }

  public function editMenuLabel($data,$id)
  {
      $this->db->where('id', $id);
      $this->db->update('manageSitemap', $data);
      return true;
  }


  /* change status */
    public function changeStatus($row_id, $table_name) {
      
      $qry = $this->db
            ->select('*')
            ->from($table_name)
            ->where('id', $row_id)
            ->get()
            ->row_array();

      $date_time = date('Y-m-d H:i:s');

      if ($qry['status'] == '1') {

        $data = array(
                'status'    => '2',
                'modifyDate'  => $date_time

              );
        $update_data = $this->db->where('id', $row_id)->update($table_name, $data);
        return 2;

      } else if ($qry['status'] == '2') {

        $data = array(
                'status'    => '1',
                'modifyDate'  => $date_time
              );
        $update_data = $this->db->where('id', $row_id)->update($table_name, $data);
        return 1;

      }
    } /* change status / */ 

    /* insert group permission data */
    public function insertGroup($table_name, $con) {
        $query = $this->db->insert($table_name, $con);
        $last_id = $this->db->insert_id();
          return $last_id; 
    }


     public function getMenu($table_name, $con = array(), $id = false) {
      
        if (!empty($id)) {
          
          $query = $this->db
                  ->select('*')
                  ->from($table_name)
                  ->order_by('posId', 'asc')
                  ->where($con)
                  ->get()
                  ->row_array();
        } else {
        $query = $this->db
                  ->select('*')
                  ->from($table_name)
                  ->order_by('posId', 'asc')
                  ->where($con)
                  ->get()
                  ->result_array();
        }
        
        return $query;
      }


    public function updateData($table_name, $con, $menu_group_id, $col_name) {
      $query = $this->db->where($col_name, $menu_group_id)->update($table_name, $con);
      return $query;
    }

    public function updateManageMenuGroup($table_name, $con, $menu_group_id) {
      $query = $this->db->where('id', $menu_group_id)->update($table_name, $con);
      return $query;
    }


    /*delete previous assets*/
    public function deleteMenuGroupHeading($id)
    {
      $this->db->where(array('menuGroupId'=>$id));
      $this->db->delete('headingControlSystem');
      return true;
    }
      /********************/


}
?>