<?php
class BabyModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  ##################################### Baby Listing Queries ###################
  // count all Babies via lounge
  public function countAllBabies($loungeID,$type=false){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    if($type == 'all'){

      $timestamp = date('Y-m-d H:i:s', strtotime('today midnight'));
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `babyAdmission` WHERE addDate >= '".$timestamp."' and status != 4 ".$where_lounge_baby." ")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeID." AND addDate >= '".$timestamp."' and status != 4")->num_rows();
      }
    } else {
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `babyAdmission` WHERE status != 4 ".$where_lounge_baby." ")->num_rows();
      } else { 
       return $this->db->query("SELECT * FROM `babyAdmission` WHERE status != 4 and `loungeId` = ".$loungeID)->num_rows();
      }
    }
  }

  // count and get data of all babies where admitted or discharged via lounge
  public function countBabiesWhereStatus($loungeID,$status,$type){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    // type 1 for num rows and 2 for get data
    $timestamp = date('Y-m-d H:i:s', strtotime('today midnight'));
    if($type == '1'){
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `babyAdmission` WHERE `status` = ".$status." ".$where_lounge_baby." ")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `babyAdmission` WHERE `loungeId` = ".$loungeID." AND `status` = ".$status)->num_rows();
      }
    }else{
      if($loungeID == 'all'){
        if(!empty($getCoachLounge['coachLoungeArray'])){ 
          $this->db->where_in('loungeId',$getCoachLounge['coachLoungeArray']);
        }
        return $this->db->get_where('babyAdmission', array('status'=>$status))->result_array();
      } else {
        return $this->db->get_where('babyAdmission', array('loungeId'=>$loungeID,'status'=>$status))->result_array();
      }
    }
  }

  // get data of all babies via lounge with limit
  public function getAllBabies($loungeID,$limit,$offset,$status='',$type=false){

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    if($type == 'all'){ 
      $timestamp = date('Y-m-d H:i:s', strtotime('today midnight'));
      if($loungeID == 'all'){
        $timestamp_qry = "WHERE addDate >= '".$timestamp."' and status != 4";
      } else {
        $timestamp_qry = "WHERE addDate >= '".$timestamp."' and status != 4 and";
      }
    } else { 
      $timestamp_qry = "WHERE status != 4 ";
    }
    
    if(empty($status)){
      if($loungeID == 'all'){ 
        $result = $this->db->query("SELECT * FROM `babyAdmission` ".$timestamp_qry." ".$where_lounge_baby." ORDER BY `id` DESC LIMIT ".$offset.", ".$limit)->result_array();
      } else {
        $result = $this->db->query("SELECT * FROM `babyAdmission` ".$timestamp_qry." `loungeId` = ".$loungeID." ORDER BY `id` DESC LIMIT ".$offset.", ".$limit)->result_array();
      }
    }else{
      if($loungeID == 'all'){ 
        $result = $this->db->query("SELECT * FROM `babyAdmission` ".$timestamp_qry." and status = ".$status." ".$where_lounge_baby." ORDER BY `id` DESC LIMIT ".$offset.", ".$limit)->result_array();
      } else { 
        $result = $this->db->query("SELECT * FROM `babyAdmission` ".$timestamp_qry." `loungeId` = ".$loungeID." AND status = ".$status."  ORDER BY `id` DESC LIMIT ".$offset.", ".$limit)->result_array();
      }
    }
    return $result;
  }

  // get all baby data where search any keyword with limit
  public function getBabyWhereSearchingBkup($keyword,$loungeID,$limit,$offset,$status,$fromDate,$toDate){
    if(empty($status)){
      if(!empty($keyword)){
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."' and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."' and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."' order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."' order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    }else{
      if(!empty($keyword)){
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    }
  }  

  // count baby Assessment where serching any keyword via lounge
  public function babyMonitoringCountWithSearching($loungeID,$keyword){
    return $this->db->query("SELECT * FROM `babyDailyMonitoring` as bm inner join babyRegistration as br on br.`babyId` = bm.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where bm.`loungeId` = ".$loungeID." and ( mr.`motherName` Like '%$keyword%' OR bm.`BabyMeasuredWeight` Like '%$keyword%' OR bm.`BabyHeadCircumference` Like '%$keyword%' OR bm.`BabyRespiratoryRate` Like '%$keyword%' OR bm.`BabyTemperature` Like '%$keyword%' OR bm.`BabyPulseSpO2` Like '%$keyword%' OR bm.`BabyPulseRate` Like '%$keyword%' OR bm.`MotherBreastStatus` Like '%$keyword%')")->num_rows();
  }

  // get All Baby Via lounge with limit
  public function getAllAssessments($loungeID,$limit,$offset){
    $this->db->order_by('id', 'desc');
    $this->db->limit($limit, $offset);
    return $this->db->get_where('babyDailyMonitoring', array('loungeId'=>$loungeID))->result_array();
  } 

  // get mother info
  public function getMotherRegistration($motherId){
    $this->db->select('motherRegistration.*,motherAdmission.status as admissionStatus');
    $this->db->join('motherAdmission','motherAdmission.motherId=motherRegistration.motherId','left');
    return $this->db->get_where('motherRegistration', array('motherRegistration.motherId'=>$motherId))->row_array();
  } 

  // get All Baby monitoring data where seaching any keyword with limit
  public function getAllAssessmentWhereSearching($keyword,$loungeID,$limit,$offset){
    return $this->db->query("SELECT * FROM `babyDailyMonitoring` as bm inner join babyRegistration as br on br.`babyId` = bm.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where bm.`loungeId` = ".$loungeID." and ( mr.`MotherName` Like '%$keyword%' OR bm.`BabyMeasuredWeight` Like '%$keyword%' OR bm.`BabyHeadCircumference` Like '%$keyword%' OR bm.`BabyRespiratoryRate` Like '%$keyword%' OR bm.`BabyTemperature` Like '%$keyword%' OR bm.`BabyPulseSpO2` Like '%$keyword%' OR bm.`BabyPulseRate` Like '%$keyword%' OR bm.`MotherBreastStatus` Like '%$keyword%') order By bm.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
  } 

  //get total kmc by id of table babyDailyKMC
  public function totalKmcBYID($kmcID, $startTime, $endTime){
   
    return $this->db->query("SELECT babyAdmissionId, time(sum(TIMEDIFF('".$endTime."','".$startTime."'))) as kmcTime from `babyDailyKMC` where id='".$kmcID."'")->row_array();
    
  }

  // get total milk by babyAdmissionId
  public function getTotalMilk($asmissionID){
    return $this->db->query("SELECT babyAdmissionId,sum(MilkQuantity) as quantityOFMilk FROM `babyDailyNutrition` where babyAdmissionId='".$asmissionID."' group by babyAdmissionId")->row_array();
  }

  // get total kmc via babyAdmissionId
  public function totalKmcBYAdmissionID($asmissionID){
   return $this->db->query("SELECT @totsec:=sum(TIME_TO_SEC(subtime(endTime,startTime))) as kmcTimeLatest, floor(@totsec/3600) as Hours, (@totsec%3600)/60 as Minutes, (@totsec%60) as seconds from `babyDailyKMC` where startTime < endTime and babyAdmissionId='".$asmissionID."' and isDataValid=1")->row_array();
  }

  
  // count babies where serching any keyword via lounge
  public function countBabyWhereSearchingBkUp($loungeID,$keyword,$status,$fromDate,$toDate){
    if(empty($status)){
      if(!empty($keyword)){
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."' and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%')")->num_rows();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."' and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%')")->num_rows();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."'")->num_rows();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."'")->num_rows();
        }
      }
    }else{
      if(!empty($keyword)){
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%')")->num_rows();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%')")->num_rows();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status)->num_rows();
        } else {
          return $this->db->query("select * from babyRegistration as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ba.`addDate` between '".$fromDate."' AND '".$toDate."' and ba.`status`=".$status)->num_rows();
        }
      }
    }
  }  


  public function countBabyWhereSearching($loungeID,$keyword,$babyStatus,$fromDate,$toDate,$facilityname,$nurseid,$district,$dischargeType=false,$admissionType=false){

    if(!empty($this->input->get('fromDate'))){ 
      $startDate = explode('-',$this->input->get('fromDate'));  
      $explodeStartDate = explode(" ",trim($startDate[0]));
      $explodeDate =  explode("/",$explodeStartDate[0]);
      $selectedFromDate = date("Y-m-d H:i:s", strtotime($explodeDate[1]."-".$explodeDate[0]."-".$explodeDate[2]." ".$explodeStartDate[1]." ".$explodeStartDate[2])); 
    } else {
      $selectedFromDate = ""; 
    }
    if(!empty($this->input->get('fromDate'))){
      $endDate = explode('-',$this->input->get('fromDate'));  
      $explodeEndDate = explode(" ",trim($endDate[1]));
      $explodeDate =  explode("/",$explodeEndDate[0]);
      $selectedToDate = date("Y-m-d H:i:s", strtotime($explodeDate[1]."-".$explodeDate[0]."-".$explodeDate[2]." ".$explodeEndDate[1]." ".$explodeEndDate[2]));
    } else {
      $selectedToDate = ""; 
    }

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }


    if($babyStatus == "1" || $babyStatus == "3"){

      if($babyStatus == "1"){
        $admitStatus = "ba.`status`=1";
      }else{
        $admitStatus = "ba.`status`!=4";
      }

      if($admissionType == "1"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ba.`status`='3' AND mr.`type` = 1 AND ";
      }elseif($admissionType == "2"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ".$admitStatus." AND ba.`status` !='3' AND mr.`type` = 1 AND ";
      }elseif($admissionType == "3"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Dead%' OR mr.`notAdmittedReason` Like 'मृत%') AND ";
      }elseif($admissionType == "4"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Baby was referred%' OR mr.`notAdmittedReason` Like 'बेबी को रेफर किया%') AND ";
      }elseif($admissionType == "5"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Mother is in a different%' OR mr.`notAdmittedReason` Like 'माँ एक ही अस्पताल%') AND ";
      }elseif($admissionType == "6"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 2 AND ";
      }elseif($admissionType == "7"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Other%' OR mr.`notAdmittedReason` Like 'अन्य%') AND ";
      }else{
        $statusQry = "".$admitStatus." AND ";
      }

    } elseif($babyStatus == "2"){
      // search by discharge type
      if(!empty($dischargeType)){
        $dischargeType = '"'.$dischargeType.'"';
        $dischargeTypeFilter = " AND ba.`typeOfDischarge`= ".$dischargeType." ";
      }else{
        $dischargeTypeFilter = "";
      }
      $statusQry = " ba.`status`=".$babyStatus." ".$dischargeTypeFilter." and ";
    } else {
      $statusQry = " ba.`status` != 4 and ";
    }

    // date filter
    if(!empty($selectedFromDate) && !empty($selectedToDate) && ($babyStatus == '2')){
      $dateFilter = " ba.`dateOfDischarge` between '".$selectedFromDate."' AND '".$selectedToDate."' ";
    }else{
      $dateFilter = " ba.`addDate` between '".$fromDate."' AND '".$toDate."' ";
    }

    if(!empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%')")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter."")->num_rows();
      }
    } else if(!empty($loungeID) && empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%')")->num_rows();
      } else { 
        return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ".$dateFilter."")->num_rows();
      }
    } else if(empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." ")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." ".$where_lounge_baby." ")->num_rows();
      }
    } else {
      if(!empty($facilityname)) { 
        if(!empty($keyword)){       
          return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." ")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ".$dateFilter." ".$where_lounge_baby." ")->num_rows();
        }
      } else if(!empty($district)) { 
        if(!empty($keyword)){     
          return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." ")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ".$dateFilter." ".$where_lounge_baby." ")->num_rows();
        }
      } else { 
        if(!empty($keyword)){ 
          return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ".$dateFilter." and ".$statusQry." (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." ")->num_rows();
        } else { 
          return $this->db->query("SELECT * FROM `babyRegistration` as br inner join babyAdmission as ba on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ".$statusQry." ".$dateFilter." ".$where_lounge_baby." ")->num_rows();
        }
      }
    }
  }  


  public function getBabyWhereSearching($loungeID,$keyword,$babyStatus,$fromDate,$toDate,$facilityname,$nurseid,$district,$limit,$offset,$dischargeType=false,$admissionType=false){

    if(!empty($this->input->get('fromDate'))){ 
      $startDate = explode('-',$this->input->get('fromDate'));  
      $explodeStartDate = explode(" ",trim($startDate[0]));
      $explodeDate =  explode("/",$explodeStartDate[0]);
      $selectedFromDate = date("Y-m-d H:i:s", strtotime($explodeDate[1]."-".$explodeDate[0]."-".$explodeDate[2]." ".$explodeStartDate[1]." ".$explodeStartDate[2])); 
    } else {
      $selectedFromDate = ""; 
    }
    if(!empty($this->input->get('fromDate'))){
      $endDate = explode('-',$this->input->get('fromDate'));  
      $explodeEndDate = explode(" ",trim($endDate[1]));
      $explodeDate =  explode("/",$explodeEndDate[0]);
      $selectedToDate = date("Y-m-d H:i:s", strtotime($explodeDate[1]."-".$explodeDate[0]."-".$explodeDate[2]." ".$explodeEndDate[1]." ".$explodeEndDate[2]));
    } else {
      $selectedToDate = ""; 
    }

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }

    if($babyStatus == "1" || $babyStatus == "3"){

      if($babyStatus == "1"){
        $admitStatus = "ba.`status`=1";
      }else{
        $admitStatus = "ba.`status`!=4";
      }

      if($admissionType == "1"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ba.`status`='3' AND mr.`type` = 1 AND ";
      }elseif($admissionType == "2"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ".$admitStatus." AND ba.`status` !='3' AND mr.`type` = 1 AND ";
      }elseif($admissionType == "3"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Dead%' OR mr.`notAdmittedReason` Like 'मृत%') AND ";
      }elseif($admissionType == "4"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Baby was referred%' OR mr.`notAdmittedReason` Like 'बेबी को रेफर किया%') AND ";
      }elseif($admissionType == "5"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Mother is in a different%' OR mr.`notAdmittedReason` Like 'माँ एक ही अस्पताल%') AND ";
      }elseif($admissionType == "6"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 2 AND ";
      }elseif($admissionType == "7"){
        $statusQry = "mr.`isMotherAdmitted`='No' and ".$admitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Other%' OR mr.`notAdmittedReason` Like 'अन्य%') AND ";
      }else{
        $statusQry = "".$admitStatus." AND ";
      }

    } elseif($babyStatus == "2"){
      // search by discharge type
      if(!empty($dischargeType)){
        $dischargeType = '"'.$dischargeType.'"';
        $dischargeTypeFilter = " AND ba.`typeOfDischarge`= ".$dischargeType." ";
      }else{
        $dischargeTypeFilter = "";
      }
      $statusQry = " ba.`status`=".$babyStatus." ".$dischargeTypeFilter." and ";
    } else {
      $statusQry = " ba.`status` != 4 and ";
    }

    // date filter
    if(!empty($selectedFromDate) && !empty($selectedToDate) && ($babyStatus == '2')){
      $dateFilter = " ba.`dateOfDischarge` between '".$selectedFromDate."' AND '".$selectedToDate."' ";
    }else{
      $dateFilter = " ba.`addDate` between '".$fromDate."' AND '".$toDate."' ";
    }

    if(!empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    } else if(!empty($loungeID) && empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else { 
        return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`loungeId`=".$loungeID." AND ".$statusQry." ".$dateFilter." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    } else if(empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    } else {
      if(!empty($facilityname)) { 
        if(!empty($keyword)){       
          return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ".$dateFilter." ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else if(!empty($district)) { 
        if(!empty($keyword)){     
          return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ".$dateFilter." and (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ".$dateFilter." ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else { 
        if(!empty($keyword)){ 
          return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ".$dateFilter." and ".$statusQry." (ba.`babyFileId` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR br.`babyGender` Like '%{$keyword}%' OR br.`deliveryType` Like '%{$keyword}%') ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `babyAdmission` as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` inner join motherRegistration as mr on mr.`motherId` = br.`motherId` where ".$statusQry." ".$dateFilter." ".$where_lounge_baby." order By ba.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    }
  }          

  // get all babies data or via lounge if LoungeId available
  public function Baby($LoungeId=''){
    if($LoungeId != ''){     
     return $this->db->query("select ba.*,ba.`status` as StatusDis from babyAdmission as ba inner join babyRegistration as br on ba.`babyId`= br.`babyId` where ba.`loungeId`=".$LoungeId." order by ba.`id` DESC")->result_array();
    }else{
      return $this->db->query("select * from babyAdmission as ba left join babyRegistration as br on ba.`babyId`= br.`babyId`")->result_array(); 
    }
  }

  // get data from table via motherId
  public function getMotherDataById($table ,$Id){
    return $this->db->get_where($table,array('motherId'=>$Id))->row_array();
  }

  // get baby data via motherId
  public function getAllBabyViaMotherId($motherID){
    return $this->db->query("select * from babyAdmission as ba left join babyRegistration as br on ba.`babyId`= br.`babyId` where br.`motherId`=".$motherID."")->result_array();
  }

  // get data from table via babyId
  public function getBabyDataById($table ,$Id){
    return $this->db->get_where($table,array('babyId'=>$Id))->row_array();
  } 

  // get staff data via staffId
  public function getStaffNameBYID($Id){
    return $this->db->get_where('staffMaster',array('staffId'=>$Id))->row_array();
  } 

  // get last baby monitoring data via babyId
  public function GetBabyAssessmentData($Id){
    return $this->db->get_where('babyDailyMonitoring',array('babyId'=>$Id))->row_array();
  }

  // get all baby monitoring data via babyId in desc order
  public function getBabyById($Id){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyDailyMonitoring',array('babyId'=>$Id))->result_array();
  }

  // get all baby monitoring data via babyId in desc order
  public function getBabysBYAdmisionId($Id,$lastId){
    $this->db->order_by('id','asc');
    return  $this->db->get_where('babyDailyMonitoring',array('babyAdmissionId'=>$lastId))->result_array();
  }

  // get last baby weight data via babyId 
  public function getBabyWeightById($baby_id){
    return  $this->db->get_where('babyDailyWeight',array('babyId'=>$baby_id))->row_array();
  }

  // get lounge data by loungeId
  public function GetLoungeById($id){
    return $this->db->get_where('loungeMaster', array('loungeId'=>$id))->row_array();
  }
  
  // get babyAdmission data via babyId
  public function getBabyRecord($baby_id){ 
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyAdmission',array('babyId'=>$baby_id))->row_array();
  }  
  
  // get babyAdmission data via id
  public function getBabyRecordByAdmisonId($id){
    return  $this->db->get_where('babyAdmission',array('id'=>$id))->row_array();
  }   
  
  
  // baby pdf generate
  public function BabypdfGenrate($baby_id,$pdfFilePath){
      $BabyssessmentData  = $this->GetBabyAssessmentData($baby_id);
      $BabyData   = $this->getBabyDataById('babyRegistration',$baby_id);
      $motherName = $this->getMotherDataById('motherRegistration',$BabyData['motherId']);
      $CurrentWieght = $this->getBabyWeightById($baby_id);
      $MotherLmpDate =strtotime($motherName['MotherLmpDate']);
      $DeliveryDate =strtotime($BabyData['DeliveryDate']);
      $datediff =$MotherLmpDate - $DeliveryDate;
      $lmpDeliveryDiffrent = round($datediff / (60 * 60 * 24));
       error_reporting(0); 
       $A='123456';
        $html .= '<div style="text-align:center;"><u>Baby &nbsp;Brief&nbsp;Report&nbsp;at&nbsp;the&nbsp;time&nbsp;of&nbsp;Discharge</u></div>';
        $html .= '<div style="margin-top:30px"><table><tr><td style="width:250px;">Baby File ID<br/><br/>'.$baby_id.'</td><td style="border-left: 1px solid black;height: 30px;"></td><td style="width:250px;">B/O<br><br>'.$motherName['MotherName'].'<td style="border-left: 1px solid black;height: 30px;"></td><td> Sex<br><br>'.$BabyData['BabyGender'].'</td></tr> 
                 </table><hr/><table><tr><td style="width:250px;">Delivery Type<br><br>'.$BabyData['DeliveryType'].'</td><td style="border-left: 1px solid black;height: 30px;"></td><td style="width:250px;">Delivery Date & Time<br><br>'.$BabyData['DeliveryDate'].'&nbsp;&nbsp;'.$BabyData['DeliveryTime'].'<td style="border-left: 1px solid black;height: 30px;"></td><td>Gest.Age at birth<br><br>'.$lmpDeliveryDiffrent.'&nbsp;days</td></tr> 
                 </table><hr/><table><tr><td style="width:250px;">Birth Weight<br/><br/>'.$BabyData['BabyWeight'].'</td><td style="border-left: 1px solid black;height: 30px;"></td><td style="width:250px;">Current Weight<br/><br/>'.$CurrentWieght['BabyWeight'].'<td style="border-left: 1px solid black;height: 30px;"></td><td>Tempererature<br><br/><span style="color:red;">'.$BabyssessmentData['BabyTemperature'].' <sup>0 </sup>F<span></td></tr> 
                 </table><hr/><table><tr><td style="width:250px;">Sp02<br/><br/><span style="color:red;">'.$BabyssessmentData['BabyPulseSpO2'].'&nbsp;&nbsp;%</span></td><td style="border-left: 1px solid black;height: 30px;"></td><td style="width:250px;">Heart Beat<br><br/>'.$BabyssessmentData['BabyPulseRate'].'&nbsp;/&nbsp;min<td style="border-left: 1px solid black;height: 30px;"></td><td>Respiratory Rate<br/><br/><span style="color:red;">'.$BabyssessmentData['BabyRespiratoryRate'].'&nbsp;/&nbsp;min</span></td></tr> 
                 </table><hr/><table><tr><td style="width:330px;">Other Danger Signs<br><br>';
                    $data =json_decode($BabyssessmentData['BabyOtherDangerSign'], true);
                  if(count($data) > 0){
                      $count=1;
                    foreach ($data as $key => $value) {
         $html .= '<ul><li style="font-size:15px;"><b style="color:red;">'.$value['name'].'<li></ul>';
                   } } else {
         $html .='<span style="color:green">No Danger Sign</span>';
            }
                $html .='</td><td>Other Observation<br/><br/>'.$BabyssessmentData['Other'].'</td></tr> 
                 </table></div>';
       
        $this->load->library('m_pdf');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
       //generate the PDF from html
        $this->m_pdf->pdf->WriteHTML($PDFContent);
        //download PDF
        $this->m_pdf->pdf->Output();  
  }


  /*Get Kmc data via babyId in desc order */
  public function getBabysSkinBYID($baby_id){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyDailyKMC',array('babyId'=>$baby_id))->result_array();
  }

  /*Get Kmc data via babyId & babyAdmissionId in desc order */
  public function getBabysSkinBYAdmissionID($baby_id,$lastID){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyDailyKMC',array('babyAdmissionId'=>$lastID,'isDataValid'=>1))->result_array();
  }

  /*Get Baby feeding List via babyId in desc order  */
  public function getBabysFeedingBYID($baby_id){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyDailyNutrition',array('babyId'=>$baby_id))->result_array();
  }

  /*Get Baby feeding List via babyId in desc order  */
  public function getBabysFeedingBYAdmissionID($baby_id,$lastID){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyDailyNutrition',array('babyAdmissionId'=>$lastID))->result_array();
  }

  /*Get Baby supplements List */
  public function getBabysSupplimentBYID($baby_id){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babySuppliment',array('babyId'=>$baby_id))->result_array();
  }

  /*Get Baby supplements List via babyId & babyAdmissionId */
  public function getBabysSupplimentBYAdmissionID($baby_id,$lastID){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babySuppliment',array('babyId'=>$baby_id,'babyAdmissionId'=>$lastID))->result_array();
  }

  /*Get Baby vaccination List */
  public function getBabysVaccinationBYID($baby_id){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyVaccination',array('babyId'=>$baby_id))->result_array();
  } 

  /*Get Baby vaccination List via babyId & babyAdmissionId */
  public function getBabysVaccinationBYAdmissionID($baby_id,$lastID){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyVaccination',array('babyAdmissionId'=>$lastID))->result_array();
  }

  /*Get Baby Weight List via babyId */
  public function getBabysWeightBYID($Id){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyDailyWeight',array('babyId'=>$Id))->result_array();
  }

  /*Get Baby Weight List via babyId & babyAdmissionId */
  public function getBabysWeightBYAdmissionID($Id,$lastID){
    $this->db->order_by('id','desc');
    return  $this->db->get_where('babyDailyWeight',array('babyAdmissionId'=>$lastID))->result_array();
  }

  /* get baby data via loungeId between two dates */
  public function getDateWiseBaby($LoungeId,$dateFrom,$dateTo){
    return $this->db->query("select * from babyRegistration as br left join babyAdmission as ba on br.`babyId`=ba.`BabyId` where ba.`LoungeId`=".$LoungeId." and (br.`addDate` between '".$dateFrom."' and '".$dateTo."')")->result_array();  
  } 

  /* Get data from dynamic table and dynamic condition */
  public function getAllTbleBabyAssessment($table){
    $this->db->order_by('id','desc');
    return  $this->db->get_where($table)->result_array();
  }

  /* Get data from table via babyId limit 1 */
  public function GetBabyStatus($table,$id){
    return $this->db->query("select * from ".$table." where babyId=".$id." order by id desc limit 0,1")->row_array();
  }

  /* Get data from table via babyId */
  public function GetBabyViaBabyId($table,$id){
    return $this->db->query("select * from ".$table." where babyId=".$id."")->row_array();
  }

  //check single Baby danger or non-danger icon code
  public function getBabyIcon($get_last_assessment1){
    $checkupCount1 = '0';
    $checkupCount2 = '0';
    $checkupCount3 = '0';
    if(!empty($get_last_assessment1['id'])){
        if($get_last_assessment1['BabyRespiratoryRate'] > 60 || $get_last_assessment1['BabyRespiratoryRate'] < 30){
          $checkupCount1 = 1;
        }

        if($get_last_assessment1['BabyTemperature'] < 95.9 || $get_last_assessment1['BabyTemperature'] > 99.5){
          $checkupCount2 = 1;
        }

        if($get_last_assessment1['BabyPulseSpO2'] < 95 && $get_last_assessment1['IsPulseOximatoryDeviceAvailable']=="Yes"){
           $checkupCount3 = 1;
        }

        if($checkupCount1 == 1 || $checkupCount2 == 1 || $checkupCount3 == 1){
           return '0'; // for danger or unstable (sad)
        }else{
           return '1'; // for happy or stable icon
        }
    }  
    return '0';  
  }


  // count stable and unstable baby code here
  public function countBabySign($getStable){
    $danger         = 0;
    $normal         = 0;
    $checkupCount   = 0;
    $elsecond       = 0;
    $withoutCheckup = 0;
    $admitted       = 0;

    foreach($getStable as $value1) {
      $query = $this->db->query("SELECT * from babyDailyMonitoring where loungeId=".$value1['loungeId']." and babyId=".$value1['babyId']." and babyAdmissionId=".$value1['id']." order by id desc limit 0,1");
      $get_last_assessment1 = $query->row_array();
      $monitoringCheck = $query->num_rows();
      if($monitoringCheck > 0){
         $admitted++;
          if(empty($get_last_assessment1['id'])){
            $danger = $danger+1;
          }
          else
          {  
           $elsecond++;
              if(!empty($get_last_assessment1['BabyRespiratoryRate']) && ($get_last_assessment1['BabyRespiratoryRate'] > 60 || $get_last_assessment1['BabyRespiratoryRate'] < 30)){
                $checkupCount = $checkupCount+1;
              }

            if(!empty($get_last_assessment1['BabyTemperature']) && ($get_last_assessment1['BabyTemperature'] < 95.9 || $get_last_assessment1['BabyTemperature'] > 99.5)){
              $checkupCount = $checkupCount+1;
            }

           if(!empty($get_last_assessment1['BabyPulseSpO2']) && ($get_last_assessment1['BabyPulseSpO2'] < 95 && $get_last_assessment1['IsPulseOximatoryDeviceAvailable']=="Yes")){
              $checkupCount = $checkupCount+1;
            }
          }

        if($checkupCount > 0 && !empty($get_last_assessment1['id']))
        {
          $danger = $danger+1;
        }
        if($elsecond > 0 && $checkupCount == 0 && !empty($get_last_assessment1['id']))
        { 
          $normal = $normal+1;
        } 
      }                   
    }
    $res['stable']       =  $normal;
    $res['unstable']     =  $danger;
    $res['admittedBaby'] =  $admitted;
    return $res;
  }

  //get baby monitoring data via babyId, babyAdmissionId & loungeId
  public function getMonitoringExistData($admisionId){
    return $this->db->query("select * from babyDailyMonitoring where babyAdmissionId=".$admisionId." order by id DESC limit 0,1")->row_array();
  } 

  // get comment data via type, motherOrBabyId & admissionId
  public function getCommentList($type, $userType, $motherOrBabyID, $admissionId){
    if($type == '1'){
      // usertype 1 for mother and 2 is baby
      // else part for count data and type 1 for fetch data 
      return $this->db->query("SELECT * from comments where type=".$userType." and admissionId=".$admissionId." order by id DESC")->result_array();
    }else{
      return $this->db->query("SELECT * from comments where type=".$userType." and admissionId=".$admissionId." order by id DESC")->num_rows();
    }
  }


  function singlerowparameter2($select,$matchWith,$matchingId,$table)
   {
        $tableRecord = & get_instance();
        $tableRecord->load->database();     
        $tableRecord->db->select($select);  
        $query = $tableRecord->db->get_where($table,array($matchWith => $matchingId))->row_array();   
        return $query[$select];       
   }

   /* Get admission checklist */
  public function getAdmissionChecklist($babyAdmissionId){
    $this->db->select('admissionCheckList.*,staffMaster.name as nurseName');
    $this->db->join('staffMaster','staffMaster.staffId=admissionCheckList.nurseId');
    return  $this->db->get_where('admissionCheckList',array('babyAdmissionId'=>$babyAdmissionId))->row_array();
  }

}
?>