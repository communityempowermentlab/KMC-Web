<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrationManagement extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('FacilityModel');
      $this->load->model('StaffModel');  
      $this->load->model('LoungeModel');  
      $this->load->model('UserModel');
  }

  
 
 // Add facility
 public function AddFacility($insert =''){
 
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['title']         = 'Add Facility | '.PROJECT_NAME; 
    $data['NewBorn']       = $this->FacilityModel->NewBornCareUnit(); 
    $data['Management']    = $this->FacilityModel->ManagementType(); 
    $data['GovtORNot']     = $this->FacilityModel->GovtORNot(); 
    $data['GetLounge']     = $this->FacilityModel->lounge(); 
    $data['GetFacilities'] = $this->FacilityModel->GetTempFacilities(); 
    $data['FacilityType']= $this->FacilityModel->GetFacilities2('2'); 
    
    $data['selectquery'] = $this->FacilityModel->selectquery(); 
    
    $data['selectCountry'] = $this->FacilityModel->selectCountry(); 

    $data['District']    = $this->FacilityModel->selectquery(); 

    $data['GetStaffType']  = $this->StaffModel->GetStaffType();
    $data['GetJobType'] = $this->StaffModel->GetJobType();

    $data['tab_id'] = $this->input->get('tab_id');
    $data['admin_settings'] = $this->db->get_where('settings')->row_array();
    
      if($insert=='') { 
         
          $this->load->view('admin/facility/RegisterFacility', $data);
         
      } else{ 
          $Form_Data = $this->input->post();
          $inserted = $this->FacilityModel->InsertFacility($Form_Data); 

          if($inserted >0) {

            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
              redirect('facility/manageFacility');

          } else {

            $this->session->set_flashdata('activate', getCustomAlert('W','Oops Something Went Worng. Please Try Again.'));
              redirect('facility/manageFacility');

          }
      }
  }

  // Add Staff
 public function AddStaff($insert =''){
 
    $data['index']         = 'facilities';
    $data['index2']        = '';
    $data['title']         = 'Add Facility | '.PROJECT_NAME; 
    $data['NewBorn']       = $this->FacilityModel->NewBornCareUnit(); 
    $data['Management']    = $this->FacilityModel->ManagementType(); 
    $data['GovtORNot']     = $this->FacilityModel->GovtORNot(); 
    $data['GetLounge']     = $this->FacilityModel->lounge(); 
    $data['GetFacilities'] = $this->FacilityModel->GetTempFacilities(); 
    $data['FacilityType']= $this->FacilityModel->GetFacilities2('2'); 
    
    $data['selectquery'] = $this->FacilityModel->selectquery(); 
    
    $data['selectCountry'] = $this->FacilityModel->selectCountry(); 

    $data['District']    = $this->FacilityModel->selectquery(); 

    $data['GetStaffType']  = $this->StaffModel->GetStaffType();
    $data['GetJobType'] = $this->StaffModel->GetJobType();

    $data['tab_id'] = $this->input->get('tab_id');
    $data['admin_settings'] = $this->db->get_where('settings')->row_array();
    
      if($insert=='') { 
         
          $this->load->view('admin/facility/RegisterStaff', $data);
         
      } else{ 
          $Form_Data = $this->input->post();
          $inserted = $this->FacilityModel->InsertFacility($Form_Data); 

          if($inserted >0) {

            $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
              redirect('facility/manageFacility');

          } else {

            $this->session->set_flashdata('activate', getCustomAlert('W','Oops Something Went Worng. Please Try Again.'));
              redirect('facility/manageFacility');

          }
      }
  }


  public function getBlock($id = '', $block_id='', $type ='') {
    if ($this->input->post()) {
      $id = $this->input->post('id');
      $block_id = $this->input->post('block_id');
      $type = $this->input->post('type');
      $distData = $this->FacilityModel->selectBlock($id, $block_id,$type);
      
      $set_html_cont = '<option value=""></option>';       

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
      
      $distData = $this->FacilityModel->selectVillageByDistrict($id); 
      
      $set_html_cont = '<option value=""></option>';       

      foreach ($distData as $value) {

        
        $set_html_cont.= '<option value= "'.$value['GPPRICode'].'">'.$value['GPNameProperCase'].'</option>';
        
      }
      print_r($set_html_cont);
    }
  }

  public function getVillage($id = '', $GP_code='', $type ='') {
    if ($this->input->post()) {
      $id = $this->input->post('id');
      $GP_code = $this->input->post('GP_code');
      $type = $this->input->post('type');

      $villData = $this->FacilityModel->selectVillage($id, $GP_code,$type);

      
      $set_html_cont = '<option value=""></option>';       

      foreach ($villData as $value) {
         $Select = ($GP_code==$value['GPPRICode'])?'SELECTED':'' ;
          $set_html_cont.= '<option value= "'.$value['GPPRICode'].'" '.$Select.' >'.$value['GPNameProperCase'].'</option>'; 
      }
      print_r($set_html_cont);
      die();

    }
  }


  public function saveFacility(){
    if ($this->input->post()) {
      
      $facility_name  = ($this->input->post('facility_name')!='') ? $this->input->post('facility_name'):NULL;
      $facility_type  = ($this->input->post('facility_type')!='') ? $this->input->post('facility_type'):NULL;
      $nbcu           = ($this->input->post('nbcu')!='') ? $this->input->post('nbcu'):NULL;
      $govt_or_not    = ($this->input->post('govt_or_not')!='') ? $this->input->post('govt_or_not'):NULL;
      $startDate      = ($this->input->post('startDate')!='') ? $this->input->post('startDate'):NULL;
      $district       = ($this->input->post('district')!='') ? $this->input->post('district'):NULL;
      $block          = ($this->input->post('block')!='') ? $this->input->post('block'):NULL;
      $village        = ($this->input->post('village')!='') ? $this->input->post('village'):NULL;
      $address        = ($this->input->post('address')!='') ? $this->input->post('address'):NULL;
      $moic_name      = ($this->input->post('moic_name')!='') ? $this->input->post('moic_name'):NULL;
      $moic_number    = ($this->input->post('moic_number')!='') ? $this->input->post('moic_number'):NULL;

      $insertArray    = array('PRIBlockCode'    => $block,
                              'FacilityTypeID'  => $facility_type,
                              'NCUType'         => $nbcu,
                              'FacilityName'    => $facility_name,
                              'Address'         => $address,
                              'GPPRICode'       => $village,
                              'KMCUnitStartedOn'  => $startDate,
                              'GOVT_NonGOVT'      => $govt_or_not,
                              'StateID'           => 38,
                              'CountryID'         => 101,
                              'PRIDistrictCode'   => $district,
                              'CMSOrMOICName'     => $moic_name,
                              'CMSOrMOICMoblie'   => $moic_number,
                              'Status'            => 1,
                              'AddDate'           => date('Y-m-d H:i:s'),
                              'ModifyDate'        => date('Y-m-d H:i:s')
                             );

      $res = $this->FacilityModel->insertData('temporaryFacilityList', $insertArray);
      if($res == 1){
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
        redirect('RegistrationManagement/AddFacility?tab_id=1');
      }
    }
  }


  public function saveLounge(){
    if ($this->input->post()) { 
      $district_id  = $this->input->post('district_id');
      $lounge_facility  = ($this->input->post('lounge_facility')!='') ? $this->input->post('lounge_facility'):NULL;
      $lounge_id      = ($this->input->post('lounge_id')!='') ? $this->input->post('lounge_id'):NULL;
      $mobile_verify      = ($this->input->post('mobile_verify')!='') ? $this->input->post('mobile_verify'):NULL;
      
      $bed_total_number = ($this->input->post('bed_total_number')!='') ? $this->input->post('bed_total_number'):NULL;
      $bed_functional   = ($this->input->post('bed_functional')!='') ? $this->input->post('bed_functional'):NULL;
      $bed_non_functional   = ($this->input->post('bed_non_functional')!='') ? $this->input->post('bed_non_functional'):NULL;
      $table_total_number   = ($this->input->post('table_total_number')!='') ? $this->input->post('table_total_number'):NULL;
      $table_functional     = ($this->input->post('table_functional')!='') ? $this->input->post('table_functional'):NULL;
      $table_non_functional = ($this->input->post('table_non_functional')!='') ? $this->input->post('table_non_functional'):NULL;
      $bedsheet_option      = ($this->input->post('bedsheet_option')!='') ? $this->input->post('bedsheet_option'):NULL;
      $bedsheet_total_number  = ($this->input->post('bedsheet_option')==1) ? $this->input->post('bedsheet_total_number'):NULL;
      $bedsheet_functional    = ($this->input->post('bedsheet_option')==1) ? $this->input->post('bedsheet_functional'):NULL;
      $bedsheet_non_functional   = ($this->input->post('bedsheet_option')==1) ? $this->input->post('bedsheet_non_functional'):NULL;
      $bedsheet_reason      = ($this->input->post('bedsheet_option')!=1) ? $this->input->post('bedsheet_reason'):NULL;
      $chair_total_number   = ($this->input->post('chair_total_number')!='') ? $this->input->post('chair_total_number'):NULL;
      $chair_functional     = ($this->input->post('chair_functional')!='') ? $this->input->post('chair_functional'):NULL;
      $chair_non_functional = ($this->input->post('chair_non_functional')!='') ? $this->input->post('chair_non_functional'):NULL;
      $nurse_table_option   = ($this->input->post('nurse_table_option')!='') ? $this->input->post('nurse_table_option'):NULL;
      $nurse_table_total_number   = ($this->input->post('nurse_table_option')==1) ? $this->input->post('nurse_table_total_number'):NULL;
      $nurse_table_functional     = ($this->input->post('nurse_table_option')==1) ? $this->input->post('nurse_table_functional'):NULL;
      $nurse_table_non_functional      = ($this->input->post('nurse_table_option')==1) ? $this->input->post('nurse_table_non_functional'):NULL;
      $nurse_table_reason   = ($this->input->post('nurse_table_option')!=1) ? $this->input->post('nurse_table_reason'):NULL;
      $highstool_option     = ($this->input->post('highstool_option')!='') ? $this->input->post('highstool_option'):NULL;
      $highstool_total_number = ($this->input->post('highstool_option')==1) ? $this->input->post('highstool_total_number'):NULL;
      $highstool_functional   = ($this->input->post('highstool_option')==1) ? $this->input->post('highstool_functional'):NULL;

      $highstool_non_functional = ($this->input->post('highstool_option')==1) ? $this->input->post('highstool_non_functional'):NULL;
      $highstool_reason   = ($this->input->post('highstool_option')!=1) ? $this->input->post('highstool_reason'):NULL;
      $cubord_total_number   = ($this->input->post('cubord_total_number')!='') ? $this->input->post('cubord_total_number'):NULL;
      $cubord_functional   = ($this->input->post('cubord_functional')!='') ? $this->input->post('cubord_functional'):NULL;
      $cubord_non_functional     = ($this->input->post('cubord_non_functional')!='') ? $this->input->post('cubord_non_functional'):NULL;
      $ac_total_number    = ($this->input->post('ac_total_number')!='') ? $this->input->post('ac_total_number'):NULL;
      $ac_functional      = ($this->input->post('ac_functional')!='') ? $this->input->post('ac_functional'):NULL;
      $ac_non_functional  = ($this->input->post('ac_non_functional')!='') ? $this->input->post('ac_non_functional'):NULL;
      $room_heater_total_number       = ($this->input->post('room_heater_total_number')!='') ? $this->input->post('room_heater_total_number'):NULL;
      $room_heater_functional         = ($this->input->post('room_heater_functional')!='') ? $this->input->post('room_heater_functional'):NULL;
      $room_heater_non_functional     = ($this->input->post('room_heater_non_functional')!='') ? $this->input->post('room_heater_non_functional'):NULL;
      $weighing_scale_total_number    = ($this->input->post('weighing_scale_total_number')!='') ? $this->input->post('weighing_scale_total_number'):NULL;
      $weighing_scale_functional      = ($this->input->post('weighing_scale_functional')!='') ? $this->input->post('weighing_scale_functional'):NULL;
      $weighing_scale_non_functional  = ($this->input->post('weighing_scale_non_functional')!='') ? $this->input->post('weighing_scale_non_functional'):NULL;
      $fan_total_number     = ($this->input->post('fan_total_number')!='') ? $this->input->post('fan_total_number'):NULL;
      $fan_functional       = ($this->input->post('fan_functional')!='') ? $this->input->post('fan_functional'):NULL;
      $fan_non_functional   = ($this->input->post('fan_non_functional')!='') ? $this->input->post('fan_non_functional'):NULL;
      $thermometer_option   = ($this->input->post('thermometer_option')!='') ? $this->input->post('thermometer_option'):NULL;
      $thermometer_total_number     = ($this->input->post('thermometer_total_number')!='') ? $this->input->post('thermometer_total_number'):NULL;
      $thermometer_functional       = ($this->input->post('thermometer_functional')!='') ? $this->input->post('thermometer_functional'):NULL;
      $thermometer_non_functional   = ($this->input->post('thermometer_non_functional')!='') ? $this->input->post('thermometer_non_functional'):NULL;
      $thermometer_reason     = ($this->input->post('thermometer_reason')!='') ? $this->input->post('thermometer_reason'):NULL;
      $mask_supply_option     = ($this->input->post('mask_supply_option')!='') ? $this->input->post('mask_supply_option'):NULL;
      $inverter       = ($this->input->post('inverter')!='') ? $this->input->post('inverter'):NULL;
      $generator      = ($this->input->post('generator')!='') ? $this->input->post('generator'):NULL;
      $solar          = ($this->input->post('solar')!='') ? $this->input->post('solar'):NULL;

      $babykit_supply_option    = ($this->input->post('babykit_supply_option')!='') ? $this->input->post('babykit_supply_option'):NULL;
      $blanket_supply_option    = ($this->input->post('blanket_supply_option')!='') ? $this->input->post('blanket_supply_option'):NULL;
      $digital_thermo_total_number    = ($this->input->post('digital_thermo_total_number')!='') ? $this->input->post('digital_thermo_total_number'):NULL;
      $digital_thermo_functional      = ($this->input->post('digital_thermo_functional')!='') ? $this->input->post('digital_thermo_functional'):NULL;
      $digital_thermo_non_functional  = ($this->input->post('digital_thermo_non_functional')!='') ? $this->input->post('digital_thermo_non_functional'):NULL;
      $oximeter_total_number    = ($this->input->post('oximeter_total_number')!='') ? $this->input->post('oximeter_total_number'):NULL;
      $oximeter_functional      = ($this->input->post('oximeter_functional')!='') ? $this->input->post('oximeter_functional'):NULL;
      $oximeter_non_functional  = ($this->input->post('oximeter_non_functional')!='') ? $this->input->post('oximeter_non_functional'):NULL;
      $bp_total_number  = ($this->input->post('bp_total_number')!='') ? $this->input->post('bp_total_number'):NULL;
      $bp_functional    = ($this->input->post('bp_functional')!='') ? $this->input->post('bp_functional'):NULL;
      $bp_non_functional    = ($this->input->post('bp_non_functional')!='') ? $this->input->post('bp_non_functional'):NULL;

      $tv_total_number      = ($this->input->post('tv_total_number')!='') ? $this->input->post('tv_total_number'):NULL;
      $tv_functional        = ($this->input->post('tv_functional')!='') ? $this->input->post('tv_functional'):NULL;
      $tv_non_functional    = ($this->input->post('tv_non_functional')!='') ? $this->input->post('tv_non_functional'):NULL;
      $clock_total_number   = ($this->input->post('clock_total_number')!='') ? $this->input->post('clock_total_number'):NULL;
      $clock_functional     = ($this->input->post('clock_functional')!='') ? $this->input->post('clock_functional'):NULL;
      $clock_non_functional = ($this->input->post('clock_non_functional')!='') ? $this->input->post('clock_non_functional'):NULL;
      $kmc_register         = ($this->input->post('kmc_register')!='') ? $this->input->post('kmc_register'):NULL;


     $insertArray    = array('facilityId'      => $lounge_facility,
                              'loungeId'        => $lounge_id,
                              'verifiedMobile'  => $mobile_verify,
                              'totalRecliningBeds'              => $bed_total_number,
                              'functionalRecliningBeds'         => $bed_functional,
                              'nonFunctionalRecliningBeds'      => $bed_non_functional,
                              'totalBedsideTable'               => $table_total_number,
                              'functionalBedsideTable'          => $table_functional,
                              'nonFunctionalBedsideTable'       => $table_non_functional,
                              'coloredBedsheetAvailability'     => $bedsheet_option,
                              'totalColoredBedsheet'            => $bedsheet_total_number,
                              'functionalColoredBedsheet'       => $bedsheet_functional,
                              'nonFunctionalColoredBedsheet'    => $bedsheet_non_functional,
                              'coloredBedsheetReason'           => $bedsheet_reason,
                              'totalRecliningChair'             => $chair_total_number,
                              'functionalRecliningChair'        => $chair_functional,
                              'nonFunctionalRecliningChair'     => $chair_non_functional,
                              'nursingStationAvailability'      => $nurse_table_option,
                              'totalNursingStation'             => $nurse_table_total_number,
                              'functionalNursingStation'        => $nurse_table_functional,
                              'nonFunctionalNursingStation'     => $nurse_table_non_functional,
                              'nursingStationReason'            => $nurse_table_reason,
                              'highStoolAvailability'           => $highstool_option,
                              'totalHighStool'                  => $highstool_total_number,
                              'functionalHighStool'             => $highstool_functional,
                              'nonFunctionalHighStool'          => $highstool_non_functional,
                              'highStoolReason'                 => $highstool_reason,
                              'totalCubord'                     => $cubord_total_number,
                              'functionalCubord'                => $cubord_functional,
                              'nonFunctionalCubord'             => $cubord_non_functional,
                              'totalAC'                         => $ac_total_number,
                              'functionalAC'                    => $ac_functional,
                              'nonFunctionalAC'                 => $ac_non_functional,
                              'totalRoomHeater'                 => $room_heater_total_number,
                              'functionalRoomHeater'            => $room_heater_functional,
                              'nonFunctionalRoomHeater'         => $room_heater_non_functional,
                              'totalDigitalWeigh'               => $weighing_scale_total_number,
                              'functionalDigitalWeigh'          => $weighing_scale_functional,
                              'nonFunctionalDigitalWeigh'       => $weighing_scale_non_functional,
                              'totalFans'                       => $fan_total_number,
                              'functionalFans'                  => $fan_functional,
                              'nonFunctionalFans'               => $fan_non_functional,
                              'roomThermometerAvailability'     => $thermometer_option,
                              'totalRoomThermometer'            => $thermometer_total_number,
                              'functionalRoomThermometer'       => $thermometer_functional,
                              'nonFunctionalRoomThermometer'    => $thermometer_non_functional,
                              'roomThermometerReason'           => $thermometer_reason,
                              'maskSupplyAvailability'          => $mask_supply_option,
                              'powerBackupInverter'             => $inverter,
                              'powerBackupGenerator'            => $generator,
                              'powerBackupSolar'                => $solar,
                              'babyKitSupply'                   => $babykit_supply_option,
                              'adultBlanketSupply'              => $blanket_supply_option,
                              'totalDigitalThermometer'         => $digital_thermo_total_number,
                              'functionalDigitalThermometer'    => $digital_thermo_functional,
                              'nonFunctionalDigitalThermometer' => $digital_thermo_non_functional,
                              'totalPulseOximeter'              => $oximeter_total_number,
                              'functionalPulseOximeter'         => $oximeter_functional,
                              'nonFunctionalPulseOximeter'      => $oximeter_non_functional,
                              'totalBPMonitor'                  => $bp_total_number,
                              'functionalBPMonitor'             => $bp_functional,
                              'nonFunctionalBPMonitor'          => $bp_non_functional,
                              'totalTV'                         => $tv_total_number,
                              'functionalTV'                    => $tv_functional,
                              'nonFunctionalTV'                 => $tv_non_functional,
                              'totalWallClock'                  => $clock_total_number,
                              'functionalWallClock'             => $clock_functional,
                              'nonFunctionalWallClock'          => $clock_non_functional,
                              'kmcRegisterAvailabilty'          => $kmc_register,
                              'status'                          => 1,
                              'AddDate'           => date('Y-m-d H:i:s'),
                              'ModifyDate'        => date('Y-m-d H:i:s')
                             );
 

$SQL = "select * from temporaryLoungeMaster where status='1' AND loungeId=$lounge_id AND facilityId=$lounge_facility";
$qu = $this->db->query($SQL);

if($qu->num_rows() > 0)
{
  $this->session->set_flashdata('activate', getCustomAlert('W','Your previous submitted information is still in review stage.'));
  redirect('RegistrationManagement/AddFacility');  
}
else{

      $res = $this->FacilityModel->insertData('temporaryLoungeMaster', $insertArray);

      $districtData = $this->FacilityModel->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs', $district_id);
      $facilityData = $this->LoungeModel->GetFacilitiName($lounge_facility);

      // send message
      $message = 'Thank you, Lounge Amenities Information has been Added Successfully. You will be updated once the approval is done.';
      sendMobileMessage($mobile_verify, $message);

      // send war room sms
      $settingData = $this->db->get_where('settings', array('id' => 1))->row_array();
      if(($settingData['warRoomAlertAmenities'] == "1") && (!empty($settingData['warRoomAlertAmenitiesMobiles']))){
          $explodeMobile = explode(",",$settingData['warRoomAlertAmenitiesMobiles']);
          $alertSms = 'Lounge amenities information has been updated Successfully for '.$districtData['DistrictNameProperCase'].', '.$facilityData['FacilityName'].'';

          if(!empty($explodeMobile)){
              foreach($explodeMobile as $explodeMobileNumber){
                  if(!empty($explodeMobileNumber)){
                    sendMobileMessage($explodeMobileNumber, $alertSms);
                  }
              }
          }
      }

      // save notification
      $this->db->order_by('id','desc');
      $lastID = $this->db->get_where('temporaryLoungeMaster')->row_array();

      $notification_text = "<span class='text-bold-500'>".$districtData['DistrictNameProperCase'].", ".$facilityData['FacilityName']."</span> has updated its lounge amenities information.";
      $notification_url = base_url()."loungeM/editTemporaryLounge/".$lastID['id'];
      $notification = array();
      $notification['type']           = 2;
      $notification['text']           = $notification_text;
      $notification['id']             = $lastID['id'];
      $notification['url']            = $notification_url;
      $this->saveNotification($notification);


      if($res == 1){
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
        redirect('RegistrationManagement/AddFacility');
      }
    }
  }
}

  public function saveNotification($data){
      $notification = array();
      $notification['type']           = $data['type'];
      $notification['text']           = $data['text'];
      $notification['status']         = 1;
      $notification['addDate']        = date('Y-m-d H:i:s');
      $notification['modifyDate']     = date('Y-m-d H:i:s');
      $notification['tableId']        = $data['id'];
      $notification['url']            = $data['url'];
      $this->db->insert('adminNotification', $notification);
  }


  public function saveStaff(){
    if ($this->input->post()) { 
      $staff_district_id   = ($this->input->post('staff_facility')!='') ? $this->input->post('staff_district_id'):NULL;
      $staff_facility   = ($this->input->post('staff_facility')!='') ? $this->input->post('staff_facility'):NULL;
      $staff_name       = ($this->input->post('staff_name')!='') ? $this->input->post('staff_name'):NULL;
      $mobile_number    = ($this->input->post('mobile_number')!='') ? $this->input->post('mobile_number'):NULL;
      $emergency_number = ($this->input->post('emergency_number')!='') ? $this->input->post('emergency_number'):NULL;
      $staff_type       = ($this->input->post('staff_type')!='') ? $this->input->post('staff_type'):NULL;
      $staff_sub_type   = ($this->input->post('staff_sub_type')!='') ? $this->input->post('staff_sub_type'):NULL;
      $staffSubTypeOther   = ($this->input->post('staff_sub_type_other')!='') ? $this->input->post('staff_sub_type_other'):NULL;
      if($this->input->post('staff_sub_type_val') == "")
      {
        $job_type         = ($this->input->post('job_type')!='') ? $this->input->post('job_type'):NULL;
      }
      else
      {
        $job_type         = ($this->input->post('job_type1')!='') ? $this->input->post('job_type1'):NULL;
      }

      $staff_address    = ($this->input->post('staff_address')!='') ? $this->input->post('staff_address'):NULL;
      $mobile_verify_staff       = ($this->input->post('mobile_verify_staff')!='') ? $this->input->post('mobile_verify_staff'):NULL;
      // $staff_gender     = ($this->input->post('staff_gender')!='') ? $this->input->post('staff_gender'):NULL;
      // $staff_experiance = ($this->input->post('staff_experiance')!='') ? $this->input->post('staff_experiance'):NULL;

      if($_FILES['staff_photo']['name']){ 
        $fileName   = $_FILES['staff_photo']['name'];
        $extension  = explode('.',$fileName);
        $extension  = strtolower(end($extension));
        $uniqueName = time().'.'.$extension;
        $tmp_name   = $_FILES['staff_photo']['tmp_name'];
        $targetlocation = $_SERVER['DOCUMENT_ROOT']."/".folderName."/assets/nurse/".$uniqueName; 
        $InsertImg = utf8_encode(trim($uniqueName));
        move_uploaded_file($tmp_name,$targetlocation);
      } else {
        $InsertImg = NULL;
      }


      $insertArray    = array('facilityId'      => $staff_facility,
                              'name'            => $staff_name,
                              'staffType'       => $staff_type,
                              'staffSubType'    => $staff_sub_type,
                              'staffSubTypeOther' => $staffSubTypeOther,
                              'staffMobileNumber'     => $mobile_number,
                              'profilePicture'        => $InsertImg,
                              'emergencyContactNumber'    => $emergency_number,
                              'jobType'                 => $job_type,
                              'staffAddress'            => $staff_address,
                              'verifiedMobile'            => $mobile_verify_staff,
                              // 'gender'         => $staff_gender,
                              // 'totalWorkingExperiance'    => $staff_experiance,
                              'status'                => 1,
                              'addDate'               => date('Y-m-d H:i:s'),
                              'modifyDate'            => date('Y-m-d H:i:s')
                             );

      $res = $this->FacilityModel->insertData('temporaryStaffMaster', $insertArray);

      $districtData = $this->FacilityModel->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs', $staff_district_id);
      $facilityData = $this->LoungeModel->GetFacilitiName($staff_facility);

      // send message
      //$message = 'Thank You. Staff information has been saved successfully.';
      $message = 'Thank you, The Staff Information has been Added Successfully. You will be updated once the approval is done.';
      sendMobileMessage($mobile_verify_staff, $message);

      // send war room sms
      $settingData = $this->db->get_where('settings', array('id' => 1))->row_array();
      if(($settingData['warRoomAlertStaff'] == "1") && (!empty($settingData['warRoomAlertStaffMobiles']))){
          $explodeMobile = explode(",",$settingData['warRoomAlertStaffMobiles']);
          $alertSms = 'A new Staff information has been added Successfully for '.$districtData['DistrictNameProperCase'].', '.$facilityData['FacilityName'].'';

          if(!empty($explodeMobile)){
              foreach($explodeMobile as $explodeMobileNumber){
                  if(!empty($explodeMobileNumber)){
                    sendMobileMessage($explodeMobileNumber, $alertSms);
                  }
              }
          }
      }

      // save notification
      $this->db->order_by('staffId','desc');
      $lastID = $this->db->get_where('temporaryStaffMaster')->row_array();

      $notification_text = "<span class='text-bold-500'>".$districtData['DistrictNameProperCase'].", ".$facilityData['FacilityName']."</span> has updated new staff details.";
      $notification_url = base_url()."staffM/editTemporaryStaff/".$lastID['staffId'];
      $notification = array();
      $notification['type']           = 3;
      $notification['text']           = $notification_text;
      $notification['id']             = $lastID['staffId'];
      $notification['url']            = $notification_url;
      $this->saveNotification($notification);

      if($res == 1){
        $this->session->set_flashdata('activate', getCustomAlert('S','Data has been Added successfully.'));
        redirect('RegistrationManagement/AddStaff');
      }

    }
  }


  public function checkFacilityExist(){
    if ($this->input->post()) {
      $val = $this->input->post('val');
      $condition = array('FacilityName' => $val );
      $res = $this->FacilityModel->checkData('temporaryFacilityList', $condition);
      if($res != 0){
        echo '2';
      } else {
        echo '1';
      }
    }
  }


  public function checkLoungeExists(){
    if ($this->input->post()) {
      $val = $this->input->post('val');
      $condition = array('loungeName' => $val );
      $res = $this->FacilityModel->checkData('temporaryLoungeMaster', $condition);
      if($res != 0){
        echo '2';
      } else {
        echo '1';
      }
    }
  }

  public function checkStaffMobile(){
    if ($this->input->post()) {
      $val = $this->input->post('val');
      $condition = array('staffMobileNumber' => $val );
      $res = $this->FacilityModel->checkData('temporaryStaffMaster', $condition);
      if($res != 0){
        echo '2';
      } else {
        echo '1';
      }
    }
  }


  public function getFacility(){
    if($this->input->post()){
      $district = $this->input->post('districtId');
      $facility = $this->input->post('facility');
      $getDistrict = $this->LoungeModel->GetFacilityByDistrict($district); 
      $html = ''; 
      if(!empty($getDistrict)){
        $html.='<option value=""></option>';
        foreach ($getDistrict as $key => $value) {
          $Select = ($facility==$value['FacilityID'])?'SELECTED':'' ;
          $html.='<option value="'.$value['FacilityID'].'" '.$Select.'>'.$value['FacilityName'].'</option>';
        }
      } else {
        $html.='<option value=""></option>';
        $html.='<option value="0">No Records Found</option>';
      }
      echo $html;die;
    }
  }




