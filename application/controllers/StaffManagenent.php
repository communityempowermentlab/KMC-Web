<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class StaffManagenent extends Welcome {
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

  /* Staff Listing page call */
  public function manageStaff(){
    // $facility_id = $this->uri->segment(3); 

    $facility_id = 'all';
    
    $limit         = DATA_PER_PAGE;
    $pageNo        = '1';
    $GetFacilities  = array();
    if(!empty($_GET['district'])){
       $GetFacilities  = $this->LoungeModel->GetFacilityByDistrict($_GET['district']);
    }

    if($this->input->get()) { 
      if(empty($_GET['keyword']) && empty($_GET['facilityname']) && empty($_GET['district'])) { 
        $totalRecords = $this->StaffModel->getStaffData('1', '', '', $facility_id); 
      } else if(!empty($_GET['keyword']) && empty($_GET['facilityname']) && empty($_GET['district'])) { 
        $totalRecords = $this->StaffModel->getStaffDataWhereSearching('1',trim($_GET['keyword']));
      } else if(empty($_GET['keyword']) && !empty($_GET['facilityname'])) { 
        $totalRecords = $this->StaffModel->getStaffDataWhereFacility('1',trim($_GET['facilityname']));
      } else if(empty($_GET['keyword']) && empty($_GET['facilityname']) && !empty($_GET['district'])) { 
        $totalRecords = $this->StaffModel->getStaffDataWhereDistrict('1',trim($_GET['district']));
      } else if(!empty($_GET['keyword']) && !empty($_GET['facilityname'])) { 
        $totalRecords = $this->StaffModel->getStaffDataWhereFacilitySearch('1',trim($_GET['keyword']),trim($_GET['facilityname']));
      } else if(!empty($_GET['keyword']) && !empty($_GET['district'])) { 
        $totalRecords = $this->StaffModel->getStaffDataWhereDistrictSearch('1',trim($_GET['keyword']),trim($_GET['district']));
      }
    } else { 
      $totalRecords = $this->StaffModel->getStaffData('1', '', '', $facility_id); 
    }  
     
      // set url for seaching and without searching
      !empty($_GET['keyword']) ? $config["base_url"] = base_url('staffM/manageStaff/'.$facility_id.'?keyword=' . $_GET['keyword']) : $config["base_url"] = base_url('staffM/manageStaff/'.$facility_id);
      
        if(!empty($totalRecords)){ 
          $config["total_rows"] = $totalRecords;
          $config["per_page"] = $limit;
          $config['use_page_numbers'] = TRUE;
          $config['page_query_string'] = TRUE;
          $config['enable_query_strings'] = TRUE;
          $config['num_links'] = 2;
          $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
          $config['cur_tag_close'] = '</a></li>';
          $config['next_link'] = 'Next';
          $config['prev_link'] = 'Previous';
          $this->pagination->initialize($config);
          $str_links           = $this->pagination->create_links();
          $links               = explode('&nbsp;', $str_links);
          $offset              = 0;
          if (!empty($_GET['per_page'])) {
              $pageNo = $_GET['per_page'];
              $offset = ($pageNo - 1) * $limit;
          }

          if($this->input->get()) { 
            if(empty($_GET['keyword']) && empty($_GET['facilityname']) && empty($_GET['district'])) { 
              $AllRecord = $this->StaffModel->getStaffData('2',$limit,$offset, $facility_id); 
            } else if(!empty($_GET['keyword']) && empty($_GET['facilityname']) && empty($_GET['district']))
            { 
              $AllRecord = $this->StaffModel->getStaffDataWhereSearching('2',trim($_GET['keyword']),$limit,$offset);
            } else if(empty($_GET['keyword']) && !empty($_GET['facilityname']))
            { 
              $AllRecord = $this->StaffModel->getStaffDataWhereFacility('2',trim($_GET['facilityname']),$limit,$offset);
            } else if(empty($_GET['keyword']) && empty($_GET['facilityname']) && !empty($_GET['district'])) { 
              $AllRecord = $this->StaffModel->getStaffDataWhereDistrict('2',trim($_GET['district']),$limit,$offset);
            } else if(!empty($_GET['keyword']) && !empty($_GET['facilityname']))
            { 
              $AllRecord = $this->StaffModel->getStaffDataWhereFacilitySearch('2',trim($_GET['keyword']),trim($_GET['facilityname']),$limit,$offset);
            } else if(!empty($_GET['keyword']) && !empty($_GET['district']))
            { 
              $AllRecord = $this->StaffModel->getStaffDataWhereDistrictSearch('2',trim($_GET['keyword']),trim($_GET['district']),$limit,$offset);
            } 
          } else {
            $AllRecord = $this->StaffModel->getStaffData('2',$limit,$offset, $facility_id); 
          }

        } else {
          $config["total_rows"] = array();
          $config["per_page"] = '';
          $config['use_page_numbers'] = FALSE;
          $config['page_query_string'] = FALSE;
          $config['enable_query_strings'] = FALSE;
          $config['num_links'] = 0;
          $config['cur_tag_open'] = '';
          $config['cur_tag_close'] = '';
          $config['next_link'] = '';
          $config['prev_link'] = '';
          $links = '';
          $AllRecord = '';
        }

        if($facility_id != 'all'){ 
          $GetFacility    = $this->LoungeModel->GetFacilitiName($facility_id); 
        } else {
          $GetFacility = '';
        }

        
        $GetDistrict    = $this->FacilityModel->selectquery(); 

        $data = array(
                  'totalResult'   => $totalRecords,
                  'results'       => $AllRecord,
                  'links'         => $links,
                  'index2'        => '',
                  'v_id'          => '',
                  'pageNo'        => $pageNo,
                  'index'         => 'staff',
                  'fileName'      => 'staffList',
                  'GetFacility'   => $GetFacility,
                  'GetDistrict'   => $GetDistrict,
                  'facilityList'  => $GetFacilities,
                  'facility_id'   => $facility_id,
                  'title'         => 'Staff | '.PROJECT_NAME
                 );
        $this->load->view('admin/include/header-new',$data);
        $this->load->view('admin/staff/staff-list');
        $this->load->view('admin/include/footer-new');
        $this->load->view('admin/include/datatable-new');
  }



  /* Staff Type Listing page call */ 
  public function staffType(){
      $data['index']         = 'StaffType';
      $data['index2']        = 'Manage Staff Type';
      $data['title']         = 'Staff Type | '.PROJECT_NAME; 
      $data['fileName']      = 'StaffTypeList'; 
      $data['StaffType']     = $this->FacilityModel->GetStaffType();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/staff/staff-type-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
  }
 /*Add Staff page call */


 public function staffTypeLog(){
      $id = $this->uri->segment(3); 
      $data['index']         = 'StaffType';
      $data['index2']        = 'Staff Type Log';
      $data['title']         = 'Staff Type Log | '.PROJECT_NAME; 
      $data['fileName']      = 'StaffTypeLogList'; 
      $data['StaffType']     = $this->FacilityModel->GetStaffTypeLog($id);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/staff/staff-type-log');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
 }


// add staff type page added by neha
 public function addStaffType(){
  $data['index']         = 'StaffType';
  $data['index2']        = 'Manage Staff Type';
  $data['title']         = 'Add Staff Type | '.PROJECT_NAME; 
  $data['fileName']      = 'StaffTypeList'; 

  if($this->input->post()){
    $data                              = $this->input->post();
    $loginId = $this->session->userdata('adminData')['Id'];
    $ip = $this->input->ip_address(); 

    if (empty($data['parent_staff_type'])) {
     $fields                            = array();
     $fields['parentId']                = '0';
     $fields['staffTypeNameEnglish']    = $data['staff_type_name'];
     $fields['addDate']                 = date('Y-m-d H:i:s');
     $fields['modifyDate']              = date('Y-m-d H:i:s');
     $insert = $this->db->insert('staffType',$fields);
     $staffTypeId = $this->db->insert_id();

     $logArray                            = array();
     $logArray['staffTypeId']             = $staffTypeId;
     $logArray['parentId']                = '0';
     $logArray['staffTypeNameEnglish']    = $data['staff_type_name'];
     $logArray['addDate']                 = date('Y-m-d H:i:s');
     $logArray['status']                  = 1;
     $logArray['addedBy']                 = $loginId;
     $logArray['ipAddress']               = $ip;
     $insert = $this->db->insert('staffTypeLog',$logArray);

    } else {
     $fields                            = array();
     $fields['parentId']                = $data['parent_staff_type'];
     $fields['staffTypeNameEnglish']    = $data['staff_type_name'];
     $fields['addDate']                 = date('Y-m-d H:i:s');
     $fields['modifyDate']              = date('Y-m-d H:i:s');
     $insert = $this->db->insert('staffType',$fields);
     $staffTypeId = $this->db->insert_id();

     $logArray                            = array();
     $logArray['staffTypeId']             = $staffTypeId;
     $logArray['parentId']                = $data['parent_staff_type'];
     $logArray['staffTypeNameEnglish']    = $data['staff_type_name'];
     $logArray['addDate']                 = date('Y-m-d H:i:s');
     $logArray['status']                  = 1;
     $logArray['addedBy']                 = $loginId;
     $logArray['ipAddress']               = $ip;
     $insert = $this->db->insert('staffTypeLog',$logArray);
    }
    if ($insert > 0) {
          $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
          redirect('staffM/staffType/');
    } else {
          $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
          redirect('staffM/staffType/');
    }
  }
      
  $this->load->view('admin/include/header-new',$data);
  $this->load->view('admin/staff/add-staff-type');
  $this->load->view('admin/include/footer-new');
 }


 public function editStaffType(){
      $id = $this->uri->segment(3); 
      $data['index']         = 'StaffType';
      $data['index2']        = 'Manage Staff Type';
      $data['title']         = 'Edit Staff Type | '.PROJECT_NAME; 
      $data['fileName']      = 'StaffTypeList'; 

      $data['StaffType']     = $this->StaffModel->GetStaffTypeById($id);

      $loginId = $this->session->userdata('adminData')['Id'];
      $ip = $this->input->ip_address();

      if($this->input->post()){
        $data                               = $this->input->post();
        $fields                             = array();
        $fields['parentId']                 = $data['parent_staff_type'];
        $fields['staffTypeNameEnglish']     = $data['staff_type_name'];
        $fields['status']                   = $data['status'];
        $fields['modifyDate']               = date('Y-m-d H:i:s');
        $this->db->where('StaffTypeID',$id);
        $update = $this->db->update('staffType',$fields);

        $logArray                             = array();
        $logArray['staffTypeId']              = $id;
        $logArray['parentId']                 = $data['parent_staff_type'];
        $logArray['staffTypeNameEnglish']     = $data['staff_type_name'];
        $logArray['status']                   = $data['status'];
        $logArray['addDate']                  = date('Y-m-d H:i:s');
        $logArray['addedBy']                  = $loginId;
        $logArray['ipAddress']                = $ip;

        $insert = $this->db->insert('staffTypeLog',$logArray);

        if ($update > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully'));
            redirect('staffM/staffType/');
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('staffM/staffType/');
        }
      }

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/staff/edit-staff-type');
      $this->load->view('admin/include/footer-new');
 }


public function addStaff(){
      $data['index']         = 'staff';
      $data['index2']        = '';
      $data['title']         = 'Add Staff | '.PROJECT_NAME; 
      // $facility_id = $this->uri->segment(3, 0); 
      // $data['facility_id']   = $facility_id;
      $data['GetFacilities'] = $this->StaffModel->GetFacilities();
      $data['GetStaffType']  = $this->StaffModel->GetStaffType();
      $data['GetJobType'] = $this->StaffModel->GetJobType();
      $data['GetDistrict'] = $this->FacilityModel->selectquery(); 
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/staff/staff-add');
      $this->load->view('admin/include/footer-new');
    }



  /* Staff Data Insert By This*/
public function AddstaffPost(){
        $data= $this->input->post();
        $facility_id = $this->input->post('facilityname');
        $result = $this->StaffModel ->AddstaffData($data);
        if ($result > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added Successfully.'));
            redirect('staffM/manageStaff/');
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('staffM/manageStaff/');
      }
    } 
  /* Update Staff Page Call*/
public function updateStaff(){
      $id = $this->uri->segment(3);
      $data['index']         = 'staff';
      $data['index2']        = '';
      $data['title']         = 'Staff Information | '.PROJECT_NAME; 
      // $facility_id = $this->uri->segment(3, 0); 
      // $data['facility_id']   = $facility_id;
      // $data['GetFacilities']  = $this->StaffModel->GetFacilities();
      $data['GetStaff']       = $this->StaffModel->GetStaffById($id);

      $facility = $data['GetStaff']['facilityId'];
      $facilityData = $this->LoungeModel->GetFacilitiName($facility);
      $data['GetFacilities']  = $this->LoungeModel->GetFacilityByDistrict($facilityData['PRIDistrictCode']); 
      $data['district_id']    = $facilityData['PRIDistrictCode'];

      $data['GetStaffType']   = $this->StaffModel->GetStaffType();
      $data['GetJobType']     = $this->StaffModel->GetJobType();
      $data['GetDistrict']    = $this->FacilityModel->selectquery(); 
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/staff/staff-edit');
      $this->load->view('admin/include/footer-new');
    }
    /* Update Staff Data By ID */
public function UpdateStaffPost(){
     $id = $this->uri->segment(3);
     $data= $this->input->post();
     // $facility_id = $this->uri->segment(3, 0); 
     $AddLounge = $this->StaffModel ->UpdateStaff($data,$id);
      if ($AddLounge > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
            redirect('staffM/manageStaff/');
      } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('staffM/manageStaff/');
      }
  }   

