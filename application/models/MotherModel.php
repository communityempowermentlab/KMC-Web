<?php

class MotherModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

    ##################################### Mother Listing Queries ###################
// count all mothers via lounge
  public function countAllMothers($loungeID){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_mother = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_mother = 'AND motherAdmission.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    $timestamp = date('Y-m-d H:i:s', strtotime('today midnight'));
    if($loungeID == 'all'){
      return $this->db->query("SELECT * FROM `motherAdmission` inner join `motherRegistration` on `motherAdmission`.id = `motherRegistration`.motherId WHERE `motherAdmission`.addDate >= '".$timestamp."' ".$where_lounge_mother." ")->num_rows();
    } else {
      return $this->db->query("SELECT * FROM `motherAdmission` inner join `motherRegistration` on `motherAdmission`.id = `motherRegistration`.motherId WHERE `motherAdmission`.`loungeId` = ".$loungeID." AND `motherAdmission`.addDate >= '".$timestamp."'")->num_rows();
    }
  }


  public function countMothersType($loungeID,$type){ 
    if($type == 'admitted'){
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes'")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." and mr.`isMotherAdmitted`='Yes'")->num_rows();
      }
    }else if($type == 'currentlyAvail'){
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='1' and mr.`isMotherAdmitted`='Yes'")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='1' and ma.`loungeId` = ".$loungeID." and mr.`isMotherAdmitted`='Yes'")->num_rows();
      }
    }else if($type == 'dischargedMother'){
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='2' and mr.`isMotherAdmitted`='Yes'")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='2' and ma.`loungeId` = ".$loungeID." and mr.`isMotherAdmitted`='Yes'")->num_rows();
      } 
    }else{ 
      if($loungeID == 'all'){ echo 2;die;
        return $this->db->query("SELECT * FROM `motherRegistration` as mr where mr.`type` != 2")->num_rows(); 
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID)->num_rows(); 
      } 
    }
  }


  public function getAllMotherCount(){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join `babyRegistration` as br on mr.`motherId` = br.`babyId` inner join `babyAdmission` as ba on br.`babyId` = ba.`babyId` where mr.`type` != 2 and ba.`status` != 4 ".$where_lounge_baby." ")->num_rows(); 
  }

  public function getAllMotherList($limit,$offset){ 
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join `babyRegistration` as br on mr.`motherId` = br.`motherId` inner join `babyAdmission` as ba on br.`babyId` = ba.`babyId` where mr.`type` != 2 and ba.`status` != 4 ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
    // echo $this->db->last_query();die;
  }


  // new function to get mothers according to search
   public function totalMotherRecordsSearchBkup($loungeID,$fromDate,$toDate,$motherStatus,$keyword){
    if($motherStatus == 'admitted'){
      if(!empty($keyword)){
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes'")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes'")->num_rows();
        }
      }
    } else if($motherStatus == 'currentlyAvail'){
      if(!empty($keyword)){
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='1' AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='1' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='1' and ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes'")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='1' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes'")->num_rows();
        }
      }
      
    }else if($motherStatus == 'dischargedMother'){
      if(!empty($keyword)){
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='2' and ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='2' and ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
        }
      } else { 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='2' AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes'")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='2' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and mr.`isMotherAdmitted`='Yes'")->num_rows();
        }
      }
    }else{
      if(!empty($keyword)){ 
        if($loungeID == 'all'){
          return  $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows(); 
        } else {
          return  $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows(); 
        }

      } else { 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`addDate` between '".$fromDate."' AND '".$toDate."'")->num_rows(); 
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."'")->num_rows(); 
        }
      }
    }
  }

  public function totalMotherRecordsSearch($loungeID,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus){

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_mother = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_mother = 'AND ma.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    if($motherStatus == 'admitted'){
      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`!='3' AND";
    } else if($motherStatus == 'currentlyAvail'){
      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='1' AND";
    } else if($motherStatus == 'dischargedMother'){
      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='2' AND";
    } else {
      $statusQry = "";
    }
    if(!empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on  br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on  br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."'")->num_rows();
      }
    } else if(!empty($loungeID) && empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%')")->num_rows();
      } else { 
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."'")->num_rows();
      }
    } else if(empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on  br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." ")->num_rows();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on  br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." ")->num_rows();
      }
    } else {
      if(!empty($facilityname)) { 
        if(!empty($keyword)){ 
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." ")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." ")->num_rows();
        }
      } else if(!empty($district)) { 
        if(!empty($keyword)){ 
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." ")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." ")->num_rows();
        }
      } else { 
        if(!empty($keyword)){ 
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." ")->num_rows();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ".$statusQry." ma.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." ")->num_rows();
        }
      }
    }
  }


  public function getMotherRecordSearch($loungeID,$limit,$offset,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus){

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_mother = "";$where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_mother = 'AND ma.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
      $where_lounge_baby = 'AND ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    if($motherStatus == 'admitted'){
      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='1' AND mr.`type` != 2 AND";
    } else if($motherStatus == 'referred'){
      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='3' AND mr.`type` != 2 AND";
    } else if($motherStatus == 'dischargedMother'){
      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='2' AND mr.`type` != 2 AND";
    } else if($motherStatus == ''){
      $statusQry2 = " mr.`type` != 2 AND ba.`status`!='4' AND ";
    } else if($motherStatus == 'notAdmtted'){
      $statusQry2 = " mr.`isMotherAdmitted` = 'No' AND mr.`type` = 3 AND ";
    }
    if(!empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        if($motherStatus == 'notAdmtted' || $motherStatus == ''){
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." ba.`staffId` = ".$nurseid." AND mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }      
      } else {
        if($motherStatus == 'notAdmtted' || $motherStatus == ''){
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." ba.`staffId` = ".$nurseid." AND mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    } else if(!empty($loungeID) && empty($nurseid)){
      if(!empty($keyword)){ 
        if($motherStatus == 'notAdmtted' || $motherStatus == ''){
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else {
        if($motherStatus == 'notAdmtted' || $motherStatus == ''){ 
          if($motherStatus == '') {
            $motherNotAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'No' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            $motherAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join `motherAdmission` as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'Yes' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            return array_merge($motherNotAdmit, $motherAdmit);

          } else {
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          }
        } else { 
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    } else if(empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        if($motherStatus == 'notAdmtted '|| $motherStatus == ''){
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else { 
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." mt.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
        }
      } else {
        if($motherStatus == 'notAdmtted' || $motherStatus == ''){
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else { 
          return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    } else {
      if(!empty($facilityname)) { 
        if(!empty($keyword)){ 
          if($motherStatus == 'notAdmtted' || $motherStatus == ''){
            $motherNotAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            $motherAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'Yes' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            return array_merge($motherNotAdmit, $motherAdmit);

          } else {
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            
          }
        } else {
          if($motherStatus == 'notAdmtted' || $motherStatus == ''){
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

          } else {
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            
          }
        }
      } else if(!empty($district)) { 
        if(!empty($keyword)){ 
          if($motherStatus == 'notAdmtted' || $motherStatus == ''){
            $motherNotAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            $motherAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'Yes' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            return array_merge($motherNotAdmit, $motherAdmit);

          } else { 
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
          }
        } else { 
          if($motherStatus == 'notAdmtted' || $motherStatus == ''){ 
            $motherNotAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            $motherAdmit = $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'Yes' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            return array_merge($motherNotAdmit, $motherAdmit);
              
          } else { 
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
             
          }
        }
      } else {
        if(!empty($keyword)){ 
          if($motherStatus == 'notAdmtted' || $motherStatus == ''){
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          } else {
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
          }
        } else {
          if($motherStatus == 'notAdmtted' || $motherStatus == ''){
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          } else {
            return $this->db->query("SELECT mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          }
        }
      }
    }
  } 


  public function getMotherRecordSearchBkup($loungeID,$limit,$offset,$fromDate,$toDate,$motherStatus,$keyword){
    if($motherStatus == 'admitted'){
      if(!empty($keyword)){ 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else { 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    }elseif($motherStatus == 'currentlyAvail'){
      if(!empty($keyword)){ 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' and ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    }elseif($motherStatus == 'dischargedMother'){
      if(!empty($keyword)){ 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else {
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' and ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' and ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    }else{
      if(!empty($keyword)){ 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else { 
        if($loungeID == 'all'){
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." AND ma.`addDate` between '".$fromDate."' AND '".$toDate."' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    }
  } 


  public function getMotherDataByType($loungeID,$limit,$offset,$type){
    if($type == 'admitted'){
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId` = ".$loungeID." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
      
    }elseif($type == 'currentlyAvail'){
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' and ma.`loungeId` = ".$loungeID." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
      
    }elseif($type == 'dischargedMother'){
      if($loungeID == 'all'){
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' and ma.`loungeId` = ".$loungeID." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
      
    }else{
      if($loungeID == 'all'){ 
        return $this->db->query("SELECT * FROM `motherRegistration` as mr where mr.`type` != 2 order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
      // echo $this->db->last_query();die;
    }
  } 


// count mothers where searching any keyword via loungeId
  public function mothersListWhereSearching($loungeID,$keyword,$motherStatus=''){
    if(!empty($motherStatus) && $motherStatus == 'admitted'){
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%')")->num_rows();
    }elseif(!empty($motherStatus) && $motherStatus == 'currentlyAvail'){
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='1' and ma.`loungeId` = ".$loungeID." and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%')")->num_rows();
    }elseif(!empty($motherStatus) && $motherStatus == 'dischargedMother'){
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`status`='2' and ma.`loungeId` = ".$loungeID." and mr.`isMotherAdmitted`='Yes' and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%')")->num_rows();
    }else{
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%')")->num_rows(); 
    }
  }

 // get All Mothers Via lounge
  public function getAllMothers($loungeID,$limit,$offset,$motherStatus = ''){
    $timestamp = date('Y-m-d H:i:s', strtotime('today midnight'));

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = 'AND ma.loungeId in '.$getCoachLounge['coachLoungeArrayString'].'';
    }

    if(!empty($motherStatus) && $motherStatus == 'admitted'){
      if($loungeID == 'all'){
        return $this->db->query("select mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' ".$where_lounge." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("select mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$loungeID." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    }else if(!empty($motherStatus) && $motherStatus == 'currentlyAvail'){
      if($loungeID == 'all'){
        return $this->db->query("select mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' ".$where_lounge." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("select mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$loungeID." and ma.`status`='1' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    }else if(!empty($motherStatus) && $motherStatus == 'dischargedMother'){
      if($loungeID == 'all'){
        return $this->db->query("select mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' ".$where_lounge." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("select mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$loungeID." and ma.`status`='2' order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    } else {
      if($loungeID == 'all'){ 
        $result = $this->db->query("SELECT * FROM `motherAdmission` as ma WHERE ma.addDate >= '".$timestamp."' ".$where_lounge." ORDER BY ma.id DESC LIMIT ".$offset.", ".$limit)->result_array();
      } else {
        $result = $this->db->query("SELECT * FROM `motherAdmission` WHERE `loungeId` = ".$loungeID." AND addDate >= '".$timestamp."' ORDER BY `id` DESC LIMIT ".$offset.", ".$limit)->result_array();
      }
      return $result;
    }
  } 

  // get All Mothers where seaching any keyword via loungeId and limit
  public function getAllMothersWhereSearching($keyword,$loungeID,$limit,$offset,$motherStatus = ''){
    if(!empty($motherStatus) && $motherStatus == 'admitted'){
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId` = ".$loungeID." and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
    }elseif(!empty($motherStatus) && $motherStatus == 'currentlyAvail'){
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='1' and ma.`loungeId` = ".$loungeID." and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
    }elseif(!empty($motherStatus) && $motherStatus == 'dischargedMother'){
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' and ma.`loungeId` = ".$loungeID." and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
    }else{
      return $this->db->query("SELECT * FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` where ma.`loungeId` = ".$loungeID." and ( ma.`hospitalRegistrationNumber` Like '%{$keyword}%' OR ma.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMoblieNumber` Like '%{$keyword}%') order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
    }
  }   

  ##################################### Mother Assessment Queries ###################


  // get mother data via loungeId if available
  public function Mother($loungeId=''){
    if($loungeId != ""){
      return $this->db->query("select distinct mr.`motherId`,ma.* from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where ma.`loungeId`=".$loungeId." order by mr.`motherId` desc")->result_array();
        //echo $this->db->last_query();exit();
    }else{
      return $this->db->get_where('motherAdmission')->result_array();    
    }      
  } 

  // get motherRegistration data via motherId
  public function GetMotherType($id){
    return $this->db->get_where('motherRegistration', array('motherId'=>$id))->row_array();
  }

  // get motherAdmission data via id
  public function GetMotherStatus($id){ 
    return $this->db->get_where('motherAdmission', array('id'=>$id))->row_array();
  }


  // get motherAdmission data via motherId
  public function GetMotherAdmission($motherId){ 
    return $this->db->get_where('motherAdmission', array('motherId'=>$motherId))->row_array();
  }

  // get babyRegistration data via motherId
  public function GetBabyPdfByMotherID($id){
    return $this->db->get_where('babyRegistration', array('motherId'=>$id))->row_array();
  } 

  // get DistrictNameProperCase from revenuevillagewithblcoksandsubdistandgs via PRIDistrictCode
  public function GetPresentDistrictName($Id){
    $this->db->select('DistrictNameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('PRIDistrictCode'=>$Id))->row_array();
  }

  // get BlockPRINameProperCase from revenuevillagewithblcoksandsubdistandgs via BlockPRICode
  public function GetPresentBlockName($Id){
    $this->db->select('BlockPRINameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('BlockPRICode'=>$Id))->row_array();
  }

  // get GPNameProperCase from revenuevillagewithblcoksandsubdistandgs via GPPRICode
  public function GetPresentVillageName($Id){
    $this->db->select('GPNameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('GPPRICode'=>$Id))->row_array();
  } 

  // get DistrictNameProperCase from revenuevillagewithblcoksandsubdistandgs via PRIDistrictCode
  public function GetPermanentDistrictName($Id){
    $this->db->select('DistrictNameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('PRIDistrictCode'=>$Id))->row_array();
  
  }

  // get BlockPRINameProperCase from revenuevillagewithblcoksandsubdistandgs via BlockPRICode
  public function GetPermanentBlockName($Id){
    $this->db->select('BlockPRINameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('BlockPRICode'=>$Id))->row_array();
  }

  // get GPNameProperCase from revenuevillagewithblcoksandsubdistandgs via GPPRICode
  public function GetPermanentVillageName($Id){
    $this->db->select('GPNameProperCase');
    $this->db->limit('1');
    return $this->db->get_where('revenuevillagewithblcoksandsubdistandgs',array('GPPRICode'=>$Id))->row_array();
  } 

  // get staff data via staffId
  public function getStaffNameBYID($Id){
    return $this->db->get_where('staffMaster',array('staffId'=>$Id))->row_array();
  }

  // get staff data via FacilityID
  public function getFacilityNameBYID($Id){
    return  $this->db->get_where('facilitylist',array('FacilityID'=>$Id))->row_array();
  }
 
  // get babyAdmission data via babyId
  public function GetBabyWeightPDF($id){
    return $this->db->get_where('babyAdmission', array('babyId'=>$id))->row_array();
  }

  public function getBabyAdmission($babyId){
    $this->db->order_by('babyId','Desc');
    return $this->db->get_where('babyAdmission', array('babyId'=>$babyId))->row_array();
  }

  // get motherMonitoring data via motherId & motherAdmissionId
  public function GetMotherAssessmentDataBYID($Id,$lastID=''){
    $this->db->order_by('id','Asc');
    return $this->db->get_where('motherMonitoring',array('motherAdmissionId'=>$lastID))->result_array();
  }

  // get loungeMaster data via loungeId 
  public function GetLoungeById($id){
    return $this->db->get_where('loungeMaster', array('loungeId'=>$id))->row_array();
  }
  
  // get data from table via motherId 
  public function getMotherDataById($table ,$Id){
    return $this->db->get_where($table,array('motherId'=>$Id))->row_array();
  }

  public function getMotherData($table ,$Id){
    return $this->db->get_where($table,array('motherId'=>$Id))->result_array();
  }

  public function getPosterCounsellingLogs($babyArray){
    $this->db->select('babyCounsellingPosterLog.counsellingType,babyCounsellingPosterLog.posterId,babyCounsellingPosterLog.duration,babyCounsellingPosterLog.addDate,counsellingMaster.posterType,counsellingMaster.videoTitle');
    $this->db->join('counsellingMaster','counsellingMaster.id=babyCounsellingPosterLog.posterId');
    $this->db->where_in('babyCounsellingPosterLog.babyId',$babyArray);
    $this->db->group_by('babyCounsellingPosterLog.posterId');
    $this->db->order_by('babyCounsellingPosterLog.id','desc');
    return $this->db->get_where('babyCounsellingPosterLog')->result_array();
  }

  public function getPosterCounsellingPosterLogs($babyArray,$posterId){
    $this->db->select('babyCounsellingPosterLog.*');
    $this->db->where_in('babyCounsellingPosterLog.babyId',$babyArray);
    $this->db->order_by('babyCounsellingPosterLog.id','desc');
    return $this->db->get_where('babyCounsellingPosterLog',array('posterId'=>$posterId))->result_array();
  }

  public function getCounsellingPosterDetails($Id){
    return $this->db->get_where('counsellingMaster',array('id'=>$Id))->row_array();
  }


  // get data from table via motherId 
  public function getBabyOfMotherId($table ,$Id){
    $adminData = $this->session->userdata('adminData');  
    $this->db->order_by('babyId','Desc');

    if ($adminData['type']=='1') {  
      return $this->db->get_where($table,array('motherId'=>$Id))->result_array();
    } 
  } 

  // get babyRegistration & babyAdmission data via motherId
  public function getpdflinkFormBabyAdm($Id){
    return $this->db->query("select babyRegistration.*,babyAdmission.* from babyAdmission inner join babyRegistration on babyRegistration.babyId = babyAdmission.babyId where babyRegistration.motherId = ".$Id."")->row_array();
  }

  // get babyRegistration & babyAdmission data via motherId
  public function getDateWiseMohter($LoungeID,$Datefrom,$Dateto){
    $adminData = $this->session->userdata('adminData');        
    if($adminData['Type']=='1') {
      return $this->db->query("select * from motherRegistration as mr left join motherAdmission as ma on ma.`motherId`=mr.`motherId` where ma.`loungeId`=".$LoungeID." and (mr.`addDate` between '".$Datefrom."' and '".$Dateto."')")->result_array();
       
    }    
  }

  // get data from dynamic table and dynamic column
  public function GetLastAsessment($table,$colName,$id){
    
    return $this->db->query("select * from ".$table." where ".$colName."=".$id." order by id desc limit 0,1")->row_array();
  }

  // get data from dynamic table and dynamic column and motherAdmissionId
  public function GetLastAsessmentBabyOrMother($colName,$lastId){
    if($colName=='motherId'){
      return $this->db->query("select * from motherMonitoring where motherAdmissionId= ".$lastId." order by id desc limit 0,1")->row_array();
    }else if($colName=='babyId')
    {
      return $this->db->query("select * from ".$table." where ".$colName."=".$id." and baby_admissionID= ".$lastId." order by id desc limit 0,1")->row_array();    
    }
  }

  // get data from babyAdmission and via babyId
  public function getBabyViaMotherId($id){
    return $this->db->query("select * from babyAdmission where babyId=".$id." order by id desc limit 0,1")->row_array();
  }

  // get data from table and via motherId
  public function GetAllBabiesViaMother($table ,$Id){
    return $this->db->get_where($table,array('motherId'=>$Id))->num_rows();
  }

  //mother danger or non-danger icon code
  public function getMotherIcon($get_last_assessment){
    $status1 = 0;
    $status2 = 0;
    $status3 = 0;
    $status4 = 0;
    $status5 = 0;
    $status6 = 0;
    $status7 = 0;
    $status8 = 0;
    if(!empty($get_last_assessment['id'])){
      if($get_last_assessment['motherPulse'] < 50 || $get_last_assessment['motherPulse'] > 120){
       $status1 = '1';
      }

      if($get_last_assessment['motherTemperature'] < 95.9 || $get_last_assessment['motherTemperature'] > 99.5){
       $status2 = '1';
      }


     if($get_last_assessment['motherSystolicBP'] >= 140 || $get_last_assessment['motherSystolicBP'] <= 90){
       $status3 = '1';
      }

      if($get_last_assessment['motherDiastolicBP'] <= 60 || $get_last_assessment['motherDiastolicBP'] >= 90){
       $status4 = '1';
      }

      if($get_last_assessment['motherUterineTone'] == 'Hard/Collapsed (Contracted)'){
       $status5 = '1';
      }

      if(!empty($get_last_assessment['episitomyCondition']) && $get_last_assessment['episitomyCondition'] == 'Infected'){
       $status6 = '1';
      }                                   

      if(!empty($get_last_assessment['sanitoryPadStatus']) && $get_last_assessment['sanitoryPadStatus'] == "It's FULL"){
       $status7 = '1';
      }   

      if(!empty($get_last_assessment['motherBleedingStatus']) && $get_last_assessment['motherBleedingStatus'] == "Yes"){
       $status8 = '1';
      }                      

      if($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1 || $status8 == 1)
      {
           return '0';
      }else{
            return '1'; // for happy mother                      
      }
    }
    return '0'; // for sad or unstable mother
  }

  // count stable ana unstable mother code here
  public function countMotherSign($getStable){
    $danger         = 0;
    $normal         = 0;
    $checkupCount   = 0;
    $elsecond       = 0;
    $withoutCheckup = 0;

    foreach ($getStable as $key => $value1) {
      $query = $this->db->query("SELECT * from motherMonitoring where motherId = ".$value1['motherId']." and motherAdmissionId = ".$value1['id']." order by id desc limit 0,1");
      $get_last_assessment1 = $query->row_array();
      $monitoringCheck      = $query->num_rows();
      if(empty($get_last_assessment1['id'])){
        $danger = $danger+1;
      }
      else
      {  
       $elsecond++;
          if(!empty($get_last_assessment1['motherPulse']) && ($get_last_assessment1['motherPulse'] < 50 || $get_last_assessment1['MotherPulse'] > 120)){
            $checkupCount = $checkupCount+1;
          }

        if(!empty($get_last_assessment1['motherTemperature']) && ($get_last_assessment1['motherTemperature'] < 95.9 || $get_last_assessment1['motherTemperature'] > 99.5)){
          $checkupCount = $checkupCount+1;
        }

       if(!empty($get_last_assessment1['motherSystolicBP']) && ($get_last_assessment1['motherSystolicBP'] >= 140 || $get_last_assessment1['motherSystolicBP'] <= 90)){
          $checkupCount = $checkupCount+1;
        }

        if(!empty($get_last_assessment1['motherDiastolicBP']) && ($get_last_assessment1['motherDiastolicBP'] <= 60 || $get_last_assessment1['motherDiastolicBP'] >= 90)){
          $checkupCount = $checkupCount+1;
        }

        if(!empty($get_last_assessment1['motherUterineTone']) && $get_last_assessment1['motherUterineTone'] == 'Hard/Collapsed (Contracted)'){
          $checkupCount = $checkupCount+1;
        }

        if(!empty($get_last_assessment1['episitomyCondition']) && $get_last_assessment1['episitomyCondition'] == 'Infected'){
          $checkupCount = $checkupCount+1;
        }                                   

        if(!empty($get_last_assessment1['sanitoryPadStatus']) && $get_last_assessment1['sanitoryPadStatus'] == "It's FULL"){
          $checkupCount = $checkupCount+1;
        }   

        if(!empty($get_last_assessment1['motherBleedingStatus']) && $get_last_assessment1['motherBleedingStatus'] == "Yes"){
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

    $res['stable']   =  $normal;
    $res['unstable'] =  $danger;
    return $res;
  }

  // get baby data from babyAdmission and babyRegistration via motherId and loungeId
  public function GetBabiesViaMotherID($Id){
    return $this->db->query("SELECT ba.* from babyAdmission as ba inner join babyRegistration as br on br.`babyId`=ba.`babyId` inner join motherRegistration as mr on mr.`motherId`=br.`motherId` where mr.`motherId`=".$Id."")->result_array();
  }

  // count stable and unstable Mother code here
  public function countMotherIcon($getAdmittedMothers){ 
    $stablecount1   = 0;
    $unstablecount1 = 0;
    $motherAdmitted = 0;
    foreach ($getAdmittedMothers as $key => $value) {  
        $query = $this->db->query("SELECT * from motherMonitoring where motherAdmissionId=".$value['id']." order by id desc limit 0,1");
        $motherAdmitted++;
        $checkMonitoringOrNot = $query->num_rows();
        $get_last_assessment  = $query->row_array();
        if($checkMonitoringOrNot > 0){
          $status1 = 0;
            $status2 = 0;
            $status3 = 0;
            $status4 = 0;
            $status5 = 0;
            $status6 = 0;
            $status7 = 0;
            $status8 = 0;
           
          if($get_last_assessment['motherPulse'] < 50 || $get_last_assessment['motherPulse'] > 120){
           $status1 = '1';
          }

          if($get_last_assessment['motherTemperature'] < 95.9 || $get_last_assessment['motherTemperature'] > 99.5){
           $status2 = '1';
          }


         if($get_last_assessment['motherSystolicBP'] >= 140 || $get_last_assessment['motherSystolicBP'] <= 90){
           $status3 = '1';
          }

          if($get_last_assessment['motherDiastolicBP'] <= 60 || $get_last_assessment['motherDiastolicBP'] >= 90){
           $status4 = '1';
          }

          // if($get_last_assessment['motherUterineTone'] == 'Hard/Collapsed (Contracted)'){
          //  $status5 = '1';
          // }

          // if(!empty($get_last_assessment['episitomyCondition']) && $get_last_assessment['episitomyCondition'] == 'Infected'){
          //  $status6 = '1';
          // }                                   

          // if(!empty($get_last_assessment['sanitoryPadStatus']) && $get_last_assessment['sanitoryPadStatus'] == "It's FULL"){
          //  $status7 = '1';
          // }   

          // if(!empty($get_last_assessment['motherBleedingStatus']) && $get_last_assessment['motherBleedingStatus'] == "Yes"){
          //  $status8 = '1';
          // }                      

          if($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1)
          {
                $unstablecount1++;
          }else{
                $stablecount1++;                       
          }
        }
    }
    $res['stable']         =  $stablecount1;
    $res['unstable']       =  $unstablecount1;
    $res['admittedMother'] =  $motherAdmitted;
    return $res;
  } 


  // count stable and unstable baby code here
  public function countBabySign($getStable){
    $admitted       = 0;
    $danger         = 0;
    $normal         = 0;
    $checkupCount1  = 0;
    $checkupCount2  = 0;
    $checkupCount3  = 0;

    foreach($getStable as $value1) {
      $query = $this->db->query("SELECT * from babyDailyMonitoring where babyAdmissionId=".$value1['id']." order by id desc limit 0,1");
      $get_last_assessment1 = $query->row_array();
      $monitoringCheck = $query->num_rows();
        if($monitoringCheck > 0){
         $admitted++;
              if($get_last_assessment1['respiratoryRate'] > 60 || $get_last_assessment1['respiratoryRate'] < 30){
                $checkupCount1 = 1;
              }

            if($get_last_assessment1['temperatureValue'] < 95.9 || $get_last_assessment1['temperatureValue'] > 99.5){
              $checkupCount2 = 1;
            }

           if($get_last_assessment1['spo2'] < 95 && $get_last_assessment1['isPulseOximatoryDeviceAvail']=="Yes"){
              $checkupCount3 = 1;
            }

            if($checkupCount1 == 1 || $checkupCount2 == 1 || $checkupCount3 == 1){
                 $danger++;
            }else{
              $normal++;
            }
        }                 
    }
    $res['stable']       =  $normal;
    $res['unstable']     =  $danger;
    $res['admittedBaby'] =  $admitted;
    return $res;
  }


  public function getBedOfLounge($loungeId){

    $res = $this->db->get_where('loungeMaster',array('loungeId'=>$loungeId))->row_array();
    return $res['numberOfBed'];
  }


  public function getMotherPastInfo($motherAdmissionId){

    $res = $this->db->get_where('motherPastInformation',array('motherAdmissionId'=>$motherAdmissionId))->row_array();
    return $res;
  }


  public function getAllAdmittedMother($loungeId){
    $motherList = $this->db->query("select mr.`motherId`, mr.motherName, ma.`id`,ma.`status`,ma.`dischargeByNurse`,mr.`addDate`,ma.hospitalRegistrationNumber,ma.temporaryFileId,br.babyId, ba.id as babyAdmissionId from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` inner join babyRegistration as br on br.motherId = mr.motherId inner join babyAdmission as ba on ba.babyId = br.babyId where mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$loungeId." and ma.status = 1 and ba.status = 1 order By ma.`id` desc")->result_array();
    
    $result = array(); $i = 0;
    foreach ($motherList as $key => $value) {
      $babyAdmissionId = $value['babyAdmissionId'];
      $date = date('Y-m-d 00:00:00', strtotime('-2 days')); 

      $chkAssesment = $this->db->query("select * from babyDailyMonitoring where babyAdmissionId=".$babyAdmissionId." and addDate > '".$date."' order by id desc limit 0,1")->row_array();
      if(!empty($chkAssesment)){
        $result[$i] = $value;
        $i++;
      }

    }
    return $result;

  }


  public function GetLastAsessmentBabyByMid($id){ 
      $baby = $this->db->get_where('babyRegistration',array('motherId'=>$id))->row_array();
      if(!empty($baby)){
        $babyId = $baby['babyId'];
        $date = date('Y-m-d 00:00:00', strtotime('-2 days')); 

        return $this->db->query("select * from babyDailyMonitoring where babyId=".$babyId." and addDate > '".$date."' order by id desc limit 0,1")->row_array();
      }  else {
        return 0;
      }
    
  }


}
 ?>