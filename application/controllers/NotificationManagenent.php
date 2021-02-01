<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class NotificationManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('FacilityModel');
    $this->load->model('EnquiryModel');
    $this->load->model('LoungeModel');
    date_default_timezone_set('Asia/Kolkata');
    $this->is_not_logged_in(); 
       
  }

  

  /* 
    view Facility listing page when click on sidemenu Facilities
    view file name & path : admin/facility/facilityList
    facility table : facilitylist
  */ 
  public function viewAll(){
    $data['index']         = 'notificationM';
    $data['index2']        = '';
    $data['fileName']      = 'notificationList';
    $data['title']         = 'Notification | '.PROJECT_NAME; 
    
    $data['GetList']  = $this->EnquiryModel->getData('adminNotification',array()); 
    
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/notification/notification-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function markAllRead(){
    $array = array( 'status' => 2, 
                    'modifyDate' => date('Y-m-d H:i:s')
            );
    $this->db->update('adminNotification',$array);

    redirect('notificationM/viewAll');

  }

  public function markReadNotification(){
    $id = $this->input->post('id');
    $array = array( 'status' => 2, 
                    'modifyDate' => date('Y-m-d H:i:s')
            );
    $this->db->where(array('id'=>$id));
    $this->db->update('adminNotification',$array);
  }


  

}

?>

