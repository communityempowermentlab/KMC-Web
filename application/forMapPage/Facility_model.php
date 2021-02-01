<?php
class Facility_model extends CI_Model {
      public function __construct(){
        parent::__construct();
      $this->load->database();
      }

public function GetLoungeById($id){
    return $this->db->get_where('lounge_master', array('LoungeID'=>$id))->row_array();
  }

 public function NewBornCareUnit(){
    return $this->db->get_where('master_data',array('type'=>'1'))->result_array(); 
   }
 public function ManagementType(){
    return $this->db->get_where('master_data',array('type'=>'2'))->result_array(); 
   }

  public function GovtORNot(){
    return $this->db->get_where('master_data',array('type'=>'3'))->result_array(); 
   }

 public function lounge(){
    return $this->db->query("SELECT * From lounge_master where status != '2' ORDER BY LoungeID desc")->result_array();
   }

 public function GetFacilities($type =''){
    #type 2 for facility type;  
    if($type !='2'){

    return $this->db->query("SELECT `FT`.FacilityTypeName,`FM`.* FROM `facilitylist` as `FM` LEFT JOIN `facilitytype` as `FT` ON FM.`FacilityType` = FT.`FacilityTypeID` ORDER BY FacilityTypeId desc")->result_array();
    //echo $this->db->last_query();die();
    }else{
    return $this->db->query("SELECT * FROM `facilitytype`  WHERE `STATUS` != '2' ORDER BY FacilityTypeId desc")->result_array();
 //echo $this->db->last_query();die();
    }  
  }

public function overAllKMC($LoungeID='')
{ 
  if($LoungeID != ""){
    return $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as kmcTime, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `skintoskin_touch_master` where StartTime < EndTime and LoungeID=".$LoungeID."")->row_array();
  }else{
    return $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as kmcTime, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `skintoskin_touch_master` where StartTime < EndTime")->row_array();

  }
} 

public function GetCurrentMonthKMC($FirstDayTimeStamp,$LastDayTimeStamp)
{ 
  $getValue = $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `skintoskin_touch_master` where StartTime < EndTime and (AddDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp.")");
    $get = $getValue->row_array();
    //echo $this->db->last_query();exit();
  return $get;
} 

public function overAllMilkQuantity($LoungeID='')
{ 
  if($LoungeID != ""){
    return $this->db->query("SELECT sum(MilkQuantity) as quantityOFMilk FROM `breast_feeding_master` where LoungeID=".$LoungeID."")->row_array();
  }else{
    return $this->db->query("SELECT sum(MilkQuantity) as quantityOFMilk FROM `breast_feeding_master`")->row_array();

  }
} 


public function GetCurrentMonthMilk($FirstDayTimeStamp,$LastDayTimeStamp)
{ 
  $getValue = $this->db->query("SELECT baby_admissionID,sum(MilkQuantity) as quantityOFMilk FROM `breast_feeding_master` where AddDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp."");
    $get = $getValue->row_array();
    //echo $this->db->last_query();exit();
  return $get;
} 

public function GetFacilities2($type =''){
    #type 2 for facility type;  
    if($type !='2'){
    return $this->db->query("SELECT `FT`.FacilityTypeName,`FM`.* FROM `facilitytype` as `FM` LEFT JOIN `facilitytype` as `FT` ON FM.`FacilityType` = FT.`FacilityTypeID` ORDER BY FacilityTypeName asc")->result_array();
    //echo $this->db->last_query();die();
    }else{
    return $this->db->query("SELECT * FROM `facilitytype`  WHERE `STATUS` != '2' ORDER BY FacilityTypeName asc")->result_array();
 //echo $this->db->last_query();die();
    } 
  }

public function selectquery(){
    return $query=$this->db->query("SELECT DISTINCT PRIDistrictCode , DistrictNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` ORDER BY DistrictNameProperCase asc")->result_array();
   } 

 public function selectBlock($id='', $block_id ='', $type=''){
  return $query=$this->db->query("SELECT DISTINCT BlockPRICode , BlockPRINameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` where PRIDistrictCode = '".$id."' And BlockPRINameProperCase!='' And BlockPRICode!='' ORDER BY BlockPRINameProperCase asc")->result_array();
 } 

 public function selectVillage($id) {
   return $query=$this->db->query("SELECT DISTINCT GPPRICode, GPNameProperCase FROM `revenuevillagewithblcoksandsubdistandgs` where BlockPRICode = '$id' And  GPNameProperCase!='' ORDER BY GPNameProperCase asc")->result_array();
  } 

public function selectCountry(){
  return $query=$this->db->query("SELECT DISTINCT id , name FROM `countries` ORDER BY name asc")->result_array();
  }

public function selectState($id){
    return $query=$this->db->query("SELECT DISTINCT id , name FROM `states` where country_id = '$id' And name!='' And id!='' ORDER BY name asc")->result_array();
  } 

public function InsertFacility($request){
      $FacilityData = array();
      $FacilityData['FacilityName']           = $request['facility_name'];
      $FacilityData['FacilityManagement']     = $request['facility_mange_type'];
      $FacilityData['FacilityTypeID']         = $request['facility_type'];
      $getName = $this->GetFacilitiesTypeById('facilitytype',$request['facility_type']);
      $FacilityData['FacilityType']            = $getName['FacilityTypeName'];
      $FacilityData['KMCLoungeStatus']         = $request['kmc_present'];
      $FacilityData['NCUType']                 = $request['newborn_caring_type'];
      $FacilityData['KMCUnitStartedOn']        = date("Y-m-d",strtotime($request['kmcunitstart']));
      $FacilityData['KMCUnitClosedOn']         = date("Y-m-d",strtotime($request['kmcunitclose']));
      $FacilityData['Address']                 = $request['facility_address'];
      $address                                 = $request['facility_address'];
      
      $FacilityData['GPPRICode']               = $request['vill_town_city'];
      $FacilityData['PRIDistrictCode']         = $request['district_name'];

      $getName = $this->GetDistrictNameById('revenuevillagewithblcoksandsubdistandgs',$request['district_name']);
      //$FacilityData['DistrictName']            = $getName['DistrictNameProperCase'];
      $FacilityData['PRIBlockCode']            = $request['block_name'];
      $FacilityData['CountryID']               = $request['country_name'];
      $FacilityData['StateID']                 = $request['state_name'];
      $FacilityData['AdministrativeMoblieNo']  = $request['contact_number'];
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
      
      $FacilityData['AddDate']                = time();
      $FacilityData['ModifiyDate']                =time();
      
     return $this->db->insert('facilitylist', $FacilityData); 
  }

public function AddUpdateFacility($data){
        $arrayName = array();
        $arrayName['FacilityTypeName'] = $data['facility_name'];
        $arrayName['Priority'] = $data['priority'];
        $arrayName['Status']      = '1';
        
        if (!empty($data['FacilityTypeID'])) {
          $arrayName['Modify_Date'] = time();
          $this->db->where('FacilityTypeID',$data['FacilityTypeID']);
          $this->db->update('facilitytype',$arrayName); 
          return 'update';
        }else{
          $arrayName['Add_Date']    = time();
          $arrayName['Modify_Date'] = time();
          $this->db->insert('facilitytype',$arrayName); 
          return 'insert';
        }
    }


 public function GetVillageName($GPPRICode=''){
        $query =  $this->db->query("SELECT DISTINCT GPPRICode, GPNameProperCase FROM revenuevillagewithblcoksandsubdistandgs where GPPRICode = '".$GPPRICode."'")->row_array();
        return $query['GPNameProperCase'];
   }

public function GetBlockName2($BLOCKID=''){
      $query =  $this->db->query("SELECT DISTINCT BlockPRICode, BlockPRINameProperCase FROM revenuevillagewithblcoksandsubdistandgs where BlockPRICode = '".$BLOCKID."'")->row_array();
   return $query['BlockPRINameProperCase'];
     }

public function countFacilitis($id){
    return $this->db->get_where('facilitylist',array('FacilityTypeID'=>$id))->num_rows();
  }
    /* change status */
  public function changeStatus($row_id, $table_name,$unikCol) {
        $qry = $this->db
              ->select('*')
              ->from($table_name)
              ->where($unikCol, $row_id)
              ->get()
              ->row_array();

        $cur_date = time();

        if ($qry['Status'] == '1') {

          $data = array(
                  'Status'    => '0',
                 'ModifiyDate' => time()
                );
          $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
          return 2;

        } else if ($qry['Status'] == '0') {

          $data = array(
                  'Status'    => '1',
                  'ModifiyDate' =>time()
                );
          $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
          return 1;

        }
      } /* change status / */


        /* change status */
   public function changeStatus2($row_id, $table_name,$unikCol) {

        $qry = $this->db
              ->select('*')
              ->from($table_name)
              ->where($unikCol, $row_id)
              ->get()
              ->row_array();

        $cur_date = time();

        if ($qry['status'] == '1') {

          $data = array(
                  'status'    => '0',
                 'modify_date' =>time()
                );
          $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
          return 2;

        } else if ($qry['status'] == '0') {

          $data = array(
                  'status'    => '1',
                  'modify_date' => time()
                );
          $update_data = $this->db->where($unikCol, $row_id)->update($table_name, $data);
          return 1;

        }
      } /* change status / */

public function GetFacilitiesById($table,$id) {
    return $this->db->get_where($table,array('FacilityID'=>$id))->row_array();
  }


public function GetFacilitiesTypeById($table,$id) {
    return $this->db->get_where($table,array('FacilityTypeID'=>$id))->row_array();
 }

public function updateDataCommon($table,$field,$id) {
             $this->db->where('FacilityID',$id);
      return $this->db->update($table,$field);
  }

public function updateFaciltyCommon($table,$field,$id) {
             $this->db->where('FacilityTypeID',$id);
      return $this->db->update($table,$field);
  }

 public function GetDistrictNameById($table,$id) { 
    return $this->db->get_where($table,array('PRIDistrictCode'=>$id))->row_array();
  }

public function GetBlockById($table,$id) {
    return $this->db->get_where($table,array('BlockPRICode'=>$id))->row_array();
  }

public function GetCountryById($table,$id) {  
   return $this->db->get_where($table,array('id'=>$id))->row_array();
  }

public function GetStateById($table,$id){
   return $this->db->get_where($table,array('id'=>$id))->row_array();
  } 

public function GetFacilityManagement($table,$id){
   return $this->db->get_where($table,array('id'=>$id))->row_array();
 }

public function GetBlockName($table,$id){
   return $this->db->get_where($table,array('BlockPRICode'=>$id))->row_array();
  }

public function GetDistrictName($District_Id=''){
    $query = $this->db->query("SELECT DISTINCT PRIDistrictCode, DistrictNameProperCase FROM revenuevillagewithblcoksandsubdistandgs  Where PRIDistrictCode = '".$District_Id."'")->row_array();
    return $query['DistrictNameProperCase'];
  }

public function checkMobile($mobile){
    return $this->db->get_where('facilitylist',array('AdministrativeMoblieNo'=>$mobile))->row_array(); 
  }

public function FindMobile($mobile) {
        $query = $this->db->get_where('facilitylist', array('AdministrativeMoblieNo'=> $mobile,STATUS=>'1'));
        return $query->row_array(); 
   }

 public function login($otp) {
        $query = $this->db->get_where('facilitylist', array('otp'=> $otp));
        return $query->row_array();
   }

public function AddData($table, $data){
      $this->db->insert($table,$data);
      return 1;
  }

public function GetLoginDatails($id){
   $this->db->order_by("id", "desc");
   $this->db->limit("1");
 return $this->db->get_where('login_master', array('lounge_master_id'=>$id))->row_array();
  }

public function GetFacilitiesID($id){
 return $this->db->get_where('lounge_master', array('LoungeID'=>$id))->row_array();
 }

public function GetFacilityName($id){
 return $this->db->get_where('facilitylist', array('FacilityID'=>$id))->row_array();
}


public function GetBabyWeightPDF($id){
 return $this->db->get_where('baby_admission', array('BabyID'=>$id))->row_array();
} 
 
  
public function MotherAssessment(){
   $adminData = $this->session->userdata('adminData');  
   if($adminData['Type']=='1') {
     $this->db->order_by('id','Desc');
     return $this->db->get_where('mother_monitoring')->result_array(); 
   }else{
    $lounge = $this->GetLoungeIdByFacilitiesID($adminData['Id']);
      foreach ($lounge as $key => $value) {
     return $this->db->get_where('mother_monitoring', array('LoungeID' => $value['LoungeID']))->result_array();

    }   
  }
} 
  public function BabyAssessment(){
   $adminData = $this->session->userdata('adminData');  
  
   if($adminData['Type']=='1') {
     $this->db->order_by('id','Desc');
     return $this->db->get_where('baby_monitoring')->result_array(); 
   }else{
    $lounge = $this->GetLoungeIdByFacilitiesID($adminData['Id']);
      foreach ($lounge as $key => $value) {
     return $this->db->get_where('baby_monitoring', array('LoungeID' => $value['LoungeID']))->result_array();
    }
   }       
} 

public function getLatestMotherViaLoungeID($LoungeID){
       return $this->db->query("select * from mother_registration as mr inner join baby_registration as br on br.`MotherID`=mr.`MotherID` inner join baby_admission as ba on ba.`BabyID`=br.`BabyID` where ba.`LoungeID`=".$LoungeID." order by mr.`MotherID` desc limit 0,8")->result_array();

      //echo $this->db->lasst_query();
}

public function getLatestMother(){
   $this->db->order_by("MotherID", "desc");
   $this->db->limit("8");
   $adminData = $this->session->userdata('adminData'); 
if($adminData['Type']=='1') {
  return $this->db->get_where('mother_registration')->result_array();
   }
 else {

       return $this->db->get_where('mother_registration',array('FacilityID' => $adminData['Id']))->result_array(); 
   
 }
}

public function getQuickEmail(){
  return $this->db->get_where('settings')->row_array();
}

public function CountByDate($addDate) {
  return $this->db->get_where('mother_registration',array('AddDate' => $addDate))->num_rows();
  }


public function GetFacilityListForMap() {
   $adminData = $this->session->userdata('adminData'); 
if($adminData['Type']=='1') {
  return $this->db->query("select * from facilitylist WHERE  Address!='' AND Latitude !='0' AND Longitude!='0'")->result_array();
 }else{
  return $this->db->query("select * from facilitylist WHERE  Address!='' AND Latitude !='0' AND Longitude!='0' AND FacilityID='$adminData[Id]' ")->result_array();
 }
}

public function FindMobileForResend($id) {
  $query = $this->db->get_where('facilitylist', array('FacilityID'=> $id));
  return $query->row_array();
}

public function GetLoungeIdByFacilitiesID($id){
  return $this->db->get_where('lounge_master', array('FacilityID'=>$id))->result_array();
 }
public function GetAdminInfo(){
  return $this->db->get_where('admin_master', array('id'=>1))->row_array();
}


public function GetlatestNotification() {
   $this->db->order_by("ID", "desc");
   $this->db->limit("5");
  return $this->db->get_where('notification')->result_array();
}
public function GetlatestSms() {
   $this->db->order_by("ID", "desc");
   $this->db->limit("5");
  return $this->db->get_where('smsmaster')->result_array();
}

public function CountNotification($notificationTime) {
      $query1 = $this->db->query("select * from notification where AddDate >'$notificationTime'")->num_rows();
      $data['notification']         = $query1;
      return $data;
    }


public function CountSMS($SMSTime) {
      $query1 = $this->db->query("select * from smsmaster where AddDate >'$SMSTime'")->num_rows();
      $data['smsmaster']         = $query1;
      return $data;
    }


public function getBabysBYID($Id){
   return  $this->db->get_where('baby_registration',array('BabyID'=>$Id))->row_array(); 
  }

public function GetSupplimentById($id){
 return $this->db->get_where('supplimentmaster', array('ID'=>$id))->row_array();
} 

public function GetBabyDanger($id){
 return $this->db->query("select * from baby_monitoring where BabyID='$id' order by id DESC limit 0,1")->row_array();
} 

public function ChangePassword($NewPassword){
         $this->db->set('password',$NewPassword);
         $this->db->where('id','1');
  return $this->db->update('admin_master');
 }

public function GetVideoType(){
   $this->db->order_by("VideoTypeName", "ASC");
  return $this->db->get_where('video_type',array('Status'=>'1'))->result_array();
 }

public function GetVideoTypeById($id){
 return $this->db->get_where('video_type', array('ID'=>$id))->row_array();
}

public function GetDataInSettings(){
  return $this->db->get_where('settings', array('ID'=>'1'))->row_array();
} 

public function GetStaffType(){
  return $this->db->get_where('staff_type')->result_array();
}

public function GetStaffType1(){
  return $this->db->get_where('staff_type',array('ParentID'=>'0'))->result_array();
}

public function getSubTypeBYParrentID($id){
  return $this->db->get_where('staff_type',array('ParentID'=>$id))->row_array();
} 

public function GetStaffTypeById($id){
  return $this->db->get_where('staff_type',array('StaffTypeID'=>$id))->row_array();
} 

public function GetStaffTypeBBYIDD($id){
 return $this->db->get_where('staff_type',array('StaffTypeID'=>$id))->row_array();
}
public function getDoctorByMobile($mobile){
 return $this->db->get_where('staff_master',array('StaffMoblieNo'=>$mobile))->row_array();
}
public function GetCurrentMonthRegistredMother($FirstDayTimeStamp,$LastDayTimeStamp){
$adminData = $this->session->userdata('adminData'); 
if($adminData['Type']=='1') { 
 return $this->db->query("select * from mother_registration WHERE AddDate BETWEEN $FirstDayTimeStamp AND $LastDayTimeStamp")->num_rows();
}else{
   $facility_ID    = $adminData['Id'];
  return $this->db->query("select * from mother_registration WHERE AddDate BETWEEN $FirstDayTimeStamp AND $LastDayTimeStamp AND FacilityID='$facility_ID'")->num_rows();
 }
}
public function GetCurrentMonthRegistredBabies($FirstDayTimeStamp,$LastDayTimeStamp){ $adminData = $this->session->userdata('adminData'); 
if($adminData['Type']=='1') { 
 return $this->db->query("select * from baby_registration WHERE add_date BETWEEN $FirstDayTimeStamp AND $LastDayTimeStamp")->num_rows();
}else{
   $facility_ID    = $adminData['Id'];
  return $this->db->query("select * from baby_registration WHERE add_date BETWEEN $FirstDayTimeStamp AND $LastDayTimeStamp AND DeliveryFacilityID='$facility_ID'")->num_rows();
 
  }
} 

public function getFacilityStatusActive(){
  return $this->db->get_where('lounge_master',array('status'=>1))->result_array();
} 

public function GetLastAdmittedBaby($id){
 return $this->db->query("select * from baby_admission where BabyID='$id' order by id DESC limit 0,1")->row_array();
} 

public function GetMotherForChecklist($id){
 return $this->db->query("select * from mother_monitoring where MotherID='$id' order by id asc limit 0,1")->row_array();
} 
public function GetBabyForChecklist($id){
 return $this->db->query("select * from baby_monitoring where BabyID='$id' order by id asc limit 0,1")->row_array();
} 

public function getCurrentBabyInHour($LoungeID='')
{ 
  if($LoungeID != ''){
      return $getValue = $this->db->query("select * from skintoskin_touch_master where (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") and LoungeID=".$LoungeID."")->num_rows();
    }else{
       return $getValue = $this->db->query("SELECT baby_admissionID,@totsec:=sum(TIME_TO_SEC(subtime(EndTime,StartTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `skintoskin_touch_master` where StartTime < EndTime group by baby_admissionID")->result_array();
    }

}

public function getExCurrentDateFeeding($startDateTime,$endDateTime,$LoungeID='')
{ 
  if($LoungeID != ""){
      return $getValue = $this->db->query("select BabyID from breast_feeding_master where FeedingType='1' and LoungeID=".$LoungeID." and (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") group by BabyID")->num_rows();
   }else {
        return $getValue = $this->db->query("select BabyID from breast_feeding_master where FeedingType='1' and (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") group by BabyID")->num_rows();
   }

}

public function getNonExCurrentDateFeeding($startDateTime,$endDateTime,$LoungeID='')
{ 

  if($LoungeID != ""){
    return $getValue = $this->db->query("select BabyID from breast_feeding_master where FeedingType != '1' and LoungeID=".$LoungeID." and (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") group by BabyID")->num_rows();
   }else {
    return $getValue = $this->db->query("select BabyID from breast_feeding_master where FeedingType != '1' and (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") group by BabyID")->num_rows();
   }  
  
}
public function getTotalAdmittedChild($LoungeID='')
{ 
  if($LoungeID != ""){
    return $getValue = $this->db->query("select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' and ba.`LoungeID`=".$LoungeID." group by bm.`BabyID`")->num_rows();
   }else {
      return $getValue = $this->db->query("select bm.`BabyID` from baby_admission as ba inner join baby_monitoring as bm on ba.`BabyID`=bm.`BabyID` where ba.`status`='1' group by bm.`BabyID`")->num_rows();
   }
  
}
public function getExexistingFeeding($startDateTime,$endDateTime,$LoungeID='')
{ 
  if($LoungeID != ""){
    return $getValue = $this->db->query("select BabyID from breast_feeding_master where (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") and LoungeID=".$LoungeID." group by BabyID")->num_rows();
   }else {
    return $getValue = $this->db->query("select BabyID from breast_feeding_master where AddDate BETWEEN ".$startDateTime." AND ".$endDateTime." group by BabyID")->num_rows();
   }
 // echo $this->db->last_query();exit();
}

public function getGivenKMC($startDateTime,$endDateTime,$LoungeID='')
{
  if($LoungeID != ""){
   return $getValue = $this->db->query("select BabyID from skintoskin_touch_master where LoungeID=".$LoungeID." and StartTime < EndTime and (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") group by BabyID")->num_rows();
   }else {
    return $getValue = $this->db->query("select BabyID from skintoskin_touch_master where StartTime < EndTime and (AddDate BETWEEN ".$startDateTime." AND ".$endDateTime.") group by BabyID")->num_rows();
   }
}

}
 ?>