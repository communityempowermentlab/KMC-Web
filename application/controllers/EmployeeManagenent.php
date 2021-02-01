<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class EmployeeManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('EmployeeModel');  
    $this->load->model('FacilityModel'); 
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
        $employee_mobile_number        = $this->input->post('employee_mobile_number');
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
                              'contactNumber' => $employee_mobile_number,
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
                              'contactNumber' => $employee_mobile_number,
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

        if ($id > 0) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added Successfully.'));
            redirect('employeeM/manageEmployee');
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('employeeM/manageEmployee');
        }

      }
      
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
      $GetEmployeeMenuGroup = $this->EmployeeModel->GetData('employeeMenuGroup', array('employeeId' => $id, 'status' => 1));
      $key_arr = array();
      $data['key_arr'] = $key_arr;
      foreach ($GetEmployeeMenuGroup as $key => $value) {
        $data['key_arr'][] = $value['groupId'];
      }
      if($this->input->post()){
        $employee_name        = $this->input->post('employee_name');
        $employee_mobile_number        = $this->input->post('employee_mobile_number');
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
                              'contactNumber' => $employee_mobile_number,
                              'profileImage'  => $InsertImg,
                              'employeeCode'  => $employee_code,
                              'password'      => base64_encode($password),
                              'status'        => $status,
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );

        } else {
          $updateData   = array('name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              'contactNumber' => $employee_mobile_number,
                              'profileImage'  => $InsertImg,
                              'employeeCode'  => $employee_code,
                              'status'        => $status,
                              'modifyDate'    => date('Y-m-d H:i:s')
                             );
        }

        $res = $this->EmployeeModel->updateData('employeesData', $updateData, array('id' => $id));
        $this->EmployeeModel->deleteData('employeeMenuGroup', array('employeeId' => $id));
        foreach ($menu_group as $key => $value) {
          $insertData2   = array( 'employeeId'          => $id,
                                  'groupId'         => $value,
                                  'status'        => 1,
                                  'addDate'       => date('Y-m-d H:i:s'),
                                  'modifyDate'    => date('Y-m-d H:i:s')
                             );
          $this->EmployeeModel->insertData('employeeMenuGroup', $insertData2);
        }

        $loginId = $this->session->userdata('adminData')['Id'];
        $ip = $this->input->ip_address();

        $strMenu = implode (", ", $menu_group);

        if(!empty($password)){

          $logData      = array('employeeId'    => $id,
                              'name'          => ucwords($employee_name),
                              'email'         => $employee_email,
                              'contactNumber' => $employee_mobile_number,
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
                              'contactNumber' => $employee_mobile_number,
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
      
      $this->load->view('admin/include/header-new',$data);
      $this->load->view('admin/employee/employee-edit');
      $this->load->view('admin/include/footer-new');
  }
  


}

    