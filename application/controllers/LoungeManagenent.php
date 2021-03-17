<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Welcome.php');
class LoungeManagenent extends Welcome {
  public function __construct() {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('LoungeModel');  
    $this->load->model('FacilityModel');  
    $this->is_not_logged_in(); 
    $this->restrictPageAccess(array('6','61'));
  }


  /*  redirect to manage lounges page
      called on: lounges menu on side menu
      view file name & path : admin/lounge/LoungeList
  */
  public function manageLounge(){ 
    $data['index']          = 'lounge';
    $data['index2']         = '';
    $data['fileName']       = 'Lounge_List';
    $data['title']          = 'Lounges | '.PROJECT_NAME; 

    if($_GET){
      $data['GetLounge'] = $this->LoungeModel->GetActiveLoungeBySearch($_GET['district'], $_GET['facilityname'], $_GET['keyword']);
    }
    else{
      $data['GetLounge']   = $this->LoungeModel->lounge();
    }


    $data['GetDistrict']   = $this->FacilityModel->selectquery(); 
    // $data['GetFacility']    = $this->LoungeModel->GetFacilitiName($facility_id);
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }




public function getLounge(){
      if($this->input->post()){
        $facility = $this->input->post('facility');
        $loungeid = $this->input->post('loungeid');
        $getLounge = $this->LoungeModel->GetLoungeByFAcility($facility); 
        $html = ''; 
        if(!empty($getLounge)){
          $html.='<option value="">Select Lounge</option>';
          foreach ($getLounge as $key => $value) {
            $Select = ($loungeid==$value['loungeId'])?'SELECTED':'' ;
            $html.='<option value="'.$value['loungeId'].'" '.$Select.'>'.$value['loungeName'].'</option>';
          }
        } else {
          $html.='<option value="">No Records Found</option>';
        }
        echo $html;die;
      }
    }



