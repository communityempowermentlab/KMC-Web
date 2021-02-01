<?php
class DashboardDataModel extends CI_Model {
      public function __construct(){
        parent::__construct();
      $this->load->database();
      }

  // get all lounges by name in asc order
  public function getAllLonges(){
    $this->db->order_by('loungeName','ASC');
    return $this->db->get_where('loungeMaster',array('status'=>1))->result_array();
  }

  // get all mother registration and admission data lounge wise or all lounges
  public function getAllMothersViaLounge($LoungeID=''){
    if($LoungeID != "all"){
    return $this->db->query("select mr.`motherId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId` = mr.`motherId` where ma.`loungeId`=".$LoungeID."")->num_rows();
    }else{
     return $this->db->query("select mr.`motherId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId` = mr.`motherId`")->num_rows();

    }
   }

  // get all baby registration and admission data lounge wise or all lounges
  public function getAllBabysViaLounge($LoungeID=''){
      if($LoungeID != "all"){
       return $this->db->query("select distinct br.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId` = br.`babyId` where ba.`loungeId`=".$LoungeID."")->num_rows();
     }else{
           return $this->db->query("select distinct br.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId`")->num_rows();
          
     }
   }

  // get all mother registration & admission data lounge wise or all lounges between two dates
  public function GetCurrentMonthRegistredMother($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID=''){
  $adminData = $this->session->userdata('adminData'); 
  if($adminData['Type']=='1') { 
    if($LoungeID != "all"){
      return $this->db->query("select distinct ma.`motherId` from motherRegistration as mr inner join babyRegistration as br on br.`motherId`=mr.`motherId` inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join motherAdmission as ma on ma.motherId=mr.motherId where ba.`loungeId`=".$LoungeID." and mr.`addDate` BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."'")->num_rows();
    }else{
       return $this->db->query("select distinct ma.`motherId` from motherRegistration as mr inner join babyRegistration as br on br.`motherId`=mr.`motherId` inner join babyAdmission as ba on ba.`babyId`=br.`babyId` inner join motherAdmission as ma on ma.motherId=mr.motherId where mr.`addDate` BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."'")->num_rows();
    }
   }
  }

  // get all baby registration & admission data lounge wise or all lounges between two dates
  public function GetCurrentMonthRegistredBabies($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID='')
  { 
    $adminData = $this->session->userdata('adminData'); 
    if($adminData['Type']=='1') { 
      if($LoungeID != "all"){
        return $this->db->query("select distinct br.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`loungeId`=".$LoungeID." and br.`addDate` BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."'")->num_rows();
      }else{
         return $this->db->query("select distinct br.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where br.`addDate` BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."'")->num_rows();
      }
    }
  } 

  // get latest mother (with limit 8) registration & admission data lounge wise 
  public function getLatestMother($LoungeID){
    $adminData = $this->session->userdata('adminData'); 
    if($adminData['Type']=='1') {
    return $this->db->get_where("select * from motherRegistration as mr inner join babyRegistration as br on br.`motherId`=mr.`motherId` inner join babyAdmission as ba on ba.`babyId`=br.`babyId` where ba.`loungeId`=".$LoungeID." order by mr.`motherId` desc limit 0,8")->result_array();

    }
  }

  //get total kmc of a particular baby by babyAdmissionId
  public function getTotalKmc($asmissionID){
   
   return $this->db->query("SELECT babyAdmissionId,@totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as kmcTime, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where startTime < endTime and babyAdmissionId='".$asmissionID."' group by babyAdmissionId")->row_array();
    
  }

  //get last 24 hrs kmc of a particular baby by babyAdmissionId
  public function getLatestKMC($startTime,$endTime,$asmissionID){
    return $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as kmcTimeLatest, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where startTime < endTime and babyAdmissionId='".$asmissionID."' and addDate BETWEEN ".$startTime." and ".$endTime."")->row_array();
  }

  //get total kmc lounge between two dates
  public function GetCurrentMonthKMC($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID='')
  { 
    if($LoungeID != 'all'){ 
      $getValue = $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` inner join babyAdmission on `babyDailyKMC`.babyAdmissionId = `babyAdmission`.id where `babyAdmission`.loungeId=".$LoungeID." and (`babyDailyKMC`.addDate BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."')");

      $get = $getValue->row_array(); 
      return $get;
    }else{

      $getValue = $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as totalseconds, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where (addDate BETWEEN '".$FirstDayTimeStamp."' AND '".$LastDayTimeStamp."')");
       
      $get = $getValue->row_array();
      return $get;
    }
  } 

  //get total milkQuantity from babyDailyNutrition lounge wise between two dates
  public function GetCurrentMonthMilk($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID='')
  { 
    $getValue = $this->db->query("SELECT sum(milkQuantity) as quantityOFMilk FROM `babyDailyNutrition` where loungeId='".$LoungeID."' and (addDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp.")");
      $get = $getValue->row_array();
    return $get;
      
  }

  //get all currently admitted mothers lounge wise 
  public function getAllAdmittedMothersViaLounge($LoungeID,$status){
    return $this->db->query("select mr.`motherId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`=".$status." and ma.`loungeId`=".$LoungeID."")->num_rows();
  }

  //get all currently admitted babies lounge wise 
  public function getAllAdmittedBabysViaLounge($LoungeID,$status){
    return $this->db->query("select distinct br.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` where ba.`status`=".$status." and ba.`loungeId`=".$LoungeID."")->num_rows();
  }

  //get total admitted mothers lounge wise
  public function totallyAdmittedMothers($LoungeID){
    return $this->db->query("select mr.`motherId` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$LoungeID."")->num_rows();
   }

  // get all mothers monthly assessments lounge wise between two dates
  public function getMothlyAsssement($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID=''){
    return $this->db->query("select * from motherMonitoring where loungeId=".$LoungeID." and addDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp."")->num_rows();
  }

  // total mother assessment via lounge
  public function totollyAssessmnts($LoungeID=''){
    return $this->db->query("select * from motherMonitoring where loungeId=".$LoungeID."")->num_rows();
  }

  // get all babies monthly assessments lounge wise between two dates
  public function getMothlyBabyAsssement($FirstDayTimeStamp,$LastDayTimeStamp,$LoungeID=''){
    return $this->db->query("select * from dailybabymonitoring where loungeId=".$LoungeID." and addDate BETWEEN ".$FirstDayTimeStamp." AND ".$LastDayTimeStamp."")->num_rows();
  }

  // total baby assessment via lounge
  public function totollyBabyAssessmnts($LoungeID=''){
    return $this->db->query("select * from dailybabymonitoring where loungeId=".$LoungeID."")->num_rows();
  }

  // get total inborn / outborn babies lounge wise
  public function getTotalInbornOutborn($LoungeID,$type,$date){
    return $this->db->query("select distinct ba.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` where br.`typeOfBorn` = '".$type."' and ba.`loungeId`=".$LoungeID." and FROM_UNIXTIME(ba.addDate,'%Y-%m')='".$date."'")->num_rows();
  }

  // get all babies with low birth weight i.e. < 2500 grams lounge wise
  public function getLowBirthWeightBabies($LoungeID,$date){
    return $this->db->query("select distinct ba.`babyId` from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` where br.`BabyWeight` < 2500 and ba.`loungeId`=".$LoungeID." and FROM_UNIXTIME(ba.addDate,'%Y-%m')='".$date."'")->num_rows();
  }

}
?>