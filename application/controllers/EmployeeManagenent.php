<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class EmployeeManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('EmployeeModel');  
    $this->load->model('FacilityModel'); 
    $this->load->model('LoungeModel');  
    $this->is_not_logged_in(); 
    $this->restrictPageAccess(array('20'));
  }

  /* Staff Listing page call */
  public function manageEmployee(){
    $data['index']         = 'employee';
    $data['index2']        = 'Manage Employee';
    $data['title']         = 'CEL Employees | '.PROJECT_NAME; 
    $data['fileName']      = 'employeeList'; 
    $data['results']     = $this->EmployeeModel->GetEmployees();
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/employee/employee-list');
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


  public function addEmployee(){
      $data['index']          = 'employee';
      $data['index2']         = '';
      $data['title']          = 'Add CEL Employee | '.PROJECT_NAME; 
      $data['fileName']      = 'employeeList'; 
      $data['menuGroup'] = $this->EmployeeModel->GetDataOrderByAsc('manageMenuGroupSetting', array('status' => 1), 'groupName');

      if($this->input->post()){ 
        $employee_name        = $this->input->post('employee_name');
        //$employee_mobile_number        = $this->input->post('employee_mobile_number');
        $employee_email       = $this->input->post('employee_email');
        $password             = $this->input->post('password');
        $employee_code        = $this->input->post('employee_code');
        $menu_group           = $this->input->post('menu_group');
        

        if($_FILES['image']['name']){
          $fileName   = $_FILES['image']['name'];
          $extension  = explode('.',$fileName);
          $extension  = strtolower(end($extension));
          $uniqueName = time().'.'.$extension;
          $tmp_name   = $_FILES['image']['tmp_name'];
          $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/employee/".$uniqueName; 
          $InsertImg = utf8_encode(trim($uniqueName));
          move_uploaded_file($tmp_name,$targetlocation);
        } else {
          $InsertImg = NULL;
        }


        $insertData   = array('name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              'contactNumber' => "",
                              'employeeCode'  => $employee_code,
                              'profileImage'  => $InsertImg,
                              'password'      => base64_encode($password),
                              'status'        => 1,
                              'addDate'       => date('Y-m-d H:i:s'),
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address();

        $id = $this->EmployeeModel->insertData('employeesData', $insertData);

        foreach ($menu_group as $key => $value) {
          $insertData2   = array( 'employeeId'    => $id,
                                  'userType'      => 4,
                                  'groupId'       => $value,
                                  'status'        => 1,
                                  'addDate'       => date('Y-m-d H:i:s'),
                                  'modifyDate'    => date('Y-m-d H:i:s')
                             );
          $this->EmployeeModel->insertData('employeeMenuGroup', $insertData2);
        }

        $strMenu = implode (", ", $menu_group);

        $logData      = array('employeeId'    => $id,
                              'name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              //'contactNumber' => $employee_mobile_number,
                              'profileImage'  => $InsertImg,
                              'employeeCode'  => $employee_code,
                              'menuGroup'     => $strMenu,
                              'password'      => base64_encode($password),
                              'status'        => 1,
                              'addDate'       => date('Y-m-d H:i:s'),
                              'addedBy'       => $loginId,
                              'ipAddress'     => $ip
                              
                             );

        $this->EmployeeModel->insertData('employeesDataLog', $logData);

        // save facility lounge
        $lounge = $this->input->post('lounge');
        if(!empty($lounge)){
          foreach($lounge as $loungevalue)
          {
            $explode = explode("-",$loungevalue); 
            $district = $explode[0];
            $facility = $explode[1];
            $lounge   = $explode[2];

            $loungeArray                    = array();
            $loungeArray['masterId']        = $id;
            $loungeArray['districtId']      = $district;
            $loungeArray['facilityId']      = $facility;
            $loungeArray['loungeId']        = $lounge;
            $loungeArray['status']          = 1;
            $loungeArray['addDate']         = date('Y-m-d H:i:s');
            $loungeArray['modifyDate']      = date('Y-m-d H:i:s');
            $this->db->insert('employeeDistrictFacilityLounge',$loungeArray);
          }
        }

        if ($id > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added Successfully.'));
            redirect('employeeM/manageEmployee');
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! something is wrong please try again.'));
            redirect('employeeM/manageEmployee');
        }

      }
      
      $data['GetDistrict'] = $this->FacilityModel->selectquery();

      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/employee/employee-add');
      $this->load->view('admin/include/footer-new');
  }


  /*  check If LogIn Mobile Number already exists in various tables
      called on : AddFacility page for AdministrativeMoblieNo column
                : AddLounge page for loungeContactNumber column
  */
  public function checkLogInMobile(){ 
    if(isset($_REQUEST['mobile_number']))
    {
      $mobile = $_REQUEST['mobile_number']; 
      $table = $_REQUEST['table_name']; 
      $column = $_REQUEST['column_name']; 
      $id = $_REQUEST['id']; 
      $id_column = $_REQUEST['id_column'];
      $data = $this->EmployeeModel->checkLogInColumn($mobile, $table, $column, $id, $id_column); 

      if($data[$column]==$mobile){
        echo 1;  
      }
    }
  }


  public function checkLogInEmail(){ 
    if(isset($_REQUEST['email']))
    {
      $mobile = $_REQUEST['email']; 
      $table = $_REQUEST['table_name']; 
      $column = $_REQUEST['column_name']; 
      $id = $_REQUEST['id']; 
      $id_column = $_REQUEST['id_column'];
      $data = $this->EmployeeModel->checkLogInColumn($mobile, $table, $column, $id, $id_column); 

      if($data[$column]==$mobile){
        echo 1;  
      }
    }
  }


  public function checkEmpCode(){ 
    if(isset($_REQUEST['code']))
    {
      $employee_code = $_REQUEST['code']; 
      $table = $_REQUEST['table_name']; 
      $column = $_REQUEST['column_name']; 
      $id = $_REQUEST['id']; 
      $id_column = $_REQUEST['id_column'];
      $data = $this->EmployeeModel->checkLogInColumn($employee_code, $table, $column, $id, $id_column); 
      
      if($data[$column]==$employee_code){
        echo 1;  
      }
    }
  }


  /* Update Staff Page Call*/
  public function updateEmployee(){
      $id = $this->uri->segment(3);
      $data['index']          = 'employee';
      $data['index2']         = '';
      $data['title']          = 'Edit CEL Employee | '.PROJECT_NAME;
      $data['GetEmployeeData'] = $this->EmployeeModel->GetDataById('employeesData', array('id' => $id));
      $data['menuGroup'] = $this->EmployeeModel->GetDataOrderByAsc('manageMenuGroupSetting', array('status' => 1), 'groupName');
      $GetEmployeeMenuGroup = $this->EmployeeModel->GetData('employeeMenuGroup', array('employeeId' => $id, 'userType'=>4, 'status' => 1));
      $key_arr = array();
      $data['key_arr'] = $key_arr;
      foreach ($GetEmployeeMenuGroup as $key => $value) {
        $data['key_arr'][] = $value['groupId'];
      }
      if($this->input->post()){
        $employee_name        = $this->input->post('employee_name');
        //$employee_mobile_number        = $this->input->post('employee_mobile_number');
        $employee_email       = $this->input->post('employee_email');
        $password             = $this->input->post('password');
        $employee_code        = $this->input->post('employee_code');
        $menu_group           = $this->input->post('menu_group');
        $status               = $this->input->post('status');

        if($_FILES['image']['name']){
          $fileName   = $_FILES['image']['name'];
          $extension  = explode('.',$fileName);
          $extension  = strtolower(end($extension));
          $uniqueName = time().'.'.$extension;
          $tmp_name   = $_FILES['image']['tmp_name'];
          $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/employee/".$uniqueName; 
          $InsertImg = utf8_encode(trim($uniqueName));
          move_uploaded_file($tmp_name,$targetlocation);
        } else {
          $InsertImg = $this->input->post('prevFile');
        }

        if(!empty($password)){

          $updateData   = array('name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              //'contactNumber' => $employee_mobile_number,
                              'profileImage'  => $InsertImg,
                              'employeeCode'  => $employee_code,
                              'password'      => base64_encode($password),
                              'status'        => $status,
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );

        } else {
          $updateData   = array('name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              //'contactNumber' => $employee_mobile_number,
                              'profileImage'  => $InsertImg,
                              'employeeCode'  => $employee_code,
                              'status'        => $status,
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );
        }

        $res = $this->EmployeeModel->updateData('employeesData', $updateData, array('id' => $id));
        $this->EmployeeModel->deleteData('employeeMenuGroup', array('employeeId' => $id,'userType'=>4));
        foreach ($menu_group as $key => $value) {
          $insertData2   = array( 'employeeId'    => $id,
                                  'groupId'       => $value,
                                  'userType'      => 4,
                                  'status'        => 1,
                                  'addDate'       => date('Y-m-d H:i:s'),
                                  'modifyDate'    => date('Y-m-d H:i:s')
                             );
          $this->EmployeeModel->insertData('employeeMenuGroup', $insertData2);
        }


        $this->db->where('masterId', $id);
        $this->db->delete('employeeDistrictFacilityLounge');
        // save facility lounge
        $lounge = $this->input->post('lounge');
        if(!empty($lounge)){
          foreach($lounge as $loungevalue)
          {
            $explode = explode("-",$loungevalue); 
            $district = $explode[0];
            $facility = $explode[1];
            $lounge   = $explode[2];

            $loungeArray                    = array();
            $loungeArray['masterId']        = $id;
            $loungeArray['districtId']      = $district;
            $loungeArray['facilityId']      = $facility;
            $loungeArray['loungeId']        = $lounge;
            $loungeArray['status']          = 1;
            $loungeArray['addDate']         = date('Y-m-d H:i:s');
            $loungeArray['modifyDate']      = date('Y-m-d H:i:s');
            $this->db->insert('employeeDistrictFacilityLounge',$loungeArray);
          }
        }

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address();

        $strMenu = implode (", ", $menu_group);

        if(!empty($password)){

          $logData      = array('employeeId'    => $id,
                              'name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              //'contactNumber' => $employee_mobile_number,
                              'profileImage'  => $InsertImg,
                              'employeeCode'  => $employee_code,
                              'menuGroup'     => $strMenu,
                              'password'      => base64_encode($password),
                              'status'        => $status,
                              'addDate'       => date('Y-m-d H:i:s'),
                              'addedBy'       => $loginId,
                              'ipAddress'     => $ip
                              
                             );
        } else {
          $logData      = array('employeeId'    => $id,
                              'name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              //'contactNumber' => $employee_mobile_number,
                              'profileImage'  => $InsertImg,
                              'employeeCode'  => $employee_code,
                              'menuGroup'     => $strMenu,
                              'status'        => $status,
                              'addDate'       => date('Y-m-d H:i:s'),
                              'addedBy'       => $loginId,
                              'ipAddress'     => $ip
                              
                             );
        }

        $this->EmployeeModel->insertData('employeesDataLog', $logData);

        if ($res > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Updated Successfully.'));
            redirect('employeeM/manageEmployee');
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('employeeM/manageEmployee');
        }

      }

      $facilitydata = $this->EmployeeModel->GetFacilityByEmployeeId($id);
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

      $data['GetDistrict']    = $this->EmployeeModel->getDistrict(); 
      $data['GetFacilities'] = $this->EmployeeModel->GetFacilities();
      $data['employeeid'] = $id;
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/employee/employee-edit');
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
        $facilitydata = $this->EmployeeModel->GetFacilityByEmployeeId($id);
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

  public function validateCelEmpEmail(){
    $email = $this->input->post('email');
    $id = $this->input->post('id');

    $checkEmail = $this->db->query('select email from adminMaster where email="'.$email.'"')->row_array();
    if(empty($checkEmail)){
      $checkEmail = $this->db->query('select email from employeesData where email="'.$email.'" and id != "'.$id.'"')->row_array();
    }
    
    if(!empty($checkEmail)){
      echo "0";
    }else{
      echo "1";
    }
  }

}

    