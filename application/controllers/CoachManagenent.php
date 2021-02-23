<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class CoachManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('CoachModel');  
    $this->load->model('LoungeModel'); 
    $this->load->model('FacilityModel'); 
    $this->is_not_logged_in();
    $this->restrictPageAccess(array('14'));  
  }

  /* Staff Listing page call */
  public function coachList(){
    $data['index']         = 'coachM';
    $data['index2']        = 'Manage Coaches';
    $data['title']         = 'Coaches | '.PROJECT_NAME; 
    $data['fileName']      = 'coachList'; 
    $data['results']     = $this->CoachModel->GetCoaches();
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/coach/coach-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function viewEmployeeLog(){
    $id = $this->uri->segment(3);
    $data['index']         = 'employee';
    $data['index2']        = 'Manage Employee';
    $data['title']         = 'CEL Employee Log | '.PROJECT_NAME; 
    $data['fileName']      = 'employeeList'; 
    $data['results']     = $this->EmployeeModel->GetEmployeeLog($id);
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/employee/employee-log-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function addCoach(){
      $data['index']          = 'coachM';
      $data['index2']         = '';
      $data['title']          = 'Add Coach | '.PROJECT_NAME; 
      $data['fileName']       = 'coachList'; 
      $data['GetDistrict']   = $this->FacilityModel->selectquery(); 
      $data['menuGroup']    = $this->CoachModel->GetDataOrderByAsc('manageMenuGroupSetting', array('status' => 1), 'groupName');

      if($this->input->post()){ 
        $coach_name             = $this->input->post('coach_name');
        $coach_mobile_number    = $this->input->post('coach_mobile_number');
        $password               = $this->input->post('password');
        $lounge                 = $this->input->post('lounge');
        $menu_group             = $this->input->post('menu_group');

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address();
        $type = $this->session->userdata('adminData')['Type'];

        $insertData   = array('name'          => ucwords($coach_name),
                              'mobile'        => $coach_mobile_number,
                              'password'      => md5($password),
                              'addedBy'       => $loginId,
                              'addedByType'   => $type,
                              'ipAddress'     => $ip,
                              'status'        => 1,
                              'addDate'       => date('Y-m-d H:i:s'),
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );

        $id = $this->CoachModel->insertData('coachMaster', $insertData);

        foreach ($lounge as $key => $value) {
          $explode = explode("-",$value); 
          $district = $explode[0];
          $facility = $explode[1];
          $lounge   = $explode[2];

          $insertData2   = array('masterId'   => $id,
                              'districtId'    => $district,
                              'facilityId'    => $facility,
                              'loungeId'      => $lounge,
                              'status'        => 1,
                              'addDate'       => date('Y-m-d H:i:s'),
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );
          $this->CoachModel->insertData('coachDistrictFacilityLounge', $insertData2);
        }

        // insert menu group
        foreach ($menu_group as $key => $group_value) {
          $insertMenuData   = array( 
                                  'employeeId'    => $id,
                                  'userType'      => 2,
                                  'groupId'       => $group_value,
                                  'status'        => 1,
                                  'addDate'       => date('Y-m-d H:i:s'),
                                  'modifyDate'    => date('Y-m-d H:i:s')
                             );
          $this->CoachModel->insertData('employeeMenuGroup', $insertMenuData);
        }


        if ($id > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added Successfully.'));
            redirect('coachM/coachList');
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('coachM/coachList');
        }

      }
      
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/coach/coach-add');
      $this->load->view('admin/include/footer-new');
  }


  public function getFacility(){
    if($this->input->post()){
      $district = $this->input->post('districtId'); 
      $facility = $this->input->post('facility');

      $html = ''; 

      foreach ($district as $key => $value) {
        $getFacility = $this->LoungeModel->GetFacilityByDistrict($value); 
        
        $getDistrict = $this->FacilityModel->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs', $value); 
        
        if(!empty($getFacility)){
          $html.='<optgroup label="'.$getDistrict['DistrictNameProperCase'].'">';
          foreach ($getFacility as $key2 => $value2) {
            $Select = ($facility==$value2['FacilityID'])?'SELECTED':'' ;
            $html.='<option value="'.$value.'-'.$value2['FacilityID'].'" '.$Select.'>'.$value2['FacilityName'].'</option>';
          }
        }
      }

      echo $html;die;
    }
  }


  public function getLounge(){
    if($this->input->post()){
      
      $facility = $this->input->post('facility');
      
      $html = ''; 

      foreach ($facility as $key => $value) {
        $facilityExp = explode("-",$value);
        $facilityIds = $facilityExp[1];
        $getFacility = $this->FacilityModel->GetFacilitiesById('facilitylist', $facilityIds); 
        
        $getLounge = $this->LoungeModel->GetLoungeByFAcility($facilityIds); 
        
        if(!empty($getLounge)){
          $html.='<optgroup label="'.$getFacility['FacilityName'].'">';
          foreach ($getLounge as $key2 => $value2) {
            
            $html.='<option value="'.$value.'-'.$value2['loungeId'].'">'.$value2['loungeName'].'</option>';
          }
        }
      }

      echo $html;die;
    }
  }




  /* Update Staff Page Call*/
  public function updateCoach(){
      $id = $this->uri->segment(3);
      $data['index']          = 'coachM';
      $data['index2']         = '';
      $data['title']          = 'Edit Coach | '.PROJECT_NAME;
      $data['GetDistrict']   = $this->FacilityModel->selectquery(); 
      $data['GetCoachData'] = $this->CoachModel->GetDataById('coachMaster', array('id' => $id));
      
      $data['menuGroup'] = $this->CoachModel->GetDataOrderByAsc('manageMenuGroupSetting', array('status' => 1), 'groupName');
      $GetEmployeeMenuGroup = $this->CoachModel->GetData('employeeMenuGroup', array('employeeId' => $id, 'userType'=>2, 'status' => 1));
      
      $key_arr = array();
      $data['key_arr'] = $key_arr;
      foreach ($GetEmployeeMenuGroup as $key => $value) {
        $data['key_arr'][] = $value['groupId'];
      }

      $GetGroup = $this->CoachModel->GetData('coachDistrictFacilityLounge', array('masterId' => $id, 'status' => 1));
      $key_arr = array();
      $data['dis_arr'] = $key_arr;
      $data['fac_arr'] = $key_arr;
      $data['lounge_arr'] = $key_arr;
      foreach ($GetGroup as $key => $value) {
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
       if($this->input->post()){ 
        $id = $this->uri->segment(3);
        $coach_name           = $this->input->post('coach_name');
        $coach_mobile_number  = $this->input->post('coach_mobile_number');
        $password             = $this->input->post('password');
        $lounge               = $this->input->post('lounge');
        $status               = $this->input->post('status');
        $menu_group           = $this->input->post('menu_group');

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address();
        $type = $this->session->userdata('adminData')['Type'];

        if(!empty($password)){
          $insertData   = array('name'          => ucwords($coach_name),
                              'mobile'        => $coach_mobile_number,
                              'password'      => md5($password),
                              'status'        => $status,
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );
        } else {
          $insertData   = array('name'          => ucwords($coach_name),
                              'mobile'        => $coach_mobile_number,
                              'status'        => $status,
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );
        }

        $this->CoachModel->updateData('coachMaster', $insertData, array('id' => $id));

        $this ->db->where('masterId', $id);
        $this ->db->delete('coachDistrictFacilityLounge');

        foreach ($lounge as $key => $value) {
          $explode = explode("-",$value); 
          $district = $explode[0];
          $facility = $explode[1];
          $lounge   = $explode[2];

          $insertData2   = array('masterId'   => $id,
                              'districtId'    => $district,
                              'facilityId'    => $facility,
                              'loungeId'      => $lounge,
                              'status'        => 1,
                              'addDate'       => date('Y-m-d H:i:s'),
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );
          $this->CoachModel->insertData('coachDistrictFacilityLounge', $insertData2);
        }

        // insert menu group
        $this ->db->where(array('employeeId'=>$id,'userType'=>2));
        $this ->db->delete('employeeMenuGroup');
        foreach ($menu_group as $key => $value) {
          $insertMenuData   = array( 
                                  'employeeId'    => $id,
                                  'userType'      => 2,
                                  'groupId'       => $value,
                                  'status'        => 1,
                                  'addDate'       => date('Y-m-d H:i:s'),
                                  'modifyDate'    => date('Y-m-d H:i:s')
                             );
          $this->CoachModel->insertData('employeeMenuGroup', $insertMenuData);
        }

        if ($id > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated Successfully.'));
            redirect('coachM/coachList');
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('coachM/coachList');
        }

      }
      
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/coach/coach-edit');
      $this->load->view('admin/include/footer-new');
  }
  
  public function checkCoachMobile(){ 
    if(isset($_REQUEST['mobile']))
    {
      $mobile = $_REQUEST['mobile']; 
      $table = $_REQUEST['table_name']; 
      $column = $_REQUEST['column_name']; 
      $id = $_REQUEST['id']; 
      $id_column = $_REQUEST['id_column'];
      $data = $this->CoachModel->checkLogInColumn($mobile, $table, $column, $id, $id_column); 

      if($data[$column]==$mobile){
        echo 1;  
      }
    }
  }

}

    