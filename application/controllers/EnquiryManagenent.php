<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class EnquiryManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('FacilityModel');
    $this->load->model('EnquiryModel');
    $this->load->model('LoungeModel');
    date_default_timezone_set('Asia/Kolkata');
    $this->is_not_logged_in(); 
    $this->restrictPageAccess(array('12'));
  }

  

  /* 
    view Facility listing page when click on sidemenu Facilities
    view file name & path : admin/facility/facilityList
    facility table : facilitylist
  */ 
  public function enquiryList(){
    $data['index']         = 'enquiryM';
    $data['index2']        = '';
    $data['fileName']      = 'enquiryList';
    $data['title']         = 'Enquiries | '.PROJECT_NAME; 
    if($this->input->get()) { 
      if(empty($_GET['keyword']) && empty($_GET['facilityname']) && empty($_GET['district'])) { 
        $data['GetList']  = $this->EnquiryModel->getData('stuckData',array()); 
      } else if(!empty($_GET['keyword']) && empty($_GET['facilityname']) && empty($_GET['district'])) { 
        $data['GetList']  = $this->EnquiryModel->getDataByKeyword($_GET['keyword']);
      } else if(empty($_GET['keyword']) && !empty($_GET['facilityname'])) { 
        $data['GetList']  = $this->EnquiryModel->getDataByFacility($_GET['facilityname']);
      } else if(empty($_GET['keyword']) && empty($_GET['facilityname']) && !empty($_GET['district'])) { 
        $data['GetList']  = $this->EnquiryModel->getDataByDistrict($_GET['district']); 
      } else if(!empty($_GET['keyword']) && !empty($_GET['facilityname'])) { 
        $data['GetList']  = $this->EnquiryModel->getDataByFacilityKeyword($_GET['facilityname'], $_GET['keyword']); 
      } else if(!empty($_GET['keyword']) && !empty($_GET['district'])) { 
        $data['GetList'] = $this->EnquiryModel->getDataByDistrictKeyword($_GET['district'], $_GET['keyword']);
      }
    } else {
      $data['GetList']  = $this->EnquiryModel->getData('stuckData',array()); 
    }

    $data['GetDistrict']      = $this->FacilityModel->selectquery(); 

     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/enquiry/enquiry-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  /* 
    view Facility log page when click on last updated link
    view file name & path : admin/facility/facilityLogList
    facility table : facilitylist
  */  
  public function takeAction(){ 
    $id=$this->uri->segment(3);
    $data['index']         = 'enquiryM';
    $data['index2']        = '';
    $data['fileName']      = 'viewEnquiry';
    $data['title']         = 'Enquiry Information | '.PROJECT_NAME; 
    
    $data['GetData'] = $this->EnquiryModel->getData('stuckData', array('id'=>$id), $id); 
    if(!empty($data['GetData']['loungeId'])){
      $GetLounge = $this->FacilityModel->GetLoungeById($data['GetData']['loungeId']); 
      $data['loungeName'] = $GetLounge['loungeName'];

      $facility   =     $this->FacilityModel->GetFacilityName($GetLounge['facilityId']); 
      $data['facilityName'] = $facility['FacilityName'];

      $data['district']   =     $this->FacilityModel->GetDistrictName($facility['PRIDistrictCode']);
    } else {
      $data['loungeName'] = '--';
      $data['facilityName'] = '--';
      $data['district'] = '--';
    }

    if($this->input->post()){ 
        $status = $this->input->post('status');
        $remark = $this->input->post('remark');

        $loginId = $this->session->userdata('adminData')['Id'];

        $UpdateData = array(
                            'status'      => $status,
                            'remark'      => $remark,
                            'responseGivenBy'       => $loginId,
                            'modifyDate'            => date('Y-m-d H:i:s')
                           );

        $cond = array('id' => $id );

        $check = $this->UserModel->updateData('stuckData', $UpdateData, $cond);

        $notiData = array(
                            'status'      => 2,
                            'modifyDate'            => date('Y-m-d H:i:s')
                           );

        $this->UserModel->updateData('adminNotification', $notiData, array('type' => 1, 'tableId' => $id));

        $this->session->set_flashdata('activate', getCustomAlert('S','Enquiry Updated successfully'));
        redirect('enquiryM/enquiryList');

      }

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/enquiry/enquiry-view');
      $this->load->view('admin/include/footer-new');

  }

}

?>

