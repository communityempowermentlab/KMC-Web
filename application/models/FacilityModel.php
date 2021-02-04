<?php

class FacilityModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  // get lounge detail by loungeId
  public function GetLoungeById($id){
    return $this->db->get_where('loungeMaster', array('loungeId'=>$id))->row_array();
  }

  // get NBCU type list i.e. type = 1 from master data
  public function NewBornCareUnit(){
    $this->db->order_by("name", "asc");
    return $this->db->get_where('masterData',array('type'=>'1', 'status' => '1'))->result_array(); 
  }

  // get managemet type list i.e. type = 2 from master data
  public function ManagementType(){
    $this->db->order_by("name", "asc");
    return $this->db->get_where('masterData',array('type'=>'2', 'status' => '1'))->result_array(); 
  }



  // get 4 latest mother lounge wise
  public function latestGetLatestMotherViaLoungeID($LoungeID){
    return $this->db->query("select * from motherRegistration as mr inner join babyRegistration as br on br.`motherId`=mr.`motherId` inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`loungeId`=".$LoungeID." order by mr.`motherId` desc limit 4")->result_array();
  }

  // get govt or non govt type list i.e. type = 3 from master data
  public function GovtORNot(){
    $this->db->order_by("name", "asc");
    return $this->db->get_where('masterData',array('type'=>'3', 'status' => '1'))->result_array(); 
  }

  // get active lounges list
  public function lounge(){
    return $this->db->query("SELECT * From loungeMaster where status != '2' ORDER BY loungeName asc")->result_array();
  }

  public function GetFacilities($type =''){
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    #type 2 for facility type;  
    if($type !='2'){ 
      $where_facility = "";
      if(!empty($getCoachFacilities['coachFacilityArray'])){ 
        $where_facility = 'where FM.FacilityID in '.$getCoachFacilities['coachFacilityArrayString'].' ';
      } 
      $qry = $this->db->query("SELECT `FT`.FacilityTypeName,`FM`.* FROM `facilitylist` as `FM` LEFT JOIN `facilityType` as `FT` ON FM.`FacilityType` = FT.`id` ".$where_facility." ORDER BY `FM`.FacilityID desc")->result_array();
      foreach($qry as $key => $fac_data)
        { 
          $this->db->select('loungeMaster.loungeName,loungeMaster.loungeId');
          $lounge_list = $this->db->get_where('loungeMaster', array('loungeMaster.facilityId'=>$fac_data['FacilityID']))->result_array();             
          
          $qry[$key]['lounge_name'] = $lounge_list;
        }
      foreach($qry as $key => $fac_data)
        { 
          $this->db->select('staffMaster.name,staffMaster.staffId');
          $staff_list = $this->db->get_where('staffMaster', array('staffMaster.facilityId'=>$fac_data['FacilityID']))->result_array();             
          
          $qry[$key]['staff_list'] = $staff_list;
        }
          
      return $qry;
    } else { 
      return $this->db->query("SELECT * FROM `facilityType` ORDER BY facilityTypeName asc")->result_array();

    }  
  }

  public function GetFacilitiesByDistrict($district){
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    $where_facility = "";
    if(!empty($getCoachFacilities['coachFacilityArray'])){ 
      $where_facility = 'AND FM.FacilityID in '.$getCoachFacilities['coachFacilityArrayString'].' ';
    }

    $qry = $this->db->query("SELECT `FT`.FacilityTypeName,`FM`.* FROM `facilitylist` as `FM` LEFT JOIN `facilityType` as `FT` ON FM.`FacilityType` = FT.`id` WHERE FM.`PRIDistrictCode` = ".$district." ".$where_facility." ORDER BY `FM`.FacilityID desc")->result_array();
    return $qry;
  }


  public function GetFacilitiesByKeyword($keyword){
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    $where_facility = "";
    if(!empty($getCoachFacilities['coachFacilityArray'])){ 
      $where_facility = 'AND FM.FacilityID in '.$getCoachFacilities['coachFacilityArrayString'].' ';
    }

    $qry = $this->db->query("SELECT `FT`.FacilityTypeName,`FM`.* FROM `facilitylist` as `FM` LEFT JOIN `facilityType` as `FT` ON FM.`FacilityTypeID` = FT.`id` WHERE (FT.`facilityTypeName` Like '%{$keyword}%' OR FM.`FacilityName` Like '%{$keyword}%' OR FM.`CMSOrMOICName` Like '%{$keyword}%' OR FM.`CMSOrMOICMoblie` Like '%{$keyword}%') ".$where_facility." ORDER BY `FM`.FacilityID desc")->result_array();
    return $qry;
  }

  public function GetFacilitiesByKeywordDistrict($district, $keyword){
    $getCoachFacilities = $this->UserModel->getCoachFacilities();
    $where_facility = "";
    if(!empty($getCoachFacilities['coachFacilityArray'])){ 
      $where_facility = 'AND FM.FacilityID in '.$getCoachFacilities['coachFacilityArrayString'].' ';
    }

    $qry = $this->db->query("SELECT `FT`.FacilityTypeName,`FM`.* FROM `facilitylist` as `FM` LEFT JOIN `facilityType` as `FT` ON FM.`FacilityTypeID` = FT.`id` WHERE FM.`PRIDistrictCode` = ".$district." AND (FT.`facilityTypeName` Like '%{$keyword}%' OR FM.`FacilityName` Like '%{$keyword}%' OR FM.`CMSOrMOICName` Like '%{$keyword}%' OR FM.`CMSOrMOICMoblie` Like '%{$keyword}%') ".$where_facility." ORDER BY `FM`.FacilityID desc")->result_array();
    return $qry;
  }

  // get over all kmc of babies lounge wise
  public function overAllKMC($LoungeID='')
  { 
    if($LoungeID != "all"){
    
      return $this->db->query("SELECT sum(TIMESTAMPDIFF(SECOND,startTime,endTime)) as kmcTime from `babyDailyKMC` inner join babyAdmission on `babyDailyKMC`.babyAdmissionId = `babyAdmission`.id where startTime < endTime and `babyAdmission`.loungeId=".$LoungeID."")->row_array();
    } else{
      
      return $this->db->query("SELECT sum(TIMESTAMPDIFF(SECOND,startTime,endTime)) as kmcTime from `babyDailyKMC` where startTime < endTime")->row_array();

    }
  } 

  // get total babies kmc for all lounges between two dates
  public function GetCurrentMonthKMC($FirstDayTimeStamp,$LastDayTimeStamp)
  { 
    $getValue = $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where startTime < endTime and (addDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp.")");
      $get = $getValue->row_array();
      
    return $get;
  } 

  // get total milkQuantity for all lounges if $LoungeID = all or else Lounge Wise
  public function overAllMilkQuantity($LoungeID='')
  { 
    if($LoungeID != "all"){
      return $this->db->query("SELECT sum(milkQuantity) as quantityOFMilk FROM `babyDailyNutrition` inner join babyAdmission on `babyDailyNutrition`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId = ".$LoungeID."")->row_array();
    }else{
      return $this->db->query("SELECT sum(milkQuantity) as quantityOFMilk FROM `babyDailyNutrition`")->row_array();
      
    }
  } 

  // get total milkQuantity for all lounges if $LoungeID = all or else Lounge Wise between two dates
  public function GetCurrentMonthMilk($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID='')
  { 
    if($LoungeID != "all"){ 
      $getValue = $this->db->query("SELECT sum(milkQuantity) as quantityOFMilk FROM `babyDailyNutrition` INNER JOIN babyAdmission on `babyDailyNutrition`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId='".$LoungeID."' and (`babyDailyNutrition`.addDate BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."')");
        $get = $getValue->row_array();
       // echo $this->db->last_query();exit();
     return $get;      
    }else{
      $getValue = $this->db->query("SELECT sum(milkQuantity) as quantityOFMilk FROM `babyDailyNutrition` where addDate BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."'");
        $get = $getValue->row_array();
    // echo $this->db->last_query();exit();
     return $get;    
    }
  } 

  public function GetFacilities2($type =''){
    #type 2 for facility type;  
    if($type !='2'){ 
      return $this->db->query("SELECT `FT`.facilityTypeName,`FM`.* FROM `facilityType` as `FM` LEFT JOIN `facilityType` as `FT` ON FM.`FacilityType` = FT.`FacilityTypeID` ORDER BY FacilityTypeName asc")->result_array();
      
    } else { 
      return $this->db->query("SELECT * FROM `facilityType`  WHERE `STATUS` != '2' ORDER BY facilityTypeName asc")->result_array();
    } 
  }

  // get distinct PRIDistrictCode & DistrictNameProperCase from revenuevillagewithblcoksandsubdistandgs
  public function selectquery(){

    $getCoachDistrict = $this->UserModel->getCoachFacilities();
    $where_district = "";
    if(!empty($getCoachDistrict['coachDistrictArray'])){ 
      $where_district = 'where revenuevillagewithblcoksandsubdistandgs.PRIDistrictCode in '.$getCoachDistrict['coachDistrictArrayString'].'';
    }

    return $query=$this->db->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` ".$where_district." ORDER BY DistrictNameProperCase asc")->result_array();
  } 

  public function selectDistrict($state){
    return $query=$this->db->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` WHERE StateCode = '".$state."' ORDER BY DistrictNameProperCase asc")->result_array();
  }

  // get distinct BlockPRICode & BlockPRINameProperCase from revenuevillagewithblcoksandsubdistandgs
  public function selectBlock($id='', $block_id ='', $type=''){
    return $query=$this->db->query("SELECT DISTINCT BlockPRICode , BlockPRINameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode = '".$id."' And BlockPRINameProperCase!='' And BlockPRICode!='' ORDER BY BlockPRINameProperCase asc")->result_array();
  } 

  // get distinct GPPRICode & GPNameProperCase from revenuevillagewithblcoksandsubdistandgs
  public function selectVillage($id) {
    return $query=$this->db->query("SELECT DISTINCT GPPRICode, GPNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` where BlockPRICode = '$id' And  GPNameProperCase!='' ORDER BY GPNameProperCase asc")->result_array();
  } 


  public function selectVillageByDistrict($id=''){
    return $query=$this->db->query("SELECT DISTINCT GPPRICode, GPNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode = '".$id."' And GPNameProperCase!='' ORDER BY GPNameProperCase asc")->result_array();
  }

  // get distinct id & name from countries
  public function selectCountry(){
    return $query=$this->db->query("SELECT DISTINCT id , name FROM `countries` ORDER BY name asc")->result_array();
  }

  // get distinct id & name from states on the basis of country_id
  public function selectState(){
    return $query=$this->db->query("SELECT DISTINCT stateCode , stateName FROM `stateMaster` ORDER BY stateName asc")->result_array();
  } 

  // insert data into facilitylist
  public function InsertFacility($request){ 
  
      $FacilityData = array();
      $FacilityData['FacilityName']           = $request['facility_name'];
      $FacilityData['FacilityManagement']     = $request['facility_mange_type'];
      $FacilityData['FacilityTypeID']         = $request['facility_type'];
      $getName = $this->GetFacilitiesTypeById('facilityType',$request['facility_type']);
      $FacilityData['FacilityType']            = $getName['facilityTypeName'];
      // $FacilityData['KMCLoungeStatus']         = '1';
      $FacilityData['NCUType']                 = $request['newborn_caring_type'];

      if($request['kmcunitstart'] != ''){
        $kmcunitstart = $this->input->post('kmcunitstart');
        $kmcunitstartDate = explode(',',$kmcunitstart); 
        $strDate = $kmcunitstartDate[0].$kmcunitstartDate[1];
        $strDate = date("Y-m-d", strtotime($strDate));
      } else {
        $strDate = NULL;
      }

      if($request['kmcunitclose'] != ''){
        $kmcunitclose = $this->input->post('kmcunitclose');
        $kmcunitcloseDate = explode(',',$kmcunitclose); 
        $clsDate = $kmcunitcloseDate[0].$kmcunitcloseDate[1];
        $clsDate = date("Y-m-d", strtotime($clsDate));
        
      } else {
        $clsDate = NULL;
      }

      

      $FacilityData['KMCUnitStartedOn']        = $strDate;
      $FacilityData['KMCUnitClosedOn']         = $clsDate;
      $FacilityData['Address']                 = $request['facility_address'];
      $address                                 = $request['facility_address'];
      
      $FacilityData['GPPRICode']               = $request['vill_town_city'];
      $FacilityData['PRIDistrictCode']         = $request['district_name'];

      $getName = $this->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs',$request['district_name']);
      //$FacilityData['DistrictName']            = $getName['DistrictNameProperCase'];
      $FacilityData['PRIBlockCode']            = $request['block_name'];
      $FacilityData['CountryID']               = NULL;
      $FacilityData['StateID']                 = $request['state_name'];
      $FacilityData['AdministrativeMoblieNo']  = NULL; //$request['contact_number'];
      $FacilityData['CMSOrMOICName']           = $request['cms_moic_name'];
      $FacilityData['CMSOrMOICMoblie']         = $request['phone_cms_moic_name'];
      $FacilityData['GOVT_NonGOVT']            = $request['governmentOrNot'];

      $FacilityData['status']                  ='1';
      
        $formattedAddr                        = str_replace(' ','+',$address);
        $geocodeFromAddr                      = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');
        // print_r($formattedAddr);
        // die(); 
        
        $output = json_decode($geocodeFromAddr);
        
        /*$dlat  = $output->results[0]->geometry->location->lat; 
        $dlong = $output->results[0]->geometry->location->lng;*/

        if(!empty($dlat) && !empty($output))
        {
          $FacilityData['latitude']                 = $dlat;
          $FacilityData['longitude']                = $dlong;
        }
        else{
          $FacilityData['latitude']                 = "0";
          $FacilityData['longitude']                = "0";
        }
      
      $FacilityData['AddDate']                      = date('Y-m-d H:i:s'); 
      $FacilityData['ModifyDate']                   = date('Y-m-d H:i:s');
      
      $result = $this->db->insert('facilitylist', $FacilityData); 
      $facilityId = $this->db->insert_id();
      
      return $result;
  }

  // add or update facilitytype
  public function AddUpdateFacility($data){
    $arrayName = array();
    $arrayName['facilityTypeName'] = $data['facility_type_name'];
    $arrayName['priority']    = $data['priority'];
    $arrayName['status']      = $data['status'];
    
    if (!empty($data['FacilityTypeID'])) {
      $arrayName['modifyDate'] = date('Y-m-d H:i:s');
      $this->db->where('id',$data['FacilityTypeID']);
      $this->db->update('facilityType',$arrayName); 
      $facilityTypeId = $data['FacilityTypeID'];
      $return = 'update';
    }else{
      $arrayName['addDate']    = date('Y-m-d H:i:s');
      $arrayName['modifyDate'] = date('Y-m-d H:i:s');
      $this->db->insert('facilityType',$arrayName); 
      $facilityTypeId = $this->db->insert_id();
      $return = 'insert';
    }

    $loginId = $this->session->userdata('adminData')['Id'];
    $ip = $this->input->ip_address();

    $LogData = array();
    $LogData['facilityTypeId']    = $facilityTypeId;
    $LogData['facilityTypeName']  = $data['facility_type_name'];
    $LogData['priority']          = $data['priority'];
    $LogData['status']            = $data['status'];
    $LogData['addDate']           = date('Y-m-d H:i:s');
    $LogData['addedBy']           = $loginId;
    $LogData['ipAddress']         = $ip;

    $this->db->insert('facilityTypeLog',$LogData); 

    return $return;

  }


  // get distinct GPPRICode & GPNameProperCase from revenuevillagewithblcoksandsubdistandgs on the basis of GPPRICode
  public function GetVillageName($GPPRICode=''){
    $query =  $this->db->query("SELECT DISTINCT GPPRICode, GPNameProperCase FROM revenuevillagewithblcoksandsubdistandgs where GPPRICode = '".$GPPRICode."'")->row_array();
    return $query['GPNameProperCase'];
  }

  // get distinct BlockPRICode & BlockPRINameProperCase from revenuevillagewithblcoksandsubdistandgs on the basis of BlockPRICode
  public function GetBlockName2($BLOCKID=''){
    $query =  $this->db->query("SELECT DISTINCT BlockPRICode, BlockPRINameProperCase FROM revenuevillagewithblcoksandsubdistandgs where BlockPRICode = '".$BLOCKID."'")->row_array();
    return $query['BlockPRINameProperCase'];
  }

  // get count of facilitylist FacilityTypeID wise
  public function countFacilitis($id){
    return $this->db->get_where('facilitylist',array('FacilityTypeID'=>$id))->num_rows();
  }

  /* change status of $table_name */
  public function changeStatus($row_id, $table_name,$unikCol) {
    $qry = $this->db
          ->select('*')
          ->from($table_name)
          ->where($unikCol, $row_id)
          ->get()
          ->row_array();

    $cur_date = date('Y-m-d H:i:s');

    if ($qry['status'] == '1') { 
      $status = '0';
      $data = array(
              'status'    => '0',
             'modifyDate' => $cur_date
            );
      $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
      
      $return = 2;

    } else if ($qry['status'] == '0') { 
      $status = '1';
      $data = array(
              'status'    => '1',
              'modifyDate' => $cur_date
            );
      $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
      $return = 1;

    }

    $loginId = $this->session->userdata('adminData')['Id'];
    $ip = $this->input->ip_address();

    if($table_name == 'masterData'){

      $logData = array(   'name'          => $qry['name'],
                          'masterDataId'  => $row_id,
                          'type'          => $qry['type'],
                          'status'        => $status,
                          'addDate'       => date('Y-m-d H:i:s'),
                          'addedBy'       => $loginId,
                          'ipAddress'     => $ip
                         );
      $this->db->insert('masterDataLog', $logData); 
      
    } else if($table_name == 'facilityType'){

      $logData = array(   'facilityTypeName'          => $qry['facilityTypeName'],
                          'facilityTypeId'            => $row_id,
                          'priority'                  => $qry['priority'],
                          'status'                    => $status,
                          'addDate'                   => date('Y-m-d H:i:s'),
                          'addedBy'                   => $loginId,
                          'ipAddress'                 => $ip
                         );
      $this->db->insert('facilityTypeLog', $logData); 
    } else if($table_name == 'loungeMaster'){
      $logData = array(   'loungeId'          => $qry['loungeId'],
                          'facilityId'        => $qry['facilityId'],
                          'loungeName'        => $qry['loungeName'],
                          'loungePassword'    => $qry['loungePassword'],
                          'type'              => $qry['type'],
                          'loungeContactNumber'       => $qry['loungeContactNumber'],
                          'address'           => $qry['address'],
                          'latitude'          => $qry['latitude'],
                          'longitude'         => $qry['longitude'],
                          'imeiNumber'        => $qry['imeiNumber'],
                          'status'                    => $status,
                          'addDate'                   => date('Y-m-d H:i:s'),
                          'addedBy'                   => $loginId,
                          'ipAddress'                 => $ip
                         );
      $this->db->insert('loungeMasterLog', $logData); 
    } else if($table_name == 'staffMaster'){
      $logData = array(   'staffId'           => $qry['staffId'],
                          'facilityId'        => $qry['facilityId'],
                          'name'              => $qry['name'],
                          'staffType'         => $qry['staffType'],
                          'staffSubType'              => $qry['staffSubType'],
                          'staffMobileNumber'         => $qry['staffMobileNumber'],
                          'staffPassword'             => $qry['staffPassword'],
                          'staffAddress'              => $qry['staffAddress'],
                          'profilePicture'            => $qry['profilePicture'],
                          'emergencyContactNumber'    => $qry['emergencyContactNumber'],
                          'jobType'                   => $qry['jobType'],
                          'status'                    => $status,
                          'addDate'                   => date('Y-m-d H:i:s'),
                          'addedBy'                   => $loginId,
                          'ipAddress'                 => $ip
                         );
      $this->db->insert('staffMasterLog', $logData); 
    } else if($table_name == 'employeesData'){
      $logData = array(   'employeeId'                => $qry['id'],
                          'name'                      => $qry['name'],
                          'email'                     => $qry['email'],
                          'contactNumber'             => $qry['contactNumber'],
                          'profileImage'              => $qry['profileImage'],
                          'password'                  => $qry['password'],
                          'status'                    => $status,
                          'addDate'                   => date('Y-m-d H:i:s'),
                          'addedBy'                   => $loginId,
                          'ipAddress'                 => $ip
                         );
      $this->db->insert('employeesDataLog', $logData); 
    }

    return $return;

  } /* change status of $table_name / */



  /* change status of table facilitylist */
  public function changeFacilityStatus($row_id, $table_name,$unikCol) {
    $qry = $this->db
          ->select('*')
          ->from($table_name)
          ->where($unikCol, $row_id)
          ->get()
          ->row_array();

    $cur_date = date('Y-m-d H:i:s');

    if ($qry['Status'] == '1') { 
      $status = '0';
      $data = array(
              'Status'    => '0',
              'ModifyDate' => $cur_date
            );
      $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
      
      $return = 2;

    } else if ($qry['Status'] == '0') { 
      $status = '1';
      $data = array(
              'Status'    => '1',
              'ModifyDate' => $cur_date
            );
      $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
      $return = 1;

    }
      
      $FacilityLogData = array();
      $loginId = $this->session->userdata('adminData')['Id'];
      $ip = $this->input->ip_address(); 
      $FacilityLogData['FacilityID']             = $row_id;
      $FacilityLogData['addedBy']                = $loginId;
      $FacilityLogData['ipAddress']              = $ip;
      $FacilityLogData['FacilityName']           = $qry['FacilityName'];
      $FacilityLogData['FacilityManagement']     = $qry['FacilityManagement'];
      $FacilityLogData['FacilityTypeID']         = $qry['FacilityTypeID'];
      
      $FacilityLogData['FacilityType']           = $qry['FacilityType'];
      
      $FacilityLogData['NCUType']                = $qry['NCUType'];
      $FacilityLogData['KMCUnitStartedOn']       = ($qry['KMCUnitStartedOn'] != '') ? date("Y-m-d",strtotime($qry['KMCUnitStartedOn'])) : NULL;
      $FacilityLogData['KMCUnitClosedOn']        = ($qry['KMCUnitClosedOn'] != '') ? date("Y-m-d",strtotime($qry['KMCUnitClosedOn'])) : NULL;
      $FacilityLogData['Address']                = $qry['Address'];
      $address                                   = $qry['Address'];
      
      $FacilityLogData['GPPRICode']              = $qry['GPPRICode'];
      $FacilityLogData['PRIDistrictCode']        = $qry['PRIDistrictCode'];

      $FacilityLogData['PRIBlockCode']            = $qry['PRIBlockCode'];
      $FacilityLogData['CountryID']               = $qry['CountryID'];
      $FacilityLogData['StateID']                 = $qry['StateID'];
      $FacilityLogData['AdministrativeMoblieNo']  = $qry['AdministrativeMoblieNo'];
      $FacilityLogData['CMSOrMOICName']           = $qry['CMSOrMOICName'];
      $FacilityLogData['CMSOrMOICMoblie']         = $qry['CMSOrMOICMoblie'];
      $FacilityLogData['GOVT_NonGOVT']            = $qry['GOVT_NonGOVT'];

      
      $FacilityLogData['Latitude']                = $qry['Latitude'];
      $FacilityLogData['Longitude']               = $qry['Longitude'];
      

      $FacilityLogData['status']                  = $status;
      $FacilityLogData['AddDate']                 = date('Y-m-d H:i:s'); 

      $facilityLogId = $this->db->insert('facilityListLog', $FacilityLogData); 
      return $return;


  } /* change status of table facilitylist / */



  /* get data from table by FacilityID  */
  public function GetFacilitiesById($table,$id) {
    return $this->db->get_where($table,array('FacilityID'=>$id))->row_array();
  }

  /* get data from table by FacilityTypeID  */
  public function GetFacilitiesTypeById($table,$id) {
    return $this->db->get_where($table,array('id'=>$id))->row_array();
  }

  /* update data in table by FacilityID  */
  public function updateDataCommon($table,$field,$id) {
    $this->db->where('FacilityID',$id);
    return $this->db->update($table,$field);
  }

  /* update data in table by FacilityTypeID  */
  public function updateFaciltyCommon($table,$field,$id) {
    $this->db->where('FacilityTypeID',$id);
    return $this->db->update($table,$field);
  }

  /* get data from table by PRIDistrictCode  */
  public function GetDistrictNameById($table,$id) { 
    return $this->db->get_where($table,array('PRIDistrictCode'=>$id))->row_array();
  }

  /* get data from table by BlockPRICode  */
  public function GetBlockById($table,$id) {
    return $this->db->get_where($table,array('BlockPRICode'=>$id))->row_array();
  }

  /* get data from table by id  */
  public function GetDataById($table,$id) {  
    return $this->db->get_where($table,array('id'=>$id))->row_array();
  }

  /* get distinct PRIDistrictCode & DistrictNameProperCase from revenuevillagewithblcoksandsubdistandgs on the basis of PRIDistrictCode */
  public function GetDistrictName($District_Id=''){
    $query = $this->db->query("SELECT DISTINCT PRIDistrictCode, DistrictNameProperCase FROM revenuevillagewithblcoksandsubdistandgs  Where PRIDistrictCode = '".$District_Id."'")->row_array();
    return $query['DistrictNameProperCase'];
  }

  /* check if login mobile number already exists */
  public function checkLogInMobile($mobile, $table, $column, $id, $id_column){
    if($id == ''){
      return $this->db->get_where($table,array($column => $mobile))->row_array(); 
    } else {
      return $this->db->get_where($table,array($column => $mobile, $id_column.'!=' => $id))->row_array(); 
    }
  }

  /* get AdministrativeMoblieNo from facilitylist where status is 1 */
  public function FindMobile($mobile) {
    $query = $this->db->get_where('facilitylist', array('AdministrativeMoblieNo'=> $mobile,STATUS=>'1'));
    return $query->row_array(); 
  }

  /* get data from facilitylist on the basis of otp */
  public function login($otp) {
    $query = $this->db->get_where('facilitylist', array('otp'=> $otp));
    return $query->row_array();
  }

  /* add data into the table */
  public function AddData($table, $data){
    $this->db->insert($table,$data);
    return 1;
  }

  /* get last detail from loginMaster on the basis of loungeMasterId */
  public function GetLoginDatails($id){
    $this->db->order_by("id", "desc");
    $this->db->limit("1");
    return $this->db->get_where('loginMaster', array('loungeMasterId'=>$id))->row_array();
  }

  /* get data from loungeMaster on the basis of loungeId */
  public function GetFacilitiesID($id){
    return $this->db->get_where('loungeMaster', array('loungeId'=>$id))->row_array();
  }

  /* get data from facilitylist on the basis of FacilityID */
  public function GetFacilityName($id){
    return $this->db->get_where('facilitylist', array('FacilityID'=>$id))->row_array();
  }

  /* get data from babyAdmission on the basis of babyId */
  public function GetBabyWeightPDF($id){
    return $this->db->get_where('babyAdmission', array('babyId'=>$id))->row_array();
  } 

  /* get data from babyDailyMonitoring on the basis of loungeId */
  public function BabyAssessment($loungeID = ''){
    $this->db->where('loungeId',$loungeID);
    $this->db->order_by('id','desc');
    return $this->db->get_where('babyDailyMonitoring')->result_array();     
  } 

  /* get latest (limit) mother data on the basis of loungeId */
  public function getLatestMotherViaLoungeID($LoungeID='',$limit){
   if($LoungeID != 'all'){
    return $this->db->query("select * from motherRegistration as mr inner join babyRegistration as br on br.`motherId`=mr.`motherId` inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`loungeId`=".$LoungeID." and mr.`Type` != 2  order by mr.`motherId` desc limit 0,".$limit."")->result_array();
   }else
   {
    return $this->db->query("select * from motherRegistration as mr inner join babyRegistration as br on br.`motherId`= mr.`motherId` inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where mr.`Type` != 2 order by mr.`motherId` desc limit 0,".$limit."")->result_array(); 

   }
  }

  /* get latest (8) mother data*/
  public function getLatestMother(){
     $this->db->order_by("motherId", "desc");
     $this->db->limit("8");
     $adminData = $this->session->userdata('adminData'); 
    if($adminData['Type']=='1') {
      return $this->db->get_where('motherRegistration')->result_array();
    } else if($adminData['Type']=='2') {
      return $this->db->get_where('motherRegistration')->result_array();
    } 
  }

  /* get data from table settings */
  public function getQuickEmail(){
    return $this->db->get_where('settings')->row_array();
  }

  /* get count from motherRegistration on the basis of addDate */
  public function CountByDate($addDate) {
    return $this->db->get_where('motherRegistration',array('addDate' => $addDate))->num_rows();
  }

  /* get data from facilitylist for map */
  public function GetFacilityListForMap() {
    $adminData = $this->session->userdata('adminData'); 
    if($adminData['Type']=='1') {
      return $this->db->query("select * from facilitylist WHERE  Address!='' AND Latitude !='0' AND Longitude!='0'")->result_array();
    }
  }

  /* get data from facilitylist on the basis of FacilityID */
  public function FindMobileForResend($id) {
    $query = $this->db->get_where('facilitylist', array('FacilityID'=> $id));
    return $query->row_array();
  }

  /* get data from loungeMaster on the basis of facilityId */
  public function GetLoungeIdByFacilitiesID($id){
    return $this->db->get_where('loungeMaster', array('facilityId'=>$id))->result_array();
  }

  /* get data from adminMaster for admin */
  public function GetAdminInfo(){
    return $this->db->get_where('adminMaster', array('id'=>1))->row_array();
  }

  /* get 5 latest notification data */
  public function GetlatestNotification() {
    $this->db->order_by("id", "desc");
    $this->db->limit("5");
    return $this->db->get_where('notification')->result_array();
  }

  /* get 5 latest smsMaster data */
  public function GetlatestSms() {
    $this->db->order_by("id", "desc");
    $this->db->limit("5");
    return $this->db->get_where('smsMaster')->result_array();
  }

  /* get count from notification on the basis of addDate */
  public function CountNotification($notificationTime) {
    $query1 = $this->db->query("select * from notification where addDate > '".$notificationTime."'")->num_rows();
    $data['notification']         = $query1;
    return $data;
  }

  /* get count from smsMaster on the basis of addDate */
  public function CountSMS($SMSTime) {
    $query1 = $this->db->query("select * from smsMaster where addDate >'".$SMSTime."'")->num_rows();
    $data['smsmaster']         = $query1;
    return $data;
  }

  /* get data from babyRegistration on the basis of babyId */
  public function getBabyById($Id){
    return  $this->db->get_where('babyRegistration',array('babyId'=>$Id))->row_array(); 
  }

  /* get data from supplementMaster on the basis of id */
  public function GetSupplimentById($id){
    return $this->db->get_where('supplementMaster', array('id'=>$id))->row_array();
  } 

  /* get last data from babyDailyMonitoring on the basis of babyId */
  public function GetBabyDanger($id){
    return $this->db->query("select * from babyDailyMonitoring where babyId=".$id." order by id DESC limit 0,1")->row_array();
  } 

  /* get admin login password */
  public function ChangePassword($NewPassword){
    $this->db->set('password',$NewPassword);
    $this->db->where('id','1');
    return $this->db->update('adminMaster');
  }

  /* get active data from videoType */
  public function GetVideoType(){
    $this->db->order_by("videoTypeName", "ASC");
    return $this->db->get_where('videoType',array('status'=>'1'))->result_array();
  }

  /* get data from videoType on the basis of id */
  public function GetVideoTypeById($id){
    return $this->db->get_where('videoType', array('id'=>$id))->row_array();
  }

  /* get data from settings */
  public function GetDataInSettings(){
    return $this->db->get_where('settings', array('id'=>'1'))->row_array();
  } 

  /* get all data from staffType */
  public function GetStaffType(){
    return $this->db->get_where('staffType')->result_array();
  }

  /* get data from staffType whose parentId is 0 */
  public function GetNoParentStaffType(){
    $this->db->order_by("staffTypeNameEnglish", "ASC");
    return $this->db->get_where('staffType',array('parentId'=>'0'))->result_array();
  }

  /* get data from staffType on the basis of staffTypeId */
  public function GetStaffTypeById($id){
    return $this->db->get_where('staffType',array('staffTypeId'=>$id))->row_array();
  } 

  /* get data from staffMaster on the basis of staffMobileNumber */
  public function getDoctorByMobile($mobile){
    return $this->db->get_where('staffMaster',array('staffMobileNumber'=>$mobile))->row_array();
  }

  /* get active data from loungeMaster */
  public function getFacilityStatusActive(){
    return $this->db->get_where('loungeMaster',array('status'=>1))->result_array();
  } 

  /* get last admitted baby */
  public function GetLastAdmittedBaby($id){
   return $this->db->query("select * from babyAdmission where babyId = ".$id." order by id DESC limit 0,1")->row_array();
  } 

  /* get data from motherMonitoring on the basis of motherId  */
  public function GetMotherForChecklist($id){
   return $this->db->query("select * from motherMonitoring where motherId = ".$id." order by id asc limit 0,1")->row_array();
  } 

  /* get data from babyDailyMonitoring on the basis of babyId  */
  public function GetBabyForChecklist($id){
   return $this->db->query("select * from babyDailyMonitoring where babyId = ".$id." order by id asc limit 0,1")->row_array();
  } 

  /* get current admitted baby in last 24 hours  */
  public function getCurrentBabyInHour($LoungeID='')
  { 
    $now = time();
    $before24fourhrsTime = strtotime(date('Y-m-d H:i:s',strtotime('last day'))); 
    if($LoungeID != 'all'){ 
         return $getValue = $this->db->query("SELECT babyAdmissionId,@totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` inner JOIN babyAdmission on `babyDailyKMC`.babyAdmissionId = `babyAdmission`.id where `babyDailyKMC`.startTime < `babyDailyKMC`.endTime and `babyAdmission`.loungeId=".$LoungeID." and `babyDailyKMC`.addDate between ".$before24fourhrsTime." and ".$now." group by `babyDailyKMC`.babyAdmissionId")->result_array();
        // echo $this->db->last_query();exit();
      }else{
         return $getValue = $this->db->query("SELECT babyAdmissionId,@totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where startTime < endTime  and addDate between ".$before24fourhrsTime." and ".$now." group by babyAdmissionId")->result_array();
      }

  }

  /* get direct feeding data between two dates */
  public function getExCurrentDateFeeding($startDateTime,$endDateTime,$LoungeID='')
  { 
    if($LoungeID != "all"){ 
        return $getValue = $this->db->query("select babyAdmissionId from babyDailyNutrition INNER JOIN babyAdmission on babyDailyNutrition.babyAdmissionId = babyAdmission.id where babyDailyNutrition.feedingType='1' and babyAdmission.loungeId=".$LoungeID." and (babyDailyNutrition.addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."') group by babyDailyNutrition.babyAdmissionId")->num_rows();
    }else {
        return $getValue = $this->db->query("select babyAdmissionId from babyDailyNutrition where feedingType='1' and (addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."') group by babyAdmissionId")->num_rows();
    }

  }

  /* get non direct feeding data between two dates */
  public function getNonExCurrentDateFeeding($startDateTime,$endDateTime,$LoungeID='')
  { 

    if($LoungeID != "all"){
      return $getValue = $this->db->query("select babyAdmissionId from babyDailyNutrition INNER JOIN babyAdmission on babyDailyNutrition.babyAdmissionId = babyAdmission.id where babyDailyNutrition.feedingType != '1' and babyAdmission.loungeId=".$LoungeID." and (babyDailyNutrition.addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."') group by babyDailyNutrition.babyAdmissionId")->num_rows();
     }else {
      return $getValue = $this->db->query("select babyAdmissionId from babyDailyNutrition where feedingType != '1' and (addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."') group by babyAdmissionId")->num_rows();
      //echo $this->db->last_query();exit;
     }  
    
  }

  /* get count for total admiited babies */
  public function getTotalAdmittedChild($LoungeID='')
  { 
    if($LoungeID != "all"){
      return $getValue = $this->db->query("select bm.babyAdmissionId from babyAdmission as ba inner join babyDailyMonitoring as bm on ba.`id`=bm.`babyAdmissionId` where ba.`status`='1' and ba.`loungeId`=".$LoungeID." group by bm.`babyAdmissionId`")->num_rows();
     }else {
        return $getValue = $this->db->query("select bm.babyAdmissionId from babyAdmission as ba inner join babyDailyMonitoring as bm on ba.`id`=bm.`babyAdmissionId` where ba.`status`='1' group by bm.`babyAdmissionId`")->num_rows();
     }
    
  }

  /* get count for babies from babyDailyNutrition between two dates */
  public function getExexistingFeeding($startDateTime,$endDateTime,$LoungeID='')
  { 
    if($LoungeID != "all"){
      return $getValue = $this->db->query("select babyAdmissionId from babyDailyNutrition INNER JOIN babyAdmission on babyDailyNutrition.babyAdmissionId = babyAdmission.id where (babyDailyNutrition.addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."') and babyAdmission.loungeId=".$LoungeID." group by babyDailyNutrition.babyAdmissionId")->num_rows();
     }else {
      return $getValue = $this->db->query("select babyAdmissionId from babyDailyNutrition where addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."' group by babyAdmissionId")->num_rows();
      
     }
  }

  /* get babies count for kmc given from babyDailyKMC between two dates */
  public function getGivenKMC($startDateTime,$endDateTime,$LoungeID='')
  {
    if($LoungeID != "all"){
      return $getValue = $this->db->query("select babyAdmissionId from babyDailyKMC INNER JOIN babyAdmission on babyDailyKMC.babyAdmissionId = babyAdmission.id where babyAdmission.loungeId=".$LoungeID." and babyDailyKMC.startTime < babyDailyKMC.endTime and (babyDailyKMC.addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."') group by babyDailyKMC.babyAdmissionId")->num_rows();
     }else {
      return $getValue = $this->db->query("select babyAdmissionId from babyDailyKMC where startTime < endTime and (addDate BETWEEN '".$startDateTime."' AND '".$endDateTime."') group by babyAdmissionId")->num_rows();
     }
  }

  /* get 4 latest babies on the basis of loungeId */
  public function getFourLatestBabyViaLoungeID($LoungeID){
    return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on br.`babyId`=ba.`babyId` where ba.`loungeId`=".$LoungeID." order by br.`babyId` desc limit 4")->result_array();
  }

  /* get latest babies on the basis of loungeId and limit */
  public function getLatestBabyViaLoungeID($LoungeID='',$limit){
   if($LoungeID != 'all'){
     return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on br.`babyId`=ba.`babyId` where ba.`loungeId`=".$LoungeID." order by br.`babyId` desc limit 0,".$limit."")->result_array();
   }else
   {
     return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on br.`babyId`=ba.`babyId` order by br.`babyId` desc limit 0,".$limit."")->result_array(); 
   }
  }

  ############################## Mother Monitoring Listing Queries ##################

  // count mother assessment on the basis of loungeId
  public function countAllMonitorings($loungeID){
     return $this->db->get_where('motherMonitoring',array('loungeId'=>$loungeID))->num_rows(); 
  } 

  // count mother assessment data on the basis of loungeId and search keyword
  public function motherMonitoringCountWithSearching($loungeID,$keyword){
    return $this->db->query("SELECT * FROM `motherMonitoring` as mm inner join motherRegistration as mr on mr.`motherId` = mm.`motherId` where mm.`loungeId` = ".$loungeID." and ( mr.`motherName` Like '%$keyword%' OR mm.`motherSystolicBP` Like '%$keyword%' OR mm.`motherDiastolicBP` Like '%$keyword%' OR mm.`motherTemperature` Like '%$keyword%' OR mm.`motherPulse` Like '%$keyword%' OR mm.`motherUterineTone` Like '%$keyword%' OR mm.`episitomyCondition` Like '%$keyword%' OR mm.`sanitoryPadStatus` Like '%$keyword%' OR mm.`IsSanitoryPadStink` Like '%$keyword%')")->num_rows();
  }

  // get All Mother assesmets Via loungeId
  public function getAllAssessments($loungeID,$limit,$offset){
    $this->db->order_by('id', 'desc');
    $this->db->limit($limit, $offset);
    return $this->db->get_where('motherMonitoring', array('loungeId'=>$loungeID))->result_array();
  } 

  // get All mother assessment data on the basis of loungeId and search keyword
  public function getAllAssessmentWhereSearching($keyword,$loungeID,$limit,$offset){
    return $this->db->query("SELECT * FROM `motherMonitoring` as mm inner join motherRegistration as mr on mr.`motherId` = mm.`motherId` where mm.`loungeId` = ".$loungeID." and ( mr.`MotherName` Like '%$keyword%' OR mm.`motherSystolicBP` Like '%$keyword%' OR mm.`motherDiastolicBP` Like '%$keyword%' OR mm.`motherTemperature` Like '%$keyword%' OR mm.`motherPulse` Like '%$keyword%' OR mm.`motherUterineTone` Like '%$keyword%' OR mm.`episitomyCondition` Like '%$keyword%' OR mm.`sanitoryPadStatus` Like '%$keyword%' OR mm.`IsSanitoryPadStink` Like '%$keyword%') order By mm.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
  }  

  // Last Login Data
  public function getLastLogin($type,$id){
    $this->db->order_by('id','desc');
    return $this->db->get_where('loginMaster', array('loungeMasterId'=>$id,'type'=>$type))->row_array();
  }

  public function getLastCheckin($id){
    $this->db->order_by('id','desc');
    return $this->db->get_where('nurseDutyChange', array('nurseId'=>$id))->row_array();
  }

  // Get state name
  public function GetStateName($id){
    $res = $this->db->get_where('stateMaster', array('stateCode'=>$id))->row_array();
    return $res['stateName'];
  }

  public function getLoginImage(){
    return $this->db->get_where('indexPageImage', array('status !='=>3))->result_array();
  }

  public function getLoginImageById($id){
    return $this->db->get_where('indexPageImage', array('id'=>$id))->row_array();
  }

  public function getActiveImage(){
    $result = $this->db->get_where('indexPageImage', array('status !='=>3))->result_array();
    $data = array();
    foreach ($result as $key => $value) {
      $data[$key] = $value['image'];
    }
    return $data;
  }

  public function insertData($table, $data){
    $this->db->insert($table,$data);
    return 1;
  }

  public function GetTempFacilities(){
    return $this->db->get_where('temporaryFacilityList',array('status'=>'1'))->result_array(); 
  }

  public function checkData($table, $cond){
    return $this->db->get_where($table, $cond)->num_rows(); 
  }

  public function GetFacilityLog($id){
    $this->db->order_by('id','desc');
    return $this->db->get_where('logData',array('tableReferenceId'=>$id, 'tableReference'=>1))->result_array();
  }

  public function GetFacilityTypeLog($id){
    $this->db->order_by('id','desc');
    return $this->db->get_where('facilityTypeLog',array('facilityTypeId'=>$id))->result_array(); 
  }

  public function GetStaffTypeLog($staffTypeId){
    $this->db->order_by('id','desc');
    return $this->db->get_where('staffTypeLog',array('staffTypeId'=>$staffTypeId))->result_array(); 
  }


  function time_ago_in_php($timestamp){
  
    date_default_timezone_set("Asia/Kolkata");         
    $time_ago        = strtotime($timestamp);
    $current_time    = time();
    $time_difference = $current_time - $time_ago;
    $seconds         = $time_difference;
    
    $minutes = round($seconds / 60); // value 60 is seconds  
    $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
    $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
    $weeks   = round($seconds / 604800); // 7*24*60*60;  
    $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
    $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

    $dateF   = date("M d ",strtotime($timestamp)).'at '.date("h:i A",strtotime($timestamp)); 
                  
    if ($seconds <= 60){

      return "Just Now";

    } else if ($minutes <= 60){

      if ($minutes == 1){

        return "one min ago";

      } else {

        return "$minutes mins ago";

      }

    } else if ($hours <= 24){

      if ($hours == 1){

        return "an hour ago";

      } else {

        return "$hours hrs ago";

      }

    } else if ($days <= 7){

      if ($days == 1){

        return "yesterday";

      } else {

        return "$days days ago";

      }

    } else if ($weeks == 1){

      return "a week ago";
        
    } else {

      return $dateF;
      
    }
  }


  public function GetFacilityLastUpdate($facilityId){
    $this->db->order_by('id','desc');
    return $this->db->get_where('logData',array('tableReference'=>1, 'tableReferenceId' => $facilityId))->row_array(); 
  }

}
 ?>