public function getStaffTypeList() {
    $table = $this->input->post('table');
    $id = $this->input->post('id');
    $sub_staff_type = $this->input->post('sub_staff_type');
    if ($id != ''){
      $update_status = $this->UserModel->getStaffTypeList($table,$id);
      $set_html_cont1 = "";
      $set_html_cont = '<option value=""></option>';   
     
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
    }
  else {
      $set_html_cont = '<option value=""></option>'; 
      print_r($set_html_cont);
      die();
    }
  } 



  public function getLounge(){
    if($this->input->post()){
      $facility_id = $this->input->post('facility_id');
      
      $getLounge = $this->LoungeModel->GetLoungeByFAcility($facility_id); 
      $html = ''; 
      if(!empty($getLounge)){
        $html.='<option value=""></option>';
        foreach ($getLounge as $key => $value) {
          
          $html.='<option value="'.$value['loungeId'].'">'.$value['loungeName'].'</option>';
        }
      } else {
        $html.='<option value=""></option>';
        $html.='<option value="0">No Records Found</option>';
      }
      echo $html;die;
    }
  }


  


  public function getLastUpdate(){
    if($this->input->post()){
      $lounge_id    = $this->input->post('lounge_id');
      $facility_id  = $this->input->post('facility_id');

      $getPendingDataQuery = "select * from temporaryLoungeMaster where status='1' AND loungeId=$lounge_id AND facilityId=$facility_id";
      $getPendingData = $this->db->query($getPendingDataQuery)->row_array();
      
      if(!empty($getPendingData))
      {
        $flag = 2;
        $last_update = "Your last submitted form at ".date("d F, Y h:i A",strtotime($get_last_update['modifyDate']))." has not approved yet.";
      }
      else
      {
        $get_last_update = $this->UserModel->getAmenitiesLastUpdate($lounge_id);
        $get_setting  = $this->db->get_where('settings',array('id'=>1))->row_array();
        $no_of_days   = $get_setting['amenitiesValueUpdation'];
        $flag = 0;
        $last_update = "";
        if(!empty($get_last_update)) {
          $now = time(); // or your date as well
          $your_date = strtotime($get_last_update['modifyDate']);
          $datediff = $now - $your_date;

          $diff = round($datediff / (60 * 60 * 24));

          if($diff > $no_of_days) {
            $flag = 1;
            $last_update = "Last Updated On : ".date("d F, Y h:i A",strtotime($get_last_update['modifyDate'])); 
          }else{

            $nextDateForUpdate = date('d F, Y', strtotime($get_last_update['modifyDate']. '+ '.$no_of_days. ' days'));

            $last_update .= "Last Updated On : ".date("d F, Y h:i A",strtotime($get_last_update['modifyDate']))."<br/>"; 
            $last_update .= "You can update amenities information after ".$nextDateForUpdate;
          }

        } else{
          $flag = 1;
        }
      }
      $result = json_encode(array('result1'=>$flag,'result2'=>$last_update));
      echo $result;die;
    }
  }


  public function sendOTP(){
    if($this->input->post()){
      $mobile    = $this->input->post('mobile');
      $random = mt_rand(100000, 999999);

      $data = array('mobile'  => $mobile,
                    'otp'     => $random,
                    'addDate'     => date('Y-m-d H:i:s')
                    );

      $this->db->insert('otpVerification',$data);
      $id = $this->db->insert_id();

      //$message = 'Hello User, Your OTP is: '.$random.' Thanks CEL Team';
      $message = 'Your OTP to validate your mobile number is '.$random.''.'. Please enter the number and complete the verification process. Do not share this code with anyone and kindly complete the process within 15 minutes.';

      sendMobileMessage($mobile, $message);
      echo $id;die;
    }
  }


  public function resendOTP(){
    if($this->input->post()){
      $id    = $this->input->post('id');
      $mobile    = $this->input->post('mobile');
      $random = mt_rand(100000, 999999);

      $data = array(
                    'otp'     => $random
                  );

      $this->db->where(array('id' => $id));
      $this->db->update('otpVerification',$data);

      //$message = 'Hello User, Your OTP is: '.$random.' Thanks CEL Team';
      $message = 'Your OTP to validate your mobile number is '.$random.''.'. Please enter the number and complete the verification process. Do not share this code with anyone and kindly complete the process within 15 minutes.';

      sendMobileMessage($mobile, $message);
      echo 1;die;
    }
  }


  public function verifyOTP(){
    if($this->input->post()){
      $id    = $this->input->post('id');
      $mobile    = $this->input->post('mobile');
      $otp = $this->input->post('otp');
      
      $get_otp  = $this->db->get_where('otpVerification',array('id'=>$id))->row_array();

      $chk_otp = $get_otp['otp'];

      if($otp == $chk_otp){
        echo 1;die;
      } else {
        echo 0;die;
      }
    }
  }
        
}
?>
