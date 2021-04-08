<?php
class FeedbackManagementModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function totalMotherRecordsSearch($loungeID,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus,$dischargeType=false,$admissionType=false,$admitType=false){

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
    $where_lounge_mother = "";$where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_mother = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
      $where_lounge_baby = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }

    if($motherStatus == 'admitted'){

      if($motherStatus == "isAdmit"){
        $babyAdmitStatus = "ba.`status`=1";
        $motherAdmitStatus = "ma.`status`=1";
      }else{
        $babyAdmitStatus = "ba.`status`!=4";
        $motherAdmitStatus = "ma.`status` !=4 AND ma.`status` !=3";
      }

      if($admissionType == "1" || $admitType == "1"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='3' AND mr.`type` = 1 AND ";
      }elseif($admissionType == "2" || $admitType == "2"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ".$motherAdmitStatus." AND mr.`type` = 1 AND ";
      }elseif($admissionType == "3"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Dead%' OR mr.`notAdmittedReason` Like 'मृत%') AND ";
      }elseif($admissionType == "4"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Baby was referred%' OR mr.`notAdmittedReason` Like 'बेबी को रेफर किया%') AND ";
      }elseif($admissionType == "5"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Mother is in a different%' OR mr.`notAdmittedReason` Like 'माँ एक ही अस्पताल%') AND ";
      }elseif($admissionType == "6"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 2 AND ";
      }elseif($admissionType == "7"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Other%' OR mr.`notAdmittedReason` Like 'अन्य%') AND ";
      }else{
        $statusQry2 = "".$babyAdmitStatus." AND ";
      }

    }elseif($motherStatus == 'isAdmit'){

      if($admitType == "1"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='3' AND mr.`type` = 1 AND ";
      }elseif($admitType == "2"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`=1 AND mr.`type` = 1 AND ";
      }else{
        $statusQry = "mr.`isMotherAdmitted`='Yes' and (ma.`status`=1 OR ma.`status`='3') AND ";
      }

    } elseif($motherStatus == 'dischargedMother'){

      // search by discharge type
      if(!empty($dischargeType)){
        $dischargeType = '"'.$dischargeType.'"';
        $dischargeTypeFilter = " AND ma.`typeOfDischarge`= ".$dischargeType." ";
      }else{
        $dischargeTypeFilter = "";
      }

      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='2' ".$dischargeTypeFilter." AND";
    } else if($motherStatus == ''){
      $statusQry2 = " ba.`status`='2' AND ";
    }
    

    if(!empty($selectedFromDate) && !empty($selectedToDate) && ($motherStatus == 'dischargedMother')){
      $dateFilter = " ma.`dateOfDischarge` between '".$selectedFromDate."' AND '".$selectedToDate."' ";
    }else{
      $dateFilter = " ma.`addDate` between '".$fromDate."' AND '".$toDate."' ";
    }

    if(!empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." ba.`staffId` = ".$nurseid." AND mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc ")->num_rows();
        } else {
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter." and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc")->num_rows();
        }      
      } else {
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." ba.`staffId` = ".$nurseid." AND mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc")->num_rows();
        } else {
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter." order By mr.`motherId` desc ")->num_rows();
        }
      }
    } else if(!empty($loungeID) && empty($nurseid)){
      if(!empty($keyword)){ 
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc")->num_rows();
        } else {
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ".$dateFilter." and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc")->num_rows();
        }
      } else {
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'No' order By mr.`motherId` desc")->num_rows();

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr left join `motherAdmission` as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where (ma.`loungeId` = ".$loungeID." OR ba.`loungeId` = ".$loungeID.") AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc")->num_rows();

            return $motherAdmit;

          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc")->num_rows();
          }
        } else { 
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ".$dateFilter." order By mr.`motherId` desc")->num_rows();
        }
      }
    } else if(empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows();
        } else { 
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows(); 
        }
      } else {
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows();
        } else { 
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows();
        }
      }
    } else {
      if(!empty($facilityname)) { 
        if(!empty($keyword)){ 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows(); 

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` left join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows(); 

            return $motherAdmit;

          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows(); 

            
          }
        } else {
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows();

          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows(); 

            
          }
        }
      } else if(!empty($district)) { 
        if(!empty($keyword)){ 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows(); 

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` left join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` left join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows(); 

            return $motherAdmit;

          } else { 
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows(); 
          }
        } else { 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows();

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` left join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` left join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows();

            return $motherAdmit;
              
          } else { 
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows(); 
             
          }
        }
      } else {
        if(!empty($keyword)){ 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows();
          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows(); 
          }
        } else {
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_baby." order By mr.`motherId` desc")->num_rows();
          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc")->num_rows();
          }
        }
      }
    }
  } 

  public function getAllMotherCount(){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }

    //return $this->db->query("SELECT distinct ma.motherId, mr.* FROM `motherRegistration` as mr left join motherAdmission as ma on mr.`motherId` = ma.`motherId` where mr.`type` != 2 ".$where_lounge_baby." ")->num_rows(); 

    return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.status=2 AND mr.isMotherAdmitted='Yes' ".$where_lounge_baby."")->num_rows();
  }

  // count all mothers via lounge
  public function countAllMothers($loungeID){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_mother = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_mother = 'AND (motherAdmission.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }

    $timestamp = date('Y-m-d H:i:s', strtotime('today midnight'));
    if($loungeID == 'all'){
      return $this->db->query("SELECT distinct motherAdmission.motherId,motherAdmission.* FROM `motherAdmission` inner join `motherRegistration` on `motherAdmission`.id = `motherRegistration`.motherId WHERE `motherAdmission`.addDate >= '".$timestamp."' AND motherAdmission.status=2 ".$where_lounge_mother." ")->num_rows();
    } else {
      return $this->db->query("SELECT distinct motherAdmission.motherId,motherAdmission.* FROM `motherAdmission` inner join `motherRegistration` on `motherAdmission`.id = `motherRegistration`.motherId WHERE `motherAdmission`.`loungeId` = ".$loungeID." AND motherAdmission.status=2 AND `motherAdmission`.addDate >= '".$timestamp."'")->num_rows();
    }
  }

  public function getMotherRecordSearch($loungeID,$limit,$offset,$fromDate,$toDate,$district,$keyword,$facilityname,$nurseid,$motherStatus,$dischargeType=false,$admissionType=false,$admitType=false){

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
    $where_lounge_mother = "";$where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_mother = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
      $where_lounge_baby = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }

    if($motherStatus == 'admitted'){

      if($motherStatus == "isAdmit"){
        $babyAdmitStatus = "ba.`status`=1";
        $motherAdmitStatus = "ma.`status`=1";
      }else{
        $babyAdmitStatus = "ba.`status`!=4";
        $motherAdmitStatus = "ma.`status` !=4 AND ma.`status` !=3";
      }

      if($admissionType == "1" || $admitType == "1"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='3' AND mr.`type` = 1 AND ";
      }elseif($admissionType == "2" || $admitType == "2"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ".$motherAdmitStatus." AND mr.`type` = 1 AND ";
      }elseif($admissionType == "3"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Dead%' OR mr.`notAdmittedReason` Like 'मृत%') AND ";
      }elseif($admissionType == "4"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Baby was referred%' OR mr.`notAdmittedReason` Like 'बेबी को रेफर किया%') AND ";
      }elseif($admissionType == "5"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Mother is in a different%' OR mr.`notAdmittedReason` Like 'माँ एक ही अस्पताल%') AND ";
      }elseif($admissionType == "6"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 2 AND ";
      }elseif($admissionType == "7"){
        $statusQry2 = "mr.`isMotherAdmitted`='No' and ".$babyAdmitStatus." AND mr.`type` = 3 and ( mr.`notAdmittedReason` Like 'Other%' OR mr.`notAdmittedReason` Like 'अन्य%') AND ";
      }else{
        $statusQry2 = "".$babyAdmitStatus." AND ";
      }

    } elseif($motherStatus == 'isAdmit'){

      if($admitType == "1"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='3' AND mr.`type` = 1 AND ";
      }elseif($admitType == "2"){
        $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`=1 AND mr.`type` = 1 AND ";
      }else{
        $statusQry = "mr.`isMotherAdmitted`='Yes' and (ma.`status`=1 OR ma.`status`='3') AND ";
      }

    } elseif($motherStatus == 'dischargedMother'){

      // search by discharge type
      if(!empty($dischargeType)){
        $dischargeType = '"'.$dischargeType.'"';
        $dischargeTypeFilter = " AND ma.`typeOfDischarge`= ".$dischargeType." ";
      }else{
        $dischargeTypeFilter = "";
      }

      $statusQry = "mr.`isMotherAdmitted`='Yes' and ma.`status`='2' ".$dischargeTypeFilter." AND";
    } else if($motherStatus == ''){
      $statusQry2 = " ba.`status`='2' AND ";
    }

    // search by discharge date
    if(!empty($selectedFromDate) && !empty($selectedToDate) && ($motherStatus == 'dischargedMother')){
      $dateFilter = " ma.`dateOfDischarge` between '".$selectedFromDate."' AND '".$selectedToDate."' ";
    }else{
      $dateFilter = " ma.`addDate` between '".$fromDate."' AND '".$toDate."' ";
    }

    if(!empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." ba.`staffId` = ".$nurseid." AND mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter." and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }      
      } else {
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." ba.`staffId` = ".$nurseid." AND mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ba.`staffId` = ".$nurseid." AND ".$dateFilter." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    } else if(!empty($loungeID) && empty($nurseid)){
      if(!empty($keyword)){ 
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else {
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ".$dateFilter." and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      } else {
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'No' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr left join `motherAdmission` as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where (ma.`loungeId` = ".$loungeID." OR ba.`loungeId` = ".$loungeID.") AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            return $motherAdmit;

          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`loungeId` = ".$loungeID." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          }
        } else { 
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.`loungeId` = ".$loungeID." AND ".$statusQry." ".$dateFilter." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    } else if(empty($loungeID) && !empty($nurseid)){
      if(!empty($keyword)){ 
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else { 
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." and ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
        }
      } else {
        if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        } else { 
          return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ba.`staffId` = ".$nurseid." AND ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
        }
      }
    } else {
      if(!empty($facilityname)) { 
        if(!empty($keyword)){ 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` left join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            return $motherAdmit;

          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            
          }
        } else {
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` where lm.`facilityId` = ".$facilityname." AND ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            
          }
        }
      } else if(!empty($district)) { 
        if(!empty($keyword)){ 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` left join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` left join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 

            return $motherAdmit;

          } else { 
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
          }
        } else { 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            //$motherNotAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' AND mr.`isMotherAdmitted` = 'No' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            $motherAdmit = $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` left join loungeMaster as lm on ba.`loungeId` = lm.`loungeId` left join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();

            return $motherAdmit;
              
          } else { 
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` inner join loungeMaster as lm on ma.`loungeId` = lm.`loungeId` INNER join facilitylist as fl on lm.`facilityId` = fl.`FacilityID` where fl.`PRIDistrictCode` = ".$district." AND ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
             
          }
        }
      } else {
        if(!empty($keyword)){ 
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on  mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry2." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry." ( mr.`motherMCTSNumber` Like '%{$keyword}%' OR mr.`addDate` Like '%{$keyword}%' OR mr.`motherName` Like '%{$keyword}%' OR mr.`motherMobileNumber` Like '%{$keyword}%') ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array(); 
          }
        } else {
          if(($motherStatus != 'dischargedMother') && ($motherStatus != 'isAdmit') && ($admissionType != "1" && $admissionType != "2")){
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join babyRegistration as br on mr.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry2." mr.`addDate` between '".$fromDate."' AND '".$toDate."' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          } else {
            return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ".$statusQry." ".$dateFilter." ".$where_lounge_mother." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
          }
        }
      }
    }
  }

  public function getAllMotherList($limit,$offset){
    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge_baby = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge_baby = 'AND (ba.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }

    return $this->db->query("SELECT distinct mr.motherId,mr.* FROM `motherRegistration` as mr inner join motherAdmission as ma on mr.`motherId` = ma.`motherId` inner join babyRegistration as br on  ma.`motherId` = br.`motherId` inner join babyAdmission as ba on br.`babyId` = ba.`babyId` where ma.status=2 AND mr.isMotherAdmitted='Yes' ".$where_lounge_baby." order By mr.`motherId` desc LIMIT ".$offset.", ".$limit."")->result_array();
  }

  // get All Mothers Via lounge
  public function getAllMothers($loungeID,$limit,$offset,$motherStatus = ''){
    $timestamp = date('Y-m-d H:i:s', strtotime('today midnight'));

    $getCoachLounge = $this->UserModel->getCoachFacilities();
    $where_lounge = "";
    if(!empty($getCoachLounge['coachLoungeArray'])){ 
      $where_lounge = 'AND (ma.loungeId in '.$getCoachLounge['coachLoungeArrayString'].')';
    }

    if(!empty($motherStatus) && $motherStatus == 'admitted'){
      if($loungeID == 'all'){
        return $this->db->query("select distinct mr.motherId,mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where ma.status=2 AND mr.`isMotherAdmitted`='Yes' ".$where_lounge." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("select distinct mr.motherId,mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where ma.status=2 mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$loungeID." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    }else if(!empty($motherStatus) && $motherStatus == 'currentlyAvail'){
      if($loungeID == 'all'){
        return $this->db->query("select distinct mr.motherId,mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`='2' ".$where_lounge." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("select distinct mr.motherId,mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$loungeID." and ma.`status`=2 order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    }else if(!empty($motherStatus) && $motherStatus == 'dischargedMother'){
      if($loungeID == 'all'){
        return $this->db->query("select distinct mr.motherId,mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`status`=2 ".$where_lounge." order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      } else {
        return $this->db->query("select distinct mr.motherId,mr.`motherId`,ma.`id`,ma.`status`,ma.`dischargeByNurse`,ma.`addDate` from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` where mr.`isMotherAdmitted`='Yes' and ma.`loungeId`=".$loungeID." and ma.`status`=2 order By ma.`id` desc LIMIT ".$offset.", ".$limit."")->result_array();
      }
    } else {
      if($loungeID == 'all'){ 
        $result = $this->db->query("SELECT distinct ma.motherId,ma.* FROM `motherAdmission` as ma WHERE ma.status=2 and ma.addDate >= '".$timestamp."' ".$where_lounge." ORDER BY ma.id DESC LIMIT ".$offset.", ".$limit)->result_array();
      } else {
        $result = $this->db->query("SELECT distinct motherAdmission.motherId,motherAdmission.* FROM `motherAdmission` WHERE motherAdmission.status=2 AND `loungeId` = ".$loungeID." AND addDate >= '".$timestamp."' ORDER BY `id` DESC LIMIT ".$offset.", ".$limit)->result_array();
      }
      return $result;
    }
  }

  public function getMotherDetailsById($motherId){
    return $this->db->query("select DISTINCT mr.motherId,fm.FacilityName,mr.motherName,mr.fatherName,mr.motherMobileNumber,mr.fatherMobileNumber,mr.guardianName,mr.guardianRelation,mr.guardianNumber,mr.isMotherAdmitted,mr.motherReligion,mr.motherCaste,br.deliveryDate,br.deliveryTime,br.babyGender,br.babyWeight,br.typeOfBorn,ba.infantComingFrom,ba.infantComingFromOther,br.deliveryType,mr.addDate as admissionDate,ma.typeOfDischarge,ma.dateOfDischarge,ma.trainForKMCAtHome,mr.presentResidenceType,mr.presentDistrictName,mr.presentBlockName,mr.presentVillageName,mr.presentAddress from motherRegistration as mr inner join motherAdmission as ma on ma.`motherId`= mr.`motherId` INNER JOIN babyRegistration as br on br.motherId=mr.motherId INNER JOIN babyAdmission as ba on ba.babyId=br.babyId INNER JOIN loungeMaster as lm on lm.loungeId=ma.loungeId INNER JOIN facilitylist as fm on fm.FacilityID=lm.facilityId where mr.`isMotherAdmitted`='Yes' and ma.`motherId`=".$motherId." and ma.`status`=2 and (ba.status != 3 || ba.status!=4)")->row_array();
  }

  public function getEmployeeList(){
    return $result = $this->db->query("SELECT * FROM `employeesData` WHERE status=1 order by name ASC")->result_array();
  }

  public function getMotherLastFeedback($motherId){
    return $result = $this->db->query("SELECT * FROM `motherFeedbackMaster` WHERE motherId=".$motherId." AND status=1 order by id DESC")->row_array();
  }

  public function getFeedbackLastUpdate($id, $type){
    if($type == 1){
        $this->db->order_by('id','desc');
        return $this->db->get_where('logData',array('tableReferenceId'=>$id, 'tableReference'=>11))->row_array();
    } else {
        $this->db->order_by('id','desc');
        return $this->db->get_where('logData',array('tableReferenceId'=>$id, 'tableReference'=>11))->result_array();
    }
  }

}
 ?>