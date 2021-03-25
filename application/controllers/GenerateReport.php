<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class GenerateReport extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('ReportSettingModel');  
    $this->load->model('FacilityModel'); 
    $this->load->model('UserModel'); 
    $this->load->model('SmsModel'); 
    $this->load->model('LoungeModel');  
    $this->load->library('pagination'); 
    $this->is_not_logged_in(); 
    $this->restrictPageAccess(array('46'));
  }

  /* Report Setting Listing page call */
  public function manageGeneralReport(){
    $facility_id = 'all';
    
    $limit         = DATA_PER_PAGE;
    $pageNo        = '1';
    $GetFacilities  = array();
    

    if($this->input->get()) { 
      if(empty($_GET['keyword']) && empty($_GET['category'])) { 
        $totalRecords = $this->ReportSettingModel->getReportSettingData('1', '', ''); 
      } else if(!empty($_GET['keyword']) && empty($_GET['category']) ) { 
        $totalRecords = $this->ReportSettingModel->getReportSettingDataWhereSearching('1',trim($_GET['keyword']));
      } else if(empty($_GET['keyword']) && !empty($_GET['category'])) { 
        $totalRecords = $this->ReportSettingModel->getReportSettingDataWhereCategory('1',trim($_GET['category']));
      } else if(!empty($_GET['keyword']) && !empty($_GET['category'])) { 
        $totalRecords = $this->ReportSettingModel->getReportSettingWhereFacilitySearch('1',trim($_GET['keyword']),trim($_GET['category']));
      } 
    } else { 
      $totalRecords = $this->ReportSettingModel->getReportSettingData('1', '', ''); 
    }  
     
      // set url for seaching and without searching
      !empty($_GET['keyword']) ? $config["base_url"] = base_url('GenerateReportM/manageGeneralReport/'.$facility_id.'?keyword=' . $_GET['keyword']) : $config["base_url"] = base_url('GenerateReportM/manageGeneralReport/'.$facility_id);
      
        if(!empty($totalRecords)){ 
          $config["total_rows"] = count($totalRecords);
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
            if(empty($_GET['keyword']) && empty($_GET['category'])) { 
              $AllRecord = $this->ReportSettingModel->getReportSettingData('2',$limit,$offset, $facility_id); 
            } else if(!empty($_GET['keyword']) && empty($_GET['category']))
            { 
              $AllRecord = $this->ReportSettingModel->getReportSettingDataWhereSearching('2',trim($_GET['keyword']),$limit,$offset);
            } else if(empty($_GET['keyword']) && !empty($_GET['category']))
            { 
              $AllRecord = $this->ReportSettingModel->getReportSettingDataWhereCategory('2',trim($_GET['category']),$limit,$offset);
            } else if(!empty($_GET['keyword']) && !empty($_GET['category']))
            { 
              $AllRecord = $this->ReportSettingModel->getReportSettingWhereFacilitySearch('2',trim($_GET['keyword']),trim($_GET['category']),$limit,$offset);
            } 
          } else {
            $AllRecord = $this->ReportSettingModel->getReportSettingData('2',$limit,$offset, $facility_id); 
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
        $reportCategory = $this->ReportSettingModel->reportCategory();
        $totalActivLounge = $this->ReportSettingModel->GettotalLaunchLounge();
        $data = array(
                  'totalResult'   => $totalRecords,
                  'results'       => $AllRecord,
                  'links'         => $links,
                  'index2'        => '',
                  'v_id'          => '',
                  'pageNo'        => $pageNo,
                  'index'         => 'ReportSetting',
                  'fileName'      => 'ReportSettingList',
                  'GetFacility'   => $GetFacility,
                  'GetDistrict'   => $GetDistrict,
                  'facilityList'  => $GetFacilities,
                  'facility_id'   => $facility_id,
                  'reportCategory'   => $reportCategory,
                  'totalActivLounge'   => $totalActivLounge,
                  'title'         => 'Generate Report | '.PROJECT_NAME
                 );
        $this->load->view('admin/include/header-new',$data);
        $this->load->view('admin/report/reportSetting_list');
        $this->load->view('admin/include/footer-new');
        $this->load->view('admin/include/datatable-new');
  }


    public function addGenerateReportM(){
      $data['index']         = 'Generate Report';
      $data['index2']        = '';
      $data['title']         = 'Add Generate Report | '.PROJECT_NAME; 
      // $facility_id = $this->uri->segment(3, 0); 
      // $data['facility_id']   = $facility_id;
      $data['GetFacilities'] = $this->ReportSettingModel->GetFacilities();
      //print_r($data['GetFacilities']); die;
      $data['GetStaffType']  = $this->ReportSettingModel->GetStaffType();
      $data['GetJobType'] = $this->ReportSettingModel->GetJobType();
      $data['GetDistrict'] = $this->FacilityModel->selectquery();
      $data['reportCategory'] = $this->ReportSettingModel->reportCategory(); 
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/report/reportSetting_add');
      $this->load->view('admin/include/footer-new');
    }

    // get lounges by facilities
    public function getFacilityMultipleLounge(){
      if($this->input->post()){
      
        $facility = $this->input->post('facility');
        $district = $this->input->post('district');
        $id = $this->input->post('id');

        $lounge_arr = array();
        if(!empty($id)){
          $facilitydata = $this->ReportSettingModel->GetFacilityByReportId($id);
          foreach ($facilitydata as $key => $value) {
            if(!in_array($value['loungeId'], $lounge_arr)){
              $lounge_arr[] = $value['loungeId'];
            }
          }
        }
        
        $html = ''; 
        $selected = "";

        foreach ($facility as $key => $value) {
          $facilityIds = $value;
          $getFacility = $this->FacilityModel->GetFacilitiesById('facilitylist', $facilityIds); 
          
          $getLounge = $this->LoungeModel->GetLoungeByFAcility($facilityIds); 
          
          if(!empty($getLounge)){
            $html.='<optgroup label="'.$getFacility['FacilityName'].'">';
            foreach ($getLounge as $key2 => $value2) {
              if(in_array($value2['loungeId'], $lounge_arr)){
                $selected = "selected";
              }else{
                $selected = "";
              }
              $html.='<option value="'.$district.'-'.$facilityIds.'-'.$value2['loungeId'].'" '.$selected.'>'.$value2['loungeName'].'</option>';
            }
          }
        }

        echo $html;die;
      }
    }



  /* Staff Data Insert By This*/
  public function AddGenerateReportPost(){
      $data= $this->input->post();
      if(empty($data['subscription']))
      {
        $data['subscription'] ="No";
      }

      $result = $this->ReportSettingModel->AddReportData($data);
      if ($result > 0) {
          $this->session->set_flashdata('activate', getCustomAlert('S','Data has been added successfully.'));
          redirect('GenerateReportM/manageGeneralReport/');
      } else {
          $this->session->set_flashdata('activate', getCustomAlert('W','Oops! something is wrong please try again.'));
          redirect('GenerateReportM/manageGeneralReport/');
    }
  } 
  /* Update Staff Page Call*/
    public function updateReport(){
      $id = $this->uri->segment(3);
      $data['index']         = 'Report';
      $data['index2']        = '';
      $data['title']         = 'Report Information | '.PROJECT_NAME; 
      // $facility_id = $this->uri->segment(3, 0); 
      // $data['facility_id']   = $facility_id;
      // $data['GetFacilities']  = $this->StaffModel->GetFacilities();
      $data['GetReport']       = $this->ReportSettingModel->GetReportById($id);

      $facilitydata = $this->ReportSettingModel->GetFacilityByReportId($id);
      // $facilitys   =       array();
      // foreach ($facilitydata as $key => $value) {
      //   $facilitys[] = $value['facilityId'];
      // }

      $key_arr = array();
      $data['dis_arr'] = $key_arr;
      $data['fac_arr'] = $key_arr;
      $data['lounge_arr'] = $key_arr;
      foreach ($facilitydata as $key => $value) {
        if(!in_array($value['districtId'], $data['dis_arr'])){
          $data['dis_arr'][] = $value['districtId'];
        }

        if(!in_array($value['facilityId'], $data['fac_arr'])){
          $data['fac_arr'][] = $value['facilityId'];
        }

        if(!in_array($value['loungeId'], $data['lounge_arr'])){
          $data['lounge_arr'][] = $value['loungeId'];
        }
      } 
      
      $emaildata = $this->ReportSettingModel->GetEmailByReportId($id);
      $emails   =       array();
      foreach ($emaildata as $key => $values) {
        $emails[] = $values['email'];
      }
      //print_r($emails); die;
      $data['emails']   = $emails;
      //$data['facilitys']   = $facilitys;
      
      $data['GetStaffType']   = $this->ReportSettingModel->GetStaffType();
      $data['GetJobType']     = $this->ReportSettingModel->GetJobType();
      $data['GetDistrict']    = $this->ReportSettingModel->getDistrict(); 
      $data['GetFacilities'] = $this->ReportSettingModel->GetFacilities();
      $data['reportid'] = $id;
      $data['reportCategory'] = $this->ReportSettingModel->reportCategory(); 
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/report/reportSetting_edit');
      $this->load->view('admin/include/footer-new');
    }
    /* Update Staff Data By ID */
public function UpdateReportPost(){
     $id = $this->uri->segment(3);
     $data= $this->input->post();
     if(empty($data['subscription']))
      {
        $data['subscription'] ="No";
      }
     // $facility_id = $this->uri->segment(3, 0); 
     $AddLounge = $this->ReportSettingModel->UpdateReport($data,$id);
      if ($AddLounge > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
            redirect('GenerateReportM/manageGeneralReport/');
      } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('GenerateReportM/manageGeneralReport/');
      }
  }   


