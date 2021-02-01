<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class SupplimentManagenent extends Welcome {
  public function __construct() {
      parent::__construct();
      $this->load->model('SupplimentModel');  
      $this->load->model('FacilityModel');  
    }
      /* Suppliment Listing Page Call*/
  public function manageSupplement() {
      $data['index']         = 'suppliment';
      $data['index2']        = 'Manage Supplements';
      $data['title']         = 'Manage Supplements | '.PROJECT_NAME; 
      $data['SupplimentData']     = $this->db->query(" select * from supplementMaster order by ID desc")->result_array();
      $data['fileName']         = 'Supplement_List'; 
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/suppliment/SupplimentList');
      $this->load->view('admin/include/footer');
      $this->load->view('admin/include/dataTable');  
  }
      /* Add  And Update Suppliment Data By this*/
  public function AddUpdateSuppliment($value='') {
       $data = $this->input->post();
       $name = $data['suppliment_name'];
       $value = $this->SupplimentModel->checkSupplimentName($name);

         $check = $this->SupplimentModel->AddUpdateSuppliment($data);
         if($check == 'insert') {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
            redirect('supplimentM/manageSupplement');
        } else if ($check == 'update') {
            $this->session->set_flashdata('activate', getCustomAlert('S','Suppliment data has been updated Successfully.'));
            redirect('supplimentM/manageSupplement');
        }else if ($value['Name']==$name) {
          $this->session->set_flashdata('activate', getCustomAlert('W','Suppliment Name already Exits.'));
           redirect('supplimentM/manageSupplement');
      } 

  }

   /* Add Suppliment page added by neha*/
  public function AddSuppliment(){
      $data['index']         = 'suppliment';
      $data['index2']        = 'Manage Supplements';
      $data['title']         = 'Manage Supplements | '.PROJECT_NAME; 
      
      $data['fileName']         = 'Supplement_List'; 

      if($this->input->post()){
        $data = $this->input->post();
         
        $arrayName['name'] = $data['suppliment_name'];
        $arrayName['duration']    = $data['number_days'];
        $arrayName['status ']     = '1';
        $arrayName['addDate']    = date('Y-m-d H:i:s');
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        $check = $this->db->insert('supplementMaster',$arrayName);

        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
        redirect('supplimentM/manageSupplement');

      }

      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/suppliment/addSuppliment');
      $this->load->view('admin/include/footer');
  }


  public function EditSuppliment(){
      $id = $this->uri->segment(3); 

      $data['index']         = 'suppliment';
      $data['index2']        = 'Manage Supplements';
      $data['title']         = 'Manage Supplements | '.PROJECT_NAME; 

      $data['SupplimentData']     = $this->db->query(" select * from supplementMaster where ID = ".$id)->row_array();

      if($this->input->post()){
        $data = $this->input->post();
         
        $arrayName['name'] = $data['suppliment_name'];
        $arrayName['duration']    = $data['number_days'];
        
        $arrayName['modifyDate'] = date('Y-m-d H:i:s');

        $this->db->where('id',$data['suppliment_id']);
        $this->db->update('supplementMaster',$arrayName);

        $this->session->set_flashdata('activate', getCustomAlert('S','Suppliment data has been updated Successfully.'));
        redirect('supplimentM/manageSupplement');

      }
      
      $data['fileName']         = 'Supplement_List'; 

      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/suppliment/editSuppliment');
      $this->load->view('admin/include/footer');

  }


  public function checkSuppliment(){
    if($this->input->post()){
      $name = $this->input->post('name');
      $id = $this->input->post('id');

      $value = $this->SupplimentModel->checkSupplimentName($name, $id);
      if(!empty($value)){
        echo 1;  // name already exists
      } else {
        echo 0;  // name does not exists
      }

    }
  }
  

 }

 