/* Add Staff Type Data By This */
public function StaffTypePost(){
        $data                              = $this->input->post();
        if (empty($data['type'])) {
         $fields                            = array();
         $fields['parentId']                = '0';
         $fields['staffTypeNameEnglish']    = $data['parent'];
         $fields['Add_Date']                = time();
         $insert = $this->db->insert('staffType',$fields);
        } else {
         $fields                            = array();
         $fields['parentId']                = $data['type'];
         $fields['staffTypeNameEnglish']    = $data['parent'];
         $fields['Add_Date']                = time();
         $insert = $this->db->insert('staffType',$fields);
        }
        if ($insert > 0) {
              $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
              redirect('staffM/staffType/');
        } else {
              $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
              redirect('staffM/staffType/');
      }
    }

   /* Update Staff Type Data  */
  public function UpdateStaffTypeData(){
        $id = $this->uri->segment(3);
        $table='staffType';
        $data                              = $this->input->post();
        $fields                            = array();
        $fields['staffTypeNameEnglish']    = $data['StaffTypeNameEnglish'];
        $fields['modify_date']             = time();
        $this->db->where('StaffTypeID',$id);
        $update = $this->db->update($table,$fields);

        if ($update > 0) {
              $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully'));
              redirect('staffM/staffType/');
          } else {
              $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
              redirect('staffM/staffType/');
          }
    } 
  /* Update Staff Type Data  */
  public function UpdateStaffTypeData2(){
        $id = $this->uri->segment(3);
        $table='staffType';
        $data                              = $this->input->post();
        $fields                            = array();
        $fields['parentId']                = $data['type'];
        $fields['staffTypeNameEnglish']    = $data['StaffTypeNameEnglish'];
        $fields['modify_date']             = time();
        $this->db->where('StaffTypeID',$id);
        $update = $this->db->update($table,$fields);

        if ($update > 0) {
              $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully'));
              redirect('staffM/staffType/');
        } else {
              $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
              redirect('staffM/staffType/');
          }
    } 
    