  public function viewLoungeLog(){
    $id=$this->uri->segment(3);
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['fileName']      = 'Lounge_List';
    $data['title']         = 'Lounge Information Update History | '.PROJECT_NAME; 
    
    $data['GetLounge'] = $this->LoungeModel->getLoungeLastUpdate($id,2); 
    $data['GetLoungeData']     = $this->LoungeModel->GetLoungeById($id); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-log-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }

                     
  public function viewAmenitiesLog(){
    $id=$this->uri->segment(3);
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['fileName']      = 'Lounge_List';
    $data['title']         = 'Lounge Amenities Information Update History | '.PROJECT_NAME; 
    
    $data['GetLounge']      = $this->LoungeModel->GetAmenitiesLog($id); 
    $data['GetLoungeData']     = $this->LoungeModel->GetLoungeById($id); 
     /*echo $this->db->last_query(); exit;*/
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/amenities-log-list');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }
    

  /*  redirect to add lounge page
      called on: Add Lounge button on manage facilities
      view file name & path : admin/lounge/LoungeList
  */
  public function addLounge(){
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['title']         = 'Add Lounge | '.PROJECT_NAME; 

    // $facility_id = $this->uri->segment(3, 0); 
    $data['GetFacilities'] = $this->LoungeModel->GetFacilities(); 
    // $data['facility_id']    = $facility_id;

    $data['GetDistrict'] = $this->FacilityModel->selectquery(); 
    $data['menuGroup']   = $this->LoungeModel->GetDataOrderByAsc('manageMenuGroupSetting', array('status' => 1), 'groupName');

    if($this->input->post()){
      // print_r($this->input->post());die;
      // $this->form_validation->set_rules('facilityname[]',  'Facility Name' , 'required');
      $this->form_validation->set_rules('lounge_name', 'Lounge Name', 'required');
      // $this->form_validation->set_rules('lounge_contact_number', 'Lounge Phone Number','required');
      $this->form_validation->set_rules('lounge_password', 'Lounge Password', 'required');

      if ($this->form_validation->run() == FALSE) { 
        $this->load->view('admin/include/header',$data);
        $this->load->view('admin/include/tableScript');
        $this->load->view('admin/lounge/AddLounge');
        $this->load->view('admin/include/footer');
      } else { 
        $data2 = $this->input->post();
        $facility_id = $this->input->post('facility_id');
        $AddLounge = $this->LoungeModel->AddLounge($data2);
        if($AddLounge == 0){
            $this->session->set_flashdata('activate', getCustomAlert('W','IMEI Number Already Exist!!'));
            redirect('loungeM/addLounge/'.$facility_id);
        }
        else if($AddLounge == 1) {
            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
            redirect('loungeM/manageLounge/'.$facility_id);
        } else {
            $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
            redirect('loungeM/manageLounge/'.$facility_id);
        }
      }
    }
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-add');
    $this->load->view('admin/include/footer-new');
       
  } 

      
  /*  redirect to update lounge page
      called on: View/Edit button on manage Lounges
      view file name & path : admin/lounge/UpdateLounge
  */
  public function UpdateLounge() { 
    $id = $this->uri->segment(3);
    
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['title']         = 'Lounge Information | '.PROJECT_NAME; 
    
    $data['GetLounge']     = $this->LoungeModel->GetLoungeById($id); 
    $data['lastUpdate'] = $this->LoungeModel ->getLoungeLastUpdate($id, 1);

    $facility = $data['GetLounge']['facilityId'];
    
    $facilityData = $this->LoungeModel->GetFacilitiName($facility);
    $data['GetFacilities'] = $this->LoungeModel->GetFacilityByDistrict($facilityData['PRIDistrictCode']); 
    $data['district_id'] = $facilityData['PRIDistrictCode'];
    $data['GetDistrict'] = $this->FacilityModel->selectquery(); 
    $data['menuGroup'] = $this->LoungeModel->GetDataOrderByAsc('manageMenuGroupSetting', array('status' => 1), 'groupName');

    $GetLoungeMenuGroup = $this->LoungeModel->GetData('employeeMenuGroup', array('employeeId' => $id, 'userType'=>3, 'status' => 1));
      
    $key_arr = array();
    $data['key_arr'] = $key_arr;
    foreach ($GetLoungeMenuGroup as $key => $value) {
      $data['key_arr'][] = $value['groupId'];
    }
    
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-edit');
    $this->load->view('admin/include/footer-new');
  }


  public function getFacility(){
    if($this->input->post()){
      $district = $this->input->post('districtId');
      $facility = $this->input->post('facility');
      $getDistrict = $this->LoungeModel->GetFacilityByDistrict($district); 
      $html = ''; 
      if(!empty($getDistrict)){
        $html.='<option value="">Select Facility</option>';
        foreach ($getDistrict as $key => $value) {
          $Select = ($facility==$value['FacilityID'])?'SELECTED':'' ;
          $html.='<option value="'.$value['FacilityID'].'" '.$Select.'>'.$value['FacilityName'].'</option>';
        }
      } else {
        $html.='<option value="">No Records Found</option>';
      }
      echo $html;die;
    }
  }
        

  /*  post form url on UpdateLounge Page
      update lounge data
      after update redirect on manageLounge
  */
  public function UpdateLoungePost(){
    $id = $this->uri->segment(3);
    $facility_id = $this->uri->segment(4);
    $data = $this->input->post(); 
    $AddLounge = $this->LoungeModel->UpdateLounge($data,$id);

    if($AddLounge == 0){
      $this->session->set_flashdata('activate', getCustomAlert('W','IMEI Number Already Exist!!'));
      redirect('loungeM/manageLounge/'.$facility_id);
    }
    else if ($AddLounge == 1) {
      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
      redirect('loungeM/manageLounge/'.$facility_id);
    } else {
      $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
      redirect('loungeM/manageLounge/'.$facility_id);
    }
  }

             

  /*  post form url on loungeAmenities Page
      update lounge Amenities data
      after update redirect on manageLounge
  */
  public function updateLoungeAmenities() {
    $id = $this->uri->segment(3); 

    $facility_id = $this->uri->segment(4);
    $data= $this->input->post(); 
    $AddLounge = $this->LoungeModel->UpdateMoreLounge($data,$id);
         
    if ($AddLounge > 0) {
      $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
      redirect('loungeM/manageLounge/'.$facility_id);
    } else {
      $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
      redirect('loungeM/manageLounge/'.$facility_id);
    }
  }


  /*  redirect to Amenities for lounge page
      called on: Amenities button on manage lounges
      view file name & path : admin/lounge/loungeAmenities
  */
  public function loungeAmenities(){
    $id = $this->uri->segment(3);
    $facility_id = $this->uri->segment(4);
    $data['facility_id']   = $facility_id;
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['title']         = 'Lounge Amenities | '.PROJECT_NAME; 
    $data['GetFacilities'] = $this->LoungeModel->GetFacilities(); 
    $data['GetLounge']     = $this->LoungeModel->GetLoungeAmenitiesById($id); 
    $data['GetLoungeData'] = $this->LoungeModel->GetLoungeById($id); 
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-amenities');
    $this->load->view('admin/include/footer-new');
  }


  public function dutylistPage(){
    $loungeId = $this->uri->segment(3);
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['fileName']      = 'Duty_List';
    $data['title']         = 'Doctor Round Visit History | '.PROJECT_NAME; 
    $data['dutyData']      = $this->db->query("SELECT * FROM `doctorRound` INNER JOIN babyAdmission on `doctorRound`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId='".$loungeId."' ORDER BY doctorRound.`id` DESC")->result_array(); 
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/duty-list');
    $this->load->view('admin/include/footer-new');
     $this->load->view('admin/include/datatable-new');
  }


  //doctor visit details
  public function visitDetails(){
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['fileName']      = 'Lounge_List';
    $data['title']         = 'Visit Details | '.PROJECT_NAME; 
    $data['GetLounge']     = $this->LoungeModel->lounge(); 
    $this->load->view('admin/include/header',$data);
    $this->load->view('admin/include/dataTable');
    $this->load->view('admin/lounge/doctorVisitDetail');
    $this->load->view('admin/include/footer');
  }


  // checkExistImei 
  public function checkExistImei(){
    $pageType =  $this->input->post('pageType');
    $imei =  $this->input->post('imeiVal');
    if($pageType == 'add'){
      $checkVal = $this->db->get_where('loungeMaster',array('imeiNumber'=>$imei))->num_rows();
    }else{
      $loungeMasterId =  $this->input->post('loungeMasterId');
      $checkVal = $this->db->get_where('loungeMaster',array('loungeId != '=>$loungeMasterId,'imeiNumber'=>$imei))->num_rows();

    }
    echo $checkVal;exit();
  }  


  /*  redirect to Amenities for lounge page
      called on: Amenities button on manage lounges
      view file name & path : admin/lounge/loungeAssessment
  */
  public function loungeAssessment(){
    $id = $this->uri->segment(3);
    $facility_id = $this->uri->segment(4);
    $data['facility_id']   = $facility_id;
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['title']         = 'Lounge Assessment | '.PROJECT_NAME; 
    $data['fileName']      = 'Lounge_List';
    $data['GetAssessment'] = $this->LoungeModel->GetLoungeAssessment($id); 
    $data['GetLounge'] = $this->LoungeModel->GetLoungeById($id); 
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-assessment');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  /*  redirect to Amenities for lounge page
      called on: Amenities button on manage lounges
      view file name & path : admin/lounge/loungeBirthReview
  */
  public function loungeBirthReview(){
    $id = $this->uri->segment(3);
    $facility_id = $this->uri->segment(4);
    $data['facility_id']   = $facility_id;
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['title']         = 'Lounge Birth Review | '.PROJECT_NAME; 
    $data['fileName']      = 'Lounge_List';
    $data['GetBirthReview'] = $this->LoungeModel->GetLoungeBirthReview($id); 
    $data['GetLounge'] = $this->LoungeModel->GetLoungeById($id); 
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-birth-review');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function loungeServices(){
    $id = $this->uri->segment(3);
    $facility_id = $this->uri->segment(4);
    $data['facility_id']   = $facility_id;
    $data['index']         = 'lounge';
    $data['index2']        = '';
    $data['title']         = 'Lounge Services | '.PROJECT_NAME; 
    $data['fileName']      = 'Lounge_List';
    //$data['GetServices'] = $this->LoungeModel->GetLoungeServices($id); 
    
    $data['GetLounge'] = $this->LoungeModel->GetLoungeById($id);
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-services');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }
        

  public function loungeNurseCheckin(){
    $lounge_id = $this->uri->segment(3);
    $data['lounge_id']      = $lounge_id;
    $data['index']          = 'lounge';
    $data['index2']         = '';
    $data['title']          = 'Lounge Nurse Checkin | '.PROJECT_NAME; 
    $data['fileName']       = 'checkin_List';
    $data['GetCheckinData'] = $this->LoungeModel->loungeNurseCheckin($lounge_id);
    $data['GetLounge'] = $this->LoungeModel->GetLoungeById($lounge_id); 
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/lounge-nurse-checkin');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }


  public function nurseCheckIn(){
    $staff_id = $this->uri->segment(3);
    $data['staff_id']       = $staff_id;
    $data['index']          = 'lounge';
    $data['index2']         = '';
    $data['title']          = 'Nurse Checkin Data | '.PROJECT_NAME; 
    $data['fileName']       = 'checkin_List';
    $data['GetCheckinData'] = $this->LoungeModel->NurseCheckinAllData($staff_id); 
    $data['GetStaffData']   = $this->LoungeModel->getStaffById($staff_id); 
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/nurse-checkin');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }

  public function temporaryLounge(){
    $data['index']          = 'temporaryLounge';
    $data['index2']         = '';
    $data['fileName']       = 'Lounge_List';
    $data['title']          = 'Amenities Information | '.PROJECT_NAME; 

    if($_GET){
      $data['GetLounge'] = $this->LoungeModel->GetTempLoungeBySearch($_GET['district'], $_GET['facilityname'], $_GET['facility_status'], $_GET['keyword']);
    }
    else{
      $data['GetLounge']   = $this->LoungeModel->temporaryLounge();
    }

    $data['GetDistrict']   = $this->FacilityModel->selectquery(); 
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/temporary-lounge');
    $this->load->view('admin/include/footer-new');
    $this->load->view('admin/include/datatable-new');
  }

                   
  public function editTemporaryLounge(){
    $id = $this->uri->segment(3);
    
    $data['index']         = 'temporaryLounge';
    $data['index2']        = '';
    $data['title']         = 'Amenities Information | '.PROJECT_NAME; 

    // update temporary data
    if($this->input->post()){
      $updateTemporaryData = array(
                      'totalRecliningBeds'  => $this->input->post('totalRecliningBeds'),
                      'functionalRecliningBeds'     => $this->input->post('functionalRecliningBeds'),
                      'nonFunctionalRecliningBeds'  => $this->input->post('nonFunctionalRecliningBeds'),
                      'totalBedsideTable'   => $this->input->post('totalBedsideTable'),
                      'functionalBedsideTable'      => $this->input->post('functionalBedsideTable'),
                      'nonFunctionalBedsideTable'   => $this->input->post('nonFunctionalBedsideTable'),
                      'coloredBedsheetAvailability' => $this->input->post('coloredBedsheetAvailability'),
                      'totalColoredBedsheet' => $this->input->post('totalColoredBedsheet'),
                      'functionalColoredBedsheet'   => $this->input->post('functionalColoredBedsheet'),
                      'nonFunctionalColoredBedsheet'     => $this->input->post('nonFunctionalColoredBedsheet'),
                      'coloredBedsheetReason'       => $this->input->post('coloredBedsheetReason'),
                      'totalRecliningChair'         => $this->input->post('totalRecliningChair'),
                      'functionalRecliningChair'    => $this->input->post('functionalRecliningChair'),
                      'nonFunctionalRecliningChair' => $this->input->post('nonFunctionalRecliningChair'),
                      'nursingStationAvailability'  => $this->input->post('nursingStationAvailability'),
                      'totalNursingStation'         => $this->input->post('totalNursingStation'),
                      'functionalNursingStation'    => $this->input->post('functionalNursingStation'),
                      'nonFunctionalNursingStation' => $this->input->post('nonFunctionalNursingStation'),
                      'nursingStationReason'    => $this->input->post('nursingStationReason'),
                      'highStoolAvailability'   => $this->input->post('highStoolAvailability'),
                      'totalHighStool'          => $this->input->post('totalHighStool'),
                      'functionalHighStool'     => $this->input->post('functionalHighStool'),
                      'nonFunctionalHighStool'  => $this->input->post('nonFunctionalHighStool'),
                      'highStoolReason'         => $this->input->post('highStoolReason'),
                      'totalCubord'             => $this->input->post('totalCubord'),
                      'functionalCubord'        => $this->input->post('functionalCubord'),
                      'nonFunctionalCubord'     => $this->input->post('nonFunctionalCubord'),
                      'totalAC'       => $this->input->post('totalAC'),
                      'functionalAC'  => $this->input->post('functionalAC'),
                      'nonFunctionalAC'   => $this->input->post('nonFunctionalAC'),
                      'totalRoomHeater'         => $this->input->post('totalRoomHeater'),
                      'functionalRoomHeater'    => $this->input->post('functionalRoomHeater'),
                      'nonFunctionalRoomHeater' => $this->input->post('nonFunctionalRoomHeater'),
                      'totalDigitalWeigh'       => $this->input->post('totalDigitalWeigh'),
                      'functionalDigitalWeigh'  => $this->input->post('functionalDigitalWeigh'),
                      'nonFunctionalDigitalWeigh'   => $this->input->post('nonFunctionalDigitalWeigh'),
                      'totalFans'         => $this->input->post('totalFans'),
                      'functionalFans'    => $this->input->post('functionalFans'),
                      'nonFunctionalFans' => $this->input->post('nonFunctionalFans'),
                      'roomThermometerAvailability' => $this->input->post('roomThermometerAvailability'),
                      'totalRoomThermometer'        => $this->input->post('totalRoomThermometer'),
                      'functionalRoomThermometer'   => $this->input->post('functionalRoomThermometer'),
                      'nonFunctionalRoomThermometer'    => $this->input->post('nonFunctionalRoomThermometer'),
                      'roomThermometerReason'       => $this->input->post('roomThermometerReason'),
                      'maskSupplyAvailability'      => $this->input->post('maskSupplyAvailability'),
                      'powerBackupInverter'         => $this->input->post('powerBackupInverter'),
                      'powerBackupGenerator'    => $this->input->post('powerBackupGenerator'),
                      'powerBackupSolar' => $this->input->post('powerBackupSolar'),
                      'babyKitSupply'    => $this->input->post('babyKitSupply'),
                      'adultBlanketSupply'      => $this->input->post('adultBlanketSupply'),
                      'totalDigitalThermometer'          => $this->input->post('totalDigitalThermometer'),
                      'functionalDigitalThermometer'     => $this->input->post('functionalDigitalThermometer'),
                      'nonFunctionalDigitalThermometer'  => $this->input->post('nonFunctionalDigitalThermometer'),
                      'totalPulseOximeter'          => $this->input->post('totalPulseOximeter'),
                      'functionalPulseOximeter'          => $this->input->post('functionalPulseOximeter'),
                      'nonFunctionalPulseOximeter'       => $this->input->post('nonFunctionalPulseOximeter'),
                      'totalBPMonitor'     => $this->input->post('totalBPMonitor'),
                      'functionalBPMonitor'         => $this->input->post('functionalBPMonitor'),
                      'nonFunctionalBPMonitor'      => $this->input->post('nonFunctionalBPMonitor'),
                      'totalTV'         => $this->input->post('totalTV'),
                      'functionalTV'    => $this->input->post('functionalTV'),
                      'nonFunctionalTV'     => $this->input->post('nonFunctionalTV'),
                      'totalWallClock'      => $this->input->post('totalWallClock'),
                      'functionalWallClock'       => $this->input->post('functionalWallClock'),
                      'nonFunctionalWallClock'    => $this->input->post('nonFunctionalWallClock'),
                      'kmcRegisterAvailabilty'    => $this->input->post('kmcRegisterAvailabilty'),
                      //'verifiedMobile'    => $this->input->post('verifiedMobile'),
                      'modifyDate'      => date('Y-m-d H:i:s')
                       
              );
      $this->LoungeModel->updateData('temporaryLoungeMaster', $updateTemporaryData, array('id' => $id));
    }
    //update end

    $data['GetLounge']     = $this->LoungeModel->GetTemporaryLoungeById($id); 
   
    $loungeData = $data['GetLounge'];
    
    if($this->input->post()){ 
      $verification_status = $this->input->post('verification_status');
      $loungeId            = $this->input->post('loungeId');
      $reason = $this->input->post('reason');


      if($verification_status == 2){
        $checkIfExist = $this->LoungeModel->checkIfAmenitiesExist($loungeId); 

        if(!empty($checkIfExist)) {
          $insertData = array(
                            'totalRecliningBeds'  => $loungeData['totalRecliningBeds'], 
                            'functionalRecliningBeds'     => $loungeData['functionalRecliningBeds'], 
                            'nonFunctionalRecliningBeds'  => $loungeData['nonFunctionalRecliningBeds'], 
                            'totalBedsideTable'   => $loungeData['totalBedsideTable'], 
                            'functionalBedsideTable'      => $loungeData['functionalBedsideTable'], 
                            'nonFunctionalBedsideTable'   => $loungeData['nonFunctionalBedsideTable'], 
                            'coloredBedsheetAvailability' => $loungeData['coloredBedsheetAvailability'], 
                            'totalColoredBedsheet' => $loungeData['totalColoredBedsheet'], 
                            'functionalColoredBedsheet'   => $loungeData['functionalColoredBedsheet'], 
                            'nonFunctionalColoredBedsheet'     => $loungeData['nonFunctionalColoredBedsheet'], 
                            'coloredBedsheetReason'       => $loungeData['coloredBedsheetReason'], 
                            'totalRecliningChair'         => $loungeData['totalRecliningChair'], 
                            'functionalRecliningChair'    => $loungeData['functionalRecliningChair'], 
                            'nonFunctionalRecliningChair' => $loungeData['nonFunctionalRecliningChair'], 
                            'nursingStationAvailability'  => $loungeData['nursingStationAvailability'], 
                            'totalNursingStation'         => $loungeData['totalNursingStation'], 
                            'functionalNursingStation'    => $loungeData['functionalNursingStation'], 
                            'nonFunctionalNursingStation' => $loungeData['nonFunctionalNursingStation'], 
                            'nursingStationReason'    => $loungeData['nursingStationReason'], 
                            'highStoolAvailability'   => $loungeData['highStoolAvailability'], 
                            'totalHighStool'          => $loungeData['totalHighStool'], 
                            'functionalHighStool'     => $loungeData['functionalHighStool'], 
                            'nonFunctionalHighStool'  => $loungeData['nonFunctionalHighStool'], 
                            'highStoolReason'         => $loungeData['highStoolReason'], 
                            'totalCubord'             => $loungeData['totalCubord'],
                            'functionalCubord'        => $loungeData['functionalCubord'], 
                            'nonFunctionalCubord'     => $loungeData['nonFunctionalCubord'], 
                            'totalAC'       => $loungeData['totalAC'], 
                            'functionalAC'  => $loungeData['functionalAC'], 
                            'nonFunctionalAC'   => $loungeData['nonFunctionalAC'], 
                            'totalRoomHeater'         => $loungeData['totalRoomHeater'], 
                            'functionalRoomHeater'    => $loungeData['functionalRoomHeater'], 
                            'nonFunctionalRoomHeater' => $loungeData['nonFunctionalRoomHeater'], 
                            'totalDigitalWeigh'       => $loungeData['totalDigitalWeigh'], 
                            'functionalDigitalWeigh'  => $loungeData['functionalDigitalWeigh'], 
                            'nonFunctionalDigitalWeigh'   => $loungeData['nonFunctionalDigitalWeigh'], 
                            'totalFans'         => $loungeData['totalFans'], 
                            'functionalFans'    => $loungeData['functionalFans'], 
                            'nonFunctionalFans' => $loungeData['nonFunctionalFans'], 
                            'roomThermometerAvailability' => $loungeData['roomThermometerAvailability'], 
                            'totalRoomThermometer'        => $loungeData['totalRoomThermometer'], 
                            'functionalRoomThermometer'   => $loungeData['functionalRoomThermometer'], 
                            'nonFunctionalRoomThermometer'    => $loungeData['nonFunctionalRoomThermometer'], 
                            'roomThermometerReason'       => $loungeData['roomThermometerReason'], 
                            'maskSupplyAvailability'      => $loungeData['maskSupplyAvailability'], 
                            'powerBackupInverter'         => $loungeData['powerBackupInverter'], 
                            'powerBackupGenerator'    => $loungeData['powerBackupGenerator'], 
                            'powerBackupSolar' => $loungeData['powerBackupSolar'], 
                            'babyKitSupply'    => $loungeData['babyKitSupply'], 
                            'adultBlanketSupply'      => $loungeData['adultBlanketSupply'], 
                            'totalDigitalThermometer'          => $loungeData['totalDigitalThermometer'], 
                            'functionalDigitalThermometer'     => $loungeData['functionalDigitalThermometer'], 
                            'nonFunctionalDigitalThermometer'  => $loungeData['nonFunctionalDigitalThermometer'], 
                            'totalPulseOximeter'          => $loungeData['totalPulseOximeter'], 
                            'functionalPulseOximeter'          => $loungeData['functionalPulseOximeter'],
                            'nonFunctionalPulseOximeter'       => $loungeData['nonFunctionalPulseOximeter'], 
                            'totalBPMonitor'     => $loungeData['totalBPMonitor'], 
                            'functionalBPMonitor'         => $loungeData['functionalBPMonitor'], 
                            'nonFunctionalBPMonitor'      => $loungeData['nonFunctionalBPMonitor'], 
                            'totalTV'         => $loungeData['totalTV'], 
                            'functionalTV'    => $loungeData['functionalTV'], 
                            'nonFunctionalTV'     => $loungeData['nonFunctionalTV'], 
                            'totalWallClock'      => $loungeData['totalWallClock'], 
                            'functionalWallClock'       => $loungeData['functionalWallClock'], 
                            'nonFunctionalWallClock'    => $loungeData['nonFunctionalWallClock'], 
                            'kmcRegisterAvailabilty'    => $loungeData['kmcRegisterAvailabilty'], 
                            'verifiedMobile'    => $loungeData['verifiedMobile'], 
                            'modifyDate'      => date('Y-m-d H:i:s')
                             
                    );
            $amenitiesId = $this->LoungeModel->updateData('loungeAmenities', $insertData, array('loungeId' => $loungeId));
        } else {
            $insertData = array('loungeId'  => $loungeId, 
                            'totalRecliningBeds'  => $loungeData['totalRecliningBeds'], 
                            'functionalRecliningBeds'     => $loungeData['functionalRecliningBeds'], 
                            'nonFunctionalRecliningBeds'  => $loungeData['nonFunctionalRecliningBeds'], 
                            'totalBedsideTable'   => $loungeData['totalBedsideTable'], 
                            'functionalBedsideTable'      => $loungeData['functionalBedsideTable'], 
                            'nonFunctionalBedsideTable'   => $loungeData['nonFunctionalBedsideTable'], 
                            'coloredBedsheetAvailability' => $loungeData['coloredBedsheetAvailability'], 
                            'totalColoredBedsheet' => $loungeData['totalColoredBedsheet'], 
                            'functionalColoredBedsheet'   => $loungeData['functionalColoredBedsheet'], 
                            'nonFunctionalColoredBedsheet'     => $loungeData['nonFunctionalColoredBedsheet'], 
                            'coloredBedsheetReason'       => $loungeData['coloredBedsheetReason'], 
                            'totalRecliningChair'         => $loungeData['totalRecliningChair'], 
                            'functionalRecliningChair'    => $loungeData['functionalRecliningChair'], 
                            'nonFunctionalRecliningChair' => $loungeData['nonFunctionalRecliningChair'], 
                            'nursingStationAvailability'  => $loungeData['nursingStationAvailability'], 
                            'totalNursingStation'         => $loungeData['totalNursingStation'], 
                            'functionalNursingStation'    => $loungeData['functionalNursingStation'], 
                            'nonFunctionalNursingStation' => $loungeData['nonFunctionalNursingStation'], 
                            'nursingStationReason'    => $loungeData['nursingStationReason'], 
                            'highStoolAvailability'   => $loungeData['highStoolAvailability'], 
                            'totalHighStool'          => $loungeData['totalHighStool'], 
                            'functionalHighStool'     => $loungeData['functionalHighStool'], 
                            'nonFunctionalHighStool'  => $loungeData['nonFunctionalHighStool'], 
                            'highStoolReason'         => $loungeData['highStoolReason'], 
                            'totalCubord'             => $loungeData['totalCubord'],
                            'functionalCubord'        => $loungeData['functionalCubord'], 
                            'nonFunctionalCubord'     => $loungeData['nonFunctionalCubord'], 
                            'totalAC'       => $loungeData['totalAC'], 
                            'functionalAC'  => $loungeData['functionalAC'], 
                            'nonFunctionalAC'   => $loungeData['nonFunctionalAC'], 
                            'totalRoomHeater'         => $loungeData['totalRoomHeater'], 
                            'functionalRoomHeater'    => $loungeData['functionalRoomHeater'], 
                            'nonFunctionalRoomHeater' => $loungeData['nonFunctionalRoomHeater'], 
                            'totalDigitalWeigh'       => $loungeData['totalDigitalWeigh'], 
                            'functionalDigitalWeigh'  => $loungeData['functionalDigitalWeigh'], 
                            'nonFunctionalDigitalWeigh'   => $loungeData['nonFunctionalDigitalWeigh'], 
                            'totalFans'         => $loungeData['totalFans'], 
                            'functionalFans'    => $loungeData['functionalFans'], 
                            'nonFunctionalFans' => $loungeData['nonFunctionalFans'], 
                            'roomThermometerAvailability' => $loungeData['roomThermometerAvailability'], 
                            'totalRoomThermometer'        => $loungeData['totalRoomThermometer'], 
                            'functionalRoomThermometer'   => $loungeData['functionalRoomThermometer'], 
                            'nonFunctionalRoomThermometer'    => $loungeData['nonFunctionalRoomThermometer'], 
                            'roomThermometerReason'       => $loungeData['roomThermometerReason'], 
                            'maskSupplyAvailability'      => $loungeData['maskSupplyAvailability'], 
                            'powerBackupInverter'         => $loungeData['powerBackupInverter'], 
                            'powerBackupGenerator'    => $loungeData['powerBackupGenerator'], 
                            'powerBackupSolar' => $loungeData['powerBackupSolar'], 
                            'babyKitSupply'    => $loungeData['babyKitSupply'], 
                            'adultBlanketSupply'      => $loungeData['adultBlanketSupply'], 
                            'totalDigitalThermometer'          => $loungeData['totalDigitalThermometer'], 
                            'functionalDigitalThermometer'     => $loungeData['functionalDigitalThermometer'], 
                            'nonFunctionalDigitalThermometer'  => $loungeData['nonFunctionalDigitalThermometer'], 
                            'totalPulseOximeter'          => $loungeData['totalPulseOximeter'], 
                            'functionalPulseOximeter'          => $loungeData['functionalPulseOximeter'],
                            'nonFunctionalPulseOximeter'       => $loungeData['nonFunctionalPulseOximeter'], 
                            'totalBPMonitor'     => $loungeData['totalBPMonitor'], 
                            'functionalBPMonitor'         => $loungeData['functionalBPMonitor'], 
                            'nonFunctionalBPMonitor'      => $loungeData['nonFunctionalBPMonitor'], 
                            'totalTV'         => $loungeData['totalTV'], 
                            'functionalTV'    => $loungeData['functionalTV'], 
                            'nonFunctionalTV'     => $loungeData['nonFunctionalTV'], 
                            'totalWallClock'      => $loungeData['totalWallClock'], 
                            'functionalWallClock'       => $loungeData['functionalWallClock'], 
                            'nonFunctionalWallClock'    => $loungeData['nonFunctionalWallClock'], 
                            'kmcRegisterAvailabilty'    => $loungeData['kmcRegisterAvailabilty'], 
                            'verifiedMobile'    => $loungeData['verifiedMobile'], 
                            'addDate'         => date('Y-m-d H:i:s'), 
                            'modifyDate'      => date('Y-m-d H:i:s')
                    );
            $amenitiesId = $this->LoungeModel->insertData('loungeAmenities', $insertData);
        }

        $loginId = $this->session->userdata('adminData')['Id'];
        $loginType = $this->session->userdata('adminData')['Type'];
        $ip = $this->input->ip_address(); 

        $logData = array(   'loungeId'  => $loungeId, 
                            'totalRecliningBeds'  => $loungeData['totalRecliningBeds'], 
                            'functionalRecliningBeds'     => $loungeData['functionalRecliningBeds'], 
                            'nonFunctionalRecliningBeds'  => $loungeData['nonFunctionalRecliningBeds'], 
                            'totalBedsideTable'   => $loungeData['totalBedsideTable'], 
                            'functionalBedsideTable'      => $loungeData['functionalBedsideTable'], 
                            'nonFunctionalBedsideTable'   => $loungeData['nonFunctionalBedsideTable'], 
                            'coloredBedsheetAvailability' => $loungeData['coloredBedsheetAvailability'], 
                            'totalColoredBedsheet' => $loungeData['totalColoredBedsheet'], 
                            'functionalColoredBedsheet'   => $loungeData['functionalColoredBedsheet'], 
                            'nonFunctionalColoredBedsheet'     => $loungeData['nonFunctionalColoredBedsheet'], 
                            'coloredBedsheetReason'       => $loungeData['coloredBedsheetReason'], 
                            'totalRecliningChair'         => $loungeData['totalRecliningChair'], 
                            'functionalRecliningChair'    => $loungeData['functionalRecliningChair'], 
                            'nonFunctionalRecliningChair' => $loungeData['nonFunctionalRecliningChair'], 
                            'nursingStationAvailability'  => $loungeData['nursingStationAvailability'], 
                            'totalNursingStation'         => $loungeData['totalNursingStation'], 
                            'functionalNursingStation'    => $loungeData['functionalNursingStation'], 
                            'nonFunctionalNursingStation' => $loungeData['nonFunctionalNursingStation'], 
                            'nursingStationReason'    => $loungeData['nursingStationReason'], 
                            'highStoolAvailability'   => $loungeData['highStoolAvailability'], 
                            'totalHighStool'          => $loungeData['totalHighStool'], 
                            'functionalHighStool'     => $loungeData['functionalHighStool'], 
                            'nonFunctionalHighStool'  => $loungeData['nonFunctionalHighStool'], 
                            'highStoolReason'         => $loungeData['highStoolReason'], 
                            'totalCubord'             => $loungeData['totalCubord'],
                            'functionalCubord'        => $loungeData['functionalCubord'], 
                            'nonFunctionalCubord'     => $loungeData['nonFunctionalCubord'], 
                            'totalAC'       => $loungeData['totalAC'], 
                            'functionalAC'  => $loungeData['functionalAC'], 
                            'nonFunctionalAC'   => $loungeData['nonFunctionalAC'], 
                            'totalRoomHeater'         => $loungeData['totalRoomHeater'], 
                            'functionalRoomHeater'    => $loungeData['functionalRoomHeater'], 
                            'nonFunctionalRoomHeater' => $loungeData['nonFunctionalRoomHeater'], 
                            'totalDigitalWeigh'       => $loungeData['totalDigitalWeigh'], 
                            'functionalDigitalWeigh'  => $loungeData['functionalDigitalWeigh'], 
                            'nonFunctionalDigitalWeigh'   => $loungeData['nonFunctionalDigitalWeigh'], 
                            'totalFans'         => $loungeData['totalFans'], 
                            'functionalFans'    => $loungeData['functionalFans'], 
                            'nonFunctionalFans' => $loungeData['nonFunctionalFans'], 
                            'roomThermometerAvailability' => $loungeData['roomThermometerAvailability'], 
                            'totalRoomThermometer'        => $loungeData['totalRoomThermometer'], 
                            'functionalRoomThermometer'   => $loungeData['functionalRoomThermometer'], 
                            'nonFunctionalRoomThermometer'    => $loungeData['nonFunctionalRoomThermometer'], 
                            'roomThermometerReason'       => $loungeData['roomThermometerReason'], 
                            'maskSupplyAvailability'      => $loungeData['maskSupplyAvailability'], 
                            'powerBackupInverter'         => $loungeData['powerBackupInverter'], 
                            'powerBackupGenerator'    => $loungeData['powerBackupGenerator'], 
                            'powerBackupSolar' => $loungeData['powerBackupSolar'], 
                            'babyKitSupply'    => $loungeData['babyKitSupply'], 
                            'adultBlanketSupply'      => $loungeData['adultBlanketSupply'], 
                            'totalDigitalThermometer'          => $loungeData['totalDigitalThermometer'], 
                            'functionalDigitalThermometer'     => $loungeData['functionalDigitalThermometer'], 
                            'nonFunctionalDigitalThermometer'  => $loungeData['nonFunctionalDigitalThermometer'], 
                            'totalPulseOximeter'          => $loungeData['totalPulseOximeter'], 
                            'functionalPulseOximeter'          => $loungeData['functionalPulseOximeter'],
                            'nonFunctionalPulseOximeter'       => $loungeData['nonFunctionalPulseOximeter'], 
                            'totalBPMonitor'     => $loungeData['totalBPMonitor'], 
                            'functionalBPMonitor'         => $loungeData['functionalBPMonitor'], 
                            'nonFunctionalBPMonitor'      => $loungeData['nonFunctionalBPMonitor'], 
                            'totalTV'         => $loungeData['totalTV'], 
                            'functionalTV'    => $loungeData['functionalTV'], 
                            'nonFunctionalTV'     => $loungeData['nonFunctionalTV'], 
                            'totalWallClock'      => $loungeData['totalWallClock'], 
                            'functionalWallClock'       => $loungeData['functionalWallClock'], 
                            'nonFunctionalWallClock'    => $loungeData['nonFunctionalWallClock'], 
                            'kmcRegisterAvailabilty'    => $loungeData['kmcRegisterAvailabilty'], 
                            'addDate'         => date('Y-m-d H:i:s'), 
                            'addedBy'         => $loginId,
                            'addedByType'     => $loginType,
                            'ipAddress'       => $ip,
                    );
        $this->LoungeModel->insertData('loungeAmenitiesLog', $logData);

        $sms_message = 'All the Amenities Information Provided by you are upto the mark and approved by the team, the data has been saved sucessfully.';
      }

      if($verification_status == 3) {
        $sms_message = 'All the Amenities Information Provided by you are not correct and Rejected by the team. Kindly recheck the data and submit the form again.';
      }

      if(!empty($loungeData['verifiedMobile'])){
        sendMobileMessage($loungeData['verifiedMobile'],$sms_message);
      }

      $updateData =array(
                      'status'          => $verification_status,
                      'reason'          => $reason,
                      'modifyDate'      => date('Y-m-d H:i:s')
                  ); 
      $res1 = $this->LoungeModel->updateData('temporaryLoungeMaster', $updateData, array('id' => $loungeData['id']));
      
      if ($res1 > 0) {
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been updated successfully.'));
        redirect('loungeM/temporaryLounge');
      } else {
        $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
        redirect('loungeM/temporaryLounge');
      }
    }
    
    $this->load->view('admin/include/header-new',$data);
    $this->load->view('admin/lounge/update-temporary-lounge');
    $this->load->view('admin/include/footer-new');
  }

}
?>
