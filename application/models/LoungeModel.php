<?php
class LoungeModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  // get data from loungeMaster via facilityId
  public function lounge(){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = 'where loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    return $this->db->query("SELECT * From loungeMaster ".$where_lounge." ORDER BY loungeId desc")->result_array();
  }

  public function GetData($table, $cond){
    return $this->db->get_where($table, $cond)->result_array();
  }

  public function GetDataOrderByAsc($table, $cond, $col){
    $this->db->order_by($col, "ASC");
    return $this->db->get_where($table, $cond)->result_array();
  }

  public function GetLoungeByDistrict($district){
    return $this->db->query("SELECT loungeMaster.* From loungeMaster inner join facilitylist on loungeMaster.`facilityId` = facilitylist.`FacilityID` where facilitylist.`PRIDistrictCode` = ".$district." ORDER BY loungeId desc")->result_array();
  }

  public function GetLoungeByKeyword($keyword){
    return $this->db->query("SELECT loungeMaster.* From loungeMaster inner join facilitylist on loungeMaster.`facilityId` = facilitylist.`FacilityID` where loungeMaster.`loungeName` Like '%{$keyword}%' OR loungeMaster.`loungeContactNumber` Like '%{$keyword}%' OR facilitylist.`FacilityName` Like '%{$keyword}%' ORDER BY loungeId desc")->result_array();
  }

  public function GetLoungeByKeywordDistrict($district, $keyword){
    return $this->db->query("SELECT loungeMaster.* From loungeMaster inner join facilitylist on loungeMaster.`facilityId` = facilitylist.`FacilityID` where facilitylist.`PRIDistrictCode` = ".$district." AND (loungeMaster.`loungeName` Like '%{$keyword}%' OR loungeMaster.`loungeContactNumber` Like '%{$keyword}%' OR facilitylist.`FacilityName` Like '%{$keyword}%') ORDER BY loungeId desc")->result_array();
  }

  public function GetActiveLoungeBySearch($district, $facilityname, $keyword){

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";

    $where = "";$where1 = "";$where2 = "";$where3 = "";$and_cond = "";
    if(!empty($district)){
      $where1 = "facilitylist.`PRIDistrictCode` = ".$district."";
      $and_cond = "AND";
    }
    if(!empty($facilityname)){
      $where2 = $and_cond." facilitylist.`FacilityID` = ".$facilityname."";
      $and_cond = "AND";
    }
    if(!empty($keyword)){
      $where3 = $and_cond." (loungeMaster.`loungeName` Like '%{$keyword}%' OR loungeMaster.`loungeContactNumber` Like '%{$keyword}%' OR facilitylist.`FacilityName` Like '%{$keyword}%')";
      $and_cond = "AND";
    }
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = $and_cond.' loungeMaster.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    if(!empty($where1) || !empty($where2) || !empty($where3) || !empty($where_lounge)){
      $where = "where";
    }

    return $this->db->query("SELECT loungeMaster.* From loungeMaster inner join facilitylist on loungeMaster.`facilityId` = facilitylist.`FacilityID` $where $where1 $where2 $where3 $where_lounge ORDER BY loungeMaster.loungeId desc")->result_array();
  }

  // update lounge data via loungeId
  public function UpdateLounge($data,$id){
    $array                                 = array();
    $array['isMNCUUnitPart']               = $data['isMNCUUnitPart'];
    $array['loungeName']                   = $data['lounge_name'];
    $array['loungeContactNumber']          = $data['lounge_contact_number'];
    $array['facilityId']                   = $data['facilityname'];
    $array['lounge_notification']          = $data['lounge_notification'];

    $getOldData = $this->db->get_where('loungeMaster', array('loungeId'=>$id))->row_array();

    $array['address']         = $data['address'];
    $array['imeiNumber']      = ($data['imeiNumber']!='') ? $data['imeiNumber']:NULL;
    $array['status']          = $data['status'];

    if($data['imeiNumber'] != ''){
        $checkImeiDuplicate = $this->checkImeiNumber($data['imeiNumber'],1,$id);
        if($checkImeiDuplicate > 0) {
         return 0;
        }
    }

    $formattedAddr                        = str_replace(' ','+',$data['address']);
    $geocodeFromAddr                      = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');

    $output = json_decode($geocodeFromAddr); 

    // $dlat  = $output->results[0]->geometry->location->lat; 
    // $dlong = $output->results[0]->geometry->location->lng;

    if(!empty($dlat) && !empty($output))
    {
      $array['latitude']                 = $dlat;
      $array['longitude']                = $dlong;
    }
    else{
      $array['latitude']                 = "0";
      $array['longitude']                = "0";
    }

    if (!empty($data['lounge_password'])){
      $array['loungePassword']          = md5($data['lounge_password']);
    } 
    $array['addDate']                     = date('Y-m-d H:i:s');
    $array['modifyDate']                  = date('Y-m-d H:i:s');

    $this->db->where('loungeId',$id);
    $this->db->update('loungeMaster',$array);

    // update menu group
    $menu_group           = $data['menu_group'];

    $this ->db->where(array('employeeId'=>$id,'userType'=>3));
    $this ->db->delete('employeeMenuGroup');
    if(!empty($menu_group)){
      foreach ($menu_group as $key => $value) {
        $insertMenuData   = array( 
                                'employeeId'    => $id,
                                'userType'      => 3,
                                'groupId'       => $value,
                                'status'        => 1,
                                'addDate'       => date('Y-m-d H:i:s'),
                                'modifyDate'    => date('Y-m-d H:i:s')
                           );
        $this->db->insert('employeeMenuGroup', $insertMenuData);
      }
    }
    
    // log data
    $logData = array();
    
    $loginId = $this->session->userdata('adminData')['Id'];
    $ip = $this->input->ip_address(); 
    $type = $this->session->userdata('adminData')['Type'];

    $logData['tableReference']        = 2;
    $logData['tableReferenceId']      = $id;
    $logData['updatedBy']             = $loginId;
    $logData['type']                  = $type;
    $logData['deviceInfo']            = $ip;
    
    $logData['addDate']               = date('Y-m-d H:i:s');
    $logData['lastSyncedTime']        = date('Y-m-d H:i:s');

    

    if($getOldData['loungeName'] != $data['lounge_name']) {
      $logData['columnName']           = 'Lounge Name / Number';
      $logData['oldValue']             = $getOldData['loungeName'];
      $logData['newValue']             = $data['lounge_name'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['isMNCUUnitPart'] != $data['isMNCUUnitPart']) {
      $logData['columnName']           = 'KMC Lounge is part of MNCU unit?';
      $logData['oldValue']             = $getOldData['isMNCUUnitPart'];
      $logData['newValue']             = $data['isMNCUUnitPart'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['loungeContactNumber'] != $data['lounge_contact_number']) {
      $logData['columnName']           = 'Lounge Mobile Number';
      $logData['oldValue']             = $getOldData['loungeContactNumber'];
      $logData['newValue']             = $data['lounge_contact_number'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['facilityId'] != $data['facilityname']) {
      $logData['columnName']           = 'Facility';
      $logData['oldValue']             = $getOldData['facilityId'];
      $logData['newValue']             = $data['facilityname'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['address'] != $data['address']) {
      $logData['columnName']           = 'Lounge Location / Address';
      $logData['oldValue']             = $getOldData['address'];
      $logData['newValue']             = $data['address'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['imeiNumber'] != $data['imeiNumber']) {
      $logData['columnName']           = 'TAB Unique Number';
      $logData['oldValue']             = $getOldData['imeiNumber'];
      $logData['newValue']             = $data['imeiNumber'];

      $this->db->insert('logData',$logData);
    }

    if($getOldData['status'] != $data['status']) {
      $logData['columnName']           = 'Status';
      $logData['oldValue']             = $getOldData['status'];
      $logData['newValue']             = $data['status'];

      $this->db->insert('logData',$logData);
    }

    if(!empty($data['lounge_password'])) { 
      if(md5($getOldData['loungePassword']) != md5($data['lounge_password'])) {
        $logData['columnName']           = 'Lounge Password';
        $logData['oldValue']             = md5($getOldData['loungePassword']);
        $logData['newValue']             = md5($data['lounge_password']);

        $this->db->insert('logData',$logData);
      }
    }
    
    return 1;
  }

  // update lounge specific data according to condition via loungeId
  public function UpdateMoreLounge($data,$id){ 
    $chkIfExist = $this->db->get_where('loungeAmenities', array('loungeId'=>$id))->num_rows();

    $array                                    = array();
    $logArray                                 = array();
    $array['loungeId']          = $logArray['loungeId']       = $id;
    $array['totalRecliningBeds']          = $logArray['totalRecliningBeds']       = ($data['bed_total_number']!='') ? $data['bed_total_number']:NULL;
    $array['functionalRecliningBeds']     = $logArray['functionalRecliningBeds']  = ($data['bed_functional']!='') ? $data['bed_functional']:NULL;
    $array['nonFunctionalRecliningBeds']  = $logArray['nonFunctionalRecliningBeds']  = ($data['bed_non_functional']!='') ? $data['bed_non_functional']:NULL;

    $array['totalBedsideTable']           = $logArray['totalBedsideTable']  = ($data['table_total_number']!='') ? $data['table_total_number']:NULL;
    $array['functionalBedsideTable']      = $logArray['functionalBedsideTable']     = ($data['table_functional']!='') ? $data['table_functional']:NULL;
    $array['nonFunctionalBedsideTable']   = $logArray['nonFunctionalBedsideTable']  = ($data['table_non_functional']!='') ? $data['table_non_functional']:NULL;

    $array['coloredBedsheetAvailability'] = $logArray['coloredBedsheetAvailability']  = ($data['bedsheet_option']!='') ? $data['bedsheet_option']:NULL;
    $array['totalColoredBedsheet']        = $logArray['totalColoredBedsheet']         = ($data['bedsheet_option']==1) ? $data['bedsheet_total_number']:NULL;
    $array['functionalColoredBedsheet']   = $logArray['functionalColoredBedsheet']    = ($data['bedsheet_option']==1) ? $data['bedsheet_functional']:NULL;
    $array['nonFunctionalColoredBedsheet'] = $logArray['nonFunctionalColoredBedsheet']  = ($data['bedsheet_option']==1) ? $data['bedsheet_non_functional']:NULL;
    $array['coloredBedsheetReason']        = $logArray['coloredBedsheetReason']         = ($data['bedsheet_option']!=1) ? $data['bedsheet_reason']:NULL;

    $array['totalRecliningChair']          = $logArray['totalRecliningChair']           = ($data['chair_total_number']!='') ? $data['chair_total_number']:NULL;
    $array['functionalRecliningChair']     = $logArray['functionalRecliningChair']      = ($data['chair_functional']!='') ? $data['chair_functional']:NULL;
    $array['nonFunctionalRecliningChair']  = $logArray['nonFunctionalRecliningChair']   = ($data['chair_non_functional']!='') ? $data['chair_non_functional']:NULL;

    $array['nursingStationAvailability']   = $logArray['nursingStationAvailability']   = ($data['nurse_table_option']!='') ? $data['nurse_table_option']:NULL;
    $array['totalNursingStation']          = $logArray['totalNursingStation']   = ($data['nurse_table_option']==1) ? $data['nurse_table_total_number']:NULL;
    $array['functionalNursingStation']     = $logArray['functionalNursingStation']   = ($data['nurse_table_option']==1) ? $data['nurse_table_functional']:NULL;
    $array['nonFunctionalNursingStation']  = $logArray['nonFunctionalNursingStation']   = ($data['nurse_table_option']==1) ? $data['nurse_table_non_functional']:NULL;
    $array['nursingStationReason']         = $logArray['nursingStationReason']   = ($data['nurse_table_option']!=1) ? $data['nurse_table_reason']:NULL;

    $array['highStoolAvailability']        = $logArray['highStoolAvailability']   = ($data['highstool_option']!='') ? $data['highstool_option']:NULL;
    $array['totalHighStool']               = $logArray['totalHighStool']   = ($data['highstool_option']==1) ? $data['highstool_total_number']:NULL;
    $array['functionalHighStool']          = $logArray['functionalHighStool']   = ($data['highstool_option']==1) ? $data['highstool_functional']:NULL;
    $array['nonFunctionalHighStool']       = $logArray['nonFunctionalHighStool']   = ($data['highstool_option']==1) ? $data['highstool_non_functional']:NULL;
    $array['highStoolReason']              = $logArray['highStoolReason']   = ($data['highstool_option']!=1) ? $data['highstool_reason']:NULL;

    $array['totalCubord']                  = $logArray['totalCubord']   = ($data['cubord_total_number']!='') ? $data['cubord_total_number']:NULL;
    $array['functionalCubord']             = $logArray['functionalCubord']   = ($data['cubord_functional']!='') ? $data['cubord_functional']:NULL;
    $array['nonFunctionalCubord']          = $logArray['nonFunctionalCubord']   = ($data['cubord_non_functional']!='') ? $data['cubord_non_functional']:NULL;

    $array['totalAC']                      = $logArray['totalAC']   = ($data['ac_total_number']!='') ? $data['ac_total_number']:NULL;
    $array['functionalAC']                 = $logArray['functionalAC']   = ($data['ac_functional']!='') ? $data['ac_functional']:NULL;
    $array['nonFunctionalAC']              = $logArray['nonFunctionalAC']   = ($data['ac_non_functional']!='') ? $data['ac_non_functional']:NULL;

    $array['totalRoomHeater']              = $logArray['totalRoomHeater']   = ($data['room_heater_total_number']!='') ? $data['room_heater_total_number']:NULL;
    $array['functionalRoomHeater']         = $logArray['functionalRoomHeater']   = ($data['room_heater_functional']!='') ? $data['room_heater_functional']:NULL;
    $array['nonFunctionalRoomHeater']      = $logArray['nonFunctionalRoomHeater']   = ($data['room_heater_non_functional']!='') ? $data['room_heater_non_functional']:NULL;

    $array['totalDigitalWeigh']            = $logArray['totalDigitalWeigh']   = ($data['weighing_scale_total_number']!='') ? $data['weighing_scale_total_number']:NULL;
    $array['functionalDigitalWeigh']       = $logArray['functionalDigitalWeigh']   = ($data['weighing_scale_functional']!='') ? $data['weighing_scale_functional']:NULL;
    $array['nonFunctionalDigitalWeigh']    = $logArray['nonFunctionalDigitalWeigh']   = ($data['weighing_scale_non_functional']!='') ? $data['weighing_scale_non_functional']:NULL;

    $array['totalFans']                    = $logArray['totalFans']   = ($data['fan_total_number']!='') ? $data['fan_total_number']:NULL;
    $array['functionalFans']               = $logArray['functionalFans']   = ($data['fan_functional']!='') ? $data['fan_functional']:NULL;
    $array['nonFunctionalFans']            = $logArray['nonFunctionalFans']   = ($data['fan_non_functional']!='') ? $data['fan_non_functional']:NULL;

    $array['roomThermometerAvailability']  = $logArray['roomThermometerAvailability']   = ($data['thermometer_option']!='') ? $data['thermometer_option']:NULL;
    $array['totalRoomThermometer']         = $logArray['totalRoomThermometer']   = ($data['thermometer_option']==1) ? $data['thermometer_total_number']:NULL;
    $array['functionalRoomThermometer']    = $logArray['functionalRoomThermometer']   = ($data['thermometer_option']==1) ? $data['thermometer_functional']:NULL;
    $array['nonFunctionalRoomThermometer'] = $logArray['nonFunctionalRoomThermometer']   = ($data['thermometer_option']==1) ? $data['thermometer_non_functional']:NULL;
    $array['roomThermometerReason']        = $logArray['roomThermometerReason']   = ($data['thermometer_option']!=1) ? $data['thermometer_reason']:NULL;


    $array['maskSupplyAvailability']       = $logArray['maskSupplyAvailability']    = ($data['mask_supply_option']!='') ? $data['mask_supply_option']:NULL;
    $array['powerBackupInverter']          = $logArray['powerBackupInverter']    = (isset($data['inverter'])) ? $data['inverter']:NULL;
    $array['powerBackupGenerator']         = $logArray['powerBackupGenerator']    = (isset($data['generator'])) ? $data['generator']:NULL;
    $array['powerBackupSolar']             = $logArray['powerBackupSolar']    = (isset($data['solar'])) ? $data['solar']:NULL;
    $array['babyKitSupply']                = $logArray['babyKitSupply']    = ($data['babykit_supply_option']!='') ? $data['babykit_supply_option']:NULL;
    $array['adultBlanketSupply']           = $logArray['adultBlanketSupply']    = ($data['blanket_supply_option']!='') ? $data['blanket_supply_option']:NULL;

    $array['totalDigitalThermometer']       = $logArray['totalDigitalThermometer']   = ($data['digital_thermo_total_number']!='') ? $data['digital_thermo_total_number']:NULL;
    $array['functionalDigitalThermometer']  = $logArray['functionalDigitalThermometer']   = ($data['digital_thermo_functional']!='') ? $data['digital_thermo_functional']:NULL;
    $array['nonFunctionalDigitalThermometer'] = $logArray['nonFunctionalDigitalThermometer']  = ($data['digital_thermo_non_functional']!='') ? $data['digital_thermo_non_functional']:NULL;

    $array['totalPulseOximeter']            = $logArray['totalPulseOximeter']  = ($data['oximeter_total_number']!='') ? $data['oximeter_total_number']:NULL;
    $array['functionalPulseOximeter']       = $logArray['functionalPulseOximeter']  = ($data['oximeter_functional']!='') ? $data['oximeter_functional']:NULL;
    $array['nonFunctionalPulseOximeter']    = $logArray['nonFunctionalPulseOximeter']  = ($data['oximeter_non_functional']!='') ? $data['oximeter_non_functional']:NULL;

    $array['totalBPMonitor']                = $logArray['totalBPMonitor']  = ($data['bp_total_number']!='') ? $data['bp_total_number']:NULL;
    $array['functionalBPMonitor']           = $logArray['functionalBPMonitor']  = ($data['bp_functional']!='') ? $data['bp_functional']:NULL;
    $array['nonFunctionalBPMonitor']        = $logArray['nonFunctionalBPMonitor']  = ($data['bp_non_functional']!='') ? $data['bp_non_functional']:NULL;

    $array['totalTV']                       = $logArray['totalTV']    = ($data['tv_total_number']!='') ? $data['tv_total_number']:NULL;
    $array['functionalTV']                  = $logArray['functionalTV']    = ($data['tv_functional']!='') ? $data['tv_functional']:NULL;
    $array['nonFunctionalTV']               = $logArray['nonFunctionalTV']    = ($data['tv_non_functional']!='') ? $data['tv_non_functional']:NULL;

    $array['totalWallClock']                = $logArray['totalWallClock']  = ($data['clock_total_number']!='') ? $data['clock_total_number']:NULL;
    $array['functionalWallClock']           = $logArray['functionalWallClock']  = ($data['clock_functional']!='') ? $data['clock_functional']:NULL;
    $array['nonFunctionalWallClock']        = $logArray['nonFunctionalWallClock']  = ($data['clock_non_functional']!='') ? $data['clock_non_functional']:NULL;

    $array['kmcRegisterAvailabilty']        = $logArray['kmcRegisterAvailabilty']  = ($data['kmc_register']!='') ? $data['kmc_register']:NULL;
    $array['modifyDate']                    = $logArray['addDate']  = date('Y-m-d H:i:s');

    $loginId = $this->session->userdata('adminData')['Id'];
    $ip = $this->input->ip_address(); 

    $logArray['ipAddress']  = $ip;
    $logArray['addedBy']  = $loginId;

    if($chkIfExist == 0){
      $array['addDate']                       = date('Y-m-d H:i:s');
      $this->db->insert('loungeAmenities', $array); 
    } else {
      $this->db->where('loungeId',$id);
      $this->db->update('loungeAmenities',$array);
    }
     
    $this->db->insert('loungeAmenitiesLog', $logArray); 

    return 1;
  }

  // get data from facilitylist where FacilityName!=''
  public function GetFacilities(){
    return $this->db->query("SELECT * FROM `facilitylist` where FacilityName!='' ORDER BY `FacilityName` ASC")->result_array();
  }

  // get data from facilitylist via FacilityID
  public function GetFacilitiName($FacilityID){
    return $this->db->query("SELECT * FROM `facilitylist` where FacilityID = ".$FacilityID)->row_array();
  }

  // get data from loungeMaster via LoungeID
  public function GetLoungeById($id){
    return $this->db->get_where('loungeMaster', array('loungeId'=>$id))->row_array();
  }

  // get data from loungeMaster via LoungeID
  public function GetLoungeAmenitiesById($id){
    return $this->db->get_where('loungeAmenities', array('loungeId'=>$id))->row_array();
  }


  // insert data into loungeMaster 
  public function AddLounge($data=''){ 
    $array  = array();
    $array['type']            = 2;
    $array['loungeName']      = $data['lounge_name'];
    $array['isMNCUUnitPart']      = $data['isMNCUUnitPart'];
    $array['loungeContactNumber'] = ($data['lounge_contact_number']!='') ? $data['lounge_contact_number']:NULL;
    $array['loungePassword']  = md5($data['lounge_password']);
    $array['facilityId']      = $data['facility_id'];
    $array['address']         = $data['address'];
    $array['imeiNumber']      = ($data['imeiNumber']!='') ? $data['imeiNumber']:NULL;
    if($data['imeiNumber']!=''){
        $checkImeiDuplicate = $this->checkImeiNumber($data['imeiNumber']);
        if($checkImeiDuplicate > 0) {
         return 0;
        }
    }
    $formattedAddr                        = str_replace(' ','+',$data['address']);
    $geocodeFromAddr                      = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');

    $output = json_decode($geocodeFromAddr); 

    // $dlat  = $output->results[0]->geometry->location->lat; 
    // $dlong = $output->results[0]->geometry->location->lng;

    if(!empty($dlat) && !empty($output))
    {
      $array['latitude']                 = $dlat;
      $array['longitude']                = $dlong;
    }
    else{
      $array['latitude']                 = "0";
      $array['longitude']                = "0";
    }


    $array['status']          = 1;
    $array['addDate']         = date('Y-m-d H:i:s');
    $array['modifyDate']      = date('Y-m-d H:i:s');
    $insert = $this->db->insert('loungeMaster', $array); 
    $loungeId = $this->db->insert_id();

    // insert menu group
    $menu_group             = $data['menu_group'];
    if(!empty($menu_group)){
      foreach ($menu_group as $key => $group_value) {
        $insertMenuData   = array( 
                                'employeeId'    => $loungeId,
                                'userType'      => 3,
                                'groupId'       => $group_value,
                                'status'        => 1,
                                'addDate'       => date('Y-m-d H:i:s'),
                                'modifyDate'    => date('Y-m-d H:i:s')
                           );
        $this->db->insert('employeeMenuGroup', $insertMenuData);
      }
    }

    return 1;
  }


  // check IMEI Number Duplicacy
  public function checkImeiNumber($imeiNumber,$status='',$id=''){
    if($status == 1){
      return $this->db->query("select * from loungeMaster where loungeId != ".$id." and imeiNumber=".$imeiNumber."")->num_rows();
    }else{
      return $this->db->get_where('loungeMaster', array('imeiNumber'=>$imeiNumber))->num_rows();
    }
  }


  public function GetLoungeAssessment($loungeId){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('loungeAssessment', array('loungeId'=>$loungeId))->result_array();
  }


  public function GetLoungeBirthReview($loungeId){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('loungeBirthReview', array('loungeId'=>$loungeId))->result_array();
  }

  public function GetLoungeServices($loungeId){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('loungeServices', array('loungeId'=>$loungeId))->result_array();
  }

  public function GetLoungeServicesByDate($date,$shift,$loungeId){
    $this->db->where('DATE(addDate)', $date);
    $this->db->order_by("id", "desc");
    return $this->db->get_where('loungeServices', array('shift'=>$shift,'loungeId'=>$loungeId))->row_array();
  }

  public function GetLoungeLog($loungeId){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('loungeMasterLog', array('loungeId'=>$loungeId))->result_array();
  }

  public function GetLastAmenitiesLog($loungeId){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('loungeAmenitiesLog', array('loungeId'=>$loungeId))->row_array();
  }

  public function GetAmenitiesLog($loungeId){
    $this->db->order_by("id", "desc");
    return $this->db->get_where('loungeAmenitiesLog', array('loungeId'=>$loungeId))->result_array();
  }


  public function getStaffById($staffId){
    return $this->db->get_where('staffMaster', array('staffId'=>$staffId))->row_array();
  }

  public function GetAvailableStaff($loungeId){
    return $this->db
        ->distinct()
        ->select('staffMaster.*')
        ->from('staffMaster')
        ->join('nurseDutyChange','staffMaster.staffId=nurseDutyChange.nurseId')
        ->where(array('nurseDutyChange.loungeId' => $loungeId, 'nurseDutyChange.type' => 1))
        ->get()
        ->result_array();
  }

  public function loungeNurseCheckin($loungeId){
    // $staff = $this->db
    //                 ->select('staffMaster.*')
    //                 ->order_by("staffMaster.name", "asc")
    //                 ->from('staffMaster')
    //                 ->join('loungeMaster','staffMaster.facilityId=loungeMaster.facilityId')
    //                 ->where(array('loungeMaster.loungeId' => $loungeId, 'staffMaster.staffType' => 2))
    //                 ->get()
    //                 ->result_array();

    // foreach ($staff as $key => $value) {
    //     $getLastCheckin = $this->db
    //                             ->select('*')
    //                             ->order_by("id", "desc")
    //                             ->from('nurseDutyChange')
    //                             ->where(array('loungeId' => $loungeId, 'nurseId' => $value['staffId']))
    //                             ->get()
    //                             ->row_array();
    //     $staff[$key]['checkin'] = $getLastCheckin;
    // }

    $this->db->select("nurseDutyChange.*,staffMaster.name as nurseName, staffMaster.staffId");
    $this->db->join('staffMaster','staffMaster.staffId=nurseDutyChange.nurseId');
    $this->db->order_by('nurseDutyChange.id','desc');
    $dutyList = $this->db->get_where($this->db->dbprefix('nurseDutyChange'), array('nurseDutyChange.loungeId'=>$loungeId))->result_array();

    return $dutyList;
  }

  public function getNurseFeelingsData($staffId){
    $getLastCheckin = $this->db
                                ->select('*')
                                ->order_by("id", "desc")
                                ->from('nurseDutyChange')
                                ->where(array('nurseId' => $staffId))
                                ->get()
                                ->result_array();
    $happy = 0;$fine = 0;$not_good = 0;
    foreach($getLastCheckin as $nurseCheckinData){
      if($nurseCheckinData['feeling'] == 1){
        $happy = $happy+1;
      }
      if($nurseCheckinData['feeling'] == 2){
        $fine = $fine+1;
      }
      if($nurseCheckinData['feeling'] == 3){
        $not_good = $not_good+1;
      }
    }

    $response['happy'] = $happy;
    $response['fine'] = $fine;
    $response['not_good'] = $not_good;
    return $response;
  }

  public function NurseCheckinAllData($staffId){
    $getLastCheckin = $this->db
                                ->select('*')
                                ->order_by("id", "desc")
                                ->from('nurseDutyChange')
                                ->where(array('nurseId' => $staffId))
                                ->get()
                                ->result_array();
    return $getLastCheckin;
  }

  public function loungeNurseCheckinLogs($checkinId){
    $getCheckinData = $this->db
                                ->select('*')
                                ->order_by("id", "desc")
                                ->from('logHistory')
                                ->where(array('tableReference'=>1,'tableReferenceId' => $checkinId))
                                ->get()
                                ->result_array();
    return $getCheckinData;
  }

  public function NurseCheckinCountData($staffId){
    $getLastCheckin = $this->db
                                ->select('*')
                                ->order_by("id", "desc")
                                ->from('nurseDutyChange')
                                ->where(array('nurseId' => $staffId))
                                ->get()
                                ->result_array();

    $late=0;$onTime=0;
    if(!empty($getLastCheckin)){ 
      foreach($getLastCheckin as $getLastCheckinData){

        $splitDate = explode(" ",$getLastCheckinData['addDate']);
        $newTime = str_replace(":","",$splitDate[1]);

        if($newTime >= 73000 && $newTime <= 80000)
        {
            $onTime = $onTime+1;
        }
        else if($newTime >= 133000 && $newTime <= 140000)
        {
            $onTime = $onTime+1;
        }
        else if($newTime >= 193000 && $newTime <= 200000)
        {
            $onTime = $onTime+1;
        }
        else
        {
            $late = $late+1;
        }
      }
    }

    $returnOutput['totalShift']   = count($getLastCheckin);
    $returnOutput['onTime']       = $onTime;
    $returnOutput['late']         = $late;
    
    return $returnOutput;
  }


  public function GetFacilityByDistrict($district){
    $getCoachFacility = $this->UserModel->getCoachFacilities();

    $this->db->select('facilitylist.*');
    if(!empty($getCoachFacility['coachFacilityArray'])){ 
      $this->db->where_in('FacilityID',$getCoachFacility['coachFacilityArray']);
    }
    $this->db->order_by('FacilityName','asc');
    return $getFacilityList = $this->db->get_where('facilitylist',array('PRIDistrictCode'=>$district,'status'=>1))->result_array();
  }


  public function GetLoungeByFAcility($facilityId){
    $getCoachLounge = $this->UserModel->getCoachFacilities();

    $this->db->select('loungeMaster.*');
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $this->db->where_in('loungeId',$getCoachLounge['coachLoungeArray']);
    }
    $this->db->order_by('loungeName','asc');
    return $getLoungeList = $this->db->get_where('loungeMaster',array('facilityId'=>$facilityId,'status'=>1))->result_array();
  }

  public function GetNurseByFacility($facilityId){
    $getLastCheckin = $this->db
                                ->select('*')
                                ->order_by("name", "asc")
                                ->from('staffMaster')
                                ->where(array('facilityId' => $facilityId, 'status' => 1, 'staffType' => 2))
                                ->get()
                                ->result_array();
    return $getLastCheckin;
  }

  // get data from loungeMaster via facilityId
  public function temporaryLounge(){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = 'where temporaryLoungeMaster.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    return $this->db->query("SELECT temporaryLoungeMaster.* From temporaryLoungeMaster inner join facilitylist on temporaryLoungeMaster.`facilityId` = facilitylist.`FacilityID` inner join loungeMaster on temporaryLoungeMaster.`loungeId` = loungeMaster.`loungeId` ".$where_lounge." ORDER BY loungeId desc")->result_array();
  }

  // by search
  public function GetTempLoungeBySearch($district, $facilityname, $facility_status, $keyword){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";

    $where1 = "";$where2 = "";$where3 = "";$where4 = "";$and_cond = "";
    if(!empty($district)){
      $where1 = "facilitylist.`PRIDistrictCode` = ".$district."";
      $and_cond = "AND";
    }
    if(!empty($facilityname)){
      $where2 = $and_cond." facilitylist.`FacilityID` = ".$facilityname."";
      $and_cond = "AND";
    }
    if(!empty($facility_status) && $facility_status != 0){
      $where3 = $and_cond." temporaryLoungeMaster.`status` = ".$facility_status."";
      $and_cond = "AND";
    }else{
      $where3 = $and_cond." temporaryLoungeMaster.`status` != 0";
      $and_cond = "AND";
    }
    if(!empty($keyword)){
      $where4 = $and_cond." (loungeMaster.`loungeName` Like '%{$keyword}%' OR loungeMaster.`loungeContactNumber` Like '%{$keyword}%' OR facilitylist.`FacilityName` Like '%{$keyword}%')";
      $and_cond = "AND";
    }
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = $and_cond.' temporaryLoungeMaster.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    return $this->db->query("SELECT temporaryLoungeMaster.* From temporaryLoungeMaster inner join facilitylist on temporaryLoungeMaster.`facilityId` = facilitylist.`FacilityID` inner join loungeMaster on temporaryLoungeMaster.`loungeId` = loungeMaster.`loungeId` where $where1 $where2 $where3 $where4 $where_lounge ORDER BY temporaryLoungeMaster.loungeId desc")->result_array();
  }

  public function GetTempFacilitiesName($FacilityID){
    return $this->db->get_where('temporaryFacilityList',array('FacilityID'=>$FacilityID))->row_array();
  }

  public function GetTemporaryLoungeById($id){
    return $this->db->query("SELECT * From temporaryLoungeMaster where id = ".$id)->row_array();
  }

  public function GetTempFacilities($facilityId){
    return $this->db->query("SELECT * From temporaryFacilityList where FacilityID = ".$facilityId)->row_array();
  }

  public function checkIfAmenitiesExist($loungeId){
    $query = $this->db
                                ->select('*')
                                ->from('loungeAmenities')
                                ->where(array('loungeId' => $loungeId))
                                ->get()
                                ->row_array();
    return $query;
  }

  public function insertData($table, $data){
    $this->db->insert($table,$data);
    return $this->db->insert_id();
  }

  public function updateData($table, $data, $cond){
    $this->db->where($cond);
    return $this->db->update($table,$data); 
  }

  public function getLoungeLastUpdate($id, $type){
    if($type == 1){
        $this->db->order_by('id','desc');
        return $this->db->get_where('logData',array('tableReferenceId'=>$id, 'tableReference'=>2))->row_array();
    } else {
        $this->db->order_by('id','desc');
        return $this->db->get_where('logData',array('tableReferenceId'=>$id, 'tableReference'=>2))->result_array();
    }
  }

}
 ?>