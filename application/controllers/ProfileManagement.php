<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class ProfileManagement extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('StaffModel');  
    $this->load->model('FacilityModel'); 
    $this->load->model('UserModel'); 
    $this->load->model('SmsModel'); 
    $this->load->model('LoungeModel');  
    $this->load->library('pagination'); 
    $this->is_not_logged_in(); 
  }


  /* Update Staff Page Call*/
public function updateProfile(){
  $adminData = $this->session->userdata('adminData');
  
      $id = $this->uri->segment(3);
      $data['index']         = 'Profile';
      $data['index2']        = '';
      $data['title']         = 'Update Profile | '.PROJECT_NAME; 
      // $facility_id = $this->uri->segment(3, 0); 
      // $data['facility_id']   = $facility_id;
      if($adminData['Type']==1) {
        $data['GetStaff']  = $this->UserModel->GetDataById('adminMaster',$adminData['Id']);
      }
      else{

       $data['GetStaff']  = $this->UserModel->GetDataById('coachMaster',$adminData['Id']);
      }
        
      
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/profile/profile');
      $this->load->view('admin/include/footer-new');
    }

    /* Update Admin Profile*/
    public function UpdateProfilePost(){
     $id = $this->uri->segment(3);
     $data= $this->input->post();

    $record = $this->UserModel->GetDataById('adminMaster',$id );
     if($_FILES['image']['name'] != ""){      
      $fileName   = $_FILES['image']['name'];
      $extension  = explode('.',$fileName);
      $extension  = strtolower(end($extension));
      $uniqueName = time().'.'.$extension;
      $tmp_name   = $_FILES['image']['tmp_name'];
      $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/admin/".$uniqueName; 
     
      $InsertImg = utf8_encode(trim($uniqueName));
      move_uploaded_file($tmp_name,$targetlocation);
    }else{
      $InsertImg = $data['prevFile'];
    }

    $fields['name']                       =       $data['Name'];
    $fields['email']                 =       $data['email'];
    $fields['profileImage']               =       $InsertImg;
    $fields['password']               =       $data['password'];
    

    if($data['password'] == "")
    {
      $fields['password']         = $record['password'];
    }
    else
    {
      $fields['password']         = base64_encode($data['password']);
    }

    $con = array('id'=>$id);

     
     $updatedatas = $this->UserModel ->updateData('adminMaster',$fields,$con);
      if ($updatedatas > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
            redirect('ProfileM/updateProfile/');
      } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('ProfileM/updateProfile/');
      }
  }

  /* Update Admin Profile*/
    public function UpdatecoachProfilePost(){
     $id = $this->uri->segment(3);
     $data= $this->input->post();

    $record = $this->UserModel->GetDataById('coachMaster',$id );
     if($_FILES['image']['name'] != ""){      
      $fileName   = $_FILES['image']['name'];
      $extension  = explode('.',$fileName);
      $extension  = strtolower(end($extension));
      $uniqueName = time().'.'.$extension;
      $tmp_name   = $_FILES['image']['tmp_name'];
      $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/admin/".$uniqueName; 
     
      $InsertImg = utf8_encode(trim($uniqueName));
      move_uploaded_file($tmp_name,$targetlocation);
    }else{
      $InsertImg = $data['prevFile'];
    }

    $fields['name']                       =       $data['Name'];
    $fields['mobile']                 =       $data['mobile'];
    $fields['profileImage']               =       $InsertImg;
    $fields['password']               =       $data['password'];
    

    if($data['password'] == "")
    {
      $fields['password']         = $record['password'];
    }
    else
    {
      $fields['password']         = md5($data['password']);
    }

    $con = array('id'=>$id);

     
     $updatedatas = $this->UserModel ->updateData('coachMaster',$fields,$con);
      if ($updatedatas > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
            redirect('ProfileM/updateProfile/');
      } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('ProfileM/updateProfile/');
      }
  }    






}

    