/* Daily Report Download Listing page call */
  public function dailyDownloadReport(){
     $reportSettingId = $this->uri->segment(3); 
//echo $reportSettingId; die;
    $facility_id = 'all';
    
    $limit         = DATA_PER_PAGE;
    $pageNo        = '1';
    $GetFacilities  = array();
    

    if($this->input->get()) { 
      if(empty($_GET['keyword'])) { 
        $totalRecords = $this->ReportSettingModel->getReportDownloadData('1', '', '',$reportSettingId);  
      } else if(!empty($_GET['keyword'])) { 
        $totalRecords = $this->StaffModel->getreportDataWhereSearching('1',trim($_GET['keyword']),$reportSettingId);
      } 
    } else { 
      $totalRecords = $this->ReportSettingModel->getReportDownloadData('1', '', '',$reportSettingId); 
    }  
     
      // set url for seaching and without searching
      !empty($_GET['keyword']) ? $config["base_url"] = base_url('GenerateReportM/dailyDownloadReport/?keyword=' . $_GET['keyword']) : $config["base_url"] = base_url('GenerateReportM/dailyDownloadReport/');
      
        if(!empty($totalRecords)){ 
          $config["total_rows"] = count($totalRecords);
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
            if(empty($_GET['keyword'])) { 
              $AllRecord = $this->StaffModel->getReportDownloadData('2',$limit,$offset, 1); 
            } else if(!empty($_GET['keyword']))
            { 
              $AllRecord = $this->StaffModel->getreportDataWhereSearching('2',trim($_GET['keyword']),$limit,$offset,$reportSettingId);
            }
          } else {
            $AllRecord = $this->ReportSettingModel->getReportDownloadData('2',$limit,$offset, $reportSettingId); 
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
                  'index'         => 'ReportSetting',
                  'fileName'      => 'ReportSettingList',
                  'GetFacility'   => $GetFacility,
                  'GetDistrict'   => $GetDistrict,
                  'facilityList'  => $GetFacilities,
                  'facility_id'   => $facility_id,
                  'title'         => 'Generate Report | '.PROJECT_NAME
                 );
        $this->load->view('admin/include/header-new',$data);
        $this->load->view('admin/report/dailyReport_list');
        $this->load->view('admin/include/footer-new');
        $this->load->view('admin/include/datatable-new');
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
    $data['title']         = 'Update Temporary Staff | '.PROJECT_NAME; 
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

    