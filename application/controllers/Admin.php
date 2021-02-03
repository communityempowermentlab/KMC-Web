<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class Admin extends Welcome {
  public function __construct() {
      parent::__construct();
      $this->load->model('UserModel');
      $this->load->model('FacilityModel');
      $this->load->model('MotherModel');
      $this->load->model('BabyModel');
      $this->load->model('DashboardDataModel');
      $this->load->model('DangerSignModel');
      $this->load->library('zip');
      $this->load->library('image_lib');
        $this->load->helper(array('captcha'));
       
  }

  
  
  /*  redirect to new dashboard
      view file name & path : dashboard/new/welcomeDashboard
  */ 
  public function welcomeDashboard(){
    $this->is_not_logged_in(); 
    $data['index']         = 'index'; 
    $data['index2']        = '';
    $data['title']         ='Dashboard Control Panel | '.PROJECT_NAME;   
    $data['counting']      = $this->UserModel->getCount();
    $data['LatestMother']  = $this->FacilityModel->getLatestMother();
    $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
    $this->load->view('dashboard/new/include/header',$data);
    $this->load->view('dashboard/new/welcomeDashboard');
    $this->load->view('dashboard/new/include/footer');
  }




public function captcha(){
        $data = array();
        
        // If captcha form is submitted
        if($this->input->post('submit')) {
            $inputCaptcha = $this->input->post('captcha');
            $sessCaptcha = $this->session->userdata('captchaCode');
            if($inputCaptcha === $sessCaptcha){
                $data['msg'] = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> Captcha code matched.
                </div>';
            }else{
                 $data['msg'] = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong> Captcha does not match, please try again.
                </div>  ';
            }
        }
        // Captcha configuration
        $config = array(
            'img_path'      => BASH_PATH.'assets/uploads/captcha_images/',
            'img_url'       => base_url().'/assets/uploads/captcha_images/',
            'img_width'     => 170,
            'img_height'    => 55,
            'expiration'    => 7200,
            'word_length'   => 6,
            'font_size'     => 25,
            'colors'        => array(
                'background' => array(171, 194, 177),
                'border' => array(10, 51, 11),
                'text' => array(0, 0, 0),
                'grid' => array(185, 234, 237)
            )
        );
        $captcha = create_captcha($config);
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        // Pass captcha image to view
        $data['captchaImg'] = $captcha['image'];
        // Load the view
        $this->load->view('admin/auth-login.php', $data);
    }
    // refresh
    public function refresh(){
        // Captcha configuration
         $config = array(
            'img_path'      => BASH_PATH.'./captcha_images/',
            'img_url'       => base_url().'assets/uploads/captcha_images/',
            'img_width'     => 170,
            'img_height'    => 55,
            'expiration'    => 7200,
            'word_length'   => 6,
            'font_size'     => 25,
            'colors'        => array(
                'background' => array(171, 194, 177 ),
                'border' => array(10, 51, 115),
                'text' => array(0, 0, 0),
                'grid' => array(185, 234, 237)
            )
        );
        $captcha = create_captcha($config);
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        // Display captcha image
        echo $captcha['image'];
    }









  /*  redirect to index page i.e. login page
      view file name & path : admin/index
  */
  public function index(){ 
    $this->is_logged_in(); 
    $data['title'] = PROJECT_NAME; 
    $data['backgroundImages'] = $this->FacilityModel->getActiveImage(); 
    $this->load->view('/admin/auth-login',$data);
  }


  public function Login(){
    $this->is_logged_in(); 
    $data['title'] = PROJECT_NAME; 
    $data['backgroundImages'] = $this->FacilityModel->getActiveImage(); 
    $this->load->view('/admin/cel-auth-login',$data);
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
      $data = $this->FacilityModel->checkLogInMobile($mobile, $table, $column, $id, $id_column); 

      if($data[$column]==$mobile){
        echo"Mobile Number Already Exits";  
      }
    }
  }


  /*  redirect admin dashboard page when click on sidemenu MNCU Dashboard
      view file name & path : admin/dashboard
  */ 
  public function dashboard(){ 
    $this->is_not_logged_in(); 
    $adminData = $this->session->userdata('adminData'); 
    $dashboardMenuSettings = array();
    if($adminData['Type']=='2'){
      $getMenus = $this->UserModel->getEmployeeMenu($adminData['Id'],$adminData['Type']);
      $this->session->set_userdata('userPermission', $getMenus);
    }

    $data['getDashboardData'] = $this->UserModel->getDashboardData();
    $data['dashboardMenuSettings'] = $dashboardMenuSettings;
    $data['sessionData'] = $adminData;

    $data['index']         = 'index';
    $data['index2']        = '';
    $data['title']         ='Dashboard Control Panel | '.PROJECT_NAME;   
    $data['counting']      = $this->UserModel->getCount(); 
    $data['LatestMother']  = $this->FacilityModel->getLatestMother();
    $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/dashboard-new',$data);
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/chart-footer');
  }


  /*  call to get chart data for dashboard
      called On: Admin Dashboard 
  */
  public function getDashboardCharts(){
    $this->load->view('getChartData');
  }

 
  /*  call to change the status of records of a table
      called On:  Staff List Page
                  Lounge List Page
  */
  public function changeStatus() {
    $table = $this->input->post('table');
    $id = $this->input->post('id');
    $unikCol = $this->input->post('tbl_id');
    $update_status = $this->FacilityModel->changeStatus($id, $table,$unikCol);
    echo $update_status;
    die();
  }


  /* call to get block data from revenuevillagewithblcoksandsubdistandgs table
     called On: AddFacility Page
                UpdateFacility Page
  */
  public function getBlock($id = '', $block_id='', $type ='') {
    if ($this->input->post()) {
      $id = $this->input->post('id');
      $block_id = $this->input->post('block_id');
      $type = $this->input->post('type');
      $distData = $this->FacilityModel->selectBlock($id, $block_id,$type);
      
      $set_html_cont = '<option value="">Select Block</option>';       

      foreach ($distData as $value) {

        $Select = ($block_id==$value['BlockPRICode'])?'SELECTED':'' ;
        $set_html_cont.= '<option value="'.$value['BlockPRICode'].'" '.$Select.' >'.$value['BlockPRINameProperCase'].'</option>'; 
        
      }
      print_r($set_html_cont);
    }
  }

  public function getVillageByDistrict($id = ''){
    if ($this->input->post()) {
      $id = $this->input->post('id');
      $vill_town_city = $this->input->post('vill_town_city');
      $distData = $this->FacilityModel->selectVillageByDistrict($id); 
      
      $set_html_cont = '<option value="">Select Village/Town/City</option>';       

      foreach ($distData as $value) {

        $Select = ($vill_town_city==$value['GPPRICode'])?'SELECTED':'' ;
        $set_html_cont.= '<option value= "'.$value['GPPRICode'].'" '.$Select.'>'.$value['GPNameProperCase'].'</option>';
        
      }
      print_r($set_html_cont);
    }
  }


  /* call to get village & GPRI data from revenuevillagewithblcoksandsubdistandgs table
     called On: AddFacility Page
                UpdateFacility Page
  */
  public function getVillage($id = '', $GP_code='', $type ='') {
    if ($this->input->post()) {
      $id = $this->input->post('id');
      $GP_code = $this->input->post('GP_code');
      $type = $this->input->post('type');

      $villData = $this->FacilityModel->selectVillage($id, $GP_code,$type);

      
      $set_html_cont = '<option value="">Select Village/Town/City</option>';       

      foreach ($villData as $value) {
         $Select = ($GP_code==$value['GPPRICode'])?'SELECTED':'' ;
          $set_html_cont.= '<option value= "'.$value['GPPRICode'].'" '.$Select.' >'.$value['GPNameProperCase'].'</option>'; 
      }
      print_r($set_html_cont);
      die();

    }
  }


  /* Get Sub Staff Type By Staff Type
     Called On : AddStaff Page On Change of Staff Type
                 UpdateStaff Page On Change of Staff Type
  */
  public function getStaffTypeList() {
    $table = $this->input->post('table');
    $id = $this->input->post('id');
    $sub_staff_type = $this->input->post('sub_staff_type');
    if ($id != ''){
      $update_status = $this->UserModel->getStaffTypeList($table,$id);
      $set_html_cont1 = "";
      $set_html_cont = '<option value="">Select Staff Sub Type</option>';    
      foreach ($update_status as $value) {
        $Select = ($sub_staff_type==$value['staffTypeId'])?'SELECTED':'' ;
        if(strtolower($value['staffTypeNameEnglish']) != "other"){
          $set_html_cont.= '<option value="'.$value['staffTypeId'].'" typevalue="'.strtolower($value['staffTypeNameEnglish']).'" '.$Select.'>'.$value['staffTypeNameEnglish'].'</option>'; 
        }
        if(strtolower($value['staffTypeNameEnglish']) == "other"){
           $set_html_cont1 = '<option value="'.$value['staffTypeId'].'" typevalue="'.strtolower($value['staffTypeNameEnglish']).'" '.$Select.'>'.$value['staffTypeNameEnglish'].'</option>'; 
        }
      }
      print_r($set_html_cont.$set_html_cont1);
      die();
    } else {
      $set_html_cont = '<option value="">Select Staff Sub Type</option>'; 
      print_r($set_html_cont);
      die();
    }
  } 

 
  /* Call To Get State By Country Id 
     Called On : Addfacilty Page On Change of Country
                 Updatefacilty Page On Change of Country
  */
  public function getState() {
    if ($this->input->post()) {
      $id = $this->input->post('id');
      $State = $this->input->post('State');
      $Type = $this->input->post('type');
      
      $distData = $this->FacilityModel->selectState($id, $State, $Type);

      print_r($distData);

      $set_html_cont = '<option value="">Select State</option>';       

      foreach ($distData as $value) {
        $Select = ($State==$value['id'])?'SELECTED':'' ;
        $set_html_cont.= '<option value="'.$value['id'].'" '.$Select.'   >'.$value['name'].'</option>'; 
      }
      print_r($set_html_cont);
      die();
    }
  }


  public function getDistrict(){
    if ($this->input->post()) {
      $id = $this->input->post('id');
      $district = $this->input->post('district');
      $distData = $this->FacilityModel->selectDistrict($id);

      $set_html_cont = '<option value="">Select District</option>';       

      foreach ($distData as $value) {
        $Select = ($district==$value['PRIDistrictCode'])?'SELECTED':'' ;
        $set_html_cont.= '<option value="'.$value['PRIDistrictCode'].'" '.$Select.'   >'.$value['DistrictNameProperCase'].'</option>'; 
      }
      print_r($set_html_cont);
      die();
    }
  }


  /* Call To Update SMS API Setting Data
     Post form url on settings page
  */
  public function updateSmsSettingData(){
    $table = 'settings';
    $data                 = $this->input->post();
    $fields                = array();
    $fields['route']       =  $data['route'];
    $fields['senderId']    =  $data['senderID'];
    $fields['userName']    =  $data['username'];
    $fields['password']    =  $data['password'];
    $fields['smsPermissionFirst']   =  empty($data['smsPermissionFirst']) ? '2' : $data['smsPermissionFirst'];
    $fields['smsPermissionSecond']  = empty($data['smsPermissionSecond']) ? '2' : $data['smsPermissionSecond'];
    $fields['smsFormatFirst']       =  $data['smsFormatFirst'];
    $fields['smsFormatSecond']      =  $data['smsFormatSecond'];
    $fields['modifyDate']           = date('Y-m-d H:i:s');
    $this->db->where('id','1');
    $update = $this->db->update($table,$fields);

    if ($update > 0) {
      $this->session->set_flashdata('activate', getCustomAlert('S','SMS Settings has been Updated successfully'));
      redirect('Admin/settings');
    } else {
      $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
      redirect('Admin/settings');
    }
  }



  /* Call To Update Setting Data
     Post form url on settings page
  */
  public function updateSettingData(){
    $table = 'settings';
    $data                                   = $this->input->post();

    $fields                                 = array();
    $fields['quickEmail']                   = $data['QuickEmail'];        
    $fields['babyMonitoringFirstTime']      =  $data['BabyMointoringOneTime'];
    $fields['babyMonitoringSecondTime']     =  $data['BabyMointoringSecondTime'];
    $fields['babyMonitoringThirdTime']      =  $data['BabyMointoringThirdTime'];
    $fields['babyMonitoringFourthTime']     =  $data['BabyMointoringFourthTime'];

    $fields['motherMonitoringFirstTime']    =  $data['MotherMointoringOneTime'];
    $fields['motherMonitoringSecondTime']   =  $data['MotherMointoringSecondTime'];
    $fields['motherMonitoringThirdTime']    =  $data['MotherMointoringThirdTime'];
    $fields['motherMonitoringFourthTime']   =  $data['MotherMointoringFourthTime'];

    $fields['roomTempFirstTime']            =  $data['RoomTempOneTime'];
    $fields['roomTempSecondTime']           =  $data['RoomTempTwoTime'];
    $fields['roomTempThirdTime']            =  $data['RoomTempThreeTime'];
    $fields['roomTempFourthTime']           =  $data['RoomTempFourTime'];
    $fields['roomTempFifthTime ']           =  $data['RoomTempFiveTime'];
    $fields['roomTempSixthTime']            =  $data['RoomTempSixTime'];

    $fields['breakfastTime']                =  $data['BreakfastTime'];
    $fields['lunchTime']                    =  $data['LunchTime'];
    $fields['dinnerTime']                   =  $data['DinnerTime'];

    $fields['loungeCleaningFirstTime']      =  $data['LoungeCleaningOneTime'];
    $fields['loungeCleaningSecondTime ']    =  $data['LoungeCleaningTwoTime'];
    $fields['loungeCleaningThirdTime']      =  $data['LoungeCleaningThreeTime'];

    $fields['morningDutyChange']            =  $data['DutyShiftOneTime'];
    $fields['dayDutyChange ']               =  $data['DutyShiftTwoTime'];
    $fields['nightDutyChange']              =  $data['DutyShiftThreeTime'];


    $fields['modifyDate']                   = date('Y-m-d H:i:s');
    $this->db->where('id','1');
    $update = $this->db->update($table,$fields);

    if ($update > 0) {
        $this->session->set_flashdata('activate', getCustomAlert('S','Settings has been Updated successfully'));
        redirect('Admin/settings');
    } else {
        $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
        redirect('Admin/settings');
    }
  }


  /* redirect to setting page, sidemenu Settings 
     view file name & path : admin/settings/settings
  */
  public function settings(){
    $this->is_not_logged_in(); 
    $data['index']         = 'Settings';
    $data['index2']        = 'Manage Settings';
    $data['title']         = 'Manage Settings | '.PROJECT_NAME; 
    $data['Settings']      = $this->FacilityModel->GetDataInSettings();
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/settings/settings');
    $this->load->view('admin/include/footer');
  }


  public function loginImage(){
    $data['index']         = 'Settings';
    $data['index2']        = 'Manage LogIn Image';
    $data['title']         = 'Manage LogIn Image | '.PROJECT_NAME; 
    $data['result']      = $this->FacilityModel->getLoginImage(); 
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/settings/loginImageList');
    $this->load->view('admin/include/footer');
  }


  public function addImage(){
    $data['index']         = 'Settings';
    $data['index2']        = 'Manage LogIn Image';
    $data['title']         = 'Manage LogIn Image | '.PROJECT_NAME; 
    

    if($this->input->post()){
      $fileName   = $_FILES['image']['name'];
      $extension  = explode('.',$fileName);
      $extension  = strtolower(end($extension));
      $uniqueName = time().'.'.$extension;
      $tmp_name   = $_FILES['image']['tmp_name'];
      $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/loginPage/".$uniqueName; 
      
      $InsertImg = utf8_encode(trim($uniqueName));
      move_uploaded_file($tmp_name,$targetlocation);

      $fields['image']                    =       $InsertImg;
      $fields['status']                   =       1;
      $fields['addDate']                  =       date('Y-m-d H:i:s');
      $fields['modifyDate']               =       date('Y-m-d H:i:s');
      $this->db->insert('indexPageImage',$fields);

      $this->session->set_flashdata('activate', getCustomAlert('S','Image added successfully.'));
      redirect('Admin/loginImage');

    }

    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/settings/addLoginImage');
    $this->load->view('admin/include/footer');
  }


  public function editImage(){
    $data['index']         = 'Settings';
    $data['index2']        = 'Manage LogIn Image';
    $data['title']         = 'Manage LogIn Image | '.PROJECT_NAME; 
    $id = $this->uri->segment('3'); 
    $data['result']        = $this->FacilityModel->getLoginImageById($id);

    if($this->input->post()){
      $id = $this->input->post('id');
      $oldImage   = $this->input->post('oldImage');
      if($_FILES['image']['name'] != ""){  
        $fileName   = $_FILES['image']['name'];
        $extension  = explode('.',$fileName);
        $extension  = strtolower(end($extension));
        $uniqueName = time().'.'.$extension;
        $tmp_name   = $_FILES['image']['tmp_name'];
        $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/loginPage/".$uniqueName; 
        $unlinkImg = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/loginPage/".$oldImage; 
        $InsertImg = utf8_encode(trim($uniqueName));
        unlink($unlinkImg);
        move_uploaded_file($tmp_name,$targetlocation);
      } else {
        $InsertImg = $oldImage;
      }

      $fields['image']                    =       $InsertImg;
      $fields['modifyDate']               =       date('Y-m-d H:i:s');
      $this->db->where('id',$id);
      $this->db->update('indexPageImage',$fields);

      $this->session->set_flashdata('activate', getCustomAlert('S','Image updated successfully.'));
      redirect('Admin/loginImage');

    }

    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/settings/editLoginImage');
    $this->load->view('admin/include/footer');
  }


  /*  redirect to Change Password page
      menu - Change Password in header file
  */
  public function changePassword(){
    $data['index']         = 'ChangePassword';
    $data['index2']        = 'Change Password';
    $data['title']         = 'Change Password | '.PROJECT_NAME; 
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/ChangePassword');
    $this->load->view('admin/include/footer');
  }


  /*  Call to update Password
      Post form url in ChangePassword Page
  */
  public function updatePassword(){
    $data                                    = $this->input->post(); 
    $OldPassword                             = $data['OldPassword'];
    $NewPassword                             = $data['NewPassword'];
    $confirmPassword                         = $data['confirmPassword'];
    $GetAdminInfo=$this->FacilityModel->GetAdminInfo();

    if (base64_decode($GetAdminInfo['password'])== $OldPassword AND $NewPassword == $confirmPassword) {
        $this->FacilityModel->ChangePassword(base64_encode($NewPassword));
        $this->session->set_flashdata('activate', getCustomAlert('S','Password has been Changed successfully.'));
        redirect('Admin/ChangePassword/1');
    } else {
        $this->session->set_flashdata('activate', getCustomAlert('W','Enter Password is Worng / New Password And confirm Password does not matched'));
        redirect('Admin/ChangePassword/');
    }
  }  


  /*  Redirect to Date Wise Mother Page
      Called On : when click on View Statistics Mother Count
  */
  public function dateWiseMother($loungeId,$loungeDate)
  {
    $data['index']         = 'report';
    $data['index2']        = '';
    $data['title']         = 'Date Wise Mother Report | '.PROJECT_NAME; 
    $t1                    = date($loungeDate. ' 00:00:01');
    $t2                    = date($loungeDate. ' 23:59:59');
    $Datefrom              = $t1;
    $Dateto                = $t2;

    $data['GetMother']   = $this->MotherModel->getDateWiseMohter($loungeId,$Datefrom,$Dateto); 
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/include/dateWiseMother');
    $this->load->view('admin/include/footer');
  }


  /*  Redirect to Date Wise Baby Page
      Called On : when click on View Statistics Baby Count
  */
  public function dateWiseBaby($loungeId,$loungeDate)
  {
    $data['index']         = 'report';
    $data['index2']        = '';
    $data['title']         = 'Date Wise Baby Report | '.PROJECT_NAME; 
    $t1                    = date($loungeDate. ' 00:00:01');
    $t2                    = date($loungeDate. ' 23:59:59');
    $Datefrom              = $t1;
    $Dateto                = $t2;

    $data['GetBaby']   = $this->BabyModel->getDateWiseBaby($loungeId,$Datefrom,$Dateto); 
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/include/dateWiseBaby');
    $this->load->view('admin/include/footer');
  } 


  /*  Redirect to War-Room Dashboard when click on side menu War-Room
      view file name & path : admin/warRoomDashboard
  */
  public function warRoom()
  {
    $data['index']         = 'waroom';
    $data['index2']        = '';
    $data['title']         = 'Manage War-Room | '.PROJECT_NAME; 
    $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
    $this->load->view('admin/include/headerChartJS',$data);
    $this->load->view('admin/warRoomDashboard');
    $this->load->view('admin/include/footer');
  }


  /*  Redirect to View Statistics Page when not post
      Sidebar Menu : Reports >> View Statistics
      By Default Current Month Statistics, else between dates (when post)
      view file name & path : admin/include/viewStatisticsReport
  */
  public function statisticsReport()
  { 
    $data['index']         = 'report';
    $data['index2']        = '';
    $data['title']         = 'Statistics Report | '.PROJECT_NAME; 
    $data['Getlounge']   = $this->DashboardDataModel->getAllLonges(); 

    $data['date1'] = Date('Y-m-d', strtotime("+1 day"));
    $data['date2']   = date('Y-m-01'); 

    $data['date3'] = date('Y-m-01'); 
    $data['date4']   = date('Y-m-d H:i:s');

    $data['fromDate'] = '';
    $data['toDate'] = '';


    if ($this->input->post()) {
      $fromDate = $this->input->post('fromDate');
      $toDate = $this->input->post('toDate');

      $data['fromDate'] = $fromDate;
      $data['toDate']   = $toDate;

      $data['date1']    = Date('Y-m-d', strtotime($toDate."+1 day"));
      $data['date2']    = date("Y-m-d", strtotime($fromDate));

      $data['date3']    = date("Y-m-d", strtotime($fromDate));
      $data['date4']    = date("Y-m-d H:i:s", strtotime($toDate));
      
    }

   
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/report/view-statistics-report');
    $this->load->view('admin/include/footer-new');
  }



  /*  Call to dowload Statistics Report in excel format
      Called On : Download button of Statistics Report Page  
      Generate Code on View Page : admin/include/viewGenerateStatisticsReportExcel
  */
  public function generateStatisticsReportExcel(){

    $data['Getlounge']   = $this->FacilityModel->getFacilityStatusActive(); 
    $data['date1'] = $this->input->get('date1');
    $data['date2'] = $this->input->get('date2');
    $data['date3'] = $this->input->get('date3');
    $data['date4'] = $this->input->get('date4');
    $this->load->view('admin/include/viewGenerateStatisticsReportExcel',$data);
  }


  /*  Redirect to Download Reports Page 
      Sidebar Menu : Reports >> Download Reports
      View Reports Lounge Wise & Month Wise
      view file name & path : admin/downloadPdfReport
  */
  public function downloadReports()
  {
    $this->is_not_logged_in(); 
    $data['index']         = 'report1';
    $data['index2']        = '';
    $data['title']         = 'Manage PDF Report | '.PROJECT_NAME; 
    $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/report/download-pdf-report');
    $this->load->view('admin/include/footer-new');
  } 


  /*  Call to dowload Pdf Reports in zip format
      Called On : Download button of Download Reports Page  
      Generate Zip then redirect to downloadReports
  */
  public function createZipPdfReports()
  {
    $paths = FCPATH .'assets/temperory/*';
    $files = glob($paths); // get all file names 
    foreach($files as $file){ // iterate files
      if(is_file($file))
      unlink($file); // delete file
    }

    $startDate =$this->uri->segment('3');
    $endDate = $this->uri->segment('4');
    $LoungeID = $this->uri->segment('5');
    $query1 = $this->db->query("select ba.`babyDischargePdfName` from babyAdmission as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` where ba.`loungeId`=".$LoungeID." and ba.`status`='2' and  ba.`addDate` between '".$startDate."' and '".$endDate."'")->result_array(); 
    foreach ($query1 as $key => $value) {
      $pathdir = FCPATH .'assets/pdfFile/'.$value['babyDischargePdfName'];
      $copydir = FCPATH .'assets/temperory/'.$value['babyDischargePdfName'];
      copy($pathdir,$copydir);
    }
    $path = FCPATH .'assets/temperory/';
    $this->zip->read_dir($path, False);
    $this->zip->archive($path.'pdf.zip');
    $this->zip->download('pdf.zip');
    redirect('Admin/downloadReports');
  } 


  public function generateReport(){
    $this->is_not_logged_in(); 
    $data['index']         = 'report2';
    $data['index2']        = '';
    $data['title']         = 'Generate Reports | '.PROJECT_NAME; 
    $data['totalLounges']  = $this->DashboardDataModel->getAllLonges();
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/report/generate-report');
    $this->load->view('admin/include/footer-new');
  }


  public function generateReportExcel(){
    $data['Getlounge']   = $this->FacilityModel->getFacilityStatusActive(); 
    $this->load->view('admin/report/excelReport',$data);
   // redirect('Admin/report');
  }

  public function generateReportExcelSTS(){
    $data['Getlounge']   = $this->FacilityModel->getFacilityStatusActive(); 
    $this->load->view('admin/report/excelReportSTS',$data);
   // redirect('Admin/report');
  }


  public function generateReportExcelAdmission(){
    $data['Getlounge']   = $this->FacilityModel->getFacilityStatusActive(); 
    $this->load->view('admin/report/excelReportAdmission',$data);
   // redirect('Admin/report');
  }
  
        
}
?>
