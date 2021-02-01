<?php
class SmsModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  // get data from smsMaster in desc order
  public function GetSmsList(){
    $this->db->order_by('id','Desc');
    return $this->db->get_where('smsMaster')->result_array(); 
  } 

  // get data from notification limit 2000
  public function NotificationList(){
    return $this->db->query("select * from notification ORDER BY id DESC LIMIT 2000")->result_array();  
  }

  //get sms data - counting for type 1 else fetching via loungeId
  public function getSmsData($type,$LoungeID,$limit='',$offset=''){
   if ($type == '1') {
     return $this->db->query("select sm.`id` from smsMaster as sm inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`=".$LoungeID."")->num_rows(); 
   } else {
     return $this->db->query("select * from smsMaster as sm inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`=".$LoungeID." order by sm.`ID` desc LIMIT ".$offset.", ".$limit."")->result_array();
    }       
  } 

  // get data from smsMaster with searching via loungeId and limit
  public function getSmsDataWhereSearching($type,$LoungeID,$keyword,$limit='',$offset=''){ 
    if ($type == '1') {
     return $this->db->query("SELECT * from smsMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join babyRegistration as br on br.`babyId` = sm.`babyId` inner join motherRegistration as mr on mr.`motherId`=br.`motherId`  inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`=".$LoungeID." and (fl.`FacilityName` Like '%{$keyword}%' OR sm.`message` Like '%{$keyword}%' OR sm.`time` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%')")->num_rows(); 
    } else {
     return $this->db->query("SELECT * from smsMaster as sm inner join facilitylist as fl on fl.`FacilityID`=sm.`facilityId` inner join babyRegistration as br on br.`babyId` = sm.`babyId` inner join motherRegistration as mr on mr.`motherId`=br.`motherId` inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`=".$LoungeID." and (fl.`FacilityName` Like '%{$keyword}%' OR sm.`message` Like '%{$keyword}%' OR sm.`time` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%') LIMIT ".$offset.", ".$limit."")->result_array();
    }       
  } 

  // get data from smsMaster join loungeMaster via loungeId and between two dates
  public function countingTOSMS($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID){
    return $this->db->query("select sm.`id` from smsMaster as sm inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`=".$LoungeID." and (sm.`addDate` BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp.")")->num_rows(); 
  }

  // get data from smsMaster join loungeMaster via loungeId
  public function getLastDateTime($LoungeID){
    return $this->db->query("select sm.`addDate`,sm.`babyId`,sm.`message` from smsMaster as sm inner join loungeMaster as lm on lm.`facilityId`=sm.`facilityId` where lm.`loungeId`=".$LoungeID." order by sm.`ID` desc")->row_array();  
  }

  // get data from dynamic table via motherId
  public function getMotherDataById($table ,$Id){
    return $this->db->get_where($table,array('motherId'=>$Id))->row_array();
  }

  // get data from facilitylist via FacilityID
  public function GetFacilityName($id){
    return $this->db->get_where('facilitylist', array('FacilityID'=>$id))->row_array();
  }

  // get data from babyRegistration via babyId
  public function getBabyById($Id){
    return $this->db->get_where('babyRegistration',array('babyId'=>$Id))->row_array(); 
  }

  // get data from staffMaster via staffMobileNumber
  public function getDoctorByMobile($mobile){
    return $this->db->get_where('staffMaster',array('staffMobileNumber'=>$mobile))->row_array();
  }

  // get data from loungeMaster via loungeId
  public function GetLoungeById($id){
    return $this->db->get_where('loungeMaster', array('loungeId'=>$id))->row_array();
  }

  //get Notification data where counting and fetching
  public function getNotificationData($type,$LoungeID,$limit='',$offset=''){
    if ($type == '1') {
      return $this->db->query("select * from notification where `loungeId`=".$LoungeID."")->num_rows(); 
    } else {
      return $this->db->query("select * from notification where `loungeId`=".$LoungeID." order by id desc LIMIT ".$offset.", ".$limit."")->result_array();
    }       
  } 

  // searching query where overall Notification
  public function getNotificationDataWhereSearching($type,$LoungeID,$keyword,$limit='',$offset=''){
    if ($type == '1') {
      return $this->db->query("select * from notification  as nt left join motherRegistration as mr on mr.`motherId` = nt.`motherId` where nt.`loungeId`=".$LoungeID." and (mr.`motherName` Like '%{$keyword}%' OR nt.`message` Like '%{$keyword}%')")->num_rows(); 
    } else {
      return $this->db->query("select * from notification  as nt left join motherRegistration as mr on mr.`motherId` = nt.`motherId` where nt.`loungeId`=".$LoungeID." and (mr.`motherName` Like '%{$keyword}%' OR nt.`message` Like '%{$keyword}%')  LIMIT ".$offset.", ".$limit."")->result_array();
   
    }       
  } 

  // get Last Notification via lounge
  public function getNotificaitonLastDateTime($LoungeID){
    return $this->db->query("select * from notification where `loungeId`=".$LoungeID." order by id desc")->row_array();  
  }

  // get Notification via lounge
  public function notificationViaType($type,$LoungeID){
    if($type == '1'){
      return $this->db->query("select * from notification where `loungeId`=".$LoungeID." and `status`='1'")->num_rows(); 
    } else if($type == '2'){
      return $this->db->query("select * from notification where `loungeId`=".$LoungeID." and `status`='2'")->num_rows(); 
    }else if($type == '3'){
      return $this->db->query("select * from notification where `loungeId`=".$LoungeID." and `status`='3'")->num_rows(); 
    }
  }

  // count notification via loungeId between two dates
  public function countingNotificationViaMonth($type,$FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID){
    if($type == '1'){
     return $this->db->query("select * from notification where `loungeId`=".$LoungeID." and `status`='2' and (addDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp.")")->num_rows(); 
    }else{
    return $this->db->query("select * from notification where `loungeId`=".$LoungeID." and `status`='3' and (addDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp.")")->num_rows(); 
    }
  }

  // get Pending Notification
  public function getPending($LoungeID){
    return $this->db->query("select * from notification where `loungeId`=".$LoungeID." and `status`='1' order by addDate desc")->result_array(); 
  }

  
 
}
 ?>