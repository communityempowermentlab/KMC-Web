<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class FacilityManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('FacilityModel');
    $this->load->model('StaffModel');
    $this->load->model('LoungeModel');  
    date_default_timezone_set('Asia/Kolkata');     
    $this->is_not_logged_in(); 
    $this->restrictPageAccess(array('3','36'));  
       
  }

  /*  Facility Login page call
      LogIn based on Facility Mobile Number
      view file name & path : /admin/facilityLogin
  */
  public function index(){
    $this->load->view('/admin/facilityLogin');
  }


  /*  Facility OTP Screen Page call 
      Called when Facility Mobile Number is validated on CheckMobile
      redirect to otp page when id exists else to Login Page 
  */
  public function Otp(){
    $id = $this->uri->segment(3);
    if(!empty($id)){
      $this->load->view('/admin/facilityOtp');
    } else {
      redirect(base_url()."facility/");
    }
  }


  /*  Facility Administration LogIn Phone Number Check 
      If validated - redirect to facility/Otp/ Page else display error message
      form post url on facilityLogin Page
  */
  public function CheckMobile(){
    $login_array    = $this->input->post();
    $mobile         = $login_array['mobile'];
    $admin          = $this->FacilityModel->FindMobile($mobile);
    if($admin['AdministrativeMoblieNo']== $mobile){
      $otp          = rand(100000, 999999);
      $this->SetOtp($admin['AdministrativeMoblieNo'],$otp);
      $message="Your OTP Code :".$otp;
      SendOtpSMS($mobile,$message);
      $this->session->set_flashdata('login_message', getCustomAlert('S', 'Otp Send Successfully'));
      redirect(base_url()."facility/Otp/".$admin['FacilityID']);
    }
    else {
      $this->session->set_flashdata('login_message', getCustomAlert('D','Mobile Number Not Registred / Wrong'));
      redirect('facility/');
    }
  }


  /*  Called when 1 minute timer is out on OTP page
      generate another otp and redirect to OTP page
      redirect to Login Page if $Id not exists
  */ 
  public function ResendOtp(){ 
    $Id = $this->uri->segment(3);
    if(!empty($Id)){
      $data = $this->FacilityModel->FindMobileForResend($Id);
      $otp          = rand(100000, 999999);
      $this->SetOtp($data['AdministrativeMoblieNo'],$otp);
      $message="Your OTP Code :".$otp;
      SendOtpSMS($data['AdministrativeMoblieNo'],$message);
      $this->session->set_flashdata('login_message', getCustomAlert('S', 'Resend Otp Send Successfully'));
      redirect(base_url()."facility/Otp/".$data['FacilityID']);
    } else {
      redirect(base_url()."facility/");
    }
  } 


  /*  post form url on facilityOtp page 
      insert login data into loginMaster
      maintain session with type 2 and redirect to Dashboard page
  */ 
  public function doLogin(){
    $login_array    = $this->input->post();
    $otp            = $login_array['otp'];
    $admin          = $this->FacilityModel->login($otp);
    $fields                         = array();
    $fields['loungeMasterId']       = $admin['FacilityID'];
    $fields['mobileNumber ']        = $admin['AdministrativeMoblieNo'];
    $fields['deviceId']             = $_SERVER['REMOTE_ADDR'];
    $fields['loginTime']            = date('H:i:s');
    $fields['type']                 = '2';
    $this->db->insert('loginMaster',$fields);
    $this->VerifyOtp($admin['AdministrativeMoblieNo']);
    if (!empty($admin)){
      $adminData = array(
        'is_logged_in'  => true,
        'Type'          => 2,
        'Id'            => $admin['FacilityID'],
        'Name'          => $admin['FacilityName'],
        'Email'         => $admin['AdministrativeMoblieNo']
      );
      $this->session->set_userdata('adminData', $adminData);

      $message = 'Welcome <strong>'.ucwords($admin['FacilityName']).'</strong>.You have successfully logged in.';
      $this->session->set_flashdata('login_message', getCustomAlert('S', $message));

      redirect('Admin/Dashboard');
      
    } else {
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 1));
      redirect('facility/');
    }
  }



  /*  Update OTP in falility Table
      Called in checkMobile() & ResendOtp()
  */ 
  public function SetOtp($mobile,$otp){
    $this->db->where('AdministrativeMoblieNo',$mobile);
    $this->db->update('facilitylist',array('Otp'=>$otp,'OtpStatus'=>'1','ModifyDate'=>date('Y-m-d H:i:s'))); 
  }


  /* Verify OTP in facility Table
     Called In:  doLogin()
  */ 
  public function VerifyOtp($mobile){
    $this->db->where('AdministrativeMoblieNo',$mobile);
    $this->db->update('facilitylist',array('OtpStatus'=>'2')); 
  }


  /* 
    view Facility listing page when click on sidemenu Facilities
    view file name & path : admin/facility/facilityList
    facility table : facilitylist
  */ 
  public function manageFacility(){
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['fileName']      = 'FacilityList';
    $data['title']         = 'Facilities | '.PROJECT_NAME; 
    if(!empty($_GET['district']) && !empty($_GET['keyword'])){ 
      $data['GetFacilities'] = $this->FacilityModel->GetFacilitiesByKeywordDistrict($_GET['district'], $_GET['keyword']);
    } else if(!empty($_GET['keyword'])){ 
      $data['GetFacilities'] = $this->FacilityModel->GetFacilitiesByKeyword($_GET['keyword']);
    } else if(!empty($_GET['district'])){ 
      $data['GetFacilities'] = $this->FacilityModel->GetFacilitiesByDistrict($_GET['district']);
    } else {
      $data['GetFacilities'] = $this->FacilityModel->GetFacilities();
    }
    
    $data['GetDistrict']   = $this->FacilityModel->selectquery(); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/facility/facility-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  /* 
    view Facility log page when click on last updated link
    view file name & path : admin/facility/facilityLogList
    facility table : facilitylist
  */ 
  public function viewFacilityLog(){
    $id=$this->uri->segment(3);
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['fileName']      = 'FacilityList';
    $data['title']         = 'Facilities | '.PROJECT_NAME; 
    
    $data['GetFacilityLog'] = $this->FacilityModel->GetFacilityLog($id); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/facility/facility-log-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  /* 
    view Facility Type listing page when click on Facility Type button on Facility Listing page
    view file name & path : admin/facility/facilityTypeList
    facility table : facilityType
  */ 
  public function FacilityType(){
    $data['index']         = 'FacilityType';
    $data['index2']        = '';
    $data['title']         = 'Facility Type | '.PROJECT_NAME; 
    $data['fileName']      = 'FacilityTypeList';

    $data['GetFacilities'] = $this->FacilityModel->GetFacilities('2'); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/facility/facility-type-list');
    $this->load->view('admin/include/datatable-new');
    $this->load->view('admin/include/footer-new');
  }
  

  /* 
    view add Facility Type page when click on Add Facility Type button of Facility Type Listing page
    view file name & path : admin/facility/addFacilityType
    facility type table : facilityType
    when post : insert data in facilityType table
    when not post : get data and redirect to view file 
  */ 
  public function addFacilityType(){
    $data['index']         = 'FacilityType';
    $data['index2']        = '';
    $data['title']         = 'Add Facility Type | '.PROJECT_NAME; 
    $data['fileName']      = 'FacilityTypeList';

    if($this->input->post()){
      $data= $this->input->post();
      $check = $this->FacilityModel->AddUpdateFacility($data);
      if ($check == 'insert') {
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
        redirect('facility/facilityType');
      }else if($check == 'update'){
        $this->session->set_flashdata('activate', getCustomAlert('S','Facility type has been updated Successfully.'));
        redirect('facility/facilityType');
      }
    }
      
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/facility/add-facility-type');
    $this->load->view('admin/include/footer-new');
  }


  /* 
    view edit Facility type page when click on View/Edit button on Facility Type Listing page
    view file name & path : admin/facility/editFacilityType
    facility table : facilityType
    
  */  
  public function editFacilityType(){
    $id=$this->uri->segment(3); 
    $data['index']         = 'FacilityType';
    $data['index2']        = '';
    $data['title']         = 'Facility Type | '.PROJECT_NAME; 
    $data['fileName']      = 'FacilityTypeList';

    $data['GetFacilities'] = $this->FacilityModel->GetFacilitiesTypeById('facilityType', $id); 

    if($this->input->post()){
      $data= $this->input->post();
      $check = $this->FacilityModel->AddUpdateFacility($data);
      if ($check == 'insert') {
         $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
        redirect('facility/facilityType');
      }else if($check == 'update'){
          $this->session->set_flashdata('activate', getCustomAlert('S','Facility type has been updated Successfully.'));
          redirect('facility/facilityType');
      }
    }                                       

    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/facility/edit-facility-type');
    $this->load->view('admin/include/footer-new');

  }

    

  public function viewFacilityTypeLog(){
    $id=$this->uri->segment(3);
    $data['index']         = 'FacilityType';
    $data['index2']        = '';
    $data['fileName']      = 'FacilityTypeList';
    $data['title']         = 'Facility Type Log | '.PROJECT_NAME; 
    
    $data['GetLog'] = $this->FacilityModel->GetFacilityTypeLog($id); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/facility/facility-type-log');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }



  /* 
    view add Facility page when click on Add Facility button of Facility Listing page
    view file name & path : admin/facility/AddFacility
    facility table : facilitylist
    when $insert is passed : insert data in facilitylist table
    when $insert is not passed : get data and redirect to view file 
  */ 
  public function AddFacility($insert =''){
    
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['title']         = 'Add Facility | '.PROJECT_NAME; 
    $data['NewBorn']       = $this->FacilityModel->NewBornCareUnit(); 
    $data['Management']    = $this->FacilityModel->ManagementType(); 
    $data['GovtORNot']     = $this->FacilityModel->GovtORNot(); 
    $data['GetLounge']     = $this->FacilityModel->lounge(); 
    $data['GetFacilities'] = $this->FacilityModel->GetFacilities('2'); 
    $data['GetFacilities2']= $this->FacilityModel->GetFacilities2('2'); 
    
    // $data['selectquery'] = $this->FacilityModel->selectquery(); 
    
    $data['selectState'] = $this->FacilityModel->selectState(); 
    
      if($insert=='') {
          $this->load->view('admin/include/header-new',$data);
          $this->load->view('admin/facility/facility-add');
          $this->load->view('admin/include/footer-new');
      }else{ 
          // print_r($this->input->post());
          
          $Form_Data = $this->input->post();
          $inserted = $this->FacilityModel->InsertFacility($Form_Data); 

          if($inserted >0){

              $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
              redirect('facility/manageFacility');

          }else{
       
             $this->session->set_flashdata('activate', getCustomAlert('W','Oops Something Went Worng. Please Tr Again.'));
              redirect('facility/manageFacility');

          }
      }
  }



  /* 
    view edit Facility page when click on View/Edit button of facility listing page
    view file name & path : admin/facility/UpdateFacility
    facility table : facilitylist
    
  */ 
  public function UpdateFacility(){
    $id=$this->uri->segment(3);
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['title']         = 'Facility Information | '.PROJECT_NAME; 

    $data['FacilitiesData'] = $this->FacilityModel->GetFacilitiesById('facilitylist',$id);

    if($data['FacilitiesData']['FacilityTypeID'] == 9) {
       $data['selectVillage']  = $this->FacilityModel->selectVillageByDistrict($data['FacilitiesData']['PRIDistrictCode']);
    } else {
       $data['selectVillage']  = $this->FacilityModel->selectVillage($data['FacilitiesData']['PRIBlockCode']);
    }

    $data['NewBorn']       = $this->FacilityModel->NewBornCareUnit(); 
    $data['Management']    = $this->FacilityModel->ManagementType(); 
    $data['GovtORNot']     = $this->FacilityModel->GovtORNot(); 
    $data['GetFacilities'] = $this->FacilityModel->GetFacilities('2'); 
    $data['selectquery'] = $this->FacilityModel->selectquery();
    $data['selectBlock'] = $this->FacilityModel->selectBlock($id); 
    //$data['selectVillage'] = $this->FacilityModel->selectVillage();
    $data['selectState'] = $this->FacilityModel->selectState(); 
    //$data['selectState'] = $this->FacilityModel->selectState();  
    

    $data['selectDistrict'] = $this->FacilityModel->selectDistrict($data['FacilitiesData']['StateID']);
    $data['selectBlock']    = $this->FacilityModel->selectBlock($data['FacilitiesData']['PRIDistrictCode']);
   

    // print_r($data['FacilitiesData']); exit;
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/facility/facility-edit');
    $this->load->view('admin/include/footer-new');
  }


  /*  post form url on facilityTypeList Page
      add or update data in facilityType
      after above redirect on facility/facilityType
  */ 
  public function AddUpdateFacility($value=''){
    $data= $this->input->post();
    $check = $this->FacilityModel->AddUpdateFacility($data);
    if ($check == 'insert') {
      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully'));
      redirect('facility/facilityType');
    }else if($check == 'update'){
      $this->session->set_flashdata('activate', getCustomAlert('S','Facility type has been updated Successfully.'));
      redirect('facility/facilityType');
    }
  }


  /* 
    form url for edit/update facility page form
    update facility data then redirect to manageFacility (Facility Listing Page)
    facility table : facilitylist
  */ 
  public function UpdateFacilitiesPost() {
    $id=$this->uri->segment(3);
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['title']         = 'Update Facility | '.PROJECT_NAME; 
    $data=$this->input->post();


    $getOldData = $this->FacilityModel->GetFacilitiesById('facilitylist',$id);

    /*print_r($data); exit;*/

    if($data['kmcunitstart'] != ''){
      $kmcunitstart = $this->input->post('kmcunitstart');
      $kmcunitstartDate = explode(',',$kmcunitstart); 
      $strDate = $kmcunitstartDate[0].$kmcunitstartDate[1];
      $strDate = date("Y-m-d", strtotime($strDate));
    } else {
      $strDate = NULL;
    }

    if($data['kmcunitclose'] != ''){
      $kmcunitclose = $this->input->post('kmcunitclose');
      $kmcunitcloseDate = explode(',',$kmcunitclose); 
      $clsDate = $kmcunitcloseDate[0].$kmcunitcloseDate[1];
      $clsDate = date("Y-m-d", strtotime($clsDate));
      
    } else {
      $clsDate = NULL;
    }

    
    $FacilityData = array();

    $FacilityData['FacilityName']            = $data['facility_name'];
    $FacilityData['FacilityManagement']      = $data['facility_mange_type'];


    $FacilityData['FacilityTypeID']           = $data['facility_type'];
     
    $getName = $this->FacilityModel->GetFacilitiesTypeById('facilityType',$data['facility_type']); 
     
    $FacilityData['FacilityType']           = $getName['facilityTypeName'];
    $FacilityData['NCUType']                = $data['newborn_caring_type'];
    $FacilityData['KMCUnitStartedOn']       = $strDate;
    $FacilityData['KMCUnitClosedOn']        = $clsDate;
    $FacilityData['Address']                = $data['facility_address'];
    $address                                = $data['facility_address'];
    $FacilityData['GOVT_NonGOVT']           = $data['governmentOrNot'];
    $FacilityData['GPPRICode']              = $data['vill_town_city'];
    // $FacilityData['KMCLoungeStatus']        = $data['kmc_present'];

    $FacilityData['PRIDistrictCode']        = $data['district_name'];

    $getName = $this->FacilityModel->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs',$data['district_name']);
      
   
    $getName2 = $this->FacilityModel->GetBlockById('revenuevillagewithblcoksandsubdistandgs',$data['block_name']);
      
    $FacilityData['PRIBlockCode']             = $data['block_name'];
      
    $FacilityData['StateID']                  = $data['state_name'];
    // $getName1 = $this->FacilityModel->GetDataById('countries',$data['country_name']);
    $FacilityData['CountryID']                = NULL;
    $FacilityData['AdministrativeMoblieNo']   = NULL; //$data['contact_number'];
    $FacilityData['CMSOrMOICName']            = $data['cms_moic_name'];
    $FacilityData['CMSOrMOICMoblie']          = $data['phone_cms_moic_name'];
    $FacilityData['Status']                   = $data['status'];

    $formattedAddr                            = str_replace(' ','+',$address);
    $geocodeFromAddr                          = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');
     
    $output = json_decode($geocodeFromAddr);
        
    if(!empty($dlat) && !empty($output))
    {
      $FacilityData['latitude']                 = $dlat;
      $FacilityData['longitude']                = $dlong;
    }
    else{
      $FacilityData['latitude']                 = "0";
      $FacilityData['longitude']                = "0";
    }

    $FacilityData['ModifyDate']             = date('Y-m-d H:i:s');

    $update = $this->FacilityModel->updateDataCommon('facilitylist',$FacilityData,$id);

    $loginId = $this->session->userdata('adminData')['Id'];
    $type = $this->session->userdata('adminData')['Type'];
    $ip = $this->input->ip_address(); 

    
    $logData = array();

    $logData['tableReference']        = 1;
    $logData['tableReferenceId']      = $id;
    $logData['updatedBy']             = $loginId;
    $logData['type']                  = $type;
    $logData['deviceInfo']            = $ip;
    
    $logData['addDate']               = date('Y-m-d H:i:s');
    $logData['lastSyncedTime']        = date('Y-m-d H:i:s');

    if($getOldData['FacilityName'] != $data['facility_name']) {
      $logData['columnName']           = 'Facility Name';
      $logData['oldValue']             = $getOldData['FacilityName'];
      $logData['newValue']             = $data['facility_name'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['FacilityManagement'] != $data['facility_mange_type']) {
      $logData['columnName']           = 'Management Type';
      $logData['oldValue']             = $getOldData['FacilityManagement'];
      $logData['newValue']             = $data['facility_mange_type'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['FacilityTypeID'] != $data['facility_type']) {
      $logData['columnName']           = 'Facility Type';
      $logData['oldValue']             = $getOldData['FacilityTypeID'];
      $logData['newValue']             = $data['facility_type'];

      $this->db->insert('logData',$logData);
    }



    if($getOldData['NCUType'] != $data['newborn_caring_type']) { 
      $logData['columnName']           = 'Newborn Care Unit Type';
      $logData['oldValue']             = $getOldData['NCUType'];
      $logData['newValue']             = $data['newborn_caring_type'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['KMCUnitStartedOn'] != $strDate) {
      $logData['columnName']           = 'KMC Unit Start';
      $logData['oldValue']             = $getOldData['KMCUnitStartedOn'];
      $logData['newValue']             = $strDate;

      $this->db->insert('logData',$logData);
    }

    if($getOldData['KMCUnitClosedOn'] != $clsDate) {
      $logData['columnName']           = 'KMC Unit Close';
      $logData['oldValue']             = $getOldData['KMCUnitClosedOn'];
      $logData['newValue']             = $clsDate;

      $this->db->insert('logData',$logData);
    }
   
    if($getOldData['Address'] != $data['facility_address']) {
      $logData['columnName']           = 'Facility Postal Address';
      $logData['oldValue']             = $getOldData['Address'];
      $logData['newValue']             = $data['facility_address'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['GOVT_NonGOVT'] != $data['governmentOrNot']) {
      $logData['columnName']           = 'Govt OR Non Govt';
      $logData['oldValue']             = $getOldData['GOVT_NonGOVT'];
      $logData['newValue']             = $data['governmentOrNot'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['GPPRICode'] != $data['vill_town_city']) {
      $logData['columnName']           = 'Village/Town/City';
      $logData['oldValue']             = $getOldData['GPPRICode'];
      $logData['newValue']             = $data['vill_town_city'];

      $this->db->insert('logData',$logData);
    }
    
    if($getOldData['PRIDistrictCode'] != $data['district_name']) {
      $logData['columnName']           = 'District';
      $logData['oldValue']             = $getOldData['PRIDistrictCode'];
      $logData['newValue']             = $data['district_name'];

      $this->db->insert('logData',$logData);
    }
    
    if(!empty($data['block_name'])){
      if($getOldData['PRIBlockCode'] != $data['block_name']) {
        $logData['columnName']           = 'Block';
        $logData['oldValue']             = $getOldData['PRIBlockCode'];
        $logData['newValue']             = $data['block_name'];

        $this->db->insert('logData',$logData);
      }
    }

    if($getOldData['StateID'] != $data['state_name']) {
      $logData['columnName']           = 'State';
      $logData['oldValue']             = $getOldData['StateID'];
      $logData['newValue']             = $data['state_name'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['CMSOrMOICName'] != $data['cms_moic_name']) {
      $logData['columnName']           = 'CMS/MOIC Name';
      $logData['oldValue']             = $getOldData['CMSOrMOICName'];
      $logData['newValue']             = $data['cms_moic_name'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['CMSOrMOICMoblie'] != $data['phone_cms_moic_name']) {
      $logData['columnName']           = 'CMS/MOIC Phone Number';
      $logData['oldValue']             = $getOldData['CMSOrMOICMoblie'];
      $logData['newValue']             = $data['phone_cms_moic_name'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['Status'] != $data['status']) {
      $logData['columnName']           = 'Status';
      $logData['oldValue']             = $getOldData['Status'];
      $logData['newValue']             = $data['status'];

      $this->db->insert('logData',$logData);
    }
   

    $getName = $this->FacilityModel->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs',$data['district_name']);
   
    $getName2 = $this->FacilityModel->GetBlockById('revenuevillagewithblcoksandsubdistandgs',$data['block_name']);
      
        
    if($update > 0)
    {
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
        redirect('facility/manageFacility/');
    }else{
        $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
        redirect('facility/manageFacility/');
    }
  } 

  

      
  /*  form post url on UpdateFacilityType Page
      Update data of facilityType
  */   
  public function UpdateFacilitiesTypePost(){
    $id = $this->uri->segment(3);
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['title']         = 'Update Facility | '.PROJECT_NAME; 
    $data              = $this->input->post();
    $FacilityData      = array();

    $FacilityData['FacilityTypeName']        = $data['FacilityTypeName'];
    $FacilityData['Priority']                = $data['priority'];
    $FacilityData['Modify_Date']             = time();

    $update = $this->FacilityModel->updateFaciltyCommon('facilityType',$FacilityData,$id);
    if($update > 0)
    {
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
        redirect('facility/facilityType/');
    }else{
        $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
        redirect('facility/facilityType/');
    }
  }   


  public function LoungeLoginHistory(){
    $id = $this->uri->segment('3');
    $data['index']               = 'lounge';
    $data['index2']              = '';
    $data['fileName']              = 'Login History';
    $data['title']               = 'Lounge Application Login History | '.PROJECT_NAME; 
    $data['GetLoungeHistory']    = $this->db->query(" select * from loginMaster where loungeMasterId=".$id." and type='1' ORDER BY id DESC")->result_array();
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/login-history');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }



  public function ViewCalendar(){
    $data['index']         = 'index';
    $data['index2']        = '';
    $data['title']         = 'View Calendar';
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/calendar');
    $this->load->view('admin/include/footer');
  }


  /*  call to send mail
  */ 
  public function SendMail(){
    $adminData = $this->session->userdata('adminData'); 
    if($adminData['Type']=='1') {
        $title   = 'Quickemail : Via Admin';
        $message = $this->input->post('Message');
        $subject = $this->input->post('subject');  
        $name    = 'Admin';
    }else{
      $facilityName = $this->FacilityModel->GetFacilityName($adminData['Id']);
      $FacilityName= $facilityName['FacilityName'];
      $title   = 'Quickemail : Via '.$FacilityName;
      $message = $this->input->post('Message'); 
      $subject = $this->input->post('subject'); 
      $name    = $FacilityName;
    }
      $html  = '';
      $html .= '<table style="padding-right: 10px;padding-left: 10px;padding-bottom: 10px;padding-top: 10px;" align="center" width="800" cellspacing="0">
                <tbody style="background-color: white;"><tr>
                </tr>
                <tr>
                <td style="text-align:left;margin:0px !important;" >Subject:&nbsp;'.$subject.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000;text-indent:90px;line-height:18px" align="left" valign="top"><p style="padding:0px;font-size: 15px;text-align: justify;margin:0px !important;">'.$message.'</p></td>
                </tr>
                <tr>
                <td align="center" valign="top"></td>
                </tr>
                <tr>
                </p>
                </td>
                </tr>
                </tbody></table>';
     $to       = 'donotreply@community.org.in';
     $subject  = $title;
     $message  = $html;
     $headers  = "From:"."donotreply@community.org.in"."\r\n";
     $headers .= "MIME-Version: 1.0\r\n";
     $headers .= "Content-type: text/html; charset=utf-8\r\n";
     $mail = mail($to,$subject,'<pre style="font-size:14px;">'.$message.'</pre>',$headers);
      if($mail > 0){
        $this->session->set_flashdata('activate', getCustomAlert('S','Send Quick Email successfully.'));      
        redirect('Admin/Dashboard');
      } else {
        $this->session->set_flashdata('activate', getCustomAlert('S','Send Quick Email not sent successfully.'));      
        redirect('Admin/Dashboard');
      }
  }


  /*  call to change status of a table
      called on: facilityTypeList, staffType, supplimentList, videolist, videoType
  */ 
  public function changeStatus() { 
    $table = $this->input->post('table');
    $id = $this->input->post('id');
    $unikCol = $this->input->post('tbl_id'); 
    $update_status = $this->FacilityModel->changeStatus($id, $table,$unikCol);
    echo $update_status;
    die();
  }

  
  /*  call to change status of a facilityList table
  */ 
  public function changeFacilityStatus() { 
    $table = $this->input->post('table');
    $id = $this->input->post('id');
    $unikCol = $this->input->post('tbl_id'); 
    $update_status = $this->FacilityModel->changeFacilityStatus($id, $table,$unikCol);
    echo $update_status;
    die();
  }  


}
?>