// for staff section
  public function pointHistoryViaNurse(){
      $id = $this->uri->segment(3);
      $data['index']         = 'staff';
      $data['index2']        = '';
      $data['title']         = 'PointHistory | '.PROJECT_NAME; 
      $data['StaffIDs']      = $id;
      $GetNurseDetail        = $this->UserModel->getStaffNameBYID($id);
      $data['fileName']      = $GetNurseDetail['Name'].'_Points_History';
      $data['GetNurseData'] = $this->db->query("SELECT * FROM pointstransactions WHERE NurseId = ".$id." ORDER BY AddDate DESC")->result_array();
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/staff/pointHistoryNurse');
      $this->load->view('admin/include/dataTable');
      $this->load->view('admin/include/footer');
    }  

//for lounge section
/*  public function pointHistoryViaLounge(){
      $id = $this->uri->segment(3);
      $data['index']         = 'lounge';
      $data['index2']        = '';
      $data['title']         = 'Lounge Point History | '.PROJECT_NAME; 
      $data['LoungeId']      = $id;
      $data['GetNurseData'] = $this->db->query("SELECT * FROM pointstransactions WHERE LoungeId = ".$id." ORDER BY AddDate DESC")->result_array();

      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/staff/pointHistoryLounge');
      $this->load->view('admin/include/footer');
    } */

/* for Collected Point via lounge */
public function pointHistoryViaLounge(){
  $loungeId = $this->uri->segment(3);
  $limit         = 100;
  $pageNo        = '1';
    if(empty($_GET['keyword'])) {
      $totalRecords = $this->SmsModel->getLoungePointsData('1',$loungeId); 
    } else if(!empty($_GET['keyword'])) {
      $totalRecords = $this->SmsModel->getLoungePointsDataWhereSearching('1',$loungeId,trim($_GET['keyword']));
    }
    // set url for seaching and without searching
    !empty($_GET['keyword']) ? $config["base_url"] = base_url('staffM/pointHistoryViaLounge/'.$loungeId.'?keyword='.$_GET['keyword']) : $config["base_url"] = base_url('staffM/pointHistoryViaLounge/'.$loungeId);
      $config["total_rows"]   = $totalRecords;
      $config["per_page"]     = $limit;
      $config['use_page_numbers']  = TRUE;
      $config['page_query_string'] = TRUE;
      $config['enable_query_strings'] = TRUE;
      $config['num_links'] = 2;
      $config['cur_tag_open'] = '&nbsp;<li class="active"><a>';
      $config['cur_tag_close'] = '</a></li>';
      $config['next_link'] = 'Next';
      $config['prev_link'] = 'Previous';
      $this->pagination->initialize($config);
      $str_links           = $this->pagination->create_links();
      $links               = explode('&nbsp;', $str_links);
      $offset              = 0;
      if (!empty($_GET['per_page'])) {
          $pageNo = $_GET['per_page'];
          $offset = ($pageNo - 1) * $limit;
      }
        if(empty($_GET['keyword'])) {
          $AllRecord = $this->SmsModel->getLoungePointsData('2',$loungeId,$limit,$offset); 
        }else if(!empty($_GET['keyword']))
        {
           $AllRecord = $this->SmsModel->getLoungePointsDataWhereSearching('2',$loungeId,trim($_GET['keyword']),$limit,$offset);
        } 

       $data = array(
                'totalResult' => $totalRecords,
                'results'     => $AllRecord,
                'links'       => $links,
                'index2'      => '',
                'v_id'        => '',
                'LoungeId'    => $loungeId,
                'pageNo'      => $pageNo,
                'index'       => 'lounge',
                'title'       => 'Lounge Points History | '.PROJECT_NAME
               );
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/staff/pointHistoryLounge');
      $this->load->view('admin/include/tableScript');  
      $this->load->view('admin/include/footer');
}



    
  public function manageTemplate(){
    $data['index']         = 'manageTemplate';
    $data['index2']        = '';
    $data['title']         = 'Manage template | '.PROJECT_NAME; 
    $data['Settings']      = $this->FacilityModel->GetDataInSettings();
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/staff/sms-template');
    $this->load->view('admin/include/footer-new');
  }

  public function SmsSettingData(){
    $table='settings';
    $data                     = $this->input->post();
    $fields                   = array();
    $fields['smsFormatThird'] = $data['smsFormatThird'];
    $fields['modifyDate']     = date('Y-m-d H:i:s');
    $this->db->where('id','1');
    $update = $this->db->update($table,$fields);

    if ($update > 0) {
      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated successfully'));
      redirect('staffM/manageTemplate/');
    } else {
      $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
      redirect('staffM/manageTemplate/');
    }
  }
    // send credentials to particular staff
  public function sendSMS(){
    $id   = $this->uri->segment(3);
    $facility_id   = $this->uri->segment(4);
    $password = "123456";
    $pass = md5($password);
    $getStaffData = $this->db->get_where('staffMaster',array('staffId'=>$id))->row_array();
    $this->db->where('staffId',$id);
    $update =  $this->db->update('staffMaster',array('staffPassword'=>$pass));
    if($update > 0){
        $message = "Hello ".$getStaffData['name'].", 
          Your KMC Application Login Credentials: 
          Username- ".$getStaffData['staffMobileNumber']."
          Password- ".$password." 
        Thanks 
        CEL Team";
      sendMobileMessage($getStaffData['staffMobileNumber'],$message);
        $insertSms = array(); 
        $insertSms['facilityId']  = $id; // staffID
        $insertSms['message']     = $message;
       
        $insertSms['sendTo']      = $getStaffData['staffMobileNumber'];
        $insertSms['time']        = date('H:i:00');
        $insertSms['userType']    = 1; // for staff
        $insertSms['date']        = date('Y-m-d');
        $insertSms['addDate']     = date('Y-m-d H:i:s');
        $this->db->insert('smsMaster',$insertSms);

        $this->session->set_flashdata('activate', getCustomAlert('S','Credentials has been send to the Mobile Number "'.$getStaffData['staffMobileNumber'].'".'));
            redirect('staffM/manageStaff/'.$facility_id);
    }else{
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('staffM/manageStaff/'.$facility_id);
    }
  }

    public function LoungeLoginHistory(){
      $id = $this->uri->segment('3');
      $data['index']               = 'staff';
      $data['index2']              = '';
      $data['fileName']            = 'Login History';
      $data['staff_id']            = $id;
      $data['title']               = 'Staff Login History | '.PROJECT_NAME; 
      $data['GetLoungeHistory']    = $this->db->query(" select * from loginMaster where loungeMasterId=".$id." and type='3' ORDER BY id DESC")->result_array();
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/include/dataTable',$data);
      $this->load->view('admin/staff/LoginHistory');
      $this->load->view('admin/include/footer');
    }


    public function manageDutyChangeModule(){
      $data['index']               = 'dutyChange';
      $data['index2']              = '';
      $data['fileName']            = 'DutyChangeHistory';
      $data['title']               = 'Duty Change History | '.PROJECT_NAME; 
      $data['getDutyHistory']    = $this->db->query("select * from nurseDutyChange where status='1' ORDER BY id DESC")->result_array();
      $this->load->view('admin/include/header',$data);
      $this->load->view('admin/include/dataTable',$data);
      $this->load->view('admin/staff/dutychange');
      $this->load->view('admin/include/footer');
    }


    public function viewStaffLog(){
      $id = $this->uri->segment('3');
      $data['index']               = 'staff';
      $data['index2']              = '';
      $data['fileName']            = 'Login History';
      $data['staff_id']            = $id;
      $data['title']               = 'Staff Log History | '.PROJECT_NAME; 
      $data['GetStaffData']    = $this->db->query(" select * from staffMaster where staffId=".$id)->row_array();
      $data['GetLogHistory']    = $this->StaffModel->getStaffLastUpdate($id, 2);
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/staff/staff-log-history');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new',$data);
    }


    public function temporaryStaff(){
      $data['index']         = 'temporaryStaff';
      $data['index2']        = '';
      $data['title']         = 'Not Approved Staff | '.PROJECT_NAME; 
      $data['fileName']      = ''; 
      $data['results']     = $this->StaffModel->GetTemporaryStaff();
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/staff/temporary-staff-list');
      $this->load->view('admin/include/footer-new');
      $this->load->view('admin/include/datatable-new');
    }


    public function editTemporaryStaff(){

    $id = $this->uri->segment(3);
    $data['index']         = 'temporaryStaff';
    $data['index2']        = '';
    $data['title']         = 'Not Approved Staff Information | '.PROJECT_NAME; 
    // $facility_id = $this->uri->segment(3, 0); 
    // $data['facility_id']   = $facility_id;
    
    $data['GetStaff'] = $this->StaffModel->GetTempStaffById($id);
    $facility = $data['GetStaff']['facilityId'];
    $facilityData = $this->LoungeModel->GetFacilitiName($facility);
    $data['GetFacilities']  = $this->LoungeModel->GetFacilityByDistrict($facilityData['PRIDistrictCode']); 
    $data['district_id']    = $facilityData['PRIDistrictCode'];

    $data['GetStaffType']   = $this->StaffModel->GetStaffType();
    $data['GetJobType']     = $this->StaffModel->GetJobType();
    $data['GetDistrict']    = $this->FacilityModel->selectquery(); 

    $staffData = $data['GetStaff'];
    $tempFacility = $data['GetFacilities'];
    if($this->input->post()){ 
      $verification_status = $this->input->post('verification_status');
      $reason = $this->input->post('reason');

      if($verification_status == 2) {

        $insertData = array('facilityId'  => $staffData['facilityId'],
                            'name'        => $staffData['name'],
                            'staffType'   => $staffData['staffType'],
                            'staffSubType'  => $staffData['staffSubType'],
                            'staffSubTypeOther'  => $staffData['staffSubTypeOther'],
                            'staffMobileNumber'       => $staffData['staffMobileNumber'],
                            'emergencyContactNumber'  => $staffData['emergencyContactNumber'],
                            'profilePicture'  => $staffData['profilePicture'],
                            'jobType'         => $staffData['jobType'],
                            'staffAddress'    => $staffData['staffAddress'],
                            'verifiedMobile'    => $staffData['verifiedMobile'],
                            'status'  => 1,
                            'addDate'           => date('Y-m-d H:i:s'),
                            'modifyDate'        => date('Y-m-d H:i:s')

                           );
        $staffMasterId = $this->LoungeModel->insertData('staffMaster', $insertData);

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address(); 
        $loginType = $this->session->userdata('adminData')['Type'];

        $logData = array(   'staffId'     => $staffMasterId,
                            'facilityId'  => $staffData['facilityId'],
                            'name'        => $staffData['name'],
                            'staffType'   => $staffData['staffType'],
                            'staffSubType'  => $staffData['staffSubType'],
                            'staffSubTypeOther'  => $staffData['staffSubTypeOther'],
                            'staffMobileNumber'       => $staffData['staffMobileNumber'],
                            'emergencyContactNumber'  => $staffData['emergencyContactNumber'],
                            'profilePicture'  => $staffData['profilePicture'],
                            'jobType'       => $staffData['jobType'],
                            'staffAddress'   => $staffData['staffAddress'],
                            
                            'status'  => 1,
                            'addDate'           => date('Y-m-d H:i:s'),
                            'addedBy'           => $loginId,
                            'addedByType'       => $loginType,
                            'ipAddress'         => $ip

                           );
        $this->LoungeModel->insertData('staffMasterLog', $logData);

        $sms_message = 'All the Staff Information Provided by you are upto the mark and approved by the team, the data has been saved sucessfully.';
      }

      if($verification_status == 3) {
        $sms_message = 'All the Staff Information Provided by you are not correct and Rejected by the team. Kindly recheck the data and submit the form again.';
      }

      sendMobileMessage($staffData['staffMobileNumber'],$sms_message);

      $updateData =array(
                        'status'    => $verification_status,
                        'reason'          => $reason,
                        'modifyDate'      => date('Y-m-d H:i:s')
                    );
      $res1 = $this->LoungeModel->updateData('temporaryStaffMaster', $updateData, array('staffId' => $staffData['staffId']));
      if ($res1 > 0) {
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
        redirect('staffM/temporaryStaff');
      } else {
        $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
        redirect('staffM/temporaryStaff');
      }
    }

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/staff/update-temporary-staff');
    $this->load->view('admin/include/footer-new');
  }


